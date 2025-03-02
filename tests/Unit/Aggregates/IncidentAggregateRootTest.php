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
use App\Models\Investigation;
use App\Models\User;
use App\Notifications\Comment\CommentAdded;
use App\Notifications\Incident\AdditionalInformationNotification;
use App\Notifications\Incident\IncidentClosedNotification;
use App\Notifications\Incident\IncidentReopenedNotification;
use App\Notifications\Incident\IncidentReviewRequestNotification;
use App\Notifications\Incident\IncidentSubmittedNotification;
use App\Notifications\Investigation\InvestigationReturnedNotification;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\Comment\CommentCreated;
use App\StorableEvents\Incident\AdditionalInformationAdded;
use App\StorableEvents\Incident\FileCreated;
use App\StorableEvents\Incident\FilesUploaded;
use App\StorableEvents\Incident\IncidentClosed;
use App\StorableEvents\Incident\IncidentCreated;
use App\StorableEvents\Incident\IncidentReopened;
use App\StorableEvents\Incident\IncidentReviewRequested;
use App\StorableEvents\Investigation\InvestigationReturned;
use App\StorableEvents\Incident\SupervisorAssigned;
use App\StorableEvents\Incident\SupervisorUnassigned;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisReturned;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Spatie\ModelStates\Exceptions\TransitionNotFound;
use Tests\TestCase;

class IncidentAggregateRootTest extends TestCase
{
    public function test_uploaded_files_are_stored()
    {
        Storage::fake('public');

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();

        IncidentAggregateRoot::retrieve($incident->id)
            ->uploadFiles([
                UploadedFile::fake()->image('file.jpg')->size(100),
                UploadedFile::fake()->create('file.pdf')->size(100)
            ])
            ->persist();

        Storage::assertCount('/'.$incident->id, 2);
    }

