<?php $__env->startSection('title', 'Candidate Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-text-main">Candidate Payments</h1>
        <p class="text-text-dark/60 text-sm mt-1">Track payouts and commission collections for candidates.</p>
    </div>
</div>

<!-- Dashboard Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4 relative overflow-hidden">
        <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 text-xl font-black relative z-10">
            <i class="fas fa-arrow-down"></i>
        </div>
        <div class="relative z-10">
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Collected This Month</p>
            <h3 class="text-xl font-black text-text-main">₹<?php echo e(number_format($totalCollected)); ?></h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4 relative overflow-hidden">
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-xl font-black relative z-10">
            <i class="fas fa-arrow-up"></i>
        </div>
        <div class="relative z-10">
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Paid Out This Month</p>
            <h3 class="text-xl font-black text-text-main">₹<?php echo e(number_format($totalPaidOut)); ?></h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4 relative overflow-hidden">
        <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-xl font-black relative z-10">
            <i class="fas fa-clock"></i>
        </div>
        <div class="relative z-10 flex-1">
            <div class="flex justify-between items-center w-full">
                <div>
                    <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Due Today</p>
                    <h3 class="text-lg font-black text-text-main"><?php echo e($dueToday); ?></h3>
                </div>
                <div class="h-8 w-px bg-card-border"></div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Tomorrow</p>
                    <h3 class="text-lg font-black text-text-main"><?php echo e($dueTomorrow); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-card-border p-4 flex items-center gap-4 relative overflow-hidden">
        <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 text-xl font-black relative z-10">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="relative z-10">
            <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-wider mb-0.5">Overdue Accounts</p>
            <h3 class="text-xl font-black text-text-main"><?php echo e($overdueCount); ?></h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-card-border overflow-hidden">
    <!-- Filters -->
    <div class="p-4 border-b border-card-border bg-secondary-bg">
        <form action="<?php echo e(route('admin.candidate-payments.index')); ?>" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/40"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search candidate, mobile, tuition..." class="w-full pl-9 pr-4 py-2 bg-white border border-card-border rounded-lg text-sm focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue">
                </div>
            </div>
            
            <div class="w-full sm:w-auto">
                <select name="status" class="w-full bg-white border border-card-border rounded-lg text-sm px-3 py-2 focus:outline-none focus:border-accent-blue" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="overdue" <?php echo e(request('status') === 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Due Soon</option>
                    <option value="paid" <?php echo e(request('status') === 'paid' ? 'selected' : ''); ?>>Settled (Paid)</option>
                </select>
            </div>

            <div class="w-full sm:w-auto flex items-center gap-2">
                <span class="text-xs font-bold text-text-dark/50">DUE:</span>
                <input type="date" name="due_date" value="<?php echo e(request('due_date')); ?>" class="bg-white border border-card-border rounded-lg text-sm px-3 py-2 focus:outline-none focus:border-accent-blue" onchange="this.form.submit()">
            </div>
            
            <?php if(request('search') || request('status') || request('due_date')): ?>
                <a href="<?php echo e(route('admin.candidate-payments.index')); ?>" class="text-xs font-bold text-red-500 hover:text-red-600 px-2">Clear</a>
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
                    <th class="px-5 py-4 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Candidate Info</th>
                    <th class="px-5 py-4 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Assignment Details</th>
                    <th class="px-5 py-4 text-left text-[10px] uppercase tracking-wider font-black text-text-dark/40">Payment Status</th>
                    <th class="px-5 py-4 text-right text-[10px] uppercase tracking-wider font-black text-text-dark/40">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-card-border bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-secondary-bg/50 transition-colors <?php echo e($account->status === 'inactive' ? 'opacity-50' : ''); ?>">
                    <td class="px-5 py-4 align-top">
                        <div class="font-bold text-text-main mb-0.5"><?php echo e($account->candidate_name); ?></div>
                        
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
                        <div class="text-sm font-bold text-text-main mb-1 truncate max-w-[200px]" title="<?php echo e($account->tuition_assigned); ?>">
                            <?php echo e($account->tuition_assigned ?? 'Not Assigned'); ?>

                        </div>
                        <div class="text-[10px] font-bold text-text-main mt-2">
                            Amount: <span class="text-blue-500">₹<?php echo e(number_format($account->monthly_amount)); ?>/mo</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 align-top">
                        <?php if($account->status === 'inactive'): ?>
                            <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-gray-200 uppercase tracking-wider inline-block mb-2">
                                INACTIVE
                            </span>
                        <?php else: ?>
                            <?php
                                $today = \Carbon\Carbon::today();
                                $dueDate = \Carbon\Carbon::parse($account->next_due_date);
                                
                                if ($dueDate->isPast() && !$dueDate->isToday()) {
                                    $statusClass = 'bg-red-500/10 text-red-500 border-red-500/20';
                                    $statusText = 'OVERDUE 🔴';
                                } elseif ($dueDate->isToday() || $dueDate->isBetween($today, $today->copy()->addDays(3))) {
                                    $statusClass = 'bg-orange-500/10 text-orange-500 border-orange-500/20';
                                    $statusText = 'PENDING ⏳';
                                } else {
                                    $statusClass = 'bg-green-500/10 text-green-500 border-green-500/20';
                                    $statusText = 'SETTLED ✅';
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
                            <a href="https://wa.me/91<?php echo e(preg_replace('/[^0-9]/', '', $account->mobile_number)); ?>" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white transition-colors" title="WhatsApp Candidate">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="<?php echo e(route('admin.candidate-payments.show', $account->id)); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-accent-blue/10 text-accent-blue hover:bg-accent-blue hover:text-white rounded-lg text-xs font-bold transition-colors whitespace-nowrap">
                                Manage <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center py-12">
                        <div class="w-16 h-16 rounded-2xl bg-secondary-bg flex items-center justify-center mx-auto mb-4 border border-card-border shadow-inner">
                            <i class="fas fa-wallet text-2xl text-text-dark/20"></i>
                        </div>
                        <div class="text-text-main font-bold mb-1">No Candidate Accounts Found</div>
                        <div class="text-sm text-text-dark/50">Try adjusting your filters or add a new account.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($accounts->hasPages()): ?>
<div class="mt-4">
    <?php echo e($accounts->links('pagination::tailwind')); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/admin/candidate_payments/index.blade.php ENDPATH**/ ?>