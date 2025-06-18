<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga_beli' => ['required', 'numeric', 'min:500', function ($attribute, $value, $fail) {
                if ($value % 500 !== 0) {
                    $fail('Harga harus kelipatan 500.');
                }
            }],
            'harga_jual' => ['required', 'numeric', 'min:500', function ($attribute, $value, $fail) {
                if ($value % 500 !== 0) {
                    $fail('Harga harus kelipatan 500.');
                }
            }],
            'stok' => 'required|integer',
        ]);

        Produk::create($request->all());

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }
    public function update(Request $request, $id) {
        $produk = Produk::findOrFail($id);
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->stok = $request->stok;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id) {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

}
