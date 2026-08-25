@extends('layouts.admin')

@section('title', 'Tuition Applications')
@section('subtitle', 'Track and manage candidate tutor applications for home tuition requirements.')

@section('content')

{{-- Analytics Stats Cards (Clickable Filters) --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <a href="{{ route('admin.tuition-applications.index', ['status' => '', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ !request('status') ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/10' : 'border-card-border hover:border-blue-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Total Applications</p>
        <h4 class="text-2xl font-black text-blue-600 relative z-10">{{ $stats['total'] }}</h4>
        <span class="text-[10px] text-slate-400 mt-0.5">All Submissions</span>
    </a>

    <a href="{{ route('admin.tuition-applications.index', ['status' => 'Applied', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'Applied' ? 'border-sky-500 ring-2 ring-sky-500/20 bg-sky-50/10' : 'border-card-border hover:border-sky-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-sky-500/5 group-hover:bg-sky-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">New (Applied)</p>
        <h4 class="text-2xl font-black text-sky-600 relative z-10">{{ $stats['applied'] }}</h4>
        <span class="text-[10px] text-sky-600 font-bold mt-0.5">Under Review</span>
    </a>

    <a href="{{ route('admin.tuition-applications.index', ['status' => 'Shortlisted', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'Shortlisted' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Shortlisted</p>
        <h4 class="text-2xl font-black text-amber-600 relative z-10">{{ $stats['shortlisted'] }}</h4>
        <span class="text-[10px] text-amber-600 font-bold mt-0.5">Demo Scheduled</span>
    </a>

    <a href="{{ route('admin.tuition-applications.index', ['status' => 'Assigned', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'Assigned' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Assigned Tutors</p>
        <h4 class="text-2xl font-black text-emerald-600 relative z-10">{{ $stats['assigned'] }}</h4>
        <span class="text-[10px] text-emerald-600 font-bold mt-0.5">Confirmed & Placed</span>
    </a>

    <a href="{{ route('admin.tuition-applications.index', ['status' => 'Rejected', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'Rejected' ? 'border-red-500 ring-2 ring-red-500/20 bg-red-50/10' : 'border-card-border hover:border-red-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-red-500/5 group-hover:bg-red-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Rejected</p>
        <h4 class="text-2xl font-black text-red-500 relative z-10">{{ $stats['rejected'] }}</h4>
        <span class="text-[10px] text-red-400 font-bold mt-0.5">Not Selected</span>
    </a>
</div>

@if(session('success'))
    <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-5 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
        <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Filter Form --}}
<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4 shadow-sm">
    <form action="{{ route('admin.tuition-applications.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3.5 top-3.5 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidate, phone, subject, class or location..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
        </div>
        <div class="w-full md:w-52">
            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3.5 py-2.5 text-sm text-text-main focus:border-accent-blue focus:outline-none cursor-pointer">
                <option value="">All Statuses</option>
                <option value="Applied" {{ request('status') === 'Applied' ? 'selected' : '' }}>New (Applied)</option>
                <option value="Shortlisted" {{ request('status') === 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                <option value="Assigned" {{ request('status') === 'Assigned' ? 'selected' : '' }}>Assigned Tutor</option>
                <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="bg-[#031b4e] text-white rounded-xl px-6 py-2.5 text-sm font-bold shadow hover:bg-[#021338] transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-filter text-xs"></i> Filter
        </button>
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('admin.tuition-applications.index') }}" class="flex items-center justify-center px-4 py-2 text-text-dark/50 hover:text-red-500 transition-colors text-sm font-bold">
                Clear
            </a>
        @endif
    </form>
</div>

