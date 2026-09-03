@extends('layouts.app')

@section('title', 'Thank You! Teacher Requirement Received | Warriors Educare Institutional Hiring')
@section('meta_description', 'Your institution faculty requirement has been received. Our recruitment specialists will review and connect with you shortly.')

@section('content')
<main class="pt-32 pb-20 bg-slate-50 min-h-screen relative overflow-hidden">
    <!-- Ambient background glow elements -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-full max-w-4xl h-96 bg-gradient-to-b from-indigo-100/50 via-blue-50/30 to-transparent blur-3xl pointer-events-none -z-10"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 overflow-hidden text-center p-8 sm:p-12 transition-all">
            
            <!-- Animated Success Badge -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-6 rounded-full bg-blue-50 border-4 border-blue-100 flex items-center justify-center text-[#031b4e] shadow-lg shadow-blue-900/15">
                <i class="fas fa-school text-3xl sm:text-4xl text-[#031b4e]"></i>
            </div>

            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 mb-4">
                <i class="fas fa-check-circle text-emerald-600"></i> Institutional Requirement Received
            </span>

            <h1 class="text-2xl sm:text-4xl font-extrabold text-[#031b4e] tracking-tight mb-3">
                Thank You! Your Hiring Requirement Is In Review
            </h1>
            
            <p class="text-base sm:text-lg text-slate-600 font-medium max-w-2xl mx-auto mb-8 leading-relaxed">
                Thank you for trusting Warriors Educare for your institution's faculty needs. Our dedicated institutional recruitment division has received your vacancy details.
            </p>

            <!-- 3 Next Steps Timeline -->
            <div class="text-left bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200/70 mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-5 flex items-center gap-2">
                    <i class="fas fa-briefcase text-blue-600"></i> Institutional Recruitment Process:
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-[#031b4e] text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md shadow-slate-900/20">
                            1
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#031b4e] mb-1">Requirement Review</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Our HR team analyzes subject, board curriculum, qualification criteria, and location.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
                            2
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#031b4e] mb-1">Candidate Screening</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">We filter pre-verified PGT, TGT, PRT, and college faculty resumes from our database.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-bold text-sm flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20">
                            3
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#031b4e] mb-1">Profiles & Interviews</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">A dedicated HR account manager connects with you to schedule candidate demo interviews.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Institutional Direct Line Box -->
            <div class="bg-gradient-to-r from-[#031b4e] to-slate-900 text-white rounded-2xl p-6 sm:p-7 flex flex-col sm:flex-row items-center justify-between gap-5 mb-8 text-left shadow-lg">
                <div>
                    <h3 class="text-base sm:text-lg font-bold mb-1 flex items-center gap-2">
                        <i class="fas fa-building text-yellow-400"></i> Direct School Hiring Desk
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300">Need urgent faculty or bulk recruitment for an upcoming session?</p>
                    <p class="text-xs text-blue-200 mt-1.5 flex items-center gap-1.5">
                        <i class="fas fa-envelope text-yellow-400"></i> <a href="mailto:support@warriorseducare.com" class="underline hover:text-white transition-colors">support@warriorseducare.com</a>
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <a href="tel:+918210545286" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 font-bold text-xs rounded-xl transition-all shadow-sm" style="background-color: #facc15; color: #031b4e;">
                        <i class="fas fa-phone-alt"></i> Call +91 82105 45286
                    </a>
                    <a href="https://wa.me/918210545286?text=Hi%20Warriors%20Educare%2C%20I%20have%20submitted%20a%20school%20teacher%20hiring%20requirement%20and%20need%20to%20discuss%20profiles." target="_blank" rel="noopener noreferrer" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-white font-bold text-xs rounded-xl transition-all shadow-sm">
                        <i class="fab fa-whatsapp text-sm"></i> WhatsApp HR
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
            window.trackLeadConversion('school_hiring', {
                page_name: 'School Hiring Success Page',
                form_type: 'School Faculty Requirement'
            });
            console.log('[Tracking] School Hiring Lead event pushed to DataLayer & Google Ads.');
        }
    });
</script>
@endpush
