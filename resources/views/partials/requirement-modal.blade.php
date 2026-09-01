@php
    $modalCategories = $categories ?? \App\Models\Category::where('is_active', true)->orderBy('name')->get();
    $modalStates = $states ?? \App\Models\State::where('is_active', true)->orderBy('name')->get();
    $modalQualifications = $qualifications ?? \App\Models\Qualification::where('is_active', true)->orderBy('name')->get();
@endphp

<script>
window.openRequirementModal = function(tab = 'tuition') {
    window.dispatchEvent(new CustomEvent('open-requirement-modal', { detail: { tab: tab } }));
};

function globalRequirementModal() {
    return {
        openPostModal: false,
        tab: 'tuition',
        submitting: false,
        successMessage: '',
        errorMessage: '',
        selectedCategory: '',
        subjects: [],
        loadingSubjects: false,
        selectedState: '',
        cities: [],
        loadingCities: false,

        init() {
            window.addEventListener('open-requirement-modal', (e) => {
                this.openPostModal = true;
                if (e.detail && e.detail.tab) {
                    this.tab = e.detail.tab;
                }
                this.successMessage = '';
                this.errorMessage = '';
                this.fieldErrors = {};
            });
        },

        fetchSubjects() {
            if (!this.selectedCategory) {
                this.subjects = [];
                return;
            }
            this.loadingSubjects = true;
            fetch(`/api/categories/${this.selectedCategory}/subjects`)
                .then(res => res.json())
                .then(data => {
                    this.subjects = data;
                    this.loadingSubjects = false;
                })
                .catch(() => { this.loadingSubjects = false; });
        },

        fetchCities() {
            if (!this.selectedState) {
                this.cities = [];
                return;
            }
            this.loadingCities = true;
            fetch(`/api/states/${this.selectedState}/cities`)
                .then(res => res.json())
                .then(data => {
                    this.cities = data;
                    this.loadingCities = false;
                })
                .catch(() => { this.loadingCities = false; });
        },

        async submitTuitionForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            this.submitting = true;
            this.successMessage = '';
            this.errorMessage = '';
            this.fieldErrors = {};

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token') || '';
                const response = await fetch('{{ route("tuition.post") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                let data = {};
                const contentType = response.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    try { data = JSON.parse(text); } catch (e) { data = {}; }
                }

                if (response.ok && data.success) {
                    this.successMessage = data.message || 'Your tuition requirement has been submitted for review! Our academic team will verify and post it shortly.';
                    if (typeof window.trackLeadConversion === 'function') {
                        window.trackLeadConversion();
                    }
                    form.reset();
                    this.fieldErrors = {};
                } else {
                    if (response.status === 419) {
                        this.errorMessage = 'Your browser session has expired. Please refresh the page (F5) and submit again.';
                    } else if (data.errors && typeof data.errors === 'object' && Object.keys(data.errors).length > 0) {
                        this.fieldErrors = data.errors;
                        this.errorMessage = data.message || 'Please correct the highlighted fields.';
                    } else if (data.message) {
                        this.errorMessage = data.message;
                    } else {
                        this.errorMessage = 'Something went wrong. Please check your inputs.';
                    }
                }
            } catch (err) {
                console.error('Tuition modal submission error:', err);
                this.errorMessage = 'Unable to complete request. Please verify your connection or refresh the page.';
            } finally {
                this.submitting = false;
            }
        },

        async submitSchoolForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            this.submitting = true;
            this.successMessage = '';
            this.errorMessage = '';
            this.fieldErrors = {};

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token') || '';
                const response = await fetch('{{ route("school.requirement.post") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                let data = {};
                const contentType = response.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    try { data = JSON.parse(text); } catch (e) { data = {}; }
                }

                if (response.ok && data.success) {
                    this.successMessage = data.message || 'Your teacher hiring requirement has been submitted for approval! Our team will review and approve it shortly.';
                    if (typeof window.trackLeadConversion === 'function') {
                        window.trackLeadConversion();
                    }
                    form.reset();
                    this.fieldErrors = {};
                    this.selectedCategory = '';
                    this.selectedState = '';
                    this.subjects = [];
                    this.cities = [];
                } else {
                    if (response.status === 419) {
                        this.errorMessage = 'Your browser session has expired. Please refresh the page (F5) and submit again.';
                    } else if (data.errors && typeof data.errors === 'object' && Object.keys(data.errors).length > 0) {
                        this.fieldErrors = data.errors;
                        this.errorMessage = data.message || 'Please correct the highlighted fields.';
                    } else if (data.message) {
                        this.errorMessage = data.message;
                    } else {
                        this.errorMessage = 'Something went wrong. Please check your inputs.';
                    }
                }
            } catch (err) {
                console.error('School modal submission error:', err);
                this.errorMessage = 'Unable to complete request. Please verify your connection or refresh the page.';
            } finally {
                this.submitting = false;
            }
        }
    };
}
</script>

