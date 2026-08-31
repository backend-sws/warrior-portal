<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function followUps()
    {
        return $this->hasMany(SchoolFollowUp::class)->latest();
    }

    public function jobs()
    {
        return $this->hasMany(JobPost::class, 'user_id', 'user_id');
    }
}
