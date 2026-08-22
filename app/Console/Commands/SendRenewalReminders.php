<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Log;

class SendRenewalReminders extends Command
{
    protected $signature   = 'notifications:renewal-reminders';
    protected $description = 'Send DB reminders to candidates whose agreement or profile details are pending.';

    public function handle()
    {
        $this->info('Starting agreement & profile completion reminder check...');

        $pendingCandidates = User::where('role', 'candidate')
            ->whereHas('profile', function ($q) {
                $q->where('is_agreement_signed', false)
                  ->orWhere('is_tuition_agreement_signed', false);
            })
            ->with('profile')
            ->get();

        $count = 0;

        foreach ($pendingCandidates as $candidate) {
            $profile = $candidate->profile;
            if (!$profile) {
                continue;
            }

            // Check if we already sent an agreement reminder today to avoid spam
            $alreadyNotified = \Illuminate\Support\Facades\DB::table('notifications')
                ->where('notifiable_id', $candidate->id)
                ->where('type', 'App\Notifications\AgreementReminder')
                ->whereDate('created_at', today())
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            NotificationHelper::notifyUser(
                $candidate->id,
                'Sign Your Teacher & Tuition Agreement ✍️',
                'Action required: Please sign your candidate agreement to unlock full access to school jobs and home tuition requirements.',
                route('candidate.agreement.show'),
                'fas fa-file-signature'
            );

            $count++;
        }

        $this->info("Agreement check completed. Notified {$count} candidates.");
    }
}
