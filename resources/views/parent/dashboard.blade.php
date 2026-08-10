@extends('layouts.parent')

@section('content')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Parent Dashboard</h1>
        <a href="{{ route('parent.tuitions.create') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#1e3a8a]/90">
            <i class="fas fa-plus mr-2"></i>Post Tuition Requirement
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Requirements</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tuitions->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tuitions->where('status', 'Confirmed')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">In Progress / Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tuitions->whereNotIn('status', ['Confirmed', 'Cancelled'])->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Your Home Tuition Requirements</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold">Class & Subjects</th>
                        <th class="px-6 py-4 font-bold">Location</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Date Posted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tuitions as $tuition)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $tuition->class }}</div>
                                <div class="text-gray-500 text-xs">{{ $tuition->subjects }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $tuition->location }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $tuition->status === 'Confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ in_array($tuition->status, ['New Lead', 'Pending']) ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ in_array($tuition->status, ['Demo Scheduled', 'Demo Completed']) ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $tuition->status === 'Cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                ">
                                    {{ $tuition->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $tuition->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                You haven't posted any tuition requirements yet.
                                <br>
                                <a href="{{ route('parent.tuitions.create') }}" class="text-[#1e3a8a] font-bold hover:underline mt-2 inline-block">Post one now</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
