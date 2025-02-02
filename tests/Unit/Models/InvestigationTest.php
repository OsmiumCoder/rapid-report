<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use Tests\TestCase;

class InvestigationTest extends TestCase
{

    public function test_can_create_an_investigation()
    {
        $investigation = Investigation::factory()->create([
            'title' => 'Test Investigation',
            'description' => 'Test Description',
        ]);

        $this->assertDatabaseHas('investigations', [
            'title' => 'Test Investigation',
            'description' => 'Test Description',
        ]);
    }
}
