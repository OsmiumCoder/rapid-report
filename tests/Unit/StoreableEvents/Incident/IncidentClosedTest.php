<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\StorableEvents\Incident\IncidentClosed;
use Tests\TestCase;

class IncidentClosedTest extends TestCase
{
    public function test_close_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $event = new IncidentClosed;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertEquals($supervisor->id, $incident->supervisor_id);

        $this->assertEquals(Closed::class, $incident->status::class);
    }
}
