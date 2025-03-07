<?php

namespace App\Notifications\Investigation;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class InvestigationReturnedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
        public string $investigationId,
        public User   $admin
    ) {
        $this->message = "$admin->name has returned your investigation on incident #$incidentSlug for further review";
        $this->url = route('incidents.investigations.show', [
            'incident' => $incidentSlug,
            'investigation' => $investigationId
        ]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Investigation For Incident #$this->incidentSlug Returned")
            ->markdown('mail.investigation-returned', [
                'url' => $this->url,
                'message' => $this->message
            ]);
    }
}
