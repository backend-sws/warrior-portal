<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('invoices:calculate-late-fees')]
#[Description('Calculate and apply daily late fees to overdue service charge invoices')]
class CalculateLateFees extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueInvoices = \App\Models\ServiceChargeInvoice::where('status', '!=', 'paid')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->get();

        $count = 0;
        foreach ($overdueInvoices as $invoice) {
            $dueDate = \Carbon\Carbon::parse($invoice->due_date)->startOfDay();
            $today = now()->startOfDay();
            $daysOverdue = (int) $dueDate->diffInDays($today);

            if ($daysOverdue > 0) {
                $newLateFee = $daysOverdue * 300; // Rs. 300 per day

                if ($newLateFee > (float)$invoice->late_fee) {
                    $difference = $newLateFee - (float)$invoice->late_fee;
                    
                    $invoice->update([
                        'late_fee' => $newLateFee,
                        'status'   => 'overdue'
                    ]);

                    // Update candidate profile pending amount
                    $candidate = \App\Models\User::find($invoice->candidate_id);
                    if ($candidate && $candidate->profile) {
                        $candidate->profile->increment('pending_amount', $difference);

                        // In-App Notification
                        \App\Helpers\NotificationHelper::notifyUser(
                            $candidate->id,
                            'Invoice Overdue: Late Fee Applied ⚠️',
                            'Invoice #' . ($invoice->invoice_number ?: $invoice->id) . ' is ' . $daysOverdue . ' days overdue. Late fine of ₹300/day (Total Fine: ₹' . number_format($newLateFee, 2) . ') is added. Total payable: ₹' . number_format($invoice->amount + $newLateFee, 2) . '.',
                            route('candidate.serviceCharge.show'),
                            'fas fa-exclamation-triangle'
                        );

                        // Send Email
                        try {
                            if ($candidate->email) {
                                \Illuminate\Support\Facades\Mail::to($candidate->email)->send(new \App\Mail\LateFeeAlertMail($invoice, $difference));
                            }
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::warning("Late Fee Email Exception: " . $e->getMessage());
                        }
                    }
                    $count++;
                }
            }
        }

        $this->info("Late fees calculated successfully. Updated $count invoices.");
    }
}
