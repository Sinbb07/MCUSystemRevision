<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FullBoardAssignedNotification extends Notification
{
    use Queueable;

    public $protocolId;
    public $assignmentId;
    public $assignedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct($protocolId, $assignmentId, $assignedBy)
    {
        $this->protocolId = $protocolId;
        $this->assignmentId = $assignmentId;
        $this->assignedBy = $assignedBy;
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
            'message' => 'You have been assigned to review protocol ' . $this->protocolId . ' for full board review.',
            'protocol_id' => $this->protocolId,
            'assignment_id' => $this->assignmentId,
            'assigned_by' => $this->assignedBy->user_Fname . ' ' . $this->assignedBy->user_Lname,
            'assigned_at' => now()->toDateTimeString(),
            'type' => 'full_board_assigned',
            'action_url' => '/full-board/reviews', // Adjust this URL as needed
        ];
    }
}