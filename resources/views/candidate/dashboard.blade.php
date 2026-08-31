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
        @if(($profile?->completion_percentage ?? 0) < 100)
            <div class="bg-gradient-to-r from-amber-50 via-orange-50/60 to-amber-50 border-2 border-amber-200/80 rounded-3xl p-6 mb-8 shadow-sm reveal">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-lg shadow-amber-500/20">
                            <i class="fas fa-user-clock animate-pulse"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-white shadow-xs">Profile Pending</span>
                                <span class="text-xs font-bold text-amber-800 font-mono">{{ $profile?->completion_percentage ?? 0 }}% Completed</span>
                            </div>
                            <h3 class="font-extrabold text-[#031b4e] text-base sm:text-lg">Please Complete Your Educator Profile</h3>
                            <p class="text-xs text-slate-600 mt-1 max-w-2xl leading-relaxed">
                                Missing fields: <strong class="text-amber-900">{{ !empty($profile?->missing_profile_fields) ? implode(', ', $profile->missing_profile_fields) : 'Basic details' }}</strong>. Complete your profile details to unlock direct applications for school jobs and home tuitions.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 shrink-0">
                        <div class="bg-white px-4 py-2.5 rounded-2xl border border-amber-200 shadow-2xs">
                            <div class="flex justify-between text-[11px] font-bold text-slate-700 mb-1">
                                <span>Progress</span>
                                <span class="text-amber-600 font-black">{{ $profile?->completion_percentage ?? 0 }}%</span>
                            </div>
                            <div class="w-full sm:w-36 bg-amber-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-full rounded-full transition-all duration-500" style="width: {{ $profile?->completion_percentage ?? 0 }}%"></div>
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
                        <div class="flex items-center gap-2">
                            <h3 class="font-extrabold text-[#031b4e] text-sm sm:text-base">100% Profile Completed</h3>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">Verified & Active</span>
                        </div>
                        <p class="text-xs text-slate-600">Your profile is complete, verified, and actively visible to top schools & tuition inquiries.</p>
                    </div>
                </div>
                <a href="{{ route('candidate.profile.edit') }}" class="px-4 py-2 bg-white hover:bg-emerald-50 text-emerald-800 border border-emerald-300 rounded-xl text-xs font-bold transition-all shadow-xs shrink-0 flex items-center gap-1.5">
                    <i class="fas fa-edit text-xs"></i> Update Details
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
                        <p class="text-white/80 text-lg">Your profile is complete and actively visible to top schools.</p>
                    @else
                        <p class="text-amber-200/90 text-sm font-medium mt-1">Complete your remaining profile details to increase interview calls from top schools.</p>
                    @endif
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <a href="{{ route('jobs') }}"
                        class="px-6 py-3 bg-white text-[#0ea5e9] font-bold rounded-xl hover:bg-gray-50 transition-all shadow-md flex items-center gap-2">
                        <i class="fas fa-search"></i> Find Jobs
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Stats & Plan --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Quick Stats: Jobs & Tuitions --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 reveal reveal-delay-1">
                    {{-- Card 1: School Jobs Applied --}}
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

                    {{-- Card 2: Tuitions Applied --}}
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
                    
                    {{-- Card 3: Shortlisted / Interview --}}
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

                    {{-- Card 4: Assigned Tuitions --}}
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
                </div>

                {{-- Quick Opportunities Banner --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                    <a href="{{ route('candidate.tuitions.index') }}" class="p-5 rounded-2xl bg-gradient-to-br from-[#031b4e] to-sky-700 text-white shadow-lg hover:shadow-xl transition-all group flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-widest text-sky-300">Home Tuitions</span>
                            <h4 class="text-lg font-black mt-0.5">Browse Tuitions</h4>
                            <p class="text-xs text-sky-100 mt-1">Find home tuition requirements near you</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-white/10 group-hover:bg-white/20 flex items-center justify-center transition-colors shrink-0 ml-3">
                            <i class="fas fa-arrow-right text-sm"></i>
                        </div>
                    </a>
                </div>

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
                <div class="light-metallic-blue-card rounded-2xl p-6 shadow-sm reveal reveal-delay-2 bg-white">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-bold text-[#031b4e] flex items-center gap-2">
                            <i class="fas fa-id-card text-accent-blue"></i> Profile Overview
                        </h3>
                        <a href="{{ route('candidate.profile.edit') }}" class="text-xs text-accent-blue hover:underline font-bold">Edit Profile</a>
                    </div>

                    <div class="space-y-3.5 text-xs sm:text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fas fa-phone mr-2 w-4"></i> Phone</span>
                            <span class="font-semibold text-[#031b4e]">{{ auth()->user()->phone }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fas fa-graduation-cap mr-2 w-4"></i> Education</span>
                            <span class="font-semibold text-[#031b4e]">{{ $profile?->highestQualification?->name ?? 'Not Provided' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-slate-500"><i class="fas fa-briefcase mr-2 w-4"></i> Experience</span>
                            <span class="font-semibold text-[#031b4e]">{{ $profile?->experience_years ?? 0 }} Years</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-slate-500"><i class="fas fa-map-marker-alt mr-2 w-4"></i> Location</span>
                            <span class="font-semibold text-[#031b4e]">{{ $profile?->preferredCity?->name ? ($profile->preferredCity->name . ', ' . ($profile->preferredState?->name ?? '')) : 'Not Selected' }}</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">
                        @if(($profile?->completion_percentage ?? 0) >= 100)
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
                                <span class="text-xs font-extrabold text-amber-600">{{ $profile?->completion_percentage ?? 0 }}% (Pending)</span>
                            </div>
                            <div class="w-full bg-amber-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-2 rounded-full transition-all" style="width: {{ $profile?->completion_percentage ?? 0 }}%"></div>
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




