<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RegistrationOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class CandidateAuthController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        return redirect()->route('login');
    }

    /**
     * Handle initial registration request & dispatch OTP to verify email authenticity.
     */
    public function register(Request $request)
    {
        // Prevent registering an administrator account as candidate
        $existingAdmin = User::where(function($query) use ($request) {
            if ($request->filled('email')) $query->orWhere('email', $request->email);
            if ($request->filled('phone')) $query->orWhere('phone', $request->phone);
        })->where('role', 'admin')->first();

        if ($existingAdmin) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email or phone is reserved for portal administration. Please log in using the Admin login page.',
                    'errors' => ['email' => ['This account is reserved for administration.']]
                ], 422);
            }
            return back()->withErrors(['email' => 'This email or phone is reserved for portal administration.'])->withInput();
        }

        $isFullRegistration = $request->filled('candidate_category') || $request->filled('gender');

        if ($isFullRegistration) {
            $rules = [
                'candidate_category'        => ['required', 'in:home_tutor,school_job,both'],
                'name'                      => ['required', 'string', 'min:3', 'max:80', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
                'email'                     => ['required', 'string', 'email:rfc', 'max:255'],
                'phone'                     => ['required', 'regex:/^[6-9]\d{9}$/'],
                'whatsapp_no'               => ['nullable', 'regex:/^[6-9]\d{9}$/'],
                'password'                  => ['required', 'string', 'min:8', 'confirmed'],
                'gender'                    => ['required', 'in:Male,Female,Other'],
                'date_of_birth'             => ['required', 'date', 'before:today'],
                'highest_qualification'     => ['required', 'string', 'max:100'],
                'experience_range'          => ['required', 'string', 'max:50'],
            ];

            $category = $request->candidate_category;

            // Common Subject and Class validation for all categories (Home Tutor, School Job, Both)
            $rules['tuition_subjects']    = ['required', 'array', 'min:1'];
            $rules['classes_interested']  = ['required', 'array', 'min:1'];

            // Home Tutor Fields validation
            if (in_array($category, ['home_tutor', 'both'])) {
                $rules['teaching_mode']       = ['required', 'in:Offline,Online,Both'];
                $rules['preferred_areas']     = ['required', 'string', 'max:1000'];
                $rules['available_time_slot'] = ['nullable', 'string', 'max:150'];
                $rules['tutor_resume']        = ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'];
            }

            // School Job Fields validation
            if (in_array($category, ['school_job', 'both'])) {
                $rules['b_ed_status']            = ['required', 'string', 'max:100'];
                $rules['d_el_ed_status']          = ['required', 'string', 'max:100'];
                $rules['position_applying_for']  = ['required', 'string', 'max:100'];
                $rules['current_salary']         = ['nullable', 'numeric', 'min:0'];
                $rules['expected_salary']        = ['nullable', 'numeric', 'min:0'];
                $rules['last_school_name']       = ['nullable', 'string', 'max:200'];
                $rules['last_designation']       = ['nullable', 'string', 'max:100'];
                $rules['last_drawn_salary']      = ['nullable', 'numeric', 'min:0'];
                $rules['preferred_locations']    = ['nullable'];
                $rules['preferred_locations_manual'] = ['nullable', 'string', 'max:500'];
                $rules['resume']                 = [$category === 'school_job' ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'];
                $rules['salary_slip']            = ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'];
            }
        } else {
            $rules = [
                'name'     => ['required', 'string', 'min:3', 'max:80', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
                'email'    => ['required', 'string', 'email:rfc', 'max:255'],
                'phone'    => ['required', 'regex:/^[6-9]\d{9}$/'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
            $category = 'both';
        }

        $messages = [
            'name.required'                  => 'Please enter your full name.',
            'name.min'                       => 'Name must be at least 3 characters long.',
            'name.regex'                     => 'Name should only contain letters and spaces.',
            'email.required'                 => 'Please enter your email address.',
            'email.email'                    => 'Please provide a valid authentic email address.',
            'phone.required'                 => 'Please enter your 10-digit mobile number.',
            'phone.regex'                    => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'whatsapp_no.regex'              => 'Please enter a valid 10-digit WhatsApp number starting with 6, 7, 8, or 9.',
            'password.min'                   => 'Password must be at least 8 characters long.',
            'password.confirmed'             => 'Password confirmation does not match.',
            'gender.required'                => 'Please select your gender.',
            'date_of_birth.required'         => 'Please enter your date of birth.',
            'highest_qualification.required' => 'Please select your highest qualification.',
            'experience_range.required'      => 'Please select your teaching experience.',
            'tuition_subjects.required'      => 'Please select at least one tuition subject.',
            'classes_interested.required'    => 'Please select at least one class you are interested to teach.',
            'teaching_mode.required'         => 'Please choose your teaching mode (Offline, Online, or Both).',
            'preferred_areas.required'       => 'Please write your preferred areas for home tuition (e.g. Kankarbagh, Boring Road).',
            'position_applying_for.required' => 'Please select the school job position you are applying for.',
            'resume.required'                => 'Resume upload is mandatory for School Job applications.',
            'preferred_locations.required'   => 'Please select at least one preferred location.',
        ];

        $request->validate($rules, $messages);

        // Handle File Uploads (Resume & Salary Slip)
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        } elseif ($request->hasFile('tutor_resume')) {
            $resumePath = $request->file('tutor_resume')->store('resumes', 'public');
        }

        $salarySlipPath = null;
        if ($request->hasFile('salary_slip')) {
            $salarySlipPath = $request->file('salary_slip')->store('salary_slips', 'public');
        }

        // Derive approximate experience years from selected range
        $expYears = 0;
        $range = $request->experience_range;
        if ($range === '0–1 Year') $expYears = 0;
        elseif ($range === '1–3 Years') $expYears = 2;
        elseif ($range === '3–5 Years') $expYears = 4;
        elseif ($range === '5–10 Years') $expYears = 7;
        elseif ($range === '10–15 Years') $expYears = 12;
        elseif ($range === '15+ Years') $expYears = 15;

        // Determine actual qualification (support direct manual text input)
        $qualificationName = trim($request->highest_qualification);
        if ($qualificationName === '__other__' && $request->filled('highest_qualification_custom')) {
            $qualificationName = trim($request->highest_qualification_custom);
        }

        // Try to associate with master qualifications table if matching
        $qualObj = \App\Models\Qualification::where('name', $qualificationName)
            ->orWhere('name', 'like', "%{$qualificationName}%")
            ->first();

        // Process preferred school locations from manual text and/or chips
        $prefLocations = [];
        if (is_array($request->preferred_locations)) {
            $prefLocations = array_filter($request->preferred_locations, fn($l) => !empty($l) && $l !== 'Other');
        } elseif (is_string($request->preferred_locations) && trim($request->preferred_locations) !== '') {
            $prefLocations = array_map('trim', explode(',', $request->preferred_locations));
        }

        if ($request->filled('preferred_locations_manual')) {
            $manualLocs = array_map('trim', explode(',', $request->preferred_locations_manual));
            $prefLocations = array_unique(array_merge($prefLocations, array_filter($manualLocs)));
        }

        // Validate that at least one location or address was provided for school jobs
        if (in_array($category, ['school_job', 'both']) && empty($prefLocations) && !$request->filled('preferred_areas')) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter your preferred school locations or address.',
                'errors' => ['preferred_locations' => ['Please enter your preferred school locations or address.']]
            ], 422);
        }

        // Generate 6-digit secure numeric OTP
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        // Store complete registration payload in session (leave password plain so model cast handles single hash)
        session([
            'register_data' => [
                'role'                       => 'candidate',
                'candidate_category'         => $category,
                'name'                       => $request->name,
                'email'                      => $request->email,
                'phone'                      => $request->phone,
                'whatsapp_no'                => $request->whatsapp_no ?: $request->phone,
                'password'                   => $request->password,
                'gender'                     => $request->gender,
                'date_of_birth'              => $request->date_of_birth,
                'highest_qualification_name' => $qualificationName,
                'highest_qualification_id'   => $qualObj?->id,
                'experience_range'           => $request->experience_range,
                'experience_years'           => $expYears,

                // Home Tutor fields
                'tuition_subjects'           => $request->tuition_subjects ?? [],
                'classes_interested'         => $request->classes_interested ?? [],
                'teaching_mode'              => $request->teaching_mode,
                'preferred_areas'            => $request->preferred_areas,
                'available_time_slot'        => $request->available_time_slot,

                // School Job fields
                'b_ed_status'                => $request->b_ed_status,
                'd_el_ed_status'              => $request->d_el_ed_status,
                'subject_specialization'     => $request->subject_specialization,
                'position_applying_for'      => $request->position_applying_for,
                'current_salary'             => $request->current_salary,
                'expected_salary'            => $request->expected_salary,
                'last_school_name'           => $request->last_school_name,
                'last_designation'           => $request->last_designation,
                'last_drawn_salary'          => $request->last_drawn_salary,
                'preferred_locations'        => array_values($prefLocations),
                'preferred_locations_manual' => $request->preferred_locations_manual,

                // Uploaded files
                'resume_path'                => $resumePath,
                'salary_slip_path'           => $salarySlipPath,
            ],
            'register_otp' => (string) $otp,
            'register_otp_expires_at' => now()->addMinutes(15),
        ]);

        // Dispatch OTP Email to verify authentic inbox
        try {
            Mail::to($request->email)->send(new RegistrationOtpMail($otp, $request->name));
        } catch (\Exception $e) {
            Log::error('Registration OTP Email Dispatch Error: ' . $e->getMessage());
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'A 6-digit verification code has been sent to ' . $request->email,
                'redirect_url' => route('register.otp.show')
            ]);
        }

        return redirect()->route('register.otp.show')->with('success', 'A 6-digit verification code has been sent to ' . $request->email);
    }

    /**
     * Display the OTP verification screen.
     */
    public function showOtpForm()
    {
        if (!session('register_data') || !session('register_otp')) {
            return redirect()->route('candidate.register');
        }

        return view('auth.register_otp');
    }

    /**
     * Verify the 6-digit OTP and activate the user account.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $data = session('register_data');
        $sessionOtp = session('register_otp');
        $expiresAt = session('register_otp_expires_at');

        if (!$data || !$sessionOtp) {
            return redirect()->route('candidate.register')->withErrors(['email' => 'Registration session expired. Please register again.']);
        }

        if (now()->gt($expiresAt)) {
            return back()->withErrors(['otp' => 'The verification code has expired. Please click "Resend Verification Code" below.']);
        }

        if ($request->otp !== $sessionOtp) {
            return back()->withErrors(['otp' => 'Invalid verification code. Please check your email and enter the correct 6-digit code.']);
        }

        // Clean up any other stale unverified records with same contact details
        User::where(function($query) use ($data) {
            if (!empty($data['email'])) $query->orWhere('email', $data['email']);
            if (!empty($data['phone'])) $query->orWhere('phone', $data['phone']);
        })->where('email', '!=', $data['email'])
          ->whereNull('email_verified_at')
          ->delete();

        // Check if user already exists
        $user = User::where('email', $data['email'])
            ->orWhere('phone', $data['phone'])
            ->first();

        if (!$user) {
            // Create brand new authentic candidate
            $user = User::create([
                'name'        => $data['name'],
                'email'       => $data['email'],
                'phone'       => $data['phone'],
                'whatsapp_no' => $data['whatsapp_no'] ?? $data['phone'],
                'role'        => 'candidate',
                'password'    => $data['password'],
                'is_active'   => true,
            ]);
        } else {
            // Existing user: update name, whatsapp, password if supplied and guarantee active
            $user->name = $data['name'] ?: $user->name;
            $user->whatsapp_no = $data['whatsapp_no'] ?? $user->whatsapp_no ?? $data['phone'];
            if (!empty($data['password'])) {
                $user->password = $data['password'];
            }
            $user->is_active = true;
        }

        $user->email_verified_at = now();
        $user->save();

        // Candidate Profile creation or update
        $profileData = [
            'candidate_category'         => $data['candidate_category'] ?? 'both',
            'whatsapp_no'                => $data['whatsapp_no'] ?? $data['phone'],
            'gender'                     => $data['gender'] ?? null,
            'date_of_birth'              => $data['date_of_birth'] ?? null,
            'highest_qualification_name' => $data['highest_qualification_name'] ?? null,
            'highest_qualification_id'   => $data['highest_qualification_id'] ?? null,
            'experience_range'           => $data['experience_range'] ?? null,
            'experience_years'           => $data['experience_years'] ?? 0,
            'address'                    => $data['preferred_locations_manual'] ?? ($data['preferred_areas'] ?? (is_array($data['preferred_locations'] ?? null) ? implode(', ', $data['preferred_locations']) : null)),

            // Home Tutor fields
            'tuition_subjects'           => $data['tuition_subjects'] ?? null,
            'classes_interested'         => $data['classes_interested'] ?? null,
            'teaching_mode'              => $data['teaching_mode'] ?? null,
            'preferred_areas'            => $data['preferred_areas'] ?? null,
            'available_time_slot'        => $data['available_time_slot'] ?? null,

            // School Job fields
            'b_ed_status'                => $data['b_ed_status'] ?? null,
            'd_el_ed_status'              => $data['d_el_ed_status'] ?? null,
            'subject_specialization'     => $data['subject_specialization'] ?? null,
            'position_applying_for'      => $data['position_applying_for'] ?? null,
            'current_salary'             => $data['current_salary'] ?? null,
            'expected_salary'            => $data['expected_salary'] ?? null,
            'last_school_name'           => $data['last_school_name'] ?? null,
            'last_designation'           => $data['last_designation'] ?? null,
            'last_drawn_salary'          => $data['last_drawn_salary'] ?? null,
            'preferred_locations'        => $data['preferred_locations'] ?? null,

            // Documents
            'resume_path'                => $data['resume_path'] ?? null,
            'salary_slip_path'           => $data['salary_slip_path'] ?? null,

            'is_profile_complete'        => true,
            'registration_completed_at'  => now(),
        ];

        if ($user->profile) {
            $user->profile->update(array_filter($profileData, fn($v) => !is_null($v)));
            $profile = $user->profile;
        } else {
            $profile = $user->profile()->create($profileData);
        }

        // Save calculated profile completion percentage
        $profile->profile_completion_percentage = $profile->completion_percentage;
        $profile->save();

        // Clear registration session & any stale intended URLs
        session()->forget(['register_data', 'register_otp', 'register_otp_expires_at', 'url.intended']);

        Auth::login($user, true);
        $request->session()->regenerate();

        // Notifications (safely caught so notification issues never block redirect)
        try {
            \App\Helpers\NotificationHelper::notifyAdmin(
                'New Verified Candidate Registered',
                $user->name . ' has verified email and registered as a candidate.',
                route('admin.users.index'),
                'fas fa-user-check'
            );

            \App\Helpers\NotificationHelper::notifyUser(
                $user->id,
                'Welcome to Warriors Educare',
                'Thank you for verifying your email. Your candidate dashboard is ready.',
                route('candidate.dashboard'),
                'fas fa-handshake',
                false
            );
        } catch (\Throwable $e) {
            Log::warning('Registration notification failed: ' . $e->getMessage());
        }

        return redirect()->route('candidate.dashboard')->with('success', 'Email verified successfully! Welcome to your dashboard.');
    }

    /**
     * Resend verification OTP code.
     */
    public function resendOtp(Request $request)
    {
        $data = session('register_data');

        if (!$data || empty($data['email'])) {
            return redirect()->route('candidate.register')->withErrors(['email' => 'Registration session expired. Please enter your details again.']);
        }

        $otp = sprintf('%06d', mt_rand(100000, 999999));

        session([
            'register_otp' => (string) $otp,
            'register_otp_expires_at' => now()->addMinutes(15),
        ]);

        try {
            Mail::to($data['email'])->send(new RegistrationOtpMail($otp, $data['name']));
        } catch (\Exception $e) {
            Log::error('Resend Registration OTP Error: ' . $e->getMessage());
        }

        Log::info("Resent Registration OTP for {$data['email']}: {$otp}");

        return back()->with('success', 'A fresh 6-digit verification code has been dispatched to ' . $data['email']);
    }

    /**
     * Cancel registration and return to form.
     */
    public function cancelRegistration()
    {
        $data = session('register_data');
        session()->forget(['register_data', 'register_otp', 'register_otp_expires_at']);

        if ($data && isset($data['role']) && $data['role'] === 'employer') {
            return redirect()->route('employer.register')->withInput($data);
        }

        return redirect()->route('candidate.register')->withInput($data ?? []);
    }
}
