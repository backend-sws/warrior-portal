@extends('layouts.app')

@section('title', 'Warriors Educare — #1 Education Recruitment Agency & Verified Home Tutors in India')
@section('meta_description', 'Connect with 10,000+ verified home tutors and certified school faculty across India. Fast matching, quality educators, and premium career placements.')

@section('content')
    
    <!-- Welcome Modal -->
    <div x-data="{ 
            showWelcomeModal: false,
            openTuitionRequirement() {
                this.showWelcomeModal = false;
                window.dispatchEvent(new CustomEvent('switch-requirement-tab', { detail: { tab: 'tuition' } }));
                setTimeout(() => {
                    const el = document.getElementById('quick-request-form');
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 150);
            },
            openSchoolRequirement() {
                this.showWelcomeModal = false;
                window.dispatchEvent(new CustomEvent('switch-requirement-tab', { detail: { tab: 'school' } }));
                setTimeout(() => {
                    const el = document.getElementById('quick-request-form');
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 150);
            }
         }" 
         x-init="setTimeout(() => { if(!sessionStorage.getItem('welcomeShown')) { showWelcomeModal = true; sessionStorage.setItem('welcomeShown', '1'); } }, 400);" 
         x-show="showWelcomeModal" 
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-3 sm:p-6 overflow-y-auto"
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         
        <div class="bg-white rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.35)] p-5 sm:p-7 md:p-8 max-w-4xl w-full relative border border-slate-100 my-auto overflow-hidden flex flex-col justify-between" 
             @click.away="showWelcomeModal = false"
             x-show="showWelcomeModal"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95">
             
            <!-- Prominent Close Button -->
            <button @click="showWelcomeModal = false" 
                    type="button"
                    title="Close Popup"
                    aria-label="Close"
                    class="absolute top-4 right-4 sm:top-5 sm:right-5 w-9 h-9 sm:w-10 sm:h-10 bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-500 rounded-full flex items-center justify-center transition-all duration-200 z-50 shadow-xs border border-slate-200/80 active:scale-90 cursor-pointer">
                <i class="fas fa-times text-sm sm:text-base font-bold"></i>
            </button>
            
            <!-- Header -->
            <div class="text-center mb-5 sm:mb-6 pr-8 sm:pr-0 relative z-10">
                <div class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-900 px-3.5 py-1 rounded-full text-[10px] sm:text-xs font-extrabold uppercase tracking-wider mb-2 border border-blue-200/60 shadow-xs">
                    <i class="fas fa-sparkles text-amber-500"></i>
                    <span>India's Trusted Education Network</span>
                </div>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-[#031b4e] mb-1 tracking-tight">Welcome to Warriors Educare</h2>
                <p class="text-slate-500 text-xs sm:text-sm max-w-md mx-auto font-medium">Please select what you are looking for to get instant matching.</p>
            </div>
            
            <!-- 3 Interactive Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 relative z-10">
                
                <!-- Card 1: Hire a Home Tutor -->
                <button type="button" 
                        @click="openTuitionRequirement()" 
                        class="group relative rounded-2xl p-4 sm:p-5 text-left md:text-center transition-all duration-300 bg-gradient-to-b from-blue-50/60 via-white to-blue-50/30 hover:from-blue-50/90 hover:to-white border-2 border-blue-100 hover:border-blue-500 shadow-xs hover:shadow-xl hover:shadow-blue-500/15 hover:-translate-y-1.5 flex flex-row md:flex-col items-center justify-between cursor-pointer w-full gap-3.5">
                    <div class="flex flex-row md:flex-col items-center gap-3 md:gap-0 w-full">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-md shadow-blue-500/25 group-hover:scale-110 group-hover:rotate-2 transition-all duration-300 md:mb-3.5 shrink-0">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="flex-grow text-left md:text-center">
                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider bg-blue-100/90 text-blue-800 group-hover:bg-blue-600 group-hover:text-white px-2.5 py-0.5 rounded-full mb-1 transition-colors">For Parents & Students</span>
                            <h3 class="text-sm sm:text-base font-black text-[#031b4e] group-hover:text-blue-600 mb-0.5 md:mb-1 transition-colors">Hire a Home Tutor</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 group-hover:text-slate-700 leading-snug transition-colors hidden sm:block font-normal">Find verified & experienced home tutors for all classes & subjects.</p>
                        </div>
                    </div>
                    <div class="md:mt-3 md:pt-2.5 md:border-t md:border-slate-100 w-auto md:w-full flex items-center justify-end md:justify-center gap-2 text-xs font-extrabold text-blue-700 group-hover:text-blue-600 transition-colors shrink-0">
                        <span class="hidden md:inline">Fill Requirement</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-100 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center text-blue-700 transition-all shadow-xs group-hover:shadow-md group-hover:shadow-blue-500/30">
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </button>
                
                <!-- Card 2: Hire Teachers & Staff -->
                <button type="button" 
                        @click="openSchoolRequirement()" 
                        class="group relative rounded-2xl p-4 sm:p-5 text-left md:text-center transition-all duration-300 bg-gradient-to-b from-indigo-50/60 via-white to-purple-50/30 hover:from-indigo-50/90 hover:to-white border-2 border-indigo-100 hover:border-indigo-500 shadow-xs hover:shadow-xl hover:shadow-indigo-500/15 hover:-translate-y-1.5 flex flex-row md:flex-col items-center justify-between cursor-pointer w-full gap-3.5">
                    <div class="flex flex-row md:flex-col items-center gap-3 md:gap-0 w-full">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-md shadow-indigo-500/25 group-hover:scale-110 group-hover:rotate-2 transition-all duration-300 md:mb-3.5 shrink-0">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="flex-grow text-left md:text-center">
                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider bg-indigo-100/90 text-indigo-800 group-hover:bg-indigo-600 group-hover:text-white px-2.5 py-0.5 rounded-full mb-1 transition-colors">For Schools & Institutes</span>
                            <h3 class="text-sm sm:text-base font-black text-[#031b4e] group-hover:text-indigo-600 mb-0.5 md:mb-1 transition-colors">Hire School Faculty</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 group-hover:text-slate-700 leading-snug transition-colors hidden sm:block font-normal">Access 10,000+ pre-verified PGT, TGT, PRT teachers & staff.</p>
                        </div>
                    </div>
                    <div class="md:mt-3 md:pt-2.5 md:border-t md:border-slate-100 w-auto md:w-full flex items-center justify-end md:justify-center gap-2 text-xs font-extrabold text-indigo-700 group-hover:text-indigo-600 transition-colors shrink-0">
                        <span class="hidden md:inline">Post Faculty Need</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-indigo-100 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center text-indigo-700 transition-all shadow-xs group-hover:shadow-md group-hover:shadow-indigo-500/30">
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </button>
                
                <!-- Card 3: Join as Teacher / Tutor -->
                @guest
                <button type="button" onclick="openTeacherModal()" 
                   class="group relative rounded-2xl p-4 sm:p-5 text-left md:text-center transition-all duration-300 bg-gradient-to-b from-amber-50/60 via-white to-orange-50/30 hover:from-amber-50/90 hover:to-white border-2 border-amber-100 hover:border-amber-500 shadow-xs hover:shadow-xl hover:shadow-amber-500/15 hover:-translate-y-1.5 flex flex-row md:flex-col items-center justify-between cursor-pointer w-full gap-3.5">
                    <div class="flex flex-row md:flex-col items-center gap-3 md:gap-0 w-full">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-md shadow-amber-500/25 group-hover:scale-110 group-hover:rotate-2 transition-all duration-300 md:mb-3.5 shrink-0">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="flex-grow text-left md:text-center">
                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider bg-amber-100/90 text-amber-900 group-hover:bg-amber-500 group-hover:text-white px-2.5 py-0.5 rounded-full mb-1 transition-colors">For Teachers & Tutors</span>
                            <h3 class="text-sm sm:text-base font-black text-[#031b4e] group-hover:text-amber-800 mb-0.5 md:mb-1 transition-colors">Join as Teacher / Tutor</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 group-hover:text-slate-700 leading-snug transition-colors hidden sm:block font-normal">Find verified home tuitions & school teaching jobs in your city.</p>
                        </div>
                    </div>
                    <div class="md:mt-3 md:pt-2.5 md:border-t md:border-slate-100 w-auto md:w-full flex items-center justify-end md:justify-center gap-2 text-xs font-extrabold text-amber-800 group-hover:text-amber-700 transition-colors shrink-0">
                        <span class="hidden md:inline">Register Free</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-amber-100 group-hover:bg-amber-500 group-hover:text-white flex items-center justify-center text-amber-800 transition-all shadow-xs group-hover:shadow-md group-hover:shadow-amber-500/30">
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </button>
                @else
                <a href="{{ route('candidate.dashboard') }}" 
                   class="group relative rounded-2xl p-4 sm:p-5 text-left md:text-center transition-all duration-300 bg-gradient-to-b from-amber-50/60 via-white to-orange-50/30 hover:from-amber-50/90 hover:to-white border-2 border-amber-100 hover:border-amber-500 shadow-xs hover:shadow-xl hover:shadow-amber-500/15 hover:-translate-y-1.5 flex flex-row md:flex-col items-center justify-between cursor-pointer w-full gap-3.5">
                    <div class="flex flex-row md:flex-col items-center gap-3 md:gap-0 w-full">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-md shadow-amber-500/25 group-hover:scale-110 group-hover:rotate-2 transition-all duration-300 md:mb-3.5 shrink-0">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="flex-grow text-left md:text-center">
                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider bg-amber-100/90 text-amber-900 group-hover:bg-amber-500 group-hover:text-white px-2.5 py-0.5 rounded-full mb-1 transition-colors">For Teachers & Tutors</span>
                            <h3 class="text-sm sm:text-base font-black text-[#031b4e] group-hover:text-amber-800 mb-0.5 md:mb-1 transition-colors">Join as Teacher / Tutor</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 group-hover:text-slate-700 leading-snug transition-colors hidden sm:block font-normal">Find verified home tuitions & school teaching jobs in your city.</p>
                        </div>
                    </div>
                    <div class="md:mt-3 md:pt-2.5 md:border-t md:border-slate-100 w-auto md:w-full flex items-center justify-end md:justify-center gap-2 text-xs font-extrabold text-amber-800 group-hover:text-amber-700 transition-colors shrink-0">
                        <span class="hidden md:inline">Go to Dashboard</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-amber-100 group-hover:bg-amber-500 group-hover:text-white flex items-center justify-center text-amber-800 transition-all shadow-xs group-hover:shadow-md group-hover:shadow-amber-500/30">
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </a>
                @endguest

            </div>
            
            <!-- Bottom Skip Button -->
            <div class="mt-4 sm:mt-5 pt-3 text-center border-t border-slate-100 relative z-10">
                <button type="button" @click="showWelcomeModal = false" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-1.5 rounded-full text-xs font-bold transition-all shadow-xs active:scale-95 cursor-pointer">
                    <span>Continue to Website</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
            </div>
            
            <!-- Decorative blurred backdrop circles -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-100/40 rounded-full blur-3xl pointer-events-none"></div>
        </div>
    </div>
    
        <!-- Hero Banner Section -->
    <style>
        .metallic-bubble {
            border-radius: 50%;
            background: radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.9) 0%, rgba(0, 191, 255, 0.8) 15%, rgba(0, 92, 197, 0.9) 45%, rgba(1, 24, 74, 1) 85%);
            box-shadow: 
                inset -15px -15px 30px rgba(0, 0, 0, 0.7), 
                inset 10px 10px 30px rgba(255, 255, 255, 0.5), 
                0 15px 35px rgba(0, 0, 0, 0.4);
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }
        .bubble-float-1 { animation: float1 15s infinite ease-in-out; }
        .bubble-float-2 { animation: float2 18s infinite ease-in-out reverse; }
        .bubble-float-3 { animation: float3 22s infinite ease-in-out; }
        
        @keyframes float1 { 
            0%, 100% { transform: translateY(0) scale(1); } 
            50% { transform: translateY(-40px) scale(1.05); } 
        }
        @keyframes float2 { 
            0%, 100% { transform: translateY(0) translateX(0); } 
            50% { transform: translateY(-50px) translateX(25px); } 
        }
        @keyframes float3 { 
            0%, 100% { transform: translateY(0) scale(1); } 
            50% { transform: translateY(-30px) scale(0.95); } 
        }
        @keyframes circleGlow {
            0%, 100% { 
                box-shadow: 0 0 15px rgba(255, 255, 255, 0.6), inset 0 0 15px rgba(255, 255, 255, 0.4); 
                border-color: rgba(255, 255, 255, 0.7); 
            }
            50% { 
                box-shadow: 0 0 45px rgba(255, 255, 255, 1), inset 0 0 25px rgba(255, 255, 255, 0.9); 
                border-color: rgba(255, 255, 255, 1); 
            }
        }
        .circle-glow {
            border-style: solid;
            border-width: 2.5px;
            border-radius: 50%;
            animation: circleGlow 4s infinite ease-in-out;
        }
        
        .smoky-metallic-text {
            background: linear-gradient(to right, #ffffff, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            transition: all 0.5s ease;
        }
        .smoky-metallic-text:hover {
            background: linear-gradient(
                90deg, 
                #ffffff 0%, 
                #89b4f8 20%, 
                #005c97 40%, 
                #1e3c72 50%, 
                #2a5298 60%, 
                #89b4f8 80%, 
                #ffffff 100%
            );
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            animation: smokeMove 3s linear infinite;
        }
        @keyframes smokeMove {
            to {
                background-position: 200% center;
            }
        }
        
        section.bg-white, section.bg-slate-50, section.bg-gray-50, section.bg-\[\#f4f7f5\], section.bg-\[\#f4f7f9\] {
            background-image: linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.96)), url('{{ asset('images/enhanced_building.jpg') }}') !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            background-position: center !important;
        }
    </style>

    <section class="relative w-full bg-[#f4f7f9] pt-[140px] pb-16 lg:pt-[160px] lg:pb-24 overflow-hidden font-sans">
        
        <!-- Blurred Background Pattern -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            
            <!-- Blurred Gradient Orbs -->
            <div class="absolute -top-[15%] -left-[10%] w-[50%] h-[70%] rounded-full bg-gradient-to-br from-blue-400/20 to-indigo-500/10 blur-[100px]"></div>
            <div class="absolute top-[10%] -right-[15%] w-[45%] h-[80%] rounded-full bg-gradient-to-tl from-[#fbc043]/20 to-orange-400/10 blur-[120px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[50%] rounded-full bg-gradient-to-tr from-cyan-400/15 to-blue-600/10 blur-[120px]"></div>
        </div>

        <div class="max-w-[1400px] mx-auto px-4 lg:px-8 relative z-20 flex flex-col lg:flex-row items-center lg:items-stretch justify-between">
            
            <!-- Left Column: Typography & CTAs -->
            <div class="w-full lg:w-[42%] flex flex-col justify-center text-[#071520] relative z-20">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-white px-5 py-2.5 rounded-full shadow-sm w-max mb-8">
                    <div class="w-2 h-2 rounded-full bg-[#031b4e]"></div>
                    <span class="text-[10px] font-extrabold text-gray-800 tracking-wider uppercase">Tutors & Mentors</span>
                </div>
                
                <h1 id="hero-title" class="text-4xl sm:text-5xl lg:text-[4rem] xl:text-[4.4rem] leading-[1.15] font-extrabold tracking-tight text-[#0a1922] mb-8 relative z-20">
                    School Staffing & Home Tuition Solutions <br>
                    <div class="relative w-max mt-3 sm:mt-4 mb-2">
                        <span class="bg-[#fbc043] text-[#1d2542] px-5 sm:px-6 py-2 md:py-2.5 rounded-full inline-block relative z-20 shadow-md">Under One Roof.</span>
                    </div>
                </h1>

                <!-- Icon badges -->
                <div class="flex gap-5 mb-8">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-[#031b4e] text-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-[#031b4e] text-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-[#031b4e] text-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>

                <div class="flex gap-6 items-start mb-10 mt-2">
                    <div class="w-16 h-[2px] bg-[#a0aec0] mt-3 hidden md:block opacity-50"></div>
                    <p id="hero-desc" class="text-gray-700 text-[14px] md:text-[15px] max-w-[350px] leading-relaxed font-bold">
                        Warriors Educare helps parents find suitable home tutors and helps schools hire qualified teaching and non-teaching staff.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" onclick="openRequirementModal('tuition')" id="btn-hire" class="bg-[#031b4e] text-white px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-[#021030] hover:scale-105 transition-all shadow-lg flex items-center justify-center cursor-pointer">Hire a Teacher / Tutor</button>
                    @guest
                        <button type="button" onclick="openTeacherModal()" id="btn-join" class="bg-white text-[#031b4e] px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-gray-50 hover:scale-105 transition-all border border-gray-200 shadow-sm flex items-center justify-center gap-2 cursor-pointer">Join as a Teacher / Tutor <i class="fas fa-arrow-right"></i></button>
                    @else
                        <a href="{{ route('candidate.dashboard') }}" id="btn-join" class="bg-white text-[#031b4e] px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-gray-50 hover:scale-105 transition-all border border-gray-200 shadow-sm flex items-center justify-center gap-2 cursor-pointer">Join as a Teacher / Tutor <i class="fas fa-arrow-right"></i></a>
                    @endguest
                </div>
            </div>

            <!-- Center Column: Main Image -->
            <div class="w-full lg:w-[30%] relative mt-16 lg:mt-0 flex justify-center items-center z-10">
                
                <div class="relative w-full max-w-[420px] h-[500px] lg:h-[580px] bg-white rounded-[2.5rem] lg:rounded-[3rem] overflow-hidden shadow-2xl">
                    <img id="main-img" src="{{ asset('images/women.jpg') }}" alt="Main Image" class="w-full h-full object-cover">
                    



                </div>
            </div>

            <!-- Far Right Column: Explore Offerings & Second Image -->
            <div class="w-full lg:w-[18%] flex flex-col justify-center mt-16 lg:mt-0 gap-10">
                
                <div class="pt-4">
                    <h3 class="text-2xl lg:text-3xl font-black mb-3 leading-tight tracking-tight text-[#031b4e]">
                        Explore Our <br><span class="text-[#0ea5e9]">Offerings</span>
                    </h3>
                    <p class="text-slate-800 font-semibold text-[13px] lg:text-[14px] leading-relaxed max-w-[220px]">
                        Whether you're a beginner or looking for advanced tutoring, our community is here to support your journey.
                    </p>
                </div>

                <div class="relative w-full max-w-[220px] h-[280px] rounded-[2rem] overflow-hidden shadow-xl border-4 border-white">
                    <img id="sub-img" src="{{ asset('images/student.png') }}" alt="Secondary Image" class="w-full h-full object-cover">
                    

                </div>

            </div>

        </div>
    </section>

    <!-- Lifestyle and Wellness Section -->
    <section class="relative w-full bg-[#031b4e] text-white">
        <!-- The S-Curve Light Overlay on the Right -->
        <div class="absolute top-[-1px] right-0 w-[55%] lg:w-[45%] h-[80px] lg:h-[120px] bg-[#f4f7f9] rounded-bl-[3rem] lg:rounded-bl-[5rem] z-10">
            <!-- Inverted Corner to blend with the dark left side -->
            <div class="absolute bottom-0 left-[-40px] lg:left-[-60px] w-[40px] lg:w-[60px] h-[40px] lg:h-[60px] bg-transparent rounded-br-[2rem] lg:rounded-br-[3rem]" style="box-shadow: 20px 20px 0 20px #f4f7f9;"></div>
        </div>

        <!-- Main Content of the Dark Section (Statistics) -->
        <div class="max-w-[1400px] mx-auto px-4 lg:px-12 relative z-20 pt-20 lg:pt-28 pb-16 lg:pb-24">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12 w-full">
                <!-- Stat 1 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="500">0</span><span class="text-[#dfa43a]">+</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Current Openings</p>
                </div>
                
                <!-- Stat 2 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="98">0</span><span class="text-[#dfa43a]">%</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Fulfillment Rate</p>
                </div>

                <!-- Stat 3 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="10">0</span>k<span class="text-[#dfa43a]">+</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Jobs Applied</p>
                </div>

                <!-- Stat 4 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="350">0</span><span class="text-[#dfa43a]">+</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Satisfied Schools</p>
                </div>
            </div>
        </div>
        
        <!-- Dripping Liquid Effect -->
        <div class="absolute -bottom-[50px] md:-bottom-[80px] left-0 w-full h-[50px] md:h-[80px] z-[50] pointer-events-none" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 50' preserveAspectRatio='none'%3E%3Cpath fill='%23031b4e' d='M0,0 h300 v10 c-10,0 -15,20 -25,20 c-10,0 -15,-20 -25,-20 c-15,0 -20,40 -35,40 c-15,0 -20,-40 -35,-40 c-10,0 -12,15 -20,15 c-8,0 -10,-15 -20,-15 c-12,0 -18,30 -30,30 c-12,0 -18,-30 -30,-30 c-10,0 -15,25 -25,25 c-10,0 -15,-25 -25,-25 c-5,0 -10,15 -15,15 c-5,0 -10,-15 -15,-15 V0 Z' /%3E%3C/svg%3E&quot;); background-repeat: repeat-x; background-size: 300px 100%;"></div>
    </section>

        <!-- About / Empowering Section -->
        <section class="py-20 bg-white relative">
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row items-center gap-16">
                    
                    <!-- Left Images Grid (Redesigned Premium UI) -->
                    <div class="w-full md:w-1/2 relative flex justify-center items-center py-12 pl-4 lg:pl-12 min-h-[400px]">
                        
                        <!-- Background Container (Horizontal Dark Panel) -->
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[90%] md:w-[85%] h-[260px] bg-[#021438] rounded-[2rem] shadow-2xl flex justify-end items-center pr-8 z-0 overflow-visible border-[6px] border-[#021438]">
                            <!-- Inner decorative border line -->
                            <div class="absolute inset-2 border-2 border-gray-400/20 rounded-[1.5rem] pointer-events-none"></div>
                            
                            <!-- Inner Box (Stats) -->
                            <div class="bg-gradient-to-r from-gray-100 to-gray-300 rounded-[1.5rem] p-6 lg:p-8 shadow-xl relative z-10 mr-6 w-[200px] lg:w-[240px]">
                                <h3 class="text-[#031b4e] text-3xl lg:text-4xl font-black mb-1">7+</h3>
                                <p class="text-[11px] lg:text-xs font-extrabold text-gray-700 uppercase tracking-widest">Years of<br>Experience</p>
                                
                                <!-- Overlapping Arrow Button -->
                                <div id="about-arrow-btn" class="absolute -right-5 lg:-right-6 top-1/2 -translate-y-1/2 bg-[#021438] border-4 border-gray-300 text-white w-12 h-12 lg:w-14 lg:h-14 rounded-xl flex items-center justify-center shadow-lg hover:scale-110 transition-transform cursor-pointer z-20">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Left Large Vertical Image Frame -->
                        <div class="relative z-10 w-[240px] lg:w-[280px] h-[320px] lg:h-[380px] bg-gradient-to-br from-gray-200 to-gray-400 p-3 lg:p-4 rounded-[2rem] shadow-[0_20px_40px_rgba(0,0,0,0.5)] mr-auto lg:-ml-8">
                            <div class="w-full h-full rounded-[1.2rem] overflow-hidden relative border border-gray-400/50 bg-gray-200">
                                <img id="about-main-img" src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Teaching Experience" class="w-full h-full object-cover transition-opacity duration-300">
                                <!-- Subtle dark overlay to match the premium vibe -->
                                <div class="absolute inset-0 bg-[#031b4e]/10 mix-blend-multiply pointer-events-none"></div>
                            </div>

                        </div>

                        <!-- Floating Circular Buttons (Bottom overlapping) -->
                        <div class="absolute bottom-2 lg:bottom-4 right-[25%] lg:right-[30%] z-20 flex gap-4">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-gradient-to-br from-gray-200 to-gray-400 p-1.5 shadow-xl hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="w-full h-full rounded-full bg-[#021438] flex items-center justify-center text-gray-300">
                                    <i class="fas fa-heart text-sm"></i>
                                </div>
                            </div>
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-gradient-to-br from-gray-200 to-gray-400 p-1.5 shadow-xl hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="w-full h-full rounded-full bg-[#021438] flex items-center justify-center text-gray-300">
                                    <i class="fas fa-bookmark text-sm"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Text Content (High-Contrast & Clean Card) -->
                    <div class="w-full md:w-1/2 bg-white/95 backdrop-blur-xl p-6 sm:p-8 lg:p-10 rounded-3xl border border-slate-200/90 shadow-[0_20px_50px_rgba(3,27,78,0.08)] relative z-20">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blue-50 text-[#031b4e] font-extrabold uppercase tracking-wider text-xs mb-3.5 border border-blue-200/70 shadow-xs">
                            <i class="fas fa-sparkles text-amber-500"></i> About Warriors Educare
                        </span>
                        <h2 class="text-3xl md:text-4xl lg:text-[40px] font-black text-[#031b4e] mb-4 leading-tight tracking-tight">
                            Empowering Businesses With The Best Right Talent
                        </h2>
                        <p class="text-slate-700 text-sm sm:text-base font-semibold mb-6 leading-relaxed">
                            At Warriors Educare, we believe that the success of any business hinges on having the right people in place. Our mission is to empower companies by providing access to top-tier academic and administrative talent.
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
                            <div class="flex items-center gap-3 p-3 bg-slate-50/90 rounded-2xl border border-slate-200/70 shadow-xs hover:bg-blue-50/60 transition-colors">
                                <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-[#031b4e] shrink-0 font-bold">
                                    <i class="fas fa-check text-xs text-blue-800"></i>
                                </div>
                                <span class="font-extrabold text-slate-900 text-xs sm:text-sm">Tailored Staffing Solutions</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50/90 rounded-2xl border border-slate-200/70 shadow-xs hover:bg-blue-50/60 transition-colors">
                                <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-[#031b4e] shrink-0 font-bold">
                                    <i class="fas fa-check text-xs text-blue-800"></i>
                                </div>
                                <span class="font-extrabold text-slate-900 text-xs sm:text-sm">Ongoing Support</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50/90 rounded-2xl border border-slate-200/70 shadow-xs hover:bg-blue-50/60 transition-colors">
                                <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-[#031b4e] shrink-0 font-bold">
                                    <i class="fas fa-check text-xs text-blue-800"></i>
                                </div>
                                <span class="font-extrabold text-slate-900 text-xs sm:text-sm">Streamlined Hiring Process</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-slate-50/90 rounded-2xl border border-slate-200/70 shadow-xs hover:bg-blue-50/60 transition-colors">
                                <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-[#031b4e] shrink-0 font-bold">
                                    <i class="fas fa-check text-xs text-blue-800"></i>
                                </div>
                                <span class="font-extrabold text-slate-900 text-xs sm:text-sm">Experienced Team</span>
                            </div>
                        </div>

                        @guest
                            <button type="button" onclick="openTeacherModal()" class="inline-flex items-center justify-center bg-[#031b4e] hover:bg-[#092b77] text-white font-bold py-3.5 px-8 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer text-sm">
                                <span>Join Our Network</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        @else
                            <a href="{{ route('candidate.dashboard') }}" class="inline-flex items-center justify-center bg-[#031b4e] hover:bg-[#092b77] text-white font-bold py-3.5 px-8 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 group text-sm">
                                <span>Go to Dashboard</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </section>

        <!-- Agency Highlight Section (Light Background) -->
        <section class="py-24 bg-gray-50 relative border-t-4 border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative">
                    <!-- ISO Badge Overlapping -->
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] px-8 py-3 flex items-center gap-3 border-b-4 border-[#fbc043] z-30">
                        <i class="fas fa-certificate text-[#031b4e] text-2xl"></i>
                        <div>
                            <p class="font-extrabold text-[#031b4e] text-xl leading-none">ISO</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Certified Agency</p>
                        </div>
                    </div>

                    <!-- Main Blue Container -->
                    <div class="bg-[#031b4e] rounded-[2.5rem] lg:rounded-[4rem] p-8 md:p-12 lg:p-16 relative mt-12 md:mt-8 shadow-2xl border border-white/10">

                        <div class="flex flex-col lg:flex-row gap-12 relative z-10">
                            <!-- Left Column: Title -->
                            <div class="w-full lg:w-5/12 flex flex-col justify-center relative">
                                <span class="text-white/70 font-bold uppercase tracking-[0.2em] text-xs mb-6 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-[#fbc043] rounded-full shadow-[0_0_8px_#fbc043]"></span> Welcome To
                                </span>
                                <h2 class="text-5xl md:text-[4rem] lg:text-[4.5rem] font-black text-white leading-[1.05] tracking-tight uppercase" style="font-family: 'Arial Black', sans-serif;">
                                    Warriors<br>
                                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">Educare</span>
                                </h2>
                                <div class="w-24 h-1.5 bg-gradient-to-r from-[#fbc043] to-[#fbc043]/20 mt-8 rounded-full"></div>

                                <!-- "EXPLORE MORE" button styled as a bottom tab linking to About page -->
                                <div class="mt-12 hidden lg:flex items-center gap-4">
                                    <a href="{{ route('about') }}" class="inline-flex items-center gap-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg border border-white/10 group/btn">
                                        <span>EXPLORE MORE</span>
                                    </a>
                                    <a href="{{ route('about') }}" aria-label="Learn more about Warriors Educare" class="w-14 h-14 bg-[#fbc043] hover:bg-[#e5ae3c] rounded-2xl flex items-center justify-center text-[#031b4e] text-xl shadow-lg transition-transform hover:scale-105">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Right Column: Overlapping Glass Card -->
                            <div class="w-full lg:w-7/12">
                                <!-- This card overlaps the top and right slightly on desktop -->
                                <div class="bg-gradient-to-br from-white/95 to-gray-50/90 backdrop-blur-2xl rounded-[2rem] lg:rounded-[3rem] p-8 md:p-10 lg:p-12 shadow-[0_20px_60px_rgba(0,0,0,0.3)] border-2 border-white relative z-20 lg:-my-8 lg:-mr-8">
                                    <h3 class="text-3xl text-[#031b4e] font-black mb-6 tracking-tight">Who we are?</h3>
                                    <p class="text-lg text-gray-800 font-bold mb-6 leading-relaxed">
                                        Warriors Educare is an education-focused recruitment and teaching platform that connects teachers, tutors, schools, educational institutions, students, and parents through a simple and reliable hiring process.
                                    </p>
                                    <div class="text-gray-600 text-[13px] md:text-[14px] mb-8 leading-relaxed space-y-4">
                                        <p>Our platform is designed for teachers and education professionals who are looking for the right opportunities. Whether you want to <strong class="text-gray-800">apply for a teaching job in a school, college, or educational institution</strong>, or you are looking for opportunities as a <strong class="text-gray-800">tuition teacher or home tutor</strong>, Warriors Educare helps you discover suitable opportunities based on your skills, qualifications, experience, and preferred location.</p>
                                        
                                        <p>At the same time, <strong class="text-gray-800">schools and educational institutions can use our platform to find and hire qualified teachers and administrative staff</strong> for their academic requirements. We help institutions connect with suitable candidates and make their recruitment process more organized and efficient.</p>
                                        
                                        <p>We also support <strong class="text-gray-800">tuition and home tutoring requirements</strong>, helping students and parents connect with suitable tutors for different subjects, classes, and learning needs. Tutors can create their profiles, showcase their qualifications and teaching experience, and explore relevant tuition opportunities.</p>

                                        <div class="p-6 bg-blue-50/50 rounded-2xl border border-blue-100 mt-6">
                                            <h4 class="text-[#031b4e] font-extrabold text-base mb-2">Our Purpose</h4>
                                            <p class="mb-3">Our goal is to create a trusted platform where <strong class="text-[#031b4e]">teachers can find better career and teaching opportunities, schools can find the right teaching talent, and students can connect with suitable tutors</strong>.</p>
                                            
                                            <p>Whether you are a <strong class="text-[#031b4e]">teacher looking for a school job, a tutor looking for tuition students, a school looking to hire teachers, or a parent/student looking for a tutor</strong>, Warriors Educare brings these opportunities together on one platform.</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile explore button -->
                                    <div class="mt-8 flex lg:hidden items-center gap-4">
                                        <a href="{{ route('about') }}" class="inline-flex items-center gap-3 bg-[#031b4e] hover:bg-[#092b77] text-white px-6 py-3 rounded-xl font-bold transition-colors shadow-md">
                                            <span>EXPLORE MORE</span> <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>



    <!-- Categories Section -->
        <section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-[5%] relative bg-slate-50 border-b border-slate-200/60">
            
            <div class="max-w-7xl mx-auto mb-8 text-center">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-blue-50 text-[#031b4e] font-extrabold uppercase tracking-wider text-xs border border-blue-200/60 shadow-xs mb-2.5">
                    <i class="fas fa-th-large text-[#0ea5e9]"></i> Browse Categories
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#031b4e] tracking-tight mb-2">
                    Explore Teaching Jobs by Level
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm font-medium max-w-lg mx-auto">
                    Select a category to explore active vacancies in schools and educational institutions.
                </p>
            </div>

            <style>
                .category-card {
                    background: linear-gradient(135deg, #1e3a8a 0%, #031b4e 100%);
                    border-radius: 1rem;
                    position: relative;
                    overflow: hidden;
                    min-height: 115px;
                    box-shadow: 0 6px 16px -4px rgba(3, 27, 78, 0.25);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-end;
                }
                
                @media (min-width: 768px) {
                    .category-card {
                        border-radius: 1.2rem;
                        min-height: 140px;
                        height: 140px;
                        transform: skewX(-10deg);
                        margin: 0 4px;
                    }
                    .category-card:hover {
                        transform: skewX(-10deg) translateY(-5px);
                        box-shadow: 0 15px 25px -5px rgba(3, 27, 78, 0.35);
                    }
                    .category-inner {
                        transform: skewX(10deg);
                        margin: 0 -12px;
                        padding: 1.25rem 22px !important;
                    }
                    .category-top-right-shape {
                        top: -30px !important;
                        right: 0px !important;
                        width: 95px !important;
                        height: 95px !important;
                        border-radius: 24px !important;
                    }
                    .category-icon-container {
                        top: 14px !important;
                        right: 30px !important;
                    }
                }

                .category-inner {
                    height: 100%;
                    padding: 0.875rem 0.75rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-end;
                    text-align: left;
                    position: relative;
                    width: 100%;
                }

                .category-top-right-shape {
                    position: absolute;
                    top: -18px;
                    right: -10px;
                    width: 58px;
                    height: 58px;
                    background: white;
                    border-radius: 16px;
                    transform: rotate(45deg);
                    box-shadow: -3px 3px 10px rgba(0,0,0,0.12);
                    z-index: 1;
                }

                .category-icon-container {
                    position: absolute;
                    top: 8px;
                    right: 8px;
                    z-index: 2;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            </style>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-6 relative z-10">
                @foreach($categories as $category)
                <a href="{{ route('category.jobs', $category->id) }}"
                    class="block category-card group reveal no-underline">
                    
                    <div class="category-inner">
                        <!-- Top Right White Shape -->
                        <div class="category-top-right-shape"></div>
                        
                        <!-- Icon -->
                        <div class="category-icon-container group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-9 md:h-9" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                              <!-- Users -->
                              <g fill="#009ee3">
                                <!-- Left -->
                                <circle cx="28" cy="35" r="7"/>
                                <path d="M 12 55 C 12 40, 44 40, 44 55 Z"/>
                                <!-- Right -->
                                <circle cx="72" cy="35" r="7"/>
                                <path d="M 56 55 C 56 40, 88 40, 88 55 Z"/>
                                <!-- Center -->
                                <circle cx="50" cy="20" r="9"/>
                                <path d="M 28 55 C 28 35, 72 35, 72 55 Z"/>
                              </g>
                              <!-- Grad Cap -->
                              <g fill="#000000">
                                <polygon points="50,44 95,54 50,65 5,54"/>
                                <path d="M 32 60 L 32 78 Q 50 88 68 78 L 68 60 Z"/>
                                <polygon points="30,60 70,60 68,66 32,66"/>
                                <!-- Tassel -->
                                <line x1="83" y1="52" x2="83" y2="72" stroke="#000000" stroke-width="2.5"/>
                                <rect x="80" y="72" width="6" height="15" rx="2"/>
                              </g>
                            </svg>
                        </div>
                        
                        <!-- Text Content (Bottom Left) -->
                        <div class="relative z-10 pr-2">
                            <h3 class="text-white text-[13px] sm:text-[14px] md:text-[16px] font-semibold tracking-normal mb-1 leading-snug line-clamp-2" title="{{ $category->name }}">
                                {{ $category->name }}
                            </h3>
                            <div class="text-white text-[15px] sm:text-[17px] md:text-[19px] font-bold">
                                {{ $category->jobs_count ?? 0 }}
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <!-- Latest Jobs / Recent Opportunities Section (Moved Right Below Categories) -->
        <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-[5%] relative bg-white border-b border-slate-200/70 overflow-hidden">
            <div class="max-w-7xl mx-auto relative z-10">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 sm:mb-12 gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 text-[#031b4e] font-extrabold uppercase tracking-wider text-xs border border-blue-200/60 shadow-xs mb-2.5">
                            <i class="fas fa-bolt text-[#ff8800]"></i> <span>Verified Vacancies</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#031b4e] tracking-tight">
                            Explore Recent Opportunities
                        </h2>
                        <p class="text-slate-500 text-xs sm:text-sm font-medium mt-1.5 max-w-lg">
                            Apply directly to newly posted teaching vacancies and school requirements across India.
                        </p>
                    </div>

                    <a href="{{ route('jobs') }}" class="hidden sm:inline-flex items-center gap-2 px-6 py-3 bg-[#031b4e] hover:bg-[#092b77] text-white font-bold rounded-full text-xs sm:text-sm shadow-md hover:shadow-lg transition-all group shrink-0">
                        <span>View All Jobs</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Job Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                    @forelse($recentJobs as $job)
                    <div class="bg-white rounded-3xl border border-slate-200/90 hover:border-[#0ea5e9]/50 shadow-[0_4px_20px_rgba(3,27,78,0.05)] hover:shadow-[0_20px_40px_rgba(14,165,233,0.12)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden p-5 sm:p-6">
                        
                        <!-- Top Accent Bar on Hover -->
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#031b4e] via-[#0ea5e9] to-[#38bdf8] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div>
                            <!-- Header Row: Confidential Institution & Status -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-bold text-slate-500 flex items-center gap-1.5 truncate">
                                    <i class="fas fa-shield-alt text-[#0ea5e9] text-xs shrink-0"></i>
                                    <span class="truncate">Verified Educational Institution</span>
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                                </span>
                            </div>

                            <!-- Job Title -->
                            <h3 class="text-base sm:text-lg font-black text-[#031b4e] group-hover:text-[#0ea5e9] transition-colors leading-snug mb-3 line-clamp-2" title="{{ $job->title }}">
                                <a href="{{ route('jobs.show', $job->id) }}" class="hover:underline">
                                    {{ $job->title ?? 'Teacher Vacancy' }}
                                </a>
                            </h3>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @if($job->category)
                                    <span class="bg-blue-50 text-blue-900 border border-blue-200/60 px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1">
                                        <i class="fas fa-folder-open text-[9px] text-blue-600"></i> {{ $job->category->name }}
                                    </span>
                                @endif
                                @if($job->subject)
                                    <span class="bg-purple-50 text-purple-900 border border-purple-200/60 px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1">
                                        <i class="fas fa-book text-[9px] text-purple-600"></i> {{ $job->subject->name }}
                                    </span>
                                @endif
                                @if($job->qualification)
                                    <span class="bg-amber-50 text-amber-900 border border-amber-200/60 px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1">
                                        <i class="fas fa-graduation-cap text-[9px] text-amber-600"></i> {{ $job->qualification->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Description Snippet -->
                            @if($job->description)
                            <p class="text-slate-600 text-xs leading-relaxed mb-4 line-clamp-2">
                                {{ Str::limit(strip_tags($job->description), 95) }}
                            </p>
                            @endif
                        </div>

                        <!-- Card Footer: Location, Salary & CTA Button -->
                        <div class="pt-4 border-t border-slate-100 mt-2 flex flex-col gap-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 font-semibold flex items-center gap-1.5">
                                    <i class="fas fa-map-marker-alt text-rose-500 text-xs shrink-0"></i>
                                    <span>{{ $job->city?->name ?? 'City' }}{{ $job->state ? ', ' . $job->state->name : '' }}</span>
                                </span>
                                @if(!empty($job->salary_range))
                                    <span class="font-extrabold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200 text-[11px]">
                                        {{ $job->salary_range }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('jobs.show', $job->id) }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-50 group-hover:bg-[#031b4e] text-[#031b4e] group-hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition-all duration-200 border border-slate-200 group-hover:border-[#031b4e] shadow-xs">
                                <span>View Details & Apply</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-slate-50 rounded-3xl border border-slate-200/80 p-8">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-50 text-[#031b4e] flex items-center justify-center text-2xl mb-3">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h4 class="font-extrabold text-slate-800 text-base mb-1">No Active Openings Right Now</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">New teaching and academic positions are added daily. You can post your requirement or register as a teacher.</p>
                        <button type="button" onclick="openRequirementModal('school')" class="px-6 py-2.5 bg-[#031b4e] text-white rounded-full text-xs font-bold shadow-md hover:bg-[#092b77] transition-all">
                            Post School Requirement
                        </button>
                    </div>
                    @endforelse
                </div>

                <!-- Mobile View All Button -->
                <div class="mt-8 text-center sm:hidden">
                    <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 px-7 py-3 bg-[#031b4e] text-white font-bold rounded-full text-xs shadow-md">
                        <span>View All Jobs</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </section>


        

        <!-- Services Section -->
        <section class="py-20 px-6 lg:px-[5%] metallic-blue-card border-none shadow-none text-white text-center relative overflow-hidden">
            <div class="absolute top-5 right-[5%] opacity-[0.02] text-7xl md:text-[100px] font-extrabold uppercase pointer-events-none select-none tracking-wider">
                Warriors Educare</div>
            <div class="mb-12 relative z-10 reveal">
                <h4 class="text-white/80 text-base font-medium mb-1.5 uppercase tracking-wider">Providing Everything You
                    Need</h4>
                <h2 class="text-4xl lg:text-5xl font-bold text-white">SCHOOLS</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                @forelse($services->where('title', '!=', 'Home Tutors') as $index => $service)
                <div class="relative bg-white rounded-2xl overflow-hidden shadow-[0_8px_25px_rgba(0,0,0,0.08)] border border-gray-100 flex flex-col group hover:-translate-y-2 transition-transform duration-300 w-full text-left reveal z-10 reveal-delay-{{ ($index % 4) + 1 }}">
                    
                    <!-- Top Right Dark Blue Background -->
                    <div class="absolute top-0 right-0 w-[55%] h-[150px] bg-[#031b4e] rounded-bl-[2.5rem] z-0 pointer-events-none transition-all duration-500 group-hover:scale-105 origin-top-right"></div>

                    <div class="p-6 relative z-10 flex flex-col flex-grow">
                        <!-- Top Badges -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-[#031b4e] text-white px-4 py-1.5 rounded-full text-[11px] font-bold shadow-md tracking-wide">
                                SERVICE
                            </div>
                            <div class="bg-white text-[#031b4e] px-4 py-1.5 rounded-full text-[11px] font-extrabold shadow-md flex items-center justify-center gap-2">
                                <i class="{{ $service->icon }} text-[#fbc043]"></i> FEATURED
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="mb-4 relative z-10">
                            <h3 class="text-[#031b4e] font-black text-xl inline-block bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-xl shadow-sm border border-slate-100">
                                {{ $service->title }}
                            </h3>
                        </div>

                        <!-- Elevated Box -->
                        <div class="bg-white rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] p-5 mb-2 mt-auto border border-gray-50 relative group-hover:shadow-[0_15px_40px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-3.5">
                                <div class="w-5 h-5 rounded-full bg-red-50 flex items-center justify-center text-red-500 text-[9px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">Premium Support</span>
                            </div>
                            <div class="flex items-center gap-3 mb-3.5">
                                <div class="w-5 h-5 rounded-full bg-purple-50 flex items-center justify-center text-purple-500 text-[9px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">Trusted Partner</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 text-[9px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">Quality Assured</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex h-[52px] mt-auto">
                        <a href="{{ route('service.details', $service->slug) }}" class="w-[45%] bg-[#3b82f6] hover:bg-[#2563eb] text-white flex items-center justify-center gap-2 text-[12px] font-bold transition-colors">
                            <i class="fas fa-info-circle text-[13px] opacity-80"></i> Details
                        </a>
                        <a href="{{ route('service.details', $service->slug) }}" class="w-[55%] bg-[#031b4e] hover:bg-[#021030] text-white flex items-center justify-center gap-2 text-[12px] font-bold transition-colors">
                            Explore Now <i class="fas fa-arrow-right text-[11px]"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10 opacity-60">
                    <p>No services currently available.</p>
                </div>
                @endforelse
            </div>
        </section>

        <!-- Tuitions Section -->
        <section class="py-20 px-6 lg:px-[5%] bg-slate-50 text-[#031b4e] relative overflow-hidden border-t border-slate-200">
            <!-- Background Watermark -->
            <div class="absolute top-5 left-1/2 -translate-x-1/2 opacity-5 text-[#031b4e] text-7xl md:text-[100px] font-extrabold uppercase pointer-events-none select-none tracking-wider w-full whitespace-nowrap text-center">
                Home Tuitions
            </div>
            
            <div class="mb-16 relative z-10 text-center reveal">
                <h4 class="text-accent-500 text-sm md:text-base font-semibold mb-2 uppercase tracking-widest">Personalized Learning</h4>
                  <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#031b4e]">Tuitions & Home Tutors</h2>
                <p class="text-slate-600 max-w-2xl mx-auto mt-4 text-sm md:text-base">Find the best home tutors near you. Get personalized learning experiences at your doorstep.</p>
            </div>


            <!-- Featured Tuition Cards Grid -->
            <div class="max-w-7xl mx-auto mb-20 relative z-10 reveal">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-black text-[#031b4e] tracking-tight">Featured Tuition Requirements</h3>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1">Verified home tuition requirements ready for qualified tutors.</p>
                    </div>
                    <a href="{{ route('tuitions') }}" class="inline-flex items-center gap-2 bg-[#031b4e] hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all shadow-md">
                        <span>Explore All Tuitions</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($employerTuitions as $tuition)
                        <div class="bg-white rounded-2xl border border-slate-200/80 hover:border-blue-300 shadow-[0_6px_20px_rgba(3,27,78,0.06)] hover:shadow-[0_12px_30px_rgba(3,27,78,0.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group h-full">
                            
                            <!-- Top Accent Bar -->
                            <div class="h-1.5 w-full bg-gradient-to-r from-[#031b4e] via-blue-600 to-sky-400"></div>

                            <div class="p-5 sm:p-6 flex flex-col flex-grow">
                                <!-- Top Row (Class Badge & Verified) -->
                                <div class="flex items-center justify-between gap-2 mb-4">
                                    <span class="inline-flex items-center gap-1.5 bg-[#031b4e] text-white px-3 py-1 rounded-full text-xs font-bold shadow-xs">
                                        <i class="fas fa-graduation-cap text-sky-300 text-[11px]"></i>
                                        {{ $tuition->class ?? $tuition->student_class ?? 'Class 10' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 border border-emerald-200 text-emerald-700 px-2.5 py-0.5 rounded-full text-[11px] font-bold">
                                        <i class="fas fa-check-circle text-emerald-500 text-[10px]"></i> Verified
                                    </span>
                                </div>

                                <!-- Subject -->
                                <h4 class="text-lg font-extrabold text-[#031b4e] mb-3.5 group-hover:text-blue-600 transition-colors line-clamp-1" title="{{ $tuition->subjects ?? 'All Subjects' }}">
                                    {{ $tuition->subjects ?? 'All Subjects' }}
                                </h4>

                                <!-- Info Box -->
                                <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100 space-y-2.5 mb-5 flex-grow">
                                    <div class="flex items-start gap-2.5 text-xs text-slate-600">
                                        <div class="w-6 h-6 rounded-lg bg-red-50 text-red-500 flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                            <i class="fas fa-map-marker-alt text-[11px]"></i>
                                        </div>
                                        <span class="truncate font-medium pt-0.5" title="{{ $tuition->location ?? 'Location on Request' }}">
                                            {{ $tuition->location ?? 'Location on Request' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-xs text-slate-600">
                                        <div class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 shadow-xs">
                                            <i class="fas fa-book-open text-[10px]"></i>
                                        </div>
                                        <span class="truncate font-medium">
                                            {{ $tuition->board ? $tuition->board : 'CBSE / All Boards' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Footer Row -->
                                <div class="flex items-center justify-between pt-3.5 border-t border-slate-100 mt-auto">
                                    <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1.5">
                                        <i class="far fa-clock text-slate-300"></i> {{ $tuition->created_at ? $tuition->created_at->diffForHumans() : 'Recently' }}
                                    </span>
                                    <a href="{{ auth()->check() ? route('candidate.tuitions.index') : route('contact') }}" class="inline-flex items-center gap-1.5 bg-[#031b4e] hover:bg-blue-600 text-white px-4 py-2 rounded-xl font-bold text-xs transition-all shadow-md group-hover:shadow-blue-500/20">
                                        <span>Apply Now</span>
                                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-white rounded-2xl shadow-sm border border-slate-200/60">
                            <i class="fas fa-chalkboard-teacher text-slate-300 text-3xl mb-3 block"></i>
                            <p class="text-slate-500 font-semibold text-sm">No featured tuition posts currently available.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            
            <div id="quick-request-form" x-data="quickRequirementForm()" x-ref="formContainer" class="max-w-4xl mx-auto mt-20 relative z-10 reveal bg-gradient-to-br from-[#f0f7ff] to-blue-50/80 backdrop-blur-xl rounded-3xl p-6 sm:p-10 shadow-2xl border border-blue-200/80 transition-all duration-300">
                
                {{-- Segmented Toggle Switch --}}
                <div class="flex justify-center mb-8">
                    <div class="inline-flex p-1.5 bg-white/90 backdrop-blur-md rounded-2xl shadow-inner border border-blue-100 gap-1.5 w-full sm:w-auto">
                        <button type="button" @click="switchTab('tuition')"
                            :class="tab === 'tuition' ? 'bg-[#031b4e] text-white shadow-md font-bold' : 'text-slate-600 hover:text-[#031b4e] font-semibold hover:bg-blue-50/80'"
                            class="flex-1 sm:flex-initial px-5 py-3 rounded-xl text-sm transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-graduation-cap text-base" :class="tab === 'tuition' ? 'text-[#38bdf8]' : 'text-slate-400'"></i>
                            <span>Need a Home Tutor</span>
                            <span class="hidden md:inline text-[11px] px-2 py-0.5 rounded-full" :class="tab === 'tuition' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'">Parent / Student</span>
                        </button>
                        <button type="button" @click="switchTab('school')"
                            :class="tab === 'school' ? 'bg-[#031b4e] text-white shadow-md font-bold' : 'text-slate-600 hover:text-[#031b4e] font-semibold hover:bg-blue-50/80'"
                            class="flex-1 sm:flex-initial px-5 py-3 rounded-xl text-sm transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-school text-base" :class="tab === 'school' ? 'text-[#f59e0b]' : 'text-slate-400'"></i>
                            <span>Hire Teachers for School</span>
                            <span class="hidden md:inline text-[11px] px-2 py-0.5 rounded-full" :class="tab === 'school' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'">School / Institute</span>
                        </button>
                    </div>
                </div>

                {{-- Header Content --}}
                <div class="text-center mb-8" x-show="!submitted">
                    <template x-if="tab === 'tuition'">
                        <div>
                            <h3 class="text-2xl md:text-3xl font-extrabold text-[#031b4e] mb-2 tracking-tight">Need a Tutor for Your Child?</h3>
                            <p class="text-slate-600 text-sm md:text-base max-w-lg mx-auto">Fill this quick form and our academic team will match you with the best verified home tutor in your area.</p>
                        </div>
                    </template>
                    <template x-if="tab === 'school'">
                        <div>
                            <h3 class="text-2xl md:text-3xl font-extrabold text-[#031b4e] mb-2 tracking-tight">Hire Qualified Teachers for Your School / Institute</h3>
                            <p class="text-slate-600 text-sm md:text-base max-w-xl mx-auto">Post your faculty requirements and access over 10,000+ pre-verified teachers, lecturers & staff across India.</p>
                        </div>
                    </template>
                </div>

                {{-- Server-Side Flash Messages (Fallback) --}}
                @if(session('tuition_success') || session('school_success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-6 py-5 rounded-2xl flex items-start gap-4 shadow-sm animate-fade-in">
                        <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 text-lg shadow-sm">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-emerald-900 text-base mb-0.5">Requirement Submitted Successfully!</h4>
                            <p class="text-sm text-emerald-700 leading-relaxed">{{ session('tuition_success') ?? session('school_success') }}</p>
                        </div>
                    </div>
                @endif                {{-- Inline AJAX Error Banner --}}
                <div x-show="errorMessage || Object.keys(fieldErrors).length > 0" x-cloak class="mb-6 bg-rose-50/95 border-2 border-rose-300 text-rose-900 px-6 py-5 rounded-2xl shadow-md animate-fade-in">
                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center shrink-0 text-sm shadow-sm mt-0.5">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-extrabold text-rose-900 text-sm mb-1">Please correct the following:</h4>
                            
                            <template x-if="Object.keys(fieldErrors).length > 0">
                                <ul class="space-y-1.5 mt-2">
                                    <template x-for="(errs, field) in fieldErrors" :key="field">
                                        <li class="text-xs font-semibold text-rose-800 flex items-start gap-2 bg-white/70 p-2 rounded-lg border border-rose-200/60">
                                            <i class="fas fa-arrow-circle-right text-rose-500 text-xs mt-0.5 shrink-0"></i>
                                            <span x-text="Array.isArray(errs) ? errs[0] : errs"></span>
                                        </li>
                                    </template>
                                </ul>
                            </template>

                            <template x-if="Object.keys(fieldErrors).length === 0 && errorMessage">
                                <p class="text-xs font-semibold text-rose-800 mt-1" x-text="errorMessage"></p>
                            </template>
                        </div>
                        <button type="button" @click="errorMessage = ''; fieldErrors = {};" class="text-rose-400 hover:text-rose-700 text-sm p-1 rounded-lg hover:bg-rose-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- Inline AJAX Success Celebration State --}}
                <div x-show="submitted" x-cloak class="text-center py-10 px-4 bg-white/90 rounded-2xl border border-emerald-200 shadow-xl space-y-5 animate-fade-in">
                    <div class="w-20 h-20 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-full flex items-center justify-center text-white text-3xl mx-auto shadow-lg shadow-emerald-500/30 ring-8 ring-emerald-50">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="max-w-md mx-auto space-y-2">
                        <h4 class="text-2xl font-extrabold text-[#031b4e]">Request Received Successfully! 🎉</h4>
                        <p class="text-slate-600 text-sm leading-relaxed" x-text="successMessage"></p>
                    </div>
                    <div class="p-4 bg-blue-50/80 rounded-xl border border-blue-100 max-w-md mx-auto text-xs text-[#031b4e]/80 flex items-center justify-center gap-2">
                        <i class="fas fa-clock text-blue-500"></i>
                        <span>Our coordinator will call or WhatsApp you shortly.</span>
                    </div>
                    <div class="pt-3">
                        <button type="button" @click="resetForm()" class="inline-flex items-center gap-2 bg-[#031b4e] hover:bg-[#004de6] text-white px-8 py-3 rounded-full text-sm font-bold shadow-md transition-all hover:scale-105 active:scale-95">
                            <i class="fas fa-redo-alt text-xs"></i> Post Another Requirement
                        </button>
                    </div>
                </div>

                {{-- 1. TUITION FORM --}}
                <div x-show="tab === 'tuition' && !submitted">
                    <form @submit.prevent="submitTuitionForm($event)" action="{{ route('tuition.post') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Parent/Student Name -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Your Name <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user text-sm"></i></span>
                                    <input type="text" name="guest_name" required minlength="3" maxlength="80" 
                                        @input="if(fieldErrors.guest_name) { delete fieldErrors.guest_name; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.guest_name ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. Ramesh Sharma" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.guest_name" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.guest_name ? fieldErrors.guest_name[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Phone Number <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-sm"></i></span>
                                    <input type="tel" name="guest_phone" required minlength="10" maxlength="10" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                        @input="if(fieldErrors.guest_phone) { delete fieldErrors.guest_phone; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.guest_phone ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. 9876543210" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.guest_phone" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.guest_phone ? fieldErrors.guest_phone[0] : ''"></span>
                                </p>
                            </div>
                            
                            <!-- Class -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Student's Class / Grade <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-graduation-cap text-sm"></i></span>
                                    <input type="text" name="student_class" minlength="1" maxlength="50" placeholder="e.g. Class 10 / Class 1-5 / Nursery" required 
                                        @input="if(fieldErrors.student_class) { delete fieldErrors.student_class; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.student_class ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.student_class" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.student_class ? fieldErrors.student_class[0] : ''"></span>
                                </p>
                            </div>
                            
                            <!-- Board -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Education Board <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none z-10"><i class="fas fa-book text-sm"></i></span>
                                    <select name="board" required 
                                        @change="if(fieldErrors.board) { delete fieldErrors.board; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.board ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-10 py-3.5 font-medium transition-colors outline-none appearance-none shadow-sm text-sm cursor-pointer">
                                        <option value="">Select Education Board</option>
                                        <option value="CBSE">CBSE Board</option>
                                        <option value="ICSE">ICSE / ISC Board</option>
                                        <option value="State Board">State Board</option>
                                        <option value="IB / IGCSE">IB / Cambridge / IGCSE</option>
                                        <option value="Other">Other / Competitive Prep</option>
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                                </div>
                                <p x-show="fieldErrors.board" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.board ? fieldErrors.board[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Subjects -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Subjects Needed <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-pencil-alt text-sm"></i></span>
                                    <input type="text" name="subjects" required minlength="2" maxlength="150" 
                                        @input="if(fieldErrors.subjects) { delete fieldErrors.subjects; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.subjects ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. Mathematics, Physics, English, or All Subjects" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.subjects" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.subjects ? fieldErrors.subjects[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Complete Location / Area <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-map-marker-alt text-sm"></i></span>
                                    <input type="text" name="location" required minlength="3" maxlength="200" 
                                        @input="if(fieldErrors.location) { delete fieldErrors.location; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.location ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. Kankarbagh, Patna or Area name" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.location" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.location ? fieldErrors.location[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Pincode -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Pincode</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-mail-bulk text-sm"></i></span>
                                    <input type="text" name="pincode" maxlength="6" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);" 
                                        @input="if(fieldErrors.pincode) { delete fieldErrors.pincode; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.pincode ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. 800001" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm font-mono">
                                </div>
                                <p x-show="fieldErrors.pincode" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.pincode ? fieldErrors.pincode[0] : ''"></span>
                                </p>
                            </div>
                        </div>

                        <div class="text-center pt-2">
                            <button type="submit" :disabled="loading" class="bg-gradient-to-r from-[#031b4e] to-[#004de6] hover:from-[#021338] hover:to-[#003cb8] text-white px-10 py-4 rounded-full font-bold text-base md:text-lg shadow-xl hover:shadow-2xl transition-all duration-300 inline-flex items-center justify-center gap-3 disabled:opacity-60 disabled:cursor-not-allowed hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                                <template x-if="!loading">
                                    <span class="inline-flex items-center gap-2">Post Tuition Requirement <i class="fas fa-paper-plane text-sm"></i></span>
                                </template>
                                <template x-if="loading">
                                    <span class="inline-flex items-center gap-2"><i class="fas fa-circle-notch fa-spin"></i> Submitting...</span>
                                </template>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 2. SCHOOL / INSTITUTE HIRING FORM --}}
                <div x-show="tab === 'school' && !submitted" x-cloak>
                    <form @submit.prevent="submitSchoolForm($event)" action="{{ route('school.requirement.post') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        {{-- Job Title --}}
                        <div>
                            <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Job Title / Position Name <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-briefcase text-sm"></i></span>
                                <input type="text" name="title" required minlength="3" maxlength="150" 
                                    @input="if(fieldErrors.title) { delete fieldErrors.title; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                    :class="fieldErrors.title ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                    placeholder="e.g. Senior Physics Teacher / PRT All Subjects / Academic Coordinator" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                            </div>
                            <p x-show="fieldErrors.title" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.title ? fieldErrors.title[0] : ''"></span>
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Institution Name -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">School / Institution Name <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-school text-sm"></i></span>
                                    <input type="text" name="school_name" required minlength="3" maxlength="150" 
                                        @input="if(fieldErrors.school_name) { delete fieldErrors.school_name; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.school_name ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. St. Xavier's High School / Apex Academy" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.school_name" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.school_name ? fieldErrors.school_name[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Contact Person -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Contact Person & Designation <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user-tie text-sm"></i></span>
                                    <input type="text" name="contact_person" required minlength="3" maxlength="80" 
                                        @input="if(fieldErrors.contact_person) { delete fieldErrors.contact_person; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.contact_person ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. Ramesh Kumar (Principal / HR Head)" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.contact_person" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.contact_person ? fieldErrors.contact_person[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Contact Phone / Mobile <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-sm"></i></span>
                                    <input type="tel" name="phone" required minlength="10" maxlength="10" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                        @input="if(fieldErrors.phone) { delete fieldErrors.phone; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.phone ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. 9876543210" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.phone" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.phone ? fieldErrors.phone[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Official Email (Optional)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                                    <input type="email" name="email" 
                                        @input="if(fieldErrors.email) { delete fieldErrors.email; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.email ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        placeholder="e.g. hr@schoolname.org" class="w-full bg-white border rounded-xl pl-11 pr-4 py-3.5 font-medium placeholder-slate-400 transition-colors outline-none shadow-sm text-sm">
                                </div>
                                <p x-show="fieldErrors.email" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.email ? fieldErrors.email[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Job Category -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Job Category <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-layer-group text-sm"></i></span>
                                    <select name="category_id" x-model="school_category_id" @change="fetchSchoolSubjects(); if(fieldErrors.category_id) { delete fieldErrors.category_id; if(Object.keys(fieldErrors).length===0) errorMessage=''; }" required 
                                        :class="fieldErrors.category_id ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-10 py-3.5 font-medium transition-colors outline-none appearance-none shadow-sm text-sm cursor-pointer">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                                </div>
                                <p x-show="fieldErrors.category_id" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.category_id ? fieldErrors.category_id[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Subject (Dynamic based on Category) -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Subject <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-book text-sm"></i></span>
                                    <select name="subject_id" x-model="school_subject_id" :disabled="!school_category_id || loadingSchoolSubjects" required 
                                        @change="if(fieldErrors.subject_id) { delete fieldErrors.subject_id; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.subject_id ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-10 py-3.5 font-medium transition-colors outline-none appearance-none shadow-sm text-sm cursor-pointer disabled:opacity-50 disabled:bg-slate-50">
                                        <option value="" x-text="!school_category_id ? '— First Select Category —' : (loadingSchoolSubjects ? 'Loading subjects...' : 'Select Subject')"></option>
                                        <template x-for="subj in school_subjects" :key="subj.id">
                                            <option :value="subj.id" x-text="subj.name"></option>
                                        </template>
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                                </div>
                                <p x-show="fieldErrors.subject_id" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.subject_id ? fieldErrors.subject_id[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Required Qualification -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Required Qualification <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-graduation-cap text-sm"></i></span>
                                    <select name="qualification_id" x-model="school_qualification_id" :disabled="!school_subject_id" required 
                                        @change="if(fieldErrors.qualification_id) { delete fieldErrors.qualification_id; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.qualification_id ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-10 py-3.5 font-medium transition-colors outline-none appearance-none shadow-sm text-sm cursor-pointer disabled:opacity-50 disabled:bg-slate-50">
                                        <option value="" x-text="!school_subject_id ? '— First Select Subject —' : 'Select Qualification'"></option>
                                        @foreach($qualifications as $qualification)
                                            <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                                </div>
                                <p x-show="fieldErrors.qualification_id" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.qualification_id ? fieldErrors.qualification_id[0] : ''"></span>
                                </p>
                            </div>

                            <!-- State -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">State <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-map text-sm"></i></span>
                                    <select name="state_id" x-model="school_state_id" @change="fetchSchoolCities(); if(fieldErrors.state_id) { delete fieldErrors.state_id; if(Object.keys(fieldErrors).length===0) errorMessage=''; }" required 
                                        :class="fieldErrors.state_id ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-10 py-3.5 font-medium transition-colors outline-none appearance-none shadow-sm text-sm cursor-pointer">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                                </div>
                                <p x-show="fieldErrors.state_id" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.state_id ? fieldErrors.state_id[0] : ''"></span>
                                </p>
                            </div>

                            <!-- City (Dynamic based on State) -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">City <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-city text-sm"></i></span>
                                    <select name="city_id" x-model="school_city_id" :disabled="!school_state_id || loadingSchoolCities" required 
                                        @change="if(fieldErrors.city_id) { delete fieldErrors.city_id; if(Object.keys(fieldErrors).length===0) errorMessage=''; }"
                                        :class="fieldErrors.city_id ? 'border-rose-400 bg-rose-50/30 ring-2 ring-rose-200 text-rose-900' : 'border-blue-200 focus:border-[#031b4e] focus:ring-2 focus:ring-[#031b4e]/30 text-[#031b4e]'"
                                        class="w-full bg-white border rounded-xl pl-11 pr-10 py-3.5 font-medium transition-colors outline-none appearance-none shadow-sm text-sm cursor-pointer disabled:opacity-50 disabled:bg-slate-50">
                                        <option value="" x-text="!school_state_id ? '— First Select State —' : (loadingSchoolCities ? 'Loading cities...' : 'Select City')"></option>
                                        <template x-for="city in school_cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></span>
                                </div>
                                <p x-show="fieldErrors.city_id" x-cloak class="mt-1.5 text-xs font-bold text-rose-600 flex items-center gap-1.5 animate-fade-in">
                                    <i class="fas fa-exclamation-circle text-xs"></i> <span x-text="fieldErrors.city_id ? fieldErrors.city_id[0] : ''"></span>
                                </p>
                            </div>

                            <!-- Salary Range -->
                            <div>
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Salary Range / Budget (Monthly)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-rupee-sign text-sm"></i></span>
                                    <input type="text" name="salary_range" maxlength="80" placeholder="e.g. ₹35,000 - ₹50,000 / Negotiable" class="w-full bg-white border border-blue-200 rounded-xl pl-11 pr-4 py-3.5 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none shadow-sm text-sm">
                                </div>
                            </div>

                            <!-- Additional Notes / Description -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-[#031b4e] uppercase tracking-wider mb-2">Job Description & Experience Requirements (Optional)</label>
                                <div class="relative">
                                    <textarea name="description" rows="2" maxlength="1500" placeholder="e.g. Looking for an experienced teacher with B.Ed and minimum 2+ years of teaching experience..." class="w-full bg-white border border-blue-200 rounded-xl p-4 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none shadow-sm text-sm resize-none"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-2">
                            <button type="submit" :disabled="loading" class="bg-gradient-to-r from-[#031b4e] to-[#004de6] hover:from-[#021338] hover:to-[#003cb8] text-white px-10 py-4 rounded-full font-bold text-base md:text-lg shadow-xl hover:shadow-2xl transition-all duration-300 inline-flex items-center justify-center gap-3 disabled:opacity-60 disabled:cursor-not-allowed hover:-translate-y-0.5 active:translate-y-0">
                                <template x-if="!loading">
                                    <span class="inline-flex items-center gap-2">Submit Job for Approval <i class="fas fa-arrow-right text-sm"></i></span>
                                </template>
                                <template x-if="loading">
                                    <span class="inline-flex items-center gap-2"><i class="fas fa-circle-notch fa-spin"></i> Submitting...</span>
                                </template>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
            function quickRequirementForm() {
                return {
                    tab: 'tuition',
                    loading: false,
                    submitted: false,
                    successMessage: '',
                    errorMessage: '',
                    fieldErrors: {},

                    // School form dynamic state
                    school_category_id: '',
                    school_subject_id: '',
                    school_qualification_id: '',
                    school_state_id: '',
                    school_city_id: '',
                    school_subjects: [],
                    school_cities: [],
                    loadingSchoolSubjects: false,
                    loadingSchoolCities: false,

                    init() {
                        window.addEventListener('switch-requirement-tab', (e) => {
                            if (e.detail && e.detail.tab) {
                                this.switchTab(e.detail.tab);
                            }
                        });

                        const urlParams = new URLSearchParams(window.location.search);
                        const tabParam = urlParams.get('tab') || urlParams.get('requirement');
                        if (tabParam === 'school' || tabParam === 'tuition') {
                            this.switchTab(tabParam);
                        }
                    },

                    switchTab(newTab) {
                        this.tab = newTab;
                        this.errorMessage = '';
                        this.fieldErrors = {};
                    },
                    resetForm() {
                        this.submitted = false;
                        this.successMessage = '';
                        this.errorMessage = '';
                        this.fieldErrors = {};
                        this.$nextTick(() => {
                            this.scrollToSection();
                        });
                    },
                    scrollToSection() {
                        const el = document.getElementById('quick-request-form');
                        if (el) {
                            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    },
                    fetchSchoolSubjects() {
                        this.school_subject_id = '';
                        this.school_qualification_id = '';
                        if (this.school_category_id) {
                            this.loadingSchoolSubjects = true;
                            fetch(`/api/categories/${this.school_category_id}/subjects`)
                                .then(res => res.json())
                                .then(data => {
                                    this.school_subjects = data;
                                })
                                .catch(err => {
                                    console.error('Error fetching subjects:', err);
                                    this.school_subjects = [];
                                })
                                .finally(() => {
                                    this.loadingSchoolSubjects = false;
                                });
                        } else {
                            this.school_subjects = [];
                        }
                    },
                    fetchSchoolCities() {
                        this.school_city_id = '';
                        if (this.school_state_id) {
                            this.loadingSchoolCities = true;
                            fetch(`/api/states/${this.school_state_id}/cities`)
                                .then(res => res.json())
                                .then(data => {
                                    this.school_cities = data;
                                })
                                .catch(err => {
                                    console.error('Error fetching cities:', err);
                                    this.school_cities = [];
                                })
                                .finally(() => {
                                    this.loadingSchoolCities = false;
                                });
                        } else {
                            this.school_cities = [];
                        }
                    },
                    async submitTuitionForm(event) {
                        const form = event.target;
                        const formData = new FormData(form);
                        this.loading = true;
                        this.errorMessage = '';
                        this.fieldErrors = {};

                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token') || '';
                            const response = await fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: formData
                            });

                            let data = {};
                            const contentType = response.headers.get('content-type') || '';
                            if (contentType.includes('application/json')) {
                                data = await response.json();
                            } else {
                                const text = await response.text();
                                try { data = JSON.parse(text); } catch (e) { data = {}; }
                            }

                            if (response.ok && data.success) {
                                if (typeof window.trackLeadConversion === 'function') {
                                    window.trackLeadConversion('home_tuition', {
                                        form_name: 'Homepage Tuition Form'
                                    });
                                }
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                    return;
                                }
                                this.submitted = true;
                                this.successMessage = data.message || 'Your tuition requirement has been posted successfully! Our team will contact you soon.';
                                form.reset();
                                this.fieldErrors = {};
                                this.scrollToSection();
                            } else {
                                if (response.status === 419) {
                                    this.errorMessage = 'Your browser session has expired. Please refresh the page (F5) and submit again.';
                                } else if (data.errors && typeof data.errors === 'object' && Object.keys(data.errors).length > 0) {
                                    this.fieldErrors = data.errors;
                                    this.errorMessage = data.message || 'Please correct the highlighted fields below.';
                                } else if (data.message) {
                                    this.errorMessage = data.message;
                                } else {
                                    this.errorMessage = 'Please check the entered details and correct any errors.';
                                }
                                this.scrollToSection();
                            }
                        } catch (err) {
                            console.error('Tuition submission error:', err);
                            this.errorMessage = 'Unable to complete request. Please verify your connection or refresh the page.';
                            this.scrollToSection();
                        } finally {
                            this.loading = false;
                        }
                    },
                    async submitSchoolForm(event) {
                        const form = event.target;
                        const formData = new FormData(form);
                        this.loading = true;
                        this.errorMessage = '';
                        this.fieldErrors = {};

                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token') || '';
                            const response = await fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: formData
                            });

                            let data = {};
                            const contentType = response.headers.get('content-type') || '';
                            if (contentType.includes('application/json')) {
                                data = await response.json();
                            } else {
                                const text = await response.text();
                                try { data = JSON.parse(text); } catch (e) { data = {}; }
                            }

                            if (response.ok && data.success) {
                                if (typeof window.trackLeadConversion === 'function') {
                                    window.trackLeadConversion('school_hiring', {
                                        form_name: 'Homepage School Hiring Form'
                                    });
                                }
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                    return;
                                }
                                this.submitted = true;
                                this.successMessage = data.message || 'Your job requirement has been submitted for approval! Our administration team will review and approve it shortly.';
                                form.reset();
                                this.fieldErrors = {};
                                this.school_subjects = [];
                                this.school_cities = [];
                                this.school_category_id = '';
                                this.school_subject_id = '';
                                this.school_qualification_id = '';
                                this.school_state_id = '';
                                this.school_city_id = '';
                                this.scrollToSection();
                            } else {
                                if (response.status === 419) {
                                    this.errorMessage = 'Your browser session has expired. Please refresh the page (F5) and submit again.';
                                } else if (data.errors && typeof data.errors === 'object' && Object.keys(data.errors).length > 0) {
                                    this.fieldErrors = data.errors;
                                    this.errorMessage = data.message || 'Please correct the highlighted fields below.';
                                } else if (data.message) {
                                    this.errorMessage = data.message;
                                } else {
                                    this.errorMessage = 'Please check the entered details and correct any errors.';
                                }
                                this.scrollToSection();
                            }
                        } catch (err) {
                            console.error('School submission error:', err);
                            this.errorMessage = 'Unable to complete request. Please verify your connection or refresh the page.';
                            this.scrollToSection();
                        } finally {
                            this.loading = false;
                        }
                    }
                };
            }

            // Auto-scroll on hash or session flash if non-ajax redirect occurs
            document.addEventListener('DOMContentLoaded', () => {
                if (window.location.hash === '#quick-request-form' || {{ (session('tuition_success') || session('school_success')) ? 'true' : 'false' }}) {
                    setTimeout(() => {
                        const el = document.getElementById('quick-request-form');
                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 200);
                }
            });
            </script>
        </section>

    <!-- Our Clients -->
        <section class="bg-white py-14 overflow-hidden border-b border-slate-100">
            <div class="text-left mb-6 px-6 lg:px-[5%] reveal">
                <h2 class="text-3xl font-bold text-slate-800 text-center mb-10">Our Clients</h2>
            </div>
            <div class="swiper marquee-swiper reveal">
                <div class="swiper-wrapper items-center">
                    @forelse($clients as $client)
                    <div class="swiper-slide w-auto">
                        <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.2)] flex items-center justify-center min-w-[180px] h-20 transition-all duration-300 hover:-translate-y-1.5 hover:bg-white/60 hover:border-[#031b4e]/50 hover:shadow-[0_8px_32px_rgba(64,186,115,0.2)] cursor-grab active:cursor-grabbing group overflow-hidden">
                            <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}" class="max-h-12 max-w-full object-contain transition-all duration-300">
                        </div>
                    </div>
                    @empty
                    <div class="w-full text-center text-slate-500 py-4 italic">
                        Our trusted clients will appear here.
                    </div>
                    @endforelse
                </div>

                </div>
            </div>
            </div>
        </section>

        <!-- Available On Section -->
        <section class="py-16 bg-white overflow-hidden border-b border-slate-100">
            <div class="text-center reveal mb-10 px-6 lg:px-[5%]">
                <h2 class="text-3xl font-bold text-slate-800">We are available on</h2>
            </div>

            <style>
                @keyframes marqueeLeftAvailable {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .animate-marquee-available {
                    animation: marqueeLeftAvailable 30s linear infinite reverse;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee-available:hover {
                    animation-play-state: paused;
                }
                .available-card {
                    flex-shrink: 0;
                }
                .fade-edges-available {
                    -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                    mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                }
            </style>

            <div class="overflow-hidden w-full relative z-10 fade-edges-available reveal">
                <div class="animate-marquee-available flex gap-6 px-3">
                    @for($i = 0; $i < 3; $i++)
                    <div class="flex gap-6">
                        <!-- Card 1: Naukri -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-2xl tracking-tight font-sans"><span class="font-black" style="color: #1e3a8a;">naukri</span><span class="font-bold" style="color: #031b4e;">.com</span></span>
                        </div>
                        <!-- Card 2: Job Hai -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <div class="font-black text-xl leading-tight text-center font-sans tracking-tight" style="color: #00c853;">JOB<span style="color: #16a34a;" class="text-lg ml-1">✓</span><br><span style="color: #1e293b;">hai</span></div>
                        </div>
                        <!-- Card 3: Justdial -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-2xl tracking-tighter font-black font-sans"><span style="color: #005fb8;">Just</span><span style="color: #ff5e00;">dial</span></span>
                        </div>
                        <!-- Card 4: LinkedIn -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-bold text-2xl flex items-center gap-1.5 font-sans tracking-tight" style="color: #0a66c2;">Linked<i class="fab fa-linkedin"></i></span>
                        </div>
                        <!-- Card 5: Indeed -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-2xl tracking-tighter font-sans flex items-center gap-1" style="color: #2164f3;">indeed</span>
                        </div>
                        <!-- Card 6: Glassdoor -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-xl tracking-tight font-sans" style="color: #0caa41;">glassdoor</span>
                        </div>
                        <!-- Card 7: foundit -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-xl tracking-tight font-sans" style="color: #6c2da5;">foundit</span>
                        </div>
                        <!-- Card 8: Shine -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-xl tracking-tight font-sans"><span class="font-black" style="color: #154696;">Shine</span><span class="font-bold" style="color: #ff9800;">.com</span></span>
                        </div>
                        <!-- Card 9: Apna -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-2xl tracking-tighter font-sans" style="color: #00a650;">apna</span>
                        </div>
                        <!-- Card 10: TeacherOn -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-2xl tracking-tighter font-black font-sans"><span style="color: #1e293b;">Teacher</span><span style="color: #f15a29;">On</span></span>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </section>



        

        <!-- Testimonial Section -->
        <section class="py-20 px-6 lg:px-[5%] text-center relative bg-slate-50">
            
            <div class="mb-8 relative z-10 reveal">
                <h4 class="text-accent-yellow text-base font-medium mb-1.5 uppercase tracking-wider">Testimonial</h4>
                <h2 class="text-slate-800 text-3xl lg:text-4xl font-bold mb-4">What Our Clients Has To Say About Us</h2>
                <p class="max-w-2xl mx-auto text-[13px] text-slate-600 leading-relaxed">
                    Discover first hand experiences as our satisfied clients share their testimonials about the exceptional
                    recruitment services we provide. Hear what they have to say about our commitment to finding the right
                    talent.
                </p>
            </div>

            @if(isset($testimonials) && count($testimonials) > 0)
            <style>
                @keyframes marqueeLeft {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                @keyframes marqueeRight {
                    0% { transform: translateX(-50%); }
                    100% { transform: translateX(0); }
                }
                .animate-marquee-left {
                    animation: marqueeLeft 35s linear infinite;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee-right {
                    animation: marqueeRight 35s linear infinite;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee-left:hover, .animate-marquee-right:hover {
                    animation-play-state: paused;
                }
                .testimonial-card-w {
                    width: 380px;
                    flex-shrink: 0;
                    white-space: normal;
                }
                .fade-edges {
                    -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                    mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                }
            </style>

            <!-- Marquee Row 1 (Right to Left) -->
            <div class="overflow-hidden w-full relative z-10 mt-8 mb-4 fade-edges reveal">
                <div class="animate-marquee-left flex" style="padding-top: 35px; padding-bottom: 10px;">
                    @for($i = 0; $i < 2; $i++)
                    <div class="flex gap-6 px-3">
                        @foreach($testimonials as $testimonial)
                        <div class="testimonial-card-w border border-green-100 rounded-2xl p-8 pt-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] transition-all duration-300" style="background-color: #f4f7f5;">
                            <div class="absolute top-6 right-6 text-[#031b4e]/10 text-4xl"><i class="fas fa-quote-right"></i></div>
                            <div class="w-16 h-16 rounded-full -mt-[60px] mx-auto mb-4 border-4 border-white relative overflow-hidden shadow-md flex items-center justify-center" style="background-color: #031b4e;">
                                @if($testimonial->image_path)
                                    <img src="{{ Storage::url($testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover bg-white">
                                @else
                                    <span class="text-xl font-bold text-white">{{ substr($testimonial->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <p class="text-[13px] text-slate-600 leading-relaxed mb-5 italic line-clamp-4 relative z-10">"{{ $testimonial->message }}"</p>
                            <div class="flex justify-center gap-1 text-accent-yellow text-[12px] mb-3 relative z-10">
                                @for($stars=0; $stars<$testimonial->rating; $stars++) <i class="fas fa-star"></i> @endfor
                                @for($stars=0; $stars<(5-$testimonial->rating); $stars++) <i class="far fa-star text-slate-300"></i> @endfor
                            </div>
                            <h4 class="text-slate-800 text-base font-extrabold mb-0.5 text-center relative z-10">{{ $testimonial->name }}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center relative z-10">{{ $testimonial->role }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Marquee Row 2 (Left to Right) -->
            <div class="overflow-hidden w-full relative z-10 mb-8 fade-edges reveal reveal-delay-1">
                <div class="animate-marquee-right flex" style="padding-top: 35px; padding-bottom: 10px;">
                    @for($i = 0; $i < 2; $i++)
                    <div class="flex gap-6 px-3">
                        @foreach($testimonials->reverse() as $testimonial)
                        <div class="testimonial-card-w border border-green-100 rounded-2xl p-8 pt-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] transition-all duration-300" style="background-color: #f4f7f5;">
                            <div class="absolute top-6 right-6 text-[#031b4e]/10 text-4xl"><i class="fas fa-quote-right"></i></div>
                            <div class="w-16 h-16 rounded-full -mt-[60px] mx-auto mb-4 border-4 border-white relative overflow-hidden shadow-md flex items-center justify-center" style="background-color: #031b4e;">
                                @if($testimonial->image_path)
                                    <img src="{{ Storage::url($testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover bg-white">
                                @else
                                    <span class="text-xl font-bold text-white">{{ substr($testimonial->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <p class="text-[13px] text-slate-600 leading-relaxed mb-5 italic line-clamp-4 relative z-10">"{{ $testimonial->message }}"</p>
                            <div class="flex justify-center gap-1 text-accent-yellow text-[12px] mb-3 relative z-10">
                                @for($stars=0; $stars<$testimonial->rating; $stars++) <i class="fas fa-star"></i> @endfor
                                @for($stars=0; $stars<(5-$testimonial->rating); $stars++) <i class="far fa-star text-slate-300"></i> @endfor
                            </div>
                            <h4 class="text-slate-800 text-base font-extrabold mb-0.5 text-center relative z-10">{{ $testimonial->name }}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center relative z-10">{{ $testimonial->role }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endfor
                </div>
            </div>
            @else
            <div class="text-center py-10 opacity-60 text-slate-800 relative z-10">
                <p>No testimonials available.</p>
            </div>
            @endif
        </section>

                <!-- New Contact Us Section -->
        <section class="py-24 bg-[#f4f7f5] relative overflow-hidden font-sans" id="contact-us-section">
            <!-- Decorative curved lines background (left) -->
            <svg class="absolute left-[-15%] top-10 w-[50%] h-[120%] z-0 text-[#e6ede8] pointer-events-none opacity-80" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M -50 300 C 50 150, 250 50, 450 -50" stroke="currentColor" stroke-width="35" stroke-linecap="round"/>
                <path d="M 0 350 C 100 200, 300 100, 500 0" stroke="currentColor" stroke-width="35" stroke-linecap="round"/>
                <path d="M 50 400 C 150 250, 350 150, 550 50" stroke="currentColor" stroke-width="35" stroke-linecap="round"/>
            </svg>
            <svg class="absolute left-[30%] bottom-[-20%] w-[30%] h-[80%] z-0 text-[#e6ede8] pointer-events-none opacity-80" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M 100 450 C 150 250, 250 150, 450 50" stroke="currentColor" stroke-width="30" stroke-linecap="round"/>
                <path d="M 150 500 C 200 300, 300 200, 500 100" stroke="currentColor" stroke-width="30" stroke-linecap="round"/>
            </svg>
            
            <div class="container mx-auto max-w-[1000px] px-6 relative z-10">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-[#e0e7ff] text-[#1e3a8a] text-[11px] font-bold uppercase tracking-widest mb-4">
                        <i class="fas fa-building text-[11px]"></i> CONTACT US
                    </div>
                    <h2 class="text-3xl lg:text-[38px] font-bold text-gray-900 tracking-tight">Let's Start the Conversation</h2>
                </div>

                <style>
                    .neu-card {
                        background-color: #e6e9f0;
                        border-radius: 32px;
                        box-shadow: 12px 12px 24px #c4c6cc, -12px -12px 24px #ffffff;
                    }
                    .neu-input {
                        background-color: #e6e9f0;
                        border-radius: 12px;
                        box-shadow: inset 4px 4px 8px #c4c6cc, inset -4px -4px 8px #ffffff;
                        border: none;
                        outline: none;
                        color: #475569;
                    }
                    .neu-input::placeholder {
                        color: #94a3b8;
                    }
                    .neu-btn {
                        background-color: #e6e9f0;
                        border-radius: 12px;
                        box-shadow: 4px 4px 8px #c4c6cc, -4px -4px 8px #ffffff;
                        color: #2563eb;
                        transition: all 0.2s ease-in-out;
                    }
                    .neu-btn:hover {
                        box-shadow: inset 4px 4px 8px #c4c6cc, inset -4px -4px 8px #ffffff;
                    }
                </style>
                <div class="neu-card p-8 lg:p-14 flex flex-col lg:flex-row gap-12 lg:gap-16 relative overflow-hidden group">
                    
                    <!-- Animated Pattern Background -->
                    <div class="absolute inset-0 z-0 opacity-5 pointer-events-none animate-pattern-move" style="background-image: url('{{ asset('images/network-pattern.svg') }}'); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>

                    <!-- Left: Form -->
                    <div class="w-full lg:w-[58%] relative z-10 flex flex-col items-center lg:items-start text-center lg:text-left">
                        <h3 class="text-[26px] font-bold text-[#334155] mb-2">Send Us A Message</h3>
                        <p class="text-sm text-[#64748b] font-medium mb-6">Our response time is within 30 minutes</p>
                        
                        <!-- Inline Success / Error Message Box -->
                        <div id="homeContactMessage" class="hidden w-full mb-6 p-4 rounded-xl text-sm font-semibold transition-all"></div>
                        
                        <form action="{{ route('contact.store') }}" method="POST" id="homeContactForm" class="flex flex-col gap-6 w-full">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <input type="text" name="name" placeholder="Full Name" class="neu-input w-full text-sm px-6 py-4" required>
                                <input type="email" name="email" placeholder="Email Address" class="neu-input w-full text-sm px-6 py-4">
                            </div>
                            <div class="relative">
                                <input type="tel" name="phone" placeholder="Phone Number" class="neu-input w-full text-sm px-6 py-4" required>
                            </div>
                            <div class="relative">
                                <textarea name="message" placeholder="Your Message" class="neu-input w-full text-sm px-6 py-4 resize-none" rows="3" required></textarea>
                            </div>
                            <div class="mt-2">
                                <button type="submit" id="homeContactBtn" class="neu-btn w-full font-bold py-4 text-base flex items-center justify-center gap-2">
                                    <span>Send Message</span> <i class="far fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Animated Graphic -->
                    <div class="hidden lg:flex w-full lg:w-[42%] relative items-center justify-center">
                        <style>
                            @keyframes float-icon {
                                0%, 100% { transform: translateY(0px) rotate(12deg); }
                                50% { transform: translateY(-15px) rotate(16deg); }
                            }
                            @keyframes float-badge-1 {
                                0%, 100% { transform: translateY(0px) rotate(-10deg); }
                                50% { transform: translateY(12px) rotate(-5deg); }
                            }
                            @keyframes float-badge-2 {
                                0%, 100% { transform: translateY(0px) scale(1); }
                                50% { transform: translateY(-10px) scale(1.05); }
                            }
                            @keyframes pulse-ring {
                                0% { transform: scale(0.8); opacity: 0.5; }
                                50% { transform: scale(1.2); opacity: 0.1; }
                                100% { transform: scale(0.8); opacity: 0.5; }
                            }
                        </style>
                        <div class="relative w-full aspect-square max-w-[320px] flex items-center justify-center">
                            <!-- Background glowing blobs -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-br from-[#0ea5e9]/20 to-[#1e3a8a]/10 blur-3xl rounded-full" style="animation: pulse-ring 6s ease-in-out infinite;"></div>
                            
                            <!-- Floating Elements -->
                            <div class="relative z-10 w-full h-full flex items-center justify-center">
                                <!-- Main central element -->
                                <div class="w-44 h-44 bg-gradient-to-br from-[#1e3a8a] to-[#0ea5e9] rounded-[2rem] shadow-[0_20px_50px_rgba(30,58,138,0.4)] flex items-center justify-center relative border border-white/20" style="animation: float-icon 5s ease-in-out infinite;">
                                    <i class="fas fa-envelope-open-text text-white text-6xl drop-shadow-md"></i>
                                    
                                    <!-- Smaller floating badges -->
                                    <div class="absolute -top-4 -right-4 w-14 h-14 bg-white rounded-xl shadow-xl flex items-center justify-center border border-gray-100" style="animation: float-badge-1 4s ease-in-out infinite;">
                                        <i class="fas fa-paper-plane text-[#0ea5e9] text-xl"></i>
                                    </div>
                                    <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-accent-yellow rounded-full shadow-xl flex items-center justify-center border-4 border-white" style="animation: float-badge-2 4.5s ease-in-out infinite 0.5s;">
                                        <i class="fas fa-bolt text-white text-2xl"></i>
                                    </div>
                                    <!-- Extra decorative dots -->
                                    <div class="absolute top-1/2 -left-10 w-4 h-4 bg-[#0ea5e9] rounded-full opacity-60" style="animation: float-badge-1 3s ease-in-out infinite 1s;"></div>
                                    <div class="absolute -bottom-4 right-8 w-3 h-3 bg-accent-yellow rounded-full opacity-80" style="animation: float-badge-2 3.5s ease-in-out infinite 0.2s;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // --- Stats Observer ---
        const stats = document.querySelectorAll('.stat-number');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalValue = parseInt(target.getAttribute('data-target'));
                    const duration = 2000; // ms
                    const stepTime = Math.max(10, Math.floor(duration / finalValue));
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += Math.ceil(finalValue / (duration / 20));
                        if (current >= finalValue) {
                            target.innerText = finalValue;
                            clearInterval(timer);
                        } else {
                            target.innerText = current;
                        }
                    }, 20);
                    
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        
        stats.forEach(stat => observer.observe(stat));

        // Tuition Slider Navigation
        const tuitionSlider = document.getElementById('tuitionCardsSlider');
        const tuitionPrevBtn = document.getElementById('tuitionSliderPrev');
        const tuitionNextBtn = document.getElementById('tuitionSliderNext');

        if (tuitionSlider && tuitionPrevBtn && tuitionNextBtn) {
            tuitionPrevBtn.addEventListener('click', () => {
                tuitionSlider.scrollBy({ left: -350, behavior: 'smooth' });
            });
            tuitionNextBtn.addEventListener('click', () => {
                tuitionSlider.scrollBy({ left: 350, behavior: 'smooth' });
            });
        }
        
        // About Section Image Swapper
        const aboutArrowBtn = document.getElementById('about-arrow-btn');
        const aboutMainImg = document.getElementById('about-main-img');
        const aboutImages = [
            'https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1544717302-de2939b7ef71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
        ];
        let aboutImgIndex = 0;

        if (aboutArrowBtn && aboutMainImg) {
            aboutArrowBtn.addEventListener('click', function() {
                aboutImgIndex = (aboutImgIndex + 1) % aboutImages.length;
                aboutMainImg.style.opacity = '0';
                
                setTimeout(() => {
                    aboutMainImg.src = aboutImages[aboutImgIndex];
                    aboutMainImg.style.opacity = '1';
                }, 300);
            });
        }

        // --- Homepage Contact Form AJAX Handler ---
        const homeContactForm = document.getElementById('homeContactForm');
        if (homeContactForm) {
            homeContactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = document.getElementById('homeContactBtn') || this.querySelector('button[type="submit"]');
                const originalContent = btn.innerHTML;
                const msgBox = document.getElementById('homeContactMessage');
                
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> <span>Sending Message...</span>';
                btn.disabled = true;
                btn.style.opacity = '0.7';

                if (msgBox) {
                    msgBox.className = 'hidden w-full mb-6 p-4 rounded-xl text-sm font-semibold transition-all';
                    msgBox.innerHTML = '';
                }

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));
                    if (response.ok && (data.success || response.status === 200)) {
                        if (typeof window.trackLeadConversion === 'function') {
                            window.trackLeadConversion();
                        }
                        if (msgBox) {
                            msgBox.className = 'w-full mb-6 p-4 rounded-xl text-sm font-semibold bg-green-100/80 text-green-800 border border-green-300 flex items-center gap-3 shadow-sm';
                            msgBox.innerHTML = '<i class="fas fa-check-circle text-green-600 text-lg shrink-0"></i> <div><p class="font-bold text-green-900 mb-0.5">Message Sent Successfully!</p><p class="text-xs text-green-800 mb-0">' + (data.message || 'Thank you for contacting us. Our team will get in touch with you within 30 minutes.') + '</p></div>';
                        }
                        homeContactForm.reset();
                    } else {
                        let errorText = data.message || 'Something went wrong. Please check your inputs and try again.';
                        if (data.errors) {
                            const firstErr = Object.values(data.errors)[0];
                            if (Array.isArray(firstErr)) errorText = firstErr[0];
                        }
                        if (msgBox) {
                            msgBox.className = 'w-full mb-6 p-4 rounded-xl text-sm font-semibold bg-red-100/80 text-red-800 border border-red-300 flex items-center gap-3 shadow-sm';
                            msgBox.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 text-lg shrink-0"></i> <div><p class="font-bold text-red-900 mb-0.5">Submission Failed</p><p class="text-xs text-red-800 mb-0">' + errorText + '</p></div>';
                        }
                    }
                })
                .catch((err) => {
                    console.error('Contact form submission error:', err);
                    if (msgBox) {
                        msgBox.className = 'w-full mb-6 p-4 rounded-xl text-sm font-semibold bg-red-100/80 text-red-800 border border-red-300 flex items-center gap-3 shadow-sm';
                        msgBox.innerHTML = '<i class="fas fa-exclamation-circle text-red-600 text-lg shrink-0"></i> <div><p class="font-bold text-red-900 mb-0.5">Network Error</p><p class="text-xs text-red-800 mb-0">Unable to send message right now. Please try again or contact us directly at +91-8210545286.</p></div>';
                    }
                })
                .finally(() => {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    btn.style.opacity = '1';
                });
            });
        }
    });
</script>
@endpush

