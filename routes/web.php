<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PostinganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Halaman publik: redirect ke feed jika sudah login ────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('postingan.index');
    }
    return view('welcome');
});

// ── Authenticated routes ──────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // ── Pelapor: Feed & Postingan ─────────────────────────────────────────
    Route::resource('postingan', PostinganController::class);

    // ── Laporan Postingan Fiktif ──────────────────────────────────────────
    Route::post('laporan', [LaporanController::class, 'store'])->name('laporan.store');

    // ── Profile ───────────────────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Admin routes (middleware IsAdmin) ─────────────────────────────────
    Route::middleware('is_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola postingan (admin)
        Route::delete('postingan/{postingan}', [AdminController::class, 'destroyPostingan'])
             ->name('postingan.destroy');
        Route::patch('postingan/{postingan}/status', [AdminController::class, 'updateStatusPostingan'])
             ->name('postingan.status');

        // Kelola laporan (admin)
        Route::delete('laporan/{laporan}', [AdminController::class, 'destroyLaporan'])
             ->name('laporan.destroy');
    });
});

require __DIR__.'/auth.php';
