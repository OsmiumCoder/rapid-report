<?php

namespace Database\Factories;

use App\Enum\CommentType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => CommentType::NOTE,
            'content' => fake()->paragraph(2),
        ];
    }
}
