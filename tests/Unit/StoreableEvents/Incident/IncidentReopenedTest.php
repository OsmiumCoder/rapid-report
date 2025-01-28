<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\Incident\IncidentReopened;
use Tests\TestCase;

class IncidentReopenedTest extends TestCase
{
    public function test_reopen_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $event = new IncidentReopened;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertNull($incident->supervisor_id);
        $this->assertEquals(Reopened::class, $incident->status::class);
    }
}
