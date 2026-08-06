<?php

namespace App\Observers;

use App\Models\TuitionRequirement;
use App\Models\HomeTuitionLead;

class TuitionRequirementObserver
{
    /**
     * Handle the TuitionRequirement "created" event.
     */
    public function created(TuitionRequirement $tuitionRequirement): void
    {
        // Automatically create a HomeTuitionLead when a new TuitionRequirement is submitted
        
        // Determine parent name and mobile based on whether it's a guest or employer
        $parentName = $tuitionRequirement->guest_name ?? ($tuitionRequirement->employer ? $tuitionRequirement->employer->name : 'Unknown');
        $parentMobile = $tuitionRequirement->guest_phone ?? ($tuitionRequirement->employer ? $tuitionRequirement->employer->phone : 'Unknown');

        $lead = HomeTuitionLead::create([
            'parent_name' => $parentName,
            'parent_mobile' => $parentMobile,
            'location' => $tuitionRequirement->location,
            'class' => $tuitionRequirement->student_class,
            'subjects' => $tuitionRequirement->subjects,
            'fee' => $tuitionRequirement->budget,
            'tutor_preference' => 'Any', // Default since not specified in form
            'enquiry_date' => $tuitionRequirement->created_at,
            'status' => 'New Lead',
            'additional_notes' => $tuitionRequirement->description,
        ]);

        // Add an initial follow-up note referencing the origin
        $origin = $tuitionRequirement->employer_id ? 'Registered Employer' : 'Guest';
        $lead->followUps()->create([
            'admin_id' => null, // System generated
            'note' => "Automatically generated from {$origin} Tuition Requirement form submission.",
        ]);

        // Send Notification to Admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewHomeTuitionLeadNotification($lead));
    }

    /**
     * Handle the TuitionRequirement "updated" event.
     */
    public function updated(TuitionRequirement $tuitionRequirement): void
    {
        //
    }

    /**
     * Handle the TuitionRequirement "deleted" event.
     */
    public function deleted(TuitionRequirement $tuitionRequirement): void
    {
        //
    }

    /**
     * Handle the TuitionRequirement "restored" event.
     */
    public function restored(TuitionRequirement $tuitionRequirement): void
    {
        //
    }

    /**
     * Handle the TuitionRequirement "force deleted" event.
     */
    public function forceDeleted(TuitionRequirement $tuitionRequirement): void
    {
        //
    }
}
