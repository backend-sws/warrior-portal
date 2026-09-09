@extends('layouts.admin')

@section('title', 'CRM & Follow-ups')
@section('subtitle', 'Manage candidates, track hiring status, generate invoices, and log follow-ups.')

@section('actions')
    <a href="{{ route('admin.crm.create') }}" class="px-5 py-2.5 bg-blue-600 text-white hover:bg-blue-700 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 shadow-sm">
        <i class="fas fa-user-plus text-xs"></i>
        <span>Manually Onboard Candidate</span>
    </a>
@endsection

@section('content')

{{-- Analytics Cards (Clickable Filters) --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.crm.index', ['crm_status' => '', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ !request('crm_status') ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Total Candidates</p>
        <h4 class="text-2xl font-black text-emerald-600 relative z-10">{{ $stats['total'] }}</h4>
        <span class="text-[10px] text-slate-400 mt-0.5">All Registrations</span>
    </a>

    <a href="{{ route('admin.crm.index', ['crm_status' => 'active_paid', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('crm_status') === 'active_paid' ? 'border-purple-500 ring-2 ring-purple-500/20 bg-purple-50/10' : 'border-card-border hover:border-purple-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-purple-500/5 group-hover:bg-purple-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Active / Paid</p>
        <h4 class="text-2xl font-black text-purple-600 relative z-10">{{ $stats['active_paid'] }}</h4>
        <span class="text-[10px] text-purple-600 font-bold mt-0.5">Verified & Paid</span>
    </a>

    <a href="{{ route('admin.crm.index', ['crm_status' => 'signed', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('crm_status') === 'signed' ? 'border-sky-500 ring-2 ring-sky-500/20 bg-sky-50/10' : 'border-card-border hover:border-sky-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-sky-500/5 group-hover:bg-sky-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Signed Agreement</p>
        <h4 class="text-2xl font-black text-sky-600 relative z-10">{{ $stats['signed'] }}</h4>
        <span class="text-[10px] text-sky-600 font-bold mt-0.5">Agreement Verified</span>
    </a>

    <a href="{{ route('admin.crm.index', ['crm_status' => 'incomplete', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('crm_status') === 'incomplete' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Incomplete</p>
        <h4 class="text-2xl font-black text-amber-600 relative z-10">{{ $stats['incomplete'] }}</h4>
        <span class="text-[10px] text-amber-600 font-bold mt-0.5">Pending Details</span>
    </a>
</div>

{{-- Filter/Search Bar --}}
<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4">
    <div class="flex justify-between items-center gap-4">
        <div class="text-sm text-text-dark/70 font-semibold flex items-center gap-2">
            <span>Showing {{ $candidates->firstItem() ?? 0 }} to {{ $candidates->lastItem() ?? 0 }} of {{ $candidates->total() }} candidates</span>
            @if(request()->anyFilled(['search', 'candidate_category', 'position', 'subject', 'qualification', 'experience', 'location', 'profile_completion', 'salary_range', 'state_id', 'city_id', 'gender']))
                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-accent-blue/10 text-accent-blue border border-accent-blue/20">
                    <i class="fas fa-filter text-[9px]"></i> Filtered Results
                </span>
            @endif
        </div>
        
        <button type="button" onclick="document.getElementById('advanced-filters').classList.toggle('hidden')" class="text-sm font-semibold text-accent-blue flex items-center gap-2 hover:text-accent-blue-hover transition-colors">
            <i class="fas fa-sliders-h"></i> 
            <span>Advanced Filters</span>
            <i class="fas fa-chevron-down text-xs"></i>
        </button>
    </div>

    <form action="{{ route('admin.crm.index') }}" method="GET" class="space-y-4 mt-3">
        <div class="flex items-center relative">
            <i class="fas fa-search absolute left-3 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone, whatsapp number..." 
                   class="w-full pl-9 pr-24 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
            @if(request()->anyFilled(['search', 'candidate_category', 'position', 'subject', 'qualification', 'experience', 'location', 'profile_completion', 'salary_range', 'subject_id', 'qualification_id', 'state_id', 'city_id', 'gender']))
                <a href="{{ route('admin.crm.index') }}" class="absolute right-3 text-red-500 hover:text-red-700 transition-colors text-xs font-bold flex items-center gap-1 bg-red-50 px-2 py-1 rounded-lg border border-red-200">
                    <i class="fas fa-times"></i> Clear All
                </a>
            @endif
        </div>

        <div id="advanced-filters" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 pt-2 border-t border-card-border {{ request()->anyFilled(['candidate_category', 'position', 'subject', 'qualification', 'experience', 'location', 'profile_completion', 'salary_range', 'state_id', 'city_id', 'gender']) ? '' : 'hidden' }}">
            {{-- 1. Candidate Category --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Apply Category</label>
                <select name="candidate_category" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Categories</option>
                    <option value="home_tutor" {{ request('candidate_category') === 'home_tutor' ? 'selected' : '' }}>🏡 Home Tutor</option>
                    <option value="school_job" {{ request('candidate_category') === 'school_job' ? 'selected' : '' }}>🏫 School Job</option>
                    <option value="both" {{ request('candidate_category') === 'both' ? 'selected' : '' }}>✨ Both (Tutor + School)</option>
                </select>
            </div>

            {{-- 2. Position Applying For --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">School Position</label>
                <select name="position" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Positions</option>
                    <option value="PRT" {{ request('position') === 'PRT' ? 'selected' : '' }}>PRT (Primary Teacher)</option>
                    <option value="TGT" {{ request('position') === 'TGT' ? 'selected' : '' }}>TGT (Trained Graduate)</option>
                    <option value="PGT" {{ request('position') === 'PGT' ? 'selected' : '' }}>PGT (Post Graduate)</option>
                    <option value="Mother Teacher" {{ request('position') === 'Mother Teacher' ? 'selected' : '' }}>Mother Teacher</option>
                    <option value="NTT" {{ request('position') === 'NTT' ? 'selected' : '' }}>NTT / Pre-Primary</option>
                    <option value="Coordinator" {{ request('position') === 'Coordinator' ? 'selected' : '' }}>Academic Coordinator</option>
                    <option value="Principal" {{ request('position') === 'Principal' ? 'selected' : '' }}>Principal / Vice Principal</option>
                    <option value="Computer Teacher" {{ request('position') === 'Computer Teacher' ? 'selected' : '' }}>Computer / IT Teacher</option>
                    <option value="Sports" {{ request('position') === 'Sports' ? 'selected' : '' }}>Sports / PET</option>
                    <option value="Special Educator" {{ request('position') === 'Special Educator' ? 'selected' : '' }}>Special Educator</option>
                    <option value="Accountant" {{ request('position') === 'Accountant' ? 'selected' : '' }}>Admin / Accountant</option>
                    <option value="Counselor" {{ request('position') === 'Counselor' ? 'selected' : '' }}>Counselor / Front Desk</option>
                </select>
            </div>

            {{-- 3. Subject Filter --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Subject / Specialization</label>
                <select name="subject" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subj)
                        <option value="{{ $subj->name }}" {{ request('subject') == $subj->name ? 'selected' : '' }}>{{ $subj->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 4. Qualification Filter --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Highest Qualification</label>
                <select name="qualification" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Qualifications</option>
                    @foreach($qualifications as $qualification)
                        <option value="{{ $qualification->name }}" {{ request('qualification') == $qualification->name ? 'selected' : '' }}>{{ $qualification->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 5. Experience Filter --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Teaching Experience</label>
                <select name="experience" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Experience Levels</option>
                    <option value="Fresher" {{ request('experience') === 'Fresher' ? 'selected' : '' }}>Fresher</option>
                    <option value="1-3" {{ request('experience') === '1-3' ? 'selected' : '' }}>1 - 3 Years</option>
                    <option value="3-5" {{ request('experience') === '3-5' ? 'selected' : '' }}>3 - 5 Years</option>
                    <option value="5-10" {{ request('experience') === '5-10' ? 'selected' : '' }}>5 - 10 Years</option>
                    <option value="10+" {{ request('experience') === '10+' ? 'selected' : '' }}>10+ Years</option>
                </select>
            </div>

            {{-- 6. Preferred Location Filter --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Preferred Location / Area</label>
                <input type="text" name="location" value="{{ request('location') }}" placeholder="e.g. Kankarbagh, Patna, Ranchi..."
                       class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
            </div>

            {{-- 7. Profile Completion Filter --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Profile Completion</label>
                <select name="profile_completion" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Completion Levels</option>
                    <option value="<50" {{ request('profile_completion') === '<50' ? 'selected' : '' }}>&lt; 50% (Incomplete)</option>
                    <option value="50-80" {{ request('profile_completion') === '50-80' ? 'selected' : '' }}>50% – 80% (Leads Locked)</option>
                    <option value=">80" {{ request('profile_completion') === '>80' ? 'selected' : '' }}>&gt; 80% (Leads Unlocked)</option>
                    <option value="100" {{ request('profile_completion') === '100' ? 'selected' : '' }}>100% (Fully Complete)</option>
                </select>
            </div>

            {{-- 8. Salary Expectation Filter --}}
            <div>
                <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Salary Expectation</label>
                <select name="salary_range" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="">All Salary Ranges</option>
                    <option value="<15k" {{ request('salary_range') === '<15k' ? 'selected' : '' }}>Under ₹15,000</option>
                    <option value="15k-25k" {{ request('salary_range') === '15k-25k' ? 'selected' : '' }}>₹15,000 – ₹25,000</option>
                    <option value="25k-40k" {{ request('salary_range') === '25k-40k' ? 'selected' : '' }}>₹25,000 – ₹40,000</option>
                    <option value="40k-60k" {{ request('salary_range') === '40k-60k' ? 'selected' : '' }}>₹40,000 – ₹60,000</option>
                    <option value=">60k" {{ request('salary_range') === '>60k' ? 'selected' : '' }}>Above ₹60,000</option>
                </select>
            </div>

            <div class="sm:col-span-2 md:col-span-4 flex justify-end gap-2 pt-2">
                <button type="submit" class="px-5 py-2 bg-accent-blue text-white rounded-xl text-xs font-bold shadow hover:bg-accent-blue-hover transition-colors flex items-center gap-1.5">
                    <i class="fas fa-check"></i> Apply Filters
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Data Table --}}
<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-sm">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                @php
                    $route = 'admin.crm.index';
                    $order = request('order') === 'asc' ? 'desc' : 'asc';
                @endphp
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">
                    <a href="{{ route($route, array_merge(request()->query(), ['sort_by' => 'name', 'order' => $order])) }}" class="flex items-center gap-2 hover:text-accent-blue transition-colors">
                        Candidate & Contact
                        @if(request('sort_by') === 'name')
                            <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }} text-accent-blue"></i>
                        @else
                            <i class="fas fa-sort text-text-dark/20"></i>
                        @endif
                    </a>
                </th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">Applied Category & Preference</th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">Profile Completion</th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">Service Readiness</th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">
                    <a href="{{ route($route, array_merge(request()->query(), ['sort_by' => 'created_at', 'order' => $order])) }}" class="flex items-center gap-2 hover:text-accent-blue transition-colors">
                        Registered
                        @if(request('sort_by') === 'created_at' || !request('sort_by'))
                            <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }} text-accent-blue"></i>
                        @else
                            <i class="fas fa-sort text-text-dark/20"></i>
                        @endif
                    </a>
                </th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($candidates as $candidate)
            @php
                $prof = $candidate->profile;
                $pct = $prof?->completion_percentage ?? 0;
                $category = $prof?->candidate_category ?: 'both';
                $isTuitionReady = ($prof && $prof->date_of_birth && $prof->gender && $prof->address && $prof->preferred_state_id && $prof->preferred_city_id && $prof->highest_qualification_id && $prof->subject_id);
                $isJobReady = ($isTuitionReady && $prof->category_id && $prof->resume_path);
            @endphp
            <tr class="group hover:bg-secondary-bg/50 transition-colors">
                {{-- Candidate & Contact --}}
                <td class="py-3.5 px-4">
                    <div class="font-bold text-sm text-text-main group-hover:text-accent-blue transition-colors flex items-center gap-1.5">
                        <span>{{ $candidate->name }}</span>
                        @if($prof && $prof->is_verified)
                            <i class="fas fa-check-circle text-accent-blue text-xs" title="Verified Candidate"></i>
                        @endif
                    </div>

                    <div class="text-xs text-text-dark/60 flex flex-col gap-1 mt-1">
                        {{-- Phone & WhatsApp --}}
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center gap-1 text-[11px] font-medium text-text-main">
                                <i class="fas fa-phone-alt text-[9px] text-text-dark/40"></i> {{ $candidate->phone }}
                            </span>
                            @if($candidate->whatsapp_no || $prof?->whatsapp_no)
                                @php $wNo = preg_replace('/[^0-9]/', '', $candidate->whatsapp_no ?: $prof?->whatsapp_no); @endphp
                                <a href="https://wa.me/{{ str_starts_with($wNo, '91') ? $wNo : '91'.$wNo }}" target="_blank" 
                                   class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200 hover:bg-emerald-100 transition-colors"
                                   title="Open WhatsApp Chat">
                                    <i class="fab fa-whatsapp text-[10px] text-emerald-600"></i>
                                    <span>{{ $candidate->whatsapp_no ?: $prof?->whatsapp_no }}</span>
                                </a>
                            @endif
                        </div>
                        <span class="text-[11px] text-text-dark/50 flex items-center gap-1 truncate">
                            <i class="fas fa-envelope text-[9px]"></i> {{ $candidate->email }}
                        </span>
                    </div>
                </td>

                {{-- Applied Category & Preference --}}
                <td class="py-3.5 px-4">
                    <div class="mb-1.5">
                        @if($category === 'home_tutor')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fas fa-chalkboard-teacher text-[9px]"></i> Home Tutor
                            </span>
                        @elseif($category === 'school_job')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                                <i class="fas fa-school text-[9px]"></i> School Job
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-50 text-purple-700 border border-purple-200">
                                <i class="fas fa-layer-group text-[9px]"></i> Both (Tutor + School)
                            </span>
                        @endif
                    </div>

                    <div class="text-xs font-bold text-text-main">
                        @if($prof?->position_applying_for)
                            <span>{{ $prof->position_applying_for }}</span>
                        @elseif($prof?->subject?->name)
                            <span>{{ $prof->subject->name }}</span>
                        @elseif($prof?->subject_specialization)
                            <span>{{ $prof->subject_specialization }}</span>
                        @else
                            <span class="text-text-dark/40">Not Specified</span>
                        @endif
                    </div>

                    <div class="text-[11px] text-text-dark/60 mt-0.5">
                        {{ $prof?->highest_qualification_name ?: ($prof?->highestQualification?->name ?? 'Qualification N/A') }} • 
                        {{ $prof?->experience_range ?: (($prof?->experience_years ?? 0) . ' Yrs Exp') }}
                    </div>

                    {{-- Tuition Subjects or Preferred Locations --}}
                    <div class="mt-1 flex flex-wrap gap-1">
                        @if(!empty($prof?->tuition_subjects) && is_array($prof->tuition_subjects))
                            @foreach(array_slice($prof->tuition_subjects, 0, 3) as $subjItem)
                                <span class="text-[9px] font-semibold px-1.5 py-0.2 rounded bg-secondary-bg text-text-dark/70 border border-card-border">
                                    {{ $subjItem }}
                                </span>
                            @endforeach
                            @if(count($prof->tuition_subjects) > 3)
                                <span class="text-[9px] text-text-dark/40">+{{ count($prof->tuition_subjects) - 3 }}</span>
                            @endif
                        @elseif($prof?->preferred_areas)
                            <span class="text-[10px] text-text-dark/50">📍 {{ Str::limit($prof->preferred_areas, 24) }}</span>
                        @elseif($prof?->preferredCity)
                            <span class="text-[10px] text-text-dark/50">📍 {{ $prof->preferredCity->name }}</span>
                        @endif
                    </div>
                </td>

                {{-- Profile Completion Percentage --}}
                <td class="py-3.5 px-4">
                    <div class="w-32 space-y-1.5">
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="{{ $pct >= 80 ? 'text-emerald-600' : ($pct >= 50 ? 'text-amber-600' : 'text-red-500') }}">
                                {{ $pct }}%
                            </span>
                            <span class="text-[9px] font-semibold text-text-dark/50">
                                @if($pct >= 100)
                                    Complete
                                @elseif($pct >= 75)
                                    Step 3/4
                                @elseif($pct >= 50)
                                    Step 2/4
                                @else
                                    Step 1/4
                                @endif
                            </span>
                        </div>
                        <div class="w-full h-2 bg-secondary-bg rounded-full overflow-hidden border border-card-border">
                            <div class="h-full rounded-full transition-all duration-500 {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                        @if($pct < 80 && ($category === 'home_tutor' || $category === 'both'))
                            <span class="inline-flex items-center gap-1 text-[9px] font-bold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">
                                <i class="fas fa-lock text-[8px]"></i> Leads Locked (&lt;80%)
                            </span>
                        @endif
                    </div>
                </td>

                {{-- Service Readiness & Agreements --}}
                <td class="py-3.5 px-4">
                    <div class="flex flex-col gap-1 w-max">
                        @if($category === 'school_job' || $category === 'both')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $isJobReady ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-secondary-bg text-text-dark/50 border border-card-border' }}">
                                <i class="fas fa-school text-[9px]"></i> {{ $isJobReady ? 'School Ready' : 'School Pending' }}
                            </span>
                        @endif

                        @if($category === 'home_tutor' || $category === 'both')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold {{ ($pct >= 80) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                <i class="fas fa-chalkboard-teacher text-[9px]"></i> {{ ($pct >= 80) ? 'Tuition Unlocked' : 'Tuition Pending' }}
                            </span>
                        @endif

                        @if($prof && ($prof->is_agreement_signed || $prof->agreement_pdf_path))
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600">
                                <i class="fas fa-check-circle text-[9px]"></i> Agreement Signed
                            </span>
                        @endif
                    </div>
                </td>

                {{-- Registered Date --}}
                <td class="py-3.5 px-4 text-text-dark/60 text-xs">
                    {{ $candidate->created_at->format('d M, Y') }}
                    <span class="block text-[10px] text-text-dark/40">{{ $candidate->created_at->diffForHumans() }}</span>
                </td>

                {{-- Actions --}}
                <td class="py-3.5 px-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.crm.show', $candidate->id) }}" class="px-3.5 py-1.5 rounded-xl bg-accent-blue hover:bg-blue-700 text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                            <span>Manage</span> <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-16 text-center">
                    <div class="w-14 h-14 bg-secondary-bg rounded-2xl flex items-center justify-center text-text-dark/20 text-2xl mx-auto mb-3 border border-card-border">
                        <i class="fas fa-users-slash"></i>
                    </div>
                    <p class="text-text-main font-bold text-base mb-1">No candidates found</p>
                    <p class="text-text-dark/40 text-xs">Try adjusting your filters or onboard a new candidate.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($candidates->hasPages())
<div class="mt-6 flex justify-end">
    {{ $candidates->links('pagination::tailwind') }}
</div>
@endif

{{-- Rating Modal --}}
<div id="ratingModal" class="fixed inset-0 z-[105] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('ratingModal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-md bg-card-bg rounded-2xl shadow-2xl overflow-hidden animate-[fadeIn_0.3s_ease-out]">
        <div class="p-6 border-b border-card-border flex justify-between items-center">
            <h3 class="text-xl font-bold text-text-main">Admin Rating</h3>
            <button type="button" onclick="document.getElementById('ratingModal').classList.add('hidden')" class="text-text-dark hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="ratingForm" action="" method="POST" class="p-6 space-y-4">
            @csrf
            @php
                $params = [
                    'communication' => 'Communication Skills',
                    'subject_knowledge' => 'Subject Knowledge',
                    'demo_performance' => 'Demo Performance',
                    'english_fluency' => 'English Fluency',
                    'discipline' => 'Professionalism & Discipline'
                ];
            @endphp

            @foreach($params as $key => $label)
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium text-text-main">{{ $label }}</label>
                <select name="{{ $key }}" id="rating_{{ $key }}" class="rounded-lg bg-secondary-bg border-card-border text-text-main focus:border-accent-blue focus:ring-0 text-sm p-1.5 w-24">
                    @for($i=1; $i<=5; $i++)
                        <option value="{{ $i }}">{{ $i }} Stars</option>
                    @endfor
                </select>
            </div>
            @endforeach

            <div class="pt-2">
                <label class="block text-xs font-semibold text-text-dark mb-1">Remarks</label>
                <textarea name="remarks" id="rating_remarks" rows="2" class="w-full rounded-lg bg-secondary-bg border-card-border text-text-main focus:border-accent-blue focus:ring-0 text-sm placeholder-text-dark/40"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('ratingModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-text-main bg-secondary-bg hover:bg-card-border transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-accent-blue hover:bg-accent-blue-hover transition-colors shadow-glow-blue">
                    Save Ratings
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openRatingModal(candidateId, comm, subj, demo, eng, disc, rem) {
        // Update form action
        const form = document.getElementById('ratingForm');
        form.action = `/admin/crm/candidate/${candidateId}/rate`;

        // Populate selects
        document.getElementById('rating_communication').value = comm;
        document.getElementById('rating_subject_knowledge').value = subj;
        document.getElementById('rating_demo_performance').value = demo;
        document.getElementById('rating_english_fluency').value = eng;
        document.getElementById('rating_discipline').value = disc;
        document.getElementById('rating_remarks').value = rem;

        // Show modal
        document.getElementById('ratingModal').classList.remove('hidden');
    }
</script>
@endpush
