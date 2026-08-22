{{-- Candidate Dashboard Navigation --}}
<div class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.03)] sticky z-30 transition-all duration-300" style="top: 112px;">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 relative flex items-center">
        
        <!-- Left Scroll Arrow (Mobile/Tablet) -->
        <button id="candidateNavPrev" type="button" aria-label="Scroll Left"
            class="hidden absolute left-1 sm:left-2 z-20 w-7 h-7 bg-white/95 backdrop-blur-md border border-slate-200 text-[#031b4e] rounded-full shadow-md flex items-center justify-center text-xs hover:bg-[#031b4e] hover:text-white transition-all">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Left Fade Gradient -->
        <div id="candidateNavFadeLeft" class="hidden absolute left-0 top-0 bottom-0 w-8 sm:w-10 bg-gradient-to-r from-white via-white/80 to-transparent z-10 pointer-events-none"></div>

        <!-- Scrollable Navigation Container -->
        <div id="candidateNavScroll" class="flex items-center justify-between gap-3 py-2.5 overflow-x-auto hide-scrollbar scroll-smooth w-full px-1">
            @php
                $appCount = auth()->user()->applications()->count();
                $tuitionCount = \App\Models\TuitionApplication::where('candidate_id', auth()->id())->count();
                $navItems = [
                    ['route' => 'candidate.dashboard', 'routeIs' => 'candidate.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
                    ['route' => 'candidate.applications.available', 'routeIs' => 'candidate.applications.available', 'icon' => 'fa-briefcase', 'label' => 'School Jobs'],
                    ['route' => 'candidate.tuitions.index', 'routeIs' => 'candidate.tuitions.*', 'icon' => 'fa-book-reader', 'label' => 'Home Tuitions'],
                    ['route' => 'candidate.applications.index', 'routeIs' => 'candidate.applications.index', 'icon' => 'fa-paper-plane', 'label' => 'My Applications', 'badge' => ($appCount + $tuitionCount)],
                    ['route' => 'candidate.profile.edit', 'routeIs' => 'candidate.profile.*', 'icon' => 'fa-user-circle', 'label' => 'My Profile'],
                    ['route' => 'candidate.agreement.show', 'routeIs' => 'candidate.agreement.*', 'icon' => 'fa-file-signature', 'label' => 'My Agreement'],
                    ['route' => 'candidate.serviceCharge.show', 'routeIs' => 'candidate.servicecharge.*', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Service Charge'],
                ];
            @endphp

            <div class="flex items-center gap-1.5 sm:gap-2 flex-nowrap shrink-0">
                @foreach($navItems as $item)
                    @php $isActive = request()->routeIs($item['routeIs']); @endphp
                    <a href="{{ route($item['route']) }}" 
                       class="relative px-3.5 py-2 rounded-xl text-xs sm:text-[13px] font-bold flex items-center gap-2 transition-all duration-200 whitespace-nowrap group shrink-0 {{ $isActive ? 'candidate-nav-active bg-[#031b4e] text-white shadow-md shadow-[#031b4e]/20' : 'text-slate-600 hover:text-[#031b4e] hover:bg-slate-100/90' }}">
                        
                        @if($item['route'] === 'candidate.profile.edit' && auth()->user()->profile?->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile->profile_photo_path) }}" alt="Profile"
                                class="w-4 h-4 rounded-full object-cover border {{ $isActive ? 'border-white' : 'border-slate-300' }}">
                        @else
                            <i class="fas {{ $item['icon'] }} text-xs {{ $isActive ? 'text-[#fbc043]' : 'text-slate-400 group-hover:text-[#031b4e]' }} transition-colors"></i>
                        @endif

                        <span>{{ $item['label'] }}</span>

                        @if(isset($item['badge']))
                            <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $isActive ? 'bg-white/20 text-white' : 'bg-blue-100 text-[#031b4e]' }}">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-2 ml-auto shrink-0 pl-3 border-l border-slate-200">
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="px-3 py-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all flex items-center gap-1.5 text-xs font-bold whitespace-nowrap border border-transparent hover:border-red-100">
                        <i class="fas fa-sign-out-alt text-xs"></i> 
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Fade Gradient -->
        <div id="candidateNavFadeRight" class="absolute right-0 top-0 bottom-0 w-10 sm:w-12 bg-gradient-to-l from-white via-white/90 to-transparent z-10 pointer-events-none"></div>

        <!-- Right Scroll Arrow (Mobile/Tablet) -->
        <button id="candidateNavNext" type="button" aria-label="Scroll Right"
            class="absolute right-1 sm:right-2 z-20 w-7 h-7 bg-white/95 backdrop-blur-md border border-slate-200 text-[#031b4e] rounded-full shadow-md flex items-center justify-center text-xs hover:bg-[#031b4e] hover:text-white transition-all">
            <i class="fas fa-chevron-right"></i>
        </button>

    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    (function() {
        function initCandidateNav() {
            const scrollContainer = document.getElementById('candidateNavScroll');
            const prevBtn = document.getElementById('candidateNavPrev');
            const nextBtn = document.getElementById('candidateNavNext');
            const fadeLeft = document.getElementById('candidateNavFadeLeft');
            const fadeRight = document.getElementById('candidateNavFadeRight');

            if (!scrollContainer) return;

            // Auto-center active tab
            const activeTab = scrollContainer.querySelector('.candidate-nav-active');
            if (activeTab) {
                setTimeout(() => {
                    const containerRect = scrollContainer.getBoundingClientRect();
                    const activeRect = activeTab.getBoundingClientRect();
                    const offset = activeRect.left - containerRect.left - (containerRect.width / 2) + (activeRect.width / 2);
                    scrollContainer.scrollBy({ left: offset, behavior: 'smooth' });
                }, 100);
            }

            function updateScrollUI() {
                const maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                const currentScroll = scrollContainer.scrollLeft;

                // Left indicators
                if (currentScroll > 15) {
                    if (prevBtn) prevBtn.classList.remove('hidden');
                    if (fadeLeft) fadeLeft.classList.remove('hidden');
                } else {
                    if (prevBtn) prevBtn.classList.add('hidden');
                    if (fadeLeft) fadeLeft.classList.add('hidden');
                }

                // Right indicators
                if (maxScroll > 15 && currentScroll < maxScroll - 15) {
                    if (nextBtn) nextBtn.classList.remove('hidden');
                    if (fadeRight) fadeRight.classList.remove('hidden');
                } else {
                    if (nextBtn) nextBtn.classList.add('hidden');
                    if (fadeRight) fadeRight.classList.add('hidden');
                }
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: -220, behavior: 'smooth' });
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: 220, behavior: 'smooth' });
                });
            }

            scrollContainer.addEventListener('scroll', updateScrollUI, { passive: true });
            window.addEventListener('resize', updateScrollUI, { passive: true });
            setTimeout(updateScrollUI, 200);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCandidateNav);
        } else {
            initCandidateNav();
        }
    })();
</script>



