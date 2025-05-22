<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiSetoranController;
use App\Http\Controllers\KoreksiSaldoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksitabungan/setoran', [TransaksiSetoranController::class, 'index'])->name('setoran.index');
    Route::post('/transaksitabungan/setoran', [TransaksiSetoranController::class, 'store'])->name('setoran.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/{siswa}/koreksi', [KoreksiSaldoController::class, 'create'])->name('koreksi.create');
    Route::post('/siswa/{siswa}/koreksi', [KoreksiSaldoController::class, 'store'])->name('koreksi.store');
});

require __DIR__.'/auth.php';
