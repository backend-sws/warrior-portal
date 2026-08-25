<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

View::share('errors', new \Illuminate\Support\ViewErrorBag());

echo "=== TESTING PROFESSIONAL JOB DETAILS VIEW ===\n";
$job = JobPost::first();
$jobCtrl = new \App\Http\Controllers\JobController();

// 1. Test as Guest
Auth::logout();
$resGuest = $jobCtrl->show($job);
$htmlGuest = $resGuest->render();
echo "✓ Job Details View as GUEST rendered (" . strlen($htmlGuest) . " bytes)\n";

// 2. Test as Logged-in Candidate
$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);
$resCandidate = $jobCtrl->show($job);
$htmlCandidate = $resCandidate->render();
echo "✓ Job Details View as CANDIDATE rendered (" . strlen($htmlCandidate) . " bytes)\n";

echo "\n=== ALL TESTS PASSED SUCCESSFULLY! ===\n";
