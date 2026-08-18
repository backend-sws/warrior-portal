

<?php
    $isPendingView = request('status') === 'pending';
    $title = $isPendingView ? 'Job Approvals' : 'Live Jobs';
?>

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('actions'); ?>
    <a href="<?php echo e(route('admin.jobs.create')); ?>" class="px-4 py-2 bg-accent-blue text-white hover:bg-accent-blue-hover rounded-xl text-sm font-semibold shadow-lg shadow-accent-blue/30 transition-all flex items-center gap-2">
        <i class="fas fa-plus"></i> Post New Job
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-card-bg border border-card-border rounded-xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group">
        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Total Jobs</p>
        <h4 class="text-2xl font-extrabold text-blue-500 relative z-10"><?php echo e($stats['total']); ?></h4>
    </div>
    <div class="bg-card-bg border border-card-border rounded-xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group">
        <div class="absolute inset-0 bg-green-500/5 group-hover:bg-green-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Live (Approved)</p>
        <h4 class="text-2xl font-extrabold text-green-500 relative z-10"><?php echo e($stats['live']); ?></h4>
    </div>
    <div class="bg-card-bg border border-card-border rounded-xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group">
        <div class="absolute inset-0 bg-yellow-500/5 group-hover:bg-yellow-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Pending Review</p>
        <h4 class="text-2xl font-extrabold text-yellow-500 relative z-10"><?php echo e($stats['pending']); ?></h4>
    </div>
    <div class="bg-card-bg border border-card-border rounded-xl p-4 shadow-sm flex flex-col items-center justify-center relative overflow-hidden group">
        <div class="absolute inset-0 bg-red-500/5 group-hover:bg-red-500/10 transition-colors"></div>
        <p class="text-[10px] text-text-dark/60 font-bold uppercase tracking-wider mb-1 relative z-10">Rejected</p>
        <h4 class="text-2xl font-extrabold text-red-500 relative z-10"><?php echo e($stats['rejected']); ?></h4>
    </div>
</div>


<div class="bg-card-bg rounded-t-2xl border-x border-t border-card-border p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div class="text-sm text-text-dark/50 font-medium">
        Showing <?php echo e($jobs->firstItem() ?? 0); ?> to <?php echo e($jobs->lastItem() ?? 0); ?> of <?php echo e($jobs->total()); ?> entries
    </div>
    <form action="<?php echo e(route('admin.jobs.index')); ?>" method="GET" class="w-full sm:w-auto flex items-center relative gap-3">
        <?php if(request('status')): ?>
            <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
        <?php endif; ?>
        
        <div class="relative w-full sm:w-72">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-dark/40 text-sm"></i>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search title or school..." 
                   class="w-full pl-9 pr-8 py-2 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.jobs.index', ['status' => request('status')])); ?>" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-dark/40 hover:text-red-400 transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            <?php endif; ?>
        </div>
        <button type="submit" class="hidden sm:block px-4 py-2 bg-secondary-bg hover:bg-card-border border border-card-border text-text-main rounded-xl text-sm transition-colors">
            Filter
        </button>
    </form>
</div>


