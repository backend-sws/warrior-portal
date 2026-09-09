@extends('layouts.admin')

@section('title')
    Candidate CRM: {{ $candidate->name }}
    @if($candidate->profile && $candidate->profile->is_verified)
        <span class="ml-2 inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 bg-blue-500/10 text-accent-blue rounded-full border border-accent-blue/20">
            <i class="fas fa-check-circle"></i> Verified
        </span>
    @endif
@endsection

@section('subtitle', 'Detailed candidate profile, school job tracking, home tuition mappings, and payment invoices.')

@section('actions')
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.crm.index') }}" class="px-4 py-2 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-main rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-arrow-left"></i> <span>Back</span>
        </a>

        <form action="{{ route('admin.crm.candidate.verify', $candidate->id) }}" method="POST" class="inline">
            @csrf
            @if($candidate->profile && $candidate->profile->is_verified)
                <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="fas fa-times-circle"></i> <span>Revoke Verification</span>
                </button>
            @else
                <button type="submit" class="px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="fas fa-check-circle"></i> <span>Verify Profile</span>
                </button>
            @endif
        </form>

        <a href="{{ route('admin.crm.edit', $candidate->id) }}" class="px-4 py-2 bg-accent-blue hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-edit"></i> <span>Edit Profile</span>
        </a>

        <a href="{{ route('admin.crm.candidate.magic-login', $candidate->id) }}" target="_blank" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition-all flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-sign-in-alt"></i> <span>Candidate Portal</span>
        </a>
    </div>
@endsection

@section('content')

@if(session('success'))
    <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-5 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
        <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

@php
    $catSlug = $profile?->candidate_category ?: 'both';
    $pct = $profile?->completion_percentage ?? 0;
    $missingFields = $profile?->missing_profile_fields ?? [];
@endphp

