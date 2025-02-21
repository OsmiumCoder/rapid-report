<?php

namespace Tests\Unit\StoreableEvents\Investigation;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\Notifications\Investigation\InvestigationReturnedNotification;
use App\Notifications\Investigation\InvestigationSubmittedNotification;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\Investigation\InvestigationCreated;
use App\StorableEvents\Investigation\InvestigationReturned;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class InvestigationReturnedTest extends TestCase
{
    public function test_returning_investigation_sends_investigation_returned_notification_to_supervisor()
    {
        Notification::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => InReview::class,
            'supervisor_id' => $supervisor->id
        ]);

        Investigation::factory()->create([
                'incident_id' => $incident->id,
                'supervisor_id' => $supervisor->id
            ]);

        $event = new InvestigationReturned;

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(1);

        Notification::assertSentTo($supervisor, InvestigationReturnedNotification::class);
    }

    public function test_throws_if_not_in_review()
    {
        $this->expectException(TransitionNotFound::class);

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $event = new InvestigationReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();
    }

    public function test_returning_investigation_adds_returned_comment()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new InvestigationReturned;
        $event->setAggregateRootUuid($incident->id);
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
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $event = new InvestigationReturned;
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }
}
