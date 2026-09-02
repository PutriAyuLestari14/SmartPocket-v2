<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\AdminNasabahController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\NasabahPenarikanController;
use App\Http\Controllers\NasabahPeminjamanController; 
use App\Http\Controllers\TransaksiController; 
use App\Http\Controllers\OperatorPeminjamanController; 
use App\Http\Controllers\OperatorVerifikasiController; 
use App\Http\Controllers\OperatorLaporanController; 
use App\Http\Controllers\OperatorSetoranController; 
use App\Http\Controllers\OperatorPenarikanController; 
use App\Http\Controllers\OperatorPembayaranController; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/nasabah', [AdminNasabahController::class, 'index'])->name('admin.nasabah.index');
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
    });

    // OPERATOR
    Route::middleware(['role:operator'])->prefix('operator')->group(function () {
        Route::get('/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');
        Route::resource('nasabah', NasabahController::class)->names([
            'index' => 'operator.nasabah.index', 'create' => 'operator.nasabah.create',
            'store' => 'operator.nasabah.store', 'edit' => 'operator.nasabah.edit',
            'update' => 'operator.nasabah.update', 'destroy' => 'operator.nasabah.destroy',
        ]);

        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('operator.transaksi.index');
        
        Route::get('/verifikasi', [OperatorVerifikasiController::class, 'index'])->name('operator.verifikasi.index');

        Route::get('/laporan', [OperatorLaporanController::class, 'index'])->name('operator.laporan.index');

        Route::get('/peminjaman', [OperatorPeminjamanController::class, 'index'])->name('operator.peminjaman.index');
        Route::get('/peminjaman/create', [OperatorPeminjamanController::class, 'create'])->name('operator.peminjaman.create');
        Route::post('/peminjaman', [OperatorPeminjamanController::class, 'store'])->name('operator.peminjaman.store');

        Route::get('/setoran/search', [OperatorSetoranController::class, 'searchNasabah'])->name('operator.setoran.search');
        Route::get('/setoran/create', [OperatorSetoranController::class, 'create'])->name('operator.setoran.create');
        Route::post('/setoran', [OperatorSetoranController::class, 'store'])->name('operator.setoran.store');
        
        Route::get('/penarikan/create', [OperatorPenarikanController::class, 'create'])->name('operator.penarikan.create');
        Route::post('/penarikan', [OperatorPenarikanController::class, 'store'])->name('operator.penarikan.store');

        Route::get('/pembayaran/create', [OperatorPembayaranController::class, 'create'])->name('operator.pembayaran.create');
        Route::post('/pembayaran', [OperatorPembayaranController::class, 'store'])->name('operator.pembayaran.store');

    });

    // NASABAH 
    Route::middleware(['role:nasabah'])->group(function () {
        Route::get('/nasabah/dashboard', [TabunganController::class, 'index'])->name('nasabah.dashboard');
        
        Route::get('/riwayat', [TabunganController::class, 'riwayat'])->name('nasabah.riwayat');


        Route::get('/nasabah/penarikan', [NasabahPenarikanController::class, 'create'])->name('nasabah.penarikan.create');
        Route::post('/nasabah/penarikan', [NasabahPenarikanController::class, 'store'])->name('nasabah.penarikan.store');

        Route::get('/nasabah/peminjaman', [NasabahPeminjamanController::class, 'create'])->name('nasabah.peminjaman.create');
        Route::post('/nasabah/peminjaman', [NasabahPeminjamanController::class, 'store'])->name('nasabah.peminjaman.store');
    });

    // PROFILE
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';