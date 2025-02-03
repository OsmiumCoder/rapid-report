<?php

namespace Database\Factories;

use App\Models\Incident;
use App\Models\Investigation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestigationFactory extends Factory
{

    public function definition()
    {
        return [
            'incident_id' => Incident::factory(),
            'immediate_causes' => fake()->paragraph,
            'basic_causes' => fake()->paragraph,
            'remedial_actions' => fake()->paragraph,
            'prevention' => fake()->paragraph,
            'hazard_class' => fake()->randomLetter,
            'risk_rank' => fake()->numberBetween(1, 9),
            'resulted_in' => [],
        ];
    }
}
