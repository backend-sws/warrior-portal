<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RegistrationOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ParentAuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_parent');
    }

    public function register(Request $request)
    {
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

        $otp = sprintf('%06d', mt_rand(100000, 999999));

        session([
            'register_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'parent',
                'password' => Hash::make($request->password),
            ],
            'register_otp' => (string) $otp,
            'register_otp_expires_at' => now()->addMinutes(15),
        ]);

        try {
            Mail::to($request->email)->send(new RegistrationOtpMail($otp, $request->name));
        } catch (\Exception $e) {
            Log::error('Parent Registration OTP Dispatch Error: ' . $e->getMessage());
        }

        Log::info("Parent Registration OTP for {$request->email}: {$otp}");

        return redirect()->route('register.otp.show')->with('success', 'A 6-digit verification code has been sent to ' . $request->email);
    }
}
