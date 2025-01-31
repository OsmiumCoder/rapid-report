<?php

namespace Policies;

use App\Models\User;
use App\Policies\ReportPolicy;
use Tests\TestCase;

class ReportPolicyTest extends TestCase
{
    public function test_admin_can_view_report()
    {

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $result = $this->getPolicy()->view($user);
        $this->assertTrue($result);
    }

    public function test_user_cant_view_report()
    {

        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@b.com',
        ])->assignRole('user');

        $result = $this->getPolicy()->view($user);
        $this->assertFalse($result);
    }

    public function test_supervisor_cant_view_report()
    {
        $user = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $result = $this->getPolicy()->view($user);
        $this->assertFalse($result);
    }

    protected function getPolicy()
    {
        return app(ReportPolicy::class);
    }
}
