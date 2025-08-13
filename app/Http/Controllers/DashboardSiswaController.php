<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // Tambahan validasi jika perlu
        if ($user->role !== 'siswa') {
            abort(403, 'Akses ditolak');
        }

        return view('dashboardSiswa', [
            'nama' => $user->name,
            'email' => $user->email,
            'saldo' => 150000,
            'tanggal_hari_ini' => now()->translatedFormat('l, d F Y'),
            'setoran_bulan_ini' => 50000,
            'penarikan_bulan_ini' => 20000,
            'transaksi_terakhir' => [
                ['jenis' => 'Setoran', 'jumlah' => 20000, 'tanggal' => '2025-08-01', 'keterangan' => 'Tabungan mingguan'],
                ['jenis' => 'Penarikan', 'jumlah' => 10000, 'tanggal' => '2025-08-05'],
            ]
        ]);
    }
}
