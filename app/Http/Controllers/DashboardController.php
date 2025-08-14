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

        if ($user->siswa) {
            $siswaId = $user->siswa->id;

            $saldo = TransaksiTabungan::where('siswa_id', $siswaId)->sum('jumlah');
            $setoranBulanIni = TransaksiTabungan::where('siswa_id', $siswaId)
                ->whereMonth('tanggal', now()->month)
                ->where('jenis', 'setor')->sum('jumlah');
            $penarikanBulanIni = TransaksiTabungan::where('siswa_id', $siswaId)
                ->whereMonth('tanggal', now()->month)
                ->where('jenis', 'tarik')->sum('jumlah');
            $transaksiTerakhir = TransaksiTabungan::where('siswa_id', $siswaId)
                ->orderBy('tanggal', 'desc')->take(5)->get();
        }

        // data untuk koordinator/petugas
        $jumlahSiswa = Siswa::count();
        $totalNominalTabunganHariIni = TransaksiTabungan::whereDate('tanggal', today())
            ->selectRaw("
                SUM(CASE 
                    WHEN jenis = 'setor' THEN jumlah 
                    WHEN jenis = 'tarik' THEN -jumlah 
                    ELSE 0 
                END) as total
            ")->value('total') ?? 0;

        $penjualanHariIni = Penjualan::whereDate('tanggal', today())->count();
        $transaksiMingguan = TransaksiTabungan::selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->where('tanggal', '>=', today()->subDays(6))->groupBy('tanggal')->orderBy('tanggal')->get();
        $penjualanMingguan = Penjualan::selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->where('tanggal', '>=', today()->subDays(6))->groupBy('tanggal')->orderBy('tanggal')->get();

        return view('dashboard', compact(
            'saldo','setoranBulanIni','penarikanBulanIni','transaksiTerakhir',
            'jumlahSiswa','totalNominalTabunganHariIni','penjualanHariIni',
            'transaksiMingguan','penjualanMingguan'
        ));
    }
}
