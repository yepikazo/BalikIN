<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        fake()->locale('id_ID');
        return [
            'content' => fake()->sentence(rand(4, 10)),
        ];
    }
}