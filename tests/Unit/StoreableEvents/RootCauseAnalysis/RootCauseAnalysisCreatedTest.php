<?php

namespace Tests\Unit\StoreableEvents\RootCauseAnalysis;

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

class RootCauseAnalysisCreatedTest extends TestCase
{
    public function test_sends_received_notification_to_admin()
    {
        Notification::fake();

        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new RootCauseAnalysisCreated(
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
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $aggregateUuid = Str::uuid()->toString();

        $event->setAggregateRootUuid($aggregateUuid);

        Notification::assertNothingSent();

        $event->react();

        Notification::assertCount(3);

        Notification::assertSentTo($admins, RootCauseAnalysisSubmitted::class);

        Notification::assertSentTo(
            $admins,
            function (RootCauseAnalysisSubmitted $notification, array $channels) use ($aggregateUuid, $supervisor) {
                return $notification->rootCauseAnalysisId === $aggregateUuid && $notification->supervisor->id === $supervisor->id;
            }
        );
    }

    public function test_adds_created_root_cause_analysis_comment_on_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new RootCauseAnalysisCreated(
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
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $event->handle();

        $this->assertCount(1, $incident->comments);

        $comment = $incident->comments->first();

        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('created', $comment->content);
        $this->assertStringContainsStringIgnoringCase('root cause analysis', $comment->content);
        $this->assertEquals($supervisor->id, $comment->user_id);
    }

    public function test_creates_root_cause_analysis_with_aggregate_uuid()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new RootCauseAnalysisCreated(
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
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $aggregateUuid = Str::uuid()->toString();

        $event->setAggregateRootUuid($aggregateUuid);

        $this->assertDatabaseCount('root_cause_analyses', 0);

        $event->handle();

        $this->assertDatabaseCount('root_cause_analyses', 1);

        $rca = RootCauseAnalysis::first();

        $this->assertEquals($aggregateUuid, $rca->id);
    }

    public function test_creates_root_cause_analysis()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['status' => Assigned::class]);

        $event = new RootCauseAnalysisCreated(
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
        );

        $event->setMetaData(['user_id' => $supervisor->id]);

        $this->assertDatabaseCount('root_cause_analyses', 0);

        $event->handle();

        $this->assertDatabaseCount('root_cause_analyses', 1);

        $rca = RootCauseAnalysis::first();

        $this->assertEquals($incident->id, $rca->incident_id);
        $this->assertEquals($supervisor->id, $rca->supervisor_id);
        $this->assertEquals($event->incident_id, $rca->incident_id);
        $this->assertEquals($event->individuals_involved, $rca->individuals_involved);
        $this->assertEquals($event->primary_effect, $rca->primary_effect);
        $this->assertEquals($event->whys, $rca->whys);
        $this->assertEquals($event->solutions_and_actions, $rca->solutions_and_actions);
        $this->assertEquals($event->peoples_positions, $rca->peoples_positions);
        $this->assertEquals($event->attention_to_work, $rca->attention_to_work);
        $this->assertEquals($event->communication, $rca->communication);
        $this->assertEquals($event->ppe_in_good_condition, $rca->ppe_in_good_condition);
        $this->assertEquals($event->ppe_in_use, $rca->ppe_in_use);
        $this->assertEquals($event->ppe_correct_type, $rca->ppe_correct_type);
        $this->assertEquals($event->correct_tool_used, $rca->correct_tool_used);
        $this->assertEquals($event->policies_followed, $rca->policies_followed);
        $this->assertEquals($event->worked_safely, $rca->worked_safely);
        $this->assertEquals($event->used_tool_properly, $rca->used_tool_properly);
        $this->assertEquals($event->tool_in_good_condition, $rca->tool_in_good_condition);
        $this->assertEquals($event->working_conditions, $rca->working_conditions);
        $this->assertEquals($event->root_causes, $rca->root_causes);
    }
}
