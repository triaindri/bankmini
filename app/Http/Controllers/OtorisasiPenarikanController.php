<?php

namespace App\Http\Controllers;

use App\Models\Transaksitabungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OtorisasiPenarikanController extends Controller
{
    public function index()
    {
        $transaksiPending = Transaksitabungan::where('jenis', 'tarik')
            ->whereIn('keterangan', ['Study Tour', 'Kenaikan Kelas'])
            ->where('status', 'pending')
            ->with(['tabungan.siswa'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('koordinator.otorisasi.index', compact('transaksiPending'));
    }

    // Aksi menyetujui / menolak
    public function update(Request $request, $id)
{
    $request->validate([
        'aksi' => 'required|in:setujui,tolak',
    ]);

    DB::beginTransaction();
    try {
        $transaksi = Transaksitabungan::with('tabungan')->findOrFail($id);

        if ($request->aksi === 'setujui') {
            $transaksi->status = 'disetujui';
            $tabungan = $transaksi->tabungan;

            if (!$tabungan) {
                throw new \Exception('Data tabungan tidak ditemukan.');
            }

            // Pastikan saldo cukup sebelum dikurangi
            if ($tabungan->saldo < $transaksi->jumlah) {
                throw new \Exception('Saldo tabungan tidak mencukupi.');
            }

            $tabungan->saldo -= $transaksi->jumlah;
            $tabungan->save();
        } else {
            $transaksi->status = 'ditolak';
        }

        $transaksi->save();
        DB::commit();

        return redirect()->route('otorisasi.index')
            ->with('success', 'Transaksi telah diperbarui.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
    }
}
}
