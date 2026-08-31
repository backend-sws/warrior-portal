@extends('layouts.admin')

@section('title', 'Schools & Colleges CRM')
@section('subtitle', 'Manage offline & registered educational institutions, track vacancies, and follow-up communication.')

@section('actions')
    <a href="{{ route('admin.schools.create') }}" class="px-5 py-2.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-blue-500/20 transition-all flex items-center gap-2">
        <i class="fas fa-plus"></i>
        <span>Add New School / Employer</span>
    </a>
@endsection

@section('content')

{{-- Quick Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.schools.index') }}"
       class="bg-card-bg border {{ !request('status') ? 'border-accent-blue ring-2 ring-accent-blue/20 bg-blue-50/10' : 'border-card-border hover:border-accent-blue/40' }} rounded-2xl p-4 sm:p-5 shadow-sm transition-all">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-text-dark/60">Total Schools</span>
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-accent-blue flex items-center justify-center text-sm font-bold">
                <i class="fas fa-school"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-text-main">{{ $stats['total'] ?? 0 }}</div>
        <span class="text-[11px] text-text-dark/50 mt-1 block font-medium">All Registered & Walk-in</span>
    </a>

    <a href="{{ route('admin.schools.index', ['status' => 'Active Client']) }}"
       class="bg-card-bg border {{ request('status') === 'Active Client' ? 'border-emerald-500 ring-2 ring-emerald-500/20 bg-emerald-50/10' : 'border-card-border hover:border-emerald-300' }} rounded-2xl p-4 sm:p-5 shadow-sm transition-all">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-text-dark/60">Active Clients</span>
            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-emerald-600">{{ $stats['active'] ?? 0 }}</div>
        <span class="text-[11px] text-emerald-600/80 mt-1 block font-medium">Hiring Actively</span>
    </a>

    <a href="{{ route('admin.schools.index', ['status' => 'Lead / Prospect']) }}"
       class="bg-card-bg border {{ request('status') === 'Lead / Prospect' ? 'border-amber-500 ring-2 ring-amber-500/20 bg-amber-50/10' : 'border-card-border hover:border-amber-300' }} rounded-2xl p-4 sm:p-5 shadow-sm transition-all">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-text-dark/60">New Inquiries / Leads</span>
            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">
                <i class="fas fa-bullhorn"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-amber-500">{{ $stats['leads'] ?? 0 }}</div>
        <span class="text-[11px] text-amber-600/80 mt-1 block font-medium">Follow-up Required</span>
    </a>

    <a href="{{ route('admin.schools.index', ['status' => 'In Discussion']) }}"
       class="bg-card-bg border {{ request('status') === 'In Discussion' ? 'border-purple-500 ring-2 ring-purple-500/20 bg-purple-50/10' : 'border-card-border hover:border-purple-300' }} rounded-2xl p-4 sm:p-5 shadow-sm transition-all">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-text-dark/60">In Discussion</span>
            <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm font-bold">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black text-purple-600">{{ $stats['in_talks'] ?? 0 }}</div>
        <span class="text-[11px] text-purple-600/80 mt-1 block font-medium">Negotiating / In Review</span>
    </a>
</div>

{{-- Search & Filter Bar --}}
<div class="bg-card-bg border border-card-border rounded-2xl p-4 sm:p-5 mb-6 shadow-sm">
    <form action="{{ route('admin.schools.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <!-- Search Query -->
        <div class="lg:col-span-2 relative">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by school name, contact person, phone, city..."
                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-xs sm:text-sm text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
        </div>

        <!-- Status Filter -->
        <div>
            <select name="status" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2.5 text-xs sm:text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                <option value="">All Statuses</option>
                <option value="Active Client" {{ request('status') === 'Active Client' ? 'selected' : '' }}>🟢 Active Client</option>
                <option value="Lead / Prospect" {{ request('status') === 'Lead / Prospect' ? 'selected' : '' }}>🟡 Lead / Prospect</option>
                <option value="In Discussion" {{ request('status') === 'In Discussion' ? 'selected' : '' }}>🟣 In Discussion</option>
                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>⚪ Inactive</option>
            </select>
        </div>

        <!-- Institution Type -->
        <div>
            <select name="institution_type" class="w-full bg-secondary-bg border border-card-border rounded-xl px-3 py-2.5 text-xs sm:text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                <option value="">All Institution Types</option>
                <option value="School" {{ request('institution_type') === 'School' ? 'selected' : '' }}>🏫 School</option>
                <option value="College" {{ request('institution_type') === 'College' ? 'selected' : '' }}>🎓 College</option>
                <option value="Coaching / Institute" {{ request('institution_type') === 'Coaching / Institute' ? 'selected' : '' }}>📚 Coaching / Institute</option>
                <option value="Preschool" {{ request('institution_type') === 'Preschool' ? 'selected' : '' }}>🧸 Preschool</option>
            </select>
        </div>

        <!-- Submit & Reset Buttons -->
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 px-4 py-2.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                <i class="fas fa-filter text-xs"></i> Filter
            </button>
            @if(request()->anyFilled(['search', 'status', 'institution_type', 'state_id', 'city_id']))
                <a href="{{ route('admin.schools.index') }}" class="px-3 py-2.5 bg-secondary-bg hover:bg-card-border text-text-dark/70 rounded-xl text-xs font-bold transition-all" title="Reset Filters">
                    <i class="fas fa-redo"></i>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Schools Table --}}
