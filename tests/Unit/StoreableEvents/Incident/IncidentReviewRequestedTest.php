<?php

namespace StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentReviewRequest;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\Incident\IncidentReviewRequested;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class IncidentReviewRequestedTest extends TestCase
{
    public function test_stores_request_notification_in_database()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new IncidentReviewRequested;

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (IncidentReviewRequest $notification, array $channels) use ($incident, $admins, $supervisor) {
                $databaseStore = $notification->toArray($admins->first());

                $this->assertEquals(route('incidents.show', $incident->id), $databaseStore['url']);

                return array_key_exists('message', $databaseStore);
            }
        );
    }

    public function test_sends_request_notification_to_admin()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new IncidentReviewRequested;

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (IncidentReviewRequest $notification, array $channels) use ($incident, $supervisor) {
                return $notification->incidentId === $incident->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_review_requested_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new IncidentReviewRequested;

        $event->setMetaData(['user_id' => $supervisor->id]);
        $event->setAggregateRootUuid($incident->id);

        $event->handle();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('review', $comment->content);
        $this->assertStringContainsStringIgnoringCase('requested', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_throws_if_not_assigned()
    {
        $this->expectException(TransitionNotFound::class);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Opened::class]);

        $event = new IncidentReviewRequested;

        $event->setMetaData(['user_id' => $supervisor->id]);
        $event->setAggregateRootUuid($incident->id);

        $event->handle();
    }

    public function test_incident_transitions_from_assigned_to_in_review()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new IncidentReviewRequested;

        $event->setMetaData(['user_id' => $supervisor->id]);
        $event->setAggregateRootUuid($incident->id);

        $event->handle();

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
    }
}
