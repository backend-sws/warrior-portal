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
    public function showRegistrationForm()
    {
        return view('auth.register_candidate');
    }

    /**
     * Handle initial registration request & dispatch OTP to verify email authenticity.
     */
    public function register(Request $request)
    {
        // Remove unverified user with same email or phone so they can re-register cleanly
        $unverifiedUser = User::where(function($query) use ($request) {
            if ($request->email) $query->orWhere('email', $request->email);
            if ($request->phone) $query->orWhere('phone', $request->phone);
        })->whereNull('email_verified_at')->first();

        if ($unverifiedUser) {
            $unverifiedUser->delete();
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:80', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.min' => 'Name must be at least 3 characters long.',
            'name.regex' => 'Name should only contain letters and spaces.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please provide a valid authentic email address.',
            'email.unique' => 'This email address is already registered with us. Please log in.',
            'phone.required' => 'Please enter your 10-digit mobile number.',
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'phone.unique' => 'This mobile number is already registered with us.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Generate 6-digit secure numeric OTP
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        // Store registration payload in session
        session([
            'register_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'candidate',
                'password' => Hash::make($request->password),
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

        Log::info("Registration OTP for {$request->email}: {$otp}");

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

        // Clean up any stale unverified collision
        User::where(function($query) use ($data) {
            if (!empty($data['email'])) $query->orWhere('email', $data['email']);
            if (!empty($data['phone'])) $query->orWhere('phone', $data['phone']);
        })->whereNull('email_verified_at')->delete();

        // Double check uniqueness for verified users
        if (User::where('email', $data['email'])->exists()) {
            return redirect()->route('login')->withErrors(['email' => 'An account with this email already exists. Please log in.']);
        }

        // Create verified authentic User
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $data['role'] ?? 'candidate',
            'password' => $data['password'],
        ]);

        $user->email_verified_at = now();
        $user->save();

        // Initialize role-based profile
        if ($user->role === 'employer') {
            $user->employerProfile()->create([
                'school_name' => $data['school_name'] ?? null,
                'contact_person' => $data['name'],
                'phone' => $data['phone'],
            ]);
        } elseif ($user->role === 'parent') {
            $user->parentProfile()->create([]);
        } else {
            $user->profile()->create([]);
        }

        // Clear registration session
        session()->forget(['register_data', 'register_otp', 'register_otp_expires_at']);

        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        // Notifications
        if ($user->role === 'employer') {
            \App\Helpers\NotificationHelper::notifyAdmin(
                'New Verified Employer Registered',
                ($data['school_name'] ?? 'Employer') . ' (' . $user->name . ') has verified email and registered.',
                route('admin.users.index'),
                'fas fa-building'
            );

            \App\Helpers\NotificationHelper::notifyUser(
                $user->id,
                'Welcome to Warriors Educare',
                'Your verified employer account has been activated. Complete your institution profile to post requirements.',
                route('employer.dashboard'),
                'fas fa-building',
                true
            );

            return redirect()->route('employer.dashboard');
        } elseif ($user->role === 'parent') {
            \App\Helpers\NotificationHelper::notifyAdmin(
                'New Verified Parent Registered',
                $user->name . ' has verified email and registered as a parent/tuition seeker.',
                route('admin.users.index'),
                'fas fa-user-friends'
            );

            \App\Helpers\NotificationHelper::notifyUser(
                $user->id,
                'Welcome to Warriors Educare',
                'Your verified parent account is now active. Find top home tutors and educators.',
                route('parent.dashboard'),
                'fas fa-user',
                true
            );

            return redirect()->route('parent.dashboard');
        } else {
            \App\Helpers\NotificationHelper::notifyAdmin(
                'New Verified Candidate Registered',
                $user->name . ' has verified email and registered as a candidate.',
                route('admin.users.index'),
                'fas fa-user-check'
            );

            \App\Helpers\NotificationHelper::notifyUser(
                $user->id,
                'Welcome to Warriors Educare',
                'Thank you for verifying your email. Please complete your profile to start applying for jobs and tuition inquiries.',
                route('candidate.dashboard'),
                'fas fa-handshake',
                true
            );

            return redirect()->route('candidate.dashboard');
        }
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
