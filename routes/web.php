<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/tuition/post', [App\Http\Controllers\HomeController::class, 'storeTuition'])->name('tuition.post');
Route::post('/school-requirement/post', [\App\Http\Controllers\HomeController::class, 'storeSchoolRequirement'])->name('school.requirement.post');
Route::get('/jobs', [\App\Http\Controllers\HomeController::class, 'jobs'])->name('jobs');
Route::get('/tuitions', [\App\Http\Controllers\HomeController::class, 'tuitions'])->name('tuitions');
Route::get('/tutors/search', [\App\Http\Controllers\TutorSearchController::class, 'search'])->name('tutors.search');
Route::post('/tutors/request-demo', [\App\Http\Controllers\TutorSearchController::class, 'requestDemo'])->name('tutors.requestDemo');
Route::get('/jobs/{job}', [\App\Http\Controllers\JobController::class, 'show'])->name('jobs.show');
Route::get('/category/{id}/jobs', [\App\Http\Controllers\HomeController::class, 'categoryJobs'])->name('category.jobs');

// Dynamic Subjects and Specializations
Route::get('/api/categories/{category}/subjects', [HomeController::class, 'getSubjects'])->name('api.category.subjects');
Route::get('/api/subjects/{subject}/specializations', [HomeController::class, 'getSpecializations'])->name('api.subject.specializations');
Route::get('/api/states/{state}/cities', function (\App\Models\State $state) {
    return $state->cities()->where('is_active', true)->get();
})->name('api.state.cities');

