@extends('layouts.admin')

@section('title', 'Edit Candidate Profile')
@section('subtitle', 'Update candidate personal details, qualification, preferences, and documents.')

@section('actions')
    <a href="{{ route('admin.crm.show', $user->id) }}" class="px-5 py-2.5 bg-secondary-bg border border-card-border text-text-main hover:bg-card-bg rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> <span>Back to Profile</span>
    </a>
@endsection

@section('content')
<div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
    <form action="{{ route('admin.crm.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm font-bold shadow-sm">
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

        <!-- Section 1: Account Setup -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-blue-500/10 text-accent-blue flex items-center justify-center font-black text-sm">1</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Account & Contact Information</h3>
                    <p class="text-xs text-text-dark/50">Basic login credentials and contact details.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="Leave blank to keep unchanged"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
            </div>
        </div>

        <!-- Section 2: Personal Details -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center font-black text-sm">2</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Personal Details</h3>
                    <p class="text-xs text-text-dark/50">Gender, birth date, and residential address.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $profile?->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $profile?->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $profile?->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile?->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}" required 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Full Residential Address <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="2" required 
                              class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">{{ old('address', $profile?->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Professional & Teaching Info -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-black text-sm">3</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Qualification & Teaching Preferences</h3>
                    <p class="text-xs text-text-dark/50">For school placements and tuition matching.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Highest Qualification <span class="text-red-500">*</span></label>
                    <select name="highest_qualification_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Qualification</option>
                        @foreach($qualifications as $qual)
                            <option value="{{ $qual->id }}" {{ old('highest_qualification_id', $profile?->highest_qualification_id) == $qual->id ? 'selected' : '' }}>{{ $qual->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Primary Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $profile?->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">School Teaching Category</label>
                    <select name="category_id" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Category (Optional)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $profile?->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Experience (Years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $profile?->experience_years ?? 0) }}" min="0"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred State <span class="text-red-500">*</span></label>
                    <select name="preferred_state_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('preferred_state_id', $profile?->preferred_state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred City <span class="text-red-500">*</span></label>
                    <select name="preferred_city_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('preferred_city_id', $profile?->preferred_city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Current Salary (₹/Month)</label>
                    <input type="text" name="current_salary" value="{{ old('current_salary', $profile?->current_salary) }}" placeholder="e.g. 25,000"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Expected Salary (₹/Month)</label>
                    <input type="text" name="expected_salary" value="{{ old('expected_salary', $profile?->expected_salary) }}" placeholder="e.g. 35,000"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">English Fluency</label>
                    <select name="english_fluency" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Fluency</option>
                        <option value="beginner" {{ old('english_fluency', $profile?->english_fluency) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('english_fluency', $profile?->english_fluency) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="fluent" {{ old('english_fluency', $profile?->english_fluency) == 'fluent' ? 'selected' : '' }}>Fluent</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">School Preference</label>
                    <select name="residential_preference" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Option</option>
                        <option value="day" {{ old('residential_preference', $profile?->residential_preference) == 'day' ? 'selected' : '' }}>Day School</option>
                        <option value="residential" {{ old('residential_preference', $profile?->residential_preference) == 'residential' ? 'selected' : '' }}>Residential / Boarding</option>
                        <option value="both" {{ old('residential_preference', $profile?->residential_preference) == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Availability to Join</label>
                    <input type="text" name="availability_to_join" value="{{ old('availability_to_join', $profile?->availability_to_join) }}" placeholder="e.g. Immediate / 15 Days"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Current School / Coaching</label>
                    <input type="text" name="current_school" value="{{ old('current_school', $profile?->current_school) }}" placeholder="e.g. DPS / Self-employed"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>
            </div>
        </div>

        <!-- Section 4: Document Uploads -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-black text-sm">4</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Document Management</h3>
                    <p class="text-xs text-text-dark/50">Upload or replace candidate files.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                {{-- Resume --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Resume (PDF, DOCX)</span>
                        @if($profile?->resume_path)
                            <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" class="text-accent-blue text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-pdf text-2xl mb-1 text-accent-blue"></i>
                            <p class="file-name-display font-bold">Upload new Resume</p>
                        </div>
                    </div>
                </div>

                {{-- Profile Photo --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Profile Photo (JPG, PNG)</span>
                        @if($profile?->profile_photo_path)
                            <a href="{{ Storage::url($profile->profile_photo_path) }}" target="_blank" class="text-purple-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="profile_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-image text-2xl mb-1 text-purple-500"></i>
                            <p class="file-name-display font-bold">Upload new Photo</p>
                        </div>
                    </div>
                </div>

                {{-- ID Photo --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Government ID Card</span>
                        @if($profile?->live_photo_path)
                            <a href="{{ Storage::url($profile->live_photo_path) }}" target="_blank" class="text-emerald-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="live_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-id-card text-2xl mb-1 text-emerald-500"></i>
                            <p class="file-name-display font-bold">Upload new ID</p>
                        </div>
                    </div>
                </div>

                {{-- Salary Slip --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Salary Slip</span>
                        @if($profile?->salary_slip_path)
                            <a href="{{ Storage::url($profile->salary_slip_path) }}" target="_blank" class="text-amber-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="salary_slip" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-invoice-dollar text-2xl mb-1 text-amber-500"></i>
                            <p class="file-name-display font-bold">Upload new Slip</p>
                        </div>
                    </div>
                </div>

                {{-- Offer Letter --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Offer Letter</span>
                        @if($profile?->offer_letter_path)
                            <a href="{{ Storage::url($profile->offer_letter_path) }}" target="_blank" class="text-sky-600 text-xs hover:underline font-bold">View Current</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="offer_letter" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-contract text-2xl mb-1 text-sky-500"></i>
                            <p class="file-name-display font-bold">Upload new Letter</p>
                        </div>
                    </div>
                </div>

                {{-- Agreement PDF --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5 flex items-center justify-between">
                        <span>Signed Agreement Copy</span>
                        @if($profile?->agreement_pdf_path)
                            <a href="{{ Storage::url($profile->agreement_pdf_path) }}" target="_blank" class="text-emerald-600 text-xs hover:underline font-bold">View Current (PDF)</a>
                        @endif
                    </label>
                    <div class="relative border-2 border-dashed border-emerald-300 bg-emerald-50/20 rounded-2xl p-4 text-center hover:bg-emerald-50/40 transition-colors">
                        <input type="file" name="agreement_pdf" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-emerald-700 text-xs pointer-events-none">
                            <i class="fas fa-file-signature text-2xl mb-1 text-emerald-600"></i>
                            <p class="file-name-display font-bold">Upload new PDF</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-card-border flex flex-col sm:flex-row justify-end items-center gap-3">
            <a href="{{ route('admin.crm.show', $user->id) }}" class="w-full sm:w-auto px-6 py-3 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-dark/70 rounded-xl font-bold text-sm text-center transition-all">
                Cancel
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-accent-blue hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> <span>Update Candidate Profile</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stateSelect = document.querySelector('select[name="preferred_state_id"]');
        const citySelect = document.querySelector('select[name="preferred_city_id"]');
        const currentCityId = '{{ old("preferred_city_id", $profile?->preferred_city_id) }}';

        if (stateSelect && citySelect) {
            stateSelect.addEventListener('change', function() {
                const stateId = this.value;
                citySelect.innerHTML = '<option value="">Loading...</option>';
                
                if (stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Select City</option>';
                            data.forEach(city => {
                                const selected = (city.id == currentCityId) ? 'selected' : '';
                                citySelect.innerHTML += `<option value="${city.id}" ${selected}>${city.name}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching cities:', error);
                            citySelect.innerHTML = '<option value="">Select City</option>';
                        });
                } else {
                    citySelect.innerHTML = '<option value="">Select City</option>';
                }
            });

            if (stateSelect.value && !citySelect.value) {
                stateSelect.dispatchEvent(new Event('change'));
            }
        }

        // File inputs UI
        const fileInputs = document.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const wrapper = this.closest('.file-upload-wrapper');
                const nameDisplay = wrapper.querySelector('.file-name-display');
                const dropZone = this.closest('.border-dashed');
                
                if (this.files && this.files.length > 0) {
                    nameDisplay.textContent = this.files[0].name;
                    nameDisplay.classList.add('text-emerald-600');
                    dropZone.classList.add('border-emerald-500', 'bg-emerald-50/20');
                } else {
                    nameDisplay.textContent = 'Click to upload';
                    nameDisplay.classList.remove('text-emerald-600');
                    dropZone.classList.remove('border-emerald-500', 'bg-emerald-50/20');
                }
            });
        });
    });
</script>
@endpush
@endsection
