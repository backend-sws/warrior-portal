<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HomeTuitionLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with([
            'profile',
            'tuitionApplications' => function($q) {
                $q->latest();
            },
            'tuitionApplications.tuitionLead',
            'applications.jobPost',
            'serviceChargeInvoices',
            'paymentTransactions',
            'homeTuitionLeads'
        ])->whereIn('role', ['candidate', 'parent']);

        // ─── 1. Role Filter ──────────────────────────────────────
        if ($request->filled('role') && in_array($request->role, ['candidate', 'parent'])) {
            $query->where('role', $request->role);
        }

        // ─── 2. Status Filter ────────────────────────────────────
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // ─── 3. Activity / Tuition / Job Filter ──────────────────
        if ($request->filled('activity')) {
            $act = $request->activity;
            if ($act === 'assigned_tuition') {
                $query->whereHas('tuitionApplications', function($q) {
                    $q->where('status', 'Assigned');
                });
            } elseif ($act === 'applied_tuition') {
                $query->has('tuitionApplications');
            } elseif ($act === 'rejected_tuition') {
                $query->whereHas('tuitionApplications', function($q) {
                    $q->where('status', 'Rejected');
                });
            } elseif ($act === 'shortlisted_tuition') {
                $query->whereHas('tuitionApplications', function($q) {
                    $q->where('status', 'Shortlisted');
                });
            } elseif ($act === 'applied_job') {
                $query->has('applications');
            } elseif ($act === 'hired_job') {
                $query->whereHas('applications', function($q) {
                    $q->where('status', 'hired');
                });
            } elseif ($act === 'posted_tuition') {
                $query->has('homeTuitionLeads');
            }
        }

        // ─── 4. Financial / Due Status Filter ────────────────────
        if ($request->filled('financial_status')) {
            $fs = $request->financial_status;
            if ($fs === 'has_dues') {
                $query->where(function($q) {
                    $q->whereHas('serviceChargeInvoices', function($iq) {
                        $iq->whereIn('status', ['pending', 'overdue']);
                    })->orWhereHas('profile', function($pq) {
                        $pq->where('pending_amount', '>', 0);
                    });
                });
            } elseif ($fs === 'paid') {
                $query->where(function($q) {
                    $q->whereHas('serviceChargeInvoices', function($iq) {
                        $iq->where('status', 'paid');
                    })->orWhereHas('paymentTransactions', function($tq) {
                        $tq->whereIn('status', ['paid', 'success']);
                    });
                });
            } elseif ($fs === 'no_dues') {
                $query->whereDoesntHave('serviceChargeInvoices', function($iq) {
                    $iq->whereIn('status', ['pending', 'overdue']);
                })->where(function($q) {
                    $q->whereDoesntHave('profile')
                      ->orWhereHas('profile', function($pq) {
                          $pq->where('pending_amount', '<=', 0);
                      });
                });
            }
        }

        // ─── 5. Date Range Filter ────────────────────────────────
        if ($request->filled('date_preset')) {
            $dp = $request->date_preset;
            if ($dp === 'today') {
                $query->whereDate('created_at', \Carbon\Carbon::today());
            } elseif ($dp === 'yesterday') {
                $query->whereDate('created_at', \Carbon\Carbon::yesterday());
            } elseif ($dp === 'this_week') {
                $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
            } elseif ($dp === 'this_month') {
                $query->whereMonth('created_at', \Carbon\Carbon::now()->month)->whereYear('created_at', \Carbon\Carbon::now()->year);
            } elseif ($dp === 'last_month') {
                $query->whereMonth('created_at', \Carbon\Carbon::now()->subMonth()->month)->whereYear('created_at', \Carbon\Carbon::now()->subMonth()->year);
            }
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // ─── 6. Search Query ─────────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($pq) use ($search) {
                      $pq->where('address', 'like', "%{$search}%")
                         ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        // ─── Quick Stats ─────────────────────────────────────────
        $stats = [
            'total'             => User::whereIn('role', ['candidate', 'parent'])->count(),
            'candidates'        => User::where('role', 'candidate')->count(),
            'parents'           => User::where('role', 'parent')->count(),
            'active'            => User::whereIn('role', ['candidate', 'parent'])->where('is_active', true)->count(),
            'inactive'          => User::whereIn('role', ['candidate', 'parent'])->where('is_active', false)->count(),
            'assigned_tuitions' => User::whereHas('tuitionApplications', function($q) { $q->where('status', 'Assigned'); })->count(),
            'with_dues'         => User::whereHas('serviceChargeInvoices', function($iq) { $iq->whereIn('status', ['pending', 'overdue']); })->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot modify admin status.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User account has been {$status}.");
    }

    public function impersonate($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot impersonate an admin.');
        }

        if (!$user->is_active) {
            return back()->with('error', 'Cannot impersonate an inactive user.');
        }

        if ($user->role === 'parent') {
            return back()->with('error', 'Parents do not have a portal login.');
        }

        // Store admin id in session to return later
        $adminId = auth()->id();
        
        Auth::login($user);
        
        session()->put('impersonate_admin_id', $adminId);
        session()->save();

        if ($user->role === 'employer') {
            return redirect()->route('employer.dashboard');
        }

        return redirect()->route('candidate.dashboard');
    }

    public function leaveImpersonate()
    {
        if (session()->has('impersonate_admin_id')) {
            $adminId = session('impersonate_admin_id');
            $admin = User::find($adminId);

            if ($admin && $admin->role === 'admin') {
                session()->forget('impersonate_admin_id');
                Auth::login($admin);
                session()->save();
                return redirect()->route('admin.users.index')->with('success', 'Returned to admin dashboard.');
            }
        }

        return redirect('/');
    }
}
