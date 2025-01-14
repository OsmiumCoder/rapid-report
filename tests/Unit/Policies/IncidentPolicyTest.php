<?php

namespace Tests\Unit\Policies;

use App\Models\Incident;
use App\Models\User;
use App\Policies\IncidentPolicy;
use Database\Seeders\RolesAndPermissionsSeeder;
use Tests\TestCase;

class IncidentPolicyTest extends TestCase
{
    protected string $seeder = RolesAndPermissionsSeeder::class;

    public function test_user_cant_view_incident_they_dont_own()
    {
        $incident = Incident::factory()->create([
            'reporters_email' => 'reporters@example.com',
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertFalse($result);
    }

    public function test_user_can_view_own_incident()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_supervisor_cant_view_incident_not_assigned_to_them()
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertFalse($result);
    }

    public function test_supervisor_can_view_assigned_incident()
    {
        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $user->id
        ]);


        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_admin_can_view_any_single_incident()
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $result = $this->getPolicy()->view($user, $incident);
        $this->assertTrue($result);
    }

    public function test_user_cant_view_all_incidents()
    {
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $result = $this->getPolicy()->viewAny($user);
        $this->assertFalse($result);
    }

    public function test_supervisor_cant_view_all_incidents()
    {
        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $result = $this->getPolicy()->viewAny($user);
        $this->assertFalse($result);
    }

    public function test_admin_can_view_all_incidents()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $result = $this->getPolicy()->viewAny($user);
        $this->assertTrue($result);
    }

    protected function getPolicy()
    {
        return app(IncidentPolicy::class);
    }
}
