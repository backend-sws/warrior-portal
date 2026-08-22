<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\NotificationHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendInterviewReminders extends Command
{
    protected $signature   = 'reminders:interview';
    protected $description = 'Send DB notification + email reminder to candidates exactly 24 hours before their scheduled interview';

    public function handle()
    {
        $applications = \App\Models\JobApplication::whereNotNull('interview_date')
            ->where('interview_reminder_sent', false)
            ->whereBetween('interview_date', [now(), now()->addHours(24)])
            ->with(['candidate', 'jobPost'])
            ->get();

        $count = 0;

        foreach ($applications as $application) {
            $candidate  = $application->candidate;
            $jobPost    = $application->jobPost;
            $interviewDt = Carbon::parse($application->interview_date)->format('d M Y, h:i A');

            if (!$candidate) {
                continue;
            }

            // 1. Email Reminder (existing)
            try {
                Mail::to($candidate->email)->send(new \App\Mail\InterviewReminderMail($application));
            } catch (\Exception $e) {
                Log::error("InterviewReminder email failed for {$candidate->email}: " . $e->getMessage());
            }

            // 2. DB Dashboard Notification (NEW)
            NotificationHelper::notifyUser(
                $candidate->id,
                '🎯 Interview Tomorrow – Be Prepared!',
                'Reminder: Your interview for "' . ($jobPost->title ?? 'a position') . '" at ' . ($jobPost->school_name ?? 'the school') . ' is scheduled for tomorrow at ' . $interviewDt . '. All the best!',
                route('candidate.applications.index'),
                'fas fa-calendar-check'
            );

            $application->update(['interview_reminder_sent' => true]);
            $count++;

            $this->info("✅ Reminder sent to {$candidate->email} — {$interviewDt}");
        }

        $this->info("Interview reminder job completed. Sent {$count} reminders.");
    }
}
