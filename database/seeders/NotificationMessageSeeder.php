<?php

namespace Database\Seeders;

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
        NotificationMessage::firstOrCreate([
            'name' => 'incident-received',
            'message' => 'Thank you for submitting this incident report. HSE may reach out to you for follow up or additional questions. You may add any additional information to this file by clicking the below link:'
        ]);
    }
}
