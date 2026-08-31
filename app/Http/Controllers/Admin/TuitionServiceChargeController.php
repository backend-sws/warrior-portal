<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceChargeInvoice;
use App\Models\HomeTuitionLead;
use App\Models\User;
use App\Models\PaymentTransaction;
use App\Models\CandidatePaymentAccount;
use App\Models\CandidatePaymentRecord;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TuitionServiceChargeController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceChargeInvoice::with(['candidate.profile', 'tuitionLead'])
            ->where(function ($q) {
                $q->whereNotNull('home_tuition_lead_id')
                  ->orWhere(function ($sub) {
                      $sub->whereNull('job_application_id')
                          ->where('description', 'like', '%tuition%');
                  });
            });

        // Search Filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('candidate', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })->orWhereHas('tuitionLead', function ($lq) use ($search) {
                      $lq->where('parent_name', 'like', "%{$search}%")
                         ->orWhere('subjects', 'like', "%{$search}%")
                         ->orWhere('class', 'like', "%{$search}%")
                         ->orWhere('location', 'like', "%{$search}%");
                  });
            });
        }

        // Status Filter
        if ($status = $request->input('status')) {
            if ($status === 'overdue') {
                $query->where('status', '!=', 'paid')
                      ->where('due_date', '<', Carbon::today());
            } else {
                $query->where('status', $status);
            }
        }

        $invoices = (clone $query)->latest()->paginate(15)->withQueryString();

        // Calculate Stats
        $baseQuery = ServiceChargeInvoice::where(function ($q) {
            $q->whereNotNull('home_tuition_lead_id')
              ->orWhere(function ($sub) {
                  $sub->whereNull('job_application_id')
                      ->where('description', 'like', '%tuition%');
              });
        });

        $today = Carbon::today();
        $stats = [
            'total_invoiced' => (clone $baseQuery)->sum('amount'),
            'total_paid'     => (clone $baseQuery)->where('status', 'paid')->sum('amount'),
            'total_pending'  => (clone $baseQuery)->where('status', '!=', 'paid')->sum('amount'),
            'pending_count'  => (clone $baseQuery)->where('status', 'pending')->count(),
            'paid_count'     => (clone $baseQuery)->where('status', 'paid')->count(),
            'overdue_count'  => (clone $baseQuery)->where('status', '!=', 'paid')->where('due_date', '<', $today)->count(),
        ];

        // For Create Modal: candidates and active tuition leads
        $candidates = User::where('role', 'candidate')->orderBy('name')->get(['id', 'name', 'phone', 'email']);
        $tuitionLeads = HomeTuitionLead::orderBy('created_at', 'desc')->get(['id', 'class', 'subjects', 'parent_name', 'location']);

        return view('admin.tuition_service_charges.index', compact('invoices', 'stats', 'candidates', 'tuitionLeads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id'         => 'required|exists:users,id',
            'home_tuition_lead_id' => 'nullable|exists:home_tuition_leads,id',
            'amount'               => 'required|numeric|min:1',
            'due_date'             => 'required|date',
            'description'          => 'nullable|string|max:255',
        ]);

        $candidate = User::with('profile')->findOrFail($request->candidate_id);
        $lead = $request->home_tuition_lead_id ? HomeTuitionLead::find($request->home_tuition_lead_id) : null;

        $desc = $request->description;
        if (!$desc && $lead) {
            $desc = "Service Charge for Home Tuition (Class {$lead->class} - {$lead->subjects})";
        } elseif (!$desc) {
            $desc = "Home Tuition Placement Service Charge";
        }

        $invoice = ServiceChargeInvoice::create([
            'candidate_id'         => $candidate->id,
            'job_application_id'   => null,
            'home_tuition_lead_id' => $lead?->id,
            'amount'               => $request->amount,
            'due_date'             => $request->due_date,
            'status'               => 'pending',
            'description'          => $desc,
        ]);

        if ($candidate->profile) {
            $candidate->profile->increment('pending_amount', $request->amount);
        }

        NotificationHelper::notifyUser(
            $candidate->id,
            'New Tuition Service Charge Invoice 🧾',
            "An invoice of ₹" . number_format($request->amount, 2) . " has been issued for your home tuition placement. Due date: " . Carbon::parse($request->due_date)->format('d M Y') . ".",
            route('candidate.serviceCharge.show'),
            'fas fa-file-invoice-dollar'
        );

        try {
            Mail::to($candidate->email)->send(new \App\Mail\ServiceChargeInvoiceMail($invoice));
        } catch (\Throwable $e) {}

        return back()->with('success', "Tuition service charge invoice created successfully for {$candidate->name}.");
    }

    public function markPaid(Request $request, $id)
    {
        $invoice = ServiceChargeInvoice::with(['candidate.profile', 'tuitionLead'])->findOrFail($id);

        if ($invoice->status === 'paid') {
            return back()->with('info', 'Invoice is already marked as paid.');
        }

        $amount = (float)($invoice->amount + ($invoice->late_fee ?? 0));

        $invoice->update([
            'status'       => 'paid',
            'payment_date' => now(),
        ]);

        if ($invoice->candidate && $invoice->candidate->profile) {
            $invoice->candidate->profile->decrement('pending_amount', min($invoice->amount, $invoice->candidate->profile->pending_amount));
            $invoice->candidate->profile->update(['is_fee_paid' => true]);
        }

        // Record Transaction and Candidate Payment Ledger
        $this->recordTransactionAndAccount($invoice, $amount, 'Cash / Direct Admin Collection');

        NotificationHelper::notifyUser(
            $invoice->candidate_id,
            'Payment Received ✅',
            "Thank you! Your payment of ₹" . number_format($invoice->amount, 2) . " for '{$invoice->description}' has been recorded.",
            route('candidate.serviceCharge.show'),
            'fas fa-check-circle'
        );

        return back()->with('success', "Invoice #{$invoice->id} marked as Paid & transaction record created successfully.");
    }

    public function sendReminder(Request $request, $id)
    {
        $invoice = ServiceChargeInvoice::with(['candidate.profile', 'tuitionLead'])->findOrFail($id);

        if ($invoice->status === 'paid') {
            return back()->with('info', 'Invoice is already paid.');
        }

        // In-app notification
        NotificationHelper::notifyUser(
            $invoice->candidate_id,
            'Payment Reminder: Tuition Service Charge ⚠️',
            "Friendly reminder: ₹" . number_format($invoice->amount, 2) . " for '{$invoice->description}' is pending (Due: " . Carbon::parse($invoice->due_date)->format('d M Y') . "). Please clear your dues.",
            route('candidate.serviceCharge.show'),
            'fas fa-bell'
        );

        // Email
        try {
            Mail::to($invoice->candidate->email)->send(new \App\Mail\ServiceChargeInvoiceMail($invoice));
        } catch (\Throwable $e) {}

        return back()->with('success', "Payment reminder sent successfully to {$invoice->candidate->name}.");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:0',
            'due_date'    => 'required|date',
            'description' => 'required|string|max:255',
            'status'      => 'required|in:pending,paid,cancelled',
        ]);

        $invoice = ServiceChargeInvoice::with('candidate.profile')->findOrFail($id);
        $oldAmount = $invoice->amount;
        $oldStatus = $invoice->status;

        $invoice->update([
            'amount'       => $request->amount,
            'due_date'     => $request->due_date,
            'description'  => $request->description,
            'status'       => $request->status,
            'payment_date' => $request->status === 'paid' ? ($invoice->payment_date ?? now()) : null,
        ]);

        // Adjust profile balance
        if ($invoice->candidate && $invoice->candidate->profile) {
            $profile = $invoice->candidate->profile;
            if ($oldStatus !== 'paid' && $request->status === 'paid') {
                $profile->decrement('pending_amount', min($oldAmount, $profile->pending_amount));
                $profile->update(['is_fee_paid' => true]);
                // Record transaction
                $this->recordTransactionAndAccount($invoice, (float)$request->amount, 'Manual / Direct Admin Update');
            } elseif ($oldStatus === 'paid' && $request->status !== 'paid') {
                $profile->increment('pending_amount', $request->amount);
            } elseif ($oldStatus !== 'paid' && $request->status !== 'paid') {
                $diff = $request->amount - $oldAmount;
                if ($diff > 0) {
                    $profile->increment('pending_amount', $diff);
                } elseif ($diff < 0) {
                    $profile->decrement('pending_amount', min(abs($diff), $profile->pending_amount));
                }
            }
        }

        return back()->with('success', "Invoice #{$invoice->id} updated successfully.");
    }

    private function recordTransactionAndAccount($invoice, $amount, $paymentMode = 'Manual / Direct Admin')
    {
        try {
            // 1. PaymentTransaction for Online & Offline ledger
            PaymentTransaction::create([
                'candidate_id'   => $invoice->candidate_id,
                'amount'         => $amount,
                'currency'       => 'INR',
                'order_id'       => 'ADM_SC_' . $invoice->id . '_' . time(),
                'transaction_id' => 'MANUAL_' . $invoice->id . '_' . time(),
                'payment_id'     => 'MANUAL_' . $invoice->id . '_' . time(),
                'type'           => 'service_charge',
                'status'         => 'success',
                'gateway'        => 'manual_admin',
                'payment_method' => $paymentMode,
                'invoice_id'     => $invoice->id,
                'tuition_lead_id'=> $invoice->home_tuition_lead_id,
                'ip_address'     => request()->ip(),
            ]);

            // 2. CandidatePaymentAccount & CandidatePaymentRecord for Admin Candidate Payments Ledger
            $candidate = $invoice->candidate ?? User::find($invoice->candidate_id);
            if ($candidate) {
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
                    'payment_mode'   => $paymentMode,
                    'transaction_id' => 'MANUAL_' . $invoice->id . '_' . time(),
                    'payment_date'   => now(),
                    'received_by'    => auth()->user()?->name ?? 'Super Admin',
                    'notes'          => 'Service Charge Invoice #' . $invoice->id . ' marked as Paid (' . ($invoice->description ?: 'Placement Service Charge') . ')',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error recording payment transaction for Invoice #' . $invoice->id . ': ' . $e->getMessage());
        }
    }

    public function showInvoice($id)
    {
        $invoice = ServiceChargeInvoice::with(['candidate.profile', 'jobApplication.jobPost', 'tuitionLead'])->findOrFail($id);

        if ($invoice->status !== 'paid') {
            return back()->with('error', 'Invoice can only be viewed or downloaded after payment is completed.');
        }

        $user = $invoice->candidate;
        return view('candidate.serviceCharge.invoice_pdf', compact('invoice', 'user'));
    }

    public function destroy($id)
    {
        $invoice = ServiceChargeInvoice::with('candidate.profile')->findOrFail($id);

        if ($invoice->status !== 'paid' && $invoice->candidate && $invoice->candidate->profile) {
            $invoice->candidate->profile->decrement('pending_amount', min($invoice->amount, $invoice->candidate->profile->pending_amount));
        }

        $invoice->delete();

        return back()->with('success', "Invoice #{$id} deleted successfully.");
    }
}
