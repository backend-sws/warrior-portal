@extends('layouts.parent')

@section('title', 'Service Charge Invoices')
@section('subtitle', 'View and pay service charge invoices sent by Admin.')

@section('content')
<div class="space-y-8">
    
    <!-- Top Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1e3a8a] flex items-center justify-center text-xl">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Total Invoices</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $serviceChargeInvoices->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Paid Invoices</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $serviceChargeInvoices->where('status', 'Paid')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Unpaid Amount</p>
                    <p class="text-2xl font-bold text-amber-600">
                        ${{ number_format($serviceChargeInvoices->where('status', 'Unpaid')->sum('amount'), 2) }} USD
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-file-invoice text-[#1e3a8a]"></i> Service Charge Invoices
            </h3>
            <span class="text-xs font-semibold bg-blue-100 text-[#1e3a8a] px-3 py-1 rounded-full">
                Sent by Admin
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Invoice #</th>
                        <th class="px-6 py-4">Title & Details</th>
                        <th class="px-6 py-4">Amount ($ USD)</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Due Date</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($serviceChargeInvoices as $invoice)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-[#1e3a8a]">
                                {{ $invoice->invoice_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $invoice->title }}</div>
                                @if($invoice->lead)
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        Class: {{ $invoice->lead->class }} ({{ $invoice->lead->subjects }})
                                    </div>
                                @endif
                                @if($invoice->notes)
                                    <div class="text-xs text-gray-400 italic mt-0.5">{{ $invoice->notes }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-extrabold text-green-600 text-base">
                                    ${{ number_format($invoice->amount, 2) }} USD
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5
                                    {{ $invoice->status === 'Paid' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                    {{ $invoice->status === 'Unpaid' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                    {{ $invoice->status === 'Cancelled' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}
                                ">
                                    @if($invoice->status === 'Paid')
                                        <i class="fas fa-check-circle text-green-600"></i> Paid
                                    @elseif($invoice->status === 'Unpaid')
                                        <i class="fas fa-exclamation-circle text-amber-600"></i> Unpaid
                                    @else
                                        Cancelled
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}
                                @if($invoice->status === 'Paid' && $invoice->updated_at)
                                    <div class="text-[11px] text-green-600 font-medium mt-0.5">
                                        Paid on: {{ $invoice->updated_at->format('M d, Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($invoice->status === 'Unpaid')
                                    <form action="{{ route('parent.serviceCharge.pay') }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2 rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center gap-1.5">
                                            <i class="fas fa-credit-card"></i> Pay Now (${{ number_format($invoice->amount, 2) }})
                                        </button>
                                        @if(env('APP_ENV') === 'local')
                                            <button type="submit" name="bypass" value="1" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-2.5 py-2 rounded-xl text-[10px] transition-colors" title="Quick Local Test Pay">
                                                Test Pay
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('parent.serviceCharge.print', $invoice->id) }}" target="_blank" class="bg-blue-50 hover:bg-blue-100 text-[#1e3a8a] font-bold px-3 py-2 rounded-xl text-xs transition-all inline-flex items-center gap-1.5 border border-blue-200">
                                            <i class="fas fa-print"></i> Print Invoice
                                        </a>
                                        <a href="{{ route('parent.serviceCharge.download', $invoice->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-2 rounded-xl text-xs transition-all inline-flex items-center gap-1.5">
                                            <i class="fas fa-download"></i> PDF
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-file-invoice text-4xl mb-3 block text-gray-200"></i>
                                No service charge invoices sent by Admin yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment History Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-history text-[#1e3a8a]"></i> Payment History
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Transaction ID</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Payment Type</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($paymentHistory ?? [] as $txn)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-gray-800">
                                {{ $txn->transaction_id ?: 'N/A' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-green-600">
                                ₹{{ number_format($txn->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-600 capitalize">
                                {{ str_replace('_', ' ', $txn->type) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $txn->status === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}
                                ">
                                    {{ ucfirst($txn->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $txn->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                No payment transaction history recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
