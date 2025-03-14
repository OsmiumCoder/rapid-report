<?php

namespace App\Notifications\Comment;

use App\Enum\NotificationMessageType;
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
        public string $url,
        public array $data,
    ) {
        $this->parseMessage(NotificationMessageType::COMMENT_ADDED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Comment Added on Incident #{$this->data['incidentSlug']}")
            ->line($this->message)
            ->markdown('mail.comment-made', [
                'message' => $this->message,
                'url' => $this->url,
            ]);
    }
}
