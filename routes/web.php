<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\AdminNasabahController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\OperatorPeminjamanController; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('admin.nasabah.index');
        });
        Route::get('/nasabah', [AdminNasabahController::class, 'index'])->name('admin.nasabah.index');
    });

    // OPERATOR
    Route::middleware(['role:operator'])->prefix('operator')->group(function () {
        Route::get('/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');

        Route::resource('nasabah', NasabahController::class)->names([
            'index'   => 'operator.nasabah.index',
            'create'  => 'operator.nasabah.create',
            'store'   => 'operator.nasabah.store',
            'edit'    => 'operator.nasabah.edit',
            'update'  => 'operator.nasabah.update',
            'destroy' => 'operator.nasabah.destroy',
        ]);

        // Route untuk tabungan
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('operator.transaksi.index');
        Route::get('/transaksi/riwayat', [TransaksiController::class, 'history'])->name('operator.transaksi.riwayat');

        Route::get('/transaksi/setoran', [TransaksiController::class, 'index'])->name('operator.setoran.create');
        Route::post('/transaksi/setoran', [TransaksiController::class, 'storeDeposit'])->name('operator.setoran.store');
        
        Route::get('/transaksi/penarikan', [TransaksiController::class, 'index'])->name('operator.penarikan.create');
        Route::post('/transaksi/penarikan', [TransaksiController::class, 'storeWithdrawal'])->name('operator.penarikan.store');

        //Route untuk peminjaman dan pembayaran
        Route::get('/peminjaman', [OperatorPeminjamanController::class, 'index'])->name('operator.peminjaman.index');
        Route::get('/peminjaman/create', [OperatorPeminjamanController::class, 'create'])->name('operator.peminjaman.create');
        Route::post('/peminjaman', [OperatorPeminjamanController::class, 'store'])->name('operator.peminjaman.store');
        
        Route::get('/peminjaman/pembayaran', [OperatorPeminjamanController::class, 'pembayaranIndex'])->name('operator.pembayaran.create');
        Route::post('/peminjaman/pembayaran', [OperatorPeminjamanController::class, 'storePembayaran'])->name('operator.pembayaran.store');
    });

    // NASABAH
    Route::middleware(['role:nasabah'])->group(function () {
        Route::get('/nasabah/dashboard', [TabunganController::class, 'index'])->name('nasabah.dashboard');
        Route::get('/nasabah/riwayat', function () {
            return view('nasabah.riwayat'); 
        })->name('nasabah.riwayat');
    });

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';