<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaBadge extends Model
{
    protected $table = 'siswa_badges';

    protected $fillable = ['siswa_id', 'badge_id', 'analisis_perilaku_menabung_id', 'diperoleh_pada'];

    protected $casts = ['diperoleh_pada' => 'datetime'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
