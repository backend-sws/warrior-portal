<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentServiceChargeInvoice;
use App\Models\PaymentTransaction;
use App\Models\HomeTuitionLeadFollowUp;
use App\Services\Payment\PaymentGatewayManager;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceChargeController extends Controller
{
    protected PaymentGatewayManager $paymentManager;

    public function __construct(PaymentGatewayManager $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    public function index()
    {
        $user = auth()->user();

        $tuitions = \App\Models\HomeTuitionLead::where('user_id', $user->id)
            ->orWhere(function($query) use ($user) {
                if ($user->phone) {
                    $cleanPhone = preg_replace('/[^0-9]/', '', $user->phone);
                    $query->where('parent_mobile', $user->phone)
                          ->orWhere('parent_mobile', 'like', "%{$cleanPhone}%");
                }
            })
            ->latest()
            ->get();

        $leadIds = $tuitions->pluck('id')->toArray();

        $serviceChargeInvoices = ParentServiceChargeInvoice::with('lead')
            ->where(function($query) use ($user, $leadIds) {
                $query->where('user_id', $user->id);
                if (!empty($leadIds)) {
                    $query->orWhereIn('home_tuition_lead_id', $leadIds);
                }
            })
            ->latest()
            ->get();

        $paymentHistory = PaymentTransaction::where('candidate_id', $user->id)
            ->where('type', 'service_charge')
            ->latest()
            ->get();

        return view('parent.service_charge.index', compact('serviceChargeInvoices', 'paymentHistory'));
    }

    public function checkout($id)
    {
        $user = auth()->user();

        $invoice = ParentServiceChargeInvoice::where('id', $id)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('lead', function($q) use ($user) {
                          $q->where('user_id', $user->id)
                            ->orWhere('parent_mobile', $user->phone);
                      });
            })
            ->where('status', 'Unpaid')
            ->with('lead')
            ->firstOrFail();

        $amount = (float) $invoice->amount;
        if ($amount <= 0) {
            return redirect()->route('parent.serviceCharge.index')->with('error', 'Invalid invoice amount.');
        }

        $receipt = 'PSC_' . $invoice->id . '_' . time();
        $gateway = $this->paymentManager->driver();

        // Create Razorpay Order
        $order = $gateway->createOrder([
            'amount'   => $amount,
            'receipt'  => $receipt,
            'notes'    => [
                'invoice_id'     => (string)$invoice->id,
                'user_id'        => (string)$user->id,
                'user_name'      => (string)$user->name,
                'user_phone'     => (string)$user->phone,
                'tuition_lead_id'=> (string)$invoice->home_tuition_lead_id,
                'type'           => 'parent_service_charge',
            ]
        ]);

        if (!$order['success']) {
            Log::error('Razorpay Parent Service Charge Order Creation Failed', ['error' => $order['error']]);
            return back()->with('error', 'Payment gateway error: ' . ($order['error'] ?? 'Please try again later.'));
        }

        PaymentTransaction::updateOrCreate(
            ['order_id' => $order['order_id']],
            [
                'candidate_id'    => $user->id,
                'amount'          => $amount,
                'currency'        => 'INR',
                'transaction_id'  => $receipt,
                'type'            => 'service_charge',
                'status'          => 'pending',
                'gateway'         => $gateway->getGatewayName(),
                'tuition_lead_id' => $invoice->home_tuition_lead_id,
                'ip_address'      => request()->ip(),
            ]
        );

        session(['active_parent_order_id' => $order['order_id'], 'parent_sc_invoice_id' => $invoice->id]);

        return view('parent.service_charge.checkout', compact('invoice', 'order', 'user'));
    }

    public function processPay(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:parent_service_charge_invoices,id',
        ]);

        return redirect()->route('parent.serviceCharge.checkout', ['id' => $request->invoice_id]);
    }

    public function callback(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in.');
        }

        $orderId   = $request->input('razorpay_order_id', session('active_parent_order_id'));
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');
        $invoiceId = session('parent_sc_invoice_id') ?? $request->input('invoice_id');

        if (empty($paymentId) || empty($orderId)) {
            return redirect()->route('parent.serviceCharge.index')->with('error', 'Payment was cancelled or failed.');
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
            return redirect()->route('parent.serviceCharge.index')->with('error', 'Payment verification failed: ' . ($verification['error'] ?? 'Invalid signature.'));
        }

        $paymentDetails = $verification['raw'] ?? [];
        $paymentMethod  = $verification['payment_method'] ?? 'online';

        DB::transaction(function () use ($txn, $invoiceId, $user, $paymentId, $signature, $paymentMethod, $paymentDetails) {
            $invoice = ParentServiceChargeInvoice::find($invoiceId);
            $amount  = $invoice ? $invoice->amount : ($txn?->amount ?? 0);

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

            if ($invoice && $invoice->status !== 'Paid') {
                $invoice->update([
                    'status'     => 'Paid',
                    'updated_at' => now(),
                ]);

                if ($invoice->lead) {
                    $invoice->lead->followUps()->create([
                        'admin_id' => null,
                        'note'     => "Service Charge Invoice #{$invoice->invoice_number} (₹" . number_format($invoice->amount, 2) . ") was paid online via Razorpay.",
                    ]);
                }

                // Notify Admin
                NotificationHelper::notifyAdmin(
                    'Parent Service Charge Paid 💳',
                    'Payment of ₹' . number_format($amount, 2) . ' received from Parent ' . $user->name . ' for Invoice #' . $invoice->invoice_number,
                    route('admin.transactions.index'),
                    'fas fa-receipt'
                );
            }
        });

        session()->forget(['active_parent_order_id', 'parent_sc_invoice_id']);

        return redirect()->route('parent.serviceCharge.index')->with('success', '✅ Payment of ₹' . number_format($txn?->amount ?? 0, 2) . ' completed successfully via Razorpay!');
    }
}
