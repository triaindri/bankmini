<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoreksiSaldoController extends Controller
{
    public function create(Siswa $siswa)
    {
        $tabungan = $siswa->tabungan;
        return view('koreksi.create', compact('siswa', 'tabungan'));
    }

    public function store(Request $request, Siswa $siswa)
    {
        $request->validate([
            'koreksi_saldo' => 'required|integer',
            'alasan' => 'required|string|max:255',
        ]);

        // Cek tabungan
        $tabungan = $siswa->tabungan;

        if (!$tabungan) {
            $tabungan = $siswa->tabungan()->create([
                'saldo' => 0,
            ]);
        }

        // Koreksi saldo
        $tabungan->saldo += $request->koreksi_saldo;
        $tabungan->save();

        // Redirect
        return redirect()->route('siswa.index')->with('success', 'Saldo berhasil dikoreksi.');
    }

}
