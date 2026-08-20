<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Create a dummy Employer User
$employer = \App\Models\User::firstOrCreate(
    ['email' => 'employer@example.com'],
    [
        'name' => 'Dummy Employer',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role' => 'employer'
    ]
);

// 2. Create Employer Tuitions (TuitionRequirement)
$t1 = new App\Models\TuitionRequirement();
$t1->employer_id = $employer->id;
$t1->guest_name = 'Employer One';
$t1->guest_phone = '1112223334';
$t1->student_class = 'Class 8';
$t1->board = 'CBSE';
$t1->subjects = 'Mathematics';
$t1->budget = '6000';
$t1->location = 'Sector 14, Gurgaon';
$t1->description = 'Looking for an experienced Mathematics tutor.';
$t1->status = 'Pending';
$t1->save();

$t2 = new App\Models\TuitionRequirement();
$t2->employer_id = $employer->id;
$t2->guest_name = 'Employer Two';
$t2->guest_phone = '4443332221';
$t2->student_class = 'Class 12';
$t2->board = 'State Board';
$t2->subjects = 'Biology';
$t2->budget = '7500';
$t2->location = 'Andheri West, Mumbai';
$t2->description = 'Need an expert Biology tutor for board exams.';
$t2->status = 'Pending';
$t2->save();

// 3. Create Home Tuition Leads (HomeTuitionLead for tuitions page)
$h1 = new App\Models\HomeTuitionLead();
$h1->parent_name = 'Rajesh Kumar';
$h1->parent_mobile = '9876501234';
$h1->class = 'Class 10';
$h1->board = 'ICSE';
$h1->subjects = 'Science, Math';
$h1->location = 'Koramangala, Bangalore';
$h1->fee = '5000';
$h1->status = 'New Lead';
$h1->save();

$h2 = new App\Models\HomeTuitionLead();
$h2->parent_name = 'Sita Devi';
$h2->parent_mobile = '9123456780';
$h2->class = 'Class 5';
$h2->board = 'CBSE';
$h2->subjects = 'All Subjects';
$h2->location = 'Vasant Kunj, New Delhi';
$h2->fee = '3000';
$h2->status = 'New Lead';
$h2->save();

echo "Dummy Tuition Posts & Leads created successfully!\n";
