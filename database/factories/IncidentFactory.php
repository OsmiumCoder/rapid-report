<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'work_related' => fake()->boolean(),
            'incident_date' => fake()->date(),
            'location' => fake()->address(),
            'incident_type' => fake()->word(),
            'descriptor' => 'Slip',
            'description' => fake()->text(),
            'has_injury' => fake()->boolean(),
            'status' => 0,
        ];
    }
}
