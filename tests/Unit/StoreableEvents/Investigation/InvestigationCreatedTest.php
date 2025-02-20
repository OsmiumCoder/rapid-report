<?php

namespace StoreableEvents\Investigation;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\Notifications\Investigation\InvestigationSubmitted;
use App\States\IncidentStatus\Assigned;
use App\StorableEvents\Investigation\InvestigationCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class InvestigationCreatedTest extends TestCase
{
    public function test_event_calculates_hazard_class_a_correctly()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: "immediate causes",
            basic_causes: 'basic causes',
            remedial_actions: "remedial actions",
            prevention: "prevention",
            risk_rank: 1,
            resulted_in: ['injury', 'burn'],
            substandard_acts: ['injury', 'burn'],
            substandard_conditions: ['injury', 'burn'],
            energy_transfer_causes: ['injury', 'burn'],
            personal_factors: ['injury', 'burn'],
            job_factors: ['injury', 'burn'],
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->handle();

        $incident->refresh();

        $this->assertEquals('A', $incident->investigations[0]->hazard_class);
    }

    public function test_event_calculates_hazard_class_b_correctly()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: "immediate causes",
            basic_causes: 'basic causes',
            remedial_actions: "remedial actions",
            prevention: "prevention",
            risk_rank: 4,
            resulted_in: ['injury', 'burn'],
            substandard_acts: ['injury', 'burn'],
            substandard_conditions: ['injury', 'burn'],
            energy_transfer_causes: ['injury', 'burn'],
            personal_factors: ['injury', 'burn'],
            job_factors: ['injury', 'burn'],
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->handle();

        $incident->refresh();

        $this->assertEquals('B', $incident->investigations[0]->hazard_class);
    }

    public function test_event_calculates_hazard_class_c_correctly()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: "immediate causes",
            basic_causes: 'basic causes',
            remedial_actions: "remedial actions",
            prevention: "prevention",
            risk_rank: 6,
            resulted_in: ['injury', 'burn'],
            substandard_acts: ['injury', 'burn'],
            substandard_conditions: ['injury', 'burn'],
            energy_transfer_causes: ['injury', 'burn'],
            personal_factors: ['injury', 'burn'],
            job_factors: ['injury', 'burn'],
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->handle();

        $incident->refresh();

        $this->assertEquals('C', $incident->investigations[0]->hazard_class);
    }

    public function test_sends_received_notification_to_admin()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: "immediate causes",
            basic_causes: 'basic causes',
            remedial_actions: "remedial actions",
            prevention: "prevention",
            risk_rank: 10,
            resulted_in: ['injury', 'burn'],
            substandard_acts: ['injury', 'burn'],
            substandard_conditions: ['injury', 'burn'],
            energy_transfer_causes: ['injury', 'burn'],
            personal_factors: ['injury', 'burn'],
            job_factors: ['injury', 'burn'],
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $aggregateUuid = Str::uuid()->toString();

        $event->setAggregateRootUuid($aggregateUuid);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);

        Notification::assertSentTo($admins, InvestigationSubmitted::class);

        Notification::assertSentTo(
            $admins,
            function (InvestigationSubmitted $notification, array $channels) use ($aggregateUuid, $supervisor) {
                return $notification->investigationId === $aggregateUuid && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_created_investigation_comment_on_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: "immediate causes",
            basic_causes: 'basic causes',
            remedial_actions: "remedial actions",
            prevention: "prevention",
            risk_rank: 10,
            resulted_in: ['injury', 'burn'],
            substandard_acts: ['injury', 'burn'],
            substandard_conditions: ['injury', 'burn'],
            energy_transfer_causes: ['injury', 'burn'],
            personal_factors: ['injury', 'burn'],
            job_factors: ['injury', 'burn'],
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->handle();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('investigation', $comment->content);
        $this->assertEquals($supervisor->id, $comment->user_id);
    }

    public function test_creates_investigation()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: "immediate causes",
            basic_causes: 'basic causes',
            remedial_actions: "remedial actions",
            prevention: "prevention",
            risk_rank: 10,
            resulted_in: ['injury', 'burn'],
            substandard_acts: ['injury', 'burn'],
            substandard_conditions: ['injury', 'burn'],
            energy_transfer_causes: ['injury', 'burn'],
            personal_factors: ['injury', 'burn'],
            job_factors: ['injury', 'burn'],
        );
        $event->setMetaData(['user_id' => $supervisor->id]);

        $this->assertDatabaseCount('investigations', 0);

        $event->handle();

        $this->assertDatabaseCount('investigations', 1);

        $investigation = Investigation::first();

        $this->assertEquals($event->incident_id, $investigation->incident_id);
        $this->assertEquals($supervisor->id, $investigation->supervisor_id);
        $this->assertEquals($event->immediate_causes, $investigation->immediate_causes);
        $this->assertEquals($event->basic_causes, $investigation->basic_causes);
        $this->assertEquals($event->remedial_actions, $investigation->remedial_actions);
        $this->assertEquals($event->prevention, $investigation->prevention);
        $this->assertEquals($event->risk_rank, $investigation->risk_rank);
        $this->assertEquals($event->resulted_in, $investigation->resulted_in);
        $this->assertEquals($event->substandard_acts, $investigation->substandard_acts);
        $this->assertEquals($event->substandard_conditions, $investigation->substandard_conditions);
        $this->assertEquals($event->energy_transfer_causes, $investigation->energy_transfer_causes);
        $this->assertEquals($event->personal_factors, $investigation->personal_factors);
        $this->assertEquals($event->job_factors, $investigation->job_factors);
    }
}
