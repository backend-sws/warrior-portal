@extends('layouts.app')

@section('title', 'Hire School Teachers & Faculty | School Hiring Form | Warriors Educare')
@section('meta_description', 'Post school teaching vacancies & hire qualified, demo-verified teachers for CBSE, ICSE, and state board schools.')

@section('content')
<div class="bg-[#f8fafc] text-slate-900 py-8 sm:py-12" x-data="hireTeacherForm()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        {{-- Hero Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-50 border border-rose-200 text-rose-800 text-xs font-extrabold uppercase tracking-wider mb-3 shadow-2xs">
                <i class="fas fa-school text-sm text-rose-600"></i> For Schools & Educational Institutions
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#031b4e] tracking-tight">
                Hire Qualified School Teachers & Faculty
            </h1>
            <p class="text-sm sm:text-base text-slate-600 max-w-xl mx-auto mt-2">
                Post your teaching vacancies & get connected with pre-screened, demo-verified educators. Choose from dropdowns or type custom details manually.
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

            <form @submit.prevent="submitForm($event)" class="p-6 sm:p-8 lg:p-10 space-y-6">
                @csrf
                <input type="hidden" name="latitude" x-model="userLat">
                <input type="hidden" name="longitude" x-model="userLng">

                {{-- Job Title / Vacancy --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                        Job Title / Vacancy <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required minlength="3" maxlength="150"
                           placeholder="e.g. PGT Physics Teacher / PRT All Subjects / Vice Principal"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                    <span x-show="fieldErrors['title']" x-text="fieldErrors['title'] ? fieldErrors['title'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Row 1: School Name | Contact Person --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            School / Institution Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="school_name" required minlength="3" maxlength="150"
                               placeholder="e.g. Delhi Public School / St. Xavier's High School"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['school_name']" x-text="fieldErrors['school_name'] ? fieldErrors['school_name'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Contact Person &amp; Designation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="contact_person" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$"
                               placeholder="e.g. Rajesh Sharma (Principal / HR Head)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['contact_person']" x-text="fieldErrors['contact_person'] ? fieldErrors['contact_person'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Row 2: Contact Mobile Number | Official Email --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Contact Mobile Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"
                               placeholder="e.g. 9876543210"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['phone']" x-text="fieldErrors['phone'] ? fieldErrors['phone'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Official Email Address</label>
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">Optional</span>
                        </div>
                        <input type="email" name="email" placeholder="e.g. hr@schoolname.org"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                        <span x-show="fieldErrors['email']" x-text="fieldErrors['email'] ? fieldErrors['email'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Row 3: Job Category | Subject (Both Select + OR TYPE) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Job Category <span class="text-red-500">*</span></label>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Select or Type Manual</span>
                        </div>
                        <select data-no-search="true" name="category_id" id="hire_category_id" x-model="selectedCategory"
                                @change="onSelectChange('category', $event)" :required="!manual_category"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                            <option value="">Select Job Category</option>
                            <option value="__manual__" x-show="manual_category" x-text="manual_category ? '✍️ Custom: ' + manual_category : ''"></option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2 flex items-center bg-white border border-dashed border-blue-300 rounded-xl px-2.5 py-1.5 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all shadow-2xs">
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded-md uppercase tracking-wider shrink-0 select-none">
                                <i class="fas fa-pen-nib text-[9px]"></i> OR TYPE
                            </span>
                            <input type="text" name="manual_category" x-model="manual_category"
                                   @input="syncManualToSelect('category')"
                                   placeholder="e.g. Primary Teacher, PRT, TGT, Music, Sports..."
                                   class="w-full bg-transparent border-0 px-2.5 py-1 text-xs font-medium text-[#031b4e] placeholder-slate-400 focus:outline-none focus:ring-0">
                        </div>
                        <span x-show="fieldErrors['category_id']" x-text="fieldErrors['category_id'] ? fieldErrors['category_id'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Subject <span class="text-red-500">*</span></label>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Select or Type Manual</span>
                        </div>
                        <select data-no-search="true" name="subject_id" id="hire_subject_id" :required="!manual_subject"
                                @change="onSelectChange('subject', $event)"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                            <option value="">Select Subject</option>
                            <option value="__manual__" x-show="manual_subject" x-text="manual_subject ? '✍️ Custom: ' + manual_subject : ''"></option>
                            @foreach($allSubjects as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2 flex items-center bg-white border border-dashed border-blue-300 rounded-xl px-2.5 py-1.5 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all shadow-2xs">
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded-md uppercase tracking-wider shrink-0 select-none">
                                <i class="fas fa-pen-nib text-[9px]"></i> OR TYPE
                            </span>
                            <input type="text" name="manual_subject" x-model="manual_subject"
                                   @input="syncManualToSelect('subject')"
                                   placeholder="e.g. Physics, Mathematics, English, Computer..."
                                   class="w-full bg-transparent border-0 px-2.5 py-1 text-xs font-medium text-[#031b4e] placeholder-slate-400 focus:outline-none focus:ring-0">
                        </div>
                        <span x-show="fieldErrors['subject_id']" x-text="fieldErrors['subject_id'] ? fieldErrors['subject_id'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Row 4: Required Qualification (Full Width: Left 50% Select, Right 50% OR TYPE) --}}
                    <div class="sm:col-span-2">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Required Qualification <span class="text-red-500">*</span></label>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Select or Type Manual</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <select data-no-search="true" name="qualification_id" id="hire_qualification_id" :required="!manual_qualification"
                                        @change="onSelectChange('qualification', $event)"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                                    <option value="">Select Qualification (e.g. B.Ed, M.Sc)</option>
                                    <option value="__manual__" x-show="manual_qualification" x-text="manual_qualification ? '✍️ Custom: ' + manual_qualification : ''"></option>
                                    @foreach($qualifications as $qual)
                                        <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center bg-white border border-dashed border-blue-300 rounded-xl px-2.5 py-1.5 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all shadow-2xs">
                                <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded-md uppercase tracking-wider shrink-0 select-none">
                                    <i class="fas fa-pen-nib text-[9px]"></i> OR TYPE
                                </span>
                                <input type="text" name="manual_qualification" x-model="manual_qualification"
                                       @input="syncManualToSelect('qualification')"
                                       placeholder="e.g. B.Ed, M.Sc, PhD, MCA, CTET, D.El.Ed..."
                                       class="w-full bg-transparent border-0 px-2.5 py-1 text-xs font-medium text-[#031b4e] placeholder-slate-400 focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        <span x-show="fieldErrors['qualification_id']" x-text="fieldErrors['qualification_id'] ? fieldErrors['qualification_id'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Row 5: Salary Range | Other Qualification --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Salary Range / Budget (Monthly)</label>
                        <input type="text" name="salary_range" maxlength="80"
                               placeholder="e.g. ₹25,000 - ₹40,000 / month (or Negotiable)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Other / Additional Qualification</label>
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">Optional</span>
                        </div>
                        <input type="text" name="other_qualification" maxlength="150"
                               placeholder="e.g. CTET qualified, NTT, 2+ Yrs Exp, Fluent English..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all">
                    </div>

                    {{-- Row 6: State | City (Both Select + OR TYPE) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">State <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-1.5">
                                <button type="button" @click="detectLocation(false)" class="text-[11px] font-bold text-purple-700 hover:text-purple-900 bg-purple-50 hover:bg-purple-100 px-2 py-0.5 rounded-lg border border-purple-200 transition-colors flex items-center gap-1 cursor-pointer">
                                    <i class="fas fa-location-crosshairs text-[10px] text-purple-600" :class="locating ? 'animate-spin' : ''"></i> Use Live GPS
                                </button>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100 hidden sm:inline-block">Select or Type</span>
                            </div>
                        </div>
                        <div class="mb-2" x-show="userLat && userLng" x-cloak>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-bold">
                                <i class="fas fa-check-circle text-emerald-500"></i> Live GPS Attached (<span x-text="Number(userLat).toFixed(4)"></span>, <span x-text="Number(userLng).toFixed(4)"></span>)
                            </span>
                        </div>
                        <select data-no-search="true" name="state_id" id="hire_state_id" x-model="selectedState"
                                @change="onSelectChange('state', $event)" :required="!manual_state"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                            <option value="">Select State</option>
                            <option value="__manual__" x-show="manual_state" x-text="manual_state ? '✍️ Custom: ' + manual_state : ''"></option>
                            @foreach($states as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2 flex items-center bg-white border border-dashed border-blue-300 rounded-xl px-2.5 py-1.5 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all shadow-2xs">
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded-md uppercase tracking-wider shrink-0 select-none">
                                <i class="fas fa-pen-nib text-[9px]"></i> OR TYPE
                            </span>
                            <input type="text" name="manual_state" x-model="manual_state"
                                   @input="syncManualToSelect('state')"
                                   placeholder="e.g. Bihar, Uttar Pradesh, Delhi NCR, Jharkhand..."
                                   class="w-full bg-transparent border-0 px-2.5 py-1 text-xs font-medium text-[#031b4e] placeholder-slate-400 focus:outline-none focus:ring-0">
                        </div>
                        <span x-show="fieldErrors['state_id']" x-text="fieldErrors['state_id'] ? fieldErrors['state_id'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">City <span class="text-red-500">*</span></label>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Select or Type Manual</span>
                        </div>
                        <select data-no-search="true" name="city_id" id="hire_city_id" :required="!manual_city"
                                @change="onSelectChange('city', $event)"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all cursor-pointer">
                            <option value="">Select City</option>
                            <option value="__manual__" x-show="manual_city" x-text="manual_city ? '✍️ Custom: ' + manual_city : ''"></option>
                            @foreach($allCities as $ct)
                                <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2 flex items-center bg-white border border-dashed border-blue-300 rounded-xl px-2.5 py-1.5 focus-within:border-[#0ea5e9] focus-within:ring-2 focus-within:ring-[#0ea5e9]/20 transition-all shadow-2xs">
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded-md uppercase tracking-wider shrink-0 select-none">
                                <i class="fas fa-pen-nib text-[9px]"></i> OR TYPE
                            </span>
                            <input type="text" name="manual_city" x-model="manual_city"
                                   @input="syncManualToSelect('city')"
                                   placeholder="e.g. Patna, Muzaffarpur, Gaya, Ranchi, Lucknow..."
                                   class="w-full bg-transparent border-0 px-2.5 py-1 text-xs font-medium text-[#031b4e] placeholder-slate-400 focus:outline-none focus:ring-0">
                        </div>
                        <span x-show="fieldErrors['city_id']" x-text="fieldErrors['city_id'] ? fieldErrors['city_id'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                    </div>

                    {{-- Row 7: Job Description & Additional Requirements (Full Width) --}}
                    <div class="sm:col-span-2">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Job Description &amp; Experience Requirements</label>
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">Optional</span>
                        </div>
                        <textarea name="description" rows="3" maxlength="1500"
                                  placeholder="e.g. Minimum 2+ years teaching experience required. Good English communication skills, student-friendly approach..."
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" :disabled="submitting"
                            class="w-full py-4 rounded-2xl bg-[#031b4e] hover:bg-[#021338] text-white text-base font-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-show="!submitting" class="flex items-center justify-center gap-2 text-white font-bold">
                            <i class="fas fa-paper-plane text-white text-sm"></i>
                            <span>Post School Requirement</span>
                        </span>
                        <span x-show="submitting" x-cloak class="flex items-center justify-center gap-2 text-white font-bold">
                            <i class="fas fa-spinner animate-spin text-white"></i>
                            <span>Submitting Requirement...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function hireTeacherForm() {
    return {
        submitting: false,
        successMessage: '',
        errorMessage: '',
        fieldErrors: {},
        selectedCategory: '',
        selectedState: '',
        subjects: [],
        cities: [],
        manual_category: '',
        manual_subject: '',
        manual_qualification: '',
        manual_state: '',
        manual_city: '',
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

        fetchSubjects() {
            const catSelect = document.getElementById('hire_category_id');
            const catVal = (catSelect && catSelect.value) ? catSelect.value : this.selectedCategory;
            this.selectedCategory = catVal;
            const subSelect = document.getElementById('hire_subject_id');

            if (!catVal || catVal === '__manual__') {
                return;
            }
            fetch('/api/categories/' + catVal + '/subjects')
                .then(res => res.json())
                .then(data => {
                    this.subjects = Array.isArray(data) ? data : [];
                    this.updateSelectOptions(subSelect, this.subjects, 'Select Subject');
                })
                .catch(err => {
                    this.subjects = [];
                    this.updateSelectOptions(subSelect, [], 'Select Subject');
                });
        },

        fetchCities() {
            const stateSelect = document.getElementById('hire_state_id');
            const stateVal = (stateSelect && stateSelect.value) ? stateSelect.value : this.selectedState;
            this.selectedState = stateVal;
            const citySelect = document.getElementById('hire_city_id');

            if (!stateVal || stateVal === '__manual__') {
                return;
            }
            fetch('/api/states/' + stateVal + '/cities')
                .then(res => res.json())
                .then(data => {
                    this.cities = Array.isArray(data) ? data : [];
                    this.updateSelectOptions(citySelect, this.cities, 'Select City');
                })
                .catch(err => {
                    this.cities = [];
                    this.updateSelectOptions(citySelect, [], 'Select City');
                });
        },

        updateSelectOptions(selectEl, items, placeholder, selectedValue = '') {
            if (!selectEl) return;
            let html = '<option value="">' + placeholder + '</option>';
            items.forEach(item => {
                const isSel = selectedValue && String(selectedValue) === String(item.id);
                html += '<option value="' + item.id + '" ' + (isSel ? 'selected' : '') + '>' + item.name + '</option>';
            });
            selectEl.innerHTML = html;
        },

        syncManualToSelect(field) {
            const manualKey = 'manual_' + field;
            const manualVal = (this[manualKey] || '').trim();
            const selectEl = document.getElementById('hire_' + field + '_id');

            if (field === 'category') {
                if (manualVal) {
                    this.selectedCategory = '__manual__';
                } else if (this.selectedCategory === '__manual__') {
                    this.selectedCategory = '';
                }
            } else if (field === 'state') {
                if (manualVal) {
                    this.selectedState = '__manual__';
                } else if (this.selectedState === '__manual__') {
                    this.selectedState = '';
                }
            }

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
                this['manual_' + field] = '';
            }
            if (field === 'category') {
                this.fetchSubjects();
            } else if (field === 'state') {
                this.fetchCities();
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
                const response = await fetch('{{ route('school.requirement.post') }}', {
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
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    this.successMessage = data.message || 'School teacher requirement submitted successfully! Our educational consultant will contact you shortly.';
                    form.reset();
                    this.manual_category = '';
                    this.manual_subject = '';
                    this.manual_qualification = '';
                    this.manual_state = '';
                    this.manual_city = '';
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
                console.error('School hiring form error:', err);
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
