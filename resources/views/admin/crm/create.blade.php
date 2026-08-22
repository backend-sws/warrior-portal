@extends('layouts.admin')

@section('title', 'Onboard Candidate')
@section('subtitle', 'Register teacher/tutor candidate profile for School Jobs and Home Tuitions.')

@section('actions')
    <a href="{{ route('admin.crm.index') }}" class="px-5 py-2.5 bg-secondary-bg border border-card-border text-text-main hover:bg-card-bg rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> <span>Back to Candidates</span>
    </a>
@endsection

@section('content')
<div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
    <form action="{{ route('admin.crm.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
        @csrf

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
                    <h3 class="text-base font-black text-text-main">Account & Login Credentials</h3>
                    <p class="text-xs text-text-dark/50">Candidate will use these credentials to log in to their portal.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Rahul Sharma"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. rahul@gmail.com"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Phone / WhatsApp Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="e.g. 9876543210"
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Temporary Password <span class="text-red-500">*</span></label>
                    <input type="text" name="password" value="{{ old('password', 'Warrior@' . rand(100, 999)) }}" required
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main font-mono focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue transition-all">
                </div>
            </div>
        </div>

        <!-- Section 2: Personal Info -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center font-black text-sm">2</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Personal Details</h3>
                    <p class="text-xs text-text-dark/50">Identity and residential address.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Full Residential Address <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="2" required placeholder="House No., Street, Landmark, Area, City, Pin Code"
                              class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">{{ old('address') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Professional & Teaching Info -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-black text-sm">3</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Qualification & Teaching Preferences</h3>
                    <p class="text-xs text-text-dark/50">Applicable for both School Placement and Home Tuition assignments.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Highest Qualification <span class="text-red-500">*</span></label>
                    <select name="highest_qualification_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Qualification</option>
                        @foreach($qualifications as $qual)
                            <option value="{{ $qual->id }}" {{ old('highest_qualification_id') == $qual->id ? 'selected' : '' }}>{{ $qual->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Primary Teaching Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">School Teaching Category</label>
                    <select name="category_id" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Category (Optional)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Teaching Experience (Years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred State <span class="text-red-500">*</span></label>
                    <select name="preferred_state_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('preferred_state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Preferred City <span class="text-red-500">*</span></label>
                    <select name="preferred_city_id" required class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('preferred_city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Current Salary (₹/Month)</label>
                    <input type="text" name="current_salary" value="{{ old('current_salary') }}" placeholder="e.g. 25,000" 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Expected Salary (₹/Month)</label>
                    <input type="text" name="expected_salary" value="{{ old('expected_salary') }}" placeholder="e.g. 35,000" 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">English Fluency</label>
                    <select name="english_fluency" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Fluency</option>
                        <option value="beginner" {{ old('english_fluency') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('english_fluency') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="fluent" {{ old('english_fluency') == 'fluent' ? 'selected' : '' }}>Fluent</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">School Preference</label>
                    <select name="residential_preference" class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        <option value="">Select Option</option>
                        <option value="day" {{ old('residential_preference') == 'day' ? 'selected' : '' }}>Day School</option>
                        <option value="residential" {{ old('residential_preference') == 'residential' ? 'selected' : '' }}>Residential / Boarding</option>
                        <option value="both" {{ old('residential_preference') == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Availability to Join</label>
                    <input type="text" name="availability_to_join" value="{{ old('availability_to_join') }}" placeholder="e.g. Immediate / 15 Days" 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Current School / Coaching</label>
                    <input type="text" name="current_school" value="{{ old('current_school') }}" placeholder="e.g. DPS / Self-employed" 
                           class="w-full bg-secondary-bg border border-card-border rounded-xl text-sm py-2.5 px-3.5 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                </div>
            </div>
        </div>

        <!-- Section 4: Document Uploads -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-black text-sm">4</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Document Uploads</h3>
                    <p class="text-xs text-text-dark/50">Upload resume, photos, and optional verification documents.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                {{-- Resume --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Resume / CV (PDF, DOCX)</label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-pdf text-2xl mb-1 text-accent-blue"></i>
                            <p class="file-name-display font-bold">Click to upload Resume</p>
                        </div>
                    </div>
                </div>

                {{-- Profile Photo --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Profile Photo (JPG, PNG)</label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="profile_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-image text-2xl mb-1 text-purple-500"></i>
                            <p class="file-name-display font-bold">Click to upload Photo</p>
                        </div>
                    </div>
                </div>

                {{-- ID Photo --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Government ID / Live Photo</label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="live_photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-id-card text-2xl mb-1 text-emerald-500"></i>
                            <p class="file-name-display font-bold">Click to upload ID Card</p>
                        </div>
                    </div>
                </div>

                {{-- Salary Slip --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Latest Salary Slip (Optional)</label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="salary_slip" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-invoice-dollar text-2xl mb-1 text-amber-500"></i>
                            <p class="file-name-display font-bold">Click to upload Slip</p>
                        </div>
                    </div>
                </div>

                {{-- Offer Letter --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Offer Letter / Relieving (Optional)</label>
                    <div class="relative border-2 border-dashed border-card-border rounded-2xl p-4 text-center hover:bg-secondary-bg transition-colors">
                        <input type="file" name="offer_letter" accept=".pdf,image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-text-dark/60 text-xs pointer-events-none">
                            <i class="fas fa-file-contract text-2xl mb-1 text-sky-500"></i>
                            <p class="file-name-display font-bold">Click to upload Letter</p>
                        </div>
                    </div>
                </div>

                {{-- Signed Agreement PDF --}}
                <div class="file-upload-wrapper">
                    <label class="block text-xs font-bold text-text-dark/70 uppercase mb-1.5">Signed Agreement Copy (PDF)</label>
                    <div class="relative border-2 border-dashed border-emerald-300 bg-emerald-50/20 rounded-2xl p-4 text-center hover:bg-emerald-50/40 transition-colors">
                        <input type="file" name="agreement_pdf" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer file-input">
                        <div class="text-emerald-700 text-xs pointer-events-none">
                            <i class="fas fa-file-signature text-2xl mb-1 text-emerald-600"></i>
                            <p class="file-name-display font-bold">Click to upload Signed PDF</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Service Ready & Agreement Status -->
        <div>
            <div class="flex items-center gap-3 border-b border-card-border pb-3 mb-5">
                <div class="w-8 h-8 rounded-xl bg-teal-500/10 text-teal-600 flex items-center justify-center font-black text-sm">5</div>
                <div>
                    <h3 class="text-base font-black text-text-main">Agreements & Initial Service Setup</h3>
                    <p class="text-xs text-text-dark/50">Candidates do not buy plans. They sign service agreements and pay upon placement.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-secondary-bg p-6 rounded-2xl border border-card-border mb-6">
                <div>
                    <h4 class="text-xs font-bold uppercase text-text-dark/60 tracking-wider mb-3">Digital Agreements Pre-Authorization</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 bg-card-bg rounded-xl border border-card-border cursor-pointer hover:border-accent-blue/50 transition-colors">
                            <input type="checkbox" name="is_agreement_signed" value="1" {{ old('is_agreement_signed') ? 'checked' : '' }} class="w-4 h-4 text-accent-blue rounded border-card-border focus:ring-accent-blue">
                            <div>
                                <p class="text-xs font-bold text-text-main">Mark School Job Agreement as Signed</p>
                                <p class="text-[10px] text-text-dark/50">Allows candidate to apply for all verified school jobs immediately.</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 bg-card-bg rounded-xl border border-card-border cursor-pointer hover:border-emerald-500/50 transition-colors">
                            <input type="checkbox" name="is_tuition_agreement_signed" value="1" {{ old('is_tuition_agreement_signed') ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded border-card-border focus:ring-emerald-500">
                            <div>
                                <p class="text-xs font-bold text-text-main">Mark Home Tuition Agreement as Signed</p>
                                <p class="text-[10px] text-text-dark/50">Allows candidate to apply for home tuition assignments immediately.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase text-text-dark/60 tracking-wider mb-3">Optional Initial Verification / Reg Fee</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Payment Mode</label>
                            <select name="payment_method" class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                                <option value="">None / Free Onboarding</option>
                                <option value="CASH" {{ old('payment_method') == 'CASH' ? 'selected' : '' }}>Cash</option>
                                <option value="ONLINE_TRANSFER" {{ old('payment_method') == 'ONLINE_TRANSFER' ? 'selected' : '' }}>Online Transfer (UPI/NEFT)</option>
                                <option value="CHEQUE" {{ old('payment_method') == 'CHEQUE' ? 'selected' : '' }}>Cheque</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Amount Collected (₹)</label>
                            <input type="number" name="payment_amount" value="{{ old('payment_amount', 0) }}" min="0" placeholder="0" 
                                   class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold text-text-dark/60 uppercase mb-1">Payment Reference / Notes</label>
                            <input type="text" name="payment_notes" value="{{ old('payment_notes') }}" placeholder="e.g. Free onboarding / GPay UTR 12345..." 
                                   class="w-full bg-card-bg border border-card-border rounded-xl text-xs py-2 px-3 text-text-main focus:ring-2 focus:ring-accent-blue/30 focus:border-accent-blue">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-card-border flex flex-col sm:flex-row justify-end items-center gap-3">
            <a href="{{ route('admin.crm.index') }}" class="w-full sm:w-auto px-6 py-3 bg-secondary-bg hover:bg-card-bg border border-card-border text-text-dark/70 rounded-xl font-bold text-sm text-center transition-all">
                Cancel
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-accent-blue hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-check-circle"></i> <span>Complete Candidate Registration</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stateSelect = document.querySelector('select[name="preferred_state_id"]');
        const citySelect = document.querySelector('select[name="preferred_city_id"]');
        const oldCityId = '{{ old("preferred_city_id") }}';

        if (stateSelect && citySelect) {
            stateSelect.addEventListener('change', function() {
                const stateId = this.value;
                citySelect.innerHTML = '<option value="">Loading cities...</option>';
                
                if (stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Select City</option>';
                            data.forEach(city => {
                                const isSelected = (city.id == oldCityId) ? 'selected' : '';
                                citySelect.innerHTML += `<option value="${city.id}" ${isSelected}>${city.name}</option>`;
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

        // File upload label UI updater
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
