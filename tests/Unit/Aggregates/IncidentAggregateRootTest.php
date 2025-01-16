<?php

namespace Tests\Unit\Aggregates;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\IncidentData;
use App\Enum\IncidentStatus;
use App\Models\Incident;
use App\StorableEvents\Incident\IncidentCreated;
use Illuminate\Support\Str;
use Tests\TestCase;

class IncidentAggregateRootTest extends TestCase
{
    public function test_fires_incident_created_event()
    {
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
            'incident_type' => 0,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        IncidentAggregateRoot::fake(Str::uuid()->toString())
            ->given([])
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot) use ($incidentData): void {
                $incidentAggregateRoot->createIncident($incidentData);
            })
            ->assertRecorded([
                new IncidentCreated(
                    role: $incidentData->role,
                    last_name: $incidentData->last_name,
                    first_name: $incidentData->first_name,
                    upei_id: $incidentData->upei_id,
                    email: $incidentData->email,
                    phone: $incidentData->phone,
                    work_related: $incidentData->work_related,
                    happened_at: $incidentData->happened_at,
                    location: $incidentData->location,
                    room_number: $incidentData->room_number,
                    reported_to: $incidentData->reported_to,
                    witnesses: $incidentData->witnesses,
                    incident_type: $incidentData->incident_type,
                    descriptor: $incidentData->descriptor,
                    description: $incidentData->description,
                    injury_description: $incidentData->injury_description,
                    first_aid_description: $incidentData->first_aid_description,
                    reporters_email: $incidentData->reporters_email,
                    supervisor_name: $incidentData->supervisor_name,
                    status: IncidentStatus::OPEN
                )
            ]);
    }

    public function test_incident_uuid_is_aggregate_uuid()
    {
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
            'incident_type' => 0,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        $this->assertDatabaseCount('incidents', 0);

        $uuid = Str::uuid()->toString();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertEquals($aggregate->uuid(), $incident->id);
    }

    public function test_stores_incident()
    {
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
            'incident_type' => 0,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        $this->assertDatabaseCount('incidents', 0);

        $uuid = Str::uuid()->toString();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertEquals($aggregate->uuid(), $incident->id);
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
