<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\Payment\PaymentGatewayManager;
use App\Models\PaymentTransaction;
use App\Helpers\NotificationHelper;

class PaymentController extends Controller
{
    private PaymentGatewayManager $paymentManager;

    public function __construct(PaymentGatewayManager $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    public function show(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;
        $isRenewal = $request->query('type') === 'renewal';

        return view('candidate.payment.show', compact('user', 'profile', 'isRenewal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:basic,premium,renewal_basic,renewal_premium,upgrade'
        ]);

        $user = auth()->user();
        $isRenewal = str_starts_with($request->plan, 'renewal');
        $isUpgrade = $request->plan === 'upgrade';
        
        $amount = 500;
        if ($request->plan === 'premium' || $request->plan === 'renewal_premium') $amount = 1000;
        if ($isUpgrade) $amount = 500;
        
        $profile = $user->profile;

        $prefix = 'TXN_';
        if ($request->plan === 'renewal_basic') $prefix = 'RENEW_BASIC_';
        if ($request->plan === 'renewal_premium') $prefix = 'RENEW_PREMIUM_';
        if ($isUpgrade) $prefix = 'UPGRADE_';
        $receipt = $prefix . $user->id . '_' . time();

        $gateway = $this->paymentManager->driver();

        $order = $gateway->createOrder([
            'amount'   => $amount,
            'receipt'  => $receipt,
            'notes'    => [
                'user_id'    => (string)$user->id,
                'user_name'  => (string)$user->name,
                'plan'       => $request->plan,
                'type'       => 'registration_fee',
            ]
        ]);

        if (!$order['success']) {
            return back()->with('error', 'Failed to initiate payment: ' . ($order['error'] ?? 'Please try again.'));
        }

        PaymentTransaction::create([
            'candidate_id'   => $user->id,
            'amount'         => $amount,
            'currency'       => 'INR',
            'transaction_id' => $receipt,
            'order_id'       => $order['order_id'],
            'type'           => 'registration_fee',
            'status'         => 'pending',
            'gateway'        => $gateway->getGatewayName(),
            'ip_address'     => request()->ip(),
        ]);

        session(['active_payment_order_id' => $order['order_id'], 'pending_plan_choice' => $request->plan]);

        return response()->json([
            'success' => true,
            'order'   => $order,
        ]);
    }

    public function callback(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in.');
        }

        $orderId   = $request->input('razorpay_order_id', session('active_payment_order_id'));
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');

        if (empty($paymentId) || empty($orderId)) {
            return redirect()->route('candidate.dashboard')->with('error', 'Payment cancelled or verification failed.');
        }

        $gateway = $this->paymentManager->driver();
        $verification = $gateway->verifyPayment([
            'order_id'   => $orderId,
            'payment_id' => $paymentId,
            'signature'  => $signature,
        ]);

        $txn = PaymentTransaction::where('order_id', $orderId)->first();

        if (!$verification['success']) {
            if ($txn) {
                $txn->update(['status' => 'failed', 'payment_id' => $paymentId, 'signature' => $signature]);
            }
            return redirect()->route('candidate.dashboard')->with('error', 'Payment verification failed.');
        }

        if ($txn) {
            $txn->update([
                'payment_id'       => $paymentId,
                'signature'        => $signature,
                'status'           => 'success',
                'payment_method'   => $verification['payment_method'] ?? 'online',
                'gateway'          => 'razorpay',
                'gateway_response' => $verification['raw'] ?? [],
            ]);
        }

        if ($user->profile) {
            $user->profile->update([
                'is_fee_paid' => true,
                'paid_amount' => (float)$user->profile->paid_amount + (float)($txn?->amount ?? 0),
            ]);
        }

        NotificationHelper::notifyAdmin(
            'Candidate Payment Received 💳',
            '₹' . number_format($txn?->amount ?? 0, 2) . ' received from ' . $user->name . ' via Razorpay.',
            route('admin.transactions.index'),
            'fas fa-wallet'
        );

        return redirect()->route('candidate.dashboard')->with('success', 'Payment successful via Razorpay!');
    }
}
