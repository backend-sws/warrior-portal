@extends('layouts.app')

@php
    $tuitionTitle = ($tuition->subjects ?? 'Home Tuition Requirement') . ' for Class ' . ($tuition->class ?? '');
    $tuitionLocation = $tuition->location . ($tuition->pincode ? ' (Pincode: ' . $tuition->pincode . ')' : '');
    $tuitionId = $tuition->tuition_id ?: ('TUI-' . str_pad($tuition->id, 4, '0', STR_PAD_LEFT));
    $shareTuitionUrl = route('tuitions.show', $tuition->id);
    $shareWhatsappText = "🎯 *Home Tuition Requirement Alert - Warriors Educare*\n\n"
        . "📌 *Tuition ID:* {$tuitionId}\n"
        . "📚 *Class & Board:* Class " . ($tuition->class ?? 'N/A') . " (" . ($tuition->board ?: 'General') . ")\n"
        . "📖 *Subjects:* " . ($tuition->subjects ?? 'All Subjects') . "\n"
        . "📍 *Location:* {$tuitionLocation}\n"
        . ($tuition->duration_hours ? "⏱ *Duration:* {$tuition->duration_hours}\n" : "")
        . ($tuition->days_per_week ? "📅 *Days/Week:* {$tuition->days_per_week}\n" : "")
        . "💰 *Tuition Fee:* " . (auth()->check() ? ($tuition->fee ? '₹' . $tuition->fee . '/month' : 'Negotiable') : 'Login to View') . "\n"
        . "👤 *Tutor Preference:* " . ($tuition->tutor_preference ?: 'Any Male/Female') . "\n\n"
        . "👉 *Check Details & Apply Directly:* \n{$shareTuitionUrl}";
@endphp

@section('title', "{$tuitionTitle} in {$tuitionLocation} | Warriors Educare")
@section('meta_description', "Verified Home Tuition Requirement ({$tuitionId}): Class {$tuition->class} ({$tuition->subjects}) in {$tuitionLocation}. " . (auth()->check() ? ('Fee: ' . ($tuition->fee ? '₹'.$tuition->fee : 'Negotiable') . '. ') : '') . "Apply now as a verified home tutor with Warriors Educare.")
@section('canonical_url', $shareTuitionUrl)
@section('og_url', $shareTuitionUrl)

@section('content')
<x-page-header title="{{ $tuitionTitle }}" :breadcrumbs="['Home' => route('home'), 'Tuitions' => route('tuitions'), ($tuitionId) => null]" />

