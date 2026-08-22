@extends('layouts.admin')

@section('title', 'Teacher & Tutor Reminder Center')
@section('subtitle', 'Send targeted DB dashboard notifications and emails to candidates, tutors, and teachers with one click.')

@section('content')
<div class="space-y-6">

    {{-- 1. Analytics KPI Metrics Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        <!-- Card 1: Job Placement Dues -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Job Fees</span>
                <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <p class="text-xl font-black text-blue-600">{{ $stats['job_service_pending'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Pending Invoices</p>
        </div>

        <!-- Card 2: Tuition Service Dues -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Tuition Fees</span>
                <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <p class="text-xl font-black text-emerald-600">{{ $stats['tuition_service_pending'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Pending Invoices</p>
        </div>

        <!-- Card 3: Agreement Needed -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider">Agreements</span>
                <div class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xs">
                    <i class="fas fa-file-signature"></i>
                </div>
            </div>
            <p class="text-xl font-black text-indigo-600">{{ $stats['agreement_pending'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Pending Signature</p>
        </div>

        <!-- Card 4: Incomplete Profiles -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Incomplete</span>
                <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center text-xs">
                    <i class="fas fa-user-edit"></i>
                </div>
            </div>
            <p class="text-xl font-black text-amber-600">{{ $stats['incomplete_profiles'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Missing Info</p>
        </div>

        <!-- Card 5: Upcoming Interviews -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-sky-600 uppercase tracking-wider">Interviews</span>
                <div class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-600 flex items-center justify-center text-xs">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <p class="text-xl font-black text-sky-600">{{ $stats['upcoming_interviews'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">In Next 5 Days</p>
        </div>

        <!-- Card 6: Upcoming Demos -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-teal-600 uppercase tracking-wider">Demos</span>
                <div class="w-7 h-7 rounded-lg bg-teal-500/10 text-teal-600 flex items-center justify-center text-xs">
                    <i class="fas fa-person-chalkboard"></i>
                </div>
            </div>
            <p class="text-xl font-black text-teal-600">{{ $stats['upcoming_demos'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Tuition Trials</p>
        </div>

        <!-- Card 7: Late Fees Active -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">Late Fees</span>
                <div class="w-7 h-7 rounded-lg bg-rose-500/10 text-rose-600 flex items-center justify-center text-xs">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
            </div>
            <p class="text-xl font-black text-rose-600">{{ $stats['late_fees'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Overdue Fees</p>
        </div>

        <!-- Card 8: Total Candidates -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-3.5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-bold text-text-dark/60 uppercase tracking-wider">Candidates</span>
                <div class="w-7 h-7 rounded-lg bg-secondary-bg text-text-dark/60 flex items-center justify-center text-xs">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <p class="text-xl font-black text-text-main">{{ $stats['total_candidates'] }}</p>
            <p class="text-[10px] text-text-dark/50 leading-tight">Total Pool</p>
        </div>
    </div>

    {{-- 2. Reminder Dispatch Modules Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        {{-- 1. School Job Placement Fee Reminder --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-blue-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center text-xs">
                            <i class="fas fa-school"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">School Placement Fee Reminder</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">{{ $jobInvoices->count() }} Due</span>
                </div>
                <p class="text-xs text-text-dark/60">Sends DB notification & email to teachers with pending school placement invoices.</p>
            </div>

            <form action="{{ route('admin.reminders.service-charge') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Candidates:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-blue-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Pending ({{ $jobInvoices->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-blue-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($jobInvoices as $inv)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="invoice_ids[]" value="{{ $inv->id }}" class="rounded text-blue-600 border-card-border focus:ring-blue-500">
                                <span class="truncate">{{ $inv->candidate->name ?? 'Candidate' }} — ₹{{ number_format($inv->amount) }}</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">No pending placement invoices.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i> <span>Send Placement Reminders</span>
                </button>
            </form>
        </div>

        {{-- 2. Home Tuition Service Fee Reminder --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-emerald-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">Tuition Service Charge Reminder</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">{{ $tuitionInvoices->count() }} Due</span>
                </div>
                <p class="text-xs text-text-dark/60">Reminds home tutors with pending tuition service charge invoices.</p>
            </div>

            <form action="{{ route('admin.reminders.tuition-service') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Tutors:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-emerald-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Pending ({{ $tuitionInvoices->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-emerald-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($tuitionInvoices as $tInv)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="invoice_ids[]" value="{{ $tInv->id }}" class="rounded text-emerald-600 border-card-border focus:ring-emerald-500">
                                <span class="truncate">{{ $tInv->candidate->name ?? 'Tutor' }} — ₹{{ number_format($tInv->amount) }}</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">No pending tuition invoices.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i> <span>Send Tuition Reminders</span>
                </button>
            </form>
        </div>

        {{-- 3. Digital Agreement Signing Reminder --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-indigo-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xs">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">Agreement Signing Reminder</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700">{{ $pendingAgreementCandidates->count() }} Pending</span>
                </div>
                <p class="text-xs text-text-dark/60">Reminds candidates whose school or tuition agreement is unsigned.</p>
            </div>

            <form action="{{ route('admin.reminders.agreement') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Candidates:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-indigo-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Pending ({{ $pendingAgreementCandidates->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-indigo-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($pendingAgreementCandidates as $cand)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="candidate_ids[]" value="{{ $cand->id }}" class="rounded text-indigo-600 border-card-border focus:ring-indigo-500">
                                <span class="truncate">{{ $cand->name }} ({{ $cand->phone ?? $cand->email }})</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">All candidates have signed agreements.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-file-signature text-xs"></i> <span>Send Agreement Reminders</span>
                </button>
            </form>
        </div>

        {{-- 4. School Job Interview Reminder --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-sky-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-sky-500/10 text-sky-600 flex items-center justify-center text-xs">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">School Interview Reminder</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700">{{ $upcomingInterviews->count() }} Upcoming</span>
                </div>
                <p class="text-xs text-text-dark/60">Reminds teachers with scheduled interviews in the next 5 days.</p>
            </div>

            <form action="{{ route('admin.reminders.interview') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Interviews:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-sky-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Next 5 Days ({{ $upcomingInterviews->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-sky-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($upcomingInterviews as $app)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="application_ids[]" value="{{ $app->id }}" class="rounded text-sky-600 border-card-border focus:ring-sky-500">
                                <span class="truncate">{{ $app->candidate->name ?? 'Candidate' }} — {{ \Carbon\Carbon::parse($app->interview_date)->format('d M, h:i A') }}</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">No upcoming interviews scheduled.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-calendar-check text-xs"></i> <span>Send Interview Alerts</span>
                </button>
            </form>
        </div>

        {{-- 5. Home Tuition Demo Reminder --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-teal-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-600 flex items-center justify-center text-xs">
                            <i class="fas fa-person-chalkboard"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">Tuition Demo Class Reminder</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-100 text-teal-700">{{ $upcomingDemos->count() }} Upcoming</span>
                </div>
                <p class="text-xs text-text-dark/60">Reminds tutors with upcoming parent trial demo sessions.</p>
            </div>

            <form action="{{ route('admin.reminders.tuition-demo') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Demos:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-teal-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Next 5 Days ({{ $upcomingDemos->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-teal-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($upcomingDemos as $tApp)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="application_ids[]" value="{{ $tApp->id }}" class="rounded text-teal-600 border-card-border focus:ring-teal-500">
                                <span class="truncate">{{ $tApp->candidate->name ?? 'Tutor' }} — {{ \Carbon\Carbon::parse($tApp->demo_date)->format('d M, h:i A') }}</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">No upcoming tuition demos scheduled.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-person-chalkboard text-xs"></i> <span>Send Demo Reminders</span>
                </button>
            </form>
        </div>

        {{-- 6. Profile Completion Reminder --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-amber-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-xs">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">Profile Completion Reminder</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">{{ $incompleteCandidates->count() }} Incomplete</span>
                </div>
                <p class="text-xs text-text-dark/60">Reminds registered candidates missing Subject, Qualification, or Resume.</p>
            </div>

            <form action="{{ route('admin.reminders.profile') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Candidates:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-amber-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Incomplete ({{ $incompleteCandidates->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-amber-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($incompleteCandidates as $inCand)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="candidate_ids[]" value="{{ $inCand->id }}" class="rounded text-amber-600 border-card-border focus:ring-amber-500">
                                <span class="truncate">{{ $inCand->name }} ({{ $inCand->email }})</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">All candidate profiles are complete!</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-user-edit text-xs"></i> <span>Send Completion Reminders</span>
                </button>
            </form>
        </div>

        {{-- 7. Late Fee Alert --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden">
            <div class="p-5 border-b border-card-border bg-rose-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-600 flex items-center justify-center text-xs">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">Late Fee & Overdue Alert</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">{{ $lateFeeInvoices->count() }} Overdue</span>
                </div>
                <p class="text-xs text-text-dark/60">Urgent penalty notification for invoices that passed due date.</p>
            </div>

            <form action="{{ route('admin.reminders.late-fee') }}" method="POST" class="p-5 space-y-4" x-data="{ mode: 'all' }">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Target Overdue Accounts:</label>
                    <div class="flex gap-2 mb-2">
                        <button type="button" @click="mode = 'all'" :class="mode === 'all' ? 'bg-rose-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            All Overdue ({{ $lateFeeInvoices->count() }})
                        </button>
                        <button type="button" @click="mode = 'specific'" :class="mode === 'specific' ? 'bg-rose-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-1.5 px-2 rounded-lg text-xs font-bold transition-all">
                            Select Specific
                        </button>
                    </div>

                    <input type="hidden" name="send_to_all" :value="mode === 'all' ? '1' : '0'">

                    <div x-show="mode === 'specific'" class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @forelse($lateFeeInvoices as $lfInv)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="invoice_ids[]" value="{{ $lfInv->id }}" class="rounded text-rose-600 border-card-border focus:ring-rose-500">
                                <span class="truncate">{{ $lfInv->candidate->name ?? 'Candidate' }} — Fee: ₹{{ number_format($lfInv->amount + $lfInv->late_fee) }}</span>
                            </label>
                        @empty
                            <p class="text-[11px] text-text-dark/40 py-1 text-center">No overdue accounts with late fees.</p>
                        @endforelse
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center justify-center gap-2">
                    <i class="fas fa-triangle-exclamation text-xs"></i> <span>Send Urgent Late Fee Alerts</span>
                </button>
            </form>
        </div>

        {{-- 8. Custom Direct Broadcast Message --}}
        <div class="bg-card-bg rounded-3xl border border-card-border shadow-sm flex flex-col justify-between overflow-hidden md:col-span-2 xl:col-span-2">
            <div class="p-5 border-b border-card-border bg-purple-500/5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-xs">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3 class="font-black text-text-main text-sm">Direct Broadcast & Notification Dispatch</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700">Custom Alert</span>
                </div>
                <p class="text-xs text-text-dark/60">Send custom DB dashboard notification and email to specific candidates or all registered teachers.</p>
            </div>

            <form action="{{ route('admin.reminders.custom') }}" method="POST" class="p-5 space-y-4" x-data="{ target: 'specific' }">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-text-main mb-1">Notification Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Urgent Walk-in Drive for PGT Maths" 
                               class="w-full px-3 py-2 text-xs bg-secondary-bg border border-card-border rounded-xl text-text-main focus:ring-1 focus:ring-purple-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-text-main mb-1">Recipient Mode *</label>
                        <div class="flex gap-2">
                            <button type="button" @click="target = 'specific'" :class="target === 'specific' ? 'bg-purple-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all">
                                Specific Candidates
                            </button>
                            <button type="button" @click="target = 'all'" :class="target === 'all' ? 'bg-purple-600 text-white' : 'bg-secondary-bg text-text-dark/70'" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all">
                                Broadcast to All ({{ $allCandidates->count() }})
                            </button>
                        </div>
                        <input type="hidden" name="target" :value="target">
                    </div>
                </div>

                <div x-show="target === 'specific'">
                    <label class="block text-[11px] font-bold text-text-dark/70 mb-1.5">Select Candidates:</label>
                    <div class="space-y-1.5 max-h-32 overflow-y-auto p-2 bg-secondary-bg rounded-xl border border-card-border">
                        @foreach($allCandidates as $c)
                            <label class="flex items-center gap-2 text-xs text-text-main cursor-pointer hover:bg-card-bg p-1 rounded-lg">
                                <input type="checkbox" name="candidate_ids[]" value="{{ $c->id }}" class="rounded text-purple-600 border-card-border focus:ring-purple-500">
                                <span class="truncate font-semibold">{{ $c->name }}</span>
                                <span class="text-[10px] text-text-dark/40 truncate">({{ $c->email ?? $c->phone }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1">Message Body *</label>
                    <textarea name="message" rows="3" required placeholder="Type your notification message here..." 
                              class="w-full px-3 py-2 text-xs bg-secondary-bg border border-card-border rounded-xl text-text-main focus:ring-1 focus:ring-purple-500 outline-none"></textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-2 text-xs text-text-dark/70 font-semibold cursor-pointer">
                        <input type="checkbox" name="send_email" value="1" checked class="rounded text-purple-600 border-card-border focus:ring-purple-500">
                        <span>Also deliver via Email</span>
                    </label>

                    <button type="submit" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold transition-all shadow flex items-center gap-2">
                        <i class="fas fa-paper-plane text-xs"></i> <span>Send Broadcast</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
