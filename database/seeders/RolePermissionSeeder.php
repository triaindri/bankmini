<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Define permissions
        // $permissions = [
        //     'create-siswa',
        //     'read-siswa',
        //     'edit-siswa',
        //     'view-rekapitulasi',
        //     'manage-transaksi-tabungan',
        //     'manage-transaksi-atk',
        //     'view-saldo',
        //     'view-riwayat-transaksi',
        //     'view-produk',
        // ];

        // // Create permissions
        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }

        // // Create roles
        // $koordinator = Role::firstOrCreate(['name' => 'koordinator']);
        // $petugas     = Role::firstOrCreate(['name' => 'petugas']);
        // $siswa       = Role::firstOrCreate(['name' => 'siswa']);

        // // Assign permissions to Koordinator
        // $koordinator->givePermissionTo([
        //     'create-siswa',
        //     'read-siswa',
        //     'edit-siswa',
        //     'view-rekapitulasi',
        // ]);

        // // Assign permissions to Petugas
        // $petugas->givePermissionTo([
        //     'read-siswa',
        //     'manage-transaksi-tabungan',
        //     'manage-transaksi-atk',
        // ]);

        // // Assign permissions to Siswa
        // $siswa->givePermissionTo([
        //     'view-saldo',
        //     'view-riwayat-transaksi',
        //     'view-produk',
        // ]);
        Role::create(['name'=>'koordinator']);
        Role::create(['name'=>'petugas']);
        Role::create(['name'=>'siswa']);
    }
}
