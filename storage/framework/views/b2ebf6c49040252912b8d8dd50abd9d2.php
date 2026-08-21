<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 reveal">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#031b4e]">Profile Registration</h1>
                    <p class="text-xs sm:text-sm text-[#031b4e]/70 mt-0.5">Manage your registration, plan details, and agreements.</p>
                </div>
            </div>
            <?php if(auth()->user()->profile && auth()->user()->profile->pending_amount > 0): ?>
                
            <?php endif; ?>
        </div>

        
        <div class="light-metallic-blue-card rounded-2xl border border-[#031b4e]/10 overflow-hidden shadow-sm reveal reveal-delay-1 mb-6 sm:mb-8 bg-white">
            <div class="p-4 sm:p-6 md:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8">
                    <?php
                        $profile = auth()->user()->profile;
                        $registrationPlan = ucfirst($profile->plan_type ?? 'Standard');
                        $isComplete = $profile && $profile->is_profile_complete && $profile->is_agreement_signed && ($profile->initial_fee_paid || $profile->is_fee_paid);
                    ?>
                    
                    
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Registration Plan</p>
                        <div class="text-2xl font-bold <?php echo e($registrationPlan === 'Premium' ? 'text-accent-yellow' : 'text-[#031b4e]'); ?>">
                            <?php echo e($registrationPlan); ?>

                        </div>
                    </div>

                    
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Registration Status</p>
                        <?php if($isComplete): ?>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-bold uppercase tracking-wider rounded-lg mt-1">
                                <i class="fas fa-check-circle"></i> Completed
                            </div>
                        <?php else: ?>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-accent-yellow/10 border border-accent-yellow/30 text-accent-yellow text-xs font-bold uppercase tracking-wider rounded-lg mt-1">
                                <i class="fas fa-exclamation-circle"></i> Pending
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Paid Amount</p>
                        <div class="text-lg font-semibold text-green-400">
                            ₹<?php echo e(number_format($registrationPaidAmount ?? 0, 2)); ?>

                        </div>
                    </div>

                    
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60 mb-2">Pending Amount</p>
                        <div class="text-2xl font-bold <?php echo e(($profile->pending_amount ?? 0) > 0 ? 'text-red-400' : 'text-[#0ea5e9]'); ?>">
                            ₹<?php echo e(number_format($profile->pending_amount ?? 0, 2)); ?>

                        </div>
                        <?php if(($profile->pending_amount ?? 0) > 0): ?>
                            <p class="text-xs text-[#031b4e]/70 mt-2 leading-relaxed bg-[#0ea5e9]/5 border border-[#0ea5e9]/10 p-2 rounded-lg">
                                <i class="fas fa-info-circle text-[#0ea5e9] mr-1"></i> This is the Final Registration fee, which will be requested by Admin upon successful job placement.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-[#031b4e]/10 flex flex-wrap gap-4">
                    
                    <a href="<?php echo e(route('candidate.agreement.download')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#f4f7f5] text-[#031b4e] rounded-xl text-sm font-semibold hover:bg-card-border/50 transition-colors border border-[#031b4e]/10">
                        <i class="fas fa-file-pdf text-red-400"></i> Download Agreement PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="reveal reveal-delay-2">
                <h2 class="text-lg font-bold text-[#031b4e] mb-4 flex items-center gap-2">
                    <i class="fas fa-history text-[#0ea5e9]"></i> Payment History
                </h2>
                <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-[#031b4e]/10 bg-[#f4f7f5]/20">
                                    <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/60">Date</th>
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
                                            <td class="px-6 py-4 text-[#031b4e] font-bold">
                                                ₹<?php echo e(number_format($payment->amount, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4">
                                                <?php if(isset($payment->status)): ?>
                                                    <?php if($payment->status === 'success' || $payment->status === 'COMPLETED'): ?>
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                                            <i class="fas fa-check-circle mr-1 text-[9px]"></i> Successful
                                                        </span>
                                                    <?php elseif(strtolower($payment->status) === 'failed'): ?>
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-500/10 text-red-500 border border-red-500/20">
                                                            <i class="fas fa-times-circle mr-1 text-[9px]"></i> Failed
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-accent-yellow/10 text-accent-yellow border border-accent-yellow/20">
                                                            <i class="fas fa-clock mr-1 text-[9px]"></i> <?php echo e(ucfirst(strtolower($payment->status))); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                                        <i class="fas fa-check-circle mr-1 text-[9px]"></i> Successful
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <?php if((isset($payment->status) && in_array($payment->status, ['success', 'COMPLETED'])) || !isset($payment->status)): ?>
                                                    <a href="<?php echo e(route('candidate.payment.invoice', $payment->id)); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] hover:bg-[#0ea5e9] hover:text-white transition-all shadow-sm" title="Download Invoice">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-lg mx-auto mb-3">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <h3 class="text-sm font-semibold text-[#031b4e] mb-1">No Payments Found</h3>
                                            <p class="text-xs text-slate-500">You haven't made any payments yet.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="reveal reveal-delay-3">
                <h2 class="text-lg font-bold text-[#031b4e] mb-4 flex items-center gap-2">
                    <i class="fas fa-bell text-accent-yellow"></i> Notifications
                </h2>
                <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl">
                    <div class="divide-y divide-gray-200">
                        <?php if(auth()->user()->notifications()->count() > 0): ?>
                            <?php $__currentLoopData = auth()->user()->notifications()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-5 flex gap-4 hover:bg-[#f4f7f5]/30 transition-colors <?php echo e($notification->unread() ? 'bg-[#f4f7f5]/10' : ''); ?>">
                                    <div class="w-10 h-10 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#031b4e] mb-1"><?php echo e($notification->data['title'] ?? ($notification->title ?? 'Notification')); ?></h4>
                                        <p class="text-xs text-[#031b4e]/80/70 leading-relaxed"><?php echo e($notification->data['message'] ?? ($notification->message ?? 'You have a new update.')); ?></p>
                                        <span class="text-[10px] text-[#031b4e]/60 font-medium mt-2 block"><?php echo e(\Carbon\Carbon::parse($notification->created_at)->diffForHumans()); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="px-6 py-12 text-center">
                                <div class="w-10 h-10 bg-card-border/30 rounded-xl flex items-center justify-center text-[#031b4e]/80/20 text-lg mx-auto mb-3">
                                    <i class="fas fa-bell-slash"></i>
                                </div>
                                <h3 class="text-sm font-semibold text-[#031b4e] mb-1">No Notifications</h3>
                                <p class="text-xs text-[#031b4e]/60">You are all caught up!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\warrioredu\resources\views/candidate/registration/show.blade.php ENDPATH**/ ?>