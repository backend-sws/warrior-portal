<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter     = $request->input('role', 'all');
        $statusFilter   = $request->input('status', 'all');
        $gatewayFilter  = $request->input('gateway', 'all');
        $typeFilter     = $request->input('type', 'all');
        $categoryFilter = $request->input('category', 'all');
        $search         = $request->input('search');

        $dateFrom   = $request->input('date_from');
        $dateTo     = $request->input('date_to');
        $datePreset = $request->input('date_preset');

        // Handle Quick Date Presets
        if ($datePreset && !$dateFrom && !$dateTo) {
            switch ($datePreset) {
                case 'today':
                    $dateFrom = Carbon::today()->toDateString();
                    $dateTo   = Carbon::today()->toDateString();
                    break;
                case 'yesterday':
                    $dateFrom = Carbon::yesterday()->toDateString();
                    $dateTo   = Carbon::yesterday()->toDateString();
                    break;
                case 'this_week':
                    $dateFrom = Carbon::now()->startOfWeek()->toDateString();
                    $dateTo   = Carbon::now()->endOfWeek()->toDateString();
                    break;
                case 'this_month':
                    $dateFrom = Carbon::now()->startOfMonth()->toDateString();
                    $dateTo   = Carbon::now()->endOfMonth()->toDateString();
                    break;
                case 'last_month':
                    $dateFrom = Carbon::now()->subMonth()->startOfMonth()->toDateString();
                    $dateTo   = Carbon::now()->subMonth()->endOfMonth()->toDateString();
                    break;
                case 'all_time':
                    $dateFrom = null;
                    $dateTo   = null;
                    break;
            }
        }

        // Base Query for Table
        $query = PaymentTransaction::with(['candidate.profile', 'invoice.tuitionLead', 'invoice.jobApplication', 'tuitionLead']);

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

        if ($categoryFilter !== 'all') {
            $query->forCategory($categoryFilter);
        }

        if ($roleFilter !== 'all') {
            $query->whereHas('candidate', function ($q) use ($roleFilter) {
                $q->where('role', $roleFilter);
            });
        }

        if (!empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $transactions = $query->latest()->paginate(25)->withQueryString();

        // Analytics Scope (Filtered by active date range)
        $statsQuery = PaymentTransaction::query();
        if (!empty($dateFrom)) {
            $statsQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $statsQuery->whereDate('created_at', '<=', $dateTo);
        }

        $totalRevenue = (float) (clone $statsQuery)->where('status', 'success')->sum('amount');
        $jobRevenue = (float) (clone $statsQuery)->where('status', 'success')->forCategory('job')->sum('amount');
        $tuitionRevenue = (float) (clone $statsQuery)->where('status', 'success')->forCategory('tuition')->sum('amount');

        $jobPercentage = $totalRevenue > 0 ? round(($jobRevenue / $totalRevenue) * 100, 1) : 0;
        $tuitionPercentage = $totalRevenue > 0 ? round(($tuitionRevenue / $totalRevenue) * 100, 1) : 0;

        $stats = [
            'total_revenue'         => $totalRevenue,
            'success_count'         => (clone $statsQuery)->where('status', 'success')->count(),
            'pending_count'         => (clone $statsQuery)->where('status', 'pending')->count(),
            'pending_amount'        => (float) (clone $statsQuery)->where('status', 'pending')->sum('amount'),
            'failed_count'          => (clone $statsQuery)->where('status', 'failed')->count(),
            'total_transactions'    => (clone $statsQuery)->count(),

            // Job Analytics
            'job_revenue'           => $jobRevenue,
            'job_count'             => (clone $statsQuery)->where('status', 'success')->forCategory('job')->count(),
            'job_pending_count'     => (clone $statsQuery)->where('status', 'pending')->forCategory('job')->count(),
            'job_percentage'        => $jobPercentage,

            // Tuition Analytics
            'tuition_revenue'       => $tuitionRevenue,
            'tuition_count'         => (clone $statsQuery)->where('status', 'success')->forCategory('tuition')->count(),
            'tuition_pending_count' => (clone $statsQuery)->where('status', 'pending')->forCategory('tuition')->count(),
            'tuition_percentage'    => $tuitionPercentage,
        ];

        return view('admin.transactions.index', compact(
            'transactions', 
            'stats', 
            'roleFilter', 
            'statusFilter', 
            'gatewayFilter', 
            'typeFilter', 
            'categoryFilter',
            'dateFrom',
            'dateTo',
            'datePreset',
            'search'
        ));
    }
}
