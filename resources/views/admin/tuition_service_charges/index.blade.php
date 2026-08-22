@extends('layouts.admin')

@section('title', 'Tuition Service Charges')
@section('subtitle', 'Track and manage teacher placement service charge invoices for home tuitions.')

@section('content')

{{-- Analytics Stats Cards (Clickable Filters) --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.tuition-service-charges.index', ['status' => '', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ !request('status') ? 'border-blue-500 ring-2 ring-blue-500/20 bg-blue-50/10' : 'border-card-border hover:border-blue-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Total Invoiced</p>
        <h4 class="text-2xl font-black text-blue-600 relative z-10">₹{{ number_format($stats['total_invoiced'], 2) }}</h4>
        <span class="text-[10px] text-slate-400 mt-0.5">{{ $stats['paid_count'] + $stats['pending_count'] }} Invoices</span>
    </a>

    <a href="{{ route('admin.tuition-service-charges.index', ['status' => 'paid', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'paid' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Collected / Paid</p>
        <h4 class="text-2xl font-black text-emerald-600 relative z-10">₹{{ number_format($stats['total_paid'], 2) }}</h4>
        <span class="text-[10px] text-emerald-600 font-bold mt-0.5">{{ $stats['paid_count'] }} Paid</span>
    </a>

    <a href="{{ route('admin.tuition-service-charges.index', ['status' => 'pending', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Pending Dues</p>
        <h4 class="text-2xl font-black text-amber-600 relative z-10">₹{{ number_format($stats['total_pending'], 2) }}</h4>
        <span class="text-[10px] text-amber-600 font-bold mt-0.5">{{ $stats['pending_count'] }} Pending</span>
    </a>

    <a href="{{ route('admin.tuition-service-charges.index', ['status' => 'overdue', 'search' => request('search')]) }}" 
       class="bg-card-bg border {{ request('status') === 'overdue' ? 'border-red-500 ring-2 ring-red-500/20 bg-red-50/10' : 'border-card-border hover:border-red-300' }} rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group transition-all cursor-pointer">
        <div class="absolute inset-0 bg-red-500/5 group-hover:bg-red-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Overdue Invoices</p>
        <h4 class="text-2xl font-black text-red-500 relative z-10">{{ $stats['overdue_count'] }}</h4>
        <span class="text-[10px] text-red-400 font-bold mt-0.5">Needs Follow-up</span>
    </a>
</div>

@if(session('success'))
    <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('info'))
    <div class="mb-5 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-sm">
        <i class="fas fa-info-circle text-blue-600 text-lg"></i>
        <span>{{ session('info') }}</span>
    </div>
@endif

{{-- Filter & Action Bar --}}
<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4 shadow-sm flex flex-col md:flex-row justify-between items-stretch md:items-center gap-3">
    <form action="{{ route('admin.tuition-service-charges.index') }}" method="GET" class="flex flex-1 flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3.5 top-3.5 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candidate, phone, tuition class or description..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
        </div>
        <div class="w-full sm:w-48">
            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3.5 py-2.5 text-sm text-text-main focus:border-accent-blue focus:outline-none cursor-pointer">
                <option value="">All Invoices</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
        </div>
        <button type="submit" class="bg-[#031b4e] text-white rounded-xl px-5 py-2.5 text-sm font-bold shadow hover:bg-[#021338] transition-colors flex items-center justify-center gap-2 shrink-0">
            <i class="fas fa-filter text-xs"></i> Filter
        </button>
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('admin.tuition-service-charges.index') }}" class="flex items-center justify-center px-3 py-2 text-text-dark/50 hover:text-red-500 transition-colors text-sm font-bold shrink-0">
                Clear
            </a>
        @endif
    </form>

    <button onclick="document.getElementById('createInvoiceModal').classList.remove('hidden')" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs sm:text-sm font-extrabold transition-all shadow flex items-center justify-center gap-2 shrink-0">
        <i class="fas fa-plus"></i> <span>Create Tuition Invoice</span>
    </button>
</div>

