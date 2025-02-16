<?php

namespace StoreableEvents\User;

use App\Enum\RolesEnum;
use App\Mail\UserAdded;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserCreatedTest extends TestCase
{
    public function test_notifies_user()
    {
        Mail::fake();

        $event = new UserCreated(
            name: 'john',
            email: 'john@doe.com',
            password: 'password',
            upei_id: '43123',
            phone: '2332413124321',
            role: RolesEnum::SUPERVISOR,
        );

        Mail::assertNothingSent();

        $event->react();

        Mail::assertSentCount(1);

        Mail::assertSent(UserAdded::class, function (UserAdded $mail) use ($event) {
            return $mail->hasTo($event->email);
        });
    }

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
