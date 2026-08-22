<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Models\ServiceChargeInvoice;
use App\Models\JobApplication;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReminderController extends Controller
{
    /**
     * Main Reminder Dashboard
     */
    public function index()
    {
        // Stats for the dashboard cards
        $stats = [
            'service_charge_pending' => ServiceChargeInvoice::whereIn('status', ['pending', 'overdue'])->count(),
            'renewal_needed'         => User::where('role', 'candidate')
                ->whereHas('profile', fn($q) => $q->whereColumn('used_applications', '>=', 'total_allowed_applications')->where('total_allowed_applications', '>', 0))
                ->count(),
            'payment_pending'        => User::where('role', 'candidate')
                ->whereHas('profile', fn($q) => $q->where('plan_type', 'standard')->where('pending_amount', '>', 0))
                ->count(),
            'upcoming_interviews'    => JobApplication::whereNotNull('interview_date')
                ->where('interview_date', '>', now())
                ->where('interview_date', '<=', now()->addDays(3))
                ->count(),
            'incomplete_profiles'    => User::where('role', 'candidate')
                ->whereHas('profile', fn($q) => $q->where(function($q2) {
                    $q2->whereNull('resume_path')
                       ->orWhereNull('profile_photo_path')
                       ->orWhereNull('preferred_city_id');
                })->where('is_fee_paid', true))
                ->count(),
            'plan_expiring'          => User::where('role', 'candidate')
                ->whereHas('profile', fn($q) => $q->whereRaw('(total_allowed_applications - used_applications) <= 1')->where('total_allowed_applications', '>', 0))
                ->count(),
            'late_fees'              => ServiceChargeInvoice::where('late_fee', '>', 0)->whereIn('status', ['pending', 'overdue'])->count(),
            'total_candidates'       => User::where('role', 'candidate')->count(),
        ];

        // Recent reminder logs (last 20 reminders sent by admin)
        $recentLogs = DB::table('admin_reminder_logs')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Candidates for individual targeting
        $candidates = User::where('role', 'candidate')
            ->with('profile')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);

        // Applications with upcoming interviews (for individual interview reminder)
        $upcomingInterviews = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost'])
            ->orderBy('interview_date')
            ->get();

        return view('admin.reminders.index', compact('stats', 'recentLogs', 'candidates', 'upcomingInterviews'));
    }

    /**
     * Send Service Charge Reminder
     */
    public function sendServiceChargeReminder(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        } // null = all

        $query = ServiceChargeInvoice::whereIn('status', ['pending', 'overdue'])
            ->with('candidate');

        if (!$sendToAll) {
            $query->whereIn('candidate_id', $candidateIds);
        }

        $invoices = $query->get();
        $count    = 0;

        foreach ($invoices as $invoice) {
            $candidate = $invoice->candidate;
            if (!$candidate) continue;

            $dueDate  = Carbon::parse($invoice->due_date)->format('d M Y');
            $totalAmt = number_format($invoice->amount + $invoice->late_fee, 2);

            NotificationHelper::notifyUser(
                $candidate->id,
                '💳 Service Charge Payment Reminder',
                'Admin reminder: Your service charge of ₹' . $totalAmt . ' is due by ' . $dueDate . '. Please pay immediately to avoid late fees.',
                route('candidate.serviceCharge.show'),
                'fas fa-rupee-sign'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\LateFeeAlertMail($invoice, $invoice->late_fee));
            } catch (\Exception $e) {
                Log::error("ServiceChargeReminder (admin) email failed: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('service_charge', $count, null);

        return back()->with('success', "✅ Service charge reminders sent to {$count} candidate(s).");
    }

    /**
     * Send Registration Renewal Reminder
     */
    public function sendRenewalReminder(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->whereColumn('used_applications', '>=', 'total_allowed_applications')->where('total_allowed_applications', '>', 0));

        if (!$sendToAll) {
            $query->whereIn('id', $candidateIds);
        }

        $candidates = $query->with('profile')->get();
        $count      = 0;

        foreach ($candidates as $candidate) {
            NotificationHelper::notifyUser(
                $candidate->id,
                '🔄 Renewal Reminder from Admin',
                'Admin message: Your registration plan has expired. Please renew your plan to get new placement opportunities from Warriors Educare.',
                route('candidate.dashboard'),
                'fas fa-redo-alt'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\RenewalReminderMail($candidate));
            } catch (\Exception $e) {
                Log::error("RenewalReminder (admin) email failed: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('renewal', $count, null);

        return back()->with('success', "✅ Renewal reminders sent to {$count} candidate(s).");
    }

    /**
     * Send Pending Payment Reminder (Standard Plan ₹500 pending)
     */
    public function sendPaymentPendingReminder(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->where('plan_type', 'standard')->where('pending_amount', '>', 0));

        if (!$sendToAll) {
            $query->whereIn('id', $candidateIds);
        }

        $candidates = $query->with('profile')->get();
        $count      = 0;

        foreach ($candidates as $candidate) {
            $pending = $candidate->profile->pending_amount;

            NotificationHelper::notifyUser(
                $candidate->id,
                '💰 Registration Payment Pending',
                'Admin reminder: You have ₹' . number_format($pending, 2) . ' registration fee pending. Please complete your payment to activate all features.',
                route('candidate.dashboard'),
                'fas fa-wallet'
            );

            $count++;
        }

        $this->logReminderAction('payment_pending', $count, null);

        return back()->with('success', "✅ Payment pending reminders sent to {$count} candidate(s).");
    }

    /**
     * Send Interview Reminder
     */
    public function sendInterviewReminder(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $applicationIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($applicationIds)) {
            return back()->with('error', 'Please select at least one interview.');
        }

        $query = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost']);

        if (!$sendToAll) {
            $query->whereIn('id', $applicationIds);
        } else {
            $query->where('interview_date', '<=', now()->addDays(3));
        }

        $applications = $query->get();
        $count        = 0;

        foreach ($applications as $application) {
            $candidate   = $application->candidate;
            $interviewDt = Carbon::parse($application->interview_date)->format('d M Y, h:i A');

            if (!$candidate) continue;

            NotificationHelper::notifyUser(
                $candidate->id,
                '🎯 Interview Reminder from Admin',
                'Admin reminder: You have an interview scheduled for "' . ($application->jobPost->title ?? 'a position') . '" at ' . ($application->jobPost->school_name ?? 'school') . ' on ' . $interviewDt . '. Please be prepared!',
                route('candidate.applications.index'),
                'fas fa-calendar-check'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\InterviewScheduledMail($application));
            } catch (\Exception $e) {
                Log::error("InterviewReminder (admin) email failed: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('interview', $count, null);

        return back()->with('success', "✅ Interview reminders sent to {$count} candidate(s).");
    }

    /**
     * Send Profile Completion Reminder
     */
    public function sendProfileCompletionReminder(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->where(function($q2) {
                $q2->whereNull('resume_path')
                   ->orWhereNull('profile_photo_path')
                   ->orWhereNull('preferred_city_id');
            })->where('is_fee_paid', true));

        if (!$sendToAll) {
            $query->whereIn('id', $candidateIds);
        }

        $candidates = $query->with('profile')->get();
        $count      = 0;

        foreach ($candidates as $candidate) {
            $profile = $candidate->profile;
            $missing = [];
            if (!$profile?->resume_path) $missing[] = 'Resume';
            if (!$profile?->profile_photo_path)  $missing[]  = 'Photo';
            if (!$profile?->preferred_city_id) $missing[] = 'Location';

            NotificationHelper::notifyUser(
                $candidate->id,
                '📝 Complete Your Profile',
                'Admin reminder: Your profile is incomplete. Missing: ' . implode(', ', $missing) . '. Complete your profile to increase your chances of placement.',
                route('candidate.profile.edit'),
                'fas fa-user-edit'
            );

            $count++;
        }

        $this->logReminderAction('profile_completion', $count, null);

        return back()->with('success', "✅ Profile completion reminders sent to {$count} candidate(s).");
    }

    /**
     * Send Plan Expiry Warning (1 application remaining)
     */
    public function sendPlanExpiryReminder(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->whereRaw('(total_allowed_applications - used_applications) <= 1')
                ->where('total_allowed_applications', '>', 0));

        if (!$sendToAll) {
            $query->whereIn('id', $candidateIds);
        }

        $candidates = $query->with('profile')->get();
        $count      = 0;

        foreach ($candidates as $candidate) {
            $remaining = max(0, $candidate->profile->total_allowed_applications - $candidate->profile->used_applications);

            NotificationHelper::notifyUser(
                $candidate->id,
                '⚠️ Plan Expiry Warning',
                'Admin reminder: You only have ' . $remaining . ' application(s) remaining on your current plan. Consider renewing to keep getting placement opportunities.',
                route('candidate.dashboard'),
                'fas fa-exclamation-triangle'
            );

            $count++;
        }

        $this->logReminderAction('plan_expiry', $count, null);

        return back()->with('success', "✅ Plan expiry warnings sent to {$count} candidate(s).");
    }

    /**
     * Send Late Fee Alert
     */
    public function sendLateFeeAlert(Request $request)
    {
        $sendToAll = $request->input('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = ServiceChargeInvoice::where('late_fee', '>', 0)
            ->whereIn('status', ['pending', 'overdue'])
            ->with('candidate');

        if (!$sendToAll) {
            $query->whereIn('candidate_id', $candidateIds);
        }

        $invoices = $query->get();
        $count    = 0;

        foreach ($invoices as $invoice) {
            $candidate = $invoice->candidate;
            if (!$candidate) continue;

            NotificationHelper::notifyUser(
                $candidate->id,
                '🚨 Late Fee Alert',
                'Admin alert: A late fee of ₹' . number_format($invoice->late_fee, 2) . ' has been added to your service charge invoice. Total due: ₹' . number_format($invoice->amount + $invoice->late_fee, 2) . '. Please pay immediately.',
                route('candidate.serviceCharge.show'),
                'fas fa-exclamation-circle'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\LateFeeAlertMail($invoice, $invoice->late_fee));
            } catch (\Exception $e) {
                Log::error("LateFeeAlert (admin) email failed: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('late_fee', $count, null);

        return back()->with('success', "✅ Late fee alerts sent to {$count} candidate(s).");
    }

    /**
     * Send Custom Message
     */
    public function sendCustomMessage(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:100',
            'message'      => 'required|string|max:500',
            'target'       => 'required|in:all,specific',
            'candidate_ids' => 'required_if:target,specific|array',
            'candidate_ids.*' => 'exists:users,id',
            'send_email'   => 'boolean',
        ]);

        if ($request->target === 'specific') {
            if(empty($request->candidate_ids)) return back()->with('error', 'Please select at least one candidate.');
            $candidates = User::whereIn('id', $request->candidate_ids)->get();
        } else {
            $candidates = User::where('role', 'candidate')->get();
        }

        $count = 0;

        foreach ($candidates as $candidate) {
            // DB Notification
            NotificationHelper::notifyUser(
                $candidate->id,
                $request->title,
                $request->message,
                null,
                'fas fa-bullhorn'
            );

            // Email (optional)
            if ($request->boolean('send_email') && $candidate->email) {
                try {
                    Mail::to($candidate->email)->send(
                        new \App\Mail\CustomAdminMessageMail($candidate, $request->title, $request->message)
                    );
                } catch (\Exception $e) {
                    Log::error("CustomMessage email failed for {$candidate->email}: " . $e->getMessage());
                }
            }

            $count++;
        }

        $this->logReminderAction('custom', $count, null, $request->title . ' (Multiple)');

        return back()->with('success', "✅ Custom message sent to {$count} candidate(s).");
    }

    /**
     * Log admin reminder action
     */
    private function logReminderAction(string $type, int $count, ?int $candidateId = null, ?string $note = null): void
    {
        try {
            DB::table('admin_reminder_logs')->insert([
                'admin_id'     => auth()->id(),
                'type'         => $type,
                'target'       => $candidateId ? "Candidate #{$candidateId}" : 'All',
                'count_sent'   => $count,
                'note'         => $note,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        } catch (\Exception $e) {
            // Logging table might not exist yet, ignore
        }
    }
}
