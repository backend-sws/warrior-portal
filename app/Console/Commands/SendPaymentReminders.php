<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TuitionFeeAccount;
use App\Models\CandidatePaymentAccount;
use App\Mail\PaymentReminderEmail;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends email and WhatsApp reminders for upcoming and overdue payments.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting payment reminders check...');

        $this->processParents();
        $this->processCandidates();

        $this->info('Payment reminders check completed.');
    }

    private function processParents()
    {
        $accounts = TuitionFeeAccount::where('status', 'active')->whereNotNull('next_due_date')->get();

        foreach ($accounts as $account) {
            $this->processAccount(
                $account->parent_name,
                "Tuition for " . $account->student_name,
                $account->monthly_fee,
                $account->next_due_date,
                $account->mobile_number,
                // Assuming we use candidate's email if available, or just log. We don't have parent email in TuitionFeeAccount.
                // We'll log a warning if email is missing.
                'admin@warriorseducare.com' // Placeholder email
            );
        }
    }

    private function processCandidates()
    {
        $accounts = CandidatePaymentAccount::where('status', 'active')->whereNotNull('next_due_date')->get();

        foreach ($accounts as $account) {
            $this->processAccount(
                $account->candidate_name,
                $account->tuition_assigned,
                $account->monthly_amount,
                $account->next_due_date,
                $account->mobile_number,
                'admin@warriorseducare.com' // Placeholder email
            );
        }
    }

    private function processAccount($name, $assignment, $amount, $dueDateStr, $mobile, $email)
    {
        $dueDate = Carbon::parse($dueDateStr)->startOfDay();
        $today = Carbon::today();
        $diffDays = $today->diffInDays($dueDate, false); // negative if past

        $statusText = null;
        $isOverdue = false;

        // Due in 2 days
        if ($diffDays == 2) {
            $statusText = "Payment Due in 2 Days";
        }
        // Due today
        elseif ($diffDays == 0) {
            $statusText = "Payment Due TODAY";
        }
        // Overdue by 1 day
        elseif ($diffDays == -1) {
            $statusText = "Payment is 1 Day Overdue";
            $isOverdue = true;
        }

        if ($statusText) {
            $details = [
                'name' => $name,
                'assignment' => $assignment,
                'amount' => $amount,
                'due_date' => $dueDateStr,
                'status_text' => $statusText,
                'is_overdue' => $isOverdue
            ];

            // Send Email
            try {
                Mail::to($email)->send(new PaymentReminderEmail($details));
                $this->info("Sent email to {$email} for {$name} - {$statusText}");
            } catch (\Exception $e) {
                Log::error("Failed to send payment reminder email to {$email}: " . $e->getMessage());
            }

            // Send WhatsApp
            $whatsappMessage = "Hi {$name},\n\n{$statusText} for {$assignment}.\nAmount: ₹{$amount}\nDue Date: {$dueDateStr}\n\nPlease complete the payment as soon as possible.";
            WhatsAppService::sendMessage($mobile, $whatsappMessage);
            $this->info("Sent WhatsApp to {$mobile} for {$name} - {$statusText}");
        }
    }
}
