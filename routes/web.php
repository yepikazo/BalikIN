<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostinganController;
use Illuminate\Support\Facades\Route;

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

    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
});

use App\Http\Controllers\AdminController;

// Rute Khusus Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Laporan
    Route::get('/admin/laporan', [AdminController::class, 'daftarLaporan'])->name('admin.laporan');
    Route::put('/admin/laporan/{id}', [AdminController::class, 'updateStatusLaporan'])->name('admin.laporan.update');
    
    // Hapus postingan langsung lewat admin
    Route::delete('/admin/postingan/{id}', [AdminController::class, 'hapusPostinganFiktif'])->name('admin.postingan.destroy');
});

require __DIR__.'/auth.php'; // Bawaan Laravel Breeze
// --- OAuth ---
use App\Http\Controllers\OAuthController;
Route::get('/auth/google',          [OAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [OAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/github',          [OAuthController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [OAuthController::class, 'handleGithubCallback'])->name('auth.github.callback');

// --- Chat API (JSON) ---
use App\Http\Controllers\Api\ConversationController;
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/conversations',      [ConversationController::class, 'index']);
    Route::get('/messages/{userId}',  [ConversationController::class, 'messages']);
});
