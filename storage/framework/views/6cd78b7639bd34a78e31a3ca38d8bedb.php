<?php $__env->startSection('title', 'Parent Payment Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-text-main">Parent Payment Management</h1>
        <p class="text-text-dark/60 text-sm mt-1">Track tuition fees, payment history & collections.</p>
    </div>
    <a href="<?php echo e(route('admin.tuition-fees.create')); ?>" class="bg-accent-blue text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition-colors flex items-center gap-2 shadow-lg shadow-accent-blue/30">
        <i class="fas fa-plus"></i> Add New Account
    </a>
</div>

<!-- Dashboard Metrics -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 text-xl font-black">
            <i class="fas fa-rupee-sign"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">This Month</p>
            <h3 class="text-xl font-black text-text-main">₹<?php echo e(number_format($totalCollected)); ?></h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-xl font-black">
            <i class="fas fa-coins"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Total Collected</p>
            <h3 class="text-xl font-black text-text-main">₹<?php echo e(number_format($totalPaymentsAmount)); ?></h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-xl font-black">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Due Today / Tomorrow</p>
            <h3 class="text-lg font-black text-text-main"><?php echo e($dueToday); ?> / <?php echo e($dueTomorrow); ?></h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 text-xl font-black">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Overdue</p>
            <h3 class="text-xl font-black text-text-main"><?php echo e($overdueCount); ?> Accounts</h3>
        </div>
    </div>
</div>

<!-- Tab Navigation -->
<div class="mb-0">
    <div class="flex border-b border-card-border overflow-x-auto">
        <button onclick="switchTab('accounts')" id="tab-accounts"
            class="tab-btn whitespace-nowrap px-6 py-3 text-sm font-bold border-b-2 border-accent-blue text-accent-blue -mb-px flex items-center gap-2">
            <i class="fas fa-users"></i> Fee Accounts
            <span class="bg-accent-blue/10 text-accent-blue text-xs px-2 py-0.5 rounded-full"><?php echo e($accounts->total()); ?></span>
        </button>
        <button onclick="switchTab('online')" id="tab-online"
            class="tab-btn whitespace-nowrap px-6 py-3 text-sm font-bold border-b-2 border-transparent text-text-dark/50 hover:text-green-600 -mb-px flex items-center gap-2 transition-colors">
            <i class="fas fa-mobile-alt"></i> Parent Online Payments
            <span class="bg-green-500/10 text-green-600 text-xs px-2 py-0.5 rounded-full font-bold"><?php echo e($parentInvoicePayments->total()); ?> Paid</span>
        </button>
        <button onclick="switchTab('history')" id="tab-history"
            class="tab-btn whitespace-nowrap px-6 py-3 text-sm font-bold border-b-2 border-transparent text-text-dark/50 hover:text-accent-blue -mb-px flex items-center gap-2 transition-colors">
            <i class="fas fa-history"></i> Manual Payment History
            <span class="bg-blue-500/10 text-blue-600 text-xs px-2 py-0.5 rounded-full font-bold"><?php echo e($allPayments->total()); ?> Records</span>
        </button>
    </div>
</div>

<!-- Tab: Fee Accounts -->
<div id="panel-accounts" class="bg-white rounded-b-xl rounded-tr-xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <!-- Filters -->
    <div class="p-4 border-b border-card-border bg-secondary-bg">
        <form action="<?php echo e(route('admin.tuition-fees.index')); ?>" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/40"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search parent, student, mobile, teacher..." class="w-full pl-9 pr-4 py-2 bg-white border border-card-border rounded-lg text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue">
                </div>
            </div>
            
            <div class="w-full sm:w-auto">
                <select name="status" class="w-full bg-white border border-card-border rounded-lg text-sm px-3 py-2 focus:outline-none focus:border-accent-blue" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="overdue" <?php echo e(request('status') === 'overdue' ? 'selected' : ''); ?>>Overdue Payments</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Due Soon (Pending)</option>
                    <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>>Paid</option>
                </select>
            </div>

            <div class="w-full sm:w-auto flex items-center gap-2">
                <span class="text-xs font-bold text-text-dark/50">DUE:</span>
                <input type="date" name="due_date" value="<?php echo e(request('due_date')); ?>" class="bg-white border border-card-border rounded-lg text-sm px-3 py-2 focus:outline-none focus:border-accent-blue" onchange="this.form.submit()">
            </div>
            
            <?php if(request('search') || request('status') || request('due_date')): ?>
                <a href="<?php echo e(route('admin.tuition-fees.index')); ?>" class="text-xs font-bold text-red-500 hover:text-red-600 px-2">Clear</a>
            <?php endif; ?>
            
            <button type="submit" class="bg-accent-blue text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-700 transition-colors ml-auto">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white border-b border-card-border">
                    <th class="px-5 py-4 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Student & Parent Info</th>
                    <th class="px-5 py-4 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Tuition Details</th>
                    <th class="px-5 py-4 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Payment Status</th>
                    <th class="px-5 py-4 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/40">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-secondary-bg/50 transition-colors <?php echo e($account->status === 'inactive' ? 'opacity-50' : ''); ?>">
                    <td class="px-5 py-4 align-top">
                        <div class="font-bold text-text-main mb-0.5"><?php echo e($account->student_name); ?></div>
                        <div class="text-xs text-text-dark/80 mb-1"><span class="text-text-dark/40">Parent:</span> <?php echo e($account->parent_name); ?></div>
                        
                        <div class="flex items-center gap-3 text-[10px] text-text-dark/60 mt-2">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-phone-alt"></i> <?php echo e($account->mobile_number); ?>

                            </div>
                            <?php if($account->address): ?>
                                <div class="flex items-center gap-1 max-w-[150px] truncate" title="<?php echo e($account->address); ?>">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo e($account->address); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-5 py-4 align-top">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-bold text-text-main"><?php echo e($account->class ?? 'N/A'); ?></span>
                            <span class="text-text-dark/30">&bull;</span>
                            <span class="text-xs text-text-dark/80 truncate max-w-[150px]"><?php echo e($account->subject ?? 'N/A'); ?></span>
                        </div>
                        <div class="text-[10px] font-bold text-text-main mt-2">
                            Fee: <span class="text-green-500">&#8377;<?php echo e(number_format($account->monthly_fee)); ?>/mo</span>
                        </div>
                        <div class="text-xs text-text-dark/80 mt-1 flex items-center gap-1">
                            <i class="fas fa-chalkboard-teacher text-[10px]"></i> 
                            <?php echo e($account->teacher_name ?? 'Not Assigned'); ?>

                        </div>
                    </td>
                    <td class="px-5 py-4 align-top">
                        <?php if($account->status === 'inactive'): ?>
                            <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-gray-200 uppercase tracking-wider inline-block mb-2">
                                INACTIVE
                            </span>
                        <?php else: ?>
                            <?php
                                $todayDate = \Carbon\Carbon::today();
                                $dueDate = \Carbon\Carbon::parse($account->next_due_date);
                                
                                if ($dueDate->isPast() && !$dueDate->isToday()) {
                                    $statusClass = 'bg-red-500/10 text-red-500 border-red-500/20';
                                    $statusText = 'OVERDUE';
                                } elseif ($dueDate->isToday() || $dueDate->isBetween($todayDate, $todayDate->copy()->addDays(3))) {
                                    $statusClass = 'bg-orange-500/10 text-orange-500 border-orange-500/20';
                                    $statusText = 'DUE SOON';
                                } else {
                                    $statusClass = 'bg-green-500/10 text-green-500 border-green-500/20';
                                    $statusText = 'CLEAR';
                                }
                            ?>
                            <span class="<?php echo e($statusClass); ?> px-2.5 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-wider inline-block mb-1">
                                <?php echo e($statusText); ?>

                            </span>
                            <div class="text-xs font-bold <?php echo e($dueDate->isPast() && !$dueDate->isToday() ? 'text-red-500' : 'text-text-main'); ?>">
                                Due: <?php echo e($dueDate->format('M d, Y')); ?>

                                <?php if($dueDate->isToday()): ?> <span class="ml-1 text-[10px] bg-orange-500/20 px-1 rounded text-orange-500">TODAY</span> <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 align-top text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="https://wa.me/91<?php echo e(preg_replace('/[^0-9]/', '', $account->mobile_number)); ?>" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition-colors" title="WhatsApp Parent">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="<?php echo e(route('admin.tuition-fees.show', $account->id)); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-accent-blue/10 text-accent-blue hover:bg-accent-blue hover:text-white rounded-lg text-xs font-bold transition-colors whitespace-nowrap">
                                Manage <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-4 border border-card-border shadow-inner">
                            <i class="fas fa-folder-open text-2xl text-text-dark/20"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Accounts Found</div>
                        <div class="text-sm text-text-dark/50">Try adjusting your filters or add a new fee account.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($accounts->hasPages()): ?>
    <div class="p-4 border-t border-card-border">
        <?php echo e($accounts->links('pagination::tailwind')); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Tab: Payment History -->
<div id="panel-history" class="hidden bg-white rounded-b-xl rounded-tr-xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <div class="p-4 border-b border-card-border bg-secondary-bg flex flex-wrap gap-3 items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-history text-green-500 text-lg"></i>
            <div>
                <h3 class="font-bold text-text-main">Complete Payment History</h3>
                <p class="text-xs text-text-dark/50">All tuition fee payments recorded in the system</p>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="bg-green-500/10 border border-green-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-green-600 font-bold uppercase">Total Collected</p>
                <p class="text-lg font-black text-green-600">&#8377;<?php echo e(number_format($totalPaymentsAmount)); ?></p>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-blue-600 font-bold uppercase">Total Records</p>
                <p class="text-lg font-black text-blue-600"><?php echo e($allPayments->total()); ?></p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-bg border-b border-card-border">
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">#</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Payment Date</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Student</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Parent</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Amount</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Mode</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Collected By</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Remarks</th>
                    <th class="px-5 py-3 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/40">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $allPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-green-50/50 transition-colors">
                    <td class="px-5 py-3 align-middle text-xs text-text-dark/40 font-bold"><?php echo e($allPayments->firstItem() + $loop->index); ?></td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-sm font-bold text-text-main"><?php echo e($payment->payment_date->format('d M, Y')); ?></div>
                        <div class="text-[10px] text-text-dark/40">Recorded: <?php echo e($payment->created_at->format('d M Y, H:i')); ?></div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="font-bold text-text-main text-sm"><?php echo e($payment->account->student_name ?? 'N/A'); ?></div>
                        <div class="text-[10px] text-text-dark/50"><?php echo e($payment->account->class ?? ''); ?></div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-sm text-text-main font-semibold"><?php echo e($payment->account->parent_name ?? 'N/A'); ?></div>
                        <div class="text-[10px] text-text-dark/50"><?php echo e($payment->account->mobile_number ?? ''); ?></div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <span class="text-base font-black text-green-600">&#8377;<?php echo e(number_format($payment->amount)); ?></span>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <?php
                            $modeColors = [
                                'Cash' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'UPI' => 'bg-purple-100 text-purple-700 border-purple-200',
                                'Bank' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'Other' => 'bg-gray-100 text-gray-700 border-gray-200',
                            ];
                            $modeClass = $modeColors[$payment->payment_mode] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                        ?>
                        <span class="text-xs <?php echo e($modeClass); ?> px-2.5 py-1 rounded-lg border font-bold">
                            <?php echo e($payment->payment_mode); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3 align-middle text-sm text-text-dark/70">
                        <?php echo e($payment->collected_by ?? '—'); ?>

                    </td>
                    <td class="px-5 py-3 align-middle text-xs text-text-dark/60 italic max-w-[150px]">
                        <?php echo e($payment->remarks ?? '—'); ?>

                    </td>
                    <td class="px-5 py-3 align-middle text-right">
                        <?php if($payment->account): ?>
                        <a href="<?php echo e(route('admin.tuition-fees.show', $payment->account->id)); ?>" class="inline-flex items-center gap-1 text-accent-blue hover:underline text-xs font-bold">
                            View <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-4 border border-card-border">
                            <i class="fas fa-receipt text-2xl text-text-dark/20"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Payment Records Found</div>
                        <div class="text-sm text-text-dark/50">Record a payment from any Fee Account to see history here.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($allPayments->hasPages()): ?>
    <div class="p-4 border-t border-card-border">
        <?php echo e($allPayments->appends(['tab' => 'history'])->links('pagination::tailwind')); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Tab: Parent Online Payments -->
<div id="panel-online" class="hidden bg-white rounded-b-xl rounded-tr-xl shadow-sm border border-card-border overflow-hidden border-t-0">
    <div class="p-4 border-b border-card-border bg-green-50 flex flex-wrap gap-3 items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-500 text-white flex items-center justify-center">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div>
                <h3 class="font-bold text-text-main">Parent Online Service Charge Payments</h3>
                <p class="text-xs text-text-dark/50">Payments made by parents via Payment Gateway for Home Tuition Service</p>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="bg-green-500/10 border border-green-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-green-600 font-bold uppercase">Total Collected</p>
                <p class="text-lg font-black text-green-600">&#36;<?php echo e(number_format($totalInvoiceAmount, 2)); ?> USD</p>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-xl">
                <p class="text-[10px] text-blue-600 font-bold uppercase">Paid Invoices</p>
                <p class="text-lg font-black text-blue-600"><?php echo e($parentInvoicePayments->total()); ?></p>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-bg border-b border-card-border">
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">#</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Invoice #</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Paid On</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Parent</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Lead / Location</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Service</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Amount</th>
                    <th class="px-5 py-3 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $parentInvoicePayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-green-50/40 transition-colors">
                    <td class="px-5 py-3 align-middle text-xs text-text-dark/40 font-bold"><?php echo e($parentInvoicePayments->firstItem() + $loop->index); ?></td>
                    <td class="px-5 py-3 align-middle">
                        <span class="font-mono text-xs font-bold text-accent-blue"><?php echo e($inv->invoice_number); ?></span>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-sm font-bold text-text-main"><?php echo e($inv->updated_at->format('d M, Y')); ?></div>
                        <div class="text-[10px] text-text-dark/40"><?php echo e($inv->updated_at->format('H:i A')); ?></div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="font-bold text-text-main text-sm"><?php echo e($inv->user->name ?? 'N/A'); ?></div>
                        <div class="text-[10px] text-text-dark/50"><?php echo e($inv->user->phone ?? $inv->user->email ?? ''); ?></div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <?php if($inv->lead): ?>
                        <div class="text-sm text-text-main font-semibold"><?php echo e($inv->lead->parent_name); ?></div>
                        <div class="text-[10px] text-text-dark/50"><?php echo e($inv->lead->location ?? ''); ?></div>
                        <?php else: ?>
                        <span class="text-text-dark/30">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <div class="text-xs text-text-main"><?php echo e($inv->title); ?></div>
                        <?php if($inv->notes): ?>
                        <div class="text-[10px] text-text-dark/40 italic"><?php echo e(Str::limit($inv->notes, 30)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <span class="text-base font-black text-green-600">&#36;<?php echo e(number_format($inv->amount, 2)); ?></span>
                        <div class="text-[10px] text-text-dark/40">USD</div>
                    </td>
                    <td class="px-5 py-3 align-middle">
                        <span class="bg-green-500/10 text-green-600 border border-green-500/20 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                            PAID
                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-4 border border-card-border">
                            <i class="fas fa-mobile-alt text-2xl text-text-dark/20"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Online Payments Yet</div>
                        <div class="text-sm text-text-dark/50">When parents pay invoices online, they will appear here.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($parentInvoicePayments->hasPages()): ?>
    <div class="p-4 border-t border-card-border">
        <?php echo e($parentInvoicePayments->appends(['tab' => 'online'])->links('pagination::tailwind')); ?>

    </div>
    <?php endif; ?>
</div>

<script>
    function switchTab(tab) {
        // Hide all panels
        ['accounts', 'online', 'history'].forEach(function(t) {
            document.getElementById('panel-' + t).classList.add('hidden');
        });
        
        // Remove active from all tabs
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.classList.remove('border-accent-blue', 'text-accent-blue', 'border-green-500', 'text-green-600');
            btn.classList.add('border-transparent', 'text-text-dark/50');
        });
        
        // Show selected panel
        document.getElementById('panel-' + tab).classList.remove('hidden');
        var activeBtn = document.getElementById('tab-' + tab);
        activeBtn.classList.remove('border-transparent', 'text-text-dark/50');
        if (tab === 'online') {
            activeBtn.classList.add('border-green-500', 'text-green-600');
        } else {
            activeBtn.classList.add('border-accent-blue', 'text-accent-blue');
        }
    }

    // Auto-switch to tab if requested via URL param
    <?php if(request('tab') === 'history'): ?>
        switchTab('history');
    <?php elseif(request('tab') === 'online'): ?>
        switchTab('online');
    <?php endif; ?>
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/admin/tuition_fees/index.blade.php ENDPATH**/ ?>