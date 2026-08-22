<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceChargeInvoice;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SendServiceChargeReminders extends Command
{
    protected $signature   = 'notifications:service-charge-reminders';
    protected $description = 'Send DB + Email reminders for service charge invoices due in 5 days, 2 days, today, and daily overdue.';

    public function handle()
    {
        $this->info('Starting service charge reminder check...');

        $invoices = ServiceChargeInvoice::whereIn('status', ['pending', 'overdue'])
            ->with(['candidate', 'jobApplication.jobPost'])
            ->get();

        $count = 0;

        foreach ($invoices as $invoice) {
            $candidate = User::find($invoice->candidate_id);
            if (!$candidate) {
                continue;
            }

            $dueDate  = Carbon::parse($invoice->due_date)->startOfDay();
            $today    = Carbon::today();
            $diffDays = $today->diffInDays($dueDate, false); // negative = overdue

            $notifyTitle = null;
            $notifyMsg   = null;
            $sendEmail   = false;

            if ($diffDays == 5) {
                $notifyTitle = '⏰ Service Charge Due in 5 Days';
                $notifyMsg   = 'Your service charge of ₹' . number_format($invoice->amount + $invoice->late_fee, 2) . ' is due on ' . $dueDate->format('d M Y') . '. Please arrange payment.';
                $sendEmail   = true;
            } elseif ($diffDays == 2) {
                $notifyTitle = '⚠️ Service Charge Due in 2 Days';
                $notifyMsg   = 'Reminder: ₹' . number_format($invoice->amount + $invoice->late_fee, 2) . ' service charge payment is due on ' . $dueDate->format('d M Y') . '.';
                $sendEmail   = true;
            } elseif ($diffDays == 0) {
                $notifyTitle = '🔴 Service Charge Due Today';
                $notifyMsg   = 'Today is the last day to pay ₹' . number_format($invoice->amount + $invoice->late_fee, 2) . ' service charge. Pay now to avoid late fees.';
                $sendEmail   = true;
            } elseif ($diffDays < 0) {
                $daysLate    = abs((int) $diffDays);
                $notifyTitle = '🚨 Service Charge ' . $daysLate . ' Days Overdue';
                $notifyMsg   = 'URGENT: Your service charge of ₹' . number_format($invoice->amount + $invoice->late_fee, 2) . ' is ' . $daysLate . ' days overdue. Late fees apply daily.';
                $sendEmail   = ($daysLate % 3 === 1); // Email every 3 days to avoid spam
            }

            if (!$notifyTitle) {
                continue;
            }

            // DB Dashboard Notification
            try {
                DB::table('notifications')->insert([
                    'id'              => Str::uuid()->toString(),
                    'type'            => 'App\Notifications\ServiceChargeReminder',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id'   => $candidate->id,
                    'data'            => json_encode([
                        'title'      => $notifyTitle,
                        'message'    => $notifyMsg,
                        'icon'       => $diffDays < 0 ? 'fas fa-exclamation-circle' : 'fas fa-clock',
                        'invoice_id' => $invoice->id,
                        'url'        => route('candidate.serviceCharge.show'),
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->info("✅ DB Notify → {$candidate->name} — {$notifyTitle}");
            } catch (\Exception $e) {
                Log::error("ServiceChargeReminder DB notify failed for {$candidate->id}: " . $e->getMessage());
            }

            // Email Notification (on selective days to avoid spam)
            if ($sendEmail && $candidate->email) {
                try {
                    Mail::to($candidate->email)->send(
                        new \App\Mail\LateFeeAlertMail($invoice, $invoice->late_fee)
                    );
                    $this->info("✅ Email → {$candidate->email} — {$notifyTitle}");
                } catch (\Exception $e) {
                    Log::error("ServiceChargeReminder email failed for {$candidate->email}: " . $e->getMessage());
                }
            }

            $count++;
        }

        $this->info("Service charge reminder check completed. Processed {$count} invoices.");
    }
}
