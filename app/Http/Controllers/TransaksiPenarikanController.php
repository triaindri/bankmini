<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tabungan;
use App\Models\Transaksi;
use App\Models\Transaksitabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiPenarikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->has('q') && $request->q !== null) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('nama', 'like', '%' . $q . '%')
                        ->orWhere('nis', 'like', '%' . $q . '%');
            });
        }

        $siswa = $query->get();

        return view('transaksi.penarikan.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        // Validasi awal
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jumlah'   => [
                'required',
                'integer',
                'min:500',
                function ($attribute, $value, $fail) {
                    if ($value % 500 !== 0) {
                        $fail('Jumlah penarikan harus kelipatan 500.');
                    }
                },
            ],
            'jenis'    => 'required|in:Pembelian ATK,Study Tour,Kenaikan Kelas',
        ]);

        try {
            DB::beginTransaction();

            $tabungan = Tabungan::where('siswa_id', $request->siswa_id)->first();

            // Kalau siswa belum punya tabungan atau saldonya 0
            if (!$tabungan || $tabungan->saldo <= 0) {
                return back()
                    ->withInput()
                    ->with('error', 'Saldo tabungan siswa ini masih 0.');
            }

            // Periksa saldo cukup atau tidak
            if ($tabungan->saldo < $request->jumlah) {
                return back()
                    ->withInput()
                    ->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan.');
            }

            // Status otomatis disetujui jika Pembelian ATK
            $status = $request->jenis === 'Pembelian ATK' ? 'disetujui' : 'pending';

            if ($status === 'disetujui') {
                $tabungan->saldo -= $request->jumlah;
                $tabungan->save();
            }

            Transaksitabungan::create([
                'tabungan_id' => $tabungan->id,
                'jenis'       => 'tarik',
                'jumlah'      => $request->jumlah,
                'tanggal'     => now(),
                'keterangan'  => $request->jenis,
                'user_id'     => Auth::id(),
                'status'      => $status,
            ]);

            DB::commit();

            return redirect()->route('penarikan.index')->with(
                'success',
                $status === 'pending'
                    ? 'Penarikan berhasil dicatat dan menunggu persetujuan koordinator.'
                    : 'Penarikan berhasil diproses.'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function create($siswa_id)
    {
        $siswa = Siswa::with('tabungan')->findOrFail($siswa_id);
        $jenisPenarikan = ['Pembelian ATK', 'Study Tour', 'Kenaikan Kelas'];

        return view('transaksi.penarikan.form', compact('siswa', 'jenisPenarikan'));
    }
}