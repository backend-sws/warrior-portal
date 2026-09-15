@extends('layouts.admin')

@section('title', 'Job Applications')
@section('subtitle', 'Track and manage candidate applications for job posts.')

@section('content')

{{-- Analytics Cards (Clickable Filters) --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <a href="{{ route('admin.applications.index', ['status' => '', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ !request('status') ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/10' : 'border-card-border hover:border-blue-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Total Apps</p>
        <h4 class="text-2xl font-black text-blue-600 relative z-10">{{ $stats['total'] }}</h4>
        <span class="text-[10px] text-slate-400 mt-0.5">All Submissions</span>
    </a>

    <a href="{{ route('admin.applications.index', ['status' => 'applied', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'applied' ? 'border-sky-500 ring-2 ring-sky-500/20 bg-sky-50/10' : 'border-card-border hover:border-sky-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-sky-500/5 group-hover:bg-sky-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">New Applied</p>
        <h4 class="text-2xl font-black text-sky-600 relative z-10">{{ $stats['applied'] }}</h4>
        <span class="text-[10px] text-sky-600 font-bold mt-0.5">Under Review</span>
    </a>

    <a href="{{ route('admin.applications.index', ['status' => 'forwarded', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ in_array(request('status'), ['forwarded', 'forwarded_to_school', 'demo_scheduled', 'shortlisted']) ? 'border-purple-500 ring-2 ring-purple-500/20 bg-purple-50/10' : 'border-card-border hover:border-purple-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-purple-500/5 group-hover:bg-purple-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Forwarded / Pipeline</p>
        <h4 class="text-2xl font-black text-purple-600 relative z-10">{{ $stats['forwarded'] }}</h4>
        <span class="text-[10px] text-purple-600 font-bold mt-0.5">School / Demo</span>
    </a>

    <a href="{{ route('admin.applications.index', ['status' => 'hired', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'hired' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Selected / Hired</p>
        <h4 class="text-2xl font-black text-emerald-600 relative z-10">{{ $stats['hired'] }}</h4>
        <span class="text-[10px] text-emerald-600 font-bold mt-0.5">Joined School</span>
    </a>

    <a href="{{ route('admin.applications.index', ['status' => 'rejected', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ in_array(request('status'), ['rejected', 'rejected_by_school', 'rejected_by_admin', 'tutor_backed_out']) ? 'border-red-500 ring-2 ring-red-500/20 bg-red-50/10' : 'border-card-border hover:border-red-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-red-500/5 group-hover:bg-red-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Rejected / Backed Out</p>
        <h4 class="text-2xl font-black text-red-500 relative z-10">{{ $stats['rejected'] }}</h4>
        <span class="text-[10px] text-red-400 font-bold mt-0.5">Not Selected</span>
    </a>
</div>

<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4">
    <form action="{{ route('admin.applications.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-3 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidate or job title..." 
                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
        </div>
        <div class="w-full md:w-64">
            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2.5 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                <option value="">All Statuses</option>
                <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>New applied</option>
                <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                <option value="forwarded_to_school" {{ request('status') == 'forwarded_to_school' ? 'selected' : '' }}>Forwarded to school/institute</option>
                <option value="demo_scheduled" {{ request('status') == 'demo_scheduled' ? 'selected' : '' }}>Demo scheduled</option>
                <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Selected/hired</option>
                <option value="rejected_by_school" {{ request('status') == 'rejected_by_school' ? 'selected' : '' }}>Rejected by school</option>
                <option value="tutor_backed_out" {{ request('status') == 'tutor_backed_out' ? 'selected' : '' }}>Tutor backed out</option>
                <option value="rejected_by_admin" {{ request('status') == 'rejected_by_admin' ? 'selected' : '' }}>Rejected by admin</option>
            </select>
        </div>
        <button type="submit" class="bg-accent-blue text-white rounded-xl px-6 py-2.5 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors">
            Filter
        </button>
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('admin.applications.index') }}" class="flex items-center justify-center px-4 py-2 text-text-dark/40 hover:text-red-400 transition-colors text-sm font-bold">
                Clear
            </a>
        @endif
    </form>
</div>

<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-xl mb-6">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                <th>Candidate</th>
                <th>Job Post (School)</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Date Applied</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($applications as $app)
            <tr class="group">
                <td>
                    <div class="font-semibold text-text-main group-hover:text-accent-blue transition-colors">{{ $app->candidate->name }}</div>
                    <div class="text-xs text-text-dark/50">{{ $app->candidate->email }}</div>
                    <div class="text-[10px] text-text-dark/40 mt-1">
                        <a href="{{ route('admin.crm.show', $app->candidate->id) }}" class="text-accent-blue hover:underline">View Profile</a>
                    </div>
                </td>
                <td>
                    <div class="font-semibold text-text-main truncate max-w-[200px]" title="{{ $app->jobPost->title }}">{{ $app->jobPost->title }}</div>
                    <div class="text-xs text-text-dark/50">{{ $app->jobPost->user->name ?? $app->jobPost->school_name ?? 'School' }}</div>
                </td>
                <td>
                    <span class="{{ $app->status_badge_class }} px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">
                        {{ $app->status_label }}
                    </span>
                    @if($app->interview_date)
                        <div class="text-[10px] text-purple-600 font-semibold mt-1 flex items-center gap-1">
                            <i class="fas fa-calendar-alt"></i> {{ $app->interview_date->format('d M, h:i A') }}
                        </div>
                    @endif
                </td>
                <td class="max-w-[200px]">
                    @if($app->remarks)
                        <p class="text-xs text-text-dark/70 truncate" title="{{ $app->remarks }}">{{ $app->remarks }}</p>
                    @else
                        <span class="text-text-dark/30 text-xs italic">No remarks</span>
                    @endif
                </td>
                <td class="text-text-dark/60 text-sm">
                    {{ $app->created_at->format('M d, Y') }}
                </td>
                <td class="text-right">
                    <button type="button" 
                            data-id="{{ $app->id }}"
                            data-status="{{ $app->status }}"
                            data-remarks="{{ $app->remarks ?? '' }}"
                            data-interview-date="{{ $app->interview_date ? $app->interview_date->format('Y-m-d\TH:i') : '' }}"
                            data-interview-link="{{ $app->interview_link ?? '' }}"
                            onclick="handleStatusModalBtn(this)" 
                            class="px-3 py-1.5 rounded-lg bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue hover:text-accent-blue text-xs font-semibold transition-colors">
                        Update Status
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-16 text-center">
                    <p class="text-text-main font-bold text-lg mb-1">No applications found</p>
                    <p class="text-text-dark/40 text-sm">Try adjusting your search criteria.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($applications->hasPages())
