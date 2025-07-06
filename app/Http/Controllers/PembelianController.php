<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pembelian;

class PembelianController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $pembelian = Pembelian::with('produk')->latest()->get();
        return view('produk.pembelian', compact('produk', 'pembelian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'produk_id' => 'required',
        ]);

        if ($request->produk_id === 'new') {
            $request->validate([
                'nama_baru' => 'required|string',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer',
            ]);

            $produk = Produk::create([
                'nama' => $request->nama_baru,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => 0,
            ]);
        } else {
            $produk = Produk::findOrFail($request->produk_id);
        }

        $produk->increment('stok', $request->jumlah);

        Pembelian::create([
            'produk_id' => $produk->id,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('produk.pembelian')->with('success', 'Stok berhasil ditambahkan.');
    }

}
