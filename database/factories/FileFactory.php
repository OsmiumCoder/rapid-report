<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->uuid() . fake()->fileExtension(),
            'original_name' => fake()->name() . fake()->fileExtension(),
            'path' => fake()->filePath(),
            'size' => fake()->numberBetween(200, 600),
            'mime_type' => fake()->mimeType(),
            'extension' => fake()->fileExtension(),
        ];
    }
}
