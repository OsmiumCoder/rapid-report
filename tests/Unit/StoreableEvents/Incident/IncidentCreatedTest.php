<?php

namespace StoreableEvents\Incident;

use App\Enum\CommentType;
use App\Enum\IncidentType;
use App\Mail\IncidentReceived;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\IncidentSubmitted;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\Incident\IncidentCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class IncidentCreatedTest extends TestCase
{
    public function test_adds_created_comment()
    {
        Carbon::setTestNow('2024-05-01 12:12:00');

        $event = new IncidentCreated(
            anonymous: false,
            on_behalf: false,
            on_behalf_anonymous: false,
            role: '0',
            last_name: 'last',
            first_name: 'first',
            upei_id: '322',
            email: 'john@doe.com',
            phone: '(902) 333-4444',
            work_related: true,
            workers_comp_submitted: true,
            happened_at: now(),
            location: 'Building A',
            room_number: '123A',
            witnesses: [],
            incident_type: IncidentType::SAFETY,
            descriptor: 'Burn',
            description: 'A fire broke out in the room.',
            injury_description: 'Minor burn',
            first_aid_description: 'Minor burn treated',
            reporters_email: 'jane@doe.com',
            supervisor_name: 'John Doe',
        );

        $this->assertDatabaseCount('incidents', 0);

        $event->handle();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_creates_new_incident(): void
    {
        Carbon::setTestNow('2024-05-01 12:12:00');

        $event = new IncidentCreated(
            anonymous: false,
            on_behalf: false,
            on_behalf_anonymous: false,
            role: '0',
            last_name: 'last',
            first_name: 'first',
            upei_id: '322',
            email: 'john@doe.com',
            phone: '(902) 333-4444',
            work_related: true,
            workers_comp_submitted: true,
            happened_at: now(),
            location: 'Building A',
            room_number: '123A',
            witnesses: [],
            incident_type: IncidentType::SAFETY,
            descriptor: 'Burn',
            description: 'A fire broke out in the room.',
            injury_description: 'Minor burn',
            first_aid_description: 'Minor burn treated',
            reporters_email: 'jane@doe.com',
            supervisor_name: 'John Doe',
        );

        $this->assertDatabaseCount('incidents', 0);

        $event->handle();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertFalse($incident->anonymous);
        $this->assertFalse($incident->on_behalf);
        $this->assertFalse($incident->on_behalf_anonymous);
        $this->assertEquals($event->role, $incident->role);
        $this->assertEquals($event->last_name, $incident->last_name);
        $this->assertEquals($event->first_name, $incident->first_name);
        $this->assertEquals($event->upei_id, $incident->upei_id);
        $this->assertEquals($event->email, $incident->email);
        $this->assertEquals($event->phone, $incident->phone);
        $this->assertTrue($event->work_related, $incident->work_related);
        $this->assertTrue($event->workers_comp_submitted, $incident->workers_comp_submitted);
        $this->assertEquals($event->happened_at, $incident->happened_at);
        $this->assertEquals($event->location, $incident->location);
        $this->assertEquals($event->room_number, $incident->room_number);
        $this->assertEquals($event->witnesses, $incident->witnesses);
        $this->assertEquals($event->incident_type, $incident->incident_type);
        $this->assertEquals($event->descriptor, $incident->descriptor);
        $this->assertEquals($event->description, $incident->description);
        $this->assertEquals($event->injury_description, $incident->injury_description);
        $this->assertEquals($event->first_aid_description, $incident->first_aid_description);
        $this->assertEquals($event->reporters_email, $incident->reporters_email);
        $this->assertEquals($event->supervisor_name, $incident->supervisor_name);
        $this->assertNull($incident->closed_at);
        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_creates_new_incident_anonymous(): void
    {
        Carbon::setTestNow('2024-05-01 12:12:00');

        $event = new IncidentCreated(
            anonymous: true,
            on_behalf: false,
            on_behalf_anonymous: false,
            role: '0',
            last_name: null,
            first_name: null,
            upei_id: null,
            email: null,
            phone: null,
            work_related: true,
            workers_comp_submitted: true,
            happened_at: now(),
            location: 'Building A',
            room_number: null,
            witnesses: null,
            incident_type: IncidentType::SAFETY,
            descriptor: 'Burn',
            description: 'A fire broke out in the room.',
            injury_description: null,
            first_aid_description: null,
            reporters_email: null,
            supervisor_name: null,
        );

        $this->assertDatabaseCount('incidents', 0);

        $event->handle();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertTrue($incident->anonymous);
        $this->assertFalse($incident->on_behalf);
        $this->assertFalse($incident->on_behalf_anonymous);
        $this->assertEquals($event->role, $incident->role);
        $this->assertNull($incident->last_name);
        $this->assertNull($incident->first_name);
        $this->assertNull($incident->upei_id);
        $this->assertNull($incident->email);
        $this->assertNull($incident->phone);
        $this->assertEquals($event->work_related, $incident->work_related);
        $this->assertTrue($event->workers_comp_submitted, $incident->workers_comp_submitted);
        $this->assertEquals($event->happened_at, $incident->happened_at);
        $this->assertEquals($event->location, $incident->location);
        $this->assertNull($incident->room_number);
        $this->assertNull($incident->witnesses);
        $this->assertEquals($event->incident_type, $incident->incident_type);
        $this->assertEquals($event->descriptor, $incident->descriptor);
        $this->assertEquals($event->description, $incident->description);
        $this->assertNull($incident->injury_description);
        $this->assertNull($incident->first_aid_description);
        $this->assertNull($incident->reporters_email);
        $this->assertNull($incident->supervisor_name);
        $this->assertNull($incident->closed_at);
        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_new_incident_notifies_reporter_if_reporters_email_set(): void
    {
        Mail::fake();
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->assignRole('admin');
        });
        $user = User::factory()->create()->assignRole('user');

        $event = new IncidentCreated(
            anonymous: false,
            on_behalf: false,
            on_behalf_anonymous: false,
            role: '0',
            last_name: null,
            first_name: null,
            upei_id: null,
            email: null,
            phone: null,
            work_related: true,
            workers_comp_submitted: true,
            happened_at: now(),
            location: 'Building A',
            room_number: null,
            witnesses: null,
            incident_type: IncidentType::SAFETY,
            descriptor: 'Burn',
            description: 'A fire broke out in the room.',
            injury_description: null,
            first_aid_description: null,
            reporters_email: $user->email,
            supervisor_name: null,
        );

        Mail::assertNothingSent();

        $event->react();

        Mail::assertSentCount(1);
        Mail::assertSent(IncidentReceived::class, 1);
        Mail::assertSent(IncidentReceived::class, $user->email);

        Notification::assertSentTo($admins, IncidentSubmitted::class);
        Notification::assertNotSentTo($user, IncidentSubmitted::class);
    }

    public function test_new_incident_does_not_notify_reporter_if_reporters_email_not_set(): void
    {
        Mail::fake();
        Notification::fake();

        $event = new IncidentCreated(
            anonymous: false,
            on_behalf: false,
            on_behalf_anonymous: false,
            role: '0',
            last_name: null,
            first_name: null,
            upei_id: null,
            email: null,
            phone: null,
            work_related: true,
            workers_comp_submitted: true,
            happened_at: now(),
            location: 'Building A',
            room_number: null,
            witnesses: null,
            incident_type: IncidentType::SAFETY,
            descriptor: 'Burn',
            description: 'A fire broke out in the room.',
            injury_description: null,
            first_aid_description: null,
            reporters_email: null,
            supervisor_name: null,
        );

        $event->react();

        Mail::assertNothingSent();
    }

    public function test_new_incident_notifies_admin_team(): void
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->assignRole('admin');
        });
        $user = User::factory()->create()->assignRole('user');

        $event = new IncidentCreated(
            anonymous: false,
            on_behalf: false,
            on_behalf_anonymous: false,
            role: '0',
            last_name: null,
            first_name: null,
            upei_id: null,
            email: null,
            phone: null,
            work_related: true,
            workers_comp_submitted: true,
            happened_at: now(),
            location: 'Building A',
            room_number: null,
            witnesses: null,
            incident_type: IncidentType::SAFETY,
            descriptor: 'Burn',
            description: 'A fire broke out in the room.',
            injury_description: null,
            first_aid_description: null,
            reporters_email: $user->email,
            supervisor_name: null,
        );

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);

        Notification::assertSentTo($admins, IncidentSubmitted::class);
        Notification::assertNotSentTo($user, IncidentSubmitted::class);
    }
}
