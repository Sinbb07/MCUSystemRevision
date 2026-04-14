<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResearchUnderReview extends Notification
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
            'message' => "Your research protocol {$this->protocolId} is now under {$this->reviewType} review",
            'action_url' => '/student/dashboard', // Adjust to your student dashboard
            'type' => 'research_under_review',
            'icon' => '🔍',
            'title' => 'Research Under Review',
        ];
    }
}