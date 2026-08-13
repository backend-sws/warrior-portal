@extends('layouts.parent')

@section('content')
<div class="py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Parent Dashboard</h1>
        <a href="{{ route('parent.tuitions.create') }}" class="bg-[#1e3a8a] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#1e3a8a]/90">
            <i class="fas fa-plus mr-2"></i>Post Tuition Requirement
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Requirements</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tuitions->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tuitions->where('status', 'Confirmed')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">In Progress / Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $tuitions->whereNotIn('status', ['Confirmed', 'Cancelled'])->count() }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('parent.serviceCharge.index') }}" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:border-blue-400 transition-all cursor-pointer group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Service Charge Invoices</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ isset($serviceChargeInvoices) ? $serviceChargeInvoices->count() : 0 }}</p>
                </div>
            </div>
        </a>
    </div>

    <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Your Home Tuition Requirements</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold">Class & Subjects</th>
                        <th class="px-6 py-4 font-bold">Location</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Date Posted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tuitions as $tuition)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $tuition->class }}</div>
                                <div class="text-gray-500 text-xs">{{ $tuition->subjects }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $tuition->location }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $tuition->status === 'Confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ in_array($tuition->status, ['New Lead', 'Pending']) ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ in_array($tuition->status, ['Demo Scheduled', 'Demo Completed']) ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $tuition->status === 'Cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                ">
                                    {{ $tuition->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $tuition->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                You haven't posted any tuition requirements yet.
                                <br>
                                <a href="{{ route('parent.tuitions.create') }}" class="text-[#1e3a8a] font-bold hover:underline mt-2 inline-block">Post one now</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden mt-8">
        <div class="px-6 py-5 border-b border-gray-100 bg-green-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Assigned Tutors</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold">Class & Subjects</th>
                        <th class="px-6 py-4 font-bold">Teacher Name</th>
                        <th class="px-6 py-4 font-bold">Teacher Contact</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tuitions->whereNotNull('teacher_name')->where('teacher_name', '!=', '') as $tuition)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $tuition->class }}</div>
                                <div class="text-gray-500 text-xs">{{ $tuition->subjects }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $tuition->teacher_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                @if($tuition->teacher_contact)
                                    <a href="tel:{{ $tuition->teacher_contact }}" class="text-[#1e3a8a] hover:underline">
                                        <i class="fas fa-phone-alt mr-1"></i>{{ $tuition->teacher_contact }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $tuition->status === 'Confirmed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $tuition->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                No tutors have been assigned to your requirements yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Service Charge Invoices Section -->
    <div id="service-charge-section" class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden mt-8 scroll-mt-24">
        <div class="px-6 py-5 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-[#1e3a8a] text-xl"></i> Service Charge Invoices
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Service charges sent by Admin in USD ($)</p>
            </div>
            @if(isset($serviceChargeInvoices) && $serviceChargeInvoices->count() > 0)
                <span class="bg-blue-100 text-[#1e3a8a] text-xs font-bold px-3 py-1 rounded-full">
                    {{ $serviceChargeInvoices->count() }} Invoice(s)
                </span>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold">Invoice #</th>
                        <th class="px-6 py-4 font-bold">Details</th>
                        <th class="px-6 py-4 font-bold">Amount ($ USD)</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Date Issued</th>
                        <th class="px-6 py-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($serviceChargeInvoices ?? [] as $invoice)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-[#1e3a8a]">
                                {{ $invoice->invoice_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $invoice->title }}</div>
                                @if($invoice->lead)
                                    <div class="text-xs text-gray-500 mt-0.5">Class: {{ $invoice->lead->class }} ({{ $invoice->lead->subjects }})</div>
                                @endif
                                @if($invoice->notes)
                                    <div class="text-xs text-gray-400 italic mt-0.5">{{ $invoice->notes }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-green-600 text-base">
                                    ${{ number_format($invoice->amount, 2) }} USD
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1
                                    {{ $invoice->status === 'Paid' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                    {{ $invoice->status === 'Unpaid' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                    {{ $invoice->status === 'Cancelled' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}
                                ">
                                    @if($invoice->status === 'Paid')
                                        <i class="fas fa-check-circle text-green-600"></i> Paid
                                    @else
                                        {{ $invoice->status }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $invoice->created_at->format('M d, Y') }}
                                @if($invoice->due_date)
                                    <div class="text-xs text-amber-600 font-medium mt-0.5">
                                        Due: {{ $invoice->due_date->format('M d, Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($invoice->status === 'Unpaid')
                                    <form action="{{ route('parent.serviceCharge.pay') }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition-colors shadow">
                                            <i class="fas fa-credit-card mr-1"></i> Pay Now
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs font-bold text-green-600 inline-flex items-center gap-1 bg-green-50 px-2.5 py-1 rounded-lg">
                                        <i class="fas fa-check-circle"></i> Paid
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No service charge invoices sent by Admin yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
