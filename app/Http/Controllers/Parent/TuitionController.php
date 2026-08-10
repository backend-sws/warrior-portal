<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\HomeTuitionLead;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    public function index()
    {
        // Fetch all active tuitions posted by admin
        $tuitions = \App\Models\TuitionRequirement::where('status', 'Active')->latest()->paginate(12);

        $appliedTuitionIds = \App\Models\TuitionApplication::where('candidate_id', auth()->id())
            ->pluck('tuition_requirement_id')
            ->toArray();

        return view('parent.tuitions.index', compact('tuitions', 'appliedTuitionIds'));
    }

    public function apply(\Illuminate\Http\Request $request, $id)
    {
        $tuition = \App\Models\TuitionRequirement::findOrFail($id);

        if ($tuition->status !== 'Active') {
            return back()->with('error', 'This tuition is no longer active.');
        }

        $existingApplication = \App\Models\TuitionApplication::where('candidate_id', auth()->id())
            ->where('tuition_requirement_id', $id)
            ->first();

        if ($existingApplication) {
            return back()->with('info', 'You have already applied to this tuition.');
        }

        \App\Models\TuitionApplication::create([
            'candidate_id' => auth()->id(),
            'tuition_requirement_id' => $id,
            'status' => 'Applied'
        ]);

        return back()->with('success', 'You have successfully applied for this tuition!');
    }

    public function create()
    {
        return view('parent.tuitions.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'class' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        \App\Models\HomeTuitionLead::create([
            'parent_name' => $request->name,
            'parent_mobile' => $request->phone,
            'class' => $request->class,
            'board' => $request->board,
            'subjects' => $request->subjects,
            'location' => $request->location,
            'status' => 'New Lead',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('parent.tuitions.create')->with('success', 'Your requirement has been submitted successfully. Our team will contact you soon.');
    }

    public function history()
    {
        $leads = \App\Models\HomeTuitionLead::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('parent.tuitions.history', compact('leads'));
    }
}
