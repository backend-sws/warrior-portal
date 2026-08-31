@extends('layouts.app')

@section('content')
    @include('candidate.partials.nav')

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

        {{-- Flash Messages --}}
        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 reveal">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#031b4e]">Service Charge</h1>
                    <p class="text-xs sm:text-sm text-[#031b4e]/70 mt-0.5">View your service charge details and payment history.</p>
                </div>
            </div>
            @if($invoices->where('status', '!=', 'paid')->count() > 0)
                <div class="px-4 py-2 bg-amber-50 text-amber-800 rounded-xl text-xs sm:text-sm font-semibold border border-amber-200">
                    <i class="fas fa-exclamation-circle mr-1 text-amber-600"></i> You have pending service charges
                </div>
            @endif
        </div>

        @forelse($invoices as $invoice)
            <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 overflow-hidden shadow-sm reveal reveal-delay-1 mb-6 sm:mb-8 relative bg-white">
                @if($invoice->status === 'paid')
                    <div class="absolute top-0 right-0 px-3.5 py-1 bg-green-500 text-white text-[10px] sm:text-xs font-bold rounded-bl-xl shadow-sm">
                        <i class="fas fa-check-circle mr-1"></i> Paid
                    </div>
                @endif
                <div class="p-4 sm:p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @if($invoice->home_tuition_lead_id || str_contains(strtolower($invoice->description ?? ''), 'tuition'))
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-lg text-xs font-bold border border-purple-200 flex items-center gap-1.5">
                                <i class="fas fa-chalkboard-teacher text-purple-600"></i> Home Tuition Placement
                            </span>
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-bold border border-blue-200 flex items-center gap-1.5">
                                <i class="fas fa-school text-blue-600"></i> School Job Placement
                            </span>
                        @endif

                        @if(!empty($invoice->description))
                            <span class="text-xs font-bold text-[#031b4e]/80 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                {{ $invoice->description }}
                            </span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8">
                        
                        {{-- Service Charge Amount --}}
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-1 sm:mb-2">Service Charge Amount</p>
                            <div class="text-xl sm:text-2xl font-bold text-[#031b4e]">
                                ₹{{ number_format($invoice->amount ?? 0, 2) }}
                            </div>
                        </div>

                        {{-- Due Date --}}
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-1 sm:mb-2">Due Date</p>
                            <div class="text-base sm:text-lg font-semibold {{ (isset($invoice->due_date) && \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status !== 'paid') ? 'text-red-500' : 'text-[#031b4e]' }}">
                                {{ isset($invoice->due_date) ? \Carbon\Carbon::parse($invoice->due_date)->format('d M, Y') : 'N/A' }}
                            </div>
                        </div>

                        {{-- Late Fee --}}
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-1 sm:mb-2">Late Fine (₹300/day)</p>
                            <div class="text-base sm:text-lg font-semibold {{ ($invoice->late_fee ?? 0) > 0 ? 'text-red-600' : 'text-slate-700' }}">
                                ₹{{ number_format($invoice->late_fee ?? 0, 2) }}
                            </div>
                            @if(($invoice->late_fee ?? 0) > 0 && isset($invoice->due_date))
                                <span class="text-[10px] font-bold text-red-500 block mt-0.5">
                                    {{ (int) \Carbon\Carbon::parse($invoice->due_date)->startOfDay()->diffInDays(now()->startOfDay()) }} days overdue
                                </span>
                            @endif
                        </div>

                        {{-- Total Payable --}}
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-1 sm:mb-2">Total Payable</p>
                            @php
                                $pendingAmount = ($invoice->amount ?? 0) + ($invoice->late_fee ?? 0) - ($invoice->paid_amount ?? 0);
                            @endphp
                            <div class="text-xl sm:text-2xl font-extrabold {{ $pendingAmount > 0 ? 'text-red-500' : 'text-green-500' }}">
                                ₹{{ number_format(max(0, $pendingAmount), 2) }}
                            </div>
                            @if(($invoice->late_fee ?? 0) > 0)
                                <span class="text-[10px] text-slate-500 block mt-0.5">Includes ₹{{ number_format($invoice->late_fee, 0) }} late fine</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-[#031b4e]/10 flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                        @if($invoice->status === 'paid')
                            <a href="{{ route('candidate.serviceCharge.invoice', $invoice->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-[#031b4e] rounded-xl text-xs sm:text-sm font-semibold transition-all">
                                <i class="fas fa-file-pdf text-red-500"></i> Download Invoice PDF
                            </a>
                        @else
                            <div></div>
                        @endif
                        
                        @if($invoice->status !== 'paid')
                            <a href="{{ route('candidate.serviceCharge.checkout', $invoice->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-green-500 text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-green-600 hover:-translate-y-0.5 transition-all shadow-md active:scale-95">
                                <i class="fas fa-credit-card text-xs"></i> Pay ₹{{ number_format($pendingAmount, 2) }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 p-6 sm:p-8 text-center text-[#031b4e]/60 mb-6 sm:mb-8 shadow-sm bg-white">
                <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3 text-green-500 text-2xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-[#031b4e] mb-1">No Service Charges</h3>
                <p class="text-xs sm:text-sm text-slate-500">You do not have any service charge invoices at the moment.</p>
            </div>
        @endforelse

        {{-- Payment History --}}
        <h2 class="text-base sm:text-lg font-bold text-[#031b4e] mb-3 sm:mb-4 reveal reveal-delay-2">Payment History</h2>
        <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 overflow-hidden shadow-sm reveal reveal-delay-2 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#031b4e]/10 bg-slate-50">
                            <th class="px-4 sm:px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Date</th>
                            <th class="px-4 sm:px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Transaction ID</th>
                            <th class="px-4 sm:px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Amount</th>
                            <th class="px-4 sm:px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Status</th>
                            <th class="px-4 sm:px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs sm:text-sm divide-y divide-slate-100">
                        @if(isset($paymentHistory) && count($paymentHistory) > 0)
                            @foreach($paymentHistory as $payment)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-3.5 text-slate-600 font-medium whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($payment->created_at)->format('d M, Y') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-3.5 text-[#031b4e] font-semibold whitespace-nowrap">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-3.5 text-[#031b4e] font-bold whitespace-nowrap">
                                        ₹{{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                            <i class="fas fa-check-circle mr-1 text-[9px]"></i> Successful
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('candidate.payment.invoice', $payment->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] hover:bg-[#0ea5e9] hover:text-white transition-all shadow-sm" title="Download Invoice">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xl mx-auto mb-3">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-[#031b4e] mb-1">No Payment History</h3>
                                    <p class="text-xs text-slate-500">You haven't made any payments yet.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
