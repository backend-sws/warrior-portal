@extends('layouts.app')

@section('content')
<div class="min-h-screen pb-12">
    <!-- Include Nav -->
    @include('employer.partials.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#031b4e]">My Tuitions</h1>
                <p class="text-[#031b4e]/70 text-sm mt-1">Manage all your home tuition requirements.</p>
            </div>
            <a href="{{ route('employer.tuitions.create') }}" class="bg-accent-yellow hover:bg-accent-yellow/90 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">
                <i class="fas fa-plus mr-2"></i>Post New Tuition
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="light-metallic-blue-card bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl shadow-sm overflow-hidden">
            @if($tuitions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#031b4e]/10 border-b border-[#031b4e]/10 text-xs uppercase tracking-wider text-[#031b4e]/70">
                                <th class="px-6 py-4 font-semibold">Subject & Class</th>
                                <th class="px-6 py-4 font-semibold">Location</th>
                                <th class="px-6 py-4 font-semibold">Budget</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-card-border">
                            @foreach($tuitions as $tuition)
                                <tr class="hover:bg-[#031b4e]/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-[#031b4e]">{{ $tuition->subjects }}</div>
                                        <div class="text-xs text-[#031b4e]/70 mt-0.5">{{ $tuition->student_class }} • {{ $tuition->board }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-[#031b4e]">{{ $tuition->location }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-[#031b4e]">{{ $tuition->budget }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($tuition->status == 'Pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                                Pending
                                            </span>
                                        @elseif($tuition->status == 'Matched')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                                Matched
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/10 text-gray-500 border border-gray-500/20">
                                                Closed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <form action="{{ route('employer.tuitions.destroy', $tuition->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tuition requirement?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-500 transition-colors" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-[#031b4e]/10 bg-[#031b4e]/5">
                    {{ $tuitions->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-[#031b4e]/10">
                        <i class="fas fa-chalkboard-teacher text-2xl text-[#031b4e]/70"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-[#031b4e] mb-1">No Tuitions Posted Yet</h3>
                    <p class="text-[#031b4e]/70 text-sm mb-6">You haven't posted any home tuition requirements yet.</p>
                    <a href="{{ route('employer.tuitions.create') }}" class="inline-flex items-center text-accent-yellow hover:text-accent-yellow/80 font-medium">
                        Post your first requirement <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
