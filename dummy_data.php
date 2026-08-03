<?php

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\ClientLogo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// 1. Create a dummy client logo image
$svg = '<svg width="200" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="200" height="100" fill="#f3f4f6" rx="10"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="20" font-weight="bold" fill="#0052cc">Logo</text></svg>';
if (!Storage::disk('public')->exists('logos')) {
    Storage::disk('public')->makeDirectory('logos');
}
Storage::disk('public')->put('logos/dummy_logo.svg', $svg);

// 2. Add Dummy Clients
$clients = ['EduCorp', 'Global Academy', 'NextGen Schools', 'Elite Tutors', 'Pinnacle Institute', 'Future Leaders'];
foreach ($clients as $clientName) {
    ClientLogo::firstOrCreate(['name' => $clientName], [
        'logo_path' => 'logos/dummy_logo.svg',
        'is_active' => true,
    ]);
}

// 3. Add Dummy Services
$services = [
    ['title' => 'Teacher Recruitment', 'description' => 'Find the best teachers for your school or institute with our dedicated recruitment process.', 'icon' => 'fas fa-chalkboard-teacher'],
    ['title' => 'Administrative Staffing', 'description' => 'Hire reliable and efficient administrative staff to manage your educational institution smoothly.', 'icon' => 'fas fa-user-tie'],
    ['title' => 'Home Tutors', 'description' => 'Connect with experienced home tutors for personalized student learning and development.', 'icon' => 'fas fa-home'],
    ['title' => 'Career Counseling', 'description' => 'Expert career counseling services for students and job seekers in the education sector.', 'icon' => 'fas fa-user-graduate'],
];

foreach ($services as $srv) {
    Service::firstOrCreate(['title' => $srv['title']], [
        'slug' => Str::slug($srv['title']),
        'description' => $srv['description'],
        'content' => '<p>' . $srv['description'] . '</p>',
        'icon' => $srv['icon'],
        'is_active' => true,
    ]);
}

// 4. Add Dummy Testimonials
$testimonials = [
    ['name' => 'Rahul Sharma', 'role' => 'School Principal', 'message' => 'Warriors Educare helped us find excellent math and science teachers within a week. Highly recommended!', 'rating' => 5],
    ['name' => 'Anita Desai', 'role' => 'Administrator', 'message' => 'The recruitment process is incredibly smooth and professional. Best agency we have worked with.', 'rating' => 5],
    ['name' => 'Vikram Singh', 'role' => 'Director', 'message' => 'Their dedication to finding the right fit for our institute is unmatched. Very satisfied with the hires.', 'rating' => 4],
    ['name' => 'Priya Patel', 'role' => 'Home Tutor', 'message' => 'I got multiple home tuition requests immediately after registering. Great platform for tutors!', 'rating' => 5],
    ['name' => 'Sunil Gupta', 'role' => 'Chairman', 'message' => 'Outstanding support and a vast database of qualified candidates. Our hiring process is 10x faster now.', 'rating' => 5],
];

foreach ($testimonials as $t) {
    Testimonial::firstOrCreate(['name' => $t['name']], [
        'role' => $t['role'],
        'message' => $t['message'],
        'rating' => $t['rating'],
        'image_path' => null,
        'is_active' => true,
    ]);
}

echo "Dummy data seeded successfully!\n";
