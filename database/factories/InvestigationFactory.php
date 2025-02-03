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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}
