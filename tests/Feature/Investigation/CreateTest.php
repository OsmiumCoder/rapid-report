<?php

namespace Tests\Feature\Investigation;

use App\Data\InvestigationData;
use App\Models\Incident;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use App\Models\User;

class CreateTest extends TestCase
{
    public function test_shows_create_page_and_has_empty_form(): void
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $response = $this->actingAs($supervisor)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            return $page->component('Investigation/Create')
                ->where('form', InvestigationData::empty());
        });
    }

    public function test_forbidden_if_basic_user(): void
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create()->assignRole('user');

        $response = $this->actingAs($user)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }

    public function test_forbidden_if_admin(): void
    {
        $incident = Incident::factory()->create();

        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }
}
