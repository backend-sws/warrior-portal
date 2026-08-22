<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\ServiceChargeInvoice;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use App\Services\PhonePeService;

class ServiceChargeController extends Controller
{
    public function show()
    {
        $candidateId = auth()->id();
        $user = auth()->user();
        $profile = $user->profile;

        // Auto-create pending service charge invoice for standard plan remaining balance
        if ($profile && $profile->pending_amount > 0) {
            $hasPending = ServiceChargeInvoice::where('candidate_id', $candidateId)
                ->whereIn('status', ['pending', 'overdue'])
                ->exists();

            if (!$hasPending) {
                $latestApp = \App\Models\JobApplication::where('candidate_id', $candidateId)->latest()->first();

                ServiceChargeInvoice::create([
                    'candidate_id' => $candidateId,
                    'job_application_id' => $latestApp?->id,
                    'amount' => $profile->pending_amount,
                    'late_fee' => 0,
                    'due_date' => now()->addDays(7),
                    'status' => 'pending',
                    'description' => 'Standard Plan Remaining Placement Balance'
                ]);
            }
        }
        
        $invoices = ServiceChargeInvoice::where('candidate_id', $candidateId)
            ->latest()
            ->get();
        
        $paymentHistory = PaymentTransaction::where('candidate_id', $candidateId)
            ->where('type', 'service_charge')
            ->latest()
            ->get();
            
        return view('candidate.serviceCharge.show', compact('invoices', 'paymentHistory', 'profile'));
    }

    public function checkout($id)
    {
        $user = auth()->user();
        $invoice = ServiceChargeInvoice::where('id', $id)
            ->where('candidate_id', $user->id)
            ->whereIn('status', ['pending', 'overdue'])
            ->firstOrFail();

        $transactionId = 'SC_' . $invoice->id . '_' . time();
        session(['sc_invoice_id' => $invoice->id, 'last_txn_id' => $transactionId]);

        return view('candidate.serviceCharge.checkout', compact('invoice', 'transactionId'));
    }

    public function process(Request $request)
    {
        $request->validate(['invoice_id' => 'required|exists:service_charge_invoices,id']);
        $user = auth()->user();
        
        $invoice = ServiceChargeInvoice::where('id', $request->invoice_id)
            ->where('candidate_id', $user->id)
            ->whereIn('status', ['pending', 'overdue'])
            ->first();

        if (!$invoice) {
            return back()->with('error', 'No pending service charge invoice found.');
        }

        $amount = $invoice->amount + $invoice->late_fee;
        if ($amount <= 0) {
            return back()->with('error', 'Invalid invoice amount.');
        }

        // --- LOCAL BYPASS (Disabled for gateway testing) ---
        // if (env('APP_ENV') === 'local') {
        //     return redirect()->route('candidate.serviceCharge.callback', [
        //         'transactionId' => 'BYPASS_' . time(),
        //         'bypass' => true,
        //         'amount' => $amount
        //     ]);
        // }
        // --------------------

        $transactionId = 'SC_' . $invoice->id . '_' . time();
        session(['sc_invoice_id' => $invoice->id, 'last_txn_id' => $transactionId]);

        $redirectUrl = route('candidate.serviceCharge.callback');

        // Initiate payment via PhonePe V2
        $phonePe = new PhonePeService();
        $result = $phonePe->initiatePay($transactionId, $amount, $redirectUrl);

        if ($result['success']) {
            return redirect()->away($result['redirect_url']);
        }

        \Illuminate\Support\Facades\Log::info('PhonePe ServiceCharge Pay Initiation Fallback to Gateway Checkout', [
            'error' => $result['error'] ?? null,
        ]);

        return redirect()->route('candidate.serviceCharge.checkout', ['id' => $invoice->id]);
    }

