<?php

namespace App\Notifications\Incident;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class FilesUploadedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $data,
    ) {
        $this->url = route('incidents.show', ['incident' => $this->data['incidentSlug']]);
        $this->parseMessage(NotificationMessageType::FILES_UPLOADED);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Files Have Been Uploaded to Incident #{$this->data['incidentSlug']}")
            ->markdown('mail.files-uploaded-notification', [
                'url' => $this->url,
                'message' => $this->message
            ]);
    }
}
