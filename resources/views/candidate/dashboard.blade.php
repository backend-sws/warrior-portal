@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 shadow-sm flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 shadow-sm flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif



        @if($profile?->agreement_status === 'pending_signature')
            {{-- ================= PENDING AGREEMENT BANNER ================= --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm reveal">
                <div class="flex items-start sm:items-center gap-3">
                    <i class="fas fa-file-signature text-amber-500 text-xl mt-0.5 sm:mt-0 shrink-0"></i>
                    <div>
                        <h3 class="font-bold text-amber-800 text-sm sm:text-base">Action Required: Sign Agreement</h3>
                        <p class="text-xs sm:text-sm text-amber-700">Admin has requested you to sign the Candidate Agreement to proceed with your tuition/job assignment.</p>
                    </div>
                </div>
                <a href="{{ route('candidate.agreement.show') }}" class="w-full sm:w-auto text-center px-5 py-2.5 bg-amber-600 text-white rounded-lg text-xs sm:text-sm font-bold shadow hover:bg-amber-700 transition-colors shrink-0">
                    Sign Now
                </a>
            </div>
        @endif

        {{-- ================= PROFILE COMPLETION PROGRESS / STATUS BANNER ================= --}}
        @php
            $completionPct = $profile?->completion_percentage ?? 0;
            $catLabel = match($profile?->candidate_category) {
                'home_tutor' => 'Home Tutor',
                'school_job' => 'School Teacher',
                default => 'Dual Profile (School + Tuition)',
            };
            $catBadgeColor = match($profile?->candidate_category) {
                'home_tutor' => 'bg-amber-100 text-amber-900 border-amber-300',
                'school_job' => 'bg-blue-100 text-blue-900 border-blue-300',
                default => 'bg-emerald-100 text-emerald-900 border-emerald-300',
            };
        @endphp

        @if($completionPct < 80)
            <div class="bg-gradient-to-r from-amber-50 via-orange-50/70 to-amber-50 border-2 border-amber-300 rounded-3xl p-6 mb-8 shadow-sm reveal">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-lg shadow-amber-500/20">
                            <i class="fas fa-user-clock animate-pulse"></i>
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white shadow-xs">Registration Pending</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $catBadgeColor }}">{{ $catLabel }}</span>
                                <span class="text-xs font-bold text-amber-900 font-mono">{{ $completionPct }}% Completed (80% Required for {{ $profile?->candidate_category === 'school_job' ? 'School Jobs' : 'Leads' }})</span>
                            </div>
                            <h3 class="font-extrabold text-[#031b4e] text-base sm:text-lg">
                                @if($profile?->candidate_category === 'school_job')
                                    Action Required: Complete Profile to Unlock School Vacancies
                                @elseif($profile?->candidate_category === 'home_tutor')
                                    Action Required: Complete Profile to Unlock Tuition Leads
                                @else
                                    Action Required: Complete Profile to Unlock Jobs & Tuition Leads
                                @endif
                            </h3>
                            <p class="text-xs text-slate-600 mt-1 max-w-2xl leading-relaxed">
                                Missing fields: <strong class="text-amber-900">{{ !empty($profile?->missing_profile_fields) ? implode(', ', $profile->missing_profile_fields) : 'Basic preferences' }}</strong>. 
                                @if($profile?->candidate_category === 'school_job')
                                    <span class="text-amber-800 font-bold block mt-0.5"><i class="fas fa-lock text-[10px] mr-1"></i> School job applications and direct school interviews require at least 80% profile completion.</span>
                                @elseif($profile?->appliesForHomeTuition())
                                    <span class="text-amber-800 font-bold block mt-0.5"><i class="fas fa-lock text-[10px] mr-1"></i> Home Tuition leads remain hidden until your profile reaches at least 80%.</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 shrink-0">
                        <div class="bg-white px-4 py-2.5 rounded-2xl border border-amber-200 shadow-2xs">
                            <div class="flex justify-between text-[11px] font-bold text-slate-700 mb-1">
                                <span>Progress</span>
                                <span class="text-amber-600 font-black">{{ $completionPct }}%</span>
                            </div>
                            <div class="w-full sm:w-36 bg-amber-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-full rounded-full transition-all duration-500" style="width: {{ $completionPct }}%"></div>
                            </div>
                        </div>

                        <a href="{{ route('candidate.profile.edit') }}" class="px-6 py-3 bg-[#031b4e] hover:bg-blue-900 text-white rounded-2xl text-xs font-black shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>Complete Profile Now</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-emerald-500/10 border border-emerald-300 rounded-3xl p-5 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm reveal">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-lg shrink-0 shadow-md shadow-emerald-500/20">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="font-extrabold text-[#031b4e] text-sm sm:text-base">{{ $completionPct }}% Profile Completed</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $catBadgeColor }}">{{ $catLabel }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">Verified & Active</span>
                        </div>
                        <p class="text-xs text-slate-600">
                            @if($profile?->candidate_category === 'school_job')
                                Your school teaching profile is eligible and active. Verified school job openings are fully unlocked!
                            @elseif($profile?->candidate_category === 'home_tutor')
                                Your home tutoring profile is eligible and active. Tuition leads and parent inquiries are fully unlocked!
                            @else
                                Your profile is eligible and active. Tuition leads and school job applications are fully unlocked!
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('candidate.profile.edit') }}" class="px-4 py-2 bg-white hover:bg-emerald-50 text-emerald-800 border border-emerald-300 rounded-xl text-xs font-bold transition-all shadow-xs shrink-0 flex items-center gap-1.5">
                    <i class="fas fa-edit text-xs"></i> Update Profile
                </a>
            </div>
        @endif

        {{-- ================= FULLY REGISTERED DASHBOARD ================= --}}

        {{-- Welcome Banner --}}
        <div class="bg-gradient-to-r from-[#031b4e] to-[#0ea5e9] rounded-3xl p-8 mb-8 text-white shadow-lg relative overflow-hidden reveal">
            <!-- Decorative Elements (Arc Reactor) -->
            <style>
                .arc-reactor-banner {
                    width: 300px;
                    height: 300px;
                    border-radius: 50%;
                    position: absolute;
                    top: 50%;
                    right: 0%;
                    transform: translate(30%, -50%);
                    opacity: 0.15;
                    box-shadow: 0 0 50px 10px rgba(14, 165, 233, 0.5), inset 0 0 50px 10px rgba(14, 165, 233, 0.5);
                    background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, transparent 70%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: pulse-arc 4s infinite alternate;
                    pointer-events: none;
                    z-index: 0;
                }
                .arc-segments-banner {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    background: repeating-conic-gradient(from 0deg, transparent 0deg 15deg, #fff 15deg 30deg);
                    -webkit-mask-image: radial-gradient(transparent 65%, black 66%, black 85%, transparent 86%);
                    mask-image: radial-gradient(transparent 65%, black 66%, black 85%, transparent 86%);
                    animation: spin-arc 30s linear infinite;
                    box-shadow: 0 0 20px #fff;
                }
                .arc-ring-banner {
                    position: absolute;
                    width: 90%;
                    height: 90%;
                    border-radius: 50%;
                    border: 12px solid transparent;
                    border-top-color: #fff;
                    border-bottom-color: #fff;
                    animation: spin-arc 15s linear infinite;
                    box-shadow: 0 0 15px #fff;
                }
                .arc-ring-2-banner {
                    position: absolute;
                    width: 65%;
                    height: 65%;
                    border-radius: 50%;
                    border: 6px dashed rgba(255,255,255,0.8);
                    box-shadow: 0 0 20px #fff, inset 0 0 20px #fff;
                    animation: spin-arc-reverse 20s linear infinite;
                }
                .arc-core-banner {
                    position: absolute;
                    width: 35%;
                    height: 35%;
                    border-radius: 50%;
                    background: #fff;
                    box-shadow: 0 0 50px 20px #fff, 0 0 100px 30px #fff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: core-pulse 2s infinite alternate;
                }
            </style>
            
            <div class="arc-reactor-banner">
                <div class="arc-segments-banner"></div>
                <div class="arc-ring-banner"></div>
                <div class="arc-ring-2-banner"></div>
                <div class="arc-core-banner"></div>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                @if($profile?->profile_photo_path)
                    <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="Profile Photo"
                        class="w-24 h-24 rounded-full object-cover border-4 border-white/20 shadow-xl">
                @else
                    <div
                        class="w-24 h-24 rounded-full bg-white/20 flex items-center justify-center text-4xl border-4 border-white/20 shadow-xl">
                        <i class="fas fa-user text-white"></i>
                    </div>
                @endif
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-3xl font-bold mb-1 flex items-center flex-wrap gap-2">
                        Welcome back, {{ auth()->user()->name }}!
                        @if(($profile?->completion_percentage ?? 0) >= 100)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/20 border border-emerald-400/50 text-emerald-300 text-xs font-bold uppercase tracking-wider rounded-full shadow-[0_0_15px_rgba(16,185,129,0.3)]"
                                title="100% Complete Profile">
                                <i class="fas fa-check-circle"></i> Profile 100% Complete
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/20 border border-amber-400/50 text-amber-300 text-xs font-bold uppercase tracking-wider rounded-full"
                                title="Profile Incomplete">
                                <i class="fas fa-clock"></i> {{ $profile?->completion_percentage ?? 0 }}% Complete
                            </span>
                        @endif
                    </h1>
                    @if(($profile?->completion_percentage ?? 0) >= 100)
                        <p class="text-white/80 text-lg">
                            @if($profile?->candidate_category === 'home_tutor')
                                Your Home Tutor profile is 100% verified and active for home tuition matching.
                            @elseif($profile?->candidate_category === 'school_job')
                                Your school teaching profile is 100% complete and visible to hiring schools.
                            @else
                                Your profile is 100% complete and visible to schools and parents.
                            @endif
                        </p>
                    @else
                        <p class="text-amber-200/90 text-sm font-medium mt-1">
                            @if($profile?->candidate_category === 'home_tutor')
                                Complete missing details to unlock instant student matching for home tuitions in your area.
                            @elseif($profile?->candidate_category === 'school_job')
                                Complete remaining profile details to increase direct interview calls from top schools.
                            @else
                                Complete remaining profile details to unlock tuition leads and school teaching jobs.
                            @endif
                        </p>
                    @endif
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    @if($profile?->candidate_category === 'home_tutor')
                        <a href="{{ route('candidate.tuitions.index') }}"
                            class="px-6 py-3 bg-white text-[#031b4e] hover:bg-slate-50 font-black rounded-xl transition-all shadow-md flex items-center gap-2 text-sm">
                            <i class="fas fa-book-reader text-amber-500"></i> Explore Home Tuitions
                        </a>
                    @elseif($profile?->candidate_category === 'school_job')
                        <a href="{{ route('candidate.applications.available') }}"
                            class="px-6 py-3 bg-white text-[#0ea5e9] hover:bg-slate-50 font-black rounded-xl transition-all shadow-md flex items-center gap-2 text-sm">
                            <i class="fas fa-briefcase"></i> Explore School Jobs
                        </a>
                    @else
                        <a href="{{ route('jobs') }}"
                            class="px-6 py-3 bg-white text-[#0ea5e9] hover:bg-slate-50 font-black rounded-xl transition-all shadow-md flex items-center gap-2 text-sm">
                            <i class="fas fa-search"></i> Find Jobs & Tuitions
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Stats & Plan --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 reveal reveal-delay-1">
                    @if($profile?->candidate_category === 'home_tutor')
                        {{-- Home Tutor Stat 1: Tuitions Applied --}}
                        <a href="{{ route('candidate.tuitions.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-amber-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ \App\Models\TuitionApplication::where('candidate_id', auth()->id())->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Tuitions Applied</p>
                        </a>

                        {{-- Home Tutor Stat 2: Assigned Tuitions --}}
                        <a href="{{ route('candidate.tuitions.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-emerald-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ \App\Models\TuitionApplication::where('candidate_id', auth()->id())->where('status', 'Assigned')->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Assigned Tutors</p>
                        </a>

                        {{-- Home Tutor Stat 3: Teaching Subjects --}}
                        <a href="{{ route('candidate.profile.edit') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-blue-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ !empty($profile->tuition_subjects) ? count($profile->tuition_subjects) : 0 }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Subjects Taught</p>
                        </a>

                        {{-- Home Tutor Stat 4: Agreement Status --}}
                        <a href="{{ route('candidate.agreement.show') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-purple-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-[#031b4e] mt-1">
                                {{ $profile->is_agreement_signed ? 'Signed' : 'Pending' }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Tuition Agreement</p>
                        </a>
                    @elseif($profile?->candidate_category === 'school_job')
                        {{-- School Job Stat 1: Jobs Applied --}}
                        <a href="{{ route('candidate.applications.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-[#0ea5e9]/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ auth()->user()->applications()->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Jobs Applied</p>
                        </a>

                        {{-- School Job Stat 2: Shortlisted --}}
                        <a href="{{ route('candidate.applications.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-amber-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ auth()->user()->applications()->whereIn('status', ['shortlisted', 'interview'])->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Shortlisted</p>
                        </a>

                        {{-- School Job Stat 3: Selected / Hired --}}
                        <a href="{{ route('candidate.applications.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-emerald-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ auth()->user()->applications()->where('status', 'hired')->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Selected</p>
                        </a>

                        {{-- School Job Stat 4: Agreement --}}
                        <a href="{{ route('candidate.agreement.show') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-purple-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-[#031b4e] mt-1">
                                {{ $profile->is_agreement_signed ? 'Signed' : 'Pending' }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Candidate Agreement</p>
                        </a>
                    @else
                        {{-- Both Category --}}
                        <a href="{{ route('candidate.applications.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-[#0ea5e9]/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ auth()->user()->applications()->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Jobs Applied</p>
                        </a>

                        <a href="{{ route('candidate.tuitions.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-purple-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ \App\Models\TuitionApplication::where('candidate_id', auth()->id())->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Tuitions Applied</p>
                        </a>
                        
                        <a href="{{ route('candidate.applications.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-amber-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ auth()->user()->applications()->whereIn('status', ['shortlisted', 'interview'])->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Shortlisted</p>
                        </a>

                        <a href="{{ route('candidate.tuitions.index') }}"
                            class="light-metallic-blue-card rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:border-green-500/30 transition-all shadow-sm cursor-pointer hover:bg-white bg-white">
                            <div class="w-11 h-11 rounded-xl bg-green-500/10 text-green-600 flex items-center justify-center text-lg mb-2">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">
                                {{ \App\Models\TuitionApplication::where('candidate_id', auth()->id())->where('status', 'Assigned')->count() }}
                            </h3>
                            <p class="text-[11px] font-bold text-[#031b4e]/70 uppercase tracking-wider mt-1">Assigned Tutors</p>
                        </a>
                    @endif
                </div>

                {{-- Quick Opportunities Banner --}}
                <div class="grid grid-cols-1 {{ $profile?->candidate_category === 'both' ? 'sm:grid-cols-2' : '' }} gap-4">
                    @if(in_array($profile?->candidate_category, ['school_job', 'both']))
                        <a href="{{ route('candidate.applications.available') }}" class="p-5 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-lg hover:shadow-xl transition-all group flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-blue-200">Verified Vacancies</span>
                                <h4 class="text-lg font-black mt-0.5">Explore School Jobs</h4>
                                <p class="text-xs text-blue-100 mt-1">Apply for latest school teacher openings</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/10 group-hover:bg-white/20 flex items-center justify-center transition-colors shrink-0 ml-3">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </a>
                    @endif

                    @if(in_array($profile?->candidate_category, ['home_tutor', 'both']))
                        <a href="{{ route('candidate.tuitions.index') }}" class="p-5 rounded-2xl bg-gradient-to-br from-[#031b4e] to-sky-700 text-white shadow-lg hover:shadow-xl transition-all group flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-sky-300">Verified Leads</span>
                                <h4 class="text-lg font-black mt-0.5">Explore Home Tuitions</h4>
                                <p class="text-xs text-sky-100 mt-1">Browse active student requirements near you</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/10 group-hover:bg-white/20 flex items-center justify-center transition-colors shrink-0 ml-3">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </a>
                    @endif
                </div>

                {{-- ================= TUITION TEACHER UPGRADE SECTION (FOR SCHOOL JOB CANDIDATES) ================= --}}
                @if($profile && $profile->candidate_category === 'school_job')
                    @if($profile->tuition_upgrade_status === 'none' || empty($profile->tuition_upgrade_status))
                        {{-- State 1: Ask to join as a tuition teacher also CTA --}}
                        <div class="bg-gradient-to-r from-amber-50 via-orange-50/50 to-blue-50 border border-amber-300 rounded-3xl p-6 shadow-sm reveal">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-amber-500/20">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div>
                                        <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black uppercase tracking-wider mb-1">
                                            <i class="fas fa-star text-amber-600"></i> Additional Earning Opportunity
                                        </div>
                                        <h3 class="text-base sm:text-lg font-extrabold text-[#031b4e]">
                                            Want to take private Home Tuitions as well?
                                        </h3>
                                        <p class="text-xs text-slate-600 mt-1 max-w-xl leading-relaxed">
                                            You are currently registered for <strong>School Teaching Jobs</strong>. If you would also like to receive verified <strong>Home Tuition leads</strong> in your preferred areas, you can request admin approval to activate a Dual Profile.
                                        </p>
                                    </div>
                                </div>
                                <form action="{{ route('candidate.tuition-upgrade.request') }}" method="POST" class="shrink-0 w-full md:w-auto">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Send request to admin to join as a tuition teacher also?');"
                                            style="background: linear-gradient(135deg, #d97706 0%, #ea580c 100%); color: #ffffff !important; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.3); border: none;"
                                            class="w-full md:w-auto px-5 py-3 text-white font-bold rounded-xl text-xs hover:opacity-95 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                                        <i class="fas fa-paper-plane text-white text-xs"></i>
                                        <span class="text-white font-bold">Ask to join as Tuition Teacher</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif($profile->tuition_upgrade_status === 'requested')
                        {{-- State 2: Request Pending Admin Review --}}
                        <div class="bg-gradient-to-r from-amber-50 via-orange-50/60 to-amber-50 border border-amber-300 rounded-3xl p-6 shadow-sm reveal">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-amber-500/20">
                                        <i class="fas fa-hourglass-half animate-spin" style="animation-duration: 4s;"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white">Upgrade Request Sent</span>
                                            <span class="text-xs font-semibold text-slate-500">Submitted {{ $profile->tuition_upgrade_requested_at?->diffForHumans() ?? 'recently' }}</span>
                                        </div>
                                        <h3 class="text-base font-black text-[#031b4e]">
                                            Tuition Teacher Request Pending Admin Approval
                                        </h3>
                                        <p class="text-xs text-slate-600 mt-0.5">
                                            Your request to join as a tuition teacher has been submitted to the admin team. Once approved, the tuition preference form will open right here so you can set your subjects, classes, and areas to activate your dual profile.
                                        </p>
                                    </div>
                                </div>
                                <span class="px-4 py-2 bg-amber-100 text-amber-900 border border-amber-300 rounded-xl text-xs font-black shrink-0">
                                    <i class="fas fa-clock mr-1"></i> Under Admin Review
                                </span>
                            </div>
                        </div>
                    @elseif($profile->tuition_upgrade_status === 'approved')
                        {{-- State 3: Approved - Tuition Preferences Form to complete and convert to 'both' --}}
                        <div class="bg-gradient-to-br from-emerald-50 via-teal-50/40 to-blue-50 border-2 border-emerald-400 rounded-3xl p-6 sm:p-8 shadow-lg reveal">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-5 border-b border-emerald-200/80 mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-lg shadow-emerald-500/20">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div>
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black uppercase tracking-wider mb-1">
                                            <i class="fas fa-check-circle text-emerald-600"></i> Request Approved by Admin!
                                        </div>
                                        <h3 class="text-lg sm:text-xl font-extrabold text-[#031b4e]">
                                            Complete Your Tuition Profile & Upgrade to Both
                                        </h3>
                                        <p class="text-xs sm:text-sm text-slate-600 mt-0.5">
                                            Admin has approved your request! Select your tuition preferences below and save to convert your account into a <strong>Dual Profile (School Teacher + Home Tutor)</strong>.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Tuition Preferences Form --}}
                            <form action="{{ route('candidate.tuition-upgrade.complete') }}" method="POST" class="space-y-6">
                                @csrf

                                {{-- Subjects You Teach --}}
                                <div>
                                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-2">
                                        <i class="fas fa-book-open text-amber-500 mr-1"></i> Subjects You Teach for Home Tuition *
                                    </label>
                                    @php
                                        $tuitionSubjectsList = [
                                            'Pre-Primary', 'All Subjects (1-5)', 'All Subjects (6-8)', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 
                                            'English', 'Hindi', 'Social Science', 'Computer Science', 'Spoken English', 'Accounts', 
                                            'Economics', 'Business Studies'
                                        ];
                                        $existingSubjs = (array) ($profile->tuition_subjects ?? []);
                                        if (empty($existingSubjs) && $profile->subject_specialization) {
                                            $existingSubjs[] = $profile->subject_specialization;
                                        }
                                    @endphp
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
                                        @foreach($tuitionSubjectsList as $subj)
                                            <label class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:border-amber-400 cursor-pointer transition-all has-[:checked]:bg-amber-500 has-[:checked]:text-white has-[:checked]:border-amber-500 shadow-2xs">
                                                <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}" {{ in_array($subj, $existingSubjs) ? 'checked' : '' }} class="rounded text-amber-600 focus:ring-amber-500">
                                                <span>{{ $subj }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="mt-2.5 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <span class="text-[11px] font-bold text-slate-600 whitespace-nowrap">
                                            <i class="fas fa-pencil-alt text-amber-500"></i> Other Subjects (comma separated):
                                        </span>
                                        <input type="text" name="manual_tuition_subjects" placeholder="e.g. Sanskrit, French, Vedic Maths..."
                                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                                    </div>
                                </div>

                                {{-- Classes Interested To Teach --}}
                                <div>
                                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-2">
                                        <i class="fas fa-graduation-cap text-blue-500 mr-1"></i> Classes Interested To Teach *
                                    </label>
                                    @php
                                        $classList = [
                                            'Pre-Primary', 'Nursery – UKG', 'Class 1 – 5', 'Class 6 – 8', 
                                            'Class 9 – 10', 'Class 11 – 12', 'IIT-JEE', 'NEET', 'Competitive / Olympiad'
                                        ];
                                        $existingClasses = (array) ($profile->classes_interested ?? []);
                                    @endphp
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-2.5">
                                        @foreach($classList as $cls)
                                            <label class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:border-blue-400 cursor-pointer transition-all has-[:checked]:bg-blue-600 has-[:checked]:text-white has-[:checked]:border-blue-600 shadow-2xs">
                                                <input type="checkbox" name="classes_interested[]" value="{{ $cls }}" {{ in_array($cls, $existingClasses) ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                                                <span>{{ $cls }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="mt-2.5 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <span class="text-[11px] font-bold text-slate-600 whitespace-nowrap">
                                            <i class="fas fa-pencil-alt text-blue-500"></i> Other Classes:
                                        </span>
                                        <input type="text" name="manual_classes" placeholder="e.g. B.Com, BCA, Engineering..."
                                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    {{-- Teaching Mode --}}
                                    <div>
                                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-2">
                                            <i class="fas fa-laptop-house text-purple-500 mr-1"></i> Teaching Mode *
                                        </label>
                                        <select name="teaching_mode" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500">
                                            <option value="Offline" {{ ($profile->teaching_mode ?? 'Offline') === 'Offline' ? 'selected' : '' }}>Offline (At Student's Home / Tutor Center)</option>
                                            <option value="Online" {{ ($profile->teaching_mode ?? '') === 'Online' ? 'selected' : '' }}>Online (Google Meet / Zoom)</option>
                                            <option value="Both" {{ ($profile->teaching_mode ?? '') === 'Both' ? 'selected' : '' }}>Both (Offline & Online)</option>
                                        </select>
                                    </div>

                                    {{-- Available Time Slot --}}
                                    <div>
                                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-2">
                                            <i class="fas fa-clock text-teal-500 mr-1"></i> Available Time Slot
                                        </label>
                                        <select name="available_time_slot" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500">
                                            <option value="Flexible / Any Time" {{ ($profile->available_time_slot ?? '') === 'Flexible / Any Time' ? 'selected' : '' }}>Flexible / Any Time</option>
                                            <option value="Morning (6:00 AM - 10:00 AM)" {{ ($profile->available_time_slot ?? '') === 'Morning (6:00 AM - 10:00 AM)' ? 'selected' : '' }}>Morning (6:00 AM - 10:00 AM)</option>
                                            <option value="Evening (4:00 PM - 8:00 PM)" {{ ($profile->available_time_slot ?? 'Evening (4:00 PM - 8:00 PM)') === 'Evening (4:00 PM - 8:00 PM)' ? 'selected' : '' }}>Evening (4:00 PM - 8:00 PM)</option>
                                            <option value="After School (3:00 PM - 7:00 PM)" {{ ($profile->available_time_slot ?? '') === 'After School (3:00 PM - 7:00 PM)' ? 'selected' : '' }}>After School (3:00 PM - 7:00 PM)</option>
                                            <option value="Weekends Only" {{ ($profile->available_time_slot ?? '') === 'Weekends Only' ? 'selected' : '' }}>Weekends Only</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Preferred Areas / Localities --}}
                                <div>
                                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-1.5">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Preferred Areas / Localities for Home Tuitions *
                                    </label>
                                    <input type="text" name="preferred_areas" required
                                           value="{{ old('preferred_areas', $profile->preferred_areas ?: (is_array($profile->preferred_locations) ? implode(', ', $profile->preferred_locations) : ($profile->address ?? ''))) }}"
                                           placeholder="e.g. Kankarbagh, Boring Road, Bailey Road, Rajendra Nagar"
                                           class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500">
                                    <p class="text-[11px] text-slate-500 mt-1">Enter localities or colonies where you are able to travel for home tuitions.</p>
                                </div>

                                {{-- Submit Button --}}
                                <div class="pt-4 border-t border-emerald-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <p class="text-xs text-slate-600">
                                        <i class="fas fa-info-circle text-blue-500 mr-1"></i> Saving this form will permanently upgrade your profile to <strong>Both (School Job + Home Tuition)</strong> with 100% completion.
                                    </p>
                                    <button type="submit"
                                            style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%); color: #ffffff !important; box-shadow: 0 4px 14px rgba(5, 150, 105, 0.4); border: none;"
                                            class="w-full sm:w-auto px-8 py-3.5 text-white font-black text-sm rounded-2xl shadow-lg hover:opacity-95 transition-all flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                                        <i class="fas fa-save text-white"></i>
                                        <span class="text-white font-black">Save & Upgrade to Both (Dual Profile)</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif

                {{-- ================= ACTIVE PLACEMENTS, INTERVIEWS & ASSIGNED TUITIONS ================= --}}
                @php
                    $dashCat = $profile?->candidate_category ?: 'both';
                    $showTuitions = in_array($dashCat, ['home_tutor', 'both']) && isset($activeTuitionAssignments) && $activeTuitionAssignments->isNotEmpty();
                    $showJobs = in_array($dashCat, ['school_job', 'both']) && isset($activeJobInterviews) && $activeJobInterviews->isNotEmpty();
                @endphp
                @if($showTuitions || $showJobs)
                    <div class="space-y-4 reveal">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base sm:text-lg font-black text-[#031b4e] flex items-center gap-2">
                                <span class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-sm shadow-xs">
                                    <i class="fas fa-bullhorn"></i>
                                </span>
                                {{ $dashCat === 'home_tutor' ? 'Active Tuition Assignments' : ($dashCat === 'school_job' ? 'Active Interviews & Selections' : 'Active Placements, Interviews & Assignments') }}
                            </h3>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full animate-pulse">
                                Action Required / Active
                            </span>
                        </div>

                        {{-- 1. Assigned Tuitions Cards --}}
                        @if($showTuitions)
                            <div class="space-y-3">
                                @foreach($activeTuitionAssignments as $tAssigned)
                                    @php $lead = $tAssigned->tuitionLead; @endphp
                                    <div class="bg-gradient-to-r from-emerald-50/90 via-teal-50/50 to-white border-2 border-emerald-300 rounded-3xl p-5 shadow-sm relative overflow-hidden">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-lg font-black shrink-0 shadow-md shadow-emerald-500/20">
                                                    <i class="fas fa-chalkboard-teacher"></i>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-mono text-[10px] font-extrabold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-lg border border-emerald-200">
                                                             {{ $lead?->tuition_id ?: 'TUI-' . str_pad($lead?->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                        <h4 class="font-black text-[#031b4e] text-base">Class {{ $lead?->class ?? 'N/A' }} ({{ $lead?->subjects }})</h4>
                                                    </div>
                                                    <p class="text-xs text-emerald-800 font-semibold mt-0.5">
                                                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $lead?->location }} {{ $lead?->pincode ? '(' . $lead->pincode . ')' : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                @if($tAssigned->status === 'Assigned')
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-600 text-white shadow-xs">
                                                        <i class="fas fa-check-circle mr-1"></i> Assigned Tutor 🎉
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-500 text-white shadow-xs">
                                                        <i class="fas fa-star mr-1"></i> Shortlisted for Demo
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Parent Contact Details (Unlocked!) --}}
                                        <div class="bg-white/90 border border-emerald-200 rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2 text-xs font-black text-[#031b4e]">
                                                    <i class="fas fa-user-circle text-emerald-600 text-sm"></i>
                                                    <span>Parent / Student: {{ $lead?->parent_name ?: 'Parent Contact' }}</span>
                                                </div>
                                                <div class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                                    <i class="fas fa-phone-alt text-emerald-600 text-xs"></i>
                                                    <span>Mobile: <strong class="text-emerald-900 font-mono">{{ $lead?->parent_mobile ?: 'Contact Coordinator' }}</strong></span>
                                                </div>
                                            </div>

                                            @if($lead?->parent_mobile)
                                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                                    <a href="tel:{{ $lead->parent_mobile }}" class="flex-1 sm:flex-none px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                                                        <i class="fas fa-phone-alt text-[10px]"></i> Call Parent
                                                    </a>
                                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->parent_mobile) }}?text={{ urlencode('Namaskar ' . $lead->parent_name . ', Warriors Educare se aapki tuition ke liye contact kar raha hu.') }}" target="_blank" class="flex-1 sm:flex-none px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                                                        <i class="fab fa-whatsapp text-sm"></i> WhatsApp
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- 2. Job Interviews & Selections Cards --}}
                        @if($showJobs)
                            <div class="space-y-3">
                                @foreach($activeJobInterviews as $jApp)
                                    <div class="bg-gradient-to-r from-amber-50/90 via-orange-50/50 to-white border-2 border-amber-300 rounded-3xl p-5 shadow-sm relative overflow-hidden">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-lg font-black shrink-0 shadow-md shadow-indigo-600/20">
                                                    <i class="fas fa-university"></i>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-mono text-[10px] font-extrabold text-indigo-800 bg-indigo-100 px-2.5 py-0.5 rounded-lg border border-indigo-200">
                                                            {{ $jApp->jobPost->job_id ?: 'JOB-' . str_pad($jApp->jobPost->id, 4, '0', STR_PAD_LEFT) }}
                                                        </span>
                                                        <h4 class="font-black text-[#031b4e] text-base">{{ $jApp->jobPost->title }}</h4>
                                                    </div>
                                                    <p class="text-xs text-indigo-900 font-extrabold mt-0.5 flex items-center gap-1.5">
                                                        <i class="fas fa-school text-indigo-600"></i>
                                                        <span>{{ $jApp->jobPost->school_name }}</span> &bull;
                                                        <span class="text-slate-500 font-semibold">{{ $jApp->jobPost->city?->name }}, {{ $jApp->jobPost->state?->name }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                @if($jApp->status === 'hired')
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-600 text-white shadow-xs">
                                                        <i class="fas fa-trophy mr-1"></i> Selected & Placed 🎉
                                                    </span>
                                                @elseif($jApp->status === 'demo_scheduled')
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-purple-600 text-white shadow-xs">
                                                        <i class="fas fa-chalkboard-teacher mr-1"></i> Demo Scheduled 🎯
                                                    </span>
                                                @elseif($jApp->status === 'forwarded_to_school')
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-600 text-white shadow-xs">
                                                        <i class="fas fa-paper-plane mr-1"></i> Forwarded to School
                                                    </span>
                                                @elseif($jApp->status === 'shortlisted')
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-600 text-white shadow-xs">
                                                        <i class="fas fa-star mr-1"></i> Shortlisted
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-600 text-white shadow-xs">
                                                        <i class="fas fa-calendar-check mr-1"></i> Interview Scheduled 📅
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- School Contact & Interview Link --}}
                                        <div class="bg-white/90 border border-amber-200 rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-2xs">
                                            <div class="space-y-1 text-xs">
                                                @if($jApp->interview_date)
                                                    <div class="font-black text-amber-900 flex items-center gap-1.5">
                                                        <i class="fas fa-clock text-amber-600"></i>
                                                        <span>Interview Date: {{ $jApp->interview_date->format('l, d M Y \a\t h:i A') }}</span>
                                                    </div>
                                                @endif
                                                <div class="text-slate-600 font-medium">
                                                    Institution Contact: <strong>{{ $jApp->jobPost->contact_person ?? 'HR / Principal' }}</strong>
                                                    @if($jApp->jobPost->phone) &bull; 📞 <strong class="text-indigo-900">{{ $jApp->jobPost->phone }}</strong> @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                                @if($jApp->interview_link)
                                                    <a href="{{ $jApp->interview_link }}" target="_blank" class="flex-1 sm:flex-none px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                                                        <i class="fas fa-video"></i> Join Online Interview
                                                    </a>
                                                @endif
                                                <a href="{{ route('candidate.applications.index') }}" class="flex-1 sm:flex-none px-4 py-2 bg-[#031b4e] hover:bg-blue-900 text-white rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5">
                                                    <span>View Application</span> <i class="fas fa-arrow-right text-[10px]"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Financial & Pending Charges --}}
                @if(($profile?->pending_amount ?? 0) > 0)
                    <div class="bg-blue-50/50 border border-blue-200/50 rounded-2xl p-6 flex items-center justify-between shadow-sm reveal reveal-delay-2">
                        <div>
                            <h3 class="text-lg font-bold text-blue-800 flex items-center gap-2">
                                <i class="fas fa-info-circle"></i> Pending Service Charge
                            </h3>
                            <p class="text-sm text-blue-700/80 mt-1">
                                You have a pending balance of <strong>₹{{ number_format($profile->pending_amount, 0) }}</strong>.
                                <br>
                                <span class="text-xs opacity-90 block mt-1"><i class="fas fa-clock mr-1"></i> Please clear your dues as per agreement terms.</span>
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('candidate.serviceCharge.show') }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 shadow-md transition-colors flex items-center gap-2">
                                <i class="fas fa-credit-card"></i> Pay Now
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Recent Notifications --}}
                <div class="light-metallic-blue-card rounded-2xl overflow-hidden shadow-sm reveal reveal-delay-2 bg-white">
                    <div class="px-6 py-4 border-b border-[#031b4e]/10 flex justify-between items-center bg-[#f4f7f5]/30">
                        <h3 class="font-bold text-[#031b4e] flex items-center gap-2">
                            <i class="fas fa-bell text-amber-500"></i> Notifications & Updates
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse(auth()->user()->notifications()->take(4)->get() as $notification)
                            <div class="p-4 sm:p-5 flex gap-4 hover:bg-slate-50/50 transition-colors {{ $notification->unread() ? 'bg-blue-50/20' : '' }}">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-accent-blue flex items-center justify-center flex-shrink-0 mt-0.5 border border-blue-100">
                                    <i class="fas fa-bell text-sm"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-xs sm:text-sm font-bold text-[#031b4e] mb-0.5">{{ $notification->data['title'] ?? 'Notification' }}</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ $notification->data['message'] ?? 'You have a new update.' }}</p>
                                    <span class="text-[10px] text-slate-400 font-medium mt-1.5 block">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 text-xs sm:text-sm">
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Right Column: Profile & Verification --}}
            <div class="space-y-6">
                {{-- Profile Card --}}
                <div class="light-metallic-blue-card rounded-2xl p-6 shadow-sm reveal reveal-delay-2 bg-white space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-[#031b4e] flex items-center gap-2">
                                <i class="fas fa-id-card text-accent-blue"></i> Profile Overview
                            </h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black border {{ $catBadgeColor }}">
                                {{ $catLabel }}
                            </span>
                        </div>
                        <a href="{{ route('candidate.profile.edit') }}" class="text-xs text-accent-blue hover:underline font-bold">Edit Profile</a>
                    </div>

                    <div class="space-y-3 text-xs sm:text-sm">
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fas fa-phone mr-2 w-4 text-slate-400"></i> Mobile</span>
                            <span class="font-semibold text-[#031b4e]">{{ auth()->user()->phone }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fab fa-whatsapp mr-2 w-4 text-emerald-500"></i> WhatsApp</span>
                            <span class="font-semibold text-emerald-700 font-mono">{{ auth()->user()->whatsapp_no ?: ($profile?->whatsapp_no ?? 'Same as mobile') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fas fa-graduation-cap mr-2 w-4 text-indigo-500"></i> Qualification</span>
                            <span class="font-semibold text-[#031b4e] text-right">{{ $profile?->highest_qualification_name ?: ($profile?->highestQualification?->name ?? 'Not Provided') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fas fa-briefcase mr-2 w-4 text-amber-500"></i> Experience</span>
                            <span class="font-semibold text-[#031b4e]">{{ $profile?->experience_range ?: ($profile?->experience_years ? $profile->experience_years . ' Years' : 'Fresher') }}</span>
                        </div>

                        {{-- Home Tutor Specific Details --}}
                        @if($profile?->appliesForHomeTuition())
                            <div class="pt-2 border-t border-slate-100 space-y-2">
                                <span class="text-[10px] font-black uppercase tracking-wider text-amber-800 block">Home Tuition Preferences</span>
                                
                                @if(!empty($profile->tuition_subjects) && is_array($profile->tuition_subjects))
                                    <div>
                                        <span class="text-[11px] text-slate-400 block mb-1">Tuition Subjects:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($profile->tuition_subjects, 0, 5) as $sub)
                                                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-900 border border-amber-200 text-[10px] font-bold">{{ $sub }}</span>
                                            @endforeach
                                            @if(count($profile->tuition_subjects) > 5)
                                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold">+{{ count($profile->tuition_subjects) - 5 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($profile->classes_interested) && is_array($profile->classes_interested))
                                    <div>
                                        <span class="text-[11px] text-slate-400 block mb-1">Target Classes:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($profile->classes_interested, 0, 4) as $cls)
                                                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-900 border border-blue-200 text-[10px] font-bold">{{ $cls }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center py-1">
                                    <span class="text-slate-500">Teaching Mode</span>
                                    <span class="font-bold text-[#031b4e]">{{ $profile?->teaching_mode ?? 'Offline' }}</span>
                                </div>

                                @if(!empty($profile->preferred_areas))
                                    <div class="py-1">
                                        <span class="text-slate-500 block mb-0.5">Preferred Areas:</span>
                                        <p class="font-medium text-[#031b4e] text-xs bg-slate-50 p-2 rounded-lg border border-slate-100">{{ $profile->preferred_areas }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- School Job Specific Details --}}
                        @if($profile?->appliesForSchoolJob())
                            <div class="pt-2 border-t border-slate-100 space-y-2">
                                <span class="text-[10px] font-black uppercase tracking-wider text-blue-800 block">School Job Preferences</span>
                                
                                @if(!empty($profile->position_applying_for))
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-slate-500">Position</span>
                                        <span class="font-black text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">{{ $profile->position_applying_for }}</span>
                                    </div>
                                @endif

                                @if(!empty($profile->subject_specialization))
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-slate-500">Specialization</span>
                                        <span class="font-bold text-[#031b4e]">{{ $profile->subject_specialization }}</span>
                                    </div>
                                @endif

                                @if(!empty($profile->tuition_subjects) && is_array($profile->tuition_subjects))
                                    <div class="py-1">
                                        <span class="text-[11px] text-slate-500 block mb-1">Subjects You Teach:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($profile->tuition_subjects as $sub)
                                                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-900 border border-amber-200 text-[10px] font-bold">{{ $sub }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($profile->classes_interested) && is_array($profile->classes_interested))
                                    <div class="py-1">
                                        <span class="text-[11px] text-slate-500 block mb-1">Classes You Teach:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($profile->classes_interested as $cls)
                                                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-900 border border-blue-200 text-[10px] font-bold">{{ $cls }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center py-1">
                                    <span class="text-slate-500">B.Ed / D.El.Ed</span>
                                    <span class="font-semibold text-slate-700 text-xs">
                                        B.Ed: {{ $profile?->b_ed_status ?? 'No' }} • D.El.Ed: {{ $profile?->d_el_ed_status ?? 'No' }}
                                    </span>
                                </div>

                                @if(!empty($profile->expected_salary))
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-slate-500">Expected Salary</span>
                                        <span class="font-black text-emerald-700">₹{{ number_format((float)$profile->expected_salary) }} /mo</span>
                                    </div>
                                @endif

                                @if(!empty($profile->preferred_locations) && is_array($profile->preferred_locations))
                                    <div>
                                        <span class="text-[11px] text-slate-400 block mb-1">Preferred Locations:</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($profile->preferred_locations as $ploc)
                                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-900 border border-indigo-200 text-[10px] font-bold">{{ $ploc }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100">
                        @if($completionPct >= 100)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-[#031b4e] flex items-center gap-1.5">
                                    <i class="fas fa-check-circle text-emerald-500"></i> Profile Status
                                </span>
                                <span class="text-xs font-extrabold text-emerald-600">100% Completed</span>
                            </div>
                            <div class="w-full bg-emerald-100 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full transition-all" style="width: 100%"></div>
                            </div>
                        @else
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-[#031b4e] flex items-center gap-1.5">
                                    <i class="fas fa-clock text-amber-500"></i> Profile Status
                                </span>
                                <span class="text-xs font-extrabold text-amber-600">{{ $completionPct }}% (Pending)</span>
                            </div>
                            <div class="w-full bg-amber-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-2 rounded-full transition-all" style="width: {{ $completionPct }}%"></div>
                            </div>
                            <a href="{{ route('candidate.profile.edit') }}" class="block text-center mt-3 text-[11px] font-bold text-amber-700 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 py-1.5 rounded-lg border border-amber-200 transition-colors">
                                Complete Missing Details →
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Educator Status & Agreement Card --}}
                <div class="light-metallic-blue-card rounded-2xl p-6 shadow-sm reveal reveal-delay-3 bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-[#031b4e] flex items-center gap-2">
                            <i class="fas fa-certificate text-purple-600"></i> Teacher Status
                        </h3>
                        <span class="text-[10px] font-bold px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg uppercase tracking-wider">
                            Active Educator
                        </span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-start gap-2.5 text-slate-700">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span>Free unlimited applications for all school jobs.</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-slate-700">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span>Direct eligibility for premium home tuition opportunities.</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-slate-700">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span>Verified profile access for school interview scheduling.</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <a href="{{ route('candidate.agreement.show') }}" class="w-full py-2.5 bg-slate-50 hover:bg-slate-100 text-[#031b4e] border border-slate-200 rounded-xl font-bold text-xs transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-file-signature text-purple-600"></i> View Educator Agreement
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection




