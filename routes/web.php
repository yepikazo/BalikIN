<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostinganController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;

Route::get('/', [PostinganController::class, 'index'])->name('beranda');
Route::get('/postingan/{id}', [PostinganController::class, 'show'])->name('postingan.show');

// Rute yang membutuhkan Login (User Biasa & Pelapor)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- CRUD Postingan ---
    Route::get('/postingan-buat', [PostinganController::class, 'create'])->name('postingan.create');
    Route::post('/postingan', [PostinganController::class, 'store'])->name('postingan.store');
    Route::get('/postingan/{id}/edit', [PostinganController::class, 'edit'])->name('postingan.edit');
    Route::put('/postingan/{id}', [PostinganController::class, 'update'])->name('postingan.update');
    Route::delete('/postingan/{id}', [PostinganController::class, 'destroy'])->name('postingan.destroy');

    // --- Komentar ---
    Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // --- Pesan (Hubungi Pihak) ---
    Route::get('/pesan', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/pesan', [MessageController::class, 'store'])->name('messages.store');
});

// Rute Khusus Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Belum kita buat view-nya
    })->name('admin.dashboard');
    
    // Nanti rute untuk mengelola Laporan Fiktif diletakkan di sini
});

require __DIR__.'/auth.php'; // Bawaan Laravel Breeze