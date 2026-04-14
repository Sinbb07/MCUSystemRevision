<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserClassified extends Notification
{
    use Queueable;

    protected $user;
    protected $classificationType;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, string $classificationType)
    {
        $this->user = $user;
        $this->classificationType = $classificationType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        \Log::info('UserClassified notification via() fired', [
            'user_id' => $this->user->user_ID,
            'classification' => $this->classificationType,
            'notifiable_id' => $notifiable->user_ID
        ]);
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
            'id' => $this->user->user_ID,
            'name' => $this->user->user_Fname . ' ' . $this->user->user_Lname,
            'email' => $this->user->user_Email,
            'classification' => $this->classificationType,
            'message' => "User {$this->user->user_Fname} {$this->user->user_Lname} has been classified as {$this->classificationType}",
            'type' => 'user_classified',
            'classification_date' => now()->toDateTimeString(),
        ];
    }
}