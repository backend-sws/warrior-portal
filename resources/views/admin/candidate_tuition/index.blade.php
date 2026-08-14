@extends('layouts.admin')

@section('title', 'Candidate Tuition Appointments')
@section('subtitle', 'Appoint tutors to parent tuition leads and move them to Confirmed.')

@section('content')

@if(session('success'))
<div class="mb-4 bg-green-500/10 border border-green-500/30 text-green-700 px-5 py-3 rounded-xl flex items-center gap-3 font-semibold text-sm">
    <i class="fas fa-check-circle text-green-500 text-lg"></i>
    {{ session('success') }}
</div>
@endif

<!-- Page Header -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-text-main flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-accent-blue text-white flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher"></i>
            </span>
            Candidate Tuition
        </h1>
        <p class="text-text-dark/60 text-sm mt-1 ml-13">All registered candidates available for home tuition appointments.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.tuition-leads.confirmed') }}" class="bg-green-500/10 text-green-600 border border-green-500/20 px-4 py-2 rounded-xl font-bold hover:bg-green-500 hover:text-white transition-colors flex items-center gap-2 text-sm">
            <i class="fas fa-check-double"></i> View Confirmed Leads
        </a>
        <a href="{{ route('admin.crm.index') }}" class="bg-secondary-bg border border-card-border text-text-main px-4 py-2 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2 text-sm">
            <i class="fas fa-users"></i> All Candidates
        </a>
    </div>
</div>

