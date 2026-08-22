@extends('layouts.parent')

@section('title', 'Razorpay Secure Checkout - Parent Service Charge')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Breadcrumb / Back button -->
    <div>
        <a href="{{ route('parent.serviceCharge.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-500 hover:text-accent-blue transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Invoices
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
                    <span class="text-[10px] font-bold uppercase tracking-wider text-cyan-300 block">Parent Service Invoice</span>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Invoice #:</span>
                        <span class="font-mono font-bold text-white">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Tuition Service:</span>
                        <span class="font-bold text-white">{{ $invoice->title }}</span>
                    </div>
                    @if($invoice->lead)
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-blue-100">Class & Subjects:</span>
                        <span class="font-bold text-white">Class {{ $invoice->lead->class }} ({{ $invoice->lead->subjects }})</span>
                    </div>
                    @endif
                </div>

                <div class="border-t border-white/15 pt-5 space-y-1.5">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-blue-200">Total Payable Amount</p>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400">
                        ₹{{ number_format($order['amount'], 2) }}
                    </div>
                    <p class="text-[10px] text-blue-200/80">Inclusive of all digital processing & teacher placement coordination fees.</p>
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
                        <i class="fas fa-bolt text-[9px]"></i> Instant Verification
                    </span>
                </div>
                <p class="text-xs text-slate-500">Pay securely via Razorpay using UPI (Google Pay, PhonePe, Paytm, BHIM), Credit/Debit Cards, or NetBanking.</p>
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

            <!-- Razorpay Trigger Button -->
            <div>
                <button type="button" id="rzp-parent-pay-button" 
                        class="w-full py-4 px-6 bg-gradient-to-r from-[#0a2558] to-[#1e40af] hover:from-[#0d3175] hover:to-[#2563eb] text-white rounded-2xl text-sm font-bold transition-all shadow-xl hover:shadow-2xl flex items-center justify-center gap-2.5 group">
                    <i class="fas fa-lock text-emerald-400 group-hover:scale-110 transition-transform"></i>
                    <span>Pay ₹{{ number_format($order['amount'], 2) }} Securely via Razorpay</span>
                </button>
            </div>

            <!-- Hidden Form Submitted Upon Razorpay Success -->
            <form id="razorpay-parent-callback-form" action="{{ route('parent.serviceCharge.callback') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="razorpay_payment_id" id="parent_razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="parent_razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="parent_razorpay_signature">
            </form>
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

        const options = {
            "key": orderData.key,
            "amount": orderData.amount_paisa,
            "currency": orderData.currency || "INR",
            "name": orderData.name || "Warriors Educare",
            "description": "Parent Tuition Service Charge (Invoice #" + invoiceId + ")",
            "image": "{{ asset('adobe.png') }}",
            "order_id": orderData.order_id,
            "handler": function (response) {
                document.getElementById('parent_razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('parent_razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('parent_razorpay_signature').value = response.razorpay_signature;
                
                const btn = document.getElementById('rzp-parent-pay-button');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Payment...';

                document.getElementById('razorpay-parent-callback-form').submit();
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
            }
        };

        const rzp = new Razorpay(options);

        rzp.on('payment.failed', function (response) {
            alert("Payment Failed: " + response.error.description);
        });

        document.getElementById('rzp-parent-pay-button').onclick = function(e) {
            rzp.open();
            e.preventDefault();
        };
    });
</script>
@endpush
