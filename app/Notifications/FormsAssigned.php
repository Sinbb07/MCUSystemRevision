<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FormsAssigned extends Notification
{
    use Queueable;

    protected $formIds;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $formIds)
    {
        $this->formIds = $formIds;
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
        $formCount = count($this->formIds);
        
        return [
            'form_ids' => $this->formIds,
            'form_count' => $formCount,
            'message' => "You have been assigned {$formCount} new form(s) to complete by ERB Admin.",
            'action_url' => '/student/dashboard', // Changed to a route that exists
            'type' => 'forms_assigned',
            'icon' => '📝',
            'title' => 'New Forms Assigned',
        ];
    }
}