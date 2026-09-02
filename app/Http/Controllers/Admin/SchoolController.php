<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployerProfile;
use App\Models\SchoolFollowUp;
use App\Models\JobPost;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    /**
     * Display a listing of all schools & educational institutes.
     */
    public function index(Request $request)
    {
        $query = EmployerProfile::with(['user', 'state', 'city', 'jobs'])
            ->latest();

        // Search Filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('school_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('city', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status Filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Institution Type Filter
        if ($type = $request->input('institution_type')) {
            $query->where('institution_type', $type);
        }

        // State / City Filter
        if ($stateId = $request->input('state_id')) {
            $query->where('state_id', $stateId);
        }
        if ($cityId = $request->input('city_id')) {
            $query->where('city_id', $cityId);
        }

        $schools = $query->paginate(15)->withQueryString();

        // Statistics
        $baseQuery = EmployerProfile::query();
        $stats = [
            'total'       => (clone $baseQuery)->count(),
            'active'      => (clone $baseQuery)->where('status', 'Active Client')->count(),
            'leads'       => (clone $baseQuery)->where('status', 'Lead / Prospect')->count(),
            'in_talks'    => (clone $baseQuery)->where('status', 'In Discussion')->count(),
            'total_jobs'  => JobPost::count(),
            'active_jobs' => JobPost::where('status', 'approved')->count(),
        ];

        $states = State::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('admin.schools.index', compact('schools', 'stats', 'states', 'cities'));
    }

    /**
     * Show the form for creating a new school entry manually.
     */
    public function create()
    {
        $states = State::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $qualifications = Qualification::where('is_active', true)->orderBy('name')->get();

        return view('admin.schools.create', compact('states', 'categories', 'subjects', 'qualifications'));
    }

    /**
     * Store a newly created school entry in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_name'      => 'required|string|max:255',
            'contact_person'   => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'alt_phone'        => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string|max:500',
            'state_id'         => 'nullable|exists:states,id',
            'city_id'          => 'nullable|exists:cities,id',
            'board'            => 'nullable|string|max:100',
            'institution_type' => 'nullable|string|max:100',
            'website'          => 'nullable|string|max:255',
            'status'           => 'required|string|max:50',
            'notes'            => 'nullable|string',

            // Optional Initial Job Post Fields
            'has_vacancy'      => 'nullable|boolean',
            'job_title'        => 'required_if:has_vacancy,1|nullable|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'subject_id'       => 'nullable|exists:subjects,id',
            'specialization_name' => 'nullable|string|max:255',
            'specialization_id' => 'nullable|exists:specializations,id',
            'qualification_id' => 'nullable|exists:qualifications,id',
            'salary_range'     => 'nullable|string|max:100',
            'job_description'  => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
            $email = $request->email ?: ('school_' . $cleanPhone . '_' . time() . '@warriorseducare.com');

            // Find or create User with role employer
            $user = User::where('phone', $request->phone)
                ->orWhere('email', $email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name'              => $request->school_name,
                    'phone'             => $request->phone,
                    'email'             => $email,
                    'password'          => Hash::make('12345678'),
                    'role'              => 'employer',
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]);
            }

            // Create or update EmployerProfile
            $profile = EmployerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'school_name'      => $request->school_name,
                    'contact_person'   => $request->contact_person,
                    'phone'            => $request->phone,
                    'alt_phone'        => $request->alt_phone,
                    'email'            => $request->email,
                    'address'          => $request->address,
                    'state_id'         => $request->state_id,
                    'city_id'          => $request->city_id,
                    'board'            => $request->board,
                    'institution_type' => $request->institution_type ?: 'School',
                    'website'          => $request->website,
                    'status'           => $request->status,
                    'about'            => $request->notes,
                    'notes'            => $request->notes,
                ]
            );

            // If initial follow-up / note exists, log it
            if ($request->filled('notes')) {
                SchoolFollowUp::create([
                    'employer_profile_id' => $profile->id,
                    'user_id'             => $user->id,
                    'created_by'          => auth()->id(),
                    'note'                => 'Initial Entry: ' . $request->notes,
                    'status_changed_to'   => $request->status,
                    'next_follow_up_date' => $request->next_follow_up_date ?? null,
                ]);
            }

            // If initial Job Vacancy was submitted
            if ($request->has('has_vacancy') && $request->filled('job_title')) {
                JobPost::create([
                    'user_id'          => $user->id,
                    'title'            => $request->job_title,
                    'school_name'      => $request->school_name,
                    'category_id'      => $request->category_id,
                    'subject_id'       => $request->subject_id,
                    'specialization_name' => $request->specialization_name,
                    'specialization_id' => $request->specialization_id,
                    'qualification_id' => $request->qualification_id,
                    'state_id'         => $request->state_id,
                    'city_id'          => $request->city_id,
                    'salary_range'     => $request->salary_range,
                    'description'      => $request->job_description ?: 'Teacher required at ' . $request->school_name,
                    'status'           => 'approved',
                    'email'            => $request->email ?: $user->email,
                    'phone'            => $request->phone,
                ]);
            }

            return redirect()->route('admin.schools.show', $profile->id)
                ->with('success', "School/Institute '{$request->school_name}' recorded successfully!");
        });
    }

    /**
     * Display the specified school profile and CRM history.
     */
    public function show($id)
    {
        $school = EmployerProfile::with([
            'user',
            'state',
            'city',
            'followUps.admin',
            'jobs' => function ($q) {
                $q->with(['category', 'subject', 'qualification', 'city'])
                  ->withCount('applications')
                  ->latest();
            }
        ])->findOrFail($id);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $qualifications = Qualification::where('is_active', true)->orderBy('name')->get();
        $states = State::where('is_active', true)->orderBy('name')->get();

        return view('admin.schools.show', compact('school', 'categories', 'subjects', 'qualifications', 'states'));
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit($id)
    {
        $school = EmployerProfile::with(['user', 'state', 'city'])->findOrFail($id);
        $states = State::where('is_active', true)->orderBy('name')->get();
        $cities = $school->state_id ? City::where('state_id', $school->state_id)->where('is_active', true)->get() : [];

        return view('admin.schools.edit', compact('school', 'states', 'cities'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, $id)
    {
        $school = EmployerProfile::with('user')->findOrFail($id);

        $request->validate([
            'school_name'      => 'required|string|max:255',
            'contact_person'   => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'alt_phone'        => 'nullable|string|max:20',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string|max:500',
            'state_id'         => 'nullable|exists:states,id',
            'city_id'          => 'nullable|exists:cities,id',
            'board'            => 'nullable|string|max:100',
            'institution_type' => 'nullable|string|max:100',
            'website'          => 'nullable|string|max:255',
            'status'           => 'required|string|max:50',
            'notes'            => 'nullable|string',
        ]);

        $oldStatus = $school->status;

        $school->update([
            'school_name'      => $request->school_name,
            'contact_person'   => $request->contact_person,
            'phone'            => $request->phone,
            'alt_phone'        => $request->alt_phone,
            'email'            => $request->email,
            'address'          => $request->address,
            'state_id'         => $request->state_id,
            'city_id'          => $request->city_id,
            'board'            => $request->board,
            'institution_type' => $request->institution_type ?: 'School',
            'website'          => $request->website,
            'status'           => $request->status,
            'notes'            => $request->notes,
        ]);

        if ($school->user) {
            $school->user->update([
                'name'  => $request->school_name,
                'phone' => $request->phone,
                'email' => $request->email ?: $school->user->email,
            ]);
        }

        // If status changed, log a follow up automatically
        if ($oldStatus !== $request->status) {
            SchoolFollowUp::create([
                'employer_profile_id' => $school->id,
                'user_id'             => $school->user_id,
                'created_by'          => auth()->id(),
                'note'                => "Status updated from '{$oldStatus}' to '{$request->status}'",
                'status_changed_to'   => $request->status,
            ]);
        }

        return redirect()->route('admin.schools.show', $school->id)
            ->with('success', "School record updated successfully.");
    }

    /**
     * Add a follow-up communication / call log for the school.
     */
    public function addFollowUp(Request $request, $id)
    {
        $school = EmployerProfile::findOrFail($id);

        $request->validate([
            'note'                => 'required|string|max:1000',
            'next_follow_up_date' => 'nullable|date',
            'status_changed_to'   => 'nullable|string|max:50',
        ]);

        SchoolFollowUp::create([
            'employer_profile_id' => $school->id,
            'user_id'             => $school->user_id,
            'created_by'          => auth()->id(),
            'note'                => $request->note,
            'status_changed_to'   => $request->status_changed_to ?: $school->status,
            'next_follow_up_date' => $request->next_follow_up_date,
        ]);

        if ($request->filled('status_changed_to') && $request->status_changed_to !== $school->status) {
            $school->update(['status' => $request->status_changed_to]);
        }

        return back()->with('success', 'Follow-up note logged successfully!');
    }

    /**
     * Post a new job vacancy directly for this school.
     */
    public function storeJob(Request $request, $id)
    {
        $school = EmployerProfile::with('user')->findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'subject_id'       => 'required|exists:subjects,id',
            'specialization_name' => 'nullable|string|max:255',
            'specialization_id' => 'nullable|exists:specializations,id',
            'qualification_id' => 'required|exists:qualifications,id',
            'state_id'         => 'required|exists:states,id',
            'city_id'          => 'required|exists:cities,id',
            'salary_range'     => 'nullable|string|max:100',
            'description'      => 'nullable|string',
        ]);

        JobPost::create([
            'user_id'          => $school->user_id,
            'title'            => $request->title,
            'school_name'      => $school->school_name,
            'category_id'      => $request->category_id,
            'subject_id'       => $request->subject_id,
            'specialization_name' => $request->specialization_name,
            'specialization_id' => $request->specialization_id,
            'qualification_id' => $request->qualification_id,
            'state_id'         => $request->state_id,
            'city_id'          => $request->city_id,
            'salary_range'     => $request->salary_range,
            'description'      => $request->description ?: 'Vacancy for ' . $request->title . ' at ' . $school->school_name,
            'status'           => 'approved',
            'email'            => $school->email ?: ($school->user?->email ?? 'hr@school.com'),
            'phone'            => $school->phone ?: ($school->user?->phone ?? 'N/A'),
        ]);

        return back()->with('success', "New job vacancy '{$request->title}' published for {$school->school_name}!");
    }

    /**
     * Remove the specified school record.
     */
    public function destroy($id)
    {
        $school = EmployerProfile::with('user')->findOrFail($id);
        $name = $school->school_name;

        if ($school->user) {
            $school->user->delete();
        } else {
            $school->delete();
        }

        return redirect()->route('admin.schools.index')
            ->with('success', "School '{$name}' deleted successfully.");
    }
}
