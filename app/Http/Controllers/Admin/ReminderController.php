<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Models\ServiceChargeInvoice;
use App\Models\JobApplication;
use App\Models\TuitionApplication;
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
        // Stats for the analytics cards
        $stats = [
            'job_service_pending'     => ServiceChargeInvoice::whereNull('home_tuition_lead_id')->whereIn('status', ['pending', 'overdue'])->count(),
            'tuition_service_pending' => ServiceChargeInvoice::whereNotNull('home_tuition_lead_id')->whereIn('status', ['pending', 'overdue'])->count(),
            'agreement_pending'       => User::where('role', 'candidate')
                ->whereHas('profile', fn($q) => $q->where('is_agreement_signed', false)->orWhere('is_tuition_agreement_signed', false))
                ->count(),
            'upcoming_interviews'     => JobApplication::whereNotNull('interview_date')
                ->where('interview_date', '>', now())
                ->where('interview_date', '<=', now()->addDays(5))
                ->count(),
            'upcoming_demos'          => TuitionApplication::whereNotNull('demo_date')
                ->where('demo_date', '>', now())
                ->where('demo_date', '<=', now()->addDays(5))
                ->count(),
            'incomplete_profiles'     => User::where('role', 'candidate')
                ->whereHas('profile', fn($q) => $q->whereNull('resume_path')
                    ->orWhereNull('subject_id')
                    ->orWhereNull('highest_qualification_id')
                    ->orWhereNull('preferred_city_id')
                )
                ->count(),
            'late_fees'               => ServiceChargeInvoice::where('late_fee', '>', 0)->whereIn('status', ['pending', 'overdue'])->count(),
            'total_candidates'        => User::where('role', 'candidate')->count(),
        ];

        // Recent reminder logs
        $recentLogs = collect();
        try {
            $recentLogs = DB::table('admin_reminder_logs')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
        } catch (\Exception $e) {
            // If table doesn't exist, ignore
        }

        // Targeted Candidate Lists for UI forms
        $jobInvoices = ServiceChargeInvoice::whereNull('home_tuition_lead_id')
            ->whereIn('status', ['pending', 'overdue'])
            ->with(['candidate', 'jobApplication.jobPost'])
            ->get();

        $tuitionInvoices = ServiceChargeInvoice::whereNotNull('home_tuition_lead_id')
            ->whereIn('status', ['pending', 'overdue'])
            ->with(['candidate', 'tuitionLead'])
            ->get();

        $pendingAgreementCandidates = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->where('is_agreement_signed', false)->orWhere('is_tuition_agreement_signed', false))
            ->with('profile')
            ->orderBy('name')
            ->get();

        $incompleteCandidates = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->whereNull('resume_path')
                ->orWhereNull('subject_id')
                ->orWhereNull('highest_qualification_id')
                ->orWhereNull('preferred_city_id')
            )
            ->with('profile')
            ->orderBy('name')
            ->get();

        $upcomingInterviews = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost'])
            ->orderBy('interview_date')
            ->get();

        $upcomingDemos = TuitionApplication::whereNotNull('demo_date')
            ->where('demo_date', '>', now())
            ->with(['candidate', 'tuitionLead'])
            ->orderBy('demo_date')
            ->get();

        $lateFeeInvoices = ServiceChargeInvoice::where('late_fee', '>', 0)
            ->whereIn('status', ['pending', 'overdue'])
            ->with('candidate')
            ->get();

        $allCandidates = User::where('role', 'candidate')
            ->with('profile')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);

        $candidatesList = $allCandidates->map(function($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'phone' => $c->phone,
            ];
        });

        return view('admin.reminders.index', compact(
            'stats',
            'recentLogs',
            'jobInvoices',
            'tuitionInvoices',
            'pendingAgreementCandidates',
            'incompleteCandidates',
            'upcomingInterviews',
            'upcomingDemos',
            'lateFeeInvoices',
            'allCandidates',
            'candidatesList'
        ));
    }

    /**
     * Send School Job Placement Service Charge Reminder
     */
    public function sendServiceChargeReminder(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $invoiceIds = $request->input('invoice_ids', []);

        if (!$sendToAll && empty($invoiceIds)) {
            return back()->with('error', 'Please select at least one invoice or choose Send to All.');
        }

        $query = ServiceChargeInvoice::whereNull('home_tuition_lead_id')
            ->whereIn('status', ['pending', 'overdue'])
            ->with(['candidate', 'jobApplication.jobPost']);

        if (!$sendToAll) {
            $query->whereIn('id', $invoiceIds);
        }

        $invoices = $query->get();
        $count = 0;

        foreach ($invoices as $invoice) {
            $candidate = $invoice->candidate;
            if (!$candidate) continue;

            $dueDate  = Carbon::parse($invoice->due_date)->format('d M Y');
            $totalAmt = number_format($invoice->amount + $invoice->late_fee, 2);
            $jobTitle = $invoice->jobApplication?->jobPost?->title ?? 'School Placement';

            NotificationHelper::notifyUser(
                $candidate->id,
                '💼 School Placement Service Charge Due: ₹' . $totalAmt,
                "Admin reminder: Your placement fee for '{$jobTitle}' is ₹{$totalAmt}, due by {$dueDate}. Please pay to keep your account active.",
                route('candidate.serviceCharge.show'),
                'fas fa-file-invoice-dollar'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\LateFeeAlertMail($invoice, $invoice->late_fee));
            } catch (\Exception $e) {
                Log::error("School Placement Fee Reminder email failed for {$candidate->email}: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('job_service_charge', $count, null);

        return back()->with('success', "✅ Placement fee reminders sent to {$count} candidate(s).");
    }

    /**
     * Send Home Tuition Service Fee Reminder
     */
    public function sendTuitionServiceReminder(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $invoiceIds = $request->input('invoice_ids', []);

        if (!$sendToAll && empty($invoiceIds)) {
            return back()->with('error', 'Please select at least one tuition invoice or choose Send to All.');
        }

        $query = ServiceChargeInvoice::whereNotNull('home_tuition_lead_id')
            ->whereIn('status', ['pending', 'overdue'])
            ->with(['candidate', 'tuitionLead']);

        if (!$sendToAll) {
            $query->whereIn('id', $invoiceIds);
        }

        $invoices = $query->get();
        $count = 0;

        foreach ($invoices as $invoice) {
            $candidate = $invoice->candidate;
            if (!$candidate) continue;

            $dueDate  = Carbon::parse($invoice->due_date)->format('d M Y');
            $totalAmt = number_format($invoice->amount + $invoice->late_fee, 2);
            $tuitionDesc = $invoice->tuitionLead ? ("Class " . $invoice->tuitionLead->class . " in " . $invoice->tuitionLead->location) : "Home Tuition Assignment";

            NotificationHelper::notifyUser(
                $candidate->id,
                '🏠 Tuition Service Charge Due: ₹' . $totalAmt,
                "Admin reminder: Your service charge for tuition ({$tuitionDesc}) is ₹{$totalAmt}, due by {$dueDate}. Please pay immediately.",
                route('candidate.serviceCharge.show'),
                'fas fa-chalkboard-teacher'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\LateFeeAlertMail($invoice, $invoice->late_fee));
            } catch (\Exception $e) {
                Log::error("Tuition Service Charge Reminder email failed for {$candidate->email}: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('tuition_service_charge', $count, null);

        return back()->with('success', "✅ Tuition service charge reminders sent to {$count} tutor(s).");
    }

    /**
     * AJAX live search candidates for reminder center (Handles 10,000+ candidates efficiently)
     */
    public function searchCandidates(Request $request)
    {
        $q = trim($request->input('q', ''));
        $category = $request->input('category', 'all');

        $query = User::where('role', 'candidate')->with('profile');

        if ($category === 'pending_agreement') {
            $query->whereHas('profile', fn($sq) => $sq->where('is_agreement_signed', false)->orWhere('is_tuition_agreement_signed', false));
        } elseif ($category === 'incomplete_profile') {
            $query->whereHas('profile', fn($sq) => $sq->whereNull('resume_path')
                ->orWhereNull('subject_id')
                ->orWhereNull('highest_qualification_id')
                ->orWhereNull('preferred_city_id')
            );
        }

        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        $candidates = $query->limit(50)->get(['id', 'name', 'email', 'phone'])->map(function($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'phone' => $c->phone,
                'display' => "{$c->name} (" . ($c->phone ?: $c->email) . ") - #{$c->id}",
            ];
        });

        return response()->json($candidates);
    }

    /**
     * Send Digital Agreement Signing Reminder
     */
    public function sendAgreementReminder(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->where('is_agreement_signed', false)->orWhere('is_tuition_agreement_signed', false));

        if (!$sendToAll) {
            $query->whereIn('id', $candidateIds);
        }

        $candidates = $query->with('profile')->get();
        $count = 0;

        foreach ($candidates as $candidate) {
            NotificationHelper::notifyUser(
                $candidate->id,
                '✍️ Action Required: Sign Candidate Agreement',
                'Admin reminder: Please review and digitally sign your Teacher Placement & Tuition Agreement to unlock direct applications and hiring.',
                route('candidate.agreement.show'),
                'fas fa-file-signature'
            );

            // Update status so banner shows on candidate dashboard
            if ($candidate->profile && $candidate->profile->agreement_status !== 'signed') {
                $candidate->profile->update(['agreement_status' => 'pending_signature']);
            }

            try {
                if ($candidate->email) {
                    Mail::to($candidate->email)->send(new \App\Mail\AgreementPendingMail($candidate));
                }
            } catch (\Exception $e) {
                Log::error("Agreement reminder email failed for {$candidate->email}: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('agreement_signing', $count, null);

        return back()->with('success', "✅ Agreement signing reminders (Notification + Email) sent to {$count} candidate(s).");
    }

    /**
     * Send School Job Interview Reminder
     */
    public function sendInterviewReminder(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $applicationIds = $request->input('application_ids', []);

        if (!$sendToAll && empty($applicationIds)) {
            return back()->with('error', 'Please select at least one interview.');
        }

        $query = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost']);

        if (!$sendToAll) {
            $query->whereIn('id', $applicationIds);
        } else {
            $query->where('interview_date', '<=', now()->addDays(5));
        }

        $applications = $query->get();
        $count = 0;

        foreach ($applications as $application) {
            $candidate   = $application->candidate;
            if (!$candidate) continue;

            $interviewDt = Carbon::parse($application->interview_date)->format('d M Y, h:i A');
            $jobTitle    = $application->jobPost->title ?? 'Teacher Position';
            $schoolName  = $application->jobPost->school_name ?? 'School';

            NotificationHelper::notifyUser(
                $candidate->id,
                '🎯 Upcoming School Interview Reminder',
                "Admin reminder: Your interview for '{$jobTitle}' at {$schoolName} is scheduled on {$interviewDt}. Please ensure you are prepared.",
                route('candidate.applications.index'),
                'fas fa-calendar-check'
            );

            try {
                if ($candidate->email) {
                    Mail::to($candidate->email)->send(new \App\Mail\InterviewReminderMail($application));
                }
            } catch (\Exception $e) {
                Log::error("Interview reminder email failed: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('interview', $count, null);

        return back()->with('success', "✅ Interview reminders (Notification + Email) sent to {$count} candidate(s).");
    }

    /**
     * Send Home Tuition Demo Class Reminder
     */
    public function sendTuitionDemoReminder(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $applicationIds = $request->input('application_ids', []);

        if (!$sendToAll && empty($applicationIds)) {
            return back()->with('error', 'Please select at least one tuition demo.');
        }

        $query = TuitionApplication::whereNotNull('demo_date')
            ->where('demo_date', '>', now())
            ->with(['candidate', 'tuitionLead']);

        if (!$sendToAll) {
            $query->whereIn('id', $applicationIds);
        } else {
            $query->where('demo_date', '<=', now()->addDays(5));
        }

        $tuitionApps = $query->get();
        $count = 0;

        foreach ($tuitionApps as $app) {
            $candidate = $app->candidate;
            if (!$candidate) continue;

            $demoDt = Carbon::parse($app->demo_date)->format('d M Y, h:i A');
            $leadInfo = $app->tuitionLead ? ("Class " . $app->tuitionLead->class . " in " . $app->tuitionLead->location) : "Home Tuition";

            NotificationHelper::notifyUser(
                $candidate->id,
                '🎓 Home Tuition Demo Class Reminder',
                "Admin reminder: Your trial demo session for {$leadInfo} is scheduled on {$demoDt}. Please contact parent and arrive on time.",
                route('candidate.tuitions.index'),
                'fas fa-chalkboard-teacher'
            );

            try {
                if ($candidate->email) {
                    Mail::to($candidate->email)->send(new \App\Mail\TuitionDemoReminderMail($app));
                }
            } catch (\Exception $e) {
                Log::error("Tuition demo reminder email failed for {$candidate->email}: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('tuition_demo', $count, null);

        return back()->with('success', "✅ Tuition demo reminders (Notification + Email) sent to {$count} tutor(s).");
    }

    /**
     * Send Profile Completion Reminder
     */
    public function sendProfileCompletionReminder(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $candidateIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($candidateIds)) {
            return back()->with('error', 'Please select at least one candidate.');
        }

        $query = User::where('role', 'candidate')
            ->whereHas('profile', fn($q) => $q->whereNull('resume_path')
                ->orWhereNull('subject_id')
                ->orWhereNull('highest_qualification_id')
                ->orWhereNull('preferred_city_id')
            );

        if (!$sendToAll) {
            $query->whereIn('id', $candidateIds);
        }

        $candidates = $query->with('profile')->get();
        $count = 0;

        foreach ($candidates as $candidate) {
            $profile = $candidate->profile;
            $missing = [];
            if (!$profile?->highest_qualification_id) $missing[] = 'Qualification';
            if (!$profile?->subject_id) $missing[] = 'Primary Subject';
            if (!$profile?->preferred_city_id) $missing[] = 'Preferred City';
            if (!$profile?->resume_path) $missing[] = 'Resume';

            NotificationHelper::notifyUser(
                $candidate->id,
                '📝 Complete Your Teaching Profile',
                'Admin reminder: Your profile is missing: ' . (implode(', ', $missing) ?: 'details') . '. Complete it now to get shortlisted for teaching jobs and home tuitions.',
                route('candidate.profile.edit'),
                'fas fa-user-edit'
            );

            try {
                if ($candidate->email) {
                    Mail::to($candidate->email)->send(new \App\Mail\ProfileCompletionReminderMail($candidate, $missing));
                }
            } catch (\Exception $e) {
                Log::error("Profile completion reminder email failed for {$candidate->email}: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('profile_completion', $count, null);

        return back()->with('success', "✅ Profile completion reminders (Notification + Email) sent to {$count} candidate(s).");
    }

    /**
     * Send Late Fee & Overdue Alert
     */
    public function sendLateFeeAlert(Request $request)
    {
        $sendToAll = $request->boolean('send_to_all');
        $invoiceIds = $request->input('invoice_ids', []);

        if (!$sendToAll && empty($invoiceIds)) {
            return back()->with('error', 'Please select at least one overdue invoice.');
        }

        $query = ServiceChargeInvoice::where('late_fee', '>', 0)
            ->whereIn('status', ['pending', 'overdue'])
            ->with('candidate');

        if (!$sendToAll) {
            $query->whereIn('id', $invoiceIds);
        }

        $invoices = $query->get();
        $count = 0;

        foreach ($invoices as $invoice) {
            $candidate = $invoice->candidate;
            if (!$candidate) continue;

            $totalAmt = number_format($invoice->amount + $invoice->late_fee, 2);

            NotificationHelper::notifyUser(
                $candidate->id,
                '🚨 Urgent: Late Fee Applied on Service Charge',
                'Admin alert: A late fee of ₹' . number_format($invoice->late_fee, 2) . ' is applied. Total due: ₹' . $totalAmt . '. Clear your dues immediately to avoid legal hold.',
                route('candidate.serviceCharge.show'),
                'fas fa-exclamation-circle'
            );

            try {
                Mail::to($candidate->email)->send(new \App\Mail\LateFeeAlertMail($invoice, $invoice->late_fee));
            } catch (\Exception $e) {
                Log::error("LateFeeAlert email failed: " . $e->getMessage());
            }

            $count++;
        }

        $this->logReminderAction('late_fee', $count, null);

        return back()->with('success', "✅ Late fee alerts sent to {$count} candidate(s).");
    }

    /**
     * Send Custom Broadcast Message
     */
    public function sendCustomMessage(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:100',
            'message'         => 'required|string|max:600',
            'target'          => 'required|in:all,specific',
            'candidate_ids'   => 'required_if:target,specific|array',
            'candidate_ids.*' => 'exists:users,id',
            'send_email'      => 'boolean',
        ]);

        if ($request->target === 'specific') {
            if (empty($request->candidate_ids)) return back()->with('error', 'Please select at least one candidate.');
            $candidates = User::whereIn('id', $request->candidate_ids)->get();
        } else {
            $candidates = User::where('role', 'candidate')->get();
        }

        $count = 0;

        foreach ($candidates as $candidate) {
            NotificationHelper::notifyUser(
                $candidate->id,
                $request->title,
                $request->message,
                route('candidate.dashboard'),
                'fas fa-bullhorn'
            );

            if ($request->boolean('send_email') && $candidate->email) {
                try {
                    Mail::to($candidate->email)->send(
                        new \App\Mail\CustomAdminMessageMail($candidate, $request->title, $request->message)
                    );
                } catch (\Exception $e) {
                    Log::error("Custom broadcast email failed for {$candidate->email}: " . $e->getMessage());
                }
            }

            $count++;
        }

        $this->logReminderAction('custom', $count, null, $request->title);

        return back()->with('success', "✅ Custom message sent to {$count} candidate(s).");
    }

    /**
     * Log admin reminder action
     */
    private function logReminderAction(string $type, int $count, ?int $candidateId = null, ?string $note = null): void
    {
        try {
            DB::table('admin_reminder_logs')->insert([
                'admin_id'   => auth()->id(),
                'type'       => $type,
                'target'     => $candidateId ? "Candidate #{$candidateId}" : 'All Matching',
                'count_sent' => $count,
                'note'       => $note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Ignore if table not present
        }
    }
}
