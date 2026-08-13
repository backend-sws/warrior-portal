<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ParentServiceChargeInvoice;
use App\Models\PaymentTransaction;
use App\Models\HomeTuitionLeadFollowUp;
use App\Services\PhonePeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ServiceChargeController extends Controller
{
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

    public function processPay(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:parent_service_charge_invoices,id',
        ]);

        $user = auth()->user();

        $invoice = ParentServiceChargeInvoice::where('id', $request->invoice_id)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('lead', function($q) use ($user) {
                          $q->where('user_id', $user->id)
                            ->orWhere('parent_mobile', $user->phone);
                      });
            })
            ->where('status', 'Unpaid')
            ->first();

        if (!$invoice) {
            return back()->with('error', 'Unpaid invoice not found or already paid.');
        }

        $amount = (float) $invoice->amount;
        if ($amount <= 0) {
            return back()->with('error', 'Invalid invoice amount.');
        }

        $transactionId = 'PSC_' . $invoice->id . '_' . time();
        session(['parent_sc_invoice_id' => $invoice->id, 'last_txn_id' => $transactionId]);

        // Local Bypass option for development if env is local and bypass flag passed
        if (env('APP_ENV') === 'local' && $request->has('bypass')) {
            return redirect()->route('parent.serviceCharge.callback', [
                'transactionId' => $transactionId,
                'bypass' => true,
                'amount' => $amount
            ]);
        }

        $redirectUrl = route('parent.serviceCharge.callback');

        // Initiate payment via PhonePe
        $phonePe = new PhonePeService();
        $result = $phonePe->initiatePay($transactionId, $amount, $redirectUrl);

        if ($result['success']) {
            return redirect()->away($result['redirect_url']);
        }

        Log::info('PhonePe Parent ServiceCharge Pay Initiation Fallback to Gateway Checkout', [
            'error' => $result['error'] ?? null,
        ]);

        // Redirect to Payment Gateway checkout screen
        return redirect()->route('parent.serviceCharge.checkout', ['id' => $invoice->id]);
    }

    public function callback(Request $request)
    {
        $user = auth()->user();
        $invoiceId = session('parent_sc_invoice_id') ?? $request->input('invoice_id');
        $transactionId = $request->merchantOrderId ?? $request->transactionId ?? session('last_txn_id') ?? ('PSC_' . time());

        // Local bypass handler
        if ($request->bypass && env('APP_ENV') === 'local') {
            $invoice = ParentServiceChargeInvoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'Paid',
                    'updated_at' => now(),
                ]);

                PaymentTransaction::create([
                    'candidate_id' => $user->id,
                    'amount' => $request->amount ?? $invoice->amount,
                    'transaction_id' => $transactionId,
                    'type' => 'service_charge',
                    'status' => 'success',
                    'gateway_response' => ['bypassed' => true]
                ]);

                // Record in lead history if lead exists
                if ($invoice->lead) {
                    $invoice->lead->followUps()->create([
                        'admin_id' => null,
                        'note' => "Service Charge Invoice #{$invoice->invoice_number} (\${$invoice->amount} USD) was paid online by Parent.",
                    ]);
                }

                // Notify Admin
                $adminUser = \App\Models\User::where('role', 'admin')->first();
                if ($adminUser) {
                    DB::table('notifications')->insert([
                        'id' => Str::uuid(),
                        'type' => 'App\Notifications\ServiceChargePaid',
                        'notifiable_type' => 'App\Models\User',
                        'notifiable_id' => $adminUser->id,
                        'data' => json_encode([
                            'title' => 'Parent Service Charge Paid',
                            'message' => 'Payment of $' . number_format($invoice->amount, 2) . ' USD received from Parent ' . $user->name . ' for Invoice #' . $invoice->invoice_number,
                            'candidate_id' => $user->id,
                            'amount' => $invoice->amount
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            return redirect()->route('parent.serviceCharge.index')->with('success', 'Service Charge invoice paid successfully!');
        }

        if (!$transactionId || !$user) {
            return redirect()->route('parent.serviceCharge.index')->with('error', 'Payment session expired. Please try again.');
        }

        // Verify status with PhonePe
        $phonePe = new PhonePeService();
        $statusResult = $phonePe->checkStatus($transactionId);

        $isSuccess = $statusResult['success'];
        $amountPaid = $statusResult['amount'] > 0 ? ($statusResult['amount'] / 100) : 0;

        PaymentTransaction::create([
            'candidate_id' => $user->id,
            'amount' => $amountPaid > 0 ? $amountPaid : 0,
            'transaction_id' => $transactionId,
            'type' => 'service_charge',
            'status' => $isSuccess ? 'success' : 'failed',
            'gateway_response' => $statusResult['raw'] ?? []
        ]);

        if (!$isSuccess) {
            return redirect()->route('parent.serviceCharge.index')->with('error', 'Payment failed or was cancelled.');
        }

        if ($invoiceId) {
            $invoice = ParentServiceChargeInvoice::find($invoiceId);
            if ($invoice) {
                $invoice->update([
                    'status' => 'Paid',
                    'updated_at' => now(),
                ]);

                if ($invoice->lead) {
                    $invoice->lead->followUps()->create([
                        'admin_id' => null,
                        'note' => "Service Charge Invoice #{$invoice->invoice_number} (\${$invoice->amount} USD) was paid online by Parent.",
                    ]);
                }
            }
        }

        // Notify Admin
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\ServiceChargePaid',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $adminUser->id,
                'data' => json_encode([
                    'title' => 'Parent Service Charge Paid',
                    'message' => 'Payment of $' . number_format($amountPaid, 2) . ' USD received from Parent ' . $user->name,
                    'candidate_id' => $user->id,
                    'amount' => $amountPaid
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('parent.serviceCharge.index')->with('success', 'Service charge invoice paid successfully!');
    }

    public function checkout($id)
    {
        $user = auth()->user();
        $invoice = ParentServiceChargeInvoice::with('lead')
            ->where('id', $id)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('lead', function($q) use ($user) {
                          $q->where('user_id', $user->id)
                            ->orWhere('parent_mobile', $user->phone);
                      });
            })
            ->firstOrFail();

        if ($invoice->status === 'Paid') {
            return redirect()->route('parent.serviceCharge.index')->with('info', 'This invoice is already paid.');
        }

        $transactionId = 'PSC_' . $invoice->id . '_' . time();
        session(['parent_sc_invoice_id' => $invoice->id, 'last_txn_id' => $transactionId]);

        return view('parent.service_charge.checkout', compact('invoice', 'transactionId', 'user'));
    }

    public function printInvoice($id)
    {
        $user = auth()->user();
        $invoice = ParentServiceChargeInvoice::with('lead')
            ->where('id', $id)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('lead', function($q) use ($user) {
                          $q->where('user_id', $user->id)
                            ->orWhere('parent_mobile', $user->phone);
                      });
            })
            ->firstOrFail();

        $transaction = PaymentTransaction::where('candidate_id', $user->id)
            ->where('type', 'service_charge')
            ->latest()
            ->first();

        return view('parent.service_charge.invoice_pdf', [
            'invoice' => $invoice,
            'user' => $user,
            'transaction' => $transaction,
            'isPrint' => true
        ]);
    }

    public function downloadInvoice($id)
    {
        $user = auth()->user();
        $invoice = ParentServiceChargeInvoice::with('lead')
            ->where('id', $id)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('lead', function($q) use ($user) {
                          $q->where('user_id', $user->id)
                            ->orWhere('parent_mobile', $user->phone);
                      });
            })
            ->firstOrFail();

        $transaction = PaymentTransaction::where('candidate_id', $user->id)
            ->where('type', 'service_charge')
            ->latest()
            ->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('parent.service_charge.invoice_pdf', [
            'invoice' => $invoice,
            'user' => $user,
            'transaction' => $transaction,
            'isPrint' => false
        ]);

        return $pdf->download('Invoice-' . ($invoice->invoice_number ?? $invoice->id) . '.pdf');
    }
}
