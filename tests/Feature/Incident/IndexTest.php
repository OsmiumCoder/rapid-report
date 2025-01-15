<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class IndexTest extends TestCase
{
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

    public function test_forbidden_if_basic_user(): void
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

    public function test_show_owned_incidents(): void {
        User::factory()->create(["email" => "email@example.com"])->assignRole("user");

        Incident::factory()->create(["reporters_email" => "email@example.com"]);

        $response = $this->get(route('incidents.owned'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Incident/Index')
                ->has('incidents', fn (AssertableInertia $page) => $page
                    ->where('current_page', 1)
                    ->count('data', 1)
                    ->has('data', fn (AssertableInertia $page) =>
                        $page->has('reporters_email', "email@example.com"))
                );
        });

    }
}
