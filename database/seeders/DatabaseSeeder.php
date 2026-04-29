<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Admin default ────────────────────────────────────────────────
        User::create([
            'name'              => 'Admin Balik.in',
            'email'             => 'admin@balik.in',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        // ── Pelapor contoh ───────────────────────────────────────────────
        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'budi@example.com',
            'password'          => Hash::make('password'),
            'role'              => 'pelapor',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Siti Rahma',
            'email'             => 'siti@example.com',
            'password'          => Hash::make('password'),
            'role'              => 'pelapor',
            'email_verified_at' => now(),
        ]);
    }
}
