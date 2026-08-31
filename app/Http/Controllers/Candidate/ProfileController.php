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
        $request->validate([
            // Basic & Tuition Requirements
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'required|string',
            'preferred_state_id' => 'required|exists:states,id',
            'preferred_city_id' => 'required|exists:cities,id',
            'highest_qualification_id' => 'required|exists:qualifications,id',
            'subject_id' => 'nullable|exists:subjects,id',

            // School Job Requirements (Optional for 11th/12th home tutors, required when applying for school jobs)
            'category_id' => 'nullable|exists:categories,id',
            'experience_years' => 'nullable|integer|min:0',
            'current_salary' => 'nullable|string',
            'expected_salary' => 'nullable|string',
            'current_school' => 'nullable|string',
            'english_fluency' => 'nullable|in:beginner,intermediate,fluent',
            'residential_preference' => 'nullable|in:residential,day,both',
            'availability_to_join' => 'nullable|string',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:3072',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $profile->resume_path = $path;
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $profile->profile_photo_path = $path;
        }

        $profile->update(array_merge(
            $request->only([
                'date_of_birth',
                'gender',
                'address',
                'preferred_state_id',
                'preferred_city_id',
                'highest_qualification_id',
                'subject_id',
                'category_id',
                'experience_years',
                'current_salary',
                'expected_salary',
                'current_school',
                'english_fluency',
                'residential_preference',
                'availability_to_join',
            ]),
            [
                'is_profile_complete' => true,
            ]
        ));

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
