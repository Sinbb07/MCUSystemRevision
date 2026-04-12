<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateExemptedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $protocol;
    public $pi;
    public $research;

    /**
     * Create a new message instance.
     */
    public function __construct($protocol, $pi, $research)
    {
        $this->protocol = $protocol;
        $this->pi = $pi;
        $this->research = $research;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificate of Exemption Granted - ' . $this->protocol->protocol_ID . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.certificate-exempted',
            with: [
                'protocol' => $this->protocol,
                'pi' => $this->pi,
                'research' => $this->research,
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