<?php

namespace App\StorableEvents\Comment;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\Comment\CommentMade;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class CommentCreated extends StoredEvent
{
    public function __construct(
        public string      $content,
        public CommentType $type,
        public string      $commentable_id,
        public string      $commentable_type,
    ) {
    }

    public function handle()
    {
        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->content = $this->content;
        $comment->type = $this->type;

        $comment->commentable_id = $this->commentable_id;
        $comment->commentable_type = $this->commentable_type;

        $comment->save();
    }

    public function react()
    {
        $commentable = $this->commentable_type::find($this->commentable_id);

        if ($commentable && $commentable->supervisor) {
            Notification::send($commentable->supervisor, new CommentMade);
        }
        $admins = User::role('admin')->get();
        Notification::send($admins, new CommentMade);
    }
}
