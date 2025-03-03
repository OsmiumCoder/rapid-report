<?php

namespace App\Notifications\Incident;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class IncidentReviewRequestNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
        public User   $supervisor,
    ) {
        $this->message = "{$this->supervisor->name} has requested follow-up review on incident #$incidentSlug.";
        $this->url = route('incidents.show', ['incident' => $incidentSlug]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Incident Follow Up Review Request')
            ->markdown('mail.incident-review-request', ['url' => $this->url, 'message' => $this->message]);
    }
}
