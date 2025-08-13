<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksitabungan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class TransaksiController extends Controller
{
    public function riwayat()
    {
        $user = Auth::user();

        // Pastikan user punya relasi ke siswa
        if (!$user->siswa) {
            abort(404, 'Data siswa tidak ditemukan.');
        }

        $siswaId = $user->siswa->id;

        // Ambil setoran
        $setoran = Transaksitabungan::whereHas('tabungan', function($q) use ($siswaId) {
                $q->where('siswa_id', $siswaId);
            })
            ->where('jenis', 'setor')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'jenis' => 'Setoran',
                    'jumlah' => $item->jumlah,
                    'keterangan' => 'Setoran tabungan'
                ];
            });

        // Ambil penarikan
        $penarikan = Transaksitabungan::whereHas('tabungan', function($q) use ($siswaId) {
                $q->where('siswa_id', $siswaId);
            })
            ->where('jenis', 'tarik')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'jenis' => 'Penarikan',
                    'jumlah' => $item->jumlah,
                    'keterangan' => $item->keterangan ?? 'Penarikan saldo tabungan'
                ];
            });

        // Ambil pembelian
        $pembelian = Penjualan::where('siswa_id', $siswaId)
            ->with('produk')
            ->get()
            ->map(function ($item) {
                $caraBayar = $item->metode_bayar === 'tabungan' ? 'Saldo tabungan' : 'Tunai';
                return [
                    'tanggal' => $item->tanggal,
                    'jenis' => 'Pembelian',
                    'jumlah' => $item->total,
                    'keterangan' => "Pembelian {$item->produk->nama} (Bayar: {$caraBayar})"
                ];
            });

        // Gabungkan semua
        $riwayat = $setoran->merge($penarikan)->merge($pembelian);

        // Urutkan berdasarkan tanggal terbaru
        $riwayat = $riwayat->sortByDesc('tanggal')->values();

        // Pagination manual
        $perPage = 10;
        $page = request()->get('page', 1);
        $pagedData = new LengthAwarePaginator(
            $riwayat->forPage($page, $perPage),
            $riwayat->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('siswa.riwayat-transaksi', ['transaksi' => $pagedData]);
    }
}
