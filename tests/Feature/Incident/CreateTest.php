<?php

namespace Tests\Feature\Incident;

use App\Data\IncidentData;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_admin_can_view_admin_create_form()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $response = $this->get(route('incidents.create.admin'));

        $response->assertOk();
    }

    public function test_supervisor_cant_view_admin_create_form()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $response = $this->get(route('incidents.create.admin'));

        $response->assertForbidden();
    }

    public function test_user_cant_view_admin_create_form()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $response = $this->get(route('incidents.create.admin'));

        $response->assertForbidden();
    }

    public function test_shows_create_page_and_has_empty_form(): void
    {
        $response = $this->get(route('incidents.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Incident/Create')
                ->where('form', IncidentData::empty());
        });
    }
}