    public function test_upload_files_fires_file_upload_events()
    {
        Storage::fake('public');

        $incident = Incident::factory()->create();

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot) use ($incident): void {
                $incidentAggregateRoot->uploadFiles([
                    UploadedFile::fake()->create('file.pdf')->size(100)
                ]);
            })
            ->assertRecorded(function (ShouldBeStored $event) use ($incident) {
                if ($event instanceof FileCreated) {
                    $this->assertEquals('file.pdf', $event->original_name);
                    $this->assertEquals($incident->id, $event->path);
                    $this->assertEquals('102400', $event->size);
                    $this->assertEquals('application/pdf', $event->mime_type);
                    $this->assertEquals('pdf', $event->extension);
                    $this->assertEquals($incident->id, $event->fileable_id);
                    $this->assertEquals(Incident::class, $event->fileable_type);
                    return true;
                } elseif ($event instanceof FilesUploaded) {
                    $this->assertInstanceOf(FilesUploaded::class, $event);
                    return true;
                }

                return false;
            });
    }

    public function test_add_additional_information_fires_add_additional_information_event()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->addAdditionalInformation('info');
            })
            ->assertRecorded([
                new AdditionalInformationAdded(
                    additionalInformation: 'info'
                ),
            ]);
    }

    public function test_request_review_fires_incident_review_requested_event()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->requestReview();
            })
            ->assertRecorded([
                new IncidentReviewRequested,
            ]);
    }

    public function test_return_rca_fires_rca_returned_event()
    {
        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::fake($incident->id)
            ->when(function (IncidentAggregateRoot $incidentAggregateRoot): void {
                $incidentAggregateRoot->returnRCA();
            })
            ->assertRecorded([
                new RootCauseAnalysisReturned,
            ]);
    }

    public function test_first_additional_information_on_incident_creates_new_array()
    {
        $user = User::factory()->create([
            'email' => 'user@b.com'
        ]);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
        ]);

        $this->assertNull($incident->additional_information);

        IncidentAggregateRoot::retrieve($incident->id)
            ->addAdditionalInformation('information')
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->additional_information);

        $this->assertEquals('information', $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );
    }

    public function test_additional_information_appends_to_current_additional_information_on_incident()
    {
        $user = User::factory()->create([
            'email' => 'user@b.com'
        ]);

        $incident = Incident::factory()->create([
            'reporters_email' => $user->email,
            'additional_information' => [
                ['information' => 'information 1', 'created_at' => now()->timestamp],
            ]
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->addAdditionalInformation('information 2')
            ->persist();

        $incident->refresh();

        $this->assertCount(2, $incident->additional_information);

        $this->assertEquals('information 1', $incident->additional_information[0]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[0]['created_at'])->timestamp
        );

        $this->assertEquals('information 2', $incident->additional_information[1]['information']);
        $this->assertEquals(
            now()->timestamp,
            Carbon::parse($incident->additional_information[1]['created_at'])->timestamp
        );
    }

    public function test_sends_additional_information_added_to_admins()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function ($user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create();

        Notification::assertNothingSent();

        IncidentAggregateRoot::retrieve($incident->id)
            ->addAdditionalInformation('information')
            ->persist();

        Notification::assertCount(3);
        Notification::assertSentTo($admins, AdditionalInformationNotification::class);
    }

    public function test_additional_information_notification_stored_in_database()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function ($user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create();

        Notification::assertNothingSent();

        IncidentAggregateRoot::retrieve($incident->id)
            ->addAdditionalInformation('information')
            ->persist();

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (AdditionalInformationNotification $notification, array $channels) use ($incident, $admins) {
                $databaseStore = $notification->toArray($admins->first());

                $this->assertEquals(route('incidents.show', $incident->id), $databaseStore['url']);

                return array_key_exists('message', $databaseStore);
            }
        );
    }

    public function test_sends_investigation_returned_notification_to_supervisor()
    {
        Notification::fake();
        $admin = User::factory()->create()->syncRoles('admin');
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($admin);

        $incident = Incident::factory()->create(['status' => InReview::class, 'supervisor_id' => $supervisor->id]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id
        ]);

        Notification::assertNothingSent();

        IncidentAggregateRoot::retrieve($incident->id)
            ->returnInvestigation()
            ->persist();

        Notification::assertCount(1);

        Notification::assertSentTo($supervisor, InvestigationReturnedNotification::class);
    }

    public function test_stores_request_notification_in_database()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        Notification::assertNothingSent();

        IncidentAggregateRoot::retrieve($incident->id)
            ->requestReview()
            ->persist();

        $incident->refresh();

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (IncidentReviewRequestNotification $notification, array $channels) use ($incident, $admins, $supervisor) {
                $databaseStore = $notification->toArray($admins->first());

                $this->assertEquals(route('incidents.show', $incident->id), $databaseStore['url']);

                return array_key_exists('message', $databaseStore);
            }
        );
    }

    public function test_request_review_sends_request_notification_to_admin()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        Notification::assertNothingSent();

        IncidentAggregateRoot::retrieve($incident->id)
            ->requestReview()
            ->persist();

        Notification::assertCount(3);

        Notification::assertSentTo($admins, IncidentReviewRequestNotification::class);

        Notification::assertSentTo(
            $admins,
            function (IncidentReviewRequestNotification $notification, array $channels) use ($incident, $supervisor) {
                return $notification->incidentId === $incident->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_request_review_adds_review_requested_comment()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->requestReview()
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('review', $comment->content);
        $this->assertStringContainsStringIgnoringCase('requested', $comment->content);
        $this->assertStringContainsStringIgnoringCase('incident', $comment->content);
    }

    public function test_request_review_throws_if_not_assigned()
    {
        $this->expectException(TransitionNotFound::class);

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Opened::class]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->requestReview()
            ->persist();
    }

    public function test_request_review_transitions_incident_from_assigned_to_in_review()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'status' => Assigned::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->requestReview()
            ->persist();

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
    }

    public function test_return_investigation_sets_returned_status()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'status' => InReview::class,
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->returnInvestigation()
            ->persist();

        $incident->refresh();

        $this->assertEquals(Returned::class, $incident->status::class);
    }

    public function test_return_investigation_adds_returned_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'status' => InReview::class,
            'supervisor_id' => $supervisor->id,
        ]);

        Investigation::factory()->create([
            'incident_id' => $incident->id,
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

    public function test_return_investigation_fires_investigation_returned_event()
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

    public function test_reopen_incident_adds_reopened_comment()
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

    public function test_close_incident_adds_closed_comment()
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

    public function test_unassign_supervisor_adds_unassigned_comment()
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

    public function test_assign_supervisor_throws_user_not_supervisor_if_id_not_supervisor()
    {
        $this->expectException(UserNotSupervisorException::class);

        $notSupervisor = User::factory()->create()->syncRoles('admin');

        $incident = Incident::factory()->create();

        IncidentAggregateRoot::retrieve($incident->id)
            ->assignSupervisor($notSupervisor->id)
            ->persist();
    }

    public function test_assign_supervisor_adds_assigned_comment()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

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

    public function test_add_comment_adds_comment_to_incident()
    {
        $user = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($user);
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

    public function test_add_comment_fires_comment_created_event()
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

    public function test_close_incident_fires_incident_closed_event()
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

    public function test_close_incident_sets_incident_status_to_closed()
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

    public function test_reopened_incident_fires_incident_reopened_event()
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

    public function test_reopen_incident_sets_status_to_reopened()
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

    public function test_unassigned_supervisor_fires_supervisor_unassigned_event()
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

    public function test_unassign_supervisor_unassigns_supervisor_from_incident()
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

    public function test_assigned_supervisor_fires_supervisor_assigned_event()
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

    public function test_assign_supervisor_assigns_supervisor_to_incident()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

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

    public function test_create_incident_adds_created_comment()
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

    public function test_create_incident_fires_incident_created_event()
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

    public function test_create_incident_stored_incident_uuid_is_aggregate_uuid()
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

    public function test_create_incident_stores_incident()
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

        Notification::assertSentTo($admins, IncidentSubmittedNotification::class);
        Notification::assertNotSentTo($user, IncidentSubmittedNotification::class);
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

        Notification::assertSentTo($admins, IncidentSubmittedNotification::class);
    }

    public function test_comment_notifies_admin_team(): void
    {
        Notification::fake();

        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);
        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create();

        $commentData = CommentData::from([
            'content' => 'Test comment for admin notification',
            'type' => CommentType::NOTE,
            'user_id' => $user->id,
        ]);

        $uuid = $incident->id;

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->addComment($commentData)
            ->persist();

        Notification::assertSentTo($admins, CommentAdded::class);
    }

    public function test_comment_notifies_supervisor_when_supervisor_is_set(): void
    {
        Notification::fake();

        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $commentData = CommentData::from([
            'content' => 'Test comment for supervisor notification',
            'type' => CommentType::NOTE,
            'user_id' => $user->id,
        ]);

        $uuid = $incident->id;

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->assignSupervisor($supervisor->id)
            ->addComment($commentData)
            ->persist();

        Notification::assertSentTo($supervisor, CommentAdded::class);
    }

    public function test_comment_does_not_notify_supervisor_when_supervisor_is_not_set(): void
    {
        Notification::fake();

        $user = User::factory()->create()->syncRoles('user');
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => null,
        ]);

        $commentData = CommentData::from([
            'content' => 'Test comment with no supervisor notification',
            'type' => CommentType::NOTE,
            'user_id' => $user->id,
        ]);

        $uuid = Str::uuid()->toString();

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->addComment($commentData)
            ->persist();

        Notification::assertNotSentTo($supervisor, CommentAdded::class);
    }

    public function test_comment_notifies_admin_team_and_supervisor_when_supervisor_is_set(): void
    {
        Notification::fake();

        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
        ]);

        $commentData = CommentData::from([
            'content' => 'Test comment for admin and supervisor notification',
            'type' => CommentType::NOTE,
            'user_id' => $user->id,
        ]);

        $uuid = $incident->id;

        $aggregate = IncidentAggregateRoot::retrieve($uuid)
            ->assignSupervisor($supervisor->id)
            ->addComment($commentData)
            ->persist();

        Notification::assertSentTo($supervisor, CommentAdded::class);
        Notification::assertSentTo($admins, CommentAdded::class);
    }

    public function test_close_incident_notifies_supervisor_when_set()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        Notification::assertSentTo($supervisor, IncidentClosedNotification::class);
        Notification::assertSentTo($admins, IncidentClosedNotification::class);
    }

    public function test_close_incident_does_not_notify_supervisor_when_not_set()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => null,
            'status' => InReview::class,
        ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        Notification::assertNotSentTo($supervisor, IncidentClosedNotification::class);
        Notification::assertSentTo($admins, IncidentClosedNotification::class);
    }

    public function test_close_incident_notifies_admin_team()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create(['status' => InReview::class,]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->closeIncident()
            ->persist();

        Notification::assertSentTo($admins, IncidentClosedNotification::class);
    }

    public function test_reopened_incident_notifies_admins()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $user = User::factory()->create()->syncRoles('user');

        $incident = Incident::factory()->create([
            'status' => Closed::class,
            'supervisor_id' => $supervisor->id,
            ]);

        IncidentAggregateRoot::retrieve($incident->id)
            ->reopenIncident()
            ->persist();

        Notification::assertCount(3);
        Notification::assertSentTo($admins, IncidentReopenedNotification::class);
        Notification::assertNotSentTo($supervisor, IncidentReopenedNotification::class);
        Notification::assertNotSentTo($user, IncidentReopenedNotification::class);
    }
}
