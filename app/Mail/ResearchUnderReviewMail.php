<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResearchUnderReviewMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $protocolCode;
    public $reviewType;

    /**
     * Create a new message instance.
     */
    public function __construct($protocolCode, $reviewType)
    {
        $this->protocolCode = $protocolCode;
        $this->reviewType = $reviewType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Research Under Review - ' . $this->protocolCode . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.research-under-review',
            with: [
                'protocolCode' => $this->protocolCode,
                'reviewType' => $this->reviewType,
                'appName' => config('app.name'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}