<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostinganFactory extends Factory
{
    public function definition(): array
    {
        // Menggunakan bahasa Indonesia untuk faker
        fake()->locale('id_ID');

        return [
            'user_id' => User::factory(), // Default jika tidak diset di seeder
            'tipe' => fake()->randomElement(['hilang', 'ditemukan']),
            'nama_barang' => fake()->randomElement(['Dompet Hitam', 'Kunci Motor Honda', 'HP iPhone 12', 'KTM Mahasiswa', 'Laptop Asus', 'Botol Minum Tupperware']),
            'kategori' => fake()->randomElement(['Elektronik', 'Dokumen/Kartu', 'Aksesoris', 'Lainnya']),
            'lokasi' => fake()->streetAddress() . ', ' . fake()->city(),
            'waktu_kejadian' => fake()->dateTimeBetween('-2 months', 'now'),
            'deskripsi' => fake()->paragraph(3),
            'foto' => null, // Kosongkan foto dummy sementara
            'status' => fake()->randomElement(['aktif', 'aktif', 'selesai']), // Rasio aktif lebih banyak
        ];
    }
}