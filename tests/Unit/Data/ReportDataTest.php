<?php

namespace Tests\Unit\Data;

use App\Data\ReportExportData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ReportDataTest extends TestCase
{
    public function test_report_data_valid_with_correct_values()
    {
        $exportData = ReportExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['slug']
        ]);

        $this->assertInstanceOf(ReportExportData::class, $exportData);
    }


    public function test_report_data_throws_invalid_fields_empty_array()
    {
        $this->expectException(ValidationException::class);

        ReportExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => []
        ]);
    }

    public function test_report_data_throws_invalid_on_invalid_field()
    {
        $this->expectException(ValidationException::class);

        ReportExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['not a field']
        ]);
    }
}
