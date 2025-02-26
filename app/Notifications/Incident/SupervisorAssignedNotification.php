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
        public string $incidentId,
        public User $supervisor,
        public User $admin,
    ) {
        $this->url = route('incidents.show', ['incident' => $this->incidentId]);
        $this->message = "$admin->name has assigned you to a new Incident";
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Incident Assigned')
            ->markdown('mail.incident-assigned', [
                'url' => $this->url,
                'supervisorName' => $this->supervisor->name,
                'adminName' => $this->admin->name
            ]);
    }
}
