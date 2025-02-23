<?php

namespace Tests\Unit\StoreableEvents\User;

use App\Enum\RolesEnum;
use App\Mail\UserAdded;
use App\Models\Incident;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserCreatedTest extends TestCase
{
    public function test_supervisor_created_with_incident_id_assigns_to_incident()
    {
        Mail::fake();

        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);
        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('users', 1);

        $event = new UserCreated(
            name: 'john',
            email: 'john@doe.com',
            password: 'password',
            upei_id: '43123',
            phone: '2332413124321',
            role: RolesEnum::SUPERVISOR,
            incident_id: $incident->id
        );

        $event->handle();

        $this->assertDatabaseCount('users', 2);

        $incident->refresh();

        $supervisor = User::role('supervisor')->firstOrFail();

        $this->assertEquals($supervisor->id, $incident->supervisor_id);
    }

    public function test_admin_created_with_incident_id_does_not_assign_to_incident()
    {
        Mail::fake();

        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);
        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('users', 1);

        $event = new UserCreated(
            name: 'john',
            email: 'john@doe.com',
            password: 'password',
            upei_id: '43123',
            phone: '2332413124321',
            role: RolesEnum::ADMIN,
            incident_id: $incident->id
        );

        $event->handle();

        $this->assertDatabaseCount('users', 2);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);
    }


    public function test_user_created_with_incident_id_does_not_assign_to_incident()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);
        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('users', 1);

        $event = new UserCreated(
            name: 'john',
            email: 'john@doe.com',
            password: 'password',
            upei_id: '43123',
            phone: '2332413124321',
            role: RolesEnum::USER,
            incident_id: $incident->id
        );

        $event->handle();

        $this->assertDatabaseCount('users', 2);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);
    }

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
