<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksitabungan extends Model
{
    protected $table = 'transaksitabungan';

    protected $fillable = ['tabungan_id', 'jenis', 'jumlah', 'tanggal', 'keterangan','status','user_id'];

     protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class, 'tabungan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
