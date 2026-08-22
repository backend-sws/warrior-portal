@extends('layouts.app')

@section('content')
@include('candidate.partials.nav')

<div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 reveal">
        <div class="flex items-center gap-4">
            @if($profile->profile_photo_path)
                <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="Profile Photo" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover border-2 border-[#0ea5e9] shadow-lg shrink-0">
            @else
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-2xl sm:text-3xl shadow-inner shrink-0">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2">
                    My Profile
                    @if($profile->is_verified)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                            <i class="fas fa-check-circle text-blue-600"></i> Verified Educator
                        </span>
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Manage your personal, tuition, and school teaching credentials.</p>
            </div>
        </div>
    </div>

    {{-- Profile Readiness Cards (Tuition vs School Jobs) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        {{-- Card 1: Home Tuition Status --}}
        <div class="p-5 rounded-2xl border transition-all {{ $isTuitionProfileReady ? 'bg-emerald-50/80 border-emerald-200' : 'bg-amber-50/80 border-amber-200' }}">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-home {{ $isTuitionProfileReady ? 'text-emerald-600' : 'text-amber-600' }}"></i>
                    <h3 class="text-sm font-bold text-[#031b4e]">Home Tuition Eligibility</h3>
                </div>
                @if($isTuitionProfileReady)
                    <span class="text-[10px] font-extrabold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-check-circle"></i> Ready to Apply
                    </span>
                @else
                    <span class="text-[10px] font-extrabold bg-amber-200/70 text-amber-900 px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-exclamation-triangle"></i> Incomplete
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-600 leading-relaxed">
                Requires: <strong>DOB, Gender, City, Address, Qualification & Subject</strong>. 
                <br><span class="text-[11px] text-slate-500 font-medium">(11th/12th students & undergraduates can also complete this and teach tuitions!)</span>
            </p>
        </div>

        {{-- Card 2: School Jobs Status --}}
        <div class="p-5 rounded-2xl border transition-all {{ $isJobProfileReady ? 'bg-emerald-50/80 border-emerald-200' : 'bg-purple-50/80 border-purple-200' }}">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-school {{ $isJobProfileReady ? 'text-emerald-600' : 'text-purple-600' }}"></i>
                    <h3 class="text-sm font-bold text-[#031b4e]">School Teaching Jobs Eligibility</h3>
                </div>
                @if($isJobProfileReady)
                    <span class="text-[10px] font-extrabold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-check-circle"></i> Ready to Apply
                    </span>
                @else
                    <span class="text-[10px] font-extrabold bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full">
                        <i class="fas fa-exclamation-triangle"></i> Requires Resume & Category
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-600 leading-relaxed">
                Requires: <strong>Teaching Category (PRT/TGT/PGT), Experience & Resume Upload</strong> in addition to basic info.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 reveal">
            <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-center gap-3 reveal">
            <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl reveal">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                <div>
                    <p class="text-sm font-bold mb-1">Please correct the following errors:</p>
                    <ul class="text-xs text-red-700 list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Profile Form --}}
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xl reveal">
        <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Section 1: Basic & Personal Information --}}
            <div class="p-6 md:p-8 border-b border-slate-100">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-blue-50 text-[#031b4e] flex items-center justify-center text-xs font-black border border-blue-100">1</span>
                        <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">Personal Information</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200">
                        Required for Tuitions & Jobs
                    </span>
                </div>

                <div class="mb-8 flex flex-col sm:flex-row items-center gap-5">
                    <div class="relative group shrink-0">
                        @if($profile->profile_photo_path)
                            <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="Profile Photo" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-md">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl text-slate-400 border border-slate-200 shadow-inner">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Profile Photo</label>
                        <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-accent-blue/40 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1"><i class="fas fa-info-circle mr-1"></i> JPG, PNG, WEBP (Max 3MB).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Full Name</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user text-sm"></i></span>
                            <input type="text" value="{{ $user->name }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-500 cursor-not-allowed font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-500 cursor-not-allowed font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Phone Number</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-sm"></i></span>
                            <input type="text" value="{{ $user->phone }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-500 cursor-not-allowed font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Date of Birth <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-calendar-alt text-sm"></i></span>
                            <input type="date" name="date_of_birth" required value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Gender <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-venus-mars text-sm"></i></span>
                            <select name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $profile->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $profile->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $profile->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Preferred State <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-map text-sm"></i></span>
                            <select name="preferred_state_id" id="preferred_state_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ old('preferred_state_id', $profile->preferred_state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Preferred City <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-city text-sm"></i></span>
                            <select name="preferred_city_id" id="preferred_city_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('preferred_city_id', $profile->preferred_city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Full Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-400"><i class="fas fa-map-marker-alt text-sm"></i></span>
                            <textarea name="address" required rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 resize-none" placeholder="Enter complete residential address with area/locality">{{ old('address', $profile->address) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Educational & Teaching Subject --}}
            <div class="p-6 md:p-8 border-b border-slate-100">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xs font-black border border-amber-200">2</span>
                        <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">Academic & Subject Expertise</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200">
                        Required for Tuitions & Jobs
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                            Current Qualification / Education <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-graduation-cap text-sm"></i></span>
                            <select name="highest_qualification_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select Qualification (e.g. 12th, B.Sc, B.Ed)</option>
                                @foreach($qualifications as $qualification)
                                    <option value="{{ $qualification->id }}" {{ old('highest_qualification_id', $profile->highest_qualification_id) == $qualification->id ? 'selected' : '' }}>{{ $qualification->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">11th/12th students can select <em>Class 12th / Intermediate</em>.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                            Primary Subject You Teach <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-book text-sm"></i></span>
                            <select name="subject_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select Primary Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $profile->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: School Jobs & Professional Teaching Details --}}
            <div class="p-6 md:p-8 bg-slate-50/40">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xs font-black border border-purple-200">3</span>
                        <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">School Teaching Details</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-purple-100 text-purple-800 border border-purple-200">
                        Required for School Jobs
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Job Category</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-layer-group text-sm"></i></span>
                            <select name="category_id" class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select Category (e.g. PRT, TGT, PGT)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $profile->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Teaching Experience (Years)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-briefcase text-sm"></i></span>
                            <input type="number" name="experience_years" min="0" value="{{ old('experience_years', $profile->experience_years ?? 0) }}"
                                class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-accent-blue/40"
                                placeholder="0 for freshers">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Upload Resume / CV <span class="text-[10px] text-slate-400">(PDF, DOC)</span></label>
                        <div class="relative">
                            <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-accent-blue/40 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer">
                        </div>
                        @if($profile->resume_path)
                            <p class="text-[11px] text-emerald-600 mt-1.5 flex items-center gap-1 font-bold"><i class="fas fa-check-circle"></i> Resume uploaded. Upload new to replace.</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Expected Salary</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-rupee-sign text-sm"></i></span>
                            <input type="text" name="expected_salary" value="{{ old('expected_salary', $profile->expected_salary) }}" placeholder="e.g. ₹25,000 - ₹35,000 / month"
                                class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Current / Previous School <span class="text-[10px] text-slate-400">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-school text-sm"></i></span>
                            <input type="text" name="current_school" value="{{ old('current_school', $profile->current_school) }}" placeholder="e.g. DAV Public School"
                                class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">English Fluency</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-language text-sm"></i></span>
                            <select name="english_fluency" class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                                <option value="">Select Fluency</option>
                                <option value="beginner" {{ old('english_fluency', $profile->english_fluency) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('english_fluency', $profile->english_fluency) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="fluent" {{ old('english_fluency', $profile->english_fluency) == 'fluent' ? 'selected' : '' }}>Fluent / Native</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="p-6 md:p-8 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500 font-medium"><i class="fas fa-info-circle mr-1"></i> Make sure to save changes after updating details.</p>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-[#031b4e] hover:bg-[#021338] text-white font-extrabold rounded-xl transition-all shadow-lg flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-save"></i> Save Profile Details
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password Section --}}
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xl mt-8 reveal">
        <form action="{{ route('candidate.password.update') }}" method="POST">
            @csrf
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xs font-black border border-red-100"><i class="fas fa-lock"></i></span>
                    <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">Change Password</h3>
                </div>

                @if(session('password_success'))
                    <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 text-xs sm:text-sm font-bold">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                        <span>{{ session('password_success') }}</span>
                    </div>
                @endif

                @if(session('password_error'))
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-center gap-3 text-xs sm:text-sm font-bold">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                        <span>{{ session('password_error') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Current Password</label>
                        <input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">New Password</label>
                        <input type="password" name="new_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40" placeholder="••••••••">
                    </div>
                </div>
            </div>
            <div class="p-6 md:p-8 pt-0 flex justify-end">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-red-500/10 text-red-600 border border-red-500/20 font-bold rounded-xl hover:bg-red-500/20 transition-all text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-key text-xs"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('preferred_state_id').addEventListener('change', function() {
        let stateId = this.value;
        let citySelect = document.getElementById('preferred_city_id');
        citySelect.innerHTML = '<option value="">Loading...</option>';
        
        if(stateId) {
            fetch(`/api/states/${stateId}/cities`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                    citySelect.innerHTML = '<option value="">Select City</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">Select City</option>';
        }
    });
</script>
@endpush
