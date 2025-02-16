<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\Incident\IncidentReopened;
use Tests\TestCase;

class IncidentReopenedTest extends TestCase
{
    public function test_adds_reopened_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $event = new IncidentReopened;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('reopened', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_reopen_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

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
