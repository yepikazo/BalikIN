<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostinganController;
use Illuminate\Support\Facades\Route;

// ===========================
// RUTE PUBLIK
// ===========================
Route::get('/', [PostinganController::class, 'index'])->name('beranda');
Route::get('/postingan/{id}', [PostinganController::class, 'show'])->name('postingan.show');


// ===========================
// RUTE AUTH (User Biasa & Pelapor)
// ===========================
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

    // --- Laporan ---
    Route::get('/laporan-saya', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');

    // --- Postingan Saya ---
    Route::get('/postingan-saya', [PostinganController::class, 'myPosts'])->name('postingan.saya');

    // --- Pesan (Chat Pribadi) ---
    Route::get('/pesan', [MessageController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{userId}', [MessageController::class, 'show'])->name('pesan.show');
    Route::post('/pesan', [MessageController::class, 'store'])->name('messages.store');
    Route::put('/pesan/{id}', [MessageController::class, 'update'])->name('pesan.update');
    Route::delete('/pesan/{id}', [MessageController::class, 'destroy'])->name('pesan.destroy');
});


// ===========================
// RUTE KHUSUS ADMIN
// ===========================
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Kelola Postingan
    Route::get('/postingan', [AdminController::class, 'daftarPostingan'])->name('postingan.index');
    Route::post('/postingan', [PostinganController::class, 'store'])->name('postingan.store');
    Route::put('/postingan/{id}/tipe', [AdminController::class, 'updateTipePostingan'])->name('postingan.updateTipe');

    // Kelola Laporan
    Route::get('/laporan', [AdminController::class, 'daftarLaporan'])->name('laporan');
    Route::put('/laporan/{id}', [AdminController::class, 'updateStatusLaporan'])->name('laporan.update');

    // Legacy: direct suspend dari halaman laporan
    Route::put('/postingan-fiktif/{id}', [AdminController::class, 'updatePostinganFiktif'])->name('postingan.update');
});


// ===========================
// AUTH (Breeze)
// ===========================
require __DIR__ . '/auth.php';


// ===========================
// OAUTH (Google & GitHub)
// ===========================
use App\Http\Controllers\OAuthController;

Route::get('/auth/google',          [OAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [OAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// ===========================
// API (JSON — untuk Chat Panel Floating)
// ===========================
use App\Http\Controllers\Api\ConversationController;

Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/conversations',     [ConversationController::class, 'index']);
    Route::get('/messages/{userId}', [ConversationController::class, 'messages']);
});
