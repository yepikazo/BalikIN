<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 1 Akun Admin Fiks (Untuk Anda Login)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@balik.in',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        // 2. Buat 1 Akun Pelapor/User Biasa Fiks (Untuk Anda Tes Login)
        User::create([
            'name' => 'Pelapor Aktif',
            'email' => 'user@balik.in',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        // 3. Buat 10 User Dummy (Pelapor Acak)
        User::factory(10)->create(['is_admin' => false]);
    }
}