@extends('layouts.app')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-12 px-4 sm:px-6 lg:px-8">
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

            <div class="relative z-10">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            <div class="relative z-10 space-y-6">
                <h2 class="text-3xl font-bold text-white leading-snug h-[80px] typewriter-effect" data-speed="40" data-repeat="8000" data-highlight="Warriors Educare" data-highlight-color="text-[#0ea5e9]">Welcome back to<br>Warriors Educare</h2>
                <p class="text-sm text-gray-200 leading-relaxed max-w-xs h-[60px] typewriter-effect" data-speed="40" data-repeat="8000">
                    Sign in to access your dashboard, manage job listings, and connect with top educational institutions across India.
                </p>
                <div class="flex items-center gap-4 pt-2">
                    <div class="flex -space-x-2">
                        <img src="https://i.pravatar.cc/80?img=11" alt="" class="w-8 h-8 rounded-full border-2 border-[#031b4e]">
                        <img src="https://i.pravatar.cc/80?img=32" alt="" class="w-8 h-8 rounded-full border-2 border-[#031b4e]">
                        <img src="https://i.pravatar.cc/80?img=44" alt="" class="w-8 h-8 rounded-full border-2 border-[#031b4e]">
                        <div class="w-8 h-8 rounded-full bg-[#1e3a8a] text-white text-[10px] font-bold flex items-center justify-center border-2 border-[#031b4e]">+500</div>
                    </div>
                    <p class="text-xs text-gray-300">Trusted by <strong class="text-white">500+</strong> educators</p>
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-[11px] text-gray-400">&copy; {{ date('Y') }} Warriors Educare. All rights reserved.</p>
            </div>
        </div>

        {{-- Right Panel - Login Form --}}
        <div class="p-8 sm:p-10 lg:p-12 flex flex-col justify-center">
            {{-- Mobile Logo --}}
            <div class="lg:hidden flex justify-center mb-6">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Sign In</h2>
                <p class="mt-1.5 text-sm text-gray-500">Enter your credentials to access your account</p>
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

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email-address" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                        <input id="email-address" name="email" type="email" autocomplete="email" required
                            class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition-all"
                            placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-11 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] transition-all"
                            placeholder="••••••••">
                        <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors" title="Toggle Password Visibility">
                            <i class="fas fa-eye text-sm" id="toggle-password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="w-4 h-4 rounded border-gray-300 text-[#1e3a8a] focus:ring-[#1e3a8a] cursor-pointer">
                        <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#1e3a8a] hover:underline transition-colors">Forgot password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-[#1e3a8a] text-white font-bold py-3.5 rounded-xl hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('login.otp') }}" class="w-full bg-white text-gray-900 border border-gray-200 font-bold py-3.5 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a8a] transition-all shadow-sm hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fas fa-mobile-alt text-[#0ea5e9]"></i>
                        Login with OTP
                    </a>
                </div>
            </form>

            <div class="mt-8 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">New here?</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <a href="{{ route('candidate.register') }}"
                    class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-bold border border-gray-200 text-gray-700 hover:bg-[#1e3a8a]/10 hover:border-[#1e3a8a]/30 transition-all group">
                    <i class="fas fa-user-graduate text-[#1e3a8a] group-hover:scale-110 transition-transform"></i>
                    <span>Candidate</span>
                </a>
                <a href="{{ route('employer.register') }}"
                    class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-bold border border-gray-200 text-gray-700 hover:bg-[#0ea5e9]/10 hover:border-[#0ea5e9]/30 transition-all group">
                    <i class="fas fa-building text-[#0ea5e9] group-hover:scale-110 transition-transform"></i>
                    <span>Employer</span>
                </a>
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
    });
</script>
@endsection
