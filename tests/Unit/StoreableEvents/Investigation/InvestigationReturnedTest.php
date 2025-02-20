<?php

namespace Tests\Unit\StoreableEvents\Investigation;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\Investigation\InvestigationReturned;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class InvestigationReturnedTest extends TestCase
{
    public function test_throws_if_not_in_review()
    {
        $this->expectException(TransitionNotFound::class);

        $admin = User::factory()->create();

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $event = new InvestigationReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $admin->id]);
        $event->handle();
    }

    public function test_returning_investigation_adds_returned_comment()
    {
        $admin = User::factory()->create();

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new InvestigationReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $admin->id]);
        $event->handle();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('returned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_returns_incident_investigation()
    {
        $admin = User::factory()->create();

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new InvestigationReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $admin->id]);
        $event->handle();

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }
}
