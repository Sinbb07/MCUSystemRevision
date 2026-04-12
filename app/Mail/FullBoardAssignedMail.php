<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FullBoardAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $protocolId;
    public $assignmentId;
    public $assignedBy;

    /**
     * Create a new message instance.
     */
    public function __construct($protocolId, $assignmentId, $assignedBy)
    {
        $this->protocolId = $protocolId;
        $this->assignmentId = $assignmentId;
        $this->assignedBy = $assignedBy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Full Board Meeting Invitation - ' . $this->protocolId . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.full-board-assigned',
            with: [
                'protocolId' => $this->protocolId,
                'assignmentId' => $this->assignmentId,
                'assignedBy' => $this->assignedBy,
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