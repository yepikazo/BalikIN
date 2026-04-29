<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Postingan;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $postingans = Postingan::all();

        foreach ($postingans as $post) {
            // 1. Buat 2-5 Komentar Utama (Parent null) di tiap postingan
            $mainComments = Comment::factory(rand(2, 5))->create([
                'postingan_id' => $post->id,
                'user_id' => $users->random()->id,
                'parent_id' => null,
            ]);

            // 2. Buat Balasan Komentar (Nested Comments)
            foreach ($mainComments as $mainComment) {
                // 50% kemungkinan komentar utama ini akan dibalas
                if (rand(1, 100) > 50) { 
                    Comment::factory(rand(1, 3))->create([
                        'postingan_id' => $post->id,
                        'user_id' => $users->random()->id,
                        'parent_id' => $mainComment->id, // Mengatur Parent ID
                    ]);
                }
            }
        }
    }
}