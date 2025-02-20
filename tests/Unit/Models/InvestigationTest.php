<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use Tests\TestCase;

class InvestigationTest extends TestCase
{
    public function test_investigation_belongs_to_supervisor_relation()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $investigation = Investigation::factory()->create(['supervisor_id' => $supervisor->id]);

        $this->assertEquals($supervisor->id, $investigation->supervisor->id);
    }

    public function test_investigation_belongs_to_incident_relation()
    {
        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $this->assertEquals($incident->id, $investigation->incident->id);
    }

    public function test_creates_an_investigation_model_with_valid_attributes()
    {
        $investigation = Investigation::factory()->create();

        $this->assertNotNull($investigation->incident_id);
        $this->assertNotNull($investigation->immediate_causes);
        $this->assertNotNull($investigation->basic_causes);
        $this->assertNotNull($investigation->remedial_actions);
        $this->assertNotNull($investigation->prevention);
        $this->assertNotNull($investigation->hazard_class);
        $this->assertNotNull($investigation->risk_rank);
        $this->assertNotNull($investigation->resulted_in);
        $this->assertNotNull($investigation->substandard_acts);
        $this->assertNotNull($investigation->substandard_conditions);
        $this->assertNotNull($investigation->energy_transfer_causes);
        $this->assertNotNull($investigation->personal_factors);
        $this->assertNotNull($investigation->job_factors);
    }
}
