<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\NasabahProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\AdminNasabahController;
use App\Http\Controllers\AdminSaldoController;
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
        Route::get('/saldo', [AdminSaldoController::class, 'index'])->name('admin.saldo.index');
    });

    // OPERATOR
    Route::middleware(['role:operator'])->prefix('operator')->group(function () {
        Route::get('/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');
        Route::resource('nasabah', NasabahController::class)->names([
            'index' => 'operator.nasabah.index', 'create' => 'operator.nasabah.create',
            'store' => 'operator.nasabah.store', 'edit' => 'operator.nasabah.edit',
            'update' => 'operator.nasabah.update', 'destroy' => 'operator.nasabah.destroy',
        ]);

        // setoran nasabah
        Route::get('/setoran/search', [OperatorSetoranController::class, 'searchNasabah'])->name('operator.setoran.search');
        Route::get('/setoran/create', [OperatorSetoranController::class, 'create'])->name('operator.setoran.create');
        Route::post('/setoran', [OperatorSetoranController::class, 'store'])->name('operator.setoran.store');
        
        // penarikan nasabah
        Route::get('/penarikan/create', [OperatorPenarikanController::class, 'create'])->name('operator.penarikan.create');
        Route::post('/penarikan', [OperatorPenarikanController::class, 'store'])->name('operator.penarikan.store');

        // peminjaman guru
        Route::get('/peminjaman', [OperatorPeminjamanController::class, 'index'])->name('operator.peminjaman.index');
        Route::get('/peminjaman/create', [OperatorPeminjamanController::class, 'create'])->name('operator.peminjaman.create');
        Route::post('/peminjaman', [OperatorPeminjamanController::class, 'store'])->name('operator.peminjaman.store');

        // pembayaran guru
        Route::get('/pembayaran/create', [OperatorPembayaranController::class, 'create'])->name('operator.pembayaran.create');
        Route::post('/pembayaran', [OperatorPembayaranController::class, 'store'])->name('operator.pembayaran.store');

        // verifikasi pengajuan
        Route::get('/verifikasi', [OperatorVerifikasiController::class, 'index'])->name('operator.verifikasi.index');
        Route::post('/verifikasi/{id}/approve', [OperatorVerifikasiController::class, 'approve'])->name('operator.verifikasi.approve');
        Route::post('/verifikasi/{id}/reject', [OperatorVerifikasiController::class, 'reject'])->name('operator.verifikasi.reject');

        // transaksi riwayat
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('operator.transaksi.index');

        // laporan
        Route::get('/laporan', [OperatorLaporanController::class, 'index'])->name('operator.laporan.index');

    });

    // NASABAH 
    Route::middleware(['role:nasabah'])->group(function () {
        Route::get('/nasabah/dashboard', [TabunganController::class, 'index'])->name('nasabah.dashboard');
        
        //riwayat
        Route::get('/riwayat', [TabunganController::class, 'riwayat'])->name('nasabah.riwayat');

        //penarikan
        Route::get('/nasabah/penarikan', [NasabahPenarikanController::class, 'create'])->name('nasabah.penarikan.create');
        Route::post('/nasabah/penarikan', [NasabahPenarikanController::class, 'store'])->name('nasabah.penarikan.store');

        // peminjaman wat GURU YAK
        Route::get('/nasabah/peminjaman', [NasabahPeminjamanController::class, 'create'])->name('nasabah.peminjaman.create');
        Route::post('/nasabah/peminjaman', [NasabahPeminjamanController::class, 'store'])->name('nasabah.peminjaman.store');

        // Profile Nasabah
        Route::get('/nasabah/profile', [NasabahProfileController::class, 'edit'])->name('nasabah.profile.edit');
        Route::patch('/nasabah/profile', [NasabahProfileController::class, 'update'])->name('nasabah.profile.update');

        // Change Password Nasabah
        Route::get('/nasabah/password', [NasabahProfileController::class, 'editPassword'])->name('nasabah.password.edit');
        Route::put('/nasabah/password', [NasabahProfileController::class, 'updatePassword'])->name('nasabah.password.update');

    });

    // profile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';