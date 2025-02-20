<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_creates_a_user_model_with_user_role()
    {
        $user = User::factory()->create();

        $this->assertTrue($user->hasRole('user'));
    }
}
