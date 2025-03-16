<?php

namespace App\Notifications\RootCauseAnalysis;

use App\Enum\NotificationMessageType;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class RootCauseAnalysisSubmittedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $data,
    ) {
        $this->url = route('incidents.root-cause-analyses.show', [
            'incident' => $this->data['incidentSlug'],
            'root_cause_analysis' => $this->data['rootCauseAnalysisId'],
        ]);

        $this->parseMessage(NotificationMessageType::RCA_CREATED);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Root Cause Analysis Submitted For Incident #{$this->data['incidentSlug']}")
            ->markdown('mail.root-cause-analysis-submitted', ['url' => $this->url, 'message' => $this->message]);
    }
}
