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

        @if($candidate->profile && $candidate->profile->tuition_upgrade_status === 'requested')
            <form action="{{ route('admin.crm.candidate.approve-tuition-upgrade', $candidate->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('Approve {{ addslashes($candidate->name) }} to join as a tuition teacher also?');"
                        style="background: linear-gradient(135deg, #d97706 0%, #ea580c 100%); color: #ffffff !important; border: none;"
                        class="px-4 py-2 text-white text-xs font-black rounded-xl transition-all flex items-center gap-1.5 shadow-md animate-pulse cursor-pointer">
                    <i class="fas fa-chalkboard-teacher text-white"></i> <span>Approve Tuition Upgrade</span>
                </button>
            </form>
        @endif

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

{{-- Tuition Upgrade Request Banner --}}
@if($profile && $profile->tuition_upgrade_status === 'requested')
    <div class="mb-6 bg-gradient-to-r from-amber-50 via-orange-50 to-amber-50 border-2 border-amber-400 rounded-3xl p-5 shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md">
                <i class="fas fa-chalkboard-teacher animate-bounce"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white shadow-xs">Upgrade Request Pending</span>
                    <span class="text-xs text-slate-500">Requested {{ $profile->tuition_upgrade_requested_at?->diffForHumans() ?? 'recently' }}</span>
                </div>
                <h3 class="text-base font-extrabold text-[#031b4e]">
                    Candidate Requested to Join as a Tuition Teacher Also
                </h3>
                <p class="text-xs text-slate-600 mt-0.5">
                    This candidate registered for <strong>School Jobs only</strong> and has submitted a request to also teach <strong>Home Tuitions</strong>. Click Approve to grant access and allow them to fill their tuition subjects, classes, and areas.
                </p>
            </div>
        </div>
        <form action="{{ route('admin.crm.candidate.approve-tuition-upgrade', $candidate->id) }}" method="POST" class="shrink-0">
            @csrf
            <button type="submit" onclick="return confirm('Approve {{ addslashes($candidate->name) }} to join as a tuition teacher?');"
                    style="background: #059669; color: #ffffff !important; border: none;"
                    class="px-5 py-2.5 hover:bg-emerald-700 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center gap-2 cursor-pointer">
                <i class="fas fa-check-circle text-sm text-white"></i>
                <span>Approve Tuition Upgrade</span>
            </button>
        </form>
    </div>
@elseif($profile && $profile->tuition_upgrade_status === 'approved')
    <div class="mb-6 bg-emerald-50 border border-emerald-300 rounded-2xl p-4 shadow-xs flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shrink-0">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-emerald-900">Tuition Upgrade Request Approved</h4>
                <p class="text-[11px] text-emerald-700">Candidate was approved on {{ $profile->tuition_upgrade_approved_at?->format('d M Y, h:i A') ?? 'N/A' }}. Waiting for candidate to complete tuition preferences on their dashboard.</p>
            </div>
        </div>
        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-black rounded-lg border border-emerald-300">Approved</span>
    </div>
