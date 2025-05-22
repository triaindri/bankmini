<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Tabungan;
use App\Models\Transaksi;
use App\Models\Transaksitabungan;
use Illuminate\Support\Facades\Auth;

class TransaksiSetoranController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('tabungan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($s) use ($q) {
                $s->where('nama', 'like', "%$q%")
                ->orWhere('nis', 'like', "%$q%");
            });
        }

        $siswa = $query->get();

        return view('transaksi.setoran.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jumlah' => 'required|integer|min:1000',
        ]);

        // Ambil tabungan berdasarkan siswa
        $tabungan = Tabungan::firstOrCreate(
            ['siswa_id' => $request->siswa_id],
            ['saldo' => 0]
        );

        // Tambah saldo
        $tabungan->saldo += $request->jumlah;
        $tabungan->save();

        // Catat transaksi
        Transaksitabungan::create([
            'tabungan_id' => $tabungan->id,
            'jenis' => 'setor',
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'user_id' => Auth::id(), // petugas yang login
        ]);

        return redirect()->back()->with('success', 'Setoran berhasil dicatat.');
    }
}
