<?php

namespace Tests\Feature\Investigation;

use App\Data\InvestigationData;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use App\Models\User;

class CreateTest extends TestCase
{
    public function test_shows_create_page_and_has_empty_form(): void
    {
        $user = User::factory()->create()->assignRole('supervisor');

        $response = $this->actingAs($user)->get(route('investigations.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Investigation/Create')
                ->where('form', InvestigationData::empty());
        });
    }

    public function test_forbidden_if_basic_user(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post(route('investigations.store'), [
            'title' => 'Unauthorized Investigation',
            'description' => 'Test',
            'incident_id' => 1
        ]);

        $response->assertForbidden();
    }

    public function test_forbidden_if_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('investigations.store'), [
            'title' => 'Admin Attempt',
            'description' => 'Admin should not create this',
            'incident_id' => 1
        ]);

        $response->assertForbidden();
    }
}
