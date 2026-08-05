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

        @if(!($profile->initial_fee_paid || $profile->is_fee_paid))
            {{-- ================= PENDING REGISTRATION BANNER ================= --}}
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8 flex items-center justify-between shadow-sm reveal">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    <div>
                        <h3 class="font-bold text-red-800">Registration Incomplete</h3>
                        <p class="text-sm text-red-700">Please complete your registration and pay the initial fee to unlock all features.</p>
                    </div>
                </div>
                <a href="{{ route('candidate.registration.show') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold shadow hover:bg-red-700 transition-colors">
                    Complete Registration
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
                @if($profile->profile_photo_path)
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
                        @if($profile->is_verified)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-500/20 border border-blue-400/50 text-blue-300 text-xs font-bold uppercase tracking-wider rounded-full shadow-[0_0_15px_rgba(59,130,246,0.3)]"
                                title="Verified Profile">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @endif
                    </h1>
                    <p class="text-white/80 text-lg">Your profile is active and visible to top schools.</p>
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

                {{-- Quick Stats & Application Limit --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 reveal reveal-delay-1">
                    <div onclick="window.location='{{ route('candidate.applications.index') }}'"
                        class="light-metallic-blue-card rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:border-[#0ea5e9]/30 transition-all shadow-sm relative cursor-pointer hover:bg-[#f4f7f5]/30">
                        <div class="w-12 h-12 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xl mb-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        @php
                            $actualUsedApplications = $profile->used_applications;
                        @endphp
                        <h3 class="text-3xl font-bold text-[#031b4e]">{{ $actualUsedApplications }} <span
                                class="text-sm text-[#031b4e]/60 font-normal">/
                                {{ $profile->total_allowed_applications }}</span>
                        </h3>
                        <p class="text-xs font-semibold text-[#031b4e]/60 uppercase tracking-wide mt-1">Applications Used
                        </p>
        @php
            $isHired = \App\Models\JobApplication::where('candidate_id', auth()->id())
                ->where('status', 'hired')
                ->where('updated_at', '>=', $profile->plan_started_at ?? $profile->created_at)
                ->exists();
            $limitReached = $actualUsedApplications >= $profile->total_allowed_applications;
            $hasActiveApplications = \App\Models\JobApplication::where('candidate_id', auth()->id())
                ->whereIn('status', ['applied', 'shortlisted'])
                ->exists();
            $isExpired = $limitReached && !$hasActiveApplications && !$isHired;
        @endphp
                        @if($isHired || $isExpired || $limitReached)
                            <div onclick="event.stopPropagation()"
                                class="absolute inset-0 bg-black/50 rounded-2xl border border-[#031b4e]/10 flex items-center justify-center backdrop-blur-sm flex-col z-10 cursor-default">
                                <span
                                    class="{{ $isHired ? 'bg-green-500' : ($isExpired ? 'bg-red-500' : 'bg-accent-yellow text-slate-900') }} text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-lg mb-2">
                                    {{ $isHired ? 'Plan Completed' : ($isExpired ? 'Plan Expired' : 'Applications In Progress') }}
                                </span>
                                @if($isExpired || $isHired)
                                    <a href="{{ route('candidate.payment.show', ['type' => 'renewal']) }}"
                                        class="px-3 py-1 bg-white text-red-600 text-xs font-bold rounded shadow hover:bg-red-50 transition-colors">Renew
                                        Plan</a>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    {{-- Card 2: Shortlisted --}}
                    <a href="{{ route('candidate.applications.index') }}"
                        class="light-metallic-blue-card rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:border-green-500/30 hover:bg-[#f4f7f5]/30 transition-all shadow-sm cursor-pointer block">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-500/10 text-green-400 flex items-center justify-center text-xl mb-3 mx-auto">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-[#031b4e]">
                            {{ auth()->user()->applications()->where('status', 'shortlisted')->count() }}</h3>
                        <p class="text-xs font-semibold text-[#031b4e]/60 uppercase tracking-wide mt-1">Shortlisted</p>
                    </a>
                </div>

                {{-- Financial & Pending Charges --}}
                @if($profile->pending_amount > 0)
                    <div class="bg-blue-50/50 border border-blue-200/50 rounded-2xl p-6 flex items-center justify-between shadow-sm reveal reveal-delay-2">
                        <div>
                            <h3 class="text-lg font-bold text-blue-800 flex items-center gap-2">
                                <i class="fas fa-info-circle"></i> Pending Service Charge
                            </h3>
                            <p class="text-sm text-blue-700/80 mt-1">
                                You have a pending balance of <strong>?{{ number_format($profile->pending_amount, 0) }}</strong>.
                                <br>
                                <span class="text-xs opacity-90 block mt-1"><i class="fas fa-clock mr-1"></i> Please clear your dues to continue accessing premium features.</span>
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
                <div
                    class="light-metallic-blue-card rounded-2xl overflow-hidden shadow-sm reveal reveal-delay-2">
                    <div class="px-6 py-4 border-b border-[#031b4e]/10 flex justify-between items-center bg-[#f4f7f5]/30">
                        <h3 class="font-bold text-[#031b4e] flex items-center gap-2"><i
                                class="fas fa-bell text-accent-yellow"></i> Notifications & Updates</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse(auth()->user()->notifications()->take(3)->get() as $notification)
                            <div class="p-5 flex gap-4 hover:bg-[#f4f7f5]/30 transition-colors {{ $notification->unread() ? 'bg-[#f4f7f5]/10' : '' }}">
                                <div
                                    class="w-10 h-10 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[#031b4e] mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h4>
                                    <p class="text-xs text-[#031b4e]/80/70 leading-relaxed">{{ $notification->data['message'] ?? 'You have a new update.' }}</p>
                                    <span
                                        class="text-[10px] text-[#031b4e]/60 font-medium mt-2 block">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center text-[#031b4e]/60 text-sm">
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Right Column: Profile & Plan --}}
            <div class="space-y-8">
                {{-- Profile Card --}}
                <div class="light-metallic-blue-card rounded-2xl p-6 shadow-sm reveal reveal-delay-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-[#031b4e] flex items-center gap-2"><i
                                class="fas fa-id-card text-[#0ea5e9]"></i> Profile Overview</h3>
                        <a href="{{ route('candidate.profile.edit') }}"
                            class="text-xs text-[#0ea5e9] hover:underline font-semibold">Edit</a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-[#031b4e]/10">
                            <span class="text-sm text-[#031b4e]/70"><i class="fas fa-phone mr-2 w-4"></i> Phone</span>
                            <span class="text-sm font-medium text-[#031b4e]">{{ auth()->user()->phone }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#031b4e]/10">
                            <span class="text-sm text-[#031b4e]/70"><i class="fas fa-graduation-cap mr-2 w-4"></i>
                                Education</span>
                            <span
                                class="text-sm font-medium text-[#031b4e]">{{ $profile->highest_qualification ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#031b4e]/10">
                            <span class="text-sm text-[#031b4e]/70"><i class="fas fa-briefcase mr-2 w-4"></i>
                                Experience</span>
                            <span
                                class="text-sm font-medium text-[#031b4e]">{{ $profile->years_of_experience ?? 0 }}
                                Years</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-[#031b4e]/70"><i class="fas fa-map-marker-alt mr-2 w-4"></i>
                                Location</span>
                            <span class="text-sm font-medium text-[#031b4e]">{{ $profile->city ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-[#031b4e]/10">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-[#031b4e]">Profile Completion</span>
                            <span class="text-sm font-bold text-accent-green">{{ $profile->profile_completion_percentage ?? 80 }}%</span>
                        </div>
                        <div class="w-full bg-[#f4f7f5] rounded-full h-2">
                            <div class="bg-accent-green h-2 rounded-full" style="width: {{ $profile->profile_completion_percentage ?? 80 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Current Plan Card --}}
                <div class="light-metallic-blue-card rounded-2xl p-6 shadow-sm reveal reveal-delay-3">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-[#031b4e] flex items-center gap-2"><i
                                class="fas fa-box text-accent-purple"></i> Current Plan</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-[#0ea5e9]/10 text-[#0ea5e9] rounded-lg uppercase tracking-wider">
                            {{ $profile->plan_type ?? 'Standard' }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                            <span class="text-sm text-[#031b4e]/80">Access to all standard job postings</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                            <span class="text-sm text-[#031b4e]/80">Basic profile visibility to schools</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas {{ $profile->plan_type === 'premium' ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-400/50' }} mt-0.5"></i>
                            <span class="text-sm text-[#031b4e]/80">Priority placement assistance</span>
                        </div>

                        @if($limitReached && !$isExpired && !$isHired)
                            <div class="pt-4 border-t border-[#031b4e]/10 text-center">
                                <p class="text-xs text-[#031b4e]/70 mb-3 text-center">You have exhausted your allowed applications for this plan. Please renew to continue applying.</p>
                                <a href="{{ route('candidate.payment.show', ['type' => 'renewal']) }}"
                                    class="block w-full py-3 bg-gradient-to-r from-[#031b4e] to-[#0ea5e9] text-white font-bold text-sm text-center rounded-xl shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-sync-alt mr-1"></i> Renew Plan
                                </a>
                            </div>
                        @elseif($limitReached && $hasActiveApplications)
                            <div class="pt-4 border-t border-[#031b4e]/10 text-center">
                                <p class="text-xs text-[#031b4e]/70 mb-3 text-center">You've reached your application limit, but your applications are currently in progress. Please wait for the results.</p>
                                <span class="inline-block px-4 py-2 bg-accent-yellow/10 text-accent-yellow font-bold text-xs rounded-lg border border-accent-yellow/20">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Applications Under Review
                                </span>
                            </div>
                        @elseif($profile->plan_type !== 'premium')
                            <div class="pt-4 border-t border-[#031b4e]/10">
                                <p class="text-xs text-[#031b4e]/70 mb-3 text-center">Get more opportunities and faster
                                    placements with Premium.</p>
                                <a href="{{ route('candidate.payment.show') }}"
                                    class="block w-full py-3 bg-gradient-to-r from-accent-yellow to-yellow-500 text-[#031b4e] font-bold text-sm text-center rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-rocket mr-1"></i> Upgrade to Premium
                                </a>
                            </div>
                        @else
                            <div class="pt-4 border-t border-[#031b4e]/10 text-center">
                                <span
                                    class="inline-block px-4 py-2 bg-accent-yellow/10 text-accent-yellow font-bold text-xs rounded-lg border border-accent-yellow/20">
                                    <i class="fas fa-crown mr-1"></i> You are on the best plan!
                                </span>
                            </div>
                        @endif
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




