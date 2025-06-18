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
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jumlah' => [
                'required',
                'integer',
                'min:500',
                function ($attribute, $value, $fail) {
                    if ($value % 500 !== 0) {
                        $fail('Jumlah penarikan harus kelipatan 500.');
                    }
                },
            ],
            'jenis' => 'required|in:Pembelian ATK,Study Tour,Kenaikan Kelas',
        ]);

        DB::beginTransaction();

        try {
            $tabungan = Tabungan::where('siswa_id', $request->siswa_id)->firstOrFail();

            if ($tabungan->saldo < $request->jumlah) {
                return back()->withErrors(['jumlah' => 'Saldo tidak cukup untuk melakukan penarikan.']);
            }

            $tabungan->saldo -= $request->jumlah;
            $tabungan->save();

            Transaksitabungan::create([
                'tabungan_id' => $tabungan->id,
                'jenis' => 'tarik',
                'jumlah' => $request->jumlah,
                'tanggal' => now(),
                'keterangan' => $request->jenis,
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('penarikan.index')->with('success', 'Penarikan berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function create($siswa_id)
    {
        $siswa = Siswa::with('tabungan')->findOrFail($siswa_id);
        $jenisPenarikan = ['Pembelian ATK', 'Study Tour', 'Kenaikan Kelas'];

        return view('transaksi.penarikan.form', compact('siswa', 'jenisPenarikan'));
    }
}