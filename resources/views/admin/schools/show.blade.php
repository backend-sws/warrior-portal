@extends('layouts.admin')

@section('title', $school->school_name)
@section('subtitle', 'School CRM Profile, Active Vacancies & Communication History')

@section('actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.schools.edit', $school->id) }}" class="px-4 py-2 bg-secondary-bg hover:bg-slate-200 border border-card-border text-text-main rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-1.5">
            <i class="fas fa-pen text-xs"></i> Edit Details
        </a>
        <a href="{{ route('admin.schools.index') }}" class="px-4 py-2 bg-secondary-bg hover:bg-slate-200 border border-card-border text-text-main rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> All Schools
        </a>
    </div>
@endsection

@section('content')

@php
    $cleanPhone = preg_replace('/[^0-9]/', '', $school->phone ?: ($school->user?->phone ?? ''));
@endphp

<div class="space-y-6" x-data="{ postJobModalOpen: false }">

    {{-- Top Profile Banner --}}
    <div class="bg-card-bg border border-card-border rounded-3xl p-6 sm:p-8 shadow-sm relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4 sm:gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-gradient-to-br from-[#031b4e] to-[#1e40af] text-white flex items-center justify-center font-black text-2xl sm:text-3xl shadow-lg shadow-blue-900/20 flex-shrink-0">
                    {{ strtoupper(substr($school->school_name ?: 'S', 0, 1)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h2 class="text-xl sm:text-2xl font-black text-text-main tracking-tight">{{ $school->school_name }}</h2>
                        
                        @if($school->status === 'Active Client')
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                🟢 Active Client
                            </span>
                        @elseif($school->status === 'Lead / Prospect')
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                🟡 Lead / Prospect
                            </span>
                        @elseif($school->status === 'In Discussion')
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-purple-100 text-purple-800 border border-purple-200">
                                🟣 In Discussion
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $school->status ?: 'Registered' }}
                            </span>
                        @endif
                    </div>

                    <p class="text-xs sm:text-sm text-text-dark/60 flex flex-wrap items-center gap-3">
                        <span><i class="fas fa-building text-accent-blue mr-1"></i> {{ $school->institution_type ?: 'School' }}</span>
                        @if($school->board)
                            <span>•</span>
                            <span><i class="fas fa-award text-amber-500 mr-1"></i> {{ $school->board }}</span>
                        @endif
                        <span>•</span>
                        <span><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $school->city?->name ?? 'City N/A' }}{{ $school->state ? ', ' . $school->state->name : '' }}</span>
                    </p>
                </div>
            </div>

            {{-- Quick Action Buttons --}}
            <div class="flex items-center gap-2.5 w-full md:w-auto">
                @if($cleanPhone)
                    <a href="https://wa.me/91{{ $cleanPhone }}" target="_blank" class="flex-1 md:flex-initial px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-xs">
                        <i class="fab fa-whatsapp text-sm text-emerald-600"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="tel:{{ $cleanPhone }}" class="flex-1 md:flex-initial px-4 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-accent-blue border border-blue-200 text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-xs">
                        <i class="fas fa-phone-alt text-sm"></i>
                        <span>Call</span>
                    </a>
                @endif
                <button type="button" @click="postJobModalOpen = true" class="flex-1 md:flex-initial px-5 py-2.5 rounded-xl bg-accent-blue hover:bg-blue-700 text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-md shadow-blue-500/20 cursor-pointer">
                    <i class="fas fa-plus"></i>
                    <span>Post New Vacancy</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Main Grid: Details (Left) + Vacancies & Followups (Right) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: School Contact & Details --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-card-bg border border-card-border rounded-2xl p-5 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-text-dark/70 uppercase tracking-wider border-b border-card-border pb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-accent-blue"></i>
                    <span>Institution Information</span>
                </h3>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-text-dark/50 block font-medium">Principal / Contact Person:</span>
                        <span class="text-sm font-bold text-text-main mt-0.5 block">{{ $school->contact_person ?: 'N/A' }}</span>
                    </div>

                    <div>
                        <span class="text-text-dark/50 block font-medium">Mobile / Phone:</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-sm font-bold text-text-main">{{ $school->phone ?: ($school->user?->phone ?? 'N/A') }}</span>
                            @if($school->alt_phone)
                                <span class="text-[11px] text-text-dark/50">/ {{ $school->alt_phone }}</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="text-text-dark/50 block font-medium">Email Address:</span>
                        <span class="text-xs font-semibold text-text-main mt-0.5 block break-all">{{ $school->email ?: ($school->user?->email ?? 'N/A') }}</span>
                    </div>

                    <div>
                        <span class="text-text-dark/50 block font-medium">Location / Address:</span>
                        <p class="text-xs font-medium text-text-main mt-0.5">
                            {{ $school->address ?: 'Address not provided' }}<br>
                            <span class="text-text-dark/60 font-semibold">{{ $school->city?->name ?? 'City N/A' }}{{ $school->state ? ', ' . $school->state->name : '' }}</span>
                        </p>
                    </div>

                    @if($school->website)
                        <div>
                            <span class="text-text-dark/50 block font-medium">Website:</span>
                            <a href="{{ Str::startsWith($school->website, 'http') ? $school->website : 'https://' . $school->website }}" target="_blank" class="text-accent-blue hover:underline font-bold mt-0.5 block truncate">
                                {{ $school->website }}
                            </a>
                        </div>
                    @endif

                    @if($school->notes)
                        <div class="pt-3 border-t border-card-border">
                            <span class="text-text-dark/50 block font-medium mb-1">Admin Offline Notes:</span>
                            <div class="p-3 bg-secondary-bg rounded-xl text-xs text-text-main leading-relaxed border border-card-border">
                                {{ $school->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Summary Stats --}}
            <div class="bg-card-bg border border-card-border rounded-2xl p-5 shadow-sm">
                <h3 class="text-xs font-bold text-text-dark/70 uppercase tracking-wider border-b border-card-border pb-3 mb-3">
                    Activity Summary
                </h3>
                <div class="grid grid-cols-2 gap-3 text-center">
                    <div class="p-3 rounded-xl bg-blue-50 border border-blue-100">
                        <div class="text-xl font-black text-accent-blue">{{ $school->jobs->count() }}</div>
                        <span class="text-[10px] font-bold text-text-dark/60 uppercase">Jobs Posted</span>
                    </div>
                    <div class="p-3 rounded-xl bg-purple-50 border border-purple-100">
                        @php
                            $totalApplicants = $school->jobs->sum('applications_count');
                        @endphp
                        <div class="text-xl font-black text-purple-600">{{ $totalApplicants }}</div>
                        <span class="text-[10px] font-bold text-text-dark/60 uppercase">Applications</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Jobs & Follow-ups --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- 1. Vacancies / Jobs Posted for this School --}}
            <div class="bg-card-bg border border-card-border rounded-2xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-card-border flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-text-main flex items-center gap-2">
                            <i class="fas fa-briefcase text-accent-blue"></i>
                            <span>Teacher Vacancies & Openings</span>
                        </h3>
                        <p class="text-xs text-text-dark/60 mt-0.5">Active and past job requirements for this institution</p>
                    </div>
                    <button type="button" @click="postJobModalOpen = true" class="px-3.5 py-1.5 bg-accent-blue text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-all flex items-center gap-1.5 cursor-pointer">
                        <i class="fas fa-plus text-[10px]"></i> Post Vacancy
                    </button>
                </div>

                <div class="divide-y divide-card-border">
                    @forelse($school->jobs as $job)
                        <div class="p-4 sm:p-5 hover:bg-secondary-bg/40 transition-colors flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-text-main hover:text-accent-blue transition-colors">
                                        <a href="{{ route('admin.jobs.show', $job->id) }}">{{ $job->title }}</a>
                                    </h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $job->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </div>
                                <div class="text-xs text-text-dark/60 mt-1 flex flex-wrap items-center gap-3">
                                    <span><i class="fas fa-book-open text-xs mr-1 text-slate-400"></i> {{ $job->subject?->name ?? 'Any Subject' }}</span>
                                    <span>•</span>
                                    <span title="{{ $job->qualification_display }}"><i class="fas fa-graduation-cap text-xs mr-1 text-slate-400"></i> {{ $job->qualification?->name ?? 'Any' }}@if($job->other_qualification) (+{{ $job->other_qualification }})@endif</span>
                                    @if($job->salary_range)
                                        <span>•</span>
                                        <span class="font-bold text-emerald-600">{{ $job->salary_range }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                <span class="px-3 py-1 bg-blue-50 text-accent-blue border border-blue-200 rounded-lg text-xs font-bold">
                                    {{ $job->applications_count }} {{ Str::plural('Applicant', $job->applications_count) }}
                                </span>
                                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="p-2 text-slate-500 hover:text-accent-blue rounded-lg bg-secondary-bg" title="Edit Job">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-text-dark/50">
                            <i class="fas fa-briefcase text-3xl text-slate-300 mb-2 block"></i>
                            <p class="text-xs font-medium">No job vacancies posted yet for this school.</p>
                            <button type="button" @click="postJobModalOpen = true" class="mt-3 px-4 py-2 bg-accent-blue text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-all cursor-pointer">
                                + Post First Job Vacancy
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 2. CRM Follow-up & Communication History --}}
            <div class="bg-card-bg border border-card-border rounded-2xl p-5 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-card-border pb-3">
                    <h3 class="text-sm font-bold text-text-main flex items-center gap-2">
                        <i class="fas fa-comments text-purple-600"></i>
                        <span>Communication & Follow-up History</span>
                    </h3>
                </div>

                {{-- Add Follow-up Form --}}
                <form action="{{ route('admin.schools.followup.store', $school->id) }}" method="POST" class="p-4 bg-secondary-bg/60 border border-card-border rounded-xl space-y-3">
                    @csrf
                    <label class="block text-xs font-bold text-text-dark/80 uppercase tracking-wider">
                        Log Call Note / Meeting Discussion
                    </label>
                    <textarea name="note" rows="2" required placeholder="Enter follow-up call discussion, hiring requirement update, or next action item..."
                              class="w-full px-3.5 py-2.5 bg-white border border-card-border rounded-xl text-xs sm:text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all"></textarea>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div>
                            <label class="block text-[11px] font-bold text-text-dark/60 mb-1">Update Status</label>
                            <select name="status_changed_to" class="w-full bg-white border border-card-border rounded-xl px-3 py-1.5 text-xs text-text-main focus:outline-none cursor-pointer">
                                <option value="Active Client" {{ $school->status === 'Active Client' ? 'selected' : '' }}>🟢 Active Client</option>
                                <option value="Lead / Prospect" {{ $school->status === 'Lead / Prospect' ? 'selected' : '' }}>🟡 Lead / Prospect</option>
                                <option value="In Discussion" {{ $school->status === 'In Discussion' ? 'selected' : '' }}>🟣 In Discussion</option>
                                <option value="Inactive" {{ $school->status === 'Inactive' ? 'selected' : '' }}>⚪ Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-text-dark/60 mb-1">Next Follow-up Call</label>
                            <input type="date" name="next_follow_up_date" class="w-full bg-white border border-card-border rounded-xl px-3 py-1.5 text-xs text-text-main focus:outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="submit" class="px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
                            <i class="fas fa-paper-plane text-[10px]"></i>
                            <span>Save Log Note</span>
                        </button>
                    </div>
                </form>

                {{-- Timeline of Follow-ups --}}
                <div class="space-y-4 pt-2">
                    @forelse($school->followUps as $fu)
                        <div class="p-3.5 bg-secondary-bg/30 border border-card-border/80 rounded-xl space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-text-main flex items-center gap-1.5">
                                    <i class="fas fa-user-circle text-purple-500"></i>
                                    {{ $fu->admin?->name ?? 'Admin Staff' }}
                                </span>
                                <span class="text-[11px] text-text-dark/40 font-medium">
                                    {{ $fu->created_at->format('d M Y, h:i A') }}
                                </span>
                            </div>
                            <p class="text-xs text-text-main leading-relaxed pl-5">
                                {{ $fu->note }}
                            </p>
                            @if($fu->next_follow_up_date)
                                <div class="pl-5 text-[11px] text-amber-600 font-bold flex items-center gap-1">
                                    <i class="far fa-clock"></i> Next Follow-up: {{ \Carbon\Carbon::parse($fu->next_follow_up_date)->format('d M Y') }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-xs text-text-dark/40 text-center py-4">No follow-up notes logged yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- Post Job Modal --}}
    <div x-show="postJobModalOpen" x-cloak class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden border border-slate-200 animate-in fade-in zoom-in-95 duration-200 my-8">
            <div class="bg-[#031b4e] p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-amber-300">
                        <i class="fas fa-briefcase text-base"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-amber-300">Quick Job Posting</span>
                        <h3 class="text-base font-bold text-white tracking-tight">Post Vacancy for {{ $school->school_name }}</h3>
                    </div>
                </div>
                <button type="button" @click="postJobModalOpen = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <form action="{{ route('admin.schools.job.store', $school->id) }}" method="POST" class="p-6 space-y-4 bg-white max-h-[80vh] overflow-y-auto">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Job Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Senior PGT Physics Teacher / Vice Principal"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Category *</label>
                        <select name="category_id" id="modal_category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none cursor-pointer">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Subject *</label>
                        <select name="subject_id" id="modal_subject_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none cursor-pointer">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Specialization <span class="text-xs text-slate-400 font-normal lowercase">(optional)</span></label>
                    <input type="text" name="specialization_name" placeholder="e.g. Physics / Maths / English Spoken / Admission Sales" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Qualification *</label>
                        <select name="qualification_id" id="modal_qualification_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none cursor-pointer">
                            <option value="">Select Qualification</option>
                            @foreach($qualifications as $qual)
                                <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Other / Additional Qualification</label>
                        <input type="text" name="other_qualification" placeholder="e.g. CTET, STET, or experience"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Salary Range</label>
                    <input type="text" name="salary_range" placeholder="e.g. ₹35,000 - ₹50,000 / month"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">State *</label>
                        <select name="state_id" id="modal_state_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none cursor-pointer">
                            <option value="">Select State</option>
                            @foreach($states as $st)
                                <option value="{{ $st->id }}" {{ $school->state_id == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">City *</label>
                        <select name="city_id" id="modal_city_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none cursor-pointer">
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>

                <!-- Job Description with Editor -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Job Description & Requirements</label>
                    <textarea name="description" id="modal_editor" rows="5" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none" placeholder="Enter job requirements, responsibilities, timings, benefits..."></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2.5">
                    <a href="{{ route('admin.jobs.create', ['school_name' => $school->school_name, 'contact_person' => $school->contact_person, 'phone' => $school->phone ?: ($school->user?->phone ?? ''), 'email' => $school->email ?: ($school->user?->email ?? ''), 'state_id' => $school->state_id, 'city_id' => $school->city_id]) }}" class="text-xs font-bold text-accent-blue hover:underline flex items-center gap-1">
                        <i class="fas fa-external-link-alt text-[10px]"></i> Open Full Job Post Page
                    </a>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="postJobModalOpen = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                            <i class="fas fa-paper-plane"></i>
                            <span>Publish Vacancy</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable_inline {
        min-height: 140px;
        color: #1e293b !important;
        background-color: #ffffff !important;
        border-radius: 0 0 0.75rem 0.75rem !important;
    }
    .ck-toolbar {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border-color: #cbd5e1 !important;
        background-color: #f8fafc !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init CKEditor for modal
        const modalEditorEl = document.querySelector('#modal_editor');
        if (modalEditorEl) {
            ClassicEditor
                .create(modalEditorEl, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
                })
                .catch(err => console.error('CKEditor init error:', err));
        }

        // SlimSelect Bridge Helper
        function updateDynamicSelect(selectEl, options, placeholder = 'Select Option', selectedId = null) {
            if (!selectEl) return;
            let html = `<option value="">${placeholder}</option>`;
            options.forEach(item => {
                const isSelected = selectedId && String(selectedId) === String(item.id) ? 'selected' : '';
                html += `<option value="${item.id}" ${isSelected}>${item.name}</option>`;
            });
            selectEl.innerHTML = html;
            selectEl.disabled = false;

            if (selectEl._slimSelect) {
                try {
                    const ssData = [
                        { text: placeholder, value: '', placeholder: true },
                        ...options.map(item => ({ 
                            text: item.name, 
                            value: String(item.id),
                            selected: selectedId && String(selectedId) === String(item.id)
                        }))
                    ];
                    selectEl._slimSelect.setData(ssData);
                    selectEl._slimSelect.enable();
                } catch (e) {
                    if (typeof window.refreshSearchableSelect === 'function') {
                        window.refreshSearchableSelect(selectEl);
                    }
                }
            }
        }

        function setSelectLoading(selectEl, placeholder = 'Loading...') {
            if (!selectEl) return;
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            selectEl.disabled = true;
            if (selectEl._slimSelect) {
                try {
                    selectEl._slimSelect.setData([{ text: placeholder, value: '', placeholder: true }]);
                    selectEl._slimSelect.disable();
                } catch (e) {}
            }
        }

        function resetDynamicSelect(selectEl, placeholder = '— First Select Option —') {
            if (!selectEl) return;
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            selectEl.disabled = true;
            if (selectEl._slimSelect) {
                try {
                    selectEl._slimSelect.setData([{ text: placeholder, value: '', placeholder: true }]);
                    selectEl._slimSelect.disable();
                } catch (e) {}
            }
        }

        // Modal State -> City sync
        const modalStateSelect = document.getElementById('modal_state_id');
        const modalCitySelect = document.getElementById('modal_city_id');
        const defaultStateId = "{{ $school->state_id ?? '' }}";
        const defaultCityId = "{{ $school->city_id ?? '' }}";

        function loadCities(stateId, selectedCityId = null) {
            if (!modalCitySelect) return;
            if (stateId) {
                setSelectLoading(modalCitySelect, 'Loading cities...');
                fetch(`/api/states/${stateId}/cities`)
                    .then(res => res.json())
                    .then(data => {
                        updateDynamicSelect(modalCitySelect, data, 'Select City', selectedCityId);
                    })
                    .catch(err => {
                        console.error('Error fetching cities:', err);
                        updateDynamicSelect(modalCitySelect, [], 'Select City');
                    });
            } else {
                resetDynamicSelect(modalCitySelect, 'Select City');
            }
        }

        if (modalStateSelect) {
            modalStateSelect.addEventListener('change', function() {
                loadCities(this.value);
            });

            // Initial load if school has state_id
            if (defaultStateId) {
                loadCities(defaultStateId, defaultCityId);
            }
        }

        // Modal Category -> Subject -> Specialization sync
        const modalCatSelect = document.getElementById('modal_category_id');
        const modalSubSelect = document.getElementById('modal_subject_id');
        const modalSpecWrapper = document.getElementById('modal_specialization_wrapper');
        const modalSpecSelect = document.getElementById('modal_specialization_id');

        function loadModalSpecializations(subjectId) {
            if (!modalSpecSelect || !modalSpecWrapper) return;
            if (subjectId) {
                fetch(`/api/subjects/${subjectId}/specializations`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            modalSpecWrapper.style.display = 'block';
                            updateDynamicSelect(modalSpecSelect, data, 'Select Specialization (Optional)');
                        } else {
                            modalSpecWrapper.style.display = 'none';
                            modalSpecSelect.innerHTML = '<option value="">Select Specialization (Optional)</option>';
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching specializations:', err);
                        modalSpecWrapper.style.display = 'none';
                    });
            } else {
                modalSpecWrapper.style.display = 'none';
                modalSpecSelect.innerHTML = '<option value="">Select Specialization (Optional)</option>';
            }
        }

        if (modalCatSelect && modalSubSelect) {
            modalCatSelect.addEventListener('change', function() {
                let catId = this.value;
                if (modalSpecWrapper) modalSpecWrapper.style.display = 'none';
                if (modalSpecSelect) modalSpecSelect.innerHTML = '<option value="">Select Specialization (Optional)</option>';

                if (catId) {
                    setSelectLoading(modalSubSelect, 'Loading subjects...');
                    fetch(`/api/categories/${catId}/subjects`)
                        .then(res => res.json())
                        .then(data => {
                            updateDynamicSelect(modalSubSelect, data, 'Select Subject');
                        })
                        .catch(err => {
                            console.error('Error fetching subjects:', err);
                            updateDynamicSelect(modalSubSelect, [], 'Select Subject');
                        });
                } else {
                    resetDynamicSelect(modalSubSelect, 'Select Subject');
                }
            });
        }

        if (modalSubSelect) {
            modalSubSelect.addEventListener('change', function() {
                loadModalSpecializations(this.value);
            });
        }
    });
</script>
@endpush

@endsection
