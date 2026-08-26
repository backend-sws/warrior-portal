@extends('layouts.app')
@section('title', 'Institutional Services & Solutions - Warriors Educare')

@section('content')

<!-- 1. Hero Section -->
<section class="relative metallic-blue-card border-none shadow-none text-white pt-20 pb-20 md:pt-28 md:pb-28 overflow-hidden">
    <!-- Ambient Background Lighting -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-20 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-amber-400/10 rounded-full blur-2xl"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Breadcrumb & Badge -->
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-6">
            <nav class="flex items-center text-xs text-blue-200/80 space-x-2 font-medium">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-blue-400">/</span>
                <span class="text-white font-semibold">Services</span>
            </nav>
            <span class="inline-flex items-center gap-1.5 bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full backdrop-blur-sm">
                <i class="fas fa-shield-alt text-[#fbc043]"></i> Verified Institutional Solutions
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Header Content -->
            <div class="lg:col-span-7 text-center lg:text-left">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.15] mb-6">
                    Elevating Institutions With <span class="bg-gradient-to-r from-blue-200 via-sky-300 to-indigo-200 bg-clip-text text-transparent">Premier Services</span>
                </h1>
                <p class="text-blue-100/85 text-base sm:text-lg leading-relaxed max-w-2xl mb-8 mx-auto lg:mx-0 font-normal">
                    From vetted teacher recruitment and leadership placement to turnkey digital classroom infrastructure and career consultation, we provide comprehensive end-to-end solutions.
                </p>

                <!-- Quick Action Buttons -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                    <a href="#services-list" class="inline-flex items-center gap-2 bg-[#2563eb] hover:bg-blue-600 text-white font-bold text-sm px-7 py-3.5 rounded-xl transition-all shadow-[0_8px_20px_rgba(37,99,235,0.35)] hover:shadow-[0_12px_25px_rgba(37,99,235,0.5)] transform hover:-translate-y-0.5">
                        <span>Explore All Services</span>
                        <i class="fas fa-arrow-down text-xs"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm px-6 py-3.5 rounded-xl transition-all backdrop-blur-md">
                        <i class="fas fa-headset text-sky-400"></i>
                        <span>Speak to Consultant</span>
                    </a>
                </div>
            </div>

            <!-- Right Quick Stats Card -->
            <div class="lg:col-span-5">
                <div class="bg-white/10 backdrop-blur-xl border border-white/15 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-blue-500/20 rounded-full blur-2xl"></div>
                    
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2 border-b border-white/10 pb-4">
                        <i class="fas fa-award text-[#fbc043]"></i> Trusted Impact in Numbers
                    </h3>

                    <div class="grid grid-cols-2 gap-4 sm:gap-6">
                        <div class="bg-[#031b4e]/60 border border-white/10 rounded-2xl p-4 sm:p-5">
                            <div class="text-2xl sm:text-3xl font-black text-white mb-1">500+</div>
                            <div class="text-xs text-blue-200/80 font-medium">Partner Institutions</div>
                        </div>
                        <div class="bg-[#031b4e]/60 border border-white/10 rounded-2xl p-4 sm:p-5">
                            <div class="text-2xl sm:text-3xl font-black text-emerald-400 mb-1">98.4%</div>
                            <div class="text-xs text-blue-200/80 font-medium">Placement Satisfaction</div>
                        </div>
                        <div class="bg-[#031b4e]/60 border border-white/10 rounded-2xl p-4 sm:p-5">
                            <div class="text-2xl sm:text-3xl font-black text-amber-300 mb-1">&lt; 48 Hrs</div>
                            <div class="text-xs text-blue-200/80 font-medium">Average Shortlisting</div>
                        </div>
                        <div class="bg-[#031b4e]/60 border border-white/10 rounded-2xl p-4 sm:p-5">
                            <div class="text-2xl sm:text-3xl font-black text-sky-300 mb-1">100%</div>
                            <div class="text-xs text-blue-200/80 font-medium">Verified Credentials</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Services Grid Section -->
