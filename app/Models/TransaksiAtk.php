<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiAtk extends Model
{
    protected $table = 'transaksi_atk';

    protected $fillable = ['siswa_id', 'produk_id', 'jumlah', 'total_harga', 'metode_pembayaran', 'user_id', 'tanggal'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function barang()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
