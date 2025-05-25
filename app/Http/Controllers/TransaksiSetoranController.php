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
    public function index()
    {
        // Ambil semua transaksi setoran dengan relasi tabungan dan siswa
        $setorans = Transaksitabungan::where('jenis', 'setor')->with('tabungan.siswa')->orderBy('tanggal', 'desc')->get();

        return view('transaksi.setoran.index', compact('setorans'));
    }

    // 2. Tampilkan form tambah setoran
    public function create()
    {
        return view('transaksi.setoran.create');
    }

    // 3. Simpan transaksi setoran baru
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,nis',
            'jumlah' => 'required|integer|min:1000',
            'tanggal' => 'required|date',
        ]);

        $siswa = Siswa::where('nis', $request->nis)->first();

        $tabungan = Tabungan::firstOrCreate(
            ['siswa_id' => $siswa->id],
            ['saldo' => 0]
        );

        // Tambah saldo tabungan
        $tabungan->saldo += $request->jumlah;
        $tabungan->save();

        // Catat transaksi setoran
        Transaksitabungan::create([
            'tabungan_id' => $tabungan->id,
            'jenis' => 'setor',
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'user_id' => Auth::id(), // Petugas yang login
        ]);

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil dicatat.');
    }

    // 4. Endpoint AJAX untuk get data siswa berdasarkan NIS
    public function getSiswaByNis(Request $request)
    {
        $nis = $request->nis;
        $siswa = Siswa::where('nis', $nis)->first();

        if (!$siswa) {
            return response()->json(['error' => 'NIS tidak ditemukan'], 404);
        }

        return response()->json([
            'nama' => $siswa->nama,
            'kelas' => $siswa->kelas,
        ]);
    }
}
