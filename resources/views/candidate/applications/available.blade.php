@extends('layouts.app')

@section('content')
@include('candidate.partials.nav')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 reveal">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-accent-yellow/10 text-accent-yellow flex items-center justify-center text-lg">
                <i class="fas fa-briefcase"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-[#031b4e]">Recommended Jobs</h1>
                <p class="text-sm text-[#031b4e]/60 mt-0.5">Jobs matching your profile preferences.</p>
            </div>
        </div>
        <a href="{{ route('candidate.applications.index') }}" class="text-sm font-semibold text-[#0ea5e9] hover:underline flex items-center gap-1.5">
            <i class="fas fa-list text-xs"></i> View My Applications &rarr;
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-500/10 border border-green-500/30 p-4 rounded-xl flex items-center gap-3 reveal">
            <i class="fas fa-check-circle text-green-400"></i>
            <span class="text-sm text-green-400 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-500/10 border border-red-500/30 p-4 rounded-xl flex items-center gap-3 reveal">
            <i class="fas fa-exclamation-circle text-red-400"></i>
            <span class="text-sm text-red-400 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Job Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($matchedJobs as $job)
        <div class="bg-white border border-[#031b4e]/10 rounded-2xl p-6 flex flex-col hover:border-[#0ea5e9]/30 hover:shadow-xl transition-all duration-300 group reveal reveal-delay-1">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-[#0ea5e9]/10 rounded-xl flex items-center justify-center text-[#0ea5e9] text-sm font-bold shrink-0 group-hover:scale-110 transition-transform">
                        {{ strtoupper(substr($job->school_name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="inline-flex items-center gap-1 font-mono text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                <i class="fas fa-hashtag text-[8px] opacity-70"></i>{{ $job->job_id ?: 'JOB-' . str_pad($job->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <h3 class="font-bold text-[#031b4e] hover:text-[#0ea5e9] transition-colors leading-tight text-sm">
                            <a href="{{ route('jobs.show', $job->id) }}" target="_blank">{{ $job->title ?? 'Teacher Required' }}</a>
                        </h3>
                        <p class="text-xs text-[#031b4e]/60 mt-0.5">{{ $job->school_name }}</p>
                    </div>
                </div>
                {{-- Match Score Badge --}}
                @if($job->match_score >= 80)
                    <span class="bg-green-500/10 text-green-400 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-green-500/20 shrink-0">
                        <i class="fas fa-star mr-0.5"></i> {{ $job->match_score }}%
                    </span>
                @elseif($job->match_score >= 50)
                    <span class="bg-[#0ea5e9]/10 text-[#0ea5e9] text-[10px] font-bold px-2.5 py-1 rounded-lg border border-[#0ea5e9]/20 shrink-0">
                        <i class="fas fa-thumbs-up mr-0.5"></i> {{ $job->match_score }}%
                    </span>
                @else
                    <span class="bg-card-border/50 text-[#031b4e]/60 text-[10px] font-bold px-2.5 py-1 rounded-lg shrink-0">
                        {{ $job->match_score }}%
                    </span>
                @endif
            </div>

            {{-- Description --}}
            <p class="text-sm text-[#031b4e]/60 line-clamp-3 mb-4 flex-grow leading-relaxed">{{ strip_tags($job->description) }}</p>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-2 mb-5">
                <span class="bg-[#f4f7f5] border border-[#031b4e]/10 text-[#031b4e]/60 px-2.5 py-1 rounded-lg text-[10px] font-medium flex items-center gap-1">
                    <i class="fas fa-map-marker-alt text-[#0ea5e9]/60"></i> {{ $job->city?->name ?? 'N/A' }}
                </span>
                <span class="bg-[#f4f7f5] border border-[#031b4e]/10 text-[#031b4e]/60 px-2.5 py-1 rounded-lg text-[10px] font-medium flex items-center gap-1">
                    <i class="fas fa-book text-accent-yellow/60"></i> {{ $job->subject->name }}
                </span>
                @if($job->salary_range)
                <span class="bg-[#f4f7f5] border border-[#031b4e]/10 text-[#031b4e]/60 px-2.5 py-1 rounded-lg text-[10px] font-medium flex items-center gap-1">
                    <i class="fas fa-rupee-sign text-green-400/60"></i> {{ $job->salary_range }}
                </span>
                @endif
            </div>

            {{-- Apply Button --}}
            <form action="{{ route('candidate.applications.apply', $job->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 bg-[#0ea5e9] text-white text-sm font-semibold rounded-xl hover:bg-[#0ea5e9]-hover hover:-translate-y-0.5 transition-all shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i> Apply Now
                </button>
            </form>
        </div>
        @empty
        <div class="col-span-full py-16 text-center border-2 border-dashed border-[#031b4e]/10 rounded-2xl reveal">
            <div class="w-16 h-16 bg-card-border/30 rounded-2xl flex items-center justify-center text-[#031b4e]/80/20 text-2xl mx-auto mb-4">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="text-lg font-bold text-[#031b4e] mb-1">No Matching Jobs Yet</h3>
            <p class="text-sm text-[#031b4e]/60">We're constantly adding new positions. We'll notify you when a match is found!</p>
        </div>
        @endforelse
    </div>
</div>
@endsection



