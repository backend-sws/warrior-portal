<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\HomeTuitionLead;

class NewHomeTuitionLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $lead;

    /**
     * Create a new notification instance.
     */
    public function __construct(HomeTuitionLead $lead)
    {
        $this->lead = $lead;
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
            'type' => 'NewHomeTuitionLead',
            'lead_id' => $this->lead->id,
            'parent_name' => $this->lead->parent_name,
            'message' => 'New Home Tuition Request from ' . $this->lead->parent_name,
            'url' => route('admin.tuition-leads.show', $this->lead->id),
        ];
    }
}
