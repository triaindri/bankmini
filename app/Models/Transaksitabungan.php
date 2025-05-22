<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksitabungan extends Model
{
    protected $table = 'transaksitabungan';

    protected $fillable = ['tabungan_id', 'jenis', 'jumlah', 'tanggal', 'user_id'];

    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
