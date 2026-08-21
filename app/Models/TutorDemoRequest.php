<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorDemoRequest extends Model
{
    protected $fillable = [
        'tutor_id',
        'parent_name',
        'parent_phone',
        'subject',
        'status',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
