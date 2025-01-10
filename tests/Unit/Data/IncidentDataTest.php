<?php

namespace Tests\Unit\Data;

use App\Data\IncidentData;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase;

class IncidentDataTest extends TestCase
{
    public function test_creates_an_incident_data_instance_with_correct_values(): void
    {
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $witnesses = [$user, $supervisor];

        $incidentDate = now();

        $incidentData = IncidentData::from([
            'user_id' => 1,
            'supervisor_id' => 2,
            'location' => 'Building A',
            'room_number' => '123A',
            'reported_to' => 'John Doe',
            'incident_type' => 'Fire',
            'descriptor' => 'Burn',
            'witnesses' => $witnesses,
            'description' => 'A fire broke out in the room.',
            'has_injury' => true,
            'first_aid_description' => 'Minor burn treated with ointment',
            'incident_date' => $incidentDate,
            'work_related' => false,
            'status' => 0,
        ]);

        $this->assertEquals(1, $incidentData->user_id);
        $this->assertEquals(2, $incidentData->supervisor_id);
        $this->assertEquals('Building A', $incidentData->location);
        $this->assertEquals('123A', $incidentData->room_number);
        $this->assertEquals('John Doe', $incidentData->reported_to);
        $this->assertEquals('Fire', $incidentData->incident_type);
        $this->assertEquals('Burn', $incidentData->descriptor);
        $this->assertCount(2, $incidentData->witnesses);
        $this->assertEquals('A fire broke out in the room.', $incidentData->description);
        $this->assertTrue($incidentData->has_injury);
        $this->assertEquals('Minor burn treated with ointment', $incidentData->first_aid_description);
        $this->assertInstanceOf(Carbon::class, $incidentData->incident_date);
        $this->assertFalse($incidentData->work_related);
        $this->assertEquals(0, $incidentData->status);
    }
}
