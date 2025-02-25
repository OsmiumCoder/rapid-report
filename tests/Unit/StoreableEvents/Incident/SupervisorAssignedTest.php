<?php

namespace Tests\Unit\StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentFollowUpOverdueNotification;
use App\Notifications\Incident\SupervisorAssignedNotification;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\Incident\SupervisorAssigned;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SupervisorAssignedTest extends TestCase
{
    public function test_overdue_does_not_send_to_supervisor_if_not_assigned_or_returned()
    {
        Notification::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => InReview::class,
            'supervisor_id' => $supervisor->id,
        ]);

        $event = new SupervisorAssigned($supervisor->id);

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        $event->react();

        Notification::assertNotSentTo(
            $supervisor,
            IncidentFollowUpOverdueNotification::class
        );
    }

    public function test_overdue_does_not_send_to_supervisor_if_no_longer_assigned()
    {
        Notification::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        $event = new SupervisorAssigned($supervisor->id);

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        $event->react();

        Notification::assertNotSentTo(
            $supervisor,
            IncidentFollowUpOverdueNotification::class
        );
    }

    public function test_overdue_sends_to_supervisor_if_returned_state_and_still_assigned()
    {
        Notification::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Returned::class,
            'supervisor_id' => $supervisor->id,
        ]);

        $event = new SupervisorAssigned($supervisor->id);

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        $event->react();

        Notification::assertSentTo(
            $supervisor,
            IncidentFollowUpOverdueNotification::class
        );
    }

    public function test_overdue_sends_to_supervisor_if_assigned_state_and_still_assigned()
    {
        Notification::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
            'supervisor_id' => $supervisor->id,
        ]);

        $event = new SupervisorAssigned($supervisor->id);

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        $event->react();

        Notification::assertSentTo(
            $supervisor,
            IncidentFollowUpOverdueNotification::class
        );
    }

    public function test_overdue_notifications_delayed_by_72_hours()
    {
        Queue::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
            'supervisor_id' => $supervisor->id,
        ]);

        $event = new SupervisorAssigned($supervisor->id);

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        $event->react();

        Queue::assertPushed(SendQueuedNotifications::class, function ($job) {
            return $job->delay == now()->addHours(72);
        });
    }

    public function test_assigning_supervisor_sends_assigned_notification_to_supervisor()
    {
        Notification::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
            'supervisor_id' => $supervisor->id
        ]);

        $event = new SupervisorAssigned($supervisor->id);

        $event->setMetaData(['user_id' => $admin->id]);

        $event->setAggregateRootUuid($incident->id);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertSentTo($supervisor, SupervisorAssignedNotification::class);
    }

    public function test_adds_assigned_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create();

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);

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
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create();

        $this->assertEquals(Opened::class, $incident->status::class);

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();

        $incident->refresh();
        $this->assertEquals(Assigned::class, $incident->status::class);
    }
    public function test_assigns_supervisor_to_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create();

        $event = new SupervisorAssigned($supervisor->id);
        $event->setAggregateRootUuid($incident->id);
        $event->setMetaData([...$event->metaData(), 'user_id' => $supervisor->id]);
        $event->handle();

        $incident->refresh();
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }
}
