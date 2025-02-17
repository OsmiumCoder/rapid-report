<?php

namespace Aggregates;

use App\Aggregates\RootCauseAnalysisAggregateRoot;
use App\Data\RootCauseAnalysisData;
use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Notifications\RootCauseAnalysis\RootCauseAnalysisSubmitted;
use App\States\IncidentStatus\Assigned;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class RootCauseAnalysisAggregateRootTest extends TestCase
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

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $uuid = Str::uuid()->toString();

        Notification::assertNothingSent();

        $aggregate = RootCauseAnalysisAggregateRoot::retrieve($uuid)
            ->createRootCauseAnalysis($rcaData, $incident)
            ->persist();

        Notification::assertCount(3);

        Notification::assertSentTo($admins, RootCauseAnalysisSubmitted::class);

        $rca = RootCauseAnalysis::first();

        Notification::assertSentTo(
            $admins,
            function (RootCauseAnalysisSubmitted $notification, array $channels) use ($rca, $supervisor) {
                return $notification->rootCauseAnalysisId === $rca->id && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_created_rca_comment_on_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $uuid = Str::uuid()->toString();

        $aggregate = RootCauseAnalysisAggregateRoot::retrieve($uuid)
            ->createRootCauseAnalysis($rcaData, $incident)
            ->persist();

        $incident->refresh();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('root cause analysis', $comment->content);

    }

    public function test_fires_rca_created_event()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        RootCauseAnalysisAggregateRoot::fake(Str::uuid()->toString())
            ->when(function (RootCauseAnalysisAggregateRoot $rcaAggregateRoot) use ($rcaData, $incident): void {
                $rcaAggregateRoot->createRootCauseAnalysis($rcaData, $incident);
            })->assertRecorded([
                new RootCauseAnalysisCreated(
                    incident_id: $incident->id,
                    individuals_involved: [
                        ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
                    ],
                    primary_effect: 'primary effect',
                    whys: ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
                    solutions_and_actions: [
                        [
                            "cause" => 'cause 1',
                            'control' => 'control 1',
                            'remedial_action' => 'action 1',
                            'by_who' => 'who 1',
                            'by_when' => now()->format('Y-m-d'),
                            'manager' => 'manager 1',
                        ],
                        [
                            "cause" => 'cause 2',
                            'control' => 'control 2',
                            'remedial_action' => 'action 2',
                            'by_who' => 'who 2',
                            'by_when' => now()->format('Y-m-d'),
                            'manager' => 'manager 2',
                        ]
                    ],
                    peoples_positions: ['position 1', 'position 2', 'position 3', 'position 4'],
                    attention_to_work: ['attention to work 1', 'attention to work 2'],
                    communication: ['communication 1', 'communication 2'],
                    ppe_in_good_condition: true,
                    ppe_in_use: true,
                    ppe_correct_type: true,
                    correct_tool_used: true,
                    policies_followed: true,
                    worked_safely: true,
                    used_tool_properly: true,
                    tool_in_good_condition: true,
                    working_conditions: ['working condition 1', 'working condition 2'],
                    root_causes: ['root cause 1', 'root cause 2'],
                )
            ]);
    }

    public function test_rca_uuid_is_aggregate_uuid()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $this->assertDatabaseCount('root_cause_analyses', 0);

        $uuid = Str::uuid()->toString();

        $aggregate = RootCauseAnalysisAggregateRoot::retrieve($uuid)
            ->createRootCauseAnalysis($rcaData, $incident)
            ->persist();

        $this->assertDatabaseCount('root_cause_analyses', 1);

        $rca = RootCauseAnalysis::first();

        $this->assertEquals($aggregate->uuid(), $rca->id);
    }

    public function test_stores_rca()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $rcaData = RootCauseAnalysisData::from([
            'individuals_involved' => [
                ['name' => 'john', 'email' => 'john@doe.com', 'phone' => '1234567890'],
            ],
            'primary_effect' => 'primary effect',
            'whys' => ['why 1', 'why 2', 'why 3', 'why 4', 'why 5'],
            'solutions_and_actions' => [
                [
                    "cause" => 'cause 1',
                    'control' => 'control 1',
                    'remedial_action' => 'action 1',
                    'by_who' => 'who 1',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 1',
                ],
                [
                    "cause" => 'cause 2',
                    'control' => 'control 2',
                    'remedial_action' => 'action 2',
                    'by_who' => 'who 2',
                    'by_when' => now()->format('Y-m-d'),
                    'manager' => 'manager 2',
                ]
            ],
            'peoples_positions' => ['position 1', 'position 2', 'position 3', 'position 4'],
            'attention_to_work' => ['attention to work 1', 'attention to work 2'],
            'communication' => ['communication 1', 'communication 2'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working condition 1', 'working condition 2'],
            'root_causes' => ['root cause 1', 'root cause 2'],
        ]);

        $this->assertDatabaseCount('root_cause_analyses', 0);

        $uuid = Str::uuid()->toString();

        $aggregate = RootCauseAnalysisAggregateRoot::retrieve($uuid)
            ->createRootCauseAnalysis($rcaData, $incident)
            ->persist();

        $this->assertDatabaseCount('root_cause_analyses', 1);

        $rca = RootCauseAnalysis::first();

        $this->assertEquals($aggregate->uuid(), $rca->id);
        $this->assertEquals($incident->id, $rca->incident_id);
        $this->assertEquals($supervisor->id, $rca->supervisor_id);
        $this->assertEquals($rcaData->individuals_involved, $rca->individuals_involved);
        $this->assertEquals($rcaData->primary_effect, $rca->primary_effect);
        $this->assertEquals($rcaData->whys, $rca->whys);
        $this->assertEquals($rcaData->solutions_and_actions, $rca->solutions_and_actions);
        $this->assertEquals($rcaData->peoples_positions, $rca->peoples_positions);
        $this->assertEquals($rcaData->attention_to_work, $rca->attention_to_work);
        $this->assertEquals($rcaData->communication, $rca->communication);
        $this->assertEquals($rcaData->ppe_in_good_condition, $rca->ppe_in_good_condition);
        $this->assertEquals($rcaData->ppe_in_use, $rca->ppe_in_use);
        $this->assertEquals($rcaData->ppe_correct_type, $rca->ppe_correct_type);
        $this->assertEquals($rcaData->correct_tool_used, $rca->correct_tool_used);
        $this->assertEquals($rcaData->policies_followed, $rca->policies_followed);
        $this->assertEquals($rcaData->worked_safely, $rca->worked_safely);
        $this->assertEquals($rcaData->used_tool_properly, $rca->used_tool_properly);
        $this->assertEquals($rcaData->tool_in_good_condition, $rca->tool_in_good_condition);
        $this->assertEquals($rcaData->working_conditions, $rca->working_conditions);
        $this->assertEquals($rcaData->root_causes, $rca->root_causes);
    }
}
