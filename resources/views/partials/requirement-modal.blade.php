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

        // Candidate Registration in Modal
        isParentTuition: false,
        candidateCategory: 'home_tutor',
        candidatePhone: '',
        candidateWhatsapp: '',
        sameAsMobile: true,
        selectedTuitionSubjects: [],
        selectedClasses: [],
        selectedLocations: [],
        teachingMode: 'Offline',

        toggleTuitionSubject(subj) {
            if (this.selectedTuitionSubjects.includes(subj)) {
                this.selectedTuitionSubjects = this.selectedTuitionSubjects.filter(s => s !== subj);
            } else {
                this.selectedTuitionSubjects.push(subj);
            }
        },
        toggleAllTuitionSubjects() {
            const allSubjs = ['All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
            if (this.selectedTuitionSubjects.includes('All Subjects')) {
                this.selectedTuitionSubjects = [];
            } else {
                this.selectedTuitionSubjects = allSubjs;
            }
        },
        toggleSelectedClass(cls) {
            if (this.selectedClasses.includes(cls)) {
                this.selectedClasses = this.selectedClasses.filter(c => c !== cls);
            } else {
                this.selectedClasses.push(cls);
            }
        },
        toggleLocation(loc) {
            if (this.selectedLocations.includes(loc)) {
                this.selectedLocations = this.selectedLocations.filter(l => l !== loc);
            } else {
                this.selectedLocations.push(loc);
            }
        },
        syncWhatsapp() {
            if (this.sameAsMobile) {
                this.candidateWhatsapp = this.candidatePhone;
            }
        },
        appendModalArea(area, inputId = 'modal_ht_areas') {
            let el = document.getElementById(inputId);
            if (!el) {
                el = document.getElementById('modal_both_areas') || document.getElementById('modal_ht_areas');
            }
            if (el) {
                let current = el.value.trim();
                if (current.length > 0 && !current.includes(area)) {
                    el.value = current + ', ' + area;
                } else if (current.length === 0) {
                    el.value = area;
                }
            }
        },

        init() {
            this.$watch('tab', () => {
                this.$nextTick(() => {
                    const modalEl = document.getElementById('requirement-modal');
                    if (modalEl && typeof window.initSearchableSelects === 'function') {
                        window.initSearchableSelects(modalEl);
                    }
                });
            });

            this.$watch('candidateCategory', () => {
                this.$nextTick(() => {
                    const modalEl = document.getElementById('requirement-modal');
                    if (modalEl && typeof window.initSearchableSelects === 'function') {
                        window.initSearchableSelects(modalEl);
                    }
                });
            });

            window.addEventListener('open-requirement-modal', (e) => {
                this.openPostModal = true;
                if (e.detail && e.detail.tab) {
                    const reqTab = e.detail.tab;
                    if (reqTab === 'tuition' || reqTab === 'tuition_need' || reqTab === 'tuition_post' || reqTab === 'parent') {
                        this.tab = 'tuition';
                    } else if (reqTab === 'school') {
                        this.tab = 'school';
                    } else if (reqTab === 'home_tutor') {
                        this.tab = 'teacher';
                        this.candidateCategory = 'home_tutor';
                    } else if (reqTab === 'teacher' || reqTab === 'school_job') {
                        this.tab = 'teacher';
                        this.candidateCategory = 'school_job';
                    } else if (reqTab === 'both') {
                        this.tab = 'teacher';
                        this.candidateCategory = 'both';
                    } else {
                        this.tab = reqTab;
                    }
                }
                this.successMessage = '';
                this.errorMessage = '';
                this.fieldErrors = {};
                this.$nextTick(() => {
                    const modalEl = document.getElementById('requirement-modal');
                    if (modalEl && typeof window.initSearchableSelects === 'function') {
                        window.initSearchableSelects(modalEl);
                    }
                });
            });
        },

        setSelectLoading(selectEl, placeholder) {
            if (!selectEl) return;
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            selectEl.disabled = true;
            if (selectEl._slimSelect) {
                selectEl._isUpdatingFromSlim = true;
                try {
                    selectEl._slimSelect.setData([{ text: placeholder, value: '', placeholder: true }]);
                    selectEl._slimSelect.disable();
                } catch (e) {
                    console.warn(e);
                } finally {
                    setTimeout(() => { selectEl._isUpdatingFromSlim = false; }, 30);
                }
            }
        },

        updateSelectOptions(selectEl, items, placeholder, selectedValue = '') {
            if (!selectEl) return;
            let html = `<option value="">${placeholder}</option>`;
            items.forEach(item => {
                const isSel = selectedValue && String(selectedValue) === String(item.id);
                html += `<option value="${item.id}" ${isSel ? 'selected' : ''}>${item.name}</option>`;
            });
            selectEl.innerHTML = html;
            selectEl.disabled = false;

            if (selectEl._slimSelect) {
                selectEl._isUpdatingFromSlim = true;
                try {
                    const ssData = [
                        { text: placeholder, value: '', placeholder: true },
                        ...items.map(item => ({
                            text: item.name,
                            value: String(item.id),
                            selected: selectedValue && String(selectedValue) === String(item.id)
                        }))
                    ];
                    selectEl._slimSelect.setData(ssData);
                    if (selectedValue) {
                        selectEl._slimSelect.setSelected(String(selectedValue), false);
                    } else {
                        selectEl._slimSelect.setSelected('', false);
                    }
                    selectEl._slimSelect.enable();
                } catch (e) {
                    console.warn(e);
                } finally {
                    setTimeout(() => { selectEl._isUpdatingFromSlim = false; }, 30);
                }
            } else if (typeof window.initSearchableSelects === 'function') {
                window.initSearchableSelects(selectEl.parentElement || document);
            }
        },

        resetSelect(selectEl, placeholder) {
            if (!selectEl) return;
            selectEl.innerHTML = `<option value="">${placeholder}</option>`;
            selectEl.value = '';
            selectEl.disabled = true;
            if (selectEl._slimSelect) {
                selectEl._isUpdatingFromSlim = true;
                try {
                    selectEl._slimSelect.setData([{ text: placeholder, value: '', placeholder: true }]);
                    selectEl._slimSelect.setSelected('', false);
                    selectEl._slimSelect.disable();
                } catch (e) {
                    console.warn(e);
                } finally {
                    setTimeout(() => { selectEl._isUpdatingFromSlim = false; }, 30);
                }
            }
        },

        fetchSubjects() {
            const catSelect = document.getElementById('modal_category_id');
            const catVal = (catSelect && catSelect.value) ? catSelect.value : this.selectedCategory;
            this.selectedCategory = catVal;
            const subSelect = document.getElementById('modal_subject_id');

            if (!catVal) {
                this.subjects = [];
                this.resetSelect(subSelect, 'Select Subject');
                return;
            }
            this.loadingSubjects = true;
            this.setSelectLoading(subSelect, 'Loading subjects...');
            fetch(`/api/categories/${catVal}/subjects`)
                .then(res => res.json())
                .then(data => {
                    this.subjects = Array.isArray(data) ? data : [];
                    this.updateSelectOptions(subSelect, this.subjects, 'Select Subject');
                })
                .catch(err => {
                    console.error('Error fetching modal subjects:', err);
                    this.subjects = [];
                    this.updateSelectOptions(subSelect, [], 'Select Subject');
                })
                .finally(() => {
                    this.loadingSubjects = false;
                });
        },

        fetchCities() {
            const stateSelect = document.getElementById('modal_state_id');
            const stateVal = (stateSelect && stateSelect.value) ? stateSelect.value : this.selectedState;
            this.selectedState = stateVal;
            const citySelect = document.getElementById('modal_city_id');

            if (!stateVal) {
                this.cities = [];
                this.resetSelect(citySelect, 'Select City');
                return;
            }
            this.loadingCities = true;
            this.setSelectLoading(citySelect, 'Loading cities...');
            fetch(`/api/states/${stateVal}/cities`)
                .then(res => res.json())
                .then(data => {
                    this.cities = Array.isArray(data) ? data : [];
                    this.updateSelectOptions(citySelect, this.cities, 'Select City');
                })
                .catch(err => {
                    console.error('Error fetching modal cities:', err);
                    this.cities = [];
                    this.updateSelectOptions(citySelect, [], 'Select City');
                })
                .finally(() => {
                    this.loadingCities = false;
                });
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
                    if (typeof window.trackLeadConversion === 'function') {
                        window.trackLeadConversion('home_tuition', {
                            form_name: 'Modal Tuition Form'
                        });
                    }
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    this.successMessage = data.message || 'Your tuition requirement has been submitted for review! Our academic team will verify and post it shortly.';
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
                    if (typeof window.trackLeadConversion === 'function') {
                        window.trackLeadConversion('school_hiring', {
                            form_name: 'Modal School Requirement Form'
                        });
                    }
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    this.successMessage = data.message || 'Your teacher hiring requirement has been submitted for approval! Our team will review and approve it shortly.';
                    form.reset();
                    this.fieldErrors = {};
                    this.selectedCategory = '';
                    this.selectedState = '';
                    this.subjects = [];
                    this.cities = [];
                    const catSelect = document.getElementById('modal_category_id');
                    const subSelect = document.getElementById('modal_subject_id');
                    const qualSelect = document.getElementById('modal_qualification_id');
                    const stateSelect = document.getElementById('modal_state_id');
                    const citySelect = document.getElementById('modal_city_id');
                    if (catSelect && catSelect._slimSelect) catSelect._slimSelect.setSelected('', false);
                    this.resetSelect(subSelect, 'Select Subject');
                    if (qualSelect && qualSelect._slimSelect) qualSelect._slimSelect.setSelected('', false);
                    if (stateSelect && stateSelect._slimSelect) stateSelect._slimSelect.setSelected('', false);
                    this.resetSelect(citySelect, 'Select City');
                    const otherQual = document.getElementById('modal_other_qualification');
                    if (otherQual) otherQual.value = '';
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
        },

        async submitCandidateForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            this.submitting = true;
            this.successMessage = '';
            this.errorMessage = '';
            this.fieldErrors = {};

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token') || '';
                const response = await fetch('{{ route("candidate.register.post") }}', {
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
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    this.successMessage = data.message || 'Registration verification code has been dispatched to your email!';
                } else {
                    if (response.status === 419) {
                        this.errorMessage = 'Your browser session has expired. Please refresh the page (F5) and submit again.';
                    } else if (data.errors && typeof data.errors === 'object' && Object.keys(data.errors).length > 0) {
                        this.fieldErrors = data.errors;
                        this.errorMessage = data.message || 'Please correct the highlighted fields.';
                    } else if (data.message) {
                        this.errorMessage = data.message;
                    } else {
                        this.errorMessage = 'Registration could not be completed. Please check your inputs.';
                    }
                    const modalScroll = document.getElementById('requirement-modal')?.querySelector('.overflow-y-auto') || window;
                    modalScroll.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } catch (err) {
                console.error('Candidate modal registration error:', err);
                this.errorMessage = 'Unable to complete registration. Please verify your connection or refresh the page.';
                const modalScroll = document.getElementById('requirement-modal')?.querySelector('.overflow-y-auto') || window;
                modalScroll.scrollTo({ top: 0, behavior: 'smooth' });
            } finally {
                this.submitting = false;
            }
        }
    };
}
</script>

