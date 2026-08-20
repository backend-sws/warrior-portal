    

    <?php $__env->startSection('content'); ?>
        <!-- Hero Banner Section -->
    <style>
        .metallic-bubble {
            border-radius: 50%;
            background: radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.9) 0%, rgba(0, 191, 255, 0.8) 15%, rgba(0, 92, 197, 0.9) 45%, rgba(1, 24, 74, 1) 85%);
            box-shadow: 
                inset -15px -15px 30px rgba(0, 0, 0, 0.7), 
                inset 10px 10px 30px rgba(255, 255, 255, 0.5), 
                0 15px 35px rgba(0, 0, 0, 0.4);
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }
        .bubble-float-1 { animation: float1 15s infinite ease-in-out; }
        .bubble-float-2 { animation: float2 18s infinite ease-in-out reverse; }
        .bubble-float-3 { animation: float3 22s infinite ease-in-out; }
        
        @keyframes float1 { 
            0%, 100% { transform: translateY(0) scale(1); } 
            50% { transform: translateY(-40px) scale(1.05); } 
        }
        @keyframes float2 { 
            0%, 100% { transform: translateY(0) translateX(0); } 
            50% { transform: translateY(-50px) translateX(25px); } 
        }
        @keyframes float3 { 
            0%, 100% { transform: translateY(0) scale(1); } 
            50% { transform: translateY(-30px) scale(0.95); } 
        }
        @keyframes circleGlow {
            0%, 100% { 
                box-shadow: 0 0 15px rgba(255, 255, 255, 0.6), inset 0 0 15px rgba(255, 255, 255, 0.4); 
                border-color: rgba(255, 255, 255, 0.7); 
            }
            50% { 
                box-shadow: 0 0 45px rgba(255, 255, 255, 1), inset 0 0 25px rgba(255, 255, 255, 0.9); 
                border-color: rgba(255, 255, 255, 1); 
            }
        }
        .circle-glow {
            border-style: solid;
            border-width: 2.5px;
            border-radius: 50%;
            animation: circleGlow 4s infinite ease-in-out;
        }
        
        .smoky-metallic-text {
            background: linear-gradient(to right, #ffffff, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            transition: all 0.5s ease;
        }
        .smoky-metallic-text:hover {
            background: linear-gradient(
                90deg, 
                #ffffff 0%, 
                #89b4f8 20%, 
                #005c97 40%, 
                #1e3c72 50%, 
                #2a5298 60%, 
                #89b4f8 80%, 
                #ffffff 100%
            );
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            animation: smokeMove 3s linear infinite;
        }
        @keyframes smokeMove {
            to {
                background-position: 200% center;
            }
        }
        
        section.bg-white, section.bg-slate-50, section.bg-gray-50, section.bg-\[\#f4f7f5\], section.bg-\[\#f4f7f9\] {
            background-image: linear-gradient(rgba(255, 255, 255, 0.65), rgba(255, 255, 255, 0.75)), url('<?php echo e(asset('images/enhanced_building.jpg')); ?>') !important;
            background-size: cover !important;
            background-attachment: fixed !important;
            background-position: center !important;
        }
    </style>

    <section class="relative w-full bg-[#f4f7f9] pt-[140px] pb-16 lg:pt-[160px] lg:pb-24 overflow-hidden font-sans">
        
        <!-- Blurred Background Pattern -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            
            <!-- Blurred Gradient Orbs -->
            <div class="absolute -top-[15%] -left-[10%] w-[50%] h-[70%] rounded-full bg-gradient-to-br from-blue-400/20 to-indigo-500/10 blur-[100px]"></div>
            <div class="absolute top-[10%] -right-[15%] w-[45%] h-[80%] rounded-full bg-gradient-to-tl from-[#fbc043]/20 to-orange-400/10 blur-[120px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[50%] rounded-full bg-gradient-to-tr from-cyan-400/15 to-blue-600/10 blur-[120px]"></div>
        </div>

        <div class="max-w-[1400px] mx-auto px-4 lg:px-8 relative z-20 flex flex-col lg:flex-row items-center lg:items-stretch justify-between">
            
            <!-- Left Column: Typography & CTAs -->
            <div class="w-full lg:w-[42%] flex flex-col justify-center text-[#071520] relative z-20">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-white px-5 py-2.5 rounded-full shadow-sm w-max mb-8">
                    <div class="w-2 h-2 rounded-full bg-[#031b4e]"></div>
                    <span class="text-[10px] font-extrabold text-gray-800 tracking-wider uppercase">Tutors & Mentors</span>
                </div>
                
                <h1 id="hero-title" class="text-5xl lg:text-[4.5rem] xl:text-[5rem] leading-[1.1] font-extrabold tracking-tight text-[#0a1922] mb-8 relative z-20">
                    Find the best teachers and private <br>
                    <div class="relative w-max mt-4 mb-2">
                        <span class="bg-[#fbc043] text-[#1d2542] px-6 py-2 md:py-3 rounded-full inline-block relative z-20 shadow-md">tutors</span>
                    </div>
                </h1>

                <!-- Icon badges -->
                <div class="flex gap-5 mb-8">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-[#031b4e] text-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-[#031b4e] text-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm text-[#031b4e] text-lg hover:scale-110 transition-transform cursor-pointer">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>

                <div class="flex gap-6 items-start mb-10 mt-2">
                    <div class="w-16 h-[2px] bg-[#a0aec0] mt-3 hidden md:block opacity-50"></div>
                    <p id="hero-desc" class="text-gray-500 text-[14px] md:text-[15px] max-w-[350px] leading-relaxed font-medium">
                        We help you connect with expert teachers and dedicated tutors to ensure the best learning experience for a bright future.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?php echo e(route('parent.register')); ?>" id="btn-hire" class="bg-[#031b4e] text-white px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-[#021030] transition shadow-lg flex items-center justify-center">Hire a Teacher / Tutor</a>
                    <a href="<?php echo e(route('candidate.register')); ?>" id="btn-join" class="bg-white text-[#031b4e] px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-gray-50 transition border border-gray-200 shadow-sm flex items-center justify-center gap-2">Join as a Teacher / Tutor <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Center Column: Main Image -->
            <div class="w-full lg:w-[30%] relative mt-16 lg:mt-0 flex justify-center items-center z-10">
                
                <div class="relative w-full max-w-[420px] h-[500px] lg:h-[580px] bg-white rounded-[2.5rem] lg:rounded-[3rem] overflow-hidden shadow-2xl">
                    <img id="main-img" src="<?php echo e(asset('images/women.jpg')); ?>" alt="Main Image" class="w-full h-full object-cover">
                    



                </div>
            </div>

            <!-- Far Right Column: Explore Offerings & Second Image -->
            <div class="w-full lg:w-[18%] flex flex-col justify-center mt-16 lg:mt-0 gap-10">
                
                <div class="text-[#071520] pt-4">
                    <h3 class="text-3xl font-bold mb-4 leading-tight tracking-tight">Explore Our <br>Offerings</h3>
                    <p class="text-gray-500 text-[12px] leading-relaxed max-w-[200px]">
                        Whether you're a beginner or looking for advanced tutoring, our community is here to support your journey.
                    </p>
                </div>

                <div class="relative w-full max-w-[220px] h-[280px] rounded-[2rem] overflow-hidden shadow-xl border-4 border-white">
                    <img id="sub-img" src="<?php echo e(asset('images/student.png')); ?>" alt="Secondary Image" class="w-full h-full object-cover">
                    

                </div>

            </div>

        </div>
    </section>

    <!-- Lifestyle and Wellness Section -->
    <section class="relative w-full bg-[#031b4e] text-white">
        <!-- The S-Curve Light Overlay on the Right -->
        <div class="absolute top-[-1px] right-0 w-[55%] lg:w-[45%] h-[80px] lg:h-[120px] bg-[#f4f7f9] rounded-bl-[3rem] lg:rounded-bl-[5rem] z-10">
            <!-- Inverted Corner to blend with the dark left side -->
            <div class="absolute bottom-0 left-[-40px] lg:left-[-60px] w-[40px] lg:w-[60px] h-[40px] lg:h-[60px] bg-transparent rounded-br-[2rem] lg:rounded-br-[3rem]" style="box-shadow: 20px 20px 0 20px #f4f7f9;"></div>
        </div>

        <!-- Main Content of the Dark Section (Statistics) -->
        <div class="max-w-[1400px] mx-auto px-4 lg:px-12 relative z-20 pt-20 lg:pt-28 pb-16 lg:pb-24">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12 w-full">
                <!-- Stat 1 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="500">0</span><span class="text-[#dfa43a]">+</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Current Openings</p>
                </div>
                
                <!-- Stat 2 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="98">0</span><span class="text-[#dfa43a]">%</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Fulfillment Rate</p>
                </div>

                <!-- Stat 3 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="10">0</span>k<span class="text-[#dfa43a]">+</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Jobs Applied</p>
                </div>

                <!-- Stat 4 -->
                <div class="text-center group cursor-default">
                    <h3 class="text-5xl lg:text-[4.5rem] font-black text-white mb-3 tracking-tight drop-shadow-md leading-none"><span class="stat-number" data-target="350">0</span><span class="text-[#dfa43a]">+</span></h3>
                    <p class="text-[11px] lg:text-[13px] font-bold text-gray-300 uppercase tracking-widest mt-4">Satisfied Schools</p>
                </div>
            </div>
        </div>
        
        <!-- Dripping Liquid Effect -->
        <div class="absolute -bottom-[50px] md:-bottom-[80px] left-0 w-full h-[50px] md:h-[80px] z-[50] pointer-events-none" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 50' preserveAspectRatio='none'%3E%3Cpath fill='%23031b4e' d='M0,0 h300 v10 c-10,0 -15,20 -25,20 c-10,0 -15,-20 -25,-20 c-15,0 -20,40 -35,40 c-15,0 -20,-40 -35,-40 c-10,0 -12,15 -20,15 c-8,0 -10,-15 -20,-15 c-12,0 -18,30 -30,30 c-12,0 -18,-30 -30,-30 c-10,0 -15,25 -25,25 c-10,0 -15,-25 -25,-25 c-5,0 -10,15 -15,15 c-5,0 -10,-15 -15,-15 V0 Z' /%3E%3C/svg%3E&quot;); background-repeat: repeat-x; background-size: 300px 100%;"></div>
    </section>

        <!-- About / Empowering Section -->
        <section class="py-20 bg-white relative">
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row items-center gap-16">
                    
                    <!-- Left Images Grid (Redesigned Premium UI) -->
                    <div class="w-full md:w-1/2 relative flex justify-center items-center py-12 pl-4 lg:pl-12 min-h-[400px]">
                        
                        <!-- Background Container (Horizontal Dark Panel) -->
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[90%] md:w-[85%] h-[260px] bg-[#021438] rounded-[2rem] shadow-2xl flex justify-end items-center pr-8 z-0 overflow-visible border-[6px] border-[#021438]">
                            <!-- Inner decorative border line -->
                            <div class="absolute inset-2 border-2 border-gray-400/20 rounded-[1.5rem] pointer-events-none"></div>
                            
                            <!-- Inner Box (Stats) -->
                            <div class="bg-gradient-to-r from-gray-100 to-gray-300 rounded-[1.5rem] p-6 lg:p-8 shadow-xl relative z-10 mr-6 w-[200px] lg:w-[240px]">
                                <h3 class="text-[#031b4e] text-3xl lg:text-4xl font-black mb-1">12+</h3>
                                <p class="text-[11px] lg:text-xs font-extrabold text-gray-700 uppercase tracking-widest">Years of<br>Experience</p>
                                
                                <!-- Overlapping Arrow Button -->
                                <div id="about-arrow-btn" class="absolute -right-5 lg:-right-6 top-1/2 -translate-y-1/2 bg-[#021438] border-4 border-gray-300 text-white w-12 h-12 lg:w-14 lg:h-14 rounded-xl flex items-center justify-center shadow-lg hover:scale-110 transition-transform cursor-pointer z-20">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Left Large Vertical Image Frame -->
                        <div class="relative z-10 w-[240px] lg:w-[280px] h-[320px] lg:h-[380px] bg-gradient-to-br from-gray-200 to-gray-400 p-3 lg:p-4 rounded-[2rem] shadow-[0_20px_40px_rgba(0,0,0,0.5)] mr-auto lg:-ml-8">
                            <div class="w-full h-full rounded-[1.2rem] overflow-hidden relative border border-gray-400/50 bg-gray-200">
                                <img id="about-main-img" src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Teaching Experience" class="w-full h-full object-cover transition-opacity duration-300">
                                <!-- Subtle dark overlay to match the premium vibe -->
                                <div class="absolute inset-0 bg-[#031b4e]/10 mix-blend-multiply pointer-events-none"></div>
                            </div>

                        </div>

                        <!-- Floating Circular Buttons (Bottom overlapping) -->
                        <div class="absolute bottom-2 lg:bottom-4 right-[25%] lg:right-[30%] z-20 flex gap-4">
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-gradient-to-br from-gray-200 to-gray-400 p-1.5 shadow-xl hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="w-full h-full rounded-full bg-[#021438] flex items-center justify-center text-gray-300">
                                    <i class="fas fa-heart text-sm"></i>
                                </div>
                            </div>
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-gradient-to-br from-gray-200 to-gray-400 p-1.5 shadow-xl hover:-translate-y-1 transition-transform cursor-pointer">
                                <div class="w-full h-full rounded-full bg-[#021438] flex items-center justify-center text-gray-300">
                                    <i class="fas fa-bookmark text-sm"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Text Content -->
                    <div class="w-full md:w-1/2">
                        <span class="text-accent-500 font-bold uppercase tracking-wider text-sm mb-2 block">About Warriors Educare</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-[#031b4e] mb-6 leading-tight">Empowering Businesses With The Best Right Talent</h2>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            At Warriors Educare, we believe that the success of any business hinges on having the right people in place. Our mission is to empower companies by providing access to top-tier academic and administrative talent.
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-royal-100 flex items-center justify-center text-[#031b4e]">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="font-semibold text-gray-800">Tailored Staffing Solutions</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-royal-100 flex items-center justify-center text-[#031b4e]">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="font-semibold text-gray-800">Ongoing Support</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-royal-100 flex items-center justify-center text-[#031b4e]">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="font-semibold text-gray-800">Streamlined Hiring Process</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-royal-100 flex items-center justify-center text-[#031b4e]">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="font-semibold text-gray-800">Experienced Team</span>
                            </div>
                        </div>

                        <a href="#" class="inline-flex items-center justify-center bg-[#031b4e] hover:hover:bg-[#021030] text-white font-bold py-3 px-8 rounded-full transition-colors">
                            Join Our Network <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Agency Highlight Section (Light Background) -->
        <section class="py-24 bg-gray-50 relative border-t-4 border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative">
                    <!-- ISO Badge Overlapping -->
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] px-8 py-3 flex items-center gap-3 border-b-4 border-[#fbc043] z-30">
                        <i class="fas fa-certificate text-[#031b4e] text-2xl"></i>
                        <div>
                            <p class="font-extrabold text-[#031b4e] text-xl leading-none">ISO</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Certified Agency</p>
                        </div>
                    </div>

                    <!-- Main Blue Container -->
                    <div class="bg-[#031b4e] rounded-[2.5rem] lg:rounded-[4rem] p-8 md:p-12 lg:p-16 relative mt-12 md:mt-8 shadow-2xl border border-white/10">

                        <div class="flex flex-col lg:flex-row gap-12 relative z-10">
                            <!-- Left Column: Title -->
                            <div class="w-full lg:w-5/12 flex flex-col justify-center relative">
                                <span class="text-white/70 font-bold uppercase tracking-[0.2em] text-xs mb-6 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-[#fbc043] rounded-full shadow-[0_0_8px_#fbc043]"></span> Welcome To
                                </span>
                                <h2 class="text-5xl md:text-[4rem] lg:text-[4.5rem] font-black text-white leading-[1.05] tracking-tight uppercase" style="font-family: 'Arial Black', sans-serif;">
                                    Warriors<br>
                                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400">Educare</span>
                                </h2>
                                <div class="w-24 h-1.5 bg-gradient-to-r from-[#fbc043] to-[#fbc043]/20 mt-8 rounded-full"></div>

                                <!-- "EXPLORE MORE" button styled as a bottom tab like in Image 1 -->
                                <div class="mt-12 hidden lg:flex items-center gap-4">
                                    <a href="#" class="inline-flex items-center gap-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg border border-white/10">
                                        EXPLORE MORE
                                    </a>
                                    <a href="#" class="w-14 h-14 bg-[#fbc043] hover:bg-[#e5ae3c] rounded-2xl flex items-center justify-center text-[#031b4e] text-xl shadow-lg transition-transform hover:scale-105">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Right Column: Overlapping Glass Card -->
                            <div class="w-full lg:w-7/12">
                                <!-- This card overlaps the top and right slightly on desktop -->
                                <div class="bg-gradient-to-br from-white/95 to-gray-50/90 backdrop-blur-2xl rounded-[2rem] lg:rounded-[3rem] p-8 md:p-10 lg:p-12 shadow-[0_20px_60px_rgba(0,0,0,0.3)] border-2 border-white relative z-20 lg:-my-8 lg:-mr-8">
                                    <h3 class="text-3xl text-[#031b4e] font-black mb-6 tracking-tight">Who we are?</h3>
                                    <p class="text-lg text-gray-800 font-bold mb-6 leading-relaxed">
                                        Warriors Educare is an education-focused recruitment and teaching platform that connects teachers, tutors, schools, educational institutions, students, and parents through a simple and reliable hiring process.
                                    </p>
                                    <div class="text-gray-600 text-[13px] md:text-[14px] mb-8 leading-relaxed space-y-4">
                                        <p>Our platform is designed for teachers and education professionals who are looking for the right opportunities. Whether you want to <strong class="text-gray-800">apply for a teaching job in a school, college, or educational institution</strong>, or you are looking for opportunities as a <strong class="text-gray-800">tuition teacher or home tutor</strong>, Warriors Educare helps you discover suitable opportunities based on your skills, qualifications, experience, and preferred location.</p>
                                        
                                        <p>At the same time, <strong class="text-gray-800">schools and educational institutions can use our platform to find and hire qualified teachers and administrative staff</strong> for their academic requirements. We help institutions connect with suitable candidates and make their recruitment process more organized and efficient.</p>
                                        
                                        <p>We also support <strong class="text-gray-800">tuition and home tutoring requirements</strong>, helping students and parents connect with suitable tutors for different subjects, classes, and learning needs. Tutors can create their profiles, showcase their qualifications and teaching experience, and explore relevant tuition opportunities.</p>

                                        <div class="p-6 bg-blue-50/50 rounded-2xl border border-blue-100 mt-6">
                                            <h4 class="text-[#031b4e] font-extrabold text-base mb-2">Our Purpose</h4>
                                            <p class="mb-3">Our goal is to create a trusted platform where <strong class="text-[#031b4e]">teachers can find better career and teaching opportunities, schools can find the right teaching talent, and students can connect with suitable tutors</strong>.</p>
                                            
                                            <p>Whether you are a <strong class="text-[#031b4e]">teacher looking for a school job, a tutor looking for tuition students, a school looking to hire teachers, or a parent/student looking for a tutor</strong>, Warriors Educare brings these opportunities together on one platform.</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile explore button -->
                                    <div class="mt-8 flex lg:hidden items-center gap-4">
                                        <a href="#" class="inline-flex items-center gap-3 bg-[#031b4e] text-white px-6 py-3 rounded-xl font-bold">
                                            EXPLORE MORE <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>



        <!-- Simple Footer / CTA Prep -->
        <footer class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-[#031b4e] mb-4">Ready To Power Up Your Savings And Reliability?</h2>
                <p class="text-gray-600 mb-8">Let's Start the Conversation and find the right talent for your institution.</p>
                <a href="#" class="bg-[#031b4e] hover:hover:bg-[#021030] text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg">
                    Contact Us Today
                </a>
            </div>
        </footer>



    <!-- Categories Section -->
        <section class="py-16 px-6 lg:px-[5%] relative bg-slate-50">
            <style>
                .category-card {
                    background: #1e3a8a; /* Base blue color */
                    border-radius: 2rem;
                    position: relative;
                    z-index: 1;
                    /* Inner box shadow for depth */
                    box-shadow: inset 0 0 0 1px rgba(255,255,255,0.2), 0 10px 30px -10px rgba(0,0,0,0.3);
                }
                .category-card::before {
                    content: '';
                    position: absolute;
                    inset: 0;
                    border-radius: 2rem;
                    background: inherit;
                    z-index: -1;
                    /* Cutout mask for the bottom right corner */
                    -webkit-mask-image: 
                        linear-gradient(black, black),
                        linear-gradient(black, black),
                        radial-gradient(circle at top left, black 100%, transparent 100%);
                    -webkit-mask-size: 
                        100% calc(100% - 75px),
                        calc(100% - 75px) 100%,
                        100% 100%;
                    -webkit-mask-position: 
                        top left,
                        top left,
                        bottom right;
                    -webkit-mask-repeat: no-repeat;
                }
                .category-card-border {
                    position: absolute;
                    inset: 0;
                    border-radius: 2rem;
                    pointer-events: none;
                    z-index: 2;
                    /* We use a path to draw the border tracing the cutout */
                    clip-path: polygon(0 0, 100% 0, 100% calc(100% - 75px), calc(100% - 75px) calc(100% - 75px), calc(100% - 75px) 100%, 0 100%);
                    border: 1.5px solid rgba(255,255,255,0.3);
                }
                .category-btn {
                    position: absolute;
                    bottom: 0;
                    right: 0;
                    width: 60px;
                    height: 60px;
                    background: white;
                    border-top-left-radius: 1.5rem;
                    border-bottom-right-radius: 2rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #031b4e;
                    font-size: 1.25rem;
                    box-shadow: -5px -5px 15px rgba(0,0,0,0.05);
                    transition: all 0.3s ease;
                    z-index: 10;
                }
                .category-card:hover .category-btn {
                    background: #fbc043;
                    color: white;
                }
            </style>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 relative z-10">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('category.jobs', $category->id)); ?>"
                    class="block category-card p-6 pb-12 text-center text-white transition-transform duration-300 hover:-translate-y-2 cursor-pointer group reveal no-underline overflow-hidden">
                    
                    <!-- Inner content wrapper to keep away from cutout -->
                    <div class="relative z-10 flex flex-col items-center justify-center h-full">
                        <i class="fas fa-briefcase text-4xl mb-4 text-white/90 group-hover:scale-110 transition-transform"></i>
                        <h3 class="text-sm md:text-base font-bold mb-4"><?php echo e($category->name); ?></h3>
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-4 py-1.5 rounded-full text-[10px] md:text-xs font-bold inline-block">
                            <?php echo e($category->jobs_count); ?> Active Jobs
                        </div>
                    </div>
                    
                    <!-- Border tracing the cutout -->
                    <div class="category-card-border"></div>
                    
                    <!-- Floating Arrow Button -->
                    <div class="category-btn">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>


        

        <!-- Services Section -->
        <section class="py-20 px-6 lg:px-[5%] metallic-blue-card border-none shadow-none text-white text-center relative overflow-hidden">
            <div class="absolute top-5 right-[5%] opacity-[0.02] text-7xl md:text-[100px] font-extrabold uppercase pointer-events-none select-none tracking-wider">
                Warriors Educare</div>
            <div class="mb-12 relative z-10 reveal">
                <h4 class="text-white/80 text-base font-medium mb-1.5 uppercase tracking-wider">Providing Everything You
                    Need</h4>
                <h2 class="text-4xl lg:text-5xl font-bold text-white">SCHOOLS</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                <?php $__empty_1 = true; $__currentLoopData = $services->where('title', '!=', 'Home Tutors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="relative bg-white rounded-2xl overflow-hidden shadow-[0_8px_25px_rgba(0,0,0,0.08)] border border-gray-100 flex flex-col group hover:-translate-y-2 transition-transform duration-300 w-full text-left reveal z-10 reveal-delay-<?php echo e(($index % 4) + 1); ?>">
                    
                    <!-- Top Right Dark Blue Background -->
                    <div class="absolute top-0 right-0 w-[55%] h-[150px] bg-[#031b4e] rounded-bl-[2.5rem] z-0 pointer-events-none transition-all duration-500 group-hover:scale-105 origin-top-right"></div>

                    <div class="p-6 relative z-10 flex flex-col flex-grow">
                        <!-- Top Badges -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-[#031b4e] text-white px-4 py-1.5 rounded-full text-[11px] font-bold shadow-md tracking-wide">
                                SERVICE
                            </div>
                            <div class="bg-white text-[#031b4e] px-4 py-1.5 rounded-full text-[11px] font-extrabold shadow-md flex items-center justify-center gap-2">
                                <i class="<?php echo e($service->icon); ?> text-[#fbc043]"></i> FEATURED
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="text-[#031b4e] font-black text-xl mb-4 pr-12"><?php echo e($service->title); ?></h3>

                        <!-- Elevated Box -->
                        <div class="bg-white rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] p-5 mb-2 mt-auto border border-gray-50 relative group-hover:shadow-[0_15px_40px_rgba(0,0,0,0.12)] transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-3.5">
                                <div class="w-5 h-5 rounded-full bg-red-50 flex items-center justify-center text-red-500 text-[9px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">Premium Support</span>
                            </div>
                            <div class="flex items-center gap-3 mb-3.5">
                                <div class="w-5 h-5 rounded-full bg-purple-50 flex items-center justify-center text-purple-500 text-[9px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">Trusted Partner</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 text-[9px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-600 truncate">Quality Assured</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex h-[52px] mt-auto">
                        <div class="w-[45%] bg-[#3b82f6] text-white/90 flex items-center justify-center gap-2 text-[11px] font-bold">
                            <i class="fas fa-info-circle opacity-60"></i> Details
                        </div>
                        <a href="<?php echo e(route('service.details', $service->slug)); ?>" class="w-[55%] bg-[#031b4e] text-white flex items-center justify-center gap-2 text-[12px] font-bold hover:bg-[#021030] transition-colors">
                            Explore Now <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-10 opacity-60">
                    <p>No services currently available.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Tuitions Section -->
        <section class="py-20 px-6 lg:px-[5%] bg-slate-50 text-[#031b4e] relative overflow-hidden border-t border-slate-200">
            <!-- Background Watermark -->
            <div class="absolute top-5 left-1/2 -translate-x-1/2 opacity-5 text-[#031b4e] text-7xl md:text-[100px] font-extrabold uppercase pointer-events-none select-none tracking-wider w-full whitespace-nowrap text-center">
                Home Tuitions
            </div>
            
            <div class="mb-16 relative z-10 text-center reveal">
                <h4 class="text-accent-500 text-sm md:text-base font-semibold mb-2 uppercase tracking-widest">Personalized Learning</h4>
                  <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#031b4e]">Tuitions & Home Tutors</h2>
                <p class="text-slate-600 max-w-2xl mx-auto mt-4 text-sm md:text-base">Find the best home tutors near you. Get personalized learning experiences at your doorstep.</p>
            </div>

            <!-- Recent Tuition Cards Slider -->
            <div class="max-w-7xl mx-auto mb-20 relative z-10 reveal">
                    <div class="flex justify-between items-center mb-6 px-4 xl:px-0">
                      <h3 class="text-2xl font-bold text-[#031b4e]">Recent Tuition Posts</h3>
                      <!-- Navigation Buttons -->
                      <div class="flex gap-2">
                          <button id="tuitionSliderPrev" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-[#031b4e] hover:border-[#031b4e] hover:bg-slate-50 flex items-center justify-center transition-all shadow-sm">
                              <i class="fas fa-chevron-left"></i>
                          </button>
                          <button id="tuitionSliderNext" class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-[#031b4e] hover:border-[#031b4e] hover:bg-slate-50 flex items-center justify-center transition-all shadow-sm">
                              <i class="fas fa-chevron-right"></i>
                          </button>
                      </div>
                  </div>
                  
                  <style>
                      .hide-scrollbar::-webkit-scrollbar { display: none; }
                      .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                  </style>
                  
                  <div id="tuitionCardsSlider" class="flex overflow-x-auto gap-6 pb-8 pt-2 px-4 xl:px-0 snap-x snap-mandatory hide-scrollbar cursor-grab active:cursor-grabbing">
                    <?php $__empty_1 = true; $__currentLoopData = $employerTuitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="min-w-[85vw] md:min-w-[350px] bg-white rounded-2xl border border-blue-50 flex-shrink-0 snap-center relative overflow-hidden flex flex-col shadow-sm">
                            <!-- Top Right Dark Blue Background -->
                            <div class="absolute top-0 right-0 w-[45%] h-[45%] bg-[#031b4e] z-0"></div>
                            <!-- Bottom Left Bright Blue Background -->
                            <div class="absolute bottom-0 left-0 w-[35%] h-[25%] bg-[#3b82f6] z-0"></div>

                            <div class="p-5 relative z-10 flex flex-col h-full">
                                <!-- Top row (badges) -->
                                <div class="flex justify-between items-start mb-6">
                                    <div class="bg-[#031b4e] text-white px-4 py-1.5 rounded-full text-xs font-bold"><?php echo e($tuition->student_class); ?></div>
                                    <div class="bg-white text-emerald-600 px-4 py-1.5 rounded-lg text-sm font-bold border border-emerald-50 shadow-md">₹<?php echo e($tuition->budget); ?><span class="text-xs font-medium">/mo</span></div>
                                </div>
                                
                                <!-- Subject -->
                                <h4 class="text-xl font-extrabold text-[#031b4e] mb-4"><?php echo e($tuition->subjects); ?></h4>
                                
                                <!-- Inner white box -->
                                <div class="bg-white rounded-xl border border-[#031b4e] p-4 mb-6 relative z-20 shadow-[0_0_20px_rgba(0,0,0,0.25)]">
                                    <div class="space-y-4">
                                        <p class="text-sm text-slate-700 flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] text-red-500 flex items-center justify-center shrink-0 border border-gray-50"><i class="fas fa-map-marker-alt"></i></span> 
                                            <span class="truncate font-medium"><?php echo e($tuition->location); ?></span>
                                        </p>
                                        <p class="text-sm text-slate-700 flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] text-purple-600 flex items-center justify-center shrink-0 border border-gray-50"><i class="fas fa-book"></i></span> 
                                            <span class="truncate font-medium"><?php echo e($tuition->board); ?></span>
                                        </p>
                                        <p class="text-sm text-slate-700 flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] text-amber-500 flex items-center justify-center shrink-0 border border-gray-50"><i class="fas fa-user-circle"></i></span> 
                                            <span class="truncate font-medium"><?php echo e($tuition->employer ? ($tuition->employer->name === 'Super Admin' ? 'Warriors Educare' : $tuition->employer->name) : $tuition->guest_name); ?></span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Footer row -->
                                <div class="flex justify-between items-center mt-auto relative z-20">
                                    <div class="absolute -top-3 left-0 w-full h-[1px] bg-slate-200 z-10"></div>
                                    <span class="text-[11px] font-medium text-slate-500 bg-white/60 backdrop-blur-sm border border-slate-200/50 px-2 py-1 rounded flex items-center gap-1 shadow-sm relative z-20 mt-1"><i class="far fa-clock"></i> <?php echo e($tuition->created_at->diffForHumans()); ?></span>
                                    <a href="<?php echo e(auth()->check() ? route('candidate.tuitions.index') : route('parent.register')); ?>" class="inline-flex items-center gap-2 bg-[#031b4e] text-white hover:bg-blue-900 px-5 py-2.5 rounded-lg font-bold text-sm transition-colors shadow-lg relative z-20">Apply Now <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="w-full text-center py-12 bg-white/40 backdrop-blur-sm rounded-2xl shadow-sm border border-white/20">
                            <p class="text-slate-500 font-semibold">No recent tuition posts available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Latest Tuition Requirements -->
            <div class="max-w-7xl mx-auto relative z-10 reveal">
                <div class="flex justify-between items-end mb-8">
                    <h3 class="text-2xl font-bold text-[#031b4e]">Latest Tuition Requirements</h3>
                    <a href="<?php echo e(route('contact')); ?>" class="text-accent-500 hover:text-[#031b4e] font-semibold text-sm transition-colors">Apply as Tutor <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="metallic-blue-card rounded-2xl border-none shadow-2xl relative">
                    <div class="overflow-x-auto overflow-y-auto w-full" style="max-height: 400px;">
                        <table class="w-full text-left border-collapse relative z-10">
                        <thead class="sticky top-0 bg-[#011233]/90 backdrop-blur-md z-20 shadow-sm">
                            <tr class="border-b border-white/20 text-white/90 text-sm">
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Posted By</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Subjects</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Class & Board</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Location</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Time</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <?php $__empty_1 = true; $__currentLoopData = $guestTuitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b border-white/10 hover:bg-white/10 transition-colors">
                                    <td class="py-4 px-6 text-white font-medium whitespace-nowrap">
                                        <i class="fas fa-user-circle text-white/60 mr-2"></i><?php echo e($tuition->employer ? ($tuition->employer->name === 'Super Admin' ? 'Warriors Educare' : $tuition->employer->name) : $tuition->guest_name); ?>

                                    </td>
                                    <td class="py-4 px-6 font-semibold text-white"><?php echo e($tuition->subjects); ?></td>
                                    <td class="py-4 px-6">
                                        <span class="inline-block bg-white/20 text-white text-xs font-bold px-2 py-1 rounded mb-1"><?php echo e($tuition->student_class); ?></span><br>
                                        <span class="text-xs text-white/70 font-medium"><?php echo e($tuition->board); ?></span>
                                    </td>
                                    <td class="py-4 px-6 text-white/90 max-w-xs truncate" title="<?php echo e($tuition->location); ?>"><?php echo e($tuition->location); ?></td>
                                    <td class="py-4 px-6 text-white/70 text-xs whitespace-nowrap"><?php echo e($tuition->created_at->diffForHumans()); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 text-white/50 text-2xl">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <h4 class="text-lg font-bold text-white mb-2">No Requirements Right Now</h4>
                                        <p class="text-white/70 mb-6">Be the first to post a new home tuition requirement!</p>
                                        <a href="#quick-request-form" class="inline-block bg-accent-yellow text-[#031b4e] hover:bg-white px-6 py-3 rounded-xl font-bold shadow-sm transition-transform hover:-translate-y-1">Post a Tuition Need</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            
            <div id="quick-request-form" class="max-w-4xl mx-auto mt-20 relative z-10 reveal bg-gradient-to-br from-[#f0f7ff] to-blue-50 rounded-3xl p-8 md:p-10 shadow-2xl border border-blue-200">
                <div class="text-center mb-8">
                    <h3 class="text-2xl md:text-3xl font-bold text-[#031b4e] mb-2">Need a Tutor for Your Child?</h3>
                    <p class="text-slate-500">Fill this quick form and we'll match you with the best verified tutor.</p>
                </div>

                <?php if(session('tuition_success')): ?>
                    <div class="mb-6 bg-green-500/10 border border-green-500 text-green-600 px-4 py-3 rounded-xl flex items-center justify-center font-medium">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?php echo e(session('tuition_success')); ?>

                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('tuition.post')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Guest Name -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Your Name *</label>
                            <input type="text" name="guest_name" required placeholder="Enter your full name" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                        </div>
                        <!-- Guest Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Your Phone Number *</label>
                            <input type="text" name="guest_phone" required placeholder="Enter your phone number" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                        </div>
                        
                        <!-- Class -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Student's Class *</label>
                            <input type="text" name="student_class" placeholder="e.g. Class 10" required class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                        </div>
                        
                        <!-- Board -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Board *</label>
                            <select name="board" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none appearance-none">
                                <option value="">Select Board</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="State Board">State Board</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Subjects -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Subjects Needed *</label>
                            <input type="text" name="subjects" required placeholder="e.g., Math, Science" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Complete Location/Address *</label>
                            <input type="text" name="location" required placeholder="Enter full address or area" class="w-full bg-white border border-blue-200 rounded-xl px-4 py-3 text-[#031b4e] font-medium placeholder-slate-400 focus:ring-2 focus:ring-[#031b4e]/30 focus:border-[#031b4e] transition-colors outline-none">
                        </div>
                    </div>

                    <div class="text-center pt-4">
                        <button type="submit" class="bg-[#031b4e] hover:bg-accent-500 text-white px-10 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-2">
                            Post Requirement <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </section>

    <!-- Our Clients -->
        <section class="bg-white py-14 overflow-hidden border-b border-slate-100">
            <div class="text-left mb-6 px-6 lg:px-[5%] reveal">
                <h2 class="text-3xl font-bold text-slate-800 text-center mb-10">Our Clients</h2>
            </div>
            <div class="swiper marquee-swiper reveal">
                <div class="swiper-wrapper items-center">
                    <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="swiper-slide w-auto">
                        <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.2)] flex items-center justify-center min-w-[180px] h-20 transition-all duration-300 hover:-translate-y-1.5 hover:bg-white/60 hover:border-[#031b4e]/50 hover:shadow-[0_8px_32px_rgba(64,186,115,0.2)] cursor-grab active:cursor-grabbing group overflow-hidden">
                            <img src="<?php echo e(Storage::url($client->logo_path)); ?>" alt="<?php echo e($client->name); ?>" class="max-h-12 max-w-full object-contain transition-all duration-300">
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="w-full text-center text-slate-500 py-4 italic">
                        Our trusted clients will appear here.
                    </div>
                    <?php endif; ?>
                </div>

                </div>
            </div>
            </div>
        </section>

        <!-- Available On Section -->
        <section class="py-16 bg-white overflow-hidden border-b border-slate-100">
            <div class="text-center reveal mb-10 px-6 lg:px-[5%]">
                <h2 class="text-3xl font-bold text-slate-800">We are available on</h2>
            </div>

            <style>
                @keyframes marqueeLeftAvailable {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .animate-marquee-available {
                    animation: marqueeLeftAvailable 30s linear infinite reverse;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee-available:hover {
                    animation-play-state: paused;
                }
                .available-card {
                    flex-shrink: 0;
                }
                .fade-edges-available {
                    -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                    mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                }
            </style>

            <div class="overflow-hidden w-full relative z-10 fade-edges-available reveal">
                <div class="animate-marquee-available flex gap-6 px-3">
                    <?php for($i = 0; $i < 3; $i++): ?>
                    <div class="flex gap-6">
                        <!-- Card 1: Naukri -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-2xl tracking-tight font-sans"><span class="font-black" style="color: #1e3a8a;">naukri</span><span class="font-bold" style="color: #031b4e;">.com</span></span>
                        </div>
                        <!-- Card 2: Job Hai -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <div class="font-black text-xl leading-tight text-center font-sans tracking-tight" style="color: #00c853;">JOB<span style="color: #16a34a;" class="text-lg ml-1">✓</span><br><span style="color: #1e293b;">hai</span></div>
                        </div>
                        <!-- Card 3: Justdial -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-2xl tracking-tighter font-black font-sans"><span style="color: #005fb8;">Just</span><span style="color: #ff5e00;">dial</span></span>
                        </div>
                        <!-- Card 4: LinkedIn -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-bold text-2xl flex items-center gap-1.5 font-sans tracking-tight" style="color: #0a66c2;">Linked<i class="fab fa-linkedin"></i></span>
                        </div>
                        <!-- Card 5: Indeed -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-2xl tracking-tighter font-sans flex items-center gap-1" style="color: #2164f3;">indeed</span>
                        </div>
                        <!-- Card 6: Glassdoor -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-xl tracking-tight font-sans" style="color: #0caa41;">glassdoor</span>
                        </div>
                        <!-- Card 7: foundit -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-xl tracking-tight font-sans" style="color: #6c2da5;">foundit</span>
                        </div>
                        <!-- Card 8: Shine -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-xl tracking-tight font-sans"><span class="font-black" style="color: #154696;">Shine</span><span class="font-bold" style="color: #ff9800;">.com</span></span>
                        </div>
                        <!-- Card 9: Apna -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="font-black text-2xl tracking-tighter font-sans" style="color: #00a650;">apna</span>
                        </div>
                        <!-- Card 10: TeacherOn -->
                        <div class="available-card bg-white border border-slate-200 rounded-xl px-8 py-5 flex items-center justify-center min-w-[180px] shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                            <span class="text-2xl tracking-tighter font-black font-sans"><span style="color: #1e293b;">Teacher</span><span style="color: #f15a29;">On</span></span>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <!-- Latest Jobs Section -->
        <section class="py-20 px-6 lg:px-[5%] metallic-blue-card border-none shadow-none text-white relative">
            <div class="text-center mb-12 reveal">
                <h4 class="text-white/80 text-base font-medium mb-1.5 uppercase tracking-wider">Latest Jobs</h4>
                <h2 class="text-white text-3xl lg:text-4xl font-bold mb-4">Explore Recent Opportunities</h2>
                <div class="zigzag-divider w-16 h-2 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                <?php $__empty_1 = true; $__currentLoopData = $recentJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('jobs.show', $job->id)); ?>"
                    class="block bg-white border border-slate-200 rounded-2xl p-7 text-slate-800 transition-all duration-300 hover:-translate-y-2 shadow-lg hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] hover:border-[#031b4e]/30 flex flex-col group reveal cursor-pointer">
                    <h3 class="text-xl font-bold mb-3 text-slate-900 group-hover:text-[#031b4e] transition-colors"><?php echo e($job->title ?? 'Job Requirement'); ?></h3>
                    <p class="text-xs text-slate-500 mb-4 flex items-center gap-3">
                        <span class="text-red-400"><i class="fas fa-map-marker-alt mr-0.5"></i> <?php echo e($job->city?->name ?? 'N/A'); ?>, <?php echo e($job->state?->name ?? 'N/A'); ?></span>
                        <span><i class="far fa-calendar-alt mr-0.5"></i> <?php echo e($job->created_at->format('d M Y')); ?></span>
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-[#031b4e]/8 text-[#031b4e] px-2.5 py-1 rounded-lg text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fas fa-folder-open text-[9px]"></i> <?php echo e($job->category?->name ?? 'N/A'); ?>

                        </span>
                        <span class="bg-[#031b4e]/8 text-[#031b4e] px-2.5 py-1 rounded-lg text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fas fa-book text-[9px]"></i> <?php echo e($job->subject?->name ?? 'N/A'); ?>

                        </span>
                        <span class="bg-[#031b4e]/8 text-[#031b4e] px-2.5 py-1 rounded-lg text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fas fa-graduation-cap text-[9px]"></i> <?php echo e($job->qualification?->name ?? 'N/A'); ?>

                        </span>
                    </div>
                    <p class="text-[13px] text-slate-600 leading-relaxed mb-6 flex-grow">
                        <?php echo e(Str::limit(strip_tags($job->description), 100)); ?>

                    </p>
                    <div class="text-[#031b4e] font-semibold text-[13px] inline-flex items-center gap-2 self-start group-hover:gap-3 transition-all mt-auto">
                        View Details 
                        <span class="bg-accent-yellow text-slate-900 w-5 h-5 rounded-full flex items-center justify-center text-[9px] transition-transform group-hover:scale-110">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-10 opacity-60">
                    <p>No recent job openings available at the moment.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-12 reveal">
                <a href="<?php echo e(route('jobs')); ?>" class="inline-flex items-center justify-center gap-3 bg-[#031b4e] text-white font-bold text-[15px] px-8 py-3.5 rounded-full hover:bg-[#1e3a8a] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    View All Jobs 
                    <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </section>

        

        <!-- Testimonial Section -->
        <section class="py-20 px-6 lg:px-[5%] text-center relative bg-slate-50">
            
            <div class="mb-8 relative z-10 reveal">
                <h4 class="text-accent-yellow text-base font-medium mb-1.5 uppercase tracking-wider">Testimonial</h4>
                <h2 class="text-slate-800 text-3xl lg:text-4xl font-bold mb-4">What Our Clients Has To Say About Us</h2>
                <p class="max-w-2xl mx-auto text-[13px] text-slate-600 leading-relaxed">
                    Discover first hand experiences as our satisfied clients share their testimonials about the exceptional
                    recruitment services we provide. Hear what they have to say about our commitment to finding the right
                    talent.
                </p>
            </div>

            <?php if(isset($testimonials) && count($testimonials) > 0): ?>
            <style>
                @keyframes marqueeLeft {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                @keyframes marqueeRight {
                    0% { transform: translateX(-50%); }
                    100% { transform: translateX(0); }
                }
                .animate-marquee-left {
                    animation: marqueeLeft 35s linear infinite;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee-right {
                    animation: marqueeRight 35s linear infinite;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee-left:hover, .animate-marquee-right:hover {
                    animation-play-state: paused;
                }
                .testimonial-card-w {
                    width: 380px;
                    flex-shrink: 0;
                    white-space: normal;
                }
                .fade-edges {
                    -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                    mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
                }
            </style>

            <!-- Marquee Row 1 (Right to Left) -->
            <div class="overflow-hidden w-full relative z-10 mt-8 mb-4 fade-edges reveal">
                <div class="animate-marquee-left flex" style="padding-top: 35px; padding-bottom: 10px;">
                    <?php for($i = 0; $i < 2; $i++): ?>
                    <div class="flex gap-6 px-3">
                        <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="testimonial-card-w border border-green-100 rounded-2xl p-8 pt-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] transition-all duration-300" style="background-color: #f4f7f5;">
                            <div class="absolute top-6 right-6 text-[#031b4e]/10 text-4xl"><i class="fas fa-quote-right"></i></div>
                            <div class="w-16 h-16 rounded-full -mt-[60px] mx-auto mb-4 border-4 border-white relative overflow-hidden shadow-md flex items-center justify-center" style="background-color: #031b4e;">
                                <?php if($testimonial->image_path): ?>
                                    <img src="<?php echo e(Storage::url($testimonial->image_path)); ?>" alt="<?php echo e($testimonial->name); ?>" class="w-full h-full object-cover bg-white">
                                <?php else: ?>
                                    <span class="text-xl font-bold text-white"><?php echo e(substr($testimonial->name, 0, 1)); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-[13px] text-slate-600 leading-relaxed mb-5 italic line-clamp-4 relative z-10">"<?php echo e($testimonial->message); ?>"</p>
                            <div class="flex justify-center gap-1 text-accent-yellow text-[12px] mb-3 relative z-10">
                                <?php for($stars=0; $stars<$testimonial->rating; $stars++): ?> <i class="fas fa-star"></i> <?php endfor; ?>
                                <?php for($stars=0; $stars<(5-$testimonial->rating); $stars++): ?> <i class="far fa-star text-slate-300"></i> <?php endfor; ?>
                            </div>
                            <h4 class="text-slate-800 text-base font-extrabold mb-0.5 text-center relative z-10"><?php echo e($testimonial->name); ?></h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center relative z-10"><?php echo e($testimonial->role); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Marquee Row 2 (Left to Right) -->
            <div class="overflow-hidden w-full relative z-10 mb-8 fade-edges reveal reveal-delay-1">
                <div class="animate-marquee-right flex" style="padding-top: 35px; padding-bottom: 10px;">
                    <?php for($i = 0; $i < 2; $i++): ?>
                    <div class="flex gap-6 px-3">
                        <?php $__currentLoopData = $testimonials->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="testimonial-card-w border border-green-100 rounded-2xl p-8 pt-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] transition-all duration-300" style="background-color: #f4f7f5;">
                            <div class="absolute top-6 right-6 text-[#031b4e]/10 text-4xl"><i class="fas fa-quote-right"></i></div>
                            <div class="w-16 h-16 rounded-full -mt-[60px] mx-auto mb-4 border-4 border-white relative overflow-hidden shadow-md flex items-center justify-center" style="background-color: #031b4e;">
                                <?php if($testimonial->image_path): ?>
                                    <img src="<?php echo e(Storage::url($testimonial->image_path)); ?>" alt="<?php echo e($testimonial->name); ?>" class="w-full h-full object-cover bg-white">
                                <?php else: ?>
                                    <span class="text-xl font-bold text-white"><?php echo e(substr($testimonial->name, 0, 1)); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-[13px] text-slate-600 leading-relaxed mb-5 italic line-clamp-4 relative z-10">"<?php echo e($testimonial->message); ?>"</p>
                            <div class="flex justify-center gap-1 text-accent-yellow text-[12px] mb-3 relative z-10">
                                <?php for($stars=0; $stars<$testimonial->rating; $stars++): ?> <i class="fas fa-star"></i> <?php endfor; ?>
                                <?php for($stars=0; $stars<(5-$testimonial->rating); $stars++): ?> <i class="far fa-star text-slate-300"></i> <?php endfor; ?>
                            </div>
                            <h4 class="text-slate-800 text-base font-extrabold mb-0.5 text-center relative z-10"><?php echo e($testimonial->name); ?></h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center relative z-10"><?php echo e($testimonial->role); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center py-10 opacity-60 text-slate-800 relative z-10">
                <p>No testimonials available.</p>
            </div>
            <?php endif; ?>
        </section>

                <!-- New Contact Us Section -->
        <section class="py-24 bg-[#f4f7f5] relative overflow-hidden font-sans">
            <!-- Decorative curved lines background (left) -->
            <svg class="absolute left-[-15%] top-10 w-[50%] h-[120%] z-0 text-[#e6ede8] pointer-events-none opacity-80" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M -50 300 C 50 150, 250 50, 450 -50" stroke="currentColor" stroke-width="35" stroke-linecap="round"/>
                <path d="M 0 350 C 100 200, 300 100, 500 0" stroke="currentColor" stroke-width="35" stroke-linecap="round"/>
                <path d="M 50 400 C 150 250, 350 150, 550 50" stroke="currentColor" stroke-width="35" stroke-linecap="round"/>
            </svg>
            <svg class="absolute left-[30%] bottom-[-20%] w-[30%] h-[80%] z-0 text-[#e6ede8] pointer-events-none opacity-80" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M 100 450 C 150 250, 250 150, 450 50" stroke="currentColor" stroke-width="30" stroke-linecap="round"/>
                <path d="M 150 500 C 200 300, 300 200, 500 100" stroke="currentColor" stroke-width="30" stroke-linecap="round"/>
            </svg>
            
            <div class="container mx-auto max-w-[1000px] px-6 relative z-10">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-[#e0e7ff] text-[#1e3a8a] text-[11px] font-bold uppercase tracking-widest mb-4">
                        <i class="fas fa-building text-[11px]"></i> CONTACT US
                    </div>
                    <h2 class="text-3xl lg:text-[38px] font-bold text-gray-900 tracking-tight">Let's Start the Conversation</h2>
                </div>

                <div class="bg-white rounded-xl shadow-[0_20px_60px_rgba(0,0,0,0.06)] p-8 lg:p-14 flex flex-col lg:flex-row gap-12 lg:gap-16 relative overflow-hidden group">
                    
                    <!-- Animated Pattern Background -->
                    <div class="absolute inset-0 z-0 opacity-10 invert pointer-events-none animate-pattern-move" style="background-image: url('<?php echo e(asset('images/network-pattern.svg')); ?>'); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>

                    <!-- Left: Form -->
                    <div class="w-full lg:w-[58%] relative z-10">
                        <h3 class="text-[20px] font-bold text-gray-900 mb-1">Send Us A Message</h3>
                        <p class="text-[11px] text-gray-400 font-medium mb-7">Our response time is within 30 minutes during business hours</p>
                        
                        <form action="#" method="POST" class="flex flex-col gap-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" placeholder="First Name" class="w-full bg-[#f3f4f6] border-none rounded text-xs px-4 py-3.5 focus:ring-1 focus:ring-[#1e3a8a] outline-none text-gray-700 font-medium placeholder-gray-400">
                                <input type="text" placeholder="Last Name" class="w-full bg-[#f3f4f6] border-none rounded text-xs px-4 py-3.5 focus:ring-1 focus:ring-[#1e3a8a] outline-none text-gray-700 font-medium placeholder-gray-400">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="tel" placeholder="Phone Number" class="w-full bg-[#f3f4f6] border-none rounded text-xs px-4 py-3.5 focus:ring-1 focus:ring-[#1e3a8a] outline-none text-gray-700 font-medium placeholder-gray-400">
                                <input type="email" placeholder="Email Address" class="w-full bg-[#f3f4f6] border-none rounded text-xs px-4 py-3.5 focus:ring-1 focus:ring-[#1e3a8a] outline-none text-gray-700 font-medium placeholder-gray-400">
                            </div>
                            <div class="relative">
                                <select class="w-full bg-[#f3f4f6] border-none rounded text-xs text-gray-400 font-medium px-4 py-3.5 focus:ring-1 focus:ring-[#1e3a8a] outline-none appearance-none">
                                    <option value="">Service Type</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="w-full bg-[#1e3a8a] text-white font-bold py-3.5 rounded-lg hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                                    Send Message <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Animated Graphic -->
                    <div class="hidden lg:flex w-full lg:w-[42%] relative items-center justify-center">
                        <style>
                            @keyframes float-icon {
                                0%, 100% { transform: translateY(0px) rotate(12deg); }
                                50% { transform: translateY(-15px) rotate(16deg); }
                            }
                            @keyframes float-badge-1 {
                                0%, 100% { transform: translateY(0px) rotate(-10deg); }
                                50% { transform: translateY(12px) rotate(-5deg); }
                            }
                            @keyframes float-badge-2 {
                                0%, 100% { transform: translateY(0px) scale(1); }
                                50% { transform: translateY(-10px) scale(1.05); }
                            }
                            @keyframes pulse-ring {
                                0% { transform: scale(0.8); opacity: 0.5; }
                                50% { transform: scale(1.2); opacity: 0.1; }
                                100% { transform: scale(0.8); opacity: 0.5; }
                            }
                        </style>
                        <div class="relative w-full aspect-square max-w-[320px] flex items-center justify-center">
                            <!-- Background glowing blobs -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-br from-[#0ea5e9]/20 to-[#1e3a8a]/10 blur-3xl rounded-full" style="animation: pulse-ring 6s ease-in-out infinite;"></div>
                            
                            <!-- Floating Elements -->
                            <div class="relative z-10 w-full h-full flex items-center justify-center">
                                <!-- Main central element -->
                                <div class="w-44 h-44 bg-gradient-to-br from-[#1e3a8a] to-[#0ea5e9] rounded-[2rem] shadow-[0_20px_50px_rgba(30,58,138,0.4)] flex items-center justify-center relative border border-white/20" style="animation: float-icon 5s ease-in-out infinite;">
                                    <i class="fas fa-envelope-open-text text-white text-6xl drop-shadow-md"></i>
                                    
                                    <!-- Smaller floating badges -->
                                    <div class="absolute -top-4 -right-4 w-14 h-14 bg-white rounded-xl shadow-xl flex items-center justify-center border border-gray-100" style="animation: float-badge-1 4s ease-in-out infinite;">
                                        <i class="fas fa-paper-plane text-[#0ea5e9] text-xl"></i>
                                    </div>
                                    <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-accent-yellow rounded-full shadow-xl flex items-center justify-center border-4 border-white" style="animation: float-badge-2 4.5s ease-in-out infinite 0.5s;">
                                        <i class="fas fa-bolt text-white text-2xl"></i>
                                    </div>
                                    <!-- Extra decorative dots -->
                                    <div class="absolute top-1/2 -left-10 w-4 h-4 bg-[#0ea5e9] rounded-full opacity-60" style="animation: float-badge-1 3s ease-in-out infinite 1s;"></div>
                                    <div class="absolute -bottom-4 right-8 w-3 h-3 bg-accent-yellow rounded-full opacity-80" style="animation: float-badge-2 3.5s ease-in-out infinite 0.2s;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // --- Hero Section Image & Text Swap Animation ---
        const btnHire = document.getElementById('btn-hire');
        const btnJoin = document.getElementById('btn-join');
        const mainImg = document.getElementById('main-img');
        const subImg = document.getElementById('sub-img');
        const heroTitle = document.getElementById('hero-title');
        const heroDesc = document.getElementById('hero-desc');

        if (btnHire && btnJoin && mainImg && subImg) {
            let activeState = 'hire';

            const textContent = {
                hire: {
                    title: 'Find the best teachers and private <br>\n                    <div class="relative w-max mt-4 mb-2">\n                        <span class="bg-[#fbc043] text-[#1d2542] px-6 py-2 md:py-3 rounded-full inline-block relative z-20 shadow-md">tutors</span>\n                    </div>',
                    desc: 'We help you connect with expert teachers and dedicated tutors to ensure the best learning experience for a bright future.'
                },
                join: {
                    title: 'Join our team of expert <br>\n                    <div class="relative w-max mt-4 mb-2">\n                        <span class="bg-[#fbc043] text-[#1d2542] px-6 py-2 md:py-3 rounded-full inline-block relative z-20 shadow-md">educators</span>\n                    </div>',
                    desc: 'Become a part of our growing community. Teach, mentor, and shape the bright futures of students worldwide.'
                }
            };

            const activeBtnClass = "bg-[#031b4e] text-white px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-[#021030] transition shadow-lg flex items-center justify-center";
            const inactiveBtnClass = "bg-white text-[#031b4e] px-8 py-3.5 rounded-full font-bold text-[14px] text-center hover:bg-gray-50 transition border border-gray-200 shadow-sm flex items-center justify-center gap-2";

            heroTitle.style.transition = 'opacity 0.3s ease-in-out';
            heroDesc.style.transition = 'opacity 0.3s ease-in-out';
            mainImg.style.transition = 'opacity 0.3s ease-in-out';
            subImg.style.transition = 'opacity 0.3s ease-in-out';

            function setState(state, event) {
                if (activeState === state) return;
                event.preventDefault();
                activeState = state;

                // Fade out
                heroTitle.style.opacity = '0';
                heroDesc.style.opacity = '0';
                mainImg.style.opacity = '0';
                subImg.style.opacity = '0';

                // Swap button styles
                if (state === 'join') {
                    btnJoin.className = activeBtnClass;
                    btnJoin.innerHTML = 'Join as a Teacher / Tutor';
                    
                    btnHire.className = inactiveBtnClass;
                    btnHire.innerHTML = 'Hire a Teacher / Tutor <i class="fas fa-arrow-right"></i>';
                } else {
                    btnHire.className = activeBtnClass;
                    btnHire.innerHTML = 'Hire a Teacher / Tutor';
                    
                    btnJoin.className = inactiveBtnClass;
                    btnJoin.innerHTML = 'Join as a Teacher / Tutor <i class="fas fa-arrow-right"></i>';
                }

                setTimeout(() => {
                    heroTitle.innerHTML = textContent[state].title;
                    heroDesc.innerHTML = textContent[state].desc;
                    
                    const tempSrc = mainImg.src;
                    mainImg.src = subImg.src;
                    subImg.src = tempSrc;

                    heroTitle.style.opacity = '1';
                    heroDesc.style.opacity = '1';
                    mainImg.style.opacity = '1';
                    subImg.style.opacity = '1';
                }, 300);
            }

            btnHire.addEventListener('click', (e) => setState('hire', e));
            btnJoin.addEventListener('click', (e) => setState('join', e));
        }

        // --- Stats Observer ---
        const stats = document.querySelectorAll('.stat-number');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalValue = parseInt(target.getAttribute('data-target'));
                    const duration = 2000; // ms
                    const stepTime = Math.max(10, Math.floor(duration / finalValue));
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += Math.ceil(finalValue / (duration / 20));
                        if (current >= finalValue) {
                            target.innerText = finalValue;
                            clearInterval(timer);
                        } else {
                            target.innerText = current;
                        }
                    }, 20);
                    
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        
        stats.forEach(stat => observer.observe(stat));

        // Tuition Slider Navigation
        const tuitionSlider = document.getElementById('tuitionCardsSlider');
        const tuitionPrevBtn = document.getElementById('tuitionSliderPrev');
        const tuitionNextBtn = document.getElementById('tuitionSliderNext');

        if (tuitionSlider && tuitionPrevBtn && tuitionNextBtn) {
            tuitionPrevBtn.addEventListener('click', () => {
                tuitionSlider.scrollBy({ left: -350, behavior: 'smooth' });
            });
            tuitionNextBtn.addEventListener('click', () => {
                tuitionSlider.scrollBy({ left: 350, behavior: 'smooth' });
            });
        }
        
        // About Section Image Swapper
        const aboutArrowBtn = document.getElementById('about-arrow-btn');
        const aboutMainImg = document.getElementById('about-main-img');
        const aboutImages = [
            'https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1544717302-de2939b7ef71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
        ];
        let aboutImgIndex = 0;

        if (aboutArrowBtn && aboutMainImg) {
            aboutArrowBtn.addEventListener('click', function() {
                aboutImgIndex = (aboutImgIndex + 1) % aboutImages.length;
                aboutMainImg.style.opacity = '0';
                
                setTimeout(() => {
                    aboutMainImg.src = aboutImages[aboutImgIndex];
                    aboutMainImg.style.opacity = '1';
                }, 300);
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/welcome.blade.php ENDPATH**/ ?>