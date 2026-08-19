<?php $__env->startSection('content'); ?>

<!-- 1. Hero Section -->
<div class="relative w-full metallic-blue-card border-none shadow-none text-white pt-20 pb-16 md:pt-28 md:pb-24 overflow-hidden flex items-center">
    <!-- Background image on right side -->
    <div id="services-hero-img" class="absolute inset-y-0 right-0 w-full md:w-1/2 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center opacity-60 md:opacity-100 transition-all duration-1000 ease-in-out z-0 [mask-image:linear-gradient(to_right,transparent,black_15%)]">
        <!-- Overlay description (hidden initially) -->
        <div id="services-img-desc" class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center p-8 lg:p-12 opacity-0 transition-opacity duration-1000">
            <div class="border border-white/20 p-8 rounded-2xl text-center bg-[#031b4e]/80 backdrop-blur-md shadow-2xl w-full max-w-md mx-auto">
                <h3 class="text-2xl lg:text-3xl font-black text-white mb-4 tracking-wide">Comprehensive Solutions</h3>
                <p class="text-white/90 text-sm md:text-base leading-relaxed">
                    From talent acquisition to digital strategy, we provide everything your institution needs to thrive in the modern educational landscape. Our certified professionals ensure top quality service delivery.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Gradient overlay to fade from dark left to transparent right -->
    <div id="services-hero-gradient" class="absolute inset-0 bg-gradient-to-r from-[#040e2d] via-[#040e2d]/70 to-transparent md:w-1/2 z-0 transition-opacity duration-1000 ease-in-out"></div>
    
    <!-- Abstract circle overlay (from template) -->
    <div class="absolute top-0 right-1/4 w-96 h-96 border border-white/5 rounded-full pointer-events-none transform -translate-y-1/2"></div>
    <div class="absolute top-10 right-1/3 w-[500px] h-[500px] border border-white/5 rounded-full pointer-events-none transform -translate-y-1/2"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 w-full flex flex-col md:flex-row items-center">
        <div id="services-hero-text" class="w-full md:w-1/2 transition-all duration-1000 ease-in-out md:pr-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-[2px] bg-[#129aef]"></div>
                <h1 class="text-[10px] md:text-sm font-black uppercase tracking-[0.3em] text-[#129aef]">PREMIUM RECRUITMENT SERVICES</h1>
            </div>
            
            <h2 class="text-4xl md:text-6xl font-black mb-6 text-white tracking-wide leading-tight">
                Our Premium <br/>
                <span class="text-white">Services</span>
            </h2>                                                                                                                
            
            <p class="text-white/70 text-sm md:text-base leading-relaxed mb-10 max-w-md">
                We deliver top-tier recruitment and digital support solutions tailored for modern educational institutions.
            </p>
            
            <div class="flex flex-wrap items-center gap-6">
                <button type="button" onclick="toggleServicesExplore()" class="inline-block bg-[#2563eb] text-white font-bold text-sm px-8 py-4 rounded-full hover:bg-blue-700 transition-colors shadow-[0_10px_30px_rgba(37,99,235,0.4)]">
                    Explore More
                </button>
                
                <!-- Play Icon from template -->
                <button class="w-12 h-12 rounded-full border-2 border-[#129aef] text-[#129aef] flex items-center justify-center hover:bg-[#129aef] hover:text-white transition-colors group">
                    <i class="fas fa-play ml-1 group-hover:scale-110 transition-transform"></i>
                </button>
            </div>
        </div>
        
        <!-- Right side empty or floating elements -->
        <div id="services-hero-floats" class="hidden md:flex justify-end relative w-full md:w-1/2 transition-transform duration-1000 ease-in-out pointer-events-none">
             <div class="absolute -top-12 -right-4 w-32 h-12 bg-[#2563eb] rounded-full flex items-center justify-center gap-2 shadow-2xl animate-float pointer-events-auto">
                 <i class="fas fa-check-circle text-white"></i>
                 <span class="text-white font-bold text-xs">Certified</span>
             </div>
        </div>
    </div>
</div>

