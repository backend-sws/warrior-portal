@extends('layouts.admin')

@section('title', 'Welcome back, ' . (auth()->user()->name ?? 'Admin'))
@section('subtitle', 'Operations Command • Real-time overview of school jobs, home tuitions, applications, and collections.')

@section('actions')
    <!-- Date Filter Form in Page Header -->
    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-card-bg p-1.5 rounded-2xl border border-card-border shadow-sm">
        <div class="flex items-center gap-1.5 px-2.5 border-r border-card-border">
            <i class="fas fa-calendar-alt text-text-dark/40 text-xs"></i>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="bg-transparent border-none text-xs text-text-main outline-none focus:ring-0 w-28">
        </div>
        <div class="flex items-center gap-1.5 px-2.5">
            <span class="text-text-dark/40 text-xs">to</span>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="bg-transparent border-none text-xs text-text-main outline-none focus:ring-0 w-28">
        </div>
        <button type="submit" class="bg-accent-blue hover:bg-blue-700 text-white px-3.5 py-1.5 rounded-xl flex items-center gap-1.5 text-xs font-bold transition-colors shadow-sm">
            <i class="fas fa-filter text-[10px]"></i> <span>Filter</span>
        </button>
        @if(request('from_date') || request('to_date'))
            <a href="{{ route('admin.dashboard') }}" class="text-red-500 hover:text-red-700 px-2 py-1 bg-red-50 rounded-lg text-xs font-bold transition-colors" title="Clear Filter">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </form>
@endsection

@section('content')

{{-- PAYMENT COLLECTION ALERT BANNER --}}
@if(($feeDueToday + $feeOverdueCount + $feeFollowUpToday) > 0)
<div class="mb-6 bg-gradient-to-r from-amber-50 via-orange-50 to-red-50 border border-amber-200/70 rounded-2xl p-5 shadow-sm relative overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30">
                    <i class="fas fa-bell text-sm animate-pulse"></i>
                </div>
                <h3 class="text-lg font-black text-[#031b4e]">Today's Payment Alerts</h3>
            </div>
            <div class="flex flex-wrap items-center gap-4 text-sm">
                @if($feeDueToday > 0)
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span class="font-bold text-amber-700">{{ $feeDueToday }} payments due today</span>
                    <span class="text-amber-600 font-black">(₹{{ number_format($feeDueTodayAmount) }})</span>
                </div>
                @endif
                @if($feeOverdueCount > 0)
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span class="font-bold text-red-600">{{ $feeOverdueCount }} overdue</span>
                    <span class="text-red-500 font-black">(₹{{ number_format($feeOverdueAmount) }})</span>
                </div>
                @endif
                @if($feeFollowUpToday > 0)
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span class="font-bold text-indigo-600">{{ $feeFollowUpToday }} follow-up collections today</span>
                </div>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.tuition-fees.index', ['tab' => 'today']) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-lg shadow-amber-500/30 flex items-center gap-1.5 whitespace-nowrap">
                <i class="fas fa-rupee-sign"></i> View Collections <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
@endif

