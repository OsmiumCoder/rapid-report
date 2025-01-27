<?php

namespace States;

use App\Models\Incident;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use Tests\TestCase;

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

    public function test_assigned_state_to_in_review_state() {
        $incident = Incident::factory()->create([
            'status' => Assigned::class
        ]);
        $incident->status->transitionTo(InReview::class);
        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_in_review_state_to_closed_state() {
        $incident = Incident::factory()->create([
            'status' => InReview::class
        ]);
        $incident->status->transitionTo(Closed::class);
        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_in_review_state_to_opened_state() {
        $incident = Incident::factory()->create([
            'status' => InReview::class
        ]);
        $incident->status->transitionTo(Opened::class);
        $this->assertEquals(Opened::class, $incident->status::class);
    }
}
