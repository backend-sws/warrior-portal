@extends('layouts.app')

@section('title', 'Razorpay Secure Checkout - Service Charge')

@section('content')
@include('candidate.partials.nav')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" x-data="{ sandboxModal: false, selectedMode: 'upi' }">
    <!-- Breadcrumb / Back button -->
    <div>
        <a href="{{ route('candidate.serviceCharge.show') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-500 hover:text-accent-blue transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Invoices & Service Charges
        </a>
    </div>

    <!-- Main Payment Checkout Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
        
        <!-- Left Side: Order Summary -->
        <div class="md:col-span-5 bg-gradient-to-br from-[#0a2558] to-[#1e40af] text-white p-7 sm:p-8 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute -left-12 -top-12 w-48 h-48 bg-cyan-400/10 rounded-full blur-xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/15 rounded-2xl flex items-center justify-center text-white text-lg font-black shadow-inner">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-base sm:text-lg text-white">Warriors Educare</h4>
                        <p class="text-xs text-blue-200 font-semibold">Razorpay Verified Merchant</p>
                    </div>
                </div>

                <div class="border-t border-white/15 pt-5 space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-300 block">Service Invoice Details</span>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Invoice ID:</span>
                        <span class="font-mono font-bold text-white">#{{ $invoice->id }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Category:</span>
                        <span class="font-bold text-white">{{ $invoice->home_tuition_lead_id ? 'Home Tuition Commission' : 'School Job Placement Fee' }}</span>
                    </div>
                    @if($invoice->tuitionLead)
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Class & Location:</span>
                        <span class="font-bold text-white">Class {{ $invoice->tuitionLead->class }} ({{ $invoice->tuitionLead->location }})</span>
                    </div>
                    @elseif($invoice->jobApplication?->jobPost)
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Job Role:</span>
                        <span class="font-bold text-white">{{ $invoice->jobApplication->jobPost->title }} ({{ $invoice->jobApplication->jobPost->school_name }})</span>
                    </div>
                    @endif
                    @if($invoice->late_fee > 0)
                    <div class="flex justify-between items-center text-xs text-rose-300">
                        <span>Late Fee Penalty:</span>
                        <span class="font-bold">+ ₹{{ number_format($invoice->late_fee, 2) }}</span>
                    </div>
                    @endif
                </div>

                <div class="border-t border-white/15 pt-5 space-y-1.5">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-blue-200">Total Payable Amount</p>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400">
                        ₹{{ number_format($order['amount'], 2) }}
                    </div>
                    <p class="text-[10px] text-blue-200/80">Inclusive of all digital processing & placement settlement charges.</p>
                </div>
            </div>

            <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-[11px] text-blue-200/80">
                <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold">
                    <i class="fas fa-lock text-xs"></i> 256-Bit SSL Secured
                </span>
                <span>Razorpay PCI-DSS</span>
            </div>
        </div>

        <!-- Right Side: Gateway Trigger View -->
        <div class="md:col-span-7 p-7 sm:p-8 space-y-6 bg-white flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg sm:text-xl font-black text-slate-900">Secure Payment Checkout</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 flex items-center gap-1">
                        <i class="fas fa-bolt text-[9px]"></i> Instant Confirmation
                    </span>
                </div>
                <p class="text-xs text-slate-500">Pay securely via Razorpay using UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, NetBanking, or Wallets.</p>
            </div>

            <!-- Supported Modes Highlights -->
            <div class="grid grid-cols-3 gap-3">
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex flex-col items-center gap-1.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-800">UPI / QR</span>
                    <span class="text-[9px] text-slate-400">GPay, PhonePe, Paytm</span>
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

            <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 text-xs text-slate-700 space-y-1.5">
                <div class="flex items-center gap-2 font-bold text-blue-900">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    <span>Payment Information:</span>
                </div>
                <p class="text-[11px] text-slate-600">
                    Clicking "Pay Now" will open the Razorpay secure payment gateway modal. Once completed, your invoice and digital receipt will be automatically verified and updated in real-time.
                </p>
            </div>

            <!-- Razorpay Trigger Button -->
            <div>
                <button type="button" id="rzp-pay-button" 
                        class="w-full py-4 px-6 bg-gradient-to-r from-[#0a2558] to-[#1e40af] hover:from-[#0d3175] hover:to-[#2563eb] text-white rounded-2xl text-sm font-bold transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2.5 group cursor-pointer">
                    <i class="fas fa-lock text-emerald-400 group-hover:scale-110 transition-transform"></i>
                    <span>Pay ₹{{ number_format($order['amount'], 2) }} Securely via Razorpay</span>
                </button>
            </div>

            <!-- Hidden Form Submitted Upon Razorpay Success -->
            <form id="razorpay-callback-form" action="{{ route('candidate.serviceCharge.callback') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">
            </form>
        </div>

    </div>

    <!-- Razorpay Sandbox Simulator Modal (For Local / Test Mode) -->
    <div x-show="sandboxModal" x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
         x-transition>
        <div class="bg-white rounded-3xl border border-slate-200 max-w-md w-full p-6 shadow-2xl space-y-5"
             @click.outside="sandboxModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-sm text-slate-900">Razorpay Payment Simulator</h4>
                        <span class="text-[10px] text-slate-400 font-semibold">Test Sandbox Environment</span>
                    </div>
                </div>
                <button type="button" @click="sandboxModal = false" class="text-slate-400 hover:text-slate-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500">Merchant:</span>
                    <span class="font-bold text-slate-800">Warriors Educare</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500">Invoice:</span>
                    <span class="font-bold text-slate-800">#{{ $invoice->id }}</span>
                </div>
                <div class="flex justify-between text-xs pt-1 border-t border-slate-200">
                    <span class="font-bold text-slate-700">Amount:</span>
                    <span class="font-black text-base text-emerald-600">₹{{ number_format($order['amount'], 2) }}</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700">Select Test Payment Mode:</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" @click="selectedMode = 'upi'" :class="selectedMode === 'upi' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'" class="py-2 px-3 rounded-xl text-xs font-bold transition-all">
                        UPI / GPay
                    </button>
                    <button type="button" @click="selectedMode = 'card'" :class="selectedMode === 'card' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'" class="py-2 px-3 rounded-xl text-xs font-bold transition-all">
                        Card
                    </button>
                    <button type="button" @click="selectedMode = 'netbanking'" :class="selectedMode === 'netbanking' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700'" class="py-2 px-3 rounded-xl text-xs font-bold transition-all">
                        Netbanking
                    </button>
                </div>
            </div>

            <div class="pt-2">
                <button type="button" id="confirm-sandbox-pay" 
                        class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i> Complete Successful Payment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const orderData = @json($order);
        const userData = @json($user);
        const invoiceId = "{{ $invoice->id }}";
        const isMock = orderData.is_mock || (orderData.key && orderData.key.includes('placeholder'));

        function triggerCallback(paymentId, orderId, signature) {
            document.getElementById('razorpay_payment_id').value = paymentId;
            document.getElementById('razorpay_order_id').value = orderId;
            document.getElementById('razorpay_signature').value = signature;
            
            const btn = document.getElementById('rzp-pay-button');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Payment...';
            }

            document.getElementById('razorpay-callback-form').submit();
        }

        const payButton = document.getElementById('rzp-pay-button');

        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            // If in test/mock mode or placeholder keys
            if (isMock || typeof Razorpay === 'undefined') {
                const alpineEl = document.querySelector('[x-data]');
                if (alpineEl && alpineEl.__x) {
                    alpineEl.__x.$data.sandboxModal = true;
                } else {
                    // Fallback direct confirmation
                    if (confirm("Proceed with Test Sandbox Payment of ₹" + orderData.amount + "?")) {
                        triggerCallback('pay_mock_' + Date.now(), orderData.order_id, 'mock_sig_' + Date.now());
                    }
                }
                return;
            }

            try {
                const options = {
                    "key": orderData.key,
                    "amount": orderData.amount_paisa,
                    "currency": orderData.currency || "INR",
                    "name": orderData.name || "Warriors Educare",
                    "description": "Service Charge Settlement (Invoice #" + invoiceId + ")",
                    "image": "{{ asset('adobe.png') }}",
                    "order_id": orderData.order_id,
                    "handler": function (response) {
                        triggerCallback(response.razorpay_payment_id, response.razorpay_order_id, response.razorpay_signature);
                    },
                    "prefill": {
                        "name": userData.name || "",
                        "email": userData.email || "",
                        "contact": userData.phone || ""
                    },
                    "notes": {
                        "invoice_id": invoiceId,
                        "user_id": userData.id
                    },
                    "theme": {
                        "color": "#0a2558"
                    },
                    "modal": {
                        "ondismiss": function() {
                            console.log('Razorpay modal closed');
                        }
                    }
                };

                const rzp = new Razorpay(options);

                rzp.on('payment.failed', function (response) {
                    alert("Payment Failed: " + (response.error ? response.error.description : 'Transaction cancelled'));
                });

                rzp.open();
            } catch (err) {
                console.warn('Razorpay SDK error, falling back to sandbox simulator:', err);
                const alpineEl = document.querySelector('[x-data]');
                if (alpineEl && alpineEl.__x) {
                    alpineEl.__x.$data.sandboxModal = true;
                } else {
                    triggerCallback('pay_mock_' + Date.now(), orderData.order_id, 'mock_sig_' + Date.now());
                }
            }
        });

        const confirmSandboxBtn = document.getElementById('confirm-sandbox-pay');
        if (confirmSandboxBtn) {
            confirmSandboxBtn.addEventListener('click', function() {
                confirmSandboxBtn.disabled = true;
                confirmSandboxBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                triggerCallback('pay_mock_' + Date.now(), orderData.order_id, 'mock_sig_' + Date.now());
            });
        }
    });
</script>
@endpush
