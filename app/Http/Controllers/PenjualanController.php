<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use App\Models\Siswa;
use App\Models\Tabungan;

class PenjualanController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $penjualan = Penjualan::with('produk')->latest()->get();

        return view('penjualan.index', compact('produk', 'penjualan'));
    }

     public function create()
    {
        $produk = Produk::all();
        $siswa = Siswa::all();
        return view('penjualan.create', compact('produk', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'   => 'required|array',
            'produk_id.*' => 'exists:produk,id',
            'jumlah'      => 'required|array',
            'jumlah.*'    => 'integer|min:1',
            'tanggal'     => 'required|date',
            'metode_bayar'=> 'required|in:cash,tabungan',
            'siswa_id'    => 'nullable|exists:siswa,id',
        ]);

        $totalKeseluruhan = 0;

        // Hitung total & cek stok
        foreach ($request->produk_id as $i => $id) {
            $produk = Produk::findOrFail($id);

            if ($request->jumlah[$i] > $produk->stok) {
                return back()->withErrors(['jumlah' => "Stok produk {$produk->nama} tidak mencukupi."]);
            }

            $totalKeseluruhan += $produk->harga_jual * $request->jumlah[$i];
        }

        // Cek saldo tabungan
        if ($request->metode_bayar == 'tabungan') {
            $tabungan = Tabungan::where('siswa_id', $request->siswa_id)->first();
            if (!$tabungan || $tabungan->saldo < $totalKeseluruhan) {
                return back()->withErrors(['siswa_id' => 'Saldo tabungan tidak cukup.']);
            }
            $tabungan->decrement('saldo', $totalKeseluruhan);
        }

        // Simpan penjualan per produk
        foreach ($request->produk_id as $i => $id) {
            $produk = Produk::findOrFail($id);
            $jumlah = $request->jumlah[$i];
            $total  = $produk->harga_jual * $jumlah;

            Penjualan::create([
                'produk_id'    => $id,
                'jumlah'       => $jumlah,
                'total'        => $total,
                'tanggal'      => $request->tanggal,
                'siswa_id'     => $request->siswa_id,
                'metode_bayar' => $request->metode_bayar,
            ]);

            $produk->decrement('stok', $jumlah);
        }

        return redirect()->back()->with('success', 'Penjualan berhasil disimpan.');
    }

}
