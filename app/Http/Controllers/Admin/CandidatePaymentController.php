<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidatePaymentAccount;
use App\Models\CandidatePaymentRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CandidatePaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = CandidatePaymentAccount::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('candidate_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('tuition_assigned', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            if ($request->status === 'overdue') {
                $query->where('status', 'active')->where('next_due_date', '<', Carbon::today());
            } elseif ($request->status === 'pending') {
                $query->where('status', 'active')
                      ->where('next_due_date', '>=', Carbon::today())
                      ->where('next_due_date', '<=', Carbon::today()->addDays(3));
            } elseif ($request->status === 'paid') {
                $query->where('status', 'active')
                      ->where('next_due_date', '>', Carbon::today()->addDays(3));
            }
        }

        if ($request->due_date) {
            $query->whereDate('next_due_date', $request->due_date);
        }

        $accounts = $query->latest()->paginate(15)->withQueryString();

        $totalCollected = CandidatePaymentRecord::where('type', 'Collected')->whereMonth('payment_date', Carbon::now()->month)->sum('amount');
        $totalPaidOut = CandidatePaymentRecord::where('type', 'Paid')->whereMonth('payment_date', Carbon::now()->month)->sum('amount');
        
        $totalPendingAmount = CandidatePaymentAccount::where('status', 'active')
            ->where('next_due_date', '<', Carbon::today())
            ->sum('monthly_amount');
            
        $dueToday = CandidatePaymentAccount::where('status', 'active')->whereDate('next_due_date', Carbon::today())->count();
        $dueTomorrow = CandidatePaymentAccount::where('status', 'active')->whereDate('next_due_date', Carbon::tomorrow())->count();
        $overdueCount = CandidatePaymentAccount::where('status', 'active')->where('next_due_date', '<', Carbon::today())->count();

        return view('admin.candidate_payments.index', compact(
            'accounts', 'totalCollected', 'totalPaidOut', 'totalPendingAmount', 'dueToday', 'dueTomorrow', 'overdueCount'
        ));
    }

    public function create()
    {
        return view('admin.candidate_payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'joining_date' => 'required|date',
            'monthly_amount' => 'required|numeric|min:0',
        ]);

        $nextDueDate = Carbon::parse($request->joining_date)->addMonth();

        CandidatePaymentAccount::create([
            'candidate_name' => $request->candidate_name,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address,
            'tuition_assigned' => $request->tuition_assigned,
            'joining_date' => $request->joining_date,
            'monthly_amount' => $request->monthly_amount,
            'next_due_date' => $nextDueDate,
        ]);

        return redirect()->route('admin.candidate-payments.index')->with('success', 'Candidate payment account created successfully.');
    }

    public function show($id)
    {
        $account = CandidatePaymentAccount::with(['payments' => function($q) {
            $q->latest('payment_date');
        }])->findOrFail($id);

        return view('admin.candidate_payments.show', compact('account'));
    }

    public function addPayment(Request $request, $id)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'type' => 'required|string|in:Collected,Paid',
        ]);

        $account = CandidatePaymentAccount::findOrFail($id);

        $account->payments()->create([
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'type' => $request->type,
            'collected_by' => auth()->user()->name ?? 'Admin',
            'remarks' => $request->remarks,
        ]);

        $currentDueDate = Carbon::parse($account->next_due_date);
        $account->update([
            'next_due_date' => $currentDueDate->addMonth()
        ]);

        return back()->with('success', 'Payment recorded successfully and next due date updated!');
    }

    public function destroy($id)
    {
        $account = CandidatePaymentAccount::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.candidate-payments.index')->with('success', 'Account deleted successfully.');
    }
}
