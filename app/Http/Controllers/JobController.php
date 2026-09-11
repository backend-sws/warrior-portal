<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\State;
use App\Models\City;
use App\Models\Qualification;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function showPostJobForm()
    {
        $categories = Category::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $qualifications = Qualification::where('is_active', true)->get();
        $states = State::where('is_active', true)->get();

        return view('post-job', compact('categories', 'subjects', 'qualifications', 'states'));
    }

    public function show(JobPost $job)
    {
        if ($job->status !== 'approved') {
            $user = Auth::user();
            $canPreview = $user && (
                $user->role === 'admin' ||
                $user->id === $job->user_id
            );

            if (!$canPreview) {
                abort(404);
            }
        }
        
        $job->load(['category', 'subject', 'qualification', 'specialization', 'state', 'city']);

        $similarJobs = JobPost::with(['category', 'subject', 'city', 'state'])
            ->where('status', 'approved')
            ->where('id', '!=', $job->id)
            ->where(function($q) use ($job) {
                $q->where('category_id', $job->category_id)
                  ->orWhere('subject_id', $job->subject_id);
            })
            ->latest()
            ->take(3)
            ->get();

        $hasApplied = false;
        if (auth()->check() && auth()->user()->role === 'candidate') {
            $hasApplied = \App\Models\JobApplication::where('job_post_id', $job->id)
                ->where('candidate_id', auth()->id())
                ->exists();
        }

        return view('jobs.show', compact('job', 'similarJobs', 'hasApplied'));
    }

    public function storeJobQuery(Request $request)
    {
        // Resolve manual inputs if provided alongside selective dropdowns
        if ($request->filled('manual_category')) {
            $cat = \App\Models\Category::firstOrCreate(
                ['name' => trim($request->manual_category)],
                ['is_active' => true]
            );
            $request->merge(['category_id' => $cat->id]);
        } elseif ($request->category_id === '__manual__') {
            $request->merge(['category_id' => null]);
        }

        if ($request->filled('manual_state')) {
            $st = \App\Models\State::firstOrCreate(
                ['name' => trim($request->manual_state)],
                ['is_active' => true]
            );
            $request->merge(['state_id' => $st->id]);
        } elseif ($request->state_id === '__manual__') {
            $request->merge(['state_id' => null]);
        }

        if ($request->filled('manual_city')) {
            $stateId = $request->state_id;
            if (!$stateId) {
                $stateId = \App\Models\State::where('is_active', true)->first()->id ?? 1;
            }
            $ct = \App\Models\City::firstOrCreate(
                ['name' => trim($request->manual_city), 'state_id' => $stateId],
                ['is_active' => true]
            );
            $request->merge(['city_id' => $ct->id]);
        } elseif ($request->city_id === '__manual__') {
            $request->merge(['city_id' => null]);
        }

        if ($request->filled('manual_subject')) {
            $sub = \App\Models\Subject::firstOrCreate(
                ['name' => trim($request->manual_subject)],
                ['is_active' => true]
            );
            if ($request->category_id && !$sub->categories()->where('categories.id', $request->category_id)->exists()) {
                $sub->categories()->attach($request->category_id);
            }
            $request->merge(['subject_id' => $sub->id]);
        } elseif ($request->subject_id === '__manual__') {
            $request->merge(['subject_id' => null]);
        }

        if ($request->filled('manual_qualification')) {
            $qual = \App\Models\Qualification::firstOrCreate(
                ['name' => trim($request->manual_qualification)],
                ['is_active' => true]
            );
            $request->merge(['qualification_id' => $qual->id]);
        } elseif ($request->qualification_id === '__manual__') {
            $request->merge(['qualification_id' => null]);
        }

        $request->validate([
            'school_name' => ['required', 'string', 'min:3', 'max:200'],
            'contact_person' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'description' => ['nullable', 'string', 'max:3000'],
            'category_id' => ['required', 'exists:categories,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'specialization_name' => ['nullable', 'string', 'max:255'],
            'specialization_id' => ['nullable', 'exists:specializations,id'],
            'qualification_id' => ['required', 'exists:qualifications,id'],
            'other_qualification' => ['nullable', 'string', 'max:255'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'salary_range' => ['nullable', 'string', 'max:100'],
        ], [
            'school_name.required' => 'Please enter the institution / school name.',
            'school_name.min' => 'School name must be at least 3 characters long.',
            'contact_person.required' => 'Please enter the contact person name.',
            'contact_person.min' => 'Contact person name must be at least 3 characters long.',
            'contact_person.regex' => 'Contact person name should only contain letters and spaces.',
            'email.required' => 'Please provide an official email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter a contact phone number.',
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'title.required' => 'Please enter the job title / position name.',
            'title.min' => 'Job title must be at least 3 characters long.',
            'category_id.required' => 'Please select a job category or enter it manually.',
            'subject_id.required' => 'Please select a subject or enter it manually.',
            'qualification_id.required' => 'Please select the required qualification or enter it manually.',
            'state_id.required' => 'Please select a state or enter it manually.',
            'city_id.required' => 'Please select a city or enter it manually.',
        ]);

        JobPost::create([
            'user_id' => auth()->check() && auth()->user()->role === 'employer' ? auth()->id() : null,
            'school_name' => $request->school_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subject_id' => $request->subject_id,
            'specialization_name' => $request->specialization_name,
            'specialization_id' => $request->specialization_id,
            'qualification_id' => $request->qualification_id,
            'other_qualification' => $request->other_qualification ? trim($request->other_qualification) : null,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'salary_range' => $request->salary_range,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
        ]);

        // Notify Admin
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\NewJobPosted',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $adminUser->id,
                'data' => json_encode([
                    'title' => 'New Job Posted',
                    'message' => $request->school_name . ' has posted a new job vacancy: ' . $request->title . '.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Your job requirement has been submitted successfully. Our team will review and approve it shortly.');
    }
}
