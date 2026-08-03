<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'guest_name',
        'guest_phone',
        'student_class',
        'board',
        'subjects',
        'location',
        'budget',
        'description',
        'status',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
