<?php $__env->startSection('title', 'Add New Home Tuition Lead'); ?>
<?php $__env->startSection('subtitle', 'Enter details for a new home tuition enquiry.'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <a href="<?php echo e(route('admin.tuition-leads.index')); ?>" class="text-sm text-text-dark/60 hover:text-accent-blue transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Leads
    </a>
</div>

<div class="bg-card-bg rounded-2xl border border-card-border p-6 shadow-sm">
    <form action="<?php echo e(route('admin.tuition-leads.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="space-y-4 col-span-1 lg:col-span-3 pb-4 border-b border-card-border">
                <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-user-circle text-accent-blue"></i> Parent & Student Info
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Parent Name *</label>
                        <input type="text" name="parent_name" value="<?php echo e(old('parent_name')); ?>" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['parent_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Parent Mobile *</label>
                        <input type="text" name="parent_mobile" value="<?php echo e(old('parent_mobile')); ?>" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['parent_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Location/Address *</label>
                        <input type="text" name="location" value="<?php echo e(old('location')); ?>" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4 col-span-1 lg:col-span-3 pb-4 border-b border-card-border">
                <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-book text-accent-blue"></i> Tuition Requirements
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Class *</label>
                        <input type="text" name="class" value="<?php echo e(old('class')); ?>" required
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-span-1 md:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-semibold text-text-dark mb-1">Subject(s) *</label>
                        <input type="text" name="subjects" value="<?php echo e(old('subjects')); ?>" required placeholder="e.g., Math, Science"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['subjects'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Tutor Preference *</label>
                        <select name="tutor_preference" required class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                            <option value="Any" <?php echo e(old('tutor_preference') == 'Any' ? 'selected' : ''); ?>>Any</option>
                            <option value="Male" <?php echo e(old('tutor_preference') == 'Male' ? 'selected' : ''); ?>>Male</option>
                            <option value="Female" <?php echo e(old('tutor_preference') == 'Female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                        <?php $__errorArgs = ['tutor_preference'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Preferred Timing</label>
                        <input type="text" name="preferred_timing" value="<?php echo e(old('preferred_timing')); ?>" placeholder="e.g., 4 PM to 6 PM"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['preferred_timing'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4 col-span-1 lg:col-span-3">
                <h3 class="text-lg font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-accent-blue"></i> Management Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Lead Status *</label>
                        <select name="status" required class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                            <option value="New Lead" <?php echo e(old('status') == 'New Lead' ? 'selected' : ''); ?>>New Lead</option>
                            <option value="Demo Scheduled" <?php echo e(old('status') == 'Demo Scheduled' ? 'selected' : ''); ?>>Demo Scheduled</option>
                            <option value="Demo Completed" <?php echo e(old('status') == 'Demo Completed' ? 'selected' : ''); ?>>Demo Completed</option>
                            <option value="Confirmed" <?php echo e(old('status') == 'Confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                            <option value="Pending" <?php echo e(old('status') == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="Cancelled" <?php echo e(old('status') == 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Enquiry Date</label>
                        <input type="date" name="enquiry_date" value="<?php echo e(old('enquiry_date', date('Y-m-d'))); ?>"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['enquiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Follow-up Date</label>
                        <input type="date" name="follow_up_date" value="<?php echo e(old('follow_up_date')); ?>"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['follow_up_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Fee Quoted</label>
                        <input type="text" name="fee" value="<?php echo e(old('fee')); ?>" placeholder="e.g., 3000/month"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-1">Teacher Contact No.</label>
                        <input type="text" name="teacher_contact" value="<?php echo e(old('teacher_contact')); ?>" placeholder="If assigned"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['teacher_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-semibold text-text-dark mb-1">Dues Information</label>
                        <input type="text" name="dues" value="<?php echo e(old('dues')); ?>" placeholder="e.g., Paid by tutor, Parent successful"
                               class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <?php $__errorArgs = ['dues'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-span-1 lg:col-span-4">
                        <label class="block text-sm font-semibold text-text-dark mb-1">Additional Notes</label>
                        <textarea name="additional_notes" rows="3" placeholder="Any extra information..."
                                  class="w-full px-4 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all"><?php echo e(old('additional_notes')); ?></textarea>
                        <?php $__errorArgs = ['additional_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-card-border">
            <button type="submit" class="bg-accent-blue text-white px-8 py-2.5 rounded-xl font-bold hover:bg-accent-blue-hover transition-colors shadow-lg shadow-accent-blue/20">
                Save Lead
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\warriors portal\warriors portal\resources\views/admin/home_tuition_leads/create.blade.php ENDPATH**/ ?>