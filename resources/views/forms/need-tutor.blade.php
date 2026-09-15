@extends('layouts.app')

@section('title', 'Need a Home Tutor in Patna | Post Tuition Requirement | Warriors Educare')
@section('meta_description', 'Find certified, experienced, and background-verified home tutors in Patna. Post your tuition requirement for all classes, ICSE, CBSE, and state boards.')

@section('content')
<div class="bg-[#f8fafc] text-slate-900 py-8 sm:py-12" x-data="needTutorForm()">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        
        {{-- Hero Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-extrabold uppercase tracking-wider mb-3 shadow-2xs">
                <i class="fas fa-graduation-cap text-sm text-emerald-600"></i> For Parents & Students • 100% Free
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#031b4e] tracking-tight">
                Request a Verified Home Tutor
            </h1>
            <p class="text-sm sm:text-base text-slate-600 max-w-xl mx-auto mt-2">
                Tell us your learning needs & our academic counseling team will match and connect you with verified home tutors.
            </p>
        </div>

        {{-- Form Container Card --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            
            {{-- Alert Messages --}}
            <div x-show="errorMessage" x-cloak class="p-4 bg-rose-50 border-b border-rose-200 text-rose-800 text-xs sm:text-sm font-bold flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-rose-500 text-base shrink-0"></i>
                <span x-text="errorMessage"></span>
            </div>
            <div x-show="successMessage" x-cloak class="p-4 bg-emerald-50 border-b border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500 text-base shrink-0"></i>
                <span x-text="successMessage"></span>
            </div>

            <form @submit.prevent="submitForm($event)" class="p-6 sm:p-8 lg:p-10 space-y-5">
                @csrf
                <input type="hidden" name="latitude" x-model="userLat">
                <input type="hidden" name="longitude" x-model="userLng">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Parent / Client Name --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Parent / Client Name <span class="text-red-500">*</span></label>
                        <input type="text" name="guest_name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" title="Please enter full name (letters only, min 3 characters)." placeholder="e.g. Rajesh Kumar" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['guest_name']" x-text="fieldErrors['guest_name'] ? fieldErrors['guest_name'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Contact Phone Number --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Contact Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="guest_phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" title="Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9." placeholder="e.g. 9876543210" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['guest_phone']" x-text="fieldErrors['guest_phone'] ? fieldErrors['guest_phone'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Student's Class (Manual text input) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Student's Class <span class="text-red-500">*</span></label>
                        <input type="text" name="student_class" required minlength="1" maxlength="50" placeholder="e.g. Class 10 / Class 12 / Nursery / Class 5" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['student_class']" x-text="fieldErrors['student_class'] ? fieldErrors['student_class'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Education Board (Select or Type Manual) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Education Board <span class="text-red-500">*</span></label>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Select or Type Manual</span>
                        </div>
                        <select data-no-search="true" name="board" id="tuition_board" :required="!modal_manual_board" 
                                @change="onSelectChange('board', $event)"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                            <option value="">Select Board</option>
                            <option value="__manual__" x-show="modal_manual_board" x-text="modal_manual_board ? '✍️ Custom: ' + modal_manual_board : ''"></option>
                            <option value="CBSE">CBSE Board</option>
                            <option value="ICSE">ICSE / ISC</option>
                            <option value="State Board">State Board (BSEB)</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="mt-2 flex items-center bg-white border border-dashed border-blue-300 rounded-xl px-2.5 py-1.5 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all shadow-2xs">
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded-md uppercase tracking-wider shrink-0 select-none">
                                <i class="fas fa-pen-nib text-[9px]"></i> OR TYPE
                            </span>
                            <input type="text" name="manual_board" x-model="modal_manual_board"
                                   @input="syncManualToSelect('board')"
                                   placeholder="e.g. CBSE, ICSE, BSEB, NIOS, Cambridge..." 
                                   class="w-full bg-transparent border-0 px-2.5 py-1 text-xs font-medium text-[#031b4e] placeholder-slate-400 focus:outline-none focus:ring-0">
                        </div>
                        <span x-show="fieldErrors['board']" x-text="fieldErrors['board'] ? fieldErrors['board'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Subjects Needed (Manual text input) --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subjects Needed <span class="text-red-500">*</span></label>
                        <input type="text" name="subjects" required minlength="2" maxlength="150" placeholder="e.g. Mathematics, Physics, English, Science (or All Subjects)" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['subjects']" x-text="fieldErrors['subjects'] ? fieldErrors['subjects'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Location / Area Address (Manual text input with Live GPS) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Location / Area Address <span class="text-red-500">*</span></label>
                            <button type="button" @click="detectLocation(false)" class="text-[11px] font-bold text-sky-700 hover:text-sky-900 bg-sky-50 hover:bg-sky-100 px-2.5 py-1 rounded-lg border border-sky-200 transition-colors flex items-center gap-1 cursor-pointer">
                                <i class="fas fa-location-crosshairs text-[10px] text-sky-600"></i>
                                <span x-text="locating ? 'Detecting...' : 'Use Live GPS'"></span>
                            </button>
                        </div>
                        <input type="text" name="location" required minlength="3" maxlength="200" placeholder="e.g. Near Shiv Mandir, Kankarbagh, Patna" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <div class="mt-1.5" x-show="userLat && userLng" x-cloak>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold">
                                <i class="fas fa-check-circle text-emerald-500"></i> GPS Attached (<span x-text="Number(userLat).toFixed(4)"></span>, <span x-text="Number(userLng).toFixed(4)"></span>)
                            </span>
                        </div>
                        <span x-show="fieldErrors['location']" x-text="fieldErrors['location'] ? fieldErrors['location'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Pincode (Manual text input) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Pincode</label>
                        <input type="text" name="pincode" maxlength="6" pattern="^[0-9]{6}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" title="Please enter a valid 6-digit Pincode." placeholder="6-digit Pincode (e.g. 800020)" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all font-mono">
                    </div>

                    {{-- Duration Hours (Manual text input) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Time Duration (Daily Hours)</label>
                        <input type="text" name="duration_hours" maxlength="50" placeholder="e.g. 1.5 Hours / Day (Kitne ghante padhana hai)" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                    </div>

                    {{-- Days Per Week (Manual text input) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Days Per Week</label>
                        <input type="text" name="days_per_week" maxlength="50" placeholder="e.g. 5 Days / Week (Week me kitne din padhana hoga)" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                    </div>

                    {{-- Remarks / Specific Requirements (Textarea) --}}
                    <div class="sm:col-span-2">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Remark / Specific Requirements</label>
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">Optional</span>
                        </div>
                        <textarea name="remarks" rows="3" maxlength="1500" placeholder="e.g. Female tutor preferred / Timing evening 5:00 PM / Focus on weak math fundamentals, etc." 
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" :disabled="submitting"
                            class="w-full py-4 rounded-2xl bg-[#031b4e] hover:bg-[#021338] text-white text-base font-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-show="!submitting" class="flex items-center justify-center gap-2 text-white font-bold">
                            <span>Post Tuition Requirement</span>
                            <i class="fas fa-paper-plane text-white text-sm"></i>
                        </span>
                        <span x-show="submitting" x-cloak class="flex items-center justify-center gap-2 text-white font-bold">
                            <i class="fas fa-spinner animate-spin text-white"></i>
                            <span>Submitting Your Requirement...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function needTutorForm() {
    return {
        submitting: false,
        successMessage: '',
        errorMessage: '',
        fieldErrors: {},
        modal_manual_board: '',
        userLat: '',
        userLng: '',
        locating: false,

        init() {
            this.detectLocation(true);
        },

        detectLocation(silent = false) {
            if (typeof window.captureUserLiveLocation === 'function') {
                this.locating = true;
                window.captureUserLiveLocation(silent, (coords) => {
                    this.userLat = coords.lat;
                    this.userLng = coords.lng;
                    this.locating = false;
                });
            }
        },

        syncManualToSelect(field) {
            const selectEl = document.getElementById('tuition_' + field);
            const manualVal = this['modal_manual_' + field] ? this['modal_manual_' + field].trim() : '';

            if (selectEl) {
                let opt = selectEl.querySelector('option[value="__manual__"]');
                if (!opt) {
                    opt = document.createElement('option');
                    opt.value = '__manual__';
                    if (selectEl.options.length > 1) {
                        selectEl.insertBefore(opt, selectEl.options[1]);
                    } else {
                        selectEl.appendChild(opt);
                    }
                }
                if (manualVal) {
                    opt.textContent = '✍️ Custom: ' + manualVal;
                    opt.style.display = '';
                    opt.selected = true;
                    selectEl.value = '__manual__';
                } else {
                    opt.textContent = '';
                    opt.style.display = 'none';
                    if (selectEl.value === '__manual__') selectEl.value = '';
                }
            }
        },

        onSelectChange(field, event) {
            const val = event && event.target ? event.target.value : '';
            if (val !== '__manual__') {
                this['modal_manual_' + field] = '';
            }
        },

        async submitForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            if (this.userLat && !formData.get('latitude')) formData.set('latitude', this.userLat);
            if (this.userLng && !formData.get('longitude')) formData.set('longitude', this.userLng);
            this.submitting = true;
            this.successMessage = '';
            this.errorMessage = '';
            this.fieldErrors = {};

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token') || '';
                const response = await fetch('{{ route('tuition.post') }}', {
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
                    try { data = JSON.parse(text); } catch (err) { data = {}; }
                }

                if (response.ok && data.success) {
                    if (typeof window.trackLeadConversion === 'function') {
                        window.trackLeadConversion('home_tuition', { form_name: 'Standalone Need Tutor Form' });
                    }
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    this.successMessage = data.message || 'Your tuition requirement has been submitted successfully! Our academic counseling team will match verified tutors with you shortly.';
                    form.reset();
                    this.modal_manual_board = '';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } catch (err) {
                console.error('Tuition requirement form error:', err);
                this.errorMessage = 'Network connection issue. Please check your connection and try again.';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } finally {
                this.submitting = false;
            }
        }
    };
}
</script>
@endsection
