<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFollowUp extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'next_follow_up_date' => 'date',
    ];

    public function employerProfile()
    {
        return $this->belongsTo(EmployerProfile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
