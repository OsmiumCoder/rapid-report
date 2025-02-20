<?php

namespace Tests\Unit\StoreableEvents\RootCauseAnalysis;

use App\Enum\CommentType;
use App\Models\Incident;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisReturned;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class RootCauseAnalysisReturnedTest extends TestCase
{
    public function test_throws_if_not_in_review()
    {
        $this->expectException(TransitionNotFound::class);

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();
    }

    public function test_returning_rca_adds_returned_comment()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('returned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('root cause analysis', $comment->content);
    }

    public function test_returns_incident_rca()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }
}
