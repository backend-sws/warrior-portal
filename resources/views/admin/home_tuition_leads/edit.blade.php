@extends('layouts.admin')

@section('title', 'Edit Tuition Requirement')
@section('subtitle', 'Review details and manage tuition requirement publishing status.')

@section('actions')
    <a href="{{ route('admin.tuition-leads.index') }}" class="px-4 py-2 bg-secondary-bg border border-card-border hover:border-accent-blue/40 text-text-main rounded-xl text-sm font-semibold transition-all inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Tuition Leads
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-card-bg border border-card-border rounded-2xl shadow-xl overflow-hidden">
        
        <!-- Header Card Ribbon -->
        <div class="p-6 border-b border-card-border bg-secondary-bg/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-accent-blue/10 border border-accent-blue/20 flex items-center justify-center text-accent-blue font-bold text-lg">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-text-main">Edit Tuition Details</h3>
                    <p class="text-xs text-text-dark/60 mt-0.5">Submitted by <span class="font-semibold text-text-main">{{ $lead->parent_name }}</span></p>
                </div>
            </div>
            
            <div>
                @if($lead->status === 'Approved')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 rounded-full text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live on Website
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 text-amber-600 border border-amber-500/20 rounded-full text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Awaiting Review
                    </span>
                @endif
            </div>
        </div>

        <form action="{{ route('admin.tuition-leads.update', $lead->id) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Section 1: Parent & Contact Info -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-user-circle text-accent-blue text-sm"></i>
                    <h4 class="text-xs font-bold text-text-dark/80 uppercase tracking-wider">Parent / Client Information</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Parent / Client Name <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="parent_name" value="{{ old('parent_name', $lead->parent_name) }}" required placeholder="Enter full name"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>
                        @error('parent_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Phone Number <span class="text-xs text-text-dark/40 font-normal lowercase">(optional)</span></label>
                        <div class="relative">
                            <i class="fas fa-phone-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="parent_mobile" value="{{ old('parent_mobile', $lead->parent_mobile) }}" placeholder="Enter phone number (optional)"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>
                        @error('parent_mobile') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="h-px w-full bg-card-border"></div>

            <!-- Section 2: Academic Requirements -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-graduation-cap text-accent-blue text-sm"></i>
                    <h4 class="text-xs font-bold text-text-dark/80 uppercase tracking-wider">Tuition Academic Details</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Student's Class / Grade <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-chalkboard absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="class" value="{{ old('class', $lead->class) }}" required placeholder="e.g. Class 10"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>
                        @error('class') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Board <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-university absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="board" value="{{ old('board', $lead->board) }}" required placeholder="e.g. CBSE / ICSE / State Board"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>
                        @error('board') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Subjects Needed <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-book-open absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="subjects" value="{{ old('subjects', $lead->subjects) }}" required placeholder="e.g. Mathematics, Physics, Chemistry"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>
                        @error('subjects') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="h-px w-full bg-card-border"></div>

            <!-- Section 3: Location Details -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-map-marked-alt text-accent-blue text-sm"></i>
                    <h4 class="text-xs font-bold text-text-dark/80 uppercase tracking-wider">Location & Address</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Complete Location / Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="location" value="{{ old('location', $lead->location) }}" required placeholder="Enter full address or area (e.g. Kankarbagh, Patna)"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>
                        @error('location') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Pincode</label>
                        <div class="relative">
                            <i class="fas fa-mail-bulk absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="pincode" value="{{ old('pincode', $lead->pincode) }}" placeholder="6-digit Pincode"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all font-mono">
                        </div>
                        @error('pincode') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="h-px w-full bg-card-border"></div>

            <!-- Section 4: Publishing Status & Homepage Feature -->
            <div class="bg-secondary-bg/30 p-5 rounded-2xl border border-card-border space-y-4">
                <div>
                    <label class="block text-xs font-bold text-text-dark/80 uppercase tracking-wider mb-2">Publishing Status <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="status" required class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                            <option value="Approved" {{ old('status', $lead->status) == 'Approved' ? 'selected' : '' }}>✅ Approved (Live on Website / Open for Tutors to Apply)</option>
                            <option value="New Lead" {{ old('status', $lead->status) == 'New Lead' ? 'selected' : '' }}>⏳ New Lead (Awaiting Admin Review & Approval)</option>
                            <option value="Confirmed" {{ old('status', $lead->status) == 'Confirmed' ? 'selected' : '' }}>🎉 Confirmed (Tutor Appointed & Assigned)</option>
                            <option value="Cancelled" {{ old('status', $lead->status) == 'Cancelled' ? 'selected' : '' }}>❌ Cancelled / Closed</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 border-t border-card-border/60">
                    <label class="flex items-start gap-3 cursor-pointer select-none">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $lead->is_featured) ? 'checked' : '' }} class="w-5 h-5 mt-0.5 rounded-lg border-card-border text-accent-blue focus:ring-accent-blue/40 transition-all">
                        <div>
                            <span class="text-sm font-bold text-text-main flex items-center gap-1.5">
                                <i class="fas fa-star text-amber-500"></i> Feature on Welcome Page
                            </span>
                            <span class="text-xs text-text-dark/60 block mt-0.5">Check this to prominently showcase this tuition card on the homepage.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-card-border">
                <a href="{{ route('admin.tuition-leads.index') }}" class="px-5 py-2.5 bg-secondary-bg text-text-main border border-card-border rounded-xl text-sm font-semibold hover:bg-card-border/50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-accent-blue text-white px-7 py-2.5 rounded-xl font-bold hover:bg-accent-blue-hover transition-colors shadow-lg shadow-accent-blue/20 flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
