<?php

namespace App\Notifications\Incident;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class SupervisorAssignedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
        public User   $supervisor,
        public User   $admin,
    ) {
        $this->url = route('incidents.show', ['incident' => $incidentSlug]);
        $this->message = "$admin->name has assigned you to incident #$incidentSlug.";
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Incident #$this->incidentSlug Assigned")
            ->markdown('mail.incident-assigned', [
                'url' => $this->url,
                'supervisorName' => $this->supervisor->name,
                'adminName' => $this->admin->name,
                'incidentSlug' => $this->incidentSlug,
            ]);
    }
}
