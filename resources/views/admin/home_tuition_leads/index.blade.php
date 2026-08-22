@extends('layouts.admin')

@section('title', 'Home Tuitions')
@section('subtitle', 'Manage tuition requirements, approve to publish live on website, and assign verified teachers.')

@section('actions')
    <a href="{{ route('admin.tuition-leads.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold transition-all shadow flex items-center gap-2">
        <i class="fas fa-plus"></i> <span>Add Tuition Requirement</span>
    </a>
@endsection

@section('content')

<div x-data="{ 
    assignModalOpen: false, 
    selectedLeadId: null, 
    selectedParentName: '', 
    selectedRequirement: '',
    candidateSearch: '',
    openAssignModal(id, parent, req) {
        this.selectedLeadId = id;
        this.selectedParentName = parent;
        this.selectedRequirement = req;
        this.assignModalOpen = true;
    }
}">

{{-- Clickable Analytics Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.tuition-leads.index', ['search' => request('search')]) }}" 
       class="bg-card-bg border {{ !request('status') ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/10' : 'border-card-border hover:border-blue-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Total Tuitions</p>
        <h4 class="text-2xl font-black text-blue-600 relative z-10">{{ $stats['total'] ?? 0 }}</h4>
        <span class="text-[10px] text-slate-400 mt-0.5">All Requirements</span>
    </a>

    <a href="{{ route('admin.tuition-leads.index', ['status' => 'New Lead', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'New Lead' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Pending Approvals</p>
        <h4 class="text-2xl font-black text-amber-500 relative z-10">{{ $stats['new_lead'] ?? 0 }}</h4>
        <span class="text-[10px] text-amber-600 font-bold mt-0.5">Needs Approval</span>
    </a>

    <a href="{{ route('admin.tuition-leads.index', ['status' => 'Approved', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'Approved' ? 'border-sky-500 ring-2 ring-sky-500/20 bg-sky-50/10' : 'border-card-border hover:border-sky-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-sky-500/5 group-hover:bg-sky-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Live on Website</p>
        <h4 class="text-2xl font-black text-sky-600 relative z-10">{{ $stats['approved'] ?? 0 }}</h4>
        <span class="text-[10px] text-sky-600 font-bold mt-0.5">Accepting Teachers</span>
    </a>

    <a href="{{ route('admin.tuition-leads.index', ['status' => 'Confirmed', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'Confirmed' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Tutor Assigned</p>
        <h4 class="text-2xl font-black text-emerald-600 relative z-10">{{ $stats['confirmed'] ?? 0 }}</h4>
        <span class="text-[10px] text-emerald-600 font-bold mt-0.5">Confirmed & Fulfilled</span>
    </a>
</div>

{{-- Filter/Search Bar --}}
<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div class="text-sm text-text-dark/50 font-medium whitespace-nowrap">
        Showing {{ $leads->firstItem() ?? 0 }} to {{ $leads->lastItem() ?? 0 }} of {{ $leads->total() }} entries
    </div>
    <form action="{{ url()->current() }}" method="GET" class="w-full flex flex-col sm:flex-row items-center justify-end gap-3 flex-wrap">
        <div class="relative w-full sm:w-56">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, phone, area..." 
                   class="w-full pl-9 pr-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
        </div>
        
        <select name="status" class="w-full sm:w-auto px-3 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50">
            <option value="">All Statuses</option>
            <option value="New Lead" {{ request('status') == 'New Lead' ? 'selected' : '' }}>Pending Approval</option>
            <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Live on Website</option>
            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Teacher Assigned</option>
            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Closed</option>
        </select>

        <button type="submit" class="w-full sm:w-auto bg-accent-blue text-white rounded-xl px-4 py-2 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors whitespace-nowrap">Filter</button>
        
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('admin.tuition-leads.index') }}" class="text-text-dark/40 hover:text-red-400 transition-colors w-full sm:w-auto text-center" title="Clear Filters">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
</div>

