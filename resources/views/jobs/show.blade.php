@extends('layouts.app')

@section('title', ($job->title ?? 'Teacher Vacancy') . ' in ' . ($job->city?->name ?? 'Bihar') . ' | Warriors Educare')
@section('meta_description', 'Apply for ' . ($job->title ?? 'Teacher') . ' vacancy in ' . ($job->city?->name ?? 'Bihar') . '. Verified educational placement by Warriors Educare Consultancy.')

@section('content')
<x-page-header title="{{ $job->title ?? 'Teaching Opportunity' }}" :breadcrumbs="['Home' => route('home'), 'Jobs' => route('jobs'), ($job->job_id ?: 'Job Details') => null]" />

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

                <!-- 1. Hero Job Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-[0_10px_30px_rgba(3,27,78,0.04)] relative">

                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-2 flex-wrap">
                            <!-- Job ID Badge -->
                            <span class="inline-flex items-center gap-1.5 font-mono text-xs font-black text-indigo-700 bg-indigo-50 border border-indigo-200/80 px-3 py-1 rounded-xl shadow-xs">
                                <i class="fas fa-hashtag text-[10px] text-indigo-500"></i> {{ $job->job_id ?: 'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            
                            @if($job->category)
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-sky-800 bg-sky-50 border border-sky-200/60 px-3 py-1 rounded-xl">
                                    <i class="fas fa-layer-group text-[10px] text-sky-500"></i> {{ $job->category->name }}
                                </span>
                            @endif

                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200/60 px-3 py-1 rounded-xl">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Actively Hiring
                            </span>
                        </div>

                        <span class="text-xs font-bold text-slate-400 flex items-center gap-1.5">
                            <i class="far fa-clock"></i> Posted {{ $job->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Role Icon & Title Header -->
                    <div class="flex items-start gap-4 sm:gap-5 mb-6">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50/80 border border-blue-100 flex items-center justify-center text-2xl sm:text-3xl text-[#0ea5e9] shadow-sm shrink-0">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="flex-1">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-[#031b4e] tracking-tight leading-tight mb-2">
                                {{ $job->title ?? 'Teaching Vacancy' }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs sm:text-sm font-semibold text-slate-600">
                                <span class="flex items-center gap-1.5 text-slate-700 bg-slate-100/80 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                    <i class="fas fa-shield-alt text-[#0ea5e9]"></i> Verified Institution (Confidential)
                                </span>
                                <span class="flex items-center gap-1.5 text-slate-500">
                                    <i class="fas fa-map-marker-alt text-red-500"></i> {{ $job->city?->name ?? 'N/A' }}, {{ $job->state?->name ?? 'Bihar' }}
                                </span>
                                @if($job->job_type)
                                    <span class="flex items-center gap-1.5 text-slate-500">
                                        <i class="fas fa-briefcase text-amber-500"></i> {{ $job->job_type }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 4 Metric Cards Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 pt-6 border-t border-slate-100">
                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-book text-sky-500"></i> Subject
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate" title="{{ $job->subject?->name ?? 'General' }}">
                                {{ $job->subject?->name ?? 'General' }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-graduation-cap text-purple-500"></i> Qualification
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate" title="{{ $job->qualification?->name ?? 'Any Graduate' }}">
                                {{ $job->qualification?->name ?? 'Any Graduate' }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-slate-50/80 border border-slate-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-award text-amber-500"></i> Specialization
                            </span>
                            <span class="font-extrabold text-[#031b4e] text-xs sm:text-sm truncate" title="{{ $job->specialization?->name ?? 'None' }}">
                                {{ $job->specialization?->name ?? 'Not Specified' }}
                            </span>
                        </div>

                        <div class="p-3.5 sm:p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200/60 flex flex-col justify-center">
                            <span class="text-[10px] sm:text-[11px] font-bold text-emerald-700 uppercase tracking-wider mb-1 flex items-center gap-1">
                                <i class="fas fa-indian-rupee-sign text-emerald-600"></i> Salary Range
                            </span>
                            <span class="font-extrabold text-emerald-900 text-xs sm:text-sm truncate" title="{{ $job->salary_range ?? 'Best in Industry' }}">
                                {{ $job->salary_range ?? 'Best in Industry' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 2. Detailed Job Description & Requirements -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-[0_10px_30px_rgba(3,27,78,0.04)]">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0ea5e9] flex items-center justify-center text-base font-bold shadow-xs">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-[#031b4e]">
                                Role Overview & Key Requirements
                            </h3>
                            <p class="text-xs text-slate-500">Read the detailed scope of work and eligibility criteria</p>
                        </div>
                    </div>

                    <!-- Formatted Content Container -->
                    <div class="bg-slate-50/60 border border-slate-200/80 rounded-2xl p-5 sm:p-7 text-slate-700 leading-relaxed text-xs sm:text-sm [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:space-y-2 [&_ul]:my-3.5 [&_li]:text-slate-700 [&_li]:marker:text-[#0ea5e9] [&_li]:marker:font-bold [&_p]:mb-3.5 [&_h4]:font-black [&_h4]:text-[#031b4e] [&_h4]:text-xs sm:[&_h4]:text-sm [&_h4]:mt-5 [&_h4]:mb-2 [&_h4]:uppercase [&_h4]:tracking-wider [&_h4]:border-b [&_h4]:border-slate-200 [&_h4]:pb-1.5">
                        @php
                            $rawDesc = $job->description ?? '';

                            if (empty(trim($rawDesc))) {
                                $formattedDescription = '<p class="text-slate-500 italic text-sm">No specific description provided. Please apply to speak with our placement counselor regarding detailed responsibilities.</p>';
                            } else {
                                $hasHtml = preg_match('/<[a-z][\s\S]*>/i', $rawDesc);

                                if ($hasHtml) {
                                    $formattedDescription = $rawDesc;
                                } else {
                                    $normalized = str_replace(['•', '·', '►', '▪', '⁃', '●'], '•', $rawDesc);

                                    $sectionKeywords = [
                                        'Key Responsibilities:', 'Responsibilities:', 'Job Responsibilities:',
                                        'Requirements:', 'Key Requirements:', 'Eligibility:', 'Qualifications:',
                                        'Job Details:', 'Job Overview:', 'Key Details:', 'About the Role:',
                                        'Job Type:', 'Location:', 'Salary:', 'Perks & Benefits:', 'Perks:'
                                    ];

                                    foreach ($sectionKeywords as $keyword) {
                                        $normalized = preg_replace('/(?i)' . preg_quote($keyword, '/') . '/', "\n\n<h4>" . trim($keyword, ':') . "</h4>\n", $normalized);
                                    }

                                    $normalized = preg_replace('/(?<!^|\n)•/', "\n•", $normalized);
                                    $rawLines = explode("\n", $normalized);
                                    $outputHtml = '';
                                    $inList = false;

                                    foreach ($rawLines as $line) {
                                        $trimmed = trim($line);
                                        if (empty($trimmed)) continue;

                                        if (strpos($trimmed, '<h4>') === 0) {
                                            if ($inList) {
                                                $outputHtml .= '</ul>';
                                                $inList = false;
                                            }
                                            $outputHtml .= $trimmed;
                                        }
                                        elseif (strpos($trimmed, '•') === 0 || strpos($trimmed, '-') === 0 || strpos($trimmed, '*') === 0) {
                                            if (!$inList) {
                                                $outputHtml .= '<ul>';
                                                $inList = true;
                                            }
                                            $cleanItem = e(trim(ltrim($trimmed, '•-* ')));
                                            $outputHtml .= '<li>' . $cleanItem . '</li>';
                                        }
                                        else {
                                            if ($inList) {
                                                $outputHtml .= '</ul>';
                                                $inList = false;
                                            }
                                            $outputHtml .= '<p>' . e($trimmed) . '</p>';
                                        }
                                    }

                                    if ($inList) {
                                        $outputHtml .= '</ul>';
                                    }

                                    $formattedDescription = $outputHtml;
                                }
                            }
                        @endphp
                        {!! $formattedDescription !!}
                    </div>
                </div>

                <!-- 3. Placement & Selection Process -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-[0_10px_30px_rgba(3,27,78,0.04)]">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-base font-bold shadow-xs">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-[#031b4e]">
                                Recruitment & Placement Workflow
                            </h3>
                            <p class="text-xs text-slate-500">How Warriors Educare facilitates your hiring journey</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 text-center relative">
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 shadow-sm">1</div>
                            <h4 class="font-bold text-xs text-[#031b4e] mb-1">Apply for Role</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">Submit your profile application online</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 text-center relative">
                            <div class="w-8 h-8 rounded-full bg-[#031b4e] text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 shadow-sm">2</div>
                            <h4 class="font-bold text-xs text-[#031b4e] mb-1">Profile Screening</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">Admin screens qualification & experience</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 text-center relative">
                            <div class="w-8 h-8 rounded-full bg-amber-500 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 shadow-sm">3</div>
                            <h4 class="font-bold text-xs text-[#031b4e] mb-1">Demo & Interview</h4>
                            <p class="text-[11px] text-slate-500 leading-tight">School schedules personal/online round</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center relative">
                            <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 shadow-sm">4</div>
                            <h4 class="font-bold text-xs text-emerald-900 mb-1">Final Selection</h4>
                            <p class="text-[11px] text-emerald-700 leading-tight">Offer letter and joining coordination</p>
                        </div>
                    </div>
                </div>

                <!-- 4. Consultancy Disclaimer & Transparency Note -->
                <div class="bg-blue-50/60 border border-blue-200/70 rounded-3xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-[#0ea5e9] flex items-center justify-center text-lg shrink-0 mt-0.5">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="text-xs text-blue-900 leading-relaxed">
                        <h4 class="font-extrabold text-sm text-[#031b4e] mb-1">Authentic & Verified Placement Notice</h4>
                        <p class="text-slate-600">
                            Warriors Educare acts as an authorized placement & recruitment agency. Selection, final salary terms, and appointment letters are issued solely by the respective hiring institution based on your interview performance. No fraudulent or hidden charges apply.
                        </p>
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
                            Direct Placement
                        </span>
                        <h3 class="text-lg font-black text-[#031b4e] mt-2 mb-1">Ready to Apply?</h3>
                        <p class="text-xs text-slate-500">Your profile will be reviewed by Warriors Educare team.</p>
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
                                        <p class="text-xs text-emerald-700 mt-0.5">You have applied for this position. Our team will contact you once shortlisted.</p>
                                    </div>
                                    <a href="{{ route('candidate.applications.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0ea5e9] hover:underline">
                                        <i class="fas fa-list-check"></i> View My Applications &rarr;
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('candidate.applications.apply', $job->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <button type="submit" class="w-full py-4 bg-[#0ea5e9] hover:bg-[#0284c7] text-white font-extrabold rounded-2xl shadow-lg shadow-[#0ea5e9]/30 hover:shadow-[#0ea5e9]/50 hover:-translate-y-0.5 active:translate-y-0 transition-all text-sm flex items-center justify-center gap-2 cursor-pointer">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Submit Application Now</span>
                                    </button>
                                </form>
                                <p class="text-[11px] text-center text-slate-400 mt-2 flex items-center justify-center gap-1">
                                    <i class="fas fa-lock text-[9px]"></i> Free submission with verified profile
                                </p>
                            @endif
                        @else
                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center text-xs text-slate-600 mb-2">
                                You are logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong>. Please log in with a candidate account to apply.
                            </div>
                        @endif
                    @else
                        <div class="space-y-3">
                            <a href="{{ route('candidate.register') }}" class="w-full py-4 bg-[#031b4e] hover:bg-[#02143a] text-white font-extrabold rounded-2xl shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all text-xs sm:text-sm flex items-center justify-center gap-2 text-center">
                                <i class="fas fa-user-plus"></i>
                                <span>Register as Candidate to Apply</span>
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
                            <span>Pre-screened & authentic vacancy</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Direct interview coordination support</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span>Transparent salary & placement terms</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Share This Job Card -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#031b4e] mb-3 flex items-center gap-2">
                        <i class="fas fa-share-alt text-[#0ea5e9]"></i> Share This Vacancy
                    </h4>
                    <p class="text-xs text-slate-500 mb-4">Know a teacher looking for a job? Share this requirement.</p>

                    <div class="flex items-center gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode('Teacher Vacancy: ' . ($job->title ?? 'Teacher') . ' (Job ID: ' . ($job->job_id ?: 'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT)) . '). Location: ' . ($job->city?->name ?? 'Bihar') . '. Check details and apply: ' . url()->current()) }}" 
                           target="_blank" 
                           class="flex-1 py-2.5 px-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fab fa-whatsapp text-sm"></i> WhatsApp
                        </a>

                        <button type="button" 
                                onclick="navigator.clipboard.writeText(window.location.href); alert('Job link copied to clipboard!');" 
                                class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-1.5">
                            <i class="fas fa-copy text-xs"></i> Copy
                        </button>
                    </div>
                </div>

                <!-- 3. Placement Counselor Helpline Card -->
                <div class="bg-gradient-to-br from-[#031b4e] to-[#0a2f7c] rounded-3xl p-6 text-white shadow-xl">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg mb-3">
                        <i class="fas fa-headset text-sky-400"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-white mb-1">Need Placement Help?</h4>
                    <p class="text-xs text-slate-300 mb-4 leading-relaxed">
                        Have queries about this vacancy or want guidance regarding demo preparations? Talk to our placement manager.
                    </p>
                    <div class="space-y-2 text-xs font-semibold">
                        <a href="tel:+919798617029" class="flex items-center gap-2 text-sky-300 hover:underline">
                            <i class="fas fa-phone-alt text-[10px]"></i> +91 97986 17029
                        </a>
                        <a href="mailto:support@warriorseducare.com" class="flex items-center gap-2 text-slate-300 hover:underline">
                            <i class="fas fa-envelope text-[10px]"></i> support@warriorseducare.com
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Similar / Recommended Jobs Section -->
        @if(isset($similarJobs) && $similarJobs->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200/80">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#0ea5e9]">Explore More Vacancies</span>
                        <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] mt-1">Similar Teaching Positions</h2>
                    </div>
                    <a href="{{ route('jobs') }}" class="text-xs sm:text-sm font-bold text-[#0ea5e9] hover:underline flex items-center gap-1">
                        View All Jobs <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($similarJobs as $simJob)
                        <div class="bg-white border border-slate-200/80 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-[#0ea5e9]/40 transition-all flex flex-col justify-between group">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="font-mono text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2.5 py-0.5 rounded-lg border border-indigo-100">
                                        {{ $simJob->job_id ?: 'JOB-' . str_pad($simJob->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400">
                                        {{ $simJob->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="font-extrabold text-[#031b4e] text-base group-hover:text-[#0ea5e9] transition-colors line-clamp-1 mb-1">
                                    <a href="{{ route('jobs.show', $simJob->id) }}">{{ $simJob->title ?? 'Teacher Required' }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 mb-4 line-clamp-1">
                                    <i class="fas fa-shield-alt text-[#0ea5e9] text-[10px]"></i> Verified Institution • {{ $simJob->city?->name ?? 'Bihar' }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-700">{{ $simJob->subject?->name ?? 'General' }}</span>
                                <a href="{{ route('jobs.show', $simJob->id) }}" class="text-xs font-bold text-[#0ea5e9] hover:underline">
                                    View Role &rarr;
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
