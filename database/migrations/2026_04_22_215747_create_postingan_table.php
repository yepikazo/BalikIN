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
        Schema::create('postingan', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->enum('tipe', ['hilang', 'ditemukan']);
            $table->string('nama_barang');
            $table->string('kategori');
            $table->string('lokasi');
            $table->dateTime('waktu_kejadian');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postingan');
    }
};
