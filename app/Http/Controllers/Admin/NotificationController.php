<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');

        // Base Query
        $baseQuery = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->whereIn('notifiable_id', $adminIds);

        // 1. Compute Analytics Metrics
        $totalCount = (clone $baseQuery)->count();
        $unreadCount = (clone $baseQuery)->whereNull('read_at')->count();
        $readCount = (clone $baseQuery)->whereNotNull('read_at')->count();

        $tuitionsCount = (clone $baseQuery)
            ->where(function($q) {
                $q->where('type', 'like', '%Tuition%')
                  ->orWhere('data', 'like', '%tuition%')
                  ->orWhere('data', 'like', '%Tuition%')
                  ->orWhere('data', 'like', '%Tutor%');
            })->count();

        $jobsCount = (clone $baseQuery)
            ->where(function($q) {
                $q->where('type', 'like', '%Job%')
                  ->orWhere('data', 'like', '%job%')
                  ->orWhere('data', 'like', '%Job%')
                  ->orWhere('data', 'like', '%School%');
            })->count();

        $paymentsCount = (clone $baseQuery)
            ->where(function($q) {
                $q->where('type', 'like', '%Payment%')
                  ->orWhere('type', 'like', '%ServiceCharge%')
                  ->orWhere('type', 'like', '%Fee%')
                  ->orWhere('data', 'like', '%Payment%')
                  ->orWhere('data', 'like', '%Service Charge%')
                  ->orWhere('data', 'like', '%₹%');
            })->count();

        $candidatesCount = (clone $baseQuery)
            ->where(function($q) {
                $q->where('type', 'like', '%Registration%')
                  ->orWhere('type', 'like', '%Profile%')
                  ->orWhere('data', 'like', '%Candidate%')
                  ->orWhere('data', 'like', '%candidate%');
            })->count();

        // 2. Apply Filters
        $query = (clone $baseQuery);

        // Filter by Status
        $status = $request->input('status');
        if ($status === 'unread') {
            $query->whereNull('read_at');
        } elseif ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        // Filter by Category
        $category = $request->input('category');
        if ($category === 'tuition') {
            $query->where(function($q) {
                $q->where('type', 'like', '%Tuition%')
                  ->orWhere('data', 'like', '%tuition%')
                  ->orWhere('data', 'like', '%Tuition%')
                  ->orWhere('data', 'like', '%Tutor%');
            });
        } elseif ($category === 'job') {
            $query->where(function($q) {
                $q->where('type', 'like', '%Job%')
                  ->orWhere('data', 'like', '%job%')
                  ->orWhere('data', 'like', '%Job%')
                  ->orWhere('data', 'like', '%School%');
            });
        } elseif ($category === 'payment') {
            $query->where(function($q) {
                $q->where('type', 'like', '%Payment%')
                  ->orWhere('type', 'like', '%ServiceCharge%')
                  ->orWhere('type', 'like', '%Fee%')
                  ->orWhere('data', 'like', '%Payment%')
                  ->orWhere('data', 'like', '%Service Charge%')
                  ->orWhere('data', 'like', '%₹%');
            });
        } elseif ($category === 'candidate') {
            $query->where(function($q) {
                $q->where('type', 'like', '%Registration%')
                  ->orWhere('type', 'like', '%Profile%')
                  ->orWhere('data', 'like', '%Candidate%')
                  ->orWhere('data', 'like', '%candidate%');
            });
        }

        // Search in data JSON
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('data', 'like', "%{$search}%");
        }

        // Order
        $order = $request->input('order', 'desc');
        $query->orderBy('created_at', $order === 'asc' ? 'asc' : 'desc');

        $notifications = $query->paginate(20)
            ->withQueryString()
            ->through(function($n) {
                $n->data = json_decode($n->data);
                return $n;
            });

        return view('admin.notifications.index', compact(
            'notifications',
            'totalCount',
            'unreadCount',
            'readCount',
            'tuitionsCount',
            'jobsCount',
            'paymentsCount',
            'candidatesCount'
        ));
    }

    public function markRead($id)
    {
        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');
        DB::table('notifications')
            ->where('id', $id)
            ->whereIn('notifiable_id', $adminIds)
            ->update(['read_at' => now()]);

        return back()->with('success', 'Notification marked as read.');
    }

    public function markUnread($id)
    {
        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');
        DB::table('notifications')
            ->where('id', $id)
            ->whereIn('notifiable_id', $adminIds)
            ->update(['read_at' => null]);

        return back()->with('success', 'Notification marked as unread.');
    }

    public function markAllRead()
    {
        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->whereIn('notifiable_id', $adminIds)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function clearRead()
    {
        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->whereIn('notifiable_id', $adminIds)
            ->whereNotNull('read_at')
            ->delete();

        return back()->with('success', 'Read notifications cleared successfully.');
    }
}
