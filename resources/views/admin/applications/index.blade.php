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
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidate, job title, or job ID..." 
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
                <option value="rejected_by_school" {{ request('status') == 'rejected_by_school' ? 'selected' : '' }}>Rejected by school/institute</option>
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
                <th class="min-w-[270px]">Candidate Details</th>
                <th class="min-w-[190px]">Job Post (School)</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Date Applied</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($applications as $app)
            @php
                $candidate = $app->candidate;
                $prof = $candidate?->profile;

                // Determine WhatsApp number:
                $rawWa = $candidate?->whatsapp_no ?: ($prof?->whatsapp_no ?: $candidate?->phone);
                $waClean = preg_replace('/[^0-9]/', '', (string)$rawWa);
                if (!empty($waClean)) {
                    $waDigits = (strlen($waClean) === 10) ? '91' . $waClean : $waClean;
                    $jobTitle = $app->jobPost->title ?? 'Teacher Position';
                    $schoolName = !empty($app->jobPost->school_name) ? $app->jobPost->school_name : ($app->jobPost->user->name ?? '');
                    $schoolPart = $schoolName ? " at {$schoolName}" : '';
                    $candName = $candidate?->name ?? 'Candidate';
                    $waMsg = "Hello {$candName}, Warriors Educare regarding your application for {$jobTitle}{$schoolPart}.";
                    $waUrl = "https://wa.me/{$waDigits}?text=" . urlencode($waMsg);
                } else {
                    $waUrl = null;
                }

                $qual = $prof?->highestQualification?->name ?: $prof?->highest_qualification_name;
                $subject = $prof?->subject_specialization ?: ($prof?->subject?->name ?: null);
                $exp = $prof?->experience_range ?: ($prof?->experience_years ? $prof->experience_years . ' yrs' : null);
                $city = $prof?->preferredCity?->name ?: ($prof?->address ? \Illuminate\Support\Str::limit($prof->address, 20) : null);
            @endphp
            <tr class="group hover:bg-secondary-bg/40 transition-colors">
                <td class="align-top py-3.5">
                    @if($candidate)
                        <div class="space-y-1.5 min-w-[270px] max-w-[340px]">
                            {{-- Name & Verified Status --}}
                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="{{ route('admin.crm.show', $candidate->id) }}" target="_blank" class="font-bold text-sm text-text-main hover:text-accent-blue transition-colors">
                                    {{ $candidate->name }}
                                </a>
                                @if($prof && $prof->is_verified)
                                    <span class="inline-flex items-center text-accent-blue text-xs" title="Verified Candidate">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                @endif
                                <span class="text-[10px] font-mono text-text-dark/50 bg-secondary-bg px-1.5 py-0.5 rounded border border-card-border" title="Candidate ID">
                                    #{{ $candidate->id }}
                                </span>
                            </div>

                            {{-- Contact Numbers & WhatsApp --}}
                            <div class="flex items-center gap-2 flex-wrap">
                                @if($candidate->phone)
                                    <a href="tel:{{ $candidate->phone }}" 
                                       class="inline-flex items-center gap-1 text-[11px] font-semibold text-text-main hover:text-accent-blue bg-secondary-bg px-2 py-0.5 rounded border border-card-border transition-colors" 
                                       title="Call {{ $candidate->phone }}">
                                        <i class="fas fa-phone-alt text-[9px] text-text-dark/40"></i>
                                        <span>{{ $candidate->phone }}</span>
                                    </a>
                                @endif

                                @if($waUrl)
                                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 hover:text-emerald-800 border border-emerald-300 text-xs font-bold transition-all shadow-xs group/wa cursor-pointer" 
                                       title="Open WhatsApp chat with {{ $candidate->name }} ({{ $rawWa }})">
                                        <i class="fab fa-whatsapp text-emerald-600 text-sm group-hover/wa:scale-110 transition-transform"></i>
                                        <span>WhatsApp</span>
                                        @if($rawWa !== $candidate->phone)
                                            <span class="text-[10px] font-mono text-emerald-800 font-normal">({{ $rawWa }})</span>
                                        @endif
                                    </a>
                                @endif
                            </div>

                            {{-- Email --}}
                            @if($candidate->email)
                                <div>
                                    <a href="mailto:{{ $candidate->email }}" class="inline-flex items-center gap-1 text-[11px] text-text-dark/60 hover:text-accent-blue truncate max-w-[280px]" title="{{ $candidate->email }}">
                                        <i class="fas fa-envelope text-[9px] text-text-dark/40"></i>
                                        <span class="truncate">{{ $candidate->email }}</span>
                                    </a>
                                </div>
                            @endif

                            {{-- Professional / Academic Badges --}}
                            <div class="flex items-center gap-1 flex-wrap pt-0.5">
                                @if(!empty($prof?->position_applying_for))
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200" title="Target Position">
                                        <i class="fas fa-user-tie text-[9px] text-blue-500"></i> {{ $prof->position_applying_for }}
                                    </span>
                                @endif

                                @if($subject)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200" title="Subject Specialization">
                                        <i class="fas fa-book text-[9px] text-purple-500"></i> {{ $subject }}
                                    </span>
                                @endif

                                @if($qual)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200" title="Highest Qualification">
                                        <i class="fas fa-graduation-cap text-[9px] text-amber-500"></i> {{ $qual }}
                                    </span>
                                @endif

                                @if(!empty($prof?->b_ed_status) && !in_array(strtolower($prof->b_ed_status), ['no', 'none']))
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-200" title="B.Ed Status">
                                        <i class="fas fa-certificate text-[9px] text-teal-500"></i> B.Ed ({{ $prof->b_ed_status }})
                                    </span>
                                @endif

                                @if($exp)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200" title="Teaching Experience">
                                        <i class="fas fa-briefcase text-[9px] text-slate-500"></i> {{ $exp }}
                                    </span>
                                @endif

                                @if($city)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200" title="Location: {{ $prof?->address ?: $city }}">
                                        <i class="fas fa-map-marker-alt text-[9px] text-slate-400"></i> {{ $city }}
                                    </span>
                                @endif

                                @if($prof?->expected_salary)
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200" title="Expected Salary">
                                        <i class="fas fa-rupee-sign text-[8px] text-emerald-500"></i> {{ $prof->expected_salary }}
                                    </span>
                                @endif
                            </div>

                            {{-- Bottom Action Links: Resume & Full Profile --}}
                            <div class="flex items-center gap-2.5 pt-1 border-t border-card-border/40 text-[11px]">
                                @if(!empty($prof?->resume_path))
                                    <a href="{{ Storage::url($prof->resume_path) }}" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center gap-1 font-bold text-rose-600 hover:text-rose-700 hover:underline bg-rose-50 px-2 py-0.5 rounded border border-rose-200 transition-colors">
                                        <i class="fas fa-file-pdf text-[10px]"></i> Resume
                                    </a>
                                    <span class="text-text-dark/20">•</span>
                                @endif
                                <a href="{{ route('admin.crm.show', $candidate->id) }}" target="_blank" 
                                   class="inline-flex items-center gap-1 font-bold text-accent-blue hover:underline">
                                    <span>View Full Profile</span>
                                    <i class="fas fa-arrow-up-right-from-square text-[9px]"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <span class="text-xs text-red-500 italic">Candidate Deleted</span>
                    @endif
                </td>
                <td class="align-top py-3.5">
                    <div class="font-semibold text-text-main truncate max-w-[220px]" title="{{ $app->jobPost->title ?? 'N/A' }}">{{ $app->jobPost->title ?? 'N/A' }}</div>
                    <div class="text-[11px] font-bold text-accent-blue mt-0.5">{{ $app->jobPost->job_id ?? '' }}</div>
                    <div class="text-xs text-text-dark/60 mt-0.5 flex items-center gap-1">
                        <i class="fas fa-school text-[10px] text-text-dark/40"></i>
                        <span>{{ !empty($app->jobPost->school_name) ? $app->jobPost->school_name : ($app->jobPost->user->name ?? 'School') }}</span>
                    </div>
                    @if(!empty($app->jobPost->location))
                        <div class="text-[11px] text-text-dark/50 mt-0.5 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-[9px] text-text-dark/40"></i>
                            <span>{{ $app->jobPost->location }}</span>
                        </div>
                    @endif
                </td>
                <td class="align-top py-3.5 whitespace-nowrap">
                    <span class="{{ $app->status_badge_class }} px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider inline-block">
                        {{ $app->status_label }}
                    </span>
                    @if($app->interview_date)
                        <div class="text-[11px] text-purple-600 font-semibold mt-1.5 flex items-center gap-1">
                            <i class="fas fa-calendar-alt text-[10px]"></i> {{ $app->interview_date->format('d M, h:i A') }}
                        </div>
                    @endif
                </td>
                <td class="align-top py-3.5 max-w-[200px]">
                    @if($app->remarks)
                        <p class="text-xs text-text-dark/70" title="{{ $app->remarks }}">{{ $app->remarks }}</p>
                    @else
                        <span class="text-text-dark/30 text-xs italic">No remarks</span>
                    @endif
                    @if($app->cover_letter)
                        <div class="mt-1 text-[11px] text-slate-500 italic bg-secondary-bg p-1.5 rounded border border-card-border/60" title="{{ $app->cover_letter }}">
                            "{{ \Illuminate\Support\Str::limit($app->cover_letter, 60) }}"
                        </div>
                    @endif
                </td>
                <td class="align-top py-3.5 text-text-dark/60 text-xs whitespace-nowrap">
                    <div class="font-medium text-text-main">{{ $app->created_at->format('M d, Y') }}</div>
                    <div class="text-[10px] text-text-dark/40">{{ $app->created_at->diffForHumans() }}</div>
                </td>
                <td class="align-top py-3.5 text-right whitespace-nowrap">
                    <button type="button" 
                            data-id="{{ $app->id }}"
                            data-status="{{ $app->status }}"
                            data-remarks="{{ $app->remarks ?? '' }}"
                            data-interview-date="{{ $app->interview_date ? $app->interview_date->format('Y-m-d\TH:i') : '' }}"
                            data-interview-link="{{ $app->interview_link ?? '' }}"
                            onclick="handleStatusModalBtn(this)" 
                            class="px-3 py-1.5 rounded-lg bg-secondary-bg text-text-main border border-card-border hover:border-accent-blue hover:text-accent-blue text-xs font-semibold transition-colors shadow-xs">
                        <i class="fas fa-edit mr-1"></i> Update Status
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
                            <option value="rejected_by_school">Rejected by school/institute</option>
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
