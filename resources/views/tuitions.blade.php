@extends('layouts.app')
@section('content')
<x-page-header title="Find Tuitions" :breadcrumbs="['Home' => route('home'), 'Tuitions' => null]" image="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" />

<!-- Tutor Search Section -->
<div class="bg-[#031b4e] py-12 px-6 lg:px-[5%] relative overflow-hidden">
    <div class="max-w-4xl mx-auto relative z-10">
        <h2 class="text-3xl font-extrabold text-white text-center mb-6">Search for a Tutor</h2>
        <form action="{{ route('tutors.search') }}" method="GET" class="bg-white p-4 rounded-2xl shadow-2xl flex flex-col md:flex-row gap-4 items-center">
            <div class="flex-1 w-full relative">
                <i class="fas fa-book absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="subject" value="{{ request('subject') }}" placeholder="Search Subject (e.g. Mathematics)" style="padding-left: 2.5rem;" class="w-full pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-accent-blue/50 outline-none text-[#031b4e] font-semibold placeholder:text-slate-400">
            </div>
            <div class="flex-1 w-full relative">
                <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Enter Location / Pincode" style="padding-left: 2.5rem;" class="w-full pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-accent-blue/50 outline-none text-[#031b4e] font-semibold placeholder:text-slate-400">
            </div>
            <button type="submit" class="w-full md:w-auto bg-accent-blue text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-600 transition-colors shadow-glow-blue whitespace-nowrap">
                Get Started <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </form>
    </div>
</div>

<div class="py-12 px-6 lg:px-[5%] flex flex-col lg:flex-row gap-8 bg-white relative overflow-hidden" x-data="{ showDemoModal: false, selectedTutorId: null, selectedTutorName: '' }">
    <div class="absolute inset-0 z-0 opacity-[0.02]" style="background-image: radial-gradient(#000000 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>

    <div class="w-full lg:w-2/3 relative z-10">
        @if(isset($tutors))
            <h3 class="text-2xl font-bold text-[#031b4e] mb-6 border-b border-slate-100 pb-4">
                {{ $subject ? $subject . ' ' : '' }}Tutors {{ $location ? 'near ' . $location : '' }}
            </h3>
            <style>
                .tutor-grid {
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                }
                @media (min-width: 768px) {
                    .tutor-grid {
                        display: grid;
                        grid-template-columns: 2fr 1.5fr 1fr 2.5fr;
                        gap: 1rem;
                        align-items: center;
                    }
                }
            </style>
            <div class="flex flex-col gap-4">
                @forelse($tutors as $tutor)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between hover:border-accent-blue/50 hover:shadow-xl transition-all duration-300 group gap-4 relative">
                    <div class="flex-1 overflow-hidden">
                        <!-- Desktop Header (Hidden on small screens) -->
                        <div class="hidden md:grid mb-2 border-b border-slate-100 pb-2 tutor-grid">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tutor</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Subject</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Experience</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Location</div>
                        </div>
                        
                        <!-- Content Grid -->
                        <div class="tutor-grid">
                            <!-- Tutor Name -->
                            <div class="font-bold text-[#031b4e] group-hover:text-accent-blue transition-colors flex items-center gap-3">
                                @if($tutor->profile && $tutor->profile->profile_photo_path)
                                    <img src="{{ Storage::url($tutor->profile->profile_photo_path) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-sm shrink-0"><i class="fas fa-user"></i></div>
                                @endif
                                <span class="text-base truncate">{{ $tutor->name }}</span>
                            </div>
                            
                            <!-- Subject -->
                            <div class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <span class="md:hidden text-xs text-slate-400">Subject:</span>
                                {{ $tutor->profile->subject->name ?? 'Various' }}
                            </div>
                            
                            <!-- Experience -->
                            <div class="text-sm text-slate-600 font-medium whitespace-nowrap flex items-center gap-2">
                                <span class="md:hidden text-xs text-slate-400">Exp:</span>
                                {{ $tutor->profile->experience_years ?? 0 }} Years
                            </div>
                            
                            <!-- Location -->
                            <div class="text-sm text-slate-600 leading-tight flex items-start gap-2">
                                <span class="md:hidden text-xs text-slate-400 mt-0.5">Loc:</span>
                                <span>{{ $tutor->profile->address ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:pl-4 md:border-l border-slate-100 shrink-0 mt-2 md:mt-0">
                        <button type="button" @click="showDemoModal = true; selectedTutorId = {{ $tutor->id }}; selectedTutorName = '{{ addslashes($tutor->name) }}'" class="w-full md:w-auto bg-accent-blue text-white font-bold py-2.5 px-6 rounded-xl hover:bg-blue-600 transition-colors shadow-glow-blue text-sm whitespace-nowrap">
                            Request Demo
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 shadow-sm text-2xl mx-auto mb-4"><i class="fas fa-search"></i></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">No Tutors Found</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto">Try adjusting your search criteria to find matching tutors.</p>
                </div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $tutors->links() }}
            </div>
        @else
            <h3 class="text-2xl font-bold text-[#031b4e] mb-6 border-b border-slate-100 pb-4">Recent Tuition Requirements</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($tuitions as $tuition)
        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between hover:border-accent-blue/50 hover:shadow-xl transition-all duration-300 group reveal">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-chalkboard-teacher text-2xl text-accent-blue"></i>
                    </div>
                    <span class="bg-blue-50 text-accent-blue px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap">{{ $tuition->board ?? 'N/A' }}</span>
                </div>
                
                <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-accent-blue transition-colors line-clamp-1">
                    {{ $tuition->subjects ?? 'Tuition Requirement' }}
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
                </div>
            </div>
            
            <div>
                <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-medium mt-1">Posted {{ $tuition->created_at->diffForHumans() }}</span>
                    </div>
                    <form action="{{ route('candidate.tuitions.apply', $tuition->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-white bg-accent-blue px-4 py-2 rounded-lg font-bold text-xs hover:bg-blue-600 transition-colors shadow-glow-blue flex items-center gap-2">Apply</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 shadow-sm text-2xl mx-auto mb-4"><i class="fas fa-chalkboard-teacher"></i></div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">No Active Tuitions</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto">We currently don't have any tuition openings.</p>
        </div>
        @endforelse

            </div>
            <div class="mt-12">
                {{ $tuitions->links() }}
            </div>
        @endif
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

            <form action="{{ route('tuition.post') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Name *</label>
                        <input type="text" name="guest_name" placeholder="Enter your full name" required class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Phone Number *</label>
                        <input type="text" name="guest_phone" placeholder="Enter your phone number" required class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Student's Class *</label>
                        <input type="text" name="student_class" placeholder="e.g. Class 10" required class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Board *</label>
                        <input type="text" name="board" placeholder="e.g. CBSE / ICSE / State" required class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Subjects Needed *</label>
                    <input type="text" name="subjects" placeholder="e.g., Math, Science, English" required class="w-full border border-blue-200 rounded-lg px-4 py-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-white text-[#031b4e] font-medium">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Complete Location/Address *</label>
                    <input type="text" name="location" required placeholder="Enter full address or area" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Pincode *</label>
                    <input type="text" name="pincode" required placeholder="Enter 6-digit Pincode" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                </div>
                
                <div class="mt-4 flex justify-center">
                    <button type="submit" class="bg-[#031b4e] text-white rounded-full px-8 py-3.5 font-bold hover:bg-[#021133] transition-colors shadow-lg flex items-center justify-center gap-2 w-auto min-w-[200px]">
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
