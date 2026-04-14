<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewerProgress extends Notification
{
    use Queueable;

    protected $protocolId;
    protected $reviewerId;
    protected $status;
    protected $formId;

    /**
     * Create a new notification instance.
     */
    public function __construct($protocolId, $reviewerId, $status, $formId)
    {
        $this->protocolId = $protocolId;
        $this->reviewerId = $reviewerId;
        $this->status = $status;
        $this->formId = $formId;
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
        $form = \App\Models\FormsTable::find($this->formId);
        $formName = $form ? $form->form_name : 'Unknown Form';
        
        $reviewer = \App\Models\User::find($this->reviewerId);
        $reviewerName = $reviewer ? $reviewer->user_Fname . ' ' . $reviewer->user_Lname : 'Unknown Reviewer';

        if ($this->status === 'Completed') {
            $message = "{$reviewerName} has completed evaluation for protocol {$this->protocolId} (Form: {$formName})";
        } else {
            $message = "{$reviewerName} has made progress on protocol {$this->protocolId} (Form: {$formName}) - Status: {$this->status}";
        }

        return [
            'protocol_id' => $this->protocolId,
            'reviewer_id' => $this->reviewerId,
            'reviewer_name' => $reviewerName,
            'status' => $this->status,
            'form_name' => $formName,
            'message' => $message,
            'action_url' => '/erb/dashboard',
            'type' => 'reviewer_progress',
            'icon' => '📊',
            'title' => 'Reviewer Progress Update',
        ];
    }
}