<div class="mt-4">
    {{ $applications->links('pagination::tailwind') }}
</div>
@endif

<!-- Update Status Modal -->
<div id="statusModal" class="fixed inset-0 z-50 hidden" style="background-color: rgba(0,0,0,0.5);">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-card-bg rounded-2xl border border-card-border w-full max-w-lg shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border flex justify-between items-center bg-secondary-bg/30">
                <h3 class="font-bold text-text-main text-base">Update Application Status</h3>
                <button type="button" onclick="closeStatusModal()" class="text-text-dark/50 hover:text-red-400 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="statusForm" method="POST" action="">
                @csrf
                <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                    <div>
                        <label class="block text-sm font-semibold text-text-main mb-2">Status</label>
                        <select name="status" id="modal_status" onchange="toggleScheduleFields()" class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-3 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="applied">New applied</option>
                            <option value="shortlisted">Shortlisted</option>
                            <option value="forwarded_to_school">Forwarded to school/institute</option>
                            <option value="demo_scheduled">Demo scheduled</option>
                            <option value="hired">Selected/hired</option>
                            <option value="rejected_by_school">Rejected by school</option>
                            <option value="tutor_backed_out">Tutor backed out</option>
                            <option value="rejected_by_admin">Rejected by admin</option>
                        </select>
                        <p class="text-xs text-text-dark/50 mt-2"><i class="fas fa-info-circle text-accent-blue"></i> Forwarding to school or scheduling demo will notify the candidate and school.</p>
                    </div>

                    <div id="scheduleFields" class="hidden space-y-3 p-4 border border-accent-blue/30 bg-accent-blue/5 rounded-xl">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-accent-blue flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i> Interview / Demo Schedule (Optional)
                        </h4>
                        <div>
                            <label class="block text-xs font-semibold text-text-main mb-1">Date & Time</label>
                            <input type="datetime-local" name="interview_date" id="modal_interview_date" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-text-main mb-1">Meeting Link / School Campus Address</label>
                            <input type="text" name="interview_link" id="modal_interview_link" placeholder="e.g. Google Meet link or School Campus Address" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-text-main mb-2">School / Admin Remarks (Optional)</label>
                        <textarea name="remarks" id="modal_remarks" rows="3" class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-3 text-sm text-text-main focus:border-accent-blue focus:outline-none placeholder-text-dark/30" placeholder="e.g. Needs to improve communication skills, or Selected for Class 9-10 Maths..."></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-card-border bg-secondary-bg/30 flex justify-end gap-3">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 rounded-xl text-sm font-bold text-text-dark hover:bg-card-border/50 transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-bold bg-accent-blue text-white shadow hover:bg-accent-blue-hover transition-colors">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleStatusModalBtn(btn) {
        const id = btn.dataset.id;
        const status = btn.dataset.status;
        const remarks = btn.dataset.remarks;
        const interviewDate = btn.dataset.interviewDate;
        const interviewLink = btn.dataset.interviewLink;
        openStatusModal(id, status, remarks, interviewDate, interviewLink);
    }

    function openStatusModal(id, currentStatus, currentRemarks, interviewDate, interviewLink) {
        document.getElementById('statusModal').classList.remove('hidden');
        
        const selectEl = document.getElementById('modal_status');
        if (selectEl) {
            if (currentStatus === 'rejected') currentStatus = 'rejected_by_admin';
            selectEl.value = currentStatus;
            if (selectEl._slimSelect) {
                selectEl._slimSelect.setSelected(currentStatus);
            }
        }

        document.getElementById('modal_remarks').value = currentRemarks || '';
        document.getElementById('modal_interview_date').value = interviewDate || '';
        document.getElementById('modal_interview_link').value = interviewLink || '';
        document.getElementById('statusForm').action = `/admin/applications/${id}/status`;
        
        toggleScheduleFields();
    }

    function toggleScheduleFields() {
        const selectEl = document.getElementById('modal_status');
        const status = selectEl ? selectEl.value : '';
        const scheduleFields = document.getElementById('scheduleFields');
        if (scheduleFields) {
            if (status === 'demo_scheduled' || status === 'shortlisted') {
                scheduleFields.classList.remove('hidden');
            } else {
                scheduleFields.classList.add('hidden');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectEl = document.getElementById('modal_status');
        if (selectEl) {
            selectEl.addEventListener('change', toggleScheduleFields);
        }
    });

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeStatusModal();
    });
</script>

@endsection
