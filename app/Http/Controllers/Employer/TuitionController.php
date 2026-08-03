<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\TuitionRequirement;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    public function index()
    {
        $tuitions = auth()->user()->tuitions()->latest()->paginate(10);
        return view('employer.tuitions.index', compact('tuitions'));
    }

    public function create()
    {
        return view('employer.tuitions.create');
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

        auth()->user()->tuitions()->create($validated);

        return redirect()->route('employer.tuitions.index')->with('success', 'Tuition requirement posted successfully!');
    }

    public function edit(TuitionRequirement $tuition)
    {
        if ($tuition->employer_id !== auth()->id()) abort(403);
        return view('employer.tuitions.edit', compact('tuition'));
    }

    public function update(Request $request, TuitionRequirement $tuition)
    {
        if ($tuition->employer_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'student_class' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'budget' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tuition->update($validated);

        return redirect()->route('employer.tuitions.index')->with('success', 'Tuition requirement updated successfully!');
    }

    public function destroy(TuitionRequirement $tuition)
    {
        if ($tuition->employer_id !== auth()->id()) abort(403);
        
        $tuition->delete();
        return back()->with('success', 'Tuition requirement deleted successfully!');
    }
}
