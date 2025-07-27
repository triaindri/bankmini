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
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'metode_bayar' => 'required|in:cash,tabungan',
            'siswa_id' => 'nullable|exists:siswa,id',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($request->jumlah > $produk->stok) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi.']);
        }

        $total = $produk->harga_jual * $request->jumlah;

        if ($request->metode_bayar == 'tabungan') {
            $tabungan = Tabungan::where('siswa_id', $request->siswa_id)->first();
            if (!$tabungan || $tabungan->saldo < $total) {
                return back()->withErrors(['siswa_id' => 'Saldo tabungan tidak cukup.']);
            }
            $tabungan->decrement('saldo', $total);
        }

        Penjualan::create([
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'tanggal' => $request->tanggal,
            'siswa_id' => $request->siswa_id,
            'metode_bayar' => $request->metode_bayar,
        ]);

        $produk->decrement('stok', $request->jumlah);

        return redirect()->back()->with('success', 'Penjualan berhasil disimpan.');
    }

}
