<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'kode' => 'menabung_baik',
                'nama' => 'Menabung Baik',
                'deskripsi' => 'Diberikan saat hasil analisis perilaku menabung berkategori "Baik" pada satu periode.',
            ],
            [
                'kode' => 'konsisten_baik',
                'nama' => 'Konsisten Baik',
                'deskripsi' => 'Diberikan saat kategori "Baik" tercapai 3 periode analisis berturut-turut.',
            ],
            [
                'kode' => 'teladan_menabung',
                'nama' => 'Teladan Menabung',
                'deskripsi' => 'Diberikan saat kategori "Baik" tercapai 6 periode analisis berturut-turut.',
            ],
             [
                'kode' => 'peningkatan_signifikan',
                'nama' => 'Peningkatan Signifikan',
                'deskripsi' => 'Diberikan saat kategori meningkat dari "Kurang"/"Cukup" menjadi "Baik" dibanding periode sebelumnya.',
            ],
        ];

         foreach ($badges as $badge) {
            Badge::updateOrCreate(['kode' => $badge['kode']], $badge);
        }
    }
}
