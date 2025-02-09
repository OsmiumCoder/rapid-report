<?php

namespace Tests\Unit\Models;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use Tests\TestCase;

class IncidentTest extends TestCase
{
    public function test_incident_has_one_supervisor_relation()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_incident_has_many_investigation_relation()
    {
        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $this->assertCount(1, $incident->investigations);

        $this->assertEquals($investigation->id, $incident->investigations->first()->id);
    }

    public function test_incident_filter()
    {
        Incident::factory()->count(2)->create([
            'descriptor' => 'a',
        ]);

        Incident::factory()->create([
            'descriptor' => 'b',
        ]);

        $this->assertDatabaseCount('incidents', 3);

        $filters = [
            0 => [
                'column' => 'descriptor',
                'value' => 'a',
                'comparator' => '=',
            ],
        ];

        $incidents = Incident::filter($filters)->get();

        $this->assertCount(2, $incidents);

        $incidents->each(fn ($incident) => $this->assertEquals('a', $incident->descriptor));
    }

    public function test_incident_sort_method_sorts_by_first_name_then_last_name()
    {
        Incident::factory()->create([
            'first_name' => 'a',
            'last_name' => 'a',
        ]);

        Incident::factory()->create([
            'first_name' => 'a',
            'last_name' => 'b',
        ]);

        Incident::factory()->create([
            'first_name' => 'b',
            'last_name' => 'a',
        ]);

        $this->assertDatabaseCount('incidents', 3);

        $incidents = Incident::sort('name', 'asc')->get();

        $this->assertEquals(3, $incidents->count());

        $this->assertEquals('a', $incidents[0]->first_name);
        $this->assertEquals('a', $incidents[0]->last_name);

        $this->assertEquals('a', $incidents[1]->first_name);
        $this->assertEquals('b', $incidents[1]->last_name);

        $this->assertEquals('b', $incidents[2]->first_name);
        $this->assertEquals('a', $incidents[2]->last_name);
    }

    public function test_incident_sort_method()
    {
        Incident::factory()->create([
            'descriptor' => 'c',
        ]);

        Incident::factory()->create([
            'descriptor' => 'a',
        ]);

        Incident::factory()->create([
            'descriptor' => 'b',
        ]);

        $this->assertDatabaseCount('incidents', 3);

        $incidents = Incident::sort('descriptor', 'asc')->get();

        $this->assertEquals(3, $incidents->count());
        $this->assertEquals('a', $incidents->first()->descriptor);
    }

    public function test_incident_with_assigned_supervisor_returns_supervisor_user()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $this->assertEquals($supervisor->id, $incident->supervisor->id);
        $this->assertInstanceOf(User::class, $incident->supervisor);

    }

    public function test_creates_an_incident_model_with_valid_attributes()
    {
        $incident = Incident::factory()->create();

        $this->assertFalse($incident->anonymous);
        $this->assertFalse($incident->on_behalf);
        $this->assertFalse($incident->on_behalf_anonymous);

        $this->assertNotNull($incident->role);
        $this->assertNotNull($incident->last_name);
        $this->assertNotNull($incident->first_name);
        $this->assertNotNull($incident->email);
        $this->assertNotNull($incident->phone);
        $this->assertNotNull($incident->work_related);
        $this->assertNotNull($incident->happened_at);
        $this->assertNotNull($incident->location);
        $this->assertNotNull($incident->incident_type);
        $this->assertNotNull($incident->descriptor);
        $this->assertNotNull($incident->description);
        $this->assertNotNull($incident->status);

        $this->assertNotNull($incident->room_number);
        $this->assertNotNull($incident->witnesses);
        $this->assertNotNull($incident->injury_description);
        $this->assertNotNull($incident->first_aid_description);
        $this->assertNotNull($incident->workers_comp_submitted);
        $this->assertNull($incident->reporters_email);
        $this->assertNull($incident->supervisor_name);
        $this->assertNull($incident->closed_at);
    }
}
