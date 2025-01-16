<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_forbidden_if_basic_user_access_assigned_incidents(): void
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.assigned'));

        $response->assertForbidden();
    }
    public function test_show_owned_incidents(): void
    {
        $email = 'email@b.com';
        $user = User::factory()->create(['email' => $email])->assignRole('user');
        $this->actingAs($user);

        Incident::factory()->create(['reporters_email' => $email]);

        $response = $this->get(route('incidents.owned'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $res) => $res
                ->component('Incident/Owned')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->count('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('reporters_email', $email)
                                ->etc()
                        )
                        ->where('current_page', 1)
                        ->count('data', 1)
                        ->where('from', 1)
                        ->where('to', 1)
                        ->where('last_page', 1)
                        ->count('links', 3)
                        ->etc()
                )
        );
    }

    public function test_show_assigned_incidents(): void
    {
        $user = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($user);

        Incident::factory()->create(['supervisor_id' => $user->id]);

        $response = $this->get(route('incidents.assigned'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $res) => $res
                ->component('Incident/Assigned')
                ->has(
                    'incidents',
                    fn (AssertableInertia $incidents) => $incidents
                        ->count('data', 1)
                        ->has(
                            'data.0',
                            fn (AssertableInertia $incident) => $incident
                                ->where('supervisor_id', $user->id)
                                ->etc()
                        )
                        ->where('current_page', 1)
                        ->count('data', 1)
                        ->where('from', 1)
                        ->where('to', 1)
                        ->where('last_page', 1)
                        ->count('links', 3)
                        ->etc()
                )
        );
    }

    public function test_must_be_auth(): void
    {
        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertFound();
        $response->assertRedirect(route('login'));
    }

    public function test_forbidden_if_supervisor(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('supervisor');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertForbidden();
    }

    public function test_forbidden_if_basic_user_access_all_incidents(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertForbidden();
    }

    public function test_shows_index_page_with_incidents(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $this->actingAs($user);

        Incident::factory()->count(20)->create();

        $response = $this->get(route('incidents.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Incident/Index')
                ->has(
                    'incidents',
                    fn (AssertableInertia $page) => $page
                        ->where('current_page', 1)
                        ->count('data', 15)
                        ->where('from', 1)
                        ->where('to', 15)
                        ->where('last_page', 2)
                        ->count('links', 4)
                        ->etc()
                );
        });
    }
}
