<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 reveal">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#031b4e]">Additional Features</h1>
                    <p class="text-sm text-[#031b4e]/60 mt-0.5">Explore premium tools and manage your candidate notifications.</p>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 reveal reveal-delay-1">
            
            
            <div class="light-metallic-blue-card rounded-2xl border-0 p-6 shadow-sm hover:shadow-xl hover:border-[#0ea5e9]/30 transition-all flex flex-col group">
                <div class="w-12 h-12 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-route"></i>
                </div>
                <h3 class="text-lg font-bold text-[#031b4e] mb-2">Job Application Tracker</h3>
                <p class="text-sm text-[#031b4e]/60 mb-6 flex-1">Monitor the real-time status of your job applications, interviews, and final placements.</p>
                <a href="<?php echo e(route('candidate.applications.index')); ?>" class="mt-auto px-4 py-2.5 bg-[#f4f7f5] text-[#031b4e] text-sm font-semibold rounded-xl hover:bg-[#0ea5e9] hover:text-white transition-colors text-center border border-[#031b4e]/10 hover:border-transparent">
                    View Tracker
                </a>
            </div>

            
            <div class="light-metallic-blue-card rounded-2xl border-0 p-6 shadow-sm hover:shadow-xl hover:border-green-500/30 transition-all flex flex-col group">
                <div class="w-12 h-12 rounded-xl bg-green-500/10 text-green-400 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3 class="text-lg font-bold text-[#031b4e] mb-2">Resume Builder</h3>
                <p class="text-sm text-[#031b4e]/60 mb-6 flex-1">Create a professional, ATS-friendly resume using our premium templates tailored for educators.</p>
                <a href="<?php echo e(route('resume.builder')); ?>" class="mt-auto px-4 py-2.5 bg-[#f4f7f5] text-[#031b4e] text-sm font-semibold rounded-xl hover:bg-green-500 hover:text-white transition-colors text-center border border-[#031b4e]/10 hover:border-transparent">
                    Build Resume
                </a>
            </div>

            
            <div class="light-metallic-blue-card rounded-2xl border-0 p-6 shadow-sm hover:shadow-xl hover:border-blue-400/30 transition-all flex flex-col group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <?php if(auth()->user()->profile && auth()->user()->profile->is_verified): ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-500/10 border border-blue-400/30 text-blue-400 text-xs font-bold uppercase tracking-wider rounded-lg">
                            Verified
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-card-border/50 text-[#031b4e]/60 text-xs font-bold uppercase tracking-wider rounded-lg">
                            Unverified
                        </span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-[#031b4e] mb-2">Verified Candidate Badge</h3>
                <p class="text-sm text-[#031b4e]/60 mb-6 flex-1">Boost your visibility. Verified profiles are 3x more likely to be shortlisted by top schools.</p>
                <a href="<?php echo e(route('candidate.profile.edit')); ?>" class="mt-auto px-4 py-2.5 bg-[#f4f7f5] text-[#031b4e] text-sm font-semibold rounded-xl hover:bg-card-border/50 transition-colors text-center border border-[#031b4e]/10">
                    Request Verification
                </a>
            </div>

        </div>

        
        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(18, 154, 239, 0.4);
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(18, 154, 239, 0.8);
            }
        </style>

        
        <?php
            $userNotifications = auth()->user()->notifications()->take(50)->get();
            $notifCount = count($userNotifications);
        ?>

        <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-sm reveal reveal-delay-2"
             x-data="{ displayLimit: 4, totalNotifs: <?php echo e($notifCount > 0 ? $notifCount : 3); ?> }">
            
            
            <div class="px-6 py-5 border-b border-[#031b4e]/10 flex items-center justify-between bg-[#f4f7f5]/30">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-[#031b4e]">Notification Center</h2>
                        <p class="text-xs text-[#031b4e]/60">Your recent updates, application alerts, and system notices</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#0ea5e9]/10 border border-[#0ea5e9]/20 text-[#0ea5e9] text-xs font-bold rounded-lg">
                    <span class="w-2 h-2 rounded-full bg-[#0ea5e9] animate-pulse"></span> Active Alerts (<?php echo e($notifCount > 0 ? $notifCount : 3); ?>)
                </span>
            </div>

            
            <div class="p-6 max-h-[380px] overflow-y-auto space-y-3 custom-scrollbar">

                <?php $__empty_1 = true; $__currentLoopData = $userNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div x-show="<?php echo e($index); ?> < displayLimit" 
                         class="p-4 bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-[#0ea5e9]/30 transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-base shrink-0 mt-0.5 border border-[#0ea5e9]/20">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-[#031b4e] mb-1"><?php echo e($notif->data['title'] ?? 'System Notification'); ?></h4>
                                <p class="text-xs text-[#031b4e]/80/70 leading-relaxed"><?php echo e($notif->data['message'] ?? 'You have a new update.'); ?></p>
                                <span class="text-[11px] text-[#0ea5e9] font-semibold mt-1.5 inline-block">
                                    <i class="far fa-clock text-[10px]"></i> <?php echo e($notif->created_at->diffForHumans()); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    
                    <div x-show="0 < displayLimit" class="p-4 bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-[#0ea5e9]/30 transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-base shrink-0 mt-0.5 border border-[#0ea5e9]/20">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-[#031b4e] mb-1">Candidate Profile Status Active</h4>
                                <p class="text-xs text-[#031b4e]/80/70 leading-relaxed">Your candidate profile is active and searchable by recruiting educational institutions across India.</p>
                                <span class="text-[11px] text-[#0ea5e9] font-semibold mt-1.5 inline-block">
                                    <i class="far fa-clock text-[10px]"></i> Just now
                                </span>
                            </div>
                        </div>
                        <a href="<?php echo e(route('candidate.profile.edit')); ?>" class="shrink-0 px-3.5 py-2 bg-white hover:bg-[#0ea5e9] hover:text-white text-[#031b4e] text-xs font-semibold rounded-lg border border-[#031b4e]/10 transition-colors">
                            Update Profile →
                        </a>
                    </div>

                    <div x-show="1 < displayLimit" class="p-4 bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-green-500/30 transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-green-500/10 text-green-400 flex items-center justify-center text-base shrink-0 mt-0.5 border border-green-500/20">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-[#031b4e] mb-1">Registration Status Active</h4>
                                <p class="text-xs text-[#031b4e]/80/70 leading-relaxed">Your registration plan is active. You can apply for open teaching and non-teaching positions.</p>
                                <span class="text-[11px] text-green-400 font-semibold mt-1.5 inline-block">
                                    <i class="far fa-clock text-[10px]"></i> 1 hour ago
                                </span>
                            </div>
                        </div>
                        <a href="<?php echo e(route('candidate.registration.show')); ?>" class="shrink-0 px-3.5 py-2 bg-white hover:bg-green-500 hover:text-white text-[#031b4e] text-xs font-semibold rounded-lg border border-[#031b4e]/10 transition-colors">
                            View Plan →
                        </a>
                    </div>

                    <div x-show="2 < displayLimit" class="p-4 bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-amber-500/30 transition-all">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-base shrink-0 mt-0.5 border border-amber-500/20">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-[#031b4e] mb-1">Service Charge & Invoices</h4>
                                <p class="text-xs text-[#031b4e]/80/70 leading-relaxed">Check your service charge status, payment due dates, and download invoices anytime.</p>
                                <span class="text-[11px] text-amber-400 font-semibold mt-1.5 inline-block">
                                    <i class="far fa-clock text-[10px]"></i> 2 hours ago
                                </span>
                            </div>
                        </div>
                        <a href="<?php echo e(route('candidate.serviceCharge.show')); ?>" class="shrink-0 px-3.5 py-2 bg-white hover:bg-amber-500 hover:text-white text-[#031b4e] text-xs font-semibold rounded-lg border border-[#031b4e]/10 transition-colors">
                            View Invoices →
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            
            <div x-show="displayLimit < totalNotifs" class="p-3.5 border-t border-[#031b4e]/10 bg-[#f4f7f5]/30 text-center">
                <button type="button" @click="displayLimit += 5" class="px-5 py-2 bg-[#0ea5e9]/10 hover:bg-[#0ea5e9] text-[#0ea5e9] hover:text-white text-xs font-bold rounded-xl transition-all border border-[#0ea5e9]/20 shadow-sm">
                    Load More Notifications <i class="fas fa-chevron-down text-[10px] ml-1"></i>
                </button>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\warrioredu\resources\views/candidate/aditionalFeature/show.blade.php ENDPATH**/ ?>