<?php

namespace Tests\Feature\Incident;

use App\Enum\CommentType;
use App\Exceptions\UserNotSupervisorException;
use App\Models\Incident;
use App\Models\User;
use Tests\TestCase;

class AssignTest extends TestCase
{
    public function test_throws_user_not_supervisor_if_id_not_supervisor()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $notSupervisor = User::factory()->create()->assignRole('user');

        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $notSupervisor->id]);

        $this->assertInstanceOf(UserNotSupervisorException::class, $response->exception);
    }

    public function test_adds_assigned_comment()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $this->assertCount(0, $incident->comments);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(200);

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::INFO, $comment->type);
        $this->assertStringContainsStringIgnoringCase('assigned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('supervisor', $comment->content);
        $this->assertStringContainsStringIgnoringCase($supervisor->name, $comment->content);
    }

    public function test_assign_supervisor_updates_supervisor_id()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $this->assertNull($incident->supervisor_id);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(200);

        $incident->refresh();

        $this->assertEquals($supervisor->id, $incident->supervisor_id);
        $this->assertInstanceOf(User::class, $incident->supervisor);
    }

    public function test_assign_supervisor_not_permitted_by_user()
    {
        $user = User::factory()->create()->assignRole('user');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create();
        $this->assertNull($incident->supervisor_id);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);

    }

    public function test_assign_supervisor_not_permitted_by_supervisor()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();
        $this->assertNull($incident->supervisor_id);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);

    }
}
