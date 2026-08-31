<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

// Daily late fee calculation (runs at midnight)
Schedule::command('invoices:calculate-late-fees')->dailyAt('00:01');

// Abandoned registration reminders
Schedule::command('reminders:abandoned-registration')->dailyAt('10:00');

// Interview reminders (24hr before)
Schedule::command('reminders:interview')->dailyAt('08:00');

// CRM lead follow-up alerts to admin
Schedule::command('reminders:lead-follow-ups')->dailyAt('09:00');

// Payment reminders (parents & candidates) — 5-day, 2-day, due-day, overdue
Schedule::command('payments:send-reminders')->dailyAt('08:30');

// Service charge reminders — candidates with pending invoices
Schedule::command('notifications:service-charge-reminders')->dailyAt('09:00');

// Renewal reminders — candidates with expired plans
Schedule::command('notifications:renewal-reminders')->dailyAt('10:00');

// Auto-process background queue jobs (Optimized for Shared Hosting crons)
Schedule::command('queue:work --stop-when-empty --tries=3 --timeout=60')->everyMinute()->withoutOverlapping();

