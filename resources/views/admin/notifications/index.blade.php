@extends('layouts.admin')

@section('title', 'System Alerts & Notifications')
@section('subtitle', 'Real-time updates across School Jobs, Home Tuitions, Placement Fees, and Teacher Onboarding.')

@section('actions')
    <div class="flex items-center gap-2">
        @if($unreadCount > 0)
            <a href="{{ route('admin.notifications.mark-all-read') }}"
               class="px-4 py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                <i class="fas fa-check-double text-[11px]"></i> <span>Mark All Read ({{ $unreadCount }})</span>
            </a>
        @endif
        @if($readCount > 0)
            <form action="{{ route('admin.notifications.clear-read') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all read notifications?');">
                @csrf
                <button type="submit" class="px-3.5 py-2 bg-card-bg hover:bg-rose-50 border border-card-border hover:border-rose-200 text-text-dark/70 hover:text-rose-600 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                    <i class="fas fa-trash-alt text-[10px]"></i> <span>Clear Read</span>
                </button>
            </form>
        @endif
    </div>
@endsection

@section('content')

{{-- 1. Clickable Analytics Metric Filter Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    <!-- Card 1: Total Alerts -->
    <a href="{{ route('admin.notifications.index') }}" 
       class="bg-card-bg hover:border-accent-blue border {{ !request('status') && !request('category') ? 'border-accent-blue ring-1 ring-accent-blue' : 'border-card-border' }} rounded-2xl p-3.5 shadow-sm transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider">Total Alerts</span>
            <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-accent-blue flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-bell"></i>
            </div>
        </div>
        <div class="text-xl font-black text-text-main">{{ number_format($totalCount) }}</div>
        <span class="text-[10px] text-text-dark/40 font-semibold mt-0.5">All History</span>
    </a>

    <!-- Card 2: Unread (Action Required) -->
    <a href="{{ route('admin.notifications.index', ['status' => 'unread']) }}" 
       class="bg-card-bg hover:border-blue-400 border {{ request('status') === 'unread' ? 'border-accent-blue ring-1 ring-accent-blue' : 'border-card-border' }} rounded-2xl p-3.5 shadow-sm transition-all group flex flex-col justify-between relative overflow-hidden">
        @if($unreadCount > 0)
            <div class="absolute -right-2 -top-2 w-8 h-8 bg-blue-500/10 rounded-full blur-md"></div>
        @endif
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Unread</span>
            <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-accent-blue flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-circle-dot"></i>
            </div>
        </div>
        <div class="text-xl font-black text-accent-blue flex items-center gap-1.5">
            <span>{{ number_format($unreadCount) }}</span>
            @if($unreadCount > 0)
                <span class="w-2 h-2 rounded-full bg-accent-blue animate-ping"></span>
            @endif
        </div>
        <span class="text-[10px] text-blue-600/80 font-bold mt-0.5">Action Needed</span>
    </a>

    <!-- Card 3: Home Tuitions -->
    <a href="{{ route('admin.notifications.index', ['category' => 'tuition']) }}" 
       class="bg-card-bg hover:border-emerald-400 border {{ request('category') === 'tuition' ? 'border-emerald-500 ring-1 ring-emerald-500' : 'border-card-border' }} rounded-2xl p-3.5 shadow-sm transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Tuitions</span>
            <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="text-xl font-black text-emerald-600">{{ number_format($tuitionsCount) }}</div>
        <span class="text-[10px] text-text-dark/40 font-semibold mt-0.5">Leads & Tutors</span>
    </a>

    <!-- Card 4: School Jobs -->
    <a href="{{ route('admin.notifications.index', ['category' => 'job']) }}" 
       class="bg-card-bg hover:border-indigo-400 border {{ request('category') === 'job' ? 'border-indigo-500 ring-1 ring-indigo-500' : 'border-card-border' }} rounded-2xl p-3.5 shadow-sm transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider">School Jobs</span>
            <div class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-school"></i>
            </div>
        </div>
        <div class="text-xl font-black text-indigo-600">{{ number_format($jobsCount) }}</div>
        <span class="text-[10px] text-text-dark/40 font-semibold mt-0.5">Posts & Apps</span>
    </a>

    <!-- Card 5: Payments & Charges -->
    <a href="{{ route('admin.notifications.index', ['category' => 'payment']) }}" 
       class="bg-card-bg hover:border-cyan-400 border {{ request('category') === 'payment' ? 'border-cyan-500 ring-1 ring-cyan-500' : 'border-card-border' }} rounded-2xl p-3.5 shadow-sm transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-cyan-600 uppercase tracking-wider">Payments</span>
            <div class="w-7 h-7 rounded-lg bg-cyan-500/10 text-cyan-600 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
        <div class="text-xl font-black text-cyan-600">{{ number_format($paymentsCount) }}</div>
        <span class="text-[10px] text-text-dark/40 font-semibold mt-0.5">Service Charges</span>
    </a>

    <!-- Card 6: Candidates -->
    <a href="{{ route('admin.notifications.index', ['category' => 'candidate']) }}" 
       class="bg-card-bg hover:border-purple-400 border {{ request('category') === 'candidate' ? 'border-purple-500 ring-1 ring-purple-500' : 'border-card-border' }} rounded-2xl p-3.5 shadow-sm transition-all group flex flex-col justify-between">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Candidates</span>
            <div class="w-7 h-7 rounded-lg bg-purple-500/10 text-purple-600 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
        <div class="text-xl font-black text-purple-600">{{ number_format($candidatesCount) }}</div>
        <span class="text-[10px] text-text-dark/40 font-semibold mt-0.5">Registrations</span>
    </a>
</div>

{{-- 2. Search & Filter Bar --}}
<div class="bg-card-bg rounded-2xl border border-card-border p-4 mb-6 shadow-sm">
    <form method="GET" action="{{ route('admin.notifications.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
        <!-- Search -->
        <div class="lg:col-span-5 relative">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, tuition, job, or invoice..." 
                   class="w-full pl-9 pr-4 py-2 text-xs bg-secondary-bg border border-card-border rounded-xl text-text-main placeholder-text-dark/40 focus:ring-1 focus:ring-accent-blue outline-none">
        </div>

        <!-- Status Filter -->
        <div class="lg:col-span-2">
            <select name="status" class="w-full py-2 px-3 text-xs bg-secondary-bg border border-card-border rounded-xl text-text-main focus:ring-1 focus:ring-accent-blue outline-none">
                <option value="">All Status ({{ $totalCount }})</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread ({{ $unreadCount }})</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read ({{ $readCount }})</option>
            </select>
        </div>

        <!-- Category Filter -->
        <div class="lg:col-span-2">
            <select name="category" class="w-full py-2 px-3 text-xs bg-secondary-bg border border-card-border rounded-xl text-text-main focus:ring-1 focus:ring-accent-blue outline-none">
                <option value="">All Categories</option>
                <option value="tuition" {{ request('category') === 'tuition' ? 'selected' : '' }}>Home Tuitions ({{ $tuitionsCount }})</option>
                <option value="job" {{ request('category') === 'job' ? 'selected' : '' }}>School Jobs ({{ $jobsCount }})</option>
                <option value="payment" {{ request('category') === 'payment' ? 'selected' : '' }}>Payments & Dues ({{ $paymentsCount }})</option>
                <option value="candidate" {{ request('category') === 'candidate' ? 'selected' : '' }}>Candidates ({{ $candidatesCount }})</option>
            </select>
        </div>

        <!-- Order Filter -->
        <div class="lg:col-span-2">
            <select name="order" class="w-full py-2 px-3 text-xs bg-secondary-bg border border-card-border rounded-xl text-text-main focus:ring-1 focus:ring-accent-blue outline-none">
                <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Newest First</option>
                <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>Oldest First</option>
            </select>
        </div>

        <!-- Filter Submit & Reset -->
        <div class="lg:col-span-1 flex items-center gap-1.5">
            <button type="submit" class="w-full py-2 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center justify-center">
                <i class="fas fa-filter text-[10px]"></i>
            </button>
            @if(request('search') || request('status') || request('category') || request('order'))
                <a href="{{ route('admin.notifications.index') }}" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition-all" title="Reset Filters">
                    <i class="fas fa-undo text-[10px]"></i>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- 3. Notifications List Table / Stream --}}
