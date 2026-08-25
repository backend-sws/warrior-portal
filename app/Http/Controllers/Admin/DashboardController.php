<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\HomeTuitionLead;
use App\Models\TuitionApplication;
use App\Models\CandidateProfile;
use App\Models\ServiceChargeInvoice;
use App\Models\PaymentTransaction;
use App\Models\TuitionFeeAccount;
use App\Models\TuitionFeePayment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Date filters for stats
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // 1. CANDIDATE STATS
        $totalCandidates = User::where('role', 'candidate')->count();
        $signedCandidates = CandidateProfile::where('is_agreement_signed', true)->orWhere('is_tuition_agreement_signed', true)->count();
        $verifiedCandidates = CandidateProfile::where('is_verified', true)->count();
        $incompleteCandidates = max(0, $totalCandidates - $signedCandidates);

        // 2. SCHOOL JOBS STATS
        $totalJobs = JobPost::count();
        $activeJobs = JobPost::where('status', 'approved')->count();
        $pendingJobsCount = JobPost::where('status', 'pending')->count();
        $hiredPlacements = JobApplication::where('status', 'hired')->count();

        $jobAppQuery = JobApplication::query();
        if ($fromDate) {
            $jobAppQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $jobAppQuery->whereDate('created_at', '<=', $toDate);
        }
        $totalJobApps = (clone $jobAppQuery)->count();
        $forwardedJobApps = (clone $jobAppQuery)->where('is_forwarded', true)->count();
        $rejectedJobApps = (clone $jobAppQuery)->where('status', 'rejected')->count();

        // 3. HOME TUITIONS STATS
        $totalTuitions = HomeTuitionLead::count();
        $pendingTuitionsCount = HomeTuitionLead::where('status', 'New Lead')->count();
        $activeTuitions = HomeTuitionLead::where('status', 'Approved')->count();
        $assignedTuitions = HomeTuitionLead::where('status', 'Confirmed')->count();

        $tuitionAppQuery = TuitionApplication::query();
        if ($fromDate) {
            $tuitionAppQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $tuitionAppQuery->whereDate('created_at', '<=', $toDate);
        }
        $totalTuitionApps = (clone $tuitionAppQuery)->count();
        $assignedTuitionApps = (clone $tuitionAppQuery)->where('status', 'Assigned')->count();

        // 4. FINANCIAL & REVENUE METRICS
        $tuitionServiceRevenue = ServiceChargeInvoice::whereNotNull('home_tuition_lead_id')->where('status', 'paid')->sum('amount');
        $jobServiceRevenue = ServiceChargeInvoice::whereNull('home_tuition_lead_id')->where('status', 'paid')->sum('amount');
        $directGatewayRevenue = PaymentTransaction::where('status', 'success')->sum('amount');
        $totalRevenue = max($directGatewayRevenue, ($tuitionServiceRevenue + $jobServiceRevenue));

        $pendingDues = ServiceChargeInvoice::whereIn('status', ['pending', 'overdue'])->sum('amount');
        $overdueInvoicesCount = ServiceChargeInvoice::where('status', 'overdue')
            ->orWhere(fn($q) => $q->where('status', 'pending')->where('due_date', '<', now()->toDateString()))
            ->count();

        // 5. CHART DATA (Days & Months)
        $paidInvoices = ServiceChargeInvoice::where('status', 'paid')->get(['amount', 'updated_at']);
        $transactions = PaymentTransaction::where('status', 'success')->get(['amount', 'created_at']);

        $chartData = ['days' => ['labels' => [], 'data' => []], 'months' => ['labels' => [], 'data' => []]];

        // Days (last 30 days)
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $chartData['days']['labels'][] = $date->format('d M');

            $dayInv = $paidInvoices->filter(fn($p) => $p->updated_at && $p->updated_at->format('Y-m-d') === $dateStr)->sum('amount');
            $dayTxn = $transactions->filter(fn($t) => $t->created_at && $t->created_at->format('Y-m-d') === $dateStr)->sum('amount');
            $chartData['days']['data'][] = max($dayInv, $dayTxn);
        }

        // Months (last 12 months)
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $dateStr = $date->format('Y-m');
            $chartData['months']['labels'][] = $date->format('M Y');

            $mInv = $paidInvoices->filter(fn($p) => $p->updated_at && $p->updated_at->format('Y-m') === $dateStr)->sum('amount');
            $mTxn = $transactions->filter(fn($t) => $t->created_at && $t->created_at->format('Y-m') === $dateStr)->sum('amount');
            $chartData['months']['data'][] = max($mInv, $mTxn);
        }

        // 6. URGENT PENDING ACTIONS LISTS
        $pendingJobsList = JobPost::where('status', 'pending')->with(['category', 'city'])->latest()->limit(5)->get();
        $pendingTuitionsList = HomeTuitionLead::where('status', 'New Lead')->latest()->limit(5)->get();

        // 8. TUITION FEE PAYMENT ALERTS (for dashboard banner)
        // Auto-update statuses
        TuitionFeeAccount::where('status', 'active')
            ->where('next_due_date', '<', Carbon::today())
            ->where('payment_status', '!=', 'paid')
            ->update(['payment_status' => 'overdue']);

        $feeDueToday = TuitionFeeAccount::dueToday()->count();
        $feeDueTodayAmount = TuitionFeeAccount::dueToday()->sum('monthly_fee');
        $feeOverdueCount = TuitionFeeAccount::overdue()->count();
        $feeOverdueAmount = TuitionFeeAccount::overdue()->sum('monthly_fee');
        $feeFollowUpToday = TuitionFeeAccount::followUpToday()->count();
        $feeCollectedThisMonth = TuitionFeePayment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)->sum('amount');

        // 7. COMBINED LIVE ACTIVITY FEED
        $recentJobApps = JobApplication::with(['candidate', 'jobPost'])->latest()->limit(10)->get();
        $recentTuitionApps = TuitionApplication::with(['candidate', 'tuitionLead'])->latest()->limit(10)->get();

        $activityFeed = collect();
        foreach ($recentJobApps as $jApp) {
            $activityFeed->push([
                'type'        => 'job_app',
                'title'       => ($jApp->candidate->name ?? 'Candidate') . ' applied for School Job',
                'subtitle'    => ($jApp->jobPost->title ?? 'Teacher') . ' at ' . ($jApp->jobPost->school_name ?? 'School'),
                'status'      => $jApp->status,
                'time'        => $jApp->created_at,
                'link'        => route('admin.applications.index'),
                'icon'        => 'fas fa-school',
                'badge_color' => 'bg-blue-500/10 text-accent-blue border-accent-blue/20'
            ]);
        }

        foreach ($recentTuitionApps as $tApp) {
            $activityFeed->push([
                'type'        => 'tuition_app',
                'title'       => ($tApp->candidate->name ?? 'Tutor') . ' applied for Home Tuition',
                'subtitle'    => 'Class ' . ($tApp->tuitionLead->class ?? '') . ' (' . ($tApp->tuitionLead->subjects ?? '') . ') in ' . ($tApp->tuitionLead->location ?? ''),
                'status'      => $tApp->status,
                'time'        => $tApp->created_at,
                'link'        => route('admin.tuition-applications.index'),
                'icon'        => 'fas fa-chalkboard-teacher',
                'badge_color' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20'
            ]);
        }

        $activityFeed = $activityFeed->sortByDesc('time')->take(12);

        return view('admin.dashboard', compact(
            'totalCandidates',
            'signedCandidates',
            'verifiedCandidates',
            'incompleteCandidates',
            'totalJobs',
            'activeJobs',
            'pendingJobsCount',
            'hiredPlacements',
            'totalJobApps',
            'forwardedJobApps',
            'rejectedJobApps',
            'totalTuitions',
            'pendingTuitionsCount',
            'activeTuitions',
            'assignedTuitions',
            'totalTuitionApps',
            'assignedTuitionApps',
            'totalRevenue',
            'tuitionServiceRevenue',
            'jobServiceRevenue',
            'pendingDues',
            'overdueInvoicesCount',
            'chartData',
            'pendingJobsList',
            'pendingTuitionsList',
            'activityFeed',
            'fromDate',
            'toDate',
            'feeDueToday',
            'feeDueTodayAmount',
            'feeOverdueCount',
            'feeOverdueAmount',
            'feeFollowUpToday',
            'feeCollectedThisMonth'
        ));
    }
}
