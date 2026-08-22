<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TuitionFeeAccount;
use App\Models\CandidatePaymentAccount;
use App\Models\User;
use App\Mail\PaymentReminderEmail;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
    protected $description = 'Sends email, DB dashboard notifications, and WhatsApp reminders for upcoming and overdue payments.';

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
            // FIX: Fetch actual parent user via mobile number or user_id
            $parentUser = null;
            if (!empty($account->user_id)) {
                $parentUser = User::find($account->user_id);
            }
            if (!$parentUser && $account->mobile_number) {
                $parentUser = User::where('phone', $account->mobile_number)->first();
            }

            $email = $parentUser?->email;

            if (!$email) {
                Log::warning("SendPaymentReminders: No email for parent account #{$account->id} ({$account->parent_name}). Email skipped.");
            }

            $this->processAccount(
                name:       $account->parent_name,
                assignment: "Tuition for " . $account->student_name,
                amount:     $account->monthly_fee,
                dueDateStr: $account->next_due_date,
                mobile:     $account->mobile_number,
                email:      $email,
                userId:     $parentUser?->id,
            );
        }
    }

    private function processCandidates()
    {
        $accounts = CandidatePaymentAccount::where('status', 'active')->whereNotNull('next_due_date')->get();

        foreach ($accounts as $account) {
            // FIX: Fetch actual candidate user via phone number
            $candidateUser = null;
            if ($account->mobile_number) {
                $candidateUser = User::where('phone', $account->mobile_number)
                    ->where('role', 'candidate')
                    ->first();
            }
            if (!$candidateUser && $account->candidate_name) {
                $candidateUser = User::where('name', $account->candidate_name)
                    ->where('role', 'candidate')
                    ->first();
            }

            $email = $candidateUser?->email;

            if (!$email) {
                Log::warning("SendPaymentReminders: No email for candidate account #{$account->id} ({$account->candidate_name}). Email skipped.");
            }

            $this->processAccount(
                name:       $account->candidate_name,
                assignment: $account->tuition_assigned,
                amount:     $account->monthly_amount,
                dueDateStr: $account->next_due_date,
                mobile:     $account->mobile_number,
                email:      $email,
                userId:     $candidateUser?->id,
            );
        }
    }

    private function processAccount(
        string  $name,
        string  $assignment,
                $amount,
                $dueDateStr,
        ?string $mobile,
        ?string $email,
        ?int    $userId = null
    ) {
        $dueDate  = Carbon::parse($dueDateStr)->startOfDay();
        $today    = Carbon::today();
        $diffDays = $today->diffInDays($dueDate, false); // negative means overdue

        $statusText  = null;
        $isOverdue   = false;
        $notifyTitle = null;
        $notifyMsg   = null;

        if ($diffDays == 5) {
            $statusText  = "Payment Due in 5 Days";
            $notifyTitle = "⏰ Payment Due in 5 Days";
            $notifyMsg   = "Your payment of ₹{$amount} for {$assignment} is due on " . $dueDate->format('d M Y') . ". Please arrange in time.";
        } elseif ($diffDays == 2) {
            $statusText  = "Payment Due in 2 Days";
            $notifyTitle = "⚠️ Payment Due in 2 Days";
            $notifyMsg   = "Reminder: ₹{$amount} for {$assignment} is due on " . $dueDate->format('d M Y') . ".";
        } elseif ($diffDays == 0) {
            $statusText  = "Payment Due TODAY";
            $notifyTitle = "🔴 Payment Due Today";
            $notifyMsg   = "Today is the last day to pay ₹{$amount} for {$assignment}. Complete now to avoid late fees.";
        } elseif ($diffDays == -1) {
            $statusText  = "Payment is 1 Day Overdue";
            $notifyTitle = "🚨 Payment Overdue – Action Required";
            $notifyMsg   = "Your payment of ₹{$amount} for {$assignment} is now 1 day overdue. Late fees may apply.";
            $isOverdue   = true;
        } elseif ($diffDays < -1) {
            $daysLate    = abs((int) $diffDays);
            $statusText  = "Payment is {$daysLate} Days Overdue";
            $notifyTitle = "🚨 Payment {$daysLate} Days Overdue";
            $notifyMsg   = "URGENT: ₹{$amount} for {$assignment} is {$daysLate} days overdue. Please clear immediately to avoid further charges.";
            $isOverdue   = true;
        }

        if (!$statusText) {
            return; // No reminder needed for today
        }

        $details = [
            'name'        => $name,
            'assignment'  => $assignment,
            'amount'      => $amount,
            'due_date'    => $dueDateStr,
            'status_text' => $statusText,
            'is_overdue'  => $isOverdue,
        ];

        // --- 1. Send Email (FIX: actual user email, not admin placeholder) ---
        if ($email) {
            try {
                Mail::to($email)->send(new PaymentReminderEmail($details));
                $this->info("✅ Email → {$email} | {$name} — {$statusText}");
            } catch (\Exception $e) {
                Log::error("SendPaymentReminders: Email failed for {$email}: " . $e->getMessage());
            }
        }

        // --- 2. Send Dashboard DB Notification ---
        if ($userId && $notifyTitle) {
            try {
                DB::table('notifications')->insert([
                    'id'              => Str::uuid()->toString(),
                    'type'            => 'App\Notifications\PaymentReminder',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $userId,
                    'data'            => json_encode([
                        'title'   => $notifyTitle,
                        'message' => $notifyMsg,
                        'icon'    => $isOverdue ? 'fas fa-exclamation-circle' : 'fas fa-clock',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->info("✅ DB Notify → user#{$userId} | {$name} — {$statusText}");
            } catch (\Exception $e) {
                Log::error("SendPaymentReminders: DB notify failed for user#{$userId}: " . $e->getMessage());
            }
        }

        // --- 3. Send WhatsApp ---
        if ($mobile) {
            $whatsappMessage = "Hi {$name},\n\n{$statusText} for {$assignment}.\nAmount: ₹{$amount}\nDue Date: {$dueDateStr}\n\nPlease complete the payment as soon as possible.\n\n— Warriors Educare";
            try {
                WhatsAppService::sendMessage($mobile, $whatsappMessage);
                $this->info("✅ WhatsApp → {$mobile} | {$name} — {$statusText}");
            } catch (\Exception $e) {
                Log::warning("SendPaymentReminders: WhatsApp failed for {$mobile}: " . $e->getMessage());
            }
        }
    }
}
