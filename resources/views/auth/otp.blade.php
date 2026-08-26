@extends('layouts.app')

@section('title', 'OTP Login - Passwordless Sign In | Warriors Educare')
@section('meta_description', 'Sign in securely without a password using a one-time passcode sent to your registered email.')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Ambient Decorative Glows --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0ea5e9]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#1e3a8a]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        {{-- Main Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-200/80 overflow-hidden reveal p-8 sm:p-10 transition-all">
            
            {{-- Top Branding / Logo --}}
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            {{-- Icon Badge & Header --}}
            <div class="text-center mb-8">
                @if(!session('otp_email'))
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#031b4e] to-[#0ea5e9] text-white shadow-lg shadow-[#0ea5e9]/25 flex items-center justify-center text-2xl mx-auto mb-4 transition-transform hover:scale-110">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e] tracking-tight">Login with OTP</h1>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                        Fast, secure, and password-less access to your account.
                    </p>
                @else
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 text-white shadow-lg shadow-emerald-500/25 flex items-center justify-center text-2xl mx-auto mb-4 transition-transform hover:scale-110">
                        <i class="fas fa-envelope-circle-check"></i>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e] tracking-tight">Verify Your OTP</h1>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                        We sent a 6-digit verification code to <span class="font-bold text-gray-800 block mt-0.5 truncate">{{ session('otp_email') }}</span>
                    </p>
                @endif
            </div>

            {{-- Status Alert (Success) --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in-down">
                    <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5 text-xs shadow-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-900">Code Sent!</p>
                        <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Errors Alert --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl shadow-sm animate-fade-in-down">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-xl bg-red-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5 text-xs shadow-sm">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-red-900">Verification Error</p>
                            <p class="text-xs text-red-700 mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(!session('otp_email'))
                {{-- Step 1: Send OTP --}}
                <form action="{{ route('login.otp.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                            Registered Email Address
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-11 pr-4 py-3.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#031b4e] focus:border-transparent focus:bg-white transition-all shadow-sm" 
                                placeholder="you@example.com" value="{{ old('email') }}">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#031b4e] text-white font-bold py-3.5 px-6 rounded-xl hover:bg-[#0a2970] focus:outline-none focus:ring-4 focus:ring-[#031b4e]/20 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span>Send Login OTP</span>
                    </button>
                </form>
            @else
                {{-- Step 2: Verify OTP --}}
                <form action="{{ route('login.otp.verify') }}" method="POST" class="space-y-5"
                      x-data="{
                          countdown: 60,
                          canResend: false,
                          init() {
                              let timer = setInterval(() => {
                                  if (this.countdown > 0) {
                                      this.countdown--;
                                  } else {
                                      this.canResend = true;
                                      clearInterval(timer);
                                  }
                              }, 1000);
                          }
                      }">
                    @csrf
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="otp" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                6-Digit Verification Code
                            </label>
                            <a href="{{ route('login.otp') }}" class="text-xs font-semibold text-[#0ea5e9] hover:underline">
                                Change Email
                            </a>
                        </div>
                        <div class="relative">
                            <input id="otp" name="otp" type="text" maxlength="6" autofocus autocomplete="one-time-code" required 
                                class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-4 py-3.5 text-center text-2xl tracking-[0.6em] font-extrabold text-[#031b4e] placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#031b4e] focus:border-transparent focus:bg-white transition-all shadow-sm" 
                                placeholder="------">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#031b4e] text-white font-bold py-3.5 px-6 rounded-xl hover:bg-[#0a2970] focus:outline-none focus:ring-4 focus:ring-[#031b4e]/20 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-shield-alt text-xs"></i>
                        <span>Verify & Sign In</span>
                    </button>
                    
                    {{-- Resend Timer Action --}}
                    <div class="text-center pt-2">
                        <template x-if="!canResend">
                            <p class="text-xs text-gray-500">
                                Didn't receive code? Resend in <span class="font-bold text-gray-700" x-text="countdown + 's'"></span>
                            </p>
                        </template>
                        <template x-if="canResend">
                            <a href="{{ route('login.otp') }}" class="text-xs font-bold text-[#0ea5e9] hover:text-[#031b4e] transition-colors inline-flex items-center gap-1">
                                <i class="fas fa-rotate-right text-[10px]"></i> Resend OTP Code
                            </a>
                        </template>
                    </div>
                </form>
            @endif

            {{-- Divider --}}
            <div class="mt-8 relative flex items-center justify-center">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative bg-white px-4 text-xs text-gray-400 uppercase tracking-widest font-semibold">
                    Or
                </div>
            </div>

            {{-- Alternative Options --}}
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-gray-700 hover:text-[#031b4e] transition-colors py-2 px-4 rounded-xl border border-gray-200 hover:bg-gray-50 w-full">
                    <i class="fas fa-key text-xs text-[#0ea5e9]"></i>
                    <span>Sign In with Password</span>
                </a>
            </div>

            {{-- Security Notice Footer --}}
            <div class="mt-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 border border-gray-200/60 text-[11px] text-gray-500">
                    <i class="fas fa-shield-halved text-[#0ea5e9]"></i>
                    <span>Fast, Secure & Encrypted Access</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
