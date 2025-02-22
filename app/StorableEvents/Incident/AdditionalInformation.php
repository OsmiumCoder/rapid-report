<?php

namespace App\StorableEvents\Incident;

use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\AdditionalInformationNotification;
use App\StorableEvents\StoredEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class AdditionalInformation extends StoredEvent
{
    public function __construct(public string $additionalInformation)
    {
        //
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $newInfo = [
            'created_at' => Carbon::now(),
            'information' => $this->additionalInformation,
        ];

        if ($incident->additional_information) {
            $additionalInfo = [...$incident->additional_information, $newInfo];
        } else {
            $additionalInfo = [$newInfo];
        }

        $incident->additional_information = $additionalInfo;
        $incident->save();
    }

    public function react()
    {
        $admins = User::role('admin')->get();
        Notification::send($admins, new AdditionalInformationNotification($this->aggregateRootUuid(), $this->additionalInformation));
    }
}