<script>
    function toggleServicesExplore() {
        const textContainer = document.getElementById('services-hero-text');
        const imgContainer = document.getElementById('services-hero-img');
        const gradient = document.getElementById('services-hero-gradient');
        const desc = document.getElementById('services-img-desc');
        const floats = document.getElementById('services-hero-floats');

        if (!textContainer || !imgContainer) return;

        // Check current state
        if (textContainer.style.transform === 'translateX(100%)') {
            // Revert to original
            textContainer.style.transform = 'translateX(0)';
            textContainer.classList.remove('md:pl-12');
            textContainer.classList.add('md:pr-12');
            
            if (window.innerWidth >= 768) {
                imgContainer.style.transform = 'translateX(0)';
                floats.style.transform = 'translateX(0)';
            }
            gradient.style.opacity = '1';
            desc.style.opacity = '0';
        } else {
            // Animate
            if (window.innerWidth >= 768) {
                textContainer.style.transform = 'translateX(100%)';
                textContainer.classList.remove('md:pr-12');
                textContainer.classList.add('md:pl-12');
                
                // Move image to the left side
                imgContainer.style.transform = 'translateX(-100%)';
                floats.style.transform = 'translateX(-100%)';
            } else {
                // On mobile just fade or hide gradient
                textContainer.style.transform = 'translateY(20px)';
            }
            gradient.style.opacity = '0';
            desc.style.opacity = '1';
            desc.style.pointerEvents = 'auto';
        }
    }
</script>

