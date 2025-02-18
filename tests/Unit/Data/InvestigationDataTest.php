<?php

namespace Tests\Unit\Data;

use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Data\InvestigationData;

class InvestigationDataTest extends TestCase
{
    public function test_investigation_data_valid_with_nullable_arrays()
    {
        $investigationData = InvestigationData::validateAndCreate([
            'immediate_causes' => 'Slippery floor',
            'basic_causes' => 'Lack of warning signs',
            'remedial_actions' => 'Install warning signs and non-slip mats',
            'prevention' => 'Regular inspections and staff training',
            'hazard_class' => 'Safety',
            'risk_rank' => 3,
            'resulted_in' => ['Injury', 'Property Damage'],
        ]);

        $this->assertInstanceOf(InvestigationData::class, $investigationData);
    }

    public function test_investigation_data_valid_with_correct_values()
    {
        $investigationData = InvestigationData::validateAndCreate([
            'immediate_causes' => 'Slippery floor',
            'basic_causes' => 'Lack of warning signs',
            'remedial_actions' => 'Install warning signs and non-slip mats',
            'prevention' => 'Regular inspections and staff training',
            'hazard_class' => 'Safety',
            'risk_rank' => 3,
            'resulted_in' => ['Injury', 'Property Damage'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
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
            'resulted_in' => 'Injury',
            'substandard_acts' => 'injury',
            'substandard_conditions' => 'injury',
            'energy_transfer_causes' => 'injury',
            'personal_factors' => 'injury',
            'job_factors' => 'injury',
        ]);
    }
}
