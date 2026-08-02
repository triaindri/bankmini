<?php

namespace App\Http\Controllers;

use App\Models\Transaksitabungan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    public function index(Request $request)
    {
        [$awal, $akhir] = $this->resolvePeriode($request);
        $rekap = $this->ambilRekap($awal, $akhir);

        return view('laporan.harian', [
            'rekap' => $rekap,
            'awal'  => $awal,
            'akhir' => $akhir,
        ]);
    }

     public function export(Request $request)
    {
        [$awal, $akhir] = $this->resolvePeriode($request);
        $rekap = $this->ambilRekap($awal, $akhir);

        $filename = 'laporan-kas-' . $awal->format('Ymd') . '-' . $akhir->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($rekap, $awal, $akhir) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF"); // BOM supaya format angka terbaca benar di Excel

            fputcsv($handle, ['Periode', $awal->format('d-m-Y') . ' s/d ' . $akhir->format('d-m-Y')]);
            fputcsv($handle, []);
            fputcsv($handle, ['Total Setoran', $rekap->total_setor]);
            fputcsv($handle, ['Total Penarikan', $rekap->total_tarik]);
            fputcsv($handle, ['Selisih (Kas Masuk Bersih)', $rekap->total_setor - $rekap->total_tarik]);
            fputcsv($handle, ['Jumlah Transaksi Setor', $rekap->jumlah_transaksi_setor]);
            fputcsv($handle, ['Jumlah Transaksi Tarik', $rekap->jumlah_transaksi_tarik]);

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    protected function resolvePeriode(Request $request): array
    {
        $awal  = $request->filled('awal')  ? Carbon::parse($request->awal)->startOfDay()  : now()->startOfMonth();
        $akhir = $request->filled('akhir') ? Carbon::parse($request->akhir)->endOfDay()    : now()->endOfDay();

        return [$awal, $akhir];
    }

    protected function ambilRekap(Carbon $awal, Carbon $akhir)
    {
        return Transaksitabungan::selectRaw("
                SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE 0 END) as total_setor,
                SUM(CASE WHEN jenis = 'tarik' THEN jumlah ELSE 0 END) as total_tarik,
                COUNT(CASE WHEN jenis = 'setor' THEN 1 END) as jumlah_transaksi_setor,
                COUNT(CASE WHEN jenis = 'tarik' THEN 1 END) as jumlah_transaksi_tarik
            ")
            ->whereBetween('tanggal', [$awal, $akhir])
            ->where('status', 'disetujui')
            ->first();
    }
}
