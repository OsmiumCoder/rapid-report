<?php

namespace StoreableEvents\Comment;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Comment\CommentMade;
use App\StorableEvents\Comment\CommentCreated;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentCreatedTest extends TestCase
{
    public function test_adds_comment_to_model()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create();

        $event = new CommentCreated(
            content: "comments",
            type: CommentType::NOTE,
            commentable_id: $incident->id,
            commentable_type: get_class($incident),
        );

        $event->setMetaData(['user_id' => $user->id]);

        $this->assertDatabaseCount('comments', 0);

        $event->handle();

        $this->assertDatabaseCount('comments', 1);

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments()->first();

        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($event->content, $comment->content);
        $this->assertEquals($event->type, $comment->type);
    }

    public function test_stores_comment()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create();

        $event = new CommentCreated(
            content: "comments",
            type: CommentType::NOTE,
            commentable_id: $incident->id,
            commentable_type: get_class($incident),
        );

        $event->setMetaData(['user_id' => $user->id]);

        $this->assertDatabaseCount('comments', 0);

        $event->handle();

        $this->assertDatabaseCount('comments', 1);

        $comment = Comment::first();
        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($event->content, $comment->content);
        $this->assertEquals($event->type, $comment->type);
        $this->assertEquals($incident->id, $comment->commentable_id);
        $this->assertEquals(get_class($incident), $comment->commentable_type);
    }

    public function test_notifies_admin_on_comment_made()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->assignRole('admin');
        });
        $user = User::factory()->create();

        $incident = Incident::factory()->create();

        $event = new CommentCreated(
            content: "comments",
            type: CommentType::NOTE,
            commentable_id: $incident->id,
            commentable_type: get_class($incident),
        );

        $event->setMetaData(['user_id' => $user->id]);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);
        Notification::assertSentTo($admins, CommentMade::class);
        Notification::assertNotSentTo($user, CommentMade::class);
    }

    public function test_new_comment_notifies_supervisor_when_supervisor_is_set()
    {
        Notification::fake();

        $supervisor = User::factory()->create()->syncRoles(['supervisor']);
        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);
        $user = User::factory()->create();

        $event = new CommentCreated(
            content: "Supervisor notification test",
            type: CommentType::NOTE,
            commentable_id: $incident->id,
            commentable_type: get_class($incident),
        );

        Notification::assertNothingSent();

        $event->react();

        Notification::assertSentTo($supervisor, CommentMade::class);
        Notification::assertNotSentTo($user, CommentMade::class);
    }

    public function test_new_comment_does_not_notify_supervisor_when_supervisor_is_not_set()
    {
        Notification::fake();

        $user = User::factory()->create();
        $incident = Incident::factory()->create();

        $event = new CommentCreated(
            content: "Important update",
            type: CommentType::NOTE,
            commentable_id: $incident->id,
            commentable_type: get_class($incident),
        );

        $event->setMetaData([
            'user_id' => $user->id,
            'supervisor' => null,
        ]);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertNothingSent();
    }

    public function test_new_comment_notifies_both_admin_and_set_supervisor()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->assignRole('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $event = new CommentCreated(
            content: "Important update",
            type: CommentType::NOTE,
            commentable_id: $incident->id,
            commentable_type: get_class($incident),
        );

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(4);
        Notification::assertSentTo($admins, CommentMade::class);
        Notification::assertSentTo($supervisor, CommentMade::class);
    }
}
