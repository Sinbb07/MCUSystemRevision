<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProtocolDecision extends Notification
{
    use Queueable;

    protected $protocolId;
    protected $decision;
    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($protocolId, $decision, $details = null)
    {
        $this->protocolId = $protocolId;
        $this->decision = $decision;
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if ($this->decision === 'Approved') {
            $message = "Your research protocol {$this->protocolId} has been approved by the ERB. Please accomplished the necessary forms for final completion.";
            $action_url = '/student/download-forms'; // Where they can access Form 3L and Form 3C
        } else {
            $message = "Your research protocol {$this->protocolId} requires resubmission. Please check the assigned forms for details.";
            $action_url = '/student/download-forms'; // Where they can access Form 3A and 3B
        }

        return [
            'protocol_id' => $this->protocolId,
            'decision' => $this->decision,
            'message' => $message,
            'action_url' => $action_url,
            'type' => 'protocol_decision',
            'icon' => $this->decision === 'Approved' ? '✅' : '📝',
            'title' => $this->decision === 'Approved' ? 'Protocol Approved' : 'Resubmission Required',
        ];
    }
}