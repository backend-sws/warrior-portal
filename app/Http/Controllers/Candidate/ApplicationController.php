<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private function ensureRegistrationComplete()
    {
        return null;
    }

    public function index()
    {
        if ($redirect = $this->ensureRegistrationComplete()) return $redirect;

        $applications = JobApplication::with(['jobPost.category', 'jobPost.city', 'jobPost.state'])
            ->where('candidate_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('candidate.applications.index', compact('applications'));
    }

    public function available()
    {
        if ($redirect = $this->ensureRegistrationComplete()) return $redirect;

        $user = auth()->user();
        $profile = $user->profile;

        // Get approved jobs
        $jobs = JobPost::with(['category', 'subject', 'city', 'state', 'qualification'])
            ->where('status', 'approved')
            ->whereDoesntHave('applications', function ($query) use ($user) {
                $query->where('candidate_id', $user->id);
            })
            ->get();

        // Calculate match scores
        $matchedJobs = $jobs->map(function ($job) use ($profile) {
            $score = 0;
            
            // Subject match is most important (40%)
            if ($job->subject_id == $profile->subject_id) $score += 40;
            
            // Category match (30%)
            if ($job->category_id == $profile->category_id) $score += 30;
            
            // Qualification match (20%)
            if ($job->qualification_id == $profile->highest_qualification_id) $score += 20;
            
            // Location match (10%)
            if ($job->city_id == $profile->preferred_city_id) $score += 10;
            elseif ($job->state_id == $profile->preferred_state_id) $score += 5;
            
            $job->match_score = $score;
            return $job;
        })->sortByDesc('match_score')->values();

        return view('candidate.applications.available', compact('matchedJobs'));
    }

    public function apply(Request $request, JobPost $job)
    {
        if ($redirect = $this->ensureRegistrationComplete()) return $redirect;

        $user = auth()->user();
        $profile = $user->profile;

        // Calculate score again for saving
        $score = 0;
        if ($job->subject_id == $profile->subject_id) $score += 40;
        if ($job->category_id == $profile->category_id) $score += 30;
        if ($job->qualification_id == $profile->highest_qualification_id) $score += 20;
        if ($job->city_id == $profile->preferred_city_id) $score += 10;
        elseif ($job->state_id == $profile->preferred_state_id) $score += 5;

        // Prevent duplicate application
        if (JobApplication::where('job_post_id', $job->id)->where('candidate_id', $user->id)->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        // Check if candidate is already hired (Plan Ended) in the current plan cycle
        if (JobApplication::where('candidate_id', $user->id)
            ->where('status', 'hired')
            ->where('created_at', '>=', $profile->plan_started_at ?? $profile->created_at)
            ->exists()) {
            return back()->with('error', 'Congratulations on being selected! Your current plan has successfully ended. You cannot apply for new jobs at this time.');
        }

        // Limit Check (Applies to all plans)
        if ($profile->used_applications >= $profile->total_allowed_applications) {
            return back()->with('error', 'You have reached your maximum allowed applications for your current plan.');
        }

        JobApplication::create([
            'job_post_id' => $job->id,
            'candidate_id' => $user->id,
            'status' => 'applied',
            'match_score' => $score
        ]);

        $profile->increment('used_applications');

        $remaining = $profile->total_allowed_applications - $profile->used_applications;

        // --- Confirm application to candidate ---
        NotificationHelper::notifyUser(
            $user->id,
            'Application Submitted ✅',
            'You have successfully applied for "' . $job->title . '" at ' . $job->school_name . '. You have ' . $remaining . ' application(s) remaining.',
            route('candidate.applications.index'),
            'fas fa-briefcase'
        );

        // Check if they need a warning (1 remaining)
        if ($remaining === 1) {
            // DB Notification
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id'              => \Illuminate\Support\Str::uuid(),
                'type'            => 'App\Notifications\RegistrationExpiryWarning',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id'   => $user->id,
                'data'            => json_encode([
                    'title'   => 'Almost Out of Applications! ⚠️',
                    'message' => 'You only have 1 application remaining on your current plan. Use it wisely!',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Email Notification
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\RegistrationExpiryMail($user, $remaining));
        }

        // Check if plan is now expired (0 remaining)
        if ($remaining <= 0) {
            NotificationHelper::notifyUser(
                $user->id,
                'Registration Plan Expired 🔄',
                'You have used all your application opportunities. Your registration plan has expired. Please renew to continue applying.',
                route('candidate.dashboard'),
                'fas fa-exclamation-triangle'
            );

            // Email
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\RenewalReminderMail($user));
            } catch (\Exception $e) {
                \Log::error('RenewalReminder Email Error: ' . $e->getMessage());
            }

            // Notify Admin
            NotificationHelper::notifyAdmin(
                'Candidate Plan Expired',
                $user->name . '\'s registration plan has expired (all ' . $profile->total_allowed_applications . ' applications used).',
                null,
                'fas fa-user-times'
            );
        }

        // Notify Admin of new application
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\NewJobApplication',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $adminUser->id,
                'data' => json_encode([
                    'title' => 'New Job Application',
                    'message' => $user->name . ' has applied for ' . $job->title . ' at ' . $job->school_name . '.',
                    'candidate_id' => $user->id,
                    'job_id' => $job->id
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('candidate.applications.index')->with('success', 'Application submitted successfully.');
    }
}
