@extends('layouts.admin')

@section('title', 'Payment Account Details')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-text-main">Payment Account Details</h1>
        <p class="text-text-dark/60 text-sm mt-1">Manage fees and payments for {{ $account->student_name }}.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.tuition-fees.index') }}" class="bg-secondary-bg border border-card-border text-text-main px-4 py-2 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <form action="{{ route('admin.tuition-fees.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this account?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl font-bold transition-colors">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Profile info -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Student Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-card-border overflow-hidden">
            <div class="bg-accent-blue/10 p-6 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-accent-blue text-white rounded-full flex items-center justify-center text-3xl font-black mb-3 shadow-lg">
                    {{ strtoupper(substr($account->student_name, 0, 1)) }}
                </div>
                <h2 class="text-xl font-black text-text-main">{{ $account->student_name }}</h2>
                <p class="text-sm text-text-dark/60 mt-1"><i class="fas fa-user-friends mr-1"></i> Parent: {{ $account->parent_name }}</p>
                
                @if($account->status === 'inactive')
                    <span class="mt-3 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">INACTIVE</span>
                @endif
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-1">Contact Details</p>
                    <div class="flex items-center gap-2 text-sm text-text-main">
                        <i class="fas fa-phone-alt text-text-dark/40 w-4"></i>
                        {{ $account->mobile_number }}
                    </div>
                    @if($account->address)
                    <div class="flex items-start gap-2 text-sm text-text-main mt-2">
                        <i class="fas fa-map-marker-alt text-text-dark/40 w-4 mt-0.5"></i>
                        {{ $account->address }}
                    </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-card-border">
                    <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-2">Tuition Requirement</p>
                    <div class="grid grid-cols-2 gap-y-3">
                        <div>
                            <p class="text-[10px] text-text-dark/50 uppercase">Class</p>
                            <p class="text-sm font-bold text-text-main">{{ $account->class ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-text-dark/50 uppercase">Subject</p>
                            <p class="text-sm font-bold text-text-main">{{ $account->subject ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-card-border">
                    <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-2">Teacher & Fee</p>
                    <div class="bg-secondary-bg rounded-lg p-3">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-chalkboard-teacher text-accent-blue"></i>
                            <span class="text-sm font-bold text-text-main">{{ $account->teacher_name ?? 'Not Assigned' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-text-dark/60">Joined:</span>
                            <span class="font-bold">{{ $account->teacher_joining_date ? $account->teacher_joining_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs mt-1">
                            <span class="text-text-dark/60">Monthly Fee:</span>
                            <span class="font-bold text-green-500 text-sm">₹{{ number_format($account->monthly_fee) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Payments -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Status & Next Due Date -->
        <div class="bg-white rounded-xl shadow-sm border border-card-border p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-text-dark/60 uppercase tracking-wider mb-1">Next Payment Due</p>
                @if($account->next_due_date)
                    @php
                        $today = \Carbon\Carbon::today();
                        $dueDate = \Carbon\Carbon::parse($account->next_due_date);
                        $isPast = $dueDate->isPast() && !$dueDate->isToday();
                    @endphp
                    <div class="flex items-center gap-3">
                        <h2 class="text-3xl font-black {{ $isPast ? 'text-red-500' : 'text-text-main' }}">
                            {{ $dueDate->format('d M, Y') }}
                        </h2>
                        @if($isPast)
                            <span class="bg-red-500/10 text-red-500 px-3 py-1 rounded-full text-xs font-bold border border-red-500/20 uppercase">OVERDUE</span>
                        @elseif($dueDate->isToday() || $dueDate->isBetween($today, $today->copy()->addDays(3)))
                            <span class="bg-orange-500/10 text-orange-500 px-3 py-1 rounded-full text-xs font-bold border border-orange-500/20 uppercase">DUE SOON</span>
                        @endif
                    </div>
                @else
                    <h2 class="text-xl font-bold text-text-main">Not Set</h2>
                @endif
            </div>

            <button onclick="document.getElementById('record-payment-modal').classList.remove('hidden')" class="bg-green-500 text-white px-5 py-3 rounded-xl font-bold hover:bg-green-600 transition-colors flex items-center gap-2 shadow-lg shadow-green-500/30 whitespace-nowrap">
                <i class="fas fa-hand-holding-usd"></i> Record Payment
            </button>
        </div>

        <!-- Payment History -->
        <div class="bg-white rounded-xl shadow-sm border border-card-border overflow-hidden">
            <div class="p-5 border-b border-card-border bg-secondary-bg flex justify-between items-center">
                <h3 class="font-bold text-text-main">Payment History</h3>
                <span class="text-xs font-bold bg-accent-blue/10 text-accent-blue px-2 py-1 rounded">{{ $account->payments->count() }} Payments</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-white border-b border-card-border">
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Date</th>
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Amount</th>
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Mode</th>
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-card-border">
                        @forelse($account->payments as $payment)
                        <tr class="hover:bg-secondary-bg/50 transition-colors">
                            <td class="px-5 py-3 align-middle">
                                <span class="text-sm font-bold text-text-main">{{ $payment->payment_date->format('d M, Y') }}</span>
                            </td>
                            <td class="px-5 py-3 align-middle">
                                <span class="text-sm font-black text-green-500">₹{{ number_format($payment->amount) }}</span>
                            </td>
                            <td class="px-5 py-3 align-middle">
                                <span class="text-xs bg-gray-100 text-text-dark/80 px-2 py-1 rounded border border-gray-200 font-bold">
                                    {{ $payment->payment_mode }}
                                </span>
                            </td>
                            <td class="px-5 py-3 align-middle">
                                <div class="text-[10px] text-text-dark/60">
                                    <span class="font-bold text-text-dark/80">By:</span> {{ $payment->collected_by ?? 'Unknown' }}
                                </div>
                                @if($payment->remarks)
                                    <div class="text-xs mt-0.5 text-text-main italic">"{{ $payment->remarks }}"</div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-8">
                                <div class="text-text-dark/40 mb-2"><i class="fas fa-receipt text-3xl"></i></div>
                                <div class="text-sm font-bold text-text-main">No Payments Recorded</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Record Payment Modal -->
<div id="record-payment-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-card-border flex justify-between items-center bg-secondary-bg">
            <h3 class="font-black text-text-main">Record Payment</h3>
            <button onclick="document.getElementById('record-payment-modal').classList.add('hidden')" class="text-text-dark/40 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.tuition-fees.payment.add', $account->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="bg-blue-50 text-accent-blue p-3 rounded-lg mb-5 text-xs">
                <i class="fas fa-info-circle mr-1"></i> Recording a payment will automatically advance the <strong>Next Due Date</strong> by 1 month.
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-text-main mb-1.5">Payment Date <span class="text-red-500">*</span></label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-1.5">Amount (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" value="{{ $account->monthly_fee }}" required
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-1.5">Payment Mode <span class="text-red-500">*</span></label>
                    <select name="payment_mode" required class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI / QR Code</option>
                        <option value="Bank">Bank Transfer</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-text-main mb-1.5">Remarks (Optional)</label>
                    <textarea name="remarks" rows="2" placeholder="Any additional notes about this payment..."
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors"></textarea>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-card-border flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('record-payment-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg font-bold text-text-dark/60 hover:bg-secondary-bg transition-colors">
                    Cancel
                </button>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-600 transition-colors shadow-lg shadow-green-500/30">
                    Save Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
