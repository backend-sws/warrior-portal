@extends('layouts.admin')

@section('title', 'Payment Gateway & Transaction Logs')
@section('subtitle', 'Real-time financial audit, revenue streams, and PhonePe gateway settlements.')

@section('content')
<div class="space-y-6" x-data="{ activePayload: null, modalOpen: false }">

    {{-- Filter Status & Date Summary Banner --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-card-bg rounded-2xl p-4 border border-card-border shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center text-base shrink-0">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-text-main uppercase tracking-wider">Financial Analytics & Revenue Streams</h4>
                <p class="text-xs text-text-dark/60 mt-0.5">
                    @if(!empty($dateFrom) && !empty($dateTo))
                        Active Period: <span class="font-bold text-text-main">{{ \Carbon\Carbon::parse($dateFrom)->format('d M, Y') }}</span> to <span class="font-bold text-text-main">{{ \Carbon\Carbon::parse($dateTo)->format('d M, Y') }}</span>
                    @elseif(!empty($dateFrom))
                        Active Period: From <span class="font-bold text-text-main">{{ \Carbon\Carbon::parse($dateFrom)->format('d M, Y') }}</span> onwards
                    @elseif(!empty($dateTo))
                        Active Period: Up to <span class="font-bold text-text-main">{{ \Carbon\Carbon::parse($dateTo)->format('d M, Y') }}</span>
                    @elseif(!empty($datePreset) && $datePreset !== 'all_time')
                        Active Period: <span class="font-bold text-text-main capitalize">{{ str_replace('_', ' ', $datePreset) }}</span>
                    @else
                        Active Period: <span class="font-bold text-text-main">All Time Record</span>
                    @endif

                    @if(!empty($categoryFilter) && $categoryFilter !== 'all')
                        &bull; Stream: <span class="font-bold text-text-main">{{ $categoryFilter === 'job' ? 'School Jobs Only' : 'Home Tuitions Only' }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap text-xs">
            @if(request()->anyFilled(['search', 'status', 'type', 'category', 'date_from', 'date_to', 'date_preset']))
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i class="fas fa-filter text-[9px]"></i> Filters Active
                </span>
                <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-secondary-bg hover:bg-card-border text-text-dark/80 border border-card-border transition-all">
                    <i class="fas fa-times text-[10px]"></i> Reset All
                </a>
            @endif
        </div>
    </div>

    {{-- Top Analytics Cards (Interactive Filters) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Total Collections --}}
        <a href="{{ route('admin.transactions.index', array_merge(request()->except(['category', 'page']), ['category' => 'all'])) }}" 
           class="bg-card-bg rounded-2xl p-5 border {{ (!request('category') || request('category') === 'all') && (!request('status') || request('status') === 'all') ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/5' : 'border-card-border hover:border-blue-300' }} shadow-xs flex flex-col justify-between transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] uppercase tracking-widest text-text-dark/50 font-black">Total Collections</span>
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 group-hover:bg-blue-500 group-hover:text-white text-blue-600 flex items-center justify-center text-sm transition-colors">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-blue-600 tracking-tight">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
                <div class="flex items-center justify-between text-[11px] text-text-dark/60 mt-1.5">
                    <span>{{ number_format($stats['success_count']) }} verified payments</span>
                    <span class="text-[10px] font-bold text-slate-400">{{ $stats['total_transactions'] }} attempts</span>
                </div>
            </div>
        </a>

        {{-- School Job Collections --}}
        <a href="{{ route('admin.transactions.index', array_merge(request()->except(['category', 'page']), ['category' => 'job'])) }}" 
           class="bg-card-bg rounded-2xl p-5 border {{ request('category') === 'job' ? 'border-sky-500 ring-2 ring-sky-500/20 bg-sky-50/10' : 'border-card-border hover:border-sky-300' }} shadow-xs flex flex-col justify-between transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-1.5">
                    <span class="text-[10px] uppercase tracking-widest text-sky-700 font-black">School Jobs</span>
                    <span class="px-1.5 py-0.2 rounded text-[9px] font-black bg-sky-100 text-sky-700">{{ $stats['job_percentage'] }}%</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-sky-500/10 group-hover:bg-sky-500 group-hover:text-white text-sky-600 flex items-center justify-center text-sm transition-colors">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-sky-600 tracking-tight">₹{{ number_format($stats['job_revenue'], 2) }}</h3>
                <div class="flex items-center justify-between text-[11px] text-sky-700/80 mt-1.5 font-medium">
                    <span>{{ number_format($stats['job_count']) }} Job Payments</span>
                    <span class="text-[10px] text-text-dark/50">Reg & Placements</span>
                </div>
            </div>
        </a>

        {{-- Home Tuition Collections --}}
        <a href="{{ route('admin.transactions.index', array_merge(request()->except(['category', 'page']), ['category' => 'tuition'])) }}" 
           class="bg-card-bg rounded-2xl p-5 border {{ request('category') === 'tuition' ? 'border-purple-500 ring-2 ring-purple-500/20 bg-purple-50/10' : 'border-card-border hover:border-purple-300' }} shadow-xs flex flex-col justify-between transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-1.5">
                    <span class="text-[10px] uppercase tracking-widest text-purple-700 font-black">Home Tuitions</span>
                    <span class="px-1.5 py-0.2 rounded text-[9px] font-black bg-purple-100 text-purple-700">{{ $stats['tuition_percentage'] }}%</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-purple-500/10 group-hover:bg-purple-500 group-hover:text-white text-purple-600 flex items-center justify-center text-sm transition-colors">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-purple-600 tracking-tight">₹{{ number_format($stats['tuition_revenue'], 2) }}</h3>
                <div class="flex items-center justify-between text-[11px] text-purple-700/80 mt-1.5 font-medium">
                    <span>{{ number_format($stats['tuition_count']) }} Tuition Payments</span>
                    <span class="text-[10px] text-text-dark/50">Service Charges</span>
                </div>
            </div>
        </a>

        {{-- Pending Settlements --}}
        <a href="{{ route('admin.transactions.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}" 
           class="bg-card-bg rounded-2xl p-5 border {{ request('status') === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} shadow-xs flex flex-col justify-between transition-all group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] uppercase tracking-widest text-amber-600 font-black">Pending Orders</span>
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 group-hover:bg-amber-500 group-hover:text-white text-amber-600 flex items-center justify-center text-sm transition-colors">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-amber-600 tracking-tight">{{ number_format($stats['pending_count']) }}</h3>
                <div class="flex items-center justify-between text-[11px] text-amber-700/80 mt-1.5 font-medium">
                    <span>₹{{ number_format($stats['pending_amount'], 2) }} Pending</span>
                    <span class="text-[10px] text-text-dark/50">Awaiting Webhook</span>
                </div>
            </div>
        </a>
    </div>

    {{-- Revenue Stream Distribution Progress Widget --}}
    <div class="bg-card-bg rounded-2xl border border-card-border p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
            <div class="flex items-center gap-2">
                <i class="fas fa-balance-scale text-text-dark/40 text-xs"></i>
                <span class="text-xs font-black uppercase tracking-wider text-text-main">Revenue Distribution Ratio (Jobs vs Tuitions)</span>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-500 inline-block"></span>
                    <span class="font-bold text-text-main">School Jobs:</span>
                    <span class="font-mono text-sky-600 font-bold">₹{{ number_format($stats['job_revenue'], 2) }} ({{ $stats['job_percentage'] }}%)</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500 inline-block"></span>
                    <span class="font-bold text-text-main">Home Tuitions:</span>
                    <span class="font-mono text-purple-600 font-bold">₹{{ number_format($stats['tuition_revenue'], 2) }} ({{ $stats['tuition_percentage'] }}%)</span>
                </div>
            </div>
        </div>

        @if($stats['total_revenue'] > 0)
            <div class="w-full bg-secondary-bg h-4 rounded-full overflow-hidden flex shadow-inner p-0.5 border border-card-border/80">
                <div style="width: {{ $stats['job_percentage'] }}%" 
                     class="bg-gradient-to-r from-sky-400 to-blue-600 h-full rounded-l-full transition-all duration-500 relative group"
                     title="School Jobs: ₹{{ number_format($stats['job_revenue'], 2) }} ({{ $stats['job_percentage'] }}%)">
                </div>
                <div style="width: {{ $stats['tuition_percentage'] }}%" 
                     class="bg-gradient-to-r from-purple-500 to-fuchsia-600 h-full rounded-r-full transition-all duration-500 relative group"
                     title="Home Tuitions: ₹{{ number_format($stats['tuition_revenue'], 2) }} ({{ $stats['tuition_percentage'] }}%)">
                </div>
            </div>
        @else
            <div class="w-full bg-secondary-bg h-3.5 rounded-full flex items-center justify-center text-[10px] text-text-dark/40 font-semibold">
                No revenue recorded for selected period
            </div>
        @endif
    </div>

    {{-- Filter & Date Toolbar --}}
    <div class="bg-card-bg rounded-2xl border border-card-border p-4 shadow-xs space-y-3">
        
        {{-- Quick Date Presets Row --}}
        <div class="flex items-center gap-1.5 flex-wrap pb-2 border-b border-card-border">
            <span class="text-[10px] uppercase tracking-wider font-extrabold text-text-dark/50 mr-1 flex items-center gap-1">
                <i class="far fa-calendar-alt"></i> Quick Presets:
            </span>

            @php
                $presets = [
                    'all_time'   => 'All Time',
                    'today'      => 'Today',
                    'yesterday'  => 'Yesterday',
                    'this_week'  => 'This Week',
                    'this_month' => 'This Month',
                    'last_month' => 'Last Month',
                ];
                $activePreset = request('date_preset', (empty($dateFrom) && empty($dateTo) ? 'all_time' : ''));
            @endphp

            @foreach($presets as $key => $label)
                <a href="{{ route('admin.transactions.index', array_merge(request()->except(['date_preset', 'date_from', 'date_to', 'page']), ['date_preset' => $key])) }}" 
                   class="px-2.5 py-1 rounded-lg text-xs font-semibold transition-all {{ ($activePreset === $key && empty(request('date_from')) && empty(request('date_to'))) ? 'bg-accent-blue text-white shadow-xs' : 'bg-secondary-bg hover:bg-card-border text-text-dark/70' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Custom Filters Form --}}
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 items-end">
            
            {{-- Search --}}
            <div class="lg:col-span-2">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-text-dark/60 mb-1">Search Keywords</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-2.5 text-text-dark/40 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Txn ID, Order ID, Candidate, Phone..." 
                           class="w-full pl-8 pr-3 py-1.5 bg-secondary-bg border border-card-border rounded-xl text-xs text-text-main focus:outline-none focus:ring-1 focus:ring-accent-blue placeholder:text-text-dark/40">
                </div>
            </div>

            {{-- Date From --}}
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-text-dark/60 mb-1">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from', $dateFrom) }}" 
                       class="w-full px-3 py-1.5 bg-secondary-bg border border-card-border rounded-xl text-xs text-text-main focus:outline-none focus:ring-1 focus:ring-accent-blue">
            </div>

            {{-- Date To --}}
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-text-dark/60 mb-1">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to', $dateTo) }}" 
                       class="w-full px-3 py-1.5 bg-secondary-bg border border-card-border rounded-xl text-xs text-text-main focus:outline-none focus:ring-1 focus:ring-accent-blue">
            </div>

            {{-- Category / Stream Filter --}}
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-text-dark/60 mb-1">Revenue Stream</label>
                <select name="category" class="w-full bg-secondary-bg border border-card-border rounded-xl px-2.5 py-1.5 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="all" {{ request('category') === 'all' || !request('category') ? 'selected' : '' }}>All Streams</option>
                    <option value="job" {{ request('category') === 'job' ? 'selected' : '' }}>School Jobs</option>
                    <option value="tuition" {{ request('category') === 'tuition' ? 'selected' : '' }}>Home Tuitions</option>
                </select>
            </div>

            {{-- Status Filter --}}
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-text-dark/60 mb-1">Status</label>
                <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-2.5 py-1.5 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="all">All Statuses</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (Captured)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Orders)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            {{-- Payment Type Filter --}}
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-text-dark/60 mb-1">Payment Type</label>
                <select name="type" class="w-full bg-secondary-bg border border-card-border rounded-xl px-2.5 py-1.5 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="all">All Payment Types</option>
                    <option value="registration_fee" {{ request('type') === 'registration_fee' ? 'selected' : '' }}>Registration Fee</option>
                    <option value="service_charge" {{ request('type') === 'service_charge' ? 'selected' : '' }}>Service Charge</option>
                    <option value="placement_fee" {{ request('type') === 'placement_fee' ? 'selected' : '' }}>Placement Fee</option>
                    <option value="parent_service_charge" {{ request('type') === 'parent_service_charge' ? 'selected' : '' }}>Parent Service Charge</option>
                </select>
            </div>

            {{-- Action Buttons --}}
            <div class="lg:col-span-5 flex gap-2 justify-end">
                <button type="submit" class="bg-accent-blue hover:bg-accent-blue-hover text-white rounded-xl py-1.5 px-4 text-xs font-bold shadow-xs transition-all flex items-center justify-center gap-1.5">
                    <i class="fas fa-filter text-[10px]"></i> <span>Apply Filters</span>
                </button>
                @if(request()->anyFilled(['search', 'status', 'type', 'category', 'date_from', 'date_to', 'date_preset']))
                    <a href="{{ route('admin.transactions.index') }}" class="px-3 py-1.5 bg-secondary-bg hover:bg-card-border text-text-dark/70 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1" title="Clear all filters">
                        <i class="fas fa-undo text-[10px]"></i> <span>Reset</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Transactions Data Table --}}
    <div class="bg-card-bg rounded-2xl border border-card-border overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse admin-table">
                <thead>
                    <tr class="bg-secondary-bg/50 border-b border-card-border text-[10px] font-extrabold text-text-dark/60 uppercase tracking-wider">
                        <th class="py-3 px-4">Transaction / Order ID</th>
                        <th class="py-3 px-4">Payer / Candidate Profile</th>
                        <th class="py-3 px-4">Revenue Stream & Type</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Gateway & Method</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date & Time</th>
                        <th class="py-3 px-4 text-right">Payload</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-card-border text-xs">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-secondary-bg/30 transition-colors">
                        
                        {{-- Transaction / Order ID --}}
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <div class="font-mono text-xs font-bold text-text-main flex items-center gap-1.5">
                                    <span>{{ $txn->transaction_id ?? ($txn->order_id ?? 'TXN_' . $txn->id) }}</span>
                                </div>
                                @if($txn->payment_id)
                                    <div class="font-mono text-[10px] text-blue-600 font-semibold">
                                        Pay ID: {{ $txn->payment_id }}
                                    </div>
                                @elseif($txn->order_id)
                                    <div class="font-mono text-[10px] text-slate-400">
                                        Order ID: {{ $txn->order_id }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Candidate / Payer (Direct Clickable Link to Profile) --}}
                        <td class="py-3.5 px-4">
                            @if($txn->candidate)
                                <a href="{{ route('admin.crm.show', $txn->candidate_id) }}" 
                                   target="_blank" 
                                   class="group flex items-start gap-2.5 text-text-main hover:text-blue-600 transition-colors"
                                   title="Open Candidate 360° Profile in new tab">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 border border-blue-200 flex items-center justify-center font-black text-xs shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all shadow-xs">
                                        {{ strtoupper(substr($txn->candidate->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-xs flex items-center gap-1.5 group-hover:text-blue-600">
                                            <span class="truncate">{{ $txn->candidate->name }}</span>
                                            <i class="fas fa-external-link-alt text-[9px] text-blue-500 opacity-60 group-hover:opacity-100 shrink-0"></i>
                                        </div>
                                        <div class="text-[10px] text-text-dark/50 font-mono truncate">
                                            {{ $txn->candidate->phone ?: $txn->candidate->email }}
                                        </div>
                                        <span class="inline-flex items-center gap-1 mt-0.5 text-[9px] font-semibold text-blue-600 bg-blue-50 px-1.5 py-0.2 rounded border border-blue-100 group-hover:border-blue-300">
                                            <span>Candidate Profile</span> <i class="fas fa-arrow-right text-[7px]"></i>
                                        </span>
                                    </div>
                                </a>
                            @else
                                <div class="flex items-center gap-2 text-text-dark/50 italic text-xs">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <span>Guest / Deleted User</span>
                                </div>
                            @endif
                        </td>

                        {{-- Revenue Stream & Type --}}
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <div>
                                    @if($txn->category === 'tuition')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-purple-50 text-purple-700 border border-purple-200 shadow-2xs">
                                            <i class="fas fa-graduation-cap text-[9px]"></i> Home Tuition
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200 shadow-2xs">
                                            <i class="fas fa-briefcase text-[9px]"></i> School Job
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs font-medium text-text-main">
                                    {{ ucwords(str_replace('_', ' ', $txn->type)) }}
                                </div>
                                @if($txn->invoice_id)
                                    <span class="text-[10px] text-text-dark/40 block font-mono">Invoice #{{ $txn->invoice_id }}</span>
                                @elseif($txn->tuition_lead_id)
                                    <span class="text-[10px] text-purple-600/70 block font-mono">Lead #{{ $txn->tuition_lead_id }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Amount --}}
                        <td class="py-3.5 px-4">
                            <span class="font-black text-sm text-text-main">₹{{ number_format($txn->amount, 2) }}</span>
                            <span class="text-[10px] text-text-dark/40 block uppercase font-mono">{{ $txn->currency ?? 'INR' }}</span>
                        </td>

                        {{-- Gateway & Method --}}
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-purple-500/10 text-purple-700">
                                    {{ $txn->gateway ?: 'PhonePe' }}
                                </span>
                                @if($txn->payment_method)
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase bg-slate-100 text-slate-700">
                                        {{ $txn->payment_method }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="py-3.5 px-4">
                            @if($txn->status === 'success')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                    <i class="fas fa-check-circle text-[9px]"></i> Success
                                </span>
                            @elseif($txn->status === 'failed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs" title="{{ $txn->error_description }}">
                                    <i class="fas fa-times-circle text-[9px]"></i> Failed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 shadow-2xs">
                                    <i class="fas fa-clock text-[9px]"></i> Pending
                                </span>
                            @endif
                        </td>

                        {{-- Date & Time --}}
                        <td class="py-3.5 px-4 text-text-dark/70 text-xs whitespace-nowrap">
                            <div class="font-medium text-text-main">{{ $txn->created_at->format('d M, Y') }}</div>
                            <span class="text-[10px] block text-text-dark/40 font-mono">{{ $txn->created_at->format('h:i A') }}</span>
                        </td>

                        {{-- Logs / Payload --}}
                        <td class="py-3.5 px-4 text-right">
                            @php
                                $payloadData = $txn->gateway_response ?: ($txn->webhook_payload ?: ['info' => 'No extra payload logged']);
                            @endphp
                            <button type="button" 
                                    @click="activePayload = {{ json_encode($payloadData) }}; modalOpen = true"
                                    class="px-2.5 py-1 text-[11px] font-bold text-accent-blue bg-accent-blue/10 hover:bg-accent-blue hover:text-white rounded-lg transition-all shadow-2xs">
                                <i class="fas fa-code"></i> Payload
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-text-dark/50">
                            <div class="w-12 h-12 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-3 text-text-dark/30 text-xl">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <p class="font-bold text-sm text-text-main">No payment transactions found</p>
                            <p class="text-[11px] text-text-dark/40 max-w-sm mx-auto mt-0.5">There are no transactions matching the selected date range or filter criteria.</p>
                            @if(request()->anyFilled(['search', 'status', 'type', 'category', 'date_from', 'date_to', 'date_preset']))
                                <a href="{{ route('admin.transactions.index') }}" class="inline-block mt-3 px-3 py-1.5 text-xs font-bold text-accent-blue bg-accent-blue/10 hover:bg-accent-blue hover:text-white rounded-xl transition-all">
                                    Clear Filters
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($transactions->hasPages())
    <div class="mt-4">
        {{ $transactions->links('pagination::tailwind') }}
    </div>
    @endif

    {{-- Payload Inspection Modal --}}
    <div x-show="modalOpen" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-card-bg rounded-2xl border border-card-border max-w-2xl w-full p-6 shadow-2xl space-y-4 max-h-[85vh] flex flex-col"
             @click.outside="modalOpen = false">
            
            <div class="flex items-center justify-between border-b border-card-border pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="font-black text-sm text-text-main">Gateway Audit Payload</h3>
                </div>
                <button type="button" @click="modalOpen = false" class="text-text-dark/40 hover:text-text-main text-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-3 bg-secondary-bg rounded-xl font-mono text-[11px] text-text-main">
                <pre x-text="JSON.stringify(activePayload, null, 2)" class="whitespace-pre-wrap word-break"></pre>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" @click="modalOpen = false" class="px-4 py-2 bg-secondary-bg hover:bg-card-border text-text-main rounded-xl text-xs font-bold transition-all">
                    Close
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
