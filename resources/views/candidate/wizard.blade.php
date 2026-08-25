@extends('layouts.app')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="min-h-[85vh] bg-[#f4f7f5] py-12 px-4 sm:px-6 lg:px-8 relative" x-data="registrationWizard()">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#0ea5e9]/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-accent-yellow/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Header -->
        <div class="text-center mb-10 reveal">
            <h1 class="text-3xl md:text-4xl font-bold text-[#031b4e] mb-3">Complete Your Registration</h1>
            <p class="text-[#031b4e]/70 text-sm md:text-base max-w-xl mx-auto">Follow these simple steps to complete your profile and activate your candidate account.</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-10 reveal reveal-delay-1">
            <div class="flex justify-between mb-2">
                <template x-for="(s, index) in steps" :key="index">
                    <div class="text-center w-1/3 relative z-10">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300"
                            :class="[
                                step > index + 1 ? 'bg-green-500 border-green-500 text-white' : '',
                                step === index + 1 ? 'bg-[#0ea5e9] border-[#0ea5e9] text-white shadow-[0_0_15px_rgba(18,154,239,0.5)]' : '',
                                step < index + 1 ? 'bg-white border-[#031b4e]/10 text-[#031b4e]/60' : ''
                            ]">
                            <i x-show="step > index + 1" class="fas fa-check"></i>
                            <span x-show="step <= index + 1" x-text="index + 1"></span>
                        </div>
                        <div class="mt-3 text-xs font-semibold tracking-wider uppercase transition-colors duration-300"
                            :class="step >= index + 1 ? 'text-[#031b4e]' : 'text-[#031b4e]/60'"
                            x-text="s"></div>
                    </div>
                </template>
            </div>
            <!-- Connecting Line -->
            <div class="relative w-full h-1 bg-card-border rounded-full -mt-[3.25rem] z-0 mx-auto" style="width: 66%;">
                <div class="absolute top-0 left-0 h-full bg-[#0ea5e9] rounded-full transition-all duration-500 ease-out"
                    :style="'width: ' + ((step - 1) / (steps.length - 1) * 100) + '%'"></div>
            </div>
        </div>

        <!-- Forms Container -->
        <div class="bg-white/80 backdrop-blur-xl border border-[#031b4e]/10 rounded-3xl shadow-2xl overflow-hidden reveal reveal-delay-2 relative">
            
            <!-- Loading Overlay -->
            <div x-show="loading" class="absolute inset-0 z-50 bg-white/80 backdrop-blur-sm flex flex-col items-center justify-center" x-transition>
                <div class="w-10 h-10 border-4 border-[#0ea5e9] border-t-transparent rounded-full animate-spin"></div>
                <p class="mt-4 text-sm font-semibold text-[#031b4e] animate-pulse" x-text="loadingMessage"></p>
            </div>

            <!-- Error Message -->
            <div x-show="error" class="bg-red-500/10 border-l-4 border-red-500 p-4 mb-4 mx-8 mt-8 rounded-r-xl" x-transition>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-400 font-medium" x-text="error"></p>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10">
                <!-- STEP 1: Profile Details -->
                <div x-show="step === 1" x-transition.opacity.duration.500ms>
                    <h2 class="text-2xl font-bold text-[#031b4e] mb-6 flex items-center gap-3">
                        <i class="fas fa-user-edit text-[#0ea5e9]"></i> Profile Details
                    </h2>
                    
                    <form id="step1Form" @submit.prevent="submitStep1" novalidate>
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Date of Birth *</label>
                                <div class="relative">
                                    <input type="text" x-model="formData.date_of_birth" required
                                        x-init="flatpickr($el, { dateFormat: 'Y-m-d', maxDate: 'today' })"
                                        placeholder="YYYY-MM-DD"
                                        class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                <template x-if="fieldErrors.date_of_birth"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.date_of_birth[0]"></p></template>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#031b4e]/50">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Gender *</label>
                                <select x-model="formData.gender" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <template x-if="fieldErrors.gender"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.gender[0]"></p></template>
                            </div>

                            <!-- Profile Photo -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Profile Photo (Optional)</label>
                                <input type="file" accept="image/*" @change="handleProfilePhotoUpload"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-2 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0ea5e9] file:text-white hover:file:bg-[#0ea5e9]-hover cursor-pointer">
                                <template x-if="fieldErrors.profile_photo"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.profile_photo[0]"></p></template>
                                <p class="text-xs text-[#031b4e]/60 mt-1">Format: JPG, PNG. Max size: 2MB.</p>
                                <div x-show="profilePhotoPreview" class="mt-3">
                                    <img :src="profilePhotoPreview" class="h-20 w-20 object-cover rounded-full border-2 border-[#0ea5e9] shadow-lg">
                                </div>
                            </div>

                            <!-- Resume Upload (Required) -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Resume / CV *</label>
                                <input type="file" accept=".pdf,.doc,.docx" @change="handleResumeUpload" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-2 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0ea5e9] file:text-white hover:file:bg-[#0ea5e9]-hover cursor-pointer">
                                <template x-if="fieldErrors.resume"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.resume[0]"></p></template>
                                <p class="text-xs text-[#031b4e]/60 mt-1">Format: PDF, DOC, DOCX. Max size: 2MB.</p>
                            </div>

                            <!-- Salary Slip (Optional) -->
                            <div class="md:col-span-1">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Salary Slip (Optional)</label>
                                <input type="file" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg" @change="handleSalarySlipUpload"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-2 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0ea5e9] file:text-white hover:file:bg-[#0ea5e9]-hover cursor-pointer">
                                <template x-if="fieldErrors.salary_slip"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.salary_slip[0]"></p></template>
                            </div>

                            <!-- Offer Letter (Optional) -->
                            <div class="md:col-span-1">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Offer Letter (Optional)</label>
                                <input type="file" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg" @change="handleOfferLetterUpload"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-2 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0ea5e9] file:text-white hover:file:bg-[#0ea5e9]-hover cursor-pointer">
                                <template x-if="fieldErrors.offer_letter"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.offer_letter[0]"></p></template>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Full Address *</label>
                                <textarea x-model="formData.address" required rows="2"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all"
                                    placeholder="Enter your complete address"></textarea>
                                <template x-if="fieldErrors.address"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.address[0]"></p></template>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Position Applied For *</label>
                                <select x-model="formData.category_id" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <template x-if="fieldErrors.category_id"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.category_id[0]"></p></template>
                            </div>

                            <!-- Subject -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Subject *</label>
                                <select x-model="formData.subject_id" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Subject</option>
                                    <template x-for="subject in availableSubjects" :key="subject.id">
                                        <option :value="subject.id" x-text="subject.name" :selected="formData.subject_id == subject.id"></option>
                                    </template>
                                </select>
                                <template x-if="fieldErrors.subject_id"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.subject_id[0]"></p></template>
                            </div>

                            <!-- Specialization -->
                            <div x-show="availableSpecializations.length > 0">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Specialization *</label>
                                <select x-model="formData.specialization_id" :required="availableSpecializations.length > 0"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Specialization</option>
                                    <template x-for="spec in availableSpecializations" :key="spec.id">
                                        <option :value="spec.id" x-text="spec.name" :selected="formData.specialization_id == spec.id"></option>
                                    </template>
                                </select>
                                <template x-if="fieldErrors.specialization_id"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.specialization_id[0]"></p></template>
                            </div>

                            <!-- Qualification -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Highest Qualification *</label>
                                <select x-model="formData.highest_qualification_id" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Qualification</option>
                                    @foreach($qualifications as $qualification)
                                        <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                    @endforeach
                                </select>
                                <template x-if="fieldErrors.highest_qualification_id"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.highest_qualification_id[0]"></p></template>
                            </div>

                            <!-- Experience -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Experience (Years) *</label>
                                <input type="number" x-model="formData.experience_years" min="0" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                <template x-if="fieldErrors.experience_years"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.experience_years[0]"></p></template>
                            </div>

                            <!-- State Preference -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Preferred State *</label>
                                <select x-model="formData.preferred_state_id" @change="fetchCities(formData.preferred_state_id)" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                <template x-if="fieldErrors.preferred_state_id"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.preferred_state_id[0]"></p></template>
                            </div>
                            
                            <!-- City Preference -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Preferred City *</label>
                                <select x-model="formData.preferred_city_id" required
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select City</option>
                                    <template x-for="city in availableCities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                                <template x-if="fieldErrors.preferred_city_id"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.preferred_city_id[0]"></p></template>
                            </div>

                            <!-- Current School (Optional) -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Current School (Optional)</label>
                                <input type="text" x-model="formData.current_school" placeholder="E.g., DPS Patna"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                <template x-if="fieldErrors.current_school"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.current_school[0]"></p></template>
                            </div>

                            <!-- English Fluency -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">English Fluency (Optional)</label>
                                <select x-model="formData.english_fluency"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Fluency</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="fluent">Fluent/Advanced</option>
                                </select>
                                <template x-if="fieldErrors.english_fluency"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.english_fluency[0]"></p></template>
                            </div>

                            <!-- Residential Preference -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">School Type Preference (Optional)</label>
                                <select x-model="formData.residential_preference"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                    <option value="">Select Preference</option>
                                    <option value="day">Day School</option>
                                    <option value="residential">Residential/Boarding School</option>
                                    <option value="both">Both</option>
                                </select>
                                <template x-if="fieldErrors.residential_preference"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.residential_preference[0]"></p></template>
                            </div>

                            <!-- Salaries (Optional) -->
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Current Salary (Optional)</label>
                                <input type="text" x-model="formData.current_salary" placeholder="E.g., ₹25,000/month"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                <template x-if="fieldErrors.current_salary"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.current_salary[0]"></p></template>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Expected Salary (Optional)</label>
                                <input type="text" x-model="formData.expected_salary" placeholder="E.g., ₹35,000/month"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                <template x-if="fieldErrors.expected_salary"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.expected_salary[0]"></p></template>
                            </div>
                            
                            <!-- Availability -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Availability to Join (Optional)</label>
                                <input type="text" x-model="formData.availability_to_join" placeholder="E.g., Immediate, 15 Days, 1 Month"
                                    class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                                <template x-if="fieldErrors.availability_to_join"><p class="text-red-500 text-xs mt-1 font-medium" x-text="fieldErrors.availability_to_join[0]"></p></template>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <button type="button" @click="window.location.href = '{{ route('candidate.dashboard') }}'" class="text-[#031b4e]/80 font-semibold hover:text-[#0ea5e9] px-4 py-3 transition-colors">
                                Skip for now
                            </button>
                            <button type="submit" class="bg-[#0ea5e9] text-white px-8 py-3 rounded-xl font-semibold shadow-glow-blue hover:bg-[#0ea5e9]-hover transition-all hover:-translate-y-0.5 flex items-center gap-2">
                                Next Step <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEP 2: Agreement -->
                <div x-show="step === 2" x-transition.opacity.duration.500ms style="display: none;">
                    <h2 class="text-2xl font-bold text-[#031b4e] mb-6 flex items-center gap-3">
                        <i class="fas fa-file-contract text-[#0ea5e9]"></i> Agreement
                    </h2>

                    <!-- Terms Box -->
                    <div class="bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl p-6 mb-6 h-64 overflow-y-auto text-sm text-[#031b4e]/80 custom-scrollbar">
                        <div class="text-center mb-6">
                            <h3 class="text-base font-black text-[#031b4e]">WARRIORS EDUCARE</h3>
                            <h4 class="font-bold text-sm text-[#0ea5e9] tracking-wider uppercase">TEACHER PLACEMENT SERVICE AGREEMENT</h4>
                            <p class="text-xs text-slate-500 mt-1">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Teacher").</p>
                        </div>

                        <div class="space-y-4 text-slate-700">
                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">1. Purpose of Agreement</h5>
                                <p>This Agreement confirms that the Candidate willingly authorizes Warriors Educare to begin the recruitment and placement process for suitable teaching opportunities.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">2. Candidate Declaration</h5>
                                <p class="mb-1">The Candidate declares that:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>All information and documents submitted are true and genuine.</li>
                                    <li>Any false information or forged document may result in immediate cancellation of registration and placement without any refund.</li>
                                    <li>The Candidate agrees to cooperate throughout the recruitment process.</li>
                                </ul>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">3. Document Verification</h5>
                                <p class="mb-1">The Candidate shall provide all required documents, including but not limited to:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Aadhaar Card</li>
                                    <li>Salary slip / Account statement</li>
                                    <li>Passport-size Photograph</li>
                                    <li>Any other document required by the school/institution or Warriors Educare.</li>
                                </ul>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">4. Registration Charges</h5>
                                <p class="mb-1">The Candidate agrees to pay a non-refundable Registration Fee of ₹1,000, payable as follows:</p>
                                <ul class="list-disc pl-5 space-y-1 mb-2">
                                    <li><strong>₹500</strong> at the time of registration to initiate the recruitment process.</li>
                                    <li><strong>₹500</strong> immediately after selection by the school/Institution and before joining.</li>
                                </ul>
                                <p class="mb-2 text-xs text-slate-600">Registration fees are charged for profile verification, documentation, screening, interview coordination and placement services. These charges are non-refundable.</p>
                                <p class="text-xs bg-blue-50 p-2.5 rounded-lg border border-blue-100 text-blue-950">
                                    <strong>Registration Validity:</strong> The registration shall remain valid for 8 (Eight) months from the date of registration. During this period, Warriors Educare will make reasonable efforts to arrange up to 4–5 suitable interviews, subject to the Candidate's qualifications, preferred location, salary expectations and the availability of vacancies. The registration is non-transferable and non-refundable. After the expiry of the validity period, a fresh registration and the applicable registration fee may be required to continue placement services.
                                </p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">5. Placement Service Charge</h5>
                                <p>After joining the school/Institution and receiving the first month's salary/payment, the Candidate agrees to pay <strong>50% of the first month's gross salary (equivalent to 15 days' salary)</strong> to Warriors Educare as the Placement Service Charge.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">6. Payment Timeline & Delay Charges</h5>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>The Placement Service Charge must be paid <strong>within 12 hours</strong> of receiving the first salary/payment from the school/Institution.</li>
                                    <li>If payment is not made within the prescribed time, a <strong>Late Payment Penalty of ₹300 per day</strong> shall be applicable until full payment is received.</li>
                                    <li>Warriors Educare reserves the right to suspend future placement services until all dues are cleared.</li>
                                </ul>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">7. Job Placement</h5>
                                <p>Warriors Educare provides recruitment and placement assistance only. Final selection, salary, benefits, probation, working conditions and employment terms shall be decided solely by the respective school/Institution.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">8. Joining Commitment</h5>
                                <p>If the Candidate accepts the offer and confirms joining, they shall not refuse or leave before joining without a genuine reason and prior written/intimated notice to Warriors Educare.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">9. Professional Conduct</h5>
                                <p>The Candidate shall maintain professionalism, honesty, discipline and comply with all school policies. Any misconduct, indiscipline or fraudulent activity may result in blacklisting from Warriors Educare.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">10. Confidentiality</h5>
                                <p>The Candidate shall not disclose confidential information relating to Warriors Educare, the recruiting school or students to any third party.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">11. No Job Guarantee</h5>
                                <p>Registration with Warriors Educare does not guarantee job placement. Selection depends entirely on the school's/Institution's requirements, interview performance and candidate eligibility.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">12. Employment Relationship</h5>
                                <p>The Candidate understands that employment shall be with the respective school only. Warriors Educare acts solely as a recruitment and placement agency and shall not be responsible for salary, PF, ESI, leave, incentives or any employment benefits unless otherwise agreed in writing.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">13. Default & Legal Action</h5>
                                <p>In case the Candidate intentionally avoids payment of the agreed Placement Service Charge or violates this Agreement, Warriors Educare reserves the right to recover the outstanding amount along with applicable late charges and to initiate appropriate legal proceedings under the applicable laws of India. Any dispute arising out of this Agreement shall be subject to the jurisdiction of the competent courts.</p>
                            </div>

                            <div>
                                <h5 class="font-bold text-[#031b4e] mb-1">14. Acceptance of Terms</h5>
                                <p class="mb-1">By signing this Agreement physically or digitally, the Candidate confirms that:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>They have carefully read and understood all the terms and conditions.</li>
                                    <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
                                    <li>They agree to comply with all payment obligations and conditions mentioned herein.</li>
                                </ul>
                            </div>
                        </div>

                        <hr class="my-6 border-[#031b4e]/10">

                        <h4 class="font-bold text-[#031b4e] mb-4 text-center mt-6">HOME TUITION – TUTOR SERVICE AGREEMENT</h4>
                        
                        <p class="mb-4">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Tutor").</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">1. Purpose of Agreement</h5>
                        <p class="mb-4">This Agreement confirms that the Candidate voluntarily authorizes Warriors Educare to provide home tuition opportunities and to begin the tutor placement process.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">2. Candidate Declaration</h5>
                        <p class="mb-2">The Candidate declares that:</p>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>All information and documents provided are true and genuine.</li>
                            <li>Any false information or forged documents may result in immediate cancellation of registration without any refund.</li>
                            <li>The Candidate agrees to cooperate throughout the recruitment and placement process.</li>
                            <li>The Candidate agrees to maintain professionalism while interacting with parents, students and Warriors Educare.</li>
                        </ul>

                        <h5 class="font-bold text-[#031b4e] mb-2">3. Registration Fee</h5>
                        <p class="mb-2">The Candidate agrees to pay a Registration Fee as follows:</p>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>₹500 – Junior Classes (Up to Class V)</li>
                            <li>₹600 – Senior Classes (Up to Class XII)</li>
                        </ul>
                        <p class="mb-4">Registration is mandatory before receiving any tuition lead, demo class or placement opportunity.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">4. Registration Validity</h5>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>Registration shall remain valid for 1 (One) Year from the date of registration.</li>
                            <li>During the validity period, Warriors Educare will make reasonable efforts to provide up to 4 confirmed tuition leads, subject to the Candidate's qualifications, preferred location, subject availability and parents' requirements.</li>
                            <li>Registration is non-transferable.</li>
                        </ul>

                        <h5 class="font-bold text-[#031b4e] mb-2">5. Registration Refund Policy</h5>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>If a parent cancels or declines a demo class and Warriors Educare is unable to provide another suitable confirmed tuition lead within 25 working days, the Candidate shall be eligible for a 100% refund of the Registration Fee.</li>
                            <li>The refund process shall commence only after the completion of 25 working days from the date of the cancelled demo.</li>
                        </ul>

                        <h5 class="font-bold text-[#031b4e] mb-2">6. Registration Cancellation</h5>
                        <p class="mb-4">If the Candidate receives three (3) consecutive demo rejections due to candidate-related reasons, Warriors Educare reserves the right to cancel the registration without any refund.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">7. Service Charge</h5>
                        <p class="mb-3">After successfully joining the tuition and receiving the first month's tuition fee/payment, the Candidate agrees to pay <strong>50% of the first month's tuition fee (equivalent to 15 days' tuition fee)</strong> to Warriors Educare as the Service Charge.</p>

                        <div class="bg-blue-50/80 p-3 rounded-xl border border-blue-200/70 space-y-1 text-xs text-slate-800 mb-4">
                            <h6 class="font-bold text-[#031b4e]">Service Charge for Hourly Tuition Assignments</h6>
                            <p>For tuition assignments that are conducted on an hourly or per-class basis, the Candidate (Teacher) shall pay Warriors Educare a one-time service charge equivalent to <strong>50% of the total classes allotted for one month</strong>.</p>
                            <p class="text-slate-600"><em>Example:</em> If a tuition assignment is allotted for 12 classes per month (such as IIT-JEE, NEET, or other hourly coaching), the Candidate must pay the service charge equivalent to 6 classes.</p>
                            <p class="font-semibold text-[#031b4e]">This service charge is mandatory and remains payable irrespective of the actual number of classes conducted during the first month. Even if the Candidate teaches fewer than the allotted monthly classes, the full agreed service charge shall remain applicable.</p>
                        </div>

                        <h5 class="font-bold text-[#031b4e] mb-2">8. Payment Timeline & Delay Charges</h5>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>The Service Charge must be paid <strong>within 12 hours</strong> of receiving the first month's tuition fee/payment.</li>
                            <li>Failure to make payment within the prescribed time shall attract a <strong>Late Payment Penalty of ₹200 per day</strong> until the outstanding amount is fully cleared.</li>
                        </ul>

                        <h5 class="font-bold text-[#031b4e] mb-2">9. Tutor Responsibilities</h5>
                        <p class="mb-2">The Candidate shall:</p>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>Maintain honesty, discipline and professionalism.</li>
                            <li>Reach tuition on time.</li>
                            <li>Behave respectfully with parents and students.</li>
                            <li>Follow all commitments made during the placement process.</li>
                        </ul>
                        <p class="mb-4">Any misconduct or unprofessional behaviour may result in cancellation of registration and future services.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">10. Confidentiality</h5>
                        <p class="mb-4">The Candidate shall keep confidential all information relating to Warriors Educare, parents and students and shall not disclose such information to any third party without prior written permission.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">11. No Tuition Guarantee</h5>
                        <p class="mb-4">Registration with Warriors Educare does not guarantee tuition opportunity. Selection depends entirely on the parents' requirements, the Candidate's qualifications, demo performance and overall suitability.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">12. Default & Legal Action</h5>
                        <p class="mb-4">In case the Candidate intentionally avoids payment of the agreed Service Charge or violates any terms of this Agreement, Warriors Educare reserves the right to recover the outstanding amount along with applicable late charges and initiate appropriate legal proceedings under the applicable laws of India. Any dispute arising from this Agreement shall be subject to the jurisdiction of the competent courts.</p>

                        <h5 class="font-bold text-[#031b4e] mb-2">13. Acceptance of Terms</h5>
                        <p class="mb-2">By signing this Agreement physically or digitally, the Candidate confirms that:</p>
                        <ul class="list-disc pl-5 mb-4 space-y-2">
                            <li>They have carefully read and understood all the terms and conditions.</li>
                            <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
                            <li>They agree to comply with all payment obligations and conditions mentioned herein.</li>
                        </ul>
                        
                        <p class="mt-6 font-semibold">By clicking Accept & Continue, I acknowledge and accept all these terms and conditions.</p>
                    </div>

                    <div class="mb-6 flex items-center gap-3 bg-[#0ea5e9]/5 p-4 rounded-xl border border-[#0ea5e9]/20 cursor-pointer" @click="agreed = !agreed">
                        <div class="w-6 h-6 rounded-md border-2 border-[#0ea5e9] flex items-center justify-center transition-colors"
                            :class="agreed ? 'bg-[#0ea5e9] text-white' : 'bg-transparent text-transparent'">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="text-sm font-semibold text-[#031b4e] select-none">I have read and agree to the Terms & Conditions of Warriors Educare.</span>
                    </div>

                    <!-- Signature Options moved to step 3 -->

                    <div class="mt-8 flex justify-between">
                        <button type="button" @click="step = 1" class="px-6 py-3 rounded-xl font-semibold text-[#031b4e]/80 hover:bg-card-border transition-colors flex items-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Back
                        </button>
                        <button type="button" @click="submitStep2" class="bg-[#0ea5e9] text-white px-8 py-3 rounded-xl font-semibold shadow-glow-blue hover:bg-[#0ea5e9]-hover transition-all hover:-translate-y-0.5 flex items-center gap-2" :disabled="!agreed" :class="!agreed ? 'opacity-50 cursor-not-allowed' : ''">
                            Accept & Continue <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Identity Verification -->
                <div x-show="step === 3" x-transition.opacity.duration.500ms style="display: none;" x-init="$watch('step', value => { if(value === 3 && !latitude) getLocation(); })">
                    <h2 class="text-2xl font-bold text-[#031b4e] mb-6 flex items-center gap-3">
                        <i class="fas fa-user-check text-[#0ea5e9]"></i> Identity Verification
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Live Photo Section -->
                        <div class="border border-[#031b4e]/10 rounded-2xl p-6 bg-[#f4f7f5] relative">
                            <h3 class="font-bold text-[#031b4e] mb-4 flex items-center gap-2"><i class="fas fa-camera text-[#0ea5e9]"></i> Live Photo</h3>
                            
                            <div x-show="!livePhotoBase64" class="w-full aspect-video light-metallic-blue-card rounded-xl overflow-hidden relative border-0">
                                <video id="cameraFeed" class="w-full h-full object-cover" autoplay playsinline muted></video>
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 gap-3" x-show="!isCameraOn">
                                    <button @click="startCamera" class="bg-[#0ea5e9] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#0ea5e9]-hover transition-colors shadow-lg"><i class="fas fa-camera"></i> Start Camera</button>
                                    <span class="text-xs text-[#031b4e]/60 font-medium">OR</span>
                                    <label class="bg-[#f4f7f5] text-[#031b4e] border border-[#031b4e]/10 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-card-border transition-colors cursor-pointer shadow-sm">
                                        <i class="fas fa-upload"></i> Upload Photo
                                        <input type="file" class="hidden" accept="image/*" @change="handleLivePhotoUpload">
                                    </label>
                                </div>
                            </div>

                            <div x-show="livePhotoBase64" class="w-full aspect-video light-metallic-blue-card rounded-xl overflow-hidden border-0 relative">
                                <img :src="livePhotoBase64" class="w-full h-full object-cover" />
                                <button @click="livePhotoBase64 = null; startCamera()" class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-600 transition-colors"><i class="fas fa-redo"></i></button>
                            </div>

                            <div class="mt-4 flex justify-center" x-show="isCameraOn && !livePhotoBase64">
                                <button @click="takePhoto" class="bg-green-500 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-green-600 transition-colors shadow-lg flex items-center gap-2"><i class="fas fa-camera"></i> Capture Photo</button>
                            </div>
                            <p x-show="cameraError" class="text-red-500 text-xs mt-2 text-center" x-text="cameraError"></p>
                        </div>

                        <!-- Location & Signature Section -->
                        <div class="flex flex-col gap-6">
                            <!-- Location -->
                            <div class="border border-[#031b4e]/10 rounded-2xl p-6 bg-[#f4f7f5]">
                                <h3 class="font-bold text-[#031b4e] mb-4 flex items-center gap-2"><i class="fas fa-map-marker-alt text-[#0ea5e9]"></i> Location</h3>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" :class="latitude ? 'bg-green-500/20 text-green-500' : 'bg-red-500/20 text-red-500'">
                                        <i class="fas" :class="latitude ? 'fa-check' : 'fa-times'"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#031b4e]" x-text="latitude ? 'Location Captured' : 'Location Required'"></p>
                                        <p class="text-xs text-[#031b4e]/70" x-text="latitude ? latitude.toFixed(4) + ', ' + longitude.toFixed(4) : 'Please allow location access'"></p>
                                    </div>
                                    <button x-show="!latitude" @click="getLocation" class="ml-auto bg-white border border-[#031b4e]/10 text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-card-border transition-colors">Retry</button>
                                </div>
                                <p x-show="locationError" class="text-red-500 text-xs mt-2" x-text="locationError"></p>
                            </div>

                            <!-- Signature Options -->
                            <div class="border border-[#031b4e]/10 rounded-2xl overflow-hidden flex-1 flex flex-col">
                                <div class="flex border-b border-[#031b4e]/10 bg-[#f4f7f5]">
                                    <button type="button" @click="sigType = 'draw'; initSignaturePad()" class="flex-1 py-3 text-sm font-semibold transition-colors" :class="sigType === 'draw' ? 'text-[#0ea5e9] bg-white border-b-2 border-[#0ea5e9]' : 'text-[#031b4e]/70 hover:bg-white/50'">Draw</button>
                                    <button type="button" @click="sigType = 'type'" class="flex-1 py-3 text-sm font-semibold transition-colors" :class="sigType === 'type' ? 'text-[#0ea5e9] bg-white border-b-2 border-[#0ea5e9]' : 'text-[#031b4e]/70 hover:bg-white/50'">Type</button>
                                    <button type="button" @click="sigType = 'upload'" class="flex-1 py-3 text-sm font-semibold transition-colors" :class="sigType === 'upload' ? 'text-[#0ea5e9] bg-white border-b-2 border-[#0ea5e9]' : 'text-[#031b4e]/70 hover:bg-white/50'">Upload</button>
                                </div>

                                <div class="p-4 bg-white flex-1">
                                    <!-- Draw Pad -->
                                    <div x-show="sigType === 'draw'" class="h-full flex flex-col">
                                        <div class="border-2 border-dashed border-[#031b4e]/10 rounded-xl bg-white relative flex-1">
                                            <canvas id="signature-pad" class="w-full h-full min-h-[120px] rounded-xl cursor-crosshair touch-none"></canvas>
                                            <button type="button" @click="clearSignature" class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500/20 transition-colors" title="Clear">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Type Name -->
                                    <div x-show="sigType === 'type'" style="display: none;" class="h-full flex items-center">
                                        <input type="text" x-model="typedSignature" placeholder="Type full name"
                                            class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-4 text-xl text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all"
                                            style="font-family: 'Playfair Display', cursive; font-style: italic;">
                                    </div>

                                    <!-- Upload Image -->
                                    <div x-show="sigType === 'upload'" style="display: none;" class="h-full">
                                        <label class="w-full h-full min-h-[120px] flex flex-col items-center justify-center border-2 border-dashed border-[#031b4e]/10 rounded-xl bg-[#f4f7f5] hover:bg-card-border/30 transition-colors cursor-pointer relative overflow-hidden">
                                            <div class="flex flex-col items-center justify-center py-4" x-show="!uploadedImagePreview">
                                                <i class="fas fa-upload text-2xl text-[#0ea5e9] mb-2"></i>
                                                <p class="text-xs text-[#031b4e]/70">Click to upload signature</p>
                                            </div>
                                            <img x-show="uploadedImagePreview" :src="uploadedImagePreview" class="absolute inset-0 w-full h-full object-contain bg-white p-2" />
                                            <input type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" @change="handleFileUpload" x-ref="sigFileInput" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <button type="button" @click="step = 2" class="px-6 py-3 rounded-xl font-semibold text-[#031b4e]/80 hover:bg-card-border transition-colors flex items-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Back
                        </button>
                        <button type="button" @click="submitStep3" class="bg-[#0ea5e9] text-white px-8 py-3 rounded-xl font-semibold shadow-glow-blue hover:bg-[#0ea5e9]-hover transition-all hover:-translate-y-0.5 flex items-center gap-2">
                            Verify Identity <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 4: Plan & Payment -->
                <div x-show="step === 4" x-transition.opacity.duration.500ms style="display: none;">
                    <h2 class="text-2xl font-bold text-[#031b4e] mb-6 flex items-center gap-3">
                        <i class="fas fa-credit-card text-[#0ea5e9]"></i> Choose Registration Plan
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Standard Plan -->
                        <div class="border-2 rounded-2xl p-6 cursor-pointer transition-all duration-300 relative"
                            :class="selectedPlan === 'standard' ? 'border-[#0ea5e9] bg-[#0ea5e9]/5 shadow-glow-blue' : 'border-[#031b4e]/10 hover:border-[#0ea5e9]/50 bg-[#f4f7f5]'"
                            @click="selectedPlan = 'standard'">
                            
                            <div class="absolute top-4 right-4 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                :class="selectedPlan === 'standard' ? 'border-[#0ea5e9]' : 'border-text-dark/30'">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#0ea5e9] transition-transform" :class="selectedPlan === 'standard' ? 'scale-100' : 'scale-0'"></div>
                            </div>

                            <h3 class="text-xl font-bold text-[#031b4e] mb-1">Standard Plan</h3>
                            <div class="text-2xl font-bold text-[#0ea5e9] mb-4">₹500 <span class="text-sm font-normal text-[#031b4e]/60">Initially</span></div>
                            
                            <ul class="space-y-3 text-sm text-[#031b4e]/80">
                                <li class="flex gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Profile Activation</li>
                                <li class="flex gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Resume Verification</li>
                                <li class="flex gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Dashboard Access</li>
                                <li class="flex gap-2 text-[#031b4e]/60"><i class="fas fa-info-circle mt-1"></i> Final ₹500 required later</li>
                            </ul>
                        </div>

                        <!-- Premium Plan -->
                        <div class="border-2 rounded-2xl p-6 cursor-pointer transition-all duration-300 relative overflow-hidden"
                            :class="selectedPlan === 'premium' ? 'border-accent-yellow bg-accent-yellow/5 shadow-glow-yellow' : 'border-[#031b4e]/10 hover:border-accent-yellow/50 bg-[#f4f7f5]'"
                            @click="selectedPlan = 'premium'">
                            
                            <div class="absolute top-0 right-0 bg-accent-yellow text-[#031b4e] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-bl-lg">Recommended</div>

                            <div class="absolute top-4 right-4 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors"
                                :class="selectedPlan === 'premium' ? 'border-accent-yellow' : 'border-text-dark/30'">
                                <div class="w-2.5 h-2.5 rounded-full bg-accent-yellow transition-transform" :class="selectedPlan === 'premium' ? 'scale-100' : 'scale-0'"></div>
                            </div>

                            <h3 class="text-xl font-bold text-[#031b4e] mb-1">Premium Plan</h3>
                            <div class="text-2xl font-bold text-accent-yellow mb-4">₹1000 <span class="text-sm font-normal text-[#031b4e]/60">One-Time</span></div>
                            
                            <ul class="space-y-3 text-sm text-[#031b4e]/80">
                                <li class="flex gap-2 font-semibold text-accent-yellow"><i class="fas fa-star mt-1"></i> Priority Shortlisting</li>
                                <li class="flex gap-2 font-semibold text-accent-yellow"><i class="fas fa-rocket mt-1"></i> Faster Interview Coordination</li>
                                <li class="flex gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Dedicated Support</li>
                                <li class="flex gap-2"><i class="fas fa-check text-green-500 mt-1"></i> Premium Badge</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center pt-6 border-t border-[#031b4e]/10">
                        <button type="button" @click="step = 3" class="px-6 py-3 rounded-xl font-semibold text-[#031b4e]/80 hover:bg-card-border transition-colors flex items-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Back
                        </button>
                        
                        <div class="flex items-center gap-4">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs text-[#031b4e]/60 uppercase tracking-wider font-semibold">Total to Pay</p>
                                <p class="text-xl font-bold text-[#031b4e]" x-text="selectedPlan === 'premium' ? '₹1000' : '₹500'"></p>
                            </div>
                            <button type="button" @click="submitPayment" class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white px-8 py-3.5 rounded-xl font-semibold shadow-lg hover:brightness-110 transition-all hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer">
                                <span>Pay via PhonePe / UPI</span> <i class="fas fa-shield-alt text-xs text-purple-200"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('registrationWizard', () => ({
            step: 1,
            steps: ['Profile', 'Agreement', 'Verification', 'Payment'],
            loading: false,
            loadingMessage: '',
            error: '',
            fieldErrors: {},
            
            // Profile Data
            formData: {
                date_of_birth: '{{ $profile->date_of_birth ? $profile->date_of_birth->format("Y-m-d") : "" }}',
                gender: '{{ $profile->gender }}',
                category_id: '{{ $profile->category_id }}',
                subject_id: '{{ $profile->subject_id }}',
                specialization_id: '{{ $profile->specialization_id }}',
                highest_qualification_id: '{{ $profile->highest_qualification_id }}',
                preferred_state_id: '{{ $profile->preferred_state_id }}',
                preferred_city_id: '{{ $profile->preferred_city_id }}',
                experience_years: '{{ $profile->experience_years }}',
                current_salary: '{{ $profile->current_salary }}',
                expected_salary: '{{ $profile->expected_salary }}',
                address: '{{ addslashes($profile->address) }}',
                marital_status: '{{ $profile->marital_status }}',
                religion: '{{ $profile->religion }}',
                english_fluency: '{{ $profile->english_fluency }}',
                residential_preference: '{{ $profile->residential_preference }}',
                availability_to_join: '{{ $profile->availability_to_join }}'
            },

            availableSubjects: {!! json_encode($subjects) !!},
            availableSpecializations: [],
            availableCities: [],

            profilePhotoFile: null,
            profilePhotoPreview: null,

            resumeFile: null,
            salarySlipFile: null,
            offerLetterFile: null,
            
            // Signature & Identity Data
            agreed: false,
            sigType: 'draw',
            signaturePad: null,
            typedSignature: '',
            uploadedImagePreview: null,
            uploadedFile: null,
            
            livePhotoBase64: null,
            latitude: null,
            longitude: null,
            locationError: '',
            cameraError: '',
            stream: null,
            isCameraOn: false,

            // Payment Data
            selectedPlan: 'standard',

            fetchCities(stateId) {
                if(stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(response => response.json())
                        .then(data => {
                            this.availableCities = data;
                            if(!data.find(c => c.id == this.formData.preferred_city_id)) {
                                this.formData.preferred_city_id = '';
                            }
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                } else {
                    this.availableCities = [];
                    this.formData.preferred_city_id = '';
                }
            },

            init() {
                // Determine initial step based on profile status
                const isProfileComplete = {{ $profile->is_profile_complete ? 'true' : 'false' }};
                const isTermsAgreed = {{ $profile->is_terms_agreed ? 'true' : 'false' }};
                const isAgreementSigned = {{ $profile->is_agreement_signed ? 'true' : 'false' }};
                
                if (isProfileComplete && !isTermsAgreed) this.step = 2;
                if (isProfileComplete && isTermsAgreed && !isAgreementSigned) this.step = 3;
                if (isProfileComplete && isTermsAgreed && isAgreementSigned) this.step = 4;

                this.$watch('step', value => {
                    if (value === 3 && this.sigType === 'draw') {
                        setTimeout(() => this.initSignaturePad(), 300);
                    }
                });

                this.$watch('sigType', value => {
                    if (value === 'draw' && this.step === 3) {
                        setTimeout(() => this.initSignaturePad(), 300);
                    }
                });

                this.$watch('formData.category_id', value => {
                    if (value) {
                        fetch(`/api/categories/${value}/subjects`)
                            .then(response => response.json())
                            .then(data => {
                                this.availableSubjects = data;
                                // Reset subject if current subject is not in new list
                                if(!data.find(s => s.id == this.formData.subject_id)) {
                                    this.formData.subject_id = '';
                                }
                            })
                            .catch(error => console.error('Error fetching subjects:', error));
                    } else {
                        this.availableSubjects = [];
                        this.formData.subject_id = '';
                    }
                });

                this.$watch('formData.subject_id', value => {
                    if (value) {
                        fetch(`/api/subjects/${value}/specializations`)
                            .then(response => response.json())
                            .then(data => {
                                this.availableSpecializations = data;
                                if(!data.find(s => s.id == this.formData.specialization_id)) {
                                    this.formData.specialization_id = '';
                                }
                            })
                            .catch(error => console.error('Error fetching specializations:', error));
                    } else {
                        this.availableSpecializations = [];
                        this.formData.specialization_id = '';
                    }
                });
                
                // Initialize subjects if category already selected
                if(this.formData.category_id) {
                    fetch(`/api/categories/${this.formData.category_id}/subjects`)
                        .then(response => response.json())
                        .then(data => {
                            this.availableSubjects = data;
                        });
                }

                // Initialize specializations if subject already selected
                if(this.formData.subject_id) {
                    fetch(`/api/subjects/${this.formData.subject_id}/specializations`)
                        .then(response => response.json())
                        .then(data => {
                            this.availableSpecializations = data;
                        });
                }

                // Initialize cities if state already selected
                if(this.formData.preferred_state_id) {
                    this.fetchCities(this.formData.preferred_state_id);
                }
            },

            async submitStep1() {
                this.error = '';
                this.fieldErrors = {};

                // Client-side validation — check required fields before calling server
                const requiredFields = {
                    'date_of_birth': 'Date of Birth is required.',
                    'gender': 'Gender is required.',
                    'address': 'Address is required.',
                    'category_id': 'Position / Category is required.',
                    'subject_id': 'Subject is required.',
                    'highest_qualification_id': 'Highest Qualification is required.',
                    'preferred_state_id': 'Preferred State is required.',
                    'preferred_city_id': 'Preferred City is required.',
                    'experience_years': 'Experience (Years) is required.'
                };

                let hasError = false;
                for (const [field, message] of Object.entries(requiredFields)) {
                    if (!this.formData[field] || this.formData[field] === '') {
                        this.fieldErrors[field] = [message];
                        hasError = true;
                    }
                }

                // Check resume file
                if (!this.resumeFile) {
                    this.fieldErrors['resume'] = ['Resume / CV is required.'];
                    hasError = true;
                }

                if (hasError) {
                    this.error = 'Please fill in all required fields.';
                    // Scroll to the first error
                    this.$nextTick(() => {
                        const firstError = document.querySelector('.text-red-500');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
                    return;
                }

                this.loadingMessage = 'Saving Profile...';
                this.loading = true;

                try {
                    const fd = new FormData();
                    fd.append('_token', '{{ csrf_token() }}');
                    for (const key in this.formData) {
                        if (this.formData[key] !== null && this.formData[key] !== undefined && this.formData[key] !== '') {
                            fd.append(key, this.formData[key]);
                        }
                    }
                    if (this.profilePhotoFile) {
                        fd.append('profile_photo', this.profilePhotoFile);
                    }
                    if (this.resumeFile) {
                        fd.append('resume', this.resumeFile);
                    }
                    if (this.salarySlipFile) {
                        fd.append('salary_slip', this.salarySlipFile);
                    }
                    if (this.offerLetterFile) {
                        fd.append('offer_letter', this.offerLetterFile);
                    }

                    const response = await fetch('{{ route("candidate.wizard.step1") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: fd
                    });

                    const text = await response.text();
                    let data;
                    try {
                        const jsonStart = text.indexOf('{');
                        const jsonEnd = text.lastIndexOf('}');
                        if (jsonStart !== -1 && jsonEnd !== -1) {
                            data = JSON.parse(text.substring(jsonStart, jsonEnd + 1));
                        } else {
                            throw new Error("No JSON object found");
                        }
                    } catch (parseError) {
                        console.error('Non-JSON response:', text);
                        throw new Error('Server returned an invalid response. Please try again.');
                    }
                    
                    if (response.ok && (data.success || !data.errors)) {
                        this.step = 2;
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    } else if (response.status === 422 || data.errors) {
                        this.fieldErrors = data.errors || {};
                        this.error = 'Please fix the errors below.';
                        this.loading = false;
                        return;
                    } else {
                        this.error = data.message || 'An error occurred on the server.';
                    }
                } catch (e) {
                    console.error("Submit Step 1 Error:", e);
                    this.error = e.message || 'Something went wrong. Please try again.';
                } finally {
                    this.loading = false;
                }
            },

            initSignaturePad() {
                if (this.sigType === 'draw' && !this.signaturePad) {
                    const canvas = document.getElementById('signature-pad');
                    if(canvas) {
                        if (canvas.offsetWidth === 0) {
                            // Retry if it's still hidden by transition
                            setTimeout(() => this.initSignaturePad(), 100);
                            return;
                        }
                        
                        const resizeCanvas = () => {
                            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext("2d").scale(ratio, ratio);
                        };
                        
                        window.addEventListener("resize", resizeCanvas);
                        resizeCanvas();
                        
                        this.signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgb(255, 255, 255)',
                            penColor: 'rgb(0, 0, 0)'
                        });
                    }
                }
            },

            clearSignature() {
                if (this.signaturePad) {
                    this.signaturePad.clear();
                }
            },

            handleFileUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                if (file.size > 2 * 1024 * 1024) {
                    this.error = "Image size must be less than 2MB";
                    return;
                }

                this.uploadedFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.uploadedImagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            handleProfilePhotoUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                if (file.size > 2 * 1024 * 1024) {
                    this.error = "Profile photo size must be less than 2MB";
                    return;
                }

                this.profilePhotoFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.profilePhotoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            handleResumeUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                this.resumeFile = file;
            },

            handleSalarySlipUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                this.salarySlipFile = file;
            },

            handleOfferLetterUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                this.offerLetterFile = file;
            },

            async submitStep2() {
                if (!this.agreed) return;
                this.error = '';
                this.loadingMessage = 'Saving Agreement...';
                this.loading = true;

                try {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('agreed', 1);

                    const response = await fetch('{{ route("candidate.wizard.step2") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    
                    if (response.ok) {
                        this.step = 3;
                    } else {
                        this.error = result.message || 'An error occurred while saving the agreement.';
                    }
                } catch (error) {
                    this.error = 'Network error. Please try again.';
                } finally {
                    this.loading = false;
                }
            },

            async submitStep3() {
                this.error = '';
                
                if (!this.livePhotoBase64) {
                    this.error = 'Please capture a live photo before continuing.';
                    return;
                }

                if (!this.latitude || !this.longitude) {
                    this.error = 'Please share your location before continuing.';
                    return;
                }

                let sigData = '';

                if (this.sigType === 'draw') {
                    if (this.signaturePad.isEmpty()) {
                        this.error = 'Please provide your signature before continuing.';
                        return;
                    }
                    sigData = this.signaturePad.toDataURL();
                } else if (this.sigType === 'type') {
                    if (!this.typedSignature.trim()) {
                        this.error = 'Please type your name as a signature.';
                        return;
                    }
                    sigData = this.typedSignature;
                } else if (this.sigType === 'upload') {
                    if (!this.uploadedImagePreview) {
                        this.error = 'Please upload a signature image.';
                        return;
                    }
                    sigData = this.uploadedImagePreview;
                }

                this.loadingMessage = 'Verifying Identity...';
                this.loading = true;

                try {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('signature_type', this.sigType);
                    
                    if (this.sigType === 'upload' && this.uploadedFile) {
                        formData.append('signature_file', this.uploadedFile);
                        formData.append('signature_data', 'uploaded');
                    } else {
                        formData.append('signature_data', sigData);
                    }
                    
                    formData.append('live_photo', this.livePhotoBase64);
                    formData.append('latitude', this.latitude);
                    formData.append('longitude', this.longitude);

                    const response = await fetch('{{ route("candidate.wizard.step3") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    
                    if (response.ok) {
                        this.step = 4;
                    } else {
                        this.error = result.message || 'An error occurred while verifying identity.';
                    }
                } catch (error) {
                    this.error = 'Network error. Please try again.';
                } finally {
                    this.loading = false;
                }
            },

            startCamera() {
                this.cameraError = '';
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
                        this.stream = stream;
                        const video = document.getElementById('cameraFeed');
                        video.srcObject = stream;
                        video.play();
                        this.isCameraOn = true;
                    }).catch(err => {
                        this.cameraError = "Unable to access camera. Please grant permission.";
                    });
                } else {
                    this.cameraError = "Camera not supported in this browser.";
                }
            },
            
            takePhoto() {
                const video = document.getElementById('cameraFeed');
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth || 640;
                canvas.height = video.videoHeight || 480;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                this.livePhotoBase64 = canvas.toDataURL('image/jpeg');
                this.stopCamera();
            },
            
            stopCamera() {
                if (this.stream) {
                    this.stream.getTracks().forEach(track => track.stop());
                }
                this.isCameraOn = false;
            },

            handleLivePhotoUpload(e) {
                const file = e.target.files[0];
                if (!file) return;
                
                if (file.size > 2 * 1024 * 1024) {
                    this.error = "Photo size must be less than 2MB";
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.livePhotoBase64 = e.target.result;
                };
                reader.readAsDataURL(file);
            async submitPayment() {
                this.error = '';
                this.loadingMessage = 'Connecting to PhonePe Payment Gateway...';
                this.loading = true;

                try {
                    const response = await fetch('{{ route("candidate.wizard.payment") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ plan_type: this.selectedPlan })
                    });

                    const data = await response.json();
                    
                    if (response.ok && data.success && data.order) {
                        const order = data.order;
                        
                        // If PhonePe returned direct redirect URL
                        if (order.redirect_url) {
                            this.loadingMessage = 'Redirecting to PhonePe Secure Pay...';
                            window.location.href = order.redirect_url;
                            return;
                        }

                        // Sandbox or fallback test checkout
                        this.loadingMessage = 'Verifying PhonePe Sandbox Payment...';
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("candidate.wizard.callback") }}';

                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfInput);

                        const orderIdInput = document.createElement('input');
                        orderIdInput.type = 'hidden';
                        orderIdInput.name = 'merchantTransactionId';
                        orderIdInput.value = order.order_id;
                        form.appendChild(orderIdInput);

                        const payIdInput = document.createElement('input');
                        payIdInput.type = 'hidden';
                        payIdInput.name = 'transactionId';
                        payIdInput.value = 'PP_TEST_' + Date.now();
                        form.appendChild(payIdInput);

                        const codeInput = document.createElement('input');
                        codeInput.type = 'hidden';
                        codeInput.name = 'code';
                        codeInput.value = 'PAYMENT_SUCCESS';
                        form.appendChild(codeInput);

                        document.body.appendChild(form);
                        form.submit();
                    } else {
                        this.error = data.message || 'Failed to connect to PhonePe gateway.';
                        this.loading = false;
                    }
                } catch (e) {
                    this.error = 'Something went wrong while connecting to payment gateway.';
                    this.loading = false;
                }
            }
        }));
    });
</script>

<style>
    select option {
        background-color: #0a1e4a;
        color: #ffffff;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.1);
        border-radius: 10px;
    }
</style>
@endsection



