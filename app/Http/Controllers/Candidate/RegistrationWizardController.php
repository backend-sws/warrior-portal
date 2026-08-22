<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Services\Payment\PaymentGatewayManager;
use App\Models\PaymentTransaction;

class RegistrationWizardController extends Controller
{
    private PaymentGatewayManager $paymentManager;

    public function __construct(PaymentGatewayManager $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    public function show()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        if ($profile->initial_fee_paid || $profile->is_fee_paid) {
            return redirect()->route('candidate.dashboard');
        }

        // Load relationships if necessary
        $profile->load(['category', 'subject', 'highestQualification', 'preferredState', 'preferredCity']);
        
        $categories = \App\Models\Category::all();
        $subjects = \App\Models\Subject::all();
        $qualifications = \App\Models\Qualification::all();
        $states = \App\Models\State::where('is_active', true)->get();

        return view('candidate.wizard', compact('user', 'profile', 'categories', 'subjects', 'qualifications', 'states'));
    }

    public function saveStep1(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:Male,Female,Other',
                'address' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'subject_id' => 'required|exists:subjects,id',
                'highest_qualification_id' => 'required|exists:qualifications,id',
                'preferred_state_id' => 'required|exists:states,id',
                'preferred_city_id' => 'required|exists:cities,id',
                'experience_years' => 'required|integer|min:0',
                'current_salary' => 'nullable|string',
                'expected_salary' => 'nullable|string',
                'current_school' => 'nullable|string',
                'english_fluency' => 'nullable|in:beginner,intermediate,fluent',
                'residential_preference' => 'nullable|in:residential,day,both',
                'availability_to_join' => 'nullable|string',
                'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'salary_slip' => 'nullable|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
                'offer_letter' => 'nullable|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()->toArray(),
                    'message' => 'Validation failed.'
                ], 422);
            }

            $profile = auth()->user()->profile;

            if ($request->hasFile('resume')) {
                $path = $request->file('resume')->store('resumes', 'public');
                $profile->resume_path = $path;
            }

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $profile->profile_photo_path = $path;
            }

            if ($request->hasFile('salary_slip')) {
                $path = $request->file('salary_slip')->store('salary_slips', 'public');
                $profile->salary_slip_path = $path;
            }

            if ($request->hasFile('offer_letter')) {
                $path = $request->file('offer_letter')->store('offer_letters', 'public');
                $profile->offer_letter_path = $path;
            }

            $isFirstTime = !$profile->is_profile_complete;

            $profile->update([
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'category_id' => $request->category_id,
                'subject_id' => $request->subject_id,
                'highest_qualification_id' => $request->highest_qualification_id,
                'preferred_state_id' => $request->preferred_state_id,
                'preferred_city_id' => $request->preferred_city_id,
                'experience_years' => $request->experience_years,
                'current_salary' => $request->current_salary,
                'expected_salary' => $request->expected_salary,
                'current_school' => $request->current_school,
                'english_fluency' => $request->english_fluency,
                'residential_preference' => $request->residential_preference,
                'availability_to_join' => $request->availability_to_join,
                'is_profile_complete' => true,
            ]);

            if ($isFirstTime) {
                $adminUser = \App\Models\User::where('role', 'admin')->first();
                if ($adminUser) {
                    \Illuminate\Support\Facades\DB::table('notifications')->insert([
                        'id' => \Illuminate\Support\Str::uuid(),
                        'type' => 'App\Notifications\NewRegistrationStep1',
                        'notifiable_type' => 'App\Models\User',
                        'notifiable_id' => $adminUser->id,
                        'data' => json_encode([
                            'title' => 'Candidate Completed Form 1',
                            'message' => auth()->user()->name . ' has just filled the first registration form.',
                            'candidate_id' => auth()->id()
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Wizard Step 1 Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveStep2(Request $request)
    {
        $request->validate([
            'agreed' => 'required|boolean|accepted',
        ]);

        $user    = auth()->user();
        $profile = $user->profile;

        $profile->update([
            'is_terms_agreed' => true,
        ]);

        // Notify Candidate — terms accepted
        NotificationHelper::notifyUser(
            $user->id,
            'Terms & Conditions Accepted ✅',
            'You have successfully accepted the Terms & Conditions. Please proceed to sign your digital agreement.',
            null,
            'fas fa-file-contract'
        );

        // Notify Admin
        NotificationHelper::notifyAdmin(
            'Candidate Accepted Terms',
            $user->name . ' has accepted the Terms & Conditions and is proceeding to sign the agreement.',
            null,
            'fas fa-file-contract'
        );

        return response()->json(['success' => true]);
    }

    public function saveStep3(Request $request)
    {
        $request->validate([
            'signature_type' => 'required|in:draw,upload,type',
            'signature_data' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'live_photo' => 'required|string', // Base64 expected
        ]);

        $user    = auth()->user();
        $profile = $user->profile;

        $signatureData = $request->signature_data;

        if ($request->signature_type === 'upload' && $request->hasFile('signature_file')) {
            $path = $request->file('signature_file')->store('signatures', 'public');
            $signatureData = $path;
        }

        $livePhotoPath = null;
        if ($request->live_photo) {
            $image_parts = explode(";base64,", $request->live_photo);
            if (count($image_parts) == 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'live_photo_' . $user->id . '_' . time() . '.jpg';
                $filePath = 'live_photos/' . $fileName;
                \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $image_base64);
                $livePhotoPath = $filePath;
            }
        }

        $profile->update([
            'is_agreement_signed' => true,
            'signature_type'      => $request->signature_type,
            'signature_data'      => $signatureData,
            'signature_date_time' => now(),
            'signature_device_info' => $request->header('User-Agent'),
            'signature_ip_address'  => $request->ip(),
            'live_photo_path'       => $livePhotoPath,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
        ]);

        // Notify Candidate — agreement signed
        NotificationHelper::notifyUser(
            $user->id,
            'Agreement Signed Successfully ✍️',
            'Your digital signature has been recorded. You are now ready to select a registration plan and complete payment.',
            null,
            'fas fa-signature'
        );

        // Notify Admin — agreement signed
        NotificationHelper::notifyAdmin(
            'Candidate Signed Agreement',
            $user->name . ' has digitally signed the registration agreement and is proceeding to payment.',
            null,
            'fas fa-signature'
        );

        return response()->json(['success' => true]);
    }

    public function initiatePayment(Request $request)
    {
        $request->validate([
            'plan_type' => 'required|in:standard,premium'
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        if ($profile->initial_fee_paid || $profile->is_fee_paid) {
            return response()->json(['success' => false, 'message' => 'You have already paid the registration fee.']);
        }

        $planType = $request->plan_type;
        $amount = $planType === 'standard' ? 500 : 1000;
        $receipt = 'TXN_' . $user->id . '_' . time();

        $gateway = $this->paymentManager->driver();
        $order = $gateway->createOrder([
            'amount'   => $amount,
            'receipt'  => $receipt,
            'notes'    => [
                'user_id'    => (string)$user->id,
                'user_name'  => (string)$user->name,
                'user_email' => (string)$user->email,
                'user_phone' => (string)$user->phone,
                'plan_type'  => $planType,
                'type'       => 'registration_fee',
            ]
        ]);

        if (!$order['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment: ' . ($order['error'] ?? 'Please try again.')
            ], 400);
        }

        session([
            'active_wizard_order_id' => $order['order_id'],
            'pending_plan_type'      => $planType
        ]);

        PaymentTransaction::create([
            'candidate_id'   => $user->id,
            'amount'         => $amount,
            'currency'       => 'INR',
            'transaction_id' => $receipt,
            'order_id'       => $order['order_id'],
            'type'           => 'registration_fee',
            'status'         => 'pending',
            'gateway'        => $gateway->getGatewayName(),
            'ip_address'     => request()->ip(),
        ]);

        return response()->json([
            'success' => true,
            'order'   => $order,
        ]);
    }

    public function callback(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in.');
        }

        $orderId   = $request->input('razorpay_order_id', session('active_wizard_order_id'));
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');
        $pendingPlanType = session('pending_plan_type', 'standard');

        if (empty($paymentId) || empty($orderId)) {
            return redirect()->route('candidate.dashboard')->with('error', 'Payment was cancelled or failed.');
        }

        $gateway = $this->paymentManager->driver();
        $verification = $gateway->verifyPayment([
            'order_id'   => $orderId,
            'payment_id' => $paymentId,
            'signature'  => $signature,
        ]);

        $txn = PaymentTransaction::where('order_id', $orderId)->first();

        if (!$verification['success']) {
            if ($txn) {
                $txn->update(['status' => 'failed', 'payment_id' => $paymentId, 'signature' => $signature]);
            }
            return redirect()->route('candidate.dashboard')->with('error', 'Payment verification failed.');
        }

        $amountPaid = $txn ? $txn->amount : ($pendingPlanType === 'standard' ? 500 : 1000);

        if ($txn) {
            $txn->update([
                'payment_id'       => $paymentId,
                'signature'        => $signature,
                'status'           => 'success',
                'payment_method'   => $verification['payment_method'] ?? 'online',
                'gateway'          => 'razorpay',
                'gateway_response' => $verification['raw'] ?? [],
            ]);
        }

        $profile = $user->profile;

        if ($pendingPlanType === 'standard') {
            // Standard plan payment (2 job applications allowed)
            $profile->update([
                'plan_type' => 'standard',
                'total_allowed_applications' => 2,
                'initial_fee_paid' => true,
                'paid_amount' => $profile->paid_amount + $amountPaid,
                'pending_amount' => 500, // Initial 500 paid, 500 pending
                'payment_id' => $statusResult['transactionId'],
                'registration_completed_at' => now(),
                'plan_started_at' => now(),
            ]);
        } else {
            // Premium plan payment (3 job applications allowed)
            $profile->update([
                'plan_type' => 'premium',
                'total_allowed_applications' => 3,
                'initial_fee_paid' => true,
                'is_fee_paid' => true,
                'paid_amount' => $profile->paid_amount + $amountPaid,
                'pending_amount' => 0,
                'payment_id' => $statusResult['transactionId'],
                'registration_completed_at' => now(),
                'plan_started_at' => now(),
            ]);
        }

        // Clear session
        $request->session()->forget(['registration_plan', 'payment_txn_id', 'pending_plan_type', 'last_txn_id']);

        // Insert Database Notification for Candidate
        \Illuminate\Support\Facades\DB::table('notifications')->insert([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\RegistrationSuccess',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $user->id,
            'data' => json_encode([
                'title' => 'Registration Successful',
                'message' => 'Welcome to Warriors Educare! Your registration plan is now active.',
                'plan' => $pendingPlanType
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Notify Admin of new registration
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            \Illuminate\Support\Facades\DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\Notifications\NewRegistration',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $adminUser->id,
                'data' => json_encode([
                    'title' => 'New Registration',
                    'message' => $user->name . ' has successfully completed registration and signed the agreement.',
                    'candidate_id' => $user->id
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Send Email to Candidate (Queued)
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\RegistrationSuccessMail($user));

        return redirect()->route('candidate.dashboard')->with('success', 'Payment successful! Registration complete.');
    }
}
