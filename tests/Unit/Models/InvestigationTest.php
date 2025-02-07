<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use Tests\TestCase;

class InvestigationTest extends TestCase
{
    public function test_investigation_belongs_to_incident_relation()
    {
        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);
        $this->assertEquals($incident->id, $investigation->incident->id);

    }

    public function test_creates_an_investigation_model_with_valid_attributes()
    {
        $investigation = Investigation::factory()->create([
            'title' => 'New Investigation',
            'description' => 'This is a test investigation',
            'incident_id' => 1,
            'status' => 'open'
        ]);

        $this->assertDatabaseHas('investigations', [
            'title' => 'New Investigation',
            'description' => 'This is a test investigation',
            'incident_id' => 1,
            'status' => 'open'
        ]);
    }
}
