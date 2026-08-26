@extends('layouts.app')

@section('title', 'Verify Email Address - Warriors Educare')
@section('meta_description', 'Please verify your email address to complete your registration on Warriors Educare.')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Ambient Decorative Glows --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0ea5e9]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#1e3a8a]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        {{-- Main Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-200/80 overflow-hidden reveal p-8 sm:p-10 text-center relative transition-all">
            
            {{-- Top Branding / Logo --}}
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                    <img src="{{ asset('adobe.png') }}" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            {{-- Floating Animated Mail Icon --}}
            <div class="w-20 h-20 rounded-3xl bg-gradient-to-tr from-[#031b4e] via-[#0a3880] to-[#0ea5e9] text-white shadow-xl shadow-[#0ea5e9]/25 flex items-center justify-center text-3xl mx-auto mb-6 transition-transform hover:scale-105">
                <i class="fas fa-envelope-open-text animate-pulse-soft"></i>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e] tracking-tight">
                Verify Your Email
            </h1>

            <p class="text-xs sm:text-sm text-gray-600 mt-3 leading-relaxed max-w-xs mx-auto">
                Thanks for joining Warriors Educare! Before getting started, please check your inbox and click the verification link we just emailed to you.
            </p>

            {{-- Step Guide --}}
            <div class="my-6 bg-gray-50 border border-gray-100 rounded-2xl p-4 text-left space-y-3">
                <div class="flex items-center gap-3 text-xs text-gray-700">
                    <div class="w-6 h-6 rounded-full bg-[#031b4e] text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0">1</div>
                    <span>Check your email inbox (and spam/junk folder)</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-700">
                    <div class="w-6 h-6 rounded-full bg-[#031b4e] text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0">2</div>
                    <span>Click the <strong>Verify Email Address</strong> button</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-700">
                    <div class="w-6 h-6 rounded-full bg-[#031b4e] text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0">3</div>
                    <span>Get instant access to your portal dashboard</span>
                </div>
            </div>

            {{-- Status Flash Alert --}}
            @if (session('message'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-down text-left">
                    <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 text-xs shadow-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-900">Email Dispatched!</p>
                        <p class="text-xs text-emerald-700 mt-0.5">{{ session('message') }}</p>
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="space-y-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#031b4e] text-white font-bold py-3.5 px-6 rounded-xl hover:bg-[#0a2970] focus:outline-none focus:ring-4 focus:ring-[#031b4e]/20 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span>Resend Verification Email</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 rounded-xl text-xs sm:text-sm font-semibold text-gray-600 hover:text-red-600 hover:bg-red-50 border border-gray-200 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt text-xs"></i>
                        <span>Log Out / Switch Account</span>
                    </button>
                </form>
            </div>

            {{-- Help text --}}
            <div class="mt-6 text-center">
                <p class="text-[11px] text-gray-400">
                    Need help? Contact our support team at <a href="mailto:support@warriorseducare.com" class="text-[#0ea5e9] font-medium hover:underline">support@warriorseducare.com</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
