<?php

namespace Incident;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_show_incident_loads_investigations_for_admins()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($investigation) {
            $page->component('Incident/Show')
                ->has('incident.investigations')
                ->where('incident.investigations.0.id', $investigation->id);
        });

    }

    public function test_show_incident_loads_investigations_for_supervisors()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($investigation) {
            $page->component('Incident/Show')
                ->has('incident.investigations')
                ->where('incident.investigations.0.id', $investigation->id);
        });

    }

    public function test_show_incident_does_not_load_investigations_for_users()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create(['reporters_email' => $user->email]);
        Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->missing('incident.investigations');
        });
    }
    public function test_show_with_admin_gives_supervisors_prop()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.show', $incident));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($supervisor, $incident) {
            $page->component('Incident/Show')
                ->has('incident')
                ->where('incident.id', $incident->id)
                ->has('supervisors', 1)
                ->where('supervisors.0.id', $supervisor->id);
        });
    }

    public function test_show_with_supervisor_gives_empty_supervisors_prop()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $response = $this->get(route('incidents.show', $incident));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($incident) {
            $page->component('Incident/Show')
                ->has('incident')
                ->where('incident.id', $incident->id)
                ->has('supervisors', 0);
        });
    }

    public function test_show_with_user_gives_empty_supervisors_prop()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $response = $this->get(route('incidents.show', $incident));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($incident) {
            $page->component('Incident/Show')
                ->has('incident')
                ->where('incident.id', $incident->id)
                ->has('supervisors', 0);
        });
    }

    public function test_incident_has_comments_loaded(): void
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
                ->where('incident.id', $incident->id)
                ->has('incident.comments');
        });
    }

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
