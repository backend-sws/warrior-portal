@extends('layouts.app')

@section('title', 'Recommended School Jobs - Candidate Dashboard | Warriors Educare')

@section('content')
@include('candidate.partials.nav')

<div class="bg-[#f8fafc] min-h-[calc(100vh-140px)] py-6 sm:py-8"
     x-data="{
         searchQuery: '',
         filterMatch: 'all',
         filterSubject: 'all',
         selectedJob: null,
         modalOpen: false,
         openModal(job) {
             this.selectedJob = job;
             this.modalOpen = true;
         },
         closeModal() {
             this.modalOpen = false;
             this.selectedJob = null;
         }
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 sm:mb-8 reveal">
            <div class="flex items-start sm:items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-[#031b4e] text-white flex items-center justify-center text-xl shrink-0 shadow-lg shadow-[#031b4e]/20">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-black text-[#031b4e] tracking-tight">Recommended School Jobs</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-[#0ea5e9]/10 text-[#0ea5e9] border border-[#0ea5e9]/20">
                            {{ count($matchedJobs) }} Openings
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Verified vacancies matching your teaching subject, level, and preferred location.</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <a href="{{ route('candidate.applications.index') }}" 
                   class="flex-1 sm:flex-initial px-4 py-2.5 bg-white hover:bg-slate-50 text-[#031b4e] border border-slate-200 rounded-xl text-xs sm:text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs text-[#0ea5e9]"></i>
                    <span>My Applications</span>
                    @php
                        $myAppCount = auth()->user()->applications()->count();
                    @endphp
                    @if($myAppCount > 0)
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-[#031b4e] text-white font-extrabold">{{ $myAppCount }}</span>
                    @endif
                </a>
                <a href="{{ route('candidate.tuitions.index') }}" 
                   class="flex-1 sm:flex-initial px-4 py-2.5 bg-[#031b4e] hover:bg-[#0a2970] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-book-reader text-xs text-[#fbc043]"></i>
                    <span>Home Tuitions</span>
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-down">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs shrink-0 shadow-sm">
                    <i class="fas fa-check"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-bold text-emerald-900">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-down">
                <div class="w-8 h-8 rounded-xl bg-red-500 text-white flex items-center justify-center text-xs shrink-0 shadow-sm">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-bold text-red-900">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Profile Matching Preferences Banner --}}
        @php
            $hasPref = $profile && ($profile->subject || $profile->category || $profile->preferredCity);
        @endphp
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-5 mb-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-sliders"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Active Match Filter</span>
                    @if($hasPref)
                        <div class="flex flex-wrap items-center gap-2 mt-0.5">
                            @if($profile->subject)
                                <span class="text-xs font-extrabold text-[#031b4e] bg-slate-100 px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-book text-[#0ea5e9] mr-1"></i> {{ $profile->subject->name }}
                                </span>
                            @endif
                            @if($profile->category)
                                <span class="text-xs font-extrabold text-[#031b4e] bg-slate-100 px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-graduation-cap text-[#fbc043] mr-1"></i> {{ $profile->category->name }}
                                </span>
                            @endif
                            @if($profile->preferredCity)
                                <span class="text-xs font-extrabold text-[#031b4e] bg-slate-100 px-2.5 py-1 rounded-lg">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $profile->preferredCity->name }}
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="text-xs text-slate-600 mt-0.5">Set your preferred subject and city in profile to get 100% accurate match recommendations.</p>
                    @endif
                </div>
            </div>
            <a href="{{ route('candidate.profile.edit') }}" class="text-xs font-bold text-[#0ea5e9] hover:text-[#031b4e] flex items-center gap-1 self-start md:self-auto bg-slate-50 hover:bg-slate-100 px-3.5 py-2 rounded-xl border border-slate-200 transition-colors shrink-0">
                <i class="fas fa-edit text-[11px]"></i> Edit Preferences &rarr;
            </a>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 mb-6 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                
                {{-- Search Bar --}}
                <div class="lg:col-span-6 relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" x-model="searchQuery"
                           placeholder="Search by title, subject, school name, or city..."
                           class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#031b4e] focus:border-transparent transition-all">
                    <button type="button" x-show="searchQuery.length > 0" @click="searchQuery = ''"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>

                {{-- Match Filter --}}
                <div class="lg:col-span-3">
                    <select x-model="filterMatch"
                            class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#031b4e] transition-all">
                        <option value="all">⚡ All Match Scores</option>
                        <option value="high">⭐ High Match (70%+)</option>
                        <option value="good">👍 Moderate Match (40%+)</option>
                    </select>
                </div>

                {{-- Quick Stats Counter --}}
                <div class="sm:col-span-2 lg:col-span-3 flex items-center justify-end text-xs text-slate-500 font-semibold">
                    <span class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="fas fa-briefcase text-slate-400"></i>
                        <span>Showing <strong class="text-[#031b4e]">{{ count($matchedJobs) }}</strong> Jobs</span>
                    </span>
                </div>

            </div>
        </div>

        {{-- Job Cards Grid --}}
        @if($matchedJobs->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($matchedJobs as $job)
                    @php
                        $score = $job->match_score ?? 0;
                        $salaryText = $job->salary_range ?: ($job->min_salary ? '₹' . number_format($job->min_salary) . ($job->max_salary ? ' - ₹' . number_format($job->max_salary) : '') . ' / mo' : 'Negotiable');
                        $searchHaystack = strtolower($job->title . ' ' . ($job->subject?->name ?? '') . ' ' . ($job->city?->name ?? '') . ' ' . ($job->category?->name ?? ''));
                    @endphp

                    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-[#0ea5e9]/40 hover:-translate-y-1 transition-all duration-300 p-5 sm:p-6 flex flex-col justify-between relative overflow-hidden group"
                         x-show="
                            (searchQuery === '' || '{{ addslashes($searchHaystack) }}'.includes(searchQuery.toLowerCase())) &&
                            (filterMatch === 'all' || (filterMatch === 'high' && {{ $score }} >= 70) || (filterMatch === 'good' && {{ $score }} >= 40))
                         "
                         x-transition>

                        <div>
                            {{-- Top Row: Job ID & Match Score Badge --}}
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 font-mono text-[11px] font-extrabold text-[#031b4e] bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded-lg">
                                    <i class="fas fa-hashtag text-[9px] text-[#0ea5e9]"></i>{{ $job->job_id }}
                                </span>

                                @if($score >= 70)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-extrabold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                        <i class="fas fa-star text-amber-500 text-[10px]"></i> {{ $score }}% Match
                                    </span>
                                @elseif($score >= 40)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-extrabold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="fas fa-thumbs-up text-blue-500 text-[10px]"></i> {{ $score }}% Match
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500">
                                        {{ $score }}% Match
                                    </span>
                                @endif
                            </div>

                            {{-- School Avatar & Title Header --}}
                            <div class="flex items-start gap-3.5 mb-3.5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#031b4e] to-[#0a3880] text-sky-400 flex items-center justify-center text-lg font-black shrink-0 shadow-md shadow-[#031b4e]/15 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-extrabold text-base sm:text-[17px] text-[#031b4e] group-hover:text-[#0ea5e9] transition-colors leading-tight truncate" title="{{ $job->title }}">
                                        {{ $job->title ?: 'Teacher Required' }}
                                    </h3>
                                    <p class="text-xs font-semibold text-slate-500 mt-1 flex items-center gap-1.5 truncate">
                                        <i class="fas fa-shield-alt text-[11px] text-sky-500"></i>
                                        <span>Verified Institution (Confidential)</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Key Job Specifications (Grid) --}}
                            <div class="grid grid-cols-2 gap-2 my-4">
                                {{-- Subject --}}
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block uppercase leading-none">Subject</span>
                                        <span class="text-xs font-extrabold text-slate-800 truncate block mt-0.5">{{ $job->subject?->name ?? 'General' }}</span>
                                    </div>
                                </div>

                                {{-- Category / Level --}}
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block uppercase leading-none">Level</span>
                                        <span class="text-xs font-extrabold text-slate-800 truncate block mt-0.5">{{ $job->category?->name ?? 'School' }}</span>
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 font-bold block uppercase leading-none">Location</span>
                                        <span class="text-xs font-extrabold text-slate-800 truncate block mt-0.5">{{ $job->city?->name ?? 'India' }}</span>
                                    </div>
                                </div>

                                {{-- Salary --}}
                                <div class="p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-100 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-indian-rupee-sign"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-emerald-600 font-bold block uppercase leading-none">Salary</span>
                                        <span class="text-xs font-black text-emerald-800 truncate block mt-0.5">{{ $salaryText }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Description Snippet --}}
                            @if($job->description)
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4 bg-slate-50/50 p-2 rounded-lg border border-slate-100">
                                    {{ strip_tags($job->description) }}
                                </p>
                            @endif
                        </div>

                        {{-- Card Footer CTA Actions --}}
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                            <a href="{{ route('jobs.show', $job->id) }}" target="_blank"
                               class="flex-1 py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-[#031b4e] text-xs font-bold rounded-xl transition-all text-center flex items-center justify-center gap-1.5">
                                <i class="fas fa-eye text-slate-400"></i>
                                <span>Details</span>
                            </a>

                            <form action="{{ route('candidate.applications.apply', $job->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full py-2.5 px-3 bg-[#031b4e] hover:bg-[#0a2970] text-white text-xs font-bold rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="fas fa-paper-plane text-[11px] text-[#fbc043]"></i>
                                    <span>Apply Now</span>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-slate-200/90 p-10 sm:p-14 text-center shadow-sm max-w-2xl mx-auto my-8">
                <div class="w-20 h-20 bg-blue-50 text-[#031b4e] rounded-3xl flex items-center justify-center text-3xl mx-auto mb-5 border border-blue-100 shadow-sm">
                    <i class="fas fa-search-location"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#031b4e] mb-2">No Matching School Jobs Right Now</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">
                    We currently don't have new job postings matching your current preference filters. New school vacancies are posted daily!
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('candidate.profile.edit') }}" 
                       class="px-5 py-3 bg-[#031b4e] text-white font-bold text-xs sm:text-sm rounded-xl hover:bg-[#0a2970] transition-all shadow-md flex items-center gap-2">
                        <i class="fas fa-user-edit text-xs"></i> Update Profile Preferences
                    </a>
                    <a href="{{ route('candidate.tuitions.index') }}" 
                       class="px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs sm:text-sm rounded-xl transition-all shadow-md flex items-center gap-2">
                        <i class="fas fa-book-reader text-xs"></i> Explore Home Tuitions
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
