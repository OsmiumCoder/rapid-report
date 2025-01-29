<?php

namespace Incident;

use App\Data\CommentData;
use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AddCommentTest extends TestCase
{
    public function test_comment_belongs_to_current_signed_in_user()
    {
        $user = User::factory()->create()->assignRole('admin');
        $incident = Incident::factory()->create();

        $this->actingAs($user);

        $commentData = CommentData::from([
            'content' => 'test comment'
        ]);

        $this->assertDatabaseCount('comments', 0);

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData->toArray());

        $response->assertRedirect();

        $this->assertDatabaseCount('comments', 1);

        $comment = Comment::first();

        $this->assertEquals($user->id, $comment->user_id);
    }

    public function test_throws_validation_error_for_bad_data()
    {
        $user = User::factory()->create()->assignRole('admin');
        $incident = Incident::factory()->create();

        $this->actingAs($user);

        $commentData = ["content" => ""];

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);

        $response->assertInvalid([
            'content',
        ]);
    }

    public function test_forbidden_user_who_cant_view_cant_add_comment()
    {
        $user = User::factory()->create();
        $incident = Incident::factory()->create();

        $this->actingAs($user);

        $commentData = CommentData::from([
            'content' => 'test comment'
        ]);

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData->toArray());

        $response->assertForbidden();
    }

    public function test_creates_comment_and_attaches_to_model()
    {
        $user = User::factory()->create()->assignRole('admin');
        $incident = Incident::factory()->create();

        $this->actingAs($user);

        $commentData = CommentData::from([
            'content' => 'test comment'
        ]);

        $this->assertDatabaseCount('comments', 0);

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData->toArray());

        $response->assertRedirect();

        $this->assertDatabaseCount('comments', 1);

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments()->first();

        $this->assertEquals($user->id, $comment->user_id);
        $this->assertEquals($commentData->content, $comment->content);
        $this->assertEquals(CommentType::NOTE, $comment->type);
    }
}
