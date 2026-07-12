<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Tabungan;
use App\Models\Transaksitabungan;
use App\Models\User;
use Illuminate\Support\Carbon;

class SiswaAnalisisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugas = User::role('petugas')->first();

        if (!$petugas) {
            $petugas = User::first();
        }

        if (!$petugas) {
            $this->command->error('Tidak ada user sama sekali. Buat minimal 1 user (petugas) dulu sebelum menjalankan seeder ini.');
            return;
        }

        $dataSampel = [
            ['nis' => 'SMP0001', 'nama' => 'Siswa A', 'frekuensi' => 104, 'setoran' => 520000, 'pendapatan' => 6800000, 'tanggungan' => 2],
            ['nis' => 'SMP0002', 'nama' => 'Siswa B', 'frekuensi' => 87,  'setoran' => 410000, 'pendapatan' => 5900000, 'tanggungan' => 3],
            ['nis' => 'SMP0003', 'nama' => 'Siswa C', 'frekuensi' => 76,  'setoran' => 360000, 'pendapatan' => 4700000, 'tanggungan' => 3],
            ['nis' => 'SMP0004', 'nama' => 'Siswa D', 'frekuensi' => 18,  'setoran' => 85000,  'pendapatan' => 2300000, 'tanggungan' => 5],
            ['nis' => 'SMP0005', 'nama' => 'Siswa E', 'frekuensi' => 63,  'setoran' => 300000, 'pendapatan' => 4500000, 'tanggungan' => 2],
            ['nis' => 'SMP0006', 'nama' => 'Siswa F', 'frekuensi' => 109, 'setoran' => 610000, 'pendapatan' => 7500000, 'tanggungan' => 2],
            ['nis' => 'SMP0007', 'nama' => 'Siswa G', 'frekuensi' => 41,  'setoran' => 190000, 'pendapatan' => 3200000, 'tanggungan' => 4],
            ['nis' => 'SMP0008', 'nama' => 'Siswa H', 'frekuensi' => 12,  'setoran' => 60000,  'pendapatan' => 2000000, 'tanggungan' => 5],
            ['nis' => 'SMP0009', 'nama' => 'Siswa I', 'frekuensi' => 95,  'setoran' => 480000, 'pendapatan' => 6200000, 'tanggungan' => 3],
            ['nis' => 'SMP0010', 'nama' => 'Siswa J', 'frekuensi' => 7,   'setoran' => 25000,  'pendapatan' => 1800000, 'tanggungan' => 6],
        ];

        // Bersihkan data dummy lama supaya seeder aman dijalankan berulang kali
        $nisList = array_column($dataSampel, 'nis');
        $siswaLama = Siswa::whereIn('nis', $nisList)->get();

        foreach ($siswaLama as $lama) {
            // Hapus transaksi & tabungan dulu (foreign key), baru siswa-nya
            $tabunganLama = $lama->tabungan;
            if ($tabunganLama) {
                $tabunganLama->transaksi()->delete();
                $tabunganLama->delete();
            }
            $lama->delete();
        }

        if ($siswaLama->count() > 0) {
            $this->command->info("Data dummy lama ({$siswaLama->count()} siswa) dihapus, akan dibuat ulang.");
        }

        $periodeAwal  = Carbon::now()->subMonths(2)->startOfMonth();
        $periodeAkhir = Carbon::now()->endOfMonth();

        foreach ($dataSampel as $data) {
            $siswa = Siswa::create([
                'nis'                  => $data['nis'],
                'nama'                 => $data['nama'],
                'kelas'                => 'XI TKJ 1',
                'alamat'               => 'Jl. Contoh No. 1, Cianjur',
                'jeniskelamin'         => 'laki-laki',
                'email'                => strtolower(str_replace(' ', '', $data['nama'])) . '@contoh.sch.id',
                'telepon'              => '0812' . substr($data['nis'], -8),
                'tempat_lahir'         => 'Cianjur',
                'tanggal_lahir'        => Carbon::now()->subYears(16),
                'pendapatan_orang_tua' => $data['pendapatan'],
                'jumlah_tanggungan'    => $data['tanggungan'],
            ]);

            $tabungan = Tabungan::create([
                'siswa_id' => $siswa->id,
                'saldo'    => 0,
            ]);

            $sisaSetoran = $data['setoran'];
            $totalHari   = $periodeAwal->diffInDays($periodeAkhir);

            for ($t = 0; $t < $data['frekuensi']; $t++) {
                $isLast = $t === $data['frekuensi'] - 1;
                $jumlah = $isLast
                    ? $sisaSetoran
                    : (int) round($data['setoran'] / $data['frekuensi']);

                $sisaSetoran -= $jumlah;

                $tanggal = $periodeAwal->copy()->addDays(rand(0, $totalHari));

                Transaksitabungan::create([
                    'tabungan_id' => $tabungan->id,
                    'jenis'       => 'setor',
                    'jumlah'      => $jumlah,
                    'tanggal'     => $tanggal,
                    'keterangan'  => 'Data dummy seeder',
                    'status'      => 'disetujui',
                    'user_id'     => $petugas->id,
                ]);

                $tabungan->increment('saldo', $jumlah);
            }
            $this->command->info("Siswa {$data['nama']} dibuat dengan {$data['frekuensi']} transaksi setoran.");
        }

        $this->command->info('Periode untuk uji coba analisis: ' . $periodeAwal->format('Y-m-d') . ' s/d ' . $periodeAkhir->format('Y-m-d'));
    }

}
