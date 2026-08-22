@extends('layouts.admin')

@section('title', 'Add New Tuition Requirement')
@section('subtitle', 'Enter details to post a new tuition requirement.')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tuition-leads.index') }}" class="text-sm text-text-dark/60 hover:text-accent-blue transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Tuition Leads
    </a>
</div>

<div class="bg-card-bg rounded-2xl border border-card-border p-8 shadow-sm max-w-4xl mx-auto">
    <form action="{{ route('admin.tuition-leads.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Parent Name --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Your Name / Parent Name *</label>
                <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Enter full name"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('parent_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Parent Mobile --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Phone Number *</label>
                <input type="text" name="parent_mobile" value="{{ old('parent_mobile') }}" required placeholder="Enter phone number"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('parent_mobile') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Class / Grade --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Student's Class *</label>
                <input type="text" name="class" value="{{ old('class') }}" required placeholder="e.g. Class 10"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('class') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Board --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Board *</label>
                <input type="text" name="board" value="{{ old('board') }}" required placeholder="e.g. CBSE / ICSE / State Board"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('board') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Subjects --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Subjects Needed *</label>
                <input type="text" name="subjects" value="{{ old('subjects') }}" required placeholder="e.g., Math, Science, English"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('subjects') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Complete Location --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Complete Location / Address *</label>
                <input type="text" name="location" value="{{ old('location') }}" required placeholder="Enter full address or area"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('location') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Pincode --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Pincode *</label>
                <input type="text" name="pincode" value="{{ old('pincode') }}" placeholder="Enter 6-digit Pincode"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('pincode') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Publishing Status *</label>
                <select name="status" required class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                    <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>✅ Approved (Publish Live on Website)</option>
                    <option value="New Lead" {{ old('status', 'New Lead') == 'New Lead' ? 'selected' : '' }}>⏳ New Lead (Save as Draft / Awaiting Review)</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-card-border">
            <a href="{{ route('admin.tuition-leads.index') }}" class="px-6 py-3 bg-secondary-bg text-text-main border border-card-border rounded-xl text-sm font-bold hover:bg-card-border/50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-accent-blue text-white px-8 py-3 rounded-xl font-bold hover:bg-accent-blue-hover transition-colors shadow-lg shadow-accent-blue/20 flex items-center gap-2">
                <i class="fas fa-paper-plane"></i> Post Tuition Lead
            </button>
        </div>
    </form>
</div>
@endsection
