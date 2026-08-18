<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuitionRequirement;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    public function index()
    {
        $employerTuitions = TuitionRequirement::with('employer')->whereNotNull('employer_id')->latest()->paginate(20, ['*'], 'employer_page');
        $guestTuitions = TuitionRequirement::whereNull('employer_id')->latest()->paginate(20, ['*'], 'guest_page');
        $appliedTuitions = \App\Models\TuitionApplication::with(['candidate', 'tuitionLead'])->latest()->paginate(10, ['*'], 'applications_page');

        return view('admin.tuitions.index', compact('employerTuitions', 'guestTuitions', 'appliedTuitions'));
    }

    public function create()
    {
        return view('admin.tuitions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_class' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'budget' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Admin posts on their own behalf or as a default employer
        $validated['employer_id'] = auth()->id();
        $validated['status'] = 'Active';

        TuitionRequirement::create($validated);

        return redirect()->route('admin.tuitions.index')->with('success', 'Tuition requirement posted successfully!');
    }

    public function update(Request $request, TuitionRequirement $tuition)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive,Pending,Matched,Closed'
        ]);

        $tuition->update(['status' => $request->status]);

        return back()->with('success', 'Tuition status updated successfully.');
    }

    public function destroy(TuitionRequirement $tuition)
    {
        $tuition->delete();
        return back()->with('success', 'Tuition deleted successfully.');
    }
}
