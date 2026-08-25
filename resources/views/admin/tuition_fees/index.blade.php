@extends('layouts.admin')

@section('title', 'Payment Collection Dashboard')
@section('subtitle', 'Track tuition fees, payment status, follow-ups & collections in real time.')

@section('actions')
    <div class="flex items-center gap-2.5">
        {{-- Send Daily Summary Email --}}
        <form action="{{ route('admin.tuition-fees.daily-summary') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200/70 px-4 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2 text-sm shadow-sm" title="Send daily summary email to all admins">
                <i class="fas fa-envelope text-indigo-500"></i> <span>Email Summary</span>
            </button>
        </form>
        <a href="{{ route('admin.tuition-fees.create') }}" class="bg-accent-blue hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2 text-sm shadow-md shadow-accent-blue/20">
            <i class="fas fa-plus"></i> <span>Add Account</span>
        </a>
    </div>
@endsection

@section('content')

<!-- Enhanced Dashboard Metrics -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 mb-6">
    <a href="{{ route('admin.tuition-fees.index', ['tab' => 'accounts']) }}" class="bg-white rounded-2xl shadow-sm border border-card-border p-4 hover:border-accent-blue/40 transition-all hover:shadow group">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-600 text-lg group-hover:scale-105 transition-transform"><i class="fas fa-users"></i></div>
            <div>
                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Active Tuitions</p>
                <h3 class="text-xl font-black text-text-main group-hover:text-accent-blue transition-colors">{{ $totalActiveAccounts }}</h3>
            </div>
        </div>
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-card-border p-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-green-500/10 flex items-center justify-center text-green-600 text-lg"><i class="fas fa-rupee-sign"></i></div>
            <div>
                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">This Month</p>
                <h3 class="text-lg font-black text-green-600">₹{{ number_format($collectedThisMonth) }}</h3>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.tuition-fees.index', ['payment_status' => 'pending', 'due_date' => date('Y-m-d')]) }}" class="bg-white rounded-2xl shadow-sm border border-card-border p-4 hover:border-amber-400 transition-all hover:shadow group">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-600 text-lg group-hover:scale-105 transition-transform"><i class="fas fa-clock"></i></div>
            <div>
                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Due Today</p>
                <h3 class="text-lg font-black text-amber-600">{{ $dueToday }} <span class="text-xs font-bold text-text-dark/40">(₹{{ number_format($dueTodayAmount) }})</span></h3>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.tuition-fees.index', ['payment_status' => 'overdue']) }}" class="bg-white rounded-2xl shadow-sm border border-card-border p-4 hover:border-red-400 transition-all hover:shadow group">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 text-lg group-hover:scale-105 transition-transform"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Overdue</p>
                <h3 class="text-lg font-black text-red-500">{{ $overdueCount }} <span class="text-xs font-bold text-text-dark/40">(₹{{ number_format($overdueAmount) }})</span></h3>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.tuition-fees.index', ['follow_up_filter' => 'today']) }}" class="bg-white rounded-2xl shadow-sm border border-card-border p-4 hover:border-indigo-400 transition-all hover:shadow group">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-600 text-lg group-hover:scale-105 transition-transform"><i class="fas fa-phone-alt"></i></div>
            <div>
                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Follow-Ups</p>
                <h3 class="text-lg font-black text-indigo-600">{{ $followUpTodayCount }} <span class="text-xs font-bold text-text-dark/40">(Today)</span></h3>
            </div>
        </div>
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-card-border p-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 text-lg"><i class="fas fa-bullseye"></i></div>
            <div>
                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Today Target</p>
                <h3 class="text-lg font-black text-emerald-600">₹{{ number_format($todayCollectionTarget) }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Tab Navigation -->
<div class="mb-0">
    <div class="flex border-b border-card-border overflow-x-auto bg-white/50 rounded-t-2xl px-2 pt-1">
        <button onclick="switchTab('today')" id="tab-today"
            class="tab-btn whitespace-nowrap px-5 py-3 text-sm font-bold border-b-2 border-transparent text-text-dark/50 hover:text-amber-600 -mb-px flex items-center gap-2 transition-all">
            <i class="fas fa-bell"></i> Today's Collections
            @if(($dueToday + $followUpTodayCount) > 0)
                <span class="bg-amber-500 text-white text-xs px-2 py-0.5 rounded-full font-bold shadow-xs">{{ $dueToday + $followUpTodayCount }}</span>
            @endif
        </button>
        <button onclick="switchTab('accounts')" id="tab-accounts"
            class="tab-btn whitespace-nowrap px-5 py-3 text-sm font-bold border-b-2 border-accent-blue text-accent-blue -mb-px flex items-center gap-2 transition-all">
            <i class="fas fa-users"></i> All Accounts
            <span class="bg-accent-blue/10 text-accent-blue text-xs px-2 py-0.5 rounded-full font-bold">{{ $accounts->total() }}</span>
        </button>
        <button onclick="switchTab('online')" id="tab-online"
            class="tab-btn whitespace-nowrap px-5 py-3 text-sm font-bold border-b-2 border-transparent text-text-dark/50 hover:text-green-600 -mb-px flex items-center gap-2 transition-all">
            <i class="fas fa-mobile-alt"></i> Online Payments
            <span class="bg-green-500/10 text-green-600 text-xs px-2 py-0.5 rounded-full font-bold">{{ $parentInvoicePayments->total() }}</span>
        </button>
        <button onclick="switchTab('history')" id="tab-history"
            class="tab-btn whitespace-nowrap px-5 py-3 text-sm font-bold border-b-2 border-transparent text-text-dark/50 hover:text-accent-blue -mb-px flex items-center gap-2 transition-all">
            <i class="fas fa-history"></i> Payment History
            <span class="bg-blue-500/10 text-blue-600 text-xs px-2 py-0.5 rounded-full font-bold">{{ $allPayments->total() }}</span>
        </button>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- Tab: TODAY'S COLLECTIONS (Due Today + Follow-Ups)       -->
<!-- ═══════════════════════════════════════════════════════ -->
<div id="panel-today" class="hidden bg-white rounded-b-2xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <div class="p-4 border-b border-card-border bg-gradient-to-r from-amber-50/80 via-orange-50/60 to-white flex flex-wrap gap-3 items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/30">
                <i class="fas fa-bell"></i>
            </div>
            <div>
                <h3 class="font-bold text-text-main">Today's Collections & Follow-Ups</h3>
                <p class="text-xs text-text-dark/50">Actions scheduled for today: {{ \Carbon\Carbon::today()->format('d M, Y (l)') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            {{-- Bulk Send Reminders --}}
            <form action="{{ route('admin.tuition-fees.bulk-reminders') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="reminder_type" value="all">
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm shadow-amber-500/20">
                    <i class="fas fa-envelope"></i> Email All Reminders
                </button>
            </form>
            <div class="bg-amber-500/10 border border-amber-500/20 px-3.5 py-1.5 rounded-xl">
                <span class="text-[10px] text-amber-600 font-bold uppercase mr-1">Target:</span>
                <span class="text-base font-black text-amber-600">₹{{ number_format($todayCollectionTarget) }}</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-bg/60 border-b border-card-border">
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Student & Parent</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Tuition Details</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Amount</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Type</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Follow-Up Notes</th>
                    <th class="px-5 py-3.5 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/50">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                @forelse($todayCollections as $acct)
                <tr class="hover:bg-amber-50/20 transition-colors">
                    <td class="px-5 py-3.5 align-top">
                        <a href="{{ route('admin.tuition-fees.show', $acct->id) }}" class="font-bold text-accent-blue hover:underline text-sm">{{ $acct->student_name }}</a>
                        <div class="text-xs text-text-dark/70 mt-0.5"><span class="text-text-dark/40">Parent:</span> {{ $acct->parent_name }}</div>
                        <div class="flex items-center gap-2 text-[11px] text-text-dark/60 mt-1">
                            <span><i class="fas fa-phone-alt text-[10px] mr-1"></i>{{ $acct->mobile_number }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 align-top">
                        <div class="text-xs font-bold text-text-main">{{ $acct->class ?? 'N/A' }} • {{ $acct->subject ?? 'N/A' }}</div>
                        <div class="text-[11px] text-text-dark/60 mt-1"><i class="fas fa-chalkboard-teacher text-[10px] mr-1"></i> {{ $acct->teacher_name ?? 'Not Assigned' }}</div>
                    </td>
                    <td class="px-5 py-3.5 align-top">
                        <span class="text-base font-black text-green-600">₹{{ number_format($acct->monthly_fee) }}</span>
                    </td>
                    <td class="px-5 py-3.5 align-top">
                        @if($acct->follow_up_date && \Carbon\Carbon::parse($acct->follow_up_date)->isToday())
                            <span class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-indigo-200 uppercase">📞 Follow-Up</span>
                        @else
                            <span class="bg-amber-50 text-amber-700 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-amber-200 uppercase">⏰ Due Today</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 align-top text-xs text-indigo-700 italic max-w-[200px]">
                        {{ $acct->follow_up_notes ?? '—' }}
                    </td>
                    <td class="px-5 py-3.5 align-top text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $acct->mobile_number) }}?text={{ urlencode('Namaskar ' . $acct->parent_name . ', Warriors Educare ki taraf se payment reminder: ' . $acct->student_name . ' ki tuition fee ₹' . number_format($acct->monthly_fee) . ' due hai. Kripya jald se jald payment karein. Dhanyavaad.') }}" target="_blank" class="w-8 h-8 rounded-lg bg-green-500/10 text-green-600 hover:bg-green-600 hover:text-white flex items-center justify-center transition-colors" title="WhatsApp Reminder">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <form action="{{ route('admin.tuition-fees.send-reminder', $acct->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors" title="Send Email Reminder">
                                    <i class="fas fa-envelope text-xs"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.tuition-fees.show', $acct->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-accent-blue/10 text-accent-blue hover:bg-accent-blue hover:text-white rounded-lg text-xs font-bold transition-colors whitespace-nowrap">
                                Manage <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-3 border border-green-200">
                            <i class="fas fa-check-circle text-2xl text-green-500"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">All Clear! 🎉</div>
                        <div class="text-xs text-text-dark/50">No payments due or follow-ups scheduled for today.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- Tab: ALL FEE ACCOUNTS                                    -->
<!-- ═══════════════════════════════════════════════════════ -->
<div id="panel-accounts" class="bg-white rounded-b-2xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <!-- Enhanced Filters -->
    <div class="p-4 border-b border-card-border bg-secondary-bg/40">
        <form action="{{ route('admin.tuition-fees.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[220px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search parent, student, mobile, teacher, class, notes..." class="w-full pl-9 pr-4 py-2 bg-white border border-card-border rounded-xl text-xs focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue shadow-xs">
                </div>
            </div>
            
            <div class="w-full sm:w-auto">
                <select name="payment_status" class="w-full bg-white border border-card-border rounded-xl text-xs px-3 py-2 focus:outline-none focus:border-accent-blue shadow-xs" onchange="this.form.submit()">
                    <option value="">All Payment Status</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>🟢 Paid</option>
                    <option value="overdue" {{ request('payment_status') === 'overdue' ? 'selected' : '' }}>🔴 Overdue</option>
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <select name="follow_up_filter" class="w-full bg-white border border-card-border rounded-xl text-xs px-3 py-2 focus:outline-none focus:border-accent-blue shadow-xs" onchange="this.form.submit()">
                    <option value="">All Follow-Ups</option>
                    <option value="today" {{ request('follow_up_filter') === 'today' ? 'selected' : '' }}>📞 Follow-Up Today</option>
                    <option value="has_followup" {{ request('follow_up_filter') === 'has_followup' ? 'selected' : '' }}>📅 Has Follow-Up Set</option>
                </select>
            </div>

            <div class="w-full sm:w-auto flex items-center gap-1.5">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase">DUE:</span>
                <input type="date" name="due_date" value="{{ request('due_date') }}" class="bg-white border border-card-border rounded-xl text-xs px-3 py-2 focus:outline-none focus:border-accent-blue shadow-xs" onchange="this.form.submit()">
            </div>
            
            @if(request('search') || request('payment_status') || request('due_date') || request('follow_up_filter'))
                <a href="{{ route('admin.tuition-fees.index') }}" class="text-xs font-bold text-red-500 hover:text-red-600 px-2">Clear</a>
            @endif
            
            <button type="submit" class="bg-accent-blue text-white px-4 py-2 rounded-xl font-bold text-xs hover:bg-blue-700 transition-colors ml-auto shadow-xs">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-bg/60 border-b border-card-border">
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Student & Parent</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Tuition Details</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Payment Status</th>
                    <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Follow-Up</th>
                    <th class="px-5 py-3.5 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/50">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                @forelse($accounts as $account)
                <tr class="hover:bg-secondary-bg/30 transition-colors {{ $account->status === 'inactive' ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3.5 align-top">
                        <a href="{{ route('admin.tuition-fees.show', $account->id) }}" class="font-bold text-accent-blue hover:underline text-sm">{{ $account->student_name }}</a>
                        <div class="text-xs text-text-dark/70 mt-0.5"><span class="text-text-dark/40">Parent:</span> {{ $account->parent_name }}</div>
                        <div class="flex items-center gap-3 text-[11px] text-text-dark/60 mt-1">
                            <span><i class="fas fa-phone-alt text-[10px] mr-1"></i>{{ $account->mobile_number }}</span>
                            @if($account->address)
                                <span class="max-w-[140px] truncate" title="{{ $account->address }}"><i class="fas fa-map-marker-alt text-[10px] mr-1"></i>{{ $account->address }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-3.5 align-top">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-text-main">{{ $account->class ?? 'N/A' }}</span>
                            <span class="text-text-dark/30">&bull;</span>
                            <span class="text-xs text-text-dark/80 truncate max-w-[130px]">{{ $account->subject ?? 'N/A' }}</span>
                        </div>
                        <div class="text-[11px] font-bold text-text-main mt-1">
                            Fee: <span class="text-green-600 font-extrabold">&#8377;{{ number_format($account->monthly_fee) }}/mo</span>
                        </div>
                        <div class="text-xs text-text-dark/70 mt-1 flex items-center gap-1">
                            <i class="fas fa-chalkboard-teacher text-[10px]"></i> 
                            {{ $account->teacher_name ?? 'Not Assigned' }}
                        </div>
                    </td>
                    <td class="px-5 py-3.5 align-top">
                        @if($account->status === 'inactive')
                            <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-gray-200 uppercase tracking-wider inline-block mb-1">INACTIVE</span>
                        @else
                            @php
                                $statusColors = [
                                    'paid' => 'bg-green-50 text-green-700 border-green-200',
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'overdue' => 'bg-red-50 text-red-700 border-red-200',
                                ];
                                $statusIcons = ['paid' => '✅', 'pending' => '🟡', 'overdue' => '🔴'];
                                $ps = $account->payment_status ?? 'pending';
                                $sc = $statusColors[$ps] ?? $statusColors['pending'];
                            @endphp
                            <span class="{{ $sc }} px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-wider inline-block mb-1">
                                {{ $statusIcons[$ps] ?? '' }} {{ strtoupper($ps) }}
                            </span>
                            @if($ps === 'overdue' && $account->days_overdue > 0)
                                <div class="text-[10px] font-bold text-red-500 mt-0.5">{{ $account->days_overdue }} days overdue</div>
                            @endif
                            <div class="text-xs font-bold {{ $ps === 'overdue' ? 'text-red-500' : 'text-text-main' }} mt-1">
                                Due: {{ $account->next_due_date ? $account->next_due_date->format('M d, Y') : 'N/A' }}
                                @if($account->next_due_date && $account->next_due_date->isToday())
                                    <span class="ml-1 text-[10px] bg-amber-500 text-white px-1.5 py-0.2 rounded font-bold">TODAY</span>
                                @endif
                            </div>
                            @if($account->last_paid_date)
                                <div class="text-[10px] text-text-dark/50 mt-0.5">Last paid: {{ $account->last_paid_date->format('d M Y') }}</div>
                            @endif
                        @endif
                    </td>
                    <td class="px-5 py-3.5 align-top">
                        @if($account->follow_up_date)
                            <div class="bg-indigo-50/80 border border-indigo-200/70 rounded-xl p-2.5 max-w-[190px]">
                                <div class="flex items-center justify-between gap-1 text-xs font-bold text-indigo-700">
                                    <span><i class="fas fa-calendar-check text-[10px] mr-1"></i>{{ \Carbon\Carbon::parse($account->follow_up_date)->format('d M, Y') }}</span>
                                    @if(\Carbon\Carbon::parse($account->follow_up_date)->isToday())
                                        <span class="bg-indigo-500 text-white text-[9px] px-1.5 py-0.2 rounded font-bold">TODAY</span>
                                    @endif
                                </div>
                                @if($account->follow_up_notes)
                                    <div class="text-[11px] text-indigo-600 mt-1 italic leading-tight">{{ Str::limit($account->follow_up_notes, 50) }}</div>
                                @endif
                            </div>
                        @else
                            <button onclick="openFollowUpModal({{ $account->id }}, '{{ addslashes($account->student_name) }}')" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-1.5 hover:underline cursor-pointer bg-indigo-50/60 px-2.5 py-1 rounded-lg border border-indigo-100">
                                <i class="fas fa-plus-circle text-[10px]"></i> Set Follow-Up
                            </button>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 align-top text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $account->mobile_number) }}?text={{ urlencode('Namaskar ' . $account->parent_name . ', Warriors Educare ki taraf se reminder: ' . $account->student_name . ' ki tuition fee ₹' . number_format($account->monthly_fee) . ' due hai. Dhanyavaad.') }}" target="_blank" class="w-8 h-8 rounded-lg bg-green-500/10 text-green-600 hover:bg-green-600 hover:text-white flex items-center justify-center transition-colors" title="WhatsApp">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="{{ route('admin.tuition-fees.show', $account->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-accent-blue/10 text-accent-blue hover:bg-accent-blue hover:text-white rounded-lg text-xs font-bold transition-colors whitespace-nowrap">
                                Manage <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-3 border border-card-border shadow-inner">
                            <i class="fas fa-folder-open text-2xl text-text-dark/30"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Accounts Found</div>
                        <div class="text-xs text-text-dark/50">Try adjusting your filters or add a new fee account.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($accounts->hasPages())
    <div class="p-4 border-t border-card-border">
        {{ $accounts->links('pagination::tailwind') }}
    </div>
    @endif
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- Tab: PAYMENT HISTORY                                     -->
<!-- ═══════════════════════════════════════════════════════ -->
<div id="panel-history" class="hidden bg-white rounded-b-2xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <div class="p-4 border-b border-card-border bg-secondary-bg/40 flex flex-wrap gap-3 items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-history text-green-500 text-lg"></i>
            <div>
                <h3 class="font-bold text-text-main">Complete Payment History</h3>
                <p class="text-xs text-text-dark/50">All tuition fee payments recorded in the system</p>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="bg-green-500/10 border border-green-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-green-600 font-bold uppercase">Total Collected</p>
                <p class="text-lg font-black text-green-600">&#8377;{{ number_format($totalPaymentsAmount) }}</p>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-blue-600 font-bold uppercase">Total Records</p>
                <p class="text-lg font-black text-blue-600">{{ $allPayments->total() }}</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-bg/60 border-b border-card-border">
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">#</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Payment Date</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Student</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Parent</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Amount</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Mode</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Collected By</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Remarks</th>
                    <th class="px-5 py-3 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/50">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                @forelse($allPayments as $payment)
                <tr class="hover:bg-green-50/40 transition-colors">
                    <td class="px-5 py-3 align-middle text-xs text-text-dark/40 font-bold">{{ $allPayments->firstItem() + $loop->index }}</td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-sm font-bold text-text-main">{{ $payment->payment_date->format('d M, Y') }}</div>
                        <div class="text-[10px] text-text-dark/40">Recorded: {{ $payment->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        @if($payment->account)
                        <a href="{{ route('admin.tuition-fees.show', $payment->account->id) }}" class="font-bold text-accent-blue hover:underline text-sm">{{ $payment->account->student_name }}</a>
                        <div class="text-[10px] text-text-dark/50">{{ $payment->account->class ?? '' }}</div>
                        @else
                        <span class="text-text-dark/40">N/A</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-sm text-text-main font-semibold">{{ $payment->account->parent_name ?? 'N/A' }}</div>
                        <div class="text-[10px] text-text-dark/50">{{ $payment->account->mobile_number ?? '' }}</div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <span class="text-base font-black text-green-600">&#8377;{{ number_format($payment->amount) }}</span>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        @php
                            $modeColors = [
                                'Cash' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'UPI' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'Bank' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Other' => 'bg-gray-50 text-gray-700 border-gray-200',
                            ];
                        @endphp
                        <span class="text-xs {{ $modeColors[$payment->payment_mode] ?? 'bg-gray-50 text-gray-700 border-gray-200' }} px-2.5 py-1 rounded-lg border font-bold">
                            {{ $payment->payment_mode }}
                        </span>
                    </td>
                    <td class="px-5 py-3 align-middle text-sm text-text-dark/70">
                        {{ $payment->collected_by ?? '—' }}
                    </td>
                    <td class="px-5 py-3 align-middle text-xs text-text-dark/60 italic max-w-[150px]">
                        {{ $payment->remarks ?? '—' }}
                    </td>
                    <td class="px-5 py-3 align-middle text-right">
                        @if($payment->account)
                        <a href="{{ route('admin.tuition-fees.show', $payment->account->id) }}" class="inline-flex items-center gap-1 text-accent-blue hover:underline text-xs font-bold">
                            View <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-3 border border-card-border">
                            <i class="fas fa-receipt text-2xl text-text-dark/30"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Payment Records Found</div>
                        <div class="text-xs text-text-dark/50">Record a payment from any Fee Account to see history here.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($allPayments->hasPages())
    <div class="p-4 border-t border-card-border">
        {{ $allPayments->appends(['tab' => 'history'])->links('pagination::tailwind') }}
    </div>
    @endif
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- Tab: PARENT ONLINE PAYMENTS                              -->
<!-- ═══════════════════════════════════════════════════════ -->
<div id="panel-online" class="hidden bg-white rounded-b-2xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <div class="p-4 border-b border-card-border bg-green-50/50 flex flex-wrap gap-3 items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-500 text-white flex items-center justify-center shadow-md shadow-green-500/30">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div>
                <h3 class="font-bold text-text-main">Parent Online Service Charge Payments</h3>
                <p class="text-xs text-text-dark/50">Payments made by parents via Payment Gateway for Home Tuition Service</p>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="bg-green-500/10 border border-green-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-green-600 font-bold uppercase">Total Collected</p>
                <p class="text-lg font-black text-green-600">&#8377;{{ number_format($totalInvoiceAmount) }}</p>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-blue-600 font-bold uppercase">Paid Invoices</p>
                <p class="text-lg font-black text-blue-600">{{ $parentInvoicePayments->total() }}</p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-bg/60 border-b border-card-border">
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">#</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Invoice #</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Paid On</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Parent</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Lead / Location</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Service</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Amount</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                @forelse($parentInvoicePayments as $inv)
                <tr class="hover:bg-green-50/40 transition-colors">
                    <td class="px-5 py-3 align-middle text-xs text-text-dark/40 font-bold">{{ $parentInvoicePayments->firstItem() + $loop->index }}</td>
                    <td class="px-5 py-3 align-middle">
                        <span class="font-mono text-xs font-bold text-accent-blue">{{ $inv->invoice_number }}</span>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-sm font-bold text-text-main">{{ $inv->updated_at->format('d M, Y') }}</div>
                        <div class="text-[10px] text-text-dark/40">{{ $inv->updated_at->format('H:i A') }}</div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="font-bold text-text-main text-sm">{{ $inv->user->name ?? 'N/A' }}</div>
                        <div class="text-[10px] text-text-dark/50">{{ $inv->user->phone ?? $inv->user->email ?? '' }}</div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        @if($inv->lead)
                        <div class="text-sm text-text-main font-semibold">{{ $inv->lead->parent_name }}</div>
                        <div class="text-[10px] text-text-dark/50">{{ $inv->lead->location ?? '' }}</div>
                        @else
                        <span class="text-text-dark/30">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-xs text-text-main">{{ $inv->title }}</div>
                        @if($inv->notes)
                        <div class="text-[10px] text-text-dark/40 italic">{{ Str::limit($inv->notes, 30) }}</div>
                        @endif
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <span class="text-base font-black text-green-600">&#8377;{{ number_format($inv->amount) }}</span>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                            PAID
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-3 border border-card-border">
                            <i class="fas fa-mobile-alt text-2xl text-text-dark/30"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Online Payments Yet</div>
                        <div class="text-xs text-text-dark/50">When parents pay invoices online, they will appear here.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($parentInvoicePayments->hasPages())
    <div class="p-4 border-t border-card-border">
        {{ $parentInvoicePayments->appends(['tab' => 'online'])->links('pagination::tailwind') }}
    </div>
    @endif
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- FOLLOW-UP MODAL                                          -->
<!-- ═══════════════════════════════════════════════════════ -->
<div id="followup-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-[fadeIn_0.2s_ease-out]">
        <div class="px-6 py-4 border-b border-card-border flex justify-between items-center bg-indigo-50">
            <h3 class="font-black text-text-main flex items-center gap-2"><i class="fas fa-calendar-check text-indigo-500"></i> Set Follow-Up</h3>
            <button onclick="closeFollowUpModal()" class="text-text-dark/40 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="followup-form" method="POST" class="p-6">
            @csrf
            
            <div class="bg-blue-50 text-accent-blue p-3 rounded-xl mb-5 text-xs">
                <i class="fas fa-info-circle mr-1"></i> Setting a follow-up for: <strong id="followup-student-name"></strong>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Follow-Up Date <span class="text-red-500">*</span></label>
                    <input type="date" name="follow_up_date" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Notes (What parent said?)</label>
                    <textarea name="follow_up_notes" rows="3" placeholder="e.g. Parent said will pay after 4 days, salary date on 5th..."
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"></textarea>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-card-border flex justify-end gap-2">
                <button type="button" onclick="closeFollowUpModal()" class="px-4 py-2 rounded-xl font-bold text-xs text-text-dark/60 hover:bg-secondary-bg transition-colors">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-xl font-bold text-xs hover:bg-indigo-700 transition-colors shadow-sm">Set Follow-Up</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tab) {
        ['today', 'accounts', 'online', 'history'].forEach(function(t) {
            var panel = document.getElementById('panel-' + t);
            if (panel) panel.classList.add('hidden');
        });
        
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.classList.remove('border-accent-blue', 'text-accent-blue', 'border-green-500', 'text-green-600', 'border-amber-500', 'text-amber-600');
            btn.classList.add('border-transparent', 'text-text-dark/50');
        });
        
        var panel = document.getElementById('panel-' + tab);
        if (panel) panel.classList.remove('hidden');
        var activeBtn = document.getElementById('tab-' + tab);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-text-dark/50');
            if (tab === 'online') {
                activeBtn.classList.add('border-green-500', 'text-green-600');
            } else if (tab === 'today') {
                activeBtn.classList.add('border-amber-500', 'text-amber-600');
            } else {
                activeBtn.classList.add('border-accent-blue', 'text-accent-blue');
            }
        }
    }

    function openFollowUpModal(accountId, studentName) {
        document.getElementById('followup-form').action = '/admin/tuition-fees/' + accountId + '/follow-up';
        document.getElementById('followup-student-name').textContent = studentName;
        document.getElementById('followup-modal').classList.remove('hidden');
    }

    function closeFollowUpModal() {
        document.getElementById('followup-modal').classList.add('hidden');
    }

    // Auto-switch to tab if requested via URL param
    @if(request('tab') === 'history')
        switchTab('history');
    @elseif(request('tab') === 'online')
        switchTab('online');
    @elseif(request('tab') === 'today')
        switchTab('today');
    @endif
</script>

@endsection
