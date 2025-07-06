<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('details.produk')->latest()->paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('penjualan.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $total = 0;
        $items = [];

        foreach ($request->produk_id as $key => $produk_id) {
            $produk = Produk::findOrFail($produk_id);
            $jumlah = $request->jumlah[$key];
            $subtotal = $produk->harga_jual * $jumlah;

            $total += $subtotal;

            $items[] = [
                'produk_id' => $produk_id,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        $penjualan = Penjualan::create([
            'tanggal' => now(),
            'total' => $total,
        ]);

        foreach ($items as $item) {
            $penjualan->details()->create($item);
        }

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dicatat.');
    }
}
