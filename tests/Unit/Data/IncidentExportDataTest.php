<?php

namespace Tests\Unit\Data;

use App\Data\IncidentExportData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class IncidentExportDataTest extends TestCase
{
    public function test_report_data_valid_with_correct_values()
    {
        $exportData = IncidentExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['ID']
        ]);

        $this->assertInstanceOf(IncidentExportData::class, $exportData);
    }


    public function test_report_data_throws_invalid_fields_empty_array()
    {
        $this->expectException(ValidationException::class);

        IncidentExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => []
        ]);
    }

    public function test_report_data_throws_invalid_on_invalid_field()
    {
        $this->expectException(ValidationException::class);

        IncidentExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['not a field']
        ]);
    }
}
