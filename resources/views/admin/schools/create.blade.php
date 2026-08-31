@extends('layouts.admin')

@section('title', 'Add New School / Educational Client')
@section('subtitle', 'Manually record offline/walk-in schools, institutes, or coaching clients into the CRM.')

@section('actions')
    <a href="{{ route('admin.schools.index') }}" class="px-4 py-2 bg-secondary-bg border border-card-border hover:border-accent-blue/40 text-text-main rounded-xl text-xs sm:text-sm font-semibold transition-all inline-flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Schools
    </a>
@endsection

@section('content')

<div class="max-w-5xl mx-auto" x-data="{ hasVacancy: {{ old('has_vacancy') ? 'true' : 'false' }} }">
    <div class="bg-card-bg border border-card-border rounded-3xl shadow-xl overflow-hidden">
        
        <!-- Header Banner -->
        <div class="p-6 bg-gradient-to-r from-[#031b4e] via-[#092b77] to-[#1e40af] text-white flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-amber-300 shadow-inner">
                    <i class="fas fa-school text-xl"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-300">Manual Entry Form</span>
                    <h3 class="text-lg font-black text-white tracking-tight mt-0.5">Record School / Institute Profile</h3>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.schools.store') }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- Section 1: Institution & Contact Details -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-accent-blue flex items-center justify-center text-xs font-bold">1</div>
                    <h4 class="text-xs font-bold text-text-dark/80 uppercase tracking-wider">Institution & Contact Details</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- School Name -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            School / College / Institute Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-university absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="school_name" value="{{ old('school_name') }}" required placeholder="e.g. St. Xavier's High School / Career Point Institute"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                        </div>
                        @error('school_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Institution Type -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Institution Type <span class="text-red-500">*</span>
                        </label>
                        <select name="institution_type" required class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                            <option value="School" {{ old('institution_type', 'School') === 'School' ? 'selected' : '' }}>🏫 School (K-12 / High School)</option>
                            <option value="College" {{ old('institution_type') === 'College' ? 'selected' : '' }}>🎓 Degree / Inter College</option>
                            <option value="Coaching / Institute" {{ old('institution_type') === 'Coaching / Institute' ? 'selected' : '' }}>📚 Coaching / Training Institute</option>
                            <option value="Preschool" {{ old('institution_type') === 'Preschool' ? 'selected' : '' }}>🧸 Preschool / Daycare</option>
                        </select>
                        @error('institution_type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Board / Affiliation -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Board / Affiliation
                        </label>
                        <input type="text" name="board" value="{{ old('board') }}" placeholder="e.g. CBSE / ICSE / State Board / IB / UGC"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                        @error('board') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Contact Person Name -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Contact Person / Principal Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user-tie absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" required placeholder="e.g. Dr. Rajesh Sharma (Principal / Director)"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                        </div>
                        @error('contact_person') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Primary Phone -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Mobile / Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="e.g. 9876543210"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                        </div>
                        @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Alternate Phone -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Alternate Phone / Landline
                        </label>
                        <input type="text" name="alt_phone" value="{{ old('alt_phone') }}" placeholder="e.g. 0612-2345678 / 9876500000"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Official Email Address
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-text-dark/40 text-xs"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. info@school.com / hr@school.com"
                                   class="w-full pl-9 pr-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                        </div>
                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="h-px w-full bg-card-border"></div>

            <!-- Section 2: Location & Address -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-accent-blue flex items-center justify-center text-xs font-bold">2</div>
                    <h4 class="text-xs font-bold text-text-dark/80 uppercase tracking-wider">Location & Address</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- State -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">State</label>
                        <select name="state_id" id="school_state_id" class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">City</label>
                        <select name="city_id" id="school_city_id" class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                            <option value="">Select City</option>
                        </select>
                        @error('city_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Full Address -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Campus / Office Address</label>
                        <textarea name="address" rows="2" placeholder="e.g. Near Gandhi Maidan, Main Road, Patna, Bihar - 800001"
                                  class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">{{ old('address') }}</textarea>
                        @error('address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="h-px w-full bg-card-border"></div>

            <!-- Section 3: Status & CRM Follow-up Notes -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-accent-blue flex items-center justify-center text-xs font-bold">3</div>
                    <h4 class="text-xs font-bold text-text-dark/80 uppercase tracking-wider">CRM Status & Follow-up Details</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Client Status -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">
                            Client Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required class="w-full bg-secondary-bg border border-card-border rounded-xl px-4 py-2.5 text-sm font-bold text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 cursor-pointer">
                            <option value="Active Client" {{ old('status', 'Active Client') === 'Active Client' ? 'selected' : '' }}>🟢 Active Client (Signed Up / Hiring)</option>
                            <option value="Lead / Prospect" {{ old('status') === 'Lead / Prospect' ? 'selected' : '' }}>🟡 Lead / Prospect (Fresh Walk-in / Inquiry)</option>
                            <option value="In Discussion" {{ old('status') === 'In Discussion' ? 'selected' : '' }}>🟣 In Discussion (Proposals & Pricing)</option>
                            <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>⚪ Inactive / Closed</option>
                        </select>
                        @error('status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Next Follow-up Date -->
                    <div>
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Next Follow-up Call Date</label>
                        <input type="date" name="next_follow_up_date" value="{{ old('next_follow_up_date') }}"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1.5">Initial Discussion / Offline Notes</label>
                        <textarea name="notes" rows="3" placeholder="e.g. Principal visited office. Looking for 3 PGT Physics & Math teachers for upcoming session. Budget 35k-45k..."
                                  class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-medium text-text-main focus:bg-card-bg focus:outline-none focus:ring-2 focus:ring-accent-blue/30 transition-all">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="h-px w-full bg-card-border"></div>

            <!-- Section 4: Optional Initial Job Vacancy -->
            <div class="bg-secondary-bg/50 border border-card-border rounded-2xl p-5">
                <div class="flex items-center justify-between cursor-pointer" @click="hasVacancy = !hasVacancy">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="has_vacancy" value="1" x-model="hasVacancy" class="w-4 h-4 rounded text-accent-blue focus:ring-accent-blue/40">
                        <div>
                            <h4 class="text-sm font-bold text-text-main">Also publish a Teacher Vacancy for this school now?</h4>
                            <p class="text-xs text-text-dark/60">Optional: Post an immediate hiring job opening linked to this school.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-accent-blue" x-text="hasVacancy ? 'Collapse Vacancy Form ▲' : '+ Add Vacancy ▼'"></span>
                </div>

                <div x-show="hasVacancy" x-collapse class="mt-5 pt-5 border-t border-card-border space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1">Job Title *</label>
                            <input type="text" name="job_title" value="{{ old('job_title') }}" placeholder="e.g. Senior PGT Physics Teacher"
                                   class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/30">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1">Category</label>
                            <select name="category_id" id="job_category_id" class="w-full bg-white border border-card-border rounded-xl px-3 py-2 text-sm text-text-main focus:outline-none cursor-pointer">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1">Subject</label>
                            <select name="subject_id" id="job_subject_id" class="w-full bg-white border border-card-border rounded-xl px-3 py-2 text-sm text-text-main focus:outline-none cursor-pointer">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1">Qualification</label>
                            <select name="qualification_id" class="w-full bg-white border border-card-border rounded-xl px-3 py-2 text-sm text-text-main focus:outline-none cursor-pointer">
                                <option value="">Select Qualification</option>
                                @foreach($qualifications as $qual)
                                    <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1">Salary Range</label>
                            <input type="text" name="salary_range" value="{{ old('salary_range') }}" placeholder="e.g. ₹35,000 - ₹45,000 / month"
                                   class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/30">
                        </div>

                        <!-- Job Description with CKEditor -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-text-dark/70 uppercase tracking-wide mb-1">Job Description & Requirements</label>
                            <textarea name="job_description" id="create_job_editor" rows="5" class="w-full bg-white border border-card-border rounded-xl px-4 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/30" placeholder="Enter detailed job description, responsibilities, and requirements here...">{{ old('job_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-card-border">
                <a href="{{ route('admin.schools.index') }}" class="px-6 py-3 rounded-xl font-bold text-xs sm:text-sm text-text-main bg-secondary-bg hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 rounded-xl font-bold text-xs sm:text-sm text-white bg-accent-blue hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fas fa-save"></i>
                    <span>Save School Record</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable_inline {
        min-height: 160px;
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
        const createEditorEl = document.querySelector('#create_job_editor');
        if (createEditorEl) {
            ClassicEditor
                .create(createEditorEl, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
                })
                .catch(err => console.error('CKEditor init error:', err));
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

    // State -> City Dynamic Fetch
    const schoolStateSelect = document.getElementById('school_state_id');
    const schoolCitySelect = document.getElementById('school_city_id');

    if (schoolStateSelect && schoolCitySelect) {
        schoolStateSelect.addEventListener('change', function() {
            let stateId = this.value;
            if (stateId) {
                setSelectLoading(schoolCitySelect, 'Loading cities...');
                fetch(`/api/states/${stateId}/cities`)
                    .then(res => res.json())
                    .then(data => {
                        updateDynamicSelect(schoolCitySelect, data, 'Select City');
                    })
                    .catch(() => {
                        updateDynamicSelect(schoolCitySelect, [], 'Select City');
                    });
            } else {
                resetDynamicSelect(schoolCitySelect, 'Select City');
            }
        });
    }

    // Category -> Subject Dynamic Fetch for Vacancy
    const jobCatSelect = document.getElementById('job_category_id');
    const jobSubSelect = document.getElementById('job_subject_id');

    if (jobCatSelect && jobSubSelect) {
        jobCatSelect.addEventListener('change', function() {
            let catId = this.value;
            if (catId) {
                setSelectLoading(jobSubSelect, 'Loading subjects...');
                fetch(`/api/categories/${catId}/subjects`)
                    .then(res => res.json())
                    .then(data => {
                        updateDynamicSelect(jobSubSelect, data, 'Select Subject');
                    })
                    .catch(() => {
                        updateDynamicSelect(jobSubSelect, [], 'Select Subject');
                    });
            } else {
                resetDynamicSelect(jobSubSelect, 'Select Subject');
            }
        });
    }
</script>
@endpush

@endsection
