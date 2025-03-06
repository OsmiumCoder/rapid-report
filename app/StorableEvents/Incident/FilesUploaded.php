<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\FilesUploadedNotification;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class FilesUploaded extends StoredEvent
{
    private ?Incident $incident = null;

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

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Files have been uploaded.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        $admins = User::role('admin')->get();
        $supervisor = User::find($this->metaData['user_id']);

        $incident = $this->incident();

        Notification::send($admins, new FilesUploadedNotification($incident->slug, $supervisor));
    }
}
