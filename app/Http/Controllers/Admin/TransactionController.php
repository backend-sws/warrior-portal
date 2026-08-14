<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->input('role', 'all');

        $query = PaymentTransaction::with('candidate');

        if ($search = $request->input('search')) {
            $query->whereHas('candidate', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })->orWhere('transaction_id', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($roleFilter !== 'all') {
            $query->whereHas('candidate', function ($q) use ($roleFilter) {
                $q->where('role', $roleFilter);
            });
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_revenue' => PaymentTransaction::where('status', 'success')->sum('amount'),
            'candidate_revenue' => PaymentTransaction::where('status', 'success')->whereHas('candidate', function($q) { $q->where('role', 'candidate'); })->sum('amount'),
            'parent_revenue' => PaymentTransaction::where('status', 'success')->whereHas('candidate', function($q) { $q->where('role', 'parent'); })->sum('amount'),
            'total_transactions' => PaymentTransaction::count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats', 'roleFilter'));
    }
}