{{-- Data Table --}}
<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-xl">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                <th>Parent Info</th>
                <th>Class & Board</th>
                <th>Subjects Needed</th>
                <th>Location & Pincode</th>
                <th>Status & Assigned Teacher</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($leads as $lead)
            <tr class="group hover:bg-secondary-bg/30 transition-colors">
                <td class="align-middle">
                    <div class="font-bold text-text-main group-hover:text-accent-blue transition-colors">{{ $lead->parent_name }}</div>
                    <div class="text-xs text-text-dark/60 mt-0.5 flex items-center gap-1.5">
                        <i class="fas fa-phone-alt text-[10px]"></i> {{ $lead->parent_mobile }}
                    </div>
                </td>
                <td class="align-middle">
                    <div class="text-sm font-semibold text-text-main">{{ $lead->class }}</div>
                    <div class="text-xs text-accent-blue font-medium mt-0.5">{{ $lead->board ?: 'General' }}</div>
                </td>
                <td class="align-middle">
                    <div class="text-sm font-medium text-text-main max-w-xs truncate" title="{{ $lead->subjects }}">
                        {{ $lead->subjects }}
                    </div>
                </td>
                <td class="align-middle">
                    <div class="text-xs text-text-main font-medium flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-red-400 text-[10px]"></i> {{ $lead->location }}
                    </div>
                    @if($lead->pincode)
                        <div class="text-[11px] text-text-dark/60 mt-0.5 font-mono">Pincode: {{ $lead->pincode }}</div>
                    @endif
                </td>
                <td class="align-middle">
                    @php
                        $statusColors = [
                            'New Lead' => 'bg-amber-500/10 text-amber-600 border-amber-500/20',
                            'Approved' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
                            'Confirmed' => 'bg-blue-500/10 text-blue-600 border-blue-500/20',
                            'Cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                        ];
                        $colorClass = $statusColors[$lead->status] ?? 'bg-gray-500/10 text-gray-500 border-gray-500/20';
                    @endphp
                    <span class="{{ $colorClass }} px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-wider inline-block">
                        {{ $lead->status === 'New Lead' ? '⏳ Pending Approval' : ($lead->status === 'Approved' ? '✅ Live on Website' : ($lead->status === 'Confirmed' ? '🎉 Teacher Assigned' : $lead->status)) }}
                    </span>

                    @if($lead->teacher_name)
                        <div class="text-xs font-semibold text-text-main mt-1 flex items-center gap-1">
                            <i class="fas fa-chalkboard-teacher text-accent-blue text-[10px]"></i>
                            <span>{{ $lead->teacher_name }}</span>
                            @if($lead->teacher_contact)
                                <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->teacher_contact) }}" target="_blank" class="text-green-500 hover:text-green-600 ml-1" title="WhatsApp Teacher">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </td>
                <td class="align-middle text-right">
                    <div class="flex items-center justify-end gap-2 flex-wrap">
                        @if($lead->status === 'New Lead')
                            <form action="{{ route('admin.tuition-leads.approve', $lead->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold transition-colors whitespace-nowrap shadow-sm" title="Approve and publish live on tuition board">
                                    <i class="fas fa-check-circle"></i> Approve & Post
                                </button>
                            </form>
                        @endif

                        {{-- Assign Teacher Button --}}
                        <button type="button" @click="openAssignModal({{ $lead->id }}, '{{ addslashes($lead->parent_name) }}', '{{ addslashes($lead->class . ' - ' . $lead->subjects) }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-blue-500/10 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-500/20 rounded-lg text-xs font-bold transition-colors whitespace-nowrap" title="Assign Teacher / Candidate">
                            <i class="fas fa-user-plus text-xs"></i> Assign Teacher
                        </button>

                        <a href="{{ route('admin.tuition-leads.edit', $lead->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue rounded-lg text-xs font-bold transition-colors" title="Edit Tuition Requirement">
                            <i class="fas fa-edit text-xs"></i> Edit
                        </a>

                        <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->parent_mobile) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition-colors" title="WhatsApp Parent">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-12">
                    <div class="flex flex-col items-center justify-center text-text-dark/40">
                        <i class="fas fa-chalkboard-teacher text-4xl mb-3"></i>
                        <p class="text-base font-semibold">No tuition requirements found</p>
                        <p class="text-xs mt-1">Tuition requirements submitted from the website will show up here.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $leads->appends(request()->query())->links() }}
</div>

{{-- Assign Teacher Modal --}}
<div x-show="assignModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition.opacity>
    <div class="bg-card-bg border border-card-border rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden" @click.away="assignModalOpen = false" x-transition.scale>
        
        <!-- Modal Header -->
        <div class="p-6 border-b border-card-border bg-secondary-bg/40 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500 font-bold">
                    <i class="fas fa-user-check text-lg"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-text-main">Assign Teacher / Tutor</h3>
                    <p class="text-xs text-text-dark/60" x-text="selectedParentName + ' (' + selectedRequirement + ')'"></p>
                </div>
            </div>
            <button @click="assignModalOpen = false" class="text-text-dark/40 hover:text-text-main transition-colors">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form :action="'{{ url('admin/tuition-leads') }}/' + selectedLeadId + '/assign-teacher'" method="POST" class="p-6 space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-text-dark/80 uppercase tracking-wider mb-2">Select Verified Teacher / Candidate *</label>
                
                <div class="relative mb-3">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                    <input type="text" x-model="candidateSearch" placeholder="Search teacher by name or phone..." class="w-full pl-8 pr-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-xs text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                </div>

                <div class="max-h-60 overflow-y-auto border border-card-border rounded-xl divide-y divide-card-border bg-secondary-bg/20 custom-scrollbar">
                    @forelse($candidates as $candidate)
                        <label class="p-3 flex items-center justify-between hover:bg-secondary-bg/60 cursor-pointer transition-colors"
                               x-show="!candidateSearch || '{{ strtolower($candidate->name) }}'.includes(candidateSearch.toLowerCase()) || '{{ $candidate->phone }}'.includes(candidateSearch)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="candidate_id" value="{{ $candidate->id }}" required class="text-accent-blue focus:ring-accent-blue/40">
                                <div>
                                    <div class="text-xs font-bold text-text-main">{{ $candidate->name }}</div>
                                    <div class="text-[11px] text-text-dark/60 flex items-center gap-2 mt-0.5">
                                        <span><i class="fas fa-phone-alt text-[9px]"></i> {{ $candidate->phone }}</span>
                                        @if($candidate->profile && $candidate->profile->subject)
                                            <span class="text-accent-blue font-medium">• {{ $candidate->profile->subject->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="text-[10px] bg-blue-500/10 text-blue-600 px-2 py-0.5 rounded font-bold">Teacher</span>
                        </label>
                    @empty
                        <div class="p-4 text-center text-xs text-text-dark/50">No registered candidates found.</div>
                    @endforelse
                </div>
            </div>

            <div class="p-3 bg-blue-500/5 rounded-xl border border-blue-500/10 text-[11px] text-text-dark/70 flex items-start gap-2">
                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                <span>Assigning this teacher will mark the tuition requirement as <strong>Confirmed</strong> and send a notification to the teacher.</span>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-card-border">
                <button type="button" @click="assignModalOpen = false" class="px-4 py-2 bg-secondary-bg text-text-main border border-card-border rounded-xl text-xs font-semibold hover:bg-card-border/50 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-xs font-bold transition-all shadow-md flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i> Confirm Assignment
                </button>
            </div>
        </form>
    </div>
</div>

</div>

@endsection
