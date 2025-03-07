<?php

namespace Database\Seeders;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NotificationMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incidentReceivedMessage = NotificationMessage::firstOrNew([
            'name' => NotificationMessageType::INCIDENT_RECEIVED,
        ]);

        if (!$incidentReceivedMessage->exists) {
            $incidentReceivedMessage->message =
                'Thank you for submitting this incident report. HSE may reach out to you for follow up or additional questions. You may add any additional information to this file by clicking the below link:';
        }

        $incidentReceivedMessage->save();
    }
}
