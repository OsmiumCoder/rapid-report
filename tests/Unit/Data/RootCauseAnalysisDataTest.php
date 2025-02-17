<?php

namespace Data;

use App\Data\RootCauseAnalysisData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RootCauseAnalysisDataTest extends TestCase
{
    public function test_rca_data_valid_with_correct_values()
    {
        $rcaData = RootCauseAnalysisData::validateAndCreate([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $this->assertInstanceOf(RootCauseAnalysisData::class, $rcaData);
    }


    public function test_rca_data_throws_invalid_with_bad_data()
    {
        $this->expectException(ValidationException::class);

        RootCauseAnalysisData::validateAndCreate([
            'individuals_involved' => '',
            'primary_effect' => '',
            'whys' => '',
            'solutions_and_actions' => '',
            'peoples_positions' => '',
            'attention_to_work' => '',
            'communication' => '',
            'ppe_in_good_condition' => '',
            'ppe_in_use' => '',
            'ppe_correct_type' => '',
            'correct_tool_used' => '',
            'policies_followed' => '',
            'worked_safely' => '',
            'used_tool_properly' => '',
            'tool_in_good_condition' => '',
            'working_conditions' => '',
            'root_causes' => '',
        ]);
    }

    public function test_rca_data_throws_invalid_for_solutions_and_actions()
    {
        $this->expectException(ValidationException::class);

        RootCauseAnalysisData::validateAndCreate([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => '',
                    'control' => '',
                    'remedial_action' => '',
                    'by_who' => '',
                    'by_when' => '',
                    'manager' => '',
                ],
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);
    }
}
