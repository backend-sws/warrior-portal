@extends('layouts.admin')

@section('title', 'Transaction Logs')
@section('subtitle', 'Monitor all payment attempts and transactions.')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-card-bg rounded-2xl p-5 border border-card-border shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-text-dark/40 font-bold mb-1">Total Revenue</p>
            <h3 class="text-2xl font-black text-text-main">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
        </div>
        <div class="w-10 h-10 rounded-full bg-accent-blue/10 flex items-center justify-center text-accent-blue">
            <i class="fas fa-rupee-sign"></i>
        </div>
    </div>
    <div class="bg-card-bg rounded-2xl p-5 border border-card-border shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-text-dark/40 font-bold mb-1">Candidate Payments</p>
            <h3 class="text-2xl font-black text-text-main">₹{{ number_format($stats['candidate_revenue'], 2) }}</h3>
        </div>
        <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
            <i class="fas fa-user-graduate"></i>
        </div>
    </div>
    <div class="bg-card-bg rounded-2xl p-5 border border-card-border shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-text-dark/40 font-bold mb-1">Parent Tuitions</p>
            <h3 class="text-2xl font-black text-text-main">₹{{ number_format($stats['parent_revenue'], 2) }}</h3>
        </div>
        <div class="w-10 h-10 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500">
            <i class="fas fa-user-friends"></i>
        </div>
    </div>
    <div class="bg-card-bg rounded-2xl p-5 border border-card-border shadow-sm flex items-center justify-between">
        <div>
            <p class="text-[10px] uppercase tracking-widest text-text-dark/40 font-bold mb-1">Total Txns</p>
            <h3 class="text-2xl font-black text-text-main">{{ number_format($stats['total_transactions']) }}</h3>
        </div>
        <div class="w-10 h-10 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-500">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>
</div>

<div class="mb-6 border-b border-card-border flex gap-6 overflow-x-auto">
    <a href="{{ route('admin.transactions.index', array_merge(request()->all(), ['role' => 'all'])) }}" class="shrink-0 pb-3 text-sm font-bold border-b-2 transition-colors {{ $roleFilter === 'all' ? 'border-accent-blue text-accent-blue' : 'border-transparent text-text-dark/50 hover:text-text-main' }}">All Transactions</a>
    <a href="{{ route('admin.transactions.index', array_merge(request()->all(), ['role' => 'candidate'])) }}" class="shrink-0 pb-3 text-sm font-bold border-b-2 transition-colors {{ $roleFilter === 'candidate' ? 'border-accent-blue text-accent-blue' : 'border-transparent text-text-dark/50 hover:text-text-main' }}">Candidate Payments</a>
    <a href="{{ route('admin.transactions.index', array_merge(request()->all(), ['role' => 'parent'])) }}" class="shrink-0 pb-3 text-sm font-bold border-b-2 transition-colors {{ $roleFilter === 'parent' ? 'border-accent-blue text-accent-blue' : 'border-transparent text-text-dark/50 hover:text-text-main' }}">Parent Tuitions</a>
</div>

<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4">
    <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-3 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidate, email or transaction ID..." 
                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
        </div>
        <div class="w-full md:w-48">
            <select name="type" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2.5 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Types</option>
                <option value="registration_fee" {{ request('type') == 'registration_fee' ? 'selected' : '' }}>Registration Fee</option>
                <option value="placement_fee" {{ request('type') == 'placement_fee' ? 'selected' : '' }}>Placement Fee</option>
            </select>
        </div>
        <div class="w-full md:w-48">
            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2.5 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Statuses</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <button type="submit" class="bg-accent-blue text-white rounded-xl px-6 py-2.5 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors">
            Filter
        </button>
        @if(request()->anyFilled(['search', 'status', 'type']))
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center justify-center px-4 py-2 text-text-dark/40 hover:text-red-400 transition-colors text-sm font-bold">
                Clear
            </a>
        @endif
    </form>
</div>

<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-xl mb-6">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Candidate</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($transactions as $txn)
            <tr class="group hover:bg-secondary-bg/20 transition-colors">
                <td>
                    <div class="font-mono text-xs text-text-main font-bold">{{ $txn->transaction_id ?? 'N/A' }}</div>
                    @if($txn->gateway_response)
                        <div class="text-[10px] text-text-dark/40 truncate max-w-[150px]" title="{{ json_encode($txn->gateway_response) }}">View details log</div>
                    @endif
                </td>
                <td>
                    <div class="font-semibold text-text-main group-hover:text-accent-blue transition-colors">{{ $txn->candidate->name ?? 'Unknown' }}</div>
                    <div class="text-xs text-text-dark/50">{{ $txn->candidate->email ?? '' }}</div>
                </td>
                <td>
                    @if($txn->type === 'registration_fee')
                        <span class="text-xs font-semibold text-text-main">Registration Fee</span>
                    @else
                        <span class="text-xs font-semibold text-text-main">Placement Fee</span>
                    @endif
                </td>
                <td>
                    <div class="font-bold text-text-main">₹{{ number_format($txn->amount, 2) }}</div>
                </td>
                <td>
                    @if($txn->status === 'success')
                        <span class="bg-green-500/10 text-green-400 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-check-circle"></i> Success
                        </span>
                    @elseif($txn->status === 'failed')
                        <span class="bg-red-500/10 text-red-500 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1 w-max" title="{{ $txn->gateway_response['message'] ?? 'Payment Failed' }}">
                            <i class="fas fa-times-circle"></i> Failed
                        </span>
                    @else
                        <span class="bg-yellow-500/10 text-yellow-500 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-clock"></i> Pending
                        </span>
                    @endif
                </td>
                <td class="text-text-dark/60 text-sm">
                    {{ $txn->created_at->format('d M, Y h:i A') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-16 text-center">
                    <p class="text-text-main font-bold text-lg mb-1">No transactions found</p>
                    <p class="text-text-dark/40 text-sm">Try adjusting your filters.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($transactions->hasPages())
<div class="mt-4">
    {{ $transactions->links('pagination::tailwind') }}
</div>
@endif

@endsection
