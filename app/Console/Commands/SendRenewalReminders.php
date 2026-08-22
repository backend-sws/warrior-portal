<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Helpers\NotificationHelper;
use App\Mail\RenewalReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRenewalReminders extends Command
{
    protected $signature   = 'notifications:renewal-reminders';
    protected $description = 'Send DB + Email renewal reminders to candidates whose registration plan has expired (all applications used).';

    public function handle()
    {
        $this->info('Starting renewal reminder check...');

        // Find candidates who have used all their allowed applications and are not yet renewed
        $expiredCandidates = User::where('role', 'candidate')
            ->whereHas('profile', function ($q) {
                $q->whereColumn('used_applications', '>=', 'total_allowed_applications')
                  ->where('total_allowed_applications', '>', 0)
                  ->where('is_fee_paid', true); // Only registered candidates
            })
            ->with('profile')
            ->get();

        $count = 0;

        foreach ($expiredCandidates as $candidate) {
            $profile = $candidate->profile;
            if (!$profile) {
                continue;
            }

            // Check if we already sent a renewal reminder today to avoid spam
            $alreadyNotified = \Illuminate\Support\Facades\DB::table('notifications')
                ->where('notifiable_id', $candidate->id)
                ->where('type', 'App\Notifications\RenewalReminder')
                ->whereDate('created_at', today())
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            $remaining = $profile->total_allowed_applications - $profile->used_applications;

            // DB Notification
            NotificationHelper::notifyUser(
                $candidate->id,
                'Your Plan Has Expired — Renew Now 🔄',
                'You have used all ' . $profile->total_allowed_applications . ' of your application opportunities. Renew your registration plan to continue getting job opportunities.',
                route('candidate.dashboard'),
                'fas fa-redo-alt'
            );

            // Email
            if ($candidate->email) {
                try {
                    Mail::to($candidate->email)->send(new RenewalReminderMail($candidate));
                    $this->info("✅ Email → {$candidate->email} — Renewal Reminder");
                } catch (\Exception $e) {
                    Log::error("RenewalReminder email failed for {$candidate->email}: " . $e->getMessage());
                }
            }

            $count++;
        }

        $this->info("Renewal reminder check completed. Notified {$count} candidates.");
    }
}
