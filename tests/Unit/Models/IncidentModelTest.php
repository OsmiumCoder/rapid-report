<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

// Import the User model

class IncidentModelTest extends TestCase
{
    public function test_creates_an_incident_model_with_valid_attributes()
    {
        $user = User::factory()->create(); // Create a user
        $incident = Incident::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertNotNull($incident->user_id);
        $this->assertNotNull($incident->work_related);
        $this->assertNotNull($incident->incident_date);
        $this->assertNotNull($incident->location);
        $this->assertNotNull($incident->incident_type);
        $this->assertNotNull($incident->descriptor);
        $this->assertNotNull($incident->description);
        $this->assertNotNull($incident->status);
        $this->assertNotNull($incident->has_injury);
    }
}
