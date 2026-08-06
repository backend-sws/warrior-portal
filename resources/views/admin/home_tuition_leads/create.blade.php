@extends('layouts.admin')

@section('title', 'Add New Home Tuition Lead')
@section('subtitle', 'Enter details for a new home tuition enquiry.')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tuition-leads.index') }}" class="text-sm text-text-dark/60 hover:text-accent-blue transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Leads
    </a>
</div>

<div class="bg-card-bg rounded-2xl border border-card-border p-6 shadow-sm">
    <form action="{{ route('admin.tuition-leads.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Parent Info --}}
            <div class="space-y-4 col-span-1 lg:col-span-3 pb-4 border-b border-card-border">
                <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-user-circle text-accent-blue"></i> Parent & Student Info
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Parent Name *</label>
                        <input type="text" name="parent_name" value="{{ old('parent_name') }}" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('parent_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Parent Mobile *</label>
                        <input type="text" name="parent_mobile" value="{{ old('parent_mobile') }}" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('parent_mobile') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Location/Address *</label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('location') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Tuition Details --}}
            <div class="space-y-4 col-span-1 lg:col-span-3 pb-4 border-b border-card-border">
                <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-book text-accent-blue"></i> Tuition Requirements
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Class *</label>
                        <input type="text" name="class" value="{{ old('class') }}" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('class') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-semibold text-text-dark mb-1">Subject(s) *</label>
                        <input type="text" name="subjects" value="{{ old('subjects') }}" required placeholder="e.g., Math, Science"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('subjects') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Tutor Preference *</label>
                        <select name="tutor_preference" required class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                            <option value="Any" {{ old('tutor_preference') == 'Any' ? 'selected' : '' }}>Any</option>
                            <option value="Male" {{ old('tutor_preference') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('tutor_preference') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('tutor_preference') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Preferred Timing</label>
                        <input type="text" name="preferred_timing" value="{{ old('preferred_timing') }}" placeholder="e.g., 4 PM to 6 PM"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('preferred_timing') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Administrative --}}
            <div class="space-y-4 col-span-1 lg:col-span-3">
                <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-accent-blue"></i> Management Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Lead Status *</label>
                        <select name="status" required class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                            <option value="New Lead" {{ old('status') == 'New Lead' ? 'selected' : '' }}>New Lead</option>
                            <option value="Demo Scheduled" {{ old('status') == 'Demo Scheduled' ? 'selected' : '' }}>Demo Scheduled</option>
                            <option value="Demo Completed" {{ old('status') == 'Demo Completed' ? 'selected' : '' }}>Demo Completed</option>
                            <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Enquiry Date</label>
                        <input type="date" name="enquiry_date" value="{{ old('enquiry_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('enquiry_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Follow-up Date</label>
                        <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('follow_up_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Fee Quoted</label>
                        <input type="text" name="fee" value="{{ old('fee') }}" placeholder="e.g., 3000/month"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('fee') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Teacher Contact No.</label>
                        <input type="text" name="teacher_contact" value="{{ old('teacher_contact') }}" placeholder="If assigned"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('teacher_contact') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-semibold text-text-dark mb-1">Dues Information</label>
                        <input type="text" name="dues" value="{{ old('dues') }}" placeholder="e.g., Paid by tutor, Parent successful"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        @error('dues') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-1 lg:col-span-4">
                        <label class="block text-sm font-semibold text-text-dark mb-1">Additional Notes</label>
                        <textarea name="additional_notes" rows="3" placeholder="Any extra information..."
                                  class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">{{ old('additional_notes') }}</textarea>
                        @error('additional_notes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-card-border">
            <button type="submit" class="bg-accent-blue text-white px-8 py-2.5 rounded-xl font-bold hover:bg-accent-blue-hover transition-colors shadow-lg shadow-accent-blue/20">
                Save Lead
            </button>
        </div>
    </form>
</div>
@endsection
