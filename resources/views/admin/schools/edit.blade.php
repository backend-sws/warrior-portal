@extends('layouts.admin')

@section('title', 'Edit ' . $school->school_name)
@section('subtitle', 'Update institution contact details, address, and status.')

@section('actions')
    <a href="{{ route('admin.schools.show', $school->id) }}" class="px-4 py-2 bg-secondary-bg border border-card-border hover:border-accent-blue/40 text-text-main rounded-xl text-xs sm:text-sm font-semibold transition-all inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to School Profile
    </a>
@endsection

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="bg-card-bg border border-card-border rounded-3xl shadow-xl overflow-hidden">
        
        <div class="p-6 bg-[#031b4e] text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-amber-300">
                    <i class="fas fa-pen text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white tracking-tight">Edit School Details</h3>
                    <p class="text-xs text-white/60 mt-0.5">{{ $school->school_name }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.schools.update', $school->id) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- School Name -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                        School / Institute Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="school_name" value="{{ old('school_name', $school->school_name) }}" required
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-bold text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                    @error('school_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Institution Type -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Institution Type <span class="text-red-500">*</span></label>
                    <select name="institution_type" required class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                        <option value="School" {{ old('institution_type', $school->institution_type) === 'School' ? 'selected' : '' }}>🏫 School</option>
                        <option value="College" {{ old('institution_type', $school->institution_type) === 'College' ? 'selected' : '' }}>🎓 College</option>
                        <option value="Coaching / Institute" {{ old('institution_type', $school->institution_type) === 'Coaching / Institute' ? 'selected' : '' }}>📚 Coaching / Institute</option>
                        <option value="Preschool" {{ old('institution_type', $school->institution_type) === 'Preschool' ? 'selected' : '' }}>🧸 Preschool</option>
                    </select>
                </div>

                <!-- Board -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Board / Affiliation</label>
                    <input type="text" name="board" value="{{ old('board', $school->board) }}" placeholder="e.g. CBSE / ICSE / State Board"
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                </div>

                <!-- Contact Person -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Contact Person / Principal <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', $school->contact_person) }}" required
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $school->phone) }}" required
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                </div>

                <!-- Alt Phone -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Alternate Phone</label>
                    <input type="text" name="alt_phone" value="{{ old('alt_phone', $school->alt_phone) }}"
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $school->email ?: $school->user?->email) }}"
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                </div>

                <!-- State -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">State</label>
                    <select name="state_id" id="edit_state_id" class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('state_id', $school->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- City -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">City</label>
                    <select name="city_id" id="edit_city_id" class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                        <option value="">Select City</option>
                        @foreach($cities as $c)
                            <option value="{{ $c->id }}" {{ old('city_id', $school->city_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Address</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">{{ old('address', $school->address) }}</textarea>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Client Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-bold text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                        <option value="Active Client" {{ old('status', $school->status) === 'Active Client' ? 'selected' : '' }}>🟢 Active Client</option>
                        <option value="Lead / Prospect" {{ old('status', $school->status) === 'Lead / Prospect' ? 'selected' : '' }}>🟡 Lead / Prospect</option>
                        <option value="In Discussion" {{ old('status', $school->status) === 'In Discussion' ? 'selected' : '' }}>🟣 In Discussion</option>
                        <option value="Inactive" {{ old('status', $school->status) === 'Inactive' ? 'selected' : '' }}>⚪ Inactive</option>
                    </select>
                </div>

                <!-- Website -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Website</label>
                    <input type="text" name="website" value="{{ old('website', $school->website) }}"
                           class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Offline / Admin Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">{{ old('notes', $school->notes) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-card-border">
                <a href="{{ route('admin.schools.show', $school->id) }}" class="px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-text-main bg-secondary-bg hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-white bg-accent-blue hover:bg-blue-700 shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                    <i class="fas fa-save"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const editStateSelect = document.getElementById('edit_state_id');
    const editCitySelect = document.getElementById('edit_city_id');

    if (editStateSelect && editCitySelect) {
        editStateSelect.addEventListener('change', function() {
            let stateId = this.value;
            if (stateId) {
                editCitySelect.innerHTML = '<option value="">Loading cities...</option>';
                fetch(`/api/states/${stateId}/cities`)
                    .then(res => res.json())
                    .then(data => {
                        let html = '<option value="">Select City</option>';
                        data.forEach(c => {
                            html += `<option value="${c.id}">${c.name}</option>`;
                        });
                        editCitySelect.innerHTML = html;
                        if (typeof window.refreshSearchableSelect === 'function') {
                            window.refreshSearchableSelect(editCitySelect);
                        }
                    })
                    .catch(() => {
                        editCitySelect.innerHTML = '<option value="">Select City</option>';
                    });
            } else {
                editCitySelect.innerHTML = '<option value="">Select City</option>';
            }
        });
    }
</script>
@endpush

@endsection
