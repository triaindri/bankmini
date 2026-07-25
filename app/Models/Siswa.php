<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = ['nis', 'nama', 'kelas', 'alamat', 'jeniskelamin', 'email', 'telepon', 'tempat_lahir', 'tanggal_lahir', 'pendapatan_orang_tua', 'jumlah_tanggungan',];

    public function tabungan()
    {
        return $this->hasOne(Tabungan::class);
    }

    public function transaksiAtk()
    {
        return $this->hasMany(TransaksiAtk::class);
    }

    public function analisisPerilaku()
    {
        return $this->hasMany(AnalisisPerilakuMenabung::class);
    }

    public function badges()
    {
        return $this->hasMany(SiswaBadge::class);
    }
}
