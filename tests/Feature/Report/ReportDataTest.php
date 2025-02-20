<?php

namespace Tests\Feature\Report;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ReportDataTest extends TestCase
{
    public function test_report_page_receives_all_incidents()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $this->actingAs($admin);

        Incident::factory()->count(40)->create();

        $response = $this->get(route('reports.index'));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Report/Index')
                ->has('incidents', 40);
        });
    }

    public function test_forbidden_if_basic_user_access_reports_page()
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('reports.index'));

        $response->assertForbidden();
    }
    public function test_forbidden_if_supervisor_access_reports_page()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $this->actingAs($supervisor);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('reports.index'));

        $response->assertForbidden();
    }
}
