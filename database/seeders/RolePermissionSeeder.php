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
        // Create Permissions
        Permission::create(['name' => 'create-siswa']);
        Permission::create(['name' => 'read-siswa']);
        // Permission::create(['name' => 'edit-siswa']);
        // Permission::create(['name' => 'view-rekapitulasi']);
        // Permission::create(['name' => 'manage-transaksi-tabungan']);
        // Permission::create(['name' => 'manage-transaksi-atk']);
        // Permission::create(['name' => 'view-saldo']);
        // Permission::create(['name' => 'view-riwayat-transaksi']);
        // Permission::create(['name' => 'view-produk']);

        // Create Roles
        Role::create(['name' => 'koordinator']);
        Role::create(['name' => 'petugas']);
        Role::create(['name' => 'siswa']);

        // Assign Permissions to Role - Koordinator
        $roleKoordinator = Role::findByName('koordinator');
        $roleKoordinator->givePermissionTo([
            'create-siswa',
            'read-siswa',
            // 'edit-siswa',
            // 'view-rekapitulasi',
        ]);

        // Assign Permissions to Role - Petugas
        $rolePetugas = Role::findByName('petugas');
        $rolePetugas->givePermissionTo([
            'read-siswa',
            // 'manage-transaksi-tabungan',
            // 'manage-transaksi-atk',
        ]);

        // Assign Permissions to Role - Siswa
        $roleSiswa = Role::findByName('siswa');
        $roleSiswa->givePermissionTo([
            'read-saldo',
            // 'read-riwayat-transaksi',
            'read-produk',
        ]);
    }
}
