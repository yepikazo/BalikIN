<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Referensi postingan yang jadi konteks percakapan
            $table->unsignedBigInteger('postingan_id')->nullable()->after('is_read');
            $table->foreign('postingan_id')->references('id')->on('postingan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['postingan_id']);
            $table->dropColumn('postingan_id');
        });
    }
};
