<?php

namespace App\Http\Controllers;

use App\Models\Transaksitabungan;
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

        $transaksi = Transaksitabungan::with('tabungan')->findOrFail($id);

        if ($request->aksi === 'setujui') {
            $transaksi->status = 'disetujui';
            $tabungan = $transaksi->tabungan;
            $tabungan->saldo -= $transaksi->jumlah;
            $tabungan->save();
        } else {
            $transaksi->status = 'ditolak';
        }

        $transaksi->save();

        return redirect()->route('otorisasi.index')->with('success', 'Transaksi telah diperbarui.');
    }
}
