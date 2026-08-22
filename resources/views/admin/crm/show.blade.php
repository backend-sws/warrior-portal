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
                {{ $isJobReady ? 'Ready for Schools' : 'Incomplete Profile' }}
            </h4>
        </div>
    </div>

    {{-- Home Tuitions Readiness --}}
    <div class="bg-card-bg border {{ $isTuitionReady ? 'border-emerald-500/40 bg-emerald-50/10' : 'border-amber-500/40 bg-amber-50/10' }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ $isTuitionReady ? 'bg-emerald-500/10 text-emerald-600' : 'bg-amber-500/10 text-amber-600' }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Home Tuition Readiness</p>
            <h4 class="text-sm font-black {{ $isTuitionReady ? 'text-emerald-600' : 'text-amber-600' }}">
                {{ $isTuitionReady ? 'Ready for Tuitions' : 'Missing Basic Details' }}
            </h4>
        </div>
    </div>

    {{-- School Job Agreement --}}
    <div class="bg-card-bg border {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'border-blue-500/40 bg-blue-50/10' : 'border-red-500/40 bg-red-50/10' }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'bg-blue-500/10 text-blue-600' : 'bg-red-500/10 text-red-500' }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-file-contract"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Job Service Agreement</p>
            <h4 class="text-sm font-black {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'text-blue-600' : 'text-red-500' }}">
                {{ ($profile?->is_agreement_signed || $profile?->agreement_pdf_path) ? 'Agreement Signed' : 'Pending Signature' }}
            </h4>
        </div>
    </div>

    {{-- Tuition Agreement --}}
    <div class="bg-card-bg border {{ $profile?->is_tuition_agreement_signed ? 'border-teal-500/40 bg-teal-50/10' : 'border-red-500/40 bg-red-50/10' }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl {{ $profile?->is_tuition_agreement_signed ? 'bg-teal-500/10 text-teal-600' : 'bg-red-500/10 text-red-500' }} flex items-center justify-center font-bold text-lg shrink-0">
            <i class="fas fa-file-signature"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Tuition Agreement</p>
            <h4 class="text-sm font-black {{ $profile?->is_tuition_agreement_signed ? 'text-teal-600' : 'text-red-500' }}">
                {{ $profile?->is_tuition_agreement_signed ? 'Tuition Signed' : 'Pending Signature' }}
            </h4>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column: Profile Card & Documents -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Candidate Profile Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <!-- Header Header with Photo -->
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
                    <h3 class="text-lg font-black text-text-main truncate">{{ $candidate->name }}</h3>
                    <p class="text-xs text-text-dark/60 mt-0.5 flex items-center gap-1.5"><i class="fas fa-phone-alt text-[10px]"></i> {{ $candidate->phone }}</p>
                    <p class="text-xs text-text-dark/60 mt-0.5 flex items-center gap-1.5 truncate"><i class="fas fa-envelope text-[10px]"></i> {{ $candidate->email }}</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <!-- Personal Info -->
                <div>
                    <h4 class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2.5">Personal Info</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Gender</span>
                            <span class="font-bold text-text-main">{{ $profile?->gender ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Date of Birth</span>
                            <span class="font-bold text-text-main">{{ $profile?->date_of_birth ? $profile->date_of_birth->format('d M Y') : 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border col-span-2">
                            <span class="text-[10px] text-text-dark/50 block">Address</span>
                            <span class="font-medium text-text-main">{{ $profile?->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Professional Info -->
                <div>
                    <h4 class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2.5">Education & Teaching Profile</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Qualification</span>
                            <span class="font-bold text-text-main">{{ $profile?->highestQualification?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Subject</span>
                            <span class="font-bold text-accent-blue">{{ $profile?->subject?->name ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">School Category</span>
                            <span class="font-bold text-text-main">{{ $profile?->category?->name ?? 'None' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Experience</span>
                            <span class="font-bold text-text-main">{{ $profile?->experience_years ?? 0 }} Years</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Current Salary</span>
                            <span class="font-bold text-text-main">{{ $profile?->current_salary ? '₹'.$profile->current_salary : 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border">
                            <span class="text-[10px] text-text-dark/50 block">Expected Salary</span>
                            <span class="font-bold text-emerald-600">{{ $profile?->expected_salary ? '₹'.$profile->expected_salary : 'N/A' }}</span>
                        </div>
                        <div class="bg-secondary-bg p-2.5 rounded-xl border border-card-border col-span-2">
                            <span class="text-[10px] text-text-dark/50 block">Preferred Location</span>
                            <span class="font-bold text-text-main">{{ $profile?->preferredCity?->name ?? 'N/A' }}, {{ $profile?->preferredState?->name ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div>
                    <h4 class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2.5">Uploaded Documents</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @if($profile?->resume_path)
                            <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" class="p-2.5 bg-blue-50/50 hover:bg-blue-100/60 border border-blue-200 text-accent-blue rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-file-pdf text-sm"></i> <span>Resume</span>
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
                        @if($profile?->salary_slip_path)
                            <a href="{{ Storage::url($profile->salary_slip_path) }}" target="_blank" class="p-2.5 bg-amber-50/50 hover:bg-amber-100/60 border border-amber-200 text-amber-700 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                                <i class="fas fa-file-invoice text-sm"></i> <span>Salary Slip</span>
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
                            @if($profile?->is_tuition_agreement_signed)
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200">
                                    <i class="fas fa-check-circle mr-0.5"></i> Signed & Valid
                                </span>
                            @else
                                <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full bg-card-border/50 text-text-dark/60 border border-card-border">
                                    <i class="fas fa-clock mr-0.5"></i> Pending
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('admin.crm.candidate.update-agreement-status', $candidate->id) }}" method="POST">
                            @csrf
                            @if($profile?->is_tuition_agreement_signed)
                                <input type="hidden" name="is_tuition_agreement_signed" value="0">
                                <button type="submit" class="w-full py-2 px-3 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                    <i class="fas fa-ban"></i> <span>Revoke Tuition Agreement</span>
                                </button>
                            @else
                                <input type="hidden" name="is_tuition_agreement_signed" value="1">
                                <button type="submit" class="w-full py-2.5 px-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                    <i class="fas fa-check-circle"></i> <span>Activate / Approve Tuition Agreement</span>
                                </button>
                            @endif
                        </form>
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
                            <option value="{{ $job->id }}">{{ $job->title }} — {{ $job->school_name }} ({{ $job->city->name ?? '' }})</option>
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
                                    <h5 class="text-sm font-black text-text-main">{{ $app->jobPost->title ?? 'N/A' }}</h5>
                                    <p class="text-xs text-text-dark/60">{{ $app->jobPost->school_name ?? 'School' }} • {{ $app->jobPost->city->name ?? '' }}</p>
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
                                        Class {{ $tLead->class }} ({{ $tLead->subjects }}) — {{ $tLead->location }} [Parent: {{ $tLead->parent_name }} - {{ $tLead->parent_mobile }}]
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
                                    <h5 class="text-sm font-black text-text-main">
                                        Class {{ $tApp->tuitionLead->class ?? 'N/A' }} ({{ $tApp->tuitionLead->subjects ?? '' }})
                                    </h5>
                                    <p class="text-xs text-text-dark/60">
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
                            <div>
                                <div class="flex items-center gap-2">
                                    <h5 class="text-sm font-black text-text-main">₹{{ number_format($inv->amount, 2) }}</h5>
                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full {{ $inv->status === 'paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($inv->status === 'overdue' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                        {{ ucfirst($inv->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-text-dark/60 mt-0.5">{{ $inv->description ?: 'Placement Service Charge' }}</p>
                                <p class="text-[10px] text-text-dark/40">Due: {{ \Carbon\Carbon::parse($inv->due_date)->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.serviceCharge.invoice', $inv->id) }}" target="_blank" class="px-3 py-1.5 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-main rounded-lg text-xs font-bold transition-colors">
                                    <i class="fas fa-file-pdf"></i> View PDF
                                </a>
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

@endsection
