<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeTuitionLead;

class FrontendLeadController extends Controller
{
    public function storeTuitionLead(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'role' => 'required|in:Parent,Student',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);

        $lead = HomeTuitionLead::create([
            'parent_name' => $request->role, // Using role to identify if it's Parent or Student
            'parent_mobile' => $request->contact,
            'email' => $request->email,
            'location' => $request->location,
            'class' => $request->level,
            'board' => $request->board,
            'subjects' => $request->subject,
            'status' => 'New Lead',
            'tutor_preference' => 'Any',
        ]);

        // Add a follow-up note to indicate it came from the landing page
        $ip = $request->ip();
        $lead->followUps()->create([
            'note' => 'Lead generated via landing page quick form. User identified as: ' . $request->role . '. (IP: ' . $ip . ')',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your request has been submitted successfully! We will contact you soon.'
        ]);
    }
}
