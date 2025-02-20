<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    public function test_admin_cant_update_role_of_self()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $result = $this->getPolicy()->updateRole($user, $user);
        $this->assertFalse($result);
    }

    public function test_admin_can_update_role_of_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $otherUser = User::factory()->create();

        $result = $this->getPolicy()->updateRole($user, $otherUser);
        $this->assertTrue($result);
    }

    public function test_supervisor_cant_update_role_of_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('supervisor');

        $otherUser = User::factory()->create();

        $result = $this->getPolicy()->updateRole($user, $otherUser);
        $this->assertFalse($result);
    }

    public function test_user_cant_update_role_of_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('user');

        $otherUser = User::factory()->create();

        $result = $this->getPolicy()->updateRole($user, $otherUser);
        $this->assertFalse($result);
    }

    public function test_admin_cant_delete_self()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $result = $this->getPolicy()->delete($user, $user);
        $this->assertFalse($result);
    }

    public function test_admin_can_delete_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $otherUser = User::factory()->create();

        $result = $this->getPolicy()->delete($user, $otherUser);
        $this->assertTrue($result);
    }

    public function test_supervisor_cant_delete_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('supervisor');

        $otherUser = User::factory()->create();

        $result = $this->getPolicy()->delete($user, $otherUser);
        $this->assertFalse($result);
    }

    public function test_user_cant_delete_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('user');

        $otherUser = User::factory()->create();

        $result = $this->getPolicy()->delete($user, $otherUser);
        $this->assertFalse($result);
    }

    public function test_admin_can_create_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $result = $this->getPolicy()->create($user);
        $this->assertTrue($result);
    }

    public function test_supervisor_cant_create_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('supervisor');

        $result = $this->getPolicy()->create($user);
        $this->assertFalse($result);
    }

    public function test_user_cant_create_users()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('user');

        $result = $this->getPolicy()->create($user);
        $this->assertFalse($result);
    }

    protected function getPolicy()
    {
        return app(UserPolicy::class);
    }
}
