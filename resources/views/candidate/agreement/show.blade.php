@extends('layouts.app')

@section('content')
@include('candidate.partials.nav')

<div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

    {{-- Page Header --}}
    <div class="text-center mb-6 sm:mb-8 reveal">
        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xl sm:text-2xl mx-auto mb-3 sm:mb-4">
            <i class="fas fa-file-contract"></i>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold text-[#031b4e]">Candidate Agreement</h1>
        <p class="text-xs sm:text-sm text-[#031b4e]/70 mt-1.5 max-w-md mx-auto">Please read the terms and conditions carefully and provide your digital signature below.</p>
        
        {{-- Agreement Type Tabs --}}
        <div class="inline-flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl mt-4 border border-slate-200 shadow-inner">
            <a href="{{ route('candidate.agreement.show') }}" class="px-4 py-2 bg-[#031b4e] text-white font-bold text-xs rounded-xl shadow-sm flex items-center gap-1.5">
                <i class="fas fa-school text-xs text-sky-400"></i>
                <span>Teacher Placement Agreement</span>
            </a>
            <a href="{{ route('candidate.tuitions.index') }}" class="px-4 py-2 text-slate-600 hover:text-[#031b4e] font-bold text-xs rounded-xl transition-colors flex items-center gap-1.5">
                <i class="fas fa-chalkboard-teacher text-xs text-amber-500"></i>
                <span>Home Tuition Agreement</span>
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-5 sm:mb-6 bg-red-500/10 border border-red-500/30 p-3.5 sm:p-4 rounded-xl flex items-center gap-3 justify-center reveal">
            <i class="fas fa-exclamation-circle text-red-500 text-sm sm:text-base"></i>
            <span class="text-xs sm:text-sm text-red-700 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-5 sm:mb-6 bg-emerald-500/10 border border-emerald-500/30 p-3.5 sm:p-4 rounded-xl flex items-center gap-3 justify-center reveal">
            <i class="fas fa-check-circle text-emerald-600 text-sm sm:text-base"></i>
            <span class="text-xs sm:text-sm text-emerald-800 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Agreement Card (Always Visible so Candidate Can Read Terms) --}}
    <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 overflow-hidden shadow-sm reveal reveal-delay-1 bg-white">

        {{-- Terms Section (Always Readable) --}}
        <div class="p-4 sm:p-6 md:p-8 border-b border-[#031b4e]/10">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 sm:mb-5">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <span class="w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xs"><i class="fas fa-scroll"></i></span>
                    <h2 class="text-base sm:text-lg font-bold text-[#031b4e]">Terms and Conditions</h2>
                </div>
                <div>
                    @if($profile->is_agreement_signed)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <i class="fas fa-check-circle text-emerald-600"></i> Status: Digitally Signed & Verified
                        </span>
                    @elseif($profile->agreement_status === 'pending_signature')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                            <i class="fas fa-pen-fancy text-blue-600"></i> Status: Active for Signing
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                            <i class="fas fa-lock text-amber-600"></i> Status: Read-Only (Signing Locked)
                        </span>
                    @endif
                </div>
            </div>
            <div class="h-96 sm:h-[480px] overflow-y-auto pr-2 sm:pr-4 text-xs sm:text-sm text-[#031b4e]/80 space-y-3 sm:space-y-4 custom-scrollbar bg-slate-50 rounded-xl p-4 sm:p-6 border border-slate-200">
                    <div class="text-center mb-6">
                        <h3 class="text-base sm:text-lg font-black text-[#031b4e]">WARRIORS EDUCARE</h3>
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
                            <h5 class="font-bold text-[#031b4e] mb-10">10. Confidentiality</h5>
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

                    <h4 class="font-bold text-[#031b4e] mb-4 text-center">DECLARATION & ACCEPTANCE</h4>
                    <div class="bg-white p-5 rounded-lg border border-[#031b4e]/10 space-y-3 text-sm">
                        <p>I, <strong>{{ $user->name }}</strong>, hereby solemnly declare that I have thoroughly read, understood, and willingly accepted all the terms and conditions stated in this document of Warriors Educare.</p>
                        <p>I confirm that all personal, academic, and professional details provided by me are true, accurate, and complete. I understand that any false or misleading information may result in immediate cancellation of my registration without any refund.</p>
                        <p>I hereby agree to pay a service/registration fee of <strong>₹ 1000 (Rupees One Thousand only)</strong> to Warriors Educare, as mutually agreed, for availing recruitment and placement assistance services.</p>
                        <p>I clearly acknowledge and accept that the aforesaid amount is non-refundable under any circumstances once paid, irrespective of selection, joining, delay, or personal decision.</p>
                        <p>I further understand that Warriors Educare functions solely as a placement facilitation and consultancy service provider and does not guarantee employment, salary structure, job continuity, or service conditions, which are solely governed by the hiring institution.</p>
                        <p>I agree to abide by all rules, policies, and professional ethics of the agency. Any breach, non-compliance, or misconduct on my part may lead to termination of services and may attract legal action, if deemed necessary.</p>
                        <p>This declaration shall be deemed to constitute a lawful and binding agreement, enforceable in accordance with applicable laws, and subject exclusively to the jurisdiction of Patna, Bihar.</p>
                        <p class="font-semibold text-accent-red mt-2">Candidates agree to resolve disputes through formal communication before taking legal recourse.</p>
                    </div>
                    
                    <p class="mt-8 font-semibold text-accent-yellow italic border-l-2 border-accent-yellow/40 pl-4">By signing below, you acknowledge that you have read, understood, and agree to be bound by these terms.</p>
                </div>
            </div>

            {{-- Signature Section --}}
            @if($profile->is_agreement_signed)
                <div class="p-6 md:p-8 bg-green-500/5">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#031b4e] mb-1">Agreement Digitally Signed</h3>
                            <p class="text-sm text-[#031b4e]/70 mb-6">You have accepted the terms and conditions.</p>
                            
                            <div class="flex flex-col sm:flex-row gap-6 mb-6">
                                {{-- Digital Signature --}}
                                <div class="bg-white border border-[#031b4e]/10 rounded-xl p-5 flex-1">
                                    <h4 class="text-xs font-semibold text-[#031b4e]/50 uppercase tracking-wider mb-3">
                                        {{ $profile->signature_data ? 'Your Digital Signature' : 'Agreement Status' }}
                                    </h4>
                                    
                                    @if($profile->signature_data)
                                        <div class="mb-3 p-2.5 bg-slate-50 rounded-xl border border-slate-200 inline-block">
                                            @if(str_starts_with($profile->signature_data, 'data:image'))
                                                <img src="{{ $profile->signature_data }}" alt="Signature" class="max-h-16 w-auto object-contain">
                                            @elseif(Storage::disk('public')->exists($profile->signature_data))
                                                <img src="{{ asset('storage/' . $profile->signature_data) }}" alt="Signature" class="max-h-16 w-auto object-contain">
                                            @elseif($profile->signature_type === 'type')
                                                <span class="font-serif italic text-2xl text-blue-900 font-bold tracking-wide" style="font-family: 'Brush Script MT', 'Dancing Script', cursive, Georgia, serif;">
                                                    {{ $profile->signature_data }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-left" style="font-family: 'Times New Roman', Times, serif; font-size: 13px; color: #000; line-height: 1.35;">
                                            <div class="flex items-center gap-1.5 mb-1 text-[11px] font-sans font-bold text-emerald-700">
                                                <i class="fas fa-certificate text-emerald-600"></i> DIGITALLY SIGNED & VERIFIED
                                            </div>
                                            <i>Digitally Signed by</i><br>
                                            <i>Name : {{ auth()->user()->name }}</i><br>
                                            <i>Phone No : ******{{ substr(auth()->user()->phone ?? '0000', -4) }}</i><br>
                                            @if(!empty($profile->signature_location_name))
                                                <i>GPS Location : 📍 {{ $profile->signature_location_name }}</i><br>
                                            @elseif($profile->latitude && $profile->longitude)
                                                <i>GPS Coordinates : 📍 {{ number_format($profile->latitude, 4) }}° N, {{ number_format($profile->longitude, 4) }}° E</i><br>
                                            @endif
                                            @if(!empty($profile->signature_ip_address))
                                                <i>IP Address : 💻 {{ $profile->signature_ip_address }}</i><br>
                                            @endif
                                            <i>Reason: Candidate Teacher Placement Agreement</i><br>
                                            <i>Date : {{ $profile->signature_date_time ? \Carbon\Carbon::parse($profile->signature_date_time)->format('D M d H:i:s T Y') : now()->format('D M d H:i:s T Y') }}</i><br>
                                            <i>Identity Verification : {{ $profile->live_photo_path ? 'Live Camera Snapshot Verified ✅' : 'Verified Digital Signature ✅' }}</i>
                                        </div>
                                    @else
                                        <p class="text-sm font-medium text-[#031b4e] mb-3">
                                            <i class="fas fa-file-pdf text-[#0ea5e9] mr-1"></i> Agreement manually uploaded by Admin.
                                        </p>
                                        <div class="text-xs text-[#031b4e]/60 mt-4 pt-4 border-t border-[#031b4e]/10">
                                            <span class="block text-[#031b4e]/50 mb-0.5">Uploaded On</span>
                                            <span class="font-medium text-[#031b4e]/80">{{ $profile->updated_at->format('d M Y, h:i A') }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Live Photo --}}
                                @if($profile->live_photo_path)
                                <div class="bg-white border border-[#031b4e]/10 rounded-xl p-5 flex-1">
                                    <h4 class="text-xs font-semibold text-[#031b4e]/50 uppercase tracking-wider mb-3">
                                        Identity Verification Photo
                                    </h4>
                                    <img src="{{ asset('storage/' . $profile->live_photo_path) }}" alt="Live Photo" class="h-24 w-auto rounded-lg object-cover mb-3 border-2 border-emerald-500 shadow-sm">
                                    
                                    <div class="text-xs text-[#031b4e]/60 mt-2 pt-2 border-t border-[#031b4e]/10">
                                        <span class="block text-[#031b4e]/50 mb-0.5">Location Captured</span>
                                        <span class="font-medium text-[#031b4e]/80">
                                            @if(!empty($profile->signature_location_name))
                                                📍 {{ $profile->signature_location_name }}
                                            @elseif($profile->latitude && $profile->longitude)
                                                📍 {{ number_format($profile->latitude, 4) }}, {{ number_format($profile->longitude, 4) }}
                                            @else
                                                Not Available
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('candidate.agreement.download', ['regenerate' => 1]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0ea5e9]/10 text-[#0ea5e9] font-medium rounded-lg hover:bg-[#0ea5e9]/20 transition-colors text-sm">
                                    <i class="fas fa-file-pdf"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($profile->agreement_status === 'pending_signature')
                <div class="p-6 md:p-8 bg-slate-50 border-t border-slate-200">
                    <form action="{{ route('candidate.agreement.sign') }}" method="POST" id="signature-form" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="signature" id="signature-data">
                    <input type="hidden" name="live_photo" id="livePhotoInput" value="">
                    <input type="hidden" name="latitude" id="latitudeInput" value="">
                    <input type="hidden" name="longitude" id="longitudeInput" value="">
                    <input type="hidden" name="location_name" id="locationNameInput" value="">

                    <!-- Verification Box (Live Photo + GPS Location) -->
                    <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm space-y-4">
                        <!-- Inline Error Notification Banner (Replaces popup alerts) -->
                        <div id="agreementErrorBanner" class="hidden p-3.5 bg-red-50 border-2 border-red-400 rounded-2xl flex items-start gap-3 text-xs text-red-900 shadow-sm transition-all duration-300">
                            <div class="w-6 h-6 rounded-lg bg-red-500 text-white flex items-center justify-center shrink-0 mt-0.5">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                            </div>
                            <div class="flex-1 font-semibold leading-relaxed" id="agreementErrorMessage"></div>
                            <button type="button" onclick="document.getElementById('agreementErrorBanner').classList.add('hidden')" class="text-red-400 hover:text-red-700 ml-1.5 shrink-0">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>

                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-bold text-[#031b4e] flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center text-xs">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                                <span>Live Identity & Location Verification</span>
                            </h4>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Mandatory Verification</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 1. Live Camera Snapshot Box -->
                            <div id="cameraBoxContainer" class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col justify-between space-y-3 transition-all">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-[#031b4e] flex items-center gap-1.5">
                                        <i class="fas fa-camera text-blue-600"></i> 1. Live Photo Capture
                                    </span>
                                    <span id="cameraStatusBadge" class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700">
                                        Click to Start
                                    </span>
                                </div>

                                <!-- Video / Photo Container -->
                                <div class="relative w-full h-40 bg-slate-900 rounded-xl overflow-hidden flex items-center justify-center border border-slate-300">
                                    <video id="agreementWebcam" autoplay playsinline class="w-full h-full object-cover"></video>
                                    <canvas id="agreementCanvas" class="hidden"></canvas>
                                    <img id="agreementCapturedPreview" class="hidden w-full h-full object-cover" alt="Captured Selfie">

                                    <!-- Camera Placeholder before start -->
                                    <div id="cameraStartPlaceholder" class="absolute inset-0 bg-slate-900/90 text-white flex flex-col items-center justify-center p-3 text-center">
                                        <i class="fas fa-camera text-2xl text-blue-400 mb-1.5"></i>
                                        <p class="text-xs font-medium text-slate-300">Take a live photo for agreement verification</p>
                                        <button type="button" onclick="startAgreementCamera()" class="mt-2.5 px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                                            <i class="fas fa-play text-[10px]"></i> Open Camera
                                        </button>
                                    </div>
                                </div>

                                <!-- Camera Controls -->
                                <div class="flex items-center gap-2">
                                    <button type="button" id="snapPhotoBtn" onclick="snapAgreementPhoto()" class="hidden flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                        <i class="fas fa-camera"></i> <span>Capture Photo</span>
                                    </button>
                                    <button type="button" id="retakePhotoBtn" onclick="retakeAgreementPhoto()" class="hidden px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-xl text-xs font-bold transition-all">
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
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col justify-between space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-[#031b4e] flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-red-500"></i> 2. Current GPS Location
                                    </span>
                                    <span id="geoStatusBadge" class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">
                                        Detecting...
                                    </span>
                                </div>

                                <!-- GPS Info Display -->
                                <div class="bg-white p-3.5 rounded-xl border border-slate-200 text-xs space-y-2 my-auto">
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
                    </div>

                    <!-- Digital Signature Canvas -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 rounded-lg bg-accent-yellow/10 text-accent-yellow flex items-center justify-center text-xs"><i class="fas fa-pen-fancy"></i></span>
                            <div>
                                <h3 class="text-base font-bold text-[#031b4e]">3. Digital Signature</h3>
                                <p class="text-xs text-[#031b4e]/60 mt-0.5">Use your mouse or touchscreen to draw your digital signature inside the box below.</p>
                            </div>
                        </div>

                        <div class="border-2 border-dashed border-[#031b4e]/20 rounded-xl bg-[#f4f7f5]/40 relative overflow-hidden group hover:border-[#0ea5e9]/40 transition-colors" style="width: 100%; max-width: 500px;">
                            <canvas id="signature-pad" class="w-full h-44 cursor-crosshair touch-none bg-white"></canvas>
                            <div class="absolute bottom-2 right-2 text-[10px] text-slate-400 pointer-events-none">Sign here</div>
                        </div>
                        <div class="mt-2.5">
                            <button type="button" id="clear-signature" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1.5 transition-colors">
                                <i class="fas fa-eraser"></i> Clear Signature
                            </button>
                        </div>
                    </div>

                    <!-- Terms Declaration Checkbox -->
                    <div class="bg-white p-4 rounded-2xl border border-blue-100 shadow-sm flex items-start gap-3">
                        <input id="terms_accepted" name="terms_accepted" type="checkbox" required class="w-5 h-5 mt-0.5 rounded border-gray-300 text-[#0ea5e9] focus:ring-[#0ea5e9]/50 cursor-pointer shrink-0">
                        <label for="terms_accepted" class="text-xs text-[#031b4e] font-bold cursor-pointer leading-relaxed">
                            I hereby declare that the captured photo & GPS location are authentic, and I agree to all the terms, registration charges, 50% service charge, and legal clauses of Warriors Educare.
                        </label>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" id="submit-btn" class="px-8 py-3.5 bg-emerald-600 text-white font-extrabold rounded-xl hover:bg-emerald-700 transition-all shadow-lg flex items-center gap-2 text-sm">
                            <i class="fas fa-check-circle"></i> Accept & Sign Agreement
                        </button>
                    </div>
                </form>
            </div>
            @else
                {{-- READ-ONLY / SIGNING LOCKED NOTICE --}}
                <div class="p-6 sm:p-8 bg-gradient-to-b from-slate-50 to-white text-center border-t border-slate-200">
                    <div class="max-w-xl mx-auto">
                        <div class="w-14 h-14 bg-amber-50 border-2 border-amber-200 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-xs text-xl">
                            <i class="fas fa-lock"></i>
                        </div>

                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-xs font-bold mb-2">
                            <i class="fas fa-shield-alt text-amber-600"></i> Digital Signing Currently Locked
                        </div>

                        <h3 class="text-base sm:text-lg font-black text-[#031b4e] mb-2">Agreement Available for Reading Only</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                            You can read and review all the terms and conditions above. Digital signing, live photo identity verification, and agreement submission will be enabled here once Warriors Educare admin activates your agreement (when you are assigned or shortlisted for a school job opportunity).
                        </p>

                        <form action="{{ route('candidate.agreement.request') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-[#031b4e] hover:bg-[#021338] text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg inline-flex items-center gap-2 text-xs sm:text-sm cursor-pointer">
                                <i class="fas fa-paper-plane text-xs text-sky-400"></i> <span>Request Agreement Activation</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>

@push('scripts')
<script>
let agreementStream = null;

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
                showAgreementInlineError('<strong>⚠️ Camera Access Denied:</strong> Camera permission was blocked or not found. Please click <u>"Upload Photo"</u> below to select your photo.', 'cameraBoxContainer');
            });
    } else {
        showAgreementInlineError('<strong>⚠️ Camera Unavailable:</strong> Direct webcam stream is not supported in this browser. Please use the <u>"Upload Photo"</u> link.', 'cameraBoxContainer');
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

    const canvas = document.getElementById('signature-pad');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const clearBtn = document.getElementById('clear-signature');
    const form = document.getElementById('signature-form');
    const signatureDataInput = document.getElementById('signature-data');

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        ctx.scale(ratio, ratio);
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.lineWidth = 2.5;
        ctx.strokeStyle = '#000000';
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    let isDrawing = false;
    let hasDrawn = false;
    let lastX = 0;
    let lastY = 0;

    function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        const clientX = e.clientX || (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
        const clientY = e.clientY || (e.touches && e.touches[0] ? e.touches[0].clientY : 0);
        return [clientX - rect.left, clientY - rect.top];
    }

    function startDrawing(e) {
        isDrawing = true;
        hasDrawn = true;
        [lastX, lastY] = getCoordinates(e);
    }

    function draw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const [x, y] = getCoordinates(e);
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.stroke();
        [lastX, lastY] = [x, y];
    }

    function stopDrawing() { isDrawing = false; }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    canvas.addEventListener('touchstart', startDrawing, { passive: false });
    canvas.addEventListener('touchmove', draw, { passive: false });
    canvas.addEventListener('touchend', stopDrawing);

    clearBtn.addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasDrawn = false;
    });

