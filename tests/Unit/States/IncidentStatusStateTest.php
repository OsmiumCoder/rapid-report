<?php

namespace States;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class IncidentStatusStateTest extends TestCase
{
    public function test_incident_state_is_open_on_creation() {
        $incident = Incident::factory()->create();
        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_incident_open_state_to_assigned_state() {
        $incident = Incident::factory()->create();

        $incident->status->transitionTo(Assigned::class);

        $this->assertEquals(Assigned::class, $incident->status::class);
    }

    public function test_incident_reopen_state_to_assigned_state() {
        $incident = Incident::factory()->create([
                'status' => Reopened::class
            ]);

        $incident->status->transitionTo(Assigned::class);

        $this->assertEquals(Assigned::class, $incident->status::class);
    }

    public function test_closed_state_to_reopened_state() {
        $incident = Incident::factory()->create([
            'status' => Closed::class
        ]);
        $incident->status->transitionTo(Reopened::class);
        $this->assertEquals(Reopened::class, $incident->status::class);
    }


}
