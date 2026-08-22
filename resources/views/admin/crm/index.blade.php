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
            <div class="text-sm text-text-dark/70 font-semibold">
                Showing {{ $candidates->firstItem() ?? 0 }} to {{ $candidates->lastItem() ?? 0 }} of {{ $candidates->total() }} candidates
            </div>
            
            <button type="button" onclick="document.getElementById('advanced-filters').classList.toggle('hidden')" class="text-sm font-semibold text-accent-blue flex items-center gap-2 hover:text-accent-blue-hover transition-colors">
                <i class="fas fa-filter"></i> Advanced Filters
            </button>
        </div>

    <form action="{{ route('admin.crm.index') }}" method="GET" class="space-y-4 mt-3">
        <div class="flex items-center relative">
            <i class="fas fa-search absolute left-3 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..." 
                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
            @if(request()->anyFilled(['search', 'subject_id', 'experience', 'qualification_id', 'state_id', 'city_id', 'gender', 'english_fluency', 'availability', 'plan_amount']))
                <a href="{{ route('admin.crm.index') }}" class="absolute right-3 text-text-dark/40 hover:text-red-400 transition-colors text-sm font-bold flex items-center gap-1">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            @endif
        </div>

        <div id="advanced-filters" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 {{ request()->anyFilled(['subject_id', 'experience', 'qualification_id', 'state_id', 'city_id', 'gender', 'english_fluency', 'availability', 'plan_amount']) ? '' : 'hidden' }}">
            <select name="subject_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>

            <select name="qualification_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Qualifications</option>
                @foreach($qualifications as $qualification)
                    <option value="{{ $qualification->id }}" {{ request('qualification_id') == $qualification->id ? 'selected' : '' }}>{{ $qualification->name }}</option>
                @endforeach
            </select>

            <select name="state_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All States</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
            </select>
            <select name="city_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>

            <select name="experience" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">Min Experience</option>
                <option value="1" {{ request('experience') == '1' ? 'selected' : '' }}>1+ Years</option>
                <option value="3" {{ request('experience') == '3' ? 'selected' : '' }}>3+ Years</option>
                <option value="5" {{ request('experience') == '5' ? 'selected' : '' }}>5+ Years</option>
                <option value="10" {{ request('experience') == '10' ? 'selected' : '' }}>10+ Years</option>
            </select>

            <select name="gender" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Genders</option>
                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <select name="english_fluency" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">English Fluency</option>
                <option value="beginner" {{ request('english_fluency') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="intermediate" {{ request('english_fluency') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="fluent" {{ request('english_fluency') == 'fluent' ? 'selected' : '' }}>Fluent</option>
            </select>

            <button type="submit" class="w-full bg-accent-blue text-white rounded-lg px-4 py-2 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors">
                Apply Filters
            </button>
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
                        Candidate
                        @if(request('sort_by') === 'name')
                            <i class="fas fa-sort-{{ request('order') === 'asc' ? 'up' : 'down' }} text-accent-blue"></i>
                        @else
                            <i class="fas fa-sort text-text-dark/20"></i>
                        @endif
                    </a>
                </th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">Teaching Profile</th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">Service Readiness</th>
                <th class="py-3.5 px-4 text-xs font-bold text-text-dark/70 uppercase">Agreement Status</th>
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
                $isTuitionReady = ($prof && $prof->date_of_birth && $prof->gender && $prof->address && $prof->preferred_state_id && $prof->preferred_city_id && $prof->highest_qualification_id && $prof->subject_id);
                $isJobReady = ($isTuitionReady && $prof->category_id && $prof->resume_path);
            @endphp
            <tr class="group hover:bg-secondary-bg/50 transition-colors">
                <td class="py-3.5 px-4">
                    <div class="font-bold text-sm text-text-main group-hover:text-accent-blue transition-colors flex items-center gap-1.5">
                        <span>{{ $candidate->name }}</span>
                        @if($prof && $prof->is_verified)
                            <i class="fas fa-check-circle text-accent-blue text-xs" title="Verified Candidate"></i>
                        @endif
                    </div>
                    <div class="text-xs text-text-dark/50 flex flex-col gap-0.5 mt-0.5">
                        <span><i class="fas fa-phone-alt text-[10px] w-3.5"></i> {{ $candidate->phone }}</span>
                        <span><i class="fas fa-envelope text-[10px] w-3.5"></i> {{ $candidate->email }}</span>
                    </div>
                </td>

                <td class="py-3.5 px-4">
                    <div class="text-xs font-bold text-text-main">
                        {{ $prof?->subject?->name ?? 'Subject N/A' }}
                    </div>
                    <div class="text-[11px] text-text-dark/60 mt-0.5">
                        {{ $prof?->highestQualification?->name ?? 'N/A' }} • {{ $prof?->experience_years ?? 0 }} Yrs Exp
                    </div>
                    <div class="text-[10px] text-text-dark/40">
                        📍 {{ $prof?->preferredCity?->name ?? 'City N/A' }}
                    </div>
                </td>

                <td class="py-3.5 px-4">
                    <div class="flex flex-col gap-1 w-max">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $isJobReady ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-secondary-bg text-text-dark/50 border border-card-border' }}">
                            <i class="fas fa-school text-[9px]"></i> {{ $isJobReady ? 'School Ready' : 'School Incomplete' }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $isTuitionReady ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-secondary-bg text-text-dark/50 border border-card-border' }}">
                            <i class="fas fa-chalkboard-teacher text-[9px]"></i> {{ $isTuitionReady ? 'Tuition Ready' : 'Tuition Incomplete' }}
                        </span>
                    </div>
                </td>

                <td class="py-3.5 px-4">
                    @if($prof && ($prof->is_agreement_signed || $prof->agreement_pdf_path))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-accent-blue border border-accent-blue/20">
                            <i class="fas fa-file-signature text-[9px]"></i> Signed
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            <i class="fas fa-clock text-[9px]"></i> Pending
                        </span>
                    @endif
                </td>

                <td class="py-3.5 px-4 text-text-dark/60 text-xs">
                    {{ $candidate->created_at->format('d M, Y') }}
                </td>

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
