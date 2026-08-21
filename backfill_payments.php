<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$invoices = \App\Models\ServiceChargeInvoice::where('status', 'paid')->get();
foreach ($invoices as $invoice) {
    $user = $invoice->candidate;
    if (!$user) continue;

    $tuitionName = 'Online Service Charge';
    if ($invoice->job_application_id) {
        $jobApp = \App\Models\JobApplication::with('jobPost')->find($invoice->job_application_id);
        if ($jobApp && $jobApp->jobPost) {
            $tuitionName = $jobApp->jobPost->title;
        }
    }

    $account = \App\Models\CandidatePaymentAccount::where('mobile_number', $user->phone ?? $user->email)
        ->orWhere(function($q) use ($user, $tuitionName) {
            $q->where('candidate_name', $user->name)
              ->where('tuition_assigned', 'like', '%' . $tuitionName . '%');
        })
        ->first();

    if (!$account) {
        $account = \App\Models\CandidatePaymentAccount::create([
            'candidate_name' => $user->name,
            'mobile_number' => $user->phone ?? $user->email,
            'address' => $user->profile->address ?? 'Online',
            'tuition_assigned' => $tuitionName,
            'joining_date' => $invoice->payment_date ?? now(),
            'monthly_amount' => $invoice->amount,
            'next_due_date' => (\Carbon\Carbon::parse($invoice->payment_date ?? now()))->addMonth(),
            'status' => 'active'
        ]);
    }

    $exists = \App\Models\CandidatePaymentRecord::where('candidate_payment_account_id', $account->id)
        ->where('amount', $invoice->amount)
        ->whereDate('payment_date', \Carbon\Carbon::parse($invoice->payment_date ?? now()))
        ->exists();

    if (!$exists) {
        \App\Models\CandidatePaymentRecord::create([
            'candidate_payment_account_id' => $account->id,
            'payment_date' => $invoice->payment_date ?? now(),
            'amount' => $invoice->amount,
            'payment_mode' => 'Online Gateway (Backfilled)',
            'type' => 'Collected',
            'collected_by' => 'System (Auto)',
            'remarks' => 'Online Service Charge Payment for ' . $tuitionName
        ]);
    }
}
echo 'Backfilled ' . $invoices->count() . ' paid invoices.';
