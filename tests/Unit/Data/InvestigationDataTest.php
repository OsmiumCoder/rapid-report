<?php

namespace Tests\Unit\Data;

use App\Models\Incident;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Data\InvestigationData;

class InvestigationDataTest extends TestCase
{
    public function test_investigation_data_valid_with_correct_values()
    {
        $investigationData = InvestigationData::validateAndCreate([
            'immediate_causes' => 'Slippery floor',
            'basic_causes' => 'Lack of warning signs',
            'remedial_actions' => 'Install warning signs and non-slip mats',
            'prevention' => 'Regular inspections and staff training',
            'hazard_class' => 'Safety',
            'risk_rank' => 3,
            'resulted_in' => ['Injury', 'Property Damage']
        ]);

        $this->assertInstanceOf(InvestigationData::class, $investigationData);
    }


    public function test_investigation_data_throws_invalid_with_bad_data()
    {
        $this->expectException(ValidationException::class);

        InvestigationData::validateAndCreate([
            'immediate_causes' => '',
            'basic_causes' => '',
            'remedial_actions' => '',
            'prevention' => [],
            'hazard_class' => '',
            'risk_rank' => 'High',
            'resulted_in' => 'Injury'
        ]);
    }
}
