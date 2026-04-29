<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();

        // Buat 30 pesan acak antar user biasa
        for ($i = 0; $i < 30; $i++) {
            $sender = $users->random();
            $receiver = $users->except($sender->id)->random(); // Pastikan tidak kirim ke diri sendiri

            Message::factory()->create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
            ]);
        }
    }
}