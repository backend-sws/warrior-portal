<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;
    public $icon;
    public $sendEmail;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $url = null, $icon = 'fas fa-bell', $sendEmail = false)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->icon = $icon;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->sendEmail ? ['database', 'mail'] : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $mail = (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject(config('app.name') . ' - ' . $this->title)
            ->greeting('Hello ' . ($notifiable->name ?? '') . ',')
            ->line($this->message);

        if ($this->url) {
            $mail->action('View Details', $this->url);
        }

        return $mail->line('Thank you for using ' . config('app.name') . '!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'icon' => $this->icon,
        ];
    }
}
