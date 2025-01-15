<?php

namespace Incident;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_must_be_auth(): void
    {
        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.show', ['incident' => $incident]));

        $response->assertFound();
        $response->assertRedirect(route('login'));
    }

    public function test_forbidden_if_supervisor_not_assigned(): void
    {
        $user = User::factory()->create([
            'name' => 'supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.show', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_forbidden_if_basic_user_not_reporter(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.show', ['incident' => $incident]));

        $response->assertForbidden();
    }

    public function test_allowed_if_supervisor_assigned(): void
    {
        $user = User::factory()->create([
            'name' => 'supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($user) {
            return $page->component('Incident/Show')
                ->has('incident')
                ->where('incident.supervisor_id', $user->id);
        });
    }

    public function test_allowed_if_basic_user_is_reporter(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($user) {
            return $page->component('Incident/Show')
                ->has('incident')
                ->where('incident.reporters_email', $user->email);
        });
    }

    public function test_shows_show_page_with_correct_incident(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $this->actingAs($user);

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.show', ['incident' => $incident]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($incident) {
            return $page->component('Incident/Show')
                ->has('incident')
                ->where('incident.id', $incident->id);
        });
    }
}
