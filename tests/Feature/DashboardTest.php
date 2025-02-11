<?php

namespace Feature;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_admin_overview_returns_5_latest_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        Incident::factory(5)->create();

        $response = $this->get(route('dashboard.admin'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/AdminOverview')
                ->has('incidents', 5);
        });
    }

    public function test_admin_overview_returns_correct_number_of_total_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        Incident::factory(10)->create();

        $response = $this->get(route('dashboard.admin'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/AdminOverview')
                ->has('incidentCount')
                ->where('incidentCount', 10);
        });
    }

    public function test_admin_overview_returns_correct_number_of_closed_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        Incident::factory(10)->create();
        Incident::factory(10)->create(['status' => Closed::class]);

        $response = $this->get(route('dashboard.admin'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/AdminOverview')
                ->has('closedCount')
                ->where('closedCount', 10);
        });
    }

    public function test_admin_overview_returns_correct_number_of_open_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        Incident::factory(10)->create();
        Incident::factory(10)->create(['status' => Closed::class]);

        $response = $this->get(route('dashboard.admin'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/AdminOverview')
                ->has('unresolvedCount')
                ->where('unresolvedCount', 10);
        });
    }

    public function test_supervisor_overview_returns_5_latest_assigned_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        Incident::factory(5)->create();
        Incident::factory(10)->create(['supervisor_id' => $supervisor->id]);

        $response = $this->get(route('dashboard.supervisor'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) use ($supervisor) {
            $page->component('Dashboard/SupervisorOverview')
                ->has('unresolvedIncidents', 5)
                ->where('unresolvedIncidents.0.supervisor_id', $supervisor->id)
                ->where('unresolvedIncidents.1.supervisor_id', $supervisor->id)
                ->where('unresolvedIncidents.2.supervisor_id', $supervisor->id)
                ->where('unresolvedIncidents.3.supervisor_id', $supervisor->id)
                ->where('unresolvedIncidents.4.supervisor_id', $supervisor->id)
            ;
        });
    }

    public function test_supervisor_overview_returns_correct_number_of_total_assigned_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        Incident::factory(10)->create(['supervisor_id' => $supervisor->id]);
        Incident::factory(10)->create();


        $response = $this->get(route('dashboard.supervisor'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/SupervisorOverview')
                ->has('incidentCount')
                ->where('incidentCount', 10);
        });
    }

    public function test_supervisor_overview_returns_correct_number_of_closed_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        Incident::factory(10)->create(['supervisor_id' => $supervisor->id]);
        Incident::factory(10)->create(['supervisor_id' => $supervisor->id, 'status' => Closed::class]);
        Incident::factory(10)->create();


        $response = $this->get(route('dashboard.supervisor'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/SupervisorOverview')
                ->has('closedCount')
                ->where('closedCount', 10);
        });
    }

    public function test_supervisor_overview_returns_correct_number_of_open_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        Incident::factory(10)->create(['supervisor_id' => $supervisor->id]);
        Incident::factory(10)->create(['supervisor_id' => $supervisor->id, 'status' => Closed::class]);
        Incident::factory(10)->create();


        $response = $this->get(route('dashboard.supervisor'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Dashboard/SupervisorOverview')
                ->has('closedCount')
                ->where('closedCount', 10);
        });
    }

    public function test_user_dashboard_returns_5_latest_submitted_incidents()
    {
        $user = User::factory()->create(['email' => 'email@b.com'])->assignRole('user');
        $this->actingAs($user);

        Incident::factory(5)->create(['reporters_email' => $user->email]);
        Incident::factory(5)->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) use ($user) {
            $page->component('Dashboard/UserDashboard')
                ->has('incidents', 5)
                ->where('incidents.0.reporters_email', $user->email)
                ->where('incidents.1.reporters_email', $user->email)
                ->where('incidents.2.reporters_email', $user->email)
                ->where('incidents.3.reporters_email', $user->email)
                ->where('incidents.4.reporters_email', $user->email)
            ;
        });
    }

    public function test_user_dashboard_returns_total_amount_of_incidents_submitted()
    {
        $user = User::factory()->create(['email' => 'email@b.com'])->assignRole('user');
        $this->actingAs($user);

        Incident::factory(10)->create(['reporters_email' => $user->email]);
        Incident::factory(5)->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) use ($user) {
            $page->component('Dashboard/UserDashboard')
                ->where('incidentCount', 10);
        });
    }

    public function test_user_dashbaord_returns_total_amount_of_unresolved_incidents()
    {
        $user = User::factory()->create(['email' => 'email@b.com'])->assignRole('user');
        $this->actingAs($user);

        Incident::factory(10)->create(['reporters_email' => $user->email]);
        Incident::factory(5)->create(['reporters_email' => $user->email, 'status' => Closed::class]);

        Incident::factory(5)->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) use ($user) {
            $page->component('Dashboard/UserDashboard')
                ->where('unresolvedCount', 10);
        });
    }

    public function test_admin_can_view_admin_overview()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);
        $response = $this->get(route('dashboard.admin'));
        $response->assertStatus(200);
    }

    public function test_supervisor_is_forbidden_to_view_admin_overview()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);
        $response = $this->get(route('dashboard.admin'));
        $response->assertForbidden();
    }

    public function test_user_is_forbidden_to_view_admin_overview()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);
        $response = $this->get(route('dashboard.admin'));
        $response->assertForbidden();
    }

    public function test_supervisor_can_view_supervisor_overview()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);
        $response = $this->get(route('dashboard.supervisor'));
        $response->assertOk();
    }

    public function test_admin_is_forbidden_to_view_supervisor_overview()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);
        $response = $this->get(route('dashboard.supervisor'));
        $response->assertForbidden();
    }

    public function test_user_is_forbidden_to_view_supervisor_overview()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);
        $response = $this->get(route('dashboard.supervisor'));
        $response->assertForbidden();
    }


    public function test_user_can_view_dashboard()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);
        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_supervisor_can_view_dashboard()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);
        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_admin_can_view_dashboard()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);
        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }
}
