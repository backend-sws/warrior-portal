@extends('layouts.app')

@section('title', 'Dual Registration: Home Tutor & School Teacher | Warriors Educare')
@section('meta_description', 'Register for both Home Tuitions and School Teaching vacancies with a single dual account. Unlock private home tuition leads and faculty jobs in top schools.')

@section('content')
<div class="bg-[#f8fafc] text-slate-900 py-8 sm:py-12" x-data="bothCandidatesForm()">

    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        {{-- Hero Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-50 border border-purple-200 text-purple-800 text-xs font-extrabold uppercase tracking-wider mb-3 shadow-2xs">
                <i class="fas fa-layer-group text-sm text-purple-600"></i> Dual Profile (Home Tutor + School Teacher)
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#031b4e] tracking-tight">
                Dual Teacher Registration
            </h1>
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto mt-2">
                Get the best of both worlds with a single registration! Apply for faculty vacancies in top schools and teach private home tuitions in your preferred localities.
            </p>

            {{-- Quick Switcher Cards --}}
            <div class="mt-5 flex flex-wrap items-center justify-center gap-2">
                <span class="text-xs font-bold text-slate-400">Prefer a single category?</span>
                <a href="{{ route('apply.home-tutor') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 bg-sky-50 border border-sky-200 hover:border-sky-300 px-3 py-1 rounded-full transition-all shadow-2xs">
                    🏡 Home Tutor Only
                </a>
                <a href="{{ route('apply.school-teacher') }}" class="text-xs font-bold text-amber-700 hover:text-amber-900 bg-amber-50 border border-amber-200 hover:border-amber-300 px-3 py-1 rounded-full transition-all shadow-2xs">
                    🏫 School Teaching Only
                </a>
            </div>
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

            <form @submit.prevent="submitForm($event)" enctype="multipart/form-data" class="p-6 sm:p-8 lg:p-10 space-y-8">
                @csrf
                <input type="hidden" name="candidate_category" value="both">
                <input type="hidden" name="latitude" x-model="userLat">
                <input type="hidden" name="longitude" x-model="userLng">

                {{-- Section 1: Account & Personal Info --}}
                <div>
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-5">
                        <div class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center font-black text-sm">1</div>
                        <div>
                            <h2 class="text-base font-black text-[#031b4e]">Personal & Account Details</h2>
                            <p class="text-xs text-slate-500">Your profile credentials and direct contact info.</p>
                        </div>
                        <span class="text-[10px] font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200 ml-auto">Common Details</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="name" required minlength="3" maxlength="80" pattern="^[a-zA-Z\s\.\,\'\-]+$" placeholder="e.g. Ramesh Kumar"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['name']" x-text="fieldErrors['name'] ? fieldErrors['name'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" x-model="email" required placeholder="e.g. rahul@example.com"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['email']" x-text="fieldErrors['email'] ? fieldErrors['email'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Calling Mobile Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" x-model="phone" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" placeholder="e.g. 9876543210"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['phone']" x-text="fieldErrors['phone'] ? fieldErrors['phone'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                WhatsApp Number <span class="text-slate-400 font-normal lowercase text-[11px]">(Optional / Can be different)</span>
                            </label>
                            <input type="tel" name="whatsapp_no" x-model="whatsapp_no" minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" placeholder="e.g. 9876543210"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['whatsapp_no']" x-text="fieldErrors['whatsapp_no'] ? fieldErrors['whatsapp_no'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" x-model="password" required minlength="8" placeholder="•••••••• (Min 8 chars)"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['password']" x-text="fieldErrors['password'] ? fieldErrors['password'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" x-model="password_confirmation" required minlength="8" placeholder="Re-enter password"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Gender <span class="text-red-500">*</span></label>
                            <select data-no-search="true" name="gender" x-model="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <span x-show="fieldErrors['gender']" x-text="fieldErrors['gender'] ? fieldErrors['gender'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                            <input type="date" name="date_of_birth" x-model="date_of_birth" required max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['date_of_birth']" x-text="fieldErrors['date_of_birth'] ? fieldErrors['date_of_birth'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        {{-- Highest Qualification: MANUAL INPUT --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Highest Qualification <span class="text-red-500">*</span></label>
                            <input type="text" name="highest_qualification" required maxlength="100" placeholder="e.g. B.Tech, M.Sc, B.Ed, M.A, BCA..."
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['highest_qualification']" x-text="fieldErrors['highest_qualification'] ? fieldErrors['highest_qualification'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>

                        {{-- Total Teaching Experience: MANUAL INPUT WITH SUGGESTIONS --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Total Teaching Experience <span class="text-red-500">*</span></label>
                            <input type="text" name="experience_range" list="both_exp_suggestions" required placeholder="e.g. Fresher / 2 Years / 3.5 Years / 5+ Years"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                            <span x-show="fieldErrors['experience_range']" x-text="fieldErrors['experience_range'] ? fieldErrors['experience_range'][0] : ''" class="text-rose-500 text-[11px] font-bold mt-1 block"></span>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Home Tuition Preferences (Part A: Tuition Profile) --}}
                <div class="pt-4 border-t border-slate-100 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center font-black text-sm">2</div>
                        <div>
                            <h2 class="text-base font-black text-[#031b4e]">Home Tuition Preferences</h2>
                            <p class="text-xs text-slate-500">Subjects, classes, time slots, and locality coverage for home tutoring.</p>
                        </div>
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200 ml-auto">Part A: Tuition Profile</span>
                    </div>

                    {{-- Tuition Subjects Card --}}
                    <div class="bg-amber-50/80 border border-amber-200 rounded-2xl p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-black text-amber-900 uppercase tracking-wide flex items-center gap-1.5">
                                <i class="fas fa-book-open text-amber-600"></i> Tuition Subjects Interested <span class="text-red-500">*</span>
                            </span>
                            <button type="button" @click="toggleAllTuitionSubjects()" class="text-xs font-bold text-amber-800 bg-white border border-amber-300 hover:bg-amber-100 px-3 py-1 rounded-lg transition-colors cursor-pointer">
                                <span x-text="selectedTuitionSubjects.includes('All Subjects') ? 'Deselect All' : 'Select All'"></span>
                            </button>
                        </div>
                        @php 
                            $bothTuitionSubs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
                        @endphp
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($bothTuitionSubs as $subj)
                                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold cursor-pointer transition-all select-none"
                                       :class="selectedTuitionSubjects.includes('{{ $subj }}') ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-amber-400'">
                                    <input type="checkbox" name="tuition_subjects[]" value="{{ $subj }}"
                                           :checked="selectedTuitionSubjects.includes('{{ $subj }}')"
                                           @change="toggleTuitionSubject('{{ $subj }}')" class="sr-only">
                                    <i class="fas fa-check text-[9px]" x-show="selectedTuitionSubjects.includes('{{ $subj }}')"></i>
                                    <span>{{ $subj }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="mt-3 pt-2.5 border-t border-amber-200/80 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <span class="text-[11px] font-bold text-amber-900 whitespace-nowrap flex items-center gap-1">
                                <i class="fas fa-edit text-amber-600"></i> Other / Manual Subjects:
                            </span>
                            <input type="text" name="manual_tuition_subjects" placeholder="Type other subjects here (e.g. Sanskrit, French, Coding...)"
                                   class="w-full bg-white border border-amber-300 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400">
                        </div>
                    </div>

                    {{-- Classes Card --}}
                    <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-4 sm:p-5">
                        <span class="text-xs font-black text-blue-900 uppercase tracking-wide flex items-center gap-1.5 mb-3">
                            <i class="fas fa-chalkboard-teacher text-blue-600"></i> Classes You Can Teach <span class="text-red-500">*</span>
                        </span>
                        @php 
                            $bothClassList = ['Pre-Primary', 'Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12', 'IIT-JEE', 'NEET', 'Olympiad', 'Competitive / Olympiad', 'Languages / Hobby'];
                        @endphp
                        <div class="flex flex-wrap gap-2">
                            @foreach($bothClassList as $cls)
                                <label class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border text-xs font-semibold cursor-pointer transition-all select-none"
                                       :class="selectedClasses.includes('{{ $cls }}') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-blue-400'">
                                    <input type="checkbox" name="classes_interested[]" value="{{ $cls }}"
                                           :checked="selectedClasses.includes('{{ $cls }}')"
                                           @change="toggleSelectedClass('{{ $cls }}')" class="sr-only">
                                    <i class="fas fa-check text-[9px]" x-show="selectedClasses.includes('{{ $cls }}')"></i>
                                    <span>{{ $cls }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="mt-3 pt-2.5 border-t border-blue-200/80 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <span class="text-[11px] font-bold text-blue-900 whitespace-nowrap flex items-center gap-1">
                                <i class="fas fa-edit text-blue-600"></i> Other Classes / Exams:
                            </span>
                            <input type="text" name="manual_classes" placeholder="Type other classes / exams (e.g. NDA, CUET, Commerce Foundation...)"
                                   class="w-full bg-white border border-blue-300 rounded-xl px-3.5 py-1.5 text-xs text-[#031b4e] font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400/40 focus:border-blue-400">
                        </div>
                    </div>

                    {{-- Teaching Mode & Time Slot --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Teaching Mode <span class="text-red-500">*</span></label>
                            <select data-no-search="true" name="teaching_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                                <option value="Offline">Offline (Student's Home)</option>
                                <option value="Online">Online (Zoom / Google Meet)</option>
                                <option value="Both" selected>Both (Offline & Online)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Available Time Slot</label>
                            <select data-no-search="true" name="available_time_slot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all">
                                <option value="Flexible / Any Time">Flexible / Any Time</option>
                                <option value="Morning (6 AM - 10 AM)">Morning (6 AM - 10 AM)</option>
                                <option value="Afternoon (12 PM - 4 PM)">Afternoon (12 PM - 4 PM)</option>
                                <option value="Evening (4 PM - 8 PM)">Evening (4 PM - 8 PM)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Preferred Areas Card (MANUAL TEXTAREA WITH QUICK BUTTONS & LIVE GPS) --}}
                    <div class="bg-emerald-50/80 border border-emerald-200 rounded-2xl p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-black text-emerald-900 uppercase tracking-wide flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-emerald-600"></i> Preferred Home Tuition Localities / Areas <span class="text-red-500">*</span>
                            </span>
                            <button type="button" @click="detectLocation(false)" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 bg-white hover:bg-emerald-100 px-3 py-1 rounded-lg border border-emerald-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-location-crosshairs text-[11px] text-emerald-600" :class="locating ? 'animate-spin' : ''"></i> Use Live GPS
                            </button>
                        </div>
                        <textarea name="preferred_areas" id="both_areas" rows="2" required placeholder="e.g. Kankarbagh, Boring Road, Bailey Road, Rajendra Nagar, Anisabad, Danapur..."
                                  class="w-full bg-white border border-emerald-200 rounded-xl px-3.5 py-2.5 text-sm text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-emerald-400/40 focus:border-emerald-400"></textarea>
                        <div class="mt-2" x-show="userLat && userLng" x-cloak>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 border border-emerald-300 text-emerald-800 text-[11px] font-bold">
                                <i class="fas fa-check-circle text-emerald-600"></i> Live GPS Attached (<span x-text="Number(userLat).toFixed(4)"></span>, <span x-text="Number(userLng).toFixed(4)"></span>)
                            </span>
                        </div>
                        <div class="mt-2.5 pt-2 border-t border-emerald-200/70">
                            <span class="block text-[10px] font-bold text-slate-500 mb-1.5">Quick Add Localities (Click to append):</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(['Patna', 'Kankarbagh', 'Boring Road', 'Bailey Road', 'Danapur', 'Rajendra Nagar', 'Anisabad', 'Ashiana Nagar', 'Raja Bazar', 'Saguna More'] as $quickArea)
                                    <button type="button" @click="appendArea('{{ $quickArea }}', 'both_areas')"
                                            class="text-xs font-bold bg-white hover:bg-emerald-100 text-emerald-800 border border-emerald-300 px-2.5 py-1 rounded-lg cursor-pointer transition-colors shadow-2xs">
                                        + {{ $quickArea }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 3: School Teaching Profile (Part B: School Profile) --}}
                <div class="pt-4 border-t border-slate-100 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-sm">3</div>
                        <div>
                            <h2 class="text-base font-black text-[#031b4e]">School Teaching Profile</h2>
                            <p class="text-xs text-slate-500">Post applying for, qualifications, experience, and school locations.</p>
                        </div>
                        <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200 ml-auto">Part B: School Profile</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Teaching Post Applying For <span class="text-red-500">*</span></label>
                            <select data-no-search="true" name="position_applying_for" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
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
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subject Specialization <span class="text-red-500">*</span></label>
                            <input type="text" name="subject_specialization" required placeholder="e.g. Mathematics, Physics, Chemistry, English, Social Studies..."
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">B.Ed Degree Status <span class="text-red-500">*</span></label>
                            <select data-no-search="true" name="b_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                                <option value="Yes">Yes (Completed)</option>
                                <option value="Pursuing">Pursuing</option>
                                <option value="No" selected>No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">D.El.Ed Degree Status <span class="text-red-500">*</span></label>
                            <select data-no-search="true" name="d_el_ed_status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                                <option value="No" selected>No</option>
                                <option value="Yes">Yes (Completed)</option>
                                <option value="Pursuing">Pursuing</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Current / Last School <span class="text-slate-400 font-normal lowercase text-[11px]">(Optional)</span></label>
                            <input type="text" name="last_school_name" placeholder="e.g. DPS / DAV / St. Xavier's High School"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Last Designation / Role <span class="text-slate-400 font-normal lowercase text-[11px]">(Optional)</span></label>
                            <input type="text" name="last_designation" placeholder="e.g. PGT Physics / TGT Maths / PRT Teacher"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Last Drawn Monthly Salary (₹) <span class="text-slate-400 font-normal lowercase text-[11px]">(Optional)</span></label>
                            <input type="number" name="last_drawn_salary" min="0" placeholder="e.g. 25000"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Expected Monthly Salary (₹) <span class="text-slate-400 font-normal lowercase text-[11px]">(Optional)</span></label>
                            <input type="number" name="expected_salary" min="0" placeholder="e.g. 35000"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all">
                        </div>
                    </div>

                    {{-- Preferred School Locations & Address --}}
                    <div class="bg-indigo-50/80 border border-indigo-200 rounded-2xl p-4 sm:p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-indigo-900 uppercase tracking-wide flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-indigo-600"></i> Preferred School Locations & Address <span class="text-red-500">*</span>
                            </span>
                            <span class="text-[10px] font-bold text-indigo-700 bg-white border border-indigo-200 px-2.5 py-0.5 rounded-full">Selective + Manual</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Select Preferred City / Region</label>
                                <select data-no-search="true" @change="
                                    if ($event.target.value === 'Other') {
                                        let el = document.getElementById('both_school_manual_address');
                                        if (el) { el.focus(); }
                                    } else if ($event.target.value) {
                                        appendArea($event.target.value, 'both_school_manual_address');
                                    }
                                " class="w-full bg-white border border-indigo-200 rounded-xl px-3.5 py-2.5 text-xs text-[#031b4e] font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-500">
                                    <option value="">-- Choose City / Region --</option>
                                    @php $bothSchoolCities = ['Patna', 'Hajipur', 'Muzaffarpur', 'Gaya', 'Bhagalpur', 'Darbhanga', 'Begusarai', 'Supaul', 'Purnea', 'Ara', 'Danapur', 'Ranchi', 'Delhi-NCR', 'Pan-India']; @endphp
                                    @foreach($bothSchoolCities as $cOpt)
                                        <option value="{{ $cOpt }}">{{ $cOpt }}</option>
                                    @endforeach
                                    <option value="Other">Other (Type Custom Location Below)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Manual Address / Places <span class="text-red-500">*</span></label>
                                <textarea name="preferred_locations_manual" id="both_school_manual_address" rows="2" required
                                          placeholder="Type your address or preferred locations (e.g. Boring Road, Kankarbagh, Patna, Hajipur, Muzaffarpur...)"
                                          class="w-full bg-white border border-indigo-200 rounded-xl px-3.5 py-2 text-xs text-[#031b4e] font-medium focus:outline-none focus:ring-2 focus:ring-indigo-400/40 focus:border-indigo-500"></textarea>
                            </div>
                        </div>

                        <div>
                            <span class="block text-[10px] font-bold text-slate-500 mb-1">Quick Add Cities (Click to append):</span>
                            <div class="flex flex-wrap gap-1.5">
                                @php $bothQuickLocs = ['Patna', 'Hajipur', 'Muzaffarpur', 'Bhagalpur', 'Gaya', 'Darbhanga', 'Begusarai', 'Supaul', 'Danapur', 'Ara']; @endphp
                                @foreach($bothQuickLocs as $quickLoc)
                                    <button type="button" @click="appendArea('{{ $quickLoc }}', 'both_school_manual_address')"
                                            class="text-xs font-bold bg-white hover:bg-indigo-100 text-indigo-700 border border-indigo-300 px-2.5 py-0.5 rounded-lg cursor-pointer transition-colors flex items-center gap-1 shadow-2xs">
                                        <i class="fas fa-plus text-[8px]"></i> {{ $quickLoc }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 4: Document Uploads --}}
                <div class="pt-4 border-t border-slate-100 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-slate-800 text-white flex items-center justify-center font-black text-sm">4</div>
                        <div>
                            <h2 class="text-base font-black text-[#031b4e]">Document Uploads</h2>
                            <p class="text-xs text-slate-500">Upload your resume and latest salary slip for verified matching.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5 flex items-center justify-between">
                                <span>Resume / CV Upload <span class="text-red-500">*</span></span>
                                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">Mandatory</span>
                            </label>
                            <input type="file" name="resume" required accept=".pdf,.doc,.docx"
                                   class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                            <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5">
                                <i class="fas fa-file-pdf text-rose-500"></i> PDF or DOC format (Max 5MB).
                            </p>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5 flex items-center justify-between">
                                <span>Latest Salary Slip</span>
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Optional</span>
                            </label>
                            <input type="file" name="salary_slip" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                   class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                            <p class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5">
                                <i class="fas fa-receipt text-emerald-600"></i> PDF, JPG, PNG or DOC (Max 5MB).
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Agreement & Submit Button --}}
                <div class="pt-4 border-t border-slate-100 space-y-4">
                    <label class="flex items-start gap-3 cursor-pointer select-none">
                        <input type="checkbox" required checked class="mt-1 w-4 h-4 rounded text-purple-600 focus:ring-purple-500 border-slate-300">
                        <span class="text-xs text-slate-600">
                            I agree to the <a href="#" class="text-purple-600 underline font-bold">Terms & Conditions</a> of Warriors Educare. I verify that the teaching credentials provided are genuine.
                        </span>
                    </label>

                    <button type="submit" :disabled="submitting"
                            class="w-full py-4 rounded-2xl bg-[#031b4e] hover:bg-[#021338] text-white text-base font-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                        <span x-show="!submitting" class="flex items-center justify-center gap-2 text-white font-bold">
                            <i class="fas fa-paper-plane text-white text-sm"></i>
                            <span>Register Dual Teacher Profile & Send OTP</span>
                        </span>
                        <span x-show="submitting" x-cloak class="flex items-center justify-center gap-2 text-white font-bold">
                            <i class="fas fa-spinner animate-spin text-white"></i>
                            <span>Registering Dual Profile...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Datalist for Manual Experience Suggestions --}}
    <datalist id="both_exp_suggestions">
        <option value="Fresher (0 Years)">
        <option value="1 Year">
        <option value="2 Years">
        <option value="3 Years">
        <option value="3.5 Years">
        <option value="4 Years">
        <option value="5 Years">
        <option value="5+ Years">
        <option value="7+ Years">
        <option value="10+ Years">
        <option value="15+ Years">
    </datalist>
</div>

<script>
function bothCandidatesForm() {
    return {
        submitting: false,
        successMessage: '',
        errorMessage: '',
        fieldErrors: {},
        name: @json(old('name', '')),
        email: @json(old('email', '')),
        phone: @json(old('phone', '')),
        whatsapp_no: @json(old('whatsapp_no', '')),
        password: '',
        password_confirmation: '',
        gender: '',
        date_of_birth: '',
        selectedTuitionSubjects: ['All Subjects'],
        selectedClasses: ['Class 1-5', 'Class 6-8', 'Class 9-10'],
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

        toggleTuitionSubject(subj) {
            if (subj === 'All Subjects') {
                const allSubjs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
                if (this.selectedTuitionSubjects.includes('All Subjects')) {
                    this.selectedTuitionSubjects = [];
                } else {
                    this.selectedTuitionSubjects = allSubjs;
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
            const allSubjs = ['Pre-Primary', 'All Subjects', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology', 'English', 'Hindi', 'SST', 'Computer', 'Spoken English', 'Accounts', 'Economics', 'Business Studies'];
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

        appendArea(area, inputId) {
            const el = document.getElementById(inputId);
            if (el) {
                let current = el.value.trim();
                if (current.length > 0 && !current.includes(area)) {
                    el.value = current + ', ' + area;
                } else if (current.length === 0) {
                    el.value = area;
                }
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
                const response = await fetch('{{ route('candidate.register.post') }}', {
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
                    this.successMessage = data.message || 'Registration successful! Redirecting to your dual dashboard...';
                    setTimeout(() => {
                        window.location.href = '{{ route('candidate.dashboard') }}';
                    }, 1500);
                } else {
                    if (response.status === 419) {
                        this.errorMessage = 'Your session has expired. Please refresh the page (F5) and submit again.';
                    } else if (data.errors && typeof data.errors === 'object' && Object.keys(data.errors).length > 0) {
                        this.fieldErrors = data.errors;
                        this.errorMessage = data.message || 'Please correct the highlighted errors below.';
                    } else if (data.message) {
                        this.errorMessage = data.message;
                    } else {
                        this.errorMessage = 'Something went wrong. Please check your details and try again.';
                    }
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } catch (err) {
                console.error('Dual candidate form error:', err);
                this.errorMessage = 'Network connection issue. Please check your internet and try again.';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } finally {
                this.submitting = false;
            }
        }
    };
}
</script>
@endsection