<div class="bg-card-bg rounded-b-2xl border border-card-border overflow-x-auto shadow-xl">
    <table class="w-full text-left border-collapse admin-table">
        <thead>
            <tr>
                <?php
                    $route = 'admin.jobs.index';
                    $order = request('order') === 'asc' ? 'desc' : 'asc';
                ?>
                <th>
                    <a href="<?php echo e(route($route, array_merge(request()->query(), ['sort_by' => 'title', 'order' => $order]))); ?>" class="flex items-center gap-2 hover:text-accent-blue transition-colors">
                        Job Title & School
                        <?php if(request('sort_by') === 'title'): ?>
                            <i class="fas fa-sort-<?php echo e(request('order') === 'asc' ? 'up' : 'down'); ?> text-accent-blue"></i>
                        <?php else: ?>
                            <i class="fas fa-sort text-text-dark/20"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>Subject & Category</th>
                <th>Location</th>
                <th>
                    <a href="<?php echo e(route($route, array_merge(request()->query(), ['sort_by' => 'status', 'order' => $order]))); ?>" class="flex items-center gap-2 hover:text-accent-blue transition-colors">
                        Status
                        <?php if(request('sort_by') === 'status'): ?>
                            <i class="fas fa-sort-<?php echo e(request('order') === 'asc' ? 'up' : 'down'); ?> text-accent-blue"></i>
                        <?php else: ?>
                            <i class="fas fa-sort text-text-dark/20"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="<?php echo e(route($route, array_merge(request()->query(), ['sort_by' => 'created_at', 'order' => $order]))); ?>" class="flex items-center gap-2 hover:text-accent-blue transition-colors">
                        Posted On
                        <?php if(request('sort_by') === 'created_at' || !request('sort_by')): ?>
                            <i class="fas fa-sort-<?php echo e(request('order') === 'asc' ? 'up' : 'down'); ?> text-accent-blue"></i>
                        <?php else: ?>
                            <i class="fas fa-sort text-text-dark/20"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-card-border">
            <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="group">
                <td>
                    <div class="font-semibold text-text-main group-hover:text-accent-blue transition-colors"><?php echo e($job->title ?? 'Untitled Job'); ?></div>
                    <div class="text-xs text-text-dark/50 flex items-center gap-1 mt-1">
                        <i class="fas fa-building text-[10px]"></i> <?php echo e($job->school_name); ?>

                    </div>
                </td>
                <td>
                    <div class="text-sm text-text-main font-medium"><?php echo e($job->subject?->name ?? 'N/A'); ?></div>
                    <div class="text-[10px] text-text-dark/40 uppercase tracking-wider mt-1"><?php echo e($job->category?->name ?? 'N/A'); ?></div>
                </td>
                <td>
                    <div class="text-sm text-text-main flex items-center gap-1.5">
                        <i class="fas fa-map-marker-alt text-red-400"></i> <?php echo e($job->city?->name ?? 'N/A'); ?>, <?php echo e($job->state?->name ?? ''); ?>

                    </div>
                </td>
                <td>
                    <?php if($job->status === 'approved'): ?>
                        <span class="bg-green-500/10 text-green-400 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-green-500/20 uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-check-circle"></i> Live
                        </span>
                    <?php elseif($job->status === 'pending'): ?>
                        <span class="bg-accent-yellow/10 text-accent-yellow px-2.5 py-1 rounded-lg text-[10px] font-bold border border-accent-yellow/20 uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-clock"></i> Pending
                        </span>
                    <?php else: ?>
                        <span class="bg-red-500/10 text-red-400 px-2.5 py-1 rounded-lg text-[10px] font-bold border border-red-500/20 uppercase tracking-wider flex items-center gap-1 w-max">
                            <i class="fas fa-times-circle"></i> Rejected
                        </span>
                    <?php endif; ?>
                </td>
                <td class="text-text-dark/60 text-sm">
                    <?php echo e($job->created_at->format('M d, Y')); ?>

                    <div class="text-[10px] text-text-dark/40 mt-0.5"><?php echo e($job->created_at->diffForHumans()); ?></div>
                </td>
                <td>
                    <div class="flex items-center justify-end gap-2">
                        <a href="<?php echo e(route('admin.jobs.show', $job)); ?>" class="w-8 h-8 rounded-lg bg-accent-blue/10 text-accent-blue flex items-center justify-center hover:bg-accent-blue hover:text-white transition-colors tooltip" title="Review Job">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <a href="<?php echo e(route('admin.jobs.edit', $job)); ?>" class="w-8 h-8 rounded-lg bg-accent-yellow/10 text-accent-yellow flex items-center justify-center hover:bg-accent-yellow hover:text-white transition-colors tooltip" title="Edit Job">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        
                        <?php if($job->status === 'pending'): ?>
                            <form action="<?php echo e(route('admin.jobs.approve', $job)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="create_account" value="1">
                                <button type="submit" class="w-8 h-8 rounded-lg bg-green-500/10 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors tooltip" title="Approve & Generate Account">
                                    <i class="fas fa-check text-xs"></i>
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.jobs.reject', $job)); ?>" method="POST" class="inline" onsubmit="return confirm('Reject this job?');">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors tooltip" title="Reject">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </form>
                        <?php endif; ?>

                        <form action="<?php echo e(route('admin.jobs.destroy', $job)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this job?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors tooltip" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="py-16 text-center">
                    <div class="w-16 h-16 bg-secondary-bg rounded-2xl flex items-center justify-center text-text-dark/20 text-3xl mx-auto mb-4 border border-card-border">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <p class="text-text-main font-bold text-lg mb-1">No jobs found</p>
                    <p class="text-text-dark/40 text-sm">
                        <?php echo e($isPendingView ? "There are currently no job queries awaiting your approval." : "Try adjusting your search criteria."); ?>

                    </p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php if($jobs->hasPages()): ?>
<div class="mt-6 flex justify-end">
    <?php echo e($jobs->links('pagination::tailwind')); ?>

</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\warriors portal\warriors portal\resources\views/admin/jobs/index.blade.php ENDPATH**/ ?>