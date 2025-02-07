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
        $user = User::factory()->create()->assignRole('user');

        $response = $this->actingAs($user)->get(route('investigations.create'));

        $response->assertForbidden();
    }

    public function test_forbidden_if_admin(): void
    {
        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('investigations.create'));

        $response->assertForbidden();
    }
}
