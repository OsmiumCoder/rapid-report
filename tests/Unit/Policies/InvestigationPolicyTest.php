<?php

namespace Policies;

use App\Models\User;
use App\Policies\InvestigationPolicy;
use Tests\TestCase;

class InvestigationPolicyTest extends TestCase
{
    public function test_admin_can_not_create_investigation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $policy = $this->getPolicy();

        $this->assertFalse($policy->create($admin));
    }

    public function test_supervisor_can_create_investigation()
    {
        $supervisor = User::factory()->create(['role' => 'supervisor']);
        $policy = $this->getPolicy();

        $this->assertTrue($policy->create($supervisor));
    }

    public function test_user_can_not_create_investigation()
    {
        $user = User::factory()->create(['role' => 'user']);
        $policy = $this->getPolicy();

        $this->assertFalse($policy->create($user));
    }

    protected function getPolicy()
    {
        return app(InvestigationPolicy::class);
    }
}
