<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 reveal">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#031b4e]">Service Charge</h1>
                    <p class="text-sm text-[#031b4e]/60 mt-0.5">View your service charge details and payment history.</p>
                </div>
            </div>
            <?php if($invoices->where('status', '!=', 'paid')->count() > 0): ?>
                <div class="px-4 py-2 bg-accent-yellow/20 text-accent-yellow rounded-xl text-sm font-semibold border border-accent-yellow/30">
                    <i class="fas fa-exclamation-circle mr-1"></i> You have pending service charges
                </div>
            <?php endif; ?>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl reveal reveal-delay-1 mb-8 relative">
                <?php if($invoice->status === 'paid'): ?>
                    <div class="absolute top-0 right-0 px-4 py-1 bg-green-500 text-white text-xs font-bold rounded-bl-xl shadow-sm">
                        <i class="fas fa-check-circle mr-1"></i> Paid
                    </div>
                <?php endif; ?>
                <div class="p-6 md:p-8">
                    <?php if(!empty($invoice->description)): ?>
                        <div class="mb-4 text-xs font-bold text-[#0ea5e9] bg-[#0ea5e9]/10 px-3 py-1.5 rounded-lg border border-[#0ea5e9]/20 w-max">
                            <i class="fas fa-info-circle mr-1"></i> <?php echo e($invoice->description); ?>

                        </div>
                    <?php endif; ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        
                        
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Service Charge Amount</p>
                            <div class="text-2xl font-bold text-[#031b4e]">
                                ₹<?php echo e(number_format($invoice->amount ?? 0, 2)); ?>

                            </div>
                        </div>

                        
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Due Date</p>
                            <div class="text-lg font-semibold <?php echo e((isset($invoice->due_date) && \Carbon\Carbon::parse($invoice->due_date)->isPast() && $invoice->status !== 'paid') ? 'text-red-500' : 'text-[#031b4e]'); ?>">
                                <?php echo e(isset($invoice->due_date) ? \Carbon\Carbon::parse($invoice->due_date)->format('d M, Y') : 'N/A'); ?>

                            </div>
                        </div>

                        
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Late Fee</p>
                            <div class="text-lg font-semibold text-accent-yellow">
                                ₹<?php echo e(number_format($invoice->late_fee ?? 0, 2)); ?>

                            </div>
                        </div>

                        
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Pending Amount</p>
                            <div class="text-2xl font-bold text-[#0ea5e9]">
                                <?php
                                    $pendingAmount = ($invoice->status === 'pending' || $invoice->status === 'overdue') ? ($invoice->amount + $invoice->late_fee) : 0;
                                ?>
                                ₹<?php echo e(number_format($pendingAmount, 2)); ?>

                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-[#031b4e]/10 flex flex-wrap gap-4 items-center justify-between">
                        
                        <a href="<?php echo e(route('candidate.serviceCharge.invoicePdf', $invoice->id)); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#f4f7f5] text-[#031b4e] rounded-xl text-sm font-semibold hover:bg-card-border/50 transition-colors border border-[#031b4e]/10">
                            <i class="fas fa-file-pdf text-red-400"></i> Download Invoice PDF
                        </a>
                        
                        <?php if($invoice->status !== 'paid'): ?>
                            <a href="<?php echo e(route('candidate.serviceCharge.checkout', $invoice->id)); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-500 text-white rounded-xl text-sm font-semibold hover:bg-green-600 hover:-translate-y-0.5 transition-all shadow-lg">
                                <i class="fas fa-credit-card text-xs"></i> Pay ₹<?php echo e(number_format($pendingAmount, 2)); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="light-metallic-blue-card rounded-2xl border-0 p-8 text-center text-[#031b4e]/60 mb-8 shadow-sm">
                <div class="w-16 h-16 bg-[#f4f7f5] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-[#031b4e] mb-1">No Service Charges</h3>
                <p class="text-sm">You do not have any service charge invoices at the moment.</p>
            </div>
        <?php endif; ?>

        
        <h2 class="text-lg font-bold text-[#031b4e] mb-4 reveal reveal-delay-2">Payment History</h2>
        <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl reveal reveal-delay-2">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#031b4e]/10 bg-[#f4f7f5]/20">
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Date</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Transaction ID</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Amount</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Status</th>
                            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200">
                        <?php if(isset($paymentHistory) && count($paymentHistory) > 0): ?>
                            <?php $__currentLoopData = $paymentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-[#f4f7f5]/30 transition-colors">
                                    <td class="px-6 py-4 text-[#031b4e]/80/70 font-medium">
                                        <?php echo e(\Carbon\Carbon::parse($payment->created_at)->format('d M, Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 text-[#031b4e] font-semibold">
                                        <?php echo e($payment->transaction_id ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 text-[#031b4e] font-bold">
                                        ₹<?php echo e(number_format($payment->amount, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                            <i class="fas fa-check-circle mr-1 text-[9px]"></i> Successful
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?php echo e(route('candidate.payment.invoice', $payment->id)); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] hover:bg-[#0ea5e9] hover:text-white transition-all shadow-sm" title="Download Invoice">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="w-12 h-12 bg-card-border/30 rounded-xl flex items-center justify-center text-[#031b4e]/80/20 text-xl mx-auto mb-3">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <h3 class="text-sm font-semibold text-[#031b4e] mb-1">No Payment History</h3>
                                    <p class="text-xs text-[#031b4e]/60">You haven't made any payments yet.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\warrioredu\resources\views/candidate/serviceCharge/show.blade.php ENDPATH**/ ?>