{{-- Invoices Table --}}
<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-xl mb-6">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Candidate (Tutor)</th>
                <th>Tuition Requirement</th>
                <th>Amount (₹)</th>
                <th>Due Date</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            @forelse($invoices as $inv)
            @php
                $isOverdue = ($inv->status !== 'paid' && $inv->due_date && $inv->due_date->isPast());
            @endphp
            <tr class="group hover:bg-slate-50/60 transition-colors">
                <td class="font-mono text-xs font-bold text-slate-600">
                    #{{ $inv->id }}
                </td>

                {{-- Candidate Details --}}
                <td>
                    <div class="font-bold text-text-main flex items-center gap-1.5">
                        <span>{{ $inv->candidate->name ?? 'Candidate' }}</span>
                    </div>
                    <div class="text-xs text-text-dark/70 font-mono">{{ $inv->candidate->phone ?? 'N/A' }}</div>
                    <div class="text-[11px] text-text-dark/50">{{ $inv->candidate->email ?? '' }}</div>
                    <div class="mt-1">
                        <a href="{{ route('admin.crm.show', $inv->candidate_id) }}" target="_blank" class="text-accent-blue text-[11px] font-bold hover:underline">
                            View Candidate Profile &rarr;
                        </a>
                    </div>
                </td>

                {{-- Tuition Details --}}
                <td>
                    @if($inv->tuitionLead)
                        <div class="font-extrabold text-[#031b4e]">
                            Class {{ $inv->tuitionLead->class }}
                            <span class="text-xs font-normal text-slate-500">({{ $inv->tuitionLead->board ?: 'General Board' }})</span>
                        </div>
                        <div class="text-xs font-semibold text-accent-blue mt-0.5">{{ $inv->tuitionLead->subjects }}</div>
                        <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1" title="{{ $inv->tuitionLead->location }}">
                            <i class="fas fa-map-marker-alt text-red-500 text-[10px] mr-1"></i> {{ $inv->tuitionLead->location }}
                        </div>
                    @else
                        <div class="font-semibold text-slate-700 text-xs">{{ $inv->description }}</div>
                    @endif
                </td>

                {{-- Amount --}}
                <td>
                    <div class="font-black text-sm text-[#031b4e]">
                        ₹{{ number_format($inv->amount, 2) }}
                    </div>
                    @if($inv->late_fee > 0)
                        <div class="text-[10px] text-red-500 font-bold">+ ₹{{ number_format($inv->late_fee, 2) }} Late Fee</div>
                    @endif
                </td>

                {{-- Due Date --}}
                <td class="text-xs whitespace-nowrap">
                    @if($inv->due_date)
                        <div class="font-bold {{ $isOverdue ? 'text-red-600' : 'text-slate-700' }}">
                            {{ $inv->due_date->format('d M Y') }}
                        </div>
                        @if($isOverdue)
                            <span class="text-[10px] font-black text-red-500 uppercase tracking-wider">Overdue</span>
                        @else
                            <span class="text-[10px] text-slate-400">{{ $inv->due_date->diffForHumans() }}</span>
                        @endif
                    @else
                        <span class="text-slate-400">N/A</span>
                    @endif
                </td>

                {{-- Status --}}
                <td>
                    @if($inv->status === 'paid')
                        <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-check-circle text-emerald-600"></i> Paid
                        </span>
                        @if($inv->paid_at)
                            <div class="text-[10px] text-slate-400 mt-1 font-mono">{{ $inv->paid_at->format('d M Y') }}</div>
                        @endif
                    @elseif($isOverdue)
                        <span class="bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider">
                            Overdue
                        </span>
                    @else
                        <span class="bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider">
                            Pending
                        </span>
                    @endif
                </td>

                {{-- Actions --}}
                <td class="text-right whitespace-nowrap">
                    <div class="flex items-center justify-end gap-1.5">
                        {{-- Mark as Paid --}}
                        @if($inv->status !== 'paid')
                            <form action="{{ route('admin.tuition-service-charges.mark-paid', $inv->id) }}" method="POST" onsubmit="return confirm('Mark this Tuition Service Charge of ₹{{ number_format($inv->amount, 2) }} as PAID?');">
                                @csrf
                                <button type="submit" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-extrabold transition-colors shadow-sm flex items-center gap-1" title="Mark as Paid">
                                    <i class="fas fa-check"></i> Collect
                                </button>
                            </form>
                        @endif

                        {{-- WhatsApp Reminder --}}
                        @if($inv->candidate && $inv->candidate->phone && $inv->status !== 'paid')
                            @php
                                $waMsg = "Hello " . $inv->candidate->name . ", this is a reminder from Warriors Educare regarding your pending Tuition Service Charge of ₹" . number_format($inv->amount, 2) . " for " . $inv->description . ". Due Date: " . ($inv->due_date ? $inv->due_date->format('d M Y') : 'Immediate') . ". Please log in to your portal to pay.";
                            @endphp
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $inv->candidate->phone) }}?text={{ urlencode($waMsg) }}" target="_blank" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center transition-colors shadow-sm" title="WhatsApp Reminder">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif

                        {{-- Email Reminder --}}
                        @if($inv->status !== 'paid')
                            <form action="{{ route('admin.tuition-service-charges.remind', $inv->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors shadow-sm" title="Send Email Reminder">
                                    <i class="fas fa-bell"></i>
                                </button>
                            </form>
                        @endif

                        {{-- Edit Modal Trigger --}}
                        <button onclick="openEditModal({{ $inv->id }}, '{{ $inv->amount }}', '{{ $inv->due_date ? $inv->due_date->format('Y-m-d') : '' }}', '{{ addslashes($inv->description ?? '') }}', '{{ $inv->status }}')" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 flex items-center justify-center transition-colors shadow-sm" title="Edit Invoice">
                            <i class="fas fa-edit text-xs"></i>
                        </button>

                        {{-- Delete --}}
                        <form action="{{ route('admin.tuition-service-charges.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-colors shadow-sm" title="Delete Invoice">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-12 text-center text-slate-400">
                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400 text-xl">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <p class="font-bold text-sm text-slate-600">No tuition service charge invoices found.</p>
                    <p class="text-xs text-slate-400 mt-1">Invoices generated for home tuition assignments will be tracked here.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($invoices->hasPages())
    <div class="mb-8">
        {{ $invoices->links() }}
    </div>
