<?php

namespace Tests\Unit\Aggregates;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\CommentData;
use App\Data\IncidentData;
use App\Enum\CommentType;
use App\Enum\IncidentType;
use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\Comment\CommentCreated;
use App\StorableEvents\Incident\IncidentCreated;
use App\StorableEvents\Incident\SupervisorAssigned;
use Illuminate\Support\Str;
use Tests\TestCase;

class IncidentAggregateRootTest extends TestCase
{
    public function test_adds_comment_to_model()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create();

        $commentData = CommentData::validateAndCreate([
            'content' => 'comments',
        ]);

        $this->assertDatabaseCount('comments', 0);

        IncidentAggregateRoot::retrieve($incident->id)
            ->addComment($commentData)
            ->persist();

        $this->assertDatabaseCount('comments', 1);

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments()->first();

        $this->assertEquals($commentData->content, $comment->content);
        $this->assertEquals(CommentType::NOTE, $comment->type);
        $this->assertEquals($incident->id, $comment->commentable_id);
        $this->assertEquals(get_class($incident), $comment->commentable_type);
    }

    public function test_comment_created_event_fired()
    {
        $incident = Incident::factory()->create();

        $commentData = CommentData::validateAndCreate([
            'content' => 'comments',
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot) use ($commentData): void {
                $incidentAggregateRoot->addComment($commentData);
            })
            ->assertRecorded([
                new CommentCreated(
                    content: $commentData->content,
                    type: CommentType::NOTE,
                    commentable_id: $incident->id,
                    commentable_type: Incident::class,
                ),
            ]);
    }

    public function test_assigned_supervisor_event_fired()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $incident = Incident::factory()->create();

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot) use ($supervisor): void {
                $incidentAggregateRoot->assignSupervisor($supervisor->id);
            })
            ->assertRecorded([
                new SupervisorAssigned($supervisor->id),
            ]);
    }

    public function test_assign_supervisor_to_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create();

        $this->assertNull($incident->supervisor_id);

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($supervisor->id)
            ->persist();

        $incident->refresh();

        $this->assertEquals($supervisor->id, $incident->supervisor_id);

        $this->assertInstanceOf(User::class, $incident->supervisor);
    }

    public function test_adds_created_comment()
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

        $uuid = Str::uuid()->toString();

        IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::INFO, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);

    }

    public function test_fires_incident_created_event()
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

        IncidentAggregateRoot::fake(Str::uuid()->toString())
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot) use ($incidentData): void {
                $incidentAggregateRoot->createIncident($incidentData);
            })
            ->assertRecorded([
                new IncidentCreated(
                    anonymous: $incidentData->anonymous,
                    on_behalf: $incidentData->on_behalf,
                    on_behalf_anonymous: $incidentData->on_behalf_anonymous,
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
                    witnesses: $incidentData->witnesses,
                    incident_type: $incidentData->incident_type,
                    descriptor: $incidentData->descriptor,
                    description: $incidentData->description,
                    injury_description: $incidentData->injury_description,
                    first_aid_description: $incidentData->first_aid_description,
                    reporters_email: $incidentData->reporters_email,
                    supervisor_name: $incidentData->supervisor_name,
                ),
            ]);
    }

    public function test_incident_uuid_is_aggregate_uuid()
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

        $uuid = Str::uuid()->toString();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        $this->assertDatabaseCount('incidents', 1);

        $incident = Incident::first();

        $this->assertEquals($aggregate->uuid(), $incident->id);
        $this->assertFalse($incident->anonymous);
        $this->assertFalse($incident->on_behalf);
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
