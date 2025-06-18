<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'nama' => 'Pulpen Biru',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
                'stok' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pensil 2B',
                'harga_beli' => 1500,
                'harga_jual' => 2000,
                'stok' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
