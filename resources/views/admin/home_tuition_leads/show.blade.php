@extends('layouts.admin')

@section('title', 'Manage Lead: ' . $lead->parent_name)
@section('subtitle', 'View lead details, update status, and manage follow-ups.')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.tuition-leads.index') }}" class="text-sm text-text-dark/60 hover:text-accent-blue transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Leads
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Lead Details -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Header Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-xl font-black border border-accent-blue/20">
                    {{ strtoupper(substr($lead->parent_name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-text-main">{{ $lead->parent_name }}</h2>
                    <div class="text-sm text-text-dark/60 mt-1">Enquired {{ $lead->enquiry_date ? $lead->enquiry_date->format('M d, Y') : 'Unknown' }}</div>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-2">
                @php
                    $statusColors = [
                        'New Lead' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                        'Demo Scheduled' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                        'Demo Completed' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                        'Confirmed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                        'Pending' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                        'Cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                    ];
                    $colorClass = $statusColors[$lead->status] ?? 'bg-gray-500/10 text-gray-500 border-gray-500/20';
                @endphp
                <span class="{{ $colorClass }} px-3 py-1.5 rounded-lg text-xs font-bold border uppercase tracking-wider flex items-center gap-1">
                    {{ $lead->status }}
                </span>
                
                @if($lead->follow_up_date)
                    <div class="text-xs font-bold text-orange-500 flex items-center gap-1 bg-orange-500/10 px-2 py-1 rounded">
                        <i class="fas fa-clock"></i> Next Follow-up: {{ $lead->follow_up_date->format('M d, Y') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Full Details Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-info-circle text-accent-blue"></i> Full Requirements
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-text-dark/40 mb-1">Contact Info</div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone w-4 text-text-dark/40"></i>
                                <a href="tel:{{ $lead->parent_mobile }}" class="text-sm font-semibold text-text-main hover:text-accent-blue transition-colors">{{ $lead->parent_mobile }}</a>
                                <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->parent_mobile) }}" target="_blank" class="text-green-500 hover:text-green-600 ml-2" title="WhatsApp Parent">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </a>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-map-marker-alt w-4 mt-1 text-text-dark/40"></i>
                                <span class="text-sm font-semibold text-text-main">{{ $lead->location }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-text-dark/40 mb-1">Tuition Details</div>
                        <ul class="space-y-2 text-sm text-text-main">
                            <li><span class="text-text-dark/60 inline-block w-20">Class:</span> <span class="font-semibold">{{ $lead->class }}</span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Subjects:</span> <span class="font-semibold">{{ $lead->subjects }}</span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Timing:</span> <span class="font-semibold">{{ $lead->preferred_timing ?: 'Not specified' }}</span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Tutor Pref:</span> <span class="font-semibold">{{ $lead->tutor_preference }}</span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Fee:</span> <span class="font-semibold text-green-500">{{ $lead->fee ?: 'Not discussed' }}</span></li>
                        </ul>
                    </div>

                    <div class="md:col-span-2 pt-4 border-t border-card-border">
                        <div class="text-[10px] uppercase font-bold tracking-widest text-text-dark/40 mb-1">Management Info</div>
                        <ul class="space-y-3 text-sm text-text-main">
                            <li class="flex items-center gap-2">
                                <span class="text-text-dark/60 w-32">Teacher Assigned:</span> 
                                @if($lead->teacher_contact)
                                    <span class="font-semibold bg-secondary-bg px-2 py-1 rounded border border-card-border flex items-center gap-2">
                                        {{ $lead->teacher_contact }}
                                        <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->teacher_contact) }}" target="_blank" class="text-green-500 hover:text-green-600" title="WhatsApp Teacher">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </span>
                                @else
                                    <span class="text-text-dark/40 italic">None assigned</span>
                                @endif
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-text-dark/60 w-32 shrink-0">Dues / Status:</span> 
                                <span class="font-semibold">{{ $lead->dues ?: 'No dues recorded' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Status & Follow-ups -->
    <div class="space-y-6">
        
        <!-- Update Status Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-tasks text-accent-blue"></i> Update Status
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.tuition-leads.status.update', $lead->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">New Status</label>
                        <select name="status" class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                            <option value="New Lead" {{ $lead->status === 'New Lead' ? 'selected' : '' }}>New Lead</option>
                            <option value="Demo Scheduled" {{ $lead->status === 'Demo Scheduled' ? 'selected' : '' }}>Demo Scheduled</option>
                            <option value="Demo Completed" {{ $lead->status === 'Demo Completed' ? 'selected' : '' }}>Demo Completed</option>
                            <option value="Confirmed" {{ $lead->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Pending" {{ $lead->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Cancelled" {{ $lead->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">Next Follow-up Date</label>
                        <input type="date" name="follow_up_date" value="{{ $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : '' }}"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">Teacher Contact (Optional)</label>
                        <input type="text" name="teacher_contact" value="{{ $lead->teacher_contact }}" placeholder="Assign a teacher..."
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                    </div>
                    
                    <button type="submit" class="w-full bg-accent-blue text-white rounded-xl px-4 py-2.5 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Follow-ups Timeline -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-history text-accent-blue"></i> Lead History
                </h3>
            </div>
            <div class="p-6">
                <!-- Add Note Form -->
                <form action="{{ route('admin.tuition-leads.followup.store', $lead->id) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea name="note" rows="2" placeholder="Add a follow-up note or conversation details..." required
                              class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all mb-3 resize-none"></textarea>
                    
                    <div class="flex items-center gap-3">
                        <input type="date" name="follow_up_date" title="Set Next Follow-up Date"
                               class="w-full px-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <button type="submit" class="bg-card-border text-text-main hover:bg-text-main hover:text-card-bg px-4 py-2 rounded-lg text-sm font-bold transition-colors whitespace-nowrap">
                            Add Note
                        </button>
                    </div>
                </form>

                <!-- Timeline -->
                <div class="space-y-4">
                    @forelse($lead->followUps()->latest()->get() as $followup)
                        <div class="relative pl-6 border-l-2 {{ $loop->first ? 'border-accent-blue' : 'border-card-border' }}">
                            <div class="absolute -left-[5px] top-1.5 w-2 h-2 rounded-full {{ $loop->first ? 'bg-accent-blue shadow-[0_0_0_4px_rgba(37,99,235,0.2)]' : 'bg-card-border' }}"></div>
                            
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-text-main">{{ $followup->admin->name ?? 'System' }}</span>
                                <span class="text-[10px] text-text-dark/40">{{ $followup->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="text-sm text-text-dark/80 whitespace-pre-wrap leading-relaxed">{{ $followup->note }}</div>
                            @if($followup->follow_up_date)
                                <div class="mt-2 text-xs font-bold text-orange-500 bg-orange-500/10 inline-block px-2 py-1 rounded">
                                    <i class="fas fa-clock"></i> Follow-up set for: {{ $followup->follow_up_date->format('M d, Y') }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 text-text-dark/40 text-sm">
                            No history or notes yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
