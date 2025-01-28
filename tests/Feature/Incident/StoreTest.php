<?php

namespace Tests\Feature\Incident;

use App\Data\IncidentData;
use App\Enum\CommentType;
use App\Enum\IncidentType;
use App\Models\Incident;
use App\States\IncidentStatus\Opened;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_adds_created_comment()
    {
        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => true,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => '123A',
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

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::INFO, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_redirects_to_show_page(): void
    {
        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => '123A',
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

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $response->assertRedirectToRoute('incidents.show', ['incident' => $incident->id]);
    }

    public function test_throws_validation_error_for_bad_data(): void
    {
        $incidentData = [
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => '',
            'work_related' => true,
            'happened_at' => now(),
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
        $incidentData = IncidentData::from([
            'anonymous' => true,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => null,
            'first_name' => null,
            'upei_id' => null,
            'email' => null,
            'phone' => null,
            'work_related' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => null,
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

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertTrue($incident->anonymous);
        $this->assertFalse($incident->on_behalf);
        $this->assertFalse($incident->on_behalf_anonymous);

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
        $this->assertNull($incident->witnesses);
        $this->assertEquals($incidentData->incident_type, $incident->incident_type);
        $this->assertEquals($incidentData->descriptor, $incident->descriptor);
        $this->assertEquals($incidentData->description, $incident->description);
        $this->assertNull($incident->injury_description);
        $this->assertNull($incident->first_aid_description);
        $this->assertNull($incident->reporters_email);
        $this->assertNull($incident->supervisor_name);
        $this->assertNull($incident->closed_at);
        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_stores_incident_with_open_status(): void
    {
        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => '123A',
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

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertNotNull($incident->status);
        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_stores_incident(): void
    {
        $incidentData = IncidentData::from([
            'anonymous' => false,
            'on_behalf' => true,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'last_name' => 'last',
            'first_name' => 'first',
            'upei_id' => '322',
            'email' => 'john@doe.com',
            'phone' => '(902) 333-4444',
            'work_related' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => '123A',
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

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertFalse($incident->anonymous);
        $this->assertTrue($incident->on_behalf);
        $this->assertFalse($incident->on_behalf_anonymous);

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
        $this->assertEquals($incidentData->witnesses, $incident->witnesses);
        $this->assertEquals($incidentData->incident_type, $incident->incident_type);
        $this->assertEquals($incidentData->descriptor, $incident->descriptor);
        $this->assertEquals($incidentData->description, $incident->description);
        $this->assertEquals($incidentData->injury_description, $incident->injury_description);
        $this->assertEquals($incidentData->first_aid_description, $incident->first_aid_description);
        $this->assertEquals($incidentData->reporters_email, $incident->reporters_email);
        $this->assertEquals($incidentData->supervisor_name, $incident->supervisor_name);
        $this->assertNull($incident->closed_at);
        $this->assertEquals(Opened::class, $incident->status::class);
    }
}