{{-- 1. Primary KPI Metric Cards (Clean, Clickable, No Duplicate Hero Box) --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Card 1: School Jobs -->
    <a href="{{ route('admin.jobs.index') }}" class="bg-card-bg hover:border-blue-300 border border-card-border rounded-2xl p-5 shadow-sm transition-all group flex flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors pointer-events-none"></div>
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-text-dark/60">School Jobs</span>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black tracking-tight text-blue-600">{{ number_format($activeJobs) }}</h3>
            <span class="text-xs text-text-dark/50 font-medium">Live Active Postings</span>
        </div>
        <div class="mt-4 pt-3 border-t border-card-border flex items-center justify-between text-xs text-text-dark/60">
            <span>{{ $totalJobs }} Total Jobs</span>
            @if($pendingJobsCount > 0)
                <span class="bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full text-[10px] border border-amber-200">{{ $pendingJobsCount }} Pending</span>
            @endif
        </div>
    </a>
    
    <!-- Card 2: Home Tuitions -->
    <a href="{{ route('admin.tuition-leads.index') }}" class="bg-card-bg hover:border-emerald-300 border border-card-border rounded-2xl p-5 shadow-sm transition-all group flex flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors pointer-events-none"></div>
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-text-dark/60">Home Tuitions</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black tracking-tight text-emerald-600">{{ number_format($activeTuitions) }}</h3>
            <span class="text-xs text-text-dark/50 font-medium">Live on Website</span>
        </div>
        <div class="mt-4 pt-3 border-t border-card-border flex items-center justify-between text-xs text-text-dark/60">
            <span>{{ $assignedTuitions }} Tutors Assigned</span>
            @if($pendingTuitionsCount > 0)
                <span class="bg-yellow-100 text-yellow-800 font-bold px-2 py-0.5 rounded-full text-[10px] border border-yellow-200">{{ $pendingTuitionsCount }} New</span>
            @endif
        </div>
    </a>
    
    <!-- Card 3: Candidates CRM -->
    <a href="{{ route('admin.crm.index') }}" class="bg-card-bg hover:border-purple-300 border border-card-border rounded-2xl p-5 shadow-sm transition-all group flex flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-xl group-hover:bg-purple-500/10 transition-colors pointer-events-none"></div>
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-text-dark/60">Candidates Pool</span>
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black tracking-tight text-purple-600">{{ number_format($totalCandidates) }}</h3>
            <span class="text-xs text-text-dark/50 font-medium">Registered Pool</span>
        </div>
        <div class="mt-4 pt-3 border-t border-card-border flex items-center justify-between text-xs text-text-dark/60">
            <span>{{ $signedCandidates }} Signed</span>
            <span class="text-emerald-600 font-bold">{{ $verifiedCandidates }} Verified</span>
        </div>
    </a>
    
    <!-- Card 4: Platform Collections -->
    <a href="{{ route('admin.tuition-service-charges.index') }}" class="bg-card-bg hover:border-cyan-300 border border-card-border rounded-2xl p-5 shadow-sm transition-all group flex flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/5 rounded-full blur-xl group-hover:bg-cyan-500/10 transition-colors pointer-events-none"></div>
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-text-dark/60">Total Collections</span>
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black tracking-tight text-cyan-600">₹{{ number_format($totalRevenue) }}</h3>
            <span class="text-xs text-text-dark/50 font-medium">Service Fees & Direct</span>
        </div>
        <div class="mt-4 pt-3 border-t border-card-border flex items-center justify-between text-xs text-text-dark/60">
            <span>₹{{ number_format($pendingDues) }} Dues</span>
            @if($overdueInvoicesCount > 0)
                <span class="bg-rose-100 text-rose-700 font-bold px-2 py-0.5 rounded-full text-[10px] border border-rose-200">{{ $overdueInvoicesCount }} Overdue</span>
            @endif
        </div>
    </a>
</div>

{{-- 2. Dual Operations Row: School Jobs vs Home Tuitions Operations --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- School Jobs Pipeline Module --}}
    <div class="bg-card-bg rounded-3xl p-6 border border-card-border shadow-sm flex flex-col justify-between relative overflow-hidden">
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 text-accent-blue flex items-center justify-center text-lg font-bold">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3 class="font-black text-text-main text-base">School Jobs Pipeline</h3>
                    <p class="text-xs text-text-dark/50">Hiring metrics and school placements</p>
                </div>
            </div>
            <a href="{{ route('admin.jobs.index') }}" class="text-xs font-bold text-accent-blue hover:underline">View Jobs &rarr;</a>
        </div>

        <div class="grid grid-cols-3 gap-3 mb-4">
            <div class="bg-secondary-bg p-3.5 rounded-2xl border border-card-border text-center">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-0.5">Applications</span>
                <span class="text-xl font-black text-text-main">{{ number_format($totalJobApps) }}</span>
                <span class="text-[10px] text-accent-blue block font-bold mt-0.5">Submitted</span>
            </div>
            <div class="bg-secondary-bg p-3.5 rounded-2xl border border-card-border text-center">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-0.5">Forwarded</span>
                <span class="text-xl font-black text-indigo-600">{{ number_format($forwardedJobApps) }}</span>
                <span class="text-[10px] text-indigo-600 block font-bold mt-0.5">To Schools</span>
            </div>
            <div class="bg-secondary-bg p-3.5 rounded-2xl border border-card-border text-center">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-0.5">Placements</span>
                <span class="text-xl font-black text-emerald-600">{{ number_format($hiredPlacements) }}</span>
                <span class="text-[10px] text-emerald-600 block font-bold mt-0.5">Hired Teachers</span>
            </div>
        </div>

        @if($pendingJobsCount > 0)
            <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-3.5 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-exclamation-circle text-amber-500 text-sm"></i>
                    <span class="text-xs font-bold text-amber-800">{{ $pendingJobsCount }} School Job(s) awaiting approval</span>
                </div>
                <a href="{{ route('admin.jobs.index', ['status' => 'pending']) }}" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                    Review Now
                </a>
            </div>
        @endif
    </div>

    {{-- Home Tuitions Pipeline Module --}}
    <div class="bg-card-bg rounded-3xl p-6 border border-card-border shadow-sm flex flex-col justify-between relative overflow-hidden">
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg font-bold">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h3 class="font-black text-text-main text-base">Home Tuitions Ecosystem</h3>
                    <p class="text-xs text-text-dark/50">Private tutoring leads & tutor assignments</p>
                </div>
            </div>
            <a href="{{ route('admin.tuition-leads.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">View Tuitions &rarr;</a>
        </div>

        <div class="grid grid-cols-3 gap-3 mb-4">
            <div class="bg-secondary-bg p-3.5 rounded-2xl border border-card-border text-center">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-0.5">Total Inquiries</span>
                <span class="text-xl font-black text-text-main">{{ number_format($totalTuitions) }}</span>
                <span class="text-[10px] text-text-dark/40 block font-bold mt-0.5">Parent Demands</span>
            </div>
            <div class="bg-secondary-bg p-3.5 rounded-2xl border border-card-border text-center">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-0.5">Applications</span>
                <span class="text-xl font-black text-sky-600">{{ number_format($totalTuitionApps) }}</span>
                <span class="text-[10px] text-sky-600 block font-bold mt-0.5">Tutor Requests</span>
            </div>
            <div class="bg-secondary-bg p-3.5 rounded-2xl border border-card-border text-center">
                <span class="text-[10px] font-bold text-text-dark/50 uppercase block mb-0.5">Assigned Tutors</span>
                <span class="text-xl font-black text-emerald-600">{{ number_format($assignedTuitions) }}</span>
                <span class="text-[10px] text-emerald-600 block font-bold mt-0.5">Confirmed</span>
            </div>
        </div>

        @if($pendingTuitionsCount > 0)
            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-2xl p-3.5 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-clock text-yellow-600 text-sm"></i>
                    <span class="text-xs font-bold text-yellow-800">{{ $pendingTuitionsCount }} Tuition Requirement(s) need review</span>
                </div>
                <a href="{{ route('admin.tuition-leads.index', ['status' => 'New Lead']) }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-slate-900 rounded-lg text-xs font-bold transition-all shadow-sm">
                    Approve Live
                </a>
            </div>
        @endif
    </div>
</div>

{{-- 3. Revenue Analytics & Live Activity Stream --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    
    <!-- Left 2 Cols: Revenue Graph & Breakdown -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-card-bg rounded-3xl p-6 sm:p-7 shadow-sm border border-card-border flex-1">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-3">
                <div>
                    <h3 class="font-black text-text-main text-lg flex items-center gap-2">
                        <i class="fas fa-chart-line text-accent-blue"></i> Platform Revenue & Collections
                    </h3>
                    <p class="text-text-dark/50 text-xs mt-0.5">Track placement commissions, tuition service charges, and payments</p>
                </div>
                <div class="flex bg-secondary-bg p-1 rounded-xl border border-card-border self-start">
                    <button type="button" onclick="updateChart('days')" id="btn-chart-days" class="px-3.5 py-1.5 text-xs font-bold rounded-lg bg-accent-blue text-white shadow-sm transition-all">Last 30 Days</button>
                    <button type="button" onclick="updateChart('months')" id="btn-chart-months" class="px-3.5 py-1.5 text-xs font-bold rounded-lg text-text-dark/60 hover:text-text-main transition-all">Monthly View</button>
                </div>
            </div>
            
            <div class="w-full h-[280px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Financial Breakdown Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
             <div class="bg-card-bg rounded-2xl p-4 border border-card-border shadow-sm flex items-center gap-3.5">
                 <div class="w-11 h-11 rounded-2xl bg-blue-500/10 text-accent-blue flex items-center justify-center text-lg shrink-0"><i class="fas fa-school"></i></div>
                 <div>
                     <span class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider block">Job Placement Fees</span>
                     <h4 class="font-black text-text-main text-lg">₹{{ number_format($jobServiceRevenue) }}</h4>
                 </div>
             </div>
             <div class="bg-card-bg rounded-2xl p-4 border border-card-border shadow-sm flex items-center gap-3.5">
                 <div class="w-11 h-11 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-lg shrink-0"><i class="fas fa-chalkboard-teacher"></i></div>
                 <div>
                     <span class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider block">Tuition Charges</span>
                     <h4 class="font-black text-emerald-600 text-lg">₹{{ number_format($tuitionServiceRevenue) }}</h4>
                 </div>
             </div>
             <div class="bg-card-bg rounded-2xl p-4 border border-card-border shadow-sm flex items-center gap-3.5">
                 <div class="w-11 h-11 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-lg shrink-0"><i class="fas fa-file-invoice-dollar"></i></div>
                 <div>
                     <span class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider block">Pending Dues</span>
                     <h4 class="font-black text-amber-600 text-lg">₹{{ number_format($pendingDues) }}</h4>
                 </div>
             </div>
        </div>
    </div>
    
    <!-- Right Col: Real-time Live Activity Feed -->
    <div class="bg-card-bg rounded-3xl p-6 shadow-sm border border-card-border flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-black text-text-main text-base">Real-time Activity</h3>
            <span class="text-[10px] text-emerald-600 bg-emerald-500/10 px-2.5 py-1 rounded-full font-bold flex items-center gap-1.5 uppercase tracking-wide border border-emerald-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Live Stream
            </span>
        </div>
        
        <div class="space-y-4 flex-1 overflow-y-auto max-h-[420px] pr-2 custom-scrollbar">
            @forelse($activityFeed as $act)
            <a href="{{ $act['link'] }}" class="flex gap-3 p-3 bg-secondary-bg/60 hover:bg-secondary-bg rounded-2xl border border-card-border transition-all group">
                <div class="w-9 h-9 rounded-xl {{ $act['badge_color'] }} flex items-center justify-center shrink-0 text-sm shadow-sm">
                    <i class="{{ $act['icon'] }}"></i>
                </div>
                
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-text-main leading-tight group-hover:text-accent-blue transition-colors truncate">
                        {{ $act['title'] }}
                    </p>
                    <p class="text-[11px] text-text-dark/60 truncate mt-0.5">{{ $act['subtitle'] }}</p>
                    <span class="text-[10px] text-text-dark/40 mt-1 block">{{ \Carbon\Carbon::parse($act['time'])->diffForHumans() }}</span>
                </div>
            </a>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-inbox text-3xl text-text-dark/20 mb-2"></i>
                <p class="text-xs text-text-dark/50">No recent activity logged.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4 pt-3 border-t border-card-border text-center">
            <a href="{{ route('admin.applications.index') }}" class="text-accent-blue text-xs font-bold hover:underline">
                View All Activity Logs &rarr;
            </a>
        </div>
    </div>
</div>

{{-- 4. Quick Action Command Hub & Urgent Approvals --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Quick Actions Cards -->
    <div class="lg:col-span-1">
        <h3 class="font-black text-text-main text-base mb-4 flex items-center gap-2">
            <i class="fas fa-bolt text-amber-500"></i> Quick Actions
        </h3>
        <div class="grid grid-cols-2 gap-3">
             <a href="{{ route('admin.jobs.create') }}" class="bg-accent-blue hover:bg-blue-700 rounded-2xl p-4 text-white shadow-sm transition-all group flex flex-col justify-between">
                 <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center mb-2 text-sm"><i class="fas fa-plus"></i></div>
                 <div>
                     <h4 class="font-bold text-sm">Post Job</h4>
                     <p class="text-blue-100 text-[10px]">New school listing</p>
                 </div>
             </a>
             
             <a href="{{ route('admin.tuition-leads.create') }}" class="bg-emerald-600 hover:bg-emerald-700 rounded-2xl p-4 text-white shadow-sm transition-all group flex flex-col justify-between">
                 <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center mb-2 text-sm"><i class="fas fa-chalkboard-teacher"></i></div>
                 <div>
                     <h4 class="font-bold text-sm">Add Tuition</h4>
                     <p class="text-emerald-100 text-[10px]">Parent requirement</p>
                 </div>
             </a>
             
             <a href="{{ route('admin.crm.create') }}" class="bg-purple-600 hover:bg-purple-700 rounded-2xl p-4 text-white shadow-sm transition-all group flex flex-col justify-between">
                 <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center mb-2 text-sm"><i class="fas fa-user-plus"></i></div>
                 <div>
                     <h4 class="font-bold text-sm">Onboard Teacher</h4>
                     <p class="text-purple-100 text-[10px]">Manual candidate</p>
                 </div>
             </a>
             
             <a href="{{ route('admin.reminders.index') }}" class="bg-amber-600 hover:bg-amber-700 rounded-2xl p-4 text-white shadow-sm transition-all group flex flex-col justify-between">
                 <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center mb-2 text-sm"><i class="fas fa-bell"></i></div>
                 <div>
                     <h4 class="font-bold text-sm">Reminders</h4>
                     <p class="text-amber-100 text-[10px]">Fee followups</p>
                 </div>
             </a>
        </div>
    </div>
    
    <!-- Urgent Approvals Lists -->
    <div class="lg:col-span-2 bg-card-bg rounded-3xl p-6 shadow-sm border border-card-border">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-black text-text-main text-base flex items-center gap-2">
                <i class="fas fa-clipboard-check text-indigo-600"></i> Pending Review Hub
            </h3>
            <span class="text-xs text-text-dark/50 font-bold">Requires Admin Decision</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Pending Jobs Box -->
            <div class="bg-secondary-bg p-4 rounded-2xl border border-card-border">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-text-main flex items-center gap-1.5"><i class="fas fa-school text-accent-blue"></i> Pending Jobs</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-accent-blue/10 text-accent-blue rounded-full">{{ $pendingJobsList->count() }} Waiting</span>
                </div>
                <div class="space-y-2">
                    @forelse($pendingJobsList as $pJob)
                        <div class="p-2.5 bg-card-bg rounded-xl border border-card-border flex items-center justify-between text-xs">
                            <div class="truncate mr-2">
                                <span class="font-bold text-text-main block truncate">{{ $pJob->title }}</span>
                                <span class="text-[10px] text-text-dark/50">{{ $pJob->school_name }} • {{ $pJob->city->name ?? '' }}</span>
                            </div>
                            <a href="{{ route('admin.jobs.show', $pJob->id) }}" class="px-2.5 py-1 bg-accent-blue hover:bg-blue-700 text-white rounded-lg text-[10px] font-bold shrink-0 transition-colors">
                                Review
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-text-dark/40 py-4 text-center">All jobs approved! No pending jobs.</p>
                    @endforelse
                </div>
            </div>

            <!-- Pending Tuitions Box -->
            <div class="bg-secondary-bg p-4 rounded-2xl border border-card-border">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-text-main flex items-center gap-1.5"><i class="fas fa-chalkboard-teacher text-emerald-600"></i> Pending Tuitions</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-emerald-500/10 text-emerald-600 rounded-full">{{ $pendingTuitionsList->count() }} Waiting</span>
                </div>
                <div class="space-y-2">
                    @forelse($pendingTuitionsList as $pTui)
                        <div class="p-2.5 bg-card-bg rounded-xl border border-card-border flex items-center justify-between text-xs">
                            <div class="truncate mr-2">
                                <span class="font-bold text-text-main block truncate">Class {{ $pTui->class }} ({{ $pTui->subjects }})</span>
                                <span class="text-[10px] text-text-dark/50">{{ $pTui->location }} • {{ $pTui->parent_name }}</span>
                            </div>
                            <form action="{{ route('admin.tuition-leads.approve', $pTui->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[10px] font-bold shrink-0 transition-colors">
                                    Approve
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-text-dark/40 py-4 text-center">All tuition leads approved! Clean state.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.4); 
        border-radius: 4px;
    }
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($chartData);
    let currentChart = null;

    function updateChart(period) {
        const btnDays = document.getElementById('btn-chart-days');
        const btnMonths = document.getElementById('btn-chart-months');
        
        if (period === 'days') {
            btnDays.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg bg-accent-blue text-white shadow-sm transition-all';
            btnMonths.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg text-text-dark/60 hover:text-text-main transition-all';
        } else {
            btnMonths.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg bg-accent-blue text-white shadow-sm transition-all';
            btnDays.className = 'px-3.5 py-1.5 text-xs font-bold rounded-lg text-text-dark/60 hover:text-text-main transition-all';
        }

        const canvas = document.getElementById('revenueChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const data = chartData[period] || { labels: [], data: [] };
        
        if (currentChart) {
            currentChart.destroy();
        }

        let gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(14, 165, 233, 0.25)');
        gradient.addColorStop(1, 'rgba(14, 165, 233, 0.0)');

        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.family = "'Instrument Sans', sans-serif";
        Chart.defaults.font.weight = '600';

        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: data.data,
                    borderColor: '#0284c7',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0284c7',
                    pointBorderWidth: 2,
                    pointRadius: 3.5,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#0284c7',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#38bdf8',
                        padding: 12,
                        cornerRadius: 12,
                        titleFont: { size: 11, weight: 'bold' },
                        bodyFont: { size: 13, weight: '900' },
                        callbacks: {
                            label: function(context) {
                                return '₹' + Number(context.parsed.y).toLocaleString('en-IN');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: 'rgba(148, 163, 184, 0.1)',
                            drawBorder: false,
                            borderDash: [4, 4]
                        },
                        border: { display: false },
                        ticks: {
                            callback: function(value) {
                                return '₹' + Number(value).toLocaleString('en-IN');
                            },
                            font: { size: 10 },
                            padding: 8
                        }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        border: { display: false },
                        ticks: {
                            font: { size: 10 },
                            padding: 6,
                            maxTicksLimit: 10
                        }
                    }
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateChart('days');
    });
</script>
@endpush
