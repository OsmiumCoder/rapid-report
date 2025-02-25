<?php

namespace App\Notifications\Comment;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\BaseNotification;

class CommentAdded extends BaseNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $comment,
        public User $user,
        public string $url
    ) {
        $this->message = "$this->user->name commented: $this->comment";
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Comment Created')
            ->line($this->message)
            ->markdown('mail.comment-made', [
                'commenter' => $this->user->name,
                'content' => $this->comment,
            ]);
    }
}
