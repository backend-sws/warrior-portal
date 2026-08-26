@guest
<!-- Teacher / Tutor Registration Modal Popup -->
<div id="jobRegPopup" class="fixed inset-0 hidden items-center justify-center px-4 bg-slate-950/75 backdrop-blur-md opacity-0 transition-opacity duration-300" style="z-index: 99999;">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative transform transition-all duration-300 popup-content border border-slate-100 my-auto" style="transform: scale(0.95);">
        <!-- Close Button -->
        <button type="button" onclick="closeTeacherModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-full w-9 h-9 flex items-center justify-center transition-colors z-20 cursor-pointer shadow-sm">
            <i class="fas fa-times text-sm"></i>
        </button>
        
        <!-- Modal Header -->
        <div class="p-6 sm:p-7 text-center relative overflow-hidden bg-gradient-to-br from-[#031b4e] via-[#092b77] to-[#0ea5e9] text-white">
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-white/90 text-[11px] font-bold uppercase tracking-wider mb-3 border border-white/20">
                <i class="fas fa-sparkles text-amber-300 text-xs"></i> <span>Teacher & Tutor Registration</span>
            </div>
            <div class="w-16 h-16 mx-auto bg-white/15 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white text-2xl mb-3 border border-white/25 shadow-inner">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">Join as a Teacher / Tutor</h3>
            <p class="text-blue-100 mt-1 text-xs sm:text-sm font-medium max-w-xs mx-auto">Create your teacher profile, get verified & connect with top schools and home tuition opportunities.</p>
        </div>
        
        <!-- Registration Form Body -->
        <div class="p-6 sm:p-7 bg-white max-h-[70vh] overflow-y-auto">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded-xl">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 shrink-0"></i>
                        <div>
                            <ul class="text-xs text-red-700 list-disc pl-4 space-y-0.5 font-medium">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('candidate.register.post') }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Full Name <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user text-xs"></i></span>
                        <input name="name" type="text" required minlength="3" maxlength="80" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all" placeholder="e.g. Rahul Sharma" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-xs"></i></span>
                            <input name="email" type="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all" placeholder="name@gmail.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Mobile Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-xs"></i></span>
                            <input name="phone" type="tel" required minlength="10" maxlength="10" pattern="^[6-9][0-9]{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all" placeholder="10-digit number" value="{{ old('phone') }}">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-lock text-xs"></i></span>
                            <input name="password" type="password" required minlength="8" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all" placeholder="Min 8 characters">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-shield-alt text-xs"></i></span>
                            <input name="password_confirmation" type="password" required minlength="8" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0ea5e9]/40 focus:border-[#0ea5e9] transition-all" placeholder="Re-enter password">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-[#031b4e] to-[#0ea5e9] hover:from-[#021030] hover:to-[#0284c7] text-white font-bold py-3.5 rounded-xl transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 mt-4 cursor-pointer">
                    <i class="fas fa-paper-plane text-xs"></i> Send Verification OTP & Continue
                </button>
                <p class="text-[11px] text-slate-500 text-center mt-1">
                    <i class="fas fa-shield-halved text-emerald-500 mr-1"></i> An email OTP will verify your registration.
                </p>
            </form>
            
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('resume.builder') }}" class="text-xs text-slate-600 hover:text-[#0ea5e9] font-bold flex items-center gap-1.5 transition-colors">
                    <i class="fas fa-file-pdf text-red-500"></i> Free Resume Builder
                </a>
                <p class="text-xs text-slate-500 font-medium">
                    Already registered? <a href="{{ route('login') }}" class="text-[#0ea5e9] font-bold hover:underline">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    window.openTeacherModal = function() {
        const popup = document.getElementById('jobRegPopup');
        if (popup) {
            const content = popup.querySelector('.popup-content');
            popup.classList.remove('hidden');
            popup.style.display = 'flex';
            setTimeout(() => {
                popup.classList.remove('opacity-0');
                popup.style.opacity = '1';
                if (content) content.style.transform = 'scale(1)';
            }, 20);
        } else {
            window.location.href = "{{ route('candidate.register') }}";
        }
    };

    window.closeTeacherModal = function() {
        const popup = document.getElementById('jobRegPopup');
        if (popup) {
            const content = popup.querySelector('.popup-content');
            popup.style.opacity = '0';
            if (content) content.style.transform = 'scale(0.95)';
            setTimeout(() => {
                popup.style.display = 'none';
                popup.classList.add('hidden');
            }, 300);
        }
    };

    document.addEventListener("DOMContentLoaded", function() {
        const closeBtn = document.getElementById('closeJobRegPopup');
        if (closeBtn) {
            closeBtn.addEventListener('click', window.closeTeacherModal);
        }

        const popupEl = document.getElementById('jobRegPopup');
        if (popupEl) {
            popupEl.addEventListener('click', function(e) {
                if (e.target === this) {
                    window.closeTeacherModal();
                }
            });
        }

        @if($errors->any() && old('name'))
            window.openTeacherModal();
        @endif
    });
</script>
@endguest
