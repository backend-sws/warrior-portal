@extends('layouts.app')

@php
    $catKey = $category ?? 'both';
    $isSchool = ($catKey === 'school_job');
    $isTutor = ($catKey === 'home_tutor');
    $isBoth = (!$isSchool && !$isTutor);

    $pageTitle = match(true) {
        $isSchool => 'Thank You! School Teacher Application Verified | Warriors Educare',
        $isTutor  => 'Thank You! Home Tutor Registration Verified | Warriors Educare',
        default   => 'Thank You! Dual Teacher Profile Verified | Warriors Educare',
    };

    $badgeText = match(true) {
        $isSchool => 'School Teacher Application Verified',
        $isTutor  => 'Home Tutor Registration Verified',
        default   => 'Dual Profile (Teacher & Tutor) Verified',
    };

    $badgeIcon = match(true) {
        $isSchool => 'fas fa-school',
        $isTutor  => 'fas fa-house-laptop',
        default   => 'fas fa-graduation-cap',
    };

    $heading = match(true) {
        $isSchool => 'Your School Teacher Profile Is Verified!',
        $isTutor  => 'Your Home Tutor Registration Is Complete!',
        default   => 'Your Dual Teacher Profile Is Live & Verified!',
    };

    $subheading = match(true) {
        $isSchool => 'Your teaching credentials, qualification, and resume have been successfully submitted and verified. Partnering schools and educational institutions can now view and shortlist your profile for demo interviews.',
        $isTutor  => 'Your tutor profile is live! You can now receive inquiries from parents and students, apply for matching home tuition leads, and start taking classes in your preferred localities.',
        default   => 'Congratulations! You have unlocked both school recruitment opportunities and premium home tuition assignments under a single verified educator account.',
    };

    $targetUrl = $redirectUrl ?? (auth()->check() ? route('candidate.dashboard') : route('login'));
@endphp

@section('title', $pageTitle)
@section('meta_description', 'Thank you for registering on Warriors Educare. Your profile has been verified and your dashboard is ready.')

