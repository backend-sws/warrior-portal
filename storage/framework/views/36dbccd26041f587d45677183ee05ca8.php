<?php $__env->startSection('title', 'Add Candidate Payment Account'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-text-main">Add Candidate Payment Account</h1>
        <p class="text-text-dark/60 text-sm mt-1">Create a new payment profile for a candidate.</p>
    </div>
    <a href="<?php echo e(route('admin.candidate-payments.index')); ?>" class="bg-secondary-bg border border-card-border text-text-main px-5 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Accounts
    </a>
</div>

<form action="<?php echo e(route('admin.candidate-payments.store')); ?>" method="POST" class="bg-white rounded-xl shadow-sm border border-card-border p-6 max-w-3xl">
    <?php echo csrf_field(); ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 border border-red-200">
            <ul class="list-disc list-inside text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Candidate Info -->
        <div class="col-span-full">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Candidate Information</h3>
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Candidate Name <span class="text-red-500">*</span></label>
            <input type="text" name="candidate_name" value="<?php echo e(old('candidate_name')); ?>" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Mobile Number <span class="text-red-500">*</span></label>
            <input type="text" name="mobile_number" value="<?php echo e(old('mobile_number')); ?>" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-bold text-text-main mb-1.5">Address</label>
            <textarea name="address" rows="2"
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors"><?php echo e(old('address')); ?></textarea>
        </div>

        <!-- Assignment Info -->
        <div class="col-span-full mt-2">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Assignment & Fee Details</h3>
        </div>

        <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-bold text-text-main mb-1.5">Tuition Assigned</label>
            <input type="text" name="tuition_assigned" value="<?php echo e(old('tuition_assigned')); ?>" placeholder="e.g. Maths for Aarav Sharma"
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Joining Date <span class="text-red-500">*</span></label>
            <input type="date" name="joining_date" value="<?php echo e(old('joining_date')); ?>" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
            <p class="text-xs text-text-dark/50 mt-1">The first due date will automatically be exactly 1 month after this date.</p>
        </div>

        <div>
            <label class="block text-sm font-bold text-text-main mb-1.5">Monthly Amount (₹) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="monthly_amount" value="<?php echo e(old('monthly_amount')); ?>" required
                class="w-full px-4 py-2 bg-white border border-card-border rounded-lg focus:outline-none focus:border-accent-blue focus:ring-1 focus:ring-accent-blue transition-colors">
            <p class="text-xs text-text-dark/50 mt-1">The amount to be collected or paid out each month.</p>
        </div>

    </div>

    <div class="mt-8 pt-6 border-t border-card-border flex justify-end">
        <button type="submit" class="bg-accent-blue text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-700 transition-colors">
            Create Account
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/admin/candidate_payments/create.blade.php ENDPATH**/ ?>