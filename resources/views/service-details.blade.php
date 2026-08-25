@extends('layouts.app')

@section('title', $service->title . ' - Institutional Solutions - Warriors Educare')

@section('content')

<!-- 1. Hero Header Section -->
<div class="relative metallic-blue-card border-none shadow-none text-white pt-20 pb-16 md:pt-24 md:pb-20 overflow-hidden border-t border-white/10">
    <!-- Ambient Background Light -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-72 h-72 bg-indigo-500/15 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex flex-wrap items-center text-xs text-blue-200/80 space-x-2 font-medium mb-6">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="text-blue-400">/</span>
            <a href="{{ route('services') }}" class="hover:text-white transition-colors">Services</a>
            <span class="text-blue-400">/</span>
            <span class="text-white font-semibold truncate max-w-[200px] sm:max-w-none">{{ $service->title }}</span>
        </nav>

        <div class="max-w-4xl">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-semibold px-3.5 py-1.5 rounded-full backdrop-blur-sm mb-5">
                <i class="fas fa-shield-alt text-[#fbc043]"></i> Verified Institutional Service
            </div>

            <!-- Title & Icon -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 mb-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-[#031b4e] text-white flex items-center justify-center text-3xl sm:text-4xl shadow-xl border border-white/20 shrink-0">
                    <i class="{{ $service->icon ?: 'fas fa-graduation-cap' }}"></i>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight leading-tight">
                        {{ $service->title }}
                    </h1>
                </div>
            </div>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-blue-100/85 leading-relaxed font-normal max-w-3xl">
                {{ $service->description }}
            </p>

            <!-- Quick Trust Highlights -->
            <div class="flex flex-wrap items-center gap-3 sm:gap-6 mt-6 pt-6 border-t border-white/10 text-xs sm:text-sm text-blue-200">
                <span class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-400"></i> Fast Turnaround
                </span>
                <span class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-400"></i> Verified Professionals
                </span>
                <span class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-400"></i> Quality Guaranteed
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for injected HTML service content */
    .service-content-body h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #031b4e;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    .service-content-body h3, .service-content-body h4 {
        font-weight: 700;
        color: #031b4e;
    }
    @media (max-width: 768px) {
        .service-content-body .p-8,
        .service-content-body .p-6 {
            padding: 1.25rem !important;
        }
        .service-content-body .grid {
            gap: 1rem !important;
        }
    }
</style>

<!-- 2. Main Content & Sidebar Layout -->
<div class="py-12 md:py-20 px-4 sm:px-6 lg:px-8 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Main Content Column -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl p-6 sm:p-10 lg:p-12 shadow-[0_10px_35px_rgba(0,0,0,0.05)] border border-slate-100">
                    <!-- Service Body Content -->
                    <div class="text-slate-700 service-content-body leading-relaxed">
                        {!! $service->content !!}
                    </div>

                    <!-- Bottom Guarantee Card -->
                    <div class="mt-12 bg-gradient-to-r from-[#f0f7ff] to-blue-50/70 rounded-2xl p-6 sm:p-8 border border-blue-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="space-y-1">
                            <h4 class="font-extrabold text-[#031b4e] text-lg">Interested in this Service?</h4>
                            <p class="text-slate-600 text-xs sm:text-sm">Get in touch with our institutional experts for a customized package.</p>
                        </div>
                        <a href="{{ route('contact') }}" class="shrink-0 bg-[#2563eb] hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition-all shadow-md shadow-blue-500/20">
                            Book Consultation <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sticky Sidebar Column -->
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                <!-- Quick Contact Card -->
                <div class="bg-gradient-to-br from-[#031b4e] to-[#0a2560] text-white rounded-3xl p-6 sm:p-7 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <span class="inline-flex items-center gap-1.5 bg-white/10 text-sky-300 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 border border-white/10">
                        <i class="fas fa-bolt text-[#fbc043]"></i> Quick Inquiry
                    </span>

                    <h3 class="text-xl font-extrabold text-white mb-2 leading-snug">
                        Need Custom Institutional Solutions?
                    </h3>
                    <p class="text-blue-100/80 text-xs sm:text-sm leading-relaxed mb-6">
                        Speak directly with our senior educational consultants for immediate assistance and customized quotes.
                    </p>

                    <div class="space-y-3">
                        <a href="{{ route('contact') }}" class="w-full inline-flex items-center justify-center gap-2 bg-[#2563eb] hover:bg-blue-600 text-white font-bold text-sm py-3.5 px-4 rounded-xl transition-colors shadow-lg shadow-blue-600/30">
                            <i class="fas fa-envelope text-xs"></i>
                            <span>Send Requirement</span>
                        </a>

                        @if(Route::has('post-job'))
                        <a href="{{ route('post-job') }}" class="w-full inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm py-3.5 px-4 rounded-xl transition-colors backdrop-blur-sm">
                            <i class="fas fa-plus-circle text-xs text-sky-300"></i>
                            <span>Post Job Directly</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Other Services Navigation -->
                @if(isset($allServices) && $allServices->count() > 0)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-base font-extrabold text-[#031b4e] mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                        <span>Other Services</span>
                        <i class="fas fa-layer-group text-blue-500 text-sm"></i>
                    </h3>
                    
                    <div class="space-y-2">
                        @foreach($allServices as $other)
                        <a href="{{ route('service.details', $other->slug) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all text-slate-700 hover:text-blue-600 group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    <i class="{{ $other->icon ?: 'fas fa-cubes' }}"></i>
                                </div>
                                <span class="font-bold text-xs sm:text-sm truncate">{{ $other->title }}</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-slate-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all shrink-0 ml-2"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Institutional Trust Badges -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">
                        Why Choose Warriors Educare
                    </h3>
                    
                    <div class="space-y-3.5">
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs">Vetted Educator Pool</h4>
                                <p class="text-slate-500 text-[11px] leading-relaxed">Rigorous multi-round screening & verification.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs">Fast 48h Turnaround</h4>
                                <p class="text-slate-500 text-[11px] leading-relaxed">Prompt candidate matching for urgent needs.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs">Replacement Guarantee</h4>
                                <p class="text-slate-500 text-[11px] leading-relaxed">Priority free replacement during guarantee period.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
