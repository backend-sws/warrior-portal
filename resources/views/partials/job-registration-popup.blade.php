@guest
<!-- Registration Popup -->
<div id="jobRegPopup" class="fixed inset-0 hidden items-center justify-center px-4 bg-slate-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-500" style="z-index: 99999;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative transform transition-transform duration-500 popup-content" style="transform: scale(0.95);">
        <!-- Close Button -->
        <button id="closeJobRegPopup" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-full w-8 h-8 flex items-center justify-center transition-colors z-20">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Header -->
        <div class="p-8 text-center relative overflow-hidden bg-white/90 backdrop-blur-md rounded-t-2xl">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-500"></div>
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-slate-50 to-indigo-50 rounded-full flex items-center justify-center text-indigo-600 shadow-[inset_0_2px_4px_rgba(255,255,255,0.8),_0_10px_20px_rgba(0,0,0,0.05)] text-3xl mb-5 relative z-10 border border-white">
                <i class="fas fa-file-invoice"></i>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">Build Your Resume</h3>
            <p class="text-slate-500 mt-2 text-sm font-medium">Create a professional resume in minutes and land your dream job.</p>
        </div>
        
        <!-- Registration Form -->
        <div class="p-8 bg-slate-50/80 backdrop-blur-xl border-t border-white/50">
            @if($errors->any())
                <div class="mb-4 bg-red-500/10 border border-red-500/30 p-3 rounded-xl">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        <div>
                            <ul class="text-xs text-red-400 list-disc pl-4 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ route('candidate.register.post') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user text-sm"></i></span>
                        <input name="name" type="text" required class="w-full bg-white/80 border border-slate-200/60 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]" placeholder="Full Name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                        <input name="email" type="email" required class="w-full bg-white/80 border border-slate-200/60 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]" placeholder="Email Address" value="{{ old('email') }}">
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-sm"></i></span>
                        <input name="phone" type="text" required class="w-full bg-white/80 border border-slate-200/60 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]" placeholder="Phone Number" value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-lock text-sm"></i></span>
                        <input name="password" type="password" required class="w-full bg-white/80 border border-slate-200/60 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]" placeholder="Password">
                    </div>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-shield-alt text-sm"></i></span>
                        <input name="password_confirmation" type="password" required class="w-full bg-white/80 border border-slate-200/60 rounded-xl pl-11 pr-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 transition-all shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]" placeholder="Confirm Password">
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-3.5 rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all shadow-[0_10px_20px_rgba(79,70,229,0.2),_inset_0_2px_0_rgba(255,255,255,0.2)] flex items-center justify-center gap-2 mt-4 transform hover:-translate-y-0.5">
                    <i class="fas fa-user-plus"></i> Register & Build Profile
                </button>
            </form>
            
            <div class="mt-4">
                <a href="{{ route('resume.builder') }}" class="w-full bg-white border border-slate-200 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-50 transition-all shadow-[0_4px_10px_rgba(0,0,0,0.03)] hover:shadow-[0_6px_15px_rgba(0,0,0,0.05)] flex items-center justify-center gap-2 group">
                    <i class="fas fa-file-pdf text-red-500 group-hover:scale-110 transition-transform"></i> Try Free Resume Builder
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-500 font-medium">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:text-indigo-800 hover:underline transition-colors">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const showPopup = () => {
            const popup = document.getElementById('jobRegPopup');
            if(popup) {
                const content = popup.querySelector('.popup-content');
                
                popup.classList.remove('hidden');
                popup.style.display = 'flex';
                
                // Trigger animation
                setTimeout(() => {
                    popup.classList.remove('opacity-0');
                    popup.style.opacity = '1';
                    content.style.transform = 'scale(1)';
                }, 50);
            }
        };

        @if($errors->any())
            // Show immediately if there are validation errors
            showPopup();
        @else
            // Show after 2 seconds normally
            setTimeout(showPopup, 2000);
        @endif

        function closeJobPopup() {
            const popup = document.getElementById('jobRegPopup');
            const content = popup.querySelector('.popup-content');
            
            // Revert inline styles
            popup.style.opacity = '0';
            content.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                popup.style.display = 'none';
            }, 500);
        }

        // Attach event listeners immediately since script is at the bottom of the DOM
        const closeBtn = document.getElementById('closeJobRegPopup');
        if(closeBtn) {
            closeBtn.addEventListener('click', closeJobPopup);
        }

        const popupEl = document.getElementById('jobRegPopup');
        if(popupEl) {
            popupEl.addEventListener('click', function(e) {
                if(e.target === this) {
                    closeJobPopup();
                }
            });
        }
    })();
</script>
@endguest
