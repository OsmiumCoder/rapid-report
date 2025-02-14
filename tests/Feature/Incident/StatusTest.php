<?php

namespace Tests\Feature\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use Tests\TestCase;

class StatusTest extends TestCase
{
    public function test_adds_returned_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('returned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
        $this->assertEquals($admin->id, $comment->user_id);
    }

    public function test_admin_can_return_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }

    public function test_user_can_not_return_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_supervisor_can_not_return_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.return-investigation', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_adds_reopened_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('reopened', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
        $this->assertEquals($admin->id, $comment->user_id);
    }

    public function test_adds_closed_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertRedirect();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('closed', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
        $this->assertEquals($admin->id, $comment->user_id);
    }

    public function test_admin_can_reopen_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Reopened::class, $incident->status::class);
        $this->assertNull($incident->supervisor_id);
    }

    public function test_user_can_not_reopen_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_supervisor_can_not_reopen_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->patch(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_admin_can_close_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_user_can_not_close_incidents()
    {
        $user = User::factory()->create()->syncRoles('user');

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_supervisor_can_not_close_incidents()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->patch(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(InReview::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }
}
