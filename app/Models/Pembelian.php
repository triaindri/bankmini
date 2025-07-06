<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = ['produk_id', 'jumlah'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
