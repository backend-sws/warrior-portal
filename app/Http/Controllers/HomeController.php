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
        $employerTuitions = \App\Models\TuitionRequirement::where('status', 'Active')->whereNotNull('employer_id')->latest()->take(6)->get();
        $guestTuitions = \App\Models\TuitionRequirement::where('status', 'Pending')->whereNull('employer_id')->latest()->take(6)->get();

        return view('welcome', compact('recentJobs', 'categories', 'services', 'testimonials', 'clients', 'totalJobs', 'totalApplications', 'totalEmployers', 'employerTuitions', 'guestTuitions'));
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
        ]);

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
            'location' => $validated['location'],
            'fee' => $validated['fee'],
            'additional_notes' => 'Guest Request: ' . ($validated['description'] ?? ''),
            'status' => $validated['status'],
            'user_id' => $validated['user_id'] ?? null,
        ]);

        // Here we can send a notification to the admin, but for now we'll just return with a success message
        return redirect()->route('home')->with('tuition_success', 'Your tuition requirement has been posted successfully! Our team will contact you soon.');
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
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\NewContactLead',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $adminUser->id,
                'data' => json_encode([
                    'title' => 'New Contact Query',
                    'message' => $request->name . ' has submitted a new contact query.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

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
