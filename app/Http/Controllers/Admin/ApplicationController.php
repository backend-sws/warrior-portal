<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ApplicationForwarded;
use App\Mail\InterviewScheduledMail;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with(['candidate', 'jobPost.user']);

        if ($search = $request->input('search')) {
            $query->whereHas('candidate', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('jobPost', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'rejected') {
                $query->whereIn('status', ['rejected', 'rejected_by_admin', 'rejected_by_school', 'tutor_backed_out']);
            } elseif ($status === 'forwarded') {
                $query->whereIn('status', ['shortlisted', 'forwarded_to_school', 'demo_scheduled']);
            } else {
                $query->where('status', $status);
            }
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        // Base query for stats (reflecting search filter if present)
        $baseQuery = JobApplication::query();
        if ($search = $request->input('search')) {
            $baseQuery->where(function($q) use ($search) {
                $q->whereHas('candidate', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('jobPost', function ($jq) use ($search) {
                    $jq->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Analytics based on current filtered query
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'applied' => (clone $baseQuery)->where('status', 'applied')->count(),
            'forwarded' => (clone $baseQuery)->whereIn('status', ['shortlisted', 'forwarded_to_school', 'demo_scheduled'])->count(),
            'hired' => (clone $baseQuery)->where('status', 'hired')->count(),
            'rejected' => (clone $baseQuery)->whereIn('status', ['rejected', 'rejected_by_admin', 'rejected_by_school', 'tutor_backed_out'])->count(),
        ];

        return view('admin.applications.index', compact('applications', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validStatuses = array_merge(array_keys(JobApplication::getStatuses()), ['rejected']);

        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses),
            'remarks' => 'nullable|string',
            'interview_date' => 'nullable|date',
            'interview_link' => 'nullable|string|max:255',
        ]);

        $application = JobApplication::with(['candidate', 'jobPost.user'])->findOrFail($id);
        
        $oldStatus = $application->status;
        $newStatus = $request->status;
        $application->status = $newStatus;
        
        if ($request->has('remarks')) {
            $application->remarks = $request->remarks;
        }

        if ($request->has('interview_date') && !empty($request->interview_date)) {
            $application->interview_date = $request->interview_date;
            $application->interview_link = $request->interview_link;
        } else if ($newStatus === 'applied') {
            // Optional: Clear schedule if status is set back to applied
            $application->interview_date = null;
            $application->interview_link = null;
        }

        if (in_array($newStatus, ['shortlisted', 'forwarded_to_school', 'demo_scheduled', 'hired'])) {
            $application->is_forwarded = true;
        }

        // Email logic based on status
        if (in_array($newStatus, ['shortlisted', 'forwarded_to_school']) && !in_array($oldStatus, ['shortlisted', 'forwarded_to_school'])) {
            try {
                // Send ApplicationForwarded to Candidate
                Mail::to($application->candidate->email)->send(new ApplicationForwarded($application));
            } catch (\Exception $e) {
                Log::error('ApplicationForwarded Mail Error: ' . $e->getMessage());
            }
            
            // Send CandidateForwardedMail to School
            $employerEmail = $application->jobPost->user->email ?? $application->jobPost->email;
            if ($employerEmail) {
                try {
                    Mail::to($employerEmail)->send(new \App\Mail\CandidateForwardedMail($application));
                } catch (\Exception $e) {
                    Log::error('CandidateForwarded Mail Error: ' . $e->getMessage());
                }
            }
        } elseif ($newStatus !== $oldStatus && $newStatus !== 'demo_scheduled') {
            // For other status changes, send the generic ApplicationStatusMail
            try {
                Mail::to($application->candidate->email)->send(new \App\Mail\ApplicationStatusMail($application));
            } catch (\Exception $e) {
                Log::error('ApplicationStatusMail Error: ' . $e->getMessage());
            }
        }

        // Demo / Interview Scheduled — send dedicated notification + email
        if ((!empty($request->interview_date) && $request->interview_date !== $application->getOriginal('interview_date')) || ($newStatus === 'demo_scheduled' && $oldStatus !== 'demo_scheduled')) {
            $dateFormatted = $request->interview_date ? \Carbon\Carbon::parse($request->interview_date)->format('d M Y, h:i A') : 'soon';
            NotificationHelper::notifyUser(
                $application->candidate_id,
                'Demo / Interview Scheduled! 🎯',
                'Your demo/interview for "' . $application->jobPost->title . '" at ' . $application->jobPost->school_name . ' has been scheduled on ' . $dateFormatted . '.',
                route('candidate.applications.index'),
                'fas fa-calendar-check'
            );

            // Email
            try {
                Mail::to($application->candidate->email)->send(new InterviewScheduledMail($application));
            } catch (\Exception $e) {
                Log::error('InterviewScheduled Email Error: ' . $e->getMessage());
            }
        }

        if ($newStatus !== $oldStatus) {
            $statusLabel = $application->status_label;

            // Notification to candidate
            NotificationHelper::notifyUser(
                $application->candidate_id,
                'Application Status: ' . $statusLabel,
                'Your application for "' . $application->jobPost->title . '" status has been updated to "' . $statusLabel . '".',
                route('candidate.applications.index'),
                'fas fa-file-signature'
            );

            // DB Notification for Candidate Dashboard
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\ApplicationStatusUpdated',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $application->candidate_id,
                'data' => json_encode([
                    'title' => 'Application Update',
                    'message' => 'Your application for ' . $application->jobPost->title . ' is now ' . $statusLabel . '.',
                    'status' => $newStatus,
                    'application_id' => $application->id
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $application->save();

        return back()->with('success', 'Application status updated to "' . $application->status_label . '" successfully.');
    }
}
