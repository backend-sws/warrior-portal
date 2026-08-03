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
        $tuitions = TuitionRequirement::where('status', 'Active')
            ->latest()
            ->paginate(12);

        $appliedTuitionIds = TuitionApplication::where('candidate_id', auth()->id())
            ->pluck('tuition_requirement_id')
            ->toArray();

        return view('candidate.tuitions.index', compact('tuitions', 'appliedTuitionIds'));
    }

    public function apply(Request $request, $id)
    {
        $tuition = TuitionRequirement::findOrFail($id);

        if ($tuition->status !== 'Active') {
            return back()->with('error', 'This tuition is no longer active.');
        }

        $existingApplication = TuitionApplication::where('candidate_id', auth()->id())
            ->where('tuition_requirement_id', $id)
            ->first();

        if ($existingApplication) {
            return back()->with('info', 'You have already applied to this tuition.');
        }

        TuitionApplication::create([
            'candidate_id' => auth()->id(),
            'tuition_requirement_id' => $id,
            'status' => 'Applied'
        ]);

        return back()->with('success', 'You have successfully applied for this tuition!');
    }
}
