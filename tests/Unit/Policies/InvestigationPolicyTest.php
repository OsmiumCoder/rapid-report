<?php

namespace Policies;

use App\Models\Incident;
use App\Models\User;
use App\Policies\InvestigationPolicy;
use Tests\TestCase;

class InvestigationPolicyTest extends TestCase
{
    public function test_admin_can_view_any_investigation()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $incident = Incident::factory()->create();

        $policy = $this->getPolicy();
        $this->assertTrue($policy->view($admin, $incident));
    }

    public function test_supervisor_can_view_investigation_on_assigned_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $policy = $this->getPolicy();
        $this->assertTrue($policy->view($supervisor, $incident));
    }

    public function test_supervisor_can_not_view_investigation_on_unassigned_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create();

        $policy = $this->getPolicy();
        $this->assertFalse($policy->view($supervisor, $incident));
    }

    public function test_user_can_not_view_investigations()
    {
        $user = User::factory()->create()->assignRole('user');

        $incident = Incident::factory()->create();

        $policy = $this->getPolicy();
        $this->assertFalse($policy->view($user, $incident));
    }


    public function test_admin_can_not_create_investigation()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $policy = $this->getPolicy();

        $this->assertFalse($policy->create($admin));
    }

    public function test_supervisor_can_create_investigation()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $policy = $this->getPolicy();

        $this->assertTrue($policy->create($supervisor));
    }

    public function test_user_can_not_create_investigation()
    {
        $user = User::factory()->create()->assignRole('user');
        $policy = $this->getPolicy();

        $this->assertFalse($policy->create($user));
    }

    protected function getPolicy()
    {
        return app(InvestigationPolicy::class);
    }
}
