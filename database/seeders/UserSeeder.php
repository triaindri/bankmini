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
        User::create([
            'name' => 'Koordinator Bank Mini',
            'email' => 'koordinator@bankmini.test',
            'username' => 'koordinator',
            'password' => Hash::make('password'),
            'role' => 'koordinator',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas Bank Mini',
            'email' => 'petugas@bankmini.test',
            'username' => 'petugas',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);
    }
}
