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
        // Arrange: Create mock data for witnesses and other fields
        $user = User::factory()->create();
        $supervisor = User::factory()->create();
        $witnesses = [$user, $supervisor];

        $incidentDate = now();
        $closedAt = now()->addDays(1);

        // Act: Create an instance of IncidentData
        $incidentData = new IncidentData(
            1,
            2,
            'Building A',
            '123A',
            'John Doe',
            'Fire',
            'Burn',
            $witnesses,
            'A fire broke out in the room.',
            true,
            'Minor burn treated with ointment',
            $incidentDate,
        );

        // Assert: Check that the instance was created with the correct values
        $this->assertEquals(1, $incidentData->user_id);
        $this->assertEquals(2, $incidentData->supervisor_id);
        $this->assertFalse($incidentData->work_related);
        $this->assertEquals('Building A', $incidentData->location);
        $this->assertEquals('123A', $incidentData->room_number);
        $this->assertEquals('John Doe', $incidentData->reported_to);
        $this->assertEquals('Fire', $incidentData->incident_type);
        $this->assertEquals('Burn', $incidentData->descriptor);
        $this->assertEquals('A fire broke out in the room.', $incidentData->description);
        $this->assertTrue($incidentData->has_injury);
        $this->assertEquals('Minor burn treated with ointment', $incidentData->first_aid_description);
        $this->assertInstanceOf(Carbon::class, $incidentData->incident_date);
        $this->assertCount(2, $incidentData->witnesses);  // Check the number of witnesses
    }
}
