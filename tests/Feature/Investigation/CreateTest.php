<?php

namespace Tests\Feature\Investigation;

use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use App\Models\User;

class CreateTest extends TestCase
{
    public function test_authenticated_user_can_access_create_investigation_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('investigations.create'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Investigation/Create');
        });
    }

    public function test_unauthenticated_user_cannot_access_create_investigation_page(): void
    {
        $response = $this->get(route('investigations.create'));

        $response->assertRedirect('/login');
    }
}
