<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TuitionRequirement;
use App\Models\TuitionApplication;

class TuitionController extends Controller
{
    public function index()
    {
        $tuitions = \App\Models\HomeTuitionLead::whereNotIn('status', ['Confirmed', 'Cancelled', 'Closed'])
            ->latest()
            ->paginate(12);

        $appliedTuitionIds = TuitionApplication::where('candidate_id', auth()->id())
            ->pluck('home_tuition_lead_id')
            ->toArray();

        return view('candidate.tuitions.index', compact('tuitions', 'appliedTuitionIds'));
    }

    public function apply(Request $request, $id)
    {
        $tuition = \App\Models\HomeTuitionLead::findOrFail($id);

        if (in_array($tuition->status, ['Confirmed', 'Cancelled', 'Closed'])) {
            return back()->with('error', 'This tuition lead is no longer active or accepting applications.');
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

        return back()->with('success', 'You have successfully applied for this tuition!');
    }
}
