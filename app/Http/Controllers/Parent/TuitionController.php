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
        $tuitions = \App\Models\HomeTuitionLead::whereNotIn('status', ['Confirmed', 'Cancelled', 'Closed'])->latest()->paginate(12);

        $appliedTuitionIds = \App\Models\TuitionApplication::where('candidate_id', auth()->id())
            ->pluck('home_tuition_lead_id')
            ->toArray();

        return view('parent.tuitions.index', compact('tuitions', 'appliedTuitionIds'));
    }

    public function apply(\Illuminate\Http\Request $request, $id)
    {
        $tuition = \App\Models\HomeTuitionLead::findOrFail($id);

        if (in_array($tuition->status, ['Confirmed', 'Cancelled', 'Closed'])) {
            return back()->with('error', 'This tuition is no longer active.');
        }

        $existingApplication = \App\Models\TuitionApplication::where('candidate_id', auth()->id())
            ->where('home_tuition_lead_id', $id)
            ->first();

        if ($existingApplication) {
            return back()->with('info', 'You have already applied to this tuition.');
        }

        \App\Models\TuitionApplication::create([
            'candidate_id' => auth()->id(),
            'home_tuition_lead_id' => $id,
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
            'name' => ['required', 'string', 'min:3', 'max:80', 'regex:/^[a-zA-Z\s\.\,\'\-]+$/'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'class' => ['required', 'string', 'min:1', 'max:50'],
            'board' => ['required', 'string', 'max:50'],
            'subjects' => ['required', 'string', 'min:2', 'max:200'],
            'location' => ['required', 'string', 'min:3', 'max:255'],
            'pincode' => ['nullable', 'regex:/^\d{6}$/'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.min' => 'Name must be at least 3 characters long.',
            'name.regex' => 'Name should only contain letters and spaces.',
            'phone.required' => 'Please enter your 10-digit mobile number.',
            'phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'class.required' => "Please enter student's class.",
            'board.required' => 'Please select an education board.',
            'subjects.required' => 'Please specify subjects needed.',
            'location.required' => 'Please enter location address.',
            'pincode.regex' => 'Pincode must be a 6-digit number.',
        ]);

        $locationWithPincode = $request->location;
        if (!empty($request->pincode)) {
            $locationWithPincode .= ' - Pincode: ' . $request->pincode;
        }

        \App\Models\HomeTuitionLead::create([
            'parent_name' => $request->name,
            'parent_mobile' => $request->phone,
            'class' => $request->class,
            'board' => $request->board,
            'subjects' => $request->subjects,
            'location' => $locationWithPincode,
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

    public function appointedTeachers()
    {
        $appointedLeads = \App\Models\HomeTuitionLead::where('user_id', auth()->id())
            ->where('is_finally_appointed', true)
            ->latest()
            ->get();

        return view('parent.tuitions.appointed_teachers', compact('appointedLeads'));
    }
}
