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
        }
        $peoplesPositions = [
            'Alignment',
            'Line of fire',
            'Overreaching',
            'Over exertion',
            'Repetition',
        ];

        $attentionToWork = [
            'Awareness of surroundings',
            'Eyes on task',
            'Mind on task',
            'Pace',
            'Work plan design',
        ];

        $communication = [
            'JHA',
            'Plan',
            'Recognize change',
            'Task coordination',
            'Tools/equipment put away',
        ];

        $workingConditions = [
            'Ambient conditions',
            'Clean/clear of clutter',
            'Footing',
            'Guards & barriers',
        ];

        $rootCauses = [
            'Poor/inadequate/improper planning',
            'No SOP/SWP/JHA',
            'SOP/SWP/JHA did not identify hazard',
            'Not following SOP/SWP/JHA',
            'Deviated from SOP/SWP/JHA',
            'Failure to identify change',
            'No pre-inspection',
            'Inadequate/no permit, permit not followed',
            'Manufacturer recommendations not followed',
            'Operation of equipment without authority',
            'Improper position of posture for task',
            'Overexertion/Overreaching of physical capability',
            'Improperlifting',
            'Improper Loading',
            'Shortcutting/rushing – correct way takes more time/effort',
            'Improper use of equipment, tools, devices',
            'Modifying or altering tools/equipment improperly',
            'Use of defective equipment',
            'Use of defective tools',
            'Electrical issue with tool or equipment',
            'Improper placement of tools, equipment, or materials',
            'Operation of equipment at improper speed Servicing of equipment in operation',
            'Inadequate equipment',
            'Improperly prepared equipment/tools/vehicles',
            'Inadequate tools',
            'Not performing an adequate inspection',
            'Dropped tool/object',
            'Defective vehicle',
            'Inadequate vehicle for the purpose',
            'Wrong selection of equipment',
            'Wrong selection of tool(s)',
            'No training/non-designated/not qualified',
            'Improper/inadequate training',
            'Improper decision making or lack of judgement',
            'Distracted by other concerns',
            'Inattention to footing and surroundings',
            'Inattention to body/hand position (crush point)',
            'Inattention to body position (line of fire)',
            'Inattention to stored energy / Horseplay',
            'Acts of violenceFailure to warn',
            'Use of drugs or alcohol',
            'Routine activity without thought',
            'Physical capability (fatigue, vision, hearing, disability)',
            'Improper assignment of personnel',
            'Inadequate communication',
            'Lack of knowledge of hazards present',
            'PPE not used',
            'Improper use of PPE',
            'Servicing of energized equipment',
            'Equipment or materials not secured',
            'Disabled guards, warning systems or safety devices',
            'PPE not available',
            'Inadequate guards or protective devices (barricades)',
            'Defective guards or protective devices',
            'Inadequate PPE',
            'Defective PPE',
            'Inadequate warning system',
            'Defective warning system',
            'Inadequate isolation of process or equipment',
            'Inadequate safety devices',
            'Defective safety devices',
            'Fire or explosion',
            'Noise',
            'Energized electrical systems',
            'Energized systems other than electrical',
            'No utility locate',
            'Radiation',
            'Temperature extremes',
            'High winds',
            'Hazardous chemicals',
            'Mechanical hazards',
            'Storms or acts of nature',
            'Congestion or restricted motion (arrangement/placement)',
            'Inadequate or excessive illumination',
            'Inadequate ventilation',
            'Unprotected height',
            'Inadequate workplace layout',
            'Inadequate access/egress',
            'Inadequate walkways',
            'Inadequate housekeeping',
            'Uneven ground',
            'Wet or slippery surfaces',
            'Tripping hazard',
        ];
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
