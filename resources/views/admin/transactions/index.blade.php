@extends('layouts.admin')

@section('title', 'Payment Gateway & Transaction Logs')
@section('subtitle', 'Real-time audit log of all PhonePe payments, webhooks, and gateway settlements.')

@section('content')
<div class="space-y-6" x-data="{ activePayload: null, modalOpen: false }">

    {{-- Analytics Cards (Clickable Filters) --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.transactions.index', ['status' => 'all']) }}" 
           class="bg-card-bg rounded-2xl p-4 sm:p-5 border {{ (!request('status') || request('status') === 'all') ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/10' : 'border-card-border hover:border-blue-300' }} shadow-sm flex items-center justify-between transition-all">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-text-dark/50 font-bold mb-1">Total Collections</p>
                <h3 class="text-xl sm:text-2xl font-black text-blue-600">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
                <span class="text-[10px] text-text-dark/40 font-semibold">{{ $stats['total_transactions'] }} Total Inquiries</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-600 text-lg">
                <i class="fas fa-wallet"></i>
            </div>
        </a>

        <a href="{{ route('admin.transactions.index', ['status' => 'success']) }}" 
           class="bg-card-bg rounded-2xl p-4 sm:p-5 border {{ request('status') === 'success' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} shadow-sm flex items-center justify-between transition-all">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-emerald-600 font-bold mb-1">Successful Payments</p>
                <h3 class="text-xl sm:text-2xl font-black text-emerald-600">{{ number_format($stats['success_count']) }}</h3>
                <span class="text-[10px] text-emerald-600 font-semibold">Captured & Verified</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 text-lg">
                <i class="fas fa-check-circle"></i>
            </div>
        </a>

        <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" 
           class="bg-card-bg rounded-2xl p-4 sm:p-5 border {{ request('status') === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} shadow-sm flex items-center justify-between transition-all">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-amber-600 font-bold mb-1">Pending / Orders</p>
                <h3 class="text-xl sm:text-2xl font-black text-amber-600">{{ number_format($stats['pending_count']) }}</h3>
                <span class="text-[10px] text-amber-600 font-semibold">Awaiting Settlement</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-600 text-lg">
                <i class="fas fa-clock"></i>
            </div>
        </a>

        <a href="{{ route('admin.transactions.index', ['status' => 'failed']) }}" 
           class="bg-card-bg rounded-2xl p-4 sm:p-5 border {{ request('status') === 'failed' ? 'border-rose-500 ring-2 ring-rose-500/20 bg-rose-50/10' : 'border-card-border hover:border-rose-300' }} shadow-sm flex items-center justify-between transition-all">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-rose-600 font-bold mb-1">Failed Attempts</p>
                <h3 class="text-xl sm:text-2xl font-black text-rose-600">{{ number_format($stats['failed_count']) }}</h3>
                <span class="text-[10px] text-rose-600 font-semibold">Cancelled or Declined</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-600 text-lg">
                <i class="fas fa-times-circle"></i>
            </div>
        </a>
    </div>

    {{-- Filter & Search Toolbar --}}
    <div class="bg-card-bg rounded-2xl border border-card-border p-4 shadow-sm">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2 relative">
                <i class="fas fa-search absolute left-3.5 top-3 text-text-dark/40 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search candidate, order ID, payment ID, or txn ID..." 
                       class="w-full pl-9 pr-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-xs text-text-main focus:outline-none focus:ring-1 focus:ring-accent-blue">
            </div>

            <div>
                <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="all">All Statuses</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (Captured)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Created)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div>
                <select name="type" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2 text-xs text-text-main focus:border-accent-blue focus:outline-none">
                    <option value="all">All Transaction Types</option>
                    <option value="service_charge" {{ request('type') === 'service_charge' ? 'selected' : '' }}>Service Charge</option>
                    <option value="registration_fee" {{ request('type') === 'registration_fee' ? 'selected' : '' }}>Registration Fee</option>
                    <option value="placement_fee" {{ request('type') === 'placement_fee' ? 'selected' : '' }}>Placement Fee</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-accent-blue hover:bg-accent-blue-hover text-white rounded-xl py-2 px-3 text-xs font-bold shadow transition-all flex items-center justify-center gap-1.5">
                    <i class="fas fa-filter text-[10px]"></i> <span>Filter</span>
                </button>
                @if(request()->anyFilled(['search', 'status', 'type', 'gateway']))
                    <a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 bg-secondary-bg hover:bg-card-border text-text-dark/60 rounded-xl text-xs font-bold transition-all flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Transactions Data Table --}}
    <div class="bg-card-bg rounded-2xl border border-card-border overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse admin-table">
                <thead>
                    <tr class="bg-secondary-bg/50 border-b border-card-border text-[10px] font-bold text-text-dark/60 uppercase tracking-wider">
                        <th class="py-3 px-4">Transaction / Order ID</th>
                        <th class="py-3 px-4">Payer / Candidate</th>
                        <th class="py-3 px-4">Payment Type</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Gateway & Method</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date & Time</th>
                        <th class="py-3 px-4 text-right">Logs</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-card-border text-xs">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-secondary-bg/30 transition-colors">
                        <td class="py-3 px-4">
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
                        <td class="py-3 px-4">
                            <div class="font-bold text-text-main">{{ $txn->candidate->name ?? 'Guest / N/A' }}</div>
                            <div class="text-[10px] text-text-dark/50">{{ $txn->candidate->email ?? ($txn->candidate->phone ?? '') }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $txn->type === 'service_charge' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                {{ ucwords(str_replace('_', ' ', $txn->type)) }}
                            </span>
                            @if($txn->invoice_id)
                                <span class="text-[10px] text-text-dark/40 block font-mono">Invoice #{{ $txn->invoice_id }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-black text-sm text-text-main">₹{{ number_format($txn->amount, 2) }}</span>
                            <span class="text-[10px] text-text-dark/40 block uppercase">{{ $txn->currency ?? 'INR' }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-1.5">
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
                        <td class="py-3 px-4">
                            @if($txn->status === 'success')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="fas fa-check-circle text-[9px]"></i> Success
                                </span>
                            @elseif($txn->status === 'failed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200" title="{{ $txn->error_description }}">
                                    <i class="fas fa-times-circle text-[9px]"></i> Failed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                    <i class="fas fa-clock text-[9px]"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-text-dark/60 text-xs whitespace-nowrap">
                            {{ $txn->created_at->format('d M, Y') }}
                            <span class="text-[10px] block text-text-dark/40">{{ $txn->created_at->format('h:i A') }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            @php
                                $payloadData = $txn->gateway_response ?: ($txn->webhook_payload ?: ['info' => 'No extra payload logged']);
                            @endphp
                            <button type="button" 
                                    @click="activePayload = {{ json_encode($payloadData) }}; modalOpen = true"
                                    class="px-2.5 py-1 text-[11px] font-bold text-accent-blue bg-accent-blue/10 hover:bg-accent-blue hover:text-white rounded-lg transition-all">
                                <i class="fas fa-code"></i> Payload
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-text-dark/50">
                            <i class="fas fa-receipt text-3xl mb-2 text-text-dark/30"></i>
                            <p class="font-bold text-sm">No payment transactions found</p>
                            <p class="text-[11px] text-text-dark/40">Transactions will appear here when users make payments via Razorpay.</p>
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
