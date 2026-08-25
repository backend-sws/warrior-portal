<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TuitionFeeAccount;
use Carbon\Carbon;

class UpdatePaymentStatuses extends Command
{
    protected $signature = 'payments:update-statuses';
    protected $description = 'Auto-mark overdue tuition fee accounts and reset statuses for upcoming cycles';

    public function handle()
    {
        $today = Carbon::today();

        // Mark accounts as overdue where due date has passed and payment is not yet recorded
        $overdueCount = TuitionFeeAccount::where('status', 'active')
            ->where('next_due_date', '<', $today)
            ->where('payment_status', '!=', 'paid')
            ->update(['payment_status' => 'overdue']);

        // Mark accounts as pending where due date is today and still marked as paid (new cycle)
        $pendingCount = TuitionFeeAccount::where('status', 'active')
            ->whereDate('next_due_date', $today)
            ->where('payment_status', 'paid')
            ->update(['payment_status' => 'pending']);

        $this->info("✅ Payment statuses updated: {$overdueCount} marked overdue, {$pendingCount} reset to pending.");

        return Command::SUCCESS;
    }
}
