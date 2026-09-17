@extends('layouts.app')
@section('title', 'Verified Home Tutors & 1-to-1 Private Tuitions in India | Warriors Educare')
@section('meta_description', 'Find pre-screened, verified home tutors for Nursery to Class 12 & competitive exams in your city. Book a free demo class today with Warriors Educare.')
@section('content')
<x-page-header title="Find Tuitions" :breadcrumbs="['Home' => route('home'), 'Tuitions' => null]" image="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" />

<!-- Tuition Search Section -->
<div class="bg-[#031b4e] py-10 sm:py-12 px-4 sm:px-6 lg:px-[5%] relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(#ffffff 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-[#0ea5e9]/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <div class="text-center mb-6">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-white mb-2 tracking-tight">Search Tuition Requirements</h2>
            <p class="text-blue-200/80 text-xs sm:text-sm font-medium max-w-lg mx-auto">Find matching home tuition posts by Job ID, Subject, or Location / Pincode</p>
        </div>

        <style>
            .tuition-search-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.75rem;
                align-items: center;
            }
            @media (min-width: 768px) {
                .tuition-search-grid {
                    grid-template-columns: 1.15fr 1.25fr 1.35fr auto;
                }
            }
            .tuition-field-box {
                position: relative;
                width: 100%;
            }
            .tuition-field-box input {
                width: 100%;
                height: 48px;
                padding-left: 2.5rem;
                padding-right: 0.85rem;
                border-radius: 0.85rem;
                border: 1.5px solid #e2e8f0;
                background-color: #f8fafc;
                color: #031b4e;
                font-weight: 700;
                font-size: 0.875rem;
                outline: none;
                transition: all 0.2s ease;
                box-sizing: border-box;
            }
            .tuition-field-box input:focus {
                background-color: #ffffff;
                border-color: #0ea5e9;
                box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            }
            .tuition-field-icon {
                position: absolute;
                left: 0.95rem;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 0.875rem;
                pointer-events: none;
            }
            .tuition-action-group {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                width: 100%;
            }
            @media (min-width: 768px) {
                .tuition-action-group {
                    width: auto;
                }
            }
            .tuition-submit-btn {
                height: 48px;
                padding: 0 1.5rem;
                border-radius: 0.85rem;
                background-color: #0ea5e9;
                color: #ffffff;
                font-weight: 800;
                font-size: 0.875rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                white-space: nowrap;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
                border: none;
                cursor: pointer;
                flex: 1;
            }
            @media (min-width: 768px) {
                .tuition-submit-btn {
                    flex: initial;
                }
            }
            .tuition-submit-btn:hover {
                background-color: #0284c7;
                box-shadow: 0 6px 18px rgba(14, 165, 233, 0.45);
                transform: translateY(-1px);
            }
            .tuition-clear-link {
                height: 48px;
                width: 48px;
                border-radius: 0.85rem;
                background-color: #f1f5f9;
                color: #64748b;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                border: 1px solid #e2e8f0;
                flex-shrink: 0;
            }
            .tuition-clear-link:hover {
                background-color: #e2e8f0;
                color: #0f172a;
            }
        </style>

        <form action="{{ route('tuitions') }}" method="GET" class="bg-white p-3.5 sm:p-4 rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-100 tuition-search-grid">
            
            <!-- Input 1: Job ID / Tuition ID -->
            <div class="tuition-field-box">
                <i class="fas fa-hashtag tuition-field-icon"></i>
                <input type="text" 
                       name="job_id" 
                       value="{{ request('job_id') ?? request('tuition_id') }}" 
                       placeholder="Job ID (e.g. TUI-0034)">
            </div>

            <!-- Input 2: Subject -->
            <div class="tuition-field-box">
                <i class="fas fa-book tuition-field-icon"></i>
                <input type="text" 
                       name="subject" 
                       value="{{ request('subject') }}" 
                       placeholder="Subject (e.g. Mathematics)">
            </div>

            <!-- Input 3: Location / Pincode -->
            <div class="tuition-field-box">
                <i class="fas fa-map-marker-alt tuition-field-icon"></i>
                <input type="text" 
                       name="location" 
                       value="{{ request('location') ?? request('pincode') }}" 
                       placeholder="Location / Pincode (e.g. 800001)">
            </div>

            <!-- Action Buttons -->
            <div class="tuition-action-group">
                <button type="submit" class="tuition-submit-btn">
                    <i class="fas fa-search text-xs"></i>
                    <span>Search</span>
                </button>
                @if(request()->hasAny(['job_id', 'tuition_id', 'subject', 'location', 'pincode', 'search']))
                    <a href="{{ route('tuitions') }}" title="Clear Search Filters" class="tuition-clear-link" aria-label="Clear filters">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="py-12 px-6 lg:px-[5%] flex flex-col lg:flex-row gap-8 bg-white relative overflow-hidden" x-data="{ showDemoModal: false, selectedTutorId: null, selectedTutorName: '' }">
    <div class="absolute inset-0 z-0 opacity-[0.02]" style="background-image: radial-gradient(#000000 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>

    <div class="w-full lg:w-2/3 relative z-10">
        @if(request()->hasAny(['job_id', 'tuition_id', 'subject', 'location', 'pincode', 'search']))
            <div class="flex items-center justify-between flex-wrap gap-3 mb-6 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#031b4e]">
                        Matching Tuition Requirements
                    </h3>
                    <div class="flex items-center flex-wrap gap-1.5 mt-1.5">
                        <span class="text-xs text-slate-500 font-medium">Found {{ $tuitions->total() }} post{{ $tuitions->total() == 1 ? '' : 's' }}</span>
                        @if($qId = (request('job_id') ?: request('tuition_id')))
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-accent-blue px-2.5 py-0.5 rounded-md text-xs font-bold border border-blue-100">
                                <i class="fas fa-hashtag text-[9px]"></i> {{ $qId }}
                            </span>
                        @endif
                        @if($qSub = request('subject'))
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-md text-xs font-bold border border-emerald-100">
                                <i class="fas fa-book text-[9px]"></i> {{ $qSub }}
                            </span>
                        @endif
                        @if($qLoc = (request('location') ?: request('pincode')))
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2.5 py-0.5 rounded-md text-xs font-bold border border-amber-100">
                                <i class="fas fa-map-marker-alt text-[9px]"></i> {{ $qLoc }}
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('tuitions') }}" class="text-xs font-bold text-accent-blue hover:text-blue-700 flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg border border-blue-100 transition-colors">
                    <i class="fas fa-undo text-[10px]"></i> View All Requirements
                </a>
            </div>
        @else
            <h3 class="text-2xl font-bold text-[#031b4e] mb-6 border-b border-slate-100 pb-4">Recent Tuition Requirements</h3>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($tuitions as $tuition)
        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between hover:border-accent-blue/50 hover:shadow-xl transition-all duration-300 group reveal">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-chalkboard-teacher text-xl text-accent-blue"></i>
                        </div>
                        <span class="inline-flex items-center gap-1 font-mono text-xs font-bold text-accent-blue bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100">
                            <i class="fas fa-hashtag text-[9px] opacity-70"></i>{{ $tuition->tuition_id ?: 'TUI-' . str_pad($tuition->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <span class="bg-blue-50 text-accent-blue px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap">{{ $tuition->board ?? 'N/A' }}</span>
                </div>
                
                <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-accent-blue transition-colors line-clamp-1">
                    <a href="{{ route('tuitions.show', $tuition->id) }}">{{ $tuition->subjects ?? 'Tuition Requirement' }}</a>
                </h3>
                <p class="text-sm text-slate-500 font-medium mb-3 flex items-center gap-1.5">
                    <i class="fas fa-map-marker-alt text-red-400 text-xs"></i> 
                    <span>{{ $tuition->location }}@if($tuition->pincode) - (Pincode: {{ $tuition->pincode }})@endif</span>
                </p>
                
                <div class="bg-slate-50 rounded-xl p-3 text-xs text-slate-700 space-y-1.5 mb-5 border border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Class:</span>
                        <span class="font-bold text-[#031b4e]">{{ $tuition->class }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Board:</span>
                        <span class="font-bold text-accent-blue">{{ $tuition->board ?: 'General' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Subjects:</span>
                        <span class="font-bold text-slate-800">{{ $tuition->subjects }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Gender Pref:</span>
                        <span class="font-bold text-slate-800">{{ $tuition->tutor_preference ?: 'Any' }}</span>
                    </div>
                    @if(!empty($tuition->duration_hours))
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Duration:</span>
                            <span class="font-bold text-slate-800">{{ $tuition->duration_hours }}</span>
                        </div>
                    @endif
                    @if(!empty($tuition->days_per_week))
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Days / Week:</span>
                            <span class="font-bold text-slate-800">{{ $tuition->days_per_week }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Tuition Fee:</span>
                        @auth
                            <span class="font-bold text-emerald-600">{{ $tuition->fee ? '₹'.$tuition->fee : 'Negotiable' }}</span>
                        @else
                            <span class="font-bold text-emerald-600 blur-sm select-none" title="Login to view fees">₹XXXX</span>
                        @endauth
                    </div>
                </div>
            </div>
            
            <div>
                <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-medium mt-1">Posted {{ $tuition->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                data-share-url="{{ route('tuitions.show', $tuition->id) }}"
                                onclick="copyJobUrl(this.dataset.shareUrl, this)" 
                                title="Copy Tuition Link to Share" 
                                class="p-2 w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all active:scale-95 cursor-pointer flex items-center justify-center shadow-2xs">
                            <i class="fas fa-link text-[#0ea5e9]"></i>
                        </button>
                        <a href="{{ route('tuitions.show', $tuition->id) }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#031b4e] font-bold text-xs transition-colors flex items-center gap-1">
                            <span>Details</span>
                        </a>
                        <form action="{{ route('candidate.tuitions.apply', $tuition->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-white bg-accent-blue px-4 py-2 rounded-xl font-bold text-xs hover:bg-blue-600 transition-colors shadow-glow-blue flex items-center gap-1.5 active:scale-95 cursor-pointer">
                                <span>Apply</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 shadow-sm text-2xl mx-auto mb-4">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">No Matching Tuition Requirements</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto mb-5">We couldn't find any tuition requirements matching your search criteria. Try adjusting the Job ID, Subject, or Pincode.</p>
            <a href="{{ route('tuitions') }}" class="inline-flex items-center gap-2 bg-[#0ea5e9] hover:bg-[#0284c7] text-white px-5 py-2.5 rounded-xl font-bold text-xs transition-colors shadow-sm">
                <i class="fas fa-undo"></i> View All Tuition Requirements
            </a>
        </div>
        @endforelse

        </div>
        <div class="mt-12">
            {{ $tuitions->links() }}
        </div>
    </div>

    <div class="w-full lg:w-1/3 relative z-10">
        <div class="bg-gradient-to-br from-[#f0f7ff] to-blue-50 rounded-2xl shadow-lg border border-blue-200 p-8 sticky top-24">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-[#031b4e] mb-2">Need a Tutor for Your Child?</h3>
                <p class="text-sm text-slate-500">Fill this quick form and our team will verify, approve and match you with the best verified tutor.</p>
            </div>

            @if(session('tuition_success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl relative mb-6 text-sm flex items-start gap-2.5 shadow-sm" role="alert">
                    <i class="fas fa-check-circle text-emerald-600 mt-0.5"></i>
                    <span class="block sm:inline font-medium">{{ session('tuition_success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl relative mb-6 text-xs flex flex-col gap-1 shadow-sm" role="alert">
                    <div class="font-bold flex items-center gap-1.5"><i class="fas fa-exclamation-circle text-rose-600"></i> Please fix the following errors:</div>
                    <ul class="list-disc pl-5 mt-1 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tuition.post') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Name *</label>
                        <input type="text" name="guest_name" value="{{ old('guest_name') }}" placeholder="Enter your full name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" title="Please enter your full name (letters only, min 3 characters)." class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Phone Number *</label>
                        <input type="tel" name="guest_phone" value="{{ old('guest_phone') }}" placeholder="Enter 10-digit mobile number" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" title="Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9." class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Student's Class *</label>
                        <input type="text" name="student_class" value="{{ old('student_class') }}" placeholder="e.g. Class 10" required minlength="1" maxlength="50" class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Board *</label>
                        <input type="text" name="board" value="{{ old('board') }}" placeholder="e.g. CBSE / ICSE / State" required minlength="2" maxlength="50" class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Subjects Needed *</label>
                    <input type="text" name="subjects" value="{{ old('subjects') }}" placeholder="e.g. Math, Science, English" required minlength="2" maxlength="150" class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Complete Location/Address *</label>
                    <input type="text" name="location" value="{{ old('location') }}" required minlength="3" maxlength="200" placeholder="Enter full address or area" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" maxlength="6" pattern="^[0-9]{6}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" title="Please enter a valid 6-digit Pincode." placeholder="Enter 6-digit Pincode" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none font-mono">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Time Duration (Daily Hours)</label>
                    <input type="text" name="duration_hours" value="{{ old('duration_hours') }}" placeholder="e.g. 1.5 Hours / Day (Kitne ghante padhana hai)" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Days Per Week</label>
                    <input type="text" name="days_per_week" value="{{ old('days_per_week') }}" placeholder="e.g. 5 Days / Week (Week me kitne din padhana hoga)" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-bold text-[#031b4e]">Remark / Specific Requirements</label>
                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">Optional</span>
                    </div>
                    <textarea name="remarks" rows="2" maxlength="1500" placeholder="e.g. Female tutor preferred / Evening 5 PM timing / Focus on weak math fundamentals etc." class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none resize-none">{{ old('remarks') }}</textarea>
                </div>
                
                <div class="mt-4 flex justify-center">
                    <button type="submit" class="bg-[#031b4e] text-white rounded-full px-8 py-3.5 font-bold hover:bg-[#021133] transition-colors shadow-lg flex items-center justify-center gap-2 w-auto min-w-[200px] cursor-pointer">
                        Submit Request for Review <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Demo Request Modal -->
<div x-show="showDemoModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 backdrop-blur-sm" x-transition.opacity>
    <div class="relative w-full max-w-md p-4 mx-auto" @click.away="showDemoModal = false" x-transition.scale.origin.bottom>
        <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-[#031b4e]">Request Demo with <span x-text="selectedTutorName" class="text-accent-blue"></span></h3>
                <button @click="showDemoModal = false" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="demoRequestForm" @submit.prevent="
                    const formData = new FormData($event.target);
                    formData.append('tutor_id', selectedTutorId);
                    
                    fetch('{{ route('tutors.requestDemo') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            if (typeof window.trackLeadConversion === 'function') {
                                window.trackLeadConversion();
                            }
                            alert(data.message);
                            showDemoModal = false;
                            $event.target.reset();
                        } else {
                            alert(data.message || 'Error occurred.');
                        }
                    })
                    .catch(err => {
                        alert('Something went wrong. Please try again.');
                    });
                ">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Name *</label>
                            <input type="text" name="parent_name" required placeholder="Enter your full name" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Phone Number *</label>
                            <input type="text" name="parent_phone" required placeholder="Enter your phone number" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Subject Need (Optional)</label>
                            <input type="text" name="subject" placeholder="e.g. Mathematics" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                        </div>
                        <button type="submit" class="w-full bg-accent-blue text-white rounded-xl px-4 py-3.5 font-bold hover:bg-blue-600 transition-colors shadow-glow-blue mt-2">
                            Send Request <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
