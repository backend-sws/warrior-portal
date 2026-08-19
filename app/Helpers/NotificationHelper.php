<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class NotificationHelper
{
    /**
     * Send a notification to all admin users.
     */
    public static function notifyAdmin($title, $message, $url = null, $icon = 'fas fa-bell', $sendEmail = false)
    {
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new SystemNotification($title, $message, $url, $icon, $sendEmail));
    }

    /**
     * Send a notification to a specific user.
     */
    public static function notifyUser($userId, $title, $message, $url = null, $icon = 'fas fa-bell', $sendEmail = false)
    {
        $user = User::find($userId);
        if ($user) {
            $user->notify(new SystemNotification($title, $message, $url, $icon, $sendEmail));
        }
    }

    /**
     * Send a notification to multiple users.
     */
    public static function notifyUsers($userIds, $title, $message, $url = null, $icon = 'fas fa-bell', $sendEmail = false)
    {
        $users = User::whereIn('id', $userIds)->get();
        if ($users->isNotEmpty()) {
            Notification::send($users, new SystemNotification($title, $message, $url, $icon, $sendEmail));
        }
    }
}
