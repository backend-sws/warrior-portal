@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Available Tuitions</h2>
    <p class="text-sm text-gray-500 mt-1">Find and apply for home tuitions matching your expertise.</p>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 mb-6 flex items-center">
        <i class="fas fa-check-circle mr-3"></i> {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-50 text-blue-700 p-4 rounded-xl border border-blue-100 mb-6 flex items-center">
        <i class="fas fa-info-circle mr-3"></i> {{ session('info') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 mb-6 flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i> {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($tuitions as $tuition)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <span class="bg-accent-blue/10 text-accent-blue text-xs font-bold px-3 py-1 rounded-full">
                    {{ $tuition->student_class }}
                </span>
                <span class="bg-green-50 text-green-700 text-sm font-bold px-3 py-1 rounded-lg border border-green-100">
                    ₹{{ $tuition->budget }}<span class="text-xs font-normal">/mo</span>
                </span>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $tuition->subjects }}</h3>
            
            <div class="space-y-3 mb-6 flex-grow">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-book w-5 text-gray-400"></i>
                    <span>{{ $tuition->board }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                    <span class="line-clamp-1" title="{{ $tuition->location }}">{{ $tuition->location }}</span>
                </div>
                @if($tuition->description)
                <div class="text-sm text-gray-500 mt-2 line-clamp-2" title="{{ $tuition->description }}">
                    {{ $tuition->description }}
                </div>
                @endif
            </div>

            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-400">
                    <i class="far fa-clock mr-1"></i> {{ $tuition->created_at->diffForHumans() }}
                </span>

                @if(in_array($tuition->id, $appliedTuitionIds))
                    <button disabled class="bg-gray-100 text-gray-500 font-semibold py-2 px-6 rounded-xl text-sm cursor-not-allowed">
                        Applied <i class="fas fa-check ml-1"></i>
                    </button>
                @else
                    <form action="{{ route('candidate.tuitions.apply', $tuition->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-accent-blue hover:bg-accent-blue/90 text-white font-semibold py-2 px-6 rounded-xl text-sm transition-colors shadow-sm">
                            Apply Now
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-gray-100">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-reader text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">No Tuitions Available</h3>
            <p class="text-gray-500">There are currently no active tuitions to apply for. Please check back later.</p>
        </div>
    @endforelse
</div>

@if($tuitions->hasPages())
    <div class="mt-8">
        {{ $tuitions->links() }}
    </div>
@endif

    </div>
@endsection
