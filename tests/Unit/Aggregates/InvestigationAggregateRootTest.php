<?php

namespace Tests\Unit\Aggregates;

use App\Aggregates\InvestigationAggregateRoot;
use App\Data\InvestigationData;
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

class InvestigationAggregateRootTest extends TestCase
{
    public function test_sends_received_notification_to_admin()
    {
        Notification::fake();

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $uuid = Str::uuid()->toString();

        Notification::assertNothingSent();

        $aggregate = InvestigationAggregateRoot::retrieve($uuid)
            ->createInvestigation($investigationData, $incident)
            ->persist();

        Notification::assertCount(3);

        Notification::assertSentTo($admins, InvestigationSubmitted::class);

        $investigation = Investigation::first();

        Notification::assertSentTo(
            $admins,
            function (InvestigationSubmitted $notification, array $channels) use ($investigation, $supervisor) {
                return $notification->investigationId === $investigation->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_created_investigation_comment_on_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $uuid = Str::uuid()->toString();

        $aggregate = InvestigationAggregateRoot::retrieve($uuid)
            ->createInvestigation($investigationData, $incident)
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('investigation', $comment->content);

    }

    public function test_fires_investigation_created_event()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        InvestigationAggregateRoot::fake(Str::uuid()->toString())
            ->when(function (InvestigationAggregateRoot $investigationAggregateRoot) use ($investigationData, $incident): void {
                $investigationAggregateRoot->createInvestigation($investigationData, $incident);
            })->assertRecorded([
                new InvestigationCreated(
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
                )
            ]);
    }

    public function test_investigation_uuid_is_aggregate_uuid()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'hazard_class' => 'hazard class',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $this->assertDatabaseCount('investigations', 0);

        $uuid = Str::uuid()->toString();

        $aggregate = InvestigationAggregateRoot::retrieve($uuid)
            ->createInvestigation($investigationData, $incident)
            ->persist();

        $this->assertDatabaseCount('investigations', 1);

        $investigation = Investigation::first();

        $this->assertEquals($aggregate->uuid(), $investigation->id);
    }

    public function test_stores_investigation()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $investigationData = InvestigationData::from([
            'immediate_causes' => "immediate causes",
            'basic_causes' => 'basic causes',
            'remedial_actions' => "remedial actions",
            'prevention' => 'prevention',
            'risk_rank' => 10,
            'resulted_in' => ['injury', 'burn'],
            'substandard_acts' => ['injury', 'burn'],
            'substandard_conditions' => ['injury', 'burn'],
            'energy_transfer_causes' => ['injury', 'burn'],
            'personal_factors' => ['injury', 'burn'],
            'job_factors' => ['injury', 'burn'],
        ]);

        $this->assertDatabaseCount('investigations', 0);

        $uuid = Str::uuid()->toString();

        $aggregate = InvestigationAggregateRoot::retrieve($uuid)
            ->createInvestigation($investigationData, $incident)
            ->persist();

        $this->assertDatabaseCount('investigations', 1);

        $investigation = Investigation::first();

        $this->assertEquals($aggregate->uuid(), $investigation->id);
        $this->assertEquals($incident->id, $investigation->incident_id);
        $this->assertEquals($investigationData->immediate_causes, $investigation->immediate_causes);
        $this->assertEquals($investigationData->basic_causes, $investigation->basic_causes);
        $this->assertEquals($investigationData->remedial_actions, $investigation->remedial_actions);
        $this->assertEquals($investigationData->prevention, $investigation->prevention);
        $this->assertEquals($investigationData->risk_rank, $investigation->risk_rank);
        $this->assertEquals($investigationData->resulted_in, $investigation->resulted_in);
        $this->assertEquals($investigationData->substandard_acts, $investigation->substandard_acts);
        $this->assertEquals($investigationData->substandard_conditions, $investigation->substandard_conditions);
        $this->assertEquals($investigationData->energy_transfer_causes, $investigation->energy_transfer_causes);
        $this->assertEquals($investigationData->personal_factors, $investigation->personal_factors);
        $this->assertEquals($investigationData->job_factors, $investigation->job_factors);
    }
}
