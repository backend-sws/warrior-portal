<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\ServiceChargeInvoice;
use App\Models\CandidateProfile;
use Illuminate\Support\Str;

class TestMailablesCommand extends Command
{
    protected $signature = 'test:mailables';
    protected $description = 'Render all 9 new mailables to verify blade templates have no missing variables or syntax errors.';

    public function handle()
    {
        $this->info('Starting mailables rendering test...');

        // Dummy Data Setup
        $candidate = new User(['id' => 1, 'name' => 'Test Candidate', 'email' => 'candidate@example.com', 'role' => 'candidate']);
        $candidate->profile = new CandidateProfile(['total_allowed_applications' => 5, 'used_applications' => 5, 'is_fee_paid' => true]);

        $employer = new User(['id' => 2, 'name' => 'Test Employer', 'email' => 'employer@example.com', 'role' => 'employer']);

        $job = new JobPost(['id' => 1, 'title' => 'Math Teacher', 'school_name' => 'DPS School', 'contact_person' => 'Mr. Principal', 'email' => 'school@example.com']);
        
        $application = new JobApplication(['id' => 1, 'candidate_id' => $candidate->id, 'job_post_id' => $job->id, 'interview_date' => now()->addDays(2)]);
        $application->setRelation('candidate', $candidate);
        $application->setRelation('jobPost', $job);

        $invoice = new ServiceChargeInvoice(['id' => 1, 'candidate_id' => $candidate->id, 'amount' => 1000, 'late_fee' => 250, 'due_date' => now()->subDays(5), 'status' => 'overdue']);
        $invoice->setRelation('candidate', $candidate);

        $mailables = [
            'WelcomeCandidateMail'            => new \App\Mail\WelcomeCandidateMail($candidate, 'password123'),
            'PaymentFailedMail'               => new \App\Mail\PaymentFailedMail($candidate, 500, 'Registration Fee'),
            'AgreementPendingMail'            => new \App\Mail\AgreementPendingMail($candidate),
            'InterviewScheduledMail'          => new \App\Mail\InterviewScheduledMail($application),
            'ServiceChargePaymentReceiptMail' => new \App\Mail\ServiceChargePaymentReceiptMail($invoice, $candidate, 1000),
            'RenewalReminderMail'             => new \App\Mail\RenewalReminderMail($candidate),
            'InvoicePaidByAdminMail'          => new \App\Mail\InvoicePaidByAdminMail($invoice, $candidate),
            'JobRejectedMail'                 => new \App\Mail\JobRejectedMail($job, 'Not enough details provided.'),
            'CustomAdminMessageMail'          => new \App\Mail\CustomAdminMessageMail($candidate, 'Important Update', 'This is a test custom message from admin.'),
        ];

        $failed = 0;

        foreach ($mailables as $name => $mailable) {
            try {
                // Attempt to render the mailable to string to catch blade syntax errors
                $rendered = $mailable->render();
                $this->info("✅ {$name} rendered successfully.");
            } catch (\Exception $e) {
                $this->error("❌ {$name} failed to render: " . $e->getMessage());
                $failed++;
            }
        }

        if ($failed > 0) {
            $this->error("Testing complete. {$failed} mailables failed.");
            return Command::FAILURE;
        }

        $this->info('All 9 mailables rendered successfully with no template errors.');
        return Command::SUCCESS;
    }
}
