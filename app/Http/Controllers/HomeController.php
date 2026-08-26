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
        $recentJobs = JobPost::with(['category', 'subject', 'state', 'city', 'qualification'])
            ->where('status', 'approved')
            ->latest()
            ->take(6)
            ->get();
        
        $totalJobs = JobPost::where('status', 'approved')->count();
        $totalApplications = \App\Models\JobApplication::count();
        $totalEmployers = \App\Models\User::where('role', 'employer')->count();
        $employerTuitions = \App\Models\HomeTuitionLead::where('is_featured', true)
            ->where('status', 'Approved')
            ->latest()
            ->take(8)
            ->get();

        if ($employerTuitions->isEmpty()) {
            $employerTuitions = \App\Models\HomeTuitionLead::where('status', 'Approved')
                ->latest()
                ->take(8)
                ->get();
        }

        $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::where('is_active', true)->orderBy('name')->get();

        return view('welcome', compact('recentJobs', 'categories', 'services', 'testimonials', 'clients', 'totalJobs', 'totalApplications', 'totalEmployers', 'employerTuitions', 'states', 'qualifications'));
    }

    public function storeTuition(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'min:3', 'max:80', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
            'guest_phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'student_class' => ['required', 'string', 'min:1', 'max:50'],
            'board' => ['required', 'string', 'max:50'],
            'subjects' => ['required', 'string', 'min:2', 'max:200'],
            'location' => ['required', 'string', 'min:3', 'max:255'],
            'pincode' => ['nullable', 'regex:/^\d{6}$/'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'guest_name.required' => 'Your Name is required.',
            'guest_name.min' => 'Your Name must be at least 3 characters.',
            'guest_name.regex' => 'Your Name must only contain letters and spaces (numbers or special symbols are not allowed).',
            'guest_phone.required' => 'Phone Number is required.',
            'guest_phone.regex' => 'Phone Number must be a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9.',
            'student_class.required' => "Please enter the student's class/grade (e.g. Class 10, Class 5).",
            'board.required' => 'Please select an education board (e.g. CBSE, ICSE, State Board).',
            'subjects.required' => 'Please enter the subjects needed for tutoring.',
            'location.required' => 'Please enter your complete area address or locality.',
            'pincode.regex' => 'Pincode must be exactly a 6-digit number (e.g. 800001).',
        ]);

        \App\Models\HomeTuitionLead::create([
            'parent_name' => $validated['guest_name'],
            'parent_mobile' => $validated['guest_phone'],
            'class' => $validated['student_class'],
            'board' => $validated['board'],
            'subjects' => $validated['subjects'],
            'location' => $validated['location'],
            'pincode' => $validated['pincode'] ?? null,
            'status' => 'New Lead',
            'user_id' => auth()->check() ? auth()->id() : null,
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
            'school_name' => ['required', 'string', 'min:3', 'max:200'],
            'contact_person' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'email' => ['nullable', 'email:rfc,dns', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'category_id' => ['required', 'exists:categories,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'qualification_id' => ['required', 'exists:qualifications,id'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ], [
            'school_name.required' => 'Please enter the school / institution name.',
            'school_name.min' => 'Institution name must be at least 3 characters.',
            'contact_person.required' => 'Please enter the contact person name.',
            'contact_person.min' => 'Contact person name must be at least 3 characters.',
            'contact_person.regex' => 'Contact person name must only contain letters and spaces (no numbers).',
            'phone.required' => 'Please enter a 10-digit mobile number.',
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'email.email' => 'Please enter a valid official email address.',
            'title.required' => 'Please enter the vacancy / job title.',
            'category_id.required' => 'Please select a job category.',
            'subject_id.required' => 'Please select a subject.',
            'qualification_id.required' => 'Please select the required qualification.',
            'state_id.required' => 'Please select a state.',
            'city_id.required' => 'Please select a city.',
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

        // 2. Notify Admin to review and approve in Job Approvals
        \App\Helpers\NotificationHelper::notifyAdmin(
            'New Job Requirement Awaiting Approval',
            $validated['school_name'] . ' submitted a new job: "' . $validated['title'] . '". Review and approve in Job Approvals.',
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
        $allServices = Service::where('is_active', true)->where('id', '!=', $service->id)->get();
        return view('service-details', compact('service', 'allServices'));
    }


    public function jobs(\Illuminate\Http\Request $request)
    {
        $query = JobPost::with(['category', 'subject', 'state', 'city', 'qualification'])
            ->where('status', 'approved');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('job_id', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('school_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }
            });
        }

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

        $jobs = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
        $subjects = \App\Models\Subject::where('is_active', true)->orderBy('name')->get();
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
            
        return view('jobs', compact('jobs', 'states', 'subjects', 'categories'));
    }

    public function tuitions(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\HomeTuitionLead::where('status', 'Approved');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('tuition_id', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%")
                  ->orWhere('subjects', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('pincode', 'like', "%{$search}%");
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }
            });
        }

        $tuitions = $query->latest()
            ->paginate(12)
            ->withQueryString();

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
