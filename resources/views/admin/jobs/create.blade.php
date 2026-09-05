@extends('layouts.admin')

@section('title', 'Post New Job')
@section('subtitle', 'Create a new job posting directly from the admin panel.')

@section('actions')
    <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 bg-secondary-bg border border-card-border hover:bg-card-border/50 text-text-main rounded-xl text-sm font-semibold transition-all">
        <i class="fas fa-arrow-left mr-2"></i> Back to Jobs
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-card-bg border border-card-border rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 border-b border-card-border bg-secondary-bg/30">
            <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                <i class="fas fa-briefcase text-accent-blue"></i> Job Details
            </h3>
        </div>

        <form action="{{ route('admin.jobs.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- School Name -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">School/Institution Name</label>
                    <input type="text" name="school_name" value="{{ old('school_name', request('school_name')) }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. Delhi Public School">
                    @error('school_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Contact Person -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', request('contact_person')) }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. Mr. Sharma">
                    @error('contact_person') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', request('email')) }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. hr@school.com">
                    @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Phone Number <span class="text-xs text-text-dark/40 font-normal lowercase">(optional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone', request('phone')) }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. 9876543210 (optional)">
                    @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="h-px w-full bg-card-border my-8"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Job Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. Senior Physics Teacher">
                    @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Job Category *</label>
                    <select name="category_id" id="category_id" required class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Subject (Dynamic based on Category) -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Subject *</label>
                    <select name="subject_id" id="subject_id" required {{ old('category_id') ? '' : 'disabled' }} class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all disabled:opacity-50 cursor-pointer">
                        <option value="">{{ old('category_id') ? 'Select Subject' : '— First Select Category —' }}</option>
                        @if(old('category_id'))
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('subject_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Specialization (Text Input) -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Specialization <span class="text-xs text-text-dark/40 font-normal lowercase">(optional)</span></label>
                    <input type="text" name="specialization_name" value="{{ old('specialization_name') }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. Physics / Botany / Admission Sales / Vedic Maths">
                    @error('specialization_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Qualification -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Required Qualification *</label>
                    <select name="qualification_id" id="qualification_id" required class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                        <option value="">Select Qualification</option>
                        @foreach($qualifications as $qualification)
                            <option value="{{ $qualification->id }}" {{ old('qualification_id') == $qualification->id ? 'selected' : '' }}>{{ $qualification->name }}</option>
                        @endforeach
                    </select>
                    @error('qualification_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Other / Additional Qualification -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Other / Additional Qualification <span class="text-xs text-text-dark/40 font-normal lowercase">(optional)</span></label>
                    <input type="text" name="other_qualification" value="{{ old('other_qualification') }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. CTET, STET, NTT, or specific requirements">
                    @error('other_qualification') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- State -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">State *</label>
                    <select name="state_id" id="state_id" required class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('state_id', request('state_id')) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                    @error('state_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- City -->
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">City *</label>
                    <select name="city_id" id="city_id" required class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all cursor-pointer">
                        <option value="">Select City</option>
                    </select>
                    @error('city_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Salary Range -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Salary Range</label>
                    <input type="text" name="salary_range" value="{{ old('salary_range') }}" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="e.g. 30,000 - 45,000 / month">
                    @error('salary_range') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Job Description & Requirements</label>
                    <textarea name="description" id="editor" rows="5" class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all" placeholder="Enter detailed job description, responsibilities, and requirements here...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-2">Publishing Status *</label>
                    <select name="status" required class="w-full bg-secondary-bg border border-card-border text-text-main rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <option value="approved" selected>Live / Approved (Publish Immediately)</option>
                        <option value="pending">Pending Review (Save as Draft)</option>
                        <option value="rejected">Rejected / Closed</option>
                    </select>
                    @error('status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.jobs.index') }}" class="px-6 py-3 rounded-xl font-bold text-sm text-text-main bg-secondary-bg border border-card-border hover:bg-card-border/50 transition-all">Cancel</a>
                <button type="submit" class="px-8 py-3 rounded-xl font-bold text-sm text-white bg-accent-blue hover:bg-accent-blue/90 shadow-lg shadow-accent-blue/20 transition-all">Post Job</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
        color: #1e293b !important;
        background-color: #ffffff !important;
        border-radius: 0 0 0.75rem 0.75rem !important;
    }
    .ck-toolbar {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border-color: #cbd5e1 !important;
        background-color: #f8fafc !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editorEl = document.querySelector('#editor');
        if (editorEl) {
            ClassicEditor
                .create(editorEl, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
                })
                .catch(error => console.error('CKEditor init error:', error));
        }
    });

    function updateDynamicSelect(selectEl, options, placeholder = 'Select Option') {
        if (!selectEl) return;
        let html = `<option value="">${placeholder}</option>`;
        options.forEach(item => {
            html += `<option value="${item.id}">${item.name}</option>`;
        });
        selectEl.innerHTML = html;
        selectEl.disabled = false;

        if (selectEl._slimSelect) {
            try {
                const ssData = [
                    { text: placeholder, value: '', placeholder: true },
                    ...options.map(item => ({ text: item.name, value: String(item.id) }))
                ];
                selectEl._slimSelect.setData(ssData);
                selectEl._slimSelect.enable();
            } catch (e) {
                if (typeof window.refreshSearchableSelect === 'function') {
                    window.refreshSearchableSelect(selectEl);
                }
            }
        }
    }

    function setSelectLoading(selectEl, placeholder = 'Loading...') {
        if (!selectEl) return;
        selectEl.innerHTML = `<option value="">${placeholder}</option>`;
        selectEl.disabled = true;
        if (selectEl._slimSelect) {
            try {
                selectEl._slimSelect.setData([{ text: placeholder, value: '', placeholder: true }]);
                selectEl._slimSelect.disable();
            } catch (e) {}
        }
    }

    function resetDynamicSelect(selectEl, placeholder = '— First Select Option —') {
        if (!selectEl) return;
        selectEl.innerHTML = `<option value="">${placeholder}</option>`;
        selectEl.disabled = true;
        if (selectEl._slimSelect) {
            try {
                selectEl._slimSelect.setData([{ text: placeholder, value: '', placeholder: true }]);
                selectEl._slimSelect.disable();
            } catch (e) {}
        }
    }

    // Category -> Subject
    const categorySelect = document.getElementById('category_id');
    const subjectSelect = document.getElementById('subject_id');
    const specializationWrapper = document.getElementById('specialization_wrapper');
    const specializationSelect = document.getElementById('specialization_id');
    const defaultSpecId = "{{ old('specialization_id') }}";

    function loadSubjectSpecializations(subjectId, selectedSpecId = null) {
        if (!specializationSelect || !specializationWrapper) return;
        if (subjectId) {
            fetch(`/api/subjects/${subjectId}/specializations`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        specializationWrapper.style.display = 'block';
                        updateDynamicSelect(specializationSelect, data, 'Select Specialization (Optional)');
                        if (selectedSpecId) {
                            specializationSelect.value = selectedSpecId;
                            if (specializationSelect._slimSelect) {
                                specializationSelect._slimSelect.setSelected(String(selectedSpecId));
                            }
                        }
                    } else {
                        specializationWrapper.style.display = 'none';
                        specializationSelect.innerHTML = '<option value="">Select Specialization (Optional)</option>';
                        specializationSelect.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching specializations:', error);
                    specializationWrapper.style.display = 'none';
                });
        } else {
            specializationWrapper.style.display = 'none';
            specializationSelect.innerHTML = '<option value="">Select Specialization (Optional)</option>';
            specializationSelect.value = '';
        }
    }

    if (categorySelect && subjectSelect) {
        categorySelect.addEventListener('change', function() {
            let categoryId = this.value;
            if (specializationWrapper) specializationWrapper.style.display = 'none';
            if (specializationSelect) {
                specializationSelect.innerHTML = '<option value="">Select Specialization (Optional)</option>';
                specializationSelect.value = '';
            }

            if (categoryId) {
                setSelectLoading(subjectSelect, 'Loading subjects...');
                fetch(`/api/categories/${categoryId}/subjects`)
                    .then(response => response.json())
                    .then(data => {
                        updateDynamicSelect(subjectSelect, data, 'Select Subject');
                    })
                    .catch(error => {
                        console.error('Error fetching subjects:', error);
                        updateDynamicSelect(subjectSelect, [], 'Select Subject');
                    });
            } else {
                resetDynamicSelect(subjectSelect, '— First Select Category —');
            }
        });
    }

    if (subjectSelect) {
        subjectSelect.addEventListener('change', function() {
            loadSubjectSpecializations(this.value);
        });

        if (subjectSelect.value) {
            loadSubjectSpecializations(subjectSelect.value, defaultSpecId);
        }
    }

    // State -> City
    const stateSelect = document.getElementById('state_id');
    const citySelect = document.getElementById('city_id');
    const defaultStateId = "{{ old('state_id', request('state_id')) }}";
    const defaultCityId = "{{ old('city_id', request('city_id')) }}";

    function loadStateCities(stateId, selectedCityId = null) {
        if (!citySelect) return;
        if (stateId) {
            setSelectLoading(citySelect, 'Loading cities...');
            fetch(`/api/states/${stateId}/cities`)
                .then(response => response.json())
                .then(data => {
                    updateDynamicSelect(citySelect, data, 'Select City');
                    if (selectedCityId && citySelect._slimSelect) {
                        citySelect._slimSelect.setSelected(String(selectedCityId));
                    }
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                    updateDynamicSelect(citySelect, [], 'Select City');
                });
        } else {
            resetDynamicSelect(citySelect, 'Select City');
        }
    }

    if (stateSelect && citySelect) {
        stateSelect.addEventListener('change', function() {
            loadStateCities(this.value);
        });

        if (defaultStateId) {
            loadStateCities(defaultStateId, defaultCityId);
        }
    }
</script>
@endpush
@endsection
