<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\ServiceChargeInvoice;
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
        
        $paymentHistory = PaymentTransaction::where('candidate_id', $candidateId)
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
            ->with(['tuitionLead', 'jobApplication.jobPost'])
            ->firstOrFail();

        $amount = (float) ($invoice->amount + $invoice->late_fee);
        if ($amount <= 0) {
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Invalid invoice amount.');
        }

        $receipt = 'SC_' . $invoice->id . '_' . time();
        $gateway = $this->paymentManager->driver();

        // Create Razorpay Order
        $order = $gateway->createOrder([
            'amount'   => $amount,
            'receipt'  => $receipt,
            'notes'    => [
                'invoice_id'   => (string)$invoice->id,
                'user_id'      => (string)$user->id,
                'user_name'    => (string)$user->name,
                'user_email'   => (string)$user->email,
                'user_phone'   => (string)$user->phone,
                'type'         => 'service_charge',
            ]
        ]);

        if (!$order['success']) {
            Log::error('Razorpay Service Charge Order Creation Failed', ['error' => $order['error']]);
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
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in.');
        }

        $orderId   = $request->input('razorpay_order_id', session('active_order_id'));
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');

        if (empty($paymentId) || empty($orderId)) {
            Log::warning('Razorpay Callback Missing Parameters', $request->all());
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment was cancelled or failed to verify.');
        }

        // Verify with Razorpay
        $gateway = $this->paymentManager->driver();
        $verification = $gateway->verifyPayment([
            'order_id'   => $orderId,
            'payment_id' => $paymentId,
            'signature'  => $signature,
        ]);

        $txn = PaymentTransaction::where('order_id', $orderId)->first();

        if (!$verification['success']) {
            if ($txn) {
                $txn->update([
                    'status'            => 'failed',
                    'payment_id'        => $paymentId,
                    'signature'         => $signature,
                    'error_description' => $verification['error'] ?? 'Signature verification failed',
                ]);
            }
            return redirect()->route('candidate.serviceCharge.show')->with('error', 'Payment verification failed: ' . ($verification['error'] ?? 'Invalid signature.'));
        }

        // Verification Succeeded
        $paymentDetails = $verification['raw'] ?? [];
        $paymentMethod  = $verification['payment_method'] ?? 'online';
        $invoiceId      = $txn?->invoice_id ?? session('sc_invoice_id');

        $invoice = ServiceChargeInvoice::find($invoiceId);

        DB::transaction(function () use ($txn, $invoice, $user, $orderId, $paymentId, $signature, $paymentMethod, $paymentDetails) {
            $amount = $invoice ? ($invoice->amount + $invoice->late_fee) : ($txn?->amount ?? 0);

            if ($txn) {
                $txn->update([
                    'payment_id'       => $paymentId,
                    'signature'        => $signature,
                    'status'           => 'success',
                    'payment_method'   => $paymentMethod,
                    'gateway'          => 'razorpay',
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
                    '₹' . number_format($amount, 2) . ' received from ' . $user->name . ' via Razorpay (' . strtoupper($paymentMethod) . ').',
                    route('admin.transactions.index'),
                    'fas fa-receipt'
                );

                // Notify Candidate
                NotificationHelper::notifyUser(
                    $user->id,
                    'Service Charge Payment Confirmed ✅',
                    '₹' . number_format($amount, 2) . ' received successfully via Razorpay. Your receipt has been generated.',
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

        return redirect()->route('candidate.serviceCharge.show')->with('success', '✅ Payment verified and recorded successfully via Razorpay!');
    }

    public function invoice($id)
    {
        $user = auth()->user();
        $invoice = ServiceChargeInvoice::where('id', $id)
            ->where('candidate_id', $user->id)
            ->with(['candidate.profile', 'jobApplication.jobPost', 'tuitionLead'])
            ->firstOrFail();

        return view('candidate.serviceCharge.invoice', compact('invoice'));
    }

    private function syncToAdminCandidatePayments($candidate, $invoice, $amount)
    {
        try {
            $account = CandidatePaymentAccount::firstOrCreate(
                ['candidate_id' => $candidate->id],
                [
                    'candidate_name' => $candidate->name,
                    'mobile_number'  => $candidate->phone ?? 'N/A',
                    'role'           => $invoice->jobApplication?->jobPost?->title ?? ($invoice->tuitionLead ? 'Home Tutor' : 'Teacher'),
                    'school_name'    => $invoice->jobApplication?->jobPost?->school_name ?? ($invoice->tuitionLead ? 'Home Tuition' : 'Private Placement'),
                    'total_service_charge' => $amount,
                    'paid_amount'    => 0,
                    'pending_amount' => $amount,
                    'status'         => 'active',
                ]
            );

            $account->paid_amount += $amount;
            $account->pending_amount = max(0, $account->pending_amount - $amount);
            if ($account->pending_amount <= 0) {
                $account->status = 'completed';
            }
            $account->save();

            CandidatePaymentRecord::create([
                'candidate_payment_account_id' => $account->id,
                'amount'         => $amount,
                'payment_mode'   => 'Razorpay Online',
                'transaction_id' => 'RZP_' . time(),
                'payment_date'   => now(),
                'received_by'    => 'Razorpay Gateway',
                'notes'          => 'Online payment for Invoice #' . $invoice->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Sync to CandidatePaymentAccount failed: ' . $e->getMessage());
        }
    }
}
