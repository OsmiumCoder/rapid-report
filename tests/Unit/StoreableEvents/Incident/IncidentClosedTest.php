<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentClosedNotification;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\StorableEvents\Incident\IncidentClosed;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class IncidentClosedTest extends TestCase
{
    public function test_adds_closed_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $event = new IncidentClosed;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('closed', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_close_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $event = new IncidentClosed;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();

        $incident->refresh();
        $this->assertEquals($supervisor->id, $incident->supervisor_id);

        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_close_incident_notifies_supervisor()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);
        $incident->save();

        $event = new IncidentClosed;
        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertSentTo($supervisor, IncidentClosedNotification::class);
        Notification::assertSentTo($admins, IncidentClosedNotification::class);
    }

    public function test_close_incident_does_not_notify_supervisor_when_supervisor_is_not_set()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => null,
            'status' => InReview::class,
        ]);
        $incident->save();

        $event = new IncidentClosed;
        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertNotSentTo($supervisor, IncidentClosedNotification::class);
        Notification::assertSentTo($admins, IncidentClosedNotification::class);
    }

    public function test_close_incident_notifies_admin_team()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create(['status' => InReview::class,]);
        $incident->save();

        $event = new IncidentClosed;
        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertSentTo($admins, IncidentClosedNotification::class);
    }
}
