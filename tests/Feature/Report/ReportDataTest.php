<?php

namespace Report;

use App\Models\Incident;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ReportDataTest extends TestCase
{
    public function test_report_page_recieves_all_incidents(): void
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);
        Incident::factory()->count(40)->create();
        $response = $this->get(route('reports.index'));
        $response->assertStatus(200);
        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Reports/Show')
                ->has('incidents', 40);
        });
    }

    public function test_forbidden_if_basic_user_access_incident_reports(): void
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $this->actingAs($user);

        Incident::factory()->count(10)->create();

        $response = $this->get(route('reports.show'));

        $response->assertForbidden();
    }
}
