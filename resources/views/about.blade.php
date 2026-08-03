@extends('layouts.app')

@section('title', 'About Us - Best Education Recruitment Agency in India | Warriors Educare')
@section('meta_description', 'Discover Warriors Educare, India\'s leading education recruitment experts. We connect top teaching talent with premier schools and institutions.')

@section('content')

<!-- 1. Hero Section -->
<div class="relative w-full bg-[#040e2d] text-white py-24 md:py-32 overflow-hidden flex items-center justify-center">
    <!-- Background overlay / image -->
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center opacity-60"></div>
    <div class="absolute inset-0 bg-black/40"></div>
    
    <div class="relative z-10 text-center px-6">
        <!-- <h1 class="text-[10px] md:text-sm font-black mb-4 uppercase tracking-[0.3em] text-[#129aef]">DIGITAL MARKETING AGENCY WEBSITE TEMPLATE</h1> -->
        <h2 class="text-4xl md:text-5xl font-black mb-6 text-white tracking-wide">About Us</h2>
        <div class="flex items-center justify-center gap-3 text-sm font-bold text-white/70 uppercase tracking-widest">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <span class="text-[#129aef] font-black">›</span>
            <span class="text-white">About Us</span>
        </div>
    </div>
</div>

<!-- 2. First Section (Who We Are + Blob) -->
<div class="py-24 px-6 lg:px-[5%] bg-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#129aef_1px,transparent_1px)] [background-size:32px_32px] opacity-[0.03]"></div>
    
    <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Left Side: Text -->
        <div>
            <span class="text-[#129aef] font-bold tracking-widest uppercase text-xs mb-3 block">ABOUT US</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-[#040e2d] leading-[1.15] mb-6">We're Strategic Education Recruitment Experts</h2>
            
            <p class="text-slate-500 text-sm leading-relaxed mb-6">
                Welcome to <strong>Warriors Educare</strong>, the most trusted name in <strong>education recruitment across India</strong>. 
                With years of specialized experience, we serve as the vital bridge connecting passionate educators with premier educational institutions.
            </p>
            <p class="text-slate-500 text-sm leading-relaxed mb-10">
                Whether you are a school looking to hire top-tier teaching faculty or an educator seeking the perfect teaching job, our comprehensive placement services are tailored to meet your unique needs. We provide end-to-end recruitment solutions.
            </p>
            
            <!-- 2 Stats -->
            <div class="flex flex-wrap gap-12 items-center pt-2">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 text-xl shadow-sm border border-blue-100">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-[#040e2d]">84%</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">SUCCESS RATE</div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 text-xl shadow-sm border border-emerald-100">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-[#040e2d]">65%</div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">GROWTH RATE</div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12">
                <a href="{{ route('about') }}" class="inline-flex items-center gap-3 bg-[#eef2ff] text-indigo-600 px-6 py-2.5 rounded-full font-bold shadow-sm hover:bg-indigo-600 hover:text-white transition-all text-xs tracking-wider">
                    DISCOVER <span class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center"><i class="fas fa-arrow-right text-[10px]"></i></span>
                </a>
            </div>
        </div>
        
        <!-- Right Side: Blob Image -->
        <div class="relative flex justify-center items-center">
            <!-- Organic Blob Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#e0f2fe] via-[#ddd6fe] to-[#c7d2fe] rounded-full filter blur-3xl opacity-60 transform -translate-x-10 translate-y-10"></div>
            
            <!-- Main solid shape behind image -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#f8fafc] to-[#e0e7ff] opacity-80 rounded-[40px] transform rotate-[-5deg] scale-90"></div>

            <div class="relative w-[320px] md:w-[480px] aspect-square z-10 flex justify-center items-center">
                <!-- SVG Blob mask for image -->
                <div class="absolute inset-0 bg-indigo-100 rounded-[100px] rounded-tl-[150px] rounded-br-[150px] overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Education Professional" class="w-full h-full object-cover">
                </div>
                
                <!-- Floating Elements -->
                <div class="absolute top-4 -left-6 bg-white px-3 py-1.5 rounded-xl shadow-lg border border-slate-50 flex items-center gap-2 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-6 h-6 bg-red-100 text-red-500 rounded-full flex items-center justify-center text-[10px]"><i class="fas fa-heart"></i></div>
                    <div class="font-bold text-slate-800 text-xs">100+</div>
                </div>
                
                <div class="absolute bottom-8 -right-4 bg-white p-2.5 rounded-2xl shadow-xl border border-slate-50 flex items-center gap-3 animate-pulse" style="animation-duration: 4s;">
                    <div class="flex -space-x-3">
                        <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="">
                        <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="">
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600">+9</div>
                    </div>
                    <div class="pr-2">
                        <div class="text-[10px] font-bold text-slate-800">Active Users</div>
                    </div>
                </div>
                
                <!-- Small decorative shapes -->
                <div class="absolute -top-4 right-10 w-4 h-4 bg-cyan-400 rounded-sm transform rotate-45 opacity-80"></div>
                <div class="absolute bottom-4 left-10 w-3 h-3 bg-indigo-500 rounded-full opacity-80"></div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Second Section (Working Process) -->
<div class="py-24 px-6 lg:px-[5%] bg-gradient-to-b from-[#f8fafc] via-[#f1f5f9] to-[#f8fafc] relative overflow-hidden">
    <!-- Abstract wavy bg -->
    <div class="absolute -left-32 top-0 w-96 h-96 bg-blue-100 rounded-full filter blur-3xl opacity-50 pointer-events-none"></div>
    <div class="absolute -right-32 bottom-0 w-96 h-96 bg-purple-100 rounded-full filter blur-3xl opacity-50 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-20">
            <span class="text-indigo-600 font-bold tracking-widest uppercase text-xs mb-3 block">HOW WE WORK</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#040e2d] mb-4">Our Working Process</h2>
        </div>
        
        <div class="relative">
            <!-- Connecting Line (Desktop only) -->
            <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-[1px] bg-slate-300 border-t border-dashed border-slate-400"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                <!-- Step 1: Mission -->
                <div class="text-center group relative animate-float">
                    <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg mb-6 relative border-[8px] border-[#f8fafc] group-hover:border-indigo-50 transition-colors duration-300 group-hover:scale-110">
                        <div class="absolute -top-2 -right-2 w-7 h-7 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md">1</div>
                        <i class="fas fa-bullseye text-3xl text-indigo-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#040e2d] mb-2">Our Mission</h3>
                    <p class="text-xs text-slate-500 leading-relaxed px-4">Support schools by providing reliable recruitment solutions, connecting talented educators with institutions that value growth.</p>
                </div>
                
                <!-- Step 2: Vision -->
                <div class="text-center group relative animate-float-delay-1">
                    <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg mb-6 relative border-[8px] border-[#f1f5f9] group-hover:border-indigo-50 transition-colors duration-300 group-hover:scale-110">
                        <div class="absolute -top-2 -right-2 w-7 h-7 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md">2</div>
                        <i class="fas fa-lightbulb text-3xl text-indigo-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#040e2d] mb-2">Our Vision</h3>
                    <p class="text-xs text-slate-500 leading-relaxed px-4">Become a trusted recruitment partner across India, building a strong network of educators and contributing to education quality.</p>
                </div>
                
                <!-- Step 3: Commitment -->
                <div class="text-center group relative animate-float-delay-2">
                    <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg mb-6 relative border-[8px] border-[#f8fafc] group-hover:border-indigo-50 transition-colors duration-300 group-hover:scale-110">
                        <div class="absolute -top-2 -right-2 w-7 h-7 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md">3</div>
                        <i class="fas fa-handshake text-3xl text-indigo-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#040e2d] mb-2">Our Commitment</h3>
                    <p class="text-xs text-slate-500 leading-relaxed px-4">Providing dependable services through honesty, transparency, and consistent quality to create lasting partnerships with schools.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. Third Section (Why Choose Us) -->
<div class="py-24 px-6 lg:px-[5%] bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Left Side: Features -->
        <div class="pr-0 lg:pr-8">
            <span class="text-[#129aef] font-bold tracking-widest uppercase text-xs mb-3 block">WHY CHOOSE US</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#040e2d] mb-4">Why Choose Us</h2>
            <p class="text-slate-500 text-sm leading-relaxed mb-10">
                As a leading teacher placement agency, we offer unparalleled benefits to both schools and job seekers. Our rigorous approach ensures the best outcomes.
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10">
                <!-- Feature 1 -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center shrink-0 border border-blue-100 group-hover:scale-110 transition-transform duration-300 animate-float">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#040e2d] mb-1 text-sm group-hover:text-blue-600 transition-colors">Extensive Network</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Access our vast database of verified schools and pre-screened educators.</p>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center shrink-0 border border-indigo-100 group-hover:scale-110 transition-transform duration-300 animate-float-delay-1">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#040e2d] mb-1 text-sm group-hover:text-indigo-600 transition-colors">Quality Assurance</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Rigorous screening ensures only the most qualified professionals make it.</p>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center shrink-0 border border-cyan-100 group-hover:scale-110 transition-transform duration-300 animate-float-delay-2">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#040e2d] mb-1 text-sm group-hover:text-cyan-600 transition-colors">Dedicated Support</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Continuous support throughout the recruitment process for both parties.</p>
                    </div>
                </div>
                
                <!-- Feature 4 -->
                <div class="flex items-start gap-4 group">
                    <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center shrink-0 border border-purple-100 group-hover:scale-110 transition-transform duration-300 animate-float">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#040e2d] mb-1 text-sm group-hover:text-purple-600 transition-colors">Time Efficient</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">We streamline the hiring process, saving valuable time and resources.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Shape & Image -->
        <div class="relative flex justify-center lg:justify-end mt-12 lg:mt-0">
            <!-- Background Shape matching template -->
            <div class="w-[320px] h-[400px] md:w-[400px] md:h-[500px] bg-gradient-to-t from-blue-600 via-indigo-500 to-[#b14aed] rounded-tl-full rounded-tr-full rounded-bl-3xl rounded-br-3xl relative overflow-hidden shadow-2xl">
                <!-- Inner pattern -->
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.3)_0%,transparent_60%)]"></div>
                
                <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Why Choose Us" class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-[95%] object-cover object-top drop-shadow-2xl z-10" style="-webkit-mask-image: linear-gradient(to top, transparent 0%, black 10%); mask-image: linear-gradient(to top, transparent 0%, black 10%);">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    .animate-float-delay-1 {
        animation: float 4s ease-in-out 1s infinite;
    }
    .animate-float-delay-2 {
        animation: float 4s ease-in-out 2s infinite;
    }
</style>
@endpush
