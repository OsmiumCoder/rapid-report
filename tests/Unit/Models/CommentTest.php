<?php

namespace Models;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_creates_a_comment_model_and_attaches_a_user()
    {
        $comment = Comment::factory()
            ->for(Incident::factory(), 'commentable')
            ->for(User::factory(), 'user')
            ->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    public function test_creates_a_comment_model_and_attaches_to_incident()
    {
        $comment = Comment::factory()
            ->for(Incident::factory(), 'commentable')
            ->create();

        $this->assertInstanceOf(CommentType::class, $comment->type);
        $this->assertNotNull($comment->content);
        $this->assertInstanceOf(Incident::class, $comment->commentable);

    }
}
