<?php

namespace Incident;

use App\Data\CommentData;
use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Comment\CommentMade;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AddCommentTest extends TestCase
{
    public function test_comment_belongs_to_current_signed_in_user()
    {
        $user = User::factory()->create()->syncRoles('admin');
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
        $user = User::factory()->create()->syncRoles('admin');
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
        $user = User::factory()->create()->syncRoles('admin');
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

    public function test_comment_notifies_admins_on_creation()
    {
        Notification::fake();

        $incident = Incident::factory()->create();

        $commentData = CommentData::from([
            'content' => 'Test comment for admin notification',
        ]);

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData->toArray());

        $response->assertRedirect();

        Notification::assertNothingSent();
    }

    public function test_comment_notifies_supervisor_when_supervisor_is_set()
    {
        Notification::fake();

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $commentData = CommentData::from([
            'content' => 'Test comment for supervisor notification',
        ]);

        $this->actingAs($supervisor);

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData->toArray());

        $response->assertRedirect();

        Notification::assertSentTo($supervisor, CommentMade::class);
    }

    public function test_comment_does_not_notify_supervisor_when_not_set()
    {
        Notification::fake();

        $incident = Incident::factory()->create([
            'supervisor_id' => null,
        ]);

        $commentData = CommentData::from([
            'content' => 'Test comment with no supervisor',
        ]);

        $response = $this->post(route('incidents.comments.store', ['incident' => $incident->id]), $commentData->toArray());

        $response->assertRedirect();

        Notification::assertNothingSent(); // should only send to admin
    }
}
