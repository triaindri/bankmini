<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = ['nama', 'harga_beli','harga_jual', 'stok', 'gambar'];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