Route::view('/about', 'about')->name('about');
Route::get('/services', [\App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/services/{slug}', [\App\Http\Controllers\HomeController::class, 'serviceDetails'])->name('service.details');
Route::view('/hiring-process', 'hiring')->name('hiring');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [\App\Http\Controllers\HomeController::class, 'storeContact'])->name('contact.store');
Route::view('/apply', 'apply')->name('apply');
Route::get('/post-job', [\App\Http\Controllers\JobController::class, 'showPostJobForm'])->name('post-job');
Route::post('/post-job', [\App\Http\Controllers\JobController::class, 'storeJobQuery'])->name('post-job.store');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/media', 'media')->name('media');
Route::get("/refund", function () {
    return view('refund');
})->name("refund");
Route::get("/pricing", function () {
    return view('pricing');
})->name("pricing");
Route::get('/cookie', function () {
    return view('cookie');
})->name("cookie");
Route::get('/disclaimer', function () {
    return view('disclaimer');
})->name('disclaimer');
Route::get('/employer', function () {
    return view('employer');
})->name('employer');
Route::get('/candidate', function () {
    return view('candidate');
})->name('candidate');  


// Resume Builder (Public)
Route::get('/resume-builder', [\App\Http\Controllers\ResumeBuilderController::class, 'index'])->name('resume.builder');
Route::post('/resume-builder/download', [\App\Http\Controllers\ResumeBuilderController::class, 'download'])->name('resume.builder.download');

// Authentication Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->middleware('guest')->name('login.post');

// Password Reset Routes
Route::get('/password/reset', [\App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])->middleware('guest')->name('password.request');
Route::post('/password/email', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');
Route::get('/password/reset/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/password/reset', [\App\Http\Controllers\PasswordResetController::class, 'reset'])->middleware('guest')->name('password.update');

// OTP Login Routes
Route::get('/login/otp', [\App\Http\Controllers\AuthController::class, 'showOtpForm'])->middleware('guest')->name('login.otp');
Route::post('/login/otp/send', [\App\Http\Controllers\AuthController::class, 'sendOtp'])->middleware('guest')->name('login.otp.send');
Route::post('/login/otp/verify', [\App\Http\Controllers\AuthController::class, 'verifyOtp'])->middleware('guest')->name('login.otp.verify');

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    if (auth()->user()->role === 'employer')
        return redirect('/employer/dashboard');
    return redirect('/candidate/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Candidate Auth Routes
Route::get('/register', [\App\Http\Controllers\CandidateAuthController::class, 'showRegistrationForm'])->middleware('guest')->name('candidate.register');
Route::post('/register', [\App\Http\Controllers\CandidateAuthController::class, 'register'])->middleware('guest')->name('candidate.register.post');
Route::get('/register/verify-otp', [\App\Http\Controllers\CandidateAuthController::class, 'showOtpForm'])->middleware('guest')->name('register.otp.show');
Route::post('/register/verify-otp', [\App\Http\Controllers\CandidateAuthController::class, 'verifyOtp'])->middleware('guest')->name('register.otp.verify');
Route::post('/register/resend-otp', [\App\Http\Controllers\CandidateAuthController::class, 'resendOtp'])->middleware('guest')->name('register.otp.resend');
Route::get('/register/cancel', [\App\Http\Controllers\CandidateAuthController::class, 'cancelRegistration'])->middleware('guest')->name('register.cancel');

// Candidate Routes (Unverified but Auth Required)
Route::middleware(['auth', 'candidate'])->prefix('candidate')->name('candidate.')->group(function () {
    // Registration Wizard
    Route::get('/wizard', [\App\Http\Controllers\Candidate\RegistrationWizardController::class, 'show'])->name('wizard');
    Route::post('/wizard/step1', [\App\Http\Controllers\Candidate\RegistrationWizardController::class, 'saveStep1'])->name('wizard.step1');
    Route::post('/wizard/step2', [\App\Http\Controllers\Candidate\RegistrationWizardController::class, 'saveStep2'])->name('wizard.step2');
    Route::post('/wizard/step3', [\App\Http\Controllers\Candidate\RegistrationWizardController::class, 'saveStep3'])->name('wizard.step3');
    Route::post('/wizard/payment', [\App\Http\Controllers\Candidate\RegistrationWizardController::class, 'initiatePayment'])->name('wizard.payment');
    Route::match(['get', 'post'], '/wizard/callback', [\App\Http\Controllers\Candidate\RegistrationWizardController::class, 'callback'])->name('wizard.callback');

    Route::get('/dashboard', function () {
        $user = auth()->user();
        $profile = $user->profile()->with(['highestQualification', 'preferredState', 'preferredCity', 'subject', 'category'])->first()
            ?? $user->profile()->create([]);
        return view('candidate.dashboard', compact('profile'));
    })->name('dashboard');
});

// Candidate Routes (Protected)
Route::middleware(['auth', 'candidate'])->prefix('candidate')->name('candidate.')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Candidate\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\Candidate\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/password', [\App\Http\Controllers\Candidate\ProfileController::class, 'updatePassword'])->name('password.update');

    Route::get('/agreement', [\App\Http\Controllers\Candidate\AgreementController::class, 'show'])->name('agreement.show');
    Route::post('/agreement/request', [\App\Http\Controllers\Candidate\AgreementController::class, 'requestActivation'])->name('agreement.request');
    Route::post('/agreement/sign', [\App\Http\Controllers\Candidate\AgreementController::class, 'sign'])->name('agreement.sign');
    Route::get('/agreement/download', [\App\Http\Controllers\Candidate\AgreementController::class, 'download'])->name('agreement.download');

    Route::get('/payment', [\App\Http\Controllers\Candidate\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/process', [\App\Http\Controllers\Candidate\PaymentController::class, 'process'])->name('payment.process');
    Route::match(['get', 'post'], '/payment/callback', [\App\Http\Controllers\Candidate\PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/invoice/{id}', [\App\Http\Controllers\Candidate\PaymentController::class, 'invoice'])->name('payment.invoice');

    Route::get('/applications', [\App\Http\Controllers\Candidate\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/available', [\App\Http\Controllers\Candidate\ApplicationController::class, 'available'])->name('applications.available');
    Route::post('/applications/{job}/apply', [\App\Http\Controllers\Candidate\ApplicationController::class, 'apply'])->name('applications.apply');

    Route::get('/registration', [\App\Http\Controllers\Candidate\RegistrationController::class, 'show'])->name('registration.show');
    Route::get('/service-charge', [\App\Http\Controllers\Candidate\ServiceChargeController::class, 'show'])->name('serviceCharge.show');
    Route::get('/service-charge/invoice/{id}', [\App\Http\Controllers\Candidate\ServiceChargeController::class, 'downloadInvoicePdf'])->name('serviceCharge.invoice');
    Route::get('/service-charge/invoice/{id}/pdf', [\App\Http\Controllers\Candidate\ServiceChargeController::class, 'downloadInvoicePdf'])->name('serviceCharge.invoicePdf');
    Route::get('/service-charge/checkout/{id}', [\App\Http\Controllers\Candidate\ServiceChargeController::class, 'checkout'])->name('serviceCharge.checkout');
    Route::post('/service-charge/pay', [\App\Http\Controllers\Candidate\ServiceChargeController::class, 'process'])->name('serviceCharge.pay');
    Route::match(['get', 'post'], '/service-charge/callback', [\App\Http\Controllers\Candidate\ServiceChargeController::class, 'callback'])->name('serviceCharge.callback');
    Route::view('/additional-feature', 'candidate.aditionalFeature.show')->name('aditionalFeature.show');

    Route::get('/tuitions', [\App\Http\Controllers\Candidate\TuitionController::class, 'index'])->name('tuitions.index');
    Route::post('/tuitions/sign-agreement', [\App\Http\Controllers\Candidate\TuitionController::class, 'signAgreement'])->name('tuitions.sign-agreement');
    Route::post('/tuitions/{id}/apply', [\App\Http\Controllers\Candidate\TuitionController::class, 'apply'])->name('tuitions.apply');
});

// Parent Auth Routes (Disabled as requested)
// Route::get('/parent/register', [\App\Http\Controllers\ParentAuthController::class, 'showRegistrationForm'])->middleware('guest')->name('parent.register');
// Route::post('/parent/register', [\App\Http\Controllers\ParentAuthController::class, 'register'])->middleware('guest')->name('parent.register.post');

// Parent Routes (Protected) - Disabled as requested
/*
Route::middleware(['auth', 'parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Parent\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Parent\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\Parent\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/tuitions', [\App\Http\Controllers\Parent\TuitionController::class, 'index'])->name('tuitions.index');
    Route::get('/tutor-need', [\App\Http\Controllers\Parent\TuitionController::class, 'create'])->name('tuitions.create');
    Route::post('/tutor-need', [\App\Http\Controllers\Parent\TuitionController::class, 'store'])->name('tuitions.store');
    Route::post('/tuitions/{id}/apply', [\App\Http\Controllers\Parent\TuitionController::class, 'apply'])->name('tuitions.apply');
    Route::get('/history', [\App\Http\Controllers\Parent\TuitionController::class, 'history'])->name('tuitions.history');
    Route::get('/appointed-teachers', [\App\Http\Controllers\Parent\TuitionController::class, 'appointedTeachers'])->name('appointed-teachers');

    // Parent Service Charge & Payment Routes
    Route::get('/service-charge', [\App\Http\Controllers\Parent\ServiceChargeController::class, 'index'])->name('serviceCharge.index');
    Route::post('/service-charge/pay', [\App\Http\Controllers\Parent\ServiceChargeController::class, 'processPay'])->name('serviceCharge.pay');
    Route::get('/service-charge/checkout/{id}', [\App\Http\Controllers\Parent\ServiceChargeController::class, 'checkout'])->name('serviceCharge.checkout');
    Route::match(['get', 'post'], '/service-charge/callback', [\App\Http\Controllers\Parent\ServiceChargeController::class, 'callback'])->name('serviceCharge.callback');
    Route::get('/service-charge/invoice/{id}/print', [\App\Http\Controllers\Parent\ServiceChargeController::class, 'printInvoice'])->name('serviceCharge.print');
    Route::get('/service-charge/invoice/{id}/download', [\App\Http\Controllers\Parent\ServiceChargeController::class, 'downloadInvoice'])->name('serviceCharge.download');
});
*/

// Employer Auth Routes (Commented out)
// Route::get('/employer/register', [\App\Http\Controllers\EmployerAuthController::class, 'showRegistrationForm'])->name('employer.register');
// Route::post('/employer/register', [\App\Http\Controllers\EmployerAuthController::class, 'register'])->name('employer.register.post');

// Employer Routes (Protected) - Commented out
/*
Route::middleware(['auth', 'verified', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Employer\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('jobs', \App\Http\Controllers\Employer\JobController::class);
    Route::resource('tuitions', \App\Http\Controllers\Employer\TuitionController::class);

    Route::get('/profile', [\App\Http\Controllers\Employer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\Employer\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/applicants', [\App\Http\Controllers\Employer\ApplicantController::class, 'index'])->name('applicants.index');
});
*/

// Global Impersonation Leave Route
Route::middleware(['auth'])->get('/admin/impersonate/leave', [\App\Http\Controllers\Admin\UserController::class, 'leaveImpersonate'])->name('admin.impersonate.leave');

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::resource('qualifications', \App\Http\Controllers\Admin\QualificationController::class);
    Route::resource('states', \App\Http\Controllers\Admin\StateController::class);
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

    // Job Posts
    Route::resource('jobs', \App\Http\Controllers\Admin\JobController::class);
    Route::resource('tuitions', \App\Http\Controllers\Admin\TuitionController::class);
    Route::post('jobs/{job}/approve', [\App\Http\Controllers\Admin\JobController::class, 'approve'])->name('jobs.approve');
    Route::post('jobs/{job}/reject', [\App\Http\Controllers\Admin\JobController::class, 'reject'])->name('jobs.reject');
    // Schools & Educational Institutes CRM (Manual Entry & Records)
    Route::get('/schools', [\App\Http\Controllers\Admin\SchoolController::class, 'index'])->name('schools.index');
    Route::get('/schools/create', [\App\Http\Controllers\Admin\SchoolController::class, 'create'])->name('schools.create');
    Route::post('/schools', [\App\Http\Controllers\Admin\SchoolController::class, 'store'])->name('schools.store');
    Route::get('/schools/{id}', [\App\Http\Controllers\Admin\SchoolController::class, 'show'])->name('schools.show');
    Route::get('/schools/{id}/edit', [\App\Http\Controllers\Admin\SchoolController::class, 'edit'])->name('schools.edit');
    Route::put('/schools/{id}', [\App\Http\Controllers\Admin\SchoolController::class, 'update'])->name('schools.update');
    Route::delete('/schools/{id}', [\App\Http\Controllers\Admin\SchoolController::class, 'destroy'])->name('schools.destroy');
    Route::post('/schools/{id}/follow-up', [\App\Http\Controllers\Admin\SchoolController::class, 'addFollowUp'])->name('schools.followup.store');
    Route::post('/schools/{id}/post-job', [\App\Http\Controllers\Admin\SchoolController::class, 'storeJob'])->name('schools.job.store');

    // Candidates CRM
    Route::get('/candidates/create', [\App\Http\Controllers\Admin\CrmController::class, 'create'])->name('crm.create');
    Route::post('/candidates/store', [\App\Http\Controllers\Admin\CrmController::class, 'store'])->name('crm.store');
    Route::get('/candidates/{id}/edit', [\App\Http\Controllers\Admin\CrmController::class, 'edit'])->name('crm.edit');
    Route::put('/candidates/{id}', [\App\Http\Controllers\Admin\CrmController::class, 'update'])->name('crm.update');
    Route::get('/candidates', [\App\Http\Controllers\Admin\CrmController::class, 'index'])->name('crm.index');
    Route::get('/candidates/{id}', [\App\Http\Controllers\Admin\CrmController::class, 'show'])->name('crm.show');
    Route::post('/crm/candidate/{id}/follow-up', [\App\Http\Controllers\Admin\CrmController::class, 'storeFollowUp'])->name('crm.followup.store');
    Route::post('/crm/candidate/{id}/invoice', [\App\Http\Controllers\Admin\CrmController::class, 'storeInvoice'])->name('crm.invoice.store');
    Route::post('/crm/candidate/{id}/assign-job', [\App\Http\Controllers\Admin\CrmController::class, 'assignJob'])->name('crm.application.assign');
    Route::post('/crm/candidate/{id}/assign-tuition', [\App\Http\Controllers\Admin\CrmController::class, 'assignTuition'])->name('crm.tuition.assign');
    Route::put('/crm/invoice/{id}', [\App\Http\Controllers\Admin\CrmController::class, 'updateInvoiceStatus'])->name('crm.invoice.update');
    Route::post('/crm/invoice/{id}/adjust', [\App\Http\Controllers\Admin\CrmController::class, 'adjustInvoice'])->name('crm.invoice.adjust');
    Route::post('/crm/candidate/{id}/toggle-verification', [\App\Http\Controllers\Admin\CrmController::class, 'toggleVerification'])->name('crm.candidate.verify');
    Route::post('/crm/candidate/{id}/rate', [\App\Http\Controllers\Admin\CrmController::class, 'rateCandidate'])->name('crm.candidate.rate');
    Route::get('/crm/candidate/{id}/magic-login', [\App\Http\Controllers\Admin\CrmController::class, 'magicLogin'])->name('crm.candidate.magic-login');
    Route::post('/crm/candidate/{id}/upload-agreement', [\App\Http\Controllers\Admin\CrmController::class, 'uploadAgreement'])->name('crm.candidate.upload-agreement');
    Route::post('/crm/candidate/{id}/update-agreement-status', [\App\Http\Controllers\Admin\CrmController::class, 'updateAgreementStatus'])->name('crm.candidate.update-agreement-status');

    // Applications & Transactions
    Route::get('/applications', [\App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/{id}/status', [\App\Http\Controllers\Admin\ApplicationController::class, 'updateStatus'])->name('applications.status.update');
    Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');

    // Contact Leads
    Route::get('/leads', [\App\Http\Controllers\Admin\ContactLeadController::class, 'index'])->name('leads.index');
    Route::post('/leads/bulk-delete', [\App\Http\Controllers\Admin\ContactLeadController::class, 'bulkDelete'])->name('leads.bulk-delete');
    Route::get('/leads/{id}', [\App\Http\Controllers\Admin\ContactLeadController::class, 'show'])->name('leads.show');
    Route::put('/leads/{id}/status', [\App\Http\Controllers\Admin\ContactLeadController::class, 'updateStatus'])->name('leads.status.update');
    Route::post('/leads/{id}/follow-up', [\App\Http\Controllers\Admin\ContactLeadController::class, 'storeFollowUp'])->name('leads.followup.store');
    Route::delete('/leads/{id}', [\App\Http\Controllers\Admin\ContactLeadController::class, 'destroy'])->name('leads.destroy');

    // Home Tuition Leads
    Route::get('/tuition-leads', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'index'])->name('tuition-leads.index');
    Route::get('/tuition-leads/pending', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'pending'])->name('tuition-leads.pending');
    Route::get('/tuition-leads/confirmed', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'confirmed'])->name('tuition-leads.confirmed');
    Route::get('/tuition-leads/create', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'create'])->name('tuition-leads.create');
    Route::post('/tuition-leads', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'store'])->name('tuition-leads.store');
    Route::get('/tuition-leads/{id}', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'show'])->name('tuition-leads.show');
    Route::get('/tuition-leads/{id}/edit', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'edit'])->name('tuition-leads.edit');
    Route::put('/tuition-leads/{id}', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'update'])->name('tuition-leads.update');
    Route::put('/tuition-leads/{id}/status', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'updateStatus'])->name('tuition-leads.status.update');
    Route::post('/tuition-leads/{id}/approve', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'approve'])->name('tuition-leads.approve');
    Route::post('/tuition-leads/{id}/toggle-featured', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'toggleFeatured'])->name('tuition-leads.toggle-featured');
    Route::post('/tuition-leads/{id}/assign-teacher', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'assignTeacher'])->name('tuition-leads.assign-teacher');
    Route::post('/tuition-leads/{id}/follow-up', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'storeFollowUp'])->name('tuition-leads.followup.store');
    Route::post('/tuition-leads/{id}/service-charge-invoice', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'storeInvoice'])->name('tuition-leads.invoice.store');
    Route::put('/tuition-leads/service-charge-invoice/{invoiceId}/status', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'updateInvoiceStatus'])->name('tuition-leads.invoice.status');
    Route::post('/tuition-leads/{id}/upload-documents', [\App\Http\Controllers\Admin\HomeTuitionLeadController::class, 'uploadTeacherDocuments'])->name('tuition-leads.upload-documents');

    // Candidate Tuition Appointment & Applications
    Route::get('/tuition-applications', [\App\Http\Controllers\Admin\TuitionApplicationController::class, 'index'])->name('tuition-applications.index');
    Route::post('/tuition-applications/{id}/status', [\App\Http\Controllers\Admin\TuitionApplicationController::class, 'updateStatus'])->name('tuition-applications.status.update');
    Route::get('/candidate-tuition', [\App\Http\Controllers\Admin\CandidateTuitionController::class, 'index'])->name('candidate-tuition.index');
    Route::post('/candidate-tuition/{candidateId}/appoint', [\App\Http\Controllers\Admin\CandidateTuitionController::class, 'appoint'])->name('candidate-tuition.appoint');

    // Tuition Service Charges (Teacher / Candidate Invoices)
    Route::get('/tuition-service-charges', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'index'])->name('tuition-service-charges.index');
    Route::get('/tuition-service-charges/invoice/{id}', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'showInvoice'])->name('serviceCharge.invoice');
    Route::post('/tuition-service-charges', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'store'])->name('tuition-service-charges.store');
    Route::put('/tuition-service-charges/{id}', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'update'])->name('tuition-service-charges.update');
    Route::post('/tuition-service-charges/{id}/mark-paid', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'markPaid'])->name('tuition-service-charges.mark-paid');
    Route::post('/tuition-service-charges/{id}/remind', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'sendReminder'])->name('tuition-service-charges.remind');
    Route::delete('/tuition-service-charges/{id}', [\App\Http\Controllers\Admin\TuitionServiceChargeController::class, 'destroy'])->name('tuition-service-charges.destroy');

    // Tuition Fee Accounts (Payment Management)
    Route::get('/tuition-fees', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'index'])->name('tuition-fees.index');
    Route::get('/tuition-fees/create', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'create'])->name('tuition-fees.create');
    Route::post('/tuition-fees', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'store'])->name('tuition-fees.store');
    Route::get('/tuition-fees/{id}', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'show'])->name('tuition-fees.show');
    Route::get('/tuition-fees/{id}/edit', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'edit'])->name('tuition-fees.edit');
    Route::put('/tuition-fees/{id}', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'update'])->name('tuition-fees.update');
    Route::delete('/tuition-fees/{id}', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'destroy'])->name('tuition-fees.destroy');
    Route::post('/tuition-fees/{id}/payment', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'addPayment'])->name('tuition-fees.payment.add');
    Route::post('/tuition-fees/{id}/follow-up', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'setFollowUp'])->name('tuition-fees.follow-up');
    Route::post('/tuition-fees/{id}/status', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'updatePaymentStatus'])->name('tuition-fees.status.update');
    Route::post('/tuition-fees/{id}/send-reminder', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'sendPaymentReminder'])->name('tuition-fees.send-reminder');
    Route::post('/tuition-fees-daily-summary', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'sendDailySummaryEmail'])->name('tuition-fees.daily-summary');
    Route::post('/tuition-fees-bulk-reminders', [\App\Http\Controllers\Admin\TuitionFeeController::class, 'sendBulkReminders'])->name('tuition-fees.bulk-reminders');


    // Candidate Payment Management
    Route::resource('candidate-payments', \App\Http\Controllers\Admin\CandidatePaymentController::class);
    Route::post('/candidate-payments/{id}/payment', [\App\Http\Controllers\Admin\CandidatePaymentController::class, 'addPayment'])->name('candidate-payments.payment.add');

    // Frontend Management
    
    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('/users/{id}/impersonate', [\App\Http\Controllers\Admin\UserController::class, 'impersonate'])->name('users.impersonate');

    // Notification Management
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/mark-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::get('/notifications/{id}/mark-unread', [\App\Http\Controllers\Admin\NotificationController::class, 'markUnread'])->name('notifications.mark-unread');
    Route::get('/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/clear-read', [\App\Http\Controllers\Admin\NotificationController::class, 'clearRead'])->name('notifications.clear-read');

    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['create', 'show', 'edit']);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['create', 'show', 'edit']);
    Route::resource('clients', \App\Http\Controllers\Admin\ClientLogoController::class)->except(['create', 'show', 'edit'])->parameters(['clients' => 'clientLogo']);

    // ── Admin Manual Reminder System ──────────────────────────────────────
    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/',                 [\App\Http\Controllers\Admin\ReminderController::class, 'index'])->name('index');
        Route::get('/search-candidates',[\App\Http\Controllers\Admin\ReminderController::class, 'searchCandidates'])->name('search-candidates');
        Route::post('/service-charge',  [\App\Http\Controllers\Admin\ReminderController::class, 'sendServiceChargeReminder'])->name('service-charge');
        Route::post('/tuition-service', [\App\Http\Controllers\Admin\ReminderController::class, 'sendTuitionServiceReminder'])->name('tuition-service');
        Route::post('/agreement',       [\App\Http\Controllers\Admin\ReminderController::class, 'sendAgreementReminder'])->name('agreement');
        Route::post('/tuition-demo',    [\App\Http\Controllers\Admin\ReminderController::class, 'sendTuitionDemoReminder'])->name('tuition-demo');
        Route::post('/interview',       [\App\Http\Controllers\Admin\ReminderController::class, 'sendInterviewReminder'])->name('interview');
        Route::post('/profile',         [\App\Http\Controllers\Admin\ReminderController::class, 'sendProfileCompletionReminder'])->name('profile');
        Route::post('/late-fee',        [\App\Http\Controllers\Admin\ReminderController::class, 'sendLateFeeAlert'])->name('late-fee');
        Route::post('/custom',          [\App\Http\Controllers\Admin\ReminderController::class, 'sendCustomMessage'])->name('custom');
        Route::post('/process-batch',   [\App\Http\Controllers\Admin\ReminderController::class, 'processBatch'])->name('process-batch');
    });
});

Route::post('/submit-tuition-request', [\App\Http\Controllers\FrontendLeadController::class, 'storeTuitionLead'])->name('submit-tuition-request');

// PhonePe Webhooks
Route::post('/webhooks/phonepe', [\App\Http\Controllers\WebhookController::class, 'handlePhonePe'])->name('webhook.phonepe');

// Razorpay Webhooks (Commented)
// Route::post('/webhooks/razorpay', [\App\Http\Controllers\WebhookController::class, 'handleRazorpay'])->name('webhook.razorpay');