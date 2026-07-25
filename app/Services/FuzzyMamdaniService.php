<?php
// app/Services/FuzzyMamdaniService.php

namespace App\Services;

class FuzzyMamdaniService
{
    /**
     * Definisi variabel input & output.
     * Format tiap himpunan: 'nama' => [tipe, ...titik]
     * tipe: 'shoulder_left' (a,b) | 'triangle' (a,b,c) | 'shoulder_right' (a,b)
     */
    protected array $variables = [
        'frekuensi' => [
            'rendah' => ['shoulder_left', 0, 36],
            'sedang' => ['triangle', 20, 50, 80],
            'tinggi' => ['shoulder_right', 60, 110],
        ],
        'setoran' => [
            'kecil'  => ['shoulder_left', 0, 300000],
            'sedang' => ['triangle', 200000, 375000, 550000],
            'besar'  => ['shoulder_right', 450000, 700000],
        ],
        'pendapatan' => [
            'rendah' => ['shoulder_left', 1000000, 5000000],
            'sedang' => ['triangle', 3000000, 6500000, 10000000],
            'tinggi' => ['shoulder_right', 8000000, 15000000],
        ],
        'tanggungan' => [
            'sedikit' => ['shoulder_left', 1, 3],
            'sedang'  => ['triangle', 2, 3.5, 5],
            'banyak'  => ['shoulder_right', 4, 7],
        ],
    ];

    protected array $output = [
        'kurang' => ['shoulder_left', 0, 33],
        'cukup'  => ['triangle', 17, 50, 83],
        'baik'   => ['shoulder_right', 67, 100],
    ];

    protected float $outputMin = 0;
    protected float $outputMax = 100;

    /**
     * Rule base sesuai Tabel 3.12 pada TA.
     * Format: [frekuensi, setoran, pendapatan, tanggungan, => output]
     */
    protected array $rules = [
        ['tinggi','besar','rendah','banyak','baik'],
        ['tinggi','besar','sedang','sedang','baik'],
        ['tinggi','besar','tinggi','sedikit','baik'],
        ['tinggi','sedang','rendah','banyak','baik'],
        ['tinggi','sedang','sedang','sedang','baik'],
        ['tinggi','sedang','tinggi','sedikit','baik'],
        ['tinggi','besar','rendah','sedang','baik'],
        ['tinggi','besar','sedang','banyak','baik'],
        ['tinggi','sedang','rendah','sedikit','baik'],
        ['sedang','sedang','rendah','banyak','cukup'],
        ['sedang','sedang','sedang','sedang','cukup'],
        ['sedang','sedang','tinggi','sedikit','cukup'],
        ['sedang','besar','rendah','banyak','cukup'],
        ['sedang','besar','sedang','sedang','cukup'],
        ['sedang','kecil','rendah','banyak','cukup'],
        ['tinggi','kecil','rendah','banyak','cukup'],
        ['rendah','besar','tinggi','sedikit','cukup'],
        ['sedang','kecil','sedang','sedang','cukup'],
        ['rendah','kecil','tinggi','sedikit','kurang'],
        ['rendah','kecil','sedang','sedang','kurang'],
        ['rendah','kecil','rendah','banyak','kurang'],
        ['rendah','sedang','tinggi','sedikit','kurang'],
        ['sedang','kecil','tinggi','sedikit','kurang'],
        ['rendah','sedang','sedang','sedang','kurang'],
        ['rendah','besar','rendah','banyak','kurang'],
        ['sedang','kecil','sedang','sedang','kurang'],
        ['rendah','sedang','rendah','banyak','kurang'],
    ];

    public function analisis(float $frekuensi, float $setoran, float $pendapatan, float $tanggungan): array
    {
        $muFrekuensi   = $this->fuzzify('frekuensi', $frekuensi);
        $muSetoran     = $this->fuzzify('setoran', $setoran);
        $muPendapatan  = $this->fuzzify('pendapatan', $pendapatan);
        $muTanggungan  = $this->fuzzify('tanggungan', $tanggungan);

        // Agregasi derajat keanggotaan output (operator MAX antar rule aktif)
        $aggregated = ['kurang' => 0, 'cukup' => 0, 'baik' => 0];

        foreach ($this->rules as [$f, $s, $p, $t, $out]) {
            $alpha = min(
                $muFrekuensi[$f]  ?? 0,
                $muSetoran[$s]    ?? 0,
                $muPendapatan[$p] ?? 0,
                $muTanggungan[$t] ?? 0,
            );
            $aggregated[$out] = max($aggregated[$out], $alpha);
        }

        // fallback jika tidak ada rule yang aktif sama sekali
        if (array_sum($aggregated) == 0) {
            $aggregated['cukup'] = 0.1;
        }

        $skor = $this->defuzzifikasiCentroid($aggregated);
        $kategori = $this->tentukanKategori($skor);

        return [
            'fuzzifikasi' => compact('muFrekuensi', 'muSetoran', 'muPendapatan', 'muTanggungan'),
            'aggregated'  => $aggregated,
            'skor'        => round($skor, 2),
            'kategori'    => $kategori,
        ];
    }

    protected function fuzzify(string $variable, float $x): array
    {
        $result = [];
        foreach ($this->variables[$variable] as $label => $params) {
            $result[$label] = $this->membership($params, $x);
        }
        return $result;
    }

    protected function membership(array $params, float $x): float
    {
        [$type] = $params;

        return match ($type) {
            'shoulder_left' => $this->shoulderLeft($x, $params[1], $params[2]),
            'triangle'      => $this->triangle($x, $params[1], $params[2], $params[3]),
            'shoulder_right'=> $this->shoulderRight($x, $params[1], $params[2]),
        };
    }

    protected function shoulderLeft(float $x, float $a, float $b): float
    {
        if ($x <= $a) return 1.0;
        if ($x >= $b) return 0.0;
        return ($b - $x) / ($b - $a);
    }

    protected function shoulderRight(float $x, float $a, float $b): float
    {
        if ($x <= $a) return 0.0;
        if ($x >= $b) return 1.0;
        return ($x - $a) / ($b - $a);
    }

    protected function triangle(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) return 0.0;
        if ($x == $b) return 1.0;
        return $x < $b
            ? ($x - $a) / ($b - $a)
            : ($c - $x) / ($c - $b);
    }

    /**
     * Metode Centroid dihitung secara numerik (integrasi diskrit).
     * Lebih sederhana & robust dibanding dekomposisi geometris manual,
     * hasilnya setara pada resolusi step kecil (di sini 0.1).
     */
    protected function defuzzifikasiCentroid(array $aggregated): float
    {
        $step = 0.1;
        $sumZMu = 0.0;
        $sumMu  = 0.0;

        for ($z = $this->outputMin; $z <= $this->outputMax; $z += $step) {
            $muKurang = min($aggregated['kurang'], $this->membership($this->output['kurang'], $z));
            $muCukup  = min($aggregated['cukup'],  $this->membership($this->output['cukup'], $z));
            $muBaik   = min($aggregated['baik'],   $this->membership($this->output['baik'], $z));

            $mu = max($muKurang, $muCukup, $muBaik);

            $sumZMu += $z * $mu;
            $sumMu  += $mu;
        }

        return $sumMu > 0 ? $sumZMu / $sumMu : 0.0;
    }

    protected function tentukanKategori(float $skor): string
    {
        return match (true) {
            $skor >= 67 => 'Baik',
            $skor >= 34 => 'Cukup',
            default     => 'Kurang',
        };
    }
}