function showAgreementInlineError(message, targetBoxId = null) {
    const banner = document.getElementById('agreementErrorBanner');
    const msg = document.getElementById('agreementErrorMessage');
    if (banner && msg) {
        msg.innerHTML = message;
        banner.classList.remove('hidden');
        banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    if (targetBoxId) {
        const box = document.getElementById(targetBoxId);
        if (box) {
            box.classList.add('ring-2', 'ring-red-500', 'border-red-500');
            setTimeout(() => {
                box.classList.remove('ring-2', 'ring-red-500', 'border-red-500');
            }, 5000);
        }
    }
}

    form.addEventListener('submit', (e) => {
        // 1. Check Signature
        if (!hasDrawn) {
            e.preventDefault();
            showAgreementInlineError('<strong>✍️ Digital Signature Required:</strong> Please draw your signature inside the signature box before submitting.', 'signatureCanvas');
            return;
        }

        // 2. Check Photo Capture
        const livePhotoInput = document.getElementById('livePhotoInput');
        const photoFileInput = document.querySelector('input[name="live_photo_file"]');
        const hasExistingPhoto = {{ (!empty($profile->live_photo_path)) ? 'true' : 'false' }};
        const hasCaptured = livePhotoInput && livePhotoInput.value.trim().length > 0;
        const hasUploaded = photoFileInput && photoFileInput.files && photoFileInput.files.length > 0;

        if (!hasCaptured && !hasUploaded && !hasExistingPhoto) {
            e.preventDefault();
            showAgreementInlineError('<strong>📸 Live Photo Required:</strong> Please click <u>"Open Camera"</u> to capture your selfie (or use <u>"Upload Photo"</u>) before signing.', 'cameraBoxContainer');
            const badge = document.getElementById('cameraStatusBadge');
            if (badge) {
                badge.textContent = 'Photo Mandatory ⚠️';
                badge.className = 'text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 animate-pulse';
            }
            return;
        }

        signatureDataInput.value = canvas.toDataURL('image/png');
    });
});
</script>
@endpush
@endsection



