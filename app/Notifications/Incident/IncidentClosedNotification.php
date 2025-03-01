<?php

namespace App\Notifications\Incident;

use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class IncidentClosedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
    ) {
        $this->message = "The incident {$incidentId} has been closed";
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
            ->subject('Incident Closed')
            ->line($this->message)
            ->markdown('mail.incident-closed-notification', ['url' => $this->url]);
    }
}
