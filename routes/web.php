<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\AdminNasabahController;

Route::get('/', function () {
    return view('welcome');
});

// Route yang wajib login
Route::middleware(['auth'])->group(function () {

    // Admin
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('admin.nasabah.index');
        });
        Route::get('/nasabah', [AdminNasabahController::class, 'index'])->name('admin.nasabah.index');
    });

    // operator
    Route::middleware(['role:operator'])->prefix('operator')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('operator.nasabah.index');
        });

        Route::resource('nasabah', NasabahController::class)->names([
            'index'   => 'operator.nasabah.index',
            'create'  => 'operator.nasabah.create',
            'store'   => 'operator.nasabah.store',
            'edit'    => 'operator.nasabah.edit',
            'update'  => 'operator.nasabah.update',
            'destroy' => 'operator.nasabah.destroy',
        ]);
    });

    // Nasabah
    Route::middleware(['role:nasabah'])->group(function () {
        Route::get('/nasabah/dashboard', [TabunganController::class, 'index'])->name('nasabah.dashboard');
    });

        Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';