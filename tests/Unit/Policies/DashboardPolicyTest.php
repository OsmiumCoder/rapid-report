<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Policies\DashboardPolicy;
use Tests\TestCase;

class DashboardPolicyTest extends TestCase
{
    public function test_admin_can_access_admin_overview()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->assertTrue($this->getPolicy()->viewAdminOverview($admin));
    }

    public function test_supervisor_can_not_access_admin_overview()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->assertFalse($this->getPolicy()->viewAdminOverview($supervisor));
    }

    public function test_user_can_not_access_admin_overview()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->assertFalse($this->getPolicy()->viewAdminOverview($user));
    }

    public function test_supervisor_can_access_supervisor_overview()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->assertTrue($this->getPolicy()->viewSupervisorOverview($supervisor));
    }

    public function test_admin_can_not_access_supervisor_overview()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->assertFalse($this->getPolicy()->viewSupervisorOverview($admin));
    }

    public function test_user_can_not_access_supervisor_overview()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->assertFalse($this->getPolicy()->viewSupervisorOverview($user));
    }

    protected function getPolicy()
    {
        return app(DashboardPolicy::class);
    }
}
