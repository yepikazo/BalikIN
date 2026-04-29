<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Postingan;
use Illuminate\Database\Seeder;

class PostinganSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get(); // Hanya user biasa yang posting

        // Setiap user biasa akan membuat 2 sampai 4 postingan secara acak
        foreach ($users as $user) {
            Postingan::factory(rand(2, 4))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}