<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

// Import the User model

class IncidentModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations before each test
        $this->artisan('migrate');
    }

    #[Test]
    public function it_creates_an_incident_with_valid_attributes()
    {
        // Arrange: Create a user and then create an incident using the factory
        $user = User::factory()->create(); // Create a user
        $incident = Incident::factory()->create([
            'user_id' => $user->id, // Assign the created user's ID
        ]);

        // Assert: Check if the incident has the required attributes
        $this->assertNotNull($incident->user_id);
        $this->assertNotNull($incident->incident_date);
        $this->assertNotNull($incident->location);
        $this->assertNotNull($incident->incident_type);
        $this->assertNotNull($incident->descriptor);
        $this->assertNotNull($incident->description);
    }

    #[Test]
    public function it_has_default_completed_value_as_false()
    {
        // Arrange: Create a user and then create an incident using the factory
        $user = User::factory()->create(); // Create a user
        $incident = Incident::factory()->create([
            'user_id' => $user->id, // Assign the created user's ID
        ]);

        // Assert: Check if the completed attribute is false by default
        $this->assertFalse($incident->completed);
    }

    #[Test]
    public function it_creates_incident_with_boolean_work_related()
    {
        // Arrange: Create a user and then create an incident using the factory
        $user = User::factory()->create(); // Create a user
        $incident = Incident::factory()->create([
            'user_id' => $user->id, // Assign the created user's ID
        ]);

        // Assert: Check if the work_related attribute is a boolean
        $this->assertIsBool($incident->work_related);
    }

    #[Test]
    public function it_creates_incident_with_boolean_has_injury()
    {
        // Arrange: Create a user and then create an incident using the factory
        $user = User::factory()->create(); // Create a user
        $incident = Incident::factory()->create([
            'user_id' => $user->id, // Assign the created user's ID
        ]);

        // Assert: Check if the has_injury attribute is a boolean
        $this->assertIsBool($incident->has_injury);
    }

    #[Test]
    public function it_creates_incident_with_non_empty_description()
    {
        // Arrange: Create a user and then create an incident using the factory
        $user = User::factory()->create(); // Create a user
        $incident = Incident::factory()->create([
            'user_id' => $user->id, // Assign the created user's ID
        ]);

        // Assert: Check if the description attribute is a non-empty string
        $this->assertIsString($incident->description);
        $this->assertNotEmpty($incident->description);
    }
}
