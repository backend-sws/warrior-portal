@extends('layouts.parent')

@section('title', 'Payment Gateway - Pay Service Charge')
@section('subtitle', 'Secure Online Payment Gateway')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Breadcrumb / Back button -->
    <div>
        <a href="{{ route('parent.serviceCharge.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#1e3a8a] transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Service Charge Invoices
        </a>
    </div>

    <!-- Main Payment Checkout Card -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
        
        <!-- Left Side: Order Summary -->
        <div class="md:col-span-5 bg-[#1e3a8a] text-white p-8 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/10 rounded-full"></div>
            <div class="absolute -left-12 -top-12 w-48 h-48 bg-white/10 rounded-full"></div>

            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('adobe.png') }}" alt="Logo" class="h-10 bg-white p-2 rounded-xl">
                    <div>
                        <h4 class="font-bold text-lg text-white">Warriors Educare</h4>
                        <p class="text-sm text-blue-100 font-semibold">Payment Gateway</p>
                    </div>
                </div>

                <div class="border-t border-white/20 pt-6 space-y-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-200">Invoice Details</p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-blue-100 font-medium">Invoice #:</span>
                        <span class="font-mono font-bold text-white">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-blue-100 font-medium">Service:</span>
                        <span class="font-bold text-white">{{ $invoice->title }}</span>
                    </div>
                    @if($invoice->lead)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-blue-100 font-medium">Class / Subject:</span>
                        <span class="font-bold text-white">{{ $invoice->lead->class }} ({{ $invoice->lead->subjects }})</span>
                    </div>
                    @endif
                </div>

                <div class="border-t border-white/20 pt-6 space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Payable Amount</p>
                    <div class="text-3xl font-extrabold text-green-400">
                        ${{ number_format($invoice->amount, 2) }} USD
                    </div>
                    <p class="text-[11px] text-gray-400">Includes all applicable service taxes and platform processing fees.</p>
                </div>
            </div>

            <div class="relative z-10 pt-8 border-t border-white/10 flex items-center justify-between text-xs text-gray-400">
                <span class="inline-flex items-center gap-1.5 text-green-400">
                    <i class="fas fa-lock text-xs"></i> 256-Bit SSL Encrypted
                </span>
                <span>PCI-DSS Compliant</span>
            </div>
        </div>

        <!-- Right Side: Gateway Options -->
        <div class="md:col-span-7 p-8 space-y-6 bg-white" x-data="{ paymentMethod: 'upi' }">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Select Payment Method</h3>
                <p class="text-xs text-gray-500 mt-1">Choose your preferred gateway channel to complete the transaction.</p>
            </div>

            <!-- Payment Method Tabs -->
            <div class="grid grid-cols-3 gap-3">
                <button type="button" @click="paymentMethod = 'upi'"
                    :class="paymentMethod === 'upi' ? 'border-[#1e3a8a] bg-blue-50/50 text-[#1e3a8a] shadow-sm' : 'border-gray-200 text-gray-600 hover:bg-gray-50'"
                    class="p-4 rounded-2xl border-2 text-center transition-all flex flex-col items-center gap-2">
                    <i class="fas fa-qrcode text-xl"></i>
                    <span class="text-xs font-bold">UPI / QR</span>
                </button>

                <button type="button" @click="paymentMethod = 'card'"
                    :class="paymentMethod === 'card' ? 'border-[#1e3a8a] bg-blue-50/50 text-[#1e3a8a] shadow-sm' : 'border-gray-200 text-gray-600 hover:bg-gray-50'"
                    class="p-4 rounded-2xl border-2 text-center transition-all flex flex-col items-center gap-2">
                    <i class="fas fa-credit-card text-xl"></i>
                    <span class="text-xs font-bold">Card</span>
                </button>

                <button type="button" @click="paymentMethod = 'netbanking'"
                    :class="paymentMethod === 'netbanking' ? 'border-[#1e3a8a] bg-blue-50/50 text-[#1e3a8a] shadow-sm' : 'border-gray-200 text-gray-600 hover:bg-gray-50'"
                    class="p-4 rounded-2xl border-2 text-center transition-all flex flex-col items-center gap-2">
                    <i class="fas fa-university text-xl"></i>
                    <span class="text-xs font-bold">Net Banking</span>
                </button>
            </div>

            <!-- Form submission to callback with bypass or payment gateway response -->
            <form action="{{ route('parent.serviceCharge.callback') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="transactionId" value="{{ $transactionId }}">
                <input type="hidden" name="bypass" value="1">
                <input type="hidden" name="amount" value="{{ $invoice->amount }}">

                <!-- UPI Details View -->
                <div x-show="paymentMethod === 'upi'" class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-700">UPI ID / VPA</span>
                        <span class="text-[10px] text-green-600 font-semibold bg-green-100 px-2 py-0.5 rounded-full">Instant Approval</span>
                    </div>
                    <input type="text" placeholder="e.g. parent@upi or 9876543210@paytm" class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#1e3a8a] outline-none">
                    <p class="text-xs text-gray-400">Supported apps: PhonePe, Google Pay, Paytm, BHIM</p>
                </div>

                <!-- Card Details View -->
                <div x-show="paymentMethod === 'card'" class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-4" style="display: none;">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Card Number</label>
                        <input type="text" placeholder="4532 •••• •••• 8901" class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#1e3a8a] outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Expiry Date</label>
                            <input type="text" placeholder="MM / YY" class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#1e3a8a] outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">CVV</label>
                            <input type="password" placeholder="•••" maxlength="4" class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#1e3a8a] outline-none">
                        </div>
                    </div>
                </div>

                <!-- Net Banking Details View -->
                <div x-show="paymentMethod === 'netbanking'" class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-4" style="display: none;">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Select Your Bank</label>
                    <select class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#1e3a8a] outline-none">
                        <option>State Bank of India (SBI)</option>
                        <option>HDFC Bank</option>
                        <option>ICICI Bank</option>
                        <option>Axis Bank</option>
                        <option>Kotak Mahindra Bank</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#1e3a8a] hover:bg-[#1e3a8a]/90 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-lock"></i> Pay ${{ number_format($invoice->amount, 2) }} USD Securely
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
