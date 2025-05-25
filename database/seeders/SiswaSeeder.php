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
            'kelas' => 'XII TKR 1',
            'alamat' => 'Seoul, Korea Selatan',
            'jeniskelamin' => 'laki-laki',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nis' => '220102',
            'nama' => 'Choi Soobin',
            'kelas' => 'XII TEIND 1',
            'alamat' => 'Anyang, Korea Selatan',
            'jeniskelamin' => 'laki-laki',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nis' => '220103',
            'nama' => 'Choi Yeonjun',
            'kelas' => 'XII TKJ 2',
            'alamat' => 'Bundang, Korea Selatan',
            'jeniskelamin' => 'laki-laki',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nis' => '220104',
            'nama' => 'Kang Taehyun',
            'kelas' => 'XII AKUL 1',
            'alamat' => 'Seoul, Korea Selatan',
            'jeniskelamin' => 'laki-laki',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nis' => '220105',
            'nama' => 'Hueningkai',
            'kelas' => 'XII AKUL 2',
            'alamat' => 'Seoul, Korea Selatan',
            'jeniskelamin' => 'laki-laki',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);
    }
}
