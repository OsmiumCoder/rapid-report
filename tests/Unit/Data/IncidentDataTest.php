<?php

namespace Tests\Unit\Data;

use App\Data\IncidentData;
use Carbon\Carbon;
use Tests\TestCase;

class IncidentDataTest extends TestCase
{
    public function test_creates_an_incident_data_instance_with_correct_values(): void
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
            'incident_type' => 0,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => 'jane@doe.com',
            'supervisor_name' => 'John Doe',
        ]);

        $this->assertEquals(0, $incidentData->role);
        $this->assertEquals('last', $incidentData->last_name);
        $this->assertEquals('first', $incidentData->first_name);
        $this->assertEquals('322', $incidentData->upei_id);
        $this->assertEquals('john@doe.com', $incidentData->email);
        $this->assertEquals('(902) 333-4444', $incidentData->phone);
        $this->assertTrue($incidentData->work_related);
        $this->assertEquals($incidentDate, $incidentData->happened_at);
        $this->assertEquals('Building A', $incidentData->location);
        $this->assertEquals('123A', $incidentData->room_number);
        $this->assertEquals('John Doe', $incidentData->reported_to);
        $this->assertCount(0, $incidentData->witnesses);
        $this->assertEquals(0, $incidentData->incident_type);
        $this->assertEquals('Burn', $incidentData->descriptor);
        $this->assertEquals('A fire broke out in the room.', $incidentData->description);
        $this->assertNotEmpty($incidentData->injury_description);
        $this->assertEquals('Minor burn treated', $incidentData->first_aid_description);
        $this->assertEquals('jane@doe.com', $incidentData->reporters_email);
        $this->assertEquals('John Doe', $incidentData->supervisor_name);
    }
}
