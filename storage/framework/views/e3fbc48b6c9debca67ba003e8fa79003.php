<?php $__env->startSection('content'); ?>
<?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <div class="flex items-center gap-4 mb-8 reveal">
        <?php if($profile->profile_photo_path): ?>
            <img src="<?php echo e(asset('storage/' . $profile->profile_photo_path)); ?>" alt="Profile Photo" class="w-16 h-16 rounded-full object-cover border-2 border-[#0ea5e9] shadow-lg">
        <?php else: ?>
            <div class="w-16 h-16 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-3xl shadow-inner">
                <i class="fas fa-user"></i>
            </div>
        <?php endif; ?>
        <div>
            <h1 class="text-2xl font-bold text-[#031b4e] flex items-center gap-2">
                My Profile
                <?php if($profile->is_verified): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-500/20 border border-blue-400/50 text-blue-300 text-[10px] font-bold uppercase tracking-wider rounded-full" title="Verified Profile">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                <?php endif; ?>
            </h1>
            <p class="text-sm text-[#031b4e]/60 mt-0.5">Manage your personal and professional details.</p>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-500/10 border border-green-500/30 p-4 rounded-xl flex items-center gap-3 reveal">
            <i class="fas fa-check-circle text-green-400"></i>
            <span class="text-sm text-green-400 font-medium"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-6 bg-red-500/10 border border-red-500/30 p-4 rounded-xl reveal">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                <div>
                    <p class="text-sm font-semibold text-red-400 mb-1">Please correct the following errors:</p>
                    <ul class="text-sm text-red-300/80 list-disc pl-4 space-y-0.5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl reveal reveal-delay-1">
        <form action="<?php echo e(route('candidate.profile.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            
            <div class="p-6 md:p-8 border-b border-[#031b4e]/10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xs font-bold">1</span>
                    <h3 class="text-lg font-bold text-[#031b4e]">Personal Information</h3>
                </div>

                <div class="mb-8 flex items-center gap-6">
                    <div class="relative group">
                        <?php if($profile->profile_photo_path): ?>
                            <img src="<?php echo e(asset('storage/' . $profile->profile_photo_path)); ?>" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover border-4 border-secondary-bg shadow-xl">
                        <?php else: ?>
                            <div class="w-24 h-24 rounded-full bg-[#f4f7f5] flex items-center justify-center text-4xl text-[#031b4e]/50 border-4 border-secondary-bg shadow-inner">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Update Profile Photo</label>
                        <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-2.5 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0ea5e9]/10 file:text-[#0ea5e9] hover:file:bg-[#0ea5e9]/20">
                        <p class="text-[11px] text-[#031b4e]/60 mt-1.5"><i class="fas fa-info-circle mr-1"></i> JPG, PNG, WEBP. Max size: 2MB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Full Name</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/50"><i class="fas fa-user text-sm"></i></span>
                            <input type="text" value="<?php echo e($user->name); ?>" disabled class="w-full bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e]/60 cursor-not-allowed">
                        </div>
                        <p class="text-[11px] text-[#031b4e]/50 mt-1.5"><i class="fas fa-lock text-[9px] mr-1"></i>Cannot be changed after registration</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/50"><i class="fas fa-envelope text-sm"></i></span>
                            <input type="email" value="<?php echo e($user->email); ?>" disabled class="w-full bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e]/60 cursor-not-allowed">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Phone Number</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/50"><i class="fas fa-phone-alt text-sm"></i></span>
                            <input type="text" value="<?php echo e($user->phone); ?>" disabled class="w-full bg-[#f4f7f5]/50 border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e]/60 cursor-not-allowed">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Date of Birth <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-calendar-alt text-sm"></i></span>
                            <input type="date" name="date_of_birth" required value="<?php echo e(old('date_of_birth', $profile->date_of_birth?->format('Y-m-d'))); ?>"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Gender <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-venus-mars text-sm"></i></span>
                            <select name="gender" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo e(old('gender', $profile->gender) == 'Male' ? 'selected' : ''); ?>>Male</option>
                                <option value="Female" <?php echo e(old('gender', $profile->gender) == 'Female' ? 'selected' : ''); ?>>Female</option>
                                <option value="Other" <?php echo e(old('gender', $profile->gender) == 'Other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Full Address <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-[#031b4e]/60"><i class="fas fa-map-marker-alt text-sm"></i></span>
                            <textarea name="address" required rows="3" class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all resize-none"><?php echo e(old('address', $profile->address)); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="p-6 md:p-8 border-b border-[#031b4e]/10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-lg bg-accent-yellow/10 text-accent-yellow flex items-center justify-center text-xs font-bold">2</span>
                    <h3 class="text-lg font-bold text-[#031b4e]">Professional & Educational Details</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Highest Qualification <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-graduation-cap text-sm"></i></span>
                            <select name="highest_qualification_id" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select Qualification</option>
                                <?php $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($qualification->id); ?>" <?php echo e(old('highest_qualification_id', $profile->highest_qualification_id) == $qualification->id ? 'selected' : ''); ?>><?php echo e($qualification->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Job Category <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-th-large text-sm"></i></span>
                            <select name="category_id" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $profile->category_id) == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Subject Specialization <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-book text-sm"></i></span>
                            <select name="subject_id" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select Subject</option>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subject->id); ?>" <?php echo e(old('subject_id', $profile->subject_id) == $subject->id ? 'selected' : ''); ?>><?php echo e($subject->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Preferred State <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-map text-sm"></i></span>
                            <select name="preferred_state_id" id="preferred_state_id" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select State</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->id); ?>" <?php echo e(old('preferred_state_id', $profile->preferred_state_id) == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Preferred City <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-city text-sm"></i></span>
                            <select name="preferred_city_id" id="preferred_city_id" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select City</option>
                                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($city->id); ?>" <?php echo e(old('preferred_city_id', $profile->preferred_city_id) == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Experience (Years) <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-briefcase text-sm"></i></span>
                            <input type="number" name="experience_years" min="0" required value="<?php echo e(old('experience_years', $profile->experience_years)); ?>"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all"
                                placeholder="e.g. 3">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Upload Resume <span class="text-[#031b4e]/50 text-[10px] normal-case">(PDF, DOC)</span></label>
                        <div class="relative">
                            <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl px-4 py-2.5 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0ea5e9]/10 file:text-[#0ea5e9] hover:file:bg-[#0ea5e9]/20">
                        </div>
                        <?php if($profile->resume_path): ?>
                            <p class="text-[11px] text-green-400 mt-1.5 flex items-center gap-1"><i class="fas fa-check-circle"></i> Resume uploaded. Select new file to replace.</p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Current Salary <span class="text-[#031b4e]/50 text-[10px] normal-case">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-rupee-sign text-sm"></i></span>
                            <input type="text" name="current_salary" value="<?php echo e(old('current_salary', $profile->current_salary)); ?>" placeholder="e.g. 25,000 / month"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] placeholder-text-dark/30 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Expected Salary <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-rupee-sign text-sm"></i></span>
                            <input type="text" name="expected_salary" required value="<?php echo e(old('expected_salary', $profile->expected_salary)); ?>" placeholder="e.g. 35,000 / month"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] placeholder-text-dark/30 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Current School/Organization <span class="text-[#031b4e]/50 text-[10px] normal-case">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-building text-sm"></i></span>
                            <input type="text" name="current_school" value="<?php echo e(old('current_school', $profile->current_school)); ?>" placeholder="e.g. XYZ Public School"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] placeholder-text-dark/30 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">English Fluency</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-language text-sm"></i></span>
                            <select name="english_fluency" class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select Fluency</option>
                                <option value="beginner" <?php echo e(old('english_fluency', $profile->english_fluency) == 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                                <option value="intermediate" <?php echo e(old('english_fluency', $profile->english_fluency) == 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                                <option value="fluent" <?php echo e(old('english_fluency', $profile->english_fluency) == 'fluent' ? 'selected' : ''); ?>>Fluent/Native</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Residential Preference</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-home text-sm"></i></span>
                            <select name="residential_preference" class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all appearance-none">
                                <option value="">Select Preference</option>
                                <option value="residential" <?php echo e(old('residential_preference', $profile->residential_preference) == 'residential' ? 'selected' : ''); ?>>Residential (Need Accommodation)</option>
                                <option value="day" <?php echo e(old('residential_preference', $profile->residential_preference) == 'day' ? 'selected' : ''); ?>>Day Boarding (No Accommodation)</option>
                                <option value="both" <?php echo e(old('residential_preference', $profile->residential_preference) == 'both' ? 'selected' : ''); ?>>Open to Both</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Availability to Join</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-clock text-sm"></i></span>
                            <input type="text" name="availability_to_join" value="<?php echo e(old('availability_to_join', $profile->availability_to_join)); ?>" placeholder="e.g. Immediate, 1 Month"
                                class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] placeholder-text-dark/30 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all">
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="p-6 md:p-8 bg-[#f4f7f5]/30 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-[#031b4e]/60"><i class="fas fa-info-circle mr-1"></i> Fields marked with <span class="text-red-400">*</span> are required</p>
                <button type="submit" class="px-8 py-3 bg-[#0ea5e9] text-white font-semibold rounded-xl hover:bg-[#0ea5e9]-hover hover:-translate-y-0.5 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Profile
                </button>
            </div>
        </form>
    </div>

    
    <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl mt-8 reveal reveal-delay-2">
        <form action="<?php echo e(route('candidate.password.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center text-xs"><i class="fas fa-lock"></i></span>
                    <h3 class="text-lg font-bold text-[#031b4e]">Change Password</h3>
                </div>

                <?php if(session('password_success')): ?>
                    <div class="mb-5 bg-green-500/10 border border-green-500/30 p-4 rounded-xl flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-400"></i>
                        <span class="text-sm text-green-400 font-medium"><?php echo e(session('password_success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(session('password_error')): ?>
                    <div class="mb-5 bg-red-500/10 border border-red-500/30 p-4 rounded-xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                        <span class="text-sm text-red-400 font-medium"><?php echo e(session('password_error')); ?></span>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Current Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-key text-sm"></i></span>
                            <input type="password" name="current_password" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all" placeholder="••••••••">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">New Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-lock text-sm"></i></span>
                            <input type="password" name="new_password" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all" placeholder="••••••••">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#031b4e]/70 mb-2 uppercase tracking-wider">Confirm New Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#031b4e]/60"><i class="fas fa-shield-alt text-sm"></i></span>
                            <input type="password" name="new_password_confirmation" required class="w-full bg-[#f4f7f5] border border-[#031b4e]/10 rounded-xl pl-11 pr-4 py-3 text-sm text-[#031b4e] focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/50 focus:border-[#0ea5e9] transition-all" placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 md:px-8 pb-6 md:pb-8 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-red-500/10 text-red-400 border border-red-500/20 font-semibold rounded-xl hover:bg-red-500/20 transition-all flex items-center gap-2">
                    <i class="fas fa-key text-xs"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('preferred_state_id').addEventListener('change', function() {
        let stateId = this.value;
        let citySelect = document.getElementById('preferred_city_id');
        citySelect.innerHTML = '<option value="">Loading...</option>';
        
        if(stateId) {
            fetch(`/api/states/${stateId}/cities`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">Select City</option>';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                    citySelect.innerHTML = '<option value="">Select City</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">Select City</option>';
        }
    });
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\warrioredu\resources\views/candidate/profile/edit.blade.php ENDPATH**/ ?>