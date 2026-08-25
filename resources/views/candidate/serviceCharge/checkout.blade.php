@extends('layouts.app')

@section('content')
@include('candidate.partials.nav')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6" x-data="{ sandboxModal: false }">

    <!-- Top Navigation / Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('candidate.serviceCharge.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Back to Service Charge Portal
        </a>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
            <i class="fas fa-shield-alt text-[10px]"></i> PhonePe Verified PG
        </span>
    </div>

    <!-- Main Payment Container -->
    <div class="grid grid-cols-1 md:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-slate-200 bg-white">
        
        <!-- Left Side: Invoice & Amount Summary (Dark Purple Theme) -->
        <div class="md:col-span-5 bg-gradient-to-br from-[#2c0e5a] via-[#4a154b] to-[#5f259f] text-white p-7 sm:p-8 flex flex-col justify-between relative overflow-hidden">
            <!-- Background Graphic Circles -->
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-purple-400/10 blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-indigo-400/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <!-- Branding Header -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white shadow-inner">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-sm tracking-wide uppercase text-purple-200">Warriors Educare</h4>
                        <p class="text-[11px] text-purple-300">Candidate Payment Settlement</p>
                    </div>
                </div>

                <!-- Invoice Meta Details -->
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 space-y-2.5">
                    <div class="flex justify-between text-xs">
                        <span class="text-purple-200">Invoice Number</span>
                        <span class="font-bold text-white tracking-wider">#{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-purple-200">Tuition Lead Ref</span>
                        <span class="font-bold text-white">{{ $invoice->lead?->tuition_id ?? ('TUI-' . str_pad($invoice->home_tuition_lead_id ?? 1, 4, '0', STR_PAD_LEFT)) }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-purple-200">Due Date</span>
                        <span class="font-semibold text-white">{{ $invoice->due_date ? $invoice->due_date->format('d M, Y') : 'Immediate' }}</span>
                    </div>
                </div>

                <!-- Total Amount Card -->
                <div class="space-y-1">
                    <p class="text-xs font-semibold text-purple-200 uppercase tracking-wider">Total Payable Amount</p>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-3xl sm:text-4xl font-black tracking-tight text-white">₹{{ number_format($order['amount'], 2) }}</span>
                        <span class="text-xs text-purple-300 font-medium">INR (All inclusive)</span>
                    </div>
                    @if($invoice->late_fee > 0)
                        <p class="text-[11px] text-amber-300 flex items-center gap-1 font-medium mt-1">
                            <i class="fas fa-exclamation-triangle text-[10px]"></i> Includes ₹{{ number_format($invoice->late_fee, 2) }} overdue charge
                        </p>
                    @endif
                </div>
            </div>

            <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-[11px] text-purple-200/80">
                <span class="inline-flex items-center gap-1.5 text-emerald-300 font-semibold">
                    <i class="fas fa-lock text-xs"></i> 256-Bit SSL Secured
                </span>
                <span>PhonePe Standard PG</span>
            </div>
        </div>

        <!-- Right Side: Gateway Trigger View -->
        <div class="md:col-span-7 p-7 sm:p-8 space-y-6 bg-white flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg sm:text-xl font-black text-slate-900">Secure Payment Checkout</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 flex items-center gap-1">
                        <i class="fas fa-bolt text-[9px]"></i> Instant Confirmation
                    </span>
                </div>
                <p class="text-xs text-slate-500">Pay securely via PhonePe using UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, NetBanking, or Wallets.</p>
            </div>

            <!-- Supported Modes Highlights -->
            <div class="grid grid-cols-3 gap-3">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">UPI / QR</span>
                    <span class="text-[9px] text-slate-400">PhonePe, GPay, Paytm</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">Cards</span>
                    <span class="text-[9px] text-slate-400">Visa, Master, RuPay</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="fas fa-building-columns"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">Net Banking</span>
                    <span class="text-[9px] text-slate-400">50+ Major Banks</span>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-100 text-xs text-slate-700 space-y-1.5">
                <div class="flex items-center gap-2 font-bold text-purple-900">
                    <i class="fas fa-info-circle text-purple-600"></i>
                    <span>Payment Information:</span>
                </div>
                <p class="text-[11px] text-slate-600">
                    Clicking "Pay Now" will redirect you to the official PhonePe secure payment gateway. Once payment is completed, your invoice and digital receipt will be verified and updated in real-time.
                </p>
            </div>

            <!-- PhonePe Trigger Button -->
            <div>
                <button type="button" id="phonepe-pay-button" 
                        class="w-full py-4 px-6 bg-gradient-to-r from-[#5f259f] to-[#4a154b] hover:from-[#6d2ab7] hover:to-[#571a58] text-white rounded-2xl text-sm font-bold transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2.5 group cursor-pointer">
                    <i class="fas fa-lock text-purple-200 group-hover:scale-110 transition-transform"></i>
                    <span>Pay ₹{{ number_format($order['amount'], 2) }} Securely via PhonePe</span>
                </button>
            </div>

            <!-- Hidden Form Submitted Upon PhonePe Callback -->
            <form id="phonepe-callback-form" action="{{ route('candidate.serviceCharge.callback') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="merchantTransactionId" id="cb_merchantTransactionId" value="{{ $order['order_id'] }}">
                <input type="hidden" name="transactionId" id="cb_transactionId">
                <input type="hidden" name="code" id="cb_code" value="PAYMENT_SUCCESS">
            </form>
        </div>

    </div>

    <!-- PhonePe Sandbox Simulator Modal (For Local / Test Mode) -->
    <div x-show="sandboxModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
         x-transition>
        <div class="bg-white rounded-3xl border border-slate-200 max-w-md w-full p-6 shadow-2xl space-y-5"
             @click.outside="sandboxModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-xs">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">PhonePe Sandbox Simulator</h4>
                        <p class="text-[10px] text-slate-400">Local Development Environment</p>
                    </div>
                </div>
                <button type="button" @click="sandboxModal = false" class="text-slate-400 hover:text-slate-700">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed">
                You are testing in sandbox mode. Click below to simulate an authorized instant PhonePe transaction for ₹{{ number_format($order['amount'], 2) }}.
            </p>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-1 font-mono text-slate-600">
                <div><span class="text-slate-400">Merchant Txn:</span> <strong class="text-slate-800">{{ $order['order_id'] }}</strong></div>
                <div><span class="text-slate-400">Amount:</span> <strong class="text-emerald-700">₹{{ number_format($order['amount'], 2) }}</strong></div>
                <div><span class="text-slate-400">Gateway:</span> <strong>PhonePe Standard</strong></div>
            </div>

            <div class="pt-2">
                <button type="button" id="confirm-sandbox-pay" 
                        class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fas fa-check-circle"></i> Complete Successful Payment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const orderData = @json($order);
        const userData = @json($user);
        const invoiceId = "{{ $invoice->id }}";
        const isMock = orderData.is_mock || !orderData.redirect_url;

        function triggerCallback(paymentId, orderId) {
            document.getElementById('cb_transactionId').value = paymentId;
            document.getElementById('cb_merchantTransactionId').value = orderId;
            document.getElementById('cb_code').value = 'PAYMENT_SUCCESS';
            
            const btn = document.getElementById('phonepe-pay-button');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Payment...';
            }

            document.getElementById('phonepe-callback-form').submit();
        }

        const payButton = document.getElementById('phonepe-pay-button');

        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            // If PhonePe returned official Pay URL, redirect user
            if (orderData.redirect_url) {
                payButton.disabled = true;
                payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Redirecting to PhonePe...';
                window.location.href = orderData.redirect_url;
                return;
            }

            // Fallback for Sandbox / Local Test Mode
            const alpineEl = document.querySelector('[x-data]');
            if (alpineEl && alpineEl.__x) {
                alpineEl.__x.$data.sandboxModal = true;
            } else {
                if (confirm("Proceed with Test PhonePe Payment of ₹" + orderData.amount + "?")) {
                    triggerCallback('PP_TEST_' + Date.now(), orderData.order_id);
                }
            }
        });

        const confirmSandboxBtn = document.getElementById('confirm-sandbox-pay');
        if (confirmSandboxBtn) {
            confirmSandboxBtn.addEventListener('click', function() {
                confirmSandboxBtn.disabled = true;
                confirmSandboxBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                triggerCallback('PP_TEST_' + Date.now(), orderData.order_id);
            });
        }
    });
</script>
@endpush