{{-- Applications Table --}}
<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-xl mb-6">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                <th>Candidate (Tutor)</th>
                <th>Tuition Requirement</th>
                <th>Parent & Location</th>
                <th>Status</th>
                <th>Demo Date / Remarks</th>
                <th>Applied On</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($applications as $app)
            <tr class="group hover:bg-slate-50/60 transition-colors">
                {{-- Candidate Info --}}
                <td>
                    <div class="font-bold text-text-main flex items-center gap-2">
                        <span>{{ $app->candidate->name }}</span>
                    </div>
                    <div class="text-xs text-text-dark/70 font-mono mt-0.5">{{ $app->candidate->phone }}</div>
                    <div class="text-[11px] text-text-dark/50">{{ $app->candidate->email }}</div>
                    <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-2">
                        <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold">
                            {{ $app->candidate->profile?->highestQualification?->name ?? 'N/A' }}
                        </span>
                        <a href="{{ route('admin.crm.show', $app->candidate->id) }}" target="_blank" class="text-accent-blue hover:underline font-bold">
                            Profile &rarr;
                        </a>
                    </div>
                </td>

                {{-- Tuition Details --}}
                <td>
                    @if($app->tuitionLead)
                        <div class="font-extrabold text-[#031b4e]">
                            Class {{ $app->tuitionLead->class }}
                            <span class="text-xs font-normal text-slate-500">({{ $app->tuitionLead->board ?: 'General Board' }})</span>
                        </div>
                        <div class="text-xs font-semibold text-accent-blue mt-0.5">{{ $app->tuitionLead->subjects }}</div>
                        <div class="text-[11px] text-slate-500 mt-1">
                            <a href="{{ route('admin.tuition-leads.show', $app->tuitionLead->id) }}" target="_blank" class="text-purple-600 hover:underline font-bold">
                                View Tuition Lead &rarr;
                            </a>
                        </div>
                    @else
                        <span class="text-xs text-red-400 font-bold">Lead deleted / removed</span>
                    @endif
                </td>

                {{-- Parent & Location --}}
                <td>
                    @if($app->tuitionLead)
                        <div class="font-semibold text-text-main">{{ $app->tuitionLead->parent_name }}</div>
                        <div class="text-xs text-slate-500 font-mono">{{ $app->tuitionLead->parent_mobile }}</div>
                        <div class="text-xs text-slate-600 mt-1 flex items-center gap-1 line-clamp-1" title="{{ $app->tuitionLead->location }}">
                            <i class="fas fa-map-marker-alt text-red-500 text-xs shrink-0"></i>
                            <span>{{ $app->tuitionLead->location }}</span>
                        </div>
                    @else
                        <span class="text-xs text-slate-400">N/A</span>
                    @endif
                </td>

                {{-- Status Badge --}}
                <td>
                    @if($app->status === 'Applied')
                        <span class="bg-sky-50 text-sky-700 border border-sky-200 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider">
                            Applied
                        </span>
                    @elseif($app->status === 'Shortlisted')
                        <span class="bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider">
                            Shortlisted
                        </span>
                    @elseif($app->status === 'Assigned')
                        <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-check-circle"></i> Assigned
                        </span>
                    @elseif($app->status === 'Rejected')
                        <span class="bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider">
                            Rejected
                        </span>
                    @endif
                </td>

                {{-- Demo Date & Remarks --}}
                <td>
                    @if($app->demo_date)
                        <div class="text-xs font-bold text-purple-700 flex items-center gap-1">
                            <i class="fas fa-calendar-alt text-xs"></i>
                            {{ $app->demo_date->format('d M Y, h:i A') }}
                        </div>
                    @endif
                    @if($app->remarks)
                        <div class="text-xs text-slate-600 mt-1 italic line-clamp-2" title="{{ $app->remarks }}">
                            "{{ $app->remarks }}"
                        </div>
                    @elseif(!$app->demo_date)
                        <span class="text-xs text-slate-400 font-normal">None</span>
                    @endif
                </td>

                {{-- Applied Date --}}
                <td class="text-xs text-slate-500 whitespace-nowrap">
                    <div>{{ $app->created_at->format('d M Y') }}</div>
                    <div class="text-[10px] text-slate-400">{{ $app->created_at->diffForHumans() }}</div>
                </td>

                {{-- Actions --}}
                <td class="text-right whitespace-nowrap">
                    <div class="flex items-center justify-end gap-1.5">
                        {{-- WhatsApp Candidate --}}
                        <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $app->candidate->phone) }}?text=Hello%20{{ urlencode($app->candidate->name) }},%20regarding%20your%20application%20for%20Home%20Tuition%20(Class%20{{ urlencode($app->tuitionLead?->class ?? '') }}%20{{ urlencode($app->tuitionLead?->subjects ?? '') }})..." target="_blank" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center transition-colors shadow-sm" title="WhatsApp Candidate">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                        {{-- Quick Update Status Modal Trigger --}}
                        <button onclick="openStatusModal({{ $app->id }}, '{{ $app->status }}', '{{ addslashes($app->remarks ?? '') }}', '{{ $app->demo_date ? $app->demo_date->format('Y-m-d\TH:i') : '' }}', '{{ addslashes($app->candidate->name) }}', '{{ addslashes($app->tuitionLead?->class ?? '') }}', '{{ addslashes($app->tuitionLead?->subjects ?? '') }}')" class="px-3 py-1.5 bg-[#031b4e] hover:bg-[#021338] text-white rounded-xl text-xs font-bold transition-all shadow flex items-center gap-1.5">
                            <i class="fas fa-edit text-[10px]"></i> <span>Status</span>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-12 text-center text-slate-400">
                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400 text-xl">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="font-bold text-sm text-slate-600">No tuition applications found.</p>
                    <p class="text-xs text-slate-400 mt-1">Applications submitted by teachers for home tuitions will appear here.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($applications->hasPages())
    <div class="mb-8">
        {{ $applications->links() }}
    </div>
