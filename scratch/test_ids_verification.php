<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\HomeTuitionLead;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

View::share('errors', new \Illuminate\Support\ViewErrorBag());

echo "=== 1. TESTING TUITION_ID & JOB_ID AUTO-GENERATION ===\n";
$firstTuition = HomeTuitionLead::first();
echo "Tuition #{$firstTuition->id} Tuition ID: " . $firstTuition->tuition_id . "\n";

$firstJob = JobPost::first();
echo "Job #{$firstJob->id} Job ID: " . $firstJob->job_id . "\n";

echo "\n=== 2. TESTING ADMIN TUITION LEADS FILTER/SEARCH ===\n";
$adminUser = User::where('role', 'admin')->first();
Auth::login($adminUser);

$htReq = Request::create('/admin/home-tuition-leads', 'GET', ['search' => 'TUI-0001']);
$htCtrl = new \App\Http\Controllers\Admin\HomeTuitionLeadController();
$htRes = $htCtrl->index($htReq);
$htHtml = $htRes->render();
echo "✓ Admin Tuition Leads Search Rendered (" . strlen($htHtml) . " bytes)\n";

echo "\n=== 3. TESTING ADMIN JOBS FILTER/SEARCH ===\n";
$jobReq = Request::create('/admin/jobs', 'GET', ['search' => 'JOB-0001']);
$jobCtrl = new \App\Http\Controllers\Admin\JobController();
$jobRes = $jobCtrl->index($jobReq);
$jobHtml = $jobRes->render();
echo "✓ Admin Jobs Search Rendered (" . strlen($jobHtml) . " bytes)\n";

echo "\n=== 4. TESTING CANDIDATE TUITIONS & APPLICATIONS VIEWS ===\n";
$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);

$candTuitionReq = Request::create('/candidate/tuitions', 'GET', ['search' => 'TUI-0001']);
$candTuitionCtrl = new \App\Http\Controllers\Candidate\TuitionController();
$candTuitionRes = $candTuitionCtrl->index($candTuitionReq);
$candTuitionHtml = $candTuitionRes->render();
echo "✓ Candidate Tuitions View Rendered (" . strlen($candTuitionHtml) . " bytes)\n";

$candAppCtrl = new \App\Http\Controllers\Candidate\ApplicationController();
$candAppRes = $candAppCtrl->index(Request::create('/candidate/applications', 'GET'));
$candAppHtml = $candAppRes->render();
echo "✓ Candidate Applications Index Rendered (" . strlen($candAppHtml) . " bytes)\n";

$candAvailRes = $candAppCtrl->available();
$candAvailHtml = $candAvailRes->render();
echo "✓ Candidate Available Jobs Rendered (" . strlen($candAvailHtml) . " bytes)\n";

echo "\n=== 5. TESTING PUBLIC JOBS & TUITIONS VIEWS ===\n";
$homeCtrl = new \App\Http\Controllers\HomeController();
$pubTuitionRes = $homeCtrl->tuitions(Request::create('/tuitions', 'GET', ['search' => 'TUI-0001']));
$pubTuitionHtml = $pubTuitionRes->render();
echo "✓ Public Tuitions View Rendered (" . strlen($pubTuitionHtml) . " bytes)\n";

$pubJobRes = $homeCtrl->jobs(Request::create('/jobs', 'GET', ['search' => 'JOB-0001']));
$pubJobHtml = $pubJobRes->render();
echo "✓ Public Jobs View Rendered (" . strlen($pubJobHtml) . " bytes)\n";

echo "\n=== ALL TESTS PASSED SUCCESSFULLY! ===\n";
