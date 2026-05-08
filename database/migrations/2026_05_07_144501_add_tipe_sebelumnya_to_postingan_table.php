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
        Schema::table('postingan', function (Blueprint $table) {
            // Menyimpan tipe asli (hilang/ditemukan/diamankan) sebelum postingan di-suspend
            $table->string('tipe_sebelumnya')->nullable()->after('tipe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postingan', function (Blueprint $table) {
            $table->dropColumn('tipe_sebelumnya');
        });
    }
};
