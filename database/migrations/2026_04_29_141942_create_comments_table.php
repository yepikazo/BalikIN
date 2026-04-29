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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel postingan (custom name) dan users
            $table->foreignId('postingan_id')->constrained('postingan')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Relasi ke tabel comments itu sendiri untuk balas komentar (nested / parent)
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
