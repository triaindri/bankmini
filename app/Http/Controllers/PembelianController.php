<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Storage;

class PembelianController extends Controller
{
    public function create(Request $request)
    {
        $query = $request->input('q');

        $produk = Produk::when($query, function ($q) use ($query) {
            return $q->where('nama', 'like', '%' . $query . '%');
        })->latest()->get();

        $riwayat = Pembelian::with('produk')->latest()->take(10)->get();

        return view('pembelian.create', compact('produk', 'riwayat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $produk = Produk::where('nama', $validated['nama'])->first();

        if ($produk) {
            $produk->stok += $validated['stok'];
            $produk->harga_beli = $validated['harga_beli'];
            $produk->harga_jual = $validated['harga_jual'];

            if ($request->hasFile('gambar')) {
                if ($produk->gambar) {
                    Storage::delete('public/' . $produk->gambar);
                }
                $produk->gambar = $request->file('gambar')->store('produk', 'public');
            }

            $produk->save();
        } else {
            $gambarPath = $request->hasFile('gambar')
                ? $request->file('gambar')->store('produk', 'public')
                : null;

            $produk = Produk::create([
                'nama'        => $validated['nama'],
                'harga_beli'  => $validated['harga_beli'],
                'harga_jual'  => $validated['harga_jual'],
                'stok'        => $validated['stok'],
                'gambar'      => $gambarPath,
            ]);
        }

        Pembelian::create([
            'produk_id'  => $produk->id,
            'jumlah'     => $validated['stok'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
        ]);

        return redirect()->route('pembelian.create')->with('success', 'Pembelian berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'stok' => 'required|integer|min:1',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::delete('public/' . $produk->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('pembelian.create')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }

        $produk->delete();

        return redirect()->route('pembelian.create')->with('success', 'Produk berhasil dihapus.');
    }
}
