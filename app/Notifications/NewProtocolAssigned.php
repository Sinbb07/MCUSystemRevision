<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewProtocolAssigned extends Notification
{
    use Queueable;

    protected $protocolId;
    protected $piName;
    protected $reviewType;

    /**
     * Create a new notification instance.
     */
    public function __construct($protocolId, $piName, $reviewType)
    {
        $this->protocolId = $protocolId;
        $this->piName = $piName;
        $this->reviewType = $reviewType;
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
        return [
            'protocol_id' => $this->protocolId,
            'pi_name' => $this->piName,
            'review_type' => $this->reviewType,
            'message' => "You have been assigned as a reviewer for protocol {$this->protocolId} ({$this->piName})",
            'action_url' => '/erb/dashboard', // Adjust to your reviewer dashboard
            'type' => 'new_protocol_assigned',
            'icon' => '📋',
            'title' => 'New Protocol Assigned',
        ];
    }
}