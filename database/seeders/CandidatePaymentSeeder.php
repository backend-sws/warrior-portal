<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CandidatePaymentAccount;
use Carbon\Carbon;

class CandidatePaymentSeeder extends Seeder
{
    public function run(): void
    {
        $account1 = CandidatePaymentAccount::create([
            'candidate_name' => 'Rahul Verma',
            'mobile_number' => '9876543210',
            'address' => 'Andheri West, Mumbai',
            'tuition_assigned' => 'Maths for Class 10 (Aarav Sharma)',
            'joining_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
            'monthly_amount' => 1500.00,
            'status' => 'active',
            'next_due_date' => Carbon::today()->addDays(2)->format('Y-m-d')
        ]);

        $account1->payments()->create([
            'payment_date' => Carbon::now()->subMonths(1)->format('Y-m-d'),
            'amount' => 1500.00,
            'payment_mode' => 'UPI',
            'type' => 'Collected',
            'collected_by' => 'Admin',
            'remarks' => 'First month commission'
        ]);

        CandidatePaymentAccount::create([
            'candidate_name' => 'Priya Singh',
            'mobile_number' => '8765432109',
            'address' => 'Bandra East, Mumbai',
            'tuition_assigned' => 'Physics for Class 12 (Neha Singh)',
            'joining_date' => Carbon::now()->subMonths(1)->format('Y-m-d'),
            'monthly_amount' => 2000.00,
            'status' => 'active',
            'next_due_date' => Carbon::today()->subDays(5)->format('Y-m-d')
        ]);

        $account3 = CandidatePaymentAccount::create([
            'candidate_name' => 'Neha Gupta',
            'mobile_number' => '7654321098',
            'address' => 'Colaba, Mumbai',
            'tuition_assigned' => 'All Subjects for Class 8 (Rohan Desai)',
            'joining_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
            'monthly_amount' => 1000.00,
            'status' => 'active',
            'next_due_date' => Carbon::today()->addDays(15)->format('Y-m-d')
        ]);

        $account3->payments()->create([
            'payment_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
            'amount' => 500.00,
            'payment_mode' => 'Cash',
            'type' => 'Paid',
            'collected_by' => 'Admin',
            'remarks' => 'Advance salary'
        ]);
    }
}
