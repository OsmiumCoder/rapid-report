<?php

namespace Database\Factories;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestigationFactory extends Factory
{
    public function definition()
    {
        return [
            'supervisor_id' => User::factory(),
            'incident_id' => Incident::factory(),
            'immediate_causes' => fake()->paragraph,
            'basic_causes' => fake()->paragraph,
            'remedial_actions' => fake()->paragraph,
            'prevention' => fake()->paragraph,
            'hazard_class' => fake()->randomLetter,
            'risk_rank' => fake()->numberBetween(1, 9),
            'resulted_in' => fake()->randomElements(['Injury', 'Illness', 'Property Damage', 'Near Miss', 'First aid', 'Medical aid', 'Recurrence'], rand(1, 7)),

            'substandard_acts' => fake()->randomElements([
                'Operating equipment without authority',
                'Failure to warn', 'Failure to secure',
                'Operating at improper speed',
                'Making safety devices inoperable',
                'Removing safety devices',
                'Using defective equipment',
                'Failure to use personal protective equipment (PPE)',
                'Improper loading',], rand(1, 7)),

            'substandard_conditions' => fake()->randomElements([
                'Fire and explosion hazard',
                'Lack of guard or barrier',
                'Inadequate or improper protective equipment',
                'Defective tools, equipment or materials',
                'Restricted space',
                'Inadequate warning system',
                'Poor housekeeping',
                'Hazardous environmental conditions (gases, dusts, fumes, vapours, etc.)',
                'Radiation exposure',
                'High or low temperature exposure',
                'Inadequate or excess illumination',
                'Inadequate ventilation',
            ], rand(1, 7)),

            'energy_transfer_causes' => fake()->randomElements([
                'Struck by (stationary or moving object)',
                'Struck against (ran or bumped into an object)',
                'Came into contact with (electricity, heat, cold, radiation, toxins, noise, caustics, etc.)',
                'Caught in or between (pinch or nip points, crushing or shearing)',
                'Caught on (snagged or hanging)',
                'Fall on the same level (slip, trip, or fall)',
                'Fall to lower level',
                'Exposure',
                'Overexertion',
                'Repetitive action',
            ], rand(1, 7)),

            'personal_factors' => fake()->randomElements([
                'Inadequate capacity',
                'Lack of knowledge/training',
                'Lack of skill',
                'Stress',
                'Improper motivation',
            ], rand(1, 7)),

            'job_factors' => fake()->randomElements([
                'Inadequate leadership/supervision',
                'Inadequate engineering',
                'Inadequate purchasing',
                'Inadequate maintenance',
                'Inadequate tools/equipment',
                'Inadequate work standards',
                'Wear and tear',
                'Abuse and/or misuse',
            ], rand(1, 7)),
        ];
    }
}