<!-- Stats Bar -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-card-border p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/40 uppercase">Total Candidates</p>
            <p class="text-xl font-black text-text-main">{{ $candidates->total() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-card-border p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
            <i class="fas fa-list-alt"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/40 uppercase">Open Leads</p>
            <p class="text-xl font-black text-text-main">{{ $tuitionLeads->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-card-border p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-green-500/10 text-green-500 flex items-center justify-center">
            <i class="fas fa-handshake"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/40 uppercase">Awaiting Appointment</p>
            <p class="text-xl font-black text-text-main">{{ $tuitionLeads->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-card-border p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center">
            <i class="fas fa-info-circle"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/40 uppercase">How It Works</p>
            <p class="text-xs font-semibold text-text-dark/60">Click "Appoint" → Select Parent</p>
        </div>
    </div>
</div>

<!-- Search -->
<div class="bg-white rounded-xl border border-card-border shadow-sm mb-6 p-4">
    <form action="{{ route('admin.candidate-tuition.index') }}" method="GET" class="flex gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/30"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, phone or email..."
                   class="w-full pl-9 pr-4 py-2.5 border border-card-border rounded-lg text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue">
        </div>
        <button type="submit" class="bg-accent-blue text-white px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition-colors">
            <i class="fas fa-search mr-1"></i> Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.candidate-tuition.index') }}" class="px-4 py-2.5 border border-red-300 text-red-500 rounded-lg text-sm font-bold hover:bg-red-50 transition-colors">
                Clear
            </a>
        @endif
    </form>
</div>

<!-- Candidate Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($candidates as $candidate)
    @php $profile = $candidate->profile; @endphp
    <div class="bg-white rounded-2xl border border-card-border shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-[#041346] to-[#2a62bb] p-5 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/5 rounded-full"></div>
            <div class="absolute -left-4 -bottom-4 w-20 h-20 bg-white/5 rounded-full"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white text-2xl font-black flex-shrink-0">
                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-black text-white text-base leading-tight truncate">{{ $candidate->name }}</h3>
                    <p class="text-blue-200 text-xs mt-0.5 truncate">{{ $candidate->email }}</p>
                    @if($candidate->phone)
                        <p class="text-blue-100 text-xs font-semibold mt-0.5">
                            <i class="fas fa-phone text-[10px] mr-1"></i>{{ $candidate->phone }}
                        </p>
                    @endif
                </div>
                @if($profile && $profile->is_verified)
                    <span class="bg-green-400/20 text-green-300 border border-green-400/30 text-[10px] font-bold px-2 py-1 rounded-lg flex-shrink-0">
                        <i class="fas fa-check mr-1"></i>VERIFIED
                    </span>
                @endif
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-5">
            @if($profile)
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-secondary-bg rounded-lg p-2.5">
                        <p class="text-[10px] text-text-dark/40 font-bold uppercase tracking-wider mb-0.5">Subject</p>
                        <p class="text-sm font-bold text-text-main truncate">{{ $profile->subject->name ?? '—' }}</p>
                    </div>
                    <div class="bg-secondary-bg rounded-lg p-2.5">
                        <p class="text-[10px] text-text-dark/40 font-bold uppercase tracking-wider mb-0.5">Experience</p>
                        <p class="text-sm font-bold text-text-main">{{ $profile->experience_years ?? 0 }} yrs</p>
                    </div>
                    <div class="bg-secondary-bg rounded-lg p-2.5">
                        <p class="text-[10px] text-text-dark/40 font-bold uppercase tracking-wider mb-0.5">Preferred City</p>
                        <p class="text-sm font-bold text-text-main truncate">{{ $profile->preferredCity->name ?? '—' }}</p>
                    </div>
                    <div class="bg-secondary-bg rounded-lg p-2.5">
                        <p class="text-[10px] text-text-dark/40 font-bold uppercase tracking-wider mb-0.5">Category</p>
                        <p class="text-sm font-bold text-text-main truncate">{{ $profile->category->name ?? '—' }}</p>
                    </div>
                </div>

                @if($profile->residential_preference)
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-home text-text-dark/30 text-xs"></i>
                    <span class="text-xs text-text-dark/60 font-semibold capitalize">{{ $profile->residential_preference }} Tutor</span>
                    @if($profile->availability_to_join)
                        <span class="text-text-dark/30">•</span>
                        <span class="text-xs text-text-dark/60">Joining: {{ $profile->availability_to_join }}</span>
                    @endif
                </div>
                @endif
            @else
                <div class="text-center py-4 text-text-dark/40 text-xs mb-4">
                    <i class="fas fa-user-slash text-2xl mb-2 block"></i>
                    Profile not completed yet
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-2">
                @php $appliedLeadIds = $candidate->tuitionApplications->pluck('home_tuition_lead_id')->toJson(); @endphp
                <button onclick="openAppointModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}', '{{ $candidate->phone }}', {{ $appliedLeadIds }})"
                    class="flex-1 bg-accent-blue text-white py-2.5 px-4 rounded-xl font-bold text-sm hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 shadow-sm shadow-accent-blue/30">
                    <i class="fas fa-user-check"></i> Appoint to Parent
                </button>
                <a href="{{ route('admin.crm.show', $candidate->id) }}"
                    class="w-10 h-10 rounded-xl bg-secondary-bg border border-card-border text-text-dark/60 hover:bg-gray-100 flex items-center justify-center transition-colors" title="View Full Profile">
                    <i class="fas fa-eye text-sm"></i>
                </a>
                @if($candidate->phone)
                <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $candidate->phone) }}" target="_blank"
                    class="w-10 h-10 rounded-xl bg-green-500/10 border border-green-500/20 text-green-500 hover:bg-green-500 hover:text-white flex items-center justify-center transition-colors" title="WhatsApp">
                    <i class="fab fa-whatsapp text-sm"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-card-border">
        <div class="w-20 h-20 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-4 border border-card-border">
            <i class="fas fa-user-graduate text-3xl text-text-dark/20"></i>
        </div>
        <h3 class="font-bold text-text-main text-lg mb-1">No Candidates Found</h3>
        <p class="text-sm text-text-dark/50">No candidates registered yet. Add candidates from <a href="{{ route('admin.crm.create') }}" class="text-accent-blue underline">Candidates CRM</a>.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($candidates->hasPages())
<div class="mt-6">
    {{ $candidates->links('pagination::tailwind') }}
</div>
@endif


<!-- ===================== APPOINT MODAL ===================== -->
<div id="appoint-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col">
        
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-[#041346] to-[#1e3a8a] px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h3 class="font-black text-white text-lg">Appoint Candidate to Parent</h3>
                <p id="modal-candidate-name" class="text-blue-200 text-sm mt-0.5"></p>
            </div>
            <button onclick="closeAppointModal()" class="text-white/60 hover:text-white w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body: Lead List -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="mb-4">
                <p class="text-sm text-text-dark/70 font-medium">
                    <i class="fas fa-info-circle text-accent-blue mr-1"></i>
                    Select a parent whose tuition requirement you want to assign this candidate to. The lead will automatically move to <strong>Confirmed</strong> status.
                </p>
            </div>

            <!-- Search inside modal -->
            <div class="relative mb-4">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/30"></i>
                <input type="text" id="lead-search" placeholder="Filter by parent name, location, class..."
                    class="w-full pl-9 pr-4 py-2.5 border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue"
                    oninput="filterLeads(this.value)">
            </div>

            @if($tuitionLeads->count() > 0)
            <div id="leads-list" class="space-y-3">
                @foreach($tuitionLeads as $lead)
                <div class="lead-card border border-card-border rounded-xl p-4 hover:border-accent-blue hover:bg-blue-50/30 transition-all cursor-pointer group"
                     data-search="{{ strtolower($lead->parent_name . ' ' . $lead->location . ' ' . $lead->{'class'} . ' ' . $lead->subjects) }}"
                     data-lead-id="{{ $lead->id }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-text-main">{{ $lead->parent_name }}</h4>
                                <span class="applied-badge hidden bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded border border-green-200">
                                    <i class="fas fa-check-circle mr-1"></i>Applied Here
                                </span>
                                @php
                                    $statusColors = [
                                        'New Lead' => 'bg-blue-500/10 text-blue-600 border-blue-500/20',
                                        'Demo Scheduled' => 'bg-purple-500/10 text-purple-600 border-purple-500/20',
                                        'Demo Completed' => 'bg-indigo-500/10 text-indigo-600 border-indigo-500/20',
                                        'Pending' => 'bg-orange-500/10 text-orange-600 border-orange-500/20',
                                    ];
                                @endphp
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded border {{ $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                    {{ $lead->status }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-text-dark/60">
                                <div><i class="fas fa-phone mr-1"></i>{{ $lead->parent_mobile }}</div>
                                <div><i class="fas fa-map-marker-alt mr-1"></i>{{ $lead->location }}</div>
                                <div><i class="fas fa-graduation-cap mr-1"></i>Class: {{ $lead->{'class'} }}</div>
                                <div><i class="fas fa-book mr-1"></i>{{ Str::limit($lead->subjects, 25) }}</div>
                                @if($lead->tutor_preference)
                                <div><i class="fas fa-user mr-1"></i>Prefers: {{ $lead->tutor_preference }} tutor</div>
                                @endif
                            </div>
                        </div>
                        <!-- Select / Appoint Form -->
                        <form action="{{ route('admin.candidate-tuition.appoint', '__CANDIDATE_ID__') }}" method="POST" class="appoint-form flex-shrink-0" onsubmit="return confirmAppoint(this)">
                            @csrf
                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                            <button type="submit"
                                class="bg-accent-blue text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-700 transition-colors flex items-center gap-1.5 whitespace-nowrap shadow">
                                <i class="fas fa-check"></i> Appoint Here
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="no-leads-found" class="hidden text-center py-8 text-text-dark/40 text-sm">
                <i class="fas fa-search text-2xl mb-2 block"></i>
                No matching leads found.
            </div>
            @else
            <div class="text-center py-10 bg-secondary-bg rounded-xl border border-card-border">
                <i class="fas fa-folder-open text-3xl text-text-dark/20 mb-3 block"></i>
                <h4 class="font-bold text-text-main mb-1">No Open Tuition Leads</h4>
                <p class="text-sm text-text-dark/50">All leads are either Confirmed or Cancelled. 
                    <a href="{{ route('admin.tuition-leads.create') }}" class="text-accent-blue underline">Create a new lead</a>.
                </p>
            </div>
            @endif
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-card-border bg-secondary-bg/50 flex justify-between items-center flex-shrink-0">
            <p class="text-xs text-text-dark/50">
                <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                After appointment, lead goes to <strong>Confirmed</strong> → Admin gives final approval there.
            </p>
            <button onclick="closeAppointModal()" class="px-4 py-2 rounded-lg border border-card-border text-text-dark/60 font-bold text-sm hover:bg-gray-100 transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>


<script>
    var currentCandidateId = null;

    function openAppointModal(candidateId, candidateName, candidatePhone, appliedLeadIds = []) {
        currentCandidateId = candidateId;
        document.getElementById('modal-candidate-name').textContent = 
            'Appointing: ' + candidateName + (candidatePhone ? ' (' + candidatePhone + ')' : '');
        
        // Set candidate ID in all appoint forms
        document.querySelectorAll('.appoint-form').forEach(function(form) {
            var action = form.getAttribute('action');
            form.setAttribute('action', action.replace('__CANDIDATE_ID__', candidateId));
        });

        // Highlight leads that candidate has applied for
        document.querySelectorAll('.lead-card').forEach(function(card) {
            var leadId = parseInt(card.getAttribute('data-lead-id'));
            var badge = card.querySelector('.applied-badge');
            
            // Remove previous highlights
            card.classList.remove('border-green-500', 'bg-green-50/50');
            if (badge) badge.classList.add('hidden');
            
            if (appliedLeadIds.includes(leadId)) {
                card.classList.add('border-green-500', 'bg-green-50/50');
                if (badge) badge.classList.remove('hidden');
            }
        });

        document.getElementById('lead-search').value = '';
        filterLeads('');
        document.getElementById('appoint-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAppointModal() {
        document.getElementById('appoint-modal').classList.add('hidden');
        document.body.style.overflow = '';
        // Reset candidate IDs
        document.querySelectorAll('.appoint-form').forEach(function(form) {
            var action = form.getAttribute('action');
            // Replace numeric IDs back to placeholder
            form.setAttribute('action', action.replace(/\/\d+\/appoint/, '/__CANDIDATE_ID__/appoint'));
        });
    }

    function filterLeads(query) {
        var q = query.toLowerCase().trim();
        var cards = document.querySelectorAll('.lead-card');
        var anyVisible = false;
        cards.forEach(function(card) {
            var search = card.getAttribute('data-search') || '';
            var visible = q === '' || search.includes(q);
            card.style.display = visible ? '' : 'none';
            if (visible) anyVisible = true;
        });
        var noFound = document.getElementById('no-leads-found');
        if (noFound) noFound.classList.toggle('hidden', anyVisible);
    }

    function confirmAppoint(form) {
        return confirm('Confirm appointment? The lead will be moved to Confirmed status and assigned to this candidate.');
    }

    // Close modal on backdrop click
    document.getElementById('appoint-modal').addEventListener('click', function(e) {
        if (e.target === this) closeAppointModal();
    });
</script>

@endsection