<section id="services-list" class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                <i class="fas fa-cubes text-blue-500"></i> What We Offer
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#031b4e] tracking-tight mb-4">
                Specialized Services for Educational Institutions
            </h2>
            <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                Discover our specialized range of educational support programs, talent acquisition pipelines, and digital solutions.
            </p>
        </div>

        <!-- Services Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @forelse($services as $index => $service)
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.06)] border border-slate-100/80 hover:shadow-[0_20px_40px_rgba(3,27,78,0.12)] hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
                
                <!-- Card Header Accent -->
                <div class="h-2 w-full bg-gradient-to-r from-[#2563eb] via-sky-400 to-[#031b4e]"></div>

                <div class="p-6 sm:p-7 flex flex-col flex-grow">
                    <!-- Icon & Badge Row -->
                    <div class="flex items-center justify-between gap-3 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#031b4e] to-[#1e3a8a] text-white flex items-center justify-center text-2xl shadow-lg shadow-blue-950/20 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <i class="{{ $service->icon ?: 'fas fa-graduation-cap' }}"></i>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-bold px-3 py-1 rounded-full shadow-xs">
                            <i class="fas fa-star text-[#fbc043] text-[10px]"></i> Featured
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-extrabold text-[#031b4e] mb-3 group-hover:text-blue-600 transition-colors leading-snug">
                        {{ $service->title }}
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 flex-grow">
                        {{ Str::limit($service->description, 110) }}
                    </p>

                    <!-- Feature Points -->
                    <div class="bg-slate-50/80 rounded-2xl p-4 mb-6 border border-slate-100 space-y-2.5">
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fas fa-check-circle text-emerald-500 text-sm shrink-0"></i>
                            <span class="truncate">Verified Expert Support</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fas fa-check-circle text-blue-500 text-sm shrink-0"></i>
                            <span class="truncate">Customized For Your Need</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-700">
                            <i class="fas fa-check-circle text-purple-500 text-sm shrink-0"></i>
                            <span class="truncate">100% Quality Guaranteed</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('service.details', $service->slug) }}" class="w-full inline-flex items-center justify-center gap-2 bg-[#031b4e] hover:bg-[#2563eb] text-white font-bold text-sm py-3.5 px-4 rounded-xl transition-all duration-300 shadow-md group-hover:shadow-blue-500/25">
                        <span>View Service Details</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 bg-white rounded-3xl shadow-sm border border-slate-100">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="text-xl font-bold text-[#031b4e] mb-2">No Services Available Yet</h4>
                <p class="text-slate-500 text-sm">Please check back soon for our updated service offerings.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 3. Why Choose Us / Institutional Advantage -->
<section class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 bg-white border-y border-slate-200/70 relative overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            <!-- Left Info -->
            <div class="lg:col-span-6">
                <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                    <i class="fas fa-check-double text-blue-500"></i> The Warriors Advantage
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-[#031b4e] tracking-tight leading-tight mb-6">
                    Why Premier Schools & Educators Trust Warriors Educare
                </h2>
                <p class="text-slate-600 text-base leading-relaxed mb-8">
                    We understand that human capital and modern infrastructure define an institution's reputation. We eliminate the guesswork from hiring and digital operations.
                </p>

                <!-- Key Value Pillars -->
                <div class="space-y-5">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-blue-500/20">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#031b4e] text-base mb-1">Multi-Tier Candidate Vetting</h4>
                            <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                                Every candidate undergoes subject evaluation, classroom demo reviews, and credential background authentication.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-emerald-500/20">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#031b4e] text-base mb-1">Rapid 48-Hour Turnaround</h4>
                            <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                                Our active talent database and direct talent matchmaking ensure you never suffer from vacant teaching desks.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-12 h-12 rounded-xl bg-purple-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-purple-500/20">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#031b4e] text-base mb-1">Dedicated Account Management</h4>
                            <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                                Get a dedicated relationship manager who understands your campus culture and specific curriculum demands.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image Banner -->
            <div class="lg:col-span-6 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Educational Team Collaboration" class="w-full h-[450px] sm:h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#031b4e]/90 via-[#031b4e]/30 to-transparent"></div>
                    
                    <!-- Floating Overlay Card -->
                    <div class="absolute bottom-6 left-6 right-6 bg-white/95 backdrop-blur-md p-6 rounded-2xl border border-white/30 shadow-xl">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h4 class="font-black text-[#031b4e] text-lg">Need Immediate Staffing?</h4>
                                <p class="text-slate-600 text-xs sm:text-sm mt-0.5">Post your urgent requirement in under 2 minutes.</p>
                            </div>
                            <a href="{{ route('post-job') }}" class="shrink-0 bg-[#2563eb] hover:bg-blue-700 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-xl transition-colors shadow-md">
                                Post Job <i class="fas fa-plus ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. How We Deliver Excellence (Process Section) -->
<section class="py-20 sm:py-28 px-4 sm:px-6 lg:px-8 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                <i class="fas fa-project-diagram text-blue-500"></i> Seamless Workflow
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#031b4e] tracking-tight mb-4">
                How We Deliver Excellence Step-by-Step
            </h2>
            <p class="text-slate-600 text-base sm:text-lg">
                Our proven structured delivery framework ensures transparent, reliable, and high-standard outcomes.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="bg-white rounded-3xl p-7 shadow-[0_8px_25px_rgba(0,0,0,0.05)] border border-slate-100 relative group hover:-translate-y-1.5 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 font-black text-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                    01
                </div>
                <h3 class="font-extrabold text-[#031b4e] text-lg mb-2">Requirement Analysis</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    We deep-dive into your specific institutional culture, subject criteria, experience needs, and budgetary preferences.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-3xl p-7 shadow-[0_8px_25px_rgba(0,0,0,0.05)] border border-slate-100 relative group hover:-translate-y-1.5 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 font-black text-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                    02
                </div>
                <h3 class="font-extrabold text-[#031b4e] text-lg mb-2">Targeted Matchmaking</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    Our AI-driven database filters and our recruitment team shortlists the top 5% verified educators matching your profile.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-3xl p-7 shadow-[0_8px_25px_rgba(0,0,0,0.05)] border border-slate-100 relative group hover:-translate-y-1.5 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 font-black text-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                    03
                </div>
                <h3 class="font-extrabold text-[#031b4e] text-lg mb-2">Interview & Demo</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    We coordinate direct virtual or in-person interview rounds, mock teaching demos, and technical assessments seamlessly.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-3xl p-7 shadow-[0_8px_25px_rgba(0,0,0,0.05)] border border-slate-100 relative group hover:-translate-y-1.5 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 font-black text-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-sm">
                    04
                </div>
                <h3 class="font-extrabold text-[#031b4e] text-lg mb-2">Onboarding & Support</h3>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                    We assist in formal contract finalization, document verification, and follow-up reviews to guarantee long-term retention.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 5. FAQ Section -->
<section class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 bg-white border-t border-slate-200">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                <i class="fas fa-question-circle text-blue-500"></i> Clear Answers
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#031b4e] tracking-tight mb-3">
                Frequently Asked Questions
            </h2>
            <p class="text-slate-500 text-sm sm:text-base">Everything you need to know about our institutional service contracts.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            <!-- FAQ 1 -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200" :class="active === 1 ? 'border-blue-500 shadow-md bg-blue-50/20' : 'bg-slate-50/50 hover:bg-slate-50'">
                <button @click="active = (active === 1 ? null : 1)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-[#031b4e] text-sm sm:text-base">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-question-circle text-blue-600 shrink-0"></i>
                        How quickly can you fill an urgent teaching or leadership vacancy?
                    </span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="active === 1 ? 'rotate-180 text-blue-600' : ''"></i>
                </button>
                <div x-show="active === 1" x-collapse class="px-5 sm:px-6 pb-6 text-slate-600 text-xs sm:text-sm leading-relaxed pl-12">
                    With our extensive pre-screened repository of 10,000+ registered teachers and educational leaders, we typically provide a shortlisted batch of candidates within 48 to 72 hours of receiving your post.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200" :class="active === 2 ? 'border-blue-500 shadow-md bg-blue-50/20' : 'bg-slate-50/50 hover:bg-slate-50'">
                <button @click="active = (active === 2 ? null : 2)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-[#031b4e] text-sm sm:text-base">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-question-circle text-blue-600 shrink-0"></i>
                        Do you offer candidate replacement if the teacher leaves early?
                    </span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="active === 2 ? 'rotate-180 text-blue-600' : ''"></i>
                </button>
                <div x-show="active === 2" x-collapse class="px-5 sm:px-6 pb-6 text-slate-600 text-xs sm:text-sm leading-relaxed pl-12">
                    Yes. Under our standard institutional agreement, we provide a replacement guarantee period. If an appointed candidate leaves within the contract window, we provide a priority replacement at no extra recruitment charge.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200" :class="active === 3 ? 'border-blue-500 shadow-md bg-blue-50/20' : 'bg-slate-50/50 hover:bg-slate-50'">
                <button @click="active = (active === 3 ? null : 3)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 font-bold text-[#031b4e] text-sm sm:text-base">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-question-circle text-blue-600 shrink-0"></i>
                        Can we get customized digital classroom setup and ERP services?
                    </span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="active === 3 ? 'rotate-180 text-blue-600' : ''"></i>
                </button>
                <div x-show="active === 3" x-collapse class="px-5 sm:px-6 pb-6 text-slate-600 text-xs sm:text-sm leading-relaxed pl-12">
                    Absolutely. Our Digital Support division provides turnkey smart classroom setups, interactive flat panels, campus networking, and tailored School Management ERP solutions with complete staff onboarding.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Bottom CTA Section -->
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[#031b4e] via-[#0a2560] to-[#040e2d] text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
    <div class="relative z-10 max-w-4xl mx-auto">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-4 tracking-tight">
            Ready to Power Up Your Institution's Quality?
        </h2>
        <p class="text-blue-200 text-base sm:text-lg max-w-2xl mx-auto mb-8 font-normal">
            Join hundreds of trusted schools and academic institutes using Warriors Educare to hire exceptional faculty and upgrade infrastructure.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('post-job') }}" class="inline-flex items-center justify-center bg-[#2563eb] hover:bg-blue-600 text-white font-extrabold px-8 py-4 rounded-2xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 group cursor-pointer">
                <i class="fas fa-file-signature mr-2.5 text-sky-200 text-base"></i>
                <span>Post Institutional Requirement</span>
                <i class="fas fa-arrow-right ml-2.5 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center bg-white/10 hover:bg-white/20 border border-white/25 text-white font-extrabold px-8 py-4 rounded-2xl backdrop-blur-md transition-all transform hover:-translate-y-0.5 group cursor-pointer">
                <i class="fas fa-headset mr-2.5 text-sky-300 text-base"></i>
                <span>Contact Our Team</span>
                <i class="fas fa-chevron-right ml-2.5 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>

@endsection
