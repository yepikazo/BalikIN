<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,      // Buat user & admin dulu
            PostinganSeeder::class, // Buat postingan yang dimiliki user
            CommentSeeder::class,   // Buat komentar pada postingan
            MessageSeeder::class,   // Buat obrolan pesan privat
            LaporanSeeder::class,   // Laporkan beberapa postingan fiktif
        ]);
    }
}