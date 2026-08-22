<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeTuitionLead;
use App\Models\TuitionApplication;
use App\Helpers\NotificationHelper;

class TuitionController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;
        $isAgreementSigned = (bool) ($profile?->is_tuition_agreement_signed);

        $tuitions = HomeTuitionLead::where('status', 'Approved')
            ->latest()
            ->paginate(12);

        $appliedTuitionIds = TuitionApplication::where('candidate_id', auth()->id())
            ->pluck('home_tuition_lead_id')
            ->toArray();

        return view('candidate.tuitions.index', compact('tuitions', 'appliedTuitionIds', 'profile', 'isAgreementSigned'));
    }

    public function signAgreement(Request $request)
    {
        $request->validate([
            'accept_terms' => 'required|accepted',
        ]);

        $profile = auth()->user()->profile;
        if ($profile) {
            $profile->update([
                'is_tuition_agreement_signed' => true,
                'tuition_agreement_signed_at' => now(),
                'tuition_signature_data' => auth()->user()->name . ' (IP: ' . $request->ip() . ')',
            ]);
        }

        NotificationHelper::notifyUser(
            auth()->id(),
            'Tuition Agreement Signed ✅',
            'You have successfully signed the Home Tuition Tutor Service Agreement. You can now apply for all home tuitions.',
            route('candidate.tuitions.index'),
            'fas fa-file-signature'
        );

        return back()->with('success', 'Home Tuition Tutor Service Agreement signed successfully! All tuitions are now unlocked for you.');
    }

    public function apply(Request $request, $id)
    {
        $profile = auth()->user()->profile;
        if (!$profile || !$profile->is_tuition_agreement_signed) {
            return back()->with('error', 'Please review and digitally sign the Home Tuition Tutor Service Agreement before applying.');
        }

        $tuition = HomeTuitionLead::findOrFail($id);

        if ($tuition->status !== 'Approved') {
            return back()->with('error', 'This tuition requirement is no longer active or accepting applications.');
        }

        $existingApplication = TuitionApplication::where('candidate_id', auth()->id())
            ->where('home_tuition_lead_id', $id)
            ->first();

        if ($existingApplication) {
            return back()->with('info', 'You have already applied to this tuition.');
        }

        TuitionApplication::create([
            'candidate_id' => auth()->id(),
            'home_tuition_lead_id' => $id,
            'status' => 'Applied'
        ]);

        NotificationHelper::notifyUser(
            auth()->id(),
            'Tuition Application Submitted ✅',
            "You have applied for {$tuition->class} ({$tuition->subjects}) in {$tuition->location}.",
            route('candidate.tuitions.index'),
            'fas fa-book-reader'
        );

        return back()->with('success', 'You have successfully applied for this tuition!');
    }
}
