<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\StorableEvents\Incident\SupervisorAssigned;
use Tests\TestCase;

class SupervisorAssignedTest extends TestCase
{
    public function test_assign_supervisor_to_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create();

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
        $this->assertEquals(Assigned::class, $incident->status::class);
    }
}
