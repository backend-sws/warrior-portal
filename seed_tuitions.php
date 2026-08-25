<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$employer = \App\Models\User::where('role', 'employer')->first() ?? \App\Models\User::firstOrCreate(
    ['email' => 'employer@example.com'],
    [
        'name' => 'Warrior Parent Partner',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role' => 'employer'
    ]
);

$tuitionsData = [
    [
        'guest_name' => 'Dr. Sunita Sharma',
        'guest_phone' => '9876543210',
        'student_class' => 'Class 10',
        'board' => 'CBSE',
        'subjects' => 'Mathematics & Science',
        'budget' => '7,000',
        'location' => 'Sector 56, Gurgaon',
        'description' => 'Need an experienced tutor for Class 10 Board preparation.',
        'status' => 'Pending'
    ],
    [
        'guest_name' => 'Rajesh Verma',
        'guest_phone' => '9811223344',
        'student_class' => 'Class 12',
        'board' => 'CBSE',
        'subjects' => 'Physics & Chemistry',
        'budget' => '9,500',
        'location' => 'Indirapuram, Ghaziabad',
        'description' => 'Require specialized teacher for competitive and board exam prep.',
        'status' => 'Pending'
    ],
    [
        'guest_name' => 'Anita Desai',
        'guest_phone' => '9988776655',
        'student_class' => 'Class 8',
        'board' => 'ICSE',
        'subjects' => 'English & Social Science',
        'budget' => '5,500',
        'location' => 'Koramangala, Bangalore',
        'description' => 'Focus on grammar, comprehension and essay writing.',
        'status' => 'Pending'
    ],
    [
        'guest_name' => 'Vikram Malhotra',
        'guest_phone' => '9765432109',
        'student_class' => 'Class 9',
        'board' => 'CBSE',
        'subjects' => 'Mathematics',
        'budget' => '6,000',
        'location' => 'Bandra West, Mumbai',
        'description' => 'Need home tutor for concept building and weekly tests.',
        'status' => 'Pending'
    ],
    [
        'guest_name' => 'Meenakshi Iyer',
        'guest_phone' => '9123456789',
        'student_class' => 'Class 11',
        'board' => 'State Board',
        'subjects' => 'Accountancy & Economics',
        'budget' => '8,000',
        'location' => 'Aliganj, Lucknow',
        'description' => 'Looking for Commerce stream home tutor.',
        'status' => 'Pending'
    ],
    [
        'guest_name' => 'Pooja Agarwal',
        'guest_phone' => '9871122334',
        'student_class' => 'Class 6',
        'board' => 'CBSE',
        'subjects' => 'All Subjects',
        'budget' => '4,500',
        'location' => 'Rohini Sector 9, Delhi',
        'description' => 'Daily homework assistance and foundational learning.',
        'status' => 'Pending'
    ]
];

foreach ($tuitionsData as $t) {
    \App\Models\TuitionRequirement::firstOrCreate(
        ['guest_name' => $t['guest_name'], 'subjects' => $t['subjects']],
        array_merge($t, ['employer_id' => $employer ? $employer->id : null])
    );
}

echo "Added " . count($tuitionsData) . " Tuition posts successfully!\n";
