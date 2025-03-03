<?php

namespace App\StorableEvents\Comment;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\Comment\CommentAdded;
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

        $comment->user_id = $this->metaData['user_id'];
        $comment->content = $this->content;
        $comment->type = $this->type;

        $comment->commentable_id = $this->commentable_id;
        $comment->commentable_type = $this->commentable_type;

        $comment->save();
    }

    public function react()
    {
        $commentable = $this->commentable_type::find($this->commentable_id);
        $commenter = User::find($this->metaData['user_id']);

        if ($commentable) {
            $url = route('incidents.show', ['incident' => $this->commentable_id]);

            $notification = new CommentAdded($this->content, $commenter, $url, $commentable->slug);

            if ($commentable->supervisor && $commentable->supervisor->id !== $this->metaData['user_id']) {
                Notification::send($commentable->supervisor, $notification);
            }

            $admins = User::role('admin')->whereKeyNot($this->metaData['user_id'])->get();

            Notification::send($admins, $notification);
        }
    }
}
