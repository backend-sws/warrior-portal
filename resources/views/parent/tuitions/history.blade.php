@extends('layouts.parent')

@section('content')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-[#031b4e]">Tutor Need History</h1>
            <p class="text-gray-500 mt-1">View the status of your submitted tutor requirements.</p>
        </div>
        <a href="{{ route('parent.tuitions.create') }}" class="bg-[#031b4e] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#031b4e]/90 transition-colors shadow-sm">
            <i class="fas fa-plus mr-1"></i> New Request
        </a>
    </div>

    @if($leads->isEmpty())
        <div class="bg-white p-12 text-center rounded-xl shadow-sm border border-gray-100">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-[#031b4e] mb-1">No History Found</h3>
            <p class="text-gray-500">You have not submitted any tutor requirements yet.</p>
            <a href="{{ route('parent.tuitions.create') }}" class="mt-4 inline-block text-[#0ea5e9] font-bold hover:underline">
                Submit your first requirement
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($leads as $lead)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        @php
                            $statusColors = [
                                'New Lead' => 'bg-blue-100 text-blue-800',
                                'Demo Scheduled' => 'bg-yellow-100 text-yellow-800',
                                'Demo Completed' => 'bg-purple-100 text-purple-800',
                                'Confirmed' => 'bg-green-100 text-green-800',
                                'Pending' => 'bg-orange-100 text-orange-800',
                                'Cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $colorClass = $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorClass }}">
                            {{ $lead->status }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-[#031b4e] mb-1 pr-24">{{ $lead->subjects }}</h3>
                    <div class="text-sm text-gray-500 font-medium mb-4">{{ $lead->class }} ({{ $lead->board }})</div>
                    
                    <div class="space-y-3 mb-6 flex-grow">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-user w-5 text-gray-400"></i>
                            <span>{{ $lead->parent_name }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-phone-alt w-5 text-gray-400"></i>
                            <span>{{ $lead->parent_mobile }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                            <span class="line-clamp-1" title="{{ $lead->location }}">{{ $lead->location }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            <i class="far fa-calendar-alt mr-1"></i> Submitted {{ $lead->created_at->format('d M, Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        @if($leads->hasPages())
            <div class="mt-8">
                {{ $leads->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
