@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 reveal">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#031b4e]">Profile Registration</h1>
                    <p class="text-sm text-[#031b4e]/60 mt-0.5">Manage your registration, plan details, and agreements.</p>
                </div>
            </div>
            @if(auth()->user()->profile && auth()->user()->profile->pending_amount > 0)
                {{-- Button removed as payment is requested by Admin upon job placement --}}
            @endif
        </div>

        {{-- Main Details Card --}}
        <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl reveal reveal-delay-1 mb-8">
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $profile = auth()->user()->profile;
                        $registrationPlan = ucfirst($profile->plan_type ?? 'Standard');
                        $isComplete = $profile && $profile->is_profile_complete && $profile->is_agreement_signed && ($profile->initial_fee_paid || $profile->is_fee_paid);
                    @endphp
                    
                    {{-- Registration Plan --}}
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Registration Plan</p>
                        <div class="text-2xl font-bold {{ $registrationPlan === 'Premium' ? 'text-accent-yellow' : 'text-[#031b4e]' }}">
                            {{ $registrationPlan }}
                        </div>
                    </div>

                    {{-- Registration Status --}}
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Registration Status</p>
                        @if($isComplete)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-bold uppercase tracking-wider rounded-lg mt-1">
                                <i class="fas fa-check-circle"></i> Completed
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-accent-yellow/10 border border-accent-yellow/30 text-accent-yellow text-xs font-bold uppercase tracking-wider rounded-lg mt-1">
                                <i class="fas fa-exclamation-circle"></i> Pending
                            </div>
                        @endif
                    </div>

                    {{-- Paid Amount --}}
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Paid Amount</p>
                        <div class="text-lg font-semibold text-green-400">
                            ₹{{ number_format($registrationPaidAmount ?? 0, 2) }}
                        </div>
                    </div>

                    {{-- Pending Amount --}}
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Pending Amount</p>
                        <div class="text-2xl font-bold {{ ($profile->pending_amount ?? 0) > 0 ? 'text-red-400' : 'text-[#0ea5e9]' }}">
                            ₹{{ number_format($profile->pending_amount ?? 0, 2) }}
                        </div>
                        @if(($profile->pending_amount ?? 0) > 0)
                            <p class="text-xs text-[#031b4e]/70 mt-2 leading-relaxed bg-[#0ea5e9]/5 border border-[#0ea5e9]/10 p-2 rounded-lg">
                                <i class="fas fa-info-circle text-[#0ea5e9] mr-1"></i> This is the Final Registration fee, which will be requested by Admin upon successful job placement.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-[#031b4e]/10 flex flex-wrap gap-4">
                    {{-- Agreement PDF Button --}}
                    <a href="{{ route('candidate.agreement.download') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#f4f7f5] text-[#031b4e] rounded-xl text-sm font-semibold hover:bg-card-border/50 transition-colors border border-[#031b4e]/10">
                        <i class="fas fa-file-pdf text-red-400"></i> Download Agreement PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Payment History --}}
            <div class="reveal reveal-delay-2">
                <h2 class="text-lg font-bold text-[#031b4e] mb-4 flex items-center gap-2">
                    <i class="fas fa-history text-[#0ea5e9]"></i> Payment History
                </h2>
                <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-[#031b4e]/10 bg-[#f4f7f5]/20">
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Date</th>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Amount</th>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-200">
                                @if(isset($paymentHistory) && count($paymentHistory) > 0)
                                    @foreach($paymentHistory as $payment)
                                        <tr class="hover:bg-[#f4f7f5]/30 transition-colors">
                                            <td class="px-6 py-4 text-[#031b4e]/80/70 font-medium">
                                                {{ \Carbon\Carbon::parse($payment->created_at)->format('d M, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-[#031b4e] font-bold">
                                                ₹{{ number_format($payment->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if(isset($payment->status))
                                                    @if($payment->status === 'success' || $payment->status === 'COMPLETED')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                                            <i class="fas fa-check-circle mr-1 text-[9px]"></i> Successful
                                                        </span>
                                                    @elseif(strtolower($payment->status) === 'failed')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-500/10 text-red-500 border border-red-500/20">
                                                            <i class="fas fa-times-circle mr-1 text-[9px]"></i> Failed
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-accent-yellow/10 text-accent-yellow border border-accent-yellow/20">
                                                            <i class="fas fa-clock mr-1 text-[9px]"></i> {{ ucfirst(strtolower($payment->status)) }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                                        <i class="fas fa-check-circle mr-1 text-[9px]"></i> Successful
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                @if((isset($payment->status) && in_array($payment->status, ['success', 'COMPLETED'])) || !isset($payment->status))
                                                    <a href="{{ route('candidate.payment.invoice', $payment->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] hover:bg-[#0ea5e9] hover:text-white transition-all shadow-sm" title="Download Invoice">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="w-10 h-10 bg-card-border/30 rounded-xl flex items-center justify-center text-[#031b4e]/80/20 text-lg mx-auto mb-3">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <h3 class="text-sm font-semibold text-[#031b4e] mb-1">No Payments Found</h3>
                                            <p class="text-xs text-[#031b4e]/60">You haven't made any payments yet.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="reveal reveal-delay-3">
                <h2 class="text-lg font-bold text-[#031b4e] mb-4 flex items-center gap-2">
                    <i class="fas fa-bell text-accent-yellow"></i> Notifications
                </h2>
                <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl">
                    <div class="divide-y divide-gray-200">
                        @if(auth()->user()->notifications()->count() > 0)
                            @foreach(auth()->user()->notifications()->take(5)->get() as $notification)
                                <div class="p-5 flex gap-4 hover:bg-[#f4f7f5]/30 transition-colors {{ $notification->unread() ? 'bg-[#f4f7f5]/10' : '' }}">
                                    <div class="w-10 h-10 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#031b4e] mb-1">{{ $notification->data['title'] ?? ($notification->title ?? 'Notification') }}</h4>
                                        <p class="text-xs text-[#031b4e]/80/70 leading-relaxed">{{ $notification->data['message'] ?? ($notification->message ?? 'You have a new update.') }}</p>
                                        <span class="text-[10px] text-[#031b4e]/60 font-medium mt-2 block">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-6 py-12 text-center">
                                <div class="w-10 h-10 bg-card-border/30 rounded-xl flex items-center justify-center text-[#031b4e]/80/20 text-lg mx-auto mb-3">
                                    <i class="fas fa-bell-slash"></i>
                                </div>
                                <h3 class="text-sm font-semibold text-[#031b4e] mb-1">No Notifications</h3>
                                <p class="text-xs text-[#031b4e]/60">You are all caught up!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



