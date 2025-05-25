<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksitabungan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function index()
    {
        // Hitung jumlah siswa yang menabung (misal semua siswa)
        $jumlahSiswa = Siswa::count();

        // Transaksi tabungan hari ini
        $transaksiHariIni = TransaksiTabungan::whereDate('tanggal', Carbon::today())->count();

        // Penjualan hari ini
        $penjualanHariIni = Penjualan::whereDate('tanggal', Carbon::today())->count();

        // Transaksi mingguan (misal, total transaksi per hari dalam 7 hari terakhir)
        $transaksiMingguan = TransaksiTabungan::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
        ->where('tanggal', '>=', Carbon::today()->subDays(6))
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        // Penjualan mingguan
        $penjualanMingguan = Penjualan::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
        ->where('tanggal', '>=', Carbon::today()->subDays(6))
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        return view('dashboard', compact(
            'jumlahSiswa', 'transaksiHariIni', 'penjualanHariIni', 'transaksiMingguan', 'penjualanMingguan'
        ));
    }
}
