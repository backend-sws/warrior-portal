<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuitionFeeAccount;
use App\Models\TuitionFeePayment;
use App\Models\ParentServiceChargeInvoice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TuitionFeeController extends Controller
{
    public function index(Request $request)
    {
        $query = TuitionFeeAccount::query();

        // Search Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('teacher_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $today = Carbon::today();
            if ($status === 'overdue') {
                $query->where('status', 'active')->where('next_due_date', '<', $today);
            } elseif ($status === 'pending') {
                // Let's say pending is due in the next 3 days
                $query->where('status', 'active')->whereBetween('next_due_date', [$today, $today->copy()->addDays(3)]);
            } elseif ($status === 'paid') {
                // Paid is due date > today + 3 days
                $query->where('status', 'active')->where('next_due_date', '>', $today->copy()->addDays(3));
            }
        }

        if ($request->filled('due_date')) {
            $query->whereDate('next_due_date', $request->due_date);
        }

        $accounts = $query->orderBy('next_due_date', 'asc')->paginate(15)->withQueryString();

        // Dashboard Metrics
        $today = Carbon::today();
        
        $dueToday = TuitionFeeAccount::where('status', 'active')
            ->whereDate('next_due_date', $today)->count();
            
        $dueTomorrow = TuitionFeeAccount::where('status', 'active')
            ->whereDate('next_due_date', $today->copy()->addDay())->count();
            
        $overdueCount = TuitionFeeAccount::where('status', 'active')
            ->where('next_due_date', '<', $today)->count();

        // Monthly Collection
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $totalCollected = TuitionFeePayment::whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)->sum('amount');
            
        $totalPendingAmount = TuitionFeeAccount::where('status', 'active')
            ->where('next_due_date', '<', $today)->sum('monthly_fee');

        // All Manual Payments History (admin recorded)
        $allPayments = TuitionFeePayment::with('account')->orderBy('payment_date', 'desc')->paginate(20, ['*'], 'payment_page');
        $totalPaymentsAmount = TuitionFeePayment::sum('amount');

        // Parent Online Service Charge Payments (paid by parent via gateway)
        $parentInvoicePayments = ParentServiceChargeInvoice::with(['lead', 'user'])
            ->where('status', 'Paid')
            ->orderBy('updated_at', 'desc')
            ->paginate(20, ['*'], 'invoice_page');
        $totalInvoiceAmount = ParentServiceChargeInvoice::where('status', 'Paid')->sum('amount');

        return view('admin.tuition_fees.index', compact(
            'accounts', 'dueToday', 'dueTomorrow', 'overdueCount', 
            'totalCollected', 'totalPendingAmount', 'allPayments', 'totalPaymentsAmount',
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

        // Advance the next_due_date by 1 month
        if ($account->next_due_date) {
            $account->next_due_date = Carbon::parse($account->next_due_date)->addMonth();
            $account->save();
        }

        return redirect()->route('admin.tuition-fees.show', $account->id)->with('success', 'Payment recorded and due date advanced by 1 month.');
    }

    public function destroy($id)
    {
        $account = TuitionFeeAccount::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.tuition-fees.index')->with('success', 'Fee account deleted successfully.');
    }
}
