@extends('layouts.admin')

@section('title', 'Edit Candidate Profile')
@section('subtitle', 'Update candidate personal details, qualification, preferences, and documents.')

@section('actions')
    <a href="{{ route('admin.crm.show', $user->id) }}" class="px-5 py-2.5 bg-secondary-bg border border-card-border text-text-main hover:bg-card-bg rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> <span>Back to Profile</span>
    </a>
@endsection

@section('content')
<div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden" 
     x-data="{ category: '{{ old('candidate_category', $profile?->candidate_category ?: 'both') }}' }">
    <form action="{{ route('admin.crm.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm font-bold shadow-sm">
                <div class="flex items-center gap-2 mb-2 text-red-800">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul class="list-disc pl-5 font-normal text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Section 0: Candidate Category Selection --}}
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-4">
                <div class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center font-black text-sm">
                    <i class="fas fa-layer-group text-xs"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-text-main">Applied Category</h3>
                    <p class="text-xs text-text-dark/50">Determine whether candidate applies for Home Tuitions, School Teaching Jobs, or Both.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                {{-- Home Tutor Card --}}
                <label @click="category = 'home_tutor'" 
                       :class="category === 'home_tutor' ? 'border-emerald-500 bg-emerald-50/20 ring-2 ring-emerald-500/30' : 'border-card-border hover:border-emerald-300'"
                       class="relative flex items-center gap-3 p-4 rounded-2xl border cursor-pointer transition-all">
                    <input type="radio" name="candidate_category" value="home_tutor" x-model="category" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-black text-text-main">Home Tutor Only</span>
                        <span class="text-[11px] text-text-dark/50">Only Home Tuitions</span>
                    </div>
                </label>

                {{-- School Job Card --}}
                <label @click="category = 'school_job'" 
                       :class="category === 'school_job' ? 'border-indigo-500 bg-indigo-50/20 ring-2 ring-indigo-500/30' : 'border-card-border hover:border-indigo-300'"
                       class="relative flex items-center gap-3 p-4 rounded-2xl border cursor-pointer transition-all">
                    <input type="radio" name="candidate_category" value="school_job" x-model="category" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-school"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-black text-text-main">School Job Only</span>
                        <span class="text-[11px] text-text-dark/50">Only School Teaching</span>
                    </div>
                </label>

                {{-- Both Card --}}
                <label @click="category = 'both'" 
                       :class="category === 'both' ? 'border-purple-500 bg-purple-50/20 ring-2 ring-purple-500/30' : 'border-card-border hover:border-purple-300'"
                       class="relative flex items-center gap-3 p-4 rounded-2xl border cursor-pointer transition-all">
                    <input type="radio" name="candidate_category" value="both" x-model="category" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-black text-text-main">Both (School Job + Home Tuition)</span>
                        <span class="text-[11px] text-text-dark/50">School Job + Home Tuition</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Section 1: Account Setup -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-500/10 text-accent-blue flex items-center justify-center font-black text-sm">1</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Account & Contact Information</h3>
                    <p class="text-xs text-text-dark/50">Candidate login credentials and communications.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">WhatsApp Number</label>
                    <input type="text" name="whatsapp_no" value="{{ old('whatsapp_no', $user->whatsapp_no ?: ($profile?->whatsapp_no ?? $user->phone)) }}"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">New Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
            </div>
        </div>

        <!-- Section 2: Personal Details -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center font-black text-sm">2</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Personal Details</h3>
                    <p class="text-xs text-text-dark/50">Gender, birth date, and residential address.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $profile?->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $profile?->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $profile?->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile?->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}" required 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>
                <div class="md:col-span-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-text-dark/70 uppercase">Full Residential Address <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            @if($profile?->google_maps_url)
                                <a href="{{ $profile->google_maps_url }}" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-emerald-600 hover:text-white bg-emerald-500/10 hover:bg-emerald-600 border border-emerald-500/20 px-2.5 py-0.5 rounded-lg transition-all inline-flex items-center gap-1 shadow-2xs">
                                    <i class="fas fa-location-arrow text-[10px]"></i> View on Map
                                </a>
                            @endif
                            <button type="button" onclick="detectAdminCandidateGps()" class="text-xs font-bold text-accent-blue hover:text-white bg-accent-blue/10 hover:bg-accent-blue border border-accent-blue/20 px-2.5 py-0.5 rounded-lg transition-all inline-flex items-center gap-1 shadow-2xs cursor-pointer">
                                <i class="fas fa-crosshairs text-[10px]"></i> Use Live GPS
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="latitude" id="admin_cand_lat" value="{{ old('latitude', $profile?->latitude) }}">
                    <input type="hidden" name="longitude" id="admin_cand_lng" value="{{ old('longitude', $profile?->longitude) }}">
                    <textarea name="address" rows="2" required 
                              onfocus="detectAdminCandidateGps(true)"
                              class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">{{ old('address', $profile?->address) }}</textarea>
                    <div id="admin_cand_gps_badge" class="{{ old('latitude', $profile?->latitude) ? 'inline-flex' : 'hidden' }} mt-2 items-center gap-1.5 text-xs font-semibold text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-lg border border-emerald-500/20">
                        <i class="fas fa-map-pin"></i>
                        <span id="admin_cand_gps_text">GPS Attached: {{ old('latitude', $profile?->latitude) }}, {{ old('longitude', $profile?->longitude) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Professional & Teaching Info -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-black text-sm">3</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Highest Qualification & Experience</h3>
                    <p class="text-xs text-text-dark/50">Core education background and teaching experience.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Highest Qualification</label>
                    <select name="highest_qualification_id" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select from list</option>
                        @foreach($qualifications as $qual)
                            <option value="{{ $qual->id }}" {{ old('highest_qualification_id', $profile?->highest_qualification_id) == $qual->id ? 'selected' : '' }}>{{ $qual->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Qualification Name / Degree</label>
                    <input type="text" name="highest_qualification_name" value="{{ old('highest_qualification_name', $profile?->highest_qualification_name ?: ($profile?->highestQualification?->name ?? '')) }}" placeholder="e.g. M.Sc Physics / B.Tech / M.A"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Experience Range</label>
                    <select name="experience_range" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Range</option>
                        @foreach(['Fresher', '1-3 Years', '3-5 Years', '5-10 Years', '10+ Years'] as $expR)
                            <option value="{{ $expR }}" {{ old('experience_range', $profile?->experience_range) == $expR ? 'selected' : '' }}>{{ $expR }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Experience (Years Numeric)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $profile?->experience_years ?? 0) }}" min="0"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>
            </div>
        </div>

        {{-- Section 4: Home Tutor Preferences --}}
        <div x-show="category === 'home_tutor' || category === 'both'" class="border border-emerald-500/30 bg-emerald-50/10 rounded-2xl p-5 sm:p-6 space-y-6">
            <div class="flex items-center gap-3 border-b border-emerald-500/20 pb-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-700 flex items-center justify-center font-black text-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-emerald-900">Home Tutor Preferences</h3>
                    <p class="text-xs text-text-dark/60">Subjects, classes, tutoring modes, and preferred areas.</p>
                </div>
            </div>

            @php
                $savedTuitionSubjs = $profile?->tuition_subjects ?? [];
                if (!is_array($savedTuitionSubjs)) $savedTuitionSubjs = [];
                $popularTuitionSubjs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Science (1-10)', 'Social Science', 'Hindi', 'Computer Science / Coding', 'Commerce / Accounts', 'Economics'];

                $savedClasses = $profile?->classes_interested ?? [];
                if (!is_array($savedClasses)) $savedClasses = [];
                $classOptions = ['Pre-Primary', 'Class 1 to 5', 'Class 6 to 8', 'Class 9 to 10', 'Class 11 to 12', 'IIT-JEE', 'NEET', 'Olympiad', 'IIT-JEE / NEET Foundation'];
            @endphp

            {{-- Tuition Subjects Multi-Select --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase mb-2">Tuition Subjects Interested</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach($popularTuitionSubjs as $tSubj)
                        <label class="flex items-center gap-2 p-2 bg-card-bg border border-card-border rounded-xl text-xs text-text-main font-semibold cursor-pointer hover:bg-emerald-50/40">
                            <input type="checkbox" name="tuition_subjects[]" value="{{ $tSubj }}" 
                                   {{ in_array($tSubj, old('tuition_subjects', $savedTuitionSubjs)) ? 'checked' : '' }}
                                   class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span>{{ $tSubj }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-2.5 pt-2 border-t border-emerald-500/20 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <span class="text-[11px] font-bold text-emerald-800 whitespace-nowrap flex items-center gap-1">
                        <i class="fas fa-edit text-emerald-600"></i> Other / Manual Subjects:
                    </span>
                    <input type="text" name="manual_tuition_subjects" value="{{ old('manual_tuition_subjects') }}" placeholder="Type other subjects here (e.g. Sanskrit, French, Coding...)"
                           class="w-full bg-white border border-card-border rounded-xl px-3.5 py-1.5 text-xs text-text-main font-medium placeholder-text-dark/40 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
            </div>

            {{-- Classes Interested Multi-Select --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase mb-2">Classes / Levels Interested</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach($classOptions as $cOpt)
                        <label class="flex items-center gap-2 p-2 bg-card-bg border border-card-border rounded-xl text-xs text-text-main font-semibold cursor-pointer hover:bg-emerald-50/40">
                            <input type="checkbox" name="classes_interested[]" value="{{ $cOpt }}" 
                                   {{ in_array($cOpt, old('classes_interested', $savedClasses)) ? 'checked' : '' }}
                                   class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span>{{ $cOpt }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-2.5 pt-2 border-t border-emerald-500/20 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <span class="text-[11px] font-bold text-emerald-800 whitespace-nowrap flex items-center gap-1">
                        <i class="fas fa-edit text-emerald-600"></i> Other Classes / Exams:
                    </span>
                    <input type="text" name="manual_classes" value="{{ old('manual_classes') }}" placeholder="Type other classes / exams (e.g. NDA, CUET, Commerce Foundation...)"
                           class="w-full bg-white border border-card-border rounded-xl px-3.5 py-1.5 text-xs text-text-main font-medium placeholder-text-dark/40 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Teaching Mode</label>
                    <select name="teaching_mode" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option value="offline" {{ old('teaching_mode', $profile?->teaching_mode) === 'offline' ? 'selected' : '' }}>Offline (At Student's Home)</option>
                        <option value="online" {{ old('teaching_mode', $profile?->teaching_mode) === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="both" {{ old('teaching_mode', $profile?->teaching_mode) === 'both' ? 'selected' : '' }}>Both (Offline & Online)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Available Time Slot</label>
                    <select name="available_time_slot" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option value="Morning" {{ old('available_time_slot', $profile?->available_time_slot) === 'Morning' ? 'selected' : '' }}>Morning (6 AM - 10 AM)</option>
                        <option value="Afternoon" {{ old('available_time_slot', $profile?->available_time_slot) === 'Afternoon' ? 'selected' : '' }}>Afternoon (12 PM - 4 PM)</option>
                        <option value="Evening" {{ old('available_time_slot', $profile?->available_time_slot) === 'Evening' ? 'selected' : '' }}>Evening (4 PM - 8 PM)</option>
                        <option value="Flexible" {{ old('available_time_slot', $profile?->available_time_slot) === 'Flexible' ? 'selected' : '' }}>Flexible / Any Time</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred Home Tuition Areas</label>
                    <input type="text" name="preferred_areas" value="{{ old('preferred_areas', $profile?->preferred_areas) }}" placeholder="e.g. Kankarbagh, Boring Road, Bailey Road"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
            </div>
        </div>

        {{-- Section 5: School Job Application Details --}}
        <div x-show="category === 'school_job' || category === 'both'" class="border border-indigo-500/30 bg-indigo-50/10 rounded-2xl p-5 sm:p-6 space-y-6">
            <div class="flex items-center gap-3 border-b border-indigo-500/20 pb-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-700 flex items-center justify-center font-black text-sm">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-indigo-900">School Job Application Details</h3>
                    <p class="text-xs text-text-dark/60">Position, B.Ed / D.El.Ed credentials, previous school history, and salary.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Position Applying For</label>
                    <input type="text" name="position_applying_for" value="{{ old('position_applying_for', $profile?->position_applying_for) }}" placeholder="e.g. PRT, TGT, PGT Physics"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Subject / Specialization</label>
                    <input type="text" name="subject_specialization" value="{{ old('subject_specialization', $profile?->subject_specialization ?: ($profile?->subject?->name ?? '')) }}" placeholder="e.g. Mathematics, English"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">B.Ed Status</label>
                    <select name="b_ed_status" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                        <option value="No" {{ old('b_ed_status', $profile?->b_ed_status) === 'No' ? 'selected' : '' }}>Not Applicable / No</option>
                        <option value="Completed" {{ old('b_ed_status', $profile?->b_ed_status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pursuing" {{ old('b_ed_status', $profile?->b_ed_status) === 'Pursuing' ? 'selected' : '' }}>Pursuing / Appearing</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">D.El.Ed Status</label>
                    <select name="d_el_ed_status" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                        <option value="No" {{ old('d_el_ed_status', $profile?->d_el_ed_status) === 'No' ? 'selected' : '' }}>Not Applicable / No</option>
                        <option value="Completed" {{ old('d_el_ed_status', $profile?->d_el_ed_status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pursuing" {{ old('d_el_ed_status', $profile?->d_el_ed_status) === 'Pursuing' ? 'selected' : '' }}>Pursuing</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Last / Current School</label>
                    <input type="text" name="last_school_name" value="{{ old('last_school_name', $profile?->last_school_name ?: ($profile?->current_school ?? '')) }}" placeholder="e.g. DPS Patna"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Last Designation</label>
                    <input type="text" name="last_designation" value="{{ old('last_designation', $profile?->last_designation) }}" placeholder="e.g. Senior Teacher"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Last Drawn Salary (₹/mo)</label>
                    <input type="text" name="last_drawn_salary" value="{{ old('last_drawn_salary', $profile?->last_drawn_salary ?: ($profile?->current_salary ?? '')) }}" placeholder="e.g. 25,000"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Expected Salary (₹/mo)</label>
                    <input type="text" name="expected_salary" value="{{ old('expected_salary', $profile?->expected_salary) }}" placeholder="e.g. 35,000"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred State</label>
                    <select name="preferred_state_id" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('preferred_state_id', $profile?->preferred_state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred City</label>
                    <select name="preferred_city_id" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('preferred_city_id', $profile?->preferred_city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">School Preference</label>
                    <select name="residential_preference" class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                        <option value="day" {{ old('residential_preference', $profile?->residential_preference) == 'day' ? 'selected' : '' }}>Day School</option>
                        <option value="residential" {{ old('residential_preference', $profile?->residential_preference) == 'residential' ? 'selected' : '' }}>Residential / Boarding</option>
                        <option value="both" {{ old('residential_preference', $profile?->residential_preference) == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Availability to Join</label>
                    <input type="text" name="availability_to_join" value="{{ old('availability_to_join', $profile?->availability_to_join) }}" placeholder="e.g. Immediate / 15 Days"
                           class="w-full bg-card-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500">
                </div>
            </div>

            {{-- Preferred Locations Multi-Select --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase mb-2">Preferred School Job Locations</label>
                @php
                    $savedLocs = $profile?->preferred_locations ?? [];
                    if (!is_array($savedLocs)) $savedLocs = [];
                    $commonLocs = ['Patna', 'Ranchi', 'Gaya', 'Muzaffarpur', 'Bhagalpur', 'Darbhanga', 'Dhanbad', 'Jamshedpur', 'Bokaro', 'Delhi-NCR', 'Pan-India'];
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach($commonLocs as $locItem)
                        <label class="flex items-center gap-2 p-2 bg-card-bg border border-card-border rounded-xl text-xs text-text-main font-semibold cursor-pointer hover:bg-indigo-50/40">
                            <input type="checkbox" name="preferred_locations[]" value="{{ $locItem }}"
                                   {{ in_array($locItem, old('preferred_locations', $savedLocs)) ? 'checked' : '' }}
                                   class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span>{{ $locItem }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Section 6: Document Uploads -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-black text-sm">
                    <i class="fas fa-file-upload"></i>
                </div>
                <div>
                    <h3 class="text-base font-black text-text-main">Document Management</h3>
                    <p class="text-xs text-text-dark/50">Upload or replace candidate files.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                {{-- Resume --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Resume (PDF, DOCX)</span>
                        @if($profile?->resume_path)
                            <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" class="text-accent-blue text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-pdf text-2xl mb-1 text-accent-blue"></i>
                            <p class="file-name-display font-bold">Upload new Resume</p>
                        </div>
                    </div>
                </div>

                {{-- Profile Photo --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Profile Photo (JPG, PNG)</span>
                        @if($profile?->profile_photo_path)
                            <a href="{{ Storage::url($profile->profile_photo_path) }}" target="_blank" class="text-purple-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="profile_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-image text-2xl mb-1 text-purple-500"></i>
                            <p class="file-name-display font-bold">Upload new Photo</p>
                        </div>
                    </div>
                </div>

                {{-- ID Photo --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Government ID Card</span>
                        @if($profile?->live_photo_path)
                            <a href="{{ Storage::url($profile->live_photo_path) }}" target="_blank" class="text-emerald-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="live_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-id-card text-2xl mb-1 text-emerald-500"></i>
                            <p class="file-name-display font-bold">Upload new ID</p>
                        </div>
                    </div>
                </div>

                {{-- Salary Slip --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Salary Slip</span>
                        @if($profile?->salary_slip_path)
                            <a href="{{ Storage::url($profile->salary_slip_path) }}" target="_blank" class="text-amber-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="salary_slip" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-invoice-dollar text-2xl mb-1 text-amber-500"></i>
                            <p class="file-name-display font-bold">Upload new Slip</p>
                        </div>
                    </div>
                </div>

                {{-- Offer Letter --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Offer Letter</span>
                        @if($profile?->offer_letter_path)
                            <a href="{{ Storage::url($profile->offer_letter_path) }}" target="_blank" class="text-sky-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="offer_letter" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-contract text-2xl mb-1 text-sky-500"></i>
                            <p class="file-name-display font-bold">Upload new Letter</p>
                        </div>
                    </div>
                </div>

                {{-- Agreement PDF --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Signed Agreement Copy</span>
                        @if($profile?->agreement_pdf_path)
                            <a href="{{ Storage::url($profile->agreement_pdf_path) }}" target="_blank" class="text-emerald-600 text-xs hover:underline font-bold">View Current (PDF)</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-emerald-300 bg-emerald-50/20 rounded-2xl p-4 text-center hover:bg-emerald-50/40 transition-colors">
                        <input type="file" name="agreement_pdf" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-emerald-700 text-xs pointer-events-none">
                            <i class="fas fa-file-signature text-2xl mb-1 text-emerald-600"></i>
                            <p class="file-name-display font-bold">Upload new PDF</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-card-border flex flex-col sm:flex-row justify-end items-center gap-3">
            <a href="{{ route('admin.crm.show', $user->id) }}" class="w-full sm:w-auto px-6 py-3 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-dark/70 rounded-xl font-bold text-sm text-center transition-all">
                Cancel
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-accent-blue hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> <span>Update Candidate Profile</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stateSelect = document.querySelector('select[name="preferred_state_id"]');
        const citySelect = document.querySelector('select[name="preferred_city_id"]');
        const currentCityId = '{{ old("preferred_city_id", $profile?->preferred_city_id) }}';

        if (stateSelect && citySelect) {
            stateSelect.addEventListener('change', function() {
                const stateId = this.value;
                citySelect.innerHTML = '<option value="">Loading...</option>';
                
                if (stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Select City</option>';
                            data.forEach(city => {
                                const selected = (city.id == currentCityId) ? 'selected' : '';
                                citySelect.innerHTML += `<option value="${city.id}" ${selected}>${city.name}</option>`;
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

            if (stateSelect.value && !citySelect.value) {
                stateSelect.dispatchEvent(new Event('change'));
            }
        }

        // File inputs UI
        const fileInputs = document.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const wrapper = this.closest('.file-upload-wrapper');
                const nameDisplay = wrapper.querySelector('.file-name-display');
                const dropZone = this.closest('.border-dashed');
                
                if (this.files && this.files.length > 0) {
                    nameDisplay.textContent = this.files[0].name;
                    nameDisplay.classList.add('text-emerald-600');
                    dropZone.classList.add('border-emerald-500', 'bg-emerald-50/20');
                } else {
                    nameDisplay.textContent = 'Click to upload';
                    nameDisplay.classList.remove('text-emerald-600');
                    dropZone.classList.remove('border-emerald-500', 'bg-emerald-50/20');
                }
            });
        });
    });

    function detectAdminCandidateGps(silent = false) {
        if (typeof window.captureUserLiveLocation === 'function') {
            window.captureUserLiveLocation(silent, function(coords) {
                var lat = document.getElementById('admin_cand_lat');
                var lng = document.getElementById('admin_cand_lng');
                if (lat && lng) {
                    lat.value = coords.lat;
                    lng.value = coords.lng;
                }
                var badge = document.getElementById('admin_cand_gps_badge');
                var text = document.getElementById('admin_cand_gps_text');
                if (badge && text) {
                    text.textContent = 'GPS Attached (' + Number(coords.lat).toFixed(4) + ', ' + Number(coords.lng).toFixed(4) + ')';
                    badge.classList.remove('hidden');
                    badge.classList.add('inline-flex');
                }
            });
        }
    }

    window.addEventListener('gps-detected', function(e) {
        if (e.detail && e.detail.lat && e.detail.lng) {
            var lat = document.getElementById('admin_cand_lat');
            var lng = document.getElementById('admin_cand_lng');
            if (lat && lng) {
                lat.value = e.detail.lat;
                lng.value = e.detail.lng;
                var badge = document.getElementById('admin_cand_gps_badge');
                var text = document.getElementById('admin_cand_gps_text');
                if (badge && text) {
                    text.textContent = 'GPS Attached (' + Number(e.detail.lat).toFixed(4) + ', ' + Number(e.detail.lng).toFixed(4) + ')';
                    badge.classList.remove('hidden');
                    badge.classList.add('inline-flex');
                }
            }
        }
    });
</script>
@endpush
@endsection
