
<div class="bg-[#031b4e] border-b border-gray-600 shadow-md sticky z-[99]" style="top: 132px;">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-nowrap overflow-x-auto hide-scrollbar py-0 gap-1 lg:gap-2 text-sm font-bold items-center justify-start">
            <?php
                $appCount = auth()->user()->applications()->count();
                $navItems = [
                    ['route' => 'candidate.dashboard', 'routeIs' => 'candidate.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
                    ['route' => 'candidate.tuitions.index', 'routeIs' => 'candidate.tuitions.*', 'icon' => 'fa-book-reader', 'label' => 'Tuitions'],
                    ['route' => 'candidate.profile.edit', 'routeIs' => 'candidate.profile.*', 'icon' => 'fa-user-circle', 'label' => 'My Profile'],
                    ['route' => 'candidate.applications.index', 'routeIs' => 'candidate.applications.*', 'icon' => 'fa-paper-plane', 'label' => "Applications ($appCount)"],
                    ['route' => 'candidate.payment.show', 'routeIs' => 'candidate.payment.*', 'icon' => 'fa-credit-card', 'label' => 'Payment & Plan'],
                    ['route' => 'candidate.agreement.show', 'routeIs' => 'candidate.agreement.*', 'icon' => 'fa-file-contract', 'label' => 'My Agreement'],
                    ['route' => 'candidate.registration.show', 'routeIs' => 'candidate.registration.*', 'icon' => 'fa-clipboard-list', 'label' => 'Registration'],
                    ['route' => 'candidate.serviceCharge.show', 'routeIs' => 'candidate.servicecharge.*', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Service Charge'],
                    ['route' => 'candidate.aditionalFeature.show', 'routeIs' => 'candidate.aditional.*', 'icon' => 'fa-puzzle-piece', 'label' => 'Aditional Feature'],
                ];
            ?>

            <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route($item['route'])); ?>" class="relative px-3 py-3 md:px-4 md:py-4 transition-all flex items-center gap-2 rounded-md whitespace-nowrap
                                   <?php echo e(request()->routeIs($item['routeIs'])
                ? 'text-[#031b4e] bg-white shadow-sm'
                : 'text-gray-300 hover:text-white hover:bg-white/10'); ?>">

                        <?php if($item['route'] === 'candidate.profile.edit' && auth()->user()->profile?->profile_photo_path): ?>
                            <img src="<?php echo e(asset('storage/' . auth()->user()->profile->profile_photo_path)); ?>" alt="Profile"
                                class="w-5 h-5 rounded-full object-cover border border-[#0ea5e9]/30">
                        <?php else: ?>
                            <i class="fas <?php echo e($item['icon']); ?> text-xs"></i>
                        <?php endif; ?>

                        <?php echo e($item['label']); ?>

                    </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <form action="<?php echo e(route('logout')); ?>" method="POST" class="ml-auto flex-shrink-0">
                <?php echo csrf_field(); ?>
                <button type="submit"
                    class="px-4 py-3 md:py-4 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-md transition-colors flex items-center gap-1.5 text-sm font-bold whitespace-nowrap">
                    <i class="fas fa-sign-out-alt text-xs"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>
<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>



<?php /**PATH D:\warrior-portal\resources\views/candidate/partials/nav.blade.php ENDPATH**/ ?>