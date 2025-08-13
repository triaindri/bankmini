<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaSaldoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        // Cek apakah siswa dan tabungan tersedia
        $saldo = optional($siswa->tabungan)->saldo ?? 0;

        return view('siswa.saldo', compact('saldo'));
    }
}