<div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-[5%] bg-slate-50/80 min-h-screen relative">
    <!-- Subtle Background Grid Pattern -->
    <div class="absolute inset-0 z-0 opacity-[0.02] pointer-events-none" style="background-image: radial-gradient(#031b4e 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl shadow-sm flex items-center justify-between animate-fadeIn">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h4 class="text-rose-900 font-extrabold text-xs sm:text-sm">Action Notice</h4>
                        <p class="text-xs text-rose-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="text-rose-400 hover:text-rose-600 p-2" onclick="this.parentElement.remove();">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-sm flex items-center justify-between animate-fadeIn">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h4 class="text-emerald-900 font-extrabold text-xs sm:text-sm">Application Sent!</h4>
                        <p class="text-xs text-emerald-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="text-emerald-400 hover:text-emerald-600 p-2" onclick="this.parentElement.remove();">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- MAIN COLUMN (2/3 Width) --}}
            <div class="lg:col-span-2 space-y-6">

                <!-- 1. Hero Tuition Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-[0_10px_30px_rgba(3,27,78,0.04)] relative">

                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-2 flex-wrap">
                            <!-- Tuition ID Badge -->
                            <span class="inline-flex items-center gap-1.5 font-mono text-xs font-black text-accent-blue bg-blue-50 border border-blue-200/80 px-3 py-1 rounded-xl shadow-xs">
                                <i class="fas fa-hashtag text-[10px] text-accent-blue"></i> {{ $tuitionId }}
                            </span>
                            
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-sky-800 bg-sky-50 border border-sky-200/60 px-3 py-1 rounded-xl">
                                <i class="fas fa-graduation-cap text-[10px] text-sky-500"></i> Class {{ $tuition->class }}
                            </span>

                            <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-800 bg-indigo-50 border border-indigo-200/60 px-3 py-1 rounded-xl">
                                <i class="fas fa-school text-[10px] text-indigo-500"></i> {{ $tuition->board ?: 'General Board' }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200/60 px-3 py-1 rounded-xl">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Tutor Needed
                            </span>
                        </div>

                        <div class="flex items-center gap-2 flex-wrap">
                            <button type="button" 
                                    data-share-url="{{ $shareTuitionUrl }}"
                                    onclick="copyJobUrl(this.dataset.shareUrl, this)" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#031b4e] text-xs font-bold border border-slate-200/80 transition-all active:scale-95 cursor-pointer shadow-2xs">
                                <i class="fas fa-link text-[#0ea5e9] text-xs"></i>
                                <span>Copy Link</span>
                            </button>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($shareWhatsappText) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-200 transition-all active:scale-95 shadow-2xs">
                                <i class="fab fa-whatsapp text-emerald-600 text-xs"></i>
                                <span>Share</span>
                            </a>
                            <span class="text-xs font-bold text-slate-400 flex items-center gap-1.5 ml-1">
                                <i class="far fa-clock"></i> {{ $tuition->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <!-- Role Icon & Title Header -->
                    <div class="flex items-start gap-4 sm:gap-5 mb-6">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50/80 border border-blue-100 flex items-center justify-center text-2xl sm:text-3xl text-[#0ea5e9] shadow-sm shrink-0">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="flex-1">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-[#031b4e] tracking-tight leading-tight mb-2">
                                {{ $tuition->subjects ?? 'All Subjects' }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs sm:text-sm font-semibold text-slate-600">
                                <span class="flex items-center gap-1.5 text-slate-700 bg-slate-100/80 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                    <i class="fas fa-user-check text-[#0ea5e9]"></i> Verified Parent Requirement
                                </span>
                                <span class="flex items-center gap-1.5 text-slate-500">
                                    <i class="fas fa-map-marker-alt text-red-500"></i> {{ $tuition->location }}
                                </span>
                                @if($tuition->pincode)
                                    <span class="flex items-center gap-1.5 text-slate-500 font-mono">
                                        <i class="fas fa-mail-bulk text-amber-500"></i> {{ $tuition->pincode }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 6 Metric Cards Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4 pt-6 border-t border-slate-100">
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-book text-sky-500"></i> Class & Board
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate">
                                Class {{ $tuition->class }} ({{ $tuition->board ?: 'General' }})
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-layer-group text-purple-500"></i> Subjects
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate" title="{{ $tuition->subjects }}">
                                {{ $tuition->subjects }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-clock text-sky-600"></i> Duration
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate">
                                {{ $tuition->duration_hours ?: '1.5 Hours / Day' }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-calendar-week text-indigo-500"></i> Days / Week
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate">
                                {{ $tuition->days_per_week ?: '5-6 Days / Week' }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-venus-mars text-amber-500"></i> Gender Pref
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate">
                                {{ $tuition->tutor_preference ?: 'Any Male/Female' }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-emerald-700 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-indian-rupee-sign text-emerald-600"></i> Monthly Fee
                            </span>
                            @auth
                                <span class="font-extrabold text-emerald-900 text-xs sm:text-sm truncate">
                                    {{ $tuition->fee ? '₹' . $tuition->fee . '/mo' : 'Negotiable' }}
                                </span>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-emerald-800 blur-sm select-none text-xs sm:text-sm">₹XXXX</span>
                                    <a href="{{ route('login') }}" class="text-[10px] sm:text-[11px] font-bold text-[#0ea5e9] hover:underline whitespace-nowrap">Login to view</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- 2. Detailed Requirement Breakdown -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#031b4e] mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle text-[#0ea5e9]"></i> Tuition Requirement Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Student Class:</span>
                                <span class="font-extrabold text-[#031b4e]">Class {{ $tuition->class }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Education Board:</span>
                                <span class="font-extrabold text-[#031b4e]">{{ $tuition->board ?: 'General / State Board' }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Subjects Required:</span>
                                <span class="font-extrabold text-[#031b4e]">{{ $tuition->subjects }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Class Duration:</span>
                                <span class="font-extrabold text-[#031b4e]">{{ $tuition->duration_hours ?: '1.5 Hours / Day (Kitne ghante padhana hai)' }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Weekly Classes:</span>
                                <span class="font-extrabold text-[#031b4e]">{{ $tuition->days_per_week ?: '5 Days / Week (Week me kitne din padhana hoga)' }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Preferred Timing:</span>
                                <span class="font-extrabold text-[#031b4e]">{{ $tuition->preferred_timing ?: 'Flexible / Mutual Discussion' }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Tutor Gender Preference:</span>
                                <span class="font-extrabold text-[#031b4e]">{{ $tuition->tutor_preference ?: 'No Preference (Any)' }}</span>
                            </div>
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Monthly Tuition Fee:</span>
                                @auth
                                    <span class="font-extrabold text-emerald-700">{{ $tuition->fee ? '₹'.$tuition->fee : 'Negotiable' }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="font-bold text-emerald-700 blur-sm select-none">₹XXXX</span>
                                        <a href="{{ route('login') }}" class="text-xs font-bold text-[#0ea5e9] hover:underline">(Login to view)</a>
                                    </span>
                                @endauth
                            </div>
                        </div>
                    </div>

                    @if(!empty($tuition->additional_notes))
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Special Instructions / Parent Notes</h4>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs sm:text-sm text-slate-700 leading-relaxed">
                            {{ $tuition->additional_notes }}
                        </div>
                    </div>
                    @endif

                    <!-- Verified Badge Notice -->
                    <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-[#0ea5e9] flex items-center justify-center text-sm shrink-0 mt-0.5">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="text-xs text-blue-900 leading-relaxed">
                            <h4 class="font-extrabold text-sm text-[#031b4e] mb-1">Authentic & Verified Home Tuition Lead</h4>
                            <p class="text-slate-600">
                                This tuition requirement has been screened and verified by the Warriors Educare placement desk. Once your application is reviewed, demo classes will be scheduled directly with the parents.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- SIDEBAR / ACTION COLUMN (1/3 Width - Sticky) --}}
            <div class="space-y-6 lg:sticky lg:top-24">

                <!-- 1. Primary Action & Apply Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-36 h-36 bg-blue-500/5 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="text-center mb-6">
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#0ea5e9] bg-blue-50 border border-blue-200/60 px-3 py-1 rounded-full">
                            Home Tutor Requirement
                        </span>
                        <h3 class="text-lg font-black text-[#031b4e] mt-2 mb-1">Apply for this Tuition?</h3>
                        <p class="text-xs text-slate-500">Your profile will be matched and shortlisted by our team.</p>
                    </div>

                    @auth
                        @if(auth()->user()->role === 'candidate')
                            @if($hasApplied)
                                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-center space-y-3 mb-4">
                                    <div class="w-12 h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto text-xl shadow-md">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-[#031b4e] text-sm">Application Already Submitted</h4>
                                        <p class="text-xs text-emerald-700 mt-0.5">You have applied for this home tuition. Our team will contact you once matched with parents.</p>
                                    </div>
                                    <a href="{{ route('candidate.tuitions.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0ea5e9] hover:underline">
                                        <i class="fas fa-list-check"></i> View My Tuitions &rarr;
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('candidate.tuitions.apply', $tuition->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <button type="submit" class="w-full py-4 bg-[#0ea5e9] hover:bg-[#0284c7] text-white font-extrabold rounded-2xl shadow-lg shadow-[#0ea5e9]/30 hover:shadow-[#0ea5e9]/50 hover:-translate-y-0.5 active:translate-y-0 transition-all text-sm flex items-center justify-center gap-2 cursor-pointer">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Apply as Home Tutor</span>
                                    </button>
                                </form>
                                <p class="text-[11px] text-center text-slate-400 mt-2 flex items-center justify-center gap-1">
                                    <i class="fas fa-lock text-[9px]"></i> Free submission with verified profile
                                </p>
                            @endif
                        @else
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center text-xs text-slate-600 mb-2">
                                You are logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong>. Please log in with a candidate/tutor account to apply.
                            </div>
                        @endif
                    @else
                        <div class="space-y-3">
                            <a href="{{ route('candidate.register') }}" class="w-full py-4 bg-[#031b4e] hover:bg-[#02143a] text-white font-extrabold rounded-2xl shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all text-xs sm:text-sm flex items-center justify-center gap-2 text-center">
                                <i class="fas fa-user-plus"></i>
                                <span>Register as Tutor to Apply</span>
                            </a>
                            <a href="{{ route('login') }}" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-[#031b4e] font-bold rounded-2xl transition-colors text-xs sm:text-sm flex items-center justify-center gap-2 text-center">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Already Registered? Sign In</span>
                            </a>
                        </div>
                    @endauth

                    <!-- Quick Bullet Highlights -->
                    <div class="mt-6 pt-5 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>100% Verified Parent Requirement</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Free Demo Class Coordination</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Guaranteed Monthly Tuition Payouts</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Share This Tuition Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#031b4e] mb-2 flex items-center gap-2">
                        <i class="fas fa-share-alt text-[#0ea5e9]"></i> Share This Tuition Vacancy
                    </h4>
                    <p class="text-xs text-slate-500 mb-4">Copy this tuition's direct link to send to teachers or share on social media.</p>

                    <!-- Direct Copyable Link Box -->
                    <div class="mb-3 flex items-center bg-slate-50 border border-slate-200/90 rounded-2xl p-1.5 pl-3 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all">
                        <input type="text" readonly value="{{ $shareTuitionUrl }}" id="shareTuitionUrlInput" 
                               class="w-full bg-transparent text-xs text-slate-700 font-mono outline-none select-all cursor-pointer font-medium" 
                               onclick="this.select()" />
                        <button type="button" 
                                data-share-url="{{ $shareTuitionUrl }}"
                                onclick="copyJobUrl(this.dataset.shareUrl, this)" 
                                class="shrink-0 py-2 px-3.5 bg-[#031b4e] hover:bg-[#0a2f7c] text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm active:scale-95 cursor-pointer">
                            <i class="fas fa-copy text-xs"></i>
                            <span>Copy Link</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($shareWhatsappText) }}" 
                           target="_blank" 
                           class="py-2.5 px-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fab fa-whatsapp text-sm text-emerald-600"></i> WhatsApp
                        </a>

                        <a href="https://t.me/share/url?url={{ urlencode($shareTuitionUrl) }}&text={{ urlencode('🎯 Home Tuition: ' . $tuitionTitle . ' in ' . $tuitionLocation) }}" 
                           target="_blank" 
                           class="py-2.5 px-3 bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fab fa-telegram-plane text-sm text-sky-500"></i> Telegram
                        </a>
                    </div>
                </div>

                <!-- 3. Placement Counselor Helpline Card -->
                <div class="bg-gradient-to-br from-[#031b4e] to-[#0a2f7c] rounded-3xl p-6 text-white shadow-xl">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg mb-3">
                        <i class="fas fa-headset text-sky-400"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-white mb-1">Need Tuition Help?</h4>
                    <p class="text-xs text-slate-300 mb-4 leading-relaxed">
                        Have queries about this tuition requirement or want help coordinating the demo class? Talk to our placement counselor.
                    </p>
                    <div class="space-y-2 text-xs font-semibold">
                        <a href="tel:+918210545286" class="flex items-center gap-2 text-sky-300 hover:underline">
                            <i class="fas fa-phone-alt text-[10px]"></i> +91 82105 45286
                        </a>
                        <a href="mailto:support@warriorseducare.com" class="flex items-center gap-2 text-slate-300 hover:underline">
                            <i class="fas fa-envelope text-[10px]"></i> support@warriorseducare.com
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Similar / Recommended Tuitions Section -->
        @if(isset($similarTuitions) && $similarTuitions->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200/80">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#0ea5e9]">Explore More Requirements</span>
                        <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] mt-1">Similar Home Tuition Openings</h2>
                    </div>
                    <a href="{{ route('tuitions') }}" class="text-xs sm:text-sm font-bold text-[#0ea5e9] hover:underline flex items-center gap-1">
                        View All Tuitions <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($similarTuitions as $simTuition)
                        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-[#0ea5e9]/40 transition-all flex flex-col justify-between group">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="font-mono text-[10px] font-bold text-accent-blue bg-blue-50 px-2.5 py-0.5 rounded-lg border border-blue-100">
                                        {{ $simTuition->tuition_id ?: 'TUI-' . str_pad($simTuition->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400">
                                        {{ $simTuition->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="font-extrabold text-[#031b4e] text-base group-hover:text-[#0ea5e9] transition-colors line-clamp-1 mb-1">
                                    <a href="{{ route('tuitions.show', $simTuition->id) }}">Class {{ $simTuition->class }} ({{ $simTuition->subjects }})</a>
                                </h3>
                                <p class="text-xs text-slate-500 mb-4 line-clamp-1">
                                    <i class="fas fa-map-marker-alt text-red-500 text-[10px]"></i> {{ $simTuition->location }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                @auth
                                    <span class="font-bold text-emerald-600">{{ $simTuition->fee ? '₹'.$simTuition->fee : 'Negotiable' }}</span>
                                @else
                                    <span class="font-bold text-emerald-600 blur-sm select-none" title="Login to view fees">₹XXXX</span>
                                @endauth
                                <a href="{{ route('tuitions.show', $simTuition->id) }}" class="text-xs font-bold text-[#0ea5e9] hover:underline">
                                    View Tuition &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
