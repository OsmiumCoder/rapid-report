<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use Tests\TestCase;

class IncidentModelTest extends TestCase
{
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

        $this->assertNull($incident->room_number);
        $this->assertNull($incident->witnesses);
        $this->assertNull($incident->injury_description);
        $this->assertNull($incident->first_aid_description);
        $this->assertNull($incident->reporters_email);
        $this->assertNull($incident->supervisor_name);
        $this->assertNull($incident->closed_at);
    }
}
