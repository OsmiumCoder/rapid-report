<?php

namespace App\Mail;

use App\Enum\NotificationMessageType;
use App\Models\NotificationMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidentReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $url;
    public string $message;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $incidentId)
    {
        $this->url = route('incidents.show', ['incident' => $this->incidentId]);
        $this->message = NotificationMessage::firstWhere('name', NotificationMessageType::INCIDENT_RECEIVED)->message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incident Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.incident-received',
            with: [
                'url' => $this->url,
                'message' => $this->message,
            ],
        );
    }
}
