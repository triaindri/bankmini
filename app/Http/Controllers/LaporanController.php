<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Transaksitabungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        [$awal, $akhir] = $this->resolvePeriode($request);

        return view('laporan.index', [
            'rekapKas' => $this->ambilRekapKas($awal, $akhir),
            'siswa'    => $this->ambilDataSiswa($awal, $akhir),
            'awal'     => $awal,
            'akhir'    => $akhir,
        ]);
    }

     public function export(Request $request)
    {
        [$awal, $akhir] = $this->resolvePeriode($request);

        $pdf = Pdf::loadView('laporan.pdf', [
            'rekapKas' => $this->ambilRekapKas($awal, $akhir),
            'siswa'    => $this->ambilDataSiswa($awal, $akhir),
            'awal'     => $awal,
            'akhir'    => $akhir,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-bank-mini-' . $awal->format('Ymd') . '-' . $akhir->format('Ymd') . '.pdf');
    }

    protected function resolvePeriode(Request $request): array
    {
        $awal  = $request->filled('awal')  ? Carbon::parse($request->awal)->startOfDay()  : now()->startOfMonth();
        $akhir = $request->filled('akhir') ? Carbon::parse($request->akhir)->endOfDay()    : now()->endOfDay();

        return [$awal, $akhir];
    }

    protected function ambilRekapKas(Carbon $awal, Carbon $akhir)
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

    protected function ambilDataSiswa(Carbon $awal, Carbon $akhir)
    {
        return Siswa::with(['tabungan', 'analisisPerilaku' => function ($query) use ($awal, $akhir) {
                $query->where('periode_awal', $awal->toDateString())
                      ->where('periode_akhir', $akhir->toDateString());
            }])
            ->orderBy('kelas')
            ->orderBy('nama')
            ->get();
    }
}
