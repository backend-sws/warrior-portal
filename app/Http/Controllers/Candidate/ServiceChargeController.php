<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\ServiceChargeInvoice;
use App\Models\CandidateRefund;
use App\Models\PaymentTransaction;
use App\Models\CandidatePaymentAccount;
use App\Models\CandidatePaymentRecord;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ServiceChargeController extends Controller
{
    protected PaymentGatewayManager $paymentManager;

    public function __construct(PaymentGatewayManager $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    public function show()
    {
        $candidateId = auth()->id();
        $user = auth()->user();
        $profile = $user->profile;
        
        $invoices = ServiceChargeInvoice::where('candidate_id', $candidateId)
            ->with(['tuitionLead', 'jobApplication.jobPost'])
            ->latest()
            ->get();

        // Real-time Late Fee Sync (₹300 per day after due date)
        foreach ($invoices as $inv) {
            if ($inv->status !== 'paid' && $inv->due_date && \Carbon\Carbon::parse($inv->due_date)->startOfDay()->isPast()) {
                $daysOverdue = (int) \Carbon\Carbon::parse($inv->due_date)->startOfDay()->diffInDays(now()->startOfDay());
                if ($daysOverdue > 0) {
                    $calculatedFee = $daysOverdue * 300;
                    if ($calculatedFee > (float)$inv->late_fee) {
                        $diff = $calculatedFee - (float)$inv->late_fee;
                        $inv->update([
                            'late_fee' => $calculatedFee,
                            'status'   => 'overdue'
                        ]);
                        if ($profile) {
                            $profile->increment('pending_amount', $diff);
                        }
                    }
                }
            }
        }
        
        $paymentHistory = PaymentTransaction::where('candidate_id', $candidateId)
            ->where('status', 'success')
            ->latest()
            ->get();

        $refunds = CandidateRefund::where('candidate_id', $candidateId)
            ->latest()
            ->get();
            
        return view('candidate.serviceCharge.show', compact('invoices', 'paymentHistory', 'profile', 'refunds'));
    }

    public function checkout($id)
    {
        $user = auth()->user();
        $invoice = ServiceChargeInvoice::where('id', $id)
            ->where('candidate_id', $user->id)
            ->whereIn('status', ['pending', 'overdue'])
            ->with(['tuitionLead', 'jobApplication.jobPost'])
            ->firstOrFail();

        // Real-time Late Fee Sync (₹300 per day after due date)
        if ($invoice->status !== 'paid' && $invoice->due_date && \Carbon\Carbon::parse($invoice->due_date)->startOfDay()->isPast()) {
            $daysOverdue = (int) \Carbon\Carbon::parse($invoice->due_date)->startOfDay()->diffInDays(now()->startOfDay());
            if ($daysOverdue > 0) {
                $calculatedFee = $daysOverdue * 300;
                if ($calculatedFee > (float)$invoice->late_fee) {
                    $diff = $calculatedFee - (float)$invoice->late_fee;
                    $invoice->update([
                        'late_fee' => $calculatedFee,
                        'status'   => 'overdue'
                    ]);
                    if ($user->profile) {
                        $user->profile->increment('pending_amount', $diff);
                    }
                }
            }
        }

        $amount = (float) ($invoice->amount + $invoice->late_fee);
        if ($amount <= 0) {
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Invalid invoice amount.');
        }

        $receipt = 'SC_' . $invoice->id . '_' . time();
        $gateway = $this->paymentManager->driver();
        $order = $gateway->createOrder([
            'amount'       => $amount,
            'receipt'      => $receipt,
            'redirect_url' => route('candidate.serviceCharge.callback'),
            'notes'        => [
                'invoice_id'   => (string)$invoice->id,
                'user_id'      => (string)$user->id,
                'user_name'    => (string)$user->name,
                'user_email'   => (string)$user->email,
                'user_phone'   => (string)$user->phone,
                'type'         => 'service_charge',
            ]
        ]);

        if (!$order['success']) {
            Log::error('Service Charge Order Creation Failed', ['error' => $order['error']]);
            return back()->with('error', 'Payment gateway error: ' . ($order['error'] ?? 'Please try again later.'));
        }

        // Record Pending Payment Transaction
        PaymentTransaction::updateOrCreate(
            ['order_id' => $order['order_id']],
            [
                'candidate_id'   => $user->id,
                'amount'         => $amount,
                'currency'       => 'INR',
                'transaction_id' => $receipt,
                'type'           => 'service_charge',
                'status'         => 'pending',
                'gateway'        => $gateway->getGatewayName(),
                'invoice_id'     => $invoice->id,
                'tuition_lead_id'=> $invoice->home_tuition_lead_id,
                'ip_address'     => request()->ip(),
            ]
        );

        session(['active_order_id' => $order['order_id'], 'sc_invoice_id' => $invoice->id]);

        return view('candidate.serviceCharge.checkout', compact('invoice', 'order', 'user'));
    }

    public function callback(Request $request)
    {
        $orderId = $request->input('merchantOrderId')
            ?? $request->input('merchantTransactionId')
            ?? $request->input('order_id')
            ?? $request->input('razorpay_order_id')
            ?? session('active_order_id');

        $paymentId = $request->input('orderId')
            ?? $request->input('transactionId')
            ?? $request->input('payment_id')
            ?? $request->input('razorpay_payment_id')
            ?? ($orderId ? 'PP_' . $orderId : null);

        $code = $request->input('code', 'PAYMENT_SUCCESS');

        $txn = !empty($orderId) ? PaymentTransaction::where('order_id', $orderId)->first() : null;

        $user = auth()->user();
        if (!$user && $txn && $txn->candidate_id) {
            $user = \App\Models\User::find($txn->candidate_id);
            if ($user) {
                auth()->login($user);
            }
        }

        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in.');
        }

        if (empty($orderId)) {
            Log::warning('Payment Callback Missing Order ID', $request->all());
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment was cancelled or failed to verify.');
        }

        // Verify with Gateway
        $gateway = $this->paymentManager->driver();
        $verification = $gateway->verifyPayment([
            'order_id'       => $orderId,
            'payment_id'     => $paymentId,
            'code'           => $code,
            'response'       => $request->input('response'),
        ]);

        $txn = PaymentTransaction::where('order_id', $orderId)->first();

        if (!$verification['success']) {
            if ($txn) {
                $txn->update([
                    'status'            => 'failed',
                    'payment_id'        => $paymentId,
                    'gateway'           => 'phonepe',
                    'error_description' => $verification['error'] ?? 'Payment verification failed',
                ]);
            }
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment verification failed: ' . ($verification['error'] ?? 'Transaction was declined.'));
        }

        // Verification Succeeded
        $paymentDetails = $verification['raw'] ?? [];
        $paymentMethod  = $verification['payment_method'] ?? 'phonepe_online';
        $finalPaymentId = $verification['payment_id'] ?: ($paymentId ?: 'PP_' . $orderId);
        $invoiceId      = $txn?->invoice_id ?? session('sc_invoice_id');

        $invoice = ServiceChargeInvoice::find($invoiceId);

        DB::transaction(function () use ($txn, $invoice, $user, $orderId, $finalPaymentId, $paymentMethod, $paymentDetails) {
            $amount = $invoice ? ($invoice->amount + $invoice->late_fee) : ($txn?->amount ?? 0);

            if ($txn) {
                $txn->update([
                    'payment_id'       => $finalPaymentId,
                    'status'           => 'success',
                    'payment_method'   => $paymentMethod,
                    'gateway'          => 'phonepe',
                    'gateway_response' => $paymentDetails,
                ]);
            }

            if ($invoice && $invoice->status !== 'paid') {
                $invoice->update([
                    'status'       => 'paid',
                    'payment_date' => now(),
                ]);

                if ($user->profile) {
                    $user->profile->update([
                        'pending_amount' => max(0, (float)$user->profile->pending_amount - (float)$invoice->amount),
                        'is_fee_paid'    => true,
                    ]);
                }

                // Sync to Admin Candidate Payments
                $this->syncToAdminCandidatePayments($user, $invoice, $amount);

                // Notify Admin
                NotificationHelper::notifyAdmin(
                    'Service Charge Received 💳',
                    '₹' . number_format($amount, 2) . ' received from ' . $user->name . ' via PhonePe (' . strtoupper($paymentMethod) . ').',
                    route('admin.transactions.index'),
                    'fas fa-receipt'
                );

                // Notify Candidate
                NotificationHelper::notifyUser(
                    $user->id,
                    'Service Charge Payment Confirmed ✅',
                    '₹' . number_format($amount, 2) . ' received successfully via PhonePe. Your receipt has been generated.',
                    route('candidate.serviceCharge.show'),
                    'fas fa-check-circle'
                );

                // Email Receipt
                try {
                    Mail::to($user->email)->send(
                        new \App\Mail\ServiceChargePaymentReceiptMail($invoice, $user, $amount)
                    );
                } catch (\Exception $e) {
                    Log::error('ServiceChargeReceipt Email Error: ' . $e->getMessage());
                }
            }
        });

        session()->forget(['active_order_id', 'sc_invoice_id']);

        return redirect()->route('candidate.serviceCharge.show')->with('success', '✅ Payment verified and recorded successfully via PhonePe!');
    }

    public function invoice($id)
    {
        return $this->downloadInvoicePdf($id);
    }

    public function downloadInvoicePdf($id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view the invoice.');
        }

        $invoice = ServiceChargeInvoice::where('id', $id)
            ->where('candidate_id', $user->id)
            ->with(['candidate.profile', 'jobApplication.jobPost', 'tuitionLead'])
            ->firstOrFail();

        if ($invoice->status !== 'paid') {
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Invoice can only be downloaded after payment is completed.');
        }

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('candidate.serviceCharge.invoice_pdf', compact('invoice', 'user'));
            return $pdf->download('Invoice_' . ($invoice->invoice_number ?: $invoice->id) . '.pdf');
        }

        return view('candidate.serviceCharge.invoice_pdf', compact('invoice', 'user'));
    }

    private function syncToAdminCandidatePayments($candidate, $invoice, $amount)
    {
        try {
            $phone = $candidate->phone ?? ($candidate->email ?? 'N/A');
            $tuitionTitle = $invoice->jobApplication?->jobPost?->title ?? ($invoice->tuitionLead ? "Class {$invoice->tuitionLead->class} ({$invoice->tuitionLead->subjects})" : 'Tuition Service Charge');

            $account = CandidatePaymentAccount::where('mobile_number', $phone)
                ->orWhere('candidate_name', $candidate->name)
                ->first();

            if (!$account) {
                $account = CandidatePaymentAccount::create([
                    'candidate_name'   => $candidate->name,
                    'mobile_number'    => $phone,
                    'address'          => $candidate->profile?->address ?? 'Online',
                    'tuition_assigned' => $tuitionTitle,
                    'joining_date'     => now()->toDateString(),
                    'monthly_amount'   => $amount,
                    'status'           => 'active',
                    'next_due_date'    => null, // One-time fee, not a recurring monthly invoice
                ]);
            }

            // Prevent duplicate CandidatePaymentRecord
            $alreadyRecorded = CandidatePaymentRecord::where('candidate_payment_account_id', $account->id)
                ->where('remarks', 'like', "%Invoice #{$invoice->id}%")
                ->exists();

            if (!$alreadyRecorded) {
                CandidatePaymentRecord::create([
                    'candidate_payment_account_id' => $account->id,
                    'payment_date'   => now()->toDateString(),
                    'amount'         => $amount,
                    'payment_mode'   => 'PhonePe Online',
                    'type'           => 'Collected',
                    'collected_by'   => 'PhonePe Gateway',
                    'remarks'        => 'Online payment for Invoice #' . $invoice->id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Sync to CandidatePaymentAccount failed: ' . $e->getMessage());
        }
    }
}
