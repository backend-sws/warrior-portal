@extends('layouts.admin')

@section('title', 'Home Tuition Leads')
@section('subtitle', 'Review incoming tuition requests, approve them to post live, or edit details.')

@section('content')

{{-- Top Action Bar --}}
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.tuition-leads.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ (!request('status')) ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            All Leads
        </a>
        <a href="{{ route('admin.tuition-leads.index', ['status' => 'New Lead']) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'New Lead' ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            <i class="fas fa-clock mr-1"></i> Awaiting Approval
            @php $pendingCount = \App\Models\HomeTuitionLead::where('status', 'New Lead')->count(); @endphp
            @if($pendingCount > 0)
                <span class="ml-1.5 bg-yellow-400 text-slate-900 text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.tuition-leads.index', ['status' => 'Approved']) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'Approved' ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            <i class="fas fa-check-double mr-1"></i> Live on Website
        </a>
        <a href="{{ route('admin.tuition-leads.index', ['status' => 'Confirmed']) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'Confirmed' ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            Confirmed / Assigned
        </a>
    </div>
    <a href="{{ route('admin.tuition-leads.create') }}" class="px-4 py-2 bg-emerald-500 text-white rounded-lg text-sm font-bold hover:bg-emerald-600 transition-colors flex items-center gap-2 shadow-sm">
        <i class="fas fa-plus"></i> Post New Tuition
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
            <option value="New Lead" {{ request('status') == 'New Lead' ? 'selected' : '' }}>New Lead (Pending)</option>
            <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved (Live)</option>
            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                <th>Status</th>
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
                    <div class="text-xs text-accent-blue font-medium mt-0.5">{{ $lead->board ?: 'Not Specified' }}</div>
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
                            'New Lead' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                            'Approved' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                            'Confirmed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                            'Cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                        ];
                        $colorClass = $statusColors[$lead->status] ?? 'bg-gray-500/10 text-gray-500 border-gray-500/20';
                    @endphp
                    <span class="{{ $colorClass }} px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-wider inline-block">
                        {{ $lead->status === 'New Lead' ? '⏳ Awaiting Review' : ($lead->status === 'Approved' ? '✅ Live / Approved' : $lead->status) }}
                    </span>
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

                        <a href="{{ route('admin.tuition-leads.edit', $lead->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue rounded-lg text-xs font-bold transition-colors" title="Edit Tuition Lead">
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
                        <p class="text-base font-semibold">No tuition leads found</p>
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

@endsection
