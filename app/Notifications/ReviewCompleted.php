<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewCompleted extends Notification
{
    use Queueable;

    protected $protocolId;
    protected $reviewType;

    /**
     * Create a new notification instance.
     */
    public function __construct($protocolId, $reviewType)
    {
        $this->protocolId = $protocolId;
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
            'review_type' => $this->reviewType,
            'message' => "Your research protocol {$this->protocolId} has been fully evaluated and the review process is complete.",
            'action_url' => '/student/dashboard', // Adjust to your student dashboard
            'type' => 'review_completed',
            'icon' => '✅',
            'title' => 'Review Completed',
        ];
    }
}