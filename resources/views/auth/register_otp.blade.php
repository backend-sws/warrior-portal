@extends('layouts.app')

@section('title', 'Verify Email OTP - Complete Registration | Warriors Educare')
@section('meta_description', 'Verify your email address using the 6-digit OTP code to complete your registration.')

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
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#031b4e] to-[#0ea5e9] text-white shadow-lg shadow-[#0ea5e9]/25 flex items-center justify-center text-2xl mx-auto mb-4 transition-transform hover:scale-110">
                    <i class="fas fa-envelope-circle-check"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e] tracking-tight">Verify Your Email</h1>
                <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                    We've sent a 6-digit verification code to
                    <span class="font-bold text-gray-900 block mt-1 text-sm truncate bg-gray-50 border border-gray-100 py-1.5 px-3 rounded-xl">
                        {{ session('register_data.email', 'your email') }}
                    </span>
                </p>
                <div class="mt-2">
                    <a href="{{ route('register.cancel') }}" class="text-xs font-semibold text-[#0ea5e9] hover:underline inline-flex items-center gap-1">
                        <i class="fas fa-edit text-[10px]"></i> Change email address
                    </a>
                </div>
            </div>

            {{-- Status Alert (Success) --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in-down">
                    <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5 text-xs shadow-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-900">OTP Sent Successfully</p>
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
                            <p class="text-sm font-bold text-red-900">Verification Failed</p>
                            <p class="text-xs text-red-700 mt-0.5">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- OTP Verification Form --}}
            <form action="{{ route('register.otp.verify') }}" method="POST" class="space-y-5"
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
                    <label for="otp" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider text-center">
                        Enter 6-Digit OTP Code
                    </label>
                    <div class="relative">
                        <input id="otp" name="otp" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" autofocus autocomplete="one-time-code" required 
                            class="w-full bg-[#f8fafc] border border-gray-200 rounded-2xl px-4 py-4 text-center text-3xl tracking-[0.5em] font-extrabold text-[#031b4e] placeholder-gray-300 focus:outline-none focus:ring-4 focus:ring-[#031b4e]/15 focus:border-[#031b4e] focus:bg-white transition-all shadow-sm" 
                            placeholder="------">
                    </div>
                    <p class="text-[11px] text-gray-400 text-center mt-2">
                        ⏳ The passcode will expire in 15 minutes.
                    </p>
                </div>

                <button type="submit"
                    class="w-full bg-[#031b4e] text-white font-bold py-3.5 px-6 rounded-xl hover:bg-[#0a2970] focus:outline-none focus:ring-4 focus:ring-[#031b4e]/20 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span>Verify & Activate Account</span>
                </button>
                
                {{-- Resend Timer Action --}}
                <div class="text-center pt-3 border-t border-gray-100">
                    <template x-if="!canResend">
                        <p class="text-xs text-gray-500">
                            Didn't receive email? Resend in <span class="font-bold text-gray-800" x-text="countdown + 's'"></span>
                        </p>
                    </template>
                    <template x-if="canResend">
                        <form action="{{ route('register.otp.resend') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-[#0ea5e9] hover:text-[#031b4e] transition-colors inline-flex items-center gap-1.5 focus:outline-none cursor-pointer">
                                <i class="fas fa-rotate-right text-[10px]"></i> Resend Verification Code
                            </button>
                        </form>
                    </template>
                </div>
            </form>

            {{-- Spam Reminder Box --}}
            <div class="mt-6 p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200/60 text-[11px] text-amber-800 flex items-start gap-2.5 leading-relaxed">
                <i class="fas fa-info-circle text-amber-600 mt-0.5 text-xs flex-shrink-0"></i>
                <span>Can't find the email? Please check your <strong>Spam</strong> or <strong>Promotions</strong> folder.</span>
            </div>

            {{-- Security Notice Footer --}}
            <div class="mt-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 border border-gray-200/60 text-[11px] text-gray-500">
                    <i class="fas fa-shield-halved text-[#0ea5e9]"></i>
                    <span>256-bit SSL encrypted authentic verification</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
