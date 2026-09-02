<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\State;
use App\Models\City;
use App\Models\Qualification;
use App\Models\Subject;
use Illuminate\Http\Request;

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
            abort(404);
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
            'category_id.required' => 'Please select a job category.',
            'subject_id.required' => 'Please select a subject.',
            'qualification_id.required' => 'Please select the required qualification.',
            'state_id.required' => 'Please select a state.',
            'city_id.required' => 'Please select a city.',
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
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'salary_range' => $request->salary_range,
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
