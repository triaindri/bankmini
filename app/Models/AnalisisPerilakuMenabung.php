<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisPerilakuMenabung extends Model
{
    protected $table = 'analisis_perilaku_menabung';

    protected $fillable = [
        'siswa_id', 'periode_awal', 'periode_akhir',
        'frekuensi_menabung', 'jumlah_setoran',
        'pendapatan_orang_tua', 'jumlah_tanggungan',
        'skor', 'kategori',
    ];

    protected $casts = [
        'periode_awal'  => 'date',
        'periode_akhir' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
