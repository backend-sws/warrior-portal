@extends('layouts.app')

@section('title', 'Set New Password - Warriors Educare')
@section('meta_description', 'Create a new password for your Warriors Educare account.')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Ambient Decorative Glows --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0ea5e9]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#1e3a8a]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        {{-- Main Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-200/80 overflow-hidden reveal p-8 sm:p-10 transition-all"
             x-data="{
                 showPassword: false,
                 showConfirm: false,
                 password: '',
                 password_confirmation: '',
                 get score() {
                     let s = 0;
                     if (this.password.length >= 8) s++;
                     if (/[A-Z]/.test(this.password)) s++;
                     if (/[0-9]/.test(this.password)) s++;
                     if (/[^A-Za-z0-9]/.test(this.password)) s++;
                     return s;
                 },
                 get strengthLabel() {
                     if (this.password.length === 0) return '';
                     if (this.score <= 1) return 'Weak';
                     if (this.score === 2) return 'Fair';
                     if (this.score === 3) return 'Good';
                     return 'Strong';
                 },
                 get strengthColor() {
                     if (this.score <= 1) return 'text-red-500';
                     if (this.score === 2) return 'text-amber-500';
                     if (this.score === 3) return 'text-blue-500';
                     return 'text-emerald-500';
                 }
             }">
            
            {{-- Top Branding / Logo --}}
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            {{-- Icon Badge & Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#031b4e] to-[#0ea5e9] text-white shadow-lg shadow-[#0ea5e9]/25 flex items-center justify-center text-2xl mx-auto mb-4 transition-transform hover:scale-110">
                    <i class="fas fa-lock"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e] tracking-tight">Set New Password</h1>
                <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                    Create a strong, secure password for your Warriors Educare account.
                </p>
            </div>

            {{-- Errors Alert --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl shadow-sm animate-fade-in-down">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-xl bg-red-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5 text-xs shadow-sm">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-red-900">Please correct the errors</p>
                            <ul class="mt-1 text-xs text-red-700 list-disc pl-4 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Reset Form --}}
            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email Address (Read-only) --}}
                <div>
                    <label for="email-address" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input id="email-address" name="email" type="email" autocomplete="email" required readonly
                            class="w-full bg-gray-100/80 border border-gray-200 rounded-xl pl-11 pr-10 py-3.5 text-sm text-gray-600 cursor-not-allowed focus:outline-none select-none font-medium"
                            value="{{ $email ?? old('email') }}">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-emerald-600" title="Account email verified">
                            <i class="fas fa-check-circle text-sm"></i>
                        </span>
                    </div>
                </div>

                {{-- New Password --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                            New Password
                        </label>
                        <template x-if="password.length > 0">
                            <span class="text-xs font-bold" :class="strengthColor" x-text="strengthLabel"></span>
                        </template>
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="new-password"
                            x-model="password"
                            class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-11 pr-11 py-3.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#031b4e] focus:border-transparent focus:bg-white transition-all shadow-sm"
                            placeholder="At least 8 characters">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>

                    {{-- Strength Meter Bar --}}
                    <div class="mt-2.5 grid grid-cols-4 gap-1.5" x-show="password.length > 0" x-transition>
                        <div class="h-1.5 rounded-full transition-all duration-300" :class="score >= 1 ? (score === 1 ? 'bg-red-500' : (score === 2 ? 'bg-amber-500' : 'bg-emerald-500')) : 'bg-gray-200'"></div>
                        <div class="h-1.5 rounded-full transition-all duration-300" :class="score >= 2 ? (score === 2 ? 'bg-amber-500' : 'bg-emerald-500') : 'bg-gray-200'"></div>
                        <div class="h-1.5 rounded-full transition-all duration-300" :class="score >= 3 ? 'bg-emerald-500' : 'bg-gray-200'"></div>
                        <div class="h-1.5 rounded-full transition-all duration-300" :class="score >= 4 ? 'bg-emerald-600' : 'bg-gray-200'"></div>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-shield-alt text-sm"></i>
                        </span>
                        <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required autocomplete="new-password"
                            x-model="password_confirmation"
                            class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-11 pr-11 py-3.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#031b4e] focus:border-transparent focus:bg-white transition-all shadow-sm"
                            placeholder="Re-type your password">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                            <i class="fas" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>

                    {{-- Match validation hint --}}
                    <template x-if="password_confirmation.length > 0">
                        <div class="mt-1.5 flex items-center gap-1.5 text-xs font-medium"
                             :class="password === password_confirmation ? 'text-emerald-600' : 'text-red-500'">
                            <i class="fas" :class="password === password_confirmation ? 'fa-check-circle' : 'fa-times-circle'"></i>
                            <span x-text="password === password_confirmation ? 'Passwords match' : 'Passwords do not match yet'"></span>
                        </div>
                    </template>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-[#031b4e] text-white font-bold py-3.5 px-6 rounded-xl hover:bg-[#0a2970] focus:outline-none focus:ring-4 focus:ring-[#031b4e]/20 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 text-sm mt-2">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span>Reset Password & Sign In</span>
                </button>
            </form>

            {{-- Back Navigation --}}
            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-[#031b4e] transition-colors flex items-center justify-center gap-2 group">
                    <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-1"></i>
                    <span>Back to sign in</span>
                </a>
            </div>

            {{-- Security Notice Footer --}}
            <div class="mt-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 border border-gray-200/60 text-[11px] text-gray-500">
                    <i class="fas fa-shield-halved text-[#0ea5e9]"></i>
                    <span>256-bit SSL encrypted & secure</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
