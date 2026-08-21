<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Route yang wajib login
Route::middleware(['auth'])->group(function () {

    // Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view ('dashboard');
        })->name('admin.dashboard');
    });

    // Petugas
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', function () {
            return view ('dashboard');
        })->name('petugas.dashboard');
    });

    // Nasabah
    Route::middleware(['role:nasabah'])->group(function () {
        Route::get('/nasabah/dashboard', function () {
            return view ('dashboard');
        })->name('nasabah.dashboard');
    });

        Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';