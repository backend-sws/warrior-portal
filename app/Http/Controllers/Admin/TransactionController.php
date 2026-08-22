<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter    = $request->input('role', 'all');
        $statusFilter  = $request->input('status', 'all');
        $gatewayFilter = $request->input('gateway', 'all');
        $typeFilter    = $request->input('type', 'all');
        $search        = $request->input('search');

        $query = PaymentTransaction::with(['candidate', 'invoice', 'tuitionLead']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('order_id', 'like', "%{$search}%")
                  ->orWhere('payment_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('candidate', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($gatewayFilter !== 'all') {
            $query->where('gateway', $gatewayFilter);
        }
        
        if ($typeFilter !== 'all') {
            $query->where('type', $typeFilter);
        }

        if ($roleFilter !== 'all') {
            $query->whereHas('candidate', function ($q) use ($roleFilter) {
                $q->where('role', $roleFilter);
            });
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_revenue'      => PaymentTransaction::where('status', 'success')->sum('amount'),
            'success_count'      => PaymentTransaction::where('status', 'success')->count(),
            'pending_count'      => PaymentTransaction::where('status', 'pending')->count(),
            'failed_count'       => PaymentTransaction::where('status', 'failed')->count(),
            'razorpay_count'     => PaymentTransaction::where('gateway', 'razorpay')->count(),
            'total_transactions' => PaymentTransaction::count(),
        ];

        return view('admin.transactions.index', compact(
            'transactions', 
            'stats', 
            'roleFilter', 
            'statusFilter', 
            'gatewayFilter', 
            'typeFilter', 
            'search'
        ));
    }
}
