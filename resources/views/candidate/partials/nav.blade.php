{{-- Candidate Dashboard Navigation --}}
<div class="bg-[#031b4e] border-b border-gray-600 shadow-md sticky z-[99]" style="top: 132px;">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-nowrap overflow-x-auto hide-scrollbar py-0 gap-1 lg:gap-2 text-sm font-bold items-center justify-start">
            @php
                $appCount = auth()->user()->applications()->count();
                $navItems = [
                    ['route' => 'candidate.dashboard', 'routeIs' => 'candidate.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
                    ['route' => 'candidate.tuitions.index', 'routeIs' => 'candidate.tuitions.*', 'icon' => 'fa-book-reader', 'label' => 'Tuitions'],
                    ['route' => 'candidate.profile.edit', 'routeIs' => 'candidate.profile.*', 'icon' => 'fa-user-circle', 'label' => 'My Profile'],
                    ['route' => 'candidate.applications.index', 'routeIs' => 'candidate.applications.*', 'icon' => 'fa-paper-plane', 'label' => "Applications ($appCount)"],
                    ['route' => 'candidate.payment.show', 'routeIs' => 'candidate.payment.*', 'icon' => 'fa-credit-card', 'label' => 'Payment & Plan'],
                    ['route' => 'candidate.agreement.show', 'routeIs' => 'candidate.agreement.*', 'icon' => 'fa-file-contract', 'label' => 'My Agreement'],
                    ['route' => 'candidate.registration.show', 'routeIs' => 'candidate.registration.*', 'icon' => 'fa-clipboard-list', 'label' => 'Registration'],
                    ['route' => 'candidate.serviceCharge.show', 'routeIs' => 'candidate.servicecharge.*', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Service Charge'],
                    ['route' => 'candidate.aditionalFeature.show', 'routeIs' => 'candidate.aditional.*', 'icon' => 'fa-puzzle-piece', 'label' => 'Aditional Feature'],
                ];
            @endphp

            @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" class="relative px-3 py-3 md:px-4 md:py-4 transition-all flex items-center gap-2 rounded-md whitespace-nowrap
                                   {{ request()->routeIs($item['routeIs'])
                ? 'text-[#031b4e] bg-white shadow-sm'
                : 'text-gray-300 hover:text-white hover:bg-white/10' }}">

                        @if($item['route'] === 'candidate.profile.edit' && auth()->user()->profile?->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile->profile_photo_path) }}" alt="Profile"
                                class="w-5 h-5 rounded-full object-cover border border-accent-blue/30">
                        @else
                            <i class="fas {{ $item['icon'] }} text-xs"></i>
                        @endif

                        {{ $item['label'] }}
                    </a>
            @endforeach

            <form action="{{ route('logout') }}" method="POST" class="ml-auto flex-shrink-0">
                @csrf
                <button type="submit"
                    class="px-4 py-3 md:py-4 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-md transition-colors flex items-center gap-1.5 text-sm font-bold whitespace-nowrap">
                    <i class="fas fa-sign-out-alt text-xs"></i> Logout
                </button>
            </form>
        </div>
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
