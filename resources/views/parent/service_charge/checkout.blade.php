@extends('layouts.parent')

@section('title', 'PhonePe Secure Checkout - Parent Service Charge')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" x-data="{ sandboxModal: false, selectedMode: 'upi' }">
    <!-- Breadcrumb / Back button -->
    <div>
        <a href="{{ route('parent.serviceCharge.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-500 hover:text-purple-700 transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Invoices
        </a>
    </div>

    <!-- Main Payment Checkout Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
        
        <!-- Left Side: Order Summary -->
        <div class="md:col-span-5 bg-gradient-to-br from-[#2c0e5a] via-[#4a154b] to-[#5f259f] text-white p-7 sm:p-8 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-purple-400/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute -left-12 -top-12 w-48 h-48 bg-indigo-400/10 rounded-full blur-xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/15 rounded-2xl flex items-center justify-center text-white text-lg font-black shadow-inner">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-base sm:text-lg text-white">Warriors Educare</h4>
                        <p class="text-xs text-purple-200 font-semibold">PhonePe Verified Merchant</p>
                    </div>
                </div>

                <div class="border-t border-white/15 pt-5 space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-purple-200 block">Parent Service Invoice</span>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-purple-100">Invoice #:</span>
                        <span class="font-mono font-bold text-white">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-purple-100">Tuition Service:</span>
                        <span class="font-bold text-white">{{ $invoice->title }}</span>
                    </div>
                    @if($invoice->lead)
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-purple-100">Class & Subjects:</span>
                        <span class="font-bold text-white">Class {{ $invoice->lead->class }} ({{ $invoice->lead->subjects }})</span>
                    </div>
                    @endif
                </div>

                <div class="border-t border-white/15 pt-5 space-y-1.5">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-purple-200">Total Payable Amount</p>
                    <div class="text-3xl sm:text-4xl font-black text-white">
                        ₹{{ number_format($order['amount'], 2) }}
                    </div>
                    <p class="text-[10px] text-purple-200/80">Inclusive of all digital processing & teacher placement coordination fees.</p>
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
                        <i class="fas fa-bolt text-[9px]"></i> Instant Verification
                    </span>
                </div>
                <p class="text-xs text-slate-500">Pay securely via PhonePe using UPI (Google Pay, PhonePe, Paytm, BHIM), Credit/Debit Cards, or NetBanking.</p>
            </div>

            <!-- Supported Modes Highlights -->
            <div class="grid grid-cols-3 gap-3">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">UPI / QR</span>
                    <span class="text-[9px] text-slate-400">Instant UPI</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">Cards</span>
                    <span class="text-[9px] text-slate-400">All Major Cards</span>
                </div>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="fas fa-building-columns"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">Net Banking</span>
                    <span class="text-[9px] text-slate-400">50+ Banks</span>
                </div>
            </div>

            <!-- PhonePe Trigger Button -->
            <div>
                <button type="button" id="phonepe-parent-pay-button" 
                        class="w-full py-4 px-6 bg-gradient-to-r from-[#5f259f] to-[#4a154b] hover:from-[#6d2ab7] hover:to-[#571a58] text-white rounded-2xl text-sm font-bold transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2.5 group cursor-pointer">
                    <i class="fas fa-lock text-purple-200 group-hover:scale-110 transition-transform"></i>
                    <span>Pay ₹{{ number_format($order['amount'], 2) }} Securely via PhonePe</span>
                </button>
            </div>

            <!-- Hidden Form Submitted Upon PhonePe Success -->
            <form id="phonepe-parent-callback-form" action="{{ route('parent.serviceCharge.callback') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="merchantTransactionId" id="parent_merchantTransactionId" value="{{ $order['order_id'] }}">
                <input type="hidden" name="transactionId" id="parent_transactionId">
                <input type="hidden" name="code" id="parent_code" value="PAYMENT_SUCCESS">
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
                        <h4 class="font-black text-sm text-slate-900">PhonePe Payment Simulator</h4>
                        <span class="text-[10px] text-slate-400 font-semibold">Test Sandbox Environment</span>
                    </div>
                </div>
                <button type="button" @click="sandboxModal = false" class="text-slate-400 hover:text-slate-700">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed">
                Click below to complete the test payment transaction for ₹{{ number_format($order['amount'], 2) }}.
            </p>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-1 font-mono text-slate-600">
                <div><span class="text-slate-400">Order ID:</span> <strong class="text-slate-800">{{ $order['order_id'] }}</strong></div>
                <div><span class="text-slate-400">Amount:</span> <strong class="text-emerald-700">₹{{ number_format($order['amount'], 2) }}</strong></div>
                <div><span class="text-slate-400">Gateway:</span> <strong>PhonePe PG</strong></div>
            </div>

            <div class="pt-2">
                <button type="button" id="parent-confirm-sandbox-pay" 
                        class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fas fa-check-circle"></i> Complete Test Payment
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

        function triggerCallback(paymentId, orderId) {
            document.getElementById('parent_transactionId').value = paymentId;
            document.getElementById('parent_merchantTransactionId').value = orderId;
            document.getElementById('parent_code').value = 'PAYMENT_SUCCESS';
            
            const btn = document.getElementById('phonepe-parent-pay-button');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Payment...';
            }

            document.getElementById('phonepe-parent-callback-form').submit();
        }

        const payButton = document.getElementById('phonepe-parent-pay-button');

        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            // If PhonePe returned direct redirect URL
            if (orderData.redirect_url) {
                payButton.disabled = true;
                payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Redirecting to PhonePe...';
                window.location.href = orderData.redirect_url;
                return;
            }

            // Sandbox / test fallback
            const alpineEl = document.querySelector('[x-data]');
            if (alpineEl && alpineEl.__x) {
                alpineEl.__x.$data.sandboxModal = true;
            } else {
                if (confirm("Proceed with Test Payment of ₹" + orderData.amount + "?")) {
                    triggerCallback('PP_TEST_' + Date.now(), orderData.order_id);
                }
            }
        });

        const confirmSandboxBtn = document.getElementById('parent-confirm-sandbox-pay');
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
