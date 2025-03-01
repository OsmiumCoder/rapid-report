<?php

namespace App\Notifications\Incident;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class FilesUploadedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public User   $user
    ) {
        $this->message = "{$this->user->name} has uploaded files to the following incident.";
        $this->url = route('incidents.show', ['incident' => $this->incidentId]);
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
            ->subject('Files Have Been Added to Incident')
            ->markdown('mail.files-uploaded-notification', ['url' => $this->url]);
    }
}
