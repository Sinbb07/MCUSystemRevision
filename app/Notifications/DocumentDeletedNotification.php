<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentDeletedNotification extends Notification
{
    use Queueable;

    public $notificationData;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $notificationData)
    {
        $this->notificationData = $notificationData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // You can add 'mail' if you want email notifications too
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->notificationData['type'],
            'message' => $this->notificationData['message'],
            'document_name' => $this->notificationData['document_name'],
            'form_name' => $this->notificationData['form_name'],
            'delete_reason' => $this->notificationData['delete_reason'],
            'deleted_at' => $this->notificationData['deleted_at'],
            'action_url' => $this->notificationData['action_url'],
        ];
    }
}