<?php

namespace Tests\Unit\Data;

use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Data\InvestigationData;

class InvestigationDataTest extends TestCase
{
    public function test_investigation_data_valid_with_correct_values()
    {
        $data = [
            'immediate_causes' => 'Slippery floor',
            'basic_causes' => 'Lack of warning signs',
            'remedial_actions' => 'Install warning signs and non-slip mats',
            'prevention' => 'Regular inspections and staff training',
            'hazard_class' => 'Safety',
            'risk_rank' => 3,
            'resulted_in' => ['Injury', 'Property Damage']
        ];

        $investigationData = new InvestigationData(...$data);

        $this->assertEquals($data['immediate_causes'], $investigationData->immediate_causes);
        $this->assertEquals($data['basic_causes'], $investigationData->basic_causes);
        $this->assertEquals($data['remedial_actions'], $investigationData->remedial_actions);
        $this->assertEquals($data['prevention'], $investigationData->prevention);
        $this->assertEquals($data['hazard_class'], $investigationData->hazard_class);
        $this->assertEquals($data['risk_rank'], $investigationData->risk_rank);
        $this->assertEquals($data['resulted_in'], $investigationData->resulted_in);
    }


    public function test_investigation_data_throws_invalid_with_bad_data()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'immediate_causes' => '',  // ❌ Empty string, should be invalid
            'basic_causes' => null,  // ❌ Null value
            'remedial_actions' => 12345,  // ❌ Wrong type (int instead of string)
            'prevention' => [],  // ❌ Wrong type (array instead of string)
            'hazard_class' => '',  // ❌ Empty string, should be invalid
            'risk_rank' => 'High',  // ❌ Wrong type (string instead of int)
            'resulted_in' => 'Injury'  // ❌ Wrong type (should be array)
        ];

        new InvestigationData(...$data);
    }
}
