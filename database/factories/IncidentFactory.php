<?php

namespace Database\Factories;

use App\Enum\IncidentType;
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
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => fake()->numberBetween(1, 4),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'upei_id' => fake()->numberBetween(99999, 9999999),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'work_related' => fake()->boolean,
            'workers_comp_submitted' => false,
            'happened_at' => fake()->date(),
            'location' => fake()->address(),
            'room_number' => fake()->buildingNumber(),
            'witnesses' => fake()-> randomElements([
                0 => [
                    'name' => fake()->name(),
                    'email' => '',
                    'phone' => fake()->phoneNumber(),
                ],
                1 => [
                    'name' => fake()->name(),
                    'email' => fake()->email(),
                    'phone' => '',
                ],
                3 => [
                    'name' => fake()->name(),
                    'email' => '',
                    'phone' => fake()->phoneNumber(),
                ]
            ],fake()->numberBetween(0,3)),
            'incident_type' => fake()->randomElement(IncidentType::cases()),
            'descriptor' => fake()->randomElement(['Burn','Slip','Stab','Murder']),
            'description' => fake()->text(),
            'injury_description' => fake()->text(),
            'first_aid_description' => fake()->text(),
        ];
    }
}
