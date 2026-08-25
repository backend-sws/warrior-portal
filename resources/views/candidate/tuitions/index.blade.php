@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')
    
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">
        <div class="mb-5 sm:mb-8">
            <h2 class="text-xl sm:text-2xl font-bold text-[#031b4e]">Available Tuitions</h2>
            <p class="text-xs sm:text-sm text-[#031b4e]/80 mt-1">Find and apply for home tuitions matching your expertise.</p>
        </div>

@if(session('success'))
    <div class="bg-green-50 text-green-700 p-3.5 sm:p-4 rounded-xl border border-green-100 mb-5 sm:mb-6 flex items-center text-xs sm:text-sm">
        <i class="fas fa-check-circle mr-2.5 sm:mr-3 text-sm sm:text-base"></i> {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-50 text-blue-700 p-4 rounded-xl border border-blue-100 mb-6 flex items-center text-xs sm:text-sm">
        <i class="fas fa-info-circle mr-3"></i> {{ session('info') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 mb-6 flex items-center text-xs sm:text-sm">
        <i class="fas fa-exclamation-circle mr-3"></i> {{ session('error') }}
    </div>
@endif

<!-- Tuition Agreement Status Banner -->
@if(!$isAgreementSigned)
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-start gap-3 sm:gap-4">
            <div class="w-11 h-11 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-amber-500/20">
                <i class="fas fa-lock"></i>
            </div>
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-200/60 text-amber-900 text-[11px] font-extrabold uppercase tracking-wider mb-1">
                    Agreement Required to Unlock Tuitions
                </div>
                <h3 class="text-base sm:text-lg font-black text-[#031b4e]">Home Tuition Tutor Service Agreement (Unsigned)</h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Please review and digitally sign the agreement below to unlock application access for all home tuitions.</p>
            </div>
        </div>
        <div class="shrink-0">
            <button onclick="document.getElementById('tuitionAgreementModal').classList.remove('hidden')" class="w-full sm:w-auto px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs sm:text-sm font-extrabold transition-all shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-file-signature"></i> <span>Review & Sign Agreement</span>
            </button>
        </div>
    </div>
@else
    <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 shadow-sm p-4 sm:p-6 mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
        <div class="flex items-start sm:items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center text-lg sm:text-xl shrink-0 mt-0.5 sm:mt-0">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-sm sm:text-base md:text-lg font-bold text-[#031b4e] leading-snug">Home Tuition - Tutor Service Agreement</h3>
                    <span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2.5 py-0.5 rounded-full">Signed ✅</span>
                </div>
                <p class="text-xs sm:text-sm text-[#031b4e]/70 mt-0.5">Signed on {{ \Carbon\Carbon::parse($profile->tuition_agreement_signed_at ?? $profile->signature_date_time ?? now())->format('d M Y, h:i A') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto shrink-0">
            <button onclick="document.getElementById('tuitionAgreementModal').classList.remove('hidden')" class="flex-1 sm:flex-initial px-4 py-2.5 bg-white border border-[#031b4e]/20 text-[#031b4e] rounded-xl text-xs sm:text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                <i class="fas fa-eye text-xs"></i> <span>View Agreement</span>
            </button>
            <button onclick="printTuitionAgreement()" class="flex-1 sm:flex-initial px-4 py-2.5 bg-[#0ea5e9] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-[#0ea5e9]/90 transition-colors shadow-sm flex items-center justify-center gap-1.5 whitespace-nowrap">
                <i class="fas fa-download text-xs"></i> <span>Download PDF</span>
            </button>
        </div>
    </div>
@endif

<!-- Modal for Tuition Agreement (2-Step Mobile-Friendly Signing Wizard) -->
<div id="tuitionAgreementModal" x-data="{ step: 1, isSigned: {{ $isAgreementSigned ? 'true' : 'false' }} }" class="fixed inset-0 z-[9999] hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[92vh] flex flex-col shadow-2xl overflow-hidden relative border border-slate-200">
        
        <!-- Modal Header with Step Navigation -->
        <div class="p-3.5 sm:p-5 border-b border-[#031b4e]/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-[#031b4e] text-white shrink-0">
            <div class="flex items-center justify-between w-full sm:w-auto">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-accent-yellow block">Warriors Educare</span>
                    <h3 class="text-sm sm:text-base md:text-lg font-black">Home Tuition – Tutor Service Agreement</h3>
                </div>
                <button type="button" onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="sm:hidden w-8 h-8 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-white/20">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <!-- Step Switcher Tabs (Shown only if agreement is unsigned) -->
            @if(!$isAgreementSigned)
                <div class="flex items-center gap-1 bg-white/10 p-1 rounded-xl self-start sm:self-auto">
                    <button type="button" @click="step = 1" :class="step === 1 ? 'bg-white text-[#031b4e] font-black shadow-sm' : 'text-white/80 hover:text-white font-bold'" class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 text-xs">
                        <i class="fas fa-file-alt text-xs"></i> <span>Step 1: Read Terms</span>
                    </button>
                    <i class="fas fa-chevron-right text-[10px] text-white/30 px-0.5"></i>
                    <button type="button" @click="step = 2; $nextTick(() => detectAgreementLocation());" :class="step === 2 ? 'bg-emerald-500 text-white font-black shadow-sm' : 'text-white/80 hover:text-white font-bold'" class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 text-xs">
                        <i class="fas fa-camera text-xs"></i> <span>Step 2: Photo & Sign</span>
                    </button>
                </div>
            @endif

            <button type="button" onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="hidden sm:flex w-9 h-9 rounded-full bg-white/10 text-white hover:bg-white/20 items-center justify-center transition-colors shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        
        <!-- STEP 1: FULL AGREEMENT TEXT (Comfortable Reading on Mobile & Desktop) -->
        <div x-show="step === 1 || isSigned" class="relative flex-1 overflow-hidden flex flex-col min-h-0">
            <!-- Centered Watermark Layer (Locked in exact center of modal frame) -->
            <div class="pointer-events-none absolute inset-0 flex items-center justify-center z-0 p-6 overflow-hidden">
                <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" class="w-3/5 max-w-[380px] sm:max-w-[420px] opacity-[0.07] select-none object-contain" alt="Watermark">
            </div>

            <!-- Scrollable Agreement Sheet -->
            <div id="printableTuitionAgreement" class="p-4 sm:p-6 md:p-8 overflow-y-auto custom-scrollbar text-[#031b4e]/80 text-xs sm:text-sm relative z-10 bg-transparent flex-1">
                <!-- Print-Only Watermark -->
                <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" class="hidden print:block watermark-img" alt="Watermark">

                <div class="text-center mb-6 border-b-2 border-[#031b4e] pb-4">
                    <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" alt="Warriors Educare Logo" style="max-height: 80px; margin: 0 auto 10px auto;">
                    <h2 class="text-2xl font-bold text-[#031b4e] mb-1">WARRIORS EDUCARE</h2>
                    <h3 class="text-lg font-semibold text-[#031b4e]">HOME TUITION – TUTOR SERVICE AGREEMENT</h3>
                </div>
            
            @php
                // Photo URL
                $photoUrl = null;
                $photoPath = null;
                if ($profile?->tuition_live_photo_path && Storage::disk('public')->exists($profile->tuition_live_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->tuition_live_photo_path);
                } elseif ($profile?->live_photo_path && Storage::disk('public')->exists($profile->live_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->live_photo_path);
                } elseif ($profile?->profile_photo_path && Storage::disk('public')->exists($profile->profile_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->profile_photo_path);
                } elseif ($profile?->passport_photo_path && Storage::disk('public')->exists($profile->passport_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->passport_photo_path);
                }

                if ($photoPath && file_exists($photoPath)) {
                    $photoData = file_get_contents($photoPath);
                    $mime = mime_content_type($photoPath);
                    $photoUrl = 'data:' . $mime . ';base64,' . base64_encode($photoData);
                }

                $sigMeta = [];
                if ($profile?->tuition_signature_data) {
                    $sigMeta = json_decode($profile->tuition_signature_data, true) ?: [];
                }
            @endphp
            
            <div class="relative z-10">
            
            <!-- Candidate Details & Photo -->
            <div class="bg-gray-50 border border-gray-200 p-3 sm:p-4 mb-4 sm:mb-6 rounded-xl flex flex-col-reverse sm:flex-row justify-between items-start gap-3">
                <div class="space-y-1 text-xs sm:text-sm">
                    <p class="mb-0"><strong>Candidate Name:</strong> {{ auth()->user()->name }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="mb-0"><strong>Phone:</strong> {{ auth()->user()->phone }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $profile?->address ?? 'Not specified' }}</p>
                    @if(!empty($profile?->tuition_location_name) || !empty($sigMeta['location']))
                        <p class="mb-0 text-emerald-700 font-medium"><strong>Signing Location:</strong> 📍 {{ $profile?->tuition_location_name ?? $sigMeta['location'] }}</p>
                    @endif
                </div>
                @if($photoUrl)
                    <div class="shrink-0 self-center sm:self-auto text-center">
                        <img src="{{ $photoUrl }}" alt="Candidate Photo" class="w-16 h-20 sm:w-20 sm:h-24 object-cover border-2 border-emerald-500/50 rounded-lg shadow-sm">
                        <span class="inline-block mt-1 px-1.5 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-bold rounded">
                            {{ ($profile?->tuition_live_photo_path || $profile?->live_photo_path) ? 'Live Photo Verified' : 'Photo' }}
                        </span>
                    </div>
                @endif
            </div>

            <p class="mb-4">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Tutor").</p>

            <div class="space-y-4 text-xs sm:text-sm text-slate-700">
                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">1. Purpose of Agreement</h5>
                    <p>This Agreement confirms that the Candidate voluntarily authorizes Warriors Educare to provide home tuition opportunities and to begin the tutor placement process.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">2. Candidate Declaration</h5>
                    <p class="mb-1">The Candidate declares that:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>All information and documents provided are true and genuine.</li>
                        <li>Any false information or forged documents may result in immediate cancellation of registration without any refund.</li>
                        <li>The Candidate agrees to cooperate throughout the recruitment and placement process.</li>
                        <li>The Candidate agrees to maintain professionalism while interacting with parents, students and Warriors Educare.</li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">3. Registration Fee</h5>
                    <p class="mb-1">The Candidate agrees to pay a Registration Fee as follows:</p>
                    <ul class="list-disc pl-5 space-y-1 mb-1">
                        <li><strong>₹500</strong> – Junior Classes (Up to Class V)</li>
                        <li><strong>₹600</strong> – Senior Classes (Up to Class XII)</li>
                    </ul>
                    <p class="text-xs text-slate-500">Registration is mandatory before receiving any tuition lead, demo class or placement opportunity.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">4. Registration Validity</h5>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Registration shall remain valid for <strong>1 (One) Year</strong> from the date of registration.</li>
                        <li>During the validity period, Warriors Educare will make reasonable efforts to provide up to 4 confirmed tuition leads, subject to the Candidate's qualifications, preferred location, subject availability and parents' requirements.</li>
                        <li>Registration is non-transferable.</li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">5. Registration Refund Policy</h5>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>If a parent cancels or declines a demo class and Warriors Educare is unable to provide another suitable confirmed tuition lead within 25 working days, the Candidate shall be eligible for a <strong>100% refund</strong> of the Registration Fee.</li>
                        <li>The refund process shall commence only after the completion of 25 working days from the date of the cancelled demo.</li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">6. Registration Cancellation</h5>
                    <p>If the Candidate receives three (3) consecutive demo rejections due to candidate-related reasons, Warriors Educare reserves the right to cancel the registration without any refund.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">7. Service Charge</h5>
                    <p class="mb-2">After successfully joining the tuition and receiving the first month's tuition fee/payment, the Candidate agrees to pay <strong>50% of the first month's tuition fee (equivalent to 15 days' tuition fee)</strong> to Warriors Educare as the Service Charge.</p>
                    
                    <div class="bg-blue-50/80 p-3 rounded-xl border border-blue-200/70 space-y-1 text-xs text-slate-800">
                        <h6 class="font-bold text-[#031b4e]">Service Charge for Hourly Tuition Assignments</h6>
                        <p>For tuition assignments that are conducted on an hourly or per-class basis, the Candidate (Teacher) shall pay Warriors Educare a one-time service charge equivalent to <strong>50% of the total classes allotted for one month</strong>.</p>
                        <p class="text-slate-600"><em>Example:</em> If a tuition assignment is allotted for 12 classes per month (such as IIT-JEE, NEET, or other hourly coaching), the Candidate must pay the service charge equivalent to 6 classes.</p>
                        <p class="font-semibold text-[#031b4e]">This service charge is mandatory and remains payable irrespective of the actual number of classes conducted during the first month. Even if the Candidate teaches fewer than the allotted monthly classes, the full agreed service charge shall remain applicable.</p>
                    </div>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">8. Payment Timeline & Delay Charges</h5>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>The Service Charge must be paid <strong>within 12 hours</strong> of receiving the first month's tuition fee/payment.</li>
                        <li>Failure to make payment within the prescribed time shall attract a <strong>Late Payment Penalty of ₹200 per day</strong> until the outstanding amount is fully cleared.</li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">9. Tutor Responsibilities</h5>
                    <p class="mb-1">The Candidate shall:</p>
                    <ul class="list-disc pl-5 space-y-1 mb-1">
                        <li>Maintain honesty, discipline and professionalism.</li>
                        <li>Reach tuition on time.</li>
                        <li>Behave respectfully with parents and students.</li>
                        <li>Follow all commitments made during the placement process.</li>
                    </ul>
                    <p class="text-xs text-slate-500">Any misconduct or unprofessional behaviour may result in cancellation of registration and future services.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">10. Confidentiality</h5>
                    <p>The Candidate shall keep confidential all information relating to Warriors Educare, parents and students and shall not disclose such information to any third party without prior written permission.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">11. No Tuition Guarantee</h5>
                    <p>Registration with Warriors Educare does not guarantee tuition opportunity. Selection depends entirely on the parents' requirements, the Candidate's qualifications, demo performance and overall suitability.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">12. Default & Legal Action</h5>
                    <p>In case the Candidate intentionally avoids payment of the agreed Service Charge or violates any terms of this Agreement, Warriors Educare reserves the right to recover the outstanding amount along with applicable late charges and initiate appropriate legal proceedings under the applicable laws of India. Any dispute arising from this Agreement shall be subject to the jurisdiction of the competent courts.</p>
                </div>

                <div>
                    <h5 class="font-bold text-[#031b4e] mb-1">13. Acceptance of Terms</h5>
                    <p class="mb-1">By signing this Agreement physically or digitally, the Candidate confirms that:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>They have carefully read and understood all the terms and conditions.</li>
                        <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
                        <li>They agree to comply with all payment obligations and conditions mentioned herein.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-300 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6" style="page-break-inside: avoid;">
                <div>
                    <div class="date mb-4 sm:mb-6 text-xs sm:text-sm">
                        <strong>Date of Execution:</strong> {{ $profile?->tuition_agreement_signed_at ? \Carbon\Carbon::parse($profile->tuition_agreement_signed_at)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y') }}
                    </div>
                    <p class="font-bold mb-4 sm:mb-8 text-xs sm:text-sm">For Warriors Educare</p>
                    <p class="text-xs text-slate-500">(Authorized Signatory)</p>
                </div>
                <div class="text-left sm:text-left bg-slate-50 p-3.5 rounded-xl border border-slate-200" style="font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; line-height: 1.35;">
                    <div class="flex items-center gap-1.5 mb-1 text-[11px] font-sans font-bold text-emerald-700">
                        <i class="fas fa-certificate text-emerald-600"></i> DIGITALLY SIGNED & VERIFIED
                    </div>
                    <i>Digitally Signed by: <strong>{{ auth()->user()->name }}</strong></i><br>
                    <i>Phone No : ******{{ substr(auth()->user()->phone ?? '0000', -4) }}</i><br>
                    @if(!empty($profile?->tuition_location_name) || !empty($sigMeta['location']))
                        <i>GPS Location : 📍 {{ $profile?->tuition_location_name ?? $sigMeta['location'] }}</i><br>
                    @elseif($profile?->tuition_latitude && $profile?->tuition_longitude)
                        <i>GPS Coordinates : 📍 {{ number_format($profile->tuition_latitude, 4) }}° N, {{ number_format($profile->tuition_longitude, 4) }}° E</i><br>
                    @endif
                    <i>IP Address : 💻 {{ $sigMeta['ip'] ?? request()->ip() }}</i><br>
                    <i>Execution Timestamp : 📅 {{ \Carbon\Carbon::parse($profile?->tuition_agreement_signed_at ?? now())->format('D M d H:i:s T Y') }}</i><br>
                    <i>Identity Verification : {{ ($profile?->tuition_live_photo_path || $profile?->live_photo_path) ? 'Live Camera Snapshot Verified ✅' : 'Verified Digital Signature ✅' }}</i>
                </div>
            </div>
            </div> <!-- End relative z-10 -->
        </div> <!-- End #printableTuitionAgreement -->

            <!-- STEP 1 FOOTER (When Unsigned) -->
            @if(!$isAgreementSigned)
                <div class="p-3.5 sm:p-4 border-t border-[#031b4e]/10 bg-gray-50 flex items-center justify-between gap-3 shrink-0">
                    <button type="button" onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 text-xs sm:text-sm">
                        Cancel
                    </button>
                    <button type="button" @click="step = 2; $nextTick(() => detectAgreementLocation());" class="px-5 sm:px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-extrabold text-xs sm:text-sm shadow-md transition-all flex items-center gap-2">
                        <span>Proceed to Sign (Photo & GPS)</span> <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </div>
            @else
                <!-- SIGNED FOOTER (Print & Close) -->
                <div class="p-3 sm:p-4 border-t border-[#031b4e]/10 bg-gray-50 flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 rounded-b-2xl shrink-0">
                    <button type="button" onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors text-xs sm:text-sm">Close</button>
                    <button type="button" onclick="printTuitionAgreement()" class="w-full sm:w-auto px-5 py-2.5 bg-[#0ea5e9] text-white rounded-xl font-semibold hover:bg-[#0ea5e9]/90 transition-colors shadow-sm flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fas fa-download"></i> Download / Print PDF
                    </button>
                </div>
            @endif
        </div> <!-- End Step 1 View -->

        <!-- STEP 2: LIVE CAMERA & GPS VERIFICATION & FINAL SIGN (Dedicated Spacious View) -->
        @if(!$isAgreementSigned)
            <div x-show="step === 2" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col justify-between bg-slate-50" style="display: none;">
                <form id="signTuitionAgreementForm" action="{{ route('candidate.tuitions.sign-agreement') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateTuitionAgreementForm(event)" class="p-4 sm:p-6 space-y-4 flex-1 flex flex-col justify-between">
                    @csrf
                    <!-- Hidden Inputs for Verification Data -->
                    <input type="hidden" name="live_photo" id="livePhotoInput" value="">
                    <input type="hidden" name="latitude" id="latitudeInput" value="">
                    <input type="hidden" name="longitude" id="longitudeInput" value="">
                    <input type="hidden" name="location_name" id="locationNameInput" value="">

                    <div class="space-y-4">
                        <!-- Candidate Quick Summary Strip -->
                        <div class="bg-blue-50/80 p-3 rounded-2xl border border-blue-200/60 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div>
                                    <span class="font-black text-[#031b4e] block text-xs sm:text-sm">{{ auth()->user()->name }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium">📞 {{ auth()->user()->phone }}</span>
                                </div>
                            </div>
                            <button type="button" @click="step = 1" class="px-2.5 py-1 bg-white border border-blue-200 text-blue-700 rounded-lg font-bold text-[11px] hover:bg-blue-50">
                                <i class="fas fa-book-open mr-1"></i> Review Terms
                            </button>
                        </div>

                        <!-- Verification Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 1. Live Camera Snapshot Box -->
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-[#031b4e] flex items-center gap-1.5">
                                        <i class="fas fa-camera text-blue-600"></i> 1. Live Camera Selfie
                                    </span>
                                    <span id="cameraStatusBadge" class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700">
                                        Click to Start
                                    </span>
                                </div>

                                <!-- Video / Photo Container -->
                                <div class="relative w-full h-44 bg-slate-900 rounded-xl overflow-hidden flex items-center justify-center border border-slate-300">
                                    <video id="agreementWebcam" autoplay playsinline class="w-full h-full object-cover"></video>
                                    <canvas id="agreementCanvas" class="hidden"></canvas>
                                    <img id="agreementCapturedPreview" class="hidden w-full h-full object-cover" alt="Captured Selfie">

                                    <!-- Camera Placeholder before start -->
                                    <div id="cameraStartPlaceholder" class="absolute inset-0 bg-slate-900/90 text-white flex flex-col items-center justify-center p-3 text-center">
                                        <i class="fas fa-camera text-3xl text-blue-400 mb-2"></i>
                                        <p class="text-xs font-medium text-slate-300">Take a live selfie to verify agreement</p>
                                        <button type="button" onclick="startAgreementCamera()" class="mt-3 px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                                            <i class="fas fa-play text-[10px]"></i> Open Camera
                                        </button>
                                    </div>
                                </div>

                                <!-- Camera Controls -->
                                <div class="flex items-center gap-2">
                                    <button type="button" id="snapPhotoBtn" onclick="snapAgreementPhoto()" class="hidden flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                        <i class="fas fa-camera"></i> <span>Capture Photo</span>
                                    </button>
                                    <button type="button" id="retakePhotoBtn" onclick="retakeAgreementPhoto()" class="hidden px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition-all">
                                        <i class="fas fa-redo text-xs mr-1"></i> Retake
                                    </button>
                                    
                                    <!-- File upload fallback -->
                                    <label class="text-xs text-blue-600 hover:underline cursor-pointer flex items-center gap-1 shrink-0 ml-auto font-medium">
                                        <i class="fas fa-upload text-[10px]"></i> Upload Photo
                                        <input type="file" name="live_photo_file" accept="image/*" capture="user" onchange="handlePhotoFileUpload(event)" class="hidden">
                                    </label>
                                </div>
                            </div>

                            <!-- 2. Live GPS Location Box -->
                            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-[#031b4e] flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-red-500"></i> 2. GPS Location
                                    </span>
                                    <span id="geoStatusBadge" class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">
                                        Detecting...
                                    </span>
                                </div>

                                <!-- GPS Info Display -->
                                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs space-y-2 my-auto">
                                    <div class="flex items-start gap-2.5">
                                        <i class="fas fa-crosshairs text-blue-600 text-base mt-0.5 shrink-0"></i>
                                        <div>
                                            <p class="font-bold text-[#031b4e] text-xs sm:text-sm" id="geoCoordinatesText">Detecting your location...</p>
                                            <p class="text-xs text-slate-500 line-clamp-3 mt-0.5 leading-relaxed" id="geoAddressText">Please allow location access when prompted by your browser.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Geo Refresh Button -->
                                <div class="flex items-center justify-between pt-1">
                                    <button type="button" onclick="detectAgreementLocation()" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <i class="fas fa-sync-alt text-[10px]"></i> <span>Refresh Location</span>
                                    </button>
                                    <span class="text-[10px] text-slate-400">GPS Timestamped</span>
                                </div>
                            </div>
                        </div>

                        <!-- Terms Acceptance Checkbox -->
                        <div class="bg-white p-3.5 rounded-2xl border border-slate-200 shadow-sm">
                            <label class="flex items-start gap-3 cursor-pointer text-left">
                                <input type="checkbox" name="accept_terms" required value="1" class="w-5 h-5 text-[#031b4e] rounded border-gray-300 focus:ring-accent-blue mt-0.5 cursor-pointer shrink-0">
                                <span class="text-xs text-[#031b4e] font-bold leading-relaxed">
                                    I declare that the captured photo & GPS location are authentic, and I voluntarily accept all terms, validity, refund and payment clauses of this Home Tuition Tutor Service Agreement.
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- STEP 2 ACTIONS FOOTER -->
                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between gap-3">
                        <button type="button" @click="step = 1" class="px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-1.5">
                            <i class="fas fa-arrow-left text-xs"></i> <span>Back to Terms</span>
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black text-xs sm:text-sm shadow-md transition-all flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> <span>Accept & Sign Agreement</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
let agreementStream = null;

function validateTuitionAgreementForm(e) {
    const livePhotoInput = document.getElementById('livePhotoInput');
    const photoFileInput = document.querySelector('input[name="live_photo_file"]');
    const hasExistingPhoto = {{ (!empty($profile?->tuition_live_photo_path) || !empty($profile?->live_photo_path)) ? 'true' : 'false' }};
    
    const hasCaptured = livePhotoInput && livePhotoInput.value.trim().length > 0;
    const hasUploaded = photoFileInput && photoFileInput.files && photoFileInput.files.length > 0;

    if (!hasCaptured && !hasUploaded && !hasExistingPhoto) {
        if (e) e.preventDefault();
        alert('📸 Live Camera Photo Capture is MANDATORY!\n\nPlease click "Open Camera" and capture your selfie (or use "Upload Photo") to verify your identity before signing the agreement.');
        const badge = document.getElementById('cameraStatusBadge');
        if (badge) {
            badge.textContent = 'Photo Mandatory ⚠️';
            badge.className = 'text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 animate-pulse';
        }
        return false;
    }
    return true;
}

function startAgreementCamera() {
    const video = document.getElementById('agreementWebcam');
    const placeholder = document.getElementById('cameraStartPlaceholder');
    const snapBtn = document.getElementById('snapPhotoBtn');
    const badge = document.getElementById('cameraStatusBadge');

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } } })
            .then(function(stream) {
                agreementStream = stream;
                video.srcObject = stream;
                video.play();
                placeholder.classList.add('hidden');
                snapBtn.classList.remove('hidden');
                badge.textContent = 'Camera Active';
                badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700';
            })
            .catch(function(err) {
                console.warn('Camera access error:', err);
                badge.textContent = 'Use File Upload';
                badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700';
                alert('Camera permission was denied or camera not found. Please click "Upload Photo" below to select/snap your photo.');
            });
    } else {
        alert('Direct webcam stream is not supported in this browser. Please use the "Upload Photo" link.');
    }
}

function snapAgreementPhoto() {
    const video = document.getElementById('agreementWebcam');
    const canvas = document.getElementById('agreementCanvas');
    const preview = document.getElementById('agreementCapturedPreview');
    const input = document.getElementById('livePhotoInput');
    const snapBtn = document.getElementById('snapPhotoBtn');
    const retakeBtn = document.getElementById('retakePhotoBtn');
    const badge = document.getElementById('cameraStatusBadge');

    canvas.width = video.videoWidth || 640;
    canvas.height = video.videoHeight || 480;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    const base64 = canvas.toDataURL('image/jpeg', 0.85);
    input.value = base64;
    preview.src = base64;

    if (agreementStream) {
        agreementStream.getTracks().forEach(track => track.stop());
        agreementStream = null;
    }

    video.classList.add('hidden');
    preview.classList.remove('hidden');
    snapBtn.classList.add('hidden');
    retakeBtn.classList.remove('hidden');
    badge.textContent = 'Photo Captured ✅';
    badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800';
}

function retakeAgreementPhoto() {
    const video = document.getElementById('agreementWebcam');
    const preview = document.getElementById('agreementCapturedPreview');
    const input = document.getElementById('livePhotoInput');
    const retakeBtn = document.getElementById('retakePhotoBtn');

    input.value = '';
    preview.classList.add('hidden');
    video.classList.remove('hidden');
    retakeBtn.classList.add('hidden');
    startAgreementCamera();
}

function handlePhotoFileUpload(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(evt) {
        const base64 = evt.target.result;
        document.getElementById('livePhotoInput').value = base64;
        const preview = document.getElementById('agreementCapturedPreview');
        preview.src = base64;
        preview.classList.remove('hidden');
        document.getElementById('agreementWebcam').classList.add('hidden');
        document.getElementById('cameraStartPlaceholder').classList.add('hidden');
        document.getElementById('snapPhotoBtn').classList.add('hidden');
        document.getElementById('retakePhotoBtn').classList.remove('hidden');
        const badge = document.getElementById('cameraStatusBadge');
        badge.textContent = 'Photo Uploaded ✅';
        badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800';
    };
    reader.readAsDataURL(file);
}

function detectAgreementLocation() {
    const coordsText = document.getElementById('geoCoordinatesText');
    const addrText = document.getElementById('geoAddressText');
    const badge = document.getElementById('geoStatusBadge');
    const latInput = document.getElementById('latitudeInput');
    const lngInput = document.getElementById('longitudeInput');
    const locInput = document.getElementById('locationNameInput');

    if (!coordsText) return;

    if (!navigator.geolocation) {
        coordsText.textContent = 'Location Not Supported';
        addrText.textContent = 'Browser geolocation is unavailable.';
        badge.textContent = 'Manual Location';
        badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800';
        return;
    }

    badge.textContent = 'Detecting...';
    badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700';

    navigator.geolocation.getCurrentPosition(
        function(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            latInput.value = lat;
            lngInput.value = lng;
            coordsText.textContent = `${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E`;
            badge.textContent = 'GPS Verified ✅';
            badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800';

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(r => r.json())
                .then(data => {
                    const place = data.display_name || `${lat}, ${lng}`;
                    locInput.value = place;
                    addrText.textContent = place;
                })
                .catch(() => {
                    const fallback = `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
                    locInput.value = fallback;
                    addrText.textContent = fallback;
                });
        },
        function(err) {
            coordsText.textContent = 'Location Permission Skipped';
            addrText.textContent = 'GPS permission not granted. IP address location will be recorded on signature.';
            badge.textContent = 'IP Geo Used';
            badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700';
        },
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
    );
}

document.addEventListener('DOMContentLoaded', function() {
    detectAgreementLocation();
});

function printTuitionAgreement() {
    const printContents = document.getElementById('printableTuitionAgreement').innerHTML;
    const originalContents = document.body.innerHTML;

    // Create a temporary print styling
    const style = document.createElement('style');
    style.innerHTML = `
        @media print {
            body { font-family: Arial, sans-serif; padding: 20px; color: #000; position: relative; }
            h2, h3, h5 { color: #000; }
            * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
            .watermark-img { 
                position: fixed !important; 
                top: 50% !important; 
                left: 50% !important; 
                transform: translate(-50%, -50%) !important; 
                width: 60% !important; 
                max-width: 420px !important; 
                opacity: 0.08 !important; 
                z-index: 0 !important; 
                display: block !important;
            }
            .relative.z-10 { position: relative !important; z-index: 10 !important; }
        }
    `;
    document.head.appendChild(style);

    document.body.innerHTML = printContents;
    window.print();
    
    // Restore
    document.body.innerHTML = originalContents;
    location.reload(); // Reload to reattach event listeners safely
}
</script>

<!-- Search / Filter Bar -->
<div class="bg-white rounded-2xl border border-[#031b4e]/10 p-4 mb-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="text-xs sm:text-sm font-bold text-[#031b4e]">
        Found {{ $tuitions->total() }} Tuition Requirements
    </div>
    <form action="{{ route('candidate.tuitions.index') }}" method="GET" class="w-full sm:w-auto flex items-center gap-2">
        <div class="relative w-full sm:w-72">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tuition ID (e.g. TUI-0001), subject, area..." 
                   class="w-full pl-8 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-blue-500">
            @if(request('search'))
                <a href="{{ route('candidate.tuitions.index') }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                    <i class="fas fa-times text-xs"></i>
                </a>
            @endif
        </div>
        <button type="submit" class="px-4 py-2 bg-[#031b4e] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-blue-900 transition-colors">
            Search
        </button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    @forelse($tuitions as $tuition)
        <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 shadow-sm p-4 sm:p-6 flex flex-col hover:shadow-md transition-shadow bg-white">
            <div class="flex justify-between items-start gap-2 mb-3 sm:mb-4">
                <span class="inline-flex items-center gap-1 font-mono text-xs font-bold text-accent-blue bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100">
                    <i class="fas fa-hashtag text-[9px] opacity-70"></i>{{ $tuition->tuition_id ?: 'TUI-' . str_pad($tuition->id, 4, '0', STR_PAD_LEFT) }}
                </span>
                <div class="flex items-center gap-1.5">
                    <span class="bg-[#0ea5e9]/10 text-[#0ea5e9] text-xs font-bold px-2.5 py-1 rounded-full">
                        Class {{ $tuition->{'class'} }}
                    </span>
                    <span class="bg-blue-50 text-[#031b4e] text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-100">
                        {{ $tuition->board ?: 'General Board' }}
                    </span>
                </div>
            </div>

            <h3 class="text-base sm:text-lg md:text-xl font-bold text-[#031b4e] mb-2 leading-snug">{{ $tuition->subjects }}</h3>
            
            <div class="space-y-2 sm:space-y-2.5 mb-4 sm:mb-6 flex-grow text-xs sm:text-sm">
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-map-marker-alt w-5 text-red-500 shrink-0"></i>
                    <span class="line-clamp-1" title="{{ $tuition->location }}">{{ $tuition->location }}</span>
                </div>
                @if($tuition->pincode)
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-mail-bulk w-5 text-[#031b4e]/50 shrink-0"></i>
                    <span class="font-mono">Pincode: {{ $tuition->pincode }}</span>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-between mt-auto pt-3 sm:pt-4 border-t border-[#031b4e]/10 gap-2">
                <span class="text-[11px] sm:text-xs text-[#031b4e]/60 whitespace-nowrap">
                    <i class="far fa-clock mr-1"></i> {{ $tuition->created_at->diffForHumans() }}
                </span>

                @if(!$isAgreementSigned)
                    <button type="button" onclick="document.getElementById('tuitionAgreementModal').classList.remove('hidden')" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-xl text-xs sm:text-sm transition-all shadow-sm flex items-center gap-1.5">
                        <i class="fas fa-lock text-xs"></i> Sign Agreement to Apply
                    </button>
                @elseif(in_array($tuition->id, $appliedTuitionIds))
                    <button disabled class="bg-gray-100 text-[#031b4e]/80 font-bold py-2 px-4 sm:px-6 rounded-xl text-xs sm:text-sm cursor-not-allowed">
                        Applied <i class="fas fa-check ml-1 text-green-600"></i>
                    </button>
                @else
                    <form action="{{ route('candidate.tuitions.apply', $tuition->id) }}" method="POST" class="shrink-0">
                        @csrf
                        <button type="submit" class="bg-[#0ea5e9] hover:bg-[#0284c7] text-white font-bold py-2 px-4 sm:px-6 rounded-xl text-xs sm:text-sm transition-all shadow-sm active:scale-95">
                            Apply Now
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white p-8 sm:p-12 text-center rounded-2xl border border-[#031b4e]/5">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <i class="fas fa-book-reader text-[#031b4e]/50 text-xl sm:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-[#031b4e] mb-1">No Tuitions Available</h3>
            <p class="text-xs sm:text-sm text-[#031b4e]/80">There are currently no active tuitions to apply for. Please check back later.</p>
        </div>
    @endforelse
</div>

@if($tuitions->hasPages())
    <div class="mt-8">
        {{ $tuitions->links() }}
    </div>
@endif

    </div>
@endsection
