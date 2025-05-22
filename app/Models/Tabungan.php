<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = ['siswa_id', 'saldo'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksitabungan::class);
    }
}