@endif

{{-- Create Invoice Modal --}}
<div id="createInvoiceModal" class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-3">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-slate-200">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-[#031b4e] text-white">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-accent-yellow block">Home Tuition</span>
                <h3 class="text-base font-bold">Create Tuition Service Charge</h3>
            </div>
            <button onclick="document.getElementById('createInvoiceModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <form action="{{ route('admin.tuition-service-charges.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Select Candidate (Tutor) <span class="text-red-500">*</span></label>
                <select name="candidate_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                    <option value="">Select Candidate</option>
                    @foreach($candidates as $cand)
                        <option value="{{ $cand->id }}">{{ $cand->name }} ({{ $cand->phone }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Associated Tuition Requirement (Optional)</label>
                <select name="home_tuition_lead_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                    <option value="">General Tuition Service Charge</option>
                    @foreach($tuitionLeads as $lead)
                        <option value="{{ $lead->id }}">Class {{ $lead->class }} - {{ $lead->subjects }} ({{ $lead->parent_name }}, {{ $lead->location }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Amount (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" required value="500" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Due Date <span class="text-red-500">*</span></label>
                    <input type="date" name="due_date" required value="{{ now()->addDays(7)->format('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Description</label>
                <input type="text" name="description" placeholder="e.g. Service Charge for Home Tuition Assignment" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('createInvoiceModal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-extrabold text-xs transition-all shadow-md flex items-center gap-1.5">
                    <i class="fas fa-save"></i> Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Invoice Modal --}}
<div id="editInvoiceModal" class="fixed inset-0 z-[9999] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-3">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-slate-200">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-[#031b4e] text-white">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-accent-yellow block">Update Invoice</span>
                <h3 class="text-base font-bold" id="editModalTitle">Edit Service Charge</h3>
            </div>
            <button onclick="document.getElementById('editInvoiceModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <form id="editInvoiceForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Amount (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" id="editAmount" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Due Date <span class="text-red-500">*</span></label>
                    <input type="date" name="due_date" id="editDueDate" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Status <span class="text-red-500">*</span></label>
                <select name="status" id="editStatus" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 cursor-pointer">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Description <span class="text-red-500">*</span></label>
                <input type="text" name="description" id="editDesc" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-2.5">
                <button type="button" onclick="document.getElementById('editInvoiceModal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-accent-blue hover:bg-accent-blue-hover text-white rounded-xl font-extrabold text-xs transition-all shadow-md flex items-center gap-1.5">
                    <i class="fas fa-save"></i> Update Invoice
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(invId, amount, dueDate, description, status) {
    document.getElementById('editInvoiceForm').action = `/admin/tuition-service-charges/${invId}`;
    document.getElementById('editModalTitle').innerText = `Edit Invoice #${invId}`;
    document.getElementById('editAmount').value = amount;
    document.getElementById('editDueDate').value = dueDate;
    document.getElementById('editDesc').value = description;
    document.getElementById('editStatus').value = status;
    document.getElementById('editInvoiceModal').classList.remove('hidden');
}
</script>

@endsection
