<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== COLUMNS IN home_tuition_leads ===\n";
print_r(Schema::getColumnListing('home_tuition_leads'));

echo "\n=== COLUMNS IN job_posts ===\n";
print_r(Schema::getColumnListing('job_posts'));

echo "\n=== SAMPLE HOME TUITION LEADS ===\n";
print_r(DB::table('home_tuition_leads')->take(2)->get()->toArray());

echo "\n=== SAMPLE JOB POSTS ===\n";
print_r(DB::table('job_posts')->take(2)->get()->toArray());
