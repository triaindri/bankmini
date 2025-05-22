<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'nis' => '220101',
                'nama' => 'Choi Beomgyu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '220102',
                'nama' => 'Choi Soobin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '220103',
                'nama' => 'Choi Yeonjun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '220104',
                'nama' => 'Kang Taehyun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis' => '220105',
                'nama' => 'Hueningkai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
