<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TuitionFeeAccount extends Model
{
    protected $fillable = [
        'parent_name',
        'student_name',
        'mobile_number',
        'address',
        'class',
        'subject',
        'teacher_name',
        'teacher_joining_date',
        'monthly_fee',
        'status',
        'next_due_date',
    ];

    protected $casts = [
        'teacher_joining_date' => 'date',
        'next_due_date' => 'date',
        'monthly_fee' => 'decimal:2',
    ];

    public function payments()
    {
        return $this->hasMany(TuitionFeePayment::class);
    }
}
