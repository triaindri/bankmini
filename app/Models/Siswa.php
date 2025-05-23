<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = ['nis', 'nama'];

    public function tabungan()
    {
        return $this->hasOne(Tabungan::class);
    }

    public function transaksiAtk()
    {
        return $this->hasMany(TransaksiAtk::class);
    }
}
