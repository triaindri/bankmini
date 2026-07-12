<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Services\AnalisisPerilakuMenabungService;
use Carbon\Carbon;

class AnalisisPerilakuMenabungController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['analisisPerilaku' => function ($q) {
            $q->latest('periode_akhir')->limit(1);
        }])->orderBy('nama')->paginate(15);

        return view('analisis.index', compact('siswa'));
    }

     public function generate(Request $request, AnalisisPerilakuMenabungService $service)
    {
        $request->validate([
            'periode_awal'  => 'required|date',
            'periode_akhir' => 'required|date|after:periode_awal',
            'siswa_id'      => 'nullable|exists:siswa,id',
        ]);

        $periodeAwal  = Carbon::parse($request->periode_awal);
        $periodeAkhir = Carbon::parse($request->periode_akhir);

        $daftarSiswa = $request->filled('siswa_id')
            ? Siswa::where('id', $request->siswa_id)->get()
            : Siswa::whereNotNull('pendapatan_orang_tua')->whereNotNull('jumlah_tanggungan')->get();
             
        $berhasil = 0;
        $gagal = [];

        foreach ($daftarSiswa as $siswa) {
            try {
                $service->jalankan($siswa, $periodeAwal, $periodeAkhir);
                $berhasil++;
            } catch (\RuntimeException $e) {
                $gagal[] = "{$siswa->nama}: {$e->getMessage()}";
            }
        }

        $pesan = "Analisis selesai. Berhasil: {$berhasil} siswa.";
        if ($gagal) {
            $pesan .= ' Dilewati: ' . implode('; ', $gagal);
        }

        $redirect = $request->filled('siswa_id')
            ? redirect()->route('analisis.show', $request->siswa_id)
            : redirect()->route('analisis.index');

        return $redirect->with('status', $pesan);
    }

    public function show(Siswa $siswa)
    {
        $riwayat = $siswa->analisisPerilaku()->orderByDesc('periode_akhir')->get();

        return view('analisis.show', compact('siswa', 'riwayat'));
    }
}
