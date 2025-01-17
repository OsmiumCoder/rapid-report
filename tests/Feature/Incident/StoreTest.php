<?php

namespace Tests\Feature\Incident;

use App\Data\IncidentData;
use App\Enum\IncidentStatus;
use App\Enum\IncidentType;
use App\Models\Incident;
use App\StorableEvents\Incident\IncidentCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_fires_incident_created_event(): void
    {
        Event::fake();

        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        $incidentData = IncidentData::from([
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => $incidentDate,
            'location' => 'Building A',
            'room_number' => '123A',
            'reported_to' => 'John Doe',
            'witnesses' => [],
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        $this->assertDatabaseCount('incidents', 0);

        $response = $this->post(route('incidents.store'), $incidentData->toArray());

        $response->assertRedirect(route('dashboard'));

        Event::assertDispatched(function (IncidentCreated $event) use ($incidentData) {
            $this->assertEquals($event->role, $incidentData->role);
            $this->assertEquals($event->last_name, $incidentData->last_name);
            $this->assertEquals($event->first_name, $incidentData->first_name);
            $this->assertEquals($event->upei_id, $incidentData->upei_id);
            $this->assertEquals($event->email, $incidentData->email);
            $this->assertEquals($event->phone, $incidentData->phone);
            $this->assertEquals($event->work_related, $incidentData->work_related);
            $this->assertEquals($event->happened_at, $incidentData->happened_at);
            $this->assertEquals($event->location, $incidentData->location);
            $this->assertEquals($event->room_number, $incidentData->room_number);
            $this->assertEquals($event->reported_to, $incidentData->reported_to);
            $this->assertEquals($event->witnesses, $incidentData->witnesses);
            $this->assertEquals($event->incident_type, $incidentData->incident_type);
            $this->assertEquals($event->descriptor, $incidentData->descriptor);
            $this->assertEquals($event->description, $incidentData->description);
            $this->assertEquals($event->injury_description, $incidentData->injury_description);
            $this->assertEquals($event->first_aid_description, $incidentData->first_aid_description);
            $this->assertEquals($event->reporters_email, $incidentData->reporters_email);
            $this->assertEquals($event->supervisor_name, $incidentData->supervisor_name);
            $this->assertEquals(IncidentStatus::OPEN, $event->status);

            return true;
        });

    }

    public function test_throws_validation_error_for_bad_data(): void
    {
        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        $incidentData = [
            'role' => '',
            'work_related' => true,
            'happened_at' => $incidentDate,
            'location' => '',
            'incident_type' => '',
            'descriptor' => '',
            'description' => '',
        ];

        $response = $this->post(route('incidents.store'), $incidentData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);

        $response->assertInvalid([
            'role',
            'location',
            'incident_type',
            'descriptor',
            'description',
        ]);

    }

    public function test_stores_anonymous_incident(): void
    {
        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        $incidentData = IncidentData::from([
            'role' => 0,
            'last_name' => null,
            'first_name' => null,
            'upei_id' => null,
            'email' => null,
            'phone' => null,
            'work_related' => true,
            'happened_at' => $incidentDate,
            'location' => 'Building A',
            'room_number' => null,
            'reported_to' => null,
            'witnesses' => null,
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => null,
            'first_aid_description' => null,
            'reporters_email' => null,
            'supervisor_name' => null,
        ]);

        $this->assertDatabaseCount('incidents', 0);

        $response = $this->post(route('incidents.store'), $incidentData->toArray());

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertEquals($incidentData->role, $incident->role);
        $this->assertNull($incident->last_name);
        $this->assertNull($incident->first_name);
        $this->assertNull($incident->upei_id);
        $this->assertNull($incident->email);
        $this->assertNull($incident->phone);
        $this->assertEquals($incidentData->work_related, $incident->work_related);
        $this->assertEquals($incidentData->happened_at, $incident->happened_at);
        $this->assertEquals($incidentData->location, $incident->location);
        $this->assertNull($incident->room_number);
        $this->assertNull($incident->reported_to);
        $this->assertNull($incident->witnesses);
        $this->assertEquals($incidentData->incident_type, $incident->incident_type);
        $this->assertEquals($incidentData->descriptor, $incident->descriptor);
        $this->assertEquals($incidentData->description, $incident->description);
        $this->assertNull($incident->injury_description);
        $this->assertNull($incident->first_aid_description);
        $this->assertNull($incident->reporters_email);
        $this->assertNull($incident->supervisor_name);
        $this->assertEquals(IncidentStatus::OPEN, $incident->status);
        $this->assertNull($incident->closed_at);
    }

    public function test_stores_incident_with_open_status(): void
    {
        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        $incidentData = IncidentData::from([
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => $incidentDate,
            'location' => 'Building A',
            'room_number' => '123A',
            'reported_to' => 'John Doe',
            'witnesses' => [],
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        $this->assertDatabaseCount('incidents', 0);

        $response = $this->post(route('incidents.store'), $incidentData->toArray());

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertEquals(IncidentStatus::OPEN, $incident->status);
    }

    public function test_stores_incident(): void
    {
        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        $incidentData = IncidentData::from([
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => $incidentDate,
            'location' => 'Building A',
            'room_number' => '123A',
            'reported_to' => 'John Doe',
            'witnesses' => [],
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        $this->assertDatabaseCount('incidents', 0);

        $response = $this->post(route('incidents.store'), $incidentData->toArray());

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertEquals($incidentData->role, $incident->role);
        $this->assertEquals($incidentData->last_name, $incident->last_name);
        $this->assertEquals($incidentData->first_name, $incident->first_name);
        $this->assertEquals($incidentData->upei_id, $incident->upei_id);
        $this->assertEquals($incidentData->email, $incident->email);
        $this->assertEquals($incidentData->phone, $incident->phone);
        $this->assertEquals($incidentData->work_related, $incident->work_related);
        $this->assertEquals($incidentData->happened_at, $incident->happened_at);
        $this->assertEquals($incidentData->location, $incident->location);
        $this->assertEquals($incidentData->room_number, $incident->room_number);
        $this->assertEquals($incidentData->reported_to, $incident->reported_to);
        $this->assertEquals($incidentData->witnesses, $incident->witnesses);
        $this->assertEquals($incidentData->incident_type, $incident->incident_type);
        $this->assertEquals($incidentData->descriptor, $incident->descriptor);
        $this->assertEquals($incidentData->description, $incident->description);
        $this->assertEquals($incidentData->injury_description, $incident->injury_description);
        $this->assertEquals($incidentData->first_aid_description, $incident->first_aid_description);
        $this->assertEquals($incidentData->reporters_email, $incident->reporters_email);
        $this->assertEquals($incidentData->supervisor_name, $incident->supervisor_name);
        $this->assertEquals(IncidentStatus::OPEN, $incident->status);
        $this->assertNull($incident->closed_at);
    }
}
