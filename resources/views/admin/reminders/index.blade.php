@extends('layouts.admin')

@section('title', 'Reminder Center')
@section('subtitle', 'Send targeted notifications & emails to candidates with one click')

@section('content')
<div class="space-y-6" x-data="reminderCenter()">

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl shadow-sm"
         x-data="{show: true}" x-show="show" x-transition>
        <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
        <span class="font-semibold">{{ session('success') }}</span>
        <button @click="show=false" class="ml-auto text-emerald-400 hover:text-emerald-600"><i class="fas fa-times"></i></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl shadow-sm"
         x-data="{show: true}" x-show="show" x-transition>
        <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
        <span class="font-semibold">{{ session('error') }}</span>
        <button @click="show=false" class="ml-auto text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="bg-gradient-to-r from-[#041346] to-[#2a62bb] rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-paper-plane text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold">Reminder Center</h1>
                </div>
                <p class="text-blue-200 text-sm max-w-lg">Send targeted DB dashboard notifications and emails to candidates. Choose a reminder type, select individual or all candidates, and click send.</p>
            </div>
            <div class="hidden md:flex gap-4 text-center">
                <div class="bg-white/10 rounded-xl px-4 py-3 backdrop-blur-sm">
                    <p class="text-2xl font-black">{{ $stats['total_candidates'] }}</p>
                    <p class="text-xs text-blue-200">Total Candidates</p>
                </div>
                <div class="bg-orange-500/30 rounded-xl px-4 py-3 backdrop-blur-sm border border-orange-400/30">
                    <p class="text-2xl font-black text-orange-300">{{ array_sum([$stats['service_charge_pending'], $stats['renewal_needed'], $stats['late_fees']]) }}</p>
                    <p class="text-xs text-orange-200">Need Attention</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $statCards = [
            ['label' => 'Service Charge Pending', 'value' => $stats['service_charge_pending'], 'icon' => 'fa-rupee-sign', 'color' => 'red'],
            ['label' => 'Renewal Needed', 'value' => $stats['renewal_needed'], 'icon' => 'fa-redo-alt', 'color' => 'purple'],
            ['label' => 'Payment Pending', 'value' => $stats['payment_pending'], 'icon' => 'fa-wallet', 'color' => 'amber'],
            ['label' => 'Upcoming Interviews', 'value' => $stats['upcoming_interviews'], 'icon' => 'fa-calendar-check', 'color' => 'blue'],
            ['label' => 'Incomplete Profiles', 'value' => $stats['incomplete_profiles'], 'icon' => 'fa-user-edit', 'color' => 'indigo'],
            ['label' => 'Plan Expiring Soon', 'value' => $stats['plan_expiring'], 'icon' => 'fa-exclamation-triangle', 'color' => 'orange'],
            ['label' => 'Late Fees Applied', 'value' => $stats['late_fees'], 'icon' => 'fa-exclamation-circle', 'color' => 'rose'],
            ['label' => 'Total Candidates', 'value' => $stats['total_candidates'], 'icon' => 'fa-users', 'color' => 'green'],
        ];
        $colorMap = [
            'red'    => 'bg-red-50 text-red-600 border-red-100',
            'purple' => 'bg-purple-50 text-purple-600 border-purple-100',
            'amber'  => 'bg-amber-50 text-amber-600 border-amber-100',
            'blue'   => 'bg-blue-50 text-blue-600 border-blue-100',
            'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
            'orange' => 'bg-orange-50 text-orange-600 border-orange-100',
            'rose'   => 'bg-rose-50 text-rose-600 border-rose-100',
            'green'  => 'bg-green-50 text-green-600 border-green-100',
        ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white rounded-2xl border {{ $colorMap[$card['color']] }} p-4 flex items-center gap-3 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $colorMap[$card['color']] }} flex-shrink-0">
                <i class="fas {{ $card['icon'] }}"></i>
            </div>
            <div>
                <p class="text-xl font-black text-gray-800">{{ $card['value'] }}</p>
                <p class="text-xs text-gray-500 leading-tight">{{ $card['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
    
    @php
        $baseCandidates = $candidates->map(fn($c) => ['id' => $c->id, 'name' => $c->name]);
        $interviewItems = $upcomingInterviews->map(fn($a) => [
            'id' => $a->id, 
            'name' => ($a->candidate->name ?? 'N/A') . ' - ' . \Carbon\Carbon::parse($a->interview_date)->format('d M')
        ]);
    @endphp

    {{-- Reminder Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        {{-- 1. Service Charge Reminder --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-red-500 to-rose-600 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Service Charge Reminder</h3>
                        <p class="text-red-100 text-xs">{{ $stats['service_charge_pending'] }} pending invoices</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Sends DB notification + email to candidates with pending or overdue service charge invoices.</p>
                <form method="POST" action="{{ route('admin.reminders.service-charge') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['service_charge_pending'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 Send to All (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100">
                                <input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400">
                            </div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold">
                                    <input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">
                                    📢 Send to All Target Candidates
                                </label>
                                <hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id">
                                    <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}">
                                        <input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300">
                                        <span x-text="c.name"></span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Service Charge Reminder
                    </button>
                </form>
            </div>
        </div>

        {{-- 2. Renewal Reminder --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-purple-500 to-violet-600 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-redo-alt"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Registration Renewal</h3>
                        <p class="text-purple-100 text-xs">{{ $stats['renewal_needed'] }} plans expired</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Reminds candidates whose registration plan has expired (all applications used) to renew.</p>
                <form method="POST" action="{{ route('admin.reminders.renewal') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['renewal_needed'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 Send to All Expired (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold"><input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">📢 Send to All Expired</label><hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id">
                                    <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300"><span x-text="c.name"></span></label>
                                </template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-violet-600 hover:from-purple-600 hover:to-violet-700 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Renewal Reminder
                    </button>
                </form>
            </div>
        </div>

        {{-- 3. Payment Pending --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Payment Pending</h3>
                        <p class="text-amber-100 text-xs">{{ $stats['payment_pending'] }} with ₹500 due</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Reminds standard plan candidates who have ₹500 pending registration fee.</p>
                <form method="POST" action="{{ route('admin.reminders.payment-pending') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['payment_pending'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 Send to All (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold"><input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">📢 Send to All Pending</label><hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id"><label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300"><span x-text="c.name"></span></label></template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Payment Reminder
                    </button>
                </form>
            </div>
        </div>

        {{-- 4. Interview Reminder --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Interview Reminder</h3>
                        <p class="text-blue-100 text-xs">{{ $stats['upcoming_interviews'] }} in next 3 days</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Sends reminder to candidates with interviews in next 3 days. Or target specific interviews.</p>
                <form method="POST" action="{{ route('admin.reminders.interview') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($interviewItems) }}, {{ $stats['upcoming_interviews'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 All Upcoming (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search interview..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold"><input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">📢 Send to All Upcoming</label><hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id"><label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300"><span x-text="c.name"></span></label></template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Interview Reminder
                    </button>
                </form>
            </div>
        </div>

        {{-- 5. Profile Completion --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Profile Completion</h3>
                        <p class="text-indigo-100 text-xs">{{ $stats['incomplete_profiles'] }} incomplete profiles</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Reminds registered candidates who haven't uploaded resume, photo, or location yet.</p>
                <form method="POST" action="{{ route('admin.reminders.profile') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['incomplete_profiles'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 All Incomplete (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold"><input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">📢 Send to All Incomplete</label><hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id"><label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300"><span x-text="c.name"></span></label></template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Profile Reminder
                    </button>
                </form>
            </div>
        </div>

        {{-- 6. Plan Expiry Warning --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-orange-500 to-amber-600 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Plan Expiry Warning</h3>
                        <p class="text-orange-100 text-xs">{{ $stats['plan_expiring'] }} with 0–1 left</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Warns candidates who have 1 or 0 applications remaining on their current plan.</p>
                <form method="POST" action="{{ route('admin.reminders.plan-expiry') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['plan_expiring'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 All At Risk (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold"><input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">📢 Send to All At Risk</label><hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id"><label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300"><span x-text="c.name"></span></label></template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Plan Warning
                    </button>
                </form>
            </div>
        </div>

        {{-- 7. Late Fee Alert --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-r from-rose-500 to-red-700 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Late Fee Alert</h3>
                        <p class="text-rose-100 text-xs">{{ $stats['late_fees'] }} with late fees</p>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-xs text-gray-500">Sends urgent alert to candidates who have accumulated late fees on their service charge invoices.</p>
                <form method="POST" action="{{ route('admin.reminders.late-fee') }}">
                    @csrf
                    <div x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['late_fees'] }})" class="relative mb-3">
                        <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 bg-gray-50 cursor-pointer text-xs">
                            <span x-text="sendToAll ? '📢 All with Late Fees (' + totalCount + ')' : '👤 Selected (' + selected.length + ')'"></span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                        <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 flex flex-col" style="display: none;">
                            <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                            <div class="overflow-y-auto p-2 space-y-1">
                                <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs font-semibold"><input type="checkbox" name="send_to_all" value="1" x-model="sendToAll" @change="toggleAll()" class="rounded border-gray-300">📢 Send to All</label><hr class="my-1 border-gray-100">
                                <template x-for="c in filteredItems" :key="c.id"><label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs" :class="{'opacity-50': sendToAll}"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" :disabled="sendToAll" class="rounded border-gray-300"><span x-text="c.name"></span></label></template>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-rose-500 to-red-700 hover:from-rose-600 hover:to-red-800 text-white text-sm font-bold py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                        <i class="fas fa-paper-plane"></i> Send Late Fee Alert
                    </button>
                </form>
            </div>
        </div>

        {{-- 8. Custom Message (Full Width) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-visible hover:shadow-md transition-shadow md:col-span-2 xl:col-span-2">
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 p-4 rounded-t-2xl text-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Custom Message</h3>
                        <p class="text-gray-300 text-xs">Write your own notification message to any or all candidates</p>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <form method="POST" action="{{ route('admin.reminders.custom') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Notification Title *</label>
                            <input type="text" name="title" required maxlength="100"
                                placeholder="e.g., Important Update from Warriors Educare"
                                class="w-full text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-400 bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Send To</label>
                            <div class="flex gap-3">
                                <div class="flex-1">
                                    <select name="target" x-model="customTarget"
                                        class="w-full text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-400 bg-gray-50">
                                        <option value="all">📢 All Candidates ({{ $stats['total_candidates'] }})</option>
                                        <option value="specific">👤 Specific Candidates (Multi-Select)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="customTarget === 'specific'" x-transition x-data="multiSelectDropdown({{ Js::from($baseCandidates) }}, {{ $stats['total_candidates'] }})" x-init="sendToAll = false">
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Select Candidates *</label>
                        <div class="relative">
                            <div @click="open = !open" class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 cursor-pointer text-sm">
                                <span x-text="selected.length > 0 ? selected.length + ' Candidates Selected' : '— Select Candidates —'"></span>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                            <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-60 flex flex-col" style="display: none;">
                                <div class="p-2 border-b border-gray-100"><input type="text" x-model="search" placeholder="Search candidate..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded px-2 py-1.5 focus:outline-none focus:border-blue-400"></div>
                                <div class="overflow-y-auto p-2 space-y-1">
                                    <template x-for="c in filteredItems" :key="c.id"><label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer text-xs"><input type="checkbox" name="candidate_ids[]" :value="c.id" x-model="selected" class="rounded border-gray-300"><span x-text="c.name"></span></label></template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Message *</label>
                        <textarea name="message" required maxlength="500" rows="3"
                            placeholder="Write your message here..."
                            class="w-full text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-400 bg-gray-50 resize-none"></textarea>
                        <p class="text-xs text-gray-400 mt-1">Max 500 characters</p>
                    </div>

                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-600 cursor-pointer select-none">
                            <input type="checkbox" name="send_email" value="1"
                                class="w-4 h-4 rounded border-gray-300 text-gray-700 focus:ring-gray-400">
                            Also send Email (in addition to dashboard notification)
                        </label>
                        <button type="submit"
                            class="ml-auto bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                            <i class="fas fa-bullhorn"></i> Send Custom Message
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- End Grid --}}

    {{-- Recent Activity Log --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-50 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500">
                <i class="fas fa-history text-sm"></i>
            </div>
            <h2 class="font-bold text-gray-800">Recent Reminder Activity</h2>
            <span class="ml-auto text-xs text-gray-400">Last 20 actions</span>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentLogs as $log)
            <div class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50 transition-colors">
                @php
                $typeConfig = [
                    'service_charge'    => ['icon' => 'fa-rupee-sign', 'color' => 'text-red-500 bg-red-50', 'label' => 'Service Charge'],
                    'renewal'           => ['icon' => 'fa-redo-alt', 'color' => 'text-purple-500 bg-purple-50', 'label' => 'Renewal'],
                    'payment_pending'   => ['icon' => 'fa-wallet', 'color' => 'text-amber-500 bg-amber-50', 'label' => 'Payment Pending'],
                    'interview'         => ['icon' => 'fa-calendar-check', 'color' => 'text-blue-500 bg-blue-50', 'label' => 'Interview'],
                    'profile_completion'=> ['icon' => 'fa-user-edit', 'color' => 'text-indigo-500 bg-indigo-50', 'label' => 'Profile Completion'],
                    'plan_expiry'       => ['icon' => 'fa-exclamation-triangle', 'color' => 'text-orange-500 bg-orange-50', 'label' => 'Plan Expiry'],
                    'late_fee'          => ['icon' => 'fa-exclamation-circle', 'color' => 'text-rose-500 bg-rose-50', 'label' => 'Late Fee'],
                    'custom'            => ['icon' => 'fa-bullhorn', 'color' => 'text-gray-600 bg-gray-100', 'label' => 'Custom Message'],
                ];
                $cfg = $typeConfig[$log->type] ?? ['icon' => 'fa-bell', 'color' => 'text-gray-400 bg-gray-50', 'label' => $log->type];
                @endphp
                <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $cfg['color'] }} flex-shrink-0 text-xs">
                    <i class="fas {{ $cfg['icon'] }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800">{{ $cfg['label'] }} Reminder</p>
                    <p class="text-xs text-gray-400">To: {{ $log->target }} · {{ $log->count_sent }} sent
                        @if($log->note) · "{{ Str::limit($log->note, 40) }}" @endif
                    </p>
                </div>
                <span class="text-xs text-gray-300 flex-shrink-0">
                    {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                </span>
            </div>
            @empty
            <div class="py-12 text-center">
                <div class="text-4xl text-gray-200 mb-3"><i class="fas fa-history"></i></div>
                <p class="text-gray-400 text-sm font-semibold">No reminders sent yet</p>
                <p class="text-gray-300 text-xs mt-1">Use the cards above to send your first reminder</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

<script>
function reminderCenter() {
    return {
        customTarget: 'all',
    }
}
function multiSelectDropdown(items, totalCount) {
    return {
        open: false,
        sendToAll: true,
        selected: [],
        search: '',
        items: items,
        totalCount: totalCount,
        get filteredItems() {
            if (this.search === '') return this.items;
            return this.items.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
        },
        toggleAll() {
            if (this.sendToAll) {
                this.selected = []; // clear individual selections if send to all is checked
            }
        }
    }
}
</script>
@endsection
