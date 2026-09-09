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
            // Common Personal Details
            'candidate_category'        => 'nullable|in:home_tutor,school_job,both',
            'date_of_birth'             => $profile->date_of_birth ? 'nullable|date' : 'required|date',
            'gender'                    => $profile->gender ? 'nullable|in:Male,Female,Other' : 'required|in:Male,Female,Other',
            'whatsapp_no'               => 'nullable|regex:/^[6-9]\d{9}$/',
            'highest_qualification'     => 'nullable|string|max:100',
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
            'b_ed_status'               => 'nullable|in:Yes,No,Pursuing',
            'd_el_ed_status'            => 'nullable|in:Yes,No,Pursuing',
            'subject_specialization'    => 'nullable|string|max:100',
            'position_applying_for'     => 'nullable|string|max:100',
            'current_salary'            => 'nullable|string',
            'expected_salary'           => 'nullable|string',
            'last_school_name'          => 'nullable|string|max:200',
            'last_designation'          => 'nullable|string|max:100',
            'last_drawn_salary'         => 'nullable|string|max:50',
            'preferred_locations'       => 'nullable|array',

            // Files
            'resume'                    => 'nullable|mimes:pdf,doc,docx|max:5120',
            'salary_slip'               => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'profile_photo'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Category is permanent once chosen
        if (empty($profile->candidate_category) && $request->filled('candidate_category')) {
            $profile->candidate_category = $request->candidate_category;
        }

        // WhatsApp: lock once saved
        if (empty($profile->whatsapp_no) && empty($user->whatsapp_no)) {
            if ($request->filled('whatsapp_no')) {
                $user->whatsapp_no = $request->whatsapp_no;
                $user->save();
                $profile->whatsapp_no = $request->whatsapp_no;
            }
        }

        // Only update fields that are NOT already saved (locked once saved)
        if (empty($profile->date_of_birth) && $request->filled('date_of_birth')) {
            $profile->date_of_birth = $request->date_of_birth;
        }
        if (empty($profile->gender) && $request->filled('gender')) {
            $profile->gender = $request->gender;
        }
        if (empty($profile->highest_qualification_name) && empty($profile->highest_qualification_id) && $request->filled('highest_qualification')) {
            $profile->highest_qualification_name = $request->highest_qualification;
        }
        if (empty($profile->experience_range) && $request->filled('experience_range')) {
            $profile->experience_range = $request->experience_range;
        }
        if (empty($profile->address) && $request->filled('address')) {
            $profile->address = $request->address;
        }

        if ($request->hasFile('profile_photo') && empty($profile->profile_photo_path)) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $profile->profile_photo_path = $path;
        }

        $activeCategory = $profile->candidate_category ?: 'both';

        // Home Tutor fields (only if category applies and field not yet saved)
        if (in_array($activeCategory, ['home_tutor', 'both'])) {
            if ((empty($profile->tuition_subjects) || count($profile->tuition_subjects) === 0) && $request->filled('tuition_subjects')) {
                $profile->tuition_subjects = $request->tuition_subjects;
            }
            if ((empty($profile->classes_interested) || count($profile->classes_interested) === 0) && $request->filled('classes_interested')) {
                $profile->classes_interested = $request->classes_interested;
            }
            if (empty($profile->teaching_mode) && $request->filled('teaching_mode')) {
                $profile->teaching_mode = $request->teaching_mode;
            }
            if (empty($profile->preferred_areas) && $request->filled('preferred_areas')) {
                $profile->preferred_areas = $request->preferred_areas;
            }
            if (empty($profile->available_time_slot) && $request->filled('available_time_slot')) {
                $profile->available_time_slot = $request->available_time_slot;
            }
        }

        // School Job fields (only if category applies and field not yet saved)
        if (in_array($activeCategory, ['school_job', 'both'])) {
            if (empty($profile->b_ed_status) && $request->filled('b_ed_status')) {
                $profile->b_ed_status = $request->b_ed_status;
            }
            if (empty($profile->d_el_ed_status) && $request->filled('d_el_ed_status')) {
                $profile->d_el_ed_status = $request->d_el_ed_status;
            }
            if (empty($profile->subject_specialization) && $request->filled('subject_specialization')) {
                $profile->subject_specialization = $request->subject_specialization;
            }
            if (empty($profile->position_applying_for) && $request->filled('position_applying_for')) {
                $profile->position_applying_for = $request->position_applying_for;
            }
            if (empty($profile->current_salary) && $request->filled('current_salary')) {
                $profile->current_salary = $request->current_salary;
            }
            if (empty($profile->expected_salary) && $request->filled('expected_salary')) {
                $profile->expected_salary = $request->expected_salary;
            }
            if (empty($profile->last_school_name) && $request->filled('last_school_name')) {
                $profile->last_school_name = $request->last_school_name;
            }
            if (empty($profile->last_designation) && $request->filled('last_designation')) {
                $profile->last_designation = $request->last_designation;
            }
            if (empty($profile->last_drawn_salary) && $request->filled('last_drawn_salary')) {
                $profile->last_drawn_salary = $request->last_drawn_salary;
            }
            if ((empty($profile->preferred_locations) || count($profile->preferred_locations) === 0) && $request->filled('preferred_locations')) {
                $profile->preferred_locations = $request->preferred_locations;
            }
            if ($request->hasFile('resume') && empty($profile->resume_path)) {
                $path = $request->file('resume')->store('resumes', 'public');
                $profile->resume_path = $path;
            }
            if ($request->hasFile('salary_slip') && empty($profile->salary_slip_path)) {
                $path = $request->file('salary_slip')->store('salary_slips', 'public');
                $profile->salary_slip_path = $path;
            }
        }

        $profile->is_profile_complete = true;
        $profile->profile_completion_percentage = $profile->completion_percentage;
        $profile->save();

        return redirect()->route('candidate.profile.edit')->with('success', 'Profile details updated successfully.');
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
