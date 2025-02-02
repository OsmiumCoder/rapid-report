<?php

namespace Tests\Unit\Data;

use Tests\TestCase;
use App\Data\InvestigationData;

class InvestigationDataTest extends TestCase
{
    public function test_correctly_assigns_data()
    {
        $data = new InvestigationData([
            'title' => 'Test Title',
            'description' => 'Test Description',
        ]);

        $this->assertEquals('Test Title', $data->title);
        $this->assertEquals('Test Description', $data->description);
    }
}
