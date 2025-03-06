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
    public function __construct(
    ) {
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

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

        $incident = Incident::find($this->aggregateRootUuid());

        Notification::send($admins, new FilesUploadedNotification($incident->slug, $supervisor));
    }
}
