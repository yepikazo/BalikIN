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
            $table->foreignId('id_pelapor')->constrained(
                table: 'users',
                indexName: 'postingan_id_pelapor'
            );
            $table->string('namaBarang');
            $table->string('kategori');
            $table->string('lokasi');
            $table->string('deskripsi');
            $table->string('foto');
            $table->string('namaKontak');
            $table->string('noKontak');
            $table->enum('status',['dibuat','diamankan','selesai'])->default('dibuat');
            $table->enum('jenis',['barangHilang','barangDitemukan'])->default('barangHilang');
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
