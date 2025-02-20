<?php

namespace App\Notifications\Comment;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class CommentMade extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $comment,
        public ?string $commenterName,
        public string $url  // Add the URL to the constructor
    ) {
        if ($this->commenterName == null) {
            $this->commenterName = 'Anonymous User';
        }

        if ($this->comment == null) {
            $this->message = "An empty comment was made by $this->commenterName";
        } else {
            $this->message = "$this->commenterName commented: $this->comment";
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'vonage'];
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     */
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->message);
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
                'recipient' => $notifiable->name,
                'commenter' => $this->commenterName,
                'content' => $this->comment,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'comment' => $this->comment,
            'name' => $this->commenterName,
            'url' => $this->url
        ];
    }
}
