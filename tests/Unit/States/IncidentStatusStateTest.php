<?php

namespace States;

use App\Models\Incident;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class IncidentStatusStateTest extends TestCase
{
    public function test_incident_returned_to_reopened_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Returned::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Reopened::class);
    }

    public function test_incident_returned_to_assigned_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Returned::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Assigned::class);
    }

    public function test_incident_returned_to_opened_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Returned::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Opened::class);
    }

    public function test_incident_returned_to_closed_state()
    {
        $incident = Incident::factory()->create([
            'status' => Returned::class,
        ]);
        $incident->status->transitionTo(Closed::class);
        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_incident_returned_to_in_review_state()
    {
        $incident = Incident::factory()->create([
            'status' => Returned::class,
        ]);
        $incident->status->transitionTo(InReview::class);
        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_incident_in_review_to_returned_state()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);
        $incident->status->transitionTo(Returned::class);
        $this->assertEquals(Returned::class, $incident->status::class);
    }

    public function test_incident_in_open_to_closed_state()
    {
        $incident = Incident::factory()->create();
        $incident->status->transitionTo(Closed::class);
        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_incident_assigned_to_closed_state()
    {
        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);
        $incident->status->transitionTo(Closed::class);
        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_incident_state_is_opened_on_creation()
    {
        $incident = Incident::factory()->create();
        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_incident_opened_to_assigned_state()
    {
        $incident = Incident::factory()->create();

        $incident->status->transitionTo(Assigned::class);

        $this->assertEquals(Assigned::class, $incident->status::class);
    }

    public function test_incident_assigned_to_opened_state()
    {
        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);
        $incident->status->transitionTo(Opened::class);

        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_incident_assigned_to_in_review_state()
    {
        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $incident->status->transitionTo(InReview::class);
        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_incident_assigned_to_assigned_state()
    {
        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);
        $incident->status->transitionTo(Assigned::class);

        $this->assertEquals(Assigned::class, $incident->status::class);
    }

    public function test_incident_in_review_to_assigned_state()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Assigned::class);
    }

    public function test_incident_in_review_to_closed_state()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);
        $incident->status->transitionTo(Closed::class);
        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_incident_closed_to_reopened_state()
    {
        $incident = Incident::factory()->create([
            'status' => Closed::class,
        ]);
        $incident->status->transitionTo(Reopened::class);
        $this->assertEquals(Reopened::class, $incident->status::class);
    }

    public function test_incident_reopen_to_assigned_state()
    {
        $incident = Incident::factory()->create([
            'status' => Reopened::class,
        ]);

        $incident->status->transitionTo(Assigned::class);

        $this->assertEquals(Assigned::class, $incident->status::class);
    }

    public function test_incident_reopen_to_closed_state()
    {
        $incident = Incident::factory()->create([
            'status' => Reopened::class,
        ]);
        $incident->status->transitionTo(Closed::class);
        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_incident_opened_to_reopened_state_throws_exception()
    {
        $incident = Incident::factory()->create();

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Reopened::class);
    }

    public function test_incident_opened_to_in_review_state_throws_exception()
    {
        $incident = Incident::factory()->create();

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(InReview::class);
    }

    public function test_incident_assigned_to_reopened_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Reopened::class);
    }

    public function test_incident_in_review_to_reopened_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Reopened::class);
    }

    public function test_incident_in_review_to_open_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Opened::class);
    }

    public function test_incident_closed_to_in_review_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Closed::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(InReview::class);
    }

    public function test_incident_closed_to_open_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Closed::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Opened::class);
    }

    public function test_incident_closed_to_assigned_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Closed::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Assigned::class);
    }


    public function test_incident_reopened_to_opened_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Reopened::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(Opened::class);
    }

    public function test_incident_reopened_to_in_review_state_throws_exception()
    {
        $incident = Incident::factory()->create([
            'status' => Reopened::class,
        ]);

        $this->expectException(TransitionNotFound::class);
        $incident->status->transitionTo(InReview::class);
    }
}