@section('content')
<main class="pt-28 pb-20 bg-slate-50 min-h-screen relative overflow-hidden flex items-center justify-center">
    <!-- Ambient Background Glow Elements -->
    <div class="absolute top-12 left-1/2 -translate-x-1/2 w-full max-w-5xl h-96 bg-gradient-to-b from-emerald-100/60 via-blue-50/40 to-transparent blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#031b4e]/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0ea5e9]/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Main Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-2xl shadow-slate-200/60 overflow-hidden text-center p-6 sm:p-12 transition-all">
            
            <!-- Animated Success Check Badge -->
            <div class="relative w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6">
                <div class="absolute inset-0 rounded-full bg-emerald-400/20 animate-ping opacity-75"></div>
                <div class="relative w-full h-full rounded-full bg-gradient-to-tr from-emerald-500 to-teal-400 border-4 border-white shadow-xl shadow-emerald-500/30 flex items-center justify-center text-white text-3xl sm:text-4xl">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <!-- Verification Pill -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 mb-4 shadow-sm">
                <i class="{{ $badgeIcon }} text-emerald-600"></i>
                <span>{{ $badgeText }}</span>
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>

            <!-- Thank You Heading -->
            <h1 class="text-2xl sm:text-4xl font-black text-[#031b4e] tracking-tight mb-3">
                {{ $heading }}
            </h1>

            @if(isset($user) && $user?->name)
                <p class="text-sm sm:text-base font-bold text-slate-800 mb-2">
                    Welcome aboard, <span class="text-[#0ea5e9]">{{ $user->name }}</span>!
                </p>
            @endif
            
            <!-- Description -->
            <p class="text-xs sm:text-sm text-slate-600 font-medium max-w-xl mx-auto mb-8 leading-relaxed">
                {{ $subheading }}
            </p>

            <!-- 3 Highlights Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 text-left">
                <!-- Highlight 1 -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex sm:flex-col items-center sm:items-start gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-emerald-500/20">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-[#031b4e]">OTP Verified</h4>
                        <p class="text-[11px] text-slate-500 leading-snug mt-0.5">Account & email confirmed with 100% completion badge.</p>
                    </div>
                </div>

                <!-- Highlight 2 -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex sm:flex-col items-center sm:items-start gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-xl bg-[#031b4e] text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-slate-900/20">
                        <i class="fas fa-magnifying-glass-chart"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-[#031b4e]">Direct Matching</h4>
                        <p class="text-[11px] text-slate-500 leading-snug mt-0.5">Matched with verified requirements in your preferred location.</p>
                    </div>
                </div>

                <!-- Highlight 3 -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex sm:flex-col items-center sm:items-start gap-3 sm:gap-2">
                    <div class="w-10 h-10 rounded-xl bg-[#0ea5e9] text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-cyan-500/20">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-[#031b4e]">Live Dashboard</h4>
                        <p class="text-[11px] text-slate-500 leading-snug mt-0.5">Track interviews, lead demo requests, and placements easily.</p>
                    </div>
                </div>
            </div>

            <!-- Auto-Redirect Countdown & Enter Dashboard Card -->
            <div class="bg-gradient-to-br from-slate-900 via-[#031b4e] to-[#0a2f7a] text-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-[#031b4e]/20 text-center relative overflow-hidden">
                <!-- Background decorative ring -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Timer Indicator -->
                <div class="flex items-center justify-center gap-2 text-xs sm:text-sm font-bold text-slate-200 mb-4">
                    <i class="fas fa-clock text-amber-300 animate-spin text-sm" style="animation-duration: 3s;"></i>
                    <span>Redirecting to your dashboard in <span id="countdownTimer" class="text-lg sm:text-xl font-black text-amber-300 px-1.5 py-0.5 bg-white/10 rounded-lg border border-white/15">8</span> seconds...</span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full max-w-md mx-auto bg-white/15 rounded-full h-2 overflow-hidden mb-6 p-0.5">
                    <div id="redirectProgress" class="bg-gradient-to-r from-amber-400 to-emerald-400 h-full rounded-full transition-all duration-1000 ease-linear" style="width: 0%;"></div>
                </div>

                <!-- CTA Button -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a id="enterDashboardBtn" href="{{ $targetUrl }}" 
                       class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2.5 cursor-pointer">
                        <span>Enter Your Dashboard</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <p class="text-[11px] text-slate-300/80 mt-3 font-medium">
                    If you are not redirected automatically, please click the button above.
                </p>
            </div>

            <!-- Footer Support Links -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <i class="fas fa-headset text-[#0ea5e9]"></i>
                    <span>Need help? Call <a href="tel:+918210545286" class="font-bold text-[#031b4e] hover:underline">+91 82105 45286</a></span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="hover:text-[#031b4e] transition-colors font-medium">Return to Home</a>
                    <span>•</span>
                    <a href="{{ route('contact') }}" class="hover:text-[#031b4e] transition-colors font-medium">Contact Support</a>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = 8;
    const totalTime = 8;
    const countdownEl = document.getElementById('countdownTimer');
    const progressBar = document.getElementById('redirectProgress');
    const targetUrl = "{{ $targetUrl }}";

    // Initial progress bar trigger
    if (progressBar) {
        progressBar.style.width = '5%';
    }

    const timer = setInterval(function() {
        timeLeft--;
        if (countdownEl) {
            countdownEl.textContent = timeLeft;
        }

        if (progressBar) {
            const percentage = Math.min(100, Math.max(5, ((totalTime - timeLeft) / totalTime) * 100));
            progressBar.style.width = percentage + '%';
        }

        if (timeLeft <= 0) {
            clearInterval(timer);
            window.location.href = targetUrl;
        }
    }, 1000);
});
</script>
@endsection
