@extends('layouts.app')

@section('title', 'Login - Candidate, Parent & Institution Portal | Warriors Educare')
@section('meta_description', 'Log in to your Warriors Educare account to access verified home tuition leads, school teaching jobs, and faculty recruitment services across India.')

@section('content')
<div x-data="{}" class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-8 sm:py-12 px-3 sm:px-6 lg:px-8">
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
        <div class="p-6 sm:p-8 lg:p-10 flex flex-col justify-center">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex justify-center mb-6">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            <div class="mb-5">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e]">Sign In</h2>
                <p class="mt-1 text-xs sm:text-sm text-gray-500">Enter your credentials to access your account</p>
            </div>

            {{-- 3 Requirement & Registration Buttons Above Login Form --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[11px] font-black uppercase tracking-wider text-[#031b4e]">
                        <i class="fas fa-layer-group text-blue-600 mr-1"></i> Apply / Post Requirement
                    </span>
                    <span class="text-[10px] font-bold text-slate-400">Choose your category</span>
                </div>

                <div class="grid grid-cols-3 gap-2 sm:gap-2.5">
                    {{-- Button 1: Tuition Post Requirement --}}
                    <button type="button" onclick="openRequirementModal('tuition')"
                            class="flex flex-col items-center justify-between text-center p-2.5 sm:p-3 rounded-2xl bg-sky-50/90 hover:bg-sky-100 border border-sky-200/80 hover:border-sky-400 hover:shadow-md hover:-translate-y-0.5 transition-all group cursor-pointer h-full">
                        <div class="w-9 h-9 rounded-xl bg-[#0ea5e9] text-white flex items-center justify-center text-sm font-bold shadow-xs mb-2 group-hover:scale-110 transition-transform shrink-0">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="w-full flex-1 flex flex-col justify-center">
                            <div class="text-[11px] sm:text-xs font-black text-[#031b4e] leading-snug">Tuition Post Requirement</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-500 font-semibold leading-tight mt-1">Parent / Student</div>
                        </div>
                    </button>

                    {{-- Button 2: School Hiring --}}
                    <button type="button" onclick="openRequirementModal('school')"
                            class="flex flex-col items-center justify-between text-center p-2.5 sm:p-3 rounded-2xl bg-purple-50/90 hover:bg-purple-100 border border-purple-200/80 hover:border-purple-400 hover:shadow-md hover:-translate-y-0.5 transition-all group cursor-pointer h-full">
                        <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center text-sm font-bold shadow-xs mb-2 group-hover:scale-110 transition-transform shrink-0">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="w-full flex-1 flex flex-col justify-center">
                            <div class="text-[11px] sm:text-xs font-black text-[#031b4e] leading-snug">School Hiring</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-500 font-semibold leading-tight mt-1">Post Vacancy</div>
                        </div>
                    </button>

                    {{-- Button 3: Join as a Teacher --}}
                    <button type="button" onclick="openRequirementModal('teacher')"
                            class="flex flex-col items-center justify-between text-center p-2.5 sm:p-3 rounded-2xl bg-amber-50/90 hover:bg-amber-100 border border-amber-200/80 hover:border-amber-400 hover:shadow-md hover:-translate-y-0.5 transition-all group cursor-pointer h-full">
                        <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm font-bold shadow-xs mb-2 group-hover:scale-110 transition-transform shrink-0">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="w-full flex-1 flex flex-col justify-center">
                            <div class="text-[11px] sm:text-xs font-black text-[#031b4e] leading-snug">Join as a Teacher</div>
                            <div class="text-[9px] sm:text-[10px] text-slate-500 font-semibold leading-tight mt-1">Tutor, School & Both</div>
                        </div>
                    </button>
                </div>
            </div>

            <div class="relative flex py-1 items-center mb-5">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Or Sign In with Account</span>
                <div class="flex-grow border-t border-gray-200"></div>
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
            </form>

            {{-- Quick Requirement / Registration Links Below Sign In --}}
            <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500 mb-2 font-medium">New to Warriors Educare? Register or post requirement:</p>
                <div class="flex flex-wrap items-center justify-center gap-2 text-xs font-bold text-[#031b4e]">
                    <button type="button" onclick="openRequirementModal('tuition')" class="hover:text-blue-600 transition-colors cursor-pointer">Tuition Post Requirement</button>
                    <span class="text-gray-300">•</span>
                    <button type="button" onclick="openRequirementModal('school')" class="hover:text-purple-600 transition-colors cursor-pointer">School Hiring</button>
                    <span class="text-gray-300">•</span>
                    <button type="button" onclick="openRequirementModal('teacher')" class="hover:text-amber-600 transition-colors cursor-pointer">Join as a Teacher</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    // Clean query parameters from URL if any were passed
    if (window.location.search && (window.location.search.includes('tab=') || window.location.search.includes('apply_for='))) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
@endsection
