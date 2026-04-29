<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Postingan;
use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $admin = User::where('is_admin', true)->first();
        // Ambil 10 postingan acak untuk dilaporkan
        $postinganDilaporkan = Postingan::inRandomOrder()->take(10)->get();

        foreach ($postinganDilaporkan as $post) {
            Laporan::factory()->create([
                'pelapor_id' => $users->random()->id,
                'postingan_id' => $post->id,
                // Secara acak menentukan apakah admin sudah menangani atau belum (null)
                'admin_id' => rand(0, 1) ? $admin->id : null, 
            ]);
        }
    }
}