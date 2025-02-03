<?php

namespace Tests\Unit\Data;

use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Data\InvestigationData;

class InvestigationDataTest extends TestCase
{
    public function test_investigation_data_valid_with_correct_values()
    {
    }

    public function test_investigation_data_throws_invalid_with_bad_data()
    {
        $this->expectException(ValidationException::class);
    }
}
