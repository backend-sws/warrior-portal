@extends('layouts.admin')

@section('title', 'Users Management')
@section('subtitle', 'Manage candidate profiles, parent accounts, tuition activity, job applications & financial records.')

@section('content')
    <!-- Top Metric Cards -->
    <div class="mb-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Users -->
        <a href="{{ route('admin.users.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-card-border flex items-center gap-4 hover:border-accent-blue/40 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-accent-blue flex items-center justify-center text-xl group-hover:scale-105 transition-transform shrink-0">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] text-text-dark/50 font-bold uppercase tracking-wider">Total Users</p>
                <h3 class="text-2xl font-black text-text-main group-hover:text-accent-blue transition-colors">{{ $stats['total'] }}</h3>
            </div>
        </a>

        <!-- Candidates -->
        <a href="{{ route('admin.users.index', ['role' => 'candidate']) }}" class="bg-white rounded-2xl p-5 shadow-sm border border-card-border flex items-center gap-4 hover:border-purple-300 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-xl group-hover:scale-105 transition-transform shrink-0">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-[10px] text-text-dark/50 font-bold uppercase tracking-wider">Candidates</p>
                <h3 class="text-2xl font-black text-purple-700 group-hover:text-purple-800 transition-colors">{{ $stats['candidates'] }}</h3>
            </div>
        </a>

        <!-- Active Tutors Assigned -->
        <a href="{{ route('admin.users.index', ['activity' => 'assigned_tuition']) }}" class="bg-white rounded-2xl p-5 shadow-sm border border-card-border flex items-center gap-4 hover:border-emerald-300 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-105 transition-transform shrink-0">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <p class="text-[10px] text-text-dark/50 font-bold uppercase tracking-wider">Assigned Tutors</p>
                <h3 class="text-2xl font-black text-emerald-600 group-hover:text-emerald-700 transition-colors">{{ $stats['assigned_tuitions'] }}</h3>
            </div>
        </a>

        <!-- Users With Pending Dues -->
        <a href="{{ route('admin.users.index', ['financial_status' => 'has_dues']) }}" class="bg-white rounded-2xl p-5 shadow-sm border border-card-border flex items-center gap-4 hover:border-red-300 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-red-500/10 text-red-500 flex items-center justify-center text-xl group-hover:scale-105 transition-transform shrink-0">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div>
                <p class="text-[10px] text-text-dark/50 font-bold uppercase tracking-wider">With Pending Dues</p>
                <h3 class="text-2xl font-black text-red-500 group-hover:text-red-600 transition-colors">{{ $stats['with_dues'] }}</h3>
            </div>
        </a>
    </div>

    <!-- Filters & Table Card -->
    <div class="bg-white shadow-sm rounded-2xl border border-card-border overflow-hidden">
        
        <!-- Filter Header Bar -->
        <div class="p-4 sm:p-5 border-b border-card-border bg-secondary-bg/30">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                
                {{-- Role Pills --}}
                <div class="flex bg-white p-1 rounded-xl border border-card-border shadow-2xs">
                    <a href="{{ route('admin.users.index', array_merge(request()->except('role'), [])) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-colors {{ !request('role') ? 'bg-accent-blue text-white shadow-xs' : 'text-text-dark/60 hover:text-text-main' }}">All</a>
                    <a href="{{ route('admin.users.index', array_merge(request()->except('role'), ['role' => 'candidate'])) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-colors {{ request('role') === 'candidate' ? 'bg-accent-blue text-white shadow-xs' : 'text-text-dark/60 hover:text-text-main' }}">Candidates</a>
                    <a href="{{ route('admin.users.index', array_merge(request()->except('role'), ['role' => 'parent'])) }}" class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-colors {{ request('role') === 'parent' ? 'bg-accent-blue text-white shadow-xs' : 'text-text-dark/60 hover:text-text-main' }}">Parents</a>
                </div>

                {{-- Activity Filter --}}
                <div class="w-full sm:w-auto">
                    <select name="activity" class="w-full bg-white border border-card-border rounded-xl text-xs font-medium px-3.5 py-2 text-text-main focus:outline-none focus:border-accent-blue shadow-2xs" onchange="this.form.submit()">
                        <option value="">🎯 All Activities</option>
                        <option value="assigned_tuition" {{ request('activity') === 'assigned_tuition' ? 'selected' : '' }}>🎓 Currently Assigned as Tutor</option>
                        <option value="applied_tuition" {{ request('activity') === 'applied_tuition' ? 'selected' : '' }}>📝 Applied for Tuitions</option>
                        <option value="rejected_tuition" {{ request('activity') === 'rejected_tuition' ? 'selected' : '' }}>❌ Rejected Tuition Applications</option>
                        <option value="shortlisted_tuition" {{ request('activity') === 'shortlisted_tuition' ? 'selected' : '' }}>⭐ Shortlisted for Demo</option>
                        <option value="applied_job" {{ request('activity') === 'applied_job' ? 'selected' : '' }}>🏫 Applied for School Jobs</option>
                        <option value="hired_job" {{ request('activity') === 'hired_job' ? 'selected' : '' }}>💼 Placed / Hired in School</option>
                        <option value="posted_tuition" {{ request('activity') === 'posted_tuition' ? 'selected' : '' }}>🏡 Posted Tuition Leads (Parents)</option>
                    </select>
                </div>

                {{-- Financial Due Filter --}}
                <div class="w-full sm:w-auto">
                    <select name="financial_status" class="w-full bg-white border border-card-border rounded-xl text-xs font-medium px-3.5 py-2 text-text-main focus:outline-none focus:border-accent-blue shadow-2xs" onchange="this.form.submit()">
                        <option value="">💰 All Financials</option>
                        <option value="has_dues" {{ request('financial_status') === 'has_dues' ? 'selected' : '' }}>🔴 Has Pending Invoices / Dues</option>
                        <option value="paid" {{ request('financial_status') === 'paid' ? 'selected' : '' }}>🟢 Paid Payments / Invoices</option>
                        <option value="no_dues" {{ request('financial_status') === 'no_dues' ? 'selected' : '' }}>⚪ Zero Dues / Clear</option>
                    </select>
                </div>

                {{-- Account Status --}}
                <div class="w-full sm:w-auto">
                    <select name="status" class="w-full bg-white border border-card-border rounded-xl text-xs font-medium px-3.5 py-2 text-text-main focus:outline-none focus:border-accent-blue shadow-2xs" onchange="this.form.submit()">
                        <option value="">Account Status: All</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Accounts</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Accounts</option>
                    </select>
                </div>

                {{-- Date Presets --}}
                <div class="w-full sm:w-auto">
                    <select name="date_preset" class="w-full bg-white border border-card-border rounded-xl text-xs font-medium px-3.5 py-2 text-text-main focus:outline-none focus:border-accent-blue shadow-2xs" onchange="this.form.submit()">
                        <option value="">📅 Joined: All Dates</option>
                        <option value="today" {{ request('date_preset') === 'today' ? 'selected' : '' }}>⚡ Today</option>
                        <option value="yesterday" {{ request('date_preset') === 'yesterday' ? 'selected' : '' }}>⏳ Yesterday</option>
                        <option value="this_week" {{ request('date_preset') === 'this_week' ? 'selected' : '' }}>📆 This Week</option>
                        <option value="this_month" {{ request('date_preset') === 'this_month' ? 'selected' : '' }}>🗓️ This Month</option>
                        <option value="last_month" {{ request('date_preset') === 'last_month' ? 'selected' : '' }}>📦 Last Month</option>
                    </select>
                </div>

                {{-- Custom Date Range (From - To) --}}
                <div class="flex items-center gap-1.5 bg-white border border-card-border rounded-xl px-3 py-1.5 shadow-2xs">
                    <span class="text-[10px] font-black text-text-dark/40 uppercase">From:</span>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="text-xs text-text-main focus:outline-none bg-transparent font-medium" title="Joined From Date">
                    <span class="text-[10px] font-black text-text-dark/40 uppercase ml-1.5">To:</span>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="text-xs text-text-main focus:outline-none bg-transparent font-medium" title="Joined To Date">
                </div>

                {{-- Search Box --}}
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone, city..." class="w-full pl-9 pr-4 py-2 bg-white border border-card-border rounded-xl text-xs focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue shadow-2xs">
                    </div>
                </div>

                @if(request('role') || request('activity') || request('financial_status') || request('status') || request('date_preset') || request('from_date') || request('to_date') || request('search'))
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-red-500 hover:text-red-600 px-2">Clear</a>
                @endif

                <button type="submit" class="bg-accent-blue hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-bold text-xs transition-colors shadow-2xs">
                    Filter
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-secondary-bg/60 border-b border-card-border">
                        <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">User Profile</th>
                        <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Role & Status</th>
                        <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Tuition & Job Record</th>
                        <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Payment & Dues</th>
                        <th class="px-5 py-3.5 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Joined On</th>
                        <th class="px-5 py-3.5 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/50">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-card-border bg-white">
                    @forelse($users as $user)
                        @php
                            $assignedTuitions = $user->tuitionApplications->where('status', 'Assigned');
                            $rejectedTuitions = $user->tuitionApplications->where('status', 'Rejected');
                            $totalTuitionApps = $user->tuitionApplications->count();
                            $hiredJobs = $user->applications->where('status', 'hired');
                            $pendingInvoices = $user->serviceChargeInvoices->whereIn('status', ['pending', 'overdue']);
                            $pendingAmount = $pendingInvoices->sum('amount');
                        @endphp
                        <tr class="hover:bg-secondary-bg/30 transition-colors {{ !$user->is_active ? 'opacity-60 bg-gray-50/50' : '' }}">
                            
                            {{-- 1. User Profile --}}
                            <td class="px-5 py-3.5 align-top">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl {{ $user->role === 'candidate' ? 'bg-purple-500/10 text-purple-600' : 'bg-orange-500/10 text-orange-600' }} flex items-center justify-center font-bold text-sm shrink-0 mt-0.5 shadow-2xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            @if($user->role === 'candidate')
                                                <a href="{{ route('admin.crm.show', $user->id) }}" class="font-extrabold text-text-main text-sm hover:text-accent-blue hover:underline">
                                                    {{ $user->name }}
                                                </a>
                                            @else
                                                <span class="font-extrabold text-text-main text-sm">{{ $user->name }}</span>
                                            @endif

                                            @if($user->profile && $user->profile->is_verified)
                                                <span class="text-accent-blue text-xs" title="Verified Candidate"><i class="fas fa-check-circle"></i></span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-text-dark/70 mt-0.5 flex items-center gap-1">
                                            <i class="fas fa-envelope text-[10px] text-text-dark/40"></i>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        @if($user->phone)
                                            <div class="text-[11px] text-text-dark/60 mt-0.5 flex items-center gap-1">
                                                <i class="fas fa-phone-alt text-[10px] text-text-dark/40"></i>
                                                <a href="tel:{{ $user->phone }}" class="hover:text-accent-blue">{{ $user->phone }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Role & Status --}}
                            <td class="px-5 py-3.5 align-top">
                                <div class="space-y-1.5">
                                    @if($user->role === 'candidate')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 uppercase">
                                            <i class="fas fa-user-graduate mr-1"></i> Candidate
                                        </span>
                                    @elseif($user->role === 'parent')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-orange-50 text-orange-700 border border-orange-200 uppercase">
                                            <i class="fas fa-user-friends mr-1"></i> Parent
                                        </span>
                                    @endif

                                    <div>
                                        @if($user->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1"></span> Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Tuition & Job Record --}}
                            <td class="px-5 py-3.5 align-top">
                                @if($user->role === 'candidate')
                                    <div class="space-y-1 text-xs">
                                        {{-- Currently Assigned Tuitions --}}
                                        @if($assignedTuitions->count() > 0)
                                            <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 text-[11px] font-black">
                                                <i class="fas fa-chalkboard-teacher text-emerald-600"></i>
                                                <span>{{ $assignedTuitions->count() }} Tuition(s) Assigned</span>
                                            </div>
                                        @endif

                                        {{-- Applications Count --}}
                                        <div class="text-[11px] text-text-dark/70">
                                            <span><strong>Tuitions:</strong> {{ $totalTuitionApps }} Applied</span>
                                            @if($rejectedTuitions->count() > 0)
                                                <span class="text-red-500 font-bold">({{ $rejectedTuitions->count() }} Rejected)</span>
                                            @endif
                                        </div>

                                        {{-- School Jobs --}}
                                        @if($user->applications->count() > 0)
                                            <div class="text-[11px] text-indigo-700">
                                                <i class="fas fa-school text-[10px] mr-0.5"></i>
                                                <span><strong>School Jobs:</strong> {{ $user->applications->count() }} Applied</span>
                                                @if($hiredJobs->count() > 0)
                                                    <span class="text-emerald-600 font-bold">({{ $hiredJobs->count() }} Placed)</span>
                                                @endif
                                            </div>
                                        @endif

                                        @if($totalTuitionApps === 0 && $user->applications->count() === 0)
                                            <span class="text-slate-400 text-[11px] italic">No applications yet</span>
                                        @endif
                                    </div>
                                @elseif($user->role === 'parent')
                                    <div class="text-xs">
                                        <span class="font-bold text-text-main">{{ $user->homeTuitionLeads->count() }}</span> Tuition Requirements Posted
                                    </div>
                                @endif
                            </td>

                            {{-- 4. Payment & Dues --}}
                            <td class="px-5 py-3.5 align-top">
                                @if($user->role === 'candidate')
                                    @if($pendingAmount > 0 || ($user->profile && $user->profile->pending_amount > 0))
                                        @php
                                            $totalDue = max($pendingAmount, (float)($user->profile->pending_amount ?? 0));
                                        @endphp
                                        <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-50 text-red-700 border border-red-200 text-xs font-black">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <span>₹{{ number_format($totalDue) }} Due</span>
                                        </div>
                                    @elseif($user->serviceChargeInvoices->where('status', 'paid')->count() > 0 || $user->paymentTransactions->whereIn('status', ['paid', 'success'])->count() > 0 || ($user->profile && $user->profile->is_fee_paid))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">
                                            <i class="fas fa-check-circle"></i> Paid / Clear
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">—</span>
                                    @endif

                                    @if($user->paymentTransactions->whereIn('status', ['paid', 'success'])->count() > 0)
                                        <div class="text-[10px] text-text-dark/50 mt-1">
                                            {{ $user->paymentTransactions->whereIn('status', ['paid', 'success'])->count() }} Transaction(s)
                                        </div>
                                    @endif
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>

                            {{-- 5. Joined Date --}}
                            <td class="px-5 py-3.5 align-top text-xs text-text-dark/60 whitespace-nowrap">
                                <div>{{ $user->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] text-text-dark/40">{{ $user->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- 6. Actions --}}
                            <td class="px-5 py-3.5 align-top text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    {{-- 360° Complete Record Button for Candidate --}}
                                    @if($user->role === 'candidate')
                                        <a href="{{ route('admin.crm.show', $user->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-accent-blue/10 hover:bg-accent-blue text-accent-blue hover:text-white rounded-xl text-xs font-bold transition-all shadow-2xs" title="View 360° Profile & All Records">
                                            <i class="fas fa-eye text-xs"></i> <span>360° Record</span>
                                        </a>
                                    @endif

                                    {{-- Impersonate / Login as User (Only for Candidates) --}}
                                    @if($user->is_active && $user->role !== 'parent')
                                        <a href="{{ route('admin.users.impersonate', $user->id) }}" target="_blank" class="w-8 h-8 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 flex items-center justify-center transition-colors shadow-2xs" title="Login as Candidate">
                                            <i class="fas fa-sign-in-alt text-xs"></i>
                                        </a>
                                    @endif

                                    {{-- Toggle Status Button --}}
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @if($user->is_active)
                                            <button type="submit" class="w-8 h-8 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-colors shadow-2xs" title="Deactivate User" onclick="return confirm('Are you sure you want to deactivate this user?')">
                                                <i class="fas fa-ban text-xs"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="w-8 h-8 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition-colors shadow-2xs" title="Activate User">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500">
                                <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-3 border border-card-border">
                                    <i class="fas fa-users-slash text-2xl text-text-dark/30"></i>
                                </div>
                                <div class="text-text-main font-bold mb-1">No Users Found</div>
                                <div class="text-xs text-text-dark/50">Try adjusting your filters or search keywords.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-card-border">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection
