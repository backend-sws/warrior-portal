<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Category;
use App\Models\Subject;
use App\Models\State;
use App\Models\City;
use App\Models\Specialization;
use App\Models\Qualification;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        $category = Category::first();
        $subject = Subject::first();
        $state = State::first();
        $city = City::first();
        $specialization = Specialization::first();
        $qualification = Qualification::first();

        if (!$category) return; // Ensure basic lookup data exists

        $jobs = [
            [
                'title' => 'Senior Mathematics Teacher',
                'school_name' => 'Delhi Public School',
                'job_type' => 'Full-time',
                'salary_range' => '₹40,000 - ₹60,000 / month',
                'description' => 'Looking for an experienced Mathematics teacher for high school students. Must have a strong background in Calculus and Algebra.',
            ],
            [
                'title' => 'Primary Science Teacher',
                'school_name' => 'St. Xavier\'s High School',
                'job_type' => 'Full-time',
                'salary_range' => '₹25,000 - ₹35,000 / month',
                'description' => 'Seeking an enthusiastic primary school science teacher to inspire young minds.',
            ],
            [
                'title' => 'Part-time English Tutor',
                'school_name' => 'EduCare Institute',
                'job_type' => 'Part-time',
                'salary_range' => '₹15,000 - ₹20,000 / month',
                'description' => 'We need a part-time English tutor for spoken English classes in the evening.',
            ],
            [
                'title' => 'Physics Lecturer',
                'school_name' => 'National Science College',
                'job_type' => 'Contract',
                'salary_range' => '₹50,000 - ₹70,000 / month',
                'description' => 'Contract-based physics lecturer for 11th and 12th grades (CBSE).',
            ],
        ];

        foreach ($jobs as $job) {
            JobPost::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'subject_id' => $subject ? $subject->id : null,
                'state_id' => $state ? $state->id : null,
                'city_id' => $city ? $city->id : null,
                'specialization_id' => $specialization ? $specialization->id : null,
                'qualification_id' => $qualification ? $qualification->id : null,
                'school_name' => $job['school_name'],
                'contact_person' => 'HR Manager',
                'email' => 'hr@' . strtolower(str_replace([' ', '\''], '', $job['school_name'])) . '.com',
                'phone' => '9876543210',
                'title' => $job['title'],
                'description' => $job['description'],
                'salary_range' => $job['salary_range'],
                'status' => 'approved',
                'job_type' => $job['job_type'],
            ]);
        }
    }
}
