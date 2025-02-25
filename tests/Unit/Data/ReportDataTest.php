<?php

namespace Tests\Unit\Data;

use App\Data\ReportExportData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ReportDataTest extends TestCase
{
    public function test_investigation_data_valid_with_correct_values()
    {
        $exportData = ReportExportData::validateAndCreate([
            'start' => now()->toString(),
            'end' => now()->toString(),
            'happened_at' => false,
            'work_related' => false,
            'personal_individual_information' => false,
            'workers_comp_submitted' => false,
            'location' => false,
            'room_number' => false,
            'incident_type' => false,
            'descriptor' => false,
            'description' => false,
            'injury_description' => false,
            'first_aid_description' => false,
            'closed_at' => false,
            'created_at' => false,
            'updated_at' => false,
        ]);

        $this->assertInstanceOf(ReportExportData::class, $exportData);
    }


    public function test_investigation_data_throws_invalid_with_bad_data()
    {
        $this->expectException(ValidationException::class);

        $exportData = ReportExportData::validateAndCreate([
            'start' => now()->toString(),
            'end' => now()->toString(),
            'happened_at' => 'false',
            'work_related' => 1,
            'personal_individual_information' => 'false',
            'workers_comp_submitted' => 'false',
            'location' => 2.3,
            'room_number' => 'false',
            'incident_type' => 0,
            'descriptor' => 45,
            'description' => 'false',
            'injury_description' => 'false',
            'first_aid_description' => 'false',
            'closed_at' => 'false',
            'created_at' => 'false',
            'updated_at' => 'false',
        ]);
    }
}
