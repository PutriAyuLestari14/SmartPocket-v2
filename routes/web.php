<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\AdminNasabahController;
use App\Http\Controllers\OperatorController;

// Tambahan import agar tidak error "Class not found"
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // ==========================================
    // ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('admin.nasabah.index');
        });
        Route::get('/nasabah', [AdminNasabahController::class, 'index'])->name('admin.nasabah.index');
    });

    // ==========================================
    // OPERATOR
    // ==========================================
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

        Route::resource('setoran', SetoranController::class)->names([
            'create' => 'operator.setoran.create',
            'store'  => 'operator.setoran.store',
        ]);

        Route::resource('penarikan', PenarikanController::class)->names([
            'create' => 'operator.penarikan.create',
            'store'  => 'operator.penarikan.store',
        ]);

        Route::resource('pembayaran', PembayaranController::class)->names([
            'create' => 'operator.pembayaran.create',
            'store'  => 'operator.pembayaran.store',
        ]);
    });

    // ==========================================
    // NASABAH
    // ==========================================
    Route::middleware(['role:nasabah'])->group(function () {
        // Dashboard
        Route::get('/nasabah/dashboard', [TabunganController::class, 'index'])->name('nasabah.dashboard');
        
        // --- TAMBAHAN BARU: Route Riwayat Transaksi ---
        Route::get('/nasabah/riwayat', function () {
            return view('nasabah.riwayat'); 
        })->name('nasabah.riwayat');
    });

    // ==========================================
    // PROFILE
    // ==========================================
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';