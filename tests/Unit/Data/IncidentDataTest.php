<?php

namespace Tests\Unit\Data;

use App\Data\IncidentData;
use App\Enum\IncidentType;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class IncidentDataTest extends TestCase
{
    public function test_incident_data_valid_with_correct_values(): void
    {
        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        $incidentData = IncidentData::validateAndCreate([
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
            'workers_comp_submitted' => true,
            'happened_at' => $incidentDate,
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

        $this->assertInstanceOf(IncidentData::class, $incidentData);
    }

    public function test_incident_data_throws_invalid_with_incorrect_values(): void
    {
        $this->expectException(ValidationException::class);

        Carbon::setTestNow('2025-01-24');

        $incidentDate = now();

        IncidentData::validateAndCreate([
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => 0,
            'work_related' => true,
            'workers_comp_submitted' => true,
            'happened_at' => $incidentDate,
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => '',
        ]);
    }
}
