<?php

namespace Tests\Feature\User;

use App\Enum\RolesEnum;
use App\Mail\UserAdded;
use App\Models\Incident;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_creating_supervisor_with_incident_id_assigns_to_incident()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
            'incident_id' => $incident->id,
        ]);

        $response->assertRedirect();

        $incident->refresh();

        $supervisor = User::role('supervisor')->firstOrFail();

        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_creating_admin_with_incident_id_does_not_assign_incident()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('users', 1);

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::ADMIN->value,
            'incident_id' => $incident->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('users', 2);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);
    }

    public function test_creating_user_with_incident_id_does_not_assign_incident()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('users', 1);

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::USER->value,
            'incident_id' => $incident->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('users', 2);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);
    }

    public function test_notifies_user()
    {
        Mail::fake();

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        Mail::assertNothingSent();

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
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
            'upei_id' => '123456',
            'phone' => '12346565',
            'role' => RolesEnum::SUPERVISOR->value,
        ]);

        $response->assertForbidden();
    }
}
