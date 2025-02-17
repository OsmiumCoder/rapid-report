<?php

namespace Database\Factories;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RootCauseAnalysis>
 */
class RootCauseAnalysisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $individualsInvolved = [];
        $solutionsAndActions = [];
        $peoplesPositions = [];
        $attentionToWork = [];
        $communication = [];
        $workingConditions = [];
        $rootCauses = [];


        for ($i = 0; $i < 10; $i++) {
            $individualsInvolved[] = [
                'name' => fake()->name,
                'email' => fake()->email,
                'phone' => fake()->phoneNumber
            ];
            $solutionsAndActions[] = [
                'cause' => fake()->paragraph,
                'control' => fake()->paragraph,
                'remedial_actions' => fake()->paragraph,
                'by_who' => fake()->name,
                'by_when' => fake()->date,
                'manager' => fake()->name,
            ];
            $peoplesPositions[] = fake()->word;
            $attentionToWork[] = fake()->word;
            $communication[] = fake()->word;
            $workingConditions[] = fake()->word;
            $rootCauses[] = fake()->word;
        }

        return [
            'supervisor_id' => User::factory(),
            'incident_id' => Incident::factory(),
            'individuals_involved' => fake()->randomElements($individualsInvolved, 3),
            'primary_effect' => fake()->paragraph,
            'whys' => fake()->randomElements(['why 1', 'why 2', 'why 3', 'why 4', 'why 5'], 3),
            'solutions_and_actions' => fake()->randomElements($solutionsAndActions, 3),
            'peoples_positions' => fake()->randomElements($peoplesPositions, 3),
            'attention_to_work' => fake()->randomElements($attentionToWork, 3),
            'communication' => fake()->randomElements($communication, 3),
            'ppe_in_good_condition' => fake()->boolean,
            'ppe_in_use' => fake()->boolean,
            'ppe_correct_type' => fake()->boolean,
            'correct_tool_used' => fake()->boolean,
            'policies_followed' => fake()->boolean,
            'worked_safely' => fake()->boolean,
            'used_tool_properly' => fake()->boolean,
            'tool_in_good_condition' => fake()->boolean,
            'working_conditions' => fake()->randomElements($workingConditions, 3),
            'root_causes' => fake()->randomElements($rootCauses, 3),
        ];
    }
}
