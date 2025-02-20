<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_show_incident_canProvideFollowup_prop_true_for_supervisor_assigned_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', true);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_true_for_supervisor_returned_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Returned::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', true);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_false_for_supervisor_opened_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Opened::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', false);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_false_for_supervisor_inReview_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', false);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_false_for_supervisor_closed_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', false);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_false_for_supervisor_reopened_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Reopened::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', false);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_false_for_admin()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $admin->id,
            'status' => Assigned::class
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', false);
        });
    }

    public function test_show_incident_canProvideFollowup_prop_false_for_reporting_user()
    {
        $user = User::factory()->create(['email' => 'email@b.com'])->syncRoles('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id,
            'reporters_email' => 'email@b.com',
            'status' => Assigned::class,
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->where('canProvideFollowup', false);
        });
    }

    public function test_show_incident_loads_only_supervisors_investigations_with_supervisor_relation_as_supervisor()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        // This investigation should not return as it was not made by the supervisor
        Investigation::factory()->create(['incident_id' => $incident->id]);

        Investigation::factory()->create([
           'supervisor_id' => $supervisor->id,
           'incident_id' => $incident->id
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->has('incident.investigations', 1)
                ->has('incident.investigations.0.supervisor');
        });

    }

    public function test_show_incident_loads_all_investigations_with_supervisor_relation_for_admins()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        Investigation::factory()->create(['incident_id' => $incident->id]);
        Investigation::factory()->create(['incident_id' => $incident->id]);


        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->has('incident.investigations', 2)
                ->has('incident.investigations.0.supervisor');
        });

    }

    public function test_show_incident_loads_all_investigations_for_admins()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);
        Investigation::factory()->create(['incident_id' => $incident->id]);


        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($investigation) {
            $page->component('Incident/Show')
                ->has('incident.investigations', 2)
                ->where('incident.investigations.0.id', $investigation->id);
        });

    }

    public function test_show_incident_loads_only_supervisors_investigations_as_supervisor()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        // This investigation should not return as it was not made by the supervisor
        Investigation::factory()->create(['incident_id' => $incident->id]);

        $investigation = Investigation::factory()->create([
            'supervisor_id' => $supervisor->id,
            'incident_id' => $incident->id
        ]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($investigation) {
            $page->component('Incident/Show')
                ->has('incident.investigations', 1)
                ->where('incident.investigations.0.id', $investigation->id);
        });
    }

    public function test_show_incident_does_not_load_investigations_for_users()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create(['reporters_email' => $user->email]);
        Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.show', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incident/Show')
                ->has('incident.investigations', 0);
        });
    }
    public function test_show_with_admin_gives_supervisors_prop()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

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
        $supervisor = User::factory()->create()->syncRoles('supervisor');
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
        $user = User::factory()->create()->syncRoles('user');
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
        ])->syncRoles('admin');

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
        ])->syncRoles('supervisor');

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
        ])->syncRoles('user');

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
        ])->syncRoles('supervisor');

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
        ])->syncRoles('user');

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
        ])->syncRoles('admin');

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