<div class="bg-card-bg border border-card-border rounded-2xl shadow-sm overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-card-border flex items-center justify-between">
        <div>
            <h3 class="text-sm sm:text-base font-bold text-text-main">Registered Schools & Educational Clients</h3>
            <p class="text-xs text-text-dark/60 mt-0.5">Showing {{ $schools->total() }} total recorded institutions</p>
        </div>
        <a href="{{ route('admin.schools.create') }}" class="text-xs font-bold text-accent-blue hover:underline flex items-center gap-1">
            <i class="fas fa-plus-circle"></i> + Add Manual School Entry
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left admin-table">
            <thead>
                <tr>
                    <th>School / Institute</th>
                    <th>Contact Person</th>
                    <th>Contact Info</th>
                    <th>Location & Board</th>
                    <th>Vacancies</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border">
                @forelse($schools as $school)
                    <tr class="hover:bg-secondary-bg/50 transition-colors">
                        <!-- School Name -->
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#031b4e] to-[#1e40af] text-white flex items-center justify-center font-black text-sm shadow-sm flex-shrink-0">
                                    {{ strtoupper(substr($school->school_name ?: 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.schools.show', $school->id) }}" class="text-sm font-bold text-text-main hover:text-accent-blue transition-colors block">
                                        {{ $school->school_name }}
                                    </a>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded mt-0.5">
                                        {{ $school->institution_type ?: 'School' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- Contact Person -->
                        <td>
                            <div class="text-xs font-bold text-text-main">{{ $school->contact_person ?: 'N/A' }}</div>
                            <span class="text-[10px] text-text-dark/50">Principal / HR / Admin</span>
                        </td>

                        <!-- Contact Info -->
                        <td>
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $school->phone ?: ($school->user?->phone ?? ''));
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-text-main">{{ $school->phone ?: ($school->user?->phone ?? 'N/A') }}</span>
                                @if($cleanPhone)
                                    <a href="https://wa.me/91{{ $cleanPhone }}" target="_blank" class="w-6 h-6 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-600 flex items-center justify-center text-[10px] transition-colors" title="WhatsApp Message">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="tel:{{ $cleanPhone }}" class="w-6 h-6 rounded-md bg-blue-50 hover:bg-blue-100 text-accent-blue flex items-center justify-center text-[10px] transition-colors" title="Call Now">
                                        <i class="fas fa-phone-alt"></i>
                                    </a>
                                @endif
                            </div>
                            @if($school->email || $school->user?->email)
                                <span class="text-[11px] text-text-dark/50 block mt-0.5 truncate max-w-[180px]" title="{{ $school->email ?: $school->user?->email }}">
                                    {{ $school->email ?: $school->user?->email }}
                                </span>
                            @endif
                        </td>

                        <!-- Location & Board -->
                        <td>
                            <div class="text-xs font-semibold text-text-main">
                                {{ $school->city?->name ?? 'City N/A' }}{{ $school->state ? ', ' . $school->state->name : '' }}
                            </div>
                            <span class="text-[10px] font-bold text-text-dark/50 mt-0.5 block">
                                {{ $school->board ?: 'Board Not Specified' }}
                            </span>
                        </td>

                        <!-- Vacancies -->
                        <td>
                            @php $jobsCount = $school->jobs->count(); @endphp
                            <a href="{{ route('admin.schools.show', $school->id) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold {{ $jobsCount > 0 ? 'bg-blue-50 text-accent-blue hover:bg-blue-100' : 'bg-slate-100 text-slate-500' }} transition-colors">
                                <i class="fas fa-briefcase text-[10px]"></i>
                                <span>{{ $jobsCount }} {{ Str::plural('Job', $jobsCount) }}</span>
                            </a>
                        </td>

                        <!-- Status -->
                        <td>
                            @if($school->status === 'Active Client')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Active Client
                                </span>
                            @elseif($school->status === 'Lead / Prospect')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    Lead / Prospect
                                </span>
                            @elseif($school->status === 'In Discussion')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-purple-100 text-purple-800 border border-purple-200">
                                    In Discussion
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $school->status ?: 'Registered' }}
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.schools.show', $school->id) }}" class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-accent-blue border border-blue-200 rounded-lg text-xs font-bold transition-colors" title="View CRM Profile">
                                    <i class="fas fa-eye text-[11px]"></i> Profile
                                </a>
                                <a href="{{ route('admin.schools.edit', $school->id) }}" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs transition-colors" title="Edit School">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                                <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this school record? All associated jobs will also be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center text-xs transition-colors cursor-pointer" title="Delete School">
                                        <i class="fas fa-trash text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-text-dark/50">
                            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-school"></i>
                            </div>
                            <h4 class="text-base font-bold text-text-main">No Schools or Institutions Found</h4>
                            <p class="text-xs text-text-dark/60 mt-1 max-w-sm mx-auto">No schools matching your search criteria. Add walk-in / offline school records manually.</p>
                            <a href="{{ route('admin.schools.create') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-accent-blue text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-all shadow">
                                <i class="fas fa-plus"></i> + Add First School Record
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($schools->hasPages())
        <div class="p-4 border-t border-card-border bg-secondary-bg/30">
            {{ $schools->links() }}
        </div>
    @endif
</div>

@endsection
