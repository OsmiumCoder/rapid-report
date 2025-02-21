<?php

namespace App\StorableEvents\Comment;

use App\Enum\CommentType;
use App\Models\Comment;
use App\StorableEvents\StoredEvent;

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
}
