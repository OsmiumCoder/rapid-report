<?php

namespace Tests\Feature\Report;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class StatsTest extends TestCase
{
    public function test_statistics_page_receives_correct_distribution_props()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        Incident::factory()->count(40)->create();

        $response = $this->get(route('report.stats'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
          //  dd($page);
            $page->component('Report/Stats')
                ->has('type_dist', 3)
                ->has('role_dist', 4)
                ->has('status_dist')
                ->has('anon_dist')
                ->has('on_behalf_dist')
                ->has('on_behalf_anon_dist')
                ->has('descriptor_dist')
                ->has('safety_dist')
                ->has('environmental_dist')
                ->has('security_dist')
                ->has('witnesses_dist');

        });
    }

    public function test_forbidden_if_basic_user_access_stats_page()
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('report.stats'));

        $response->assertForbidden();
    }
    public function test_forbidden_if_supervisor_access_stats_page()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('report.stats'));

        $response->assertForbidden();
    }
}
