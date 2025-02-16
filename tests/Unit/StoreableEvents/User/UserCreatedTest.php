<?php

namespace StoreableEvents\User;

use App\Enum\RolesEnum;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use Tests\TestCase;

class UserCreatedTest extends TestCase
{
    public function test_creates_user()
    {
        $event = new UserCreated(
            name: 'john',
            email: 'john@doe.com',
            password: 'password',
            upei_id: '43123',
            phone: '2332413124321',
            role: RolesEnum::SUPERVISOR,
        );

        $this->assertDatabaseCount('users', 0);

        $event->handle();

        $this->assertDatabaseCount('users', 1);

        $user = User::first();

        $this->assertEquals($event->name, $user->name);
        $this->assertEquals($event->email, $user->email);
        $this->assertEquals($event->upei_id, $user->upei_id);
        $this->assertEquals($event->phone, $user->phone);
        $this->assertTrue($user->hasExactRoles($event->role->value));
    }
}
