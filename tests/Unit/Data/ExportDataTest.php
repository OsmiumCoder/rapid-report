<?php

namespace Tests\Unit\Data;

use App\Data\ExportData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ExportDataTest extends TestCase
{
    public function test_report_data_valid_with_correct_values()
    {
        $exportData = ExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['slug']
        ]);

        $this->assertInstanceOf(ExportData::class, $exportData);
    }


    public function test_report_data_throws_invalid_fields_empty_array()
    {
        $this->expectException(ValidationException::class);

        ExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => []
        ]);
    }

    public function test_report_data_throws_invalid_on_invalid_field()
    {
        $this->expectException(ValidationException::class);

        ExportData::validateAndCreate([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['not a field']
        ]);
    }
}
