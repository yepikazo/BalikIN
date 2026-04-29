<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanFactory extends Factory
{
    public function definition(): array
    {
        fake()->locale('id_ID');
        return [
            'alasan' => fake()->randomElement(['Postingan palsu / Spam', 'Barang bukan milik pelapor', 'Konten tidak pantas', 'Penipuan hadiah']),
            'tanggal_laporan' => fake()->dateTimeBetween('-1 weeks', 'now'),
            'status_laporan' => fake()->randomElement(['pending', 'diproses', 'selesai']),
        ];
    }
}