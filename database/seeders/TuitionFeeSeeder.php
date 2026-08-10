<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TuitionFeeAccount;
use Carbon\Carbon;

class TuitionFeeSeeder extends Seeder
{
    public function run(): void
    {
        $account1 = TuitionFeeAccount::create([
            'parent_name' => 'Rajesh Sharma',
            'student_name' => 'Aarav Sharma',
            'mobile_number' => '9876543210',
            'address' => 'Andheri West, Mumbai',
            'class' => '10th',
            'subject' => 'Maths, Science',
            'teacher_name' => 'Priya Singh',
            'teacher_joining_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
            'monthly_fee' => 4000.00,
            'status' => 'active',
            'next_due_date' => Carbon::today()->addDays(2)->format('Y-m-d')
        ]);

        $account1->payments()->create([
            'payment_date' => Carbon::now()->subMonths(1)->format('Y-m-d'),
            'amount' => 4000.00,
            'payment_mode' => 'UPI',
            'collected_by' => 'Admin',
            'remarks' => 'Paid via GPay'
        ]);

        TuitionFeeAccount::create([
            'parent_name' => 'Vikram Singh',
            'student_name' => 'Neha Singh',
            'mobile_number' => '8765432109',
            'address' => 'Bandra East, Mumbai',
            'class' => '12th',
            'subject' => 'Physics',
            'teacher_name' => 'Rahul Verma',
            'teacher_joining_date' => Carbon::now()->subMonths(1)->format('Y-m-d'),
            'monthly_fee' => 5000.00,
            'status' => 'active',
            'next_due_date' => Carbon::today()->subDays(5)->format('Y-m-d')
        ]);

        TuitionFeeAccount::create([
            'parent_name' => 'Anita Desai',
            'student_name' => 'Rohan Desai',
            'mobile_number' => '7654321098',
            'address' => 'Colaba, Mumbai',
            'class' => '8th',
            'subject' => 'All Subjects',
            'teacher_name' => 'Neha Gupta',
            'teacher_joining_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
            'monthly_fee' => 3000.00,
            'status' => 'active',
            'next_due_date' => Carbon::today()->addDays(15)->format('Y-m-d')
        ]);
    }
}
