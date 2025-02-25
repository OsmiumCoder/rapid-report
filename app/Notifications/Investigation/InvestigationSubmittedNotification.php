<?php

namespace App\Notifications\Investigation;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class InvestigationSubmittedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public string $investigationId,
        public User $supervisor,
    ) {
        $this->message = "A new investigation was submitted by {$this->supervisor->name}";
        $this->url = route('incidents.investigations.show', [
            'incident' => $this->incidentId,
            'investigation' => $this->investigationId
        ]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Investigation Submitted')
            ->markdown('mail.investigation-submitted', ['url' => $this->url]);
    }
}