@endif

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
                    <div class="mt-2 space-y-1 text-xs text-text-dark/70" x-data="{ editNumbersModal: false }">
                        <div class="flex items-center justify-between gap-1">
                            <p class="flex items-center gap-1.5">
                                <i class="fas fa-phone-alt text-[10px] text-text-dark/40"></i>
                                <a href="tel:{{ $candidate->phone }}" class="hover:text-accent-blue font-semibold">{{ $candidate->phone }}</a>
                            </p>
                            <button type="button" @click="editNumbersModal = true" class="text-[10px] text-accent-blue hover:text-blue-700 font-bold px-2 py-0.5 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors flex items-center gap-1" title="Change Phone or WhatsApp number">
                                <i class="fas fa-pen text-[9px]"></i> <span>Change</span>
                            </button>
                        </div>
                        @if($candidate->whatsapp_no || $profile?->whatsapp_no)
                            @php $wNo = preg_replace('/[^0-9]/', '', $candidate->whatsapp_no ?: $profile?->whatsapp_no); @endphp
                            <p class="flex items-center gap-1.5">
                                <i class="fab fa-whatsapp text-[11px] text-emerald-600"></i>
                                <a href="https://wa.me/{{ str_starts_with($wNo, '91') ? $wNo : '91'.$wNo }}" target="_blank" class="text-emerald-700 font-bold hover:underline">
                                    {{ $candidate->whatsapp_no ?: $profile?->whatsapp_no }}
                                </a>
                                @if(($candidate->whatsapp_no ?: $profile?->whatsapp_no) !== $candidate->phone)
                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">Different</span>
                                @endif
                            </p>
                        @endif
                        <p class="flex items-center gap-1.5 truncate">
                            <i class="fas fa-envelope text-[10px] text-text-dark/40"></i>
                            <a href="mailto:{{ $candidate->email }}" class="hover:text-accent-blue truncate">{{ $candidate->email }}</a>
                        </p>

                        {{-- Edit Numbers Modal --}}
                        <div x-show="editNumbersModal" 
                             x-cloak 
                             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
                             @keydown.escape.window="editNumbersModal = false">
                            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 relative text-left"
                                 @click.away="editNumbersModal = false">
                                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-black text-[#031b4e]">Update Contact Numbers</h3>
                                            <p class="text-[11px] text-slate-500">{{ $candidate->name }}</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="editNumbersModal = false" class="text-slate-400 hover:text-slate-700 text-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <form action="{{ route('admin.crm.candidate.update-numbers', $candidate->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">
                                            Mobile / Calling Number <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" name="phone" value="{{ old('phone', $candidate->phone) }}" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                               placeholder="10-digit mobile number"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/40">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">
                                            WhatsApp Number <span class="text-slate-400 font-normal lowercase text-[11px]">(Leave blank if same as mobile)</span>
                                        </label>
                                        <input type="tel" name="whatsapp_no" value="{{ old('whatsapp_no', $candidate->whatsapp_no ?: ($profile?->whatsapp_no ?? '')) }}" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                                               placeholder="Different 10-digit WhatsApp number"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                                    </div>

                                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                        <button type="button" @click="editNumbersModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-black text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all flex items-center gap-1.5">
                                            <i class="fas fa-check"></i> <span>Save Numbers</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] text-text-dark/50 block">Full Residential Address</span>
                                @if($profile?->google_maps_url)
                                    <a href="{{ $profile->google_maps_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20 text-[10px] font-bold border border-emerald-500/20 transition-all">
                                        <i class="fas fa-location-dot text-[9px]"></i> View on Google Maps
                                    </a>
                                @endif
                            </div>
                            <span class="font-medium text-text-main block mt-0.5">{{ $profile?->address ?? 'N/A' }}</span>
                            @if($profile?->latitude && $profile?->longitude)
                                <span class="text-[10px] text-text-dark/40 font-mono block mt-0.5">GPS: {{ number_format((float)$profile->latitude, 4) }}, {{ number_format((float)$profile->longitude, 4) }}</span>
                            @endif
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

                <!-- Candidate Documents & Identity Files Repository -->
                @php
                    $rawDocs = [
                        'resume' => [
                            'key'         => 'resume',
                            'title'       => 'Resume / CV',
                            'category'    => 'Professional',
                            'icon'        => 'fas fa-file-pdf',
                            'color'       => 'blue',
                            'bg_class'    => 'bg-blue-50/60',
                            'border_class'=> 'border-blue-200',
                            'text_class'  => 'text-blue-700',
                            'icon_bg'     => 'bg-blue-100 text-blue-700',
                            'path'        => $profile?->resume_path,
                            'is_uploaded' => !empty($profile?->resume_path) && Storage::disk('public')->exists($profile->resume_path),
                            'is_image'    => false,
                            'accept'      => '.pdf,.doc,.docx',
                            'hint'        => 'PDF, DOC, DOCX up to 10MB',
                        ],
                        'live_photo' => [
                            'key'         => 'live_photo',
                            'title'       => 'ID Card / Live Photo',
                            'category'    => 'Verification',
                            'icon'        => 'fas fa-id-card',
                            'color'       => 'emerald',
                            'bg_class'    => 'bg-emerald-50/60',
                            'border_class'=> 'border-emerald-200',
                            'text_class'  => 'text-emerald-700',
                            'icon_bg'     => 'bg-emerald-100 text-emerald-700',
                            'path'        => $profile?->live_photo_path ?: $profile?->tuition_live_photo_path,
                            'is_uploaded' => (!empty($profile?->live_photo_path) && Storage::disk('public')->exists($profile->live_photo_path)) || (!empty($profile?->tuition_live_photo_path) && Storage::disk('public')->exists($profile->tuition_live_photo_path)),
                            'is_image'    => true,
                            'accept'      => 'image/*',
                            'hint'        => 'Live selfie or Govt ID Card',
                        ],
                        'profile_photo' => [
                            'key'         => 'profile_photo',
                            'title'       => 'Profile / Passport Photo',
                            'category'    => 'Identity',
                            'icon'        => 'fas fa-user-circle',
                            'color'       => 'purple',
                            'bg_class'    => 'bg-purple-50/60',
                            'border_class'=> 'border-purple-200',
                            'text_class'  => 'text-purple-700',
                            'icon_bg'     => 'bg-purple-100 text-purple-700',
                            'path'        => $profile?->profile_photo_path ?: $profile?->passport_photo_path,
                            'is_uploaded' => (!empty($profile?->profile_photo_path) && Storage::disk('public')->exists($profile->profile_photo_path)) || (!empty($profile?->passport_photo_path) && Storage::disk('public')->exists($profile->passport_photo_path)),
                            'is_image'    => true,
                            'accept'      => 'image/*',
                            'hint'        => 'Passport size photo',
                        ],
                        'salary_slip' => [
                            'key'         => 'salary_slip',
                            'title'       => 'Salary Slip',
                            'category'    => 'Financial',
                            'icon'        => 'fas fa-file-invoice-dollar',
                            'color'       => 'amber',
                            'bg_class'    => 'bg-amber-50/60',
                            'border_class'=> 'border-amber-200',
                            'text_class'  => 'text-amber-700',
                            'icon_bg'     => 'bg-amber-100 text-amber-700',
                            'path'        => $profile?->salary_slip_path,
                            'is_uploaded' => !empty($profile?->salary_slip_path) && Storage::disk('public')->exists($profile->salary_slip_path),
                            'is_image'    => in_array(strtolower(pathinfo($profile?->salary_slip_path ?? '', PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp']),
                            'accept'      => '.pdf,image/*',
                            'hint'        => 'Latest salary slip',
                        ],
                        'offer_letter' => [
                            'key'         => 'offer_letter',
                            'title'       => 'Offer / Experience Letter',
                            'category'    => 'Experience',
                            'icon'        => 'fas fa-file-contract',
                            'color'       => 'sky',
                            'bg_class'    => 'bg-sky-50/60',
                            'border_class'=> 'border-sky-200',
                            'text_class'  => 'text-sky-700',
                            'icon_bg'     => 'bg-sky-100 text-sky-700',
                            'path'        => $profile?->offer_letter_path,
                            'is_uploaded' => !empty($profile?->offer_letter_path) && Storage::disk('public')->exists($profile->offer_letter_path),
                            'is_image'    => in_array(strtolower(pathinfo($profile?->offer_letter_path ?? '', PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp']),
                            'accept'      => '.pdf,image/*',
                            'hint'        => 'Experience / Relieving / Offer letter',
                        ],
                        'agreement_pdf' => [
                            'key'         => 'agreement_pdf',
                            'title'       => 'Physical Agreement (PDF)',
                            'category'    => 'Legal',
                            'icon'        => 'fas fa-file-signature',
                            'color'       => 'teal',
                            'bg_class'    => 'bg-teal-50/60',
                            'border_class'=> 'border-teal-200',
                            'text_class'  => 'text-teal-700',
                            'icon_bg'     => 'bg-teal-100 text-teal-700',
                            'path'        => $profile?->agreement_pdf_path,
                            'is_uploaded' => !empty($profile?->agreement_pdf_path) && Storage::disk('public')->exists($profile->agreement_pdf_path),
                            'is_image'    => false,
                            'accept'      => '.pdf',
                            'hint'        => 'Signed physical agreement PDF',
                        ],
                    ];

                    $totalDocCount = count($rawDocs);
                    $uploadedDocCount = collect($rawDocs)->where('is_uploaded', true)->count();
                    $missingDocCount = $totalDocCount - $uploadedDocCount;
                @endphp

                <div class="pt-3 border-t border-card-border space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-wider text-text-main flex items-center gap-1.5">
                                <i class="fas fa-folder-open text-accent-blue"></i>
                                <span>Uploaded Documents</span>
                            </h4>
                            <p class="text-[10px] text-text-dark/50">Candidate files & digital certificates</p>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full {{ $uploadedDocCount > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $uploadedDocCount }}/{{ $totalDocCount }} Uploaded
                            </span>
                            <button type="button" onclick="openUploadDocModal()" class="px-2.5 py-1 bg-accent-blue hover:bg-blue-700 text-white rounded-lg text-[10px] font-bold transition-all shadow-2xs flex items-center gap-1 cursor-pointer">
                                <i class="fas fa-upload text-[9px]"></i> Upload
                            </button>
                        </div>
                    </div>

                    <!-- Document Cards List -->
                    <div class="space-y-2">
                        @foreach($rawDocs as $doc)
                            @if($doc['is_uploaded'])
                                <div class="p-2.5 {{ $doc['bg_class'] }} border {{ $doc['border_class'] }} rounded-xl transition-all hover:shadow-xs flex items-center justify-between gap-2.5">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        @if($doc['is_image'])
                                            <div class="relative group cursor-pointer shrink-0" data-img-url="{{ Storage::url($doc['path']) }}" data-img-title="{{ $doc['title'] }}" onclick="openImagePreviewModal(this.dataset.imgUrl, this.dataset.imgTitle)">
                                                <img src="{{ Storage::url($doc['path']) }}" alt="{{ $doc['title'] }}" class="w-10 h-10 rounded-lg object-cover border border-emerald-300 shadow-2xs">
                                                <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity text-white text-[9px]">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-lg {{ $doc['icon_bg'] }} border {{ $doc['border_class'] }} flex items-center justify-center text-base shrink-0 shadow-2xs">
                                                <i class="{{ $doc['icon'] }}"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-xs font-bold text-text-main truncate">{{ $doc['title'] }}</span>
                                                <span class="text-[9px] font-black uppercase px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800">
                                                    Uploaded
                                                </span>
                                            </div>
                                            <p class="text-[10px] text-text-dark/50 truncate">{{ strtoupper(pathinfo($doc['path'], PATHINFO_EXTENSION)) }} Document &bull; Verified</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <a href="{{ Storage::url($doc['path']) }}" target="_blank" class="px-2 py-1 bg-white hover:bg-slate-50 border border-card-border rounded-lg text-[10px] font-bold text-text-main transition-colors flex items-center gap-1 shadow-2xs">
                                            <i class="fas fa-external-link-alt text-[9px] text-accent-blue"></i>
                                            <span>View</span>
                                        </a>
                                        <button type="button" data-doc-key="{{ $doc['key'] }}" onclick="openUploadDocModal(this.dataset.docKey)" title="Replace Document" class="w-6 h-6 rounded-lg bg-white hover:bg-slate-100 border border-card-border text-text-dark/60 hover:text-text-main flex items-center justify-center text-[10px] transition-colors cursor-pointer">
                                            <i class="fas fa-sync-alt text-[9px]"></i>
                                        </button>
                                        <button type="button" data-doc-key="{{ $doc['key'] }}" data-doc-title="{{ $doc['title'] }}" onclick="confirmDeleteDocument(this.dataset.docKey, this.dataset.docTitle)" title="Delete Document" class="w-6 h-6 rounded-lg bg-white hover:bg-red-50 border border-card-border hover:border-red-200 text-text-dark/40 hover:text-red-600 flex items-center justify-center text-[10px] transition-colors cursor-pointer">
                                            <i class="fas fa-trash-alt text-[9px]"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="p-2.5 bg-slate-50/60 border border-dashed border-slate-300 rounded-xl flex items-center justify-between gap-2.5 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-10 h-10 rounded-lg bg-slate-200/60 text-slate-400 border border-slate-200 flex items-center justify-center text-base shrink-0">
                                            <i class="{{ $doc['icon'] }}"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-xs font-bold text-slate-600 truncate">{{ $doc['title'] }}</span>
                                                <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                                    Missing
                                                </span>
                                            </div>
                                            <p class="text-[10px] text-slate-400 truncate">{{ $doc['hint'] }}</p>
                                        </div>
                                    </div>
                                    <button type="button" data-doc-key="{{ $doc['key'] }}" onclick="openUploadDocModal(this.dataset.docKey)" class="px-2.5 py-1 bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-slate-700 hover:text-blue-700 rounded-lg text-[10px] font-bold transition-all shadow-2xs flex items-center gap-1 shrink-0 cursor-pointer">
                                        <i class="fas fa-plus text-[9px]"></i>
                                        <span>Upload</span>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Digital Agreements Quick Links within Documents Section --}}
                    @php
                        $hasTuitionAgreement = ($profile?->tuition_agreement_status === 'signed' || $profile?->is_tuition_agreement_signed);
                        $hasSchoolAgreement = ($profile?->is_agreement_signed || $profile?->agreement_status === 'signed');
                    @endphp

                    @if($hasTuitionAgreement || $hasSchoolAgreement)
                        <div class="pt-2 border-t border-card-border space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-text-dark/50 block">Signed Digital Agreements</span>
                            
                            @if($hasTuitionAgreement)
                                <div class="p-2.5 bg-teal-50/80 border border-teal-200 rounded-xl flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-teal-600 text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-bold text-teal-900 truncate">Home Tuition Agreement</span>
                                                <span class="text-[8px] font-black uppercase px-1.5 py-0.2 bg-teal-200/80 text-teal-900 rounded">Signed</span>
                                            </div>
                                            <p class="text-[9px] text-teal-700 truncate">
                                                @if($profile?->tuition_agreement_signed_at)
                                                    {{ \Carbon\Carbon::parse($profile->tuition_agreement_signed_at)->format('d M Y, h:i A') }}
                                                @else
                                                    Verified Digital Signature
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="openTuitionAgreementModal()" class="px-2 py-1 bg-white hover:bg-teal-100/60 border border-teal-300 text-teal-800 rounded-lg text-[10px] font-bold transition-all shadow-2xs flex items-center gap-1 shrink-0 cursor-pointer">
                                        <i class="fas fa-file-contract text-teal-600 text-[9px]"></i>
                                        <span>View</span>
                                    </button>
                                </div>
                            @endif

                            @if($hasSchoolAgreement)
                                <div class="p-2.5 bg-indigo-50/80 border border-indigo-200 rounded-xl flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs shrink-0 shadow-2xs">
                                            <i class="fas fa-school"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-bold text-indigo-900 truncate">School Job Placement Agreement</span>
                                                <span class="text-[8px] font-black uppercase px-1.5 py-0.2 bg-indigo-200/80 text-indigo-900 rounded">Signed</span>
                                            </div>
                                            <p class="text-[9px] text-indigo-700 truncate">
                                                @if($profile?->signature_date_time)
                                                    {{ \Carbon\Carbon::parse($profile->signature_date_time)->format('d M Y, h:i A') }}
                                                @else
                                                    Verified Digital Signature
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="openSchoolAgreementModal()" class="px-2 py-1 bg-white hover:bg-indigo-100/60 border border-indigo-300 text-indigo-800 rounded-lg text-[10px] font-bold transition-all shadow-2xs flex items-center gap-1 shrink-0 cursor-pointer">
                                        <i class="fas fa-file-contract text-indigo-600 text-[9px]"></i>
                                        <span>View</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
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
    <div class="lg:col-span-2 space-y-6" x-data="{ tab: '{{ request('tab', 'jobs') }}' }">
        <!-- Tab Navigation -->
        <div class="bg-card-bg border border-card-border rounded-2xl p-1.5 flex gap-1 shadow-sm overflow-x-auto">
            <button @click="tab = 'jobs'" :class="tab === 'jobs' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-school"></i> <span>School Jobs ({{ $candidate->applications->count() }})</span>
            </button>
            <button @click="tab = 'tuitions'" :class="tab === 'tuitions' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-chalkboard-teacher"></i> <span>Home Tuitions ({{ $tuitionApplications->count() }})</span>
            </button>
            <button @click="tab = 'documents'" :class="tab === 'documents' ? 'bg-accent-blue text-white shadow-sm' : 'text-text-dark/60 hover:text-text-main'" class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fas fa-folder-open"></i> <span>Documents & Files ({{ $uploadedDocCount }})</span>
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
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full {{ $app->status_badge_class }}">
                                        {{ $app->status_label }}
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
                                            <option value="applied" {{ $app->status === 'applied' ? 'selected' : '' }}>New applied</option>
                                            <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                            <option value="forwarded_to_school" {{ $app->status === 'forwarded_to_school' ? 'selected' : '' }}>Forwarded to school/institute</option>
                                            <option value="demo_scheduled" {{ $app->status === 'demo_scheduled' ? 'selected' : '' }}>Demo scheduled</option>
                                            <option value="hired" {{ $app->status === 'hired' ? 'selected' : '' }}>Selected/hired</option>
                                            <option value="rejected_by_school" {{ $app->status === 'rejected_by_school' ? 'selected' : '' }}>Rejected by school/institute</option>
                                            <option value="tutor_backed_out" {{ $app->status === 'tutor_backed_out' ? 'selected' : '' }}>Tutor backed out</option>
                                            <option value="rejected_by_admin" {{ in_array($app->status, ['rejected_by_admin', 'rejected']) ? 'selected' : '' }}>Rejected by admin</option>
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
                                <input type="checkbox" name="create_service_charge" value="1" class="w-4 h-4 text-emerald-600 rounded">
                                <span class="text-xs font-bold text-text-main">Generate Tuition Service Charge Invoice</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="w-36">
                                    <input type="number" name="service_charge_amount" value="500" min="0" placeholder="Amount ₹" 
                                           class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-1.5 px-3 text-text-main font-bold">
                                </div>
                                <span class="text-[10px] text-text-dark/60">Candidate will see this invoice under Tuition Service Charges (only created if checked).</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="submit" onclick="this.classList.add('opacity-50','pointer-events-none');" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
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
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Issue Invoice Card -->
                <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                    <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-accent-blue"></i> Issue Placement Service Charge Invoice
                    </h4>
                    <form action="{{ route('admin.crm.invoice.store', $candidate->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Invoice Amount (₹) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="amount" required placeholder="e.g. 1500" 
                                       class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Due Date <span class="text-red-500">*</span></label>
                                <input type="date" name="due_date" required 
                                       class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Description</label>
                                <input type="text" name="description" placeholder="e.g. Placement Service Charge" 
                                       class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                Create Invoice
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Issue Refund Card -->
                <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-sm">
                    <h4 class="text-sm font-black text-text-main mb-3 flex items-center gap-2">
                        <i class="fas fa-undo-alt text-amber-500"></i> Log a Refund
                    </h4>
                    <form action="{{ route('admin.crm.refund.store', $candidate->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Refund Amount (₹) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="amount" required placeholder="e.g. 500" 
                                       class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Reason / Description <span class="text-red-500">*</span></label>
                                <input type="text" name="description" required placeholder="e.g. Refunded due to cancelled tuition" 
                                       class="w-full bg-secondary-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                Send Refund
                            </button>
                        </div>
                    </form>
                </div>
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

            <!-- Refunds List -->
            <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden mt-6">
                <div class="p-4 border-b border-card-border bg-amber-50/50 flex justify-between items-center">
                    <h4 class="text-sm font-black text-text-main uppercase tracking-wider">Refund History</h4>
                    <span class="text-xs font-bold text-text-dark/50">{{ $refunds->count() }} Total</span>
                </div>
                <div class="divide-y divide-card-border">
                    @forelse($refunds as $ref)
                        <div class="p-4 hover:bg-secondary-bg/30 transition-colors flex items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-sm text-text-main">₹{{ number_format($ref->amount, 2) }}</span>
                                    <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-700 text-[10px] font-bold">Refunded</span>
                                </div>
                                <p class="text-xs text-text-dark/60 mt-0.5">{{ $ref->description }}</p>
                                <p class="text-[10px] text-text-dark/40 mt-1 flex items-center gap-1">
                                    <i class="fas fa-user-shield text-[9px]"></i> By: {{ $ref->admin->name ?? 'Admin' }}
                                    <span class="mx-1">•</span>
                                    <i class="fas fa-clock text-[9px]"></i> {{ $ref->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-text-dark/50 text-xs">
                            <i class="fas fa-undo-alt text-2xl mb-2 block text-text-dark/30"></i>
                            No refunds recorded for this candidate.
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
                                <option value="open">Open / Pending Next Call</option>
                                <option value="closed">Closed / Completed</option>
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

        <!-- TAB 6: DOCUMENTS & VERIFICATION AUDIT -->
        <div x-show="tab === 'documents'" class="space-y-6" style="display: none;">
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-card-bg p-3.5 rounded-2xl border border-card-border shadow-2xs">
                    <span class="text-[10px] font-bold uppercase text-text-dark/50 block">Total Files</span>
                    <h4 class="text-xl font-black text-text-main mt-0.5">{{ $totalDocCount }}</h4>
                    <span class="text-[10px] text-text-dark/60">Candidate Repository</span>
                </div>
                <div class="bg-card-bg p-3.5 rounded-2xl border border-card-border shadow-2xs">
                    <span class="text-[10px] font-bold uppercase text-text-dark/50 block">Uploaded & Valid</span>
                    <h4 class="text-xl font-black text-emerald-600 mt-0.5">{{ $uploadedDocCount }}</h4>
                    <span class="text-[10px] text-emerald-700/80 font-bold">Verified on system</span>
                </div>
                <div class="bg-card-bg p-3.5 rounded-2xl border border-card-border shadow-2xs">
                    <span class="text-[10px] font-bold uppercase text-text-dark/50 block">Missing Documents</span>
                    <h4 class="text-xl font-black {{ $missingDocCount > 0 ? 'text-amber-500' : 'text-slate-400' }} mt-0.5">{{ $missingDocCount }}</h4>
                    <span class="text-[10px] text-text-dark/60">{{ $missingDocCount > 0 ? 'Action required' : 'All clear' }}</span>
                </div>
                <div class="bg-card-bg p-3.5 rounded-2xl border border-card-border shadow-2xs">
                    <span class="text-[10px] font-bold uppercase text-text-dark/50 block">Agreements Signed</span>
                    <h4 class="text-xl font-black text-blue-600 mt-0.5">{{ ($hasTuitionAgreement ? 1 : 0) + ($hasSchoolAgreement ? 1 : 0) }}</h4>
                    <span class="text-[10px] text-blue-700/80 font-bold">Digital Contracts</span>
                </div>
            </div>

            <!-- Full Document Management Grid -->
            <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-card-border bg-secondary-bg flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-sm font-bold shadow-2xs">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-text-main">Candidate Document Dossier</h3>
                            <p class="text-xs text-text-dark/50">Direct preview, download and instant file upload/replacement.</p>
                        </div>
                    </div>
                    <button type="button" onclick="openUploadDocModal()" class="px-3.5 py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Upload Any Document</span>
                    </button>
                </div>

                <div class="p-4 sm:p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($rawDocs as $doc)
                        <div class="p-4 rounded-2xl border {{ $doc['is_uploaded'] ? $doc['border_class'] . ' ' . $doc['bg_class'] : 'border-dashed border-card-border bg-secondary-bg/50' }} flex flex-col justify-between gap-3 transition-all">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-start gap-3 min-w-0">
                                    @if($doc['is_uploaded'] && $doc['is_image'])
                                        <div class="relative group cursor-pointer shrink-0" data-img-url="{{ Storage::url($doc['path']) }}" data-img-title="{{ $doc['title'] }}" onclick="openImagePreviewModal(this.dataset.imgUrl, this.dataset.imgTitle)">
                                            <img src="{{ Storage::url($doc['path']) }}" alt="{{ $doc['title'] }}" class="w-14 h-14 rounded-xl object-cover border-2 border-white shadow-sm">
                                            <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition-opacity">
                                                <i class="fas fa-search-plus"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 rounded-xl {{ $doc['is_uploaded'] ? $doc['icon_bg'] : 'bg-card-border/40 text-text-dark/40' }} flex items-center justify-center text-xl shrink-0 shadow-2xs">
                                            <i class="{{ $doc['icon'] }}"></i>
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <h5 class="text-xs font-black text-text-main truncate">{{ $doc['title'] }}</h5>
                                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full {{ $doc['is_uploaded'] ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $doc['is_uploaded'] ? 'Verified & On File' : 'Not Uploaded' }}
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-text-dark/60 mt-1 leading-snug">{{ $doc['hint'] }}</p>
                                        @if($doc['is_uploaded'])
                                            <p class="text-[10px] font-mono text-text-dark/40 mt-1 truncate">
                                                Path: {{ $doc['path'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t {{ $doc['is_uploaded'] ? 'border-card-border/60' : 'border-card-border' }} flex items-center justify-between gap-2">
                                @if($doc['is_uploaded'])
                                    <div class="flex items-center gap-2">
                                        <a href="{{ Storage::url($doc['path']) }}" target="_blank" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-card-border text-text-main rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5">
                                            <i class="fas fa-external-link-alt text-accent-blue text-[10px]"></i>
                                            <span>Open File</span>
                                        </a>
                                        <a href="{{ Storage::url($doc['path']) }}" download class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-card-border text-text-dark/70 rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5">
                                            <i class="fas fa-download text-[10px]"></i>
                                            <span>Download</span>
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" data-doc-key="{{ $doc['key'] }}" onclick="openUploadDocModal(this.dataset.docKey)" class="px-2.5 py-1.5 bg-white hover:bg-slate-100 border border-card-border text-text-dark/70 rounded-xl text-xs font-bold transition-colors cursor-pointer flex items-center gap-1">
                                            <i class="fas fa-sync-alt text-[10px]"></i>
                                            <span>Replace</span>
                                        </button>
                                        <button type="button" data-doc-key="{{ $doc['key'] }}" data-doc-title="{{ $doc['title'] }}" onclick="confirmDeleteDocument(this.dataset.docKey, this.dataset.docTitle)" class="p-1.5 bg-white hover:bg-red-50 border border-card-border hover:border-red-200 text-text-dark/40 hover:text-red-600 rounded-xl transition-colors cursor-pointer" title="Delete">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-[11px] text-amber-700/80 font-medium italic">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Document pending
                                    </span>
                                    <button type="button" data-doc-key="{{ $doc['key'] }}" onclick="openUploadDocModal(this.dataset.docKey)" class="px-3.5 py-1.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5 cursor-pointer">
                                        <i class="fas fa-plus"></i>
                                        <span>Upload Now</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Digital Agreements & E-Signatures Dossier -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Home Tuition Agreement Card -->
                <div class="bg-card-bg rounded-2xl border {{ $hasTuitionAgreement ? 'border-teal-300 bg-teal-50/20' : 'border-card-border' }} p-5 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center text-base shadow-2xs">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-text-main">Home Tuition Agreement</h4>
                                <span class="text-[10px] text-text-dark/50">Tutor Service Terms & Conditions</span>
                            </div>
                        </div>
                        @if($hasTuitionAgreement)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-teal-100 text-teal-800 border border-teal-200">
                                <i class="fas fa-check-circle mr-0.5"></i> Signed & Valid
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold text-text-dark/50 bg-slate-100">
                                Not Signed
                            </span>
                        @endif
                    </div>
                    
                    @if($hasTuitionAgreement)
                        <div class="p-3 bg-white rounded-xl border border-teal-200 text-xs space-y-1">
                            <p class="font-bold text-teal-900 flex items-center gap-1.5">
                                <i class="fas fa-signature text-teal-600"></i> Digitally Signed by {{ $candidate->name }}
                            </p>
                            @if($profile?->tuition_agreement_signed_at)
                                <p class="text-[11px] text-text-dark/60">Date: {{ \Carbon\Carbon::parse($profile->tuition_agreement_signed_at)->format('d M Y, h:i A') }}</p>
                            @endif
                            @if(!empty($profile?->tuition_location_name) || !empty($tuitionMeta['location']))
                                <p class="text-[11px] text-text-dark/70">📍 Location: {{ $profile?->tuition_location_name ?? ($tuitionMeta['location'] ?? 'Captured') }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <button type="button" onclick="openTuitionAgreementModal()" class="flex-1 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fas fa-eye text-xs"></i>
                                <span>View Agreement Sheet</span>
                            </button>
                            <button type="button" onclick="printTuitionAgreement()" class="px-3 py-2 bg-white hover:bg-teal-50 border border-teal-300 text-teal-800 rounded-xl text-xs font-bold transition-colors shadow-2xs flex items-center gap-1 cursor-pointer">
                                <i class="fas fa-print"></i>
                                <span>Print</span>
                            </button>
                        </div>
                    @else
                        <p class="text-xs text-text-dark/60">Candidate has not signed the Home Tuition agreement yet. You can unlock signing in the signing control card on the left column.</p>
                    @endif
                </div>

                <!-- School Placement Agreement Card -->
                <div class="bg-card-bg rounded-2xl border {{ $hasSchoolAgreement ? 'border-indigo-300 bg-indigo-50/20' : 'border-card-border' }} p-5 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-base shadow-2xs">
                                <i class="fas fa-school"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-text-main">Teacher Placement Agreement</h4>
                                <span class="text-[10px] text-text-dark/50">School Recruitment Terms</span>
                            </div>
                        </div>
                        @if($hasSchoolAgreement)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-indigo-100 text-indigo-800 border border-indigo-200">
                                <i class="fas fa-check-circle mr-0.5"></i> Signed & Valid
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold text-text-dark/50 bg-slate-100">
                                Not Signed
                            </span>
                        @endif
                    </div>

                    @if($hasSchoolAgreement)
                        <div class="p-3 bg-white rounded-xl border border-indigo-200 text-xs space-y-1">
                            <p class="font-bold text-indigo-900 flex items-center gap-1.5">
                                <i class="fas fa-signature text-indigo-600"></i> Digitally Signed by {{ $candidate->name }}
                            </p>
                            @if($profile?->signature_date_time)
                                <p class="text-[11px] text-text-dark/60">Date: {{ \Carbon\Carbon::parse($profile->signature_date_time)->format('d M Y, h:i A') }}</p>
                            @endif
                            @if($profile?->agreement_pdf_path)
                                <p class="text-[11px] text-emerald-700 font-bold">📄 Physical Signed Copy Attached (PDF)</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            @if($profile?->agreement_pdf_path)
                                <a href="{{ Storage::url($profile->agreement_pdf_path) }}" target="_blank" class="flex-1 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>View Uploaded PDF Copy</span>
                                </a>
                            @else
                                <button type="button" onclick="openSchoolAgreementModal()" class="flex-1 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="fas fa-eye text-xs"></i>
                                    <span>View Agreement Sheet</span>
                                </button>
                                <button type="button" onclick="printSchoolAgreement()" class="px-3 py-2 bg-white hover:bg-indigo-50 border border-indigo-300 text-indigo-800 rounded-xl text-xs font-bold transition-colors shadow-2xs flex items-center gap-1 cursor-pointer">
                                    <i class="fas fa-print"></i>
                                    <span>Print</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <p class="text-xs text-text-dark/60">School job placement agreement is not signed yet.</p>
                    @endif
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

{{-- Hidden Delete Document Form --}}
<form id="deleteDocumentForm" action="{{ route('admin.crm.candidate.delete-document', $candidate->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
    <input type="hidden" name="document_type" id="deleteDocTypeInput">
</form>

{{-- Upload Candidate Document Modal --}}
<div id="uploadDocumentModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-[#031b4e] p-5 sm:p-6 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-accent-blue">
                    <i class="fas fa-file-upload text-base"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-sky-400 block">Candidate Dossier</span>
                    <h3 class="text-base font-bold text-white tracking-tight" id="uploadModalTitle">Upload Candidate Document</h3>
                </div>
            </div>
            <button type="button" onclick="closeUploadDocModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.crm.candidate.upload-document', $candidate->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 bg-white">
            @csrf

            <!-- Document Type Selection -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Select Document Type <span class="text-red-500">*</span>
                </label>
                <select name="document_type" id="uploadDocTypeSelect" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-pointer">
                    <option value="resume">Resume / Curriculum Vitae (PDF, DOCX)</option>
                    <option value="live_photo">Government ID Card / Verification Photo (JPG, PNG)</option>
                    <option value="profile_photo">Profile / Passport Photo (JPG, PNG)</option>
                    <option value="salary_slip">Salary Slip / Proof of Income (PDF, Image)</option>
                    <option value="offer_letter">Offer Letter / Experience Letter (PDF, Image)</option>
                    <option value="agreement_pdf">Signed Physical Agreement Copy (PDF)</option>
                </select>
            </div>

            <!-- File Input Area -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Choose File <span class="text-red-500">*</span>
                </label>
                <div class="relative border-2 border-dashed border-slate-200 hover:border-blue-400 bg-slate-50 hover:bg-blue-50/20 rounded-2xl p-6 text-center transition-all cursor-pointer">
                    <input type="file" name="document_file" id="uploadDocFileInput" required
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           onchange="handleDocFileChange(this)">
                    <div id="uploadDocDropzoneContent" class="space-y-1.5 pointer-events-none">
                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-1"></i>
                        <p class="text-xs font-bold text-slate-700" id="uploadDocFileName">Click or drag & drop file to upload</p>
                        <p class="text-[10px] text-slate-400">PDF, DOC, DOCX, JPG, PNG up to 10MB</p>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-blue-50/70 rounded-xl border border-blue-200/60 text-xs text-blue-900 space-y-1">
                <p class="font-bold flex items-center gap-1.5"><i class="fas fa-shield-alt text-blue-600"></i> Instant Profile Synchronization</p>
                <p class="text-[11px] text-blue-800/80">The document will be securely saved into the candidate profile and made available immediately across all administrative workflows.</p>
            </div>

            <!-- Modal Footer -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeUploadDocModal()"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-accent-blue hover:bg-blue-700 shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Upload Document</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Image Preview Lightbox Modal --}}
<div id="imagePreviewModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4" onclick="closeImagePreviewModal()">
    <div class="relative max-w-3xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200" onclick="event.stopPropagation()">
        <div class="bg-[#031b4e] p-4 text-white flex items-center justify-between">
            <h4 id="imagePreviewTitle" class="text-sm font-bold text-white">Document Preview</h4>
            <button type="button" onclick="closeImagePreviewModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="p-4 flex items-center justify-center max-h-[75vh] overflow-auto bg-slate-100">
            <img id="imagePreviewSrc" src="" alt="Preview" class="max-h-[70vh] w-auto rounded-xl shadow-md border border-slate-200 object-contain">
        </div>
        <div class="p-3 border-t border-slate-100 flex items-center justify-end gap-2 bg-white">
            <a id="imagePreviewDownload" href="" target="_blank" class="px-4 py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-external-link-alt text-[10px]"></i> Open Full Image
            </a>
        </div>
    </div>
</div>

{{-- Home Tuition Agreement Viewer Modal --}}
<div id="tuitionAgreementModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[92vh] shadow-2xl flex flex-col overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-[#031b4e] p-4 sm:p-5 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-teal-300">
                    <i class="fas fa-chalkboard-teacher text-base"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-teal-300 block">Digital Legal Document</span>
                    <h3 class="text-base font-bold text-white tracking-tight">Home Tuition – Tutor Service Agreement</h3>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="printTuitionAgreement()" class="px-3.5 py-1.5 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-print"></i>
                    <span>Print Agreement</span>
                </button>
                <button type="button" onclick="closeTuitionAgreementModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Scrollable Printable Agreement Body -->
        <div id="printableTuitionAgreement" class="p-4 sm:p-8 overflow-y-auto custom-scrollbar text-[#031b4e]/90 text-xs sm:text-sm space-y-4 bg-white flex-1">
            <div class="text-center border-b-2 border-[#031b4e] pb-4">
                <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" alt="Warriors Educare Logo" style="max-height: 70px; margin: 0 auto 10px auto;">
                <h2 class="text-xl sm:text-2xl font-bold text-[#031b4e]">WARRIORS EDUCARE</h2>
                <h3 class="text-base sm:text-lg font-semibold text-[#031b4e]">HOME TUITION – TUTOR SERVICE AGREEMENT</h3>
            </div>

            <!-- Candidate Details & Live Verification Photo -->
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="space-y-1.5 text-xs sm:text-sm">
                    <p><strong>Candidate Name:</strong> {{ $candidate->name }}</p>
                    <p><strong>Email:</strong> {{ $candidate->email }}</p>
                    <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
                    <p><strong>Address:</strong> {{ $profile?->address ?? 'Not specified' }}</p>
                    @if(!empty($profile?->tuition_location_name) || !empty($tuitionMeta['location']))
                        <p class="text-teal-800 font-medium"><strong>Signing Location:</strong> 📍 {{ $profile?->tuition_location_name ?? ($tuitionMeta['location'] ?? 'Captured') }}</p>
                    @endif
                    @if($profile?->tuition_agreement_signed_at)
                        <p class="text-slate-600"><strong>Signed At:</strong> {{ \Carbon\Carbon::parse($profile->tuition_agreement_signed_at)->format('d M Y, h:i:s A') }}</p>
                    @endif
                </div>

                @php
                    $tPhoto = $profile?->tuition_live_photo_path ?? $profile?->live_photo_path;
                @endphp
                @if($tPhoto && Storage::disk('public')->exists($tPhoto))
                    <div class="shrink-0 text-center self-center sm:self-auto">
                        <img src="{{ Storage::url($tPhoto) }}" alt="Candidate Live Verification" class="w-20 h-24 object-cover border-2 border-emerald-500 rounded-xl shadow-sm">
                        <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-full">
                            Live Photo Verified
                        </span>
                    </div>
                @endif
            </div>

            <p class="text-slate-700">This Agreement is entered into voluntarily between <strong>Warriors Educare</strong> ("Agency") and the undersigned Candidate ("Tutor").</p>

            <div class="space-y-3 text-slate-700 leading-relaxed text-xs">
                <div>
                    <h5 class="font-bold text-[#031b4e]">1. Purpose of Agreement</h5>
                    <p>This Agreement confirms that the Candidate voluntarily authorizes Warriors Educare to provide home tuition opportunities and to begin the tutor placement process.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">2. Candidate Declaration</h5>
                    <p>The Candidate declares that all information and documents provided are true and genuine. Any false information or forged documents may result in immediate cancellation of registration without any refund.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">3. Registration Fee & Validity</h5>
                    <p>The Candidate agrees to pay the prescribed registration fee. Registration shall remain valid for 1 (One) Year from the date of registration.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">4. Placement & Service Charge</h5>
                    <p>The Candidate agrees to pay the agreed placement service charge upon confirmation of tuition leads as per agency terms.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">5. Code of Conduct & Safety</h5>
                    <p>The Candidate agrees to maintain the highest standards of professionalism, integrity, and safety while teaching students at their residences.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">6. Legal Jurisdiction</h5>
                    <p>Any dispute arising out of this Agreement shall be subject to the exclusive jurisdiction of the competent courts in Patna, Bihar.</p>
                </div>
            </div>

            <!-- Verification Signature Footer -->
            <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-center sm:text-left">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Candidate E-Signature</span>
                    <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl min-w-[160px] text-center">
                        @if(!empty($adminSig) && str_starts_with($adminSig, 'data:image'))
                            <img src="{{ $adminSig }}" alt="Signature" class="max-h-12 mx-auto">
                        @elseif(!empty($adminSig) && Storage::disk('public')->exists($adminSig))
                            <img src="{{ asset('storage/' . $adminSig) }}" alt="Signature" class="max-h-12 mx-auto">
                        @elseif(!empty($adminSig))
                            <span class="text-lg font-serif italic text-blue-900 font-bold" style="font-family: 'Brush Script MT', 'Dancing Script', cursive;">{{ $adminSig }}</span>
                        @else
                            <span class="text-xs font-bold text-slate-400">Digitally Verified</span>
                        @endif
                    </div>
                    <span class="text-[10px] text-slate-500 font-semibold block mt-1">{{ $candidate->name }}</span>
                </div>

                <div class="text-center sm:text-right">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Authorized Agency Seal</span>
                    <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl min-w-[160px] text-center">
                        <span class="text-xs font-black uppercase text-blue-900 tracking-wider">Warriors Educare</span>
                        <span class="text-[9px] text-emerald-700 block font-bold">Verified Administrator</span>
                    </div>
                    <span class="text-[10px] text-slate-500 font-semibold block mt-1">Official Verification Stamp</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- School Placement Agreement Viewer Modal --}}
<div id="schoolAgreementModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[92vh] shadow-2xl flex flex-col overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-[#031b4e] p-4 sm:p-5 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-indigo-300">
                    <i class="fas fa-school text-base"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-300 block">Digital Legal Document</span>
                    <h3 class="text-base font-bold text-white tracking-tight">Teacher Placement Service Agreement</h3>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="printSchoolAgreement()" class="px-3.5 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-print"></i>
                    <span>Print Agreement</span>
                </button>
                <button type="button" onclick="closeSchoolAgreementModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Scrollable Printable Agreement Body -->
        <div id="printableSchoolAgreement" class="p-4 sm:p-8 overflow-y-auto custom-scrollbar text-[#031b4e]/90 text-xs sm:text-sm space-y-4 bg-white flex-1">
            <div class="text-center border-b-2 border-[#031b4e] pb-4">
                <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" alt="Warriors Educare Logo" style="max-height: 70px; margin: 0 auto 10px auto;">
                <h2 class="text-xl sm:text-2xl font-bold text-[#031b4e]">WARRIORS EDUCARE</h2>
                <h3 class="text-base sm:text-lg font-semibold text-[#031b4e]">TEACHER PLACEMENT SERVICE AGREEMENT</h3>
            </div>

            <!-- Candidate Details -->
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="space-y-1.5 text-xs sm:text-sm">
                    <p><strong>Candidate Name:</strong> {{ $candidate->name }}</p>
                    <p><strong>Email:</strong> {{ $candidate->email }}</p>
                    <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
                    <p><strong>Address:</strong> {{ $profile?->address ?? 'Not specified' }}</p>
                    @if($profile?->signature_date_time)
                        <p class="text-slate-600"><strong>Signed At:</strong> {{ \Carbon\Carbon::parse($profile->signature_date_time)->format('d M Y, h:i:s A') }}</p>
                    @endif
                </div>

                @if($profile?->live_photo_path && Storage::disk('public')->exists($profile->live_photo_path))
                    <div class="shrink-0 text-center self-center sm:self-auto">
                        <img src="{{ Storage::url($profile->live_photo_path) }}" alt="Candidate Live Verification" class="w-20 h-24 object-cover border-2 border-indigo-500 rounded-xl shadow-sm">
                        <span class="inline-block mt-1 px-2 py-0.5 bg-indigo-100 text-indigo-800 text-[10px] font-bold rounded-full">
                            Identity Verified
                        </span>
                    </div>
                @endif
            </div>

            <p class="text-slate-700">This Agreement is entered into voluntarily between <strong>Warriors Educare</strong> ("Agency") and the undersigned Candidate ("Teacher").</p>

            <div class="space-y-3 text-slate-700 leading-relaxed text-xs">
                <div>
                    <h5 class="font-bold text-[#031b4e]">1. Purpose of Agreement</h5>
                    <p>This Agreement confirms that the Candidate willingly authorizes Warriors Educare to begin the recruitment and placement process for suitable teaching opportunities in schools and colleges.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">2. Placement Service Charge</h5>
                    <p>Upon final appointment or joining a school/institution through Warriors Educare, the Candidate agrees to pay the stipulated placement service fee.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">3. Accuracy of Credentials</h5>
                    <p>The Candidate affirms that all qualifications, degrees, experience certificates, and documents provided are authentic.</p>
                </div>
                <div>
                    <h5 class="font-bold text-[#031b4e]">4. Legal Jurisdiction</h5>
                    <p>Any dispute arising out of this Agreement shall be subject to the exclusive jurisdiction of the competent courts in Patna, Bihar.</p>
                </div>
            </div>

            <!-- Signatures -->
            <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-center sm:text-left">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Candidate E-Signature</span>
                    <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl min-w-[160px] text-center">
                        @if(!empty($profile?->signature_data))
                            <span class="text-lg font-serif italic text-blue-900 font-bold" style="font-family: 'Brush Script MT', 'Dancing Script', cursive;">{{ $profile->signature_data }}</span>
                        @else
                            <span class="text-xs font-bold text-slate-400">Digitally Verified</span>
                        @endif
                    </div>
                    <span class="text-[10px] text-slate-500 font-semibold block mt-1">{{ $candidate->name }}</span>
                </div>

                <div class="text-center sm:text-right">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Authorized Agency Seal</span>
                    <div class="p-2 bg-slate-50 border border-slate-200 rounded-xl min-w-[160px] text-center">
                        <span class="text-xs font-black uppercase text-blue-900 tracking-wider">Warriors Educare</span>
                        <span class="text-[9px] text-emerald-700 block font-bold">Verified Administrator</span>
                    </div>
                    <span class="text-[10px] text-slate-500 font-semibold block mt-1">Official Verification Stamp</span>
                </div>
            </div>
        </div>
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

function openUploadDocModal(docKey) {
    const modal = document.getElementById('uploadDocumentModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
    if (docKey) {
        const select = document.getElementById('uploadDocTypeSelect');
        if (select) select.value = docKey;
    }
    document.getElementById('uploadDocFileInput').value = '';
    document.getElementById('uploadDocFileName').innerText = 'Click or drag & drop file to upload';
    modal.classList.remove('hidden');
}

function closeUploadDocModal() {
    const modal = document.getElementById('uploadDocumentModal');
    if (modal) modal.classList.add('hidden');
}

function handleDocFileChange(input) {
    if (input.files && input.files[0]) {
        document.getElementById('uploadDocFileName').innerText = input.files[0].name + ' (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
    }
}

function confirmDeleteDocument(docKey, docTitle) {
    if (confirm('Are you sure you want to delete ' + docTitle + '? This action cannot be undone.')) {
        document.getElementById('deleteDocTypeInput').value = docKey;
        document.getElementById('deleteDocumentForm').submit();
    }
}

function openImagePreviewModal(url, title) {
    const modal = document.getElementById('imagePreviewModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
    document.getElementById('imagePreviewSrc').src = url;
    document.getElementById('imagePreviewTitle').innerText = title || 'Document Preview';
    document.getElementById('imagePreviewDownload').href = url;
    modal.classList.remove('hidden');
}

function closeImagePreviewModal() {
    const modal = document.getElementById('imagePreviewModal');
    if (modal) modal.classList.add('hidden');
}

function openTuitionAgreementModal() {
    const modal = document.getElementById('tuitionAgreementModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
    modal.classList.remove('hidden');
}

function closeTuitionAgreementModal() {
    const modal = document.getElementById('tuitionAgreementModal');
    if (modal) modal.classList.add('hidden');
}

function printTuitionAgreement() {
    const printContent = document.getElementById('printableTuitionAgreement').innerHTML;
    const printWindow = window.open('', '', 'width=900,height=700');
    printWindow.document.write('<html><head><title>Home Tuition Agreement - Warriors Educare</title>');
    printWindow.document.write('<style>body{font-family:sans-serif;padding:30px;color:#1e293b;line-height:1.5;} table{width:100%;border-collapse:collapse;} img{max-width:100%;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 400);
}

function openSchoolAgreementModal() {
    const modal = document.getElementById('schoolAgreementModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
    modal.classList.remove('hidden');
}

function closeSchoolAgreementModal() {
    const modal = document.getElementById('schoolAgreementModal');
    if (modal) modal.classList.add('hidden');
}

function printSchoolAgreement() {
    const printContent = document.getElementById('printableSchoolAgreement').innerHTML;
    const printWindow = window.open('', '', 'width=900,height=700');
    printWindow.document.write('<html><head><title>Teacher Placement Agreement - Warriors Educare</title>');
    printWindow.document.write('<style>body{font-family:sans-serif;padding:30px;color:#1e293b;line-height:1.5;} table{width:100%;border-collapse:collapse;} img{max-width:100%;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 400);
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
