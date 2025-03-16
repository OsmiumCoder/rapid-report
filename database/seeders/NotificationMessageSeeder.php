<?php

namespace Database\Seeders;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use Illuminate\Database\Seeder;

class NotificationMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initialMessages = [
            NotificationMessageType::INCIDENT_RECEIVED->value => [
                'message' => 'Thank you for submitting this incident report. HSE may reach out to you for follow-up or additional questions. You may add any additional information to this file by clicking the below link:',
                'data' => []
            ],
            NotificationMessageType::INCIDENT_SUBMITTED->value => [
                'message' => 'An incident was submitted by {name}.',
                'data' => ['name']
            ],
            NotificationMessageType::INCIDENT_ASSIGNED->value => [
                'message' => '{name} has assigned you to incident #{incidentSlug}.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::INCIDENT_REVIEW_REQUESTED->value => [
                'message' => '{name} has requested follow-up review on incident #{incidentSlug}.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::INCIDENT_REVIEW_LATE->value => [
                'message' => 'Your required follow-up on incident #{incidentSlug} is overdue.',
                'data' => ['incidentSlug']
            ],
            NotificationMessageType::ADDITIONAL_INFORMATION_ADDED->value => [
                'message' => 'Additional information was added to incident {incidentSlug}.',
                'data' => ['incidentSlug']
            ],
            NotificationMessageType::FILES_UPLOADED->value => [
                'message' => '{name} has uploaded files to incident #{incidentSlug}.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::INCIDENT_CLOSED->value => [
                'message' => 'Incident #{incidentSlug} has been closed.',
                'data' => ['incidentSlug']
            ],
            NotificationMessageType::INCIDENT_REOPENED->value => [
                'message' => 'Incident #{incidentSlug} has been reopened.',
                'data' => ['incidentSlug']
            ],
            NotificationMessageType::INVESTIGATION_CREATED->value => [
                'message' => 'A new investigation for incident #{incidentSlug} was submitted by {name}.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::INVESTIGATION_RETURNED->value => [
                'message' => '{name} has returned your investigation on incident #{incidentSlug} for further review.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::RCA_CREATED->value => [
                'message' => 'A new Root Cause Analysis for incident #{incidentSlug} was submitted by {name}.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::RCA_RETURNED->value => [
                'message' => '{name} has returned your Root Cause Analysis on incident #{incidentSlug} for further review.',
                'data' => ['name', 'incidentSlug']
            ],
            NotificationMessageType::COMMENT_ADDED->value => [
                'message' => '{name} commented on incident #{incidentSlug}: {comment}.',
                'data' => ['name', 'incidentSlug', 'comment']
            ],
        ];


        foreach ($initialMessages as $notificationName => $initialMessage) {
            $notificationMessage = NotificationMessage::firstOrNew([
                'name' => $notificationName,
            ]);

            if (! $notificationMessage->exists) {
                $notificationMessage->message = $initialMessage['message'];
                $notificationMessage->data = $initialMessage['data'];
            }

            $notificationMessage->save();
        }
    }
}
