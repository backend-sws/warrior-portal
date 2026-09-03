@extends('layouts.app')

@section('title', 'Thank You! Home Tuition Requirement Received | Warriors Educare')
@section('meta_description', 'Your home tuition requirement has been received successfully. Our academic counselors will match verified tutors and contact you within 2-4 hours.')

@section('content')
<main class="pt-32 pb-20 bg-slate-50 min-h-screen relative overflow-hidden">
    <!-- Ambient background glow elements -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-full max-w-4xl h-96 bg-gradient-to-b from-blue-100/50 via-indigo-50/30 to-transparent blur-3xl pointer-events-none -z-10"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 overflow-hidden text-center p-8 sm:p-12 transition-all">
            
            <!-- Animated Success Badge -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-500 shadow-lg shadow-emerald-500/15">
                <i class="fas fa-check text-3xl sm:text-4xl animate-pulse"></i>
            </div>

            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-blue-50 text-[#031b4e] border border-blue-200 mb-4">
                <i class="fas fa-shield-alt text-blue-600"></i> Requirement Confirmed & Verified
            </span>

            <h1 class="text-2xl sm:text-4xl font-extrabold text-[#031b4e] tracking-tight mb-3">
                Thank You! Your Tuition Requirement Has Been Posted
            </h1>
            
            <p class="text-base sm:text-lg text-slate-600 font-medium max-w-2xl mx-auto mb-8 leading-relaxed">
                We have received your home tuition request. Our expert academic counselors are already reviewing the details to find the best-matched verified tutor for your child.
            </p>

            <!-- 3 Next Steps Timeline -->
            <div class="text-left bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200/70 mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-5 flex items-center gap-2">
                    <i class="fas fa-clock text-blue-600"></i> What Happens Next:
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
                            1
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#031b4e] mb-1">Requirement Analysis</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Our academic team checks the student's class, board, and location for the best fit.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-[#031b4e] text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md shadow-slate-900/20">
                            2
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#031b4e] mb-1">Tutor Matching</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">We shortlist verified tutors with a proven track record in your exact subject areas.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20">
                            3
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#031b4e] mb-1">Counselor Call & Demo</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">You will receive a call within 2–4 hours to finalize tutor selection and schedule a demo class.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Need Instant Assistance Box -->
            <div class="bg-gradient-to-r from-blue-900 to-[#031b4e] text-white rounded-2xl p-6 sm:p-7 flex flex-col sm:flex-row items-center justify-between gap-5 mb-8 text-left shadow-lg">
                <div>
                    <h3 class="text-base sm:text-lg font-bold mb-1 flex items-center gap-2">
                        <i class="fas fa-headset text-yellow-400"></i> Need Immediate Assistance?
                    </h3>
                    <p class="text-xs sm:text-sm text-blue-200">Connect with our dedicated parent support team right away.</p>
                    <p class="text-xs text-blue-200 mt-1.5 flex items-center gap-1.5">
                        <i class="fas fa-envelope text-yellow-400"></i> <a href="mailto:support@warriorseducare.com" class="underline hover:text-white transition-colors">support@warriorseducare.com</a>
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <a href="tel:+918210545286" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 font-bold text-xs rounded-xl transition-all shadow-sm" style="background-color: #facc15; color: #031b4e;">
                        <i class="fas fa-phone-alt"></i> Call +91 82105 45286
                    </a>
                    <a href="https://wa.me/918210545286?text=Hi%20Warriors%20Educare%2C%20I%20have%20submitted%20a%20home%20tuition%20requirement%20and%20need%20quick%20assistance." target="_blank" rel="noopener noreferrer" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white font-bold text-xs rounded-xl transition-all shadow-sm">
                        <i class="fab fa-whatsapp text-sm"></i> WhatsApp Us
                    </a>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-center pt-2">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-[#031b4e] hover:bg-[#021338] text-white font-bold text-xs transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-arrow-left"></i> Return to Homepage
                </a>
            </div>

        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    // Automatic Lead Conversion Trigger on Thank You Page Load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.trackLeadConversion === 'function') {
            window.trackLeadConversion('home_tuition', {
                page_name: 'Home Tuition Success Page',
                form_type: 'Home Tuition Enquiry'
            });
            console.log('[Tracking] Home Tuition Lead event pushed to DataLayer & Google Ads.');
        }
    });
</script>
@endpush
