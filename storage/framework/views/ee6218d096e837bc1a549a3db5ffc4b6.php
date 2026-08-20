<?php $__env->startSection('content'); ?>

<!-- Split Hero & Form Section -->
<div class="relative w-full bg-slate-50 min-h-screen pb-20 overflow-hidden">
    <!-- Animated Background gradient -->
    <div class="absolute inset-x-0 top-0 h-[600px] md:h-[700px] bg-gradient-to-br from-[#031b4e] via-[#0ea5e9] to-[#7dd3fc] z-0">
        <!-- Animated geometric patterns -->
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px; animation: moveGrid 20s linear infinite;"></div>
        
        <!-- Floating orbs -->
        <div class="absolute top-10 left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-cyan-300/20 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute top-40 right-40 w-40 h-40 border-[20px] border-white/5 rounded-full animate-[spin_10s_linear_infinite]"></div>
    </div>
    
    <style>
        @keyframes moveGrid {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }
    </style>
    
    <div class="max-w-[1400px] mx-auto px-0 md:px-6 relative z-10 pt-8 md:pt-12 flex flex-col md:flex-row gap-0 md:gap-8">
        
        <!-- Left Side: Text and Image -->
        <div class="w-full md:w-1/2 flex flex-col justify-start px-8 md:px-0 mb-12 md:mb-0">
            <div class="mt-4 md:mt-8 mb-12 md:mb-20 min-h-[120px]">
                <h1 class="text-white text-5xl md:text-6xl font-light mb-4 flex items-center h-[60px] md:h-[72px]" 
                    x-data="{ text: '', fullText: 'Get in touch', i: 0 }" 
                    x-init="setTimeout(() => { let int = setInterval(() => { text += fullText[i]; i++; if(i >= fullText.length) clearInterval(int); }, 120); }, 300)">
                    <span x-text="text"></span><span class="w-1 md:w-[3px] h-10 md:h-14 bg-white ml-2 animate-pulse"></span>
                </h1>
                <p class="text-white/90 text-sm md:text-base font-medium"
                   x-data="{ show: false }" 
                   x-init="setTimeout(() => show = true, 2000)" 
                   x-show="show" 
                   x-transition.opacity.duration.1000ms>
                   We'd love to hear from you!
                </p>
            </div>
            
            <div class="rounded-tr-[40px] md:rounded-tr-none md:rounded-tl-[40px] md:rounded-bl-[40px] overflow-hidden shadow-2xl h-[400px] md:h-[500px]">
                <!-- Using a modern building image as seen in the template -->
                <img src="https://images.unsplash.com/photo-1600607686527-6fb886090705?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Modern Building" class="w-full h-full object-cover" />
            </div>
        </div>

        <!-- Right Side: Contact Form Card -->
        <div class="w-full md:w-1/2 flex items-center justify-center px-4 md:px-0 md:pt-10">
            <div class="w-full max-w-xl bg-white rounded-[32px] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.1)] relative md:-ml-12 md:mt-10 z-20">
                <h2 class="text-[#040e2d] text-2xl md:text-3xl font-medium mb-2">Contact us</h2>
                <p class="text-slate-400 text-sm mb-10">We'd love to hear from you!</p>
                
                <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="space-y-6" id="contactForm">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Name</label>
                        <input type="text" name="name" required class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" placeholder="Your fullname">
                    </div>
                    
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Your email</label>
                        <input type="email" name="email" class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" placeholder="Your email address">
                    </div>

                    <!-- Phone (keeping from original context) -->
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Your phone</label>
                        <input type="text" name="phone" required class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all" placeholder="Your phone number">
                    </div>
                    
                    <div>
                        <label class="block text-slate-800 text-sm font-medium mb-2">Your messages</label>
                        <textarea name="message" required rows="5" class="w-full bg-transparent border border-slate-200 rounded-xl px-4 py-3.5 text-sm text-slate-800 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all resize-none" placeholder="Your messages here..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-[#111] text-white font-medium py-4 rounded-xl hover:bg-black hover:shadow-xl transition-all duration-300">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Contact Info Cards (Original Content Integrated) -->
<div class="py-16 px-6 lg:px-[5%] bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Location -->
            <div class="light-metallic-blue-card border-0 p-8 rounded-2xl flex flex-col items-center text-center gap-4 hover:shadow-xl transition-all duration-300 group overflow-hidden">
                <div class="w-14 h-14 bg-[#031b4e]/10 text-[#031b4e] rounded-full flex items-center justify-center text-xl shrink-0 group-hover:scale-110 group-hover:bg-[#031b4e] group-hover:text-white transition-all">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="relative z-10">
                    <h4 class="text-[#031b4e] font-bold mb-2">Our Location</h4>
                    <p class="text-sm text-[#031b4e]/70 leading-relaxed">Career Point Building, 2nd floor,<br>Patna,800001, Bihar</p>
                </div>
            </div>

            <!-- Email -->
            <a href="mailto:info@warriorseducare.in" class="light-metallic-blue-card border-0 p-8 rounded-2xl flex flex-col items-center text-center gap-4 hover:shadow-xl transition-all duration-300 group block overflow-hidden">
                <div class="w-14 h-14 bg-[#031b4e]/10 text-[#031b4e] rounded-full flex items-center justify-center text-xl shrink-0 group-hover:scale-110 group-hover:bg-[#031b4e] group-hover:text-white transition-all">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="relative z-10">
                    <h4 class="text-[#031b4e] font-bold mb-2">Email Us</h4>
                    <span class="text-sm text-[#031b4e]/70">info@warriorseducare.in</span>
                </div>
            </a>

            <!-- Call -->
            <a href="tel:+917070938975" class="light-metallic-blue-card border-0 p-8 rounded-2xl flex flex-col items-center text-center gap-4 hover:shadow-xl transition-all duration-300 group block overflow-hidden">
                <div class="w-14 h-14 bg-[#031b4e]/10 text-[#031b4e] rounded-full flex items-center justify-center text-xl shrink-0 group-hover:scale-110 group-hover:bg-[#031b4e] group-hover:text-white transition-all">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="relative z-10">
                    <h4 class="text-[#031b4e] font-bold mb-2">Call Us</h4>
                    <span class="text-sm text-[#031b4e]/70">+91-7070938975</span>
                </div>
            </a>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
    btn.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                confirmButtonColor: '#111'
            });
            this.reset();
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#111'
        });
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/contact.blade.php ENDPATH**/ ?>