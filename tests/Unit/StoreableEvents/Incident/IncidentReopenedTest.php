<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentReopenedNotification;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\Incident\IncidentReopened;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class IncidentReopenedTest extends TestCase
{
    public function test_reopen_incident_resets_closed_at()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $event = new IncidentReopened;
        $event->setMetaData(['user_id' => $supervisor->id]);
        $event->setAggregateRootUuid($incident->id);
        $event->handle();

        $incident->refresh();
        $this->assertNull($incident->closed_at);
    }

    public function test_throws_if_not_closed()
    {
        $this->expectException(TransitionNotFound::class);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Opened::class,
        ]);

        $event = new IncidentReopened;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();
    }

    public function test_adds_reopened_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $event = new IncidentReopened;
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
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
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();

        $incident->refresh();
        $this->assertNull($incident->supervisor_id);
        $this->assertEquals(Reopened::class, $incident->status::class);
    }

    public function test_reopen_incident_notifies_admin_team()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $user = User::factory()->create()->syncRoles('user');

        $incident = Incident::factory()->create([
            'status' => Closed::class,
            'supervisor_id' => $supervisor->id,
            ]);

        $event = new IncidentReopened;
        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);
        Notification::assertSentTo($admins, IncidentReopenedNotification::class);
        Notification::assertNotSentTo($supervisor, IncidentReopenedNotification::class);
        Notification::assertNotSentTo($user, IncidentReopenedNotification::class);
    }
}
