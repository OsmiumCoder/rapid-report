<?php

namespace Database\Factories;

use App\Enum\IncidentStatus;
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
            'role' => fake()->numberBetween(0, 5),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'work_related' => fake()->boolean,
            'happened_at' => fake()->date(),
            'location' => fake()->address(),
            'incident_type' => 0,
            'descriptor' => 'Burn',
            'description' => fake()->text(),
            'status' => IncidentStatus::OPEN,
        ];
    }
}
