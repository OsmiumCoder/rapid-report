<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\Incident\SupervisorAssigned;
use Tests\TestCase;

class SupervisorAssignedTest extends TestCase
{
    public function test_adds_assigned_comment()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create();

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);

        $this->assertDatabaseCount('comments', 0);

        $event->handle();

        $this->assertDatabaseCount('comments', 1);

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('assigned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('supervisor', $comment->content);
        $this->assertStringContainsStringIgnoringCase($supervisor->name, $comment->content);

    }

    public function test_updates_status_from_open_to_assigned()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create();
        $this->assertEquals(Opened::class, $incident->status::class);

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertEquals(Assigned::class, $incident->status::class);
    }
    public function test_assigns_supervisor_to_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create();

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }
}
