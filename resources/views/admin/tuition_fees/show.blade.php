@extends('layouts.admin')

@section('title', $account->student_name)
@section('subtitle', 'Payment profile & collection history for ' . $account->student_name . ' (Parent: ' . $account->parent_name . ')')

@section('actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.tuition-fees.index') }}" class="bg-secondary-bg border border-card-border text-text-main px-4 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2 text-sm shadow-xs">
            <i class="fas fa-arrow-left text-xs"></i> <span>Back</span>
        </a>
        <a href="{{ route('admin.tuition-fees.edit', $account->id) }}" class="bg-accent-blue/10 text-accent-blue border border-accent-blue/20 px-4 py-2.5 rounded-xl font-bold hover:bg-accent-blue hover:text-white transition-colors flex items-center gap-2 text-sm">
            <i class="fas fa-edit text-xs"></i> <span>Edit</span>
        </a>
        <form action="{{ route('admin.tuition-fees.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment account?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3.5 py-2.5 rounded-xl font-bold transition-colors text-sm" title="Delete Account">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
@endsection

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Profile info -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Student Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-card-border overflow-hidden">
            <div class="bg-gradient-to-br from-accent-blue/10 to-blue-50/50 p-6 flex flex-col items-center text-center relative">
                <div class="w-16 h-16 bg-accent-blue text-white rounded-2xl flex items-center justify-center text-2xl font-black mb-3 shadow-lg shadow-accent-blue/20">
                    {{ strtoupper(substr($account->student_name, 0, 1)) }}
                </div>
                <h2 class="text-xl font-black text-text-main">{{ $account->student_name }}</h2>
                <p class="text-xs text-text-dark/60 mt-1"><i class="fas fa-user-friends mr-1"></i> Parent: {{ $account->parent_name }}</p>
                
                @if($account->status === 'inactive')
                    <span class="mt-3 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">INACTIVE</span>
                @endif
            </div>

            <div class="p-5 space-y-4">
                <div>
                    <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2">Contact & Location</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-text-main">
                            <i class="fas fa-phone-alt text-text-dark/40 w-4 text-xs"></i>
                            <a href="tel:{{ $account->mobile_number }}" class="font-semibold hover:text-accent-blue">{{ $account->mobile_number }}</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fab fa-whatsapp text-green-500 w-4 text-sm"></i>
                            <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $account->mobile_number) }}" target="_blank" class="text-green-600 hover:underline text-xs font-bold">Open in WhatsApp</a>
                        </div>
                        @if($account->address)
                        <div class="flex items-start gap-2 text-xs text-text-dark/80 pt-1">
                            <i class="fas fa-map-marker-alt text-red-400 w-4 mt-0.5 text-xs"></i>
                            <span>{{ $account->address }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-card-border">
                    <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2">Tuition Details</p>
                    <div class="grid grid-cols-2 gap-2 bg-secondary-bg/40 p-3 rounded-xl">
                        <div>
                            <p class="text-[10px] text-text-dark/50 uppercase">Class</p>
                            <p class="text-xs font-bold text-text-main">{{ $account->class ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-text-dark/50 uppercase">Subject</p>
                            <p class="text-xs font-bold text-text-main truncate" title="{{ $account->subject }}">{{ $account->subject ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-card-border">
                    <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-2">Teacher & Fee</p>
                    <div class="bg-secondary-bg/40 rounded-xl p-3.5 space-y-2">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-chalkboard-teacher text-accent-blue text-xs"></i>
                            <span class="text-xs font-bold text-text-main">{{ $account->teacher_name ?? 'Not Assigned' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-text-dark/60">Joined Date:</span>
                            <span class="font-bold">{{ $account->teacher_joining_date ? $account->teacher_joining_date->format('d M, Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-text-dark/60">Monthly Fee:</span>
                            <span class="font-black text-green-600 text-sm">₹{{ number_format($account->monthly_fee) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-text-dark/60">Total Payments:</span>
                            <span class="font-bold text-accent-blue">{{ $account->total_payments_count }}</span>
                        </div>
                        @if($account->last_paid_date)
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-text-dark/60">Last Paid:</span>
                            <span class="font-bold text-green-600">{{ $account->last_paid_date->format('d M, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Follow-Up Management Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-card-border overflow-hidden">
            <div class="px-5 py-3.5 border-b border-card-border bg-indigo-50/60 flex items-center justify-between">
                <h3 class="font-bold text-sm text-text-main flex items-center gap-2"><i class="fas fa-calendar-check text-indigo-500"></i> Follow-Up Management</h3>
            </div>
            <div class="p-5">
                @if($account->follow_up_date)
                <div class="bg-indigo-50/80 border border-indigo-200/70 rounded-xl p-3.5 mb-4">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[10px] font-bold text-indigo-700 uppercase">Scheduled Follow-Up</span>
                        @if(\Carbon\Carbon::parse($account->follow_up_date)->isToday())
                            <span class="bg-indigo-600 text-white text-[9px] px-2 py-0.5 rounded-full font-bold animate-pulse">TODAY</span>
                        @elseif(\Carbon\Carbon::parse($account->follow_up_date)->isPast())
                            <span class="bg-red-500 text-white text-[9px] px-2 py-0.5 rounded-full font-bold">PAST</span>
                        @endif
                    </div>
                    <div class="text-base font-black text-indigo-800">{{ \Carbon\Carbon::parse($account->follow_up_date)->format('d M, Y (l)') }}</div>
                    @if($account->follow_up_notes)
                    <div class="mt-2 text-xs text-indigo-700 italic bg-white/80 rounded-lg p-2 border border-indigo-100">
                        "{{ $account->follow_up_notes }}"
                    </div>
                    @endif
                </div>
                @endif

                <form action="{{ route('admin.tuition-fees.follow-up', $account->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-text-main mb-1">{{ $account->follow_up_date ? 'Update Follow-Up Date' : 'Set Next Follow-Up Date' }}</label>
                        <input type="date" name="follow_up_date" value="{{ $account->follow_up_date ? $account->follow_up_date->format('Y-m-d') : '' }}" required min="{{ date('Y-m-d') }}"
                            class="w-full px-3.5 py-2 bg-white border border-card-border rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-text-main mb-1">Notes (What did parent say?)</label>
                        <textarea name="follow_up_notes" rows="2" placeholder="e.g. Parent requested 4 days extension, will pay on 5th..."
                            class="w-full px-3.5 py-2 bg-white border border-card-border rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">{{ $account->follow_up_notes }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-xs transition-colors shadow-sm">
                        <i class="fas fa-calendar-check mr-1"></i> {{ $account->follow_up_date ? 'Update Follow-Up' : 'Set Follow-Up Date' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-card-border overflow-hidden">
            <div class="px-5 py-3.5 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-xs uppercase tracking-wider text-text-dark/60">Quick Actions</h3>
            </div>
            <div class="p-4 space-y-2.5">
                {{-- Send Email Reminder --}}
                <form action="{{ route('admin.tuition-fees.send-reminder', $account->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200/50 text-blue-700 text-xs font-bold transition-colors">
                        <i class="fas fa-envelope"></i> Send Email Reminder
                    </button>
                </form>
                {{-- WhatsApp --}}
                <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $account->mobile_number) }}?text={{ urlencode('Namaskar ' . $account->parent_name . ', Warriors Educare ki taraf se payment reminder: ' . $account->student_name . ' ki tuition fee ₹' . number_format($account->monthly_fee) . ' due hai. Due date: ' . ($account->next_due_date ? $account->next_due_date->format('d M Y') : 'N/A') . '. Kripya jald se jald payment karein. Dhanyavaad.') }}" target="_blank"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-green-50 hover:bg-green-100 border border-green-200/50 text-green-700 text-xs font-bold transition-colors">
                    <i class="fab fa-whatsapp text-sm"></i> WhatsApp Parent
                </a>
                {{-- Update Payment Status --}}
                <form action="{{ route('admin.tuition-fees.status.update', $account->id) }}" method="POST" class="flex gap-1.5 pt-1">
                    @csrf
                    <select name="payment_status" class="flex-1 bg-white border border-card-border rounded-xl text-xs px-3 py-2 focus:outline-none focus:border-accent-blue">
                        <option value="pending" {{ $account->payment_status === 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                        <option value="paid" {{ $account->payment_status === 'paid' ? 'selected' : '' }}>🟢 Paid</option>
                        <option value="overdue" {{ $account->payment_status === 'overdue' ? 'selected' : '' }}>🔴 Overdue</option>
                    </select>
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 border border-card-border px-3 py-2 rounded-xl text-xs font-bold text-text-main transition-colors">Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Status & Payments -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Payment Status & Next Due Date -->
        <div class="bg-white rounded-2xl shadow-sm border border-card-border p-6 sm:p-7">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                <div>
                    {{-- Payment Status Badge --}}
                    @php
                        $statusConfig = [
                            'paid' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => '✅', 'label' => 'PAID'],
                            'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => '🟡', 'label' => 'PENDING'],
                            'overdue' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => '🔴', 'label' => 'OVERDUE'],
                        ];
                        $ps = $account->payment_status ?? 'pending';
                        $cfg = $statusConfig[$ps] ?? $statusConfig['pending'];
                    @endphp
                    <div class="flex items-center gap-3 mb-3">
                        <span class="{{ $cfg['bg'] }} {{ $cfg['text'] }} border {{ $cfg['border'] }} px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider">
                            {{ $cfg['icon'] }} {{ $cfg['label'] }}
                        </span>
                        @if($ps === 'overdue' && $account->days_overdue > 0)
                            <span class="text-xs font-bold text-red-500 bg-red-50 px-2.5 py-1 rounded-lg border border-red-200">{{ $account->days_overdue }} days overdue</span>
                        @endif
                    </div>

                    <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-1">Next Payment Due</p>
                    @if($account->next_due_date)
                        @php
                            $today = \Carbon\Carbon::today();
                            $dueDate = \Carbon\Carbon::parse($account->next_due_date);
                            $isPast = $dueDate->isPast() && !$dueDate->isToday();
                        @endphp
                        <div class="flex items-center gap-3">
                            <h2 class="text-2xl sm:text-3xl font-black {{ $isPast ? 'text-red-500' : 'text-text-main' }}">
                                {{ $dueDate->format('d M, Y') }}
                            </h2>
                            @if($dueDate->isToday())
                                <span class="bg-amber-500 text-white px-2.5 py-0.5 rounded-full text-xs font-bold animate-pulse">DUE TODAY</span>
                            @endif
                        </div>
                    @else
                        <h2 class="text-xl font-bold text-text-main">Not Set</h2>
                    @endif
                </div>

                <button onclick="document.getElementById('record-payment-modal').classList.remove('hidden')" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3.5 rounded-xl font-bold transition-all flex items-center gap-2 shadow-lg shadow-green-600/20 whitespace-nowrap text-sm">
                    <i class="fas fa-hand-holding-usd"></i> <span>Record Payment</span>
                </button>
            </div>
        </div>

        <!-- Payment History -->
        <div class="bg-white rounded-2xl shadow-sm border border-card-border overflow-hidden">
            <div class="p-5 border-b border-card-border bg-secondary-bg/40 flex justify-between items-center">
                <h3 class="font-bold text-text-main text-sm flex items-center gap-2">
                    <i class="fas fa-history text-accent-blue"></i> Payment History
                </h3>
                <span class="text-xs font-bold bg-accent-blue/10 text-accent-blue px-2.5 py-1 rounded-lg">{{ $account->payments->count() }} Payments</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-secondary-bg/30 border-b border-card-border">
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Date</th>
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Amount</th>
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Mode</th>
                            <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/50">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-card-border">
                        @forelse($account->payments as $payment)
                        <tr class="hover:bg-secondary-bg/20 transition-colors">
                            <td class="px-5 py-3.5 align-middle">
                                <span class="text-sm font-bold text-text-main">{{ $payment->payment_date->format('d M, Y') }}</span>
                            </td>
                            <td class="px-5 py-3.5 align-middle">
                                <span class="text-base font-black text-green-600">₹{{ number_format($payment->amount) }}</span>
                            </td>
                            <td class="px-5 py-3.5 align-middle">
                                @php
                                    $modeColors = [
                                        'Cash' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'UPI' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Bank' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Other' => 'bg-gray-50 text-gray-700 border-gray-200',
                                    ];
                                @endphp
                                <span class="text-xs {{ $modeColors[$payment->payment_mode] ?? 'bg-gray-50 text-gray-700 border-gray-200' }} px-2.5 py-1 rounded-lg border font-bold">
                                    {{ $payment->payment_mode }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 align-middle">
                                <div class="text-[11px] text-text-dark/60">
                                    <span class="font-bold text-text-dark/80">By:</span> {{ $payment->collected_by ?? 'Unknown' }}
                                </div>
                                @if($payment->remarks)
                                    <div class="text-xs mt-0.5 text-text-main italic">"{{ $payment->remarks }}"</div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-10">
                                <div class="text-text-dark/30 mb-2"><i class="fas fa-receipt text-3xl"></i></div>
                                <div class="text-sm font-bold text-text-main">No Payments Recorded Yet</div>
                                <div class="text-xs text-text-dark/50 mt-0.5">Click 'Record Payment' above to log fee collection.</div>
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
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-[fadeIn_0.2s_ease-out]">
        <div class="px-6 py-4 border-b border-card-border flex justify-between items-center bg-secondary-bg">
            <h3 class="font-black text-text-main flex items-center gap-2"><i class="fas fa-hand-holding-usd text-green-600"></i> Record Payment</h3>
            <button onclick="document.getElementById('record-payment-modal').classList.add('hidden')" class="text-text-dark/40 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.tuition-fees.payment.add', $account->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="bg-blue-50/80 text-accent-blue p-3.5 rounded-xl mb-5 text-xs border border-blue-100">
                <i class="fas fa-info-circle mr-1"></i> Recording a payment will automatically:
                <ul class="list-disc pl-4 mt-1 space-y-0.5 text-slate-700">
                    <li>Set status to <strong>Paid</strong></li>
                    <li>Advance <strong>Next Due Date</strong> by 1 month</li>
                    <li>Clear any active follow-up</li>
                </ul>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Payment Date <span class="text-red-500">*</span></label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Amount (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" value="{{ $account->monthly_fee }}" required
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm font-bold focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Payment Mode <span class="text-red-500">*</span></label>
                    <select name="payment_mode" required class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI / QR Code</option>
                        <option value="Bank">Bank Transfer</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-text-main mb-1.5">Remarks (Optional)</label>
                    <textarea name="remarks" rows="2" placeholder="Any additional notes about this payment..."
                        class="w-full px-4 py-2 bg-white border border-card-border rounded-xl text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors"></textarea>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-card-border flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('record-payment-modal').classList.add('hidden')" class="px-4 py-2 rounded-xl font-bold text-xs text-text-dark/60 hover:bg-secondary-bg transition-colors">
                    Cancel
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-green-600/20">
                    Save Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
