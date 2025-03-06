<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\AdditionalInformationNotification;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class AdditionalInformationAdded extends StoredEvent
{
    private ?Incident $incident = null;

    public function __construct(public string $additionalInformation)
    {
        //
    }

    public function incident()
    {
        if (!$this->incident) {
            $this->incident = Incident::find($this->aggregateRootUuid());
        }

        return $this->incident;
    }

    public function handle()
    {
        $incident = $this->incident();

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
        $incident = $this->incident();

        Notification::send($admins, new AdditionalInformationNotification($incident->slug, $this->additionalInformation));
    }
}
