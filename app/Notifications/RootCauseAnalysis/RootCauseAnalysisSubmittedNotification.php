<?php

namespace App\Notifications\RootCauseAnalysis;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class RootCauseAnalysisSubmittedNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentSlug,
        public string $rootCauseAnalysisId,
        public User   $supervisor,
    ) {
        $this->message = "A new root cause analysis for incident #$incidentSlug was submitted by $supervisor->name";
        $this->url = route('incidents.root-cause-analyses.show', [
            'incident' => $incidentSlug,
            'root_cause_analysis' => $rootCauseAnalysisId
        ]);

    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Root Cause Analysis Submitted')
            ->markdown('mail.root-cause-analysis-submitted', ['url' => $this->url, 'message' => $this->message]);
    }
}
