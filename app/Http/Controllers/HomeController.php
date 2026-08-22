<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Category;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\ClientLogo;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->withCount(['jobs' => function ($query) {
            $query->where('status', 'approved');
        }])->get();
        $featuredJobs = JobPost::with(['category', 'subject', 'state', 'city'])
            ->where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();
        
        $testimonials = Testimonial::where('is_active', true)->get();
        $clients = ClientLogo::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        $recentJobs = JobPost::where('status', 'approved')->latest()->take(5)->get();
        
        $totalJobs = JobPost::where('status', 'approved')->count();
        $totalApplications = \App\Models\JobApplication::count();
        $totalEmployers = \App\Models\User::where('role', 'employer')->count();
        $employerTuitions = \App\Models\TuitionRequirement::where('status', 'Pending')->whereNotNull('employer_id')->latest()->take(6)->get();
        $guestTuitions = \App\Models\TuitionRequirement::where('status', 'Pending')->whereNull('employer_id')->latest()->take(6)->get();

        $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::where('is_active', true)->orderBy('name')->get();

        return view('welcome', compact('recentJobs', 'categories', 'services', 'testimonials', 'clients', 'totalJobs', 'totalApplications', 'totalEmployers', 'employerTuitions', 'guestTuitions', 'states', 'qualifications'));
    }

    public function storeTuition(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:255',
            'student_class' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
        ]);

        $locationWithPincode = $validated['location'];
        if (!empty($validated['pincode'])) {
            $locationWithPincode .= ' - Pincode: ' . $validated['pincode'];
        }

        $validated['fee'] = 'Not Specified';
        $validated['status'] = 'New Lead';
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        \App\Models\HomeTuitionLead::create([
            'parent_name' => $validated['guest_name'],
            'parent_mobile' => $validated['guest_phone'],
            'class' => $validated['student_class'],
            'board' => $validated['board'],
            'subjects' => $validated['subjects'],
            'location' => $locationWithPincode,
            'fee' => $validated['fee'],
            'additional_notes' => 'Guest Tuition Request: ' . ($validated['description'] ?? 'None'),
            'status' => $validated['status'],
            'tutor_preference' => 'Any',
            'user_id' => $validated['user_id'] ?? null,
        ]);

        \App\Helpers\NotificationHelper::notifyAdmin(
            'New Tuition Enquiry (Pending Action)',
            $validated['guest_name'] . ' has posted a new tuition requirement for ' . $validated['student_class'] . ' (' . $validated['subjects'] . '). Review and post in Tuition Leads.',
            route('admin.tuition-leads.index'),
            'fas fa-chalkboard-teacher'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your tuition requirement has been submitted successfully. Our team will review, match verified tutors, and contact you shortly.'
            ]);
        }

        return redirect()->to(url()->previous() . '#quick-request-form')->with('tuition_success', 'Your tuition requirement has been posted successfully! Our team will contact you soon.');
    }

    public function storeSchoolRequirement(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subject_id' => 'required|exists:subjects,id',
            'qualification_id' => 'required|exists:qualifications,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        // 1. Create JobPost with pending approval status
        $jobPost = \App\Models\JobPost::create([
            'user_id' => (auth()->check() && auth()->user()->role === 'employer') ? auth()->id() : null,
            'school_name' => $validated['school_name'],
            'contact_person' => $validated['contact_person'],
            'email' => $validated['email'] ?? ($validated['phone'] . '@school.warriorseducare.com'),
            'phone' => $validated['phone'],
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'subject_id' => $validated['subject_id'],
            'qualification_id' => $validated['qualification_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'salary_range' => $validated['salary_range'],
            'description' => $validated['description'] ?? 'Submitted via website quick requirement form',
            'status' => 'pending',
        ]);

        // 2. Also log in Contact Leads for CRM follow-up
        $catName = \App\Models\Category::find($validated['category_id'])?->name ?? 'General';
        $subjName = \App\Models\Subject::find($validated['subject_id'])?->name ?? 'Subject';
        \App\Models\ContactLead::create([
            'name' => $validated['contact_person'] . ' [' . $validated['school_name'] . ']',
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'],
            'message' => "🏫 School Job Requirement (Pending Approval - Job #{$jobPost->id}):\n• Title: {$validated['title']}\n• Category: {$catName}\n• Subject: {$subjName}\n• Salary: " . ($validated['salary_range'] ?? 'Negotiable') . "\n• Extra Notes: " . ($validated['description'] ?? 'None'),
            'status' => 'new',
        ]);

        // 3. Notify Admin to review and approve
        \App\Helpers\NotificationHelper::notifyAdmin(
            'New Job Requirement Awaiting Approval',
            $validated['school_name'] . ' submitted a new job: "' . $validated['title'] . '". Review and approve in Job Management.',
            route('admin.jobs.index', ['status' => 'pending']),
            'fas fa-briefcase'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your teacher requirement has been submitted for approval. Our administration team will review and approve it shortly.'
            ]);
        }

        return redirect()->to(url()->previous() . '#quick-request-form')->with('school_success', 'Your teacher requirement has been submitted for approval! Our team will review and approve it shortly.');
    }

    public function categoryJobs($id)
    {
        $category = Category::findOrFail($id);
        $jobs = JobPost::with([
                'category',
                'subject',
                'state',
                'city',
                'qualification'
            ])
            ->where('category_id', $id)
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        $activeSubjectIds = $jobs->pluck('subject_id')->filter()->unique()->toArray();
        $subjects = Subject::whereIn('id', $activeSubjectIds)->where('is_active', true)->get();
        return view('category-jobs', compact('category', 'subjects', 'jobs'));
    }

    public function serviceDetails($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('service-details', compact('service'));
    }


    public function jobs(\Illuminate\Http\Request $request)
    {
        $query = JobPost::with(['category', 'subject', 'state', 'city', 'qualification'])
            ->where('status', 'approved');

        if ($request->filled('state')) {
            $query->where('state_id', $request->state);
        }

        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }

        if ($request->filled('class')) {
            $query->where('category_id', $request->class);
        }

        if ($request->filled('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(12);

        $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
        $subjects = \App\Models\Subject::where('is_active', true)->orderBy('name')->get();
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
            
        return view('jobs', compact('jobs', 'states', 'subjects', 'categories'));
    }

    public function tuitions(\Illuminate\Http\Request $request)
    {
        $tuitions = \App\Models\HomeTuitionLead::where('status', 'Approved')
            ->latest()
            ->paginate(12);

        return view('tuitions', compact('tuitions'));
    }

    public function storeContact(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string'
        ]);

        \App\Models\ContactLead::create($request->only(['name', 'email', 'phone', 'message']));

        // Notify Admin of new lead
        \App\Helpers\NotificationHelper::notifyAdmin(
            'New Contact Query',
            $request->name . ' has submitted a new contact query.',
            route('admin.leads.index'),
            'fas fa-envelope'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Thank you for your message. We will get back to you shortly.'
            ]);
        }

        return back()->with('success', 'Thank you for your message. We will get back to you shortly.');
    }
   

        public function services()
        {
            $services = Service::where('is_active', true)->latest()->get();
            return view('services', compact('services'));
        }

        public function getSubjects($categoryId)
    {
        $category = \App\Models\Category::findOrFail($categoryId);
        return response()->json($category->subjects()->where('is_active', true)->orderBy('name')->get());
    }

    public function getSpecializations($subjectId)
    {
        $subject = \App\Models\Subject::findOrFail($subjectId);
        return response()->json($subject->specializations()->where('is_active', true)->orderBy('name')->get());
    }
}
