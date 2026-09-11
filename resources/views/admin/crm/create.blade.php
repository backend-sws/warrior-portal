@extends('layouts.admin')

@section('title', 'Onboard Candidate')
@section('subtitle', 'Register teacher or tutor candidate profile for School Jobs and Home Tuitions.')

@section('actions')
    <a href="{{ route('admin.crm.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> <span>Back to Candidates</span>
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8"
     x-data="{
         candidateCategory: '{{ old('candidate_category', 'both') }}',
         name: '{{ old('name', '') }}',
         email: '{{ old('email', '') }}',
         phone: '{{ old('phone', '') }}',
         whatsapp_no: '{{ old('whatsapp_no', '') }}',
         sameAsMobile: true,
         password: '{{ old('password', 'Warrior@' . rand(100, 999)) }}',
         password_confirmation: '{{ old('password_confirmation', '') }}',
         gender: '{{ old('gender', '') }}',
         date_of_birth: '{{ old('date_of_birth', '') }}',
         highest_qualification: '{{ old('highest_qualification', '') }}',
         experience_range: '{{ old('experience_range', '') }}',
         selectedTuitionSubjects: {{ json_encode(old('tuition_subjects', ['All Subjects'])) }},
         selectedClasses: {{ json_encode(old('classes_interested', ['Class 1-5', 'Class 6-8', 'Class 9-10'])) }},
         userLat: '{{ old('latitude', '') }}',
         userLng: '{{ old('longitude', '') }}',
         detectLocation(silent = false) {
             if (typeof window.captureUserLiveLocation === 'function') {
                 window.captureUserLiveLocation(silent, (coords) => {
                     this.userLat = coords.lat;
                     this.userLng = coords.lng;
                 });
             }
         },
         
         init() {
             if (!this.password_confirmation && this.password) {
                 this.password_confirmation = this.password;
             }
             window.addEventListener('gps-detected', (e) => {
                 if (e.detail && e.detail.lat && e.detail.lng) {
                     this.userLat = e.detail.lat;
                     this.userLng = e.detail.lng;
                 }
             });
         },
         syncWhatsapp() {
             if (this.sameAsMobile) {
                 this.whatsapp_no = this.phone;
             }
         },
         syncPassword() {
             this.password_confirmation = this.password;
         },
         toggleTuitionSubject(subj) {
             if (subj === 'All Subjects') {
                 if (this.selectedTuitionSubjects.includes('All Subjects')) {
                     this.selectedTuitionSubjects = [];
                 } else {
                     this.selectedTuitionSubjects = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
                 }
                 return;
             }
             if (this.selectedTuitionSubjects.includes(subj)) {
                 this.selectedTuitionSubjects = this.selectedTuitionSubjects.filter(s => s !== subj && s !== 'All Subjects');
             } else {
                 this.selectedTuitionSubjects.push(subj);
             }
         },
         toggleAllTuitionSubjects() {
             if (this.selectedTuitionSubjects.length > 0) {
                 this.selectedTuitionSubjects = [];
             } else {
                 this.selectedTuitionSubjects = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
             }
         },
         toggleSelectedClass(cls) {
             if (this.selectedClasses.includes(cls)) {
                 this.selectedClasses = this.selectedClasses.filter(c => c !== cls);
             } else {
                 this.selectedClasses.push(cls);
             }
         },
         appendArea(area, elId) {
             const el = document.getElementById(elId);
             if (!el) return;
             let val = el.value.trim();
             if (!val) {
                 el.value = area;
             } else {
                 let parts = val.split(',').map(s => s.trim());
                 if (!parts.includes(area)) {
                     el.value = val + ', ' + area;
                 }
             }
             el.dispatchEvent(new Event('input'));
         }
     }">

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm font-bold shadow-sm">
            <div class="flex items-center gap-2 mb-2 text-red-800">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Please correct the errors below:</span>
            </div>
            <ul class="list-disc pl-5 font-normal text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Teaching Mode Switcher Tabs (Exact match to present modal) --}}
    <div class="mb-8 p-2 bg-gradient-to-r from-slate-100 via-sky-50/50 to-slate-100 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="px-2 py-1 mb-1.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-600">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-chalkboard-teacher text-amber-500"></i> Select Candidate Teaching Preference:
            </span>
            <span class="text-[10px] font-semibold text-slate-400">Choose one to display corresponding registration form</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
            <button type="button" @click="candidateCategory = 'home_tutor'"
                    :class="candidateCategory === 'home_tutor' ? 'bg-white text-[#031b4e] shadow-md font-black border-2 border-[#0ea5e9] scale-[1.01]' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white font-bold border border-transparent'"
                    class="py-3 px-3 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fas fa-home text-[#0ea5e9]"></i>
                <span>Home Tutor Only</span>
            </button>
            <button type="button" @click="candidateCategory = 'school_job'"
                    :class="candidateCategory === 'school_job' ? 'bg-white text-[#031b4e] shadow-md font-black border-2 border-amber-500 scale-[1.01]' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white font-bold border border-transparent'"
                    class="py-3 px-3 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fas fa-chalkboard-teacher text-amber-500"></i>
                <span>School Job Only</span>
            </button>
            <button type="button" @click="candidateCategory = 'both'"
                    :class="candidateCategory === 'both' ? 'bg-white text-[#031b4e] shadow-md font-black border-2 border-emerald-500 scale-[1.01]' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white font-bold border border-transparent'"
                    class="py-3 px-3 rounded-xl text-xs sm:text-[13px] transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fas fa-handshake text-emerald-600"></i>
                <span>Both (School Job + Home Tuition)</span>
            </button>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- 1. HOME TUTOR CANDIDATE REGISTRATION FORM                                 --}}
    {{-- ========================================================================= --}}
    <div x-show="candidateCategory === 'home_tutor'">
        <form action="{{ route('admin.crm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <input type="text" name="name" x-model="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="email" required placeholder="e.g. rahul@example.com"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" x-model="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" @input="syncWhatsapp()" placeholder="e.g. 9876543210"
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
                        <input type="tel" name="whatsapp_no" x-model="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" placeholder="e.g. 9876543210"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="text" name="password" x-model="password" @input="syncPassword()" required minlength="6" placeholder="•••••••• (Min 8 chars)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="text" name="password_confirmation" x-model="password_confirmation" required minlength="6" placeholder="Re-enter password (Min 8 chars)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" x-model="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_birth" x-model="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                        <input type="text" name="highest_qualification" x-model="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Total Teaching Experience <span class="text-red-500">*</span></label>
                        <select name="experience_range" x-model="experience_range" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                        <select name="teaching_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="Offline">Offline (Student's Home)</option>
                            <option value="Online">Online (Zoom / Google Meet)</option>
                            <option value="Both">Both (Offline & Online)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Available Time Slot</label>
                        <select name="available_time_slot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                    @php $modalTuitionSubs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies']; @endphp
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($modalTuitionSubs as $subj)
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-amber-400'">
                                <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}" :checked="selectedTuitionSubjects.includes('{{ $subj }}')" @change="toggleTuitionSubject('{{ $subj }}')" class="sr-only">
                                <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                <span>{{ $subj }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-amber-200/80 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <span class="text-[11px] font-bold text-amber-900 whitespace-nowrap flex items-center gap-1">
                            <i class="fas fa-edit text-amber-600"></i> Other / Manual Subjects:
                        </span>
                        <input type="text" name="manual_tuition_subjects" value="{{ old('manual_tuition_subjects') }}" placeholder="Type other subjects here (e.g. Sanskrit, French, Coding...)"
                               class="w-full bg-white border border-amber-300 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400">
                    </div>
                </div>

                {{-- Classes Card --}}
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                    <span class="text-xs font-black text-blue-800 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-chalkboard-teacher text-blue-500"></i> Classes You Can Teach <span class="text-red-500">*</span></span>
                    @php $modalClassList = ['Pre-Primary', 'Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12', 'IIT-JEE', 'NEET', 'Olympiad', 'Competitive / Olympiad', 'Languages / Hobby']; @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach($modalClassList as $cls)
                            <label class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'">
                                <input type="checkbox" name="classes_interested[]" value="{{ $cls }}" :checked="selectedClasses.includes('{{ $cls }}')" @change="toggleSelectedClass('{{ $cls }}')" class="sr-only">
                                <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                <span>{{ $cls }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-blue-200/80 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <span class="text-[11px] font-bold text-blue-900 whitespace-nowrap flex items-center gap-1">
                            <i class="fas fa-edit text-blue-600"></i> Other Classes / Exams:
                        </span>
                        <input type="text" name="manual_classes" value="{{ old('manual_classes') }}" placeholder="Type other classes / exams (e.g. NDA, CUET, Commerce Foundation...)"
                               class="w-full bg-white border border-blue-300 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40 focus:border-blue-400">
                    </div>
                </div>

                {{-- Preferred Areas Card --}}
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-emerald-800 uppercase tracking-wide flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-emerald-500"></i> Preferred Localities / Areas <span class="text-red-500">*</span></span>
                        <button type="button" @click="detectLocation()" class="text-xs font-bold text-emerald-800 hover:text-white bg-emerald-100 hover:bg-emerald-600 border border-emerald-300 px-2.5 py-1 rounded-lg cursor-pointer transition-all flex items-center gap-1 shadow-2xs">
                            <i class="fas fa-crosshairs text-[10px]"></i> Use Live GPS
                        </button>
                    </div>
                    <input type="hidden" name="latitude" :value="userLat">
                    <input type="hidden" name="longitude" :value="userLng">
                    <textarea name="preferred_areas" id="modal_ht_areas" rows="2" placeholder="e.g. Kankarbagh, Boring Road, Bailey Road, Rajendra Nagar..." class="w-full bg-white border border-emerald-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-emerald-400/40 focus:border-emerald-400">{{ old('preferred_areas') }}</textarea>
                    <div x-show="userLat && userLng" x-cloak class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-white px-2.5 py-1 rounded-lg border border-emerald-300 animate-fade-in">
                        <i class="fas fa-map-pin text-emerald-600"></i>
                        <span>GPS Coordinates Attached (<span x-text="Number(userLat).toFixed(4)"></span>, <span x-text="Number(userLng).toFixed(4)"></span>)</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-2">
                        @foreach(['Patna', 'Kankarbagh', 'Boring Road', 'Bailey Road', 'Danapur', 'Rajendra Nagar', 'Anisabad'] as $quickArea)
                            <button type="button" @click="appendArea('{{ $quickArea }}', 'modal_ht_areas')" class="text-[11px] font-bold bg-white hover:bg-emerald-100 text-emerald-700 border border-emerald-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors">
                                + {{ $quickArea }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Optional Resume --}}
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                    <span class="text-xs font-black text-slate-700 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-file-alt text-slate-500"></i> Resume / CV <span class="text-slate-400 font-normal normal-case text-[11px]">(Optional)</span></span>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-white hover:file:bg-amber-600 cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1.5">PDF, DOC, DOCX format. Max 5MB.</p>
                </div>
            </div>

            {{-- Submit Row --}}
            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                <a href="{{ route('admin.crm.index') }}" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 cursor-pointer text-white"
                        style="background-image: linear-gradient(to right, #f59e0b, #d97706, #ea580c);">
                    <i class="fas fa-check-circle"></i>
                    <span>Register as Home Tutor</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ========================================================================= --}}
    {{-- 2. SCHOOL JOB CANDIDATE REGISTRATION FORM                                 --}}
    {{-- ========================================================================= --}}
    <div x-show="candidateCategory === 'school_job'">
        <form action="{{ route('admin.crm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <input type="text" name="name" x-model="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="email" required placeholder="e.g. rahul@example.com"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" x-model="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" @input="syncWhatsapp()" placeholder="e.g. 9876543210"
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
                        <input type="tel" name="whatsapp_no" x-model="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" placeholder="e.g. 9876543210"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="text" name="password" x-model="password" @input="syncPassword()" required minlength="6" placeholder="•••••••• (Min 8 chars)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="text" name="password_confirmation" x-model="password_confirmation" required minlength="6" placeholder="Re-enter password (Min 8 chars)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" x-model="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_birth" x-model="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                        <input type="text" name="highest_qualification" x-model="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Total Teaching Experience <span class="text-red-500">*</span></label>
                        <select name="experience_range" x-model="experience_range" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                        <select name="position_applying_for" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                        <select name="b_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="Yes">Yes (Completed)</option>
                            <option value="Pursuing">Pursuing</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">D.El.Ed Status <span class="text-red-500">*</span></label>
                        <select name="d_el_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="No">No</option>
                            <option value="Yes">Yes (Completed)</option>
                            <option value="Pursuing">Pursuing</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Current / Last School <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="text" name="last_school_name" placeholder="e.g. DPS / DAV / St. Xavier's High School" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Last Designation / Role <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="text" name="last_designation" placeholder="e.g. PGT Physics / TGT Maths / PRT Teacher" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Last Drawn Monthly Salary (₹) <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="number" name="last_drawn_salary" min="0" placeholder="e.g. 25000 (Current / Last Monthly Salary)" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Expected Monthly Salary (₹) <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="number" name="expected_salary" min="0" placeholder="e.g. 35000 (Expected Monthly Salary)" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-black text-amber-800 uppercase tracking-wide flex items-center gap-1.5"><i class="fas fa-book-open text-amber-500"></i> Subjects You Can Teach <span class="text-red-500">*</span></span>
                        <button type="button" @click="toggleAllTuitionSubjects()" class="text-[11px] font-bold text-amber-700 bg-white border border-amber-300 px-2.5 py-1 rounded-lg cursor-pointer hover:bg-amber-100">
                            <span x-text="selectedTuitionSubjects.includes('All Subjects') ? 'Deselect All' : 'Select All'"></span>
                        </button>
                    </div>
                    @php $modalSchoolSubs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies']; @endphp
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($modalSchoolSubs as $subj)
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-amber-400'">
                                <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}" :checked="selectedTuitionSubjects.includes('{{ $subj }}')" @change="toggleTuitionSubject('{{ $subj }}')" class="sr-only">
                                <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                <span>{{ $subj }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-amber-200/80 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <span class="text-[11px] font-bold text-amber-900 whitespace-nowrap flex items-center gap-1">
                            <i class="fas fa-edit text-amber-600"></i> Other / Manual Subjects:
                        </span>
                        <input type="text" name="manual_tuition_subjects" value="{{ old('manual_tuition_subjects') }}" placeholder="Type other subjects here (e.g. Sanskrit, French, Coding...)"
                               class="w-full bg-white border border-amber-300 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400">
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                    <span class="text-xs font-black text-blue-800 uppercase tracking-wide flex items-center gap-1.5 mb-3"><i class="fas fa-chalkboard-teacher text-blue-500"></i> Classes You Can Teach <span class="text-red-500">*</span></span>
                    @php $modalSchoolClassList = ['Pre-Primary', 'Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12', 'IIT-JEE', 'NEET', 'Olympiad', 'Languages / Hobby']; @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach($modalSchoolClassList as $cls)
                            <label class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all select-none" :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400'">
                                <input type="checkbox" name="classes_interested[]" value="{{ $cls }}" :checked="selectedClasses.includes('{{ $cls }}')" @change="toggleSelectedClass('{{ $cls }}')" class="sr-only">
                                <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                <span>{{ $cls }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-blue-200/80 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <span class="text-[11px] font-bold text-blue-900 whitespace-nowrap flex items-center gap-1">
                            <i class="fas fa-edit text-blue-600"></i> Other Classes / Exams:
                        </span>
                        <input type="text" name="manual_classes" value="{{ old('manual_classes') }}" placeholder="Type other classes / exams (e.g. NDA, CUET, Commerce Foundation...)"
                               class="w-full bg-white border border-blue-300 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40 focus:border-blue-400">
                    </div>
                </div>

                <div class="bg-indigo-50/80 border border-indigo-200 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-indigo-800 uppercase tracking-wide flex items-center gap-1.5">
                            <i class="fas fa-map-marker-alt text-indigo-500"></i> Preferred School Locations & Address <span class="text-red-500">*</span>
                        </span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="detectLocation()" class="text-xs font-bold text-indigo-800 hover:text-white bg-indigo-100 hover:bg-indigo-600 border border-indigo-300 px-2.5 py-1 rounded-lg cursor-pointer transition-all flex items-center gap-1 shadow-2xs">
                                <i class="fas fa-crosshairs text-[10px]"></i> Use Live GPS
                            </button>
                            <span class="text-[10px] font-bold text-indigo-700 bg-indigo-100/90 px-2.5 py-0.5 rounded-full">Manual Type + Quick Add</span>
                        </div>
                    </div>
                    <input type="hidden" name="latitude" :value="userLat">
                    <input type="hidden" name="longitude" :value="userLng">
                    <textarea name="preferred_locations_manual" id="modal_school_manual_address" rows="2"
                              placeholder="Type your address or preferred locations (e.g. Boring Road, Kankarbagh, Patna, Hajipur, Muzaffarpur...)"
                              class="w-full bg-white border border-indigo-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-500">{{ old('preferred_locations_manual') }}</textarea>
                    <div x-show="userLat && userLng" x-cloak class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-indigo-800 bg-white px-2.5 py-1 rounded-lg border border-indigo-300 animate-fade-in">
                        <i class="fas fa-map-pin text-indigo-600"></i>
                        <span>GPS Coordinates Attached (<span x-text="Number(userLat).toFixed(4)"></span>, <span x-text="Number(userLng).toFixed(4)"></span>)</span>
                    </div>
                    <div class="mt-2">
                        <span class="block text-[11px] font-bold text-slate-500 mb-1.5">Quick Add Cities (Click to append):</span>
                        <div class="flex flex-wrap gap-1.5">
                            @php $modalLocs = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Gaya', 'Darbhanga', 'Begusarai', 'Supaul', 'Danapur', 'Ara']; @endphp
                            @foreach($modalLocs as $loc)
                                <button type="button" 
                                        @click="appendArea('{{ $loc }}', 'modal_school_manual_address')"
                                        class="text-[11px] font-bold bg-white hover:bg-indigo-100 text-indigo-700 border border-indigo-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors flex items-center gap-1 shadow-2xs">
                                    <i class="fas fa-plus text-[9px]"></i> {{ $loc }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Document Uploads: Resume & Salary Slip --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="bg-slate-50/90 border border-slate-200 rounded-2xl p-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5 flex items-center justify-between">
                            <span>Resume / CV Upload <span class="text-red-500">*</span></span>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">Mandatory</span>
                        </label>
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5"><i class="fas fa-file-pdf text-rose-500"></i> PDF or DOC format (Max 5MB).</p>
                    </div>

                    <div class="bg-slate-50/90 border border-slate-200 rounded-2xl p-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5 flex items-center justify-between">
                            <span>Latest Salary Slip</span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Optional (Recommended)</span>
                        </label>
                        <input type="file" name="salary_slip" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                        <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5"><i class="fas fa-receipt text-emerald-600"></i> PDF, JPG, PNG or DOC (Max 5MB) for quick verification.</p>
                    </div>
                </div>
            </div>

            {{-- Submit Row --}}
            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                <a href="{{ route('admin.crm.index') }}" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 cursor-pointer text-white"
                        style="background-image: linear-gradient(to right, #1d4ed8, #1e40af, #1e1b4b);">
                    <i class="fas fa-check-circle"></i>
                    <span>Register for School Job</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ========================================================================= --}}
    {{-- 3. BOTH (DUAL PROFILE: HOME TUTOR + SCHOOL JOB)                          --}}
    {{-- ========================================================================= --}}
    <div x-show="candidateCategory === 'both'">
        <form action="{{ route('admin.crm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <input type="text" name="name" x-model="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" x-model="email" required placeholder="e.g. rahul@example.com"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" x-model="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" @input="syncWhatsapp()" placeholder="e.g. 9876543210"
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
                        <input type="tel" name="whatsapp_no" x-model="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" placeholder="e.g. 9876543210"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="text" name="password" x-model="password" @input="syncPassword()" required minlength="6" placeholder="•••••••• (Min 8 chars)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="text" name="password_confirmation" x-model="password_confirmation" required minlength="6" placeholder="Re-enter password (Min 8 chars)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" x-model="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_birth" x-model="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                        <input type="text" name="highest_qualification" x-model="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Total Teaching Experience <span class="text-red-500">*</span></label>
                        <select name="experience_range" x-model="experience_range" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                        $modalTuitionSubs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
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
                    <div class="mt-2.5 pt-2 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <span class="text-[11px] font-bold text-slate-600 whitespace-nowrap flex items-center gap-1">
                            <i class="fas fa-edit text-amber-500"></i> Other / Manual Subjects:
                        </span>
                        <input type="text" name="manual_tuition_subjects" value="{{ old('manual_tuition_subjects') }}" placeholder="Type other subjects here (e.g. Sanskrit, French, Coding...)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                </div>

                {{-- Classes --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Classes You Can Teach <span class="text-red-500">*</span></label>
                    @php
                        $modalClassList = ['Pre-Primary', 'Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12', 'IIT-JEE', 'NEET', 'Olympiad', 'Competitive / Olympiad', 'Languages / Hobby'];
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
                    <div class="mt-2.5 pt-2 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <span class="text-[11px] font-bold text-slate-600 whitespace-nowrap flex items-center gap-1">
                            <i class="fas fa-edit text-blue-500"></i> Other Classes / Exams:
                        </span>
                        <input type="text" name="manual_classes" value="{{ old('manual_classes') }}" placeholder="Type other classes / exams (e.g. NDA, CUET, Commerce Foundation...)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Teaching Mode <span class="text-red-500">*</span></label>
                        <select name="teaching_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="Offline">Offline (Student's Home)</option>
                            <option value="Online">Online (Zoom / Google Meet)</option>
                            <option value="Both">Both (Offline & Online)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Available Time Slot</label>
                        <select name="available_time_slot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">{{ old('preferred_areas') }}</textarea>
                    <div class="flex flex-wrap gap-1 mt-1.5">
                        @foreach(['Patna', 'Kankarbagh', 'Boring Road', 'Bailey Road', 'Danapur', 'Rajendra Nagar', 'Anisabad'] as $quickArea)
                            <button type="button" @click="appendArea('{{ $quickArea }}', 'modal_both_areas')" class="text-[10px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full cursor-pointer transition-colors">
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
                        <select name="position_applying_for" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
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
                        <select name="b_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="Yes">Yes (Completed)</option>
                            <option value="Pursuing">Pursuing</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">D.El.Ed Status <span class="text-red-500">*</span></label>
                        <select name="d_el_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                            <option value="No">No</option>
                            <option value="Yes">Yes (Completed)</option>
                            <option value="Pursuing">Pursuing</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Current / Last School <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="text" name="last_school_name" placeholder="e.g. DPS / DAV / St. Xavier's High School"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Last Designation / Role <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="text" name="last_designation" placeholder="e.g. PGT Physics / TGT Maths / PRT Teacher"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Last Drawn Monthly Salary (₹) <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="number" name="last_drawn_salary" min="0" placeholder="e.g. 25000 (Current / Last Salary)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1">Expected Monthly Salary (₹) <span class="text-slate-400 font-normal text-[10px] normal-case">(Optional)</span></label>
                        <input type="number" name="expected_salary" min="0" placeholder="e.g. 35000 (Expected Monthly Salary)"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">
                    </div>
                </div>

                {{-- Preferred School Locations --}}
                <div class="bg-indigo-50/70 border border-indigo-200 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                            <i class="fas fa-map-marker-alt text-indigo-500"></i> Preferred School Locations & Address <span class="text-red-500">*</span>
                        </span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="detectLocation()" class="text-xs font-bold text-indigo-800 hover:text-white bg-indigo-100 hover:bg-indigo-600 border border-indigo-300 px-2.5 py-1 rounded-lg cursor-pointer transition-all flex items-center gap-1 shadow-2xs">
                                <i class="fas fa-crosshairs text-[10px]"></i> Use Live GPS
                            </button>
                            <span class="text-[10px] font-bold text-indigo-700 bg-indigo-100/90 px-2.5 py-0.5 rounded-full">Manual Type + Quick Add</span>
                        </div>
                    </div>
                    <input type="hidden" name="latitude" :value="userLat">
                    <input type="hidden" name="longitude" :value="userLng">
                    <textarea name="preferred_locations_manual" id="modal_both_school_manual_address" rows="2"
                              placeholder="Type your address or preferred locations (e.g. Boring Road, Kankarbagh, Patna, Hajipur, Muzaffarpur...)"
                              class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9]">{{ old('preferred_locations_manual') }}</textarea>
                    <div x-show="userLat && userLng" x-cloak class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-indigo-800 bg-white px-2.5 py-1 rounded-lg border border-indigo-300 animate-fade-in">
                        <i class="fas fa-map-pin text-indigo-600"></i>
                        <span>GPS Coordinates Attached (<span x-text="Number(userLat).toFixed(4)"></span>, <span x-text="Number(userLng).toFixed(4)"></span>)</span>
                    </div>
                    <div class="mt-2">
                        <span class="block text-[11px] font-bold text-slate-500 mb-1.5">Quick Add Cities (Click to append):</span>
                        <div class="flex flex-wrap gap-1.5">
                            @php $modalLocs = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Gaya', 'Darbhanga', 'Begusarai', 'Supaul', 'Danapur', 'Ara']; @endphp
                            @foreach($modalLocs as $quickLoc)
                                <button type="button" 
                                        @click="appendArea('{{ $quickLoc }}', 'modal_both_school_manual_address')"
                                        class="text-[11px] font-bold bg-white hover:bg-indigo-100 text-indigo-700 border border-indigo-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors flex items-center gap-1 shadow-2xs">
                                    <i class="fas fa-plus text-[9px]"></i> {{ $quickLoc }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Document Uploads: Resume & Salary Slip --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="bg-slate-50/90 border border-slate-200 rounded-2xl p-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5 flex items-center justify-between">
                            <span>Resume / CV Upload <span class="text-red-500">*</span></span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Mandatory</span>
                        </label>
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" required
                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                        <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5"><i class="fas fa-file-pdf text-rose-500"></i> PDF or DOC format (Max 5MB).</p>
                    </div>

                    <div class="bg-slate-50/90 border border-slate-200 rounded-2xl p-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5 flex items-center justify-between">
                            <span>Latest Salary Slip</span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Optional (Recommended)</span>
                        </label>
                        <input type="file" name="salary_slip" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-teal-600 file:text-white hover:file:bg-teal-700 cursor-pointer">
                        <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5"><i class="fas fa-receipt text-teal-600"></i> PDF, JPG, PNG or DOC (Max 5MB) for quick verification.</p>
                    </div>
                </div>
            </div>

            {{-- Submit Row --}}
            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3 items-center">
                <a href="{{ route('admin.crm.index') }}" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg flex items-center justify-center gap-2 cursor-pointer text-white"
                        style="background-image: linear-gradient(to right, #059669, #047857, #115e59);">
                    <i class="fas fa-check-circle"></i>
                    <span>Register for Both (Dual Profile)</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
