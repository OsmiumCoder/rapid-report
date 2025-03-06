<?php

namespace Tests\Unit\StoreableEvents\RootCauseAnalysis;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Notifications\RootCauseAnalysis\RootCauseAnalysisReturnedNotification;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisReturned;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class RootCauseAnalysisReturnedTest extends TestCase
{
    public function test_throws_if_not_in_review()
    {
        $this->expectException(TransitionNotFound::class);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();
    }

    public function test_returning_rca_adds_returned_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
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
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setMetaData(['user_id' => $supervisor->id]);
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }

    public function test_returned_rca_notifies_supervisor()
    {
        Notification::fake();

        $user = User::factory()->create()->syncRoles('user');
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $admin = User::factory()->create()->syncRoles('admin');

        $incident = Incident::factory()->create([
            'status' => InReview::class,
            'supervisor_id' => $supervisor->id,
        ]);

        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $event = new RootCauseAnalysisReturned;
        $event->setMetaData(['user_id' => $admin->id]);
        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertNotSentTo($user, RootCauseAnalysisReturnedNotification::class);
        Notification::assertSentTo($supervisor, RootCauseAnalysisReturnedNotification::class);
        Notification::assertNotSentTo($admin, RootCauseAnalysisReturnedNotification::class);
    }
}
