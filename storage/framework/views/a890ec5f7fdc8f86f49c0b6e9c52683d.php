<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Warriors Educare</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('adobe.png')); ?>?v=<?php echo e(time()); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            /* Override Tailwind Theme Variables for Admin Light Mode */
            --theme-primary-bg: #f8fafc;
            --theme-secondary-bg: #f1f5f9;
            --theme-accent-blue: #3b82f6;
            --theme-accent-blue-hover: #3f76edff;
            --theme-accent-yellow: #f59e0b;
            --theme-text-dark: #64748b;
            /* Slate 500 */
            --theme-text-main: #0f172a;
            /* Slate 900 */
            --theme-card-bg: #ffffff;
            --theme-card-border: #e2e8f0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--theme-primary-bg);
            color: var(--theme-text-main);
        }

        .admin-sidebar {
            background: linear-gradient(180deg, #041346ff 0%, #2a62bbff 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 3px solid #3b82f6;
            font-weight: 600;
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--theme-card-border);
        }

        /* Smooth scrolling and transitions */
        html {
            scroll-behavior: smooth;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Table Styles */
        .admin-table th {
            background-color: #f8fafc;
            color: var(--theme-text-dark);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--theme-card-border);
        }

        .admin-table td {
            padding: 1rem 1.5rem;
            color: var(--theme-text-main);
            border-bottom: 1px solid var(--theme-card-border);
            font-size: 0.875rem;
        }

        .admin-table tr:hover td {
            background-color: #f1f5f9;
        }

        /* Mobile Sidebar Custom CSS */
        @media (max-width: 767px) {
            #admin-sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                transform: translateX(-100%);
                display: flex !important;
            }
            #admin-sidebar.sidebar-open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="admin-sidebar"
            class="admin-sidebar w-64 flex-shrink-0 flex flex-col transition-transform duration-300 z-30 shadow-2xl hidden md:flex">
            <!-- Brand -->
            <div
                class="h-[70px] flex items-center justify-center border-b border-white/5 px-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-accent-blue/10 blur-xl"></div>
                <img src="<?php echo e(asset('adobe.png')); ?>" alt="Warriors Educare Logo" class="h-10">
            </div>

            <!-- Navigation -->
            <div id="sidebar-scroll-container" class="flex-1 overflow-y-auto py-5 px-3 flex flex-col gap-1 no-scrollbar">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?> px-4 py-3 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-th-large w-5 text-center text-lg"></i> Dashboard
                </a>
                
                <a href="<?php echo e(route('admin.notifications.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.notifications.*') ? 'active' : ''); ?> px-4 py-3 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-bell w-5 text-center text-lg"></i> Notifications
                </a>

                <div class="text-[10px] uppercase font-bold tracking-widest text-white/30 mt-6 mb-2 px-4">Master Data
                </div>

                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-users w-5 text-center"></i> Users
                </a>

                <a href="<?php echo e(route('admin.categories.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-layer-group w-5 text-center"></i> Categories
                </a>
                <a href="<?php echo e(route('admin.subjects.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.subjects.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-book-open w-5 text-center"></i> Subjects
                </a>
                <a href="<?php echo e(route('admin.qualifications.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.qualifications.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-graduation-cap w-5 text-center"></i> Qualifications
                </a>
                <a href="<?php echo e(route('admin.states.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.states.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-map-marked-alt w-5 text-center"></i> States
                </a>
                <a href="<?php echo e(route('admin.cities.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.cities.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-city w-5 text-center"></i> Cities
                </a>

                <div class="text-[10px] uppercase font-bold tracking-widest text-white/30 mt-6 mb-2 px-4">Candidates & Jobs
                </div>

                <a href="<?php echo e(route('admin.jobs.index', ['status' => 'pending'])); ?>"
                    class="sidebar-link <?php echo e(request('status') === 'pending' ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-clipboard-check w-5 text-center"></i> Job Approvals
                    <?php $pendingCount = \App\Models\JobPost::where('status', 'pending')->count(); ?>
                    <?php if($pendingCount > 0): ?>
                        <span
                            class="ml-auto bg-accent-yellow text-[#031b4e] text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e($pendingCount); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.jobs.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.jobs.*') && request('status') !== 'pending' ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-briefcase w-5 text-center"></i> All Jobs
                </a>
                <a href="<?php echo e(route('admin.crm.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.crm.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-users-cog w-5 text-center"></i> Candidates CRM
                </a>
                <a href="<?php echo e(route('admin.applications.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.applications.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-file-signature w-5 text-center"></i> Job Applications
                </a>
                <a href="<?php echo e(route('admin.candidate-payments.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.candidate-payments.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-wallet w-5 text-center"></i> Candidate Payments
                </a>
                <a href="<?php echo e(route('admin.leads.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.leads.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-headset w-5 text-center"></i> Support Leads
                </a>
                <a href="<?php echo e(route('admin.candidate-tuition.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.candidate-tuition.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm text-yellow-300 hover:text-yellow-200">
                    <i class="fas fa-chalkboard w-5 text-center"></i> Candidate Tuition
                    <?php $openLeadsCount = \App\Models\HomeTuitionLead::whereNotIn('status', ['Confirmed','Cancelled'])->count(); ?>
                    <?php if($openLeadsCount > 0): ?>
                        <span class="ml-auto bg-yellow-400 text-[#031b4e] text-[10px] font-black px-2 py-0.5 rounded-full"><?php echo e($openLeadsCount); ?></span>
                    <?php endif; ?>
                </a>

                <div class="text-[10px] uppercase font-bold tracking-widest text-white/30 mt-6 mb-2 px-4">Tuitions & Parents
                </div>

                <a href="<?php echo e(route('admin.tuitions.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.tuitions.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-chalkboard-teacher w-5 text-center"></i> Manage Tuitions
                </a>
                <a href="<?php echo e(route('admin.tuition-leads.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.tuition-leads.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-chalkboard-teacher w-5 text-center"></i> Home Tuition Leads
                </a>
                <a href="<?php echo e(route('admin.tuition-fees.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.tuition-fees.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-file-invoice-dollar w-5 text-center"></i> Parent Payments
                </a>

                <div class="text-[10px] uppercase font-bold tracking-widest text-white/30 mt-6 mb-2 px-4">Finance
                </div>

                <a href="<?php echo e(route('admin.transactions.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.transactions.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-receipt w-5 text-center"></i> Transactions
                </a>

                <div class="text-[10px] uppercase font-bold tracking-widest text-white/30 mt-6 mb-2 px-4">CMS</div>

                <!-- <a href="<?php echo e(route('admin.services.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.services.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-concierge-bell w-5 text-center"></i> Services
                </a> -->
                <a href="<?php echo e(route('admin.testimonials.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.testimonials.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-star w-5 text-center"></i> Testimonials
                </a>
                <a href="<?php echo e(route('admin.clients.index')); ?>"
                    class="sidebar-link <?php echo e(request()->routeIs('admin.clients.*') ? 'active' : ''); ?> px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm">
                    <i class="fas fa-building w-5 text-center"></i> Client Logos
                </a>
            </div>

            <!-- User Section -->
            <div class="p-4 border-t border-white/5 bg-black/10">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="w-full px-4 py-3 rounded-xl flex items-center gap-3 font-semibold text-sm text-red-400 bg-red-500/10 hover:bg-red-500/20 transition-all border border-red-500/20 shadow-lg">
                        <i class="fas fa-power-off w-5 text-center"></i> Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay (Placeholder for future JS) -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden backdrop-blur-sm"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">

            <!-- Header -->
            <header
                class="admin-header h-[70px] flex items-center justify-between px-4 sm:px-8 z-20 shadow-sm sticky top-0">
                <div class="flex items-center gap-4">
                    <button id="mobile-menu-btn"
                        class="text-text-dark hover:text-accent-blue md:hidden focus:outline-none transition-colors w-10 h-10 rounded-lg hover:bg-accent-blue/10 flex items-center justify-center">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    
                    
                </div>

                <div class="flex items-center gap-3 sm:gap-5">
                    
                    <?php
                        $adminIds = \App\Models\User::where('role', 'admin')->pluck('id');
                        $adminNotifications = \Illuminate\Support\Facades\DB::table('notifications')
                            ->where('notifiable_type', 'App\Models\User')
                            ->whereIn('notifiable_id', $adminIds)
                            ->whereNull('read_at')
                            ->orderByDesc('created_at')
                            ->take(10)
                            ->get()
                            ->map(function($n) {
                                $n->data = json_decode($n->data);
                                return $n;
                            });
                        $unreadCount = $adminNotifications->count();
                    ?>

                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open"
                            class="relative w-10 h-10 rounded-full hover:bg-secondary-bg border border-transparent hover:border-card-border text-text-dark hover:text-accent-blue transition-all flex items-center justify-center focus:outline-none group">
                            <i class="fas fa-bell"></i>
                            <?php if($unreadCount > 0): ?>
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-red-500 rounded-full text-white text-[9px] font-black flex items-center justify-center shadow-lg">
                                    <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

                                </span>
                            <?php endif; ?>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="absolute right-0 top-12 w-80 bg-white border border-gray-100 rounded-2xl shadow-2xl z-50 overflow-hidden"
                            style="display:none">

                            <!-- Header -->
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-bell text-accent-blue text-sm"></i>
                                    <span class="text-sm font-bold text-gray-800">Notifications</span>
                                    <?php if($unreadCount > 0): ?>
                                        <span class="bg-red-100 text-red-600 text-[10px] font-black px-1.5 py-0.5 rounded-full"><?php echo e($unreadCount); ?> new</span>
                                    <?php endif; ?>
                                </div>
                                <?php if($unreadCount > 0): ?>
                                    <a href="<?php echo e(route('admin.notifications.mark-all-read')); ?>"
                                        class="text-[11px] text-accent-blue hover:underline font-semibold">Mark all read</a>
                                <?php endif; ?>
                            </div>

                            <!-- Notification List -->
                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                                <?php $__empty_1 = true; $__currentLoopData = $adminNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(route('admin.notifications.mark-read', $notif->id)); ?>"
                                        class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                                            <?php if(str_contains($notif->type, 'LeadFollowUp')): ?>
                                                <i class="fas fa-user-clock"></i>
                                            <?php elseif(str_contains($notif->type, 'LateFee')): ?>
                                                <i class="fas fa-exclamation-triangle text-orange-500"></i>
                                            <?php elseif(str_contains($notif->type, 'ProfileVerified')): ?>
                                                <i class="fas fa-check-circle text-green-500"></i>
                                            <?php else: ?>
                                                <i class="fas fa-bell"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-gray-800 leading-snug"><?php echo e($notif->data->title ?? 'Notification'); ?></p>
                                            <p class="text-xs text-gray-500 mt-0.5 leading-snug"><?php echo e($notif->data->message ?? ''); ?></p>
                                            <p class="text-[10px] text-gray-400 mt-1 font-medium"><?php echo e(\Carbon\Carbon::parse($notif->created_at)->diffForHumans()); ?></p>
                                        </div>
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="py-10 text-center">
                                        <div class="text-3xl text-gray-200 mb-2"><i class="fas fa-bell-slash"></i></div>
                                        <p class="text-sm text-gray-400 font-medium">All caught up!</p>
                                        <p class="text-xs text-gray-300 mt-1">No new notifications</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Footer -->
                            <?php if($adminNotifications->isNotEmpty()): ?>
                                <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50/50">
                                    <a href="<?php echo e(route('admin.notifications.index')); ?>"
                                        class="text-xs font-bold text-accent-blue hover:underline flex items-center justify-center gap-1">
                                        View All Notifications <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div
                        class="flex items-center gap-3 pl-3 sm:pl-5 border-l border-card-border cursor-pointer hover:opacity-80 transition-opacity">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-bold text-text-main leading-none"><?php echo e(auth()->user()->name); ?></p>
                            <p class="text-[10px] text-text-dark/50 mt-1 uppercase tracking-wider font-semibold">Super
                                Admin</p>
                        </div>
                        <div
                            class="h-10 w-10 rounded-xl bg-gradient-to-br from-accent-blue to-accent-blue/70 text-white flex items-center justify-center font-bold shadow-lg shadow-accent-blue/20">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-8 flex flex-col relative bg-secondary-bg/30">
                
                <div class="flex-1">
                    
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-text-main tracking-tight">
                            <?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                        <?php if (! empty(trim($__env->yieldContent('subtitle')))): ?>
                            <p class="text-sm text-text-dark/50 mt-1"><?php echo $__env->yieldContent('subtitle'); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (! empty(trim($__env->yieldContent('actions')))): ?>
                        <div class="flex items-center gap-3">
                            <?php echo $__env->yieldContent('actions'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if(session('success')): ?>
                    <div
                        class="bg-green-500/10 border border-green-500/20 text-green-500 p-4 mb-8 rounded-xl shadow-sm flex items-start gap-3 animate-[fadeIn_0.3s_ease-out]">
                        <i class="fas fa-check-circle mt-0.5 text-lg"></i>
                        <p class="font-medium text-sm"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div
                        class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 mb-8 rounded-xl shadow-sm flex items-start gap-3 animate-[fadeIn_0.3s_ease-out]">
                        <i class="fas fa-exclamation-triangle mt-0.5 text-lg"></i>
                        <p class="font-medium text-sm"><?php echo e(session('error')); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 mb-8 rounded-xl shadow-sm flex items-start gap-3 animate-[fadeIn_0.3s_ease-out]">
                        <i class="fas fa-exclamation-triangle mt-0.5 text-lg"></i>
                        <div class="font-medium text-sm">
                            <ul class="list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php echo $__env->yieldContent('content'); ?>
                </div>

                
                <footer class="mt-auto pt-6 pb-2">
                    <div class="bg-card-bg rounded-2xl border border-card-border p-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm relative overflow-hidden">
                        <!-- Decorative background element -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-accent-blue/5 rounded-full blur-2xl pointer-events-none"></div>
                        
                        <div class="flex flex-col md:flex-row items-center gap-4 text-center md:text-left z-10">
                            <div class="w-10 h-10 rounded-xl bg-accent-blue/10 flex items-center justify-center text-accent-blue shadow-inner border border-accent-blue/20">
                                <i class="fas fa-shield-alt text-lg"></i>
                            </div>
                            <div>
                                <p class="text-text-main font-bold text-sm tracking-tight">&copy; <?php echo e(date('Y')); ?> Warriors Educare.</p>
                                <p class="text-text-dark/60 text-xs font-medium mt-0.5">All rights reserved. Designed with <i class="fas fa-heart text-red-500 mx-0.5"></i> for excellence.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-6 z-10">
                            <div class="text-right hidden sm:block">
                                <p class="text-[10px] font-bold text-text-dark/50 uppercase tracking-widest mb-0.5">System Status</p>
                                <div class="flex items-center gap-1.5 justify-end">
                                    <span class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)] animate-pulse"></span>
                                    <span class="text-xs font-semibold text-text-main">All Systems Operational</span>
                                </div>
                            </div>
                            <div class="h-8 w-px bg-card-border hidden sm:block"></div>
                            <div class="bg-secondary-bg border border-card-border px-3 py-1.5 rounded-lg">
                                <span class="text-xs font-bold text-accent-blue tracking-wider">Admin Portal <span class="text-text-dark/60">v2.0</span></span>
                            </div>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    
    <div id="globalSearchModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('globalSearchModal').classList.add('hidden')"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-3xl bg-card-bg rounded-2xl shadow-2xl overflow-hidden animate-[fadeIn_0.3s_ease-out]">
            <div class="p-6 border-b border-card-border flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-main">Advanced Candidate Search</h3>
                <button type="button" onclick="document.getElementById('globalSearchModal').classList.add('hidden')" class="text-text-dark hover:text-red-500 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <?php
                $searchSubjects = \App\Models\Subject::orderBy('name')->get();
                $searchQuals = \App\Models\Qualification::orderBy('name')->get();
                $searchStates = \App\Models\State::orderBy('name')->get();
            ?>
            
            <form action="<?php echo e(route('admin.crm.index')); ?>" method="GET" class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-text-dark mb-1">Subject</label>
                        <select name="subject_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any Subject</option>
                            <?php $__currentLoopData = $searchSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-text-dark mb-1">Qualification</label>
                        <select name="qualification_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any Qualification</option>
                            <?php $__currentLoopData = $searchQuals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qual): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($qual->id); ?>"><?php echo e($qual->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-dark mb-1">State</label>
                        <select name="state_id" id="global_search_state_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any State</option>
                            <?php $__currentLoopData = $searchStates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-dark mb-1">City</label>
                        <select name="city_id" id="global_search_city_id" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any City</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-text-dark mb-1">Experience (Min Years)</label>
                        <select name="experience" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any Experience</option>
                            <option value="1">1+ Years</option>
                            <option value="3">3+ Years</option>
                            <option value="5">5+ Years</option>
                            <option value="10">10+ Years</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-text-dark mb-1">Gender</label>
                        <select name="gender" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-dark mb-1">English Fluency</label>
                        <select name="english_fluency" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="fluent">Fluent</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-dark mb-1">Availability</label>
                        <select name="availability" class="w-full bg-secondary-bg border border-card-border rounded-lg px-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                            <option value="">Any</option>
                            <option value="immediate">Immediate</option>
                            <option value="1_month">1 Month</option>
                            <option value="2_months">2 Months</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-text-dark mb-1">Salary (Expected/Current)</label>
                        <div class="relative">
                            <i class="fas fa-rupee-sign absolute left-3 top-2.5 text-text-dark/40 text-sm"></i>
                            <input type="text" name="salary" placeholder="e.g. 15000" class="w-full bg-secondary-bg border border-card-border rounded-lg pl-8 pr-3 py-2 text-sm text-text-main focus:border-accent-blue focus:outline-none">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('globalSearchModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-text-main bg-secondary-bg hover:bg-card-border transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-accent-blue hover:bg-accent-blue-hover transition-colors shadow-glow-blue flex items-center gap-2">
                        <i class="fas fa-search"></i> Search Candidates
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    
    <script>
        const globalStateSelect = document.getElementById('global_search_state_id');
        if (globalStateSelect) {
            globalStateSelect.addEventListener('change', function() {
                let stateId = this.value;
                let citySelect = document.getElementById('global_search_city_id');
                citySelect.innerHTML = '<option value="">Loading...</option>';
                
                if(stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Any City</option>';
                            data.forEach(city => {
                                citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching cities:', error);
                            citySelect.innerHTML = '<option value="">Any City</option>';
                        });
                } else {
                    citySelect.innerHTML = '<option value="">Any City</option>';
                }
            });
        }

        // Mobile Sidebar Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const adminSidebar = document.getElementById('admin-sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        if (mobileMenuBtn && adminSidebar && mobileOverlay) {
            function toggleSidebar() {
                adminSidebar.classList.toggle('sidebar-open');
                mobileOverlay.classList.toggle('hidden');
            }

            mobileMenuBtn.addEventListener('click', toggleSidebar);
            mobileOverlay.addEventListener('click', toggleSidebar);
        }

        // Sidebar Scroll State Management
        const sidebarContainer = document.getElementById('sidebar-scroll-container');
        if (sidebarContainer) {
            // Restore scroll position
            const scrollPos = sessionStorage.getItem('adminSidebarScroll');
            if (scrollPos) {
                sidebarContainer.scrollTop = parseInt(scrollPos, 10);
            }

            // Save scroll position on scroll
            sidebarContainer.addEventListener('scroll', function() {
                sessionStorage.setItem('adminSidebarScroll', this.scrollTop);
            });
        }
    </script>
</body>

</html>
<?php /**PATH E:\warriors portal\warriors portal\resources\views/layouts/admin.blade.php ENDPATH**/ ?>