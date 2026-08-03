@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

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
        <div class="bg-gradient-to-r from-accent-blue to-accent-blue-hover rounded-3xl p-8 mb-8 text-white shadow-lg relative overflow-hidden reveal">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
            <div class="absolute bottom-0 right-32 -mb-16 w-40 h-40 rounded-full bg-white opacity-10 blur-xl"></div>

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
                        class="px-6 py-3 bg-white text-accent-blue font-bold rounded-xl hover:bg-gray-50 transition-all shadow-md flex items-center gap-2">
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
                        class="bg-card-bg rounded-2xl border border-card-border p-6 flex flex-col items-center justify-center text-center hover:border-accent-blue/30 transition-all shadow-sm relative cursor-pointer hover:bg-secondary-bg/30">
                        <div class="w-12 h-12 rounded-xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-xl mb-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        @php
                            $actualUsedApplications = $profile->used_applications;
                        @endphp
                        <h3 class="text-3xl font-bold text-text-main">{{ $actualUsedApplications }} <span
                                class="text-sm text-text-dark/40 font-normal">/
                                {{ $profile->total_allowed_applications }}</span>
                        </h3>
                        <p class="text-xs font-semibold text-text-dark/50 uppercase tracking-wide mt-1">Applications Used
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
                                class="absolute inset-0 bg-black/50 rounded-2xl border border-card-border flex items-center justify-center backdrop-blur-sm flex-col z-10 cursor-default">
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
                        class="bg-card-bg rounded-2xl border border-card-border p-6 flex flex-col items-center justify-center text-center hover:border-green-500/30 hover:bg-secondary-bg/30 transition-all shadow-sm cursor-pointer block">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-500/10 text-green-400 flex items-center justify-center text-xl mb-3 mx-auto">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-text-main">
                            {{ auth()->user()->applications()->where('status', 'shortlisted')->count() }}</h3>
                        <p class="text-xs font-semibold text-text-dark/50 uppercase tracking-wide mt-1">Shortlisted</p>
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
                    class="bg-card-bg rounded-2xl border border-card-border overflow-hidden shadow-sm reveal reveal-delay-2">
                    <div class="px-6 py-4 border-b border-card-border flex justify-between items-center bg-secondary-bg/30">
                        <h3 class="font-bold text-text-main flex items-center gap-2"><i
                                class="fas fa-bell text-accent-yellow"></i> Notifications & Updates</h3>
                    </div>
                    <div class="divide-y divide-card-border">
                        @forelse(auth()->user()->notifications()->take(3)->get() as $notification)
                            <div class="p-5 flex gap-4 hover:bg-secondary-bg/30 transition-colors {{ $notification->unread() ? 'bg-secondary-bg/10' : '' }}">
                                <div
                                    class="w-10 h-10 rounded-full bg-accent-blue/10 text-accent-blue flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-text-main mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h4>
                                    <p class="text-xs text-text-dark/70 leading-relaxed">{{ $notification->data['message'] ?? 'You have a new update.' }}</p>
                                    <span
                                        class="text-[10px] text-text-dark/40 font-medium mt-2 block">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center text-text-dark/50 text-sm">
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Right Column: Profile & Plan --}}
            <div class="space-y-8">
                {{-- Profile Card --}}
                <div class="bg-card-bg rounded-2xl border border-card-border p-6 shadow-sm reveal reveal-delay-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-text-main flex items-center gap-2"><i
                                class="fas fa-id-card text-accent-blue"></i> Profile Overview</h3>
                        <a href="{{ route('candidate.profile.edit') }}"
                            class="text-xs text-accent-blue hover:underline font-semibold">Edit</a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-card-border">
                            <span class="text-sm text-text-dark/60"><i class="fas fa-phone mr-2 w-4"></i> Phone</span>
                            <span class="text-sm font-medium text-text-main">{{ auth()->user()->phone }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-card-border">
                            <span class="text-sm text-text-dark/60"><i class="fas fa-graduation-cap mr-2 w-4"></i>
                                Education</span>
                            <span
                                class="text-sm font-medium text-text-main">{{ $profile->highest_qualification ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-card-border">
                            <span class="text-sm text-text-dark/60"><i class="fas fa-briefcase mr-2 w-4"></i>
                                Experience</span>
                            <span
                                class="text-sm font-medium text-text-main">{{ $profile->years_of_experience ?? 0 }}
                                Years</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-text-dark/60"><i class="fas fa-map-marker-alt mr-2 w-4"></i>
                                Location</span>
                            <span class="text-sm font-medium text-text-main">{{ $profile->city ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-card-border">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-text-main">Profile Completion</span>
                            <span class="text-sm font-bold text-accent-green">{{ $profile->profile_completion_percentage ?? 80 }}%</span>
                        </div>
                        <div class="w-full bg-secondary-bg rounded-full h-2">
                            <div class="bg-accent-green h-2 rounded-full" style="width: {{ $profile->profile_completion_percentage ?? 80 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Current Plan Card --}}
                <div class="bg-card-bg rounded-2xl border border-card-border p-6 shadow-sm reveal reveal-delay-3">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-text-main flex items-center gap-2"><i
                                class="fas fa-box text-accent-purple"></i> Current Plan</h3>
                        <span class="text-xs font-bold px-2.5 py-1 bg-accent-blue/10 text-accent-blue rounded-lg uppercase tracking-wider">
                            {{ $profile->plan_type ?? 'Standard' }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                            <span class="text-sm text-text-dark/80">Access to all standard job postings</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                            <span class="text-sm text-text-dark/80">Basic profile visibility to schools</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas {{ $profile->plan_type === 'premium' ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-400/50' }} mt-0.5"></i>
                            <span class="text-sm text-text-dark/80">Priority placement assistance</span>
                        </div>

                        @if($limitReached && !$isExpired && !$isHired)
                            <div class="pt-4 border-t border-card-border text-center">
                                <p class="text-xs text-text-dark/60 mb-3 text-center">You have exhausted your allowed applications for this plan. Please renew to continue applying.</p>
                                <a href="{{ route('candidate.payment.show', ['type' => 'renewal']) }}"
                                    class="block w-full py-3 bg-gradient-to-r from-accent-blue to-accent-blue-hover text-white font-bold text-sm text-center rounded-xl shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-sync-alt mr-1"></i> Renew Plan
                                </a>
                            </div>
                        @elseif($limitReached && $hasActiveApplications)
                            <div class="pt-4 border-t border-card-border text-center">
                                <p class="text-xs text-text-dark/60 mb-3 text-center">You've reached your application limit, but your applications are currently in progress. Please wait for the results.</p>
                                <span class="inline-block px-4 py-2 bg-accent-yellow/10 text-accent-yellow font-bold text-xs rounded-lg border border-accent-yellow/20">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Applications Under Review
                                </span>
                            </div>
                        @elseif($profile->plan_type !== 'premium')
                            <div class="pt-4 border-t border-card-border">
                                <p class="text-xs text-text-dark/60 mb-3 text-center">Get more opportunities and faster
                                    placements with Premium.</p>
                                <a href="{{ route('candidate.payment.show') }}"
                                    class="block w-full py-3 bg-gradient-to-r from-accent-yellow to-yellow-500 text-[#031b4e] font-bold text-sm text-center rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-rocket mr-1"></i> Upgrade to Premium
                                </a>
                            </div>
                        @else
                            <div class="pt-4 border-t border-card-border text-center">
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