    public function callback(Request $request)
    {
        $user = auth()->user();
        
        // --- LOCAL BYPASS ---
        if ($request->bypass && env('APP_ENV') === 'local') {
            $invoice = ServiceChargeInvoice::where('candidate_id', $user->id)->whereIn('status', ['pending', 'overdue'])->latest()->first();
            if ($invoice) {
                $invoice->update(['status' => 'paid', 'payment_date' => now()]);
                if ($user->profile) {
                    $user->profile->pending_amount = max(0, $user->profile->pending_amount - $invoice->amount);
                    $user->profile->save();
                }
                PaymentTransaction::create([
                    'candidate_id' => $user->id,
                    'amount' => $request->amount,
                    'transaction_id' => $request->transactionId,
                    'type' => 'service_charge',
                    'status' => 'success',
                    'gateway_response' => ['bypassed' => true]
                ]);

                // Sync to Admin Candidate Payments
                $this->syncToAdminCandidatePayments($user, $invoice, $request->amount);

                // Notify Admin
                $adminUser = \App\Models\User::where('role', 'admin')->first();
                if ($adminUser) {
                    \Illuminate\Support\Facades\DB::table('notifications')->insert([
                        'id'              => \Illuminate\Support\Str::uuid(),
                        'type'            => 'App\Notifications\ServiceChargePaid',
                        'notifiable_type' => 'App\Models\User',
                        'notifiable_id'   => $adminUser->id,
                        'data'            => json_encode([
                            'title'        => 'Service Charge Received',
                            'message'      => '₹' . $request->amount . ' was received from ' . $user->name . ' for Service Charge.',
                            'candidate_id' => $user->id,
                            'amount'       => $request->amount
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Notify Candidate — payment receipt
                NotificationHelper::notifyUser(
                    $user->id,
                    'Service Charge Payment Received ✅',
                    '₹' . number_format($request->amount, 2) . ' service charge payment received successfully. Thank you!',
                    route('candidate.serviceCharge.show'),
                    'fas fa-check-circle'
                );

                // Email receipt to Candidate
                try {
                    if ($invoice) {
                        \Illuminate\Support\Facades\Mail::to($user->email)->send(
                            new \App\Mail\ServiceChargePaymentReceiptMail($invoice, $user, $request->amount)
                        );
                    }
                } catch (\Exception $e) {
                    \Log::error('ServiceChargeReceipt Email Error: ' . $e->getMessage());
                }
            }
            return redirect()->route('candidate.serviceCharge.show')->with('success', 'Service charge paid successfully! (Local Bypass)');
        }
        // --------------------

        $transactionId = $request->merchantOrderId ?? $request->transactionId ?? session('last_txn_id');
        $invoiceId = session('sc_invoice_id');

        // Guard: If transactionId or user is missing, abort
        if (!$transactionId || !$user) {
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment session expired. Please try again.');
        }

        // Guard: Prevent duplicate processing
        $existingTxn = PaymentTransaction::where('transaction_id', $transactionId)->first();
        if ($existingTxn) {
            if ($existingTxn->status === 'success') {
                return redirect()->route('candidate.serviceCharge.show')->with('success', 'Payment already processed successfully.');
            }
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment failed or was already processed.');
        }

        // Verify status with PhonePe V2
        $phonePe = new PhonePeService();
        $statusResult = $phonePe->checkStatus($transactionId);

        // Log full response for debugging
        \Illuminate\Support\Facades\Log::info('PhonePe V2 Service Charge Callback', [
            'txn' => $transactionId,
            'invoice_id' => $invoiceId,
            'result' => $statusResult,
        ]);

        $isSuccess = $statusResult['success'];
        $amountPaid = $statusResult['amount'] / 100; // Convert paise to rupees

        // Always record transaction
        PaymentTransaction::create([
            'candidate_id' => $user->id,
            'amount' => $amountPaid,
            'transaction_id' => $transactionId,
            'type' => 'service_charge',
            'status' => $isSuccess ? 'success' : 'failed',
            'gateway_response' => $statusResult['raw']
        ]);

        // If payment failed, stop here — do NOT update invoice or profile
        if (!$isSuccess) {
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment failed or cancelled. Please try again.');
        }

        // Payment confirmed COMPLETED — update invoice and profile
        if ($invoiceId) {
            ServiceChargeInvoice::where('id', $invoiceId)->update([
                'status' => 'paid',
                'payment_date' => now()
            ]);
            $inv = ServiceChargeInvoice::find($invoiceId);
            if ($inv && $user->profile) {
                $user->profile->pending_amount = max(0, $user->profile->pending_amount - $inv->amount);
                if ($user->profile->pending_amount <= 0) {
                    $user->profile->is_fee_paid = true;
                }
                $user->profile->save();
            }
        } else {
            // Fallback to latest pending invoice
            $latestInvoice = ServiceChargeInvoice::where('candidate_id', $user->id)
                ->whereIn('status', ['pending', 'overdue'])
                ->latest()
                ->first();
            if ($latestInvoice) {
                $latestInvoice->update(['status' => 'paid', 'payment_date' => now()]);
                if ($user->profile) {
                    $user->profile->pending_amount = max(0, $user->profile->pending_amount - $latestInvoice->amount);
                    if ($user->profile->pending_amount <= 0) {
                        $user->profile->is_fee_paid = true;
                    }
                    $user->profile->save();
                }
            }
        }

        // Sync to Admin Candidate Payments
        $invToSync = $invoiceId ? ServiceChargeInvoice::find($invoiceId) : ($latestInvoice ?? null);
        if ($invToSync) {
            $this->syncToAdminCandidatePayments($user, $invToSync, $amountPaid);
        }

        // Notify Admin
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id'              => \Illuminate\Support\Str::uuid(),
                'type'            => 'App\Notifications\ServiceChargePaid',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id'   => $adminUser->id,
                'data'            => json_encode([
                    'title'        => 'Service Charge Received',
                    'message'      => '₹' . $amountPaid . ' was received from ' . $user->name . ' for Service Charge.',
                    'candidate_id' => $user->id,
                    'amount'       => $amountPaid
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Notify Candidate — payment receipt DB notification
        NotificationHelper::notifyUser(
            $user->id,
            'Service Charge Payment Received ✅',
            '₹' . number_format($amountPaid, 2) . ' service charge payment received successfully. Your invoice has been updated.',
            route('candidate.serviceCharge.show'),
            'fas fa-check-circle'
        );

        // Email receipt to Candidate
        $paidInvoice = $invoiceId ? ServiceChargeInvoice::find($invoiceId) : ($latestInvoice ?? null);
        if ($paidInvoice) {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(
                    new \App\Mail\ServiceChargePaymentReceiptMail($paidInvoice, $user, $amountPaid)
                );
            } catch (\Exception $e) {
                \Log::error('ServiceChargeReceipt Email Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('candidate.serviceCharge.show')->with('success', 'Service charge paid successfully!');
    }

    public function downloadInvoicePdf($id)
    {
        $candidateId = auth()->id();
        $invoice = ServiceChargeInvoice::where('id', $id)
            ->where('candidate_id', $candidateId)
            ->with(['jobApplication.jobPost', 'candidate'])
            ->firstOrFail();

        $user = auth()->user();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('candidate.serviceCharge.invoice_pdf', [
            'invoice' => $invoice,
            'user' => $user
        ]);

        return $pdf->download('Service-Charge-Invoice-' . $invoice->id . '.pdf');
    }

    private function syncToAdminCandidatePayments($user, $invoice, $amountPaid)
    {
        $tuitionName = 'Online Service Charge';
        if ($invoice && $invoice->job_application_id) {
            $jobApp = \App\Models\JobApplication::with('jobPost')->find($invoice->job_application_id);
            if ($jobApp && $jobApp->jobPost) {
                $tuitionName = $jobApp->jobPost->title;
            }
        }

        $account = \App\Models\CandidatePaymentAccount::where('mobile_number', $user->phone ?? $user->email)
            ->orWhere(function($q) use ($user, $tuitionName) {
                $q->where('candidate_name', $user->name)
                  ->where('tuition_assigned', 'like', "%{$tuitionName}%");
            })
            ->first();

        if (!$account) {
            $account = \App\Models\CandidatePaymentAccount::create([
                'candidate_name' => $user->name,
                'mobile_number' => $user->phone ?? $user->email,
                'address' => $user->profile->address ?? 'Online',
                'tuition_assigned' => $tuitionName,
                'joining_date' => now(),
                'monthly_amount' => $amountPaid,
                'next_due_date' => now()->addMonth(),
                'status' => 'active'
            ]);
        }

        \App\Models\CandidatePaymentRecord::create([
            'candidate_payment_account_id' => $account->id,
            'payment_date' => now(),
            'amount' => $amountPaid,
            'payment_mode' => 'Online Gateway',
            'type' => 'Collected',
            'collected_by' => 'System (Auto)',
            'remarks' => 'Online Service Charge Payment for ' . $tuitionName
        ]);
    }
}
