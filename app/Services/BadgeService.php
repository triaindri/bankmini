<?php
// app/Services/BadgeService.php

namespace App\Services;

use App\Models\AnalisisPerilakuMenabung;
use App\Models\Badge;
use App\Models\Siswa;
use App\Models\SiswaBadge;

class BadgeService
{
    /**
     * Evaluasi dan berikan badge berdasarkan hasil analisis terbaru siswa.
     * Dipanggil setelah satu record AnalisisPerilakuMenabung dibuat.
     *
     * @return \App\Models\Badge[] badge baru yang diperoleh (bisa kosong)
     */
    public function evaluasi(Siswa $siswa, AnalisisPerilakuMenabung $analisisTerbaru): array
    {
        $riwayat = $siswa->analisisPerilaku()
            ->orderByDesc('periode_akhir')
            ->limit(6)
            ->get();

        $badgeBaru = [];

        // 1. Menabung Baik — kategori Baik pada periode ini
        if ($analisisTerbaru->kategori === 'Baik') {
            $badgeBaru[] = $this->beriBadge($siswa, 'menabung_baik', $analisisTerbaru);
        }

        // 2 & 3. Konsisten Baik (3x) / Teladan Menabung (6x) berturut-turut
        $berturutBaik = 0;
        foreach ($riwayat as $item) {
            if ($item->kategori === 'Baik') {
                $berturutBaik++;
            } else {
                break; // berhenti begitu rangkaian "Baik" terputus
            }
        }

        if ($berturutBaik >= 3) {
            $badgeBaru[] = $this->beriBadge($siswa, 'konsisten_baik', $analisisTerbaru);
        }

        if ($berturutBaik >= 6) {
            $badgeBaru[] = $this->beriBadge($siswa, 'teladan_menabung', $analisisTerbaru);
        }

        // 4. Peningkatan Signifikan — kategori sebelumnya Kurang/Cukup, sekarang Baik
        $periodeSebelumnya = $riwayat->skip(1)->first();
        if (
            $analisisTerbaru->kategori === 'Baik'
            && $periodeSebelumnya
            && in_array($periodeSebelumnya->kategori, ['Kurang', 'Cukup'])
        ) {
            $badgeBaru[] = $this->beriBadge($siswa, 'peningkatan_signifikan', $analisisTerbaru);
        }

        return array_values(array_filter($badgeBaru));
    }

    protected function beriBadge(Siswa $siswa, string $kodeBadge, AnalisisPerilakuMenabung $analisis): ?Badge
    {
        $badge = Badge::where('kode', $kodeBadge)->first();

        if (!$badge) {
            return null;
        }

        $sudahAda = SiswaBadge::where('siswa_id', $siswa->id)
            ->where('badge_id', $badge->id)
            ->where('analisis_perilaku_menabung_id', $analisis->id)
            ->exists();

        if ($sudahAda) {
            return null; // sudah pernah diberikan untuk analisis ini, jangan dobel
        }

        SiswaBadge::create([
            'siswa_id' => $siswa->id,
            'badge_id' => $badge->id,
            'analisis_perilaku_menabung_id' => $analisis->id,
            'diperoleh_pada' => now(),
        ]);

        return $badge;
    }
}