<div x-data="globalRequirementModal()" 
     x-on:open-requirement-modal.window="openPostModal = true; if($event.detail && $event.detail.tab) { tab = $event.detail.tab; } successMessage = ''; errorMessage = ''; fieldErrors = {};"
     class="relative z-[9999]">

    {{-- Professional Dual-Tab Requirement Modal (Mobile-First & High Aesthetic) --}}
    <div x-show="openPostModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-3 sm:p-6 overflow-y-auto" x-transition.opacity>
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden my-auto border border-slate-100 relative" @click.away="openPostModal = false" x-transition.scale>
            
            <!-- Modal Header -->
            <div class="bg-[#031b4e] p-5 sm:p-7 text-white relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#0ea5e9]/20 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-white/90 text-[11px] font-bold uppercase tracking-wider mb-2 border border-white/10">
                            <i class="fas fa-bolt text-[#ff8800] text-xs"></i> <span>Direct Requirement Posting</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white">Post Teacher Requirement</h3>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1">Get matched with verified teachers & expert home tutors quickly.</p>
                    </div>
                    <button type="button" @click="openPostModal = false" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors shrink-0 ml-3 cursor-pointer">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Modern Tab Switcher -->
                <div class="grid grid-cols-2 bg-white/10 p-1.5 rounded-2xl gap-2 mt-5 relative z-10 border border-white/10">
                    <button type="button" @click="tab = 'tuition'; successMessage = ''; errorMessage = ''; fieldErrors = {};" 
                            :class="tab === 'tuition' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                            class="py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fas fa-home text-sm text-[#0ea5e9]"></i> 
                        <span>Home Tuition <span class="hidden sm:inline font-normal text-xs text-slate-500">(For Parents)</span></span>
                    </button>
                    <button type="button" @click="tab = 'school'; successMessage = ''; errorMessage = ''; fieldErrors = {};" 
                            :class="tab === 'school' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                            class="py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fas fa-school text-sm text-purple-600"></i> 
                        <span>School Hiring <span class="hidden sm:inline font-normal text-xs text-slate-500">(Institutions)</span></span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-5 sm:p-8 max-h-[65vh] overflow-y-auto custom-scrollbar">
                
                {{-- Success Banner --}}
                <div x-show="successMessage" class="p-4 sm:p-5 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-2xl mb-6 text-sm flex items-start gap-3 shadow-sm" x-transition>
                    <i class="fas fa-check-circle text-emerald-600 text-xl mt-0.5 shrink-0"></i>
                    <div>
                        <h4 class="font-bold text-emerald-900">Requirement Submitted Successfully!</h4>
                        <p class="text-xs text-emerald-700 mt-1" x-text="successMessage"></p>
                    </div>
                </div>

                {{-- Error Banner --}}
                <div x-show="errorMessage || Object.keys(fieldErrors).length > 0" class="p-4 sm:p-5 bg-rose-50 border-2 border-rose-300 text-rose-900 rounded-2xl mb-6 text-sm flex items-start gap-3 shadow-sm" x-transition>
                    <i class="fas fa-exclamation-triangle text-rose-600 text-xl mt-0.5 shrink-0"></i>
                    <div class="flex-1">
                        <h4 class="font-bold text-rose-900">Please Correct the Following:</h4>
                        <template x-if="Object.keys(fieldErrors).length > 0">
                            <ul class="space-y-1.5 mt-2">
                                <template x-for="(errs, field) in fieldErrors" :key="field">
                                    <li class="text-xs font-semibold text-rose-800 flex items-start gap-2 bg-white/70 p-2 rounded-lg border border-rose-200/60">
                                        <i class="fas fa-arrow-circle-right text-rose-500 text-xs mt-0.5 shrink-0"></i>
                                        <span x-text="Array.isArray(errs) ? errs[0] : errs"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>
                        <template x-if="Object.keys(fieldErrors).length === 0 && errorMessage">
                            <p class="text-xs text-rose-700 mt-1" x-text="errorMessage"></p>
                        </template>
                    </div>
                    <button type="button" @click="errorMessage = ''; fieldErrors = {};" class="text-rose-400 hover:text-rose-600"><i class="fas fa-times"></i></button>
                </div>

                {{-- TAB 1: HOME TUITION FORM --}}
                <div x-show="tab === 'tuition'">
                    <form @submit.prevent="submitTuitionForm($event)" class="space-y-4 sm:space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Parent / Client Name <span class="text-red-500">*</span></label>
                                <input type="text" name="guest_name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" title="Please enter full name (letters only, min 3 characters)." placeholder="e.g. Rajesh Kumar" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Contact Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="guest_phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" title="Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9." placeholder="Enter 10-digit phone" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Student's Class <span class="text-red-500">*</span></label>
                                <input type="text" name="student_class" required minlength="1" maxlength="50" placeholder="e.g. Class 10 / Class 12" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Education Board <span class="text-red-500">*</span></label>
                                <select name="board" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select Board</option>
                                    <option value="CBSE">CBSE Board</option>
                                    <option value="ICSE">ICSE / ISC</option>
                                    <option value="State Board">State Board</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subjects Needed <span class="text-red-500">*</span></label>
                                <input type="text" name="subjects" required minlength="2" maxlength="150" placeholder="e.g. Mathematics, Physics, English" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Location / Area Address <span class="text-red-500">*</span></label>
                                <input type="text" name="location" required minlength="3" maxlength="200" placeholder="e.g. Kankarbagh, Patna" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Pincode</label>
                                <input type="text" name="pincode" maxlength="6" pattern="^[0-9]{6}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" title="Please enter a valid 6-digit Pincode." placeholder="6-digit Pincode" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all font-mono">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto bg-[#031b4e] hover:bg-[#021338] text-white px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg shadow-blue-950/20 flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer">
                                <i class="fas fa-paper-plane"></i>
                                <span x-text="submitting ? 'Submitting...' : 'Post Tuition Requirement'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- TAB 2: SCHOOL TEACHER HIRING FORM --}}
                <div x-show="tab === 'school'">
                    <form @submit.prevent="submitSchoolForm($event)" class="space-y-4 sm:space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Job Title / Vacancy <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required minlength="3" maxlength="150" placeholder="e.g. PGT Physics Teacher / PRT All Subjects" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">School / Institution Name <span class="text-red-500">*</span></label>
                                <input type="text" name="school_name" required minlength="3" maxlength="150" placeholder="e.g. Delhi Public School" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Contact Person <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_person" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" title="Please enter contact person name (letters only)." placeholder="e.g. Mr. Sharma (Principal)" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" title="Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9." placeholder="Enter 10-digit phone" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Email (Optional)</label>
                                <input type="email" name="email" placeholder="e.g. hr@school.com" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Job Category <span class="text-red-500">*</span></label>
                                <select name="category_id" x-model="selectedCategory" @change="fetchSubjects()" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select Category</option>
                                    @foreach($modalCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subject <span class="text-red-500">*</span></label>
                                <select name="subject_id" required :disabled="loadingSubjects" 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer disabled:opacity-50">
                                    <option value="">Select Subject</option>
                                    <template x-for="subj in subjects" :key="subj.id">
                                        <option :value="subj.id" x-text="subj.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Required Qualification <span class="text-red-500">*</span></label>
                                <select name="qualification_id" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select Qualification</option>
                                    @foreach($modalQualifications as $qual)
                                        <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Salary Range / Budget</label>
                                <input type="text" name="salary_range" maxlength="80" placeholder="e.g. ₹25,000 - ₹35,000" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">State <span class="text-red-500">*</span></label>
                                <select name="state_id" x-model="selectedState" @change="fetchCities()" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select State</option>
                                    @foreach($modalStates as $st)
                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">City <span class="text-red-500">*</span></label>
                                <select name="city_id" required :disabled="loadingCities" 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer disabled:opacity-50">
                                    <option value="">Select City</option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto bg-[#031b4e] hover:bg-[#021338] text-white px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg shadow-purple-950/20 flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer">
                                <i class="fas fa-paper-plane"></i>
                                <span x-text="submitting ? 'Submitting...' : 'Post School Requirement'"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
