<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\PaymentTransaction;
use App\Models\CrmFollowUp;
use App\Models\ServiceChargeInvoice;
use App\Models\CandidateRating;
use App\Models\HomeTuitionLead;
use App\Models\TuitionApplication;
use App\Models\JobPost;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CrmController extends Controller
{
    public function create()
    {
        $categories = \App\Models\Category::all();
        $subjects = \App\Models\Subject::all();
        $qualifications = \App\Models\Qualification::all();
        $states = \App\Models\State::where('is_active', true)->get();
        $cities = \App\Models\City::where('is_active', true)->get();

        return view('admin.crm.create', compact('categories', 'subjects', 'qualifications', 'states', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                     => 'required|string|max:255',
            'email'                    => 'required|email|unique:users,email',
            'phone'                    => 'required|string|max:20|unique:users,phone',
            'password'                 => 'required|string|min:6',
            'gender'                   => 'required|in:Male,Female,Other',
            'date_of_birth'            => 'required|date',
            'address'                  => 'required|string',
            'highest_qualification_id' => 'required|exists:qualifications,id',
            'subject_id'               => 'required|exists:subjects,id',
            'category_id'              => 'nullable|exists:categories,id',
            'experience_years'         => 'nullable|integer|min:0',
            'preferred_state_id'       => 'required|exists:states,id',
            'preferred_city_id'        => 'required|exists:cities,id',
            'current_salary'           => 'nullable|string',
            'expected_salary'          => 'nullable|string',
            'english_fluency'          => 'nullable|string',
            'residential_preference'   => 'nullable|string',
            'availability_to_join'     => 'nullable|string',
            'current_school'           => 'nullable|string',
            'resume'                   => 'nullable|mimes:pdf,doc,docx|max:5120',
            'profile_photo'            => 'nullable|image|max:5120',
            'live_photo'               => 'nullable|image|max:5120',
            'salary_slip'              => 'nullable|mimes:pdf,jpg,png,jpeg|max:5120',
            'offer_letter'             => 'nullable|mimes:pdf,jpg,png,jpeg|max:5120',
            'agreement_pdf'            => 'nullable|mimes:pdf|max:5120',
            'payment_amount'           => 'nullable|numeric|min:0',
            'payment_method'           => 'nullable|string',
            'payment_notes'            => 'nullable|string',
        ]);

        try {
            // 1. Create User
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'role'              => 'candidate',
                'password'          => Hash::make($request->password),
                'email_verified_at' => now(),
            ]);

            // 2. Handle File Uploads
            $resumePath = $request->hasFile('resume') ? $request->file('resume')->store('resumes', 'public') : null;
            $profilePhotoPath = $request->hasFile('profile_photo') ? $request->file('profile_photo')->store('profile_photos', 'public') : null;
            $livePhotoPath = $request->hasFile('live_photo') ? $request->file('live_photo')->store('live_photos', 'public') : null;
            $salarySlipPath = $request->hasFile('salary_slip') ? $request->file('salary_slip')->store('salary_slips', 'public') : null;
            $offerLetterPath = $request->hasFile('offer_letter') ? $request->file('offer_letter')->store('offer_letters', 'public') : null;
            $agreementPdfPath = $request->hasFile('agreement_pdf') ? $request->file('agreement_pdf')->store('agreements', 'public') : null;

            $isJobAgreementSigned = ($agreementPdfPath || $request->boolean('is_agreement_signed'));
            $isTuitionAgreementSigned = $request->boolean('is_tuition_agreement_signed');

            $paymentId = $request->payment_method ? ($request->payment_method . '-ADMIN-' . strtoupper(uniqid())) : null;

            // 3. Create Candidate Profile
            $profile = CandidateProfile::create([
                'user_id'                    => $user->id,
                'gender'                     => $request->gender,
                'date_of_birth'              => $request->date_of_birth,
                'address'                    => $request->address,
                'category_id'                => $request->category_id,
                'subject_id'                 => $request->subject_id,
                'highest_qualification_id'   => $request->highest_qualification_id,
                'experience_years'           => $request->experience_years ?? 0,
                'current_salary'             => $request->current_salary,
                'expected_salary'            => $request->expected_salary,
                'preferred_state_id'         => $request->preferred_state_id,
                'preferred_city_id'          => $request->preferred_city_id,
                'english_fluency'            => $request->english_fluency,
                'residential_preference'     => $request->residential_preference,
                'availability_to_join'       => $request->availability_to_join,
                'current_school'             => $request->current_school,
                
                'resume_path'                => $resumePath,
                'profile_photo_path'         => $profilePhotoPath,
                'live_photo_path'            => $livePhotoPath,
                'salary_slip_path'           => $salarySlipPath,
                'offer_letter_path'          => $offerLetterPath,
                'agreement_pdf_path'         => $agreementPdfPath,

                'is_profile_complete'        => true,
                'is_fee_paid'                => true,
                'paid_amount'                => $request->payment_amount ?? 0,
                'plan_type'                  => 'standard',
                'total_allowed_applications' => 9999, // Unlimited applications
                'plan_started_at'            => now(),
                'payment_id'                 => $paymentId,
                'registration_completed_at'  => now(),
                
                'is_terms_agreed'            => true,
                'is_agreement_signed'        => $isJobAgreementSigned,
                'agreement_status'           => $isJobAgreementSigned ? 'signed' : 'pending_signature',
                'signature_date_time'        => $isJobAgreementSigned ? now() : null,
                'is_tuition_agreement_signed'=> $isTuitionAgreementSigned,
                'tuition_agreement_signed_at'=> $isTuitionAgreementSigned ? now() : null,
            ]);

            // 4. Create Payment Transaction if fee was collected
            if ($request->filled('payment_amount') && $request->payment_amount > 0 && $request->payment_method) {
                PaymentTransaction::create([
                    'candidate_id'     => $user->id,
                    'transaction_id'   => $paymentId,
                    'amount'           => $request->payment_amount,
                    'type'             => 'registration_fee',
                    'status'           => 'success',
                    'gateway_response' => [
                        'note'           => 'Manually collected by Admin', 
                        'admin_notes'    => $request->payment_notes,
                        'payment_method' => $request->payment_method
                    ],
                ]);
            }

            // Welcome DB notification to candidate
            NotificationHelper::notifyUser(
                $user->id,
                'Welcome to Warriors Educare! 🎉',
                'Your teacher profile has been registered by our team. Log in to your portal to explore school jobs and home tuitions.',
                null,
                'fas fa-user-plus'
            );

            // Welcome email with login credentials
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(
                    new \App\Mail\WelcomeCandidateMail($user, $request->password)
                );
            } catch (\Throwable $emailEx) {
                \Log::error('WelcomeCandidate Email Error: ' . $emailEx->getMessage());
            }

            // Admin confirmation notify
            NotificationHelper::notifyAdmin(
                'New Candidate Onboarded',
                $user->name . ' has been onboarded successfully by admin.',
                null,
                'fas fa-user-plus'
            );

            return redirect()->route('admin.crm.show', $user->id)->with('success', 'Candidate onboarded successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Manual Onboard Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to onboard candidate: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::where('role', 'candidate')->findOrFail($id);
        $profile = $user->profile;

        $categories = \App\Models\Category::all();
        $subjects = \App\Models\Subject::all();
        $qualifications = \App\Models\Qualification::all();
        $states = \App\Models\State::where('is_active', true)->get();
        $cities = \App\Models\City::where('is_active', true)->get();

        return view('admin.crm.edit', compact('user', 'profile', 'categories', 'subjects', 'qualifications', 'states', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'candidate')->findOrFail($id);
        
        $request->validate([
            'name'                     => 'required|string|max:255',
            'email'                    => 'required|email|unique:users,email,' . $id,
            'phone'                    => 'required|string|max:20|unique:users,phone,' . $id,
            'gender'                   => 'required|in:Male,Female,Other',
            'date_of_birth'            => 'required|date',
            'address'                  => 'required|string',
            'highest_qualification_id' => 'required|exists:qualifications,id',
            'subject_id'               => 'required|exists:subjects,id',
            'category_id'              => 'nullable|exists:categories,id',
            'experience_years'         => 'nullable|integer|min:0',
            'preferred_state_id'       => 'required|exists:states,id',
            'preferred_city_id'        => 'required|exists:cities,id',
            'current_salary'           => 'nullable|string',
            'expected_salary'          => 'nullable|string',
            'english_fluency'          => 'nullable|string',
            'residential_preference'   => 'nullable|string',
            'availability_to_join'     => 'nullable|string',
            'current_school'           => 'nullable|string',
            'resume'                   => 'nullable|mimes:pdf,doc,docx|max:5120',
            'profile_photo'            => 'nullable|image|max:5120',
            'live_photo'               => 'nullable|image|max:5120',
            'salary_slip'              => 'nullable|mimes:pdf,jpg,png,jpeg|max:5120',
            'offer_letter'             => 'nullable|mimes:pdf,jpg,png,jpeg|max:5120',
            'agreement_pdf'            => 'nullable|mimes:pdf|max:5120',
        ]);

        try {
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

            $updates = [
                'gender'                   => $request->gender,
                'date_of_birth'            => $request->date_of_birth,
                'address'                  => $request->address,
                'category_id'              => $request->category_id,
                'subject_id'               => $request->subject_id,
                'highest_qualification_id' => $request->highest_qualification_id,
                'experience_years'         => $request->experience_years ?? 0,
                'current_salary'           => $request->current_salary,
                'expected_salary'          => $request->expected_salary,
                'preferred_state_id'       => $request->preferred_state_id,
                'preferred_city_id'        => $request->preferred_city_id,
                'english_fluency'          => $request->english_fluency,
                'residential_preference'   => $request->residential_preference,
                'availability_to_join'     => $request->availability_to_join,
                'current_school'           => $request->current_school,
                'total_allowed_applications' => 9999,
            ];

            if ($request->hasFile('resume')) {
                $updates['resume_path'] = $request->file('resume')->store('resumes', 'public');
            }
            if ($request->hasFile('profile_photo')) {
                $updates['profile_photo_path'] = $request->file('profile_photo')->store('profile_photos', 'public');
            }
            if ($request->hasFile('live_photo')) {
                $updates['live_photo_path'] = $request->file('live_photo')->store('live_photos', 'public');
            }
            if ($request->hasFile('salary_slip')) {
                $updates['salary_slip_path'] = $request->file('salary_slip')->store('salary_slips', 'public');
            }
            if ($request->hasFile('offer_letter')) {
                $updates['offer_letter_path'] = $request->file('offer_letter')->store('offer_letters', 'public');
            }
            if ($request->hasFile('agreement_pdf')) {
                $updates['agreement_pdf_path'] = $request->file('agreement_pdf')->store('agreements', 'public');
                $updates['is_agreement_signed'] = true;
                $updates['agreement_status'] = 'signed';
            }

            if ($user->profile) {
                $user->profile->update($updates);
            } else {
                $updates['user_id'] = $user->id;
                CandidateProfile::create($updates);
            }

            NotificationHelper::notifyUser(
                $user->id,
                'Profile Updated',
                'Your candidate profile has been updated by the Warriors Educare team.',
                null,
                'fas fa-user-edit'
            );

            return redirect()->route('admin.crm.show', $user->id)->with('success', 'Candidate profile updated successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Profile Update Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to update candidate profile: ' . $e->getMessage()]);
        }
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'candidate')
            ->with([
                'profile.highestQualification',
                'profile.subject',
                'profile.category',
                'profile.preferredState',
                'profile.preferredCity',
                'applications.jobPost',
            ]);

        // Search text
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Advanced Filters
        if ($subjectId = $request->input('subject_id')) {
            $query->whereHas('profile', function($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            });
        }

        if ($experience = $request->input('experience')) {
            $query->whereHas('profile', function($q) use ($experience) {
                $q->where('experience_years', '>=', $experience);
            });
        }

        if ($qualificationId = $request->input('qualification_id')) {
            $query->whereHas('profile', function($q) use ($qualificationId) {
                $q->where('highest_qualification_id', $qualificationId);
            });
        }

        if ($stateId = $request->input('state_id')) {
            $query->whereHas('profile', function($q) use ($stateId) {
                $q->where('preferred_state_id', $stateId);
            });
        }

        if ($cityId = $request->input('city_id')) {
            $query->whereHas('profile', function($q) use ($cityId) {
                $q->where('preferred_city_id', $cityId);
            });
        }

        if ($gender = $request->input('gender')) {
            $query->whereHas('profile', function($q) use ($gender) {
                $q->where('gender', $gender);
            });
        }

        // Status filter from analytics cards
        if ($crmStatus = $request->input('crm_status')) {
            if ($crmStatus === 'active_paid') {
                $query->whereHas('profile', fn($q) => $q->where('is_fee_paid', true));
            } elseif ($crmStatus === 'signed') {
                $query->whereHas('profile', fn($q) => $q->where('is_fee_paid', false)->where('is_agreement_signed', true));
            } elseif ($crmStatus === 'incomplete') {
                $query->where(function($subQ) {
                    $subQ->whereDoesntHave('profile')
                         ->orWhereHas('profile', fn($q) => $q->where('is_fee_paid', false)->where('is_agreement_signed', false));
                });
            }
        }

        // Sorting
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('order', 'desc');
        
        $allowedFields = ['id', 'name', 'email', 'created_at'];
        if (in_array($sortField, $allowedFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $candidates = $query->with('rating')->paginate(15)->withQueryString();

        // Accurate Analytics based on search/base
        $baseQuery = User::where('role', 'candidate');
        if ($search) {
            $baseQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $stats = [
            'total'       => (clone $baseQuery)->count(),
            'active_paid' => (clone $baseQuery)->whereHas('profile', fn($q) => $q->where('is_fee_paid', true))->count(),
            'signed'      => (clone $baseQuery)->whereHas('profile', fn($q) => $q->where('is_fee_paid', false)->where('is_agreement_signed', true))->count(),
        ];
        $stats['incomplete'] = max(0, $stats['total'] - $stats['active_paid'] - $stats['signed']);

        // Pass master data for filters
        $subjects = \App\Models\Subject::all();
        $qualifications = \App\Models\Qualification::all();
        $states = \App\Models\State::all();
        $cities = \App\Models\City::all();

        return view('admin.crm.index', compact('candidates', 'stats', 'sortField', 'sortDirection', 'subjects', 'qualifications', 'states', 'cities'));
    }

    public function show($id)
    {
        $candidate = User::where('role', 'candidate')->with([
            'profile.highestQualification',
            'profile.category',
            'profile.subject',
            'profile.preferredState',
            'profile.preferredCity',
            'applications.jobPost.category',
            'applications.jobPost.city',
            'rating'
        ])->findOrFail($id);

        $tuitionApplications = TuitionApplication::with('tuitionLead')
            ->where('candidate_id', $id)
            ->latest()
            ->get();

        $availableJobs = JobPost::where('status', 'approved')->orderBy('created_at', 'desc')->get();
        $availableTuitionLeads = HomeTuitionLead::whereIn('status', ['New Lead', 'Approved'])->orderBy('created_at', 'desc')->get();

        $followUps = CrmFollowUp::where('candidate_id', $id)->with('admin')->orderBy('created_at', 'desc')->get();
        $invoices = ServiceChargeInvoice::where('candidate_id', $id)->with(['jobApplication.jobPost', 'tuitionLead'])->orderBy('created_at', 'desc')->get();
        $rating = CandidateRating::where('candidate_id', $id)->first();
        $payments = PaymentTransaction::where('candidate_id', $id)->latest()->get();

        // Calculate Profile Readiness
        $profile = $candidate->profile;
        $isTuitionReady = ($profile && $profile->date_of_birth && $profile->gender && $profile->address && $profile->preferred_state_id && $profile->preferred_city_id && $profile->highest_qualification_id && $profile->subject_id);
        $isJobReady = ($isTuitionReady && $profile->category_id && $profile->resume_path);

        $history = collect();

        // 1. Profile Creation
        $history->push([
            'date'        => $candidate->created_at,
            'type'        => 'profile_created',
            'title'       => 'Candidate Registered',
            'description' => 'Account created on Warriors Educare portal.',
            'icon'        => 'fas fa-user-plus',
            'color'       => 'bg-blue-500'
        ]);

        // 2. Payments
        foreach ($payments as $payment) {
            $history->push([
                'date'        => $payment->created_at,
                'type'        => 'payment',
                'title'       => 'Payment Recorded',
                'description' => 'Payment of ₹' . number_format($payment->amount, 2) . ' received (' . $payment->type . ').',
                'icon'        => 'fas fa-rupee-sign',
                'color'       => 'bg-emerald-500'
            ]);
        }

        // 3. Job Applications
        foreach ($candidate->applications as $app) {
            $history->push([
                'date'        => $app->created_at,
                'type'        => 'job_applied',
                'title'       => 'Applied for School Job',
                'description' => 'Applied for ' . ($app->jobPost->title ?? 'Teacher') . ' at ' . ($app->jobPost->school_name ?? 'School') . ' (Status: ' . ucfirst($app->status) . ').',
                'icon'        => 'fas fa-briefcase',
                'color'       => 'bg-indigo-500'
            ]);
        }

        // 4. Tuition Applications
        foreach ($tuitionApplications as $tApp) {
            $history->push([
                'date'        => $tApp->created_at,
                'type'        => 'tuition_applied',
                'title'       => 'Applied for Home Tuition',
                'description' => 'Applied for Class ' . ($tApp->tuitionLead->class ?? 'N/A') . ' (' . ($tApp->tuitionLead->subjects ?? '') . ') in ' . ($tApp->tuitionLead->location ?? '') . ' (Status: ' . $tApp->status . ').',
                'icon'        => 'fas fa-chalkboard-teacher',
                'color'       => 'bg-purple-500'
            ]);
        }

        // Sort timeline
        $history = $history->sortByDesc('date');

        return view('admin.crm.show', compact(
            'candidate',
            'profile',
            'tuitionApplications',
            'availableJobs',
            'availableTuitionLeads',
            'followUps',
            'invoices',
            'rating',
            'payments',
            'history',
            'isTuitionReady',
            'isJobReady'
        ));
    }

    public function assignJob(Request $request, $id)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id'
        ]);

        $candidate = User::findOrFail($id);
        
        $existing = \App\Models\JobApplication::where('candidate_id', $id)
            ->where('job_post_id', $request->job_post_id)
            ->first();

        if ($existing) {
            return back()->with('info', 'Candidate is already applied/assigned to this job.');
        }

        $app = \App\Models\JobApplication::create([
            'candidate_id' => $id,
            'job_post_id'  => $request->job_post_id,
            'status'       => 'applied',
            'match_score'  => 85,
        ]);

        NotificationHelper::notifyUser(
            $candidate->id,
            'New Job Assigned by Admin! 💼',
            'You have been mapped to a new teaching opportunity. Check your application tracker for details.',
            route('candidate.applications.index', ['tab' => 'jobs']),
            'fas fa-briefcase'
        );

        return back()->with('success', 'Job opportunity assigned to candidate successfully.');
    }

    public function assignTuition(Request $request, $candidateId)
    {
        $request->validate([
            'home_tuition_lead_id'   => 'required|exists:home_tuition_leads,id',
            'status'                 => 'required|in:Applied,Shortlisted,Assigned',
            'remarks'                => 'nullable|string|max:500',
            'demo_date'              => 'nullable|date',
            'create_service_charge'  => 'nullable|boolean',
            'service_charge_amount'  => 'nullable|numeric|min:0',
        ]);

        $candidate = User::with('profile')->findOrFail($candidateId);
        $lead = HomeTuitionLead::findOrFail($request->home_tuition_lead_id);

        $tuitionApp = TuitionApplication::updateOrCreate(
            ['candidate_id' => $candidateId, 'home_tuition_lead_id' => $lead->id],
            [
                'status'    => $request->status,
                'remarks'   => $request->remarks,
                'demo_date' => $request->demo_date,
            ]
        );

        if ($request->status === 'Assigned') {
            $lead->update([
                'teacher_name'    => $candidate->name,
                'teacher_contact' => $candidate->phone,
                'status'          => 'Confirmed',
            ]);

            if ($request->boolean('create_service_charge') && $request->filled('service_charge_amount') && $request->service_charge_amount > 0) {
                $amount = (float) $request->service_charge_amount;
                $dueDate = now()->addDays(7)->toDateString();
                $desc = "Service Charge for Home Tuition (Class {$lead->class} - {$lead->subjects})";

                $invoice = ServiceChargeInvoice::create([
                    'candidate_id'           => $candidate->id,
                    'job_application_id'     => null,
                    'home_tuition_lead_id'   => $lead->id,
                    'tuition_application_id' => $tuitionApp->id,
                    'amount'                 => $amount,
                    'due_date'               => $dueDate,
                    'status'                 => 'pending',
                    'description'            => $desc,
                ]);

                if ($candidate->profile) {
                    $candidate->profile->increment('pending_amount', $amount);
                }

                NotificationHelper::notifyUser(
                    $candidate->id,
                    'Tuition Service Charge Generated 🧾',
                    "An invoice for ₹" . number_format($amount, 2) . " has been issued for your tuition placement.",
                    route('candidate.serviceCharge.show'),
                    'fas fa-file-invoice-dollar'
                );
            }

            NotificationHelper::notifyUser(
                $candidate->id,
                'Tuition Assigned! 🎉',
                "You have been assigned to Class {$lead->class} ({$lead->subjects}) in {$lead->location}. Parent: {$lead->parent_name} ({$lead->parent_mobile}).",
                route('candidate.applications.index', ['tab' => 'tuitions']),
                'fas fa-chalkboard-teacher'
            );
        }

        return back()->with('success', "Home tuition mapped to {$candidate->name} successfully.");
    }

    public function storeFollowUp(Request $request, $id)
    {
        $request->validate([
            'notes'          => 'required|string',
            'follow_up_date' => 'nullable|date',
            'status'         => 'required|in:pending,completed,cancelled'
        ]);

        CrmFollowUp::create([
            'candidate_id'   => $id,
            'admin_id'       => Auth::id(),
            'notes'          => $request->notes,
            'follow_up_date' => $request->follow_up_date,
            'status'         => $request->status
        ]);

        return back()->with('success', 'Follow-up note logged successfully.');
    }

    public function storeInvoice(Request $request, $id)
    {
        $request->validate([
            'job_application_id'   => 'nullable|exists:job_applications,id',
            'home_tuition_lead_id' => 'nullable|exists:home_tuition_leads,id',
            'amount'               => 'required|numeric|min:0',
            'due_date'             => 'required|date',
            'description'          => 'nullable|string|max:255',
        ]);

        $candidate = User::with('profile')->findOrFail($id);

        $invoice = ServiceChargeInvoice::create([
            'candidate_id'         => $id,
            'job_application_id'   => $request->job_application_id,
            'home_tuition_lead_id' => $request->home_tuition_lead_id,
            'amount'               => $request->amount,
            'due_date'             => $request->due_date,
            'status'               => 'pending',
            'description'          => $request->description ?: 'Placement Service Charge',
        ]);

        if ($candidate->profile) {
            $candidate->profile->increment('pending_amount', $request->amount);
        }

        NotificationHelper::notifyUser(
            $id,
            'New Service Charge Invoice 🧾',
            'An invoice of ₹' . number_format($request->amount, 2) . ' has been generated for your placement. Due Date: ' . Carbon::parse($request->due_date)->format('d M Y') . '.',
            route('candidate.serviceCharge.show'),
            'fas fa-file-invoice-dollar'
        );

        return back()->with('success', 'Invoice created successfully.');
    }

    public function toggleVerification(Request $request, $id)
    {
        $user = User::with('profile')->findOrFail($id);
        if ($user->profile) {
            $user->profile->is_verified = !$user->profile->is_verified;
            $user->profile->save();
            
            $msg = $user->profile->is_verified ? 'Candidate profile verified successfully.' : 'Verification revoked.';
            return back()->with('success', $msg);
        }
        return back()->with('error', 'Profile not found.');
    }

    public function magicLogin($id)
    {
        $user = User::findOrFail($id);
        Auth::login($user);
        return redirect()->route('candidate.dashboard');
    }

    public function uploadAgreement(Request $request, $id)
    {
        $request->validate([
            'agreement_pdf' => 'required|mimes:pdf|max:5120',
        ]);

        $user = User::with('profile')->findOrFail($id);
        if ($user->profile) {
            $path = $request->file('agreement_pdf')->store('agreements', 'public');
            $user->profile->update([
                'agreement_pdf_path'  => $path,
                'is_agreement_signed' => true,
                'agreement_status'    => 'signed',
                'signature_date_time' => now(),
            ]);

            return back()->with('success', 'Signed agreement PDF uploaded successfully.');
        }

        return back()->with('error', 'Candidate profile not found.');
    }

    public function updateAgreementStatus(Request $request, $id)
    {
        $request->validate([
            'agreement_status'            => 'nullable|in:not_required,pending_signature,signed',
            'is_tuition_agreement_signed' => 'nullable|boolean',
        ]);

        $user = User::with('profile')->findOrFail($id);
        if ($user->profile) {
            $updates = [];
            
            if ($request->filled('agreement_status')) {
                $status = $request->agreement_status;
                $updates['agreement_status'] = $status;
                $updates['is_agreement_signed'] = ($status === 'signed');
                if ($status === 'signed') {
                    $updates['signature_date_time'] = now();
                }

                if ($status === 'pending_signature') {
                    NotificationHelper::notifyUser(
                        $user->id,
                        'Action Required: Sign Candidate Agreement ✍️',
                        'Warriors Educare admin has activated your Placement Agreement. Please visit your dashboard to review and sign it.',
                        route('candidate.agreement.show'),
                        'fas fa-file-signature'
                    );
                } elseif ($status === 'signed') {
                    NotificationHelper::notifyUser(
                        $user->id,
                        'Agreement Approved & Verified! ✅',
                        'Your Teacher Placement Service Agreement is verified. You can now apply for all eligible school jobs.',
                        route('candidate.dashboard'),
                        'fas fa-check-circle'
                    );
                }
            }

            if ($request->has('is_tuition_agreement_signed')) {
                $isTuitionSigned = $request->boolean('is_tuition_agreement_signed');
                $updates['is_tuition_agreement_signed'] = $isTuitionSigned;
                $updates['tuition_agreement_signed_at'] = $isTuitionSigned ? now() : null;

                if ($isTuitionSigned) {
                    NotificationHelper::notifyUser(
                        $user->id,
                        'Tuition Agreement Approved! 🏠',
                        'Your Home Tuition Agreement is verified. You can now apply for home tuition assignments.',
                        route('tuitions.index'),
                        'fas fa-chalkboard-teacher'
                    );
                }
            }

            $user->profile->update($updates);

            return back()->with('success', 'Agreement settings updated successfully.');
        }

        return back()->with('error', 'Candidate profile not found.');
    }

    public function rateCandidate(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);

        CandidateRating::updateOrCreate(
            ['candidate_id' => $id],
            [
                'admin_id' => Auth::id(),
                'rating'   => $request->rating,
                'feedback' => $request->feedback,
            ]
        );

        return back()->with('success', 'Candidate rating saved successfully.');
    }
}
