@extends('layouts.admin')

@section('title', 'Edit Tuition Requirement')
@section('subtitle', 'Update details and publish to the tuition board.')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tuition-leads.index') }}" class="text-sm text-text-dark/60 hover:text-accent-blue transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Tuition Leads
    </a>
</div>

<div class="bg-card-bg rounded-2xl border border-card-border p-8 shadow-sm max-w-4xl mx-auto">
    <form action="{{ route('admin.tuition-leads.update', $lead->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Parent Name --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Parent / Student Name *</label>
                <input type="text" name="parent_name" value="{{ old('parent_name', $lead->parent_name) }}" required
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('parent_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Parent Mobile --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Contact Mobile Number *</label>
                <input type="text" name="parent_mobile" value="{{ old('parent_mobile', $lead->parent_mobile) }}" required
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('parent_mobile') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Class / Grade --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Student's Class / Grade *</label>
                <input type="text" name="class" value="{{ old('class', $lead->class) }}" required placeholder="e.g. Class 10 / Class 12"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('class') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Subjects --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Subject(s) Needed *</label>
                <input type="text" name="subjects" value="{{ old('subjects', $lead->subjects) }}" required placeholder="e.g. Mathematics, Physics"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('subjects') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Complete Location --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Location / Area Address *</label>
                <input type="text" name="location" value="{{ old('location', $lead->location) }}" required placeholder="e.g. Kankarbagh, Patna"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('location') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Monthly Budget / Fee --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Monthly Fee / Budget</label>
                <input type="text" name="fee" value="{{ old('fee', $lead->fee) }}" placeholder="e.g. ₹3,500 / month"
                       class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                @error('fee') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Tutor Gender Preference --}}
            <div>
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Tutor Preference</label>
                <select name="tutor_preference" class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                    <option value="Any" {{ old('tutor_preference', $lead->tutor_preference) == 'Any' ? 'selected' : '' }}>Any Preference</option>
                    <option value="Male" {{ old('tutor_preference', $lead->tutor_preference) == 'Male' ? 'selected' : '' }}>Male Tutor</option>
                    <option value="Female" {{ old('tutor_preference', $lead->tutor_preference) == 'Female' ? 'selected' : '' }}>Female Tutor</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Tuition Status *</label>
                <select name="status" required class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                    <option value="Approved" {{ old('status', $lead->status) == 'Approved' ? 'selected' : '' }}>✅ Approved (Live on Website / Open for Tutors)</option>
                    <option value="New Lead" {{ old('status', $lead->status) == 'New Lead' ? 'selected' : '' }}>⏳ New Lead (Awaiting Approval)</option>
                    <option value="Confirmed" {{ old('status', $lead->status) == 'Confirmed' ? 'selected' : '' }}>🎉 Confirmed (Tutor Appointed)</option>
                    <option value="Cancelled" {{ old('status', $lead->status) == 'Cancelled' ? 'selected' : '' }}>❌ Cancelled / Closed</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-card-border">
            <a href="{{ route('admin.tuition-leads.index') }}" class="px-6 py-3 bg-secondary-bg text-text-main border border-card-border rounded-xl text-sm font-bold hover:bg-card-border/50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-accent-blue text-white px-8 py-3 rounded-xl font-bold hover:bg-accent-blue-hover transition-colors shadow-lg shadow-accent-blue/20 flex items-center gap-2">
                <i class="fas fa-save"></i> Save & Update
            </button>
        </div>
    </form>
</div>
@endsection
