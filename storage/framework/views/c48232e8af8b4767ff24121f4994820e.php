<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 reveal">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#031b4e]">My Applications</h1>
                    <p class="text-xs sm:text-sm text-[#031b4e]/70 mt-0.5">Track the status of jobs you've applied for.</p>
                </div>
            </div>
            <a href="<?php echo e(route('candidate.applications.available')); ?>"
                class="w-full sm:w-auto px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0284c7] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-2 active:scale-95">
                <i class="fas fa-search text-xs"></i> Find More Jobs
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-5 sm:mb-6 bg-green-500/10 border border-green-500/30 p-3.5 sm:p-4 rounded-xl flex items-center gap-3 reveal">
                <i class="fas fa-check-circle text-green-500 text-sm sm:text-base shrink-0"></i>
                <span class="text-xs sm:text-sm text-green-700 font-medium"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if($applications->isEmpty()): ?>
            
            <div class="bg-white rounded-2xl border border-[#031b4e]/10 p-6 sm:p-12 text-center shadow-sm reveal">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-50 text-[#0ea5e9] rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 shadow-sm">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-[#031b4e] mb-1.5">No Applications Yet</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-sm sm:max-w-md mx-auto mb-5 leading-relaxed">
                    You haven't applied for any school jobs yet. Start exploring active job openings that match your qualifications.
                </p>
                <a href="<?php echo e(route('candidate.applications.available')); ?>"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#0ea5e9] hover:bg-[#0284c7] text-white rounded-xl text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition-all active:scale-95">
                    <i class="fas fa-search text-xs"></i> Browse Available Jobs &rarr;
                </a>
            </div>
        <?php else: ?>
            
            <div class="block md:hidden space-y-3.5" x-data="{ expandedId: null }">
                <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border border-[#031b4e]/10 rounded-2xl p-4 shadow-sm transition-all">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 bg-[#0ea5e9]/10 rounded-lg flex items-center justify-center text-[#0ea5e9] text-xs font-bold shrink-0">
                                    <?php echo e(strtoupper(substr($app->jobPost->school_name ?? 'SC', 0, 2))); ?>

                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-[#031b4e] text-sm truncate">
                                        <a href="<?php echo e(route('jobs.show', $app->jobPost->id)); ?>" target="_blank" class="hover:text-[#0ea5e9]">
                                            <?php echo e($app->jobPost->title ?? 'Teacher'); ?>

                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 truncate"><?php echo e($app->jobPost->school_name); ?> &bull; <?php echo e($app->jobPost->city?->name ?? 'N/A'); ?></p>
                                </div>
                            </div>

                            <?php if($app->status === 'hired'): ?>
                                <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-green-100 text-green-700 border border-green-200">
                                    <i class="fas fa-trophy mr-0.5"></i> Placed
                                </span>
                            <?php elseif($app->status === 'rejected'): ?>
                                <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700 border border-red-200">
                                    <i class="fas fa-times mr-0.5"></i> Not Selected
                                </span>
                            <?php else: ?>
                                <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    <i class="fas fa-spinner fa-spin mr-0.5"></i> In Progress
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between pt-2.5 border-t border-slate-100 text-xs">
                            <div>
                                <?php if($app->interview_date): ?>
                                    <button @click="$dispatch('open-schedule-modal', { date: '<?php echo e($app->interview_date->format('l, F j, Y \a\t g:i A')); ?>', link: '<?php echo e($app->interview_link ?? ''); ?>' })" 
                                        class="inline-flex items-center px-2 py-0.5 rounded-lg font-bold bg-green-50 text-green-700 border border-green-200 text-[11px]">
                                        <i class="fas fa-calendar-alt mr-1 text-[9px]"></i> View Schedule
                                    </button>
                                <?php else: ?>
                                    <span class="text-slate-400 font-medium">
                                        <i class="far fa-clock mr-1 text-[10px]"></i> Interview Pending
                                    </span>
                                <?php endif; ?>
                            </div>

                            <button @click="expandedId === <?php echo e($app->id); ?> ? expandedId = null : expandedId = <?php echo e($app->id); ?>" 
                                class="flex items-center gap-1 font-bold text-[#0ea5e9] hover:underline text-xs">
                                <span>Tracker</span>
                                <i class="fas fa-chevron-down text-[10px] transition-transform" :class="expandedId === <?php echo e($app->id); ?> ? 'rotate-180' : ''"></i>
                            </button>
                        </div>

                        
                        <div x-show="expandedId === <?php echo e($app->id); ?>" x-collapse style="display: none;" class="mt-3 pt-3 border-t border-slate-100">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                                <h4 class="font-bold text-[#031b4e] text-xs flex items-center gap-1.5">
                                    <i class="fas fa-route text-[#0ea5e9]"></i> Status Timeline
                                </h4>

                                <div class="space-y-2 text-xs">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full bg-green-500 text-white flex items-center justify-center text-[10px] shrink-0">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-bold text-slate-800">Applied:</span> 
                                            <span class="text-slate-500"><?php echo e($app->created_at->format('d M, Y')); ?></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] shrink-0 <?php echo e(in_array($app->status, ['shortlisted', 'hired', 'rejected']) ? 'bg-amber-500 text-white' : 'bg-slate-200 text-slate-500'); ?>">
                                            <i class="fas <?php echo e(in_array($app->status, ['shortlisted', 'hired', 'rejected']) ? 'fa-check' : 'fa-hourglass-half'); ?>"></i>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-bold text-slate-800">Forwarded:</span> 
                                            <span class="text-slate-500"><?php echo e($app->is_forwarded ? 'Sent to school' : 'Pending review'); ?></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] shrink-0 <?php echo e($app->status === 'hired' ? 'bg-green-500 text-white' : ($app->status === 'rejected' ? 'bg-red-500 text-white' : 'bg-slate-200 text-slate-500')); ?>">
                                            <i class="fas <?php echo e($app->status === 'hired' ? 'fa-trophy' : ($app->status === 'rejected' ? 'fa-times' : 'fa-question')); ?>"></i>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-bold text-slate-800">Decision:</span> 
                                            <span class="<?php echo e($app->status === 'hired' ? 'text-green-600 font-bold' : ($app->status === 'rejected' ? 'text-red-600 font-bold' : 'text-slate-500')); ?>">
                                                <?php echo e($app->status === 'hired' ? 'Selected / Hired' : ($app->status === 'rejected' ? 'Not Selected' : 'In Progress')); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <?php if($app->remarks): ?>
                                    <div class="p-2.5 bg-blue-50/70 border border-blue-100 rounded-lg text-xs">
                                        <strong class="text-[#031b4e] block mb-0.5">Admin Remarks:</strong>
                                        <p class="text-slate-600 mb-0"><?php echo e($app->remarks); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="hidden md:block bg-white rounded-2xl border border-[#031b4e]/10 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/60">
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Institution & Role</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Applied School</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Interview Status</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-[#031b4e]/70">Placement Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100" x-data="{ expandedId: null }">
                            <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-50/50 transition-colors cursor-pointer group"
                                    @click="expandedId === <?php echo e($app->id); ?> ? expandedId = null : expandedId = <?php echo e($app->id); ?>">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-[#0ea5e9]/10 rounded-xl flex items-center justify-center text-[#0ea5e9] text-sm font-bold shrink-0 group-hover:scale-110 transition-transform">
                                                <?php echo e(strtoupper(substr($app->jobPost->school_name ?? 'SC', 0, 2))); ?>

                                            </div>
                                            <div>
                                                <div class="font-bold text-[#031b4e] flex items-center gap-2 hover:text-[#0ea5e9] transition-colors">
                                                    <a href="<?php echo e(route('jobs.show', $app->jobPost->id)); ?>" target="_blank" @click.stop>
                                                        <?php echo e($app->jobPost->title ?? 'Teacher'); ?>

                                                    </a>
                                                    <i class="fas fa-chevron-down text-[10px] text-[#031b4e]/50 transition-transform"
                                                        :class="expandedId === <?php echo e($app->id); ?> ? 'rotate-180 text-[#0ea5e9]' : ''"></i>
                                                </div>
                                                <div class="text-xs text-slate-500 mt-0.5">
                                                    <?php echo e($app->jobPost->school_name); ?> &bull; <?php echo e($app->jobPost->city?->name ?? 'N/A'); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-[#031b4e] text-sm font-medium">
                                        <?php echo e($app->jobPost->school_name); ?>

                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if($app->interview_date): ?>
                                            <button @click.stop="$dispatch('open-schedule-modal', { date: '<?php echo e($app->interview_date->format('l, F j, Y \a\t g:i A')); ?>', link: '<?php echo e($app->interview_link ?? ''); ?>' })" 
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 transition-colors">
                                                <i class="fas fa-calendar-alt mr-1.5 text-[10px]"></i> View Schedule
                                            </button>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-500">
                                                <i class="fas fa-clock mr-1.5 text-[10px]"></i> Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if($app->status === 'hired'): ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                <i class="fas fa-trophy mr-1 text-[10px]"></i> Placed
                                            </span>
                                        <?php elseif($app->status === 'rejected'): ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                <i class="fas fa-times mr-1 text-[10px]"></i> Not Selected
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                <i class="fas fa-spinner fa-spin mr-1 text-[10px]"></i> In Progress
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                
                                <tr x-show="expandedId === <?php echo e($app->id); ?>" class="bg-slate-50/50" x-transition.opacity style="display: none;">
                                    <td colspan="4" class="px-6 py-6 border-b-2 border-[#0ea5e9]/30">
                                        <div class="p-5 border border-slate-200 rounded-2xl bg-white shadow-inner">
                                            <h4 class="font-bold text-[#031b4e] mb-6 flex items-center gap-2">
                                                <i class="fas fa-route text-[#0ea5e9]"></i> Application Tracker
                                            </h4>

                                            <div class="relative flex flex-col md:flex-row justify-between w-full mb-6 gap-6 md:gap-0">
                                                <!-- Connecting Line -->
                                                <div class="absolute top-4 left-[10%] w-[80%] h-1 bg-slate-200 z-0 hidden md:block">
                                                    <div class="h-full bg-[#0ea5e9] transition-all duration-500"
                                                        style="width: <?php echo e(in_array($app->status, ['shortlisted', 'hired', 'rejected']) ? (in_array($app->status, ['hired', 'rejected']) ? '100%' : '50%') : '0%'); ?>">
                                                    </div>
                                                </div>

                                                <!-- Step 1: Applied -->
                                                <div class="relative z-10 flex flex-col items-center flex-1">
                                                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center shadow-md z-10">
                                                        <i class="fas fa-check text-xs"></i>
                                                    </div>
                                                    <div class="mt-3 text-sm font-bold text-[#031b4e]">Applied</div>
                                                    <div class="text-[10px] text-slate-500">
                                                        <?php echo e($app->created_at->format('d M, Y h:i A')); ?>

                                                    </div>
                                                </div>

                                                <!-- Step 2: Forwarded -->
                                                <div class="relative z-10 flex flex-col items-center flex-1">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center z-10 transition-colors duration-300 <?php echo e(in_array($app->status, ['shortlisted', 'hired', 'rejected']) ? 'bg-amber-500 text-white shadow-md' : 'bg-slate-200 text-slate-500'); ?>">
                                                        <i class="fas <?php echo e(in_array($app->status, ['shortlisted', 'hired', 'rejected']) ? 'fa-check' : 'fa-hourglass-half'); ?> text-xs"></i>
                                                    </div>
                                                    <div class="mt-3 text-sm font-bold <?php echo e(in_array($app->status, ['shortlisted', 'hired', 'rejected']) ? 'text-[#031b4e]' : 'text-slate-500'); ?>">
                                                        Forwarded to School
                                                    </div>
                                                    <?php if($app->is_forwarded): ?>
                                                        <div class="text-[10px] text-slate-500"><i class="fas fa-share text-[8px]"></i> Profile sent to employer</div>
                                                    <?php else: ?>
                                                        <div class="text-[10px] text-slate-400">Pending admin review</div>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Step 3: Final Decision -->
                                                <div class="relative z-10 flex flex-col items-center flex-1">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center z-10 transition-colors duration-300 <?php echo e($app->status === 'hired' ? 'bg-green-500 text-white shadow-md' : ($app->status === 'rejected' ? 'bg-red-500 text-white shadow-md' : 'bg-slate-200 text-slate-500')); ?>">
                                                        <?php if($app->status === 'hired'): ?>
                                                            <i class="fas fa-trophy text-xs"></i>
                                                        <?php elseif($app->status === 'rejected'): ?>
                                                            <i class="fas fa-times text-xs"></i>
                                                        <?php else: ?>
                                                            <i class="fas fa-question text-xs"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="mt-3 text-sm font-bold <?php echo e($app->status === 'hired' ? 'text-green-600' : ($app->status === 'rejected' ? 'text-red-600' : 'text-slate-500')); ?>">
                                                        <?php echo e($app->status === 'hired' ? 'Selected / Hired' : ($app->status === 'rejected' ? 'Not Selected' : 'Final Decision')); ?>

                                                    </div>
                                                    <div class="text-[10px] text-slate-500">
                                                        <?php echo e(in_array($app->status, ['hired', 'rejected']) ? 'Process completed' : 'Awaiting interview feedback'); ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <?php if($app->remarks): ?>
                                                <div class="mt-6 p-4 bg-blue-50/60 border border-blue-100 rounded-xl relative overflow-hidden">
                                                    <h5 class="text-xs font-bold text-[#0ea5e9] uppercase tracking-wider mb-1.5 flex items-center gap-2">
                                                        <i class="fas fa-comment-dots"></i> Update / Remarks:
                                                    </h5>
                                                    <p class="text-sm text-[#031b4e] relative z-10 leading-relaxed mb-0"><?php echo e($app->remarks); ?></p>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if($app->interview_date): ?>
                                                <div class="mt-4 p-4 bg-amber-50/60 border border-amber-200 rounded-xl">
                                                    <h5 class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                                                        <i class="fas fa-calendar-check"></i> Interview Scheduled
                                                    </h5>
                                                    <div class="text-sm text-[#031b4e] flex flex-col gap-1">
                                                        <p class="mb-0"><strong>Date & Time:</strong> <?php echo e($app->interview_date->format('l, F j, Y \a\t g:i A')); ?></p>
                                                        <?php if($app->interview_link): ?>
                                                            <p class="mb-0"><strong>Link / Location:</strong> 
                                                                <?php if(filter_var($app->interview_link, FILTER_VALIDATE_URL)): ?>
                                                                    <a href="<?php echo e($app->interview_link); ?>" target="_blank" class="text-[#0ea5e9] hover:underline"><?php echo e($app->interview_link); ?></a>
                                                                <?php else: ?>
                                                                    <?php echo e($app->interview_link); ?>

                                                                <?php endif; ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php elseif($app->status === 'shortlisted' && !$app->remarks): ?>
                                                <div class="mt-6 p-4 bg-amber-50/60 border border-amber-200 rounded-xl">
                                                    <p class="text-sm text-[#031b4e] flex items-center gap-2 mb-0">
                                                        <i class="fas fa-info-circle text-amber-600"></i>
                                                        Your profile has been forwarded to the school. The school will contact you directly to schedule an interview.
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if($applications->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($applications->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Schedule Modal -->
    <div x-data="{ open: false, schedule: {} }" 
         @open-schedule-modal.window="open = true; schedule = $event.detail"
         x-show="open" 
         style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        
        <div @click.outside="open = false" class="bg-white border border-[#031b4e]/10 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden p-5 sm:p-6 relative"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <button @click="open = false" class="absolute top-4 right-4 w-7 h-7 bg-slate-100 text-slate-500 hover:text-red-500 rounded-full flex items-center justify-center">
                <i class="fas fa-times text-xs"></i>
            </button>
            <h3 class="text-base sm:text-lg font-bold text-[#031b4e] mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-check text-amber-500 text-lg"></i> Interview Schedule
            </h3>
            <div class="space-y-3 text-xs sm:text-sm text-[#031b4e]">
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                    <p class="text-[10px] text-slate-500 mb-1 font-bold uppercase tracking-widest">Date & Time</p>
                    <p class="font-bold text-[#031b4e] mb-0" x-text="schedule.date"></p>
                </div>
                <template x-if="schedule.link">
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-[10px] text-slate-500 mb-1 font-bold uppercase tracking-widest">Link / Location</p>
                        <a :href="schedule.link" target="_blank" class="text-[#0ea5e9] font-bold hover:underline break-all" x-text="schedule.link"></a>
                    </div>
                </template>
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="open = false" class="w-full sm:w-auto px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-bold rounded-xl transition-colors">Close</button>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\warrioredu\resources\views/candidate/applications/index.blade.php ENDPATH**/ ?>