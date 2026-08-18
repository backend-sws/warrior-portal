

<?php $__env->startSection('title'); ?>
    CRM: <?php echo e($candidate->name); ?>

    <?php if($candidate->profile && $candidate->profile->is_verified): ?>
        <i class="fas fa-check-circle text-blue-500 text-base" title="Verified Candidate"></i>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('actions'); ?>
    <div class="flex flex-wrap items-center gap-2 sm:gap-4 mt-2 sm:mt-0">
        <a href="<?php echo e(route('admin.crm.index')); ?>" class="text-sm text-gray-600 hover:underline shrink-0">&larr; Back to List</a>
        
        <?php if($candidate->role === 'candidate'): ?>
        <form action="<?php echo e(route('admin.crm.candidate.verify', $candidate->id)); ?>" method="POST" class="inline">
            <?php echo csrf_field(); ?>
            <?php if($candidate->profile && $candidate->profile->is_verified): ?>
                <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 text-sm font-semibold rounded-xl hover:bg-red-200 transition-colors flex items-center shadow-sm">
                    <i class="fas fa-times-circle mr-2"></i> Remove Verification
                </button>
            <?php else: ?>
                <button type="submit" class="px-4 py-2 bg-green-100 text-green-700 text-sm font-semibold rounded-xl hover:bg-green-200 transition-colors flex items-center shadow-sm">
                    <i class="fas fa-check-circle mr-2"></i> Verify Profile
                </button>
            <?php endif; ?>
        </form>

        <a href="<?php echo e(route('admin.crm.edit', $candidate->id)); ?>" class="px-4 py-2 bg-blue-100 text-blue-700 text-sm font-semibold rounded-xl hover:bg-blue-200 transition-colors flex items-center shadow-sm">
            <i class="fas fa-edit mr-2"></i> Edit Profile
        </a>
        <?php endif; ?>
        
        <a href="<?php echo e(route('admin.crm.candidate.magic-login', $candidate->id)); ?>" target="_blank" class="px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-xl hover:bg-indigo-200 transition-colors flex items-center shadow-sm">
            <i class="fas fa-sign-in-alt mr-2"></i> <?php echo e($candidate->role === 'parent' ? 'Login as Parent' : 'Login as Candidate'); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column: Profile & Applications -->
    <div class="lg:col-span-1 space-y-6 min-w-0">
        <!-- Candidate Profile -->
        <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 mb-6 overflow-hidden">
            <!-- Banner / Header -->
            <div class="p-4 sm:p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-white flex flex-col sm:flex-row justify-between items-start relative gap-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 relative z-10 w-full">
                    <?php if($candidate->profile && $candidate->profile->profile_photo_path): ?>
                        <img src="<?php echo e(Storage::url($candidate->profile->profile_photo_path)); ?>" alt="<?php echo e($candidate->name); ?>" class="w-16 h-16 shrink-0 rounded-full object-cover shadow-sm border-4 border-white">
                    <?php elseif($candidate->profile && $candidate->profile->live_photo_path): ?>
                        <img src="<?php echo e(Storage::url($candidate->profile->live_photo_path)); ?>" alt="<?php echo e($candidate->name); ?>" class="w-16 h-16 shrink-0 rounded-full object-cover shadow-sm border-4 border-white">
                    <?php else: ?>
                        <div class="w-16 h-16 shrink-0 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-extrabold shadow-sm border-4 border-white">
                            <?php echo e(strtoupper(substr($candidate->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                    <div class="min-w-0">
                        <h3 class="text-xl font-extrabold text-gray-900 break-words"><?php echo e($candidate->name); ?></h3>
                        <div class="text-xs text-gray-500 mt-1.5 flex flex-wrap items-center gap-1.5 sm:gap-4">
                            <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-gray-400"></i> <?php echo e($candidate->email); ?></span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-phone-alt text-gray-400"></i> <?php echo e($candidate->phone); ?></span>
                            <?php if($candidate->profile && $candidate->profile->latitude && $candidate->profile->longitude): ?>
                                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e($candidate->profile->latitude); ?>,<?php echo e($candidate->profile->longitude); ?>" target="_blank" class="flex items-center gap-1.5 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i> <?php echo e($candidate->profile->latitude); ?>, <?php echo e($candidate->profile->longitude); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <?php if($candidate->profile): ?>
                    <!-- Personal Info -->
                    <div class="mb-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Personal Details</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Gender</div>
                                <div class="text-sm font-medium text-gray-800"><?php echo e($candidate->profile->gender ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Date of Birth</div>
                                <div class="text-sm font-medium text-gray-800"><?php echo e($candidate->profile->date_of_birth ? $candidate->profile->date_of_birth->format('M d, Y') : 'N/A'); ?></div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100 col-span-2">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Address</div>
                                <div class="text-sm font-medium text-gray-800"><?php echo e($candidate->profile->address ?? 'N/A'); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Info -->
                    <div class="mb-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Professional Details</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-50">
                                <div class="text-[10px] text-blue-400 uppercase font-bold mb-0.5 flex items-center gap-1"><i class="fas fa-folder"></i> Category</div>
                                <div class="text-sm font-bold text-blue-900"><?php echo e($candidate->profile->category?->name ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-50">
                                <div class="text-[10px] text-blue-400 uppercase font-bold mb-0.5 flex items-center gap-1"><i class="fas fa-book"></i> Subject</div>
                                <div class="text-sm font-bold text-blue-900"><?php echo e($candidate->profile->subject?->name ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-orange-50/50 p-3 rounded-xl border border-orange-50">
                                <div class="text-[10px] text-orange-400 uppercase font-bold mb-0.5 flex items-center gap-1"><i class="fas fa-graduation-cap"></i> Qualification</div>
                                <div class="text-sm font-bold text-orange-900"><?php echo e($candidate->profile->highestQualification?->name ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-emerald-50/50 p-3 rounded-xl border border-emerald-50">
                                <div class="text-[10px] text-emerald-500 uppercase font-bold mb-0.5 flex items-center gap-1"><i class="fas fa-briefcase"></i> Experience</div>
                                <div class="text-sm font-bold text-emerald-900"><?php echo e($candidate->profile->experience_years ?? 0); ?> Years</div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Current Salary</div>
                                <div class="text-sm font-medium text-gray-800"><?php echo e($candidate->profile->current_salary ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Expected Salary</div>
                                <div class="text-sm font-medium text-gray-800"><?php echo e($candidate->profile->expected_salary ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100 col-span-2">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5 flex items-center gap-1"><i class="fas fa-map-marker-alt"></i> Preferred Location</div>
                                <div class="text-sm font-medium text-gray-800"><?php echo e($candidate->profile->preferredCity?->name ?? 'N/A'); ?>, <?php echo e($candidate->profile->preferredState?->name ?? 'N/A'); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Plan & Transactions -->
                    <div class="mb-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Plan & Transaction</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-1">Status</div>
                                <?php if($candidate->profile->is_fee_paid): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1 text-[10px]"></i> Active</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1 text-[10px]"></i> Pending</span>
                                <?php endif; ?>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100">
                                <div class="text-[10px] text-gray-400 uppercase font-bold mb-1">Plan Details</div>
                                <div class="text-sm font-bold text-gray-800"><?php echo e($candidate->profile->plan_type ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-gray-50/80 p-3 rounded-xl border border-gray-100 col-span-2 flex justify-between items-center">
                                <div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Transaction ID</div>
                                    <div class="font-mono text-xs font-bold text-gray-600"><?php echo e($candidate->profile->payment_id ?? 'No Transaction'); ?></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] text-gray-400 uppercase font-bold mb-0.5">Paid On</div>
                                    <div class="text-xs font-medium text-gray-600"><?php echo e($candidate->profile->registration_completed_at ? $candidate->profile->registration_completed_at->format('M d, Y') : 'N/A'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="mb-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Documents</h4>
                        <div class="flex flex-wrap gap-2">
                            <?php if($candidate->profile->resume_path): ?>
                                <a href="<?php echo e(Storage::url($candidate->profile->resume_path)); ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition-colors">
                                    <i class="fas fa-file-pdf"></i> Resume
                                </a>
                            <?php endif; ?>
                            <?php if($candidate->profile->salary_slip_path): ?>
                                <a href="<?php echo e(Storage::url($candidate->profile->salary_slip_path)); ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition-colors">
                                    <i class="fas fa-file-invoice-dollar"></i> Salary Slip
                                </a>
                            <?php endif; ?>
                            <?php if($candidate->profile->offer_letter_path): ?>
                                <a href="<?php echo e(Storage::url($candidate->profile->offer_letter_path)); ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-purple-50 hover:bg-purple-100 border border-purple-100 text-purple-700 rounded-lg text-xs font-bold transition-colors">
                                    <i class="fas fa-file-contract"></i> Offer Letter
                                </a>
                            <?php endif; ?>
                            <?php if($candidate->profile->profile_photo_path): ?>
                                <a href="<?php echo e(Storage::url($candidate->profile->profile_photo_path)); ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-amber-50 hover:bg-amber-100 border border-amber-100 text-amber-700 rounded-lg text-xs font-bold transition-colors">
                                    <i class="fas fa-image"></i> Profile Photo
                                </a>
                            <?php endif; ?>
                            <?php if($candidate->profile->live_photo_path): ?>
                                <a href="<?php echo e(Storage::url($candidate->profile->live_photo_path)); ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-rose-50 hover:bg-rose-100 border border-rose-100 text-rose-700 rounded-lg text-xs font-bold transition-colors">
                                    <i class="fas fa-camera"></i> Live Photo
                                </a>
                            <?php endif; ?>
                             <?php if($candidate->profile->agreement_pdf_path): ?>
                                 <a href="<?php echo e(Storage::url($candidate->profile->agreement_pdf_path)); ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-teal-50 hover:bg-teal-100 border border-teal-100 text-teal-700 rounded-lg text-xs font-bold transition-colors">
                                     <i class="fas fa-file-signature"></i> Signed Agreement (PDF)
                                 </a>
                             <?php elseif($candidate->profile->is_agreement_signed): ?>
                                 <span class="inline-flex items-center gap-2 px-3 py-2 bg-teal-50 border border-teal-100 text-teal-700 rounded-lg text-xs font-bold">
                                     <i class="fas fa-file-signature"></i> Signed Digitally (<?php echo e($candidate->profile->signature_date_time ? $candidate->profile->signature_date_time->format('d M, Y') : 'Active'); ?>)
                                 </span>
                             <?php endif; ?>
                        </div>
                    </div>

                    <!-- Manual Agreement Upload -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Agreement Status</h4>
                            <?php if($candidate->profile->agreement_status === 'signed' || $candidate->profile->is_agreement_signed || $candidate->profile->agreement_pdf_path || $candidate->profile->signature_date_time): ?>
                                <?php if($candidate->profile->agreement_pdf_path): ?>
                                    <a href="<?php echo e(Storage::url($candidate->profile->agreement_pdf_path)); ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200 hover:bg-green-100 transition-colors">
                                        <i class="fas fa-check-circle"></i> Signed & Valid (PDF)
                                    </a>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                        <i class="fas fa-check-circle"></i> Signed (Digitally)
                                    </span>
                                <?php endif; ?>
                            <?php elseif($candidate->profile->agreement_status === 'pending_signature'): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-bold border border-amber-200">
                                    <i class="fas fa-hourglass-half"></i> Pending Signature
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-700 rounded-full text-xs font-bold border border-gray-200">
                                    <i class="fas fa-ban"></i> Not Required
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Update Agreement Status Form -->
                        <form action="<?php echo e(route('admin.crm.candidate.update-agreement-status', $candidate->id)); ?>" method="POST" class="mb-4 bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                            <?php echo csrf_field(); ?>
                            <label class="block text-xs font-bold text-gray-700">Change Status:</label>
                            <div class="flex items-center gap-2">
                                <select name="agreement_status" class="text-xs bg-gray-50 border-gray-200 rounded-lg py-1.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="not_required" <?php echo e($candidate->profile->agreement_status === 'not_required' ? 'selected' : ''); ?>>Not Required</option>
                                    <option value="pending_signature" <?php echo e($candidate->profile->agreement_status === 'pending_signature' ? 'selected' : ''); ?>>Pending Signature</option>
                                    <option value="signed" <?php echo e($candidate->profile->agreement_status === 'signed' ? 'selected' : ''); ?>>Signed</option>
                                </select>
                                <button type="submit" class="px-3 py-1.5 bg-gray-800 text-white rounded-lg text-xs font-bold hover:bg-gray-700 transition-colors">
                                    Update
                                </button>
                            </div>
                        </form>

                        <form action="<?php echo e(route('admin.crm.candidate.update-agreement-status', $candidate->id)); ?>" method="POST" class="bg-gray-50 p-4 rounded-xl border border-gray-200 shadow-sm mb-4">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="agreement_status" value="pending_signature">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Generate & Send Standard Agreement</label>
                            <p class="text-[10px] text-gray-500 mb-3">Proceed to send the standard formatted agreement. The candidate will see it in their portal to sign.</p>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="submit" class="shrink-0 px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700 transition-colors shadow-sm flex items-center gap-2">
                                    <i class="fas fa-paper-plane"></i> Proceed & Send to Candidate
                                </button>
                            </div>
                        </form>

                        <form action="<?php echo e(route('admin.crm.candidate.upload-agreement', $candidate->id)); ?>" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                            <?php echo csrf_field(); ?>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Or Manually Upload Custom Agreement (PDF)</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="file" name="agreement_pdf" accept="application/pdf" required class="flex-1 block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                                <button type="submit" class="shrink-0 px-4 py-2 bg-gray-800 text-white rounded-lg text-xs font-bold hover:bg-gray-900 transition-colors shadow-sm">
                                    Upload & Send
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Verification -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <form action="<?php echo e(route('admin.crm.candidate.verify', $candidate->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-4 py-3 <?php echo e($candidate->profile->is_verified ? 'bg-red-50 text-red-600 border border-red-200 hover:bg-red-100' : 'bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100'); ?> rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                                <?php if($candidate->profile->is_verified): ?>
                                    <i class="fas fa-times-circle"></i> Revoke Verification Badge
                                <?php else: ?>
                                    <i class="fas fa-check-circle"></i> Verify & Award Badge
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>
                <?php elseif($candidate->role === 'candidate'): ?>
                    <div class="py-10 flex flex-col items-center justify-center text-gray-500">
                        <i class="fas fa-user-slash text-4xl mb-3 text-gray-300"></i>
                        <p class="font-medium text-sm">No profile data available yet.</p>
                        <p class="text-xs text-gray-400 mt-1">Candidate has not completed their profile setup.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Job Applications -->
        <?php if($candidate->role === 'candidate'): ?>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col gap-3 mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Job Applications</h3>
                    <form action="<?php echo e(route('admin.crm.application.assign', $candidate->id)); ?>" method="POST" class="flex flex-col gap-2 w-full">
                        <?php echo csrf_field(); ?>
                        <select name="job_post_id" required class="text-sm rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full">
                            <option value="">-- Assign a Job to Candidate --</option>
                            <?php $__currentLoopData = $availableJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($job->id); ?>"><?php echo e($job->title); ?> (<?php echo e($job->school_name); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="px-3 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm w-full text-center">Assign Job</button>
                    </form>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = $candidate->applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                        <div class="font-semibold text-gray-800"><?php echo e($app->jobPost->title); ?></div>
                        <div class="text-xs text-gray-500 mb-1"><?php echo e($app->jobPost->school_name); ?></div>
                            <div class="mt-3">
                                <form action="<?php echo e(route('admin.applications.status.update', $app->id)); ?>" method="POST" class="space-y-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                        <label class="text-xs font-bold text-gray-700 shrink-0">Status:</label>
                                        <select name="status" class="text-xs font-bold px-2 py-1.5 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer w-full">
                                            <option value="applied" <?php echo e($app->status === 'applied' ? 'selected' : ''); ?>>Applied</option>
                                            <option value="shortlisted" <?php echo e($app->status === 'shortlisted' ? 'selected' : ''); ?>>Shortlisted (Schedule Interview)</option>
                                            <option value="hired" <?php echo e($app->status === 'hired' ? 'selected' : ''); ?>>Hired</option>
                                            <option value="rejected" <?php echo e($app->status === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                                        </select>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Interview Date (If Shortlisted)</label>
                                            <input type="datetime-local" name="interview_date" value="<?php echo e($app->interview_date); ?>" class="w-full text-xs rounded-lg border-gray-300 shadow-sm px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Interview Link / Location</label>
                                            <input type="text" name="interview_link" value="<?php echo e($app->interview_link); ?>" placeholder="e.g. Zoom Link or Address" class="w-full text-xs rounded-lg border-gray-300 shadow-sm px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Remarks (Visible to Candidate)</label>
                                        <textarea name="remarks" rows="2" class="w-full text-xs rounded-lg border-gray-300 shadow-sm px-2 py-1.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Add feedback or updates here..."><?php echo e($app->remarks); ?></textarea>
                                    </div>

                                    <div class="flex flex-col sm:flex-row justify-end gap-2 sm:items-center w-full">
                                        <?php if($app->status === 'hired'): ?>
                                            <?php if(!$app->invoice): ?>
                                                <button type="button" onclick="prepareInvoice(<?php echo e($app->id); ?>)" class="w-full sm:w-auto text-xs px-3 py-2 sm:py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 font-bold transition-colors shadow-sm text-center">
                                                    <i class="fas fa-file-invoice-dollar mr-1"></i> Generate Invoice
                                                </button>
                                            <?php else: ?>
                                                <span class="w-full sm:w-auto text-center text-xs px-3 py-2 sm:py-1.5 bg-gray-100 text-green-700 font-bold rounded-lg border border-green-200">
                                                    <i class="fas fa-check-circle mr-1"></i> Invoiced
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <button type="submit" class="w-full sm:w-auto text-center text-xs px-4 py-2 sm:py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold transition-colors shadow-sm whitespace-nowrap">
                                            Save Updates
                                        </button>
                                    </div>
                                </form>
                            </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-sm text-gray-500">No applications found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Candidate Rating System -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Admin Ratings</h3>
                    <?php if($rating): ?>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded"><i class="fas fa-star text-yellow-500 mr-1"></i> <?php echo e(number_format($rating->overall_rating, 1)); ?> Overall</span>
                    <?php endif; ?>
                </div>

                <form action="<?php echo e(route('admin.crm.candidate.rate', $candidate->id)); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php
                        $params = [
                            'communication' => 'Communication Skills',
                            'subject_knowledge' => 'Subject Knowledge',
                            'demo_performance' => 'Demo Performance',
                            'english_fluency' => 'English Fluency',
                            'discipline' => 'Professionalism & Discipline'
                        ];
                    ?>

                    <?php $__currentLoopData = $params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700"><?php echo e($label); ?></label>
                        <select name="<?php echo e($key); ?>" class="rounded-md border-gray-300 shadow-sm text-sm p-1 w-24">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(($rating && $rating->$key == $i) ? 'selected' : ($i==3 ? 'selected' : '')); ?>><?php echo e($i); ?> Stars</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea name="remarks" rows="2" class="w-full rounded-md border-gray-300 shadow-sm text-sm"><?php echo e($rating->remarks ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded text-sm font-bold hover:bg-gray-900 transition-colors">
                        Save Ratings
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: CRM Follow-ups & Invoices -->
    <div class="lg:col-span-2 space-y-6 min-w-0">
        
        <!-- Alerts -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Parent Tuitions or Service Charge Invoices -->
        <?php if($candidate->role === 'parent'): ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Home Tuition Requirements</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-bold">Class & Subjects</th>
                                    <th class="px-4 py-3 font-bold">Location</th>
                                    <th class="px-4 py-3 font-bold">Status</th>
                                    <th class="px-4 py-3 font-bold">Date Posted</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php $__empty_1 = true; $__currentLoopData = $tuitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-gray-900"><?php echo e($tuition->class); ?></div>
                                            <div class="text-gray-500 text-xs"><?php echo e($tuition->subjects); ?></div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600"><?php echo e($tuition->location); ?></td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                <?php echo e($tuition->status === 'Confirmed' ? 'bg-green-100 text-green-700' : ''); ?>

                                                <?php echo e(in_array($tuition->status, ['New Lead', 'Pending']) ? 'bg-yellow-100 text-yellow-700' : ''); ?>

                                                <?php echo e(in_array($tuition->status, ['Demo Scheduled', 'Demo Completed']) ? 'bg-blue-100 text-blue-700' : ''); ?>

                                                <?php echo e($tuition->status === 'Cancelled' ? 'bg-red-100 text-red-700' : ''); ?>

                                            ">
                                                <?php echo e($tuition->status); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-500"><?php echo e($tuition->created_at->format('M d, Y')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                            No tuition requirements posted yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Service Charge Invoices</h3>
                </div>

                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="py-2 px-4 text-left font-medium">Job Role</th>
                                <th class="py-2 px-4 text-left font-medium">Amount</th>
                                <th class="py-2 px-4 text-left font-medium">Late Fee</th>
                                <th class="py-2 px-4 text-left font-medium">Due Date</th>
                                <th class="py-2 px-4 text-left font-medium">Status</th>
                                <th class="py-2 px-4 text-left font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="py-2 px-4"><?php echo e($invoice->jobApplication->jobPost->title); ?></td>
                                <td class="py-2 px-4">₹<?php echo e(number_format($invoice->amount, 2)); ?></td>
                                <td class="py-2 px-4 text-red-600">₹<?php echo e(number_format($invoice->late_fee, 2)); ?></td>
                                <td class="py-2 px-4"><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('M d, Y')); ?></td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        <?php echo e($invoice->status === 'paid' ? 'bg-green-100 text-green-800' : ($invoice->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                        <?php echo e(ucfirst($invoice->status)); ?>

                                    </span>
                                </td>
                                <td class="py-2 px-4 space-y-2">
                                    <?php if($invoice->status !== 'paid'): ?>
                                    <form action="<?php echo e(route('admin.crm.invoice.update', $invoice->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="text-xs text-green-600 hover:text-green-900 font-bold" onclick="return confirm('Mark this invoice as Paid?')">Mark Paid</button>
                                    </form>
                                    
                                    <?php if($invoice->late_fee > 0): ?>
                                    <div class="mt-2 border-t border-gray-100 pt-2">
                                        <form action="<?php echo e(route('admin.crm.invoice.adjust', $invoice->id)); ?>" method="POST" class="flex items-center gap-2">
                                            <?php echo csrf_field(); ?>
                                            <input type="number" name="deduction" max="<?php echo e($invoice->late_fee); ?>" min="1" required placeholder="Amt" class="w-16 rounded-md border-gray-300 shadow-sm text-xs py-1 px-2 focus:ring-blue-500 focus:border-blue-500">
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-900 font-bold bg-blue-50 px-2 py-1 rounded">Waive</button>
                                        </form>
                                    </div>
                                    <?php endif; ?>

                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">Settled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">No invoices generated yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Generate Invoice Form -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mt-4">
                    <h4 class="font-bold text-sm text-gray-800 mb-3">Generate New Invoice</h4>
                    <form action="<?php echo e(route('admin.crm.invoice.store', $candidate->id)); ?>" method="POST" class="flex flex-wrap gap-4 items-end">
                        <?php echo csrf_field(); ?>
                        
                        <?php if($errors->any()): ?>
                            <div class="w-full bg-red-100 text-red-700 p-2 rounded text-xs mb-2">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="w-full md:w-auto flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Select Hired Job Application</label>
                            <select name="job_application_id" id="job_application_id" class="w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Select Application --</option>
                                <?php $__currentLoopData = $candidate->applications->where('status', 'hired'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($app->id); ?>"><?php echo e($app->jobPost->title); ?> (<?php echo e($app->jobPost->school_name); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="w-24">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Amount (₹)</label>
                            <input type="number" name="amount" class="w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500" required min="0">
                        </div>
                        <div class="w-36">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Due Date</label>
                            <input type="date" name="due_date" class="w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Follow-ups -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Follow-ups & Notes</h3>
                
                <!-- Add Follow-up Form -->
                <form action="<?php echo e(route('admin.crm.followup.store', $candidate->id)); ?>" method="POST" class="mb-6 bg-gray-50 p-4 rounded border border-gray-200">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes / Call Summary</label>
                        <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500" required placeholder="What was discussed?"></textarea>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Next Follow-up Date</label>
                            <input type="date" name="follow_up_date" class="w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm text-sm py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500">
                                <option value="open">Open (Needs Action)</option>
                                <option value="closed">Closed (Resolved)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                            Add Follow-up
                        </button>
                    </div>
                </form>

                <!-- Follow-up History -->
                <div class="space-y-4">
                    <h4 class="font-bold text-sm text-gray-600 uppercase tracking-wider mb-2">History</h4>
                    <?php $__empty_1 = true; $__currentLoopData = $followUps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border-l-4 <?php echo e($fu->status === 'open' ? 'border-yellow-400' : 'border-green-400'); ?> pl-4 py-2">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-xs font-bold text-gray-500"><?php echo e($fu->admin->name); ?> &bull; <?php echo e($fu->created_at->format('M d, Y h:i A')); ?></span>
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded <?php echo e($fu->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'); ?>"><?php echo e($fu->status); ?></span>
                            </div>
                            <p class="text-sm text-gray-800"><?php echo e($fu->notes); ?></p>
                            <?php if($fu->follow_up_date): ?>
                                <div class="mt-2 text-xs text-indigo-600 font-medium">
                                    <i class="fas fa-calendar-alt mr-1"></i> Next Follow-up: <?php echo e(\Carbon\Carbon::parse($fu->follow_up_date)->format('M d, Y')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500 italic">No follow-ups recorded yet.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- History Timeline -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Audit Trail / History</h3>
                
                <div class="relative border-l-2 border-gray-200 ml-4 space-y-8">
                    <?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="relative pl-6">
                            <!-- Timeline Dot -->
                            <div class="absolute -left-3.5 top-0 w-7 h-7 rounded-full <?php echo e($event['color']); ?> text-white flex items-center justify-center text-xs shadow-md border-2 border-white">
                                <i class="<?php echo e($event['icon']); ?>"></i>
                            </div>
                            
                            <!-- Content -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-gray-800 text-sm"><?php echo e($event['title']); ?></h4>
                                    <span class="text-xs text-gray-500 font-medium"><?php echo e(\Carbon\Carbon::parse($event['date'])->format('M d, Y h:i A')); ?></span>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed"><?php echo e($event['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="pl-6 text-sm text-gray-500 italic">No history found for this candidate.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function prepareInvoice(appId) {
        const select = document.getElementById('job_application_id');
        if(select) {
            select.value = appId;
            select.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Highlight the form momentarily
            const formContainer = select.closest('.bg-gray-50');
            if(formContainer) {
                formContainer.classList.add('ring-2', 'ring-indigo-500', 'transition-all', 'duration-500');
                setTimeout(() => formContainer.classList.remove('ring-2', 'ring-indigo-500'), 1500);
            }

            // Focus on amount
            const amountInput = document.querySelector('input[name="amount"]');
            if(amountInput) {
                amountInput.focus();
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\warriors portal\warriors portal\resources\views/admin/crm/show.blade.php ENDPATH**/ ?>