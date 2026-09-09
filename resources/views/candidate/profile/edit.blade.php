@extends('layouts.app')

@section('content')
@include('candidate.partials.nav')

@php
    $activeCategory = $profile->candidate_category ?: 'both';
    $curQual = $profile->highest_qualification_name ?: ($profile->highestQualification?->name ?? '');
    $hasSavedSubjects = !empty($profile->tuition_subjects) && count($profile->tuition_subjects) > 0;
    $hasSavedClasses = !empty($profile->classes_interested) && count($profile->classes_interested) > 0;
    $hasSavedLocations = !empty($profile->preferred_locations) && count($profile->preferred_locations) > 0;
@endphp

<div class="max-w-5xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8" x-data="{
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
                <h1 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2">
                    My Educator Profile
                    @if($profile->is_verified)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-extrabold uppercase tracking-wider rounded-full">
                            <i class="fas fa-check-circle text-blue-600"></i> Verified
                        </span>
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    @if($activeCategory === 'home_tutor')
                        Manage your home tuition preferences, subjects, and verified details.
                    @elseif($activeCategory === 'school_job')
                        Manage your school teaching credentials, experience, and verified details.
                    @else
                        Manage your home tuition and school teaching preferences.
                    @endif
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

    @if($errors->any())
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

            {{-- Category Header (Locked to registered category) --}}
            <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="block text-[11px] font-black text-slate-500 uppercase tracking-wider mb-1.5">
                        Registered Teaching Category
                    </span>
                    <div class="flex flex-wrap items-center gap-2.5">
                        @if($activeCategory === 'home_tutor')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 text-white font-black text-sm shadow-xs">
                                <i class="fas fa-chalkboard-teacher text-base"></i> Home Tutor
                            </span>
                        @elseif($activeCategory === 'school_job')
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-black text-sm shadow-xs">
                                <i class="fas fa-school text-base"></i> School Job Candidate
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white font-black text-sm shadow-xs">
                                <i class="fas fa-layer-group text-base"></i> Both (Home Tutor + School Job)
                            </span>
                        @endif

                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-200/80 text-slate-700 text-xs font-bold border border-slate-300/60">
                            <i class="fas fa-lock text-[11px] text-slate-500"></i> Locked
                        </span>
                    </div>
                </div>
                <input type="hidden" name="candidate_category" value="{{ $activeCategory }}">
                <div class="text-left sm:text-right">
                    <p class="text-xs text-slate-500 font-medium">
                        <i class="fas fa-shield-alt text-emerald-500 mr-1"></i>
                        Details once saved are permanently locked for profile integrity.
                    </p>
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
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Profile Photo</label>
                        @if($profile->profile_photo_path)
                            <div class="flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-2 rounded-xl border border-emerald-200 w-fit">
                                <i class="fas fa-check-circle text-emerald-600"></i> Profile photo uploaded & saved
                            </div>
                        @else
                            <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-accent-blue/40 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <p class="text-[11px] text-slate-400 mt-1"><i class="fas fa-info-circle mr-1"></i> JPG, PNG, WEBP (Max 3MB).</p>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                    {{-- Full Name (Locked) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Full Name</label>
                            <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                        </div>
                        <input type="text" value="{{ $user->name }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 cursor-not-allowed font-medium">
                    </div>

                    {{-- Email (Locked) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Address</label>
                            <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                        </div>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 cursor-not-allowed font-medium">
                    </div>

                    {{-- Mobile Number (Locked) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Mobile Number</label>
                            <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                        </div>
                        <input type="text" value="{{ $user->phone }}" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 cursor-not-allowed font-medium">
                    </div>

                    {{-- WhatsApp Number --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">WhatsApp Number</label>
                            @if(!empty($profile->whatsapp_no) || !empty($user->whatsapp_no))
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if(!empty($profile->whatsapp_no) || !empty($user->whatsapp_no))
                            <input type="text" value="{{ $profile->whatsapp_no ?: $user->whatsapp_no }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                        @else
                            <input type="tel" name="whatsapp_no" value="{{ old('whatsapp_no') }}" minlength="10" maxlength="10"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium"
                                placeholder="10-digit WhatsApp number">
                        @endif
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Date of Birth</label>
                            @if(!empty($profile->date_of_birth))
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if(!empty($profile->date_of_birth))
                            <input type="text" value="{{ $profile->date_of_birth->format('d M, Y') }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                        @else
                            <input type="date" name="date_of_birth" required value="{{ old('date_of_birth') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                        @endif
                    </div>

                    {{-- Gender --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Gender</label>
                            @if(!empty($profile->gender))
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if(!empty($profile->gender))
                            <input type="text" value="{{ $profile->gender }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                        @else
                            <select name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        @endif
                    </div>

                    {{-- Highest Qualification --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Highest Qualification</label>
                            @if(!empty($curQual))
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if(!empty($curQual))
                            <input type="text" value="{{ $curQual }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                        @else
                            <select name="highest_qualification" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                                <option value="">Select Qualification</option>
                                @php
                                    $quals = ['Graduate (B.A/B.Sc/B.Com/B.Tech)', 'Post Graduate (M.A/M.Sc/M.Com/M.Tech)', 'B.Ed', 'M.Ed', 'D.El.Ed', 'Ph.D. / Doctorate', 'CTET / STET Qualified', '12th Pass / Undergraduate', 'Other'];
                                @endphp
                                @foreach($quals as $q)
                                    <option value="{{ $q }}" {{ old('highest_qualification') === $q ? 'selected' : '' }}>{{ $q }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- Teaching Experience --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Teaching Experience</label>
                            @if(!empty($profile->experience_range))
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if(!empty($profile->experience_range))
                            <input type="text" value="{{ $profile->experience_range }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                        @else
                            <select name="experience_range" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium">
                                <option value="">Select Experience</option>
                                @php
                                    $experiences = ['Fresher', '0–1 Year', '1–3 Years', '3–5 Years', '5–10 Years', '10–15 Years', '15+ Years'];
                                @endphp
                                @foreach($experiences as $exp)
                                    <option value="{{ $exp }}" {{ old('experience_range') === $exp ? 'selected' : '' }}>{{ $exp }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- Address / Locality --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Address / Locality</label>
                            @if(!empty($profile->address))
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if(!empty($profile->address))
                            <input type="text" value="{{ $profile->address }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 font-medium cursor-not-allowed">
                        @else
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 font-medium"
                                placeholder="Residential area">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Section 2: Home Tuition Preferences (Only if home_tutor or both) --}}
            @if(in_array($activeCategory, ['home_tutor', 'both']))
                <div class="p-6 md:p-8 border-b border-slate-100 bg-amber-50/20 space-y-6">
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
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Subjects You Teach
                            </label>
                            @if($hasSavedSubjects)
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>

                        @if($hasSavedSubjects)
                            <div class="flex flex-wrap gap-2">
                                @foreach($profile->tuition_subjects as $subj)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500 text-white text-xs font-bold shadow-2xs">
                                        <i class="fas fa-check text-[9px]"></i> {{ $subj }}
                                    </span>
                                @endforeach
                            </div>
                        @else
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
                        @endif
                    </div>

                    {{-- Classes Interested --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Classes Interested To Teach
                            </label>
                            @if($hasSavedClasses)
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>

                        @if($hasSavedClasses)
                            <div class="flex flex-wrap gap-2">
                                @foreach($profile->classes_interested as $cls)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-bold shadow-2xs">
                                        <i class="fas fa-check text-[9px]"></i> {{ $cls }}
                                    </span>
                                @endforeach
                            </div>
                        @else
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
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        {{-- Teaching Mode --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Teaching Mode</label>
                                @if(!empty($profile->teaching_mode))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->teaching_mode))
                                <div class="px-4 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 flex items-center gap-2">
                                    <i class="fas fa-chalkboard text-amber-600"></i> {{ $profile->teaching_mode }}
                                </div>
                            @else
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(['Offline', 'Online', 'Both'] as $mode)
                                        <label class="p-2.5 rounded-xl border text-center cursor-pointer transition-all"
                                               :class="teachingMode === '{{ $mode }}' ? 'bg-amber-500 text-white border-amber-500 font-bold' : 'bg-white text-slate-700 border-slate-200'">
                                            <input type="radio" name="teaching_mode" value="{{ $mode }}" x-model="teachingMode" class="sr-only">
                                            <span class="text-xs">{{ $mode }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Available Time Slot --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Available Time Slot</label>
                                @if(!empty($profile->available_time_slot))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->available_time_slot))
                                <input type="text" value="{{ $profile->available_time_slot }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <input type="text" name="available_time_slot" value="{{ old('available_time_slot') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/40"
                                    placeholder="e.g. Morning 6 AM – 9 AM">
                            @endif
                        </div>

                        {{-- Preferred Areas --}}
                        <div class="sm:col-span-2">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Preferred Areas For Home Tuition</label>
                                @if(!empty($profile->preferred_areas))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->preferred_areas))
                                <div class="p-3.5 bg-slate-100 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-600 font-medium">
                                    {{ $profile->preferred_areas }}
                                </div>
                            @else
                                <textarea name="preferred_areas" rows="2"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/40"
                                    placeholder="e.g. Kankarbagh, Boring Road, Danapur">{{ old('preferred_areas') }}</textarea>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Section 3: School Job Details (Only if school_job or both) --}}
            @if(in_array($activeCategory, ['school_job', 'both']))
                <div class="p-6 md:p-8 border-b border-slate-100 bg-blue-50/20 space-y-6">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-black">
                                {{ $activeCategory === 'school_job' ? '2' : '3' }}
                            </span>
                            <h3 class="text-base sm:text-lg font-bold text-[#031b4e]">School Teaching & Employment Details</h3>
                        </div>
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-blue-100 text-blue-900 border border-blue-300">
                            School Job Credentials
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                        {{-- B.Ed Status --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">B.Ed Status</label>
                                @if(!empty($profile->b_ed_status))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->b_ed_status))
                                <input type="text" value="{{ $profile->b_ed_status }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <select name="b_ed_status" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium">
                                    <option value="">Select Status</option>
                                    <option value="Yes" {{ old('b_ed_status') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('b_ed_status') === 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Pursuing" {{ old('b_ed_status') === 'Pursuing' ? 'selected' : '' }}>Pursuing</option>
                                </select>
                            @endif
                        </div>

                        {{-- D.El.Ed Status --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">D.El.Ed Status</label>
                                @if(!empty($profile->d_el_ed_status))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->d_el_ed_status))
                                <input type="text" value="{{ $profile->d_el_ed_status }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <select name="d_el_ed_status" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium">
                                    <option value="">Select Status</option>
                                    <option value="Yes" {{ old('d_el_ed_status') === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('d_el_ed_status') === 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Pursuing" {{ old('d_el_ed_status') === 'Pursuing' ? 'selected' : '' }}>Pursuing</option>
                                </select>
                            @endif
                        </div>

                        {{-- Subject Specialization --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Subject Specialization</label>
                                @if(!empty($profile->subject_specialization))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->subject_specialization))
                                <input type="text" value="{{ $profile->subject_specialization }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <select name="subject_specialization" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium">
                                    <option value="">Select Specialization</option>
                                    @php
                                        $specs = ['Mathematics', 'English', 'Science', 'Physics', 'Chemistry', 'Biology', 'Hindi', 'SST', 'Computer', 'Commerce', 'Others'];
                                    @endphp
                                    @foreach($specs as $spec)
                                        <option value="{{ $spec }}" {{ old('subject_specialization') === $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                        {{-- Position Applying For --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Position Applying For</label>
                                @if(!empty($profile->position_applying_for))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->position_applying_for))
                                <input type="text" value="{{ $profile->position_applying_for }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <select name="position_applying_for" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40 font-medium">
                                    <option value="">Select Position</option>
                                    <optgroup label="Teaching">
                                        @foreach(['Mother Teacher', 'PRT', 'TGT', 'PGT', 'Academic Coordinator', 'Vice Principal', 'Principal'] as $p)
                                            <option value="{{ $p }}" {{ old('position_applying_for') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Non-Teaching">
                                        @foreach(['Receptionist', 'Accountant', 'Librarian', 'Counselor', 'Lab Assistant', 'Computer Operator', 'Hostel Warden', 'Office Executive', 'Administrative Staff', 'Other'] as $p)
                                            <option value="{{ $p }}" {{ old('position_applying_for') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            @endif
                        </div>

                        {{-- Current Salary --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Current Salary (₹)</label>
                                @if(!empty($profile->current_salary))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->current_salary))
                                <input type="text" value="{{ $profile->current_salary }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <input type="text" name="current_salary" value="{{ old('current_salary') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40" placeholder="e.g. 25000">
                            @endif
                        </div>

                        {{-- Expected Salary --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Expected Salary (₹)</label>
                                @if(!empty($profile->expected_salary))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->expected_salary))
                                <input type="text" value="{{ $profile->expected_salary }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <input type="text" name="expected_salary" value="{{ old('expected_salary') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40" placeholder="e.g. 35000">
                            @endif
                        </div>
                    </div>

                    {{-- Previous School Details --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                        {{-- Last School Name --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Last School Name</label>
                                @if(!empty($profile->last_school_name))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->last_school_name))
                                <input type="text" value="{{ $profile->last_school_name }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <input type="text" name="last_school_name" value="{{ old('last_school_name') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40" placeholder="e.g. DPS Patna">
                            @endif
                        </div>

                        {{-- Last Designation --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Last Designation</label>
                                @if(!empty($profile->last_designation))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->last_designation))
                                <input type="text" value="{{ $profile->last_designation }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <input type="text" name="last_designation" value="{{ old('last_designation') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40" placeholder="e.g. TGT Mathematics">
                            @endif
                        </div>

                        {{-- Last Drawn Salary --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Last Drawn Salary (₹)</label>
                                @if(!empty($profile->last_drawn_salary))
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                                @endif
                            </div>
                            @if(!empty($profile->last_drawn_salary))
                                <input type="text" value="{{ $profile->last_drawn_salary }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-600 font-medium cursor-not-allowed">
                            @else
                                <input type="text" name="last_drawn_salary" value="{{ old('last_drawn_salary') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/40" placeholder="e.g. 28000">
                            @endif
                        </div>
                    </div>

                    {{-- Preferred School Locations --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Preferred School Locations
                            </label>
                            @if($hasSavedLocations)
                                <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Locked</span>
                            @endif
                        </div>
                        @if($hasSavedLocations)
                            <div class="flex flex-wrap gap-2">
                                @foreach($profile->preferred_locations as $loc)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-2xs">
                                        <i class="fas fa-check text-[9px]"></i> {{ $loc }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            @php
                                $locList = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Supaul', 'Darbhanga', 'Gaya', 'Begusarai', 'Other'];
                            @endphp
                            <div class="flex flex-wrap gap-2">
                                @foreach($locList as $loc)
                                    <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-xs font-bold cursor-pointer transition-all select-none"
                                           :class="selectedLocations.includes('{{ $loc }}') ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-indigo-400'">
                                        <input type="checkbox" name="preferred_locations[]" value="{{ $loc }}"
                                               :checked="selectedLocations.includes('{{ $loc }}')"
                                               @change="toggleLocation('{{ $loc }}')"
                                               class="sr-only">
                                        <i class="fas fa-check text-[9px]" x-show="selectedLocations.includes('{{ $loc }}')"></i>
                                        <span>{{ $loc }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Document Uploads --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 pt-2">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Resume (PDF / DOC)</label>
                                @if($profile->resume_path)
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Uploaded</span>
                                @endif
                            </div>
                            @if($profile->resume_path)
                                <div class="p-3 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between gap-3">
                                    <span class="text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                                        <i class="fas fa-file-pdf text-red-500"></i> Resume Uploaded & Saved
                                    </span>
                                    <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="text-xs text-blue-600 font-black hover:underline">
                                        View File
                                    </a>
                                </div>
                            @else
                                <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            @endif
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Salary Slip (Optional)</label>
                                @if($profile->salary_slip_path)
                                    <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-lock text-[9px] mr-0.5"></i>Uploaded</span>
                                @endif
                            </div>
                            @if($profile->salary_slip_path)
                                <div class="p-3 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between gap-3">
                                    <span class="text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                                        <i class="fas fa-file-invoice text-blue-500"></i> Slip Uploaded
                                    </span>
                                    <a href="{{ asset('storage/' . $profile->salary_slip_path) }}" target="_blank" class="text-xs text-blue-600 font-black hover:underline">
                                        View File
                                    </a>
                                </div>
                            @else
                                <input type="file" name="salary_slip" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 cursor-pointer">
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Save Button --}}
            <div class="p-6 md:p-8 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500 font-medium">
                    <i class="fas fa-info-circle mr-1"></i> 
                    Unsaved fields will be saved permanently upon submission.
                </p>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-[#031b4e] hover:bg-[#021338] text-white font-extrabold rounded-xl transition-all shadow-lg flex items-center justify-center gap-2 text-sm cursor-pointer">
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
