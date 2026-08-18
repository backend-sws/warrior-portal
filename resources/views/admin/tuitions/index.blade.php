@extends('layouts.admin')

@section('title', 'Manage Tuitions')
@section('subtitle', 'View and manage home tuition requirements posted by employers and guests.')

@section('actions')
    <a href="{{ route('admin.tuitions.create') }}" class="px-5 py-2.5 bg-accent-blue text-white hover:bg-accent-blue/90 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 shadow-sm">
        <i class="fas fa-plus"></i> Post New Tuition
    </a>
@endsection

@section('content')
<div x-data="{ activeTab: 'employers' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 border-b border-green-100 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Header -->
    <div class="flex border-b border-gray-100">
        <button @click="activeTab = 'employers'" :class="{'border-accent-blue text-accent-blue': activeTab === 'employers', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'employers'}" class="px-6 py-4 font-semibold text-sm border-b-2 transition-colors">
            <i class="fas fa-briefcase mr-2"></i> Employer Posted
            <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $employerTuitions->total() }}</span>
        </button>
        <button @click="activeTab = 'guests'" :class="{'border-accent-blue text-accent-blue': activeTab === 'guests', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'guests'}" class="px-6 py-4 font-semibold text-sm border-b-2 transition-colors">
            <i class="fas fa-user-graduate mr-2"></i> Guest Requests
            <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $guestTuitions->total() }}</span>
        </button>
        <button @click="activeTab = 'applied'" :class="{'border-accent-blue text-accent-blue': activeTab === 'applied', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'applied'}" class="px-6 py-4 font-semibold text-sm border-b-2 transition-colors">
            <i class="fas fa-paper-plane mr-2"></i> Applied Tuitions
            <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $appliedTuitions->total() }}</span>
        </button>
    </div>

    <!-- Employer Tab -->
    <div x-show="activeTab === 'employers'" x-cloak>
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Posted By</th>
                        <th class="px-6 py-4">Details</th>
                        <th class="px-6 py-4">Location</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($employerTuitions as $tuition)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $tuition->employer->name === 'Super Admin' ? 'Warriors Educare' : $tuition->employer->name }} <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded ml-1">Employer</span></div>
                                <div class="text-xs text-gray-500">{{ $tuition->employer->phone ?? $tuition->employer->email }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $tuition->created_at->format('d M Y, h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $tuition->subjects }}</div>
                                <div class="text-xs text-gray-500">{{ $tuition->student_class }} • {{ $tuition->board }}</div>
                                @if($tuition->description)
                                    <div class="text-xs text-gray-400 mt-1 line-clamp-2" title="{{ $tuition->description }}">{{ $tuition->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800"><i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>{{ $tuition->location }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.tuitions.update', $tuition->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-full px-3 py-1 border-gray-200 shadow-sm focus:ring-accent-blue focus:border-accent-blue
                                        @if($tuition->status == 'Active') bg-green-50 text-green-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        <option value="Active" {{ $tuition->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $tuition->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.tuitions.destroy', $tuition->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tuition requirement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-2" title="Delete Tuition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <p>No employer tuition requirements posted yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employerTuitions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $employerTuitions->links() }}
            </div>
        @endif
    </div>

    <!-- Guest Tab -->
    <div x-show="activeTab === 'guests'" x-cloak style="display: none;">
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Posted By</th>
                        <th class="px-6 py-4">Details</th>
                        <th class="px-6 py-4">Location</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($guestTuitions as $tuition)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $tuition->guest_name }} <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-0.5 rounded ml-1">Guest</span></div>
                                <div class="text-xs text-gray-500">{{ $tuition->guest_phone }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $tuition->created_at->format('d M Y, h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $tuition->subjects }}</div>
                                <div class="text-xs text-gray-500">{{ $tuition->student_class }} • {{ $tuition->board }}</div>
                                @if($tuition->description)
                                    <div class="text-xs text-gray-400 mt-1 line-clamp-2" title="{{ $tuition->description }}">{{ $tuition->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800"><i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>{{ $tuition->location }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.tuitions.update', $tuition->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-full px-3 py-1 border-gray-200 shadow-sm focus:ring-accent-blue focus:border-accent-blue
                                        @if($tuition->status == 'Pending') bg-yellow-50 text-yellow-700
                                        @elseif($tuition->status == 'Matched') bg-green-50 text-green-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        <option value="Pending" {{ $tuition->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Matched" {{ $tuition->status == 'Matched' ? 'selected' : '' }}>Matched</option>
                                        <option value="Closed" {{ $tuition->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.tuitions.destroy', $tuition->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tuition requirement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-2" title="Delete Tuition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <p>No guest tuition requests posted yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($guestTuitions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $guestTuitions->links() }}
            </div>
        @endif
    </div>
    
    <!-- Applied Tuitions Tab -->
    <div x-show="activeTab === 'applied'" x-cloak style="display: none;">
        <div class="overflow-x-auto">
            <table class="w-full admin-table">
                <thead>
                    <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Candidate</th>
                        <th class="px-6 py-4">Applied Tuition</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Applied At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($appliedTuitions as $application)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $application->candidate->name }}</div>
                                <div class="text-xs text-gray-500">{{ $application->candidate->email }}</div>
                                <div class="text-xs text-gray-500">{{ $application->candidate->phone ?? 'No Phone' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $application->tuitionLead->subjects ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $application->tuitionLead->{'class'} ?? '' }} • {{ $application->tuitionLead->board ?? '' }}</div>
                                <div class="text-xs text-gray-400 mt-1 line-clamp-2" title="{{ $application->tuitionLead->location ?? '' }}">📍 {{ $application->tuitionLead->location ?? 'No location specified' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold px-3 py-1 rounded-full 
                                    {{ $application->status == 'Applied' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $application->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-500">{{ $application->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $application->created_at->format('h:i A') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                    <i class="fas fa-paper-plane text-gray-400 text-xl"></i>
                                </div>
                                <p>No candidates have applied for tuitions yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appliedTuitions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $appliedTuitions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
