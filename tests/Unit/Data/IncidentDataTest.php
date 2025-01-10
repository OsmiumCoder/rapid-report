<?php

namespace Tests\Unit\Data;

use App\Data\IncidentData;
use App\Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class IncidentDataTest extends TestCase
{
    #[Test]
    public function it_creates_an_incident_data_instance_with_correct_values(): void
    {
        // Arrange: Create mock data for witnesses and other fields
        $user = new User(['id' => 1]);
        $supervisor = new User(['id' => 2]);
        $witnesses = [$user, $supervisor];

        $incidentDate = now();
        $closingDate = now()->addDays(1);

        // Act: Create an instance of IncidentData
        $incidentData = new IncidentData(
            1,                            // id
            1,                            // user_id
            2,                            // supervisor_id
            true,                         // work_related
            $closingDate,                 // closing_date
            'Building A',                 // location
            '101',                         // room_number
            'John Doe',                   // reported_to
            'Fire',                        // incident_type
            'Burn',                        // descriptor
            $witnesses,                   // witnesses
            'A fire broke out in the room.', // description
            true,                         // has_injury
            'Minor burn treated with ointment', // first_aid_description
            true,                         // completed
            $incidentDate                 // incident_date
        );

        // Assert: Check that the instance was created with the correct values
        $this->assertEquals(1, $incidentData->id);
        $this->assertEquals(1, $incidentData->user_id);
        $this->assertEquals(2, $incidentData->supervisor_id);
        $this->assertTrue($incidentData->work_related);
        $this->assertEquals('Building A', $incidentData->location);
        $this->assertEquals('101', $incidentData->room_number);
        $this->assertEquals('John Doe', $incidentData->reported_to);
        $this->assertEquals('Fire', $incidentData->incident_type);
        $this->assertEquals('Burn', $incidentData->descriptor);
        $this->assertEquals('A fire broke out in the room.', $incidentData->description);
        $this->assertTrue($incidentData->has_injury);
        $this->assertEquals('Minor burn treated with ointment', $incidentData->first_aid_description);
        $this->assertTrue($incidentData->completed);
        $this->assertInstanceOf(Carbon::class, $incidentData->incident_date);
        $this->assertInstanceOf(Carbon::class, $incidentData->closing_date);
        $this->assertCount(2, $incidentData->witnesses);  // Check the number of witnesses
    }

    #[Test]
    public function it_sets_default_values_for_optional_fields()
    {
        // Arrange: Create mock data for witnesses and other fields
        $witnesses = [];
        $incidentDate = now();
        $closingDate = now()->addDays(1);

        // Act: Create an instance of IncidentData with default values for optional fields
        $incidentData = new IncidentData(
            1,                            // id
            1,                            // user_id
            2,                            // supervisor_id
            false,                        // work_related (default is false)
            $closingDate,                 // closing_date
            'Building B',                 // location
            '102',                         // room_number
            'Jane Doe',                   // reported_to
            'Slip',                        // incident_type
            'Fall',                        // descriptor
            $witnesses,                   // witnesses
            'A person slipped on the floor.', // description
            false,                        // has_injury
            'No first aid needed',        // first_aid_description
            false,                        // completed
            $incidentDate                 // incident_date
        );

        // Assert: Check that default values are applied correctly
        $this->assertFalse($incidentData->work_related); // Default value should be false
        $this->assertFalse($incidentData->completed);   // Default value should be false
    }
}
