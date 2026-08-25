<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuitionFeeAccount;
use App\Models\TuitionFeePayment;
use App\Models\ParentServiceChargeInvoice;
use App\Mail\PaymentCollectionDailyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TuitionFeeController extends Controller
{
    public function index(Request $request)
    {
        // ── Auto-Update Statuses on Page Load ──────────────────
        $this->autoUpdateStatuses();

        $query = TuitionFeeAccount::query();

        // ── Search (enhanced — proper searching across all fields) ──
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('teacher_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('follow_up_notes', 'like', "%{$search}%");
            });
        }

        // ── Payment Status Filter ──────────────────────────────
        if ($request->filled('payment_status')) {
            $ps = $request->payment_status;
            if ($ps === 'overdue') {
                $query->overdue();
            } elseif ($ps === 'pending') {
                $query->pending();
            } elseif ($ps === 'paid') {
                $query->paid();
            }
        }

        // ── Status (active/inactive) ───────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ── Due Date specific filter ───────────────────────────
        if ($request->filled('due_date')) {
            $query->whereDate('next_due_date', $request->due_date);
        }

        // ── Follow-Up Date filter ──────────────────────────────
        if ($request->filled('follow_up_filter')) {
            if ($request->follow_up_filter === 'today') {
                $query->followUpToday();
            } elseif ($request->follow_up_filter === 'has_followup') {
                $query->whereNotNull('follow_up_date');
            }
        }

        $accounts = $query->orderBy('next_due_date', 'asc')->paginate(20)->withQueryString();

        // ── Dashboard Metrics (comprehensive) ──────────────────
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalActiveAccounts = TuitionFeeAccount::active()->count();
        $totalExpectedCollection = TuitionFeeAccount::active()->sum('monthly_fee');

        $collectedThisMonth = TuitionFeePayment::whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)->sum('amount');

        $pendingAmount = max(0, $totalExpectedCollection - $collectedThisMonth);

        $dueToday = TuitionFeeAccount::dueToday()->count();
        $dueTodayAmount = TuitionFeeAccount::dueToday()->sum('monthly_fee');

        $dueTomorrow = TuitionFeeAccount::active()
            ->whereDate('next_due_date', $today->copy()->addDay())->count();

        $overdueCount = TuitionFeeAccount::overdue()->count();
        $overdueAmount = TuitionFeeAccount::overdue()->sum('monthly_fee');

        $followUpTodayCount = TuitionFeeAccount::followUpToday()->count();
        $followUpTodayAmount = TuitionFeeAccount::followUpToday()->sum('monthly_fee');

        $todayCollectionTarget = $dueTodayAmount + $followUpTodayAmount;

        // ── Today's Collections (Due Today + Follow-Up Today) ──
        $todayCollections = TuitionFeeAccount::active()
            ->where(function($q) use ($today) {
                $q->whereDate('next_due_date', $today)
                  ->orWhere(function($q2) use ($today) {
                      $q2->whereNotNull('follow_up_date')->whereDate('follow_up_date', $today);
                  });
            })
            ->orderBy('next_due_date', 'asc')
            ->get();

        // ── All Manual Payments History ─────────────────────────
        $allPayments = TuitionFeePayment::with('account')->orderBy('payment_date', 'desc')->paginate(20, ['*'], 'payment_page');
        $totalPaymentsAmount = TuitionFeePayment::sum('amount');

        // ── Parent Online Service Charge Payments ───────────────
        $parentInvoicePayments = ParentServiceChargeInvoice::with(['lead', 'user'])
            ->where('status', 'Paid')
            ->orderBy('updated_at', 'desc')
            ->paginate(20, ['*'], 'invoice_page');
        $totalInvoiceAmount = ParentServiceChargeInvoice::where('status', 'Paid')->sum('amount');

        return view('admin.tuition_fees.index', compact(
            'accounts', 'totalActiveAccounts', 'totalExpectedCollection',
            'collectedThisMonth', 'pendingAmount',
            'dueToday', 'dueTodayAmount', 'dueTomorrow',
            'overdueCount', 'overdueAmount',
            'followUpTodayCount', 'followUpTodayAmount',
            'todayCollectionTarget', 'todayCollections',
            'allPayments', 'totalPaymentsAmount',
            'parentInvoicePayments', 'totalInvoiceAmount'
        ));
    }

    public function create()
    {
        return view('admin.tuition_fees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'class' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'teacher_name' => 'nullable|string|max:255',
            'teacher_joining_date' => 'required|date',
            'monthly_fee' => 'required|numeric|min:0',
        ]);

        $account = TuitionFeeAccount::create($validated);
        
        // Calculate initial due date (1 month after joining)
        if ($account->teacher_joining_date) {
            $account->next_due_date = Carbon::parse($account->teacher_joining_date)->addMonth();
            $account->payment_status = 'pending';
            $account->save();
        }

        return redirect()->route('admin.tuition-fees.show', $account->id)->with('success', 'Fee account created successfully.');
    }

    public function show($id)
    {
        $account = TuitionFeeAccount::with(['payments' => function($q) {
            $q->orderBy('payment_date', 'desc');
        }])->findOrFail($id);
        
        return view('admin.tuition_fees.show', compact('account'));
    }

    public function edit($id)
    {
        $account = TuitionFeeAccount::findOrFail($id);
        return view('admin.tuition_fees.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = TuitionFeeAccount::findOrFail($id);
        
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'class' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'teacher_name' => 'nullable|string|max:255',
            'teacher_joining_date' => 'required|date',
            'monthly_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'next_due_date' => 'required|date',
        ]);

        $account->update($validated);

        return redirect()->route('admin.tuition-fees.show', $account->id)->with('success', 'Fee account updated successfully.');
    }

    public function addPayment(Request $request, $id)
    {
        $account = TuitionFeeAccount::findOrFail($id);

        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required|in:Cash,UPI,Bank,Other',
            'remarks' => 'nullable|string',
        ]);

        $account->payments()->create([
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'collected_by' => auth()->user()->name,
            'remarks' => $request->remarks,
        ]);

        // Update account tracking fields
        $account->payment_status = 'paid';
        $account->last_paid_date = Carbon::parse($request->payment_date);
        $account->total_payments_count = $account->total_payments_count + 1;
        
        // Clear follow-up since payment is done
        $account->follow_up_date = null;
        $account->follow_up_notes = null;

        // Advance the next_due_date by 1 month
        if ($account->next_due_date) {
            $account->next_due_date = Carbon::parse($account->next_due_date)->addMonth();
        }

        $account->save();

        return redirect()->route('admin.tuition-fees.show', $account->id)->with('success', 'Payment recorded! Status set to Paid and due date advanced by 1 month.');
    }

    /**
     * Set follow-up date and notes for a specific account
     */
    public function setFollowUp(Request $request, $id)
    {
        $account = TuitionFeeAccount::findOrFail($id);
        
        $request->validate([
            'follow_up_date' => 'required|date|after_or_equal:today',
            'follow_up_notes' => 'nullable|string|max:500',
        ]);

        $account->follow_up_date = $request->follow_up_date;
        $account->follow_up_notes = $request->follow_up_notes;
        $account->save();

        return redirect()->back()->with('success', 'Follow-up date set for ' . Carbon::parse($request->follow_up_date)->format('d M, Y') . '.');
    }

    /**
     * Update payment status manually
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $account = TuitionFeeAccount::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:pending,paid,overdue',
        ]);

        $account->payment_status = $request->payment_status;
        $account->save();

        return redirect()->back()->with('success', 'Payment status updated to ' . ucfirst($request->payment_status) . '.');
    }

    /**
     * Send daily payment collection summary email to admin
     */
    public function sendDailySummaryEmail()
    {
        $this->autoUpdateStatuses();

        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $dueTodayAccounts = TuitionFeeAccount::dueToday()->get();
        $overdueAccounts = TuitionFeeAccount::overdue()->get();
        $followUpAccounts = TuitionFeeAccount::followUpToday()->get();

        $summary = [
            'due_today_count' => $dueTodayAccounts->count(),
            'due_today_amount' => TuitionFeeAccount::dueToday()->sum('monthly_fee'),
            'overdue_count' => $overdueAccounts->count(),
            'overdue_amount' => TuitionFeeAccount::overdue()->sum('monthly_fee'),
            'follow_up_today_count' => $followUpAccounts->count(),
            'follow_up_today_amount' => TuitionFeeAccount::followUpToday()->sum('monthly_fee'),
            'today_collection_target' => TuitionFeeAccount::dueToday()->sum('monthly_fee') + TuitionFeeAccount::followUpToday()->sum('monthly_fee'),
            'total_active' => TuitionFeeAccount::active()->count(),
            'collected_this_month' => TuitionFeePayment::whereMonth('payment_date', $currentMonth)->whereYear('payment_date', $currentYear)->sum('amount'),
            'pending_amount' => max(0, TuitionFeeAccount::active()->sum('monthly_fee') - TuitionFeePayment::whereMonth('payment_date', $currentMonth)->whereYear('payment_date', $currentYear)->sum('amount')),
            'due_today_accounts' => $dueTodayAccounts,
            'overdue_accounts' => $overdueAccounts,
            'follow_up_accounts' => $followUpAccounts,
        ];

        // Send to all admin users
        $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email')->filter();
        
        foreach ($adminEmails as $email) {
            try {
                Mail::to($email)->send(new PaymentCollectionDailyMail($summary));
            } catch (\Exception $e) {
                Log::error("Daily payment summary email failed for {$email}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', '📧 Daily collection summary email sent to ' . $adminEmails->count() . ' admin(s).');
    }

    /**
     * Send individual payment reminder email for a specific account
     */
    public function sendPaymentReminder($id)
    {
        $account = TuitionFeeAccount::findOrFail($id);

        $isOverdue = $account->next_due_date && Carbon::parse($account->next_due_date)->isPast() && !Carbon::parse($account->next_due_date)->isToday();

        $details = [
            'name' => $account->parent_name,
            'assignment' => ($account->student_name ?? 'Student') . ' — ' . ($account->class ?? '') . ' ' . ($account->subject ?? ''),
            'amount' => $account->monthly_fee,
            'due_date' => $account->next_due_date,
            'is_overdue' => $isOverdue,
            'status_text' => $isOverdue 
                ? '🔴 OVERDUE: Your tuition fee payment is past due. Please pay immediately.'
                : '⏰ REMINDER: Your tuition fee payment is due. Please pay on time.',
        ];

        // Send to all admins (since parent doesn't have email in this table)
        $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email')->filter();
        
        foreach ($adminEmails as $email) {
            try {
                Mail::to($email)->send(new \App\Mail\PaymentReminderEmail($details));
            } catch (\Exception $e) {
                Log::error("Payment reminder email failed for account #{$id}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', '📧 Payment reminder email sent for ' . $account->student_name . '.');
    }

    /**
     * Bulk send reminders for all overdue and due-today accounts
     */
    public function sendBulkReminders(Request $request)
    {
        $this->autoUpdateStatuses();
        
        $type = $request->input('reminder_type', 'all'); // all, overdue, due_today, follow_up
        $count = 0;

        $adminEmails = \App\Models\User::where('role', 'admin')->pluck('email')->filter();

        $accounts = collect();

        if ($type === 'all' || $type === 'due_today') {
            $accounts = $accounts->merge(TuitionFeeAccount::dueToday()->get());
        }
        if ($type === 'all' || $type === 'overdue') {
            $accounts = $accounts->merge(TuitionFeeAccount::overdue()->get());
        }
        if ($type === 'all' || $type === 'follow_up') {
            $accounts = $accounts->merge(TuitionFeeAccount::followUpToday()->get());
        }

        $accounts = $accounts->unique('id');

        foreach ($accounts as $account) {
            $isOverdue = $account->next_due_date && Carbon::parse($account->next_due_date)->isPast();

            $details = [
                'name' => $account->parent_name,
                'assignment' => ($account->student_name ?? 'Student') . ' — ' . ($account->class ?? '') . ' ' . ($account->subject ?? ''),
                'amount' => $account->monthly_fee,
                'due_date' => $account->next_due_date,
                'is_overdue' => $isOverdue,
                'status_text' => $isOverdue 
                    ? '🔴 OVERDUE: Payment for ' . $account->student_name . ' is past due.'
                    : '⏰ REMINDER: Payment for ' . $account->student_name . ' is due.',
            ];

            foreach ($adminEmails as $email) {
                try {
                    Mail::to($email)->send(new \App\Mail\PaymentReminderEmail($details));
                    $count++;
                } catch (\Exception $e) {
                    Log::error("Bulk reminder failed for account #{$account->id}: " . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', "📧 Bulk reminders sent for {$accounts->count()} account(s) to {$adminEmails->count()} admin(s).");
    }

    public function destroy($id)
    {
        $account = TuitionFeeAccount::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.tuition-fees.index')->with('success', 'Fee account deleted successfully.');
    }

    /**
     * Auto-update payment statuses (called on page load instead of cron)
     */
    private function autoUpdateStatuses()
    {
        $today = Carbon::today();

        // Mark overdue
        TuitionFeeAccount::where('status', 'active')
            ->where('next_due_date', '<', $today)
            ->where('payment_status', '!=', 'paid')
            ->update(['payment_status' => 'overdue']);

        // Reset paid to pending for new cycle where due date is today
        TuitionFeeAccount::where('status', 'active')
            ->whereDate('next_due_date', $today)
            ->where('payment_status', 'paid')
            ->update(['payment_status' => 'pending']);
    }
}
