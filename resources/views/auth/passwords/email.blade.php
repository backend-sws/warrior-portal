@extends('layouts.app')

@section('title', 'Forgot Password - Reset Your Account | Warriors Educare')
@section('meta_description', 'Forgot your password? Reset your Warriors Educare account password quickly and securely. Enter your registered email to receive a password reset link.')

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
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#031b4e] to-[#0ea5e9] text-white shadow-lg shadow-[#0ea5e9]/25 flex items-center justify-center text-2xl mx-auto mb-4 transition-transform hover:scale-110">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#031b4e] tracking-tight">Forgot Password?</h1>
                <p class="mt-2 text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                    Enter your registered email address and we'll send you a link to reset your password.
                </p>
            </div>

            {{-- Status Alert (Success) --}}
            @if (session('status'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in-down">
                    <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5 text-xs shadow-sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-900">Reset link sent!</p>
                        <p class="text-xs text-emerald-700 mt-0.5 leading-relaxed">{{ session('status') }}</p>
                        <p class="text-[11px] text-emerald-600 mt-1.5 font-medium">Please check your inbox & spam folder.</p>
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
                            <p class="text-sm font-bold text-red-900">Unable to proceed</p>
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
            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email-address" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Registered Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input id="email-address" name="email" type="email" autocomplete="email" required
                            class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-11 pr-4 py-3.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#031b4e] focus:border-transparent focus:bg-white transition-all shadow-sm"
                            placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#031b4e] text-white font-bold py-3.5 px-6 rounded-xl hover:bg-[#0a2970] focus:outline-none focus:ring-4 focus:ring-[#031b4e]/20 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span>Send Password Reset Link</span>
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
