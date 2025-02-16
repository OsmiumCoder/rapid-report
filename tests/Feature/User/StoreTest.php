<?php

namespace Tests\Feature\User;

use App\Enum\RolesEnum;
use App\Mail\UserAdded;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_notifies_user()
    {
        Mail::fake();

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        Mail::assertNothingSent();

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
        ]);

        Mail::assertSentCount(1);

        Mail::assertSent(UserAdded::class, function (UserAdded $mail) {
            return $mail->hasTo('test@example.com');
        });
    }

    public function test_fires_user_deleted_event()
    {
        Event::fake();

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
        ]);

        Event::assertDispatchedTimes(UserCreated::class, 1);

        Event::assertDispatched(function (UserCreated $event) {
            $this->assertEquals('Test User', $event->name);
            $this->assertEquals('test@example.com', $event->email);
            $this->assertEquals('123456', $event->upei_id);
            $this->assertEquals('12346565', $event->phone);
            $this->assertEquals(RolesEnum::SUPERVISOR, $event->role);
            return true;
        });
    }

    public function test_stores_user()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $this->assertDatabaseCount('users', 1);

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
        ]);

        $this->assertDatabaseCount('users', 2);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('123456', $user->upei_id);
        $this->assertEquals('12346565', $user->phone);
        $this->assertTrue($user->hasExactRoles(RolesEnum::SUPERVISOR->value));
    }

    public function test_user_forbidden_to_store()
    {
        $user = User::factory()->create()->assignRole('user');

        $this->actingAs($user);

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
        ]);

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_store()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
        ]);

        $response->assertForbidden();
    }
}
