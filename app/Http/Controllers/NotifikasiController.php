<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksitabungan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user adalah siswa
        if (!$user->siswa) {
            abort(403, 'Akses ditolak');
        }

        $siswaId = $user->siswa->id;

        $notifikasi = collect();

        // Penarikan saldo
        $penarikan = Transaksitabungan::whereHas('tabungan', function($q) use ($siswaId) {
                $q->where('siswa_id', $siswaId);
            })
            ->where('jenis', 'tarik')
            ->get()
            ->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'icon' => '✔',
                    'warna' => 'green',
                    'pesan' => "Penarikan Rp " . number_format($item->jumlah, 0, ',', '.') . " untuk {$item->keterangan} telah disetujui",
                    'jenis' => 'Transaksi'
                ];
            });

        // Produk baru (contoh: semua produk yang dibuat dalam 30 hari terakhir)
        $produkBaru = Produk::where('created_at', '>=', now()->subDays(30))
            ->get()
            ->map(function($item) {
                return [
                    'tanggal' => $item->created_at,
                    'icon' => '📦',
                    'warna' => 'purple',
                    'pesan' => "Produk baru telah tersedia : {$item->nama}",
                    'jenis' => 'Pengumuman'
                ];
            });

        // Gabungkan semua
        $notifikasi = $penarikan->merge($produkBaru)->sortByDesc('tanggal')->values();

        return view('siswa.notifikasi', compact('notifikasi'));
    }
}
