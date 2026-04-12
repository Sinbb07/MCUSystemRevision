<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProtocolAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $protocolCode;
    public $piName;
    public $reviewType;

    /**
     * Create a new message instance.
     */
    public function __construct($protocolCode, $piName, $reviewType)
    {
        $this->protocolCode = $protocolCode;
        $this->piName = $piName;
        $this->reviewType = $reviewType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Protocol Assigned - ' . $this->protocolCode . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.new-protocol-assigned',
            with: [
                'protocolCode' => $this->protocolCode,
                'piName' => $this->piName,
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