@extends('layouts.app')
@section('content')
<x-page-header title="Find Tuitions" :breadcrumbs="['Home' => route('home'), 'Tuitions' => null]" image="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" />

<div class="py-12 px-6 lg:px-[5%] flex flex-col lg:flex-row gap-8 bg-white relative overflow-hidden">
    <div class="absolute inset-0 z-0 opacity-[0.02]" style="background-image: radial-gradient(#000000 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>

    <div class="w-full lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
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
                <p class="text-sm text-slate-500 font-medium mb-3 line-clamp-1">{{ $tuition->location }}</p>
                
                <p class="text-sm text-slate-600 leading-relaxed mb-5 line-clamp-3">
                    Class: {{ $tuition->class }} <br>
                    Timing: {{ $tuition->preferred_timing ?? 'Not specified' }}
                </p>
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

        <div class="mt-12 col-span-full">
            {{ $tuitions->links() }}
        </div>
    </div>

    <div class="w-full lg:w-1/3 relative z-10">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 sticky top-24">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-[#031b4e] mb-2">Need a Tutor for Your Child?</h3>
                <p class="text-sm text-slate-500">Fill this quick form and we'll match you with the best verified tutor.</p>
            </div>

            @if(session('tuition_success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                    <span class="block sm:inline">{{ session('tuition_success') }}</span>
                </div>
            @endif

            <form action="{{ route('tuition.post') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Name *</label>
                        <input type="text" name="guest_name" placeholder="Enter your full name" required class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Your Phone Number *</label>
                        <input type="text" name="guest_phone" placeholder="Enter your phone number" required class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Student's Class *</label>
                        <input type="text" name="student_class" placeholder="Select Class" required class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Board *</label>
                        <input type="text" name="board" placeholder="Select Board" required class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Subjects Needed *</label>
                    <input type="text" name="subjects" placeholder="e.g., Math, Science" required class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#031b4e] mb-1.5">Complete Location/Address *</label>
                    <input type="text" name="location" placeholder="Enter full address or area" required class="w-full border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue bg-slate-50/50">
                </div>
                
                <div class="mt-4 flex justify-center">
                    <button type="submit" class="bg-[#031b4e] text-white rounded-full px-8 py-3.5 font-bold hover:bg-[#021133] transition-colors shadow-lg flex items-center justify-center gap-2 w-auto min-w-[200px]">
                        Post Requirement <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
