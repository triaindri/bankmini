<?php

namespace App\Http\Controllers;
use App\Models\Transaksitabungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
     public function index()
    {
        // Ambil ID siswa dari user yang login
        $siswaId = Auth::user()->siswa->id;

        // Ambil semua transaksi tabungan milik siswa ini
        $transaksi = Transaksitabungan::whereHas('tabungan', function ($query) use ($siswaId) {
                $query->where('siswa_id', $siswaId);
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10); // pagination

        return view('siswa.riwayat', compact('transaksi'));
    }
}
