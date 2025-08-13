<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $koordinator = User::UpdateorCreate([
            'email' => 'koordinator@bankmini.test'],[
            'name' => 'Koordinator Bank Mini',
            'username' => 'koordinator',
            'password' => Hash::make('password'),
        ]);
        $koordinator->assignRole('koordinator');

        // Petugas
        $petugas = User::UpdateorCreate([
            'email' => 'petugas@bankmini.test'],[
            'name' => 'Petugas Bank Mini',
            'username' => 'petugas',
            'password' => Hash::make('password'),
        ]);
        $petugas->assignRole('petugas');

        $siswa = User::UpdateorCreate([
            'email' => 'siswa@bankmini.test'],[
            'name' => 'siswa Bank Mini',
            'username' => 'siswa',
            'password' => Hash::make('password'),
        ]);
        $siswa->assignRole('siswa');
    }
}
