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

<!-- Modal for Tuition Agreement -->
<div id="tuitionAgreementModal" class="fixed inset-0 z-[9999] hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[92vh] flex flex-col shadow-2xl overflow-hidden relative border border-slate-200">
        <div class="p-4 sm:p-5 md:p-6 border-b border-[#031b4e]/10 flex justify-between items-center bg-[#031b4e] text-white">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-accent-yellow block">Warriors Educare</span>
                <h3 class="text-base sm:text-lg md:text-xl font-black">Home Tuition – Tutor Service Agreement</h3>
            </div>
            <button onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="w-9 h-9 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center transition-colors shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        
        <div id="printableTuitionAgreement" class="p-4 sm:p-6 md:p-8 overflow-y-auto custom-scrollbar text-[#031b4e]/80 text-xs sm:text-sm relative bg-white">
            <!-- Watermark Image -->
            <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" class="watermark-img" alt="Watermark" style="position: absolute; top: 65%; left: 50%; transform: translateX(-50%); width: 60%; max-width: 500px; opacity: 0.1; z-index: 0; pointer-events: none;">

            <div class="text-center mb-6 relative z-10 border-b-2 border-[#031b4e] pb-4">
                <img src="{{ asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" alt="Warriors Educare Logo" style="max-height: 80px; margin: 0 auto 10px auto;">
                <h2 class="text-2xl font-bold text-[#031b4e] mb-1">WARRIORS EDUCARE</h2>
                <h3 class="text-lg font-semibold text-[#031b4e]">HOME TUITION – TUTOR SERVICE AGREEMENT</h3>
            </div>
            
            @php
                // Photo URL
                $photoUrl = null;
                $photoPath = null;
                if ($profile->live_photo_path && Storage::disk('public')->exists($profile->live_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->live_photo_path);
                } elseif ($profile->profile_photo_path && Storage::disk('public')->exists($profile->profile_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->profile_photo_path);
                } elseif ($profile->passport_photo_path && Storage::disk('public')->exists($profile->passport_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->passport_photo_path);
                }

                if ($photoPath && file_exists($photoPath)) {
                    $photoData = file_get_contents($photoPath);
                    $mime = mime_content_type($photoPath);
                    $photoUrl = 'data:' . $mime . ';base64,' . base64_encode($photoData);
                }
            @endphp
            
            <div class="relative z-10">
            
            <!-- Candidate Details & Photo -->
            <div class="bg-gray-50 border border-gray-200 p-3 sm:p-4 mb-4 sm:mb-6 rounded-xl flex flex-col-reverse sm:flex-row justify-between items-start gap-3">
                <div class="space-y-1 text-xs sm:text-sm">
                    <p class="mb-0"><strong>Candidate Name:</strong> {{ auth()->user()->name }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="mb-0"><strong>Phone:</strong> {{ auth()->user()->phone }}</p>
                    <p class="mb-0"><strong>Address:</strong> {{ $profile->address ?? 'Not specified' }}</p>
                </div>
                @if($photoUrl)
                    <div class="shrink-0 self-center sm:self-auto">
                        <img src="{{ $photoUrl }}" alt="Candidate Photo" class="w-16 h-20 sm:w-20 sm:h-24 object-cover border border-gray-300 rounded-lg shadow-sm">
                    </div>
                @endif
            </div>

            <p class="mb-4">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Tutor").</p>

            <h5 class="font-bold text-[#031b4e] mb-2">1. Purpose of Agreement</h5>
            <p class="mb-4">Warriors Educare provides consultancy, placement support, and home tuition matchmaking services to educators. By accepting this Agreement, the Candidate authorizes the Agency to connect them with prospective parents/students for home tuition assignments.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">2. Service Charge & Placement Terms</h5>
            <p class="mb-4">Upon successful confirmation and assignment of any home tuition lead, the Candidate agrees to pay the stipulated service charge as communicated by the Agency. The service charge is non-refundable once classes commence.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">3. Professional Code of Conduct</h5>
            <p class="mb-4">The Candidate agrees to maintain the highest level of professionalism, punctuality, academic integrity, and respectful conduct during all demo sessions and confirmed home tuition classes.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">4. Acceptance & Digital Signature Confirmation</h5>
            <p class="mb-2">By signing this Agreement digitally, the Candidate confirms that:</p>
            <ul class="list-disc pl-5 mb-4 space-y-1.5">
                <li>They have carefully read and understood all the terms and conditions.</li>
                <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
                <li>They agree to comply with all payment obligations and tuition guidelines.</li>
            </ul>

            <div class="mt-8 pt-6 border-t border-gray-300 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6" style="page-break-inside: avoid;">
                <div>
                    <div class="date mb-4 sm:mb-6">
                        <strong>Date of Execution:</strong> {{ $profile->tuition_agreement_signed_at ? \Carbon\Carbon::parse($profile->tuition_agreement_signed_at)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y') }}
                    </div>
                    <p class="font-bold mb-4 sm:mb-8">For Warriors Educare</p>
                    <p>(Authorized Signatory)</p>
                </div>
                <div class="text-left sm:text-left" style="font-family: 'Times New Roman', Times, serif; font-size: 13px; color: #000; line-height: 1.2;">
                    <i>Digitally Signed by</i><br>
                    <i>Name : {{ auth()->user()->name }}</i><br>
                    <i>Phone No : ******{{ substr(auth()->user()->phone ?? '0000', -4) }}</i><br>
                    <i>Reason: Home Tuition Agreement E-signature</i><br>
                    <i>Date : {{ \Carbon\Carbon::parse($profile->tuition_agreement_signed_at ?? now())->format('D M d H:i:s T Y') }}</i>
                </div>
            </div>
            </div> <!-- End relative z-10 -->
        </div>

        {{-- Modal Footer: Signature Action if not signed, else Download & Close --}}
        @if(!$isAgreementSigned)
            <form action="{{ route('candidate.tuitions.sign-agreement') }}" method="POST" class="p-4 sm:p-5 bg-amber-50 border-t border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                @csrf
                <label class="flex items-start gap-3 cursor-pointer text-left">
                    <input type="checkbox" name="accept_terms" required value="1" class="w-5 h-5 text-[#031b4e] rounded border-gray-300 focus:ring-accent-blue mt-0.5 cursor-pointer">
                    <span class="text-xs text-[#031b4e] font-bold leading-snug">
                        I have read, understood and voluntarily accept all terms and conditions of this Home Tuition Tutor Service Agreement.
                    </span>
                </label>
                <div class="flex items-center gap-2 w-full sm:w-auto shrink-0 justify-end">
                    <button type="button" onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 text-xs sm:text-sm">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-extrabold text-xs sm:text-sm shadow-md transition-all flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Accept & Sign Agreement
                    </button>
                </div>
            </form>
        @else
            <div class="p-3 sm:p-4 border-t border-[#031b4e]/10 bg-gray-50 flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 rounded-b-2xl">
                <button onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors text-xs sm:text-sm">Close</button>
                <button onclick="printTuitionAgreement()" class="w-full sm:w-auto px-5 py-2.5 bg-[#0ea5e9] text-white rounded-xl font-semibold hover:bg-[#0ea5e9]/90 transition-colors shadow-sm flex items-center justify-center gap-2 text-xs sm:text-sm">
                    <i class="fas fa-download"></i> Download / Print PDF
                </button>
            </div>
        @endif
    </div>
</div>

<script>
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
                top: 25% !important; 
                left: 20% !important; 
                width: 60% !important; 
                opacity: 0.1 !important; 
                z-index: -1 !important; 
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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    @forelse($tuitions as $tuition)
        <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 shadow-sm p-4 sm:p-6 flex flex-col hover:shadow-md transition-shadow bg-white">
            <div class="flex justify-between items-start gap-2 mb-3 sm:mb-4">
                <span class="bg-[#0ea5e9]/10 text-[#0ea5e9] text-xs font-bold px-2.5 sm:px-3 py-1 rounded-full">
                    Class {{ $tuition->{'class'} }}
                </span>
                <span class="bg-blue-50 text-[#031b4e] text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-100">
                    {{ $tuition->board ?: 'General Board' }}
                </span>
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
