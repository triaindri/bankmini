<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
     protected $fillable = ['produk_id', 'jumlah', 'total', 'tanggal'];

      public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}
