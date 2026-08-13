@extends('layouts.parent')

@section('content')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-check"></i>
                </div>
                Appointed Teachers
            </h1>
            <p class="text-gray-500 mt-1">Teachers appointed and finalized for your tuition requirements.</p>
        </div>
    </div>

    @if($appointedLeads->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($appointedLeads as $lead)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Header / Photo -->
                <div class="bg-blue-50 p-6 flex flex-col items-center justify-center border-b border-gray-100 relative">
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded border border-green-200">
                        <i class="fas fa-check-circle mr-1"></i>Appointed
                    </span>
                    <div class="w-24 h-24 rounded-full bg-white border-4 border-white shadow-sm overflow-hidden mb-3">
                        @if($lead->teacher_passport_photo)
                            <img src="{{ asset('storage/' . $lead->teacher_passport_photo) }}" alt="Teacher Photo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-3xl font-bold">
                                {{ strtoupper(substr($lead->teacher_name ?? 'T', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 text-center">{{ $lead->teacher_name ?? 'Assigned Teacher' }}</h3>
                    <p class="text-sm text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i> {{ $lead->teacher_contact ?? 'N/A' }}</p>
                </div>

                <!-- Details -->
                <div class="p-6">
                    <div class="mb-4">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tuition Details</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[10px] font-bold text-gray-500">Student Class</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $lead->class }}</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[10px] font-bold text-gray-500">Subjects</span>
                                <span class="text-sm font-semibold text-gray-900 truncate" title="{{ $lead->subjects }}">{{ Str::limit($lead->subjects, 15) }}</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100 col-span-2">
                                <span class="block text-[10px] font-bold text-gray-500">Location</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $lead->location }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                        @if($lead->teacher_contact)
                            <a href="tel:{{ $lead->teacher_contact }}" class="flex-1 bg-blue-50 text-blue-600 hover:bg-blue-100 py-2.5 rounded-lg text-center font-semibold text-sm transition-colors border border-blue-100">
                                <i class="fas fa-phone-alt mr-1"></i> Call
                            </a>
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->teacher_contact) }}" target="_blank" class="flex-1 bg-green-50 text-green-600 hover:bg-green-100 py-2.5 rounded-lg text-center font-semibold text-sm transition-colors border border-green-100">
                                <i class="fab fa-whatsapp mr-1"></i> Chat
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <i class="fas fa-user-slash text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Teachers Appointed Yet</h3>
            <p class="text-gray-500 max-w-md mx-auto">Once a teacher is finalized for your tuition requirements, their details and photo will appear here.</p>
            <div class="mt-6">
                <a href="{{ route('parent.tuitions.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold transition-colors">
                    <i class="fas fa-plus"></i> Post New Requirement
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
