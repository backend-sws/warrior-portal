@extends('layouts.admin')

@section('title', $title ?? 'Home Tuition Leads')
@section('subtitle', 'Manage home tuition enquiries and follow-ups.')

@section('content')

{{-- Top Action Bar --}}
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.tuition-leads.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ (request()->routeIs('admin.tuition-leads.index') && !request('status') && $filterStatus === 'All') ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            All Leads
        </a>
        <a href="{{ route('admin.tuition-leads.pending') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $filterStatus === 'Pending' ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            Pending Follow-ups
        </a>
        <a href="{{ route('admin.tuition-leads.confirmed') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $filterStatus === 'Confirmed' ? 'bg-accent-blue text-white' : 'bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue' }}">
            Confirmed Leads
        </a>
    </div>
    <a href="{{ route('admin.tuition-leads.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-bold hover:bg-green-600 transition-colors flex items-center gap-2">
        <i class="fas fa-plus"></i> Add New Lead
    </a>
</div>

{{-- Filter/Search Bar --}}
<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div class="text-sm text-text-dark/50 font-medium whitespace-nowrap">
        Showing {{ $leads->firstItem() ?? 0 }} to {{ $leads->lastItem() ?? 0 }} of {{ $leads->total() }} entries
    </div>
    <form action="{{ url()->current() }}" method="GET" class="w-full flex flex-col sm:flex-row items-center justify-end gap-3 flex-wrap">
        <div class="relative w-full sm:w-48">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, phone..." 
                   class="w-full pl-9 pr-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
        </div>
        
        <select name="status" class="w-full sm:w-auto px-3 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50">
            <option value="">All Statuses</option>
            <option value="New Lead" {{ request('status') == 'New Lead' ? 'selected' : '' }}>New Lead</option>
            <option value="Demo Scheduled" {{ request('status') == 'Demo Scheduled' ? 'selected' : '' }}>Demo Scheduled</option>
            <option value="Demo Completed" {{ request('status') == 'Demo Completed' ? 'selected' : '' }}>Demo Completed</option>
            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" class="w-full sm:w-auto bg-accent-blue text-white rounded-xl px-4 py-2 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors whitespace-nowrap">Filter</button>
        
        @if(request()->anyFilled(['search', 'status', 'follow_up_date']))
            <a href="{{ url()->current() }}" class="text-text-dark/40 hover:text-red-400 transition-colors w-full sm:w-auto text-center" title="Clear Filters">
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
                <th>Requirement</th>
                <th>Status</th>
                <th>Follow-up</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($leads as $lead)
            <tr class="group hover:bg-secondary-bg/30 transition-colors">
                <td class="align-top">
                    <div class="font-bold text-text-main group-hover:text-accent-blue transition-colors">{{ $lead->parent_name }}</div>
                    <div class="text-xs text-text-dark/60 mt-1 flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <span class="flex items-center gap-1.5"><i class="fas fa-phone-alt w-3 text-[10px]"></i> {{ $lead->parent_mobile }}</span>
                        </div>
                        <span class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt w-3 text-[10px]"></i> {{ $lead->location }}</span>
                    </div>
                </td>
                <td class="align-top">
                    <div class="text-sm font-semibold text-text-main mb-1">Class: {{ $lead->class }}</div>
                    <div class="text-xs text-text-dark/80 mb-1">Sub: {{ $lead->subjects }}</div>
                    @if($lead->fee)
                        <div class="text-xs font-bold text-green-500/80">Fee: {{ $lead->fee }}</div>
                    @endif
                </td>
                <td class="align-top">
                    @php
                        $statusColors = [
                            'New Lead' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                            'Demo Scheduled' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                            'Demo Completed' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                            'Confirmed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                            'Pending' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                            'Cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                        ];
                        $colorClass = $statusColors[$lead->status] ?? 'bg-gray-500/10 text-gray-500 border-gray-500/20';
                    @endphp
                    <span class="{{ $colorClass }} px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-wider inline-block mb-2">
                        {{ $lead->status }}
                    </span>
                    
                    @if($lead->teacher_contact)
                        <div class="text-xs text-text-dark/80 mt-1 flex items-center gap-1">
                            <i class="fas fa-chalkboard-teacher text-[10px]"></i> 
                            {{ $lead->teacher_contact }}
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->teacher_contact) }}" target="_blank" class="text-green-500 hover:text-green-600 ml-1" title="WhatsApp Teacher">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    @endif
                </td>
                <td class="align-top">
                    @if($lead->follow_up_date)
                        @php
                            $isPast = \Carbon\Carbon::parse($lead->follow_up_date)->isPast() && !\Carbon\Carbon::parse($lead->follow_up_date)->isToday();
                            $isToday = \Carbon\Carbon::parse($lead->follow_up_date)->isToday();
                        @endphp
                        <div class="text-xs font-bold {{ $isPast ? 'text-red-500' : ($isToday ? 'text-orange-500' : 'text-text-main') }}">
                            {{ \Carbon\Carbon::parse($lead->follow_up_date)->format('M d, Y') }}
                            @if($isToday) <span class="ml-1 text-[10px] bg-orange-500/20 px-1 rounded">TODAY</span> @endif
                        </div>
                    @else
                        <span class="text-xs text-text-dark/40">Not set</span>
                    @endif
                    <div class="text-[10px] text-text-dark/40 mt-1">Enquiry: {{ $lead->enquiry_date ? $lead->enquiry_date->format('M d, Y') : 'Unknown' }}</div>
                </td>
                <td class="align-top text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->parent_mobile) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition-colors" title="WhatsApp Parent">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                        <a href="{{ route('admin.tuition-leads.show', $lead->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-accent-blue/10 text-accent-blue hover:bg-accent-blue hover:text-white rounded-lg text-xs font-bold transition-colors whitespace-nowrap">
                            Manage <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-12">
                    <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-4 border border-card-border shadow-inner">
                        <i class="fas fa-folder-open text-2xl text-text-dark/20"></i>
                    </div>
                    <div class="text-text-main font-bold mb-1">No Leads Found</div>
                    <div class="text-sm text-text-dark/50">There are no home tuition leads matching your criteria.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($leads->hasPages())
<div class="mt-4">
    {{ $leads->links('pagination::tailwind') }}
</div>
@endif

@endsection
