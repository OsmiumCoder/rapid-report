<?php

namespace Tests\Unit\Aggregates;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\CommentData;
use App\Data\IncidentData;
use App\Enum\CommentType;
use App\Enum\IncidentType;
use App\Exceptions\UserNotSupervisorException;
use App\Mail\IncidentReceived;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentSubmitted;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\Comment\CommentCreated;
use App\StorableEvents\Incident\IncidentClosed;
use App\StorableEvents\Incident\IncidentCreated;
use App\StorableEvents\Incident\IncidentReopened;
use App\StorableEvents\Incident\SupervisorAssigned;
use App\StorableEvents\Incident\SupervisorUnassigned;
use App\StorableEvents\Investigation\InvestigationReturned;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class IncidentAggregateRootTest extends TestCase
{
    public function test_sets_returned_status()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->returnInvestigation()
            ->persist();

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }

    public function test_adds_returned_comment()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->returnInvestigation()
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('returned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_fires_investigation_returned_event()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->returnInvestigation();
            })
            ->assertRecorded([
                new InvestigationReturned,
            ]);
    }

    public function test_adds_reopened_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->reopenIncident()
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('reopened', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_adds_closed_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('closed', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_adds_unassigned_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->unassignSupervisor()
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('unassigned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_throws_user_not_supervisor_if_id_not_supervisor()
    {
        $this->expectException(UserNotSupervisorException::class);

        $notSupervisor = User::factory()->create()->syncRoles('admin');

        $incident = Incident::factory()->create();

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($notSupervisor->id)
            ->persist();
    }

    public function test_adds_assigned_comment_on_supervisor_assigned()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create();

        $this->assertCount(0, $incident->comments);

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($supervisor->id)
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('assigned', $comment->content);
        $this->assertStringContainsStringIgnoringCase('supervisor', $comment->content);
        $this->assertStringContainsStringIgnoringCase($supervisor->name, $comment->content);
    }

    public function test_add_comment_adds_comment_to_model()
    {
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

    public function test_closed_incident_event_fired()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->given([])
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->closeIncident();
            })
            ->assertRecorded([
                new IncidentClosed,
            ]);
    }

    public function test_close_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        $incident->refresh();

        $this->assertEquals($supervisor->id, $incident->supervisor_id);

        $this->assertEquals(Closed::class, $incident->status::class);
    }

    public function test_reopened_incident_event_fired()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->given([])
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->reopenIncident();
            })
            ->assertRecorded([
                new IncidentReopened,
            ]);
    }

    public function test_reopen_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->reopenIncident()
            ->persist();

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);

        $this->assertEquals(Reopened::class, $incident->status::class);
    }

    public function test_unassigned_supervisor_event_fired()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->given([])
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->unassignSupervisor();
            })
            ->assertRecorded([
                new SupervisorUnassigned,
            ]);
    }

    public function test_unassign_supervisor_from_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->unassignSupervisor()
            ->persist();

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);

        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_assigned_supervisor_event_fired()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
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
        $supervisor = User::factory()->create()->syncRoles('supervisor');

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
            'workers_comp_submitted' => true,
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

        $this->assertEquals(CommentType::ACTION, $comment->type);
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
            'workers_comp_submitted' => true,
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
                    workers_comp_submitted: $incidentData->workers_comp_submitted,
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
            'workers_comp_submitted' => true,
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
            'workers_comp_submitted' => true,
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
        $this->assertEquals($incidentData->workers_comp_submitted, $incident->workers_comp_submitted);
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

    public function test_create_incident_sends_mail_on_reporters_email_set(): void
    {
        Mail::fake();
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $user = User::factory()->create()->syncRoles('user');

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
            'workers_comp_submitted' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => '123A',
            'witnesses' => [],
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => $user->email,
            'supervisor_name' => 'John Doe',
        ]);

        $uuid = Str::uuid()->toString();

        Mail::assertNothingSent();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        Mail::assertSentCount(1);
        Mail::assertSent(IncidentReceived::class, 1);
        Mail::assertSent(IncidentReceived::class, $user->email);

        Notification::assertSentTo($admins, IncidentSubmitted::class);
        Notification::assertNotSentTo($user, IncidentSubmitted::class);
    }

    public function test_create_incident_sends_no_mail_on_reporters_email_not_set(): void
    {
        Mail::fake();
        Notification::fake();

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
            'workers_comp_submitted' => true,
            'happened_at' => now(),
            'location' => 'Building A',
            'room_number' => '123A',
            'witnesses' => [],
            'incident_type' => IncidentType::SAFETY,
            'descriptor' => 'Burn',
            'description' => 'A fire broke out in the room.',
            'injury_description' => 'Minor burn',
            'first_aid_description' => 'Minor burn treated',
            'reporters_email' => null,
            'supervisor_name' => 'John Doe',
        ]);

        $uuid = Str::uuid()->toString();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        Mail::assertNothingSent();
    }

    public function test_create_incident_notifies_admin_team(): void
    {
        Mail::fake();
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

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
            'workers_comp_submitted' => true,
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

        $uuid = Str::uuid()->toString();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->createIncident($incidentData)
            ->persist();

        Notification::assertSentTo($admins, IncidentSubmitted::class);
    }
}
