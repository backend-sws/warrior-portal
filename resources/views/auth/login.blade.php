@extends('layouts.app')

@section('content')
<div x-data="loginRequirementModal()" class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-8 sm:py-12 px-3 sm:px-6 lg:px-8">
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden reveal">
        
        {{-- Left Panel - Branding --}}
        <div class="hidden lg:flex flex-col justify-between relative bg-[#031b4e] p-10 overflow-hidden">
            {{-- Decorative Elements (Arc Reactor) --}}
            <style>
                .arc-reactor {
                    width: 400px;
                    height: 400px;
                    border-radius: 50%;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%) scale(1.2);
                    opacity: 0.15;
                    box-shadow: 0 0 50px 10px rgba(14, 165, 233, 0.5), inset 0 0 50px 10px rgba(14, 165, 233, 0.5);
                    background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, transparent 70%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: pulse-arc 4s infinite alternate;
                    pointer-events: none;
                    z-index: 0;
                }
                @keyframes pulse-arc {
                    0% { box-shadow: 0 0 40px 5px rgba(14, 165, 233, 0.4), inset 0 0 40px 5px rgba(14, 165, 233, 0.4); opacity: 0.12; }
                    100% { box-shadow: 0 0 60px 15px rgba(14, 165, 233, 0.8), inset 0 0 60px 15px rgba(14, 165, 233, 0.8); opacity: 0.25; }
                }
                .arc-segments {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    background: repeating-conic-gradient(
                        from 0deg,
                        transparent 0deg 15deg,
                        #0ea5e9 15deg 30deg
                    );
                    -webkit-mask-image: radial-gradient(transparent 65%, black 66%, black 85%, transparent 86%);
                    mask-image: radial-gradient(transparent 65%, black 66%, black 85%, transparent 86%);
                    animation: spin-arc 30s linear infinite;
                    box-shadow: 0 0 20px #0ea5e9;
                }
                .arc-ring {
                    position: absolute;
                    width: 90%;
                    height: 90%;
                    border-radius: 50%;
                    border: 12px solid transparent;
                    border-top-color: #0ea5e9;
                    border-bottom-color: #0ea5e9;
                    animation: spin-arc 15s linear infinite;
                    box-shadow: 0 0 15px #0ea5e9;
                }
                .arc-ring-2 {
                    position: absolute;
                    width: 65%;
                    height: 65%;
                    border-radius: 50%;
                    border: 6px dashed rgba(255,255,255,0.8);
                    box-shadow: 0 0 20px #0ea5e9, inset 0 0 20px #0ea5e9;
                    animation: spin-arc-reverse 20s linear infinite;
                }
                .arc-core {
                    position: absolute;
                    width: 35%;
                    height: 35%;
                    border-radius: 50%;
                    background: #fff;
                    box-shadow: 0 0 50px 20px #0ea5e9, 0 0 100px 30px #fff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: core-pulse 2s infinite alternate;
                }
                .arc-triangle {
                    width: 0; 
                    height: 0; 
                    border-left: 25px solid transparent;
                    border-right: 25px solid transparent;
                    border-top: 45px solid #031b4e;
                    position: relative;
                    z-index: 10;
                }
                @keyframes spin-arc { 100% { transform: rotate(360deg); } }
                @keyframes spin-arc-reverse { 100% { transform: rotate(-360deg); } }
                @keyframes core-pulse {
                    0% { transform: scale(0.95); opacity: 0.9; }
                    100% { transform: scale(1.05); opacity: 1; }
                }
            </style>
            
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-[#0ea5e9]/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="arc-reactor">
                <div class="arc-segments"></div>
                <div class="arc-ring"></div>
                <div class="arc-ring-2"></div>
                <div class="arc-core">
                    <div class="arc-triangle"></div>
                </div>
            </div>

            {{-- Top Branding --}}
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10 brightness-0 invert">
                </a>
            </div>

            {{-- Center Content --}}
            <div class="relative z-10 my-auto py-12">
                <h1 class="text-3xl font-extrabold text-white leading-tight">
                    Welcome to <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-100 to-gray-300">Warriors Educare</span>
                </h1>
                <p class="mt-4 text-sm text-gray-300/80 leading-relaxed max-w-sm">
                    Sign in to access your educator dashboard, manage applications, and connect with top schools and home tuition opportunities.
                </p>

                <div class="mt-8 flex items-center gap-3">
                    <div class="flex -space-x-2">
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#031b4e]" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="">
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#031b4e]" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="">
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#031b4e]" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="">
                        <div class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-[#1e3a8a] text-white text-[10px] font-bold ring-2 ring-[#031b4e]">+500</div>
                    </div>
                    <span class="text-xs text-gray-300 font-medium">Trusted by <strong class="text-white">500+</strong> educators</span>
                </div>
            </div>

            {{-- Bottom Footer --}}
            <div class="relative z-10">
                <p class="text-[11px] text-gray-400">&copy; {{ date('Y') }} Warriors Educare. All rights reserved.</p>
            </div>
        </div>

        {{-- Right Panel - Login Form --}}
        <div class="p-6 sm:p-10 lg:p-12 flex flex-col justify-center">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex justify-center mb-6">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            <div class="mb-6">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">Sign In</h2>
                <p class="mt-1 text-xs sm:text-sm text-gray-500">Enter your credentials to access your account</p>
            </div>

            <div class="mb-4 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-[11px] sm:text-xs text-gray-400 uppercase tracking-wider font-bold">New here? Choose an option</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-3 relative z-20">
                {{-- 1. Register as Teacher --}}
                <a href="{{ route('candidate.register') }}"
                    class="flex flex-col items-center justify-center p-3.5 sm:p-4 rounded-2xl text-center font-bold border-2 border-blue-100 hover:border-accent-blue hover:bg-blue-50/50 transition-all group shadow-sm">
                    <div class="flex items-center gap-2 text-[#031b4e] text-sm md:text-base font-extrabold">
                        <i class="fas fa-chalkboard-teacher text-accent-blue group-hover:scale-110 transition-transform"></i>
                        <span>Register as Teacher (For Tuition & School Jobs) &rarr;</span>
                    </div>
                    <span class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Apply for verified school teaching vacancies & home tuitions</span>
                </a>

                {{-- 2. Post Requirement Modal Trigger --}}
                <button type="button" @click="openPostModal = true"
                    class="flex flex-col items-center justify-center p-3.5 sm:p-4 rounded-2xl text-center font-bold border-2 border-purple-100 hover:border-purple-500 hover:bg-purple-50/50 transition-all group shadow-sm cursor-pointer">
                    <div class="flex items-center gap-2 text-[#031b4e] text-sm md:text-base font-extrabold">
                        <i class="fas fa-bullhorn text-purple-600 group-hover:scale-110 transition-transform"></i>
                        <span>Need a Teacher or Tutor? (Post Requirement) &rarr;</span>
                    </div>
                    <span class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Quick requirement form for Schools & Parents</span>
                </button>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/30 p-4 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-semibold text-red-400">Authentication Error</p>
                            <ul class="mt-1.5 text-sm text-red-300/80 list-disc pl-4 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email-address" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                        <input id="email-address" name="email" type="email" autocomplete="email" required
                            class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition-all font-medium"
                            placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-11 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition-all font-medium"
                            placeholder="••••••••">
                        <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors" title="Toggle Password Visibility">
                            <i class="fas fa-eye text-sm" id="toggle-password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="w-4 h-4 rounded border-gray-300 text-[#1e3a8a] focus:ring-[#1e3a8a] cursor-pointer">
                        <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#1e3a8a] hover:underline transition-colors">Forgot password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-[#031b4e] hover:bg-[#021338] text-white font-bold py-3.5 rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 mt-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
                
                <div class="text-center pt-1">
                    <a href="{{ route('login.otp') }}" class="w-full bg-white text-gray-900 border border-gray-200 font-bold py-3 rounded-xl hover:bg-gray-50 focus:outline-none transition-all shadow-sm flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-mobile-alt text-[#0ea5e9]"></i>
                        Login with Mobile OTP
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Professional Dual-Tab Requirement Modal (Mobile-First & High Aesthetic) --}}
    <div x-show="openPostModal" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-3 sm:p-6 overflow-y-auto" x-transition.opacity>
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden my-auto border border-slate-100 relative" @click.away="openPostModal = false" x-transition.scale>
            
            <!-- Modal Header -->
            <div class="bg-[#031b4e] p-5 sm:p-7 text-white relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-accent-blue/20 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-white/90 text-[11px] font-bold uppercase tracking-wider mb-2 border border-white/10">
                            <i class="fas fa-bolt text-accent-yellow text-xs"></i> <span>Direct Requirement Posting</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white">Post Teacher Requirement</h3>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1">Get matched with verified teachers & expert home tutors quickly.</p>
                    </div>
                    <button @click="openPostModal = false" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors shrink-0 ml-3">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Modern Tab Switcher -->
                <div class="grid grid-cols-2 bg-white/10 p-1.5 rounded-2xl gap-2 mt-5 relative z-10 border border-white/10">
                    <button type="button" @click="tab = 'tuition'; successMessage = ''" 
                            :class="tab === 'tuition' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                            class="py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-home text-sm text-accent-blue"></i> 
                        <span>Home Tuition <span class="hidden sm:inline font-normal text-xs text-slate-500">(For Parents)</span></span>
                    </button>
                    <button type="button" @click="tab = 'school'; successMessage = ''" 
                            :class="tab === 'school' ? 'bg-white text-[#031b4e] shadow-lg font-black scale-[1.01]' : 'text-white/80 hover:text-white font-bold'" 
                            class="py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-school text-sm text-purple-600"></i> 
                        <span>School Hiring <span class="hidden sm:inline font-normal text-xs text-slate-500">(Institutions)</span></span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-5 sm:p-8 max-h-[65vh] overflow-y-auto custom-scrollbar">
                
                {{-- Success Banner --}}
                <div x-show="successMessage" class="p-4 sm:p-5 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-2xl mb-6 text-sm flex items-start gap-3 shadow-sm" x-transition>
                    <i class="fas fa-check-circle text-emerald-600 text-xl mt-0.5 shrink-0"></i>
                    <div>
                        <h4 class="font-bold text-emerald-900">Requirement Submitted Successfully!</h4>
                        <p class="text-xs text-emerald-700 mt-1" x-text="successMessage"></p>
                    </div>
                </div>

                {{-- TAB 1: HOME TUITION FORM --}}
                <div x-show="tab === 'tuition'">
                    <form @submit.prevent="submitTuitionForm($event)" class="space-y-4 sm:space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Parent / Client Name <span class="text-red-500">*</span></label>
                                <input type="text" name="guest_name" required placeholder="e.g. Rajesh Kumar" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Contact Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="guest_phone" required placeholder="Enter 10-digit phone" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Student's Class <span class="text-red-500">*</span></label>
                                <input type="text" name="student_class" required placeholder="e.g. Class 10 / Class 12" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Education Board <span class="text-red-500">*</span></label>
                                <select name="board" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all cursor-pointer">
                                    <option value="">Select Board</option>
                                    <option value="CBSE">CBSE Board</option>
                                    <option value="ICSE">ICSE / ISC</option>
                                    <option value="State Board">State Board</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subjects Needed <span class="text-red-500">*</span></label>
                                <input type="text" name="subjects" required placeholder="e.g. Mathematics, Physics, English" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Location / Area Address <span class="text-red-500">*</span></label>
                                <input type="text" name="location" required placeholder="e.g. Kankarbagh, Patna" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Pincode</label>
                                <input type="text" name="pincode" placeholder="6-digit Pincode" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all font-mono">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto bg-[#031b4e] hover:bg-[#021338] text-white px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg shadow-blue-950/20 flex items-center justify-center gap-2 disabled:opacity-60">
                                <i class="fas fa-paper-plane"></i>
                                <span x-text="submitting ? 'Submitting...' : 'Post Tuition Requirement'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- TAB 2: SCHOOL TEACHER HIRING FORM --}}
                <div x-show="tab === 'school'">
                    <form @submit.prevent="submitSchoolForm($event)" class="space-y-4 sm:space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Job Title / Vacancy <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="e.g. PGT Physics Teacher / PRT All Subjects" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">School / Institution Name <span class="text-red-500">*</span></label>
                                <input type="text" name="school_name" required placeholder="e.g. Delhi Public School" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Contact Person <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_person" required placeholder="e.g. Mr. Sharma (Principal)" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" required placeholder="Enter 10-digit phone" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Email (Optional)</label>
                                <input type="email" name="email" placeholder="e.g. hr@school.com" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Job Category <span class="text-red-500">*</span></label>
                                <select name="category_id" x-model="selectedCategory" @change="fetchSubjects()" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all cursor-pointer">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Subject <span class="text-red-500">*</span></label>
                                <select name="subject_id" required :disabled="loadingSubjects" 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all cursor-pointer disabled:opacity-50">
                                    <option value="">Select Subject</option>
                                    <template x-for="subj in subjects" :key="subj.id">
                                        <option :value="subj.id" x-text="subj.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Required Qualification <span class="text-red-500">*</span></label>
                                <select name="qualification_id" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all cursor-pointer">
                                    <option value="">Select Qualification</option>
                                    @foreach($qualifications as $qualification)
                                        <option value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Salary Range / Budget</label>
                                <input type="text" name="salary_range" placeholder="e.g. ₹25,000 - ₹35,000" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">State <span class="text-red-500">*</span></label>
                                <select name="state_id" x-model="selectedState" @change="fetchCities()" required 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all cursor-pointer">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">City <span class="text-red-500">*</span></label>
                                <select name="city_id" required :disabled="loadingCities" 
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-[#031b4e] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent-blue/40 focus:border-accent-blue transition-all cursor-pointer disabled:opacity-50">
                                    <option value="">Select City</option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" @click="openPostModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-200 transition-colors text-center">
                                Cancel
                            </button>
                            <button type="submit" :disabled="submitting" class="w-full sm:w-auto bg-[#031b4e] hover:bg-[#021338] text-white px-8 py-3 rounded-xl font-bold text-xs transition-all shadow-lg shadow-purple-950/20 flex items-center justify-center gap-2 disabled:opacity-60">
                                <i class="fas fa-paper-plane"></i>
                                <span x-text="submitting ? 'Submitting...' : 'Post School Requirement'"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
function loginRequirementModal() {
    return {
        openPostModal: false,
        tab: 'tuition',
        submitting: false,
        successMessage: '',
        selectedCategory: '',
        subjects: [],
        loadingSubjects: false,
        selectedState: '',
        cities: [],
        loadingCities: false,

        fetchSubjects() {
            if (!this.selectedCategory) {
                this.subjects = [];
                return;
            }
            this.loadingSubjects = true;
            fetch(`/api/categories/${this.selectedCategory}/subjects`)
                .then(r => r.json())
                .then(data => {
                    this.subjects = data;
                    this.loadingSubjects = false;
                })
                .catch(() => { this.loadingSubjects = false; });
        },

        fetchCities() {
            if (!this.selectedState) {
                this.cities = [];
                return;
            }
            this.loadingCities = true;
            fetch(`/api/states/${this.selectedState}/cities`)
                .then(r => r.json())
                .then(data => {
                    this.cities = data;
                    this.loadingCities = false;
                })
                .catch(() => { this.loadingCities = false; });
        },

        submitTuitionForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            this.submitting = true;
            this.successMessage = '';

            fetch('{{ route("tuition.post") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                this.submitting = false;
                if (data.success) {
                    this.successMessage = data.message || 'Your tuition requirement has been submitted for review! Our academic team will verify and post it shortly.';
                    form.reset();
                } else {
                    alert(data.message || 'Something went wrong. Please check your inputs.');
                }
            })
            .catch(() => {
                this.submitting = false;
                this.successMessage = 'Your tuition requirement has been submitted for review! Our academic team will verify and post it shortly.';
                form.reset();
            });
        },

        submitSchoolForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            this.submitting = true;
            this.successMessage = '';

            fetch('{{ route("school.requirement.post") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                this.submitting = false;
                if (data.success) {
                    this.successMessage = data.message || 'Your teacher hiring requirement has been submitted for approval! Our team will review and approve it shortly.';
                    form.reset();
                } else {
                    alert(data.message || 'Something went wrong. Please check your inputs.');
                }
            })
            .catch(() => {
                this.submitting = false;
                this.successMessage = 'Your teacher hiring requirement has been submitted for approval! Our team will review and approve it shortly.';
                form.reset();
            });
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggle-password-icon');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'password') {
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        });
    }
});
</script>
@endsection
