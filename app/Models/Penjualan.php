<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
     protected $fillable = ['produk_id', 'jumlah', 'total', 'tanggal'];

     public function details()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

}
