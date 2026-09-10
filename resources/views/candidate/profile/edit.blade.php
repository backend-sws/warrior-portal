@extends('layouts.app')

@section('content')
@include('candidate.partials.nav')

@php
    $activeCategory = $profile->candidate_category ?: 'both';
    $curQual = $profile->highest_qualification_name ?: ($profile->highestQualification?->name ?? '');
@endphp

<div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8" x-data="{
    activeCategory: '{{ old('candidate_category', $activeCategory) }}',
    teachingMode: '{{ old('teaching_mode', $profile->teaching_mode ?? 'Offline') }}',
    selectedTuitionSubjects: {{ json_encode(old('tuition_subjects', $profile->tuition_subjects ?? [])) }},
    selectedClasses: {{ json_encode(old('classes_interested', $profile->classes_interested ?? [])) }},
    selectedLocations: {{ json_encode(old('preferred_locations', $profile->preferred_locations ?? [])) }},
    toggleTuitionSubject(subj) {
        if (this.selectedTuitionSubjects.includes(subj)) {
            this.selectedTuitionSubjects = this.selectedTuitionSubjects.filter(s => s !== subj);
        } else {
            this.selectedTuitionSubjects.push(subj);
        }
    },
    toggleSelectedClass(cls) {
        if (this.selectedClasses.includes(cls)) {
            this.selectedClasses = this.selectedClasses.filter(c => c !== cls);
        } else {
            this.selectedClasses.push(cls);
        }
    },
    toggleLocation(loc) {
        if (this.selectedLocations.includes(loc)) {
            this.selectedLocations = this.selectedLocations.filter(l => l !== loc);
        } else {
            this.selectedLocations.push(loc);
        }
    }
}">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 reveal">
        <div class="flex items-center gap-4">
            @if($profile->profile_photo_path)
                <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="{{ $user->name }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover border-2 border-[#0ea5e9] shadow-lg shrink-0" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0ea5e9&color=fff';">
            @else
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-2xl sm:text-3xl shadow-inner shrink-0">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#031b4e] flex flex-wrap items-center gap-2">
                    My Educator Profile
                    <span x-show="activeCategory === 'home_tutor'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 text-xs font-black rounded-full border border-amber-200 shadow-2xs">
                        <i class="fas fa-chalkboard-teacher text-amber-600"></i> Home Tutor
                    </span>
                    <span x-show="activeCategory === 'school_job'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-800 text-xs font-black rounded-full border border-blue-200 shadow-2xs">
                        <i class="fas fa-school text-blue-600"></i> School Job
                    </span>
                    <span x-show="activeCategory === 'both'" class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-800 text-xs font-black rounded-full border border-purple-200 shadow-2xs">
                        <i class="fas fa-layer-group text-purple-600"></i> Both (Tutor & School)
                    </span>
                    @if($profile->is_verified)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                            <i class="fas fa-check-circle text-blue-600"></i> Verified
                        </span>
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    <span x-show="activeCategory === 'home_tutor'">Update your home tuition preferences, subjects, and contact details anytime.</span>
                    <span x-show="activeCategory === 'school_job'">Update your school teaching credentials, experience, and contact details anytime.</span>
                    <span x-show="activeCategory === 'both'">Update your profile, teaching preferences, subjects, and contact details anytime.</span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-600">Profile Completion:</span>
            <span class="px-3 py-1 rounded-full text-xs font-black {{ $profile->completion_percentage >= 80 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                {{ $profile->completion_percentage }}%
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 reveal shadow-xs">
            <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-center gap-3 reveal shadow-xs">
            <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl reveal shadow-xs">
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

            {{-- Teaching Role / Category Selector --}}
            <div class="p-6 md:p-8 border-b border-slate-100 bg-gradient-to-r from-slate-50 via-blue-50/20 to-slate-50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></span>
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Select Your Teaching Role / Category
                            </h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            Choose your desired role below. Your form fields and dashboard will adapt immediately to your selection.
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-blue-700 bg-blue-100/60 px-3 py-1 rounded-full border border-blue-200 self-start sm:self-auto">
                        <i class="fas fa-hand-pointer text-[10px]"></i> Click to Switch
                    </span>
                </div>

                {{-- Hidden input bound to Alpine activeCategory for form submission --}}
                <input type="hidden" name="candidate_category" :value="activeCategory">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                    {{-- Option 1: Home Tutor Only --}}
                    <div @click="activeCategory = 'home_tutor'" 
                         class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex items-start gap-3.5 select-none"
                         :class="activeCategory === 'home_tutor' 
                            ? 'bg-amber-50/70 border-amber-500 shadow-sm ring-2 ring-amber-500/20' 
                            : 'bg-white border-slate-200 hover:border-slate-300 hover:bg-slate-50/80'">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base shrink-0 transition-colors"
                             :class="activeCategory === 'home_tutor' ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-100 text-slate-500'">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800">Home Tutor</h4>
                                <i class="fas fa-check-circle text-amber-500 text-sm" x-show="activeCategory === 'home_tutor'"></i>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                Private home & online tuitions
                            </p>
                        </div>
                    </div>

                    {{-- Option 2: School Teacher Only --}}
                    <div @click="activeCategory = 'school_job'" 
                         class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex items-start gap-3.5 select-none"
                         :class="activeCategory === 'school_job' 
                            ? 'bg-blue-50/70 border-blue-600 shadow-sm ring-2 ring-blue-600/20' 
                            : 'bg-white border-slate-200 hover:border-slate-300 hover:bg-slate-50/80'">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base shrink-0 transition-colors"
                             :class="activeCategory === 'school_job' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-500'">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800">School Teacher</h4>
                                <i class="fas fa-check-circle text-blue-600 text-sm" x-show="activeCategory === 'school_job'"></i>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                School & college faculty jobs
                            </p>
                        </div>
                    </div>

                    {{-- Option 3: Both Categories --}}
                    <div @click="activeCategory = 'both'" 
                         class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all duration-200 flex items-start gap-3.5 select-none"
                         :class="activeCategory === 'both' 
                            ? 'bg-purple-50/70 border-purple-600 shadow-sm ring-2 ring-purple-600/20' 
                            : 'bg-white border-slate-200 hover:border-slate-300 hover:bg-slate-50/80'">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base shrink-0 transition-colors"
                             :class="activeCategory === 'both' ? 'bg-purple-600 text-white shadow-xs' : 'bg-slate-100 text-slate-500'">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800">Both Roles</h4>
                                <i class="fas fa-check-circle text-purple-600 text-sm" x-show="activeCategory === 'both'"></i>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">
                                Home tuitions + school jobs
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 1: Basic & Personal Information (Common) --}}
            <div class="p-6 md:p-8 border-b border-slate-100">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-blue-50 text-[#031b4e] flex items-center justify-center text-xs font-black border border-blue-100">1</span>
                        <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">Personal Information</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200">
                        Common Details
                    </span>
                </div>

                {{-- Profile Photo --}}
                <div class="mb-8 flex flex-col sm:flex-row items-center gap-5">
                    <div class="relative group shrink-0">
                        @if($profile->profile_photo_path)
                            <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="{{ $user->name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-slate-200 shadow-md" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0ea5e9&color=fff';">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl text-slate-400 border border-slate-200 shadow-inner">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
                            Profile Photo {{ $profile->profile_photo_path ? '(Update / Change)' : '' }}
                        </label>
                        <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-accent-blue/40 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">
                            <i class="fas fa-info-circle mr-1"></i> JPG, PNG, WEBP (Max 3MB). {{ $profile->profile_photo_path ? 'Leave blank to keep existing photo.' : '' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                    {{-- Full Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                        <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                        <input type="email" name="email" required value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                    </div>

                    {{-- Mobile Number --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mobile Number *</label>
                        <input type="tel" name="phone" required value="{{ old('phone', $user->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                    </div>

                    {{-- WhatsApp Number --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Number</label>
                        <input type="tel" name="whatsapp_no" value="{{ old('whatsapp_no', $profile->whatsapp_no ?: $user->whatsapp_no) }}" minlength="10" maxlength="15"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium"
                            placeholder="10-digit WhatsApp number">
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gender</label>
                        <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $profile->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $profile->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $profile->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    {{-- Highest Qualification (Manual entry with suggestion datalist) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Highest Qualification</label>
                        <input type="text" name="highest_qualification" list="qualification-suggestions" value="{{ old('highest_qualification', $curQual) }}"
                            placeholder="e.g. B.Tech, M.Sc Physics, B.Ed, M.A"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                        <datalist id="qualification-suggestions">
                            <option value="Graduate (B.A/B.Sc/B.Com/B.Tech)"></option>
                            <option value="Post Graduate (M.A/M.Sc/M.Com/M.Tech)"></option>
                            <option value="B.Ed"></option>
                            <option value="M.Ed"></option>
                            <option value="D.El.Ed"></option>
                            <option value="Ph.D. / Doctorate"></option>
                            <option value="CTET / STET Qualified"></option>
                            <option value="12th Pass / Undergraduate"></option>
                        </datalist>
                    </div>

                    {{-- Teaching Experience (Manual Input + Suggestions) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teaching Experience</label>
                        <input type="text" name="experience_range" list="experience-suggestions" value="{{ old('experience_range', $profile->experience_range) }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium"
                            placeholder="e.g. Fresher, 1–3 Years, 5+ Years">
                        <datalist id="experience-suggestions">
                            <option value="Fresher"></option>
                            <option value="0–1 Year"></option>
                            <option value="1–3 Years"></option>
                            <option value="3–5 Years"></option>
                            <option value="5–10 Years"></option>
                            <option value="10–15 Years"></option>
                            <option value="15+ Years"></option>
                        </datalist>
                    </div>

                    {{-- Address / Locality (Manual entry) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address / Locality</label>
                        <input type="text" name="address" value="{{ old('address', $profile->address) }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium"
                            placeholder="Residential address / Colony / City">
                    </div>
                </div>
            </div>

            {{-- Section 2: Home Tuition Preferences --}}
            <div x-show="activeCategory === 'home_tutor' || activeCategory === 'both'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="p-6 md:p-8 border-b border-slate-100 bg-amber-50/20 space-y-6">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs font-black">2</span>
                        <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">Home Tuition Preferences</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-amber-100 text-amber-900 border border-amber-300">
                        Home Tutor Details
                    </span>
                </div>

                {{-- Subjects Multi-select --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Subjects You Teach
                    </label>
                    @php
                        $tuitionSubjectsList = [
                            'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 
                            'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 
                            'Economics', 'Business Studies', 'Others'
                        ];
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach($tuitionSubjectsList as $subj)
                            <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-xs font-bold cursor-pointer transition-all select-none"
                                   :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-amber-400'">
                                <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}"
                                       :checked="selectedTuitionSubjects.includes('{{ $subj }}')"
                                       @change="toggleTuitionSubject('{{ $subj }}')"
                                       class="sr-only">
                                <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                <span>{{ $subj }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Classes Interested --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Classes Interested To Teach
                    </label>
                    @php
                        $classList = [
                            'Nursery – UKG', 'Class nur – 5', 'Class 5 – 8', 'Class 6-10', 
                            'Class 9 – 10', 'Class 11 – 12', 'IIT JEE', 'NEET', 'Graduation Level'
                        ];
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach($classList as $cls)
                            <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-xs font-bold cursor-pointer transition-all select-none"
                                   :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-blue-400'">
                                <input type="checkbox" name="classes_interested[]" value="{{ $cls }}"
                                       :checked="selectedClasses.includes('{{ $cls }}')"
                                       @change="toggleSelectedClass('{{ $cls }}')"
                                       class="sr-only">
                                <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                <span>{{ $cls }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    {{-- Teaching Mode --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teaching Mode</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(['Offline', 'Online', 'Both'] as $mode)
                                <label class="p-2.5 rounded-xl border text-center cursor-pointer transition-all select-none"
                                       :class="teachingMode === '{{ $mode }}' ? 'bg-amber-500 text-white border-amber-500 font-bold shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:border-amber-300'">
                                    <input type="radio" name="teaching_mode" value="{{ $mode }}" x-model="teachingMode" class="sr-only">
                                    <span class="text-xs">{{ $mode }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Available Time Slot --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Available Time Slot</label>
                        <input type="text" name="available_time_slot" value="{{ old('available_time_slot', $profile->available_time_slot) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/40 font-medium"
                            placeholder="e.g. Morning 6 AM – 9 AM, Evening 4 PM – 8 PM">
                    </div>

                    {{-- Preferred Areas --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Preferred Areas For Home Tuition</label>
                        <textarea name="preferred_areas" rows="2"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/40 font-medium"
                            placeholder="e.g. Kankarbagh, Boring Road, Danapur, Bailey Road">{{ old('preferred_areas', $profile->preferred_areas) }}</textarea>
                    </div>
                </div>
            </div>
            
            {{-- Section 3: School Job Details --}}
            <div x-show="activeCategory === 'school_job' || activeCategory === 'both'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="p-6 md:p-8 border-b border-slate-100 bg-blue-50/20 space-y-6">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black"
                              x-text="activeCategory === 'school_job' ? '2' : '3'">
                            {{ $activeCategory === 'school_job' ? '2' : '3' }}
                        </span>
                        <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">School Teaching & Employment Details</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-blue-100 text-blue-900 border border-blue-300">
                        School Job Credentials
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                    {{-- B.Ed Status (Manual Input + Suggestions) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">B.Ed Status</label>
                        <input type="text" name="b_ed_status" list="bed_status_suggestions" 
                            value="{{ old('b_ed_status', $profile->b_ed_status) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" 
                            placeholder="e.g. Yes, No, Pursuing">
                        <datalist id="bed_status_suggestions">
                            <option value="Yes"></option>
                            <option value="No"></option>
                            <option value="Pursuing"></option>
                            <option value="Completed"></option>
                        </datalist>
                    </div>

                    {{-- D.El.Ed Status (Manual Input + Suggestions) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">D.El.Ed Status</label>
                        <input type="text" name="d_el_ed_status" list="deled_status_suggestions" 
                            value="{{ old('d_el_ed_status', $profile->d_el_ed_status) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" 
                            placeholder="e.g. Yes, No, Pursuing">
                        <datalist id="deled_status_suggestions">
                            <option value="No"></option>
                            <option value="Yes"></option>
                            <option value="Pursuing"></option>
                            <option value="Completed"></option>
                        </datalist>
                    </div>

                    {{-- Subject Specialization (Manual Input + Suggestions) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subject Specialization</label>
                        <input type="text" name="subject_specialization" list="subject_specialization_suggestions" 
                            value="{{ old('subject_specialization', $profile->subject_specialization) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" 
                            placeholder="e.g. Mathematics, Biology, English...">
                        <datalist id="subject_specialization_suggestions">
                            <option value="Mathematics"></option>
                            <option value="English"></option>
                            <option value="Science"></option>
                            <option value="Physics"></option>
                            <option value="Chemistry"></option>
                            <option value="Biology"></option>
                            <option value="Hindi"></option>
                            <option value="SST"></option>
                            <option value="Social Science"></option>
                            <option value="Computer / IT"></option>
                            <option value="Commerce"></option>
                            <option value="Economics"></option>
                            <option value="Sanskrit"></option>
                            <option value="Physical Education"></option>
                            <option value="Art & Craft"></option>
                            <option value="Music"></option>
                        </datalist>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                    {{-- Position Applying For (Manual Input + Suggestions) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Position Applying For</label>
                        <input type="text" name="position_applying_for" list="position_suggestions" 
                            value="{{ old('position_applying_for', $profile->position_applying_for) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" 
                            placeholder="e.g. PRT, TGT, PGT, Mother Teacher...">
                        <datalist id="position_suggestions">
                            <option value="Mother Teacher"></option>
                            <option value="Pre-Primary / NTT"></option>
                            <option value="PRT (Primary Teacher)"></option>
                            <option value="TGT (Trained Graduate Teacher)"></option>
                            <option value="PGT (Post Graduate Teacher)"></option>
                            <option value="Academic Coordinator"></option>
                            <option value="Vice Principal"></option>
                            <option value="Principal"></option>
                            <option value="Receptionist"></option>
                            <option value="Accountant"></option>
                            <option value="Librarian"></option>
                            <option value="Counselor"></option>
                            <option value="Lab Assistant"></option>
                            <option value="Computer Operator"></option>
                            <option value="Hostel Warden"></option>
                            <option value="Office Executive"></option>
                            <option value="Administrative Staff"></option>
                        </datalist>
                    </div>

                    {{-- Current Salary --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Salary (₹)</label>
                        <input type="text" name="current_salary" value="{{ old('current_salary', $profile->current_salary) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" placeholder="e.g. 25000">
                    </div>

                    {{-- Expected Salary --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Expected Salary (₹)</label>
                        <input type="text" name="expected_salary" value="{{ old('expected_salary', $profile->expected_salary) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" placeholder="e.g. 35000">
                    </div>
                </div>

                {{-- Previous School Details --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                    {{-- Last School Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Last School Name</label>
                        <input type="text" name="last_school_name" value="{{ old('last_school_name', $profile->last_school_name) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" placeholder="e.g. DPS Patna">
                    </div>

                    {{-- Last Designation --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Last Designation</label>
                        <input type="text" name="last_designation" value="{{ old('last_designation', $profile->last_designation) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" placeholder="e.g. TGT Mathematics">
                    </div>

                    {{-- Last Drawn Salary --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Last Drawn Salary (₹)</label>
                        <input type="text" name="last_drawn_salary" value="{{ old('last_drawn_salary', $profile->last_drawn_salary) }}"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium" placeholder="e.g. 28000">
                    </div>
                </div>

                {{-- Preferred School Locations (Manual Entry + Quick Add) --}}
                @php
                    $currentSchoolLocs = is_array($profile->preferred_locations) 
                        ? implode(', ', $profile->preferred_locations) 
                        : ($profile->preferred_locations ?? '');
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Preferred School Locations & Areas
                        </label>
                        <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2.5 py-0.5 rounded-full">
                            Manual Type
                        </span>
                    </div>
                    <textarea name="preferred_locations_manual" id="school_preferred_locations_input" rows="2"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium"
                        placeholder="Type preferred cities/areas separated by comma (e.g. Patna, Hajipur, Muzaffarpur, Kankarbagh, Boring Road...)">{{ old('preferred_locations_manual', $currentSchoolLocs) }}</textarea>

                    {{-- Quick Add City Chips --}}
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        <span class="text-[11px] font-bold text-slate-500 mr-1">Quick Add:</span>
                        @php
                            $quickCities = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Supaul', 'Darbhanga', 'Gaya', 'Begusarai', 'Danapur', 'Ara', 'Purnea'];
                        @endphp
                        @foreach($quickCities as $city)
                            <button type="button"
                                    @click="
                                        let el = document.getElementById('school_preferred_locations_input');
                                        let current = el.value.trim();
                                        if (!current) {
                                            el.value = '{{ $city }}';
                                        } else if (!current.toLowerCase().includes('{{ strtolower($city) }}')) {
                                            el.value = current + ', {{ $city }}';
                                        }
                                    "
                                    class="text-[11px] font-bold bg-slate-50 hover:bg-blue-50 text-blue-700 hover:text-blue-800 border border-slate-200 hover:border-blue-300 px-2.5 py-1 rounded-lg transition-all cursor-pointer shadow-2xs flex items-center gap-1">
                                <i class="fas fa-plus text-[9px]"></i> {{ $city }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Document Uploads --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Resume (PDF / DOC)</label>
                        @if($profile->resume_path)
                            <div class="mb-2 p-2.5 bg-white border border-slate-200 rounded-xl flex items-center justify-between gap-3 text-xs">
                                <span class="font-bold text-emerald-700 flex items-center gap-1.5">
                                    <i class="fas fa-file-pdf text-red-500"></i> Current Resume Uploaded
                                </span>
                                <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="text-blue-600 font-black hover:underline">
                                    View File
                                </a>
                            </div>
                        @endif
                        <input type="file" name="resume" accept=".pdf,.doc,.docx"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Leave blank to keep existing resume.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Salary Slip (Optional)</label>
                        @if($profile->salary_slip_path)
                            <div class="mb-2 p-2.5 bg-white border border-slate-200 rounded-xl flex items-center justify-between gap-3 text-xs">
                                <span class="font-bold text-emerald-700 flex items-center gap-1.5">
                                    <i class="fas fa-file-invoice text-blue-500"></i> Current Salary Slip
                                </span>
                                <a href="{{ asset('storage/' . $profile->salary_slip_path) }}" target="_blank" class="text-blue-600 font-black hover:underline">
                                    View File
                                </a>
                            </div>
                        @endif
                        <input type="file" name="salary_slip" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Leave blank to keep existing slip.</p>
                    </div>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="p-6 md:p-8 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500 font-medium">
                    <i class="fas fa-info-circle text-blue-500 mr-1"></i> 
                    You can update any details anytime. Changes will be saved to your active profile immediately.
                </p>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-[#031b4e] hover:bg-[#021338] text-white font-extrabold rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm cursor-pointer">
                    <i class="fas fa-save"></i> Save Profile Details
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password Card --}}
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xl mt-8 reveal">
        <form action="{{ route('candidate.password.update') }}" method="POST">
            @csrf
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xs font-black border border-red-100"><i class="fas fa-lock"></i></span>
                    <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">Security & Password</h3>
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
                        <input type="password" name="new_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40" placeholder="Min. 8 characters">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40" placeholder="Re-enter password">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition-all shadow-md cursor-pointer">
                        Update Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
