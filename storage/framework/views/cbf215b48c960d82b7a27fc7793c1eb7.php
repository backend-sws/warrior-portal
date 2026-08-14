<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Warriors Educare — The Gold Standard in Education Recruitment'); ?></title>
    <meta name="description"
        content="<?php echo $__env->yieldContent('meta_description', 'Warriors Educare connects educators and schools across India. Find top teaching jobs or hire expert educators with us.'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Lora:wght@400;500;600;700&family=Oswald:wght@300;400;500;600;700&family=Nunito:wght@300;400;500;600;700&family=Fira+Code:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="icon" type="image/png" href="<?php echo e(asset('adobe.png')); ?>?v=<?php echo e(time()); ?>">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        .marquee-swiper {
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }

        .marquee-swiper .swiper-wrapper {
            transition-timing-function: linear !important;
        }

        .marquee-swiper .swiper-slide {
            width: auto !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        .hero-bg-pattern {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(18, 154, 239, 0.08) 0%, transparent 40%);
        }

        .hero-waves {
            background-image: repeating-linear-gradient(transparent, transparent 10px, rgba(255, 255, 255, 0.03) 10px, rgba(255, 255, 255, 0.03) 11px);
            mask-image: radial-gradient(circle, black 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(circle, black 40%, transparent 100%);
        }

        .zigzag-divider {
            background-image: linear-gradient(135deg, transparent 25%, white 25%, white 50%, transparent 50%, transparent 75%, white 75%, white 100%);
            background-size: 10px 10px;
        }

        .git-bg-pattern {
            background-image:
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 20%),
                radial-gradient(circle at 10% 80%, rgba(255, 255, 255, 0.04) 0%, transparent 30%);
        }

        .fade-out {
            opacity: 0;
            transform: scale(0.95);
        }

        .float-fade-out {
            opacity: 0 !important;
            transform: translateY(20px) !important;
        }

        .shadow-glow-blue {
            box-shadow: 0 4px 15px rgba(18, 154, 239, 0.25);
        }

        .shadow-glow-yellow {
            box-shadow: 0 8px 20px rgba(255, 184, 0, 0.25);
        }

        .shadow-card {
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .shadow-card-hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.10);
        }

        /* Scroll-triggered animations via IntersectionObserver */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: all 0.7s cubic-bezier(.22, .61, .36, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        .reveal-delay-4 {
            transition-delay: 0.4s;
        }

        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* Smooth header on scroll */
        .header-scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            background-image: none !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12) !important;
            border-color: #f1f5f9 !important;
        }

        /* Geometric pattern for header */
        .bg-geometric-navy {
            background-color: #031b4e;
        }

        @keyframes patternMove {
            0% { transform: scale(1.1) translate(0px, 0px); }
            33% { transform: scale(1.1) translate(15px, -20px); }
            66% { transform: scale(1.1) translate(-20px, 10px); }
            100% { transform: scale(1.1) translate(0px, 0px); }
        }
        .animate-pattern-move {
            animation: patternMove 30s ease-in-out infinite;
        }

        .glowing-blue-bg {
            background-color: rgba(3, 27, 78, 0.85); /* Matches theme #031b4e */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Metallic Blue Shiny Cards */
        .metallic-blue-card {
            background: linear-gradient(145deg, #005c97, #1e3c72, #2a5298);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3), inset 0 2px 3px rgba(255, 255, 255, 0.4);
        }
        .metallic-blue-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            animation: shine 9s infinite;
        }
        @keyframes shine {
            0% { left: -100%; }
            60% { left: 200%; }
            100% { left: 200%; }
        }

        /* Hover state for Metallic Blue */
        .group:hover .group-hover\:metallic-blue-card {
            background: linear-gradient(145deg, #005c97, #1e3c72, #2a5298) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3), inset 0 2px 3px rgba(255, 255, 255, 0.4);
        }
        .group-hover\:metallic-blue-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .group:hover .group-hover\:metallic-blue-card::after {
            opacity: 1;
            animation: shine 2s infinite;
        }

        /* Light Metallic Blue Shiny Cards */
        .light-metallic-blue-card {
            background: linear-gradient(145deg, #e0f2fe, #bae6fd, #7dd3fc);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.15), inset 0 2px 3px rgba(255, 255, 255, 0.8);
        }
        .light-metallic-blue-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            animation: shine 6s infinite;
        }
            /* Shiny Button */
        .shiny-btn {
            position: relative;
            overflow: hidden;
        }
        .shiny-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            animation: shine 3s infinite;
        }
    </style>
</head>

<body class="<?php echo e(request()->is('candidate*') || request()->is('employer*') ? 'bg-[#f4f7f5] text-gray-900' : 'bg-secondary-bg text-text-dark'); ?> <?php echo e(session()->has('impersonate_admin_id') ? 'pt-10' : ''); ?>">

    <!-- Preloader removed per user request -->

    <?php if(session()->has('impersonate_admin_id')): ?>
        <div class="fixed top-0 left-0 w-full z-[9999] bg-gradient-to-r from-red-600 to-red-500 text-white text-center py-2 px-4 shadow-lg flex justify-center items-center gap-4 text-sm font-semibold">
            <span><i class="fas fa-user-secret mr-2"></i> You are currently impersonating <strong><?php echo e(auth()->user()->name); ?></strong> (<?php echo e(ucfirst(auth()->user()->role)); ?>).</span>
            <a href="<?php echo e(route('admin.impersonate.leave')); ?>" class="bg-white text-red-600 px-3 py-1 rounded-full text-xs font-bold hover:bg-red-50 transition-colors shadow-sm">
                Return to Admin <i class="fas fa-sign-out-alt ml-1"></i>
            </a>
        </div>
    <?php endif; ?>

            </div>

        <!-- Global Marquee Bar -->
    <div class="fixed top-0 left-0 w-full bg-gradient-to-r from-[#031b4e] via-[#031b4e] to-[#031b4e] text-white text-[12px] md:text-sm py-2 px-4 font-semibold tracking-wide shadow-md z-[101] border-b border-white/10">
        <marquee behavior="scroll" direction="left" scrollamount="5" class="w-full flex items-center">
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-bolt"></i></span>
            <span>Welcome to Warriors Educare! Empowering your journey with expert guidance and tailored solutions.</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-star"></i></span>
            <span>Latest Updates: New consulting services available. Contact us for a free evaluation!</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-bolt"></i></span>
            <span>Join our community today and take the next step in your career.</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-graduation-cap"></i></span>
            <span>Boost your career with our specialized resume building and interview prep services.</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-globe"></i></span>
            <span>Connecting top talent with leading employers globally. Explore opportunities now!</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-star"></i></span>
            <span>Sign up today to get exclusive access to premium job listings and career resources.</span>

            <span class="mx-4 text-[#ff8800]"><i class="fas fa-bolt"></i></span>
            <span>Welcome to Warriors Educare! Empowering your journey with expert guidance and tailored solutions.</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-star"></i></span>
            <span>Latest Updates: New consulting services available. Contact us for a free evaluation!</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-bolt"></i></span>
            <span>Join our community today and take the next step in your career.</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-graduation-cap"></i></span>
            <span>Boost your career with our specialized resume building and interview prep services.</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-globe"></i></span>
            <span>Connecting top talent with leading employers globally. Explore opportunities now!</span>
            
            <span class="mx-4 text-[#ff8800]"><i class="fas fa-star"></i></span>
            <span>Sign up today to get exclusive access to premium job listings and career resources.</span>
        </marquee>
    </div>    <!-- Header -->
    <header id="main-header"
        class="!fixed top-[48px] left-1/2 -translate-x-1/2 w-[95%] max-w-7xl px-4 lg:px-8 py-1 flex justify-between items-center z-[100] transition-all duration-500 metallic-blue-card rounded-full">
        <a href="#" class="flex items-center no-underline py-1 z-10">
            <img src="<?php echo e(asset('adobe.png')); ?>" alt="Warriors Educare Logo" class="h-12 lg:h-14 logo-img transition-all duration-300">
        </a>
        <nav class="hidden lg:flex items-center gap-4 xl:gap-6">
            <ul class="flex gap-3 lg:gap-4 xl:gap-6 list-none m-0 p-0">
                <li><a href="<?php echo e(route('home')); ?>"
                        class="<?php echo e(request()->routeIs('home') ? 'text-white font-bold' : 'text-gray-200 hover:text-white'); ?> whitespace-nowrap font-medium text-[14px] lg:text-[15px] transition-colors">Home</a>
                </li>
                <li><a href="<?php echo e(route('about')); ?>"
                        class="<?php echo e(request()->routeIs('about') ? 'text-white font-bold' : 'text-gray-200 hover:text-white'); ?> whitespace-nowrap font-medium text-[14px] lg:text-[15px] transition-colors">About us</a></li>
                <li><a href="<?php echo e(route('services')); ?>"
                        class="<?php echo e(request()->routeIs('services') ? 'text-white font-bold' : 'text-gray-200 hover:text-white'); ?> whitespace-nowrap font-medium text-[14px] lg:text-[15px] transition-colors">Services</a></li>
                <li><a href="<?php echo e(route('jobs')); ?>"
                        class="<?php echo e(request()->routeIs('jobs') ? 'text-white font-bold' : 'text-gray-200 hover:text-white'); ?> whitespace-nowrap font-medium text-[14px] lg:text-[15px] transition-colors">Jobs</a>
                </li>
                <li><a href="<?php echo e(route('resume.builder')); ?>"
                        class="<?php echo e(request()->routeIs('resume.builder') ? 'text-white font-bold' : 'text-gray-200 hover:text-white'); ?> whitespace-nowrap font-medium text-[15px] transition-colors">Resume Builder <span
                            class="bg-accent-blue text-white text-[9px] px-1.5 py-0.5 rounded-sm uppercase font-extrabold ml-1 relative -top-1">Free</span></a>
                </li>
                <li><a href="<?php echo e(route('contact')); ?>"
                        class="<?php echo e(request()->routeIs('contact') ? 'text-white font-bold' : 'text-gray-200 hover:text-white'); ?> whitespace-nowrap font-medium text-[15px] transition-colors">Contact</a></li>
            </ul>
            <div class="flex gap-3 lg:gap-4 items-center">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(auth()->user()->role === 'candidate' ? route('candidate.dashboard') : (auth()->user()->role === 'employer' ? route('employer.dashboard') : (auth()->user()->role === 'parent' ? route('parent.dashboard') : route('admin.dashboard')))); ?>"
                        class="px-5 py-2.5 rounded font-medium text-[14px] cursor-pointer transition-all bg-white/20 text-white hover:bg-white/30 border border-white/30 flex items-center gap-2 whitespace-nowrap">
                        <div
                            class="w-6 h-6 rounded-full bg-white text-[#031b4e] flex items-center justify-center text-[10px] font-bold">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                        Dashboard
                    </a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="px-4 py-2.5 rounded font-medium text-[14px] cursor-pointer transition-all text-white hover:bg-white/10 border border-white/30 flex items-center gap-1.5">
                            <i class="fas fa-sign-out-alt text-xs"></i> Logout
                        </button>
                    </form>
                <?php else: ?>
                    <a href="/login"
                        class="px-4 py-2 rounded font-medium text-[14px] text-white/90 hover:text-white transition-colors whitespace-nowrap">
                        Login
                    </a>
                    <a href="/register"
                        class="px-6 py-2.5 rounded font-semibold text-[14px] bg-white text-[#031b4e] hover:bg-gray-100 transition-colors shadow-lg whitespace-nowrap">
                        Get Started
                    </a>
                <?php endif; ?>
            </div>
        </nav>
        <button id="mobileMenuBtn" class="lg:hidden text-[#031b4e] text-2xl focus:outline-none z-10">
            <i class="fas fa-bars"></i>
        </button>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenu"
        class="fixed inset-0 bg-primary-bg z-[105] transform translate-x-full transition-transform duration-300 lg:hidden flex flex-col">
        <div class="flex justify-between items-center p-6 border-b border-card-border">
            <img src="<?php echo e(asset('adobe.png')); ?>" alt="Warriors Educare Logo" class="h-10">
            <button id="closeMobileMenuBtn" class="text-text-main text-2xl focus:outline-none"><i
                    class="fas fa-times"></i></button>
        </div>
        <div class="flex-grow overflow-y-auto p-6 flex flex-col gap-6">
            <ul class="flex flex-col gap-5 text-lg font-semibold">
                <li><a href="<?php echo e(route('home')); ?>"
                        class="<?php echo e(request()->routeIs('home') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">Home</a>
                </li>
                <li><a href="<?php echo e(route('about')); ?>"
                        class="<?php echo e(request()->routeIs('about') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">About
                        us</a></li>
                <li><a href="<?php echo e(route('services')); ?>"
                        class="<?php echo e(request()->routeIs('services') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">Our
                        Services</a></li>
                <li><a href="<?php echo e(route('jobs')); ?>"
                        class="<?php echo e(request()->routeIs('jobs') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">Jobs</a>
                </li>
                <li><a href="<?php echo e(route('resume.builder')); ?>"
                        class="<?php echo e(request()->routeIs('resume.builder') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">Resume
                        Builder <span
                            class="bg-accent-yellow text-white text-[8px] px-1 py-0.5 rounded uppercase font-bold ml-1 relative -top-1">Free</span></a>
                </li>
                <li><a href="<?php echo e(route('hiring')); ?>"
                        class="<?php echo e(request()->routeIs('hiring') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">Hiring
                        Process</a></li>
                <li><a href="<?php echo e(route('contact')); ?>"
                        class="<?php echo e(request()->routeIs('contact') ? 'text-accent-blue' : 'text-text-main hover:text-accent-blue'); ?> transition-colors">Contact
                        us</a></li>
            </ul>

            <div class="h-px bg-card-border w-full"></div>

            <div class="flex flex-col gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(auth()->user()->role === 'candidate' ? route('candidate.dashboard') : (auth()->user()->role === 'employer' ? route('employer.dashboard') : (auth()->user()->role === 'parent' ? route('parent.dashboard') : route('admin.dashboard')))); ?>"
                        class="px-5 py-3.5 rounded-xl font-medium text-center bg-accent-blue text-white shadow-glow-blue flex items-center justify-center gap-2">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="w-full px-5 py-3.5 rounded-xl font-medium text-center text-red-400 border border-red-500/20 hover:bg-red-500/10 transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                <?php else: ?>
                    <a href="/login"
                        class="px-5 py-3.5 rounded-xl font-medium text-center bg-white/10 text-text-main">Login</a>
                    <a href="/register"
                        class="px-5 py-3.5 rounded-xl font-medium text-center bg-accent-blue text-white shadow-glow-blue">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main class="min-h-screen" style="<?php echo e(!request()->routeIs('home') ? 'padding-top: 140px;' : ''); ?>">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

                    <!-- Footer -->
    <footer class="bg-gradient-to-br from-[#f0f4f8] to-[#ffffff] pt-20 pb-8 text-[#555] font-sans relative overflow-hidden border-t border-gray-200">
        <!-- Decorative Background Elements -->
        <svg class="absolute right-[-5%] bottom-[-10%] w-[50%] h-[120%] z-0 text-[#dbeafe] pointer-events-none opacity-60" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="300" cy="300" r="200" stroke="currentColor" stroke-width="50"/>
            <circle cx="300" cy="300" r="320" stroke="currentColor" stroke-width="40"/>
        </svg>
        <svg class="absolute left-[-10%] top-[-10%] w-[40%] h-[120%] z-0 text-[#dbeafe] pointer-events-none opacity-70" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M 0 0 C 150 100, 250 200, 100 450" stroke="currentColor" stroke-width="40" stroke-linecap="round"/>
            <path d="M -50 50 C 100 150, 200 250, 50 500" stroke="currentColor" stroke-width="30" stroke-linecap="round"/>
        </svg>
        <div class="absolute inset-0 bg-[radial-gradient(#a3b8ad_1.5px,transparent_1.5px)] [background-size:24px_24px] opacity-[0.2] z-0 pointer-events-none"></div>

        <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-16 mb-16 relative z-10">
            <!-- Brand -->
            <div>
                <a href="<?php echo e(route('home')); ?>" class="flex items-center no-underline mb-6">
                    <img src="<?php echo e(asset('adobe.png')); ?>" alt="Warriors Educare Logo" class="h-20">
                </a>
                <p class="text-[13px] text-gray-600 font-medium leading-[1.8] mb-8 pr-4">
                    Our goal is to demystify the process, address your concerns, and empower you with the knowledge to embark.
                </p>
                <div class="flex items-center gap-3">
                    <a href="#" class="w-[34px] h-[34px] rounded-full bg-[#031b4e] text-white flex items-center justify-center hover:bg-[#004de6] hover:-translate-y-1 transition-all shadow-md text-sm"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-[34px] h-[34px] rounded-full bg-[#031b4e] text-white flex items-center justify-center hover:bg-[#004de6] hover:-translate-y-1 transition-all shadow-md text-sm"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="w-[34px] h-[34px] rounded-full bg-[#031b4e] text-white flex items-center justify-center hover:bg-[#004de6] hover:-translate-y-1 transition-all shadow-md text-sm"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="w-[34px] h-[34px] rounded-full bg-[#031b4e] text-white flex items-center justify-center hover:bg-[#004de6] hover:-translate-y-1 transition-all shadow-md text-sm font-bold">X</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-[17px] font-bold text-gray-900 mb-6 relative inline-block">Quick Links<span class="absolute bottom-[-6px] left-0 w-1/2 h-[2px] bg-[#031b4e]"></span></h4>
                <ul class="flex flex-col gap-4 text-[13px] text-gray-600 font-semibold mt-4">
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> About Us</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Our Services</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Our Solution</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Our Blog</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Contact Us</a></li>
                </ul>
            </div>

            <!-- Our Services -->
            <div>
                <h4 class="text-[17px] font-bold text-gray-900 mb-6 relative inline-block">Our Services<span class="absolute bottom-[-6px] left-0 w-1/2 h-[2px] bg-[#031b4e]"></span></h4>
                <ul class="flex flex-col gap-4 text-[13px] text-gray-600 font-semibold mt-4">
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Accounting Finance</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Business Consulting</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Technology Services</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Logistics Services</a></li>
                    <li><a href="#" class="hover:text-[#031b4e] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#031b4e]/60"></i> Front Line Support</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div>
                <h4 class="text-[17px] font-bold text-gray-900 mb-6 relative inline-block">Contact Us<span class="absolute bottom-[-6px] left-0 w-1/2 h-[2px] bg-[#031b4e]"></span></h4>
                <ul class="flex flex-col gap-5 text-[13px] text-gray-600 font-semibold mt-4">
                    <li class="flex items-start gap-3 group">
                        <div class="w-7 h-7 rounded bg-white shadow-sm flex items-center justify-center shrink-0 group-hover:bg-[#031b4e] transition-colors"><i class="fas fa-phone-alt text-[#031b4e] group-hover:text-white text-xs transition-colors"></i></div>
                        <span class="mt-1">+1 123 456 7890</span>
                    </li>
                    <li class="flex items-start gap-3 group">
                        <div class="w-7 h-7 rounded bg-white shadow-sm flex items-center justify-center shrink-0 group-hover:bg-[#031b4e] transition-colors"><i class="fas fa-map-marker-alt text-[#031b4e] group-hover:text-white text-xs transition-colors"></i></div>
                        <span class="mt-1">421 Allen, Mexico 4233</span>
                    </li>
                    <li class="flex items-start gap-3 group">
                        <div class="w-7 h-7 rounded bg-white shadow-sm flex items-center justify-center shrink-0 group-hover:bg-[#031b4e] transition-colors"><i class="fas fa-envelope text-[#031b4e] group-hover:text-white text-xs transition-colors"></i></div>
                        <span class="mt-1">staffingagency@com</span>
                    </li>
                    <li class="flex items-start gap-3 group">
                        <div class="w-7 h-7 rounded bg-white shadow-sm flex items-center justify-center shrink-0 group-hover:bg-[#031b4e] transition-colors"><i class="fas fa-globe text-[#031b4e] group-hover:text-white text-xs transition-colors"></i></div>
                        <span class="mt-1">staffingagency.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-[1200px] mx-auto px-6 border-t border-gray-300 pt-6 text-center text-[13px] text-gray-500 font-medium relative z-10">
            &copy; Copyright 2024 - Warriors Educare. All Right Reserved
        </div>
    </footer>

    <!-- FABs -->
    <div class="fixed right-6 bottom-6 flex flex-col gap-3 z-[999]">
        <a href="tel:+917070938975" title="Call Us"
            class="w-12 h-12 rounded-full flex items-center justify-center text-text-main text-lg no-underline shadow-lg transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-accent-blue"><i
                class="fas fa-phone-alt"></i></a>
        <a href="https://wa.me/917070938975" target="_blank" title="WhatsApp Us"
            class="w-12 h-12 rounded-full flex items-center justify-center text-text-main text-xl no-underline shadow-lg transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-[#25D366]"><i
                class="fab fa-whatsapp"></i></a>
        <a href="#" title="Scroll to Top"
            class="w-12 h-12 rounded-full flex items-center justify-center text-text-main text-lg no-underline shadow-lg transition-all duration-300 hover:scale-110 hover:-translate-y-1 bg-accent-blue"
            onclick="window.scrollTo({top:0,behavior:'smooth'}); return false;"><i class="fas fa-chevron-up"></i></a>
    </div>

    <!-- Scripts -->
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // ---- Swiper Initialization ----
        document.addEventListener('DOMContentLoaded', function () {
            const swipers = document.querySelectorAll('.marquee-swiper');
            swipers.forEach(function (swiperEl) {
                new Swiper(swiperEl, {
                    loop: true,
                    slidesPerView: 'auto',
                    spaceBetween: 24,
                    speed: 2000,
                    autoplay: {
                        delay: 0,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    freeMode: true,
                    grabCursor: true,
                });
            });
        });

        // ---- Scroll-triggered reveal animations ----
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ---- Header shrink on scroll ----
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                header.classList.remove('py-2');
                header.classList.add('py-1');
            } else {
                header.classList.add('py-2');
                header.classList.remove('py-1');
            }
        });

        // ---- Role Toggle ----
        const contentData = {
            seeker: {
                title: "Get placed in top<br>schools across...",
                subtitle: "step into the right opportunity with trusted schools that value your talent",
                ctaText: "Job Seeker",
                ctaLink: "<?php echo e(route('candidate.register')); ?>",
                imgUrl: "images/men.jpg",
                fc1Title: "20K +",
                fc1Desc: "Job Vacancy",
                fc1Icon: "fa-briefcase",
                fc1Color: "bg-accent-yellow",
                fc2Title: "1+ Million",
                fc2Desc: "Trusted User",
                fc2HTML: `
                    <img src="https://i.pravatar.cc/100?img=11" alt="User" class="w-7 h-7 rounded-full border-2 border-white first:ml-0">
                    <img src="https://i.pravatar.cc/100?img=32" alt="User" class="w-7 h-7 rounded-full border-2 border-white -ml-2">
                    <img src="https://i.pravatar.cc/100?img=44" alt="User" class="w-7 h-7 rounded-full border-2 border-white -ml-2">
                    <img src="https://i.pravatar.cc/100?img=55" alt="User" class="w-7 h-7 rounded-full border-2 border-white -ml-2">
                    <div class="w-7 h-7 rounded-full bg-accent-yellow text-[#031b4e] flex items-center justify-center font-bold border-2 border-white -ml-2 text-[10px]">+</div>
                `
            },
            employer: {
                title: "Hire the Minds <br> That Shape Tomorrow",
                subtitle: "partner with us to find top-tier teaching professionals for your institution",
                ctaText: "Employer",
                ctaLink: "<?php echo e(route('employer.register')); ?>",
                imgUrl: "images/women.jpg",
                fc1Title: "500+",
                fc1Desc: "Partner Schools",
                fc1Icon: "fa-building",
                fc1Color: "bg-accent-blue",
                fc2Title: "Fast Hiring",
                fc2Desc: "Quality candidates",
                fc2HTML: `
                    <div class="text-xl text-accent-blue font-bold p-1"><i class="fas fa-bolt"></i></div>
                `
            }
        };

        let currentRole = 'seeker';

        function toggleRole(role) {
            if (role === currentRole) return;
            currentRole = role;

            const btnSeeker = document.getElementById('btn-seeker');
            const btnEmployer = document.getElementById('btn-employer');
            const btnSeekerMob = document.getElementById('btn-seeker-mobile');
            const btnEmployerMob = document.getElementById('btn-employer-mobile');

            const activeClass = "role-btn flex-1 py-3.5 rounded-lg text-[15px] font-extrabold flex items-center justify-center gap-2.5 transition-all duration-300 bg-gradient-to-r from-[#2196f3] to-[#00bcd4] text-white shadow-md";
            const inactiveClass = "role-btn flex-1 py-3.5 rounded-lg text-[15px] font-extrabold text-slate-800 flex items-center justify-center gap-2.5 transition-all duration-300 bg-transparent hover:bg-slate-50";

            if (role === 'seeker') {
                if (btnSeeker) btnSeeker.className = activeClass;
                if (btnEmployer) btnEmployer.className = inactiveClass;
                if (btnSeekerMob) btnSeekerMob.className = activeClass;
                if (btnEmployerMob) btnEmployerMob.className = inactiveClass;
            } else {
                if (btnEmployer) btnEmployer.className = activeClass;
                if (btnSeeker) btnSeeker.className = inactiveClass;
                if (btnEmployerMob) btnEmployerMob.className = activeClass;
                if (btnSeekerMob) btnSeekerMob.className = inactiveClass;
            }

            const data = contentData[role];

            const elementsToFade = [
                document.getElementById('hero-title'),
                document.getElementById('hero-subtitle'),
                document.getElementById('hero-img')
            ];
            const floatingCards = [
                document.getElementById('fc-1'),
                document.getElementById('fc-2')
            ];

            elementsToFade.forEach(el => el.classList.add('fade-out'));
            floatingCards.forEach(el => el.classList.add('float-fade-out'));

            const svgRings = document.getElementById('hero-svg-rings');
            if (svgRings) {
                const currentRot = parseInt(svgRings.dataset.rot || 0);
                const newRot = currentRot + 180;
                svgRings.style.transform = `rotate(${newRot}deg)`;
                svgRings.dataset.rot = newRot;
            }

            setTimeout(() => {
                document.getElementById('hero-title').innerHTML = data.title;
                document.getElementById('hero-subtitle').innerHTML = data.subtitle;
                document.getElementById('cta-text').innerText = data.ctaText;
                document.getElementById('hero-cta-btn').href = data.ctaLink;
                document.getElementById('hero-img').src = data.imgUrl;

                document.getElementById('fc-1-title').innerText = data.fc1Title;
                document.getElementById('fc-1-desc').innerText = data.fc1Desc;
                document.getElementById('fc-1-icon').className = 'fas ' + data.fc1Icon;

                const iconWrap = document.getElementById('fc-1-icon-wrap');
                iconWrap.classList.remove('bg-accent-yellow', 'bg-accent-blue');
                iconWrap.classList.add(data.fc1Color);
                
                document.getElementById('fc-2-title').innerText = data.fc2Title;
                document.getElementById('fc-2-desc').innerText = data.fc2Desc;
                document.getElementById('fc-2-avatars').innerHTML = data.fc2HTML;

                elementsToFade.forEach(el => el.classList.remove('fade-out'));
                floatingCards.forEach(el => el.classList.remove('float-fade-out'));
            }, 300);
        }
    </script>
    <script>

        // Mobile Menu Logic
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const closeMobileMenuBtn = document.getElementById('closeMobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuBtn && closeMobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.remove('translate-x-full');
                });

                closeMobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.add('translate-x-full');
                });
            }
        });

        // Theme and Font Switcher Logic
        document.addEventListener('DOMContentLoaded', () => {
            const themeBtn = document.getElementById('themeSwitcherBtn');
            const themeDropdown = document.getElementById('themeDropdown');
            const htmlEl = document.documentElement;

            if (themeBtn && themeDropdown) {
                themeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (themeDropdown.classList.contains('hidden')) {
                        themeDropdown.classList.remove('hidden');
                        setTimeout(() => themeDropdown.classList.remove('opacity-0'), 10);
                    } else {
                        themeDropdown.classList.add('opacity-0');
                        setTimeout(() => themeDropdown.classList.add('hidden'), 200);
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!themeDropdown.contains(e.target) && !themeBtn.contains(e.target)) {
                        themeDropdown.classList.add('opacity-0');
                        setTimeout(() => themeDropdown.classList.add('hidden'), 200);
                    }
                });
            }

            const themeButtons = document.querySelectorAll('[data-set-theme]');
            const applyTheme = (theme) => {
                htmlEl.setAttribute('data-theme', theme);
                localStorage.setItem('Warriors Educare-theme', theme);
                themeButtons.forEach(btn => {
                    if (btn.dataset.setTheme === theme) {
                        btn.classList.add('border-accent-blue');
                        btn.classList.remove('border-transparent');
                    } else {
                        btn.classList.remove('border-accent-blue');
                        btn.classList.add('border-transparent');
                    }
                });
            };

            themeButtons.forEach(btn => {
                btn.addEventListener('click', () => applyTheme(btn.dataset.setTheme));
            });

            const fontButtons = document.querySelectorAll('[data-set-font]');
            const applyFont = (font) => {
                htmlEl.setAttribute('data-font', font);
                localStorage.setItem('Warriors Educare-font', font);

                const fontsMap = {
                    'outfit': "'Outfit', sans-serif",
                    'inter': "'Inter', sans-serif",
                    'roboto': "'Roboto', sans-serif",
                    'playfair': "'Playfair Display', serif",
                    'poppins': "'Poppins', sans-serif",
                    'montserrat': "'Montserrat', sans-serif",
                    'lora': "'Lora', serif",
                    'oswald': "'Oswald', sans-serif",
                    'nunito': "'Nunito', sans-serif",
                    'fira': "'Fira Code', monospace"
                };
                document.body.style.fontFamily = fontsMap[font] || "'Outfit', sans-serif";

                fontButtons.forEach(btn => {
                    if (btn.dataset.setFont === font) {
                        btn.classList.replace('text-text-dark', 'text-text-main');
                        btn.classList.add('bg-white/10');
                    } else {
                        btn.classList.replace('text-text-main', 'text-text-dark');
                        btn.classList.remove('bg-white/10');
                    }
                });
            };

            fontButtons.forEach(btn => {
                btn.addEventListener('click', () => applyFont(btn.dataset.setFont));
            });

            const savedTheme = localStorage.getItem('Warriors Educare-theme') || 'dark';
            const savedFont = localStorage.getItem('Warriors Educare-font') || 'outfit';
            applyTheme(savedTheme);
            applyFont(savedFont);
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const typeElements = document.querySelectorAll('.typewriter-effect');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (!entry.target.classList.contains('typing-done')) {
                        entry.target.classList.add('typing-done');
                        const text = entry.target.getAttribute('data-original-text');
                        const speed = parseInt(entry.target.getAttribute('data-speed')) || 40;
                        entry.target.innerHTML = '';
                        
                        if (entry.target.typeTimeout) clearTimeout(entry.target.typeTimeout);
                        
                        let i = 0;
                        function typeWriter() {
                            if (!entry.target.classList.contains('typing-done')) return;
                            const currentFullText = entry.target.getAttribute('data-original-text');
                            
                            if (i < currentFullText.length) {
                                let currentText = currentFullText.substring(0, i + 1);
                                let textHtml = currentText.replace(/\n/g, '<br>');
                                
                                const highlight = entry.target.getAttribute('data-highlight');
                                const highlightColor = entry.target.getAttribute('data-highlight-color') || 'text-[#0ea5e9]';
                                if (highlight && textHtml.includes(highlight)) {
                                    textHtml = textHtml.replace(highlight, `<span class="${highlightColor}">${highlight}</span>`);
                                }
                                
                                entry.target.innerHTML = textHtml + '<span class="animate-pulse text-[#3b82f6]">|</span>';
                                i++;
                                entry.target.typeTimeout = setTimeout(typeWriter, speed);
                            } else {
                                let finalHtml = currentFullText.replace(/\n/g, '<br>');
                                const highlight = entry.target.getAttribute('data-highlight');
                                const highlightColor = entry.target.getAttribute('data-highlight-color') || 'text-[#0ea5e9]';
                                if (highlight && finalHtml.includes(highlight)) {
                                    finalHtml = finalHtml.replace(highlight, `<span class="${highlightColor}">${highlight}</span>`);
                                }
                                entry.target.innerHTML = finalHtml;
                                
                                const repeatTime = parseInt(entry.target.getAttribute('data-repeat')) || 12000;
                                // Restart animation after specified seconds
                                entry.target.typeTimeout = setTimeout(() => {
                                    i = 0;
                                    entry.target.innerHTML = '';
                                    typeWriter();
                                }, repeatTime);
                            }
                        }
                        
                        // Expose restart capability
                        entry.target.restartTypewriter = () => {
                            if (entry.target.typeTimeout) clearTimeout(entry.target.typeTimeout);
                            i = 0;
                            entry.target.innerHTML = '';
                            typeWriter();
                        };
                        
                        entry.target.typeTimeout = setTimeout(typeWriter, 200);
                    }
                } else {
                    entry.target.classList.remove('typing-done');
                    if (entry.target.typeTimeout) clearTimeout(entry.target.typeTimeout);
                    entry.target.innerHTML = '&nbsp;';
                }
            });
        }, { threshold: 0.2 });

        typeElements.forEach(el => {
            el.setAttribute('data-original-text', el.innerText.trim());
            el.innerHTML = '&nbsp;'; 
            observer.observe(el);
        });
    });
    </script>
</body>

</html>

<?php /**PATH E:\warriors portal\warriors portal\resources\views/layouts/app.blade.php ENDPATH**/ ?>