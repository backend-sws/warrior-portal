<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

echo "Sending anonymous mail...\n";

Notification::route('mail', 'test@warriorseducare.com')
    ->notify(new SystemNotification(
        'Welcome to Warriors Educare Test',
        'This is a test to verify that emails are logged properly.',
        'http://example.com/dashboard',
        'fas fa-handshake',
        true
    ));

echo "Notification dispatched to test@warriorseducare.com. Check storage/logs/laravel.log\n";
