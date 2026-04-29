<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            
            // Pelapor merujuk ke tabel users
            $table->foreignId('pelapor_id')->constrained('users')->cascadeOnDelete();
            
            // Postingan merujuk ke tabel postingan
            $table->foreignId('postingan_id')->constrained('postingan')->cascadeOnDelete();
            
            // Admin yang menangani merujuk ke tabel users (bisa null jika belum ditangani)
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->text('alasan');
            $table->date('tanggal_laporan');
            $table->enum('status_laporan', ['pending', 'diproses', 'selesai'])->default('pending');
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
