<?php $__env->startSection('content'); ?>
<div class="min-h-[85vh] flex items-center justify-center bg-[#f4f7f5] py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden reveal">

        
        <div class="hidden lg:flex flex-col justify-between relative bg-[#031b4e] p-10 overflow-hidden">
            
            <style>
                .arc-reactor {
                    width: 400px;
                    height: 400px;
                    border-radius: 50%;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%) scale(1.2);
                    opacity: 0.15;
                    box-shadow: 0 0 50px 10px rgba(14, 165, 233, 0.5), inset 0 0 50px 10px rgba(14, 165, 233, 0.5);
                    background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, transparent 70%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: pulse-arc 4s infinite alternate;
                    pointer-events: none;
                    z-index: 0;
                }
                @keyframes pulse-arc {
                    0% { box-shadow: 0 0 40px 5px rgba(14, 165, 233, 0.4), inset 0 0 40px 5px rgba(14, 165, 233, 0.4); opacity: 0.12; }
                    100% { box-shadow: 0 0 60px 15px rgba(14, 165, 233, 0.8), inset 0 0 60px 15px rgba(14, 165, 233, 0.8); opacity: 0.25; }
                }
                .arc-segments {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    background: repeating-conic-gradient(
                        from 0deg,
                        transparent 0deg 15deg,
                        #0ea5e9 15deg 30deg
                    );
                    -webkit-mask-image: radial-gradient(transparent 65%, black 66%, black 85%, transparent 86%);
                    mask-image: radial-gradient(transparent 65%, black 66%, black 85%, transparent 86%);
                    animation: spin-arc 30s linear infinite;
                    box-shadow: 0 0 20px #0ea5e9;
                }
                .arc-ring {
                    position: absolute;
                    width: 90%;
                    height: 90%;
                    border-radius: 50%;
                    border: 12px solid transparent;
                    border-top-color: #0ea5e9;
                    border-bottom-color: #0ea5e9;
                    animation: spin-arc 15s linear infinite;
                    box-shadow: 0 0 15px #0ea5e9;
                }
                .arc-ring-2 {
                    position: absolute;
                    width: 65%;
                    height: 65%;
                    border-radius: 50%;
                    border: 6px dashed rgba(255,255,255,0.8);
                    box-shadow: 0 0 20px #0ea5e9, inset 0 0 20px #0ea5e9;
                    animation: spin-arc-reverse 20s linear infinite;
                }
                .arc-core {
                    position: absolute;
                    width: 35%;
                    height: 35%;
                    border-radius: 50%;
                    background: #fff;
                    box-shadow: 0 0 50px 20px #0ea5e9, 0 0 100px 30px #fff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: core-pulse 2s infinite alternate;
                }
                .arc-triangle {
                    width: 0; 
                    height: 0; 
                    border-left: 25px solid transparent;
                    border-right: 25px solid transparent;
                    border-top: 45px solid #031b4e;
                    position: relative;
                    z-index: 10;
                }
                @keyframes spin-arc { 100% { transform: rotate(360deg); } }
                @keyframes spin-arc-reverse { 100% { transform: rotate(-360deg); } }
                @keyframes core-pulse {
                    0% { transform: scale(0.95); opacity: 0.9; }
                    100% { transform: scale(1.05); opacity: 1; }
                }
            </style>
            
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-[#0ea5e9]/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="arc-reactor">
                <div class="arc-segments"></div>
                <div class="arc-ring"></div>
                <div class="arc-ring-2"></div>
                <div class="arc-core">
                    <div class="arc-triangle"></div>
                </div>
            </div>

            <div class="relative z-10">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('adobe.png')); ?>" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            <div class="relative z-10 space-y-6">
                <h2 class="text-3xl font-bold text-white leading-snug h-[80px] typewriter-effect" data-speed="40" data-repeat="8000" data-highlight="Warriors Educare" data-highlight-color="text-[#0ea5e9]">
                    Start your teaching
career with Warriors Educare
                </h2>
                <p class="text-sm text-gray-200 leading-relaxed max-w-xs h-[60px] typewriter-effect" data-speed="40" data-repeat="8000">
                    Create your free candidate profile, discover job opportunities, and get placed at top schools across India.
                </p>

                
                <div class="space-y-3 pt-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center text-xs"><i class="fas fa-briefcase"></i></div>
                        <span class="text-sm text-gray-200">Access 20K+ verified job vacancies</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center text-xs"><i class="fas fa-shield-alt"></i></div>
                        <span class="text-sm text-gray-200">100% free registration for candidates</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 text-white flex items-center justify-center text-xs"><i class="fas fa-headset"></i></div>
                        <span class="text-sm text-gray-200">Dedicated placement support team</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-[11px] text-gray-400">&copy; <?php echo e(date('Y')); ?> Warriors Educare. All rights reserved.</p>
            </div>
        </div>

        
        <div class="p-8 sm:p-10 lg:p-12 flex flex-col justify-center">
            
            <div class="lg:hidden flex justify-center mb-6">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('adobe.png')); ?>" alt="Warriors Educare Logo" class="h-10">
                </a>
            </div>

            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-purple-600/10 text-purple-600 flex items-center justify-center text-lg">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Parent Registration</h2>
                </div>
                <p class="mt-1.5 text-sm text-gray-500">Join Warriors Educare to find the best home tutors for your child</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-6 bg-red-500/10 border border-red-500/30 p-4 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        <div>
                            <ul class="text-sm text-red-300/80 list-disc pl-4 space-y-0.5">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('parent.register.post')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Full Name</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-user text-sm"></i></span>
                        <input id="name" name="name" type="text" required
                            class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all"
                            placeholder="Your full name" value="<?php echo e(old('name')); ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                            <input id="email" name="email" type="email" required
                                class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all"
                                placeholder="you@example.com" value="<?php echo e(old('email')); ?>">
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Phone</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-phone-alt text-sm"></i></span>
                            <input id="phone" name="phone" type="text" required
                                class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all"
                                placeholder="+91-XXXXXXXXXX" value="<?php echo e(old('phone')); ?>">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                            <input id="password" name="password" type="password" required
                                class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-shield-alt text-sm"></i></span>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full bg-[#f3f4f6] border-none rounded-xl pl-11 pr-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-purple-600 text-white font-bold py-3.5 rounded-xl hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 mt-2">
                    <i class="fas fa-user-plus"></i>
                    Create Parent Account
                </button>
            </form>

            <div class="mt-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Or Register As</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-4 relative z-20">
                <a href="<?php echo e(route('candidate.register')); ?>"
                    class="flex flex-col items-center justify-center p-4 rounded-xl text-center font-bold border border-gray-200 hover:bg-[#1e3a8a]/10 hover:border-[#1e3a8a]/30 transition-all group cursor-pointer pointer-events-auto">
                    <div class="flex items-center gap-2 text-gray-800 text-sm">
                        <i class="fas fa-user-graduate text-[#1e3a8a] group-hover:scale-110 transition-transform"></i>
                        <span>Join as a Teacher / Tutor &rarr;</span>
                    </div>
                    <span class="text-xs text-gray-500 font-medium mt-1">(Find School Jobs & Tuition Opportunities)</span>
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? <a href="<?php echo e(route('login')); ?>" class="font-bold text-[#1e3a8a] hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/auth/register_parent.blade.php ENDPATH**/ ?>