<div id="requirement-modal" 
     x-data="globalRequirementModal()" 
     x-on:open-requirement-modal.window="openPostModal = true; if($event.detail && $event.detail.tab) { tab = $event.detail.tab; } successMessage = ''; errorMessage = ''; fieldErrors = {};"
     class="relative z-[9999]">

    <div x-show="openPostModal" style="display: none;" class="fixed inset-0 z-[9999] bg-slate-950/80 backdrop-blur-md overflow-y-auto" x-transition.opacity>
        <div class="min-h-screen flex items-start justify-center p-3 sm:p-6 py-10 md:py-12">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-slate-100 relative" @click.away="openPostModal = false" x-transition.scale>
                
                <!-- Modal Header -->
                <div class="bg-[#031b4e] p-5 sm:p-7 text-white relative shrink-0">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#0ea5e9]/20 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-white/90 text-[11px] font-bold uppercase tracking-wider mb-2 border border-white/10">
                                <i class="fas fa-bolt text-[#ff8800] text-xs"></i> <span>Warriors Educare Portal</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-white">
                                <span x-show="tab === 'tuition'">Post Tuition Requirement</span>
                                <span x-show="tab === 'school'">School Teacher Hiring</span>
                                <span x-show="tab === 'teacher'">
                                    <span x-show="candidateCategory === 'home_tutor'">Home Tutor Registration</span>
                                    <span x-show="candidateCategory === 'school_job'">Join as School Teacher</span>
                                    <span x-show="candidateCategory === 'both'">Dual Profile Registration (Both)</span>
                                </span>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                                <span x-show="tab === 'tuition'">Get matched with verified & expert home tutors near your locality.</span>
                                <span x-show="tab === 'school'">Hire qualified & experienced teachers for your school or institution.</span>
                                <span x-show="tab === 'teacher'">
                                    <span x-show="candidateCategory === 'home_tutor'">Register as an expert home tutor & connect with students looking for tutors.</span>
                                    <span x-show="candidateCategory === 'school_job'">Apply directly for teaching vacancies across reputed schools & colleges.</span>
                                    <span x-show="candidateCategory === 'both'">Register once to get both private home tuitions and school teaching offers.</span>
                                </span>
                            </p>
                        </div>
                        <button type="button" @click="openPostModal = false" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors shrink-0 ml-3 cursor-pointer">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <!-- Modern 3-Tab Switcher -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 bg-white/10 p-1.5 rounded-2xl gap-2 mt-5 relative z-10 border border-white/10">
                        <button type="button" @click="tab = 'tuition'; successMessage = ''; errorMessage = ''; fieldErrors = {};" 
                                :class="tab === 'tuition' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                                class="py-2.5 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-graduation-cap text-[#0ea5e9]"></i> 
                            <span>Tuition Post Requirement</span>
                        </button>
                        <button type="button" @click="tab = 'school'; successMessage = ''; errorMessage = ''; fieldErrors = {};" 
                                :class="tab === 'school' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                                class="py-2.5 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-school text-purple-400"></i> 
                            <span>School Hiring</span>
                        </button>
                        <button type="button" @click="tab = 'teacher'; successMessage = ''; errorMessage = ''; fieldErrors = {};" 
                                :class="tab === 'teacher' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                                class="py-2.5 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-chalkboard-teacher text-amber-400"></i> 
                            <span>Join as a Teacher</span>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-5 sm:p-8">
                
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

                        <template x-if="Object.values(fieldErrors).some(err => (Array.isArray(err) ? err.join(' ') : String(err)).toLowerCase().includes('already registered')) || (errorMessage && errorMessage.toLowerCase().includes('already registered'))">
                            <div class="mt-3 pt-2.5 border-t border-rose-200 flex flex-wrap items-center gap-2">
                                <span class="text-xs text-rose-700 font-medium">Already have an account?</span>
                                <a href="{{ route('login.otp') }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 underline flex items-center gap-1">
                                    <i class="fas fa-key text-[10px]"></i> Quick Login with OTP &rarr;
                                </a>
                                <span class="text-xs text-slate-400">|</span>
                                <a href="{{ route('login') }}" class="text-xs font-bold text-[#031b4e] hover:underline">
                                    Sign In with Password
                                </a>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="errorMessage = ''; fieldErrors = {};" class="text-rose-400 hover:text-rose-600 cursor-pointer"><i class="fas fa-times"></i></button>
                </div>

                {{-- TAB 1: TUITION POST REQUIREMENT (FOR PARENTS / STUDENTS) --}}
                <div x-show="tab === 'tuition'">
                    <div class="mb-5 flex items-center justify-between p-3.5 bg-sky-50/80 border border-sky-200/70 rounded-2xl">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-[#0ea5e9] text-white flex items-center justify-center text-sm font-bold shadow-xs">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-[#031b4e]">Post Your Tuition Requirement</h4>
                                <p class="text-[11px] text-slate-500 font-medium">Tell us your learning needs & our team will connect you with verified home tutors.</p>
                            </div>
                        </div>
                        <span class="hidden sm:inline-block px-3 py-1 bg-white text-[#0ea5e9] text-[11px] font-black rounded-full border border-sky-200">
                            100% Free for Parents
                        </span>
                    </div>

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
                                <select data-no-search="true" name="board" required 
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

                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
                                    style="background-color: #031b4e !important; color: #ffffff !important;">
                                <i class="fas fa-paper-plane" x-show="!submitting"></i>
                                <i class="fas fa-spinner fa-spin" x-show="submitting" style="display: none;"></i>
                                <span x-text="submitting ? 'Submitting...' : 'Post Tuition Requirement'">Post Tuition Requirement</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- TAB 2: JOIN AS A TEACHER (HOME TUTOR, SCHOOL TEACHER & BOTH) --}}
                <div x-show="tab === 'teacher'">
                    {{-- Sub-Switcher for Teacher Modes: Home Tutor, Join as Teacher (School), Both --}}
                    <div class="mb-6 p-2 bg-gradient-to-r from-slate-100 via-sky-50/50 to-slate-100 rounded-2xl border border-slate-200/80 shadow-xs">
                        <div class="px-2 py-1 mb-1.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-chalkboard-teacher text-amber-500"></i> Select Your Teaching Preference:
                            </span>
                            <span class="text-[10px] font-semibold text-slate-400">Choose one to display registration form</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <button type="button" @click="candidateCategory = 'home_tutor'; errorMessage = ''; fieldErrors = {};"
                                    :class="candidateCategory === 'home_tutor' ? 'bg-white text-[#031b4e] shadow-md font-black border-2 border-[#0ea5e9] scale-[1.01]' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white font-bold border border-transparent'"
                                    class="py-2.5 px-3 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-home text-[#0ea5e9]"></i>
                                <span>Home Tutor</span>
                            </button>
                            <button type="button" @click="candidateCategory = 'school_job'; errorMessage = ''; fieldErrors = {};"
                                    :class="candidateCategory === 'school_job' ? 'bg-white text-[#031b4e] shadow-md font-black border-2 border-amber-500 scale-[1.01]' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white font-bold border border-transparent'"
                                    class="py-2.5 px-3 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-chalkboard-teacher text-amber-500"></i>
                                <span>Join as a Teacher</span>
                            </button>
                            <button type="button" @click="candidateCategory = 'both'; errorMessage = ''; fieldErrors = {};"
                                    :class="candidateCategory === 'both' ? 'bg-white text-[#031b4e] shadow-md font-black border-2 border-emerald-500 scale-[1.01]' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white font-bold border border-transparent'"
                                    class="py-2.5 px-3 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fas fa-handshake text-emerald-600"></i>
                                <span>Both</span>
                            </button>
                        </div>
                    </div>

                    {{-- 1. HOME TUTOR CANDIDATE REGISTRATION FORM --}}
                    <div x-show="candidateCategory === 'home_tutor'">
                        <form @submit.prevent="submitCandidateForm($event)" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <input type="hidden" name="candidate_category" value="home_tutor">

                            {{-- Section 1: Personal & Account Details --}}
                            <div>
                                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-100">
                                    <span class="w-6 h-6 rounded-lg bg-[#031b4e] text-white flex items-center justify-center text-xs font-bold">1</span>
                                    <h4 class="text-sm font-black text-[#031b4e]">Personal & Account Details</h4>
                                    <span class="text-[10px] font-bold text-slate-400 ml-auto">Mandatory for Home Tutor</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address <span class="text-red-500">*</span></label>
                                        <input type="email" name="email" required placeholder="you@example.com"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number <span class="text-red-500">*</span></label>
                                        <input type="tel" name="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" x-model="candidatePhone" @input="syncWhatsapp()" placeholder="10-digit mobile"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">WhatsApp Number</label>
                                            <label class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-600 cursor-pointer">
                                                <input type="checkbox" x-model="sameAsMobile" @change="syncWhatsapp()" class="rounded text-blue-600">
                                                <span>Same as mobile</span>
                                            </label>
                                        </div>
                                        <input type="tel" name="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" x-model="candidateWhatsapp" placeholder="10-digit WhatsApp"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-500">*</span></label>
                                        <input type="password" name="password" required minlength="8" placeholder="•••••••• (Min 8 chars)"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                        <input type="password" name="password_confirmation" required minlength="8" placeholder="••••••••"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Gender <span class="text-red-500">*</span></label>
                                        <select data-no-search="true" name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Date of Birth <span class="text-red-500">*</span></label>
                                        <input type="date" name="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                                        <input type="text" name="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Total Teaching Experience <span class="text-red-500">*</span></label>
                                        <select data-no-search="true" name="experience_range" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                            <option value="">Select Experience</option>
                                            <option value="0–1 Year">Fresher (0–1 Year)</option>
                                            <option value="1–3 Years">1–3 Years</option>
                                            <option value="3–5 Years">3–5 Years</option>
                                            <option value="5–10 Years">5–10 Years</option>
                                            <option value="10–15 Years">10–15 Years</option>
                                            <option value="15+ Years">15+ Years</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 2: Home Tuition Specific Details --}}
                            <div class="pt-4 border-t border-slate-100 space-y-4">
                                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                                    <span class="w-6 h-6 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs font-bold">2</span>
                                    <h4 class="text-sm font-black text-[#031b4e]">Home Tuition Preferences</h4>
                                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200 ml-auto">Home Tutor Details</span>
                                </div>

                                {{-- Teaching Mode + Time Slot --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Teaching Mode <span class="text-red-500">*</span></label>
                                        <select data-no-search="true" name="teaching_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                            <option value="Offline">Offline (Student's Home)</option>
                                            <option value="Online">Online (Zoom / Google Meet)</option>
                                            <option value="Both">Both (Offline &amp; Online)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Available Time Slot</label>
                                        <select data-no-search="true" name="available_time_slot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                            <option value="Flexible / Any Time">Flexible / Any Time</option>
                                            <option value="Morning (6 AM - 10 AM)">Morning (6 AM - 10 AM)</option>
                                            <option value="Afternoon (12 PM - 4 PM)">Afternoon (12 PM - 4 PM)</option>
                                            <option value="Evening (4 PM - 8 PM)">Evening (4 PM - 8 PM)</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Subjects Card --}}
                                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-black text-amber-800 uppercase tracking-wide flex items-center gap-1.5"><i class="fas fa-book-open text-amber-500"></i> Tuition Subjects Interested <span class="text-red-500">*</span></span>
                                        <button type="button" @click="toggleAllTuitionSubjects()" class="text-[11px] font-bold text-amber-700 bg-white border border-amber-300 px-2.5 py-1 rounded-lg cursor-pointer hover:bg-amber-100">
                                            <span x-text="selectedTuitionSubjects.includes('All Subjects') ? 'Deselect All' : 'Select All'"></span>
                                        </button>
                                    </div>
                                    @php $modalTuitionSubs = ['All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies']; @endphp
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($modalTuitionSubs as $subj)
                                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-amber-400'">
                                                <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}" :checked="selectedTuitionSubjects.includes('{{ $subj }}')" @change="toggleTuitionSubject('{{ $subj }}')" class="sr-only">
                                                <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                                <span>{{ $subj }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Classes Card --}}
                                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                                    <span class="text-xs font-black text-blue-800 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-chalkboard-teacher text-blue-500"></i> Classes You Can Teach <span class="text-red-500">*</span></span>
                                    @php $modalClassList = ['Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12', 'Competitive / Olympiad', 'Languages / Hobby']; @endphp
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($modalClassList as $cls)
                                            <label class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'">
                                                <input type="checkbox" name="classes_interested[]" value="{{ $cls }}" :checked="selectedClasses.includes('{{ $cls }}')" @change="toggleSelectedClass('{{ $cls }}')" class="sr-only">
                                                <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                                <span>{{ $cls }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Preferred Areas Card --}}
                                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
                                    <span class="text-xs font-black text-emerald-800 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-map-marker-alt text-emerald-500"></i> Preferred Localities / Areas <span class="text-red-500">*</span></span>
                                    <textarea name="preferred_areas" id="modal_ht_areas" rows="2" placeholder="e.g. Kankarbagh, Boring Road, Bailey Road, Rajendra Nagar..." class="w-full bg-white border border-emerald-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-emerald-400/40 focus:border-emerald-400"></textarea>
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        @foreach(['Patna', 'Kankarbagh', 'Boring Road', 'Bailey Road', 'Danapur', 'Rajendra Nagar', 'Anisabad'] as $quickArea)
                                            <button type="button" @click="appendModalArea('{{ $quickArea }}', 'modal_ht_areas')" class="text-[11px] font-bold bg-white hover:bg-emerald-100 text-emerald-700 border border-emerald-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors">
                                                + {{ $quickArea }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Optional Resume --}}
                                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                                    <span class="text-xs font-black text-slate-700 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-file-alt text-slate-500"></i> Resume / CV <span class="text-slate-400 font-normal normal-case text-[11px]">(Optional)</span></span>
                                    <input type="file" name="tutor_resume" accept=".pdf,.doc,.docx" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-white hover:file:bg-amber-600 cursor-pointer">
                                    <p class="text-[11px] text-slate-400 mt-1.5">PDF, DOC, DOCX format. Max 2MB.</p>
                                </div>
                            </div>

                            {{-- Submit & Cancel Button Row --}}
                            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                                <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                    Cancel
                                </button>
                                <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
                                        style="background-color: #d97706 !important; color: #ffffff !important; background-image: linear-gradient(to right, #f59e0b, #d97706, #ea580c) !important;">
                                    <i class="fas fa-paper-plane" x-show="!submitting"></i>
                                    <i class="fas fa-spinner fa-spin" x-show="submitting" style="display: none;"></i>
                                    <span x-text="submitting ? 'Registering & Sending OTP...' : 'Register as Home Tutor & Send OTP'">Register as Home Tutor & Send OTP</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- 2. JOIN AS SCHOOL TEACHER CANDIDATE REGISTRATION FORM --}}
                    <div x-show="candidateCategory === 'school_job'">
                        <form @submit.prevent="submitCandidateForm($event)" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <input type="hidden" name="candidate_category" value="school_job">

                        {{-- Section 1: Personal & Account Details --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-100">
                                <span class="w-6 h-6 rounded-lg bg-[#031b4e] text-white flex items-center justify-center text-xs font-bold">1</span>
                                <h4 class="text-sm font-black text-[#031b4e]">Personal & Account Details</h4>
                                <span class="text-[10px] font-bold text-slate-400 ml-auto">Mandatory for School Job</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" required placeholder="you@example.com"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" x-model="candidatePhone" @input="syncWhatsapp()" placeholder="10-digit mobile"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">WhatsApp Number</label>
                                        <label class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-600 cursor-pointer">
                                            <input type="checkbox" x-model="sameAsMobile" @change="syncWhatsapp()" class="rounded text-blue-600">
                                            <span>Same as mobile</span>
                                        </label>
                                    </div>
                                    <input type="tel" name="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" x-model="candidateWhatsapp" placeholder="10-digit WhatsApp"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" required minlength="8" placeholder="•••••••• (Min 8 chars)"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" required minlength="8" placeholder="••••••••"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Gender <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Date of Birth <span class="text-red-500">*</span></label>
                                    <input type="date" name="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                                    <input type="text" name="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Total Teaching Experience <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="experience_range" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="">Select Experience</option>
                                        <option value="0–1 Year">Fresher (0–1 Year)</option>
                                        <option value="1–3 Years">1–3 Years</option>
                                        <option value="3–5 Years">3–5 Years</option>
                                        <option value="5–10 Years">5–10 Years</option>
                                        <option value="10–15 Years">10–15 Years</option>
                                        <option value="15+ Years">15+ Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        {{-- Section 2: School Job Profile Details --}}
                        <div class="pt-4 border-t border-slate-100 space-y-4">
                            <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                                <span class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold">2</span>
                                <h4 class="text-sm font-black text-[#031b4e]">School Teaching Profile</h4>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200 ml-auto">School Candidate Details</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Teaching Post Applying For <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="position_applying_for" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="">Select Teaching Post</option>
                                        <option value="PRT (Primary Teacher)">PRT (Primary Teacher)</option>
                                        <option value="TGT (Trained Graduate Teacher)">TGT (Trained Graduate Teacher)</option>
                                        <option value="PGT (Post Graduate Teacher)">PGT (Post Graduate Teacher)</option>
                                        <option value="Pre-Primary / NTT">Pre-Primary / NTT</option>
                                        <option value="Coordinator / Academic Head">Coordinator / Academic Head</option>
                                        <option value="Principal / Vice Principal">Principal / Vice Principal</option>
                                        <option value="Admin / Non-Teaching Staff">Admin / Non-Teaching Staff</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">B.Ed Status <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="b_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="Yes">Yes (Completed)</option>
                                        <option value="Pursuing">Pursuing</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">D.El.Ed Status <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="d_el_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes (Completed)</option>
                                        <option value="Pursuing">Pursuing</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Current / Last School <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                                    <input type="text" name="last_school_name" placeholder="e.g. DPS / DAV / St. Michael's" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Expected Monthly Salary (&#8377;) <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                                    <input type="number" name="expected_salary" placeholder="e.g. 30000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-black text-amber-800 uppercase tracking-wide flex items-center gap-1.5"><i class="fas fa-book-open text-amber-500"></i> Subjects You Can Teach <span class="text-red-500">*</span></span>
                                    <button type="button" @click="toggleAllTuitionSubjects()" class="text-[11px] font-bold text-amber-700 bg-white border border-amber-300 px-2.5 py-1 rounded-lg cursor-pointer hover:bg-amber-100">
                                        <span x-text="selectedTuitionSubjects.includes('All Subjects') ? 'Deselect All' : 'Select All'"></span>
                                    </button>
                                </div>
                                @php $modalSchoolSubs = ['All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies']; @endphp
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($modalSchoolSubs as $subj)
                                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-amber-400'">
                                            <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}" :checked="selectedTuitionSubjects.includes('{{ $subj }}')" @change="toggleTuitionSubject('{{ $subj }}')" class="sr-only">
                                            <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                            <span>{{ $subj }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                                <span class="text-xs font-black text-blue-800 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-chalkboard-teacher text-blue-500"></i> Classes You Can Teach <span class="text-red-500">*</span></span>
                                @php $modalSchoolClassList = ['Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12', 'Pre-Primary', 'Languages / Hobby']; @endphp
                                <div class="flex flex-wrap gap-2">
                                    @foreach($modalSchoolClassList as $cls)
                                        <label class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'">
                                            <input type="checkbox" name="classes_interested[]" value="{{ $cls }}" :checked="selectedClasses.includes('{{ $cls }}')" @change="toggleSelectedClass('{{ $cls }}')" class="sr-only">
                                            <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                            <span>{{ $cls }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-indigo-50/80 border border-indigo-200 rounded-2xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-black text-indigo-800 uppercase tracking-wide flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-indigo-500"></i> Preferred School Locations & Address <span class="text-red-500">*</span>
                                    </span>
                                    <span class="text-[10px] font-bold text-indigo-700 bg-indigo-100/90 px-2.5 py-0.5 rounded-full">Manual Type + Quick Add</span>
                                </div>
                                <textarea name="preferred_locations_manual" id="modal_school_manual_address" rows="2"
                                          placeholder="Type your address or preferred locations (e.g. Boring Road, Kankarbagh, Patna, Hajipur, Muzaffarpur...)"
                                          class="w-full bg-white border border-indigo-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-500"></textarea>
                                <div class="mt-2">
                                    <span class="block text-[11px] font-bold text-slate-500 mb-1.5">Quick Add Cities (Click to append):</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @php $modalLocs = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Gaya', 'Darbhanga', 'Begusarai', 'Supaul', 'Danapur', 'Ara']; @endphp
                                        @foreach($modalLocs as $loc)
                                            <button type="button" 
                                                    @click="appendModalArea('{{ $loc }}', 'modal_school_manual_address')"
                                                    class="text-[11px] font-bold bg-white hover:bg-indigo-100 text-indigo-700 border border-indigo-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors flex items-center gap-1 shadow-2xs">
                                                <i class="fas fa-plus text-[9px]"></i> {{ $loc }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{-- Resume Upload (Mandatory for School Job) --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">
                                    Resume / CV Upload <span class="text-red-500">* (Mandatory for School Job)</span>
                                </label>
                                <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                                <p class="text-[11px] text-slate-500 mt-1">PDF or DOC format (Max 5MB).</p>
                            </div>
                        </div>

                        {{-- Submit & Cancel Button Row --}}
                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
                                    style="background-color: #1d4ed8 !important; color: #ffffff !important; background-image: linear-gradient(to right, #1d4ed8, #1e40af, #1e1b4b) !important;">
                                <i class="fas fa-paper-plane" x-show="!submitting"></i>
                                <i class="fas fa-spinner fa-spin" x-show="submitting" style="display: none;"></i>
                                <span x-text="submitting ? 'Registering & Sending OTP...' : 'Register for School Job & Send OTP'">Register for School Job & Send OTP</span>
                            </button>
                        </div>
                    </form>
                </div>

                    {{-- 3. BOTH (DUAL PROFILE: HOME TUTOR + SCHOOL JOB) --}}
                    <div x-show="candidateCategory === 'both'">
                    <form @submit.prevent="submitCandidateForm($event)" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="candidate_category" value="both">

                        {{-- Section 1: Common Personal & Account Details --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-100">
                                <span class="w-6 h-6 rounded-lg bg-[#031b4e] text-white flex items-center justify-center text-xs font-bold">1</span>
                                <h4 class="text-sm font-black text-[#031b4e]">Personal & Account Details</h4>
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 ml-auto">Dual Profile (Both)</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" required placeholder="you@example.com"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" x-model="candidatePhone" @input="syncWhatsapp()" placeholder="10-digit mobile"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">WhatsApp Number</label>
                                        <label class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-600 cursor-pointer">
                                            <input type="checkbox" x-model="sameAsMobile" @change="syncWhatsapp()" class="rounded text-blue-600">
                                            <span>Same as mobile</span>
                                        </label>
                                    </div>
                                    <input type="tel" name="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" x-model="candidateWhatsapp" placeholder="10-digit WhatsApp"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" required minlength="8" placeholder="•••••••• (Min 8 chars)"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" required minlength="8" placeholder="••••••••"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Gender <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Date of Birth <span class="text-red-500">*</span></label>
                                    <input type="date" name="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                                    <input type="text" name="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Total Teaching Experience <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="experience_range" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="">Select Experience</option>
                                        <option value="0–1 Year">Fresher (0–1 Year)</option>
                                        <option value="1–3 Years">1–3 Years</option>
                                        <option value="3–5 Years">3–5 Years</option>
                                        <option value="5–10 Years">5–10 Years</option>
                                        <option value="10–15 Years">10–15 Years</option>
                                        <option value="15+ Years">15+ Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Home Tuition Preferences --}}
                        <div class="pt-4 border-t border-slate-100 space-y-4">
                            <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                                <span class="w-6 h-6 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs font-bold">2</span>
                                <h4 class="text-sm font-black text-[#031b4e]">Home Tuition Preferences</h4>
                                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200 ml-auto">Part A: Tuition Profile</span>
                            </div>

                            {{-- Tuition Subjects --}}
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Tuition Subjects Interested <span class="text-red-500">*</span></label>
                                    <button type="button" @click="toggleAllTuitionSubjects()" class="text-[11px] font-bold text-blue-600 hover:underline cursor-pointer">
                                        <span x-text="selectedTuitionSubjects.includes('All Subjects') ? 'Deselect All' : 'Select All Subjects'"></span>
                                    </button>
                                </div>
                                @php
                                    $modalTuitionSubs = ['All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
                                @endphp
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($modalTuitionSubs as $subj)
                                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none"
                                               :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-xs' : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-amber-300'">
                                            <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}"
                                                   :checked="selectedTuitionSubjects.includes('{{ $subj }}')"
                                                   @change="toggleTuitionSubject('{{ $subj }}')"
                                                   class="sr-only">
                                            <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                            <span>{{ $subj }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Classes --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Classes You Can Teach <span class="text-red-500">*</span></label>
                                @php
                                    $modalClassList = ['Class 1–5', 'Class 6–8', 'Class 9–10', 'Class 11–12', 'Competitive / Olympiad', 'Languages / Hobby'];
                                @endphp
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($modalClassList as $cls)
                                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none"
                                               :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-xs' : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-blue-300'">
                                            <input type="checkbox" name="classes_interested[]" value="{{ $cls }}"
                                                   :checked="selectedClasses.includes('{{ $cls }}')"
                                                   @change="toggleSelectedClass('{{ $cls }}')"
                                                   class="sr-only">
                                            <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                            <span>{{ $cls }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Teaching Mode <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="teaching_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="Offline">Offline (Student's Home)</option>
                                        <option value="Online">Online (Zoom / Google Meet)</option>
                                        <option value="Both">Both (Offline & Online)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Available Time Slot</label>
                                    <select data-no-search="true" name="available_time_slot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="Flexible / Any Time">Flexible / Any Time</option>
                                        <option value="Morning (6 AM – 10 AM)">Morning (6 AM – 10 AM)</option>
                                        <option value="Afternoon (12 PM – 4 PM)">Afternoon (12 PM – 4 PM)</option>
                                        <option value="Evening (4 PM – 8 PM)">Evening (4 PM – 8 PM)</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Preferred Localities / Areas <span class="text-red-500">*</span></label>
                                <textarea name="preferred_areas" id="modal_both_areas" rows="2" placeholder="e.g. Kankarbagh, Boring Road, Bailey Road, Rajendra Nagar..."
                                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]"></textarea>
                                <div class="flex flex-wrap gap-1 mt-1.5">
                                    @foreach(['Patna', 'Kankarbagh', 'Boring Road', 'Bailey Road', 'Danapur', 'Rajendra Nagar', 'Anisabad'] as $quickArea)
                                        <button type="button" @click="appendModalArea('{{ $quickArea }}', 'modal_both_areas')" class="text-[10px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full cursor-pointer transition-colors">
                                            + {{ $quickArea }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: School Teaching Profile --}}
                        <div class="pt-4 border-t border-slate-100 space-y-4">
                            <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                                <span class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold">3</span>
                                <h4 class="text-sm font-black text-[#031b4e]">School Teaching Profile</h4>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200 ml-auto">Part B: School Profile</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Teaching Post <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="position_applying_for" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="">Select Teaching Post</option>
                                        <option value="PRT (Primary Teacher)">PRT (Primary Teacher)</option>
                                        <option value="TGT (Trained Graduate Teacher)">TGT (Trained Graduate Teacher)</option>
                                        <option value="PGT (Post Graduate Teacher)">PGT (Post Graduate Teacher)</option>
                                        <option value="Pre-Primary / NTT">Pre-Primary / NTT</option>
                                        <option value="Coordinator / Academic Head">Coordinator / Academic Head</option>
                                        <option value="Principal / Vice Principal">Principal / Vice Principal</option>
                                        <option value="Admin / Non-Teaching Staff">Admin / Non-Teaching Staff</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Subject Specialization <span class="text-red-500">*</span></label>
                                    <input type="text" name="subject_specialization" required placeholder="e.g. Mathematics, Physics, English..."
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">B.Ed Status <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="b_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="Yes">Yes (Completed)</option>
                                        <option value="Pursuing">Pursuing</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">D.El.Ed Status <span class="text-red-500">*</span></label>
                                    <select data-no-search="true" name="d_el_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes (Completed)</option>
                                        <option value="Pursuing">Pursuing</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Current / Last School (Optional)</label>
                                    <input type="text" name="last_school_name" placeholder="e.g. DPS / DAV / St. Michael's"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Expected Monthly Salary (₹)</label>
                                    <input type="number" name="expected_salary" placeholder="e.g. 30000"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                                </div>
                            </div>

                            {{-- Preferred School Locations --}}
                            <div class="bg-indigo-50/70 border border-indigo-200 rounded-2xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-indigo-500"></i> Preferred School Locations & Address <span class="text-red-500">*</span>
                                    </span>
                                    <span class="text-[10px] font-bold text-indigo-700 bg-indigo-100/90 px-2.5 py-0.5 rounded-full">Manual Type + Quick Add</span>
                                </div>
                                <textarea name="preferred_locations_manual" id="modal_both_school_manual_address" rows="2"
                                          placeholder="Type your address or preferred locations (e.g. Boring Road, Kankarbagh, Patna, Hajipur, Muzaffarpur...)"
                                          class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]"></textarea>
                                <div class="mt-2">
                                    <span class="block text-[11px] font-bold text-slate-500 mb-1.5">Quick Add Cities (Click to append):</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @php $modalLocs = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Gaya', 'Darbhanga', 'Begusarai', 'Supaul', 'Danapur', 'Ara']; @endphp
                                        @foreach($modalLocs as $quickLoc)
                                            <button type="button" 
                                                    @click="appendModalArea('{{ $quickLoc }}', 'modal_both_school_manual_address')"
                                                    class="text-[11px] font-bold bg-white hover:bg-indigo-100 text-indigo-700 border border-indigo-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors flex items-center gap-1 shadow-2xs">
                                                <i class="fas fa-plus text-[9px]"></i> {{ $quickLoc }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Resume Upload --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">
                                    Resume / CV Upload <span class="text-red-500">* (Mandatory)</span>
                                </label>
                                <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                                <p class="text-[11px] text-slate-500 mt-1">PDF or DOC format (Max 5MB).</p>
                            </div>
                        </div>

                        {{-- Submit & Cancel Button Row --}}
                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
                                    style="background-color: #059669 !important; color: #ffffff !important; background-image: linear-gradient(to right, #059669, #047857, #115e59) !important;">
                                <i class="fas fa-paper-plane" x-show="!submitting"></i>
                                <i class="fas fa-spinner fa-spin" x-show="submitting" style="display: none;"></i>
                                <span x-text="submitting ? 'Registering Dual Profile...' : 'Register for Both (Dual Profile) & Send OTP'">Register for Both (Dual Profile) & Send OTP</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TAB 3: SCHOOL TEACHER HIRING FORM --}}
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
                                <select data-no-search="true" name="category_id" id="modal_category_id" x-model="selectedCategory" @change="fetchSubjects()" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select Category</option>
                                    @foreach($modalCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subject <span class="text-red-500">*</span></label>
                                <select data-no-search="true" name="subject_id" id="modal_subject_id" required :disabled="loadingSubjects" 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer disabled:opacity-50">
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Required Qualification <span class="text-red-500">*</span></label>
                                <select data-no-search="true" name="qualification_id" id="modal_qualification_id" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select Qualification</option>
                                    @foreach($modalQualifications as $qual)
                                        <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Other / Additional Qualification</label>
                                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Optional</span>
                                </div>
                                <input type="text" name="other_qualification" id="modal_other_qualification" maxlength="150" placeholder="e.g. B.Ed, CTET, NTT, 2+ Yrs Exp..." 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Salary Range / Budget</label>
                                <input type="text" name="salary_range" maxlength="80" placeholder="e.g. ₹25,000 - ₹35,000" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">State <span class="text-red-500">*</span></label>
                                <select data-no-search="true" name="state_id" id="modal_state_id" x-model="selectedState" @change="fetchCities()" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select State</option>
                                    @foreach($modalStates as $st)
                                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">City <span class="text-red-500">*</span></label>
                                <select data-no-search="true" name="city_id" id="modal_city_id" required :disabled="loadingCities" 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer disabled:opacity-50">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 disabled:opacity-60 cursor-pointer"
                                    style="background-color: #031b4e !important; color: #ffffff !important;">
                                <i class="fas fa-paper-plane" x-show="!submitting"></i>
                                <i class="fas fa-spinner fa-spin" x-show="submitting" style="display: none;"></i>
                                <span x-text="submitting ? 'Submitting...' : 'Post School Requirement'">Post School Requirement</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
