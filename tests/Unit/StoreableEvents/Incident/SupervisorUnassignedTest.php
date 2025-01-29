<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\Incident\SupervisorUnassigned;
use Tests\TestCase;

class SupervisorUnassignedTest extends TestCase
{
    public function test_unassign_supervisor_from_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        $event = new SupervisorUnassigned;

        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertNull($incident->supervisor_id);
        $this->assertEquals(Opened::class, $incident->status::class);
    }
}
