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
                'harga' => 3000,
                'stok' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pensil 2B',
                'harga' => 2000,
                'stok' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Penghapus',
                'harga' => 1500,
                'stok' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Buku Tulis',
                'harga' => 4000,
                'stok' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rautan',
                'harga' => 2500,
                'stok' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
