<?php

namespace App\Notifications\RootCauseAnalysis;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class RootCauseAnalysisSubmitted extends Notification
{
    use Queueable;

    public string $message;
    public string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $incidentId,
        public string $rootCauseAnalysisId,
        public User $supervisor,
    ) {
        $this->message = "A new root cause analysis was submitted by {$this->supervisor->name}";
        $this->url = route('incidents.root-cause-analyses.show', [
            'incident' => $this->incidentId,
            'root_cause_analysis' => $this->rootCauseAnalysisId
        ]);

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'vonage'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Root Cause Analysis Submitted')
            ->markdown('mail.root-cause-analysis-submitted', ['url' => $this->url]);
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     */
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'url' => $this->url,
            'message' => $this->message,
            'supervisor_name' => $this->supervisor->name,
        ];
    }
}
