<?php

namespace Tests\Unit\Data;

use App\Data\RootCauseAnalysisData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RootCauseAnalysisDataTest extends TestCase
{
    public function test_rca_data_valid_with_nullable_arrays()
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
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                ]
            ],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $this->assertInstanceOf(RootCauseAnalysisData::class, $rcaData);
    }

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
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
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
                    "cause" => 0,
                    'control' => 0,
                    'remedial_action' => 0,
                    'by_who' => 0,
                    'by_when' => 0,
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
