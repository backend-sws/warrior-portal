<div x-data="whatsappPopup()" x-show="showPopup" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
    <!-- Backdrop -->
    <div x-show="showPopup" x-transition.opacity class="absolute inset-0 bg-[#031b4e]/70 backdrop-blur-sm" @click="closePopup()"></div>
    
    <!-- Modal -->
    <div x-show="showPopup" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
         class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden z-10 border border-[#25D366]/20">
        
        <!-- Close Button -->
        <button @click="closePopup()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/50 hover:bg-white text-slate-600 hover:text-slate-900 transition-all z-20 backdrop-blur-md shadow-sm">
            <i class="fas fa-times"></i>
        </button>

        <!-- Top Design -->
        <div class="bg-gradient-to-br from-[#25D366]/20 to-[#128C7E]/20 p-8 text-center relative overflow-hidden">
            <!-- Decorative WhatsApp Icon Background -->
            <i class="fab fa-whatsapp absolute -bottom-10 -right-10 text-9xl text-[#25D366] opacity-10 -rotate-12"></i>
            
            <div class="w-20 h-20 bg-gradient-to-br from-[#25D366] to-[#128C7E] rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg shadow-[#25D366]/40 relative z-10">
                <i class="fab fa-whatsapp text-4xl text-white"></i>
            </div>
            
            <h3 class="text-2xl font-black text-[#031b4e] mb-2 tracking-tight relative z-10">Join Our Community!</h3>
            <p class="text-slate-700 text-sm font-medium relative z-10">
                Stay updated with the latest job alerts, tuition leads, and important announcements directly on WhatsApp.
            </p>
        </div>

        <!-- Bottom Action -->
        <div class="bg-white p-6 text-center">
            <a href="https://whatsapp.com/channel/0029VaMr7BdEwEjtDxyUyL2r" target="_blank" @click="closePopup()" class="inline-flex items-center justify-center gap-3 w-full bg-[#25D366] hover:bg-[#128C7E] text-white font-bold text-base px-6 py-4 rounded-xl shadow-lg shadow-[#25D366]/30 transition-all hover:-translate-y-1">
                <i class="fab fa-whatsapp text-xl"></i>
                Join WhatsApp Channel
            </a>
            
            <button @click="closePopup()" class="mt-5 text-xs font-bold text-slate-400 hover:text-slate-600 underline decoration-slate-300 underline-offset-4 transition-colors">
                Maybe Later
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('whatsappPopup', () => ({
        showPopup: false,
        init() {
            setTimeout(() => {
                this.showPopup = true;
            }, 1000); // 1 second delay
        },
        closePopup() {
            this.showPopup = false;
        }
    }));
});
</script>
