<?php

namespace States;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Opened;
use Tests\TestCase;

class IncidentStatusStateTest extends TestCase
{
    public function testIncidentStateIsOpenOnCreations() {
        $incident = Incident::factory()->create();

        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function testOpenStatusToAssignedStatusAssignsSupervisor() {
        $incident = Incident::factory()->create();

        $supervisor = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $incident->status->transitionTo(Assigned::class, $supervisor->id);

        $this->assertEquals($supervisor->id, $incident->supervisor_id);

    }
}