{{-- Top Readiness & Agreement Status Strip --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    {{-- School Jobs Readiness --}}
    <div class="bg-card-bg border {{ $isJobReady ? 'border-indigo-500/40 bg-indigo-50/10' : 'border-amber-500/40 bg-amber-50/10' }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ $isJobReady ? 'bg-indigo-500/10 text-indigo-600' : 'bg-amber-500/10 text-amber-600' }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-school"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">School Hiring Readiness</p>
            <h4 class="text-sm font-black {{ $isJobReady ? 'text-indigo-600' : 'text-amber-600' }}">
                @if(!$profile?->appliesForSchoolJob())
                    <span class="text-text-dark/50">Not Applied</span>
                @elseif($isJobReady)
                    Ready for Schools
                @else
                    Incomplete Profile
                @endif
            </h4>
        </div>
    </div>

    {{-- Home Tuitions Readiness --}}
    <div class="bg-card-bg border {{ ($pct >= 80 && $isTuitionReady) ? 'border-emerald-500/40 bg-emerald-50/10' : 'border-amber-500/40 bg-amber-50/10' }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ ($pct >= 80 && $isTuitionReady) ? 'bg-emerald-500/10 text-emerald-600' : 'bg-amber-500/10 text-amber-600' }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Home Tuition Readiness</p>
            <h4 class="text-sm font-black {{ ($pct >= 80 && $isTuitionReady) ? 'text-emerald-600' : 'text-amber-600' }}">
                @if(!$profile?->appliesForHomeTuition())
                    <span class="text-text-dark/50">Not Applied</span>
                @elseif($pct < 80)
                    Leads Locked (&lt;80%)
                @elseif($isTuitionReady)
                    Ready & Unlocked
                @else
                    Missing Details
                @endif
            </h4>
        </div>
    </div>

    {{-- School Job Agreement --}}
    <div class="bg-card-bg border {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'border-blue-500/40 bg-blue-50/10' : ($catSlug === 'home_tutor' ? 'border-card-border bg-card-bg opacity-70' : 'border-red-500/40 bg-red-50/10') }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'bg-blue-500/10 text-blue-600' : ($catSlug === 'home_tutor' ? 'bg-slate-100 text-slate-400' : 'bg-red-500/10 text-red-500') }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-file-contract"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Job Service Agreement</p>
            <h4 class="text-sm font-black {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'text-blue-600' : ($catSlug === 'home_tutor' ? 'text-slate-400' : 'text-red-500') }}">
                @if($catSlug === 'home_tutor')
                    <span class="text-slate-400 font-semibold">Not Applicable</span>
                @elseif($profile?->is_agreement_signed || $profile?->agreement_pdf_path)
                    Agreement Signed
                @else
                    Pending Signature
                @endif
            </h4>
        </div>
    </div>

    {{-- Tuition Agreement --}}
    <div class="bg-card-bg border {{ ($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed) ? 'border-teal-500/40 bg-teal-50/10' : ($profile?->tuition_agreement_status === 'pending_signature' ? 'border-amber-500/40 bg-amber-50/10' : ($catSlug === 'school_job' ? 'border-card-border bg-card-bg opacity-70' : 'border-slate-300/40 bg-slate-50/20')) }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ ($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed) ? 'bg-teal-500/10 text-teal-600' : ($profile?->tuition_agreement_status === 'pending_signature' ? 'bg-amber-500/10 text-amber-600' : 'bg-slate-200 text-slate-500') }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-file-signature"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Tuition Agreement</p>
            <h4 class="text-sm font-black {{ ($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed) ? 'text-teal-600' : ($profile?->tuition_agreement_status === 'pending_signature' ? 'text-amber-600' : 'text-slate-500') }}">
                @if($catSlug === 'school_job')
                    <span class="text-slate-400 font-semibold">Not Applicable</span>
                @elseif($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed)
                    Tuition Signed ✅
                @elseif($profile?->tuition_agreement_status === 'pending_signature')
                    Unlocked (Pending Sign)
                @else
                    Locked / Inactive
                @endif
            </h4>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column: Profile Card & Documents -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Candidate Profile Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <!-- Header Header with Photo & Category -->
            <div class="p-6 border-b border-card-border bg-secondary-bg flex items-center gap-4">
                @if($profile && $profile->profile_photo_path)
                    <img src="{{ Storage::url($profile->profile_photo_path) }}" alt="{{ $candidate->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-accent-blue/30 shadow-sm shrink-0">
                @elseif($profile && $profile->live_photo_path)
                    <img src="{{ Storage::url($profile->live_photo_path) }}" alt="{{ $candidate->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-500/30 shadow-sm shrink-0">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-2xl font-black border border-accent-blue/20 shrink-0">
                        {{ strtoupper(substr($candidate->name, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-lg font-black text-text-main truncate">{{ $candidate->name }}</h3>
                    </div>

                    {{-- Category Badge --}}
                    <div class="mt-1">
                        @if($catSlug === 'home_tutor')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fas fa-chalkboard-teacher text-[9px]"></i> Home Tutor
                            </span>
                        @elseif($catSlug === 'school_job')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                                <i class="fas fa-school text-[9px]"></i> School Job
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-50 text-purple-700 border border-purple-200">
                                <i class="fas fa-layer-group text-[9px]"></i> Both (Tutor + School)
                            </span>
                        @endif
                    </div>

                    {{-- Contact --}}
                    <div class="mt-2 space-y-0.5 text-xs text-text-dark/70">
                        <p class="flex items-center gap-1.5">
                            <i class="fas fa-phone-alt text-[10px] text-text-dark/40"></i>
                            <a href="tel:{{ $candidate->phone }}" class="hover:text-accent-blue font-semibold">{{ $candidate->phone }}</a>
                        </p>
                        @if($candidate->whatsapp_no || $profile?->whatsapp_no)
                            @php $wNo = preg_replace('/[^0-9]/', '', $candidate->whatsapp_no ?: $profile?->whatsapp_no); @endphp
                            <p class="flex items-center gap-1.5">
                                <i class="fab fa-whatsapp text-[11px] text-emerald-600"></i>
                                <a href="https://wa.me/{{ str_starts_with($wNo, '91') ? $wNo : '91'.$wNo }}" target="_blank" class="text-emerald-700 font-bold hover:underline">
                                    {{ $candidate->whatsapp_no ?: $profile?->whatsapp_no }}
                                </a>
                            </p>
                        @endif
                        <p class="flex items-center gap-1.5 truncate">
                            <i class="fas fa-envelope text-[10px] text-text-dark/40"></i>
                            <a href="mailto:{{ $candidate->email }}" class="hover:text-accent-blue truncate">{{ $candidate->email }}</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-5">
                {{-- Profile Completion Progress Card --}}
                <div class="bg-secondary-bg/70 p-4 rounded-2xl border border-card-border space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-wider text-text-dark/60">Profile Completion</span>
                        <span class="text-xs font-black {{ $pct >= 80 ? 'text-emerald-600' : ($pct >= 50 ? 'text-amber-600' : 'text-red-500') }}">
                            {{ $pct }}% Complete
                        </span>
                    </div>

                    <div class="w-full h-2.5 bg-card-bg rounded-full overflow-hidden border border-card-border">
                        <div class="h-full rounded-full transition-all duration-500 {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                             style="width: {{ (int)$pct }}%;"></div>
                    </div>

                    @if($pct < 80 && ($catSlug === 'home_tutor' || $catSlug === 'both'))
                        <div class="p-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-semibold flex items-center gap-2">
                            <i class="fas fa-lock text-amber-600 shrink-0"></i>
                            <span>Tuition leads are locked for this teacher because completion is &lt; 80%.</span>
                        </div>
                    @endif

                    @if(!empty($missingFields))
                        <div class="pt-1">
                            <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-1">Missing Details:</span>
                            <div class="flex flex-wrap gap-1">
                                @foreach($missingFields as $field)
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-red-50 text-red-600 border border-red-100">
                                        • {{ $field }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Personal Info -->
                <div>
                    <h4 class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2.5">Common Personal Details</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Gender</span>
                            <span class="font-bold text-text-main">{{ $profile?->gender ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Date of Birth</span>
                            <span class="font-bold text-text-main">{{ $profile?->date_of_birth ? $profile->date_of_birth->format('d M Y') : 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Highest Qualification</span>
                            <span class="font-bold text-text-main">{{ $profile?->highest_qualification_name ?: ($profile?->highestQualification?->name ?? 'N/A') }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Teaching Experience</span>
                            <span class="font-bold text-text-main">{{ $profile?->experience_range ?: (($profile?->experience_years ?? 0) . ' Years') }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border col-span-2">
                            <span class="text-[10px] text-text-dark/50 block">Full Residential Address</span>
                            <span class="font-medium text-text-main">{{ $profile?->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Home Tutor Flow Details --}}
                @if($profile?->appliesForHomeTuition())
                <div class="pt-2 border-t border-card-border">
                    <h4 class="text-xs font-black text-emerald-700 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <i class="fas fa-chalkboard-teacher"></i> Home Tutor Preferences
                    </h4>
                    <div class="space-y-2 text-xs">
                        {{-- Tuition Subjects --}}
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block mb-1">Subjects Interested in Teaching:</span>
                            @if(!empty($profile?->tuition_subjects) && is_array($profile->tuition_subjects))
                                <div class="flex flex-wrap gap-1">
                                    @foreach($profile->tuition_subjects as $subj)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            {{ $subj }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-text-dark/40 italic">None selected</span>
                            @endif
                        </div>

                        {{-- Classes Interested --}}
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block mb-1">Classes / Levels:</span>
                            @if(!empty($profile?->classes_interested) && is_array($profile->classes_interested))
                                <div class="flex flex-wrap gap-1">
                                    @foreach($profile->classes_interested as $cls)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-accent-blue border border-blue-200">
                                            {{ $cls }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-text-dark/40 italic">None selected</span>
                            @endif
                        </div>

                        {{-- Mode & Time Slot --}}
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Teaching Mode</span>
                                <span class="font-bold text-text-main">{{ ucfirst($profile?->teaching_mode ?? 'Offline') }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Time Slot</span>
                                <span class="font-bold text-text-main">{{ $profile?->available_time_slot ?? 'Any Time' }}</span>
                            </div>
                        </div>

                        {{-- Preferred Areas --}}
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Preferred Home Tuition Areas</span>
                            <span class="font-bold text-emerald-800">{{ $profile?->preferred_areas ?? 'Not Specified' }}</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- School Job Flow Details --}}
                @if($profile?->appliesForSchoolJob())
                <div class="pt-2 border-t border-card-border">
                    <h4 class="text-xs font-black text-indigo-700 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <i class="fas fa-school"></i> School Job Application Details
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Position Applying For</span>
                                <span class="font-black text-indigo-700">{{ $profile?->position_applying_for ?? 'N/A' }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Subject / Specialization</span>
                                <span class="font-bold text-text-main">{{ $profile?->subject_specialization ?: ($profile?->subject?->name ?? 'N/A') }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">B.Ed Status</span>
                                <span class="font-bold text-text-main">{{ $profile?->b_ed_status ?? 'No' }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">D.El.Ed Status</span>
                                <span class="font-bold text-text-main">{{ $profile?->d_el_ed_status ?? 'No' }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Current / Last Drawn Salary</span>
                                <span class="font-bold text-text-main">{{ $profile?->last_drawn_salary ?: ($profile?->current_salary ? '₹'.$profile->current_salary : 'N/A') }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Expected Salary</span>
                                <span class="font-black text-emerald-600">{{ $profile?->expected_salary ? '₹'.$profile->expected_salary : 'N/A' }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Previous School</span>
                                <span class="font-bold text-text-main">{{ $profile?->last_school_name ?: ($profile?->current_school ?? 'N/A') }}</span>
                            </div>
                            <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                                <span class="text-[10px] text-text-dark/50 block">Last Designation</span>
                                <span class="font-bold text-text-main">{{ $profile?->last_designation ?? 'N/A' }}</span>
                            </div>
                        </div>

                        {{-- Preferred Locations --}}
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block mb-1">Preferred Locations for School:</span>
                            @if(!empty($profile?->preferred_locations) && is_array($profile->preferred_locations))
                                <div class="flex flex-wrap gap-1">
                                    @foreach($profile->preferred_locations as $locItem)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-800 border border-indigo-200">
                                            📍 {{ $locItem }}
                                        </span>
                                    @endforeach
                                </div>
                            @elseif($profile?->preferredCity)
                                <span class="font-bold text-text-main">📍 {{ $profile->preferredCity->name }}, {{ $profile->preferredState?->name }}</span>
                            @else
                                <span class="text-text-dark/40 italic">None selected</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Documents -->
                <div class="pt-2 border-t border-card-border">
                    <h4 class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2.5">Uploaded Documents</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @if($profile?->resume_path)
                            <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" class="p-2.5 bg-blue-50/50 hover:bg-blue-100/60 border border-blue-200 text-accent-blue rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-file-pdf text-sm"></i> <span>Resume / CV</span>
                            </a>
                        @endif
                        @if($profile?->salary_slip_path)
                            <a href="{{ Storage::url($profile->salary_slip_path) }}" target="_blank" class="p-2.5 bg-amber-50/50 hover:bg-amber-100/60 border border-amber-200 text-amber-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-file-invoice text-sm"></i> <span>Salary Slip</span>
                            </a>
                        @endif
                        @if($profile?->profile_photo_path)
                            <a href="{{ Storage::url($profile->profile_photo_path) }}" target="_blank" class="p-2.5 bg-purple-50/50 hover:bg-purple-100/60 border border-purple-200 text-purple-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-image text-sm"></i> <span>Photo</span>
                            </a>
                        @endif
                        @if($profile?->live_photo_path)
                            <a href="{{ Storage::url($profile->live_photo_path) }}" target="_blank" class="p-2.5 bg-emerald-50/50 hover:bg-emerald-100/60 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-id-card text-sm"></i> <span>ID Card</span>
                            </a>
                        @endif
                        @if($profile?->offer_letter_path)
                            <a href="{{ Storage::url($profile->offer_letter_path) }}" target="_blank" class="p-2.5 bg-sky-50/50 hover:bg-sky-100/60 border border-sky-200 text-sky-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-file-contract text-sm"></i> <span>Offer Letter</span>
                            </a>
                        @endif
                        @if($profile?->agreement_pdf_path)
                            <a href="{{ Storage::url($profile->agreement_pdf_path) }}" target="_blank" class="p-2.5 bg-teal-50/50 hover:bg-teal-100/60 border border-teal-200 text-teal-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2 col-span-2">
                                <i class="fas fa-file-signature text-sm"></i> <span>Signed Agreement (PDF)</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Agreement Management Section -->
                <div class="pt-4 border-t border-card-border space-y-4">
                    <h4 class="text-xs font-black uppercase tracking-wider text-text-main flex items-center gap-2">
                        <i class="fas fa-file-signature text-accent-blue"></i> Agreements & Signing Control
                    </h4>

                    {{-- 1. School Job Placement Agreement Control --}}
                    <div class="bg-secondary-bg p-4 rounded-2xl border border-card-border space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-text-main">School Job Agreement:</span>
                            @if($profile?->is_agreement_signed || $profile?->agreement_pdf_path)
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="fas fa-check-circle mr-0.5"></i> Signed & Valid
                                </span>
                            @elseif($profile?->agreement_status === 'pending_signature')
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                    <i class="fas fa-hourglass-half mr-0.5"></i> Active on Candidate Panel
                                </span>
                            @else
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-card-border/50 text-text-dark/60 border border-card-border">
                                    <i class="fas fa-ban mr-0.5"></i> Inactive / Not Sent
                                </span>
                            @endif
                        </div>

                        {{-- 1-Click Send / Activate Agreement Button for Candidate --}}
                        @if(!$profile?->is_agreement_signed && $profile?->agreement_status !== 'pending_signature')
                            <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="agreement_status" value="pending_signature">
                                <button type="submit" class="w-full py-2.5 px-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i> <span>Activate Agreement on Candidate Panel</span>
                                </button>
                                <p class="text-[10px] text-text-dark/50 mt-1.5 leading-tight">Enables the "Sign Now" digital signature banner in candidate dashboard.</p>
                            </form>
                        @elseif($profile?->agreement_status === 'pending_signature')
                            <div class="p-2.5 bg-amber-500/10 border border-amber-500/20 rounded-xl text-xs text-amber-800 space-y-2">
                                <p class="font-bold flex items-center gap-1.5"><i class="fas fa-bell"></i> Agreement is LIVE on candidate portal</p>
                                <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="agreement_status" value="signed">
                                    <button type="submit" class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                        <i class="fas fa-check-double mr-1"></i> Force Mark as Signed & Approved
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Status Selector Dropdown --}}
                        <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST" class="pt-2 border-t border-card-border flex items-center justify-between gap-2">
                            @csrf
                            <label class="text-[11px] font-bold text-text-dark/70">Change Status:</label>
                            <div class="flex items-center gap-1.5">
                                <select name="agreement_status" class="text-xs bg-card-bg border border-card-border rounded-lg py-1 px-2 text-text-main font-semibold focus:ring-1 focus:ring-accent-blue">
                                    <option value="not_required" {{ $profile?->agreement_status === 'not_required' ? 'selected' : '' }}>Not Required</option>
                                    <option value="pending_signature" {{ $profile?->agreement_status === 'pending_signature' ? 'selected' : '' }}>Pending Signature</option>
                                    <option value="signed" {{ ($profile?->agreement_status === 'signed' || $profile?->is_agreement_signed) ? 'selected' : '' }}>Signed</option>
                                </select>
                                <button type="submit" class="px-2.5 py-1 bg-text-main hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors">
                                    Set
                                </button>
                            </div>
                        </form>

                        {{-- Upload Signed Agreement PDF --}}
                        <form action="{{ route('admin.crm.candidate.upload-agreement', $candidate->id) }}" method="POST" enctype="multipart/form-data" class="pt-2 border-t border-card-border">
                            @csrf
                            <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Or Upload Physical Signed Copy (PDF):</label>
                            <div class="flex items-center gap-2">
                                <input type="file" name="agreement_pdf" accept=".pdf" required class="flex-1 text-[11px] text-text-dark/60 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-card-bg file:text-text-main cursor-pointer">
                                <button type="submit" class="px-3 py-1 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-main rounded-lg text-xs font-bold transition-colors">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- 2. Home Tuition Agreement Control --}}
                    <div class="bg-secondary-bg p-4 rounded-2xl border border-card-border space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-text-main">Home Tuition Agreement:</span>
                            @if($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed)
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200">
                                    <i class="fas fa-check-circle mr-0.5"></i> Signed & Valid
                                </span>
                            @elseif($profile?->tuition_agreement_status === 'pending_signature')
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                    <i class="fas fa-hourglass-half mr-0.5"></i> Active on Candidate Panel
                                </span>
                            @elseif($profile?->tuition_agreement_status === 'request_pending')
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 animate-pulse">
                                    <i class="fas fa-hand-paper mr-0.5"></i> Request Pending
                                </span>
                            @else
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-card-border/50 text-text-dark/60 border border-card-border">
                                    <i class="fas fa-ban mr-0.5"></i> Inactive / Not Sent
                                </span>
                            @endif
                        </div>

                        {{-- 1-Click Action Buttons for Tuition Agreement --}}
                        @if($profile?->tuition_agreement_status === 'request_pending')
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl space-y-2">
                                <p class="text-xs text-blue-800 font-bold flex items-center gap-1.5"><i class="fas fa-info-circle"></i> Candidate requested to sign the agreement</p>
                                <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tuition_agreement_status" value="pending_signature">
                                    <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2">
                                        <i class="fas fa-check"></i> <span>Approve & Unlock Signature</span>
                                    </button>
                                </form>
                            </div>
                        @elseif(!$profile?->is_tuition_agreement_signed && $profile?->tuition_agreement_status !== 'pending_signature')
                            <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tuition_agreement_status" value="pending_signature">
                                <button type="submit" class="w-full py-2.5 px-3 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2 cursor-pointer">
                                    <i class="fas fa-lock-open"></i> <span>Unlock Tuition Agreement for Candidate</span>
                                </button>
                                <p class="text-[10px] text-text-dark/50 mt-1.5 leading-tight">Unlocks the digital signing form (Live Photo & Signature) for the candidate on their panel.</p>
                            </form>
                        @elseif($profile?->tuition_agreement_status === 'pending_signature')
                            <div class="p-2.5 bg-amber-500/10 border border-amber-500/20 rounded-xl text-xs text-amber-800 space-y-2">
                                <p class="font-bold flex items-center gap-1.5"><i class="fas fa-lock-open text-amber-600"></i> Tuition Agreement is UNLOCKED on candidate portal</p>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="tuition_agreement_status" value="signed">
                                        <button type="submit" class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                            <i class="fas fa-check-double mr-1"></i> Mark Signed
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="tuition_agreement_status" value="not_required">
                                        <button type="submit" class="w-full py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold transition-all">
                                            <i class="fas fa-lock mr-1"></i> Lock Again
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tuition_agreement_status" value="not_required">
                                <button type="submit" class="w-full py-1.5 px-3 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                    <i class="fas fa-ban"></i> <span>Revoke / Reset Tuition Agreement</span>
                                </button>
                            </form>
                        @endif

                        {{-- Status Selector Dropdown for Tuition Agreement --}}
                        <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST" class="pt-2 border-t border-card-border flex items-center justify-between gap-2">
                            @csrf
                            <label class="text-[11px] font-bold text-text-dark/70">Change Status:</label>
                            <div class="flex items-center gap-1.5">
                                <select name="tuition_agreement_status" class="text-xs bg-card-bg border border-card-border rounded-lg py-1 px-2 text-text-main font-semibold focus:ring-1 focus:ring-accent-blue">
                                    <option value="not_required" {{ ($profile?->tuition_agreement_status === 'not_required' || (!$profile?->tuition_agreement_status && !$profile?->is_tuition_agreement_signed)) ? 'selected' : '' }}>Not Required / Inactive</option>
                                    <option value="request_pending" {{ $profile?->tuition_agreement_status === 'request_pending' ? 'selected' : '' }}>Request Pending</option>
                                    <option value="pending_signature" {{ $profile?->tuition_agreement_status === 'pending_signature' ? 'selected' : '' }}>Pending Signature (Active)</option>
                                    <option value="signed" {{ ($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed) ? 'selected' : '' }}>Signed & Approved</option>
                                </select>
                                <button type="submit" class="px-2.5 py-1 bg-text-main hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors">
                                    Set
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- 3. Live Digital Verification Audit Details (Photo & GPS) --}}
                    @php
                        $tuitionMeta = [];
                        if ($profile?->tuition_signature_data) {
                            $tuitionMeta = json_decode($profile->tuition_signature_data, true) ?: [];
                        }
                        $livePhoto = $profile?->tuition_live_photo_path ?? $profile?->live_photo_path;
                        $geoLat = $profile?->tuition_latitude ?? $profile?->latitude ?? ($tuitionMeta['latitude'] ?? null);
                        $geoLng = $profile?->tuition_longitude ?? $profile?->longitude ?? ($tuitionMeta['longitude'] ?? null);
                        $geoLoc = $profile?->tuition_location_name ?? $profile?->signature_location_name ?? ($tuitionMeta['location'] ?? null);
                        $signIp = $profile?->signature_ip_address ?? ($tuitionMeta['ip'] ?? null);
                    @endphp

                    <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-200/80 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase text-[#031b4e] flex items-center gap-1.5">
                                <i class="fas fa-shield-check text-emerald-600"></i> Live Identity & GPS Verification
                            </span>
                            @if($livePhoto || $geoLat)
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                                    Verified
                                </span>
                            @else
                                <span class="text-[9px] font-bold text-slate-400">
                                    Pending Capture
                                </span>
                            @endif
                        </div>

                        @php
                            $isActuallySigned = false;
                            if ($catSlug === 'home_tutor') {
                                $isActuallySigned = ($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed);
                                $adminSig = $isActuallySigned ? ($tuitionMeta['signature_data'] ?? $profile?->tuition_signature_data ?? $profile?->signature_data) : null;
                                $adminSigType = $tuitionMeta['signature_type'] ?? $profile?->signature_type ?? 'draw';
                            } else {
                                $isActuallySigned = ($profile?->is_agreement_signed || $profile?->agreement_status === 'signed');
                                $adminSig = $isActuallySigned ? ($profile?->signature_data ?? ($tuitionMeta['signature_data'] ?? null)) : null;
                                $adminSigType = $profile?->signature_type ?? ($tuitionMeta['signature_type'] ?? 'draw');
                            }
                        @endphp

                        @if($isActuallySigned && $adminSig)
                            <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-blue-100">
                                <div class="shrink-0 p-1.5 bg-slate-50 rounded-lg border border-slate-200">
                                    @if(str_starts_with($adminSig, 'data:image'))
                                        <img src="{{ $adminSig }}" alt="Digital Signature" class="max-h-10 w-auto object-contain">
                                    @elseif(Storage::disk('public')->exists($adminSig))
                                        <img src="{{ asset('storage/' . $adminSig) }}" alt="Digital Signature" class="max-h-10 w-auto object-contain">
                                    @elseif($adminSigType === 'type')
                                        <span class="text-base font-serif italic text-blue-900 font-bold" style="font-family: 'Brush Script MT', 'Dancing Script', cursive;">{{ $adminSig }}</span>
                                    @else
                                        <span class="text-xs font-mono font-bold">{{ $adminSig }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0 text-xs">
                                    <p class="font-bold text-indigo-900 flex items-center gap-1">
                                        <i class="fas fa-signature text-indigo-600 text-[10px]"></i> Digital E-Signature
                                    </p>
                                    <p class="text-[10px] text-text-dark/60 mt-0.5">Verified candidate signature attached to agreement.</p>
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-slate-100/90 rounded-xl text-xs text-slate-500 flex items-center gap-2">
                                <i class="fas fa-lock text-slate-400"></i>
                                <span>No signature submitted yet. {{ ($profile?->tuition_agreement_status === 'pending_signature' || $profile?->agreement_status === 'pending_signature') ? '(Agreement is Unlocked for candidate to sign)' : '(Agreement is Locked - Unlock above to allow candidate signing)' }}</span>
                            </div>
                        @endif

                        @if($livePhoto)
                            <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-blue-100">
                                <a href="{{ Storage::url($livePhoto) }}" target="_blank" class="relative group shrink-0">
                                    <img src="{{ Storage::url($livePhoto) }}" alt="Live Agreement Photo" class="w-16 h-16 rounded-lg object-cover border-2 border-emerald-500 shadow-sm">
                                    <div class="absolute inset-0 bg-black/40 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-search-plus text-white text-xs"></i>
                                    </div>
                                </a>
                                <div class="min-w-0 text-xs">
                                    <p class="font-bold text-emerald-800 flex items-center gap-1">
                                        <i class="fas fa-camera text-emerald-600 text-[10px]"></i> Live Camera Snapshot
                                    </p>
                                    <p class="text-[10px] text-text-dark/60 mt-0.5">Captured at the moment of agreement digital signing.</p>
                                    <a href="{{ Storage::url($livePhoto) }}" target="_blank" class="text-[11px] font-bold text-accent-blue hover:underline inline-block mt-0.5">
                                        View Full Photo &rarr;
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($geoLat && $geoLng)
                            <div class="bg-white p-2.5 rounded-xl border border-blue-100 text-xs space-y-1">
                                <span class="text-[10px] font-bold text-text-dark/50 uppercase block">GPS Signing Location</span>
                                <p class="font-bold text-text-main flex items-start gap-1">
                                    <i class="fas fa-map-marker-alt text-red-500 mt-0.5 shrink-0"></i>
                                    <span class="line-clamp-2">{{ $geoLoc ?: "{$geoLat}, {$geoLng}" }}</span>
                                </p>
                                <div class="flex items-center justify-between pt-1">
                                    <span class="font-mono text-[10px] text-text-dark/60">Lat: {{ number_format($geoLat, 4) }}, Lng: {{ number_format($geoLng, 4) }}</span>
                                    <a href="https://www.google.com/maps?q={{ $geoLat }},{{ $geoLng }}" target="_blank" class="px-2 py-0.5 bg-blue-50 text-accent-blue border border-blue-200 rounded text-[10px] font-bold hover:bg-blue-100 transition-colors flex items-center gap-1">
                                        <i class="fas fa-external-link-alt text-[8px]"></i> Google Maps
                                    </a>
                                </div>
                            </div>
                        @elseif($geoLoc)
                            <div class="bg-white p-2.5 rounded-xl border border-blue-100 text-xs">
                                <span class="text-[10px] font-bold text-text-dark/50 uppercase block">Location</span>
                                <p class="font-bold text-text-main">📍 {{ $geoLoc }}</p>
                            </div>
                        @endif

                        @if($signIp || $profile?->tuition_agreement_signed_at || $profile?->signature_date_time)
                            <div class="text-[10px] text-text-dark/60 space-y-0.5 pt-1 border-t border-blue-100">
                                @if($signIp)
                                    <div><i class="fas fa-laptop text-[9px] text-blue-500 mr-1"></i> IP: <span class="font-mono font-bold">{{ $signIp }}</span></div>
                                @endif
                                @if($profile?->tuition_agreement_signed_at)
                                    <div><i class="fas fa-calendar-check text-[9px] text-teal-600 mr-1"></i> Tuition Signed: <span class="font-semibold">{{ \Carbon\Carbon::parse($profile->tuition_agreement_signed_at)->format('d M Y, h:i A') }}</span></div>
                                @endif
                                @if($profile?->signature_date_time)
                                    <div><i class="fas fa-calendar-check text-[9px] text-indigo-600 mr-1"></i> Job Signed: <span class="font-semibold">{{ \Carbon\Carbon::parse($profile->signature_date_time)->format('d M Y, h:i A') }}</span></div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Tabs for Jobs, Tuitions, Invoices, CRM Followups, and Ratings -->
    <div class="lg:col-span-2 space-y-6" x-data="{ tab: 'jobs' }">
        <!-- Tab Navigation -->
        <div class="bg-card-bg border border-card-border rounded-2xl p-1.5 flex gap-1 shadow-sm overflow-x-auto">
            <button @click="tab = 'jobs'" :class="tab === 'jobs' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-school"></i> <span>School Jobs ({{ $candidate->applications->count() }})</span>
            </button>
            <button @click="tab = 'tuitions'" :class="tab === 'tuitions' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-chalkboard-teacher"></i> <span>Home Tuitions ({{ $tuitionApplications->count() }})</span>
            </button>
            <button @click="tab = 'invoices'" :class="tab === 'invoices' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-file-invoice-dollar"></i> <span>Invoices ({{ $invoices->count() }})</span>
            </button>
            <button @click="tab = 'followups'" :class="tab === 'followups' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-comments"></i> <span>Follow-ups ({{ $followUps->count() }})</span>
            </button>
            <button @click="tab = 'timeline'" :class="tab === 'timeline' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-history"></i> <span>Timeline</span>
            </button>
        </div>

        <!-- TAB 1: SCHOOL JOBS -->
        <div x-show="tab === 'jobs'" class="space-y-6">
            <!-- Assign Job Form -->
            <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-accent-blue"></i> Map & Assign School Teaching Job
                </h4>
                <form action="{{ route('admin.crm.application.assign', $candidate->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <select name="job_post_id" required class="flex-1 bg-secondary-bg border border-card-border rounded-xl text-xs py-2.5 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">-- Select Active School Job --</option>
                        @foreach($availableJobs as $job)
                            <option value="{{ $job->id }}">[{{ $job->job_id ?: 'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT) }}] {{ $job->title }} — {{ $job->school_name }} ({{ $job->city->name ?? '' }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-5 py-2.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shrink-0">
                        Assign Job
                    </button>
                </form>
            </div>

            <!-- Job Applications List -->
            <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
                <div class="p-4 border-b border-card-border bg-secondary-bg flex justify-between items-center">
                    <h4 class="text-xs font-black uppercase tracking-wider text-text-main">Applied & Mapped School Jobs</h4>
                    <span class="text-xs font-bold text-text-dark/50">{{ $candidate->applications->count() }} Total</span>
                </div>

                <div class="divide-y divide-card-border">
                    @forelse($candidate->applications as $app)
                        <div class="p-5 space-y-4">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1 font-mono text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                            {{ $app->jobPost->job_id ?: 'JOB-' . str_pad($app->jobPost->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <h5 class="text-sm font-black text-text-main">{{ $app->jobPost->title ?? 'N/A' }}</h5>
                                    </div>
                                    <p class="text-xs text-text-dark/60 mt-0.5">{{ $app->jobPost->school_name ?? 'School' }} • {{ $app->jobPost->city->name ?? '' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full 
                                        {{ $app->status === 'hired' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($app->status === 'shortlisted' ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($app->status === 'rejected' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-blue-50 text-accent-blue border border-blue-200')) }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Update Application Status Form -->
                            <form action="{{ route('admin.applications.status.update', $app->id) }}" method="POST" class="bg-secondary-bg p-4 rounded-xl border border-card-border space-y-3">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Status</label>
                                        <select name="status" class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                            <option value="applied" {{ $app->status === 'applied' ? 'selected' : '' }}>Applied (New)</option>
                                            <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted (Schedule Interview)</option>
                                            <option value="hired" {{ $app->status === 'hired' ? 'selected' : '' }}>Hired (Selected)</option>
                                            <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Interview Date</label>
                                        <input type="datetime-local" name="interview_date" value="{{ $app->interview_date }}" 
                                               class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Interview Location / Link</label>
                                        <input type="text" name="interview_link" value="{{ $app->interview_link }}" placeholder="e.g. Zoom link / School Campus" 
                                               class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Feedback / Notes (Visible to Candidate)</label>
                                    <input type="text" name="remarks" value="{{ $app->remarks }}" placeholder="e.g. Interview scheduled for 11 AM..." 
                                           class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                </div>

                                <div class="flex justify-end items-center gap-2 pt-1">
                                    <button type="submit" class="px-4 py-2 bg-text-main hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <div class="p-8 text-center text-text-dark/50 text-xs">
                            <i class="fas fa-briefcase text-2xl mb-2 block text-text-dark/30"></i>
                            No school job applications recorded yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- TAB 2: HOME TUITIONS -->
        <div x-show="tab === 'tuitions'" class="space-y-6" style="display: none;">
            <!-- Direct Assign Tuition Form -->
            <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-emerald-600"></i> Assign Home Tuition to Candidate
                </h4>
                <form action="{{ route('admin.crm.tuition.assign', $candidate->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Select Home Tuition Requirement <span class="text-red-500">*</span></label>
                            <select name="home_tuition_lead_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2.5 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                <option value="">-- Choose Home Tuition Lead --</option>
                                @foreach($availableTuitionLeads as $tLead)
                                    <option value="{{ $tLead->id }}">
                                        [{{ $tLead->tuition_id ?: 'TUI-' . str_pad($tLead->id, 4, '0', STR_PAD_LEFT) }}] Class {{ $tLead->class }} ({{ $tLead->subjects }}) — {{ $tLead->location }} [Parent: {{ $tLead->parent_name }} - {{ $tLead->parent_mobile }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Assignment Status</label>
                            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2.5 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                <option value="Assigned">Assigned & Confirmed (Direct Placement)</option>
                                <option value="Shortlisted">Shortlisted (Demo Trial)</option>
                                <option value="Applied">Applied (Under Review)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Demo / Start Date</label>
                            <input type="date" name="demo_date" value="{{ date('Y-m-d') }}" 
                                   class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2.5 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Teacher Instructions / Notes</label>
                            <input type="text" name="remarks" placeholder="e.g. 5 days/week demo starting Monday, 5 PM" 
                                   class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        </div>

                        <div class="sm:col-span-2 bg-emerald-50/20 p-3 rounded-xl border border-emerald-200">
                            <label class="flex items-center gap-2 cursor-pointer mb-2">
                                <input type="checkbox" name="create_service_charge" value="1" checked class="w-4 h-4 text-emerald-600 rounded">
                                <span class="text-xs font-bold text-text-main">Generate Tuition Service Charge Invoice</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="w-36">
                                    <input type="number" name="service_charge_amount" value="500" min="0" placeholder="Amount ₹" 
                                           class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-1.5 px-3 text-text-main font-bold">
                                </div>
                                <span class="text-[10px] text-text-dark/60">Candidate will see this invoice under Tuition Service Charges.</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                            <i class="fas fa-user-check mr-1"></i> Confirm Tuition Assignment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Home Tuition Applications List -->
            <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
                <div class="p-4 border-b border-card-border bg-secondary-bg flex justify-between items-center">
                    <h4 class="text-xs font-black uppercase tracking-wider text-text-main">Tuition Applications & Placements</h4>
                    <span class="text-xs font-bold text-text-dark/50">{{ $tuitionApplications->count() }} Total</span>
                </div>

                <div class="divide-y divide-card-border">
                    @forelse($tuitionApplications as $tApp)
                        <div class="p-5 space-y-3">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1 font-mono text-[10px] font-bold text-accent-blue bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                            {{ $tApp->tuitionLead?->tuition_id ?: 'TUI-' . str_pad($tApp->tuitionLead?->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <h5 class="text-sm font-black text-text-main">
                                            Class {{ $tApp->tuitionLead->class ?? 'N/A' }} ({{ $tApp->tuitionLead->subjects ?? '' }})
                                        </h5>
                                    </div>
                                    <p class="text-xs text-text-dark/60 mt-0.5">
                                        📍 {{ $tApp->tuitionLead->location ?? '' }} • Parent: {{ $tApp->tuitionLead->parent_name ?? '' }} ({{ $tApp->tuitionLead->parent_mobile ?? '' }})
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full 
                                        {{ $tApp->status === 'Assigned' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($tApp->status === 'Shortlisted' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-accent-blue border border-blue-200') }}">
                                        {{ $tApp->status }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($tApp->remarks || $tApp->demo_date)
                                <div class="bg-secondary-bg p-3 rounded-xl text-xs text-text-dark/80 flex items-center justify-between">
                                    <div><i class="fas fa-info-circle text-accent-blue mr-1"></i> {{ $tApp->remarks ?: 'No remarks' }}</div>
                                    @if($tApp->demo_date)
                                        <span class="font-bold text-text-main">Demo: {{ \Carbon\Carbon::parse($tApp->demo_date)->format('d M Y') }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-text-dark/50 text-xs">
                            <i class="fas fa-chalkboard-teacher text-2xl mb-2 block text-text-dark/30"></i>
                            No home tuition applications or assignments yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- TAB 3: INVOICES -->
        <div x-show="tab === 'invoices'" class="space-y-6" style="display: none;">
            <!-- Create Invoice Form -->
            <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-accent-blue"></i> Issue Placement Service Charge Invoice
                </h4>
                <form action="{{ route('admin.crm.invoice.store', $candidate->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Invoice Amount (₹) <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" required min="1" placeholder="e.g. 1500" 
                               class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Due Date <span class="text-red-500">*</span></label>
                        <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required 
                               class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Description</label>
                        <input type="text" name="description" placeholder="e.g. Placement Service Charge" 
                               class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                    </div>
                    <div class="sm:col-span-3 flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                            Create Invoice
                        </button>
                    </div>
                </form>
            </div>

            <!-- Invoices List -->
            <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
                <div class="p-4 border-b border-card-border bg-secondary-bg flex justify-between items-center">
                    <h4 class="text-xs font-black uppercase tracking-wider text-text-main">Issued Invoices</h4>
                    <span class="text-xs font-bold text-text-dark/50">{{ $invoices->count() }} Total</span>
                </div>

                <div class="divide-y divide-card-border">
                    @forelse($invoices as $inv)
                        <div class="p-4 flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                            {{-- Invoice Info --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h5 class="text-sm font-black text-text-main">₹{{ number_format($inv->amount, 2) }}</h5>
                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $inv->status === 'paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($inv->status === 'overdue' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                        {{ ucfirst($inv->status) }}
                                    </span>
                                    @if($inv->late_fee > 0)
                                        <span class="text-[10px] font-bold text-red-500">+₹{{ number_format($inv->late_fee, 0) }} late fee</span>
                                    @endif
                                </div>
                                <p class="text-xs text-text-dark/60 mt-0.5">{{ $inv->description ?: 'Placement Service Charge' }}</p>
                                <p class="text-[10px] text-text-dark/40">Due: {{ \Carbon\Carbon::parse($inv->due_date)->format('d M Y') }}</p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center gap-1.5 flex-shrink-0">
                                @if($inv->status === 'paid')
                                    <a href="{{ route('admin.serviceCharge.invoice', $inv->id) }}" target="_blank" class="px-2.5 py-1.5 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-main rounded-lg text-[11px] font-bold transition-colors" title="View PDF">
                                        <i class="fas fa-file-pdf text-red-400 mr-0.5"></i> PDF
                                    </a>
                                @endif

                                @if($inv->status !== 'paid')
                                    {{-- Edit Button --}}
                                    <button type="button" onclick="openEditInvoiceModal({{ $inv->id }}, '{{ $inv->amount }}', '{{ \Carbon\Carbon::parse($inv->due_date)->format('Y-m-d') }}', '{{ addslashes($inv->description ?? '') }}', '{{ $inv->status }}')" class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 rounded-lg text-[11px] font-bold transition-colors cursor-pointer" title="Edit Invoice">
                                        <i class="fas fa-pen text-[10px]"></i> Edit
                                    </button>

                                    {{-- Mark Paid Button --}}
                                    <form action="{{ route('admin.tuition-service-charges.mark-paid', $inv->id) }}" method="POST" class="inline" onsubmit="return confirm('Mark this invoice as Paid?')">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-lg text-[11px] font-bold transition-colors cursor-pointer" title="Mark as Paid">
                                            <i class="fas fa-check text-[10px]"></i> Paid
                                        </button>
                                    </form>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.tuition-service-charges.destroy', $inv->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this invoice? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 rounded-lg text-[11px] font-bold transition-colors cursor-pointer" title="Delete Invoice">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="px-2.5 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-lg text-[10px] font-bold">
                                        <i class="fas fa-check-circle text-[10px]"></i> Paid
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-text-dark/50 text-xs">
                            <i class="fas fa-file-invoice text-2xl mb-2 block text-text-dark/30"></i>
                            No invoices generated for this candidate yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- TAB 4: FOLLOW-UPS -->
        <div x-show="tab === 'followups'" class="space-y-6" style="display: none;">
            <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-accent-blue"></i> Add Follow-up / Call Log
                </h4>
                <form action="{{ route('admin.crm.followup.store', $candidate->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Notes / Discussion Details <span class="text-red-500">*</span></label>
                        <textarea name="notes" rows="2" required placeholder="e.g. Spoke with candidate, agreed for demo on Monday..."
                                  class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue"></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Next Follow-up Date</label>
                            <input type="date" name="follow_up_date" 
                                   class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Status</label>
                            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                <option value="completed">Completed</option>
                                <option value="pending">Pending Next Call</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                            Log Follow-up
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
                <div class="p-4 border-b border-card-border bg-secondary-bg flex justify-between items-center">
                    <h4 class="text-xs font-black uppercase tracking-wider text-text-main">Follow-up History</h4>
                    <span class="text-xs font-bold text-text-dark/50">{{ $followUps->count() }} Total</span>
                </div>
                <div class="divide-y divide-card-border">
                    @forelse($followUps as $fu)
                        <div class="p-4 space-y-1 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-text-main">{{ $fu->admin->name ?? 'Admin' }}</span>
                                <span class="text-[10px] text-text-dark/40">{{ $fu->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            <p class="text-text-dark/80">{{ $fu->notes }}</p>
                            @if($fu->follow_up_date)
                                <p class="text-[10px] text-accent-blue font-bold">Next Follow-up: {{ \Carbon\Carbon::parse($fu->follow_up_date)->format('d M Y') }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-text-dark/50 text-xs">
                            <i class="fas fa-comments text-2xl mb-2 block text-text-dark/30"></i>
                            No follow-up notes logged yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- TAB 5: TIMELINE & RATING -->
        <div x-show="tab === 'timeline'" class="space-y-6" style="display: none;">
            <!-- Candidate Rating -->
            <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                    <i class="fas fa-star text-amber-500"></i> Performance Rating & Feedback
                </h4>
                <form action="{{ route('admin.crm.candidate.rate', $candidate->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="flex items-center gap-4">
                        <label class="text-xs font-bold text-text-main">Score:</label>
                        <select name="rating" class="bg-secondary-bg border border-card-border rounded-xl text-xs py-1.5 px-3 font-bold text-amber-600">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ ($rating?->rating == $i) ? 'selected' : '' }}>⭐ {{ $i }} Stars</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <input type="text" name="feedback" value="{{ $rating?->feedback }}" placeholder="Feedback regarding teaching skills, demo results, or communication..." 
                               class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                            Save Rating
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                <h4 class="text-sm font-black text-text-main mb-4">Activity Timeline</h4>
                <div class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-card-border">
                    @foreach($history as $item)
                        <div class="relative">
                            <div class="absolute -left-6 top-0 w-5 h-5 rounded-full {{ $item['color'] ?? 'bg-accent-blue' }} text-white text-[10px] flex items-center justify-center shadow-sm">
                                <i class="{{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-text-main">{{ $item['title'] }}</h5>
                                <p class="text-xs text-text-dark/60 mt-0.5">{{ $item['description'] }}</p>
                                <span class="text-[10px] text-text-dark/40 mt-1 block">{{ \Carbon\Carbon::parse($item['date'])->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Invoice Modal --}}
<div id="editInvoiceModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-[#031b4e] p-5 sm:p-6 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-amber-300">
                    <i class="fas fa-file-invoice-dollar text-base"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-300 block">Edit Placement Charge</span>
                    <h3 class="text-base font-bold text-white tracking-tight" id="editModalTitle">Edit Invoice</h3>
                </div>
            </div>
            <button type="button" onclick="closeEditInvoiceModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form id="editInvoiceForm" method="POST" action="" class="p-6 space-y-4 bg-white">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Amount -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Amount (₹) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="amount" id="editAmount" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-[#031b4e] font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Due Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="due_date" id="editDueDate" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="editStatus" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-pointer">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Description <span class="text-red-500">*</span>
                </label>
                <input type="text" name="description" id="editDesc" required placeholder="e.g. Placement Service Charge"
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Modal Footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeEditInvoiceModal()"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-save"></i>
                    <span>Update Invoice</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditInvoiceModal(invId, amount, dueDate, description, status) {
    const modal = document.getElementById('editInvoiceModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
    document.getElementById('editInvoiceForm').action = `/admin/tuition-service-charges/${invId}`;
    document.getElementById('editModalTitle').innerText = `Edit Invoice #${invId}`;
    document.getElementById('editAmount').value = amount;
    document.getElementById('editDueDate').value = dueDate;
    document.getElementById('editDesc').value = description;
    document.getElementById('editStatus').value = status;
    modal.classList.remove('hidden');
}

function closeEditInvoiceModal() {
    document.getElementById('editInvoiceModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editInvoiceModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeEditInvoiceModal();
            }
        });
    }
});
</script>

@endsection
