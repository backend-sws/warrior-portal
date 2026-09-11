<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\State;
use App\Models\City;
use App\Models\Qualification;
use App\Models\Subject;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $qualifications = Qualification::where('is_active', true)->orderBy('id')->get();
        $states = State::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('state_id', $profile->preferred_state_id)->where('is_active', true)->orderBy('name')->get();

        // Check readiness
        $isTuitionProfileReady = !empty($profile->gender) 
            && !empty($profile->date_of_birth) 
            && !empty($profile->address) 
            && !empty($profile->preferred_state_id) 
            && !empty($profile->preferred_city_id) 
            && !empty($profile->highest_qualification_id);

        $isJobProfileReady = $isTuitionProfileReady 
            && !empty($profile->category_id) 
            && !empty($profile->resume_path);

        return view('candidate.profile.edit', compact(
            'user', 
            'profile', 
            'categories', 
            'subjects', 
            'qualifications', 
            'states', 
            'cities',
            'isTuitionProfileReady',
            'isJobProfileReady'
        ));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? $user->profile()->create([]);

        $request->validate([
            // User details
            'name'                      => 'required|string|max:255',
            'email'                     => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'                     => 'required|string|max:20|unique:users,phone,' . $user->id,
            'whatsapp_no'               => 'nullable|string|max:20',

            // Common Personal Details
            'candidate_category'        => 'nullable|in:home_tutor,school_job,both',
            'date_of_birth'             => 'nullable|date',
            'gender'                    => 'nullable|in:Male,Female,Other',
            'highest_qualification'     => 'nullable|string|max:150',
            'experience_range'          => 'nullable|string|max:50',
            'experience_years'          => 'nullable|integer|min:0',
            'address'                   => 'nullable|string',

            // Home Tuition Preferences
            'tuition_subjects'          => 'nullable|array',
            'classes_interested'        => 'nullable|array',
            'teaching_mode'             => 'nullable|in:Offline,Online,Both',
            'preferred_areas'           => 'nullable|string|max:1000',
            'available_time_slot'       => 'nullable|string|max:150',

            // School Job Preferences
            'b_ed_status'               => 'nullable|string|max:100',
            'd_el_ed_status'            => 'nullable|string|max:100',
            'subject_specialization'    => 'nullable|string|max:150',
            'position_applying_for'     => 'nullable|string|max:150',
            'current_salary'            => 'nullable|string|max:100',
            'expected_salary'           => 'nullable|string|max:100',
            'last_school_name'          => 'nullable|string|max:200',
            'last_designation'          => 'nullable|string|max:100',
            'last_drawn_salary'         => 'nullable|string|max:100',
            'preferred_locations'       => 'nullable',
            'preferred_locations_manual'=> 'nullable|string|max:1000',

            // Files
            'resume'                    => 'nullable|mimes:pdf,doc,docx|max:5120',
            'salary_slip'               => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'profile_photo'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // 1. Update User info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->filled('whatsapp_no')) {
            $user->whatsapp_no = $request->whatsapp_no;
        }
        $user->save();

        // 2. Update Profile info
        if ($request->filled('candidate_category')) {
            $profile->candidate_category = $request->candidate_category;
        }

        if ($request->filled('whatsapp_no')) {
            $profile->whatsapp_no = $request->whatsapp_no;
        }

        if ($request->has('date_of_birth')) {
            $profile->date_of_birth = $request->date_of_birth;
        }
        if ($request->has('gender')) {
            $profile->gender = $request->gender;
        }
        if ($request->has('highest_qualification')) {
            $profile->highest_qualification_name = $request->highest_qualification;
        }
        if ($request->has('experience_range')) {
            $profile->experience_range = $request->experience_range;
        }
        if ($request->has('address')) {
            $profile->address = $request->address;
        }
        if ($request->filled('latitude')) {
            $profile->latitude = $request->latitude;
        }
        if ($request->filled('longitude')) {
            $profile->longitude = $request->longitude;
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $profile->profile_photo_path = $path;
        }

        $activeCategory = $profile->candidate_category ?: 'both';

        // Home Tutor fields
        if (in_array($activeCategory, ['home_tutor', 'both'])) {
            $tuitionSubjs = (array) $request->input('tuition_subjects', []);
            if ($request->filled('manual_tuition_subjects')) {
                $manualSubs = array_filter(array_map('trim', explode(',', $request->input('manual_tuition_subjects'))));
                $tuitionSubjs = array_values(array_unique(array_merge($tuitionSubjs, $manualSubs)));
            }
            $profile->tuition_subjects = $tuitionSubjs;

            $classesInterested = (array) $request->input('classes_interested', []);
            if ($request->filled('manual_classes')) {
                $manualCls = array_filter(array_map('trim', explode(',', $request->input('manual_classes'))));
                $classesInterested = array_values(array_unique(array_merge($classesInterested, $manualCls)));
            }
            $profile->classes_interested = $classesInterested;

            $profile->teaching_mode = $request->input('teaching_mode');
            $profile->preferred_areas = $request->input('preferred_areas');
            $profile->available_time_slot = $request->input('available_time_slot');
        }

        // School Job fields
        if (in_array($activeCategory, ['school_job', 'both'])) {
            $profile->b_ed_status = $request->input('b_ed_status');
            $profile->d_el_ed_status = $request->input('d_el_ed_status');
            $profile->subject_specialization = $request->input('subject_specialization');
            $profile->position_applying_for = $request->input('position_applying_for');
            $profile->current_salary = $request->input('current_salary');
            $profile->expected_salary = $request->input('expected_salary');
            $profile->last_school_name = $request->input('last_school_name');
            $profile->last_designation = $request->input('last_designation');
            $profile->last_drawn_salary = $request->input('last_drawn_salary');

            if ($request->filled('preferred_locations_manual')) {
                $locParts = array_map('trim', explode(',', $request->input('preferred_locations_manual')));
                $profile->preferred_locations = array_values(array_filter($locParts));
            } elseif ($request->has('preferred_locations')) {
                $rawLocs = $request->input('preferred_locations');
                if (is_string($rawLocs)) {
                    $locParts = array_map('trim', explode(',', $rawLocs));
                    $profile->preferred_locations = array_values(array_filter($locParts));
                } else {
                    $profile->preferred_locations = (array) $rawLocs;
                }
            }

            if ($request->hasFile('resume')) {
                $path = $request->file('resume')->store('resumes', 'public');
                $profile->resume_path = $path;
            }
            if ($request->hasFile('salary_slip')) {
                $path = $request->file('salary_slip')->store('salary_slips', 'public');
                $profile->salary_slip_path = $path;
            }
        }

        $profile->is_profile_complete = true;
        $profile->profile_completion_percentage = $profile->completion_percentage;
        $profile->save();

        return redirect()->route('candidate.dashboard')->with('success', 'Profile details updated successfully! Welcome to your dashboard.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('password_error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return back()->with('password_success', 'Password updated successfully.');
    }
}
