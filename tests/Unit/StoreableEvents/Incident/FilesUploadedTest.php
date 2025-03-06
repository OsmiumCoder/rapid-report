<?php

namespace StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\FilesUploadedNotification;
use App\StorableEvents\Incident\FilesUploaded;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class FilesUploadedTest extends TestCase
{
    public function test_sends_notification_to_admins()
    {
        Notification::fake();
        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create();

        $event = new FilesUploaded;

        $event->setMetaData(['user_id' => $supervisor->id]);
        $event->setAggregateRootUuid($incident->id);

        $event->react();

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (FilesUploadedNotification $notification, array $channels) use ($incident, $supervisor) {
                return $notification->incidentSlug === $incident->slug && $notification->user->id === $supervisor->id;
            }
        );
    }

    public function test_adds_comment_to_incident()
    {
        $incident = Incident::factory()->create();
        $user = User::factory()->create();

        $event = new FilesUploaded;
        $event->setMetaData(['user_id' => $user->id]);
        $event->setAggregateRootUuid($incident->id);

        $event->handle();

        $incident->refresh();

        $comment = $incident->comments->first();

        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('files', $comment->content);
        $this->assertStringContainsStringIgnoringCase('uploaded', $comment->content);
    }
}