@endif

{{-- Status Update Modal --}}
<div id="statusModal" class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-3">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-slate-200">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-[#031b4e] text-white">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-accent-yellow block">Tuition Application</span>
                <h3 class="text-base font-bold" id="modalCandidateTitle">Update Application Status</h3>
            </div>
            <button onclick="closeStatusModal()" class="w-8 h-8 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <form id="statusForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Application Status <span class="text-red-500">*</span></label>
                <select name="status" id="modalStatusSelect" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                    <option value="Applied">Applied (Under Review)</option>
                    <option value="Shortlisted">Shortlisted (Selected for Demo)</option>
                    <option value="Assigned">Assigned (Confirmed as Tutor & Assigned to Parent)</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            {{-- Demo Session (Hidden if Rejected) --}}
            <div id="demoSessionContainer">
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Schedule Demo Session (Optional)</label>
                <input type="datetime-local" name="demo_date" id="modalDemoDate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                <p class="text-[11px] text-slate-400 mt-1">If set, candidate will receive an instant notification & email with this demo date & time.</p>
            </div>

            {{-- Service Charge Invoice Generation (Shown when Assigned) --}}
            <div id="serviceChargeBox" class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 space-y-3">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="create_service_charge" value="1" id="createServiceChargeCheckbox" class="w-4 h-4 text-emerald-600 rounded border-emerald-300 focus:ring-emerald-500 cursor-pointer" onchange="toggleServiceChargeFields()">
                    <span class="text-xs font-bold text-emerald-900">
                        <i class="fas fa-file-invoice-dollar mr-1"></i> Generate Candidate Service Charge Invoice
                    </span>
                </label>

                <div id="serviceChargeFields" class="hidden space-y-3 pt-2 border-t border-emerald-200/60">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-emerald-900 mb-1">Charge Amount (₹)</label>
                            <input type="number" step="0.01" name="service_charge_amount" id="serviceChargeAmount" value="500" class="w-full bg-white border border-emerald-300 rounded-xl px-3 py-2 text-xs font-bold text-[#031b4e]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-emerald-900 mb-1">Due Date <span class="text-xs text-emerald-600 font-normal">(Triggers Reminders)</span></label>
                            <input type="date" name="service_charge_due_date" id="serviceChargeDueDate" value="{{ now()->addDays(7)->format('Y-m-d') }}" class="w-full bg-white border border-emerald-300 rounded-xl px-3 py-2 text-xs font-bold text-[#031b4e]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-emerald-900 mb-1">Invoice Description</label>
                        <input type="text" name="service_charge_description" id="serviceChargeDesc" value="Service Charge for Home Tuition Assignment" class="w-full bg-white border border-emerald-300 rounded-xl px-3 py-2 text-xs text-[#031b4e]">
                    </div>
                    <p class="text-[10px] text-emerald-700 font-medium">
                        <i class="fas fa-bell mr-1"></i> When this Due Date arrives, automated collection alerts & email reminders will be sent to the candidate and displayed in the Admin Reminder Center.
                    </p>
                </div>
            </div>

            {{-- Remarks / Rejection Reason --}}
            <div>
                <label id="remarksLabel" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Admin Remarks / Notes</label>
                <textarea name="remarks" id="modalRemarks" rows="2" placeholder="Enter internal notes, interview feedback, or remarks..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 resize-none transition-all"></textarea>
                <p id="remarksHelper" class="text-[11px] text-slate-400 mt-1">Remarks will be included in the candidate's dashboard update and email.</p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2.5">
                <button type="button" onclick="closeStatusModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl font-extrabold text-xs transition-all shadow-md flex items-center gap-1.5">
                    <i class="fas fa-save"></i> Save Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateModalFieldsForStatus(status) {
    const remarksLabel = document.getElementById('remarksLabel');
    const remarksInput = document.getElementById('modalRemarks');
    const remarksHelper = document.getElementById('remarksHelper');
    const serviceChargeBox = document.getElementById('serviceChargeBox');
    const demoSessionContainer = document.getElementById('demoSessionContainer');
    const createChargeCheckbox = document.getElementById('createServiceChargeCheckbox');

    if (status === 'Rejected') {
        remarksLabel.innerHTML = '<span class="text-red-600 font-black"><i class="fas fa-times-circle mr-1"></i> Rejection Reason / Feedback *</span> <span class="text-[10px] text-red-500 font-normal lowercase">(Sent to candidate via email & dashboard)</span>';
        remarksInput.placeholder = 'e.g. Profile location mismatch, candidate requested higher fee than parent budget, etc.';
        remarksInput.classList.add('border-red-300', 'bg-red-50/30');
        remarksHelper.innerText = 'Candidate will clearly see this reason on their dashboard and in their status email.';
        remarksHelper.classList.add('text-red-500');

        serviceChargeBox.classList.add('hidden');
        demoSessionContainer.classList.add('hidden');
        createChargeCheckbox.checked = false;
    } else if (status === 'Assigned') {
        remarksLabel.innerHTML = '<span class="text-emerald-700 font-black"><i class="fas fa-check-circle mr-1"></i> Assignment Notes & Instructions</span>';
        remarksInput.placeholder = 'e.g. Parent prefers evening classes from 5 PM to 6:30 PM. Please carry intro notes.';
        remarksInput.classList.remove('border-red-300', 'bg-red-50/30');
        remarksHelper.innerText = 'Candidate will receive these instructions with parent contact details.';
        remarksHelper.classList.remove('text-red-500');

        serviceChargeBox.classList.remove('hidden');
        demoSessionContainer.classList.remove('hidden');
        createChargeCheckbox.checked = true;
    } else if (status === 'Shortlisted') {
        remarksLabel.innerHTML = '<span class="text-amber-700 font-black"><i class="fas fa-star mr-1"></i> Shortlisting Notes / Demo Guidelines</span>';
        remarksInput.placeholder = 'e.g. Shortlisted for Class 10th Maths demo. Be prepared for chapter 1 & 2.';
        remarksInput.classList.remove('border-red-300', 'bg-red-50/30');
        remarksHelper.innerText = 'Included in candidate shortlist notification & email.';
        remarksHelper.classList.remove('text-red-500');

        serviceChargeBox.classList.add('hidden');
        demoSessionContainer.classList.remove('hidden');
        createChargeCheckbox.checked = false;
    } else {
        remarksLabel.innerHTML = 'Admin Remarks / Notes';
        remarksInput.placeholder = 'Enter internal notes, interview feedback, or remarks...';
        remarksInput.classList.remove('border-red-300', 'bg-red-50/30');
        remarksHelper.innerText = 'Remarks will be included in the candidate dashboard update.';
        remarksHelper.classList.remove('text-red-500');

        serviceChargeBox.classList.add('hidden');
        demoSessionContainer.classList.remove('hidden');
        createChargeCheckbox.checked = false;
    }
    toggleServiceChargeFields();
}

function openStatusModal(appId, status, remarks, demoDate, candidateName, className, subjects) {
    document.getElementById('statusForm').action = `/admin/tuition-applications/${appId}/status`;
    document.getElementById('modalCandidateTitle').innerText = `${candidateName} (Class ${className} - ${subjects})`;
    document.getElementById('modalStatusSelect').value = status;
    document.getElementById('modalRemarks').value = remarks || '';
    document.getElementById('modalDemoDate').value = demoDate || '';
    document.getElementById('serviceChargeDesc').value = `Service Charge for Home Tuition (Class ${className} - ${subjects})`;
    
    updateModalFieldsForStatus(status);

    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

function toggleServiceChargeFields() {
    const isChecked = document.getElementById('createServiceChargeCheckbox').checked;
    const fields = document.getElementById('serviceChargeFields');
    if (isChecked) {
        fields.classList.remove('hidden');
    } else {
        fields.classList.add('hidden');
    }
}

document.getElementById('modalStatusSelect').addEventListener('change', function() {
    updateModalFieldsForStatus(this.value);
});
</script>

@endsection
