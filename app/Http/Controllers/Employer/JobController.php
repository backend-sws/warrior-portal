<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobPost;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Qualification;
use App\Models\State;
use App\Models\City;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPost::where('user_id', auth()->id())->latest()->paginate(10);
        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $qualifications = Qualification::where('is_active', true)->get();
        $states = State::where('is_active', true)->get();
        
        $profile = auth()->user()->employerProfile;

        return view('employer.jobs.create', compact('categories', 'subjects', 'qualifications', 'states', 'profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
            'jobs' => 'required|array|min:1',
            'jobs.*.title' => 'required|string|max:255',
            'jobs.*.description' => 'required|string',
            'jobs.*.category_id' => 'required|exists:categories,id',
            'jobs.*.subject_id' => 'required|exists:subjects,id',
            'jobs.*.specialization_name' => 'nullable|string|max:255',
            'jobs.*.specialization_id' => 'nullable|exists:specializations,id',
            'jobs.*.qualification_id' => 'required|exists:qualifications,id',
            'jobs.*.state_id' => 'required|exists:states,id',
            'jobs.*.city_id' => 'required|exists:cities,id',
            'jobs.*.salary_range' => 'nullable|string|max:255',
        ]);

        foreach ($request->jobs as $jobData) {
            JobPost::create([
                'user_id' => auth()->id(),
                'school_name' => $request->school_name,
                'contact_person' => $request->contact_person,
                'email' => $request->email,
                'phone' => $request->phone,
                'title' => $jobData['title'],
                'description' => $jobData['description'],
                'category_id' => $jobData['category_id'],
                'subject_id' => $jobData['subject_id'],
                'specialization_name' => $jobData['specialization_name'] ?? null,
                'specialization_id' => $jobData['specialization_id'] ?? null,
                'qualification_id' => $jobData['qualification_id'],
                'state_id' => $jobData['state_id'],
                'city_id' => $jobData['city_id'],
                'salary_range' => $jobData['salary_range'] ?? null,
                'status' => 'pending',
            ]);
        }

        // Notify Admin
        \App\Helpers\NotificationHelper::notifyAdmin(
            'New Job Posted',
            auth()->user()->name . ' has posted a new job vacancy.',
            route('admin.jobs.index'),
            'fas fa-briefcase'
        );

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully. It will be live once approved by admin.');
    }

    public function show($id)
    {
        $job = JobPost::where('user_id', auth()->id())->findOrFail($id);
        return view('employer.jobs.show', compact('job'));
    }

    public function edit($id)
    {
        $job = JobPost::where('user_id', auth()->id())->findOrFail($id);
        
        if ($job->status !== 'pending') {
            return redirect()->route('employer.jobs.index')->with('error', 'Only pending jobs can be edited.');
        }

        $categories = Category::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $specializations = $job->subject_id ? \App\Models\Specialization::where('subject_id', $job->subject_id)->where('is_active', true)->get() : collect();
        $qualifications = Qualification::where('is_active', true)->get();
        $states = State::where('is_active', true)->get();
        $cities = City::where('state_id', $job->state_id)->where('is_active', true)->get();

        return view('employer.jobs.edit', compact('job', 'categories', 'subjects', 'specializations', 'qualifications', 'states', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPost::where('user_id', auth()->id())->findOrFail($id);
        
        if ($job->status !== 'pending') {
            return redirect()->route('employer.jobs.index')->with('error', 'Only pending jobs can be edited.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subject_id' => 'required|exists:subjects,id',
            'specialization_name' => 'nullable|string|max:255',
            'specialization_id' => 'nullable|exists:specializations,id',
            'qualification_id' => 'required|exists:qualifications,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'salary_range' => 'nullable|string|max:255',
        ]);

        $job->update($request->only([
            'title', 'description', 'category_id', 'subject_id', 'specialization_name', 'specialization_id', 'qualification_id', 'state_id', 'city_id', 'salary_range'
        ]));

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy($id)
    {
        $job = JobPost::where('user_id', auth()->id())->findOrFail($id);
        $job->delete();
        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully.');
    }
}
