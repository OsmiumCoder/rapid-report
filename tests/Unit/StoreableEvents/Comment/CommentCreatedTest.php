<?php

namespace StoreableEvents\Comment;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\StorableEvents\Comment\CommentCreated;
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
}
