<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\AdditionalInformationNotification;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class AdditionalInformationAdded extends StoredEvent
{
    public function __construct(public string $additionalInformation)
    {
        //
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $newInfo = [
            'created_at' => now(),
            'information' => $this->additionalInformation,
        ];

        if ($incident->additional_information) {
            $additionalInfo = [...$incident->additional_information, $newInfo];
        } else {
            $additionalInfo = [$newInfo];
        }

        $incident->additional_information = $additionalInfo;
        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Additional information added.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        $admins = User::role('admin')->get();
        $incident = Incident::find($this->aggregateRootUuid());

        Notification::send($admins, new AdditionalInformationNotification($incident->slug, $this->additionalInformation));
    }
}