<div class="bg-card-bg rounded-3xl border border-card-border shadow-sm overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-card-border bg-secondary-bg/30 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-xs font-black uppercase tracking-wider text-text-main">
                Feed: {{ $notifications->total() }} Alert{{ $notifications->total() === 1 ? '' : 's' }}
            </span>
            @if(request('status') === 'unread')
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-accent-blue border border-blue-200">Unread Only</span>
            @endif
        </div>
        <span class="text-xs text-text-dark/40">Showing {{ $notifications->firstItem() ?? 0 }}-{{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }}</span>
    </div>

    <div class="divide-y divide-card-border">
        @forelse($notifications as $notif)
            @php
                $title = $notif->data->title ?? 'System Notification';
                $message = $notif->data->message ?? '';
                $link = $notif->data->link ?? null;
                $customIcon = $notif->data->icon ?? null;
                
                // Smart Category Styling
                $isTuition = str_contains($notif->type, 'Tuition') || str_contains($title, 'Tuition') || str_contains($message, 'tuition') || str_contains($message, 'Tutor');
                $isJob = str_contains($notif->type, 'Job') || str_contains($title, 'Job') || str_contains($message, 'School') || str_contains($message, 'Teacher');
                $isPayment = str_contains($notif->type, 'Payment') || str_contains($notif->type, 'ServiceCharge') || str_contains($notif->type, 'LateFee') || str_contains($title, 'Service Charge') || str_contains($message, '₹');
                $isCandidate = str_contains($notif->type, 'Registration') || str_contains($title, 'Candidate');

                $iconColor = 'bg-blue-500/10 text-accent-blue border-blue-500/20';
                $iconClass = $customIcon ?? 'fas fa-bell';

                if ($isPayment) {
                    $iconColor = 'bg-cyan-500/10 text-cyan-600 border-cyan-500/20';
                    $iconClass = $customIcon ?? 'fas fa-wallet';
                } elseif ($isTuition) {
                    $iconColor = 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20';
                    $iconClass = $customIcon ?? 'fas fa-chalkboard-teacher';
                } elseif ($isJob) {
                    $iconColor = 'bg-indigo-500/10 text-indigo-600 border-indigo-500/20';
                    $iconClass = $customIcon ?? 'fas fa-school';
                } elseif ($isCandidate) {
                    $iconColor = 'bg-purple-500/10 text-purple-600 border-purple-500/20';
                    $iconClass = $customIcon ?? 'fas fa-user-check';
                }
            @endphp
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 sm:p-5 {{ $notif->read_at ? 'bg-card-bg opacity-75' : 'bg-blue-50/20 hover:bg-blue-50/40' }} hover:bg-secondary-bg/60 transition-all group">
                <!-- Left: Icon & Info -->
                <div class="flex items-start gap-3.5 min-w-0 flex-1">
                    <div class="w-10 h-10 rounded-2xl {{ $iconColor }} border flex items-center justify-center text-sm shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                        <i class="{{ $iconClass }}"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="text-xs sm:text-sm font-black text-text-main group-hover:text-accent-blue transition-colors">
                                {{ $title }}
                            </h4>
                            @if(!$notif->read_at)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase bg-blue-100 text-accent-blue border border-blue-200">
                                    New
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-text-dark/70 mt-1 leading-relaxed">{{ $message }}</p>
                        <div class="flex items-center gap-3 text-[11px] text-text-dark/40 mt-1.5">
                            <span class="flex items-center gap-1"><i class="fas fa-clock text-[10px]"></i> {{ \Carbon\Carbon::parse($notif->created_at)->format('d M Y, h:i A') }}</span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Action Buttons -->
                <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                    @if($link)
                        <a href="{{ $link }}" class="px-3 py-1.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1">
                            <span>Open</span> <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    @endif

                    @if(!$notif->read_at)
                        <a href="{{ route('admin.notifications.mark-read', $notif->id) }}" 
                           class="px-2.5 py-1.5 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-dark/70 hover:text-accent-blue rounded-xl text-xs font-bold transition-colors"
                           title="Mark as Read">
                            <i class="fas fa-check text-[10px]"></i>
                        </a>
                    @else
                        <a href="{{ route('admin.notifications.mark-unread', $notif->id) }}" 
                           class="px-2.5 py-1.5 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-dark/40 hover:text-text-main rounded-xl text-xs font-semibold transition-colors"
                           title="Mark as Unread">
                            <i class="fas fa-envelope text-[10px]"></i>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-16 text-center">
                <div class="w-14 h-14 bg-secondary-bg rounded-2xl flex items-center justify-center text-text-dark/20 text-2xl mx-auto mb-3 border border-card-border">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <p class="text-text-main font-bold text-base mb-1">No alerts found</p>
                <p class="text-text-dark/40 text-xs">There are no notifications matching your active filters.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="p-4 border-t border-card-border bg-secondary-bg/30">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

@endsection
