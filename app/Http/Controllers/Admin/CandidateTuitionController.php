<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\HomeTuitionLead;
use Illuminate\Http\Request;

class CandidateTuitionController extends Controller
{
    /**
     * List all candidates who can be appointed as tutors.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'candidate')
            ->with(['profile.preferredCity', 'profile.preferredState', 'profile.subject', 'profile.category', 'tuitionApplications'])
            ->whereHas('profile');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $candidates = $query->latest()->paginate(15)->withQueryString();

        // All open tuition leads (not confirmed or cancelled) for appointment modal
        $tuitionLeads = HomeTuitionLead::whereNotIn('status', ['Cancelled', 'Confirmed'])
            ->orderBy('created_at', 'desc')
            ->get(['id', 'parent_name', 'parent_mobile', 'location', 'class', 'subjects', 'status', 'tutor_preference']);

        return view('admin.candidate_tuition.index', compact('candidates', 'tuitionLeads'));
    }

    /**
     * Appoint a candidate to a parent's home tuition lead.
     * Updates lead: status → Confirmed, teacher_name & teacher_contact set.
     */
    public function appoint(Request $request, $candidateId)
    {
        $request->validate([
            'lead_id' => 'required|exists:home_tuition_leads,id',
        ]);

        $candidate = User::with('profile')->findOrFail($candidateId);
        $lead = HomeTuitionLead::findOrFail($request->lead_id);

        // Update the lead with teacher info and set to Confirmed
        $lead->update([
            'teacher_name'    => $candidate->name,
            'teacher_contact' => $candidate->phone,
            'status'          => 'Confirmed',
        ]);

        // Add a follow-up note
        $lead->followUps()->create([
            'admin_id'   => auth()->id(),
            'note'       => "Candidate \"{$candidate->name}\" (Ph: {$candidate->phone}) appointed as tutor. Status set to Confirmed. Pending final admin approval.",
            'follow_up_date' => now()->addDays(1)->toDateString(),
        ]);

        return redirect()
            ->route('admin.tuition-leads.show', $lead->id)
            ->with('success', "✅ {$candidate->name} appointed to {$lead->parent_name}'s lead. Please upload their ID proof and photo to finalize the appointment.");

    }
}
