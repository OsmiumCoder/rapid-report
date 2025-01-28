<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\User;
use Tests\TestCase;

class IncidentModelTest extends TestCase
{
    public function test_incident_with_assigned_supervisor_returns_supervisor_user()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_creates_an_incident_model_with_valid_attributes()
    {
        $incident = Incident::factory()->create();

        $this->assertFalse($incident->anonymous);
        $this->assertFalse($incident->on_behalf);
        $this->assertFalse($incident->on_behalf_anonymous);

        $this->assertNotNull($incident->role);
        $this->assertNotNull($incident->last_name);
        $this->assertNotNull($incident->first_name);
        $this->assertNotNull($incident->email);
        $this->assertNotNull($incident->phone);
        $this->assertNotNull($incident->work_related);
        $this->assertNotNull($incident->happened_at);
        $this->assertNotNull($incident->location);
        $this->assertNotNull($incident->incident_type);
        $this->assertNotNull($incident->descriptor);
        $this->assertNotNull($incident->description);
        $this->assertNotNull($incident->status);

        $this->assertNotNull($incident->room_number);
        $this->assertNotNull($incident->witnesses);
        $this->assertNotNull($incident->injury_description);
        $this->assertNotNull($incident->first_aid_description);
        $this->assertNull($incident->reporters_email);
        $this->assertNull($incident->supervisor_name);
        $this->assertNull($incident->closed_at);
    }
}
