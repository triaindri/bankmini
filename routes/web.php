<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiSetoranController;
use App\Http\Controllers\KoreksiSaldoController;
use App\Http\Controllers\TransaksiPenarikanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ProdukController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksitabungan/setoran', [TransaksiSetoranController::class, 'index'])->name('setoran.index');
    Route::get('/transaksitabungan/setoran/create', [TransaksiSetoranController::class, 'create'])->name('setoran.create'); // tambah halaman form
    Route::post('/transaksitabungan/setoran', [TransaksiSetoranController::class, 'store'])->name('setoran.store');

    Route::get('/transaksitabungan/setoran/get-siswa-by-nis', [TransaksiSetoranController::class, 'getSiswaByNis'])->name('setoran.getSiswaByNis'); // ajax
});


Route::middleware(['auth'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi/penarikan', [TransaksiPenarikanController::class, 'index'])->name('penarikan.index');
    Route::post('/transaksi/penarikan', [TransaksiPenarikanController::class, 'store'])->name('penarikan.store');
    Route::get('/penarikan/create/{siswa}', [TransaksiPenarikanController::class, 'create'])->name('penarikan.create');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pembelian', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');
});

require __DIR__.'/auth.php';
