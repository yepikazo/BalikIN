<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        fake()->locale('id_ID');
        return [
            'body' => fake()->sentence(rand(3, 8)),
            'is_read' => fake()->boolean(70), // 70% kemungkinan sudah dibaca
        ];
    }
}