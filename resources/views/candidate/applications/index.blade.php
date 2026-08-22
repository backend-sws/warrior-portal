@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 reveal">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-[#031b4e] text-white flex items-center justify-center text-lg shrink-0 shadow-md shadow-[#031b4e]/20">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black text-[#031b4e]">My Applications & Tracking</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Track live progress for School Teaching Jobs and Home Tuitions.</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('candidate.applications.available') }}"
                    class="flex-1 sm:flex-initial px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-[#031b4e] border border-blue-200 rounded-xl text-xs sm:text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                    <i class="fas fa-briefcase text-xs"></i> <span>School Jobs</span>
                </a>
                <a href="{{ route('candidate.tuitions.index') }}"
                    class="flex-1 sm:flex-initial px-4 py-2.5 bg-[#031b4e] hover:bg-[#021338] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-1.5">
                    <i class="fas fa-book-reader text-xs"></i> <span>Home Tuitions</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 sm:mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 reveal shadow-sm text-xs sm:text-sm font-bold">
                <i class="fas fa-check-circle text-emerald-600 text-base shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Dual Switcher Tabs --}}
        <div class="flex items-center gap-2 mb-6 border-b border-slate-200 pb-3 overflow-x-auto">
            <a href="{{ route('candidate.applications.index', ['tab' => 'jobs']) }}" 
               class="px-5 py-2.5 rounded-xl font-black text-xs sm:text-sm flex items-center gap-2 transition-all whitespace-nowrap {{ ($activeTab ?? 'jobs') === 'jobs' ? 'bg-[#031b4e] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fas fa-school text-xs"></i>
                <span>School Teaching Jobs</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ ($activeTab ?? 'jobs') === 'jobs' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $jobCount }}
                </span>
            </a>

            <a href="{{ route('candidate.applications.index', ['tab' => 'tuitions']) }}" 
               class="px-5 py-2.5 rounded-xl font-black text-xs sm:text-sm flex items-center gap-2 transition-all whitespace-nowrap {{ ($activeTab ?? 'jobs') === 'tuitions' ? 'bg-[#031b4e] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fas fa-chalkboard-teacher text-xs"></i>
                <span>Home Tuition Applications</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ ($activeTab ?? 'jobs') === 'tuitions' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">
                    {{ $tuitionCount }}
                </span>
            </a>
        </div>

        {{-- TAB 1: SCHOOL TEACHING JOBS --}}
        @if(($activeTab ?? 'jobs') === 'jobs')
            @if($applications->isEmpty())
                <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 text-center shadow-sm reveal">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 border border-blue-100">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#031b4e] mb-1.5">No School Job Applications Yet</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-5 leading-relaxed">
                        You haven't applied for any school teacher positions yet. Explore active vacancies matching your subject & category.
                    </p>
                    <a href="{{ route('candidate.applications.available') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-[#031b4e] hover:bg-[#021338] text-white rounded-xl text-xs sm:text-sm font-bold shadow-md transition-all">
                        <i class="fas fa-search text-xs"></i> Browse School Jobs &rarr;
                    </a>
                </div>
            @else
                <div class="space-y-4" x-data="{ expandedId: null }">
                    @foreach($applications as $app)
                        <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#031b4e] border border-blue-100 flex items-center justify-center text-sm font-black shrink-0">
                                        {{ strtoupper(substr($app->jobPost->school_name ?? 'SC', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-extrabold text-[#031b4e] text-base hover:text-accent-blue transition-colors">
                                            <a href="{{ route('jobs.show', $app->jobPost->id) }}" target="_blank">
                                                {{ $app->jobPost->title ?? 'Teacher' }}
                                            </a>
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            <i class="fas fa-school mr-1 text-slate-400"></i> {{ $app->jobPost->school_name }} &bull;
                                            <i class="fas fa-map-marker-alt ml-1 mr-0.5 text-red-500"></i> {{ $app->jobPost->city?->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 self-start sm:self-auto">
                                    @if($app->status === 'hired')
                                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1">
                                            <i class="fas fa-trophy text-emerald-600"></i> Selected & Placed
                                        </span>
                                    @elseif($app->status === 'rejected')
                                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-red-100 text-red-700 border border-red-200">
                                            <i class="fas fa-times"></i> Not Selected
                                        </span>
                                    @elseif($app->status === 'shortlisted')
                                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-200">
                                            <i class="fas fa-star text-amber-600"></i> Shortlisted / Interview
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-sky-100 text-sky-800 border border-sky-200">
                                            <i class="fas fa-clock"></i> Applied (Under Review)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($app->interview_date)
                                <div class="mb-4 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2 text-amber-900 font-bold">
                                        <i class="fas fa-calendar-check text-amber-600 text-sm"></i>
                                        <span>Interview Scheduled: {{ $app->interview_date->format('l, d M Y \a\t h:i A') }}</span>
                                    </div>
                                    @if($app->interview_link)
                                        <a href="{{ $app->interview_link }}" target="_blank" class="px-3 py-1 bg-amber-600 text-white rounded-lg font-bold hover:bg-amber-700 transition-colors">
                                            Join Interview &rarr;
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <span><i class="far fa-clock mr-1"></i> Applied on {{ $app->created_at->format('d M Y') }} ({{ $app->created_at->diffForHumans() }})</span>
                                <span class="font-bold text-slate-700">Match Score: {{ $app->match_score }}%</span>
                            </div>
                        </div>
                    @endforeach

                    @if($applications->hasPages())
                        <div class="mt-6">
                            {{ $applications->appends(['tab' => 'jobs'])->links() }}
                        </div>
                    @endif
                </div>
            @endif

        {{-- TAB 2: HOME TUITION APPLICATIONS --}}
        @else
            @if($tuitionApplications->isEmpty())
                <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 text-center shadow-sm reveal">
                    <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 border border-purple-100">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#031b4e] mb-1.5">No Home Tuition Applications Yet</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-5 leading-relaxed">
                        You haven't applied for any home tuitions yet. Browse open parent requirements and apply for home tuitions near your area.
                    </p>
                    <a href="{{ route('candidate.tuitions.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-[#031b4e] hover:bg-[#021338] text-white rounded-xl text-xs sm:text-sm font-bold shadow-md transition-all">
                        <i class="fas fa-book-reader text-xs"></i> Browse Home Tuitions &rarr;
                    </a>
                </div>
            @else
                <div class="space-y-5">
                    @foreach($tuitionApplications as $tApp)
                        @php
                            $lead = $tApp->tuitionLead;
                            $status = $tApp->status;
                        @endphp
                        <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all">
                            {{-- Header --}}
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 border border-purple-100 flex items-center justify-center text-lg font-black shrink-0">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-extrabold text-[#031b4e] text-base sm:text-lg">
                                                Class {{ $lead?->class ?? 'N/A' }}
                                            </h3>
                                            <span class="bg-blue-50 text-blue-700 text-[11px] font-bold px-2 py-0.5 rounded-lg border border-blue-100">
                                                {{ $lead?->board ?: 'General Board' }}
                                            </span>
                                        </div>
                                        <p class="text-xs font-semibold text-accent-blue mt-0.5">
                                            Subjects: {{ $lead?->subjects ?? 'All Subjects' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Status Badge --}}
                                <div class="self-start sm:self-auto">
                                    @if($status === 'Assigned')
                                        <span class="px-3 py-1.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1.5 shadow-sm">
                                            <i class="fas fa-check-circle text-emerald-600"></i> Assigned as Tutor 🎉
                                        </span>
                                    @elseif($status === 'Shortlisted')
                                        <span class="px-3 py-1.5 rounded-full text-xs font-black bg-amber-100 text-amber-900 border border-amber-200 flex items-center gap-1.5">
                                            <i class="fas fa-star text-amber-600"></i> Shortlisted for Demo
                                        </span>
                                    @elseif($status === 'Rejected')
                                        <span class="px-3 py-1.5 rounded-full text-xs font-black bg-red-100 text-red-700 border border-red-200">
                                            <i class="fas fa-times"></i> Not Selected
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-full text-xs font-black bg-sky-100 text-sky-800 border border-sky-200">
                                            <i class="fas fa-clock"></i> Applied (Under Review)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Location & Parent Details if Assigned --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 p-3.5 bg-slate-50 rounded-2xl text-xs text-slate-700">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-red-500 shrink-0"></i>
                                    <span class="line-clamp-1"><strong>Location:</strong> {{ $lead?->location ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    @if($status === 'Assigned' && $lead?->parent_mobile)
                                        <div class="flex items-center gap-2 text-emerald-800 font-bold">
                                            <i class="fas fa-user-check text-emerald-600"></i>
                                            <span>Parent: {{ $lead->parent_name }} ({{ $lead->parent_mobile }})</span>
                                        </div>
                                    @else
                                        <div class="text-slate-500">
                                            <i class="fas fa-lock text-slate-400 mr-1"></i> Parent details revealed upon tutor confirmation
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Demo Session Alert --}}
                            @if($tApp->demo_date)
                                <div class="mb-4 p-4 rounded-2xl bg-purple-50 border border-purple-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                    <div class="flex items-center gap-2.5 text-purple-900 font-bold text-xs sm:text-sm">
                                        <i class="fas fa-calendar-alt text-purple-600 text-base"></i>
                                        <span>Demo Class Scheduled: {{ $tApp->demo_date->format('l, d M Y \a\t h:i A') }}</span>
                                    </div>
                                    <span class="text-[11px] font-bold text-purple-700 bg-purple-100 px-2.5 py-1 rounded-lg">
                                        Be prepared for the demo session
                                    </span>
                                </div>
                            @endif

                            {{-- Admin Remarks --}}
                            @if($tApp->remarks)
                                <div class="mb-4 p-3 rounded-xl bg-slate-100/80 border border-slate-200 text-xs text-slate-700">
                                    <strong>Admin Note:</strong> "{{ $tApp->remarks }}"
                                </div>
                            @endif

                            {{-- Tracking Stepper --}}
                            <div class="pt-4 border-t border-slate-100">
                                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Application Progress</div>
                                <div class="grid grid-cols-4 gap-2 text-center text-[10px] sm:text-xs">
                                    {{-- Step 1: Applied --}}
                                    <div class="flex flex-col items-center">
                                        <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold mb-1 shadow-sm">
                                            <i class="fas fa-check text-[10px]"></i>
                                        </div>
                                        <span class="font-bold text-slate-800">Applied</span>
                                    </div>

                                    {{-- Step 2: Shortlisted --}}
                                    <div class="flex flex-col items-center">
                                        <div class="w-7 h-7 rounded-full {{ in_array($status, ['Shortlisted', 'Assigned']) ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center font-bold mb-1 shadow-sm">
                                            @if(in_array($status, ['Shortlisted', 'Assigned']))
                                                <i class="fas fa-check text-[10px]"></i>
                                            @else
                                                2
                                            @endif
                                        </div>
                                        <span class="font-bold {{ in_array($status, ['Shortlisted', 'Assigned']) ? 'text-slate-800' : 'text-slate-400' }}">Shortlisted</span>
                                    </div>

                                    {{-- Step 3: Demo Class --}}
                                    <div class="flex flex-col items-center">
                                        <div class="w-7 h-7 rounded-full {{ ($tApp->demo_date || $status === 'Assigned') ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center font-bold mb-1 shadow-sm">
                                            @if($tApp->demo_date || $status === 'Assigned')
                                                <i class="fas fa-check text-[10px]"></i>
                                            @else
                                                3
                                            @endif
                                        </div>
                                        <span class="font-bold {{ ($tApp->demo_date || $status === 'Assigned') ? 'text-slate-800' : 'text-slate-400' }}">Demo Class</span>
                                    </div>

                                    {{-- Step 4: Assigned --}}
                                    <div class="flex flex-col items-center">
                                        <div class="w-7 h-7 rounded-full {{ $status === 'Assigned' ? 'bg-emerald-500 text-white' : ($status === 'Rejected' ? 'bg-red-500 text-white' : 'bg-slate-200 text-slate-500') }} flex items-center justify-center font-bold mb-1 shadow-sm">
                                            @if($status === 'Assigned')
                                                <i class="fas fa-trophy text-[10px]"></i>
                                            @elseif($status === 'Rejected')
                                                <i class="fas fa-times text-[10px]"></i>
                                            @else
                                                4
                                            @endif
                                        </div>
                                        <span class="font-bold {{ $status === 'Assigned' ? 'text-emerald-700' : ($status === 'Rejected' ? 'text-red-600' : 'text-slate-400') }}">
                                            {{ $status === 'Rejected' ? 'Not Selected' : 'Assigned' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Service Charge Reminder if Assigned --}}
                            @if($status === 'Assigned')
                                <div class="mt-4 pt-3 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                                    <span class="text-xs text-slate-600 font-medium">
                                        <i class="fas fa-info-circle text-accent-blue mr-1"></i> Check your service charge invoice to finalize your placement.
                                    </span>
                                    <a href="{{ route('candidate.serviceCharge.show') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-md transition-colors flex items-center gap-1.5">
                                        <i class="fas fa-file-invoice-dollar"></i> View Service Charge & Dues
                                    </a>
                                </div>
                            @endif

                            <div class="mt-3 pt-2 text-[11px] text-slate-400 text-right">
                                Applied on {{ $tApp->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    @endforeach

                    @if($tuitionApplications->hasPages())
                        <div class="mt-6">
                            {{ $tuitionApplications->appends(['tab' => 'tuitions'])->links() }}
                        </div>
                    @endif
                </div>
            @endif
        @endif

    </div>
@endsection