<!-- 2. Services Section (Cards) -->
<section id="services" class="py-24 px-6 lg:px-[5%] bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-6 h-[2px] bg-[#129aef]"></div>
                <span class="text-[#129aef] text-[10px] font-bold uppercase tracking-widest">WHAT WE OFFER</span>
                <div class="w-6 h-[2px] bg-[#129aef]"></div>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#040e2d]">The Success of our Services</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="metallic-blue-card border-none shadow-lg shadow-[#040e2d]/50 rounded-xl p-8 text-center group hover:-translate-y-2 transition-transform duration-300 relative flex flex-col h-full overflow-hidden text-white">
                
                <!-- Icon in Circle with downward triangle -->
                <div class="relative w-24 h-24 mx-auto mb-6">
                    <div class="w-full h-full bg-white/10 rounded-full flex items-center justify-center text-3xl text-white group-hover:metallic-blue-card overflow-hidden transition-colors duration-300">
                        <i class="<?php echo e($service->icon); ?>"></i>
                    </div>
                    <!-- Downward triangle -->
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[12px] border-l-transparent border-r-[12px] border-r-transparent border-t-[12px] border-t-white/10 group-hover:border-t-[#2563eb] transition-colors duration-300"></div>
                </div>

                <h3 class="text-white font-bold text-lg mb-3 mt-4"><?php echo e($service->title); ?></h3>
                <p class="text-white/80 text-xs leading-relaxed mb-8 flex-grow">
                    <?php echo e(Str::limit($service->description, 90)); ?>

                </p>

                <!-- Solid Blue Banner Button at bottom -->
                <div class="mt-auto relative">
                     <a href="<?php echo e(route('service.details', $service->slug)); ?>" class="inline-block bg-[#2563eb] text-white text-[10px] font-bold uppercase tracking-widest px-8 py-2.5 relative">
                         MORE
                         <!-- Ribbon tails -->
                         <div class="absolute top-0 -left-2 w-0 h-0 border-t-[18px] border-t-transparent border-r-[8px] border-r-[#1d4ed8] border-b-[18px] border-b-transparent"></div>
                         <div class="absolute top-0 -right-2 w-0 h-0 border-t-[18px] border-t-transparent border-l-[8px] border-l-[#1d4ed8] border-b-[18px] border-b-transparent"></div>
                     </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12 text-slate-500 bg-white rounded-3xl shadow-sm border border-slate-100">
                <i class="fas fa-box-open text-4xl mb-4 opacity-50"></i>
                <p class="text-lg">No services currently available.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 3. Split Section (Solution System Design) -->
<section class="py-24 px-6 lg:px-[5%] bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 items-center rounded-3xl overflow-hidden shadow-2xl">
            
            <!-- Left Image -->
            <div class="relative h-[400px] lg:h-[500px] w-full overflow-hidden bg-slate-100">
                <img id="recruitment-img" src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Recruitment" class="w-full h-full object-cover transition-all duration-700 ease-in-out">
                <!-- Floating Blue accent on left edge -->
                <div class="absolute top-1/2 -left-4 w-8 h-24 bg-[#4f46e5] rounded-full blur-xl opacity-70 pointer-events-none z-10"></div>
            </div>

            <!-- Right Dark Block -->
            <div class="relative h-[400px] lg:h-[500px] bg-[#0f172a] p-10 lg:p-16 flex flex-col justify-center overflow-hidden">
                <!-- Top Right Blue Cutout (from template) -->
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-[#3b82f6] rotate-45 transform"></div>
                
                <!-- Concentric Circles Background -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full pointer-events-none"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] border border-white/5 rounded-full pointer-events-none"></div>
                
                <!-- Glowing Blue Spot -->
                <div class="absolute bottom-1/4 right-1/4 w-32 h-32 bg-blue-500 rounded-full blur-[80px] opacity-40 pointer-events-none"></div>

                <div class="relative z-10 flex gap-6 items-start">
                    <!-- Icon Button -->
                    <button id="change-recruitment-img-btn" class="w-16 h-16 shrink-0 border border-[#3b82f6] text-[#3b82f6] rounded-xl flex items-center justify-center text-3xl cursor-pointer hover:bg-[#3b82f6] hover:text-white transition-all duration-300 shadow-[0_0_15px_rgba(59,130,246,0.3)] hover:shadow-[0_0_25px_rgba(59,130,246,0.6)] focus:outline-none" title="Change Image">
                        <i class="fas fa-users-cog"></i>
                    </button>
                    
                    <div>
                        <h2 class="text-3xl font-extrabold text-white mb-4 typewriter-effect">Expert Recruitment Services</h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8 max-w-sm typewriter-effect" data-speed="15">
                            Our flagship recruitment service connects highly qualified educators with top-tier schools and colleges. We handle the entire process from sourcing and screening to interview scheduling and final placement.
                        </p>
                        
                        <div class="flex items-center gap-6">
                            <!-- Avatar Group -->
                            <div class="flex -space-x-3">
                                <img class="w-10 h-10 rounded-full border-2 border-[#0f172a]" src="https://i.pravatar.cc/100?img=1" alt="User">
                                <img class="w-10 h-10 rounded-full border-2 border-[#0f172a]" src="https://i.pravatar.cc/100?img=2" alt="User">
                                <img class="w-10 h-10 rounded-full border-2 border-[#0f172a]" src="https://i.pravatar.cc/100?img=3" alt="User">
                            </div>
                            <span class="text-white text-xs font-bold">More <i class="fas fa-play text-[#3b82f6] ml-1 text-[8px]"></i></span>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-white/10">
                            <p class="text-slate-400 text-xs">
                                Provide excellent with our services. <a href="<?php echo e(route('contact')); ?>" class="text-[#3b82f6] hover:text-white transition-colors underline font-bold ml-1">Let's Chat Here <i class="fas fa-arrow-right ml-1"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Process Section (We Kinds of Services Business style) -->
<section class="py-24 px-6 lg:px-[5%] bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-20">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-6 h-[2px] bg-[#129aef]"></div>
                <span class="text-[#129aef] text-[10px] font-bold uppercase tracking-widest">OUR BEST SERVICE</span>
                <div class="w-6 h-[2px] bg-[#129aef]"></div>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#040e2d]">How We Deliver Excellence</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 overflow-hidden text-center group">
                <!-- Curved Top Area -->
                <div class="bg-[#f0f7ff] pt-10 pb-16 px-6 rounded-b-[100px] relative transition-colors duration-500 group-hover:metallic-blue-card overflow-hidden">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg text-[#2563eb] text-3xl group-hover:text-white group-hover:bg-[#3b82f6] transition-colors duration-500 relative z-10 border-[6px] border-[#f0f7ff] group-hover:border-[#2563eb]">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <!-- Bottom Content -->
                <div class="pt-8 pb-10 px-8">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2">Step 01</span>
                    <h3 class="text-[#040e2d] font-bold text-lg mb-3">Consultation</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">We understand your unique needs and specific requirements for the roles.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 overflow-hidden text-center group">
                <div class="bg-[#f0f7ff] pt-10 pb-16 px-6 rounded-b-[100px] relative transition-colors duration-500 group-hover:metallic-blue-card overflow-hidden">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg text-[#2563eb] text-3xl group-hover:text-white group-hover:bg-[#3b82f6] transition-colors duration-500 relative z-10 border-[6px] border-[#f0f7ff] group-hover:border-[#2563eb]">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div class="pt-8 pb-10 px-8">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2">Step 02</span>
                    <h3 class="text-[#040e2d] font-bold text-lg mb-3">Sourcing</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Our experts identify and shortlist the most qualified candidates.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 overflow-hidden text-center group">
                <div class="bg-[#f0f7ff] pt-10 pb-16 px-6 rounded-b-[100px] relative transition-colors duration-500 group-hover:metallic-blue-card overflow-hidden">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg text-[#2563eb] text-3xl group-hover:text-white group-hover:bg-[#3b82f6] transition-colors duration-500 relative z-10 border-[6px] border-[#f0f7ff] group-hover:border-[#2563eb]">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                </div>
                <div class="pt-8 pb-10 px-8">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2">Step 03</span>
                    <h3 class="text-[#040e2d] font-bold text-lg mb-3">Screening</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Rigorous background checks and multiple interview rounds.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 overflow-hidden text-center group">
                <div class="bg-[#f0f7ff] pt-10 pb-16 px-6 rounded-b-[100px] relative transition-colors duration-500 group-hover:metallic-blue-card overflow-hidden">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg text-[#2563eb] text-3xl group-hover:text-white group-hover:bg-[#3b82f6] transition-colors duration-500 relative z-10 border-[6px] border-[#f0f7ff] group-hover:border-[#2563eb]">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
                <div class="pt-8 pb-10 px-8">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-2">Step 04</span>
                    <h3 class="text-[#040e2d] font-bold text-lg mb-3">Placement</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Finalizing the placement for a smooth transition for both parties.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<div class="py-24 px-6 lg:px-[5%] bg-white border-t border-slate-200">
    <div class="max-w-3xl mx-auto text-center mb-16">
        <h4 class="text-[#2563eb] text-sm font-bold mb-2 uppercase tracking-widest">Got Questions?</h4>
        <h2 class="text-3xl md:text-4xl font-extrabold text-[#040e2d] mb-4">Frequently Asked Questions</h2>
        <p class="text-slate-600 text-sm max-w-xl mx-auto">Here are some common questions about our services and how we can help you.</p>
    </div>
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-[#040e2d] font-bold text-sm mb-2"><i class="fas fa-question-circle text-[#2563eb] mr-2"></i> How quickly can you fill an urgent vacancy?</h3>
            <p class="text-slate-500 text-xs pl-7 leading-relaxed">Thanks to our vast pre-screened database, we can typically provide a shortlist of highly qualified candidates within 48 to 72 hours of your request.</p>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-[#040e2d] font-bold text-sm mb-2"><i class="fas fa-question-circle text-[#2563eb] mr-2"></i> Do you only recruit for teaching positions?</h3>
            <p class="text-slate-500 text-xs pl-7 leading-relaxed">No, while teachers form a large part of our network, we also recruit for administrative roles, principals, coordinators, and specialized staff like counselors and IT administrators.</p>
        </div>
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <h3 class="text-[#040e2d] font-bold text-sm mb-2"><i class="fas fa-question-circle text-[#2563eb] mr-2"></i> What kind of digital support do you offer?</h3>
            <p class="text-slate-500 text-xs pl-7 leading-relaxed">We provide complete end-to-end digital infrastructure setup. This includes interactive smart boards, reliable campus Wi-Fi, School Management ERP systems, and comprehensive staff training.</p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Image change functionality
    const btn = document.getElementById('change-recruitment-img-btn');
    const img = document.getElementById('recruitment-img');
    const images = [
        "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80",
        "https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80",
        "https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80",
        "https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
    ];
    let currentIndex = 0;

    if(btn && img) {
        btn.addEventListener('click', () => {
            // Animation out (scale down and fade out)
            img.style.transform = 'scale(0.9) rotate(2deg)';
            img.style.opacity = '0';
            img.style.filter = 'blur(10px)';
            
            // Wait for animation to finish, change src, then animate in
            setTimeout(() => {
                currentIndex = (currentIndex + 1) % images.length;
                img.src = images[currentIndex];
                
                // Animation in
                img.style.transform = 'scale(1) rotate(0deg)';
                img.style.opacity = '1';
                img.style.filter = 'blur(0px)';
            }, 700); // Wait for the transition duration
        });
    }
});
</script>

<?php $__env->startPush('scripts'); ?>
<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
</style>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/services.blade.php ENDPATH**/ ?>