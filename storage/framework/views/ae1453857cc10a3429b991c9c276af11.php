<?php $__env->startSection('title', 'Dashboard Overview'); ?>

<?php $__env->startSection('content'); ?>


<div class="bg-gradient-to-r from-[#1b64bd] to-[#124d9c] rounded-3xl p-6 md:p-8 shadow-lg mb-8 text-white relative overflow-hidden">
    <!-- Abstract Background shapes -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-[#00a8e8]/20 rounded-full blur-2xl translate-y-1/3 -translate-x-1/4"></div>

    <!-- Top Row: Welcome + Date Filter -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 relative z-10 gap-4">
        <div>
            <h2 class="text-3xl font-bold mb-1">Welcome back, Admin</h2>
            <p class="text-blue-100 text-sm">Here's your platform performance overview</p>
        </div>
        
        <!-- Date Filter Form -->
        <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2 bg-white/10 p-2 rounded-xl border border-white/20 backdrop-blur-md">
            <div class="flex items-center gap-2 px-2 border-r border-white/20">
                <i class="fas fa-filter text-white/70 text-xs"></i>
                <input type="date" name="from_date" value="<?php echo e(request('from_date')); ?>" class="bg-transparent border-none text-sm text-white outline-none [&::-webkit-calendar-picker-indicator]:filter-[invert(1)] focus:ring-0 w-32">
            </div>
            <div class="flex items-center gap-2 px-2">
                <span class="text-white/50 text-xs">to</span>
                <input type="date" name="to_date" value="<?php echo e(request('to_date')); ?>" class="bg-transparent border-none text-sm text-white outline-none [&::-webkit-calendar-picker-indicator]:filter-[invert(1)] focus:ring-0 w-32">
            </div>
            <button type="submit" class="bg-white text-[#124d9c] w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors shadow-sm">
                <i class="fas fa-search text-xs"></i>
            </button>
            <?php if(request('from_date') || request('to_date')): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-red-300 hover:text-red-200 ml-1 text-xs px-2 py-1 bg-red-500/20 rounded-md transition-colors"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Stats Row (4 cards inside hero) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 relative z-10">
        <!-- Card 1: Total Candidates (Green Gradient) -->
        <a href="<?php echo e(route('admin.crm.index')); ?>" class="bg-gradient-to-br from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 border border-white/20 rounded-2xl p-5 transition-all group shadow-[0_0_20px_rgba(52,211,153,0.5)]">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform"><i class="fas fa-users"></i></div>
                <span class="text-blue-100 text-sm font-medium">Total Candidates</span>
            </div>
            <h3 class="text-3xl font-bold tracking-tight"><?php echo e(number_format($totalCandidates)); ?></h3>
            <p class="text-blue-200 text-xs mt-2 font-medium flex items-center gap-1"><i class="fas fa-arrow-up text-[10px]"></i> +12% from last month</p>
        </a>
        
        <!-- Card 2: Active Jobs (Purple Gradient) -->
        <a href="<?php echo e(route('admin.jobs.index')); ?>" class="bg-gradient-to-br from-violet-600 to-indigo-500 hover:from-violet-700 hover:to-indigo-600 border border-white/20 rounded-2xl p-5 transition-all group shadow-[0_0_20px_rgba(139,92,246,0.5)]">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform"><i class="fas fa-briefcase"></i></div>
                <span class="text-blue-100 text-sm font-medium">Active Jobs</span>
            </div>
            <h3 class="text-3xl font-bold tracking-tight"><?php echo e(number_format($activeJobs)); ?></h3>
            <p class="text-blue-200 text-xs mt-2 font-medium flex items-center gap-1"><i class="fas fa-arrow-up text-[10px]"></i> +5% from last month</p>
        </a>
        
        <!-- Card 3: Total Revenue (Cyan Gradient) -->
        <a href="<?php echo e(route('admin.transactions.index')); ?>" class="bg-gradient-to-br from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 border border-white/20 rounded-2xl p-5 transition-all group shadow-[0_0_20px_rgba(6,182,212,0.5)]">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform"><i class="fas fa-wallet"></i></div>
                <span class="text-blue-100 text-sm font-medium">Total Revenue</span>
            </div>
            <h3 class="text-3xl font-bold tracking-tight">₹<?php echo e(number_format($totalCollections)); ?></h3>
            <p class="text-blue-200 text-xs mt-2 font-medium flex items-center gap-1"><i class="fas fa-arrow-up text-[10px]"></i> +18% from last month</p>
        </a>
        
        <!-- Card 4: Pending Jobs (Orange Gradient) -->
        <a href="<?php echo e(route('admin.jobs.index', ['status' => 'pending'])); ?>" class="bg-gradient-to-br from-orange-400 to-amber-500 hover:from-orange-500 hover:to-amber-600 border border-white/20 rounded-2xl p-5 transition-all group shadow-[0_0_20px_rgba(249,115,22,0.5)]">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center text-sm shadow-inner group-hover:scale-110 transition-transform"><i class="fas fa-clock"></i></div>
                <span class="text-blue-100 text-sm font-medium">Pending Jobs</span>
            </div>
            <h3 class="text-3xl font-bold tracking-tight"><?php echo e(number_format($pendingJobs->count())); ?></h3>
            <p class="text-red-200 text-xs mt-2 font-medium bg-red-500/30 w-max px-2 py-0.5 rounded-full">Requires Action</p>
        </a>
    </div>
</div>


<?php if(request('from_date') || request('to_date')): ?>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-8 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/30 flex justify-between items-center">
            <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                <i class="fas fa-filter text-blue-500"></i> Filtered Applications
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Candidate</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Job Applied For</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Date</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $recentApps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/80 transition-colors <?php echo e($app->candidate ? 'cursor-pointer' : ''); ?>" 
                        <?php if($app->candidate): ?> onclick="window.location='<?php echo e(route('admin.crm.show', $app->candidate->id)); ?>'" <?php endif; ?>>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 text-sm"><?php echo e($app->candidate->name ?? 'Unknown'); ?></div>
                            <div class="text-xs text-gray-500 mt-0.5"><?php echo e($app->candidate->email ?? 'N/A'); ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800 text-sm"><?php echo e($app->jobPost->title ?? 'Teacher'); ?></div>
                            <div class="text-xs text-gray-500 mt-0.5"><?php echo e($app->jobPost->school_name ?? 'School'); ?></div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm font-medium"><?php echo e($app->created_at->diffForHumans()); ?></td>
                        <td class="px-6 py-4">
                            <?php if($app->status === 'applied'): ?>
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-md text-xs font-bold border border-blue-100">Applied</span>
                            <?php elseif($app->status === 'hired'): ?>
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-md text-xs font-bold border border-emerald-100">Hired</span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-md text-xs font-bold border border-gray-200">Waitlisted</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="py-12 text-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 text-xl mx-auto mb-3">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">No applications found for this date range.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Received -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border-b-[3px] border-blue-500 hover:-translate-y-1 transition-transform">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-lg"><i class="fas fa-file-signature"></i></div>
            <span class="text-emerald-500 text-xs font-bold flex items-center gap-1"><i class="fas fa-arrow-up"></i> 10.5%</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e(number_format($totalApplications)); ?></h3>
        <p class="text-gray-500 text-sm font-medium">Total Received</p>
    </div>
    
    <!-- Transferred -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border-b-[3px] border-emerald-500 hover:-translate-y-1 transition-transform">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg"><i class="fas fa-share-square"></i></div>
            <span class="text-emerald-500 text-xs font-bold flex items-center gap-1"><i class="fas fa-arrow-up"></i> 4.3%</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e(number_format($transferredApplications)); ?></h3>
        <p class="text-gray-500 text-sm font-medium">Transferred to School</p>
    </div>
    
    <!-- Rejected -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border-b-[3px] border-amber-500 hover:-translate-y-1 transition-transform">
         <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg"><i class="fas fa-times-circle"></i></div>
            <span class="text-rose-500 text-xs font-bold flex items-center gap-1"><i class="fas fa-arrow-up"></i> 2.1%</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e(number_format($rejectedApplications)); ?></h3>
        <p class="text-gray-500 text-sm font-medium">Rejected Apps</p>
    </div>
    
    <!-- Placements -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border-b-[3px] border-purple-500 hover:-translate-y-1 transition-transform">
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-lg"><i class="fas fa-award"></i></div>
            <span class="text-emerald-500 text-xs font-bold flex items-center gap-1"><i class="fas fa-arrow-up"></i> 8.2%</span>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e(number_format($placements)); ?></h3>
        <p class="text-gray-500 text-sm font-medium">Total Placements</p>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    
    <!-- Left Column (Revenue Analytics & Sub-stats) -->
    <div class="lg:col-span-2 flex flex-col gap-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex-1">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Revenue Analytics</h3>
                    <p class="text-gray-500 text-xs mt-1">Overview of your earnings performance</p>
                </div>
                <div class="flex bg-blue-50 p-1 rounded-lg border border-blue-100 shadow-inner">
                    <button type="button" onclick="updateChart('days')" id="btn-chart-days" class="px-4 py-1.5 text-xs font-bold rounded-md bg-blue-600 text-white shadow-sm transition-all">This Month</button>
                    <button type="button" onclick="updateChart('months')" id="btn-chart-months" class="px-4 py-1.5 text-xs font-bold rounded-md text-blue-600 hover:bg-blue-100 transition-all">Yearly</button>
                </div>
            </div>
            
            <div class="w-full h-[300px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Small Revenue Stats Below Chart -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
             <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center hover:border-blue-200 transition-colors">
                 <div class="w-10 h-10 mx-auto rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-3 text-lg"><i class="fas fa-wallet"></i></div>
                 <h4 class="font-bold text-gray-900 text-xl">₹<?php echo e(number_format($totalCollections)); ?></h4>
                 <p class="text-xs font-medium text-gray-500 mt-1">Total Collected</p>
             </div>
             <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center hover:border-emerald-200 transition-colors">
                 <div class="w-10 h-10 mx-auto rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-3 text-lg"><i class="fas fa-check-double"></i></div>
                 <h4 class="font-bold text-gray-900 text-xl">₹<?php echo e(number_format($registrationRevenue)); ?></h4>
                 <p class="text-xs font-medium text-gray-500 mt-1">Registration Fees</p>
             </div>
             <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center hover:border-amber-200 transition-colors">
                 <div class="w-10 h-10 mx-auto rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mb-3 text-lg"><i class="fas fa-receipt"></i></div>
                 <h4 class="font-bold text-gray-900 text-xl">₹<?php echo e(number_format($serviceChargeRevenue)); ?></h4>
                 <p class="text-xs font-medium text-gray-500 mt-1">Service Charges</p>
             </div>
        </div>
    </div>
    
    <!-- Right Column (Live Activity) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-bold text-gray-900 text-lg">Live Activity</h3>
            <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md font-bold flex items-center gap-1.5 uppercase tracking-wide border border-emerald-100">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div> Live
            </span>
        </div>
        
        <div class="space-y-6 flex-1 overflow-y-auto max-h-[460px] pr-2 custom-scrollbar">
            <?php $__empty_1 = true; $__currentLoopData = $recentApps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex gap-4 relative">
                <!-- Line connector -->
                <?php if(!$loop->last): ?>
                <div class="absolute top-10 left-5 w-px h-[calc(100%-8px)] bg-gray-100"></div>
                <?php endif; ?>
                
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 border-4 border-white shadow-sm z-10 text-sm">
                    <i class="fas fa-paper-plane"></i>
                </div>
                
                <div class="pt-2 pb-4">
                    <p class="text-sm text-gray-700 leading-tight">
                        <span class="font-bold text-gray-900"><?php echo e($app->candidate->name ?? 'Unknown'); ?></span> applied for 
                        <span class="font-bold text-gray-900"><?php echo e($app->jobPost->title ?? 'a job'); ?></span>
                    </p>
                    <p class="text-xs font-medium text-gray-400 mt-1.5"><?php echo e($app->created_at->diffForHumans()); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-gray-200 mb-3"></i>
                <p class="text-sm font-medium text-gray-500">No recent activity.</p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-100 text-center">
            <a href="<?php echo e(route('admin.applications.index')); ?>" class="text-blue-500 text-sm font-bold hover:text-blue-600 transition-colors">View all activities <i class="fas fa-arrow-right text-[10px] ml-1"></i></a>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    
    <!-- Quick Actions -->
    <div>
        <h3 class="font-bold text-gray-900 text-lg mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-4">
             <a href="<?php echo e(route('admin.jobs.create')); ?>" class="bg-blue-600 rounded-2xl p-6 text-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group overflow-hidden relative">
                 <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all"></div>
                 <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mb-4 text-xl backdrop-blur-sm"><i class="fas fa-plus"></i></div>
                 <h4 class="font-bold text-lg tracking-tight">Add Job</h4>
                 <p class="text-blue-100 text-xs mt-1">Create new listing</p>
             </a>
             
             <a href="<?php echo e(route('admin.jobs.index', ['status' => 'pending'])); ?>" class="bg-emerald-500 rounded-2xl p-6 text-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group overflow-hidden relative">
                 <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all"></div>
                 <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mb-4 text-xl backdrop-blur-sm"><i class="fas fa-clipboard-check"></i></div>
                 <h4 class="font-bold text-lg tracking-tight">Approve Jobs</h4>
                 <p class="text-emerald-100 text-xs mt-1">Review pending</p>
             </a>
             
             <a href="<?php echo e(route('admin.categories.index')); ?>" class="bg-amber-500 rounded-2xl p-6 text-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group overflow-hidden relative">
                 <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all"></div>
                 <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mb-4 text-xl backdrop-blur-sm"><i class="fas fa-layer-group"></i></div>
                 <h4 class="font-bold text-lg tracking-tight">Categories</h4>
                 <p class="text-amber-100 text-xs mt-1">Manage listings</p>
             </a>
             
             <a href="#" class="bg-purple-600 rounded-2xl p-6 text-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group overflow-hidden relative">
                 <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all"></div>
                 <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mb-4 text-xl backdrop-blur-sm"><i class="fas fa-cog"></i></div>
                 <h4 class="font-bold text-lg tracking-tight">Settings</h4>
                 <p class="text-purple-100 text-xs mt-1">Configure system</p>
             </a>
        </div>
    </div>
    
    <!-- Top Sellers / Plan Purchases -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
         <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-900 text-lg">Top Plans</h3>
            <a href="<?php echo e(route('admin.crm.index')); ?>" class="text-blue-500 text-sm font-bold hover:text-blue-600 transition-colors">View all</a>
        </div>
        
        <div class="space-y-3">
            <a href="<?php echo e(route('admin.crm.index', ['plan_amount' => 500])); ?>" class="flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 border border-gray-100 rounded-xl transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform"><i class="fas fa-star"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-900">₹500 Starter Plan</h4>
                        <p class="text-xs font-medium text-gray-500 mt-0.5">Basic access plan</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-bold text-gray-900 block text-lg"><?php echo e(number_format($plan500Count)); ?></span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Users</span>
                </div>
            </a>
            
            <a href="<?php echo e(route('admin.crm.index', ['plan_amount' => 1000])); ?>" class="flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 border border-gray-100 rounded-xl transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform"><i class="fas fa-crown"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-900">₹1000 Premium Plan</h4>
                        <p class="text-xs font-medium text-gray-500 mt-0.5">Full access plan</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-bold text-gray-900 block text-lg"><?php echo e(number_format($plan1000Count)); ?></span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Users</span>
                </div>
            </a>
            
            <a href="<?php echo e(route('admin.subjects.index')); ?>" class="flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-50 border border-gray-100 rounded-xl transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform"><i class="fas fa-book"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-900">Manage Subjects</h4>
                        <p class="text-xs font-medium text-gray-500 mt-0.5">Configure platform subjects</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-emerald-500 group-hover:border-emerald-200 transition-colors">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar for live activity */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = <?php echo json_encode($chartData, 15, 512) ?>;
    let currentChart = null;

    function updateChart(period) {
        // Update buttons UI
        const btnDays = document.getElementById('btn-chart-days');
        const btnMonths = document.getElementById('btn-chart-months');
        
        if (period === 'days') {
            btnDays.className = 'px-4 py-1.5 text-xs font-bold rounded-md bg-blue-600 text-white shadow-sm transition-all';
            btnMonths.className = 'px-4 py-1.5 text-xs font-bold rounded-md text-blue-600 hover:bg-blue-100 transition-all';
        } else {
            btnMonths.className = 'px-4 py-1.5 text-xs font-bold rounded-md bg-blue-600 text-white shadow-sm transition-all';
            btnDays.className = 'px-4 py-1.5 text-xs font-bold rounded-md text-blue-600 hover:bg-blue-100 transition-all';
        }

        const canvas = document.getElementById('revenueChart');
        const ctx = canvas.getContext('2d');
        
        // If data is missing for period, fallback to empty
        const data = chartData[period] || { labels: [], data: [] };
        
        if (currentChart) {
            currentChart.destroy();
        }

        // Create elegant gradient for chart fill
        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)'); // blue-600
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        // Set global font settings for Chart.js
        Chart.defaults.color = '#9ca3af'; // Tailwind gray-400
        Chart.defaults.font.family = "'Instrument Sans', sans-serif";
        Chart.defaults.font.weight = '600';

        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Revenue',
                    data: data.data,
                    borderColor: '#2563eb', // blue-600
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4, // Smooth curve
                    pointBackgroundColor: '#ffffff', // white
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#2563eb',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937', // gray-800
                        titleColor: '#f9fafb', // gray-50
                        bodyColor: '#f9fafb', // gray-50
                        borderColor: 'transparent',
                        padding: 12,
                        displayColors: false,
                        cornerRadius: 8,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 14, weight: 'bold' },
                        callbacks: {
                            label: function(context) {
                                return '₹' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: '#f3f4f6', // gray-100
                            drawBorder: false,
                            borderDash: [5, 5]
                        },
                        border: { display: false },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            },
                            font: { size: 11 },
                            padding: 10
                        }
                    },
                    x: {
                        grid: { 
                            display: false,
                            drawBorder: false,
                        },
                        border: { display: false },
                        ticks: {
                            font: { size: 11 },
                            padding: 10,
                            maxTicksLimit: 8
                        }
                    }
                }
            }
        });
    }

    // Initialize with days
    document.addEventListener("DOMContentLoaded", function() {
        updateChart('days');
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\warriors portal\warriors portal\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>