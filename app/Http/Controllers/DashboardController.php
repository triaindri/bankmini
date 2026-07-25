<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksitabungan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        // default untuk bagian siswa
        $saldo = 0;
        $setoranBulanIni = 0;
        $penarikanBulanIni = 0;
        $transaksiTerakhir = collect();
        $badges = collect();

        if ($user->siswa) {
            $siswa = $user->siswa;
            $tabungan = $siswa->tabungan;

            $saldo = $tabungan->saldo ?? 0;

            $setoranBulanIni = $tabungan
                ?->transaksi()
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->where('jenis', 'setor')
                ->sum('jumlah') ?? 0;

            $penarikanBulanIni = $tabungan
                ?->transaksi()
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->where('jenis', 'tarik')
                ->sum('jumlah') ?? 0;

            $transaksiTerakhir = $tabungan
                ?->transaksi()
                ->orderBy('tanggal', 'desc')
                ->take(5)
                ->get() ?? collect();

            $badges = $siswa->badges()->with('badge')->orderByDesc('diperoleh_pada')->get();
        }

        // Data untuk koordinator/petugas (tidak diubah)
        $jumlahSiswa = DB::table('transaksitabungan')
            ->join('tabungan', 'transaksitabungan.tabungan_id', '=', 'tabungan.id')
            ->join('siswa', 'tabungan.siswa_id', '=', 'siswa.id')
            ->whereDate('transaksitabungan.tanggal', today())
            ->where('transaksitabungan.jenis', 'setor')
            ->distinct('siswa.id')
            ->count('siswa.id');

        $totalNominalTabunganHariIni = DB::table('transaksitabungan')
            ->whereDate('tanggal', today())
            ->where('jenis', 'setor')
            ->sum('jumlah');

        $penjualanHariIni = Penjualan::whereDate('tanggal', today())->sum('total');
        $transaksiMingguan = TransaksiTabungan::selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->where('tanggal', '>=', today()->subDays(6))->groupBy('tanggal')->orderBy('tanggal')->get();
        $penjualanMingguan = Penjualan::selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->where('tanggal', '>=', today()->subDays(6))->groupBy('tanggal')->orderBy('tanggal')->get();

        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();

        $siswaPerBulan = DB::table('transaksitabungan')
            ->join('tabungan', 'transaksitabungan.tabungan_id', '=', 'tabungan.id')
            ->join('siswa', 'tabungan.siswa_id', '=', 'siswa.id')
            ->selectRaw('YEAR(transaksitabungan.tanggal) as tahun, MONTH(transaksitabungan.tanggal) as bulan, COUNT(DISTINCT siswa.id) as total_siswa')
            ->whereBetween('transaksitabungan.tanggal', [$startOfYear, $endOfYear])
            ->where('transaksitabungan.jenis', 'setor')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $labelsGrafikTahunan = [];
        $dataGrafikTahunan = [];
        foreach ($siswaPerBulan as $row) {
            $labelsGrafikTahunan[] = Carbon::create($row->tahun, $row->bulan)->format('F');
            $dataGrafikTahunan[] = $row->total_siswa;
        }

        return view('dashboard', compact(
            'saldo','setoranBulanIni','penarikanBulanIni','transaksiTerakhir','badges',
            'jumlahSiswa','totalNominalTabunganHariIni','penjualanHariIni',
            'transaksiMingguan','penjualanMingguan',
            'labelsGrafikTahunan','dataGrafikTahunan'
        ));
    } 
    
}
