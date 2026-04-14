<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class FileUploaded extends Notification
{
    use Queueable;

    protected $student;
    protected $formId;
    protected $fileName;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $student, $formId, $fileName)
    {
        $this->student = $student;
        $this->formId = $formId;
        $this->fileName = $fileName;
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
        $studentName = $this->student->user_Fname . ' ' . $this->student->user_Lname;
        
        return [
            'student_id' => $this->student->user_ID,
            'student_name' => $studentName,
            'form_id' => $this->formId,
            'file_name' => $this->fileName,
            'message' => "{$studentName} has uploaded a new file: {$this->fileName}",
            'action_url' => '/admin/submissions', // Adjust to your admin submissions page
            'type' => 'file_uploaded',
            'icon' => '📤',
            'title' => 'New File Uploaded',
        ];
    }
}