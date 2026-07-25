<?php
// app/Services/AnalisisPerilakuMenabungService.php

namespace App\Services;

use App\Models\Siswa;
use App\Models\AnalisisPerilakuMenabung;
use Carbon\Carbon;

class AnalisisPerilakuMenabungService
{
    public function __construct(protected FuzzyMamdaniService $fuzzy, protected BadgeService $badgeService,) {}

    public function jalankan(Siswa $siswa, Carbon $periodeAwal, Carbon $periodeAkhir): AnalisisPerilakuMenabung
    {
        if (is_null($siswa->pendapatan_orang_tua) || is_null($siswa->jumlah_tanggungan)) {
            throw new \RuntimeException('Data pendapatan orang tua / jumlah tanggungan siswa belum diisi.');
        }

        $transaksi = $siswa->tabungan
            ?->transaksi()
            ->where('jenis', 'setor')
            ->where('status', 'disetujui')
            ->whereBetween('tanggal', [$periodeAwal, $periodeAkhir])
            ->get();

        $frekuensi = $transaksi?->count() ?? 0;
        $jumlahSetoran = $transaksi?->sum('jumlah') ?? 0;

        $hasil = $this->fuzzy->analisis(
            frekuensi: $frekuensi,
            setoran: $jumlahSetoran,
            pendapatan: (float) $siswa->pendapatan_orang_tua,
            tanggungan: (int) $siswa->jumlah_tanggungan,
        );

        $analisis = AnalisisPerilakuMenabung::create([
            'siswa_id'             => $siswa->id,
            'periode_awal'         => $periodeAwal,
            'periode_akhir'        => $periodeAkhir,
            'frekuensi_menabung'   => $frekuensi,
            'jumlah_setoran'       => $jumlahSetoran,
            'pendapatan_orang_tua' => $siswa->pendapatan_orang_tua,
            'jumlah_tanggungan'    => $siswa->jumlah_tanggungan,
            'skor'                 => $hasil['skor'],
            'kategori'             => $hasil['kategori'],
        ]);

        // Evaluasi badge setelah hasil analisis tersimpan
        $this->badgeService->evaluasi($siswa, $analisis);

        return $analisis;
    }
}