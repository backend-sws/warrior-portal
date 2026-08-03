    @extends('layouts.app')

    @section('content')
        <!-- Hero Banner Section -->
        <style>
            .hero-bg {
                background: linear-gradient(to bottom, #02102e 0%, #031b4e 55%, #ffffff 85%, #ffffff 100%);
            }
            @media (min-width: 768px) {
                .hero-bg {
                    background: linear-gradient(to right, #02102e 0%, #031b4e 55%, #ffffff 90%, #ffffff 100%);
                }
            }
            
            /* Floating Animations */
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(10deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
            @keyframes float-slow {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(-5deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
            @keyframes float-fast {
                0% { transform: translateY(0px) rotate(0deg) scale(1); }
                50% { transform: translateY(-25px) rotate(15deg) scale(1.05); }
                100% { transform: translateY(0px) rotate(0deg) scale(1); }
            }
            .animate-float { animation: float 6s ease-in-out infinite; }
            .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
            .animate-float-fast { animation: float-fast 4s ease-in-out infinite; }
        </style>
        <section class="relative overflow-hidden flex items-center hero-bg" style="min-height: 600px;">
            
            <!-- Random Floating Background Patterns -->
            <!-- Outline Circle -->
            <div class="absolute top-20 left-10 md:left-20 w-16 h-16 rounded-full border border-white/5 animate-float z-0 pointer-events-none"></div>
            <!-- Triangle -->
            <svg class="absolute top-32 left-1/3 w-8 h-8 text-white/5 animate-float-slow z-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l9 19H3L12 2z"></path></svg>
            <!-- Plus Sign -->
            <div class="absolute bottom-40 left-1/4 text-white/5 text-4xl font-light animate-float z-0 pointer-events-none">+</div>
            <!-- Small Solid Circle -->
            <div class="absolute top-1/2 left-1/4 w-3 h-3 rounded-full bg-white/5 animate-float-fast z-0 pointer-events-none"></div>
            <!-- Gold Outline Hexagon -->
            <svg class="absolute bottom-24 left-12 md:left-32 w-12 h-12 text-[#dfa43a]/10 animate-float-slow z-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l8.66 5v10L12 22l-8.66-5V7L12 2z"></path></svg>
            <!-- Dotted grid (using text) -->
            <div class="absolute top-1/4 left-1/2 text-white/5 text-xs animate-float z-0 pointer-events-none tracking-widest leading-none">
                . . . <br>
                . . . <br>
                . . . 
            </div>
            
            <!-- MORE PATTERN ADDITIONS -->
            <!-- Large faint circle bottom-left -->
            <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full border-2 border-white/5 animate-float-slow z-0 pointer-events-none"></div>
            <!-- Square Outline top-left-center -->
            <div class="absolute top-12 left-1/4 w-10 h-10 border border-white/5 rotate-45 animate-float-fast z-0 pointer-events-none"></div>
            <!-- Small plus signs scattered -->
            <div class="absolute top-1/3 left-10 text-white/5 text-2xl font-light animate-float-fast z-0 pointer-events-none">+</div>
            <div class="absolute bottom-1/4 left-1/2 text-white/5 text-xl font-light animate-float z-0 pointer-events-none">+</div>
            <!-- Zigzag/Wave SVG -->
            <svg class="absolute top-2/3 left-16 w-12 h-4 text-white/5 animate-float z-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 40 10" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M0 5l5-5 10 10 10-10 10 10 5-5"></path>
            </svg>
            <!-- Scattered solid dots -->
            <div class="absolute top-10 left-1/2 w-2 h-2 rounded-full bg-white/5 animate-float-fast z-0 pointer-events-none"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1.5 h-1.5 rounded-full bg-[#dfa43a]/20 animate-float-slow z-0 pointer-events-none"></div>
            
            <!-- Right side decorative shadow flag -->
            <div class="absolute top-1/2 -translate-y-1/2 z-0 hidden md:block" style="right: 15%; width: 450px; height: 350px; background: linear-gradient(to right, rgba(1, 10, 28, 0.8), transparent); clip-path: polygon(100% 0, 100% 100%, 25% 100%, 0% 50%, 25% 0%);"></div>
            
            <!-- Small circular decorations -->
            <div class="absolute rounded-full border-2 z-10 hidden md:block" style="right: 45%; bottom: 8rem; width: 30px; height: 30px; border-color: rgba(3, 27, 78, 0.8);"></div>
            <div class="absolute text-5xl font-light z-10 hidden md:block" style="right: 38%; bottom: 4rem; color: #031b4e;">+</div>

            <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-20 w-full h-full flex flex-col md:flex-row items-center justify-between pt-16 pb-40">
                
                <!-- Left Side: Text Content -->
                <div class="w-full md:w-3/5 pr-0 z-20">
                    <h2 id="hero-top-text" class="text-white/90 text-xl md:text-2xl font-light tracking-widest mb-2 uppercase">EXPERT CAREER</h2>
                    
                    <div class="flex flex-wrap items-baseline gap-x-4 gap-y-2 mb-6">
                        <h1 id="hero-heading-1" class="text-white text-5xl md:text-6xl lg:text-7xl font-black uppercase tracking-tight">GET THE JOB</h1>
                        <h1 id="hero-heading-2" class="text-white/90 text-4xl md:text-5xl lg:text-6xl font-light uppercase tracking-wide">FASTER</h1>
                    </div>
                    
                    <!-- Decorative Outlined Dashes -->
                    <div class="flex gap-3 mb-8">
                        <div class="w-16 h-2 border border-white/40 rounded-full"></div>
                        <div class="w-16 h-2 border border-white/40 rounded-full"></div>
                        <div class="w-16 h-2 border border-white/40 rounded-full"></div>
                        <div class="w-16 h-2 border border-white/40 rounded-full"></div>
                    </div>
                    
                    <!-- Paragraph with left border -->
                    <div class="border-l-2 pl-6 max-w-lg mb-8" style="border-color: #dfa43a;">
                        <p id="hero-paragraph" class="text-white/80 text-lg leading-relaxed">
                            We provide expert career services tailored to protect your future, resolve job hurdles, and secure your career with confidence.
                        </p>
                    </div>
                </div>

                <!-- Right Side: Hexagon Image -->
                <div class="w-full md:w-2/5 flex justify-center md:justify-end mt-12 md:mt-0 relative z-20">
                    <!-- Hexagon Border Wrapper -->
                    <div class="p-[10px] relative shadow-2xl mx-auto md:mx-0" style="width: 100%; max-width: 450px; height: 390px; background-color: #010a1c; clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);">
                        <!-- Inner Hexagon Image -->
                        <div class="w-full h-full relative overflow-hidden" style="clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);">
                            <img id="hero-img" src="{{ asset('images/candidate_hero_4k.png') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Bottom Left Angled Bar (Replaces Call for order with Candidate/Employer Switcher) -->
            <div class="absolute bottom-0 left-0 bg-white z-30 flex flex-col sm:flex-row items-center justify-between pl-6 pr-12 md:pl-12 md:pr-24 py-4 md:py-6 shadow-2xl" style="width: 75%; clip-path: polygon(0 0, 92% 0, 100% 100%, 0 100%); min-width: 300px;">
                
                <div class="flex items-center gap-4 md:gap-8 mb-4 sm:mb-0">
                    <!-- Candidate Toggle -->
                    <button id="btn-candidate" class="flex items-center gap-3 font-bold text-left transition-colors" style="color: #031b4e;" onclick="setHeroMode('candidate')">
                        <i class="fas fa-user-graduate text-3xl"></i>
                        <div class="leading-tight">
                            <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">I am a</div>
                            <div class="text-sm md:text-lg">CANDIDATE</div>
                        </div>
                    </button>
                    
                    <!-- Separator -->
                    <div class="w-px h-12 bg-gray-300"></div>
                    
                    <!-- Employer Toggle -->
                    <button id="btn-employer" class="flex items-center gap-3 text-gray-400 font-bold text-left transition-colors" onclick="setHeroMode('employer')">
                        <i class="fas fa-building text-3xl"></i>
                        <div class="leading-tight">
                            <div class="text-xs uppercase tracking-wider font-semibold">I am an</div>
                            <div class="text-sm md:text-lg">EMPLOYER</div>
                        </div>
                    </button>
                </div>
                
                <!-- Social Icons -->
                <div class="flex items-center gap-4 md:gap-6 pr-4 md:pr-12">
                    <a href="#" class="text-lg md:text-xl transition-colors hover:opacity-80" style="color: #031b4e;"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-lg md:text-xl transition-colors hover:opacity-80" style="color: #031b4e;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-lg md:text-xl transition-colors hover:opacity-80" style="color: #031b4e;"><i class="fab fa-instagram"></i></a>
                    <span class="font-bold text-sm hidden lg:inline-block" style="color: #031b4e;">WarriorsEducare</span>
                </div>
            </div>

            <!-- Bottom Right Visit Us -->
            <div class="absolute bottom-6 right-6 md:right-12 z-30 flex flex-col items-end">
                <a href="{{ route('contact') }}" class="font-extrabold py-2 md:py-3 px-6 md:px-8 rounded-full flex items-center gap-3 hover:opacity-90 transition-colors shadow-lg text-sm md:text-base" style="background-color: #031b4e; color: white;">
                    Visit Us <i class="fas fa-chevron-right rounded-full w-5 h-5 flex items-center justify-center text-xs" style="background-color: white; color: #031b4e;"></i>
                </a>
                <div class="text-xs md:text-sm mt-3 font-semibold tracking-wide" style="color: #031b4e;">www.warriorsportal.com</div>
            </div>

            <script>
                function setHeroMode(mode) {
                    const topText = document.getElementById('hero-top-text');
                    const heading1 = document.getElementById('hero-heading-1');
                    const heading2 = document.getElementById('hero-heading-2');
                    const paragraph = document.getElementById('hero-paragraph');
                    const btnCandidate = document.getElementById('btn-candidate');
                    const btnEmployer = document.getElementById('btn-employer');
                    const heroImg = document.getElementById('hero-img');

                    if (mode === 'employer') {
                        topText.innerHTML = "EXPERT HIRING";
                        heading1.innerHTML = "FIND TOP TALENT";
                        heading2.innerHTML = "FASTER";
                        paragraph.innerHTML = "We provide expert hiring services tailored to find top tier professionals, streamline your recruitment, and build your dream team.";
                        heroImg.src = "https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=600&q=80"; // Employer image
                        
                        // Active state styling
                        btnEmployer.style.color = "#031b4e";
                        btnEmployer.classList.remove('text-gray-400');
                        btnEmployer.querySelector('.text-xs').style.color = "#6b7280"; // text-gray-500
                        
                        btnCandidate.style.color = "";
                        btnCandidate.classList.add('text-gray-400');
                        btnCandidate.querySelector('.text-xs').style.color = "";
                    } else {
                        topText.innerHTML = "EXPERT CAREER";
                        heading1.innerHTML = "GET THE JOB";
                        heading2.innerHTML = "FASTER";
                        paragraph.innerHTML = "We provide expert career services tailored to protect your future, resolve job hurdles, and secure your career with confidence.";
                        heroImg.src = "{{ asset('images/candidate_hero_4k.png') }}"; // Candidate image
                        
                        // Active state styling
                        btnCandidate.style.color = "#031b4e";
                        btnCandidate.classList.remove('text-gray-400');
                        btnCandidate.querySelector('.text-xs').style.color = "#6b7280";
                        
                        btnEmployer.style.color = "";
                        btnEmployer.classList.add('text-gray-400');
                        btnEmployer.querySelector('.text-xs').style.color = "";
                    }
                }
            </script>
        </section>

        <!-- About / Empowering Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center gap-16">
                    
                    <!-- Left Images Grid -->
                    <div class="w-full md:w-1/2 relative">
                        <div class="grid grid-cols-2 gap-4">
                            <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Team high five" class="w-full h-64 object-cover rounded-tl-3xl rounded-br-3xl shadow-md">
                            <div class="flex flex-col gap-4">
                                <img src="https://images.unsplash.com/photo-1544717302-de2939b7ef71?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Professional Student" class="w-full h-32 object-cover rounded-tr-3xl shadow-md">
                                <div class="bg-royal-50 rounded-bl-3xl p-6 flex flex-col justify-center items-center text-center shadow-inner h-full">
                                    <h3 class="text-3xl font-extrabold text-[#031b4e]">12+</h3>
                                    <p class="text-sm font-semibold text-gray-600">Years of Experience</p>
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

        <!-- Agency Highlight Section (Dark Blue Background) -->
        <section class="py-24 bg-geometric-navy relative border-t-4 border-[#031b4e]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Glassmorphism Card -->
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-16 shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] relative">
                    
                    <!-- ISO Badge Overlapping -->
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-xl px-6 py-3 flex items-center gap-3 border-b-4 border-accent-500">
                        <i class="fas fa-certificate text-[#031b4e] text-2xl"></i>
                        <div>
                            <p class="font-extrabold text-gray-900 text-lg leading-none">ISO</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Certified Agency</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-12 mt-6">
                        <!-- Left Column: Title -->
                        <div class="w-full md:w-1/3">
                            <span class="text-accent-500 font-bold uppercase tracking-wider text-sm mb-2 block flex items-center gap-2">
                                <span class="w-2 h-2 bg-accent-500 rounded-full"></span> Welcome To
                            </span>
                            <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
                                Warriors<br>
                                <span class="text-royal-400">Educare</span><br>
                                
                            </h2>
                            <div class="w-16 h-1 bg-accent-500 mt-6 rounded-full"></div>
                        </div>

                        <!-- Right Column: Description -->
                        <div class="w-full md:w-2/3 flex flex-col justify-center border-l-0 md:border-l border-royal-700 md:pl-12">
                            <p class="text-lg text-white font-medium mb-6">
                                Warriors Educare is an ISO-certified and government-registered education recruitment consultancy operating at a national level across India. 
                                We provide structured, compliance-driven, and outcome-focused hiring solutions to schools, colleges, and educational institutions.
                            </p>
                            <p class="text-royal-100 text-sm mb-8 leading-relaxed opacity-80">
                                About Us – An Warriors Educare

At An Warriors Educare, we connect talent with opportunity in the education sector. Our platform is designed to support job seekers, educational institutions, and private tutors through a seamless recruitment experience.

With a strong network across multiple states, we help schools and institutes hire qualified teachers and administrative staff, while enabling candidates to find the right job opportunities that match their skills and career goals.

We also provide dedicated support for tuition teachers and home tutors, helping them connect with students and expand their reach.

Our recruitment approach follows modern hiring practices, institutional standards, and quality-focused selection, ensuring the best outcomes for both employers and candidates.
                            </p>
                            <div>
                                <a href="#" class="inline-flex items-center gap-2 text-white font-bold hover:text-accent-500 transition-colors group">
                                    EXPLORE MORE 
                                    <span class="w-10 h-10 rounded-full bg-accent-500 flex items-center justify-center text-white group-hover:bg-white group-hover:text-accent-500 transition-all">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- White Gap Divider -->
        <div class="h-4 lg:h-6 bg-white w-full"></div>

        <!-- Transparent Statistics Section -->
        <section class="py-6 bg-[#031b4e] border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <!-- Stat 1 -->
                    <div class="text-center group cursor-default">
                        <h3 class="text-4xl lg:text-5xl font-black text-white mb-2 tracking-tight drop-shadow-md"><span class="stat-number" data-target="500">0</span><span class="text-[#dfa43a]">+</span></h3>
                        <p class="text-[10px] lg:text-[11px] font-bold text-gray-300 uppercase tracking-widest">Current Openings</p>
                    </div>
                    
                    <!-- Stat 2 -->
                    <div class="text-center group cursor-default">
                        <h3 class="text-4xl lg:text-5xl font-black text-white mb-2 tracking-tight drop-shadow-md"><span class="stat-number" data-target="98">0</span><span class="text-[#031b4e]">%</span></h3>
                        <p class="text-[10px] lg:text-[11px] font-bold text-gray-300 uppercase tracking-widest">Fulfillment Rate</p>
                    </div>

                    <!-- Stat 3 -->
                    <div class="text-center group cursor-default">
                        <h3 class="text-4xl lg:text-5xl font-black text-white mb-2 tracking-tight drop-shadow-md"><span class="stat-number" data-target="10">0</span>k<span class="text-[#dfa43a]">+</span></h3>
                        <p class="text-[10px] lg:text-[11px] font-bold text-gray-300 uppercase tracking-widest">Jobs Applied</p>
                    </div>

                    <!-- Stat 4 -->
                    <div class="text-center group cursor-default">
                        <h3 class="text-4xl lg:text-5xl font-black text-white mb-2 tracking-tight drop-shadow-md"><span class="stat-number" data-target="350">0</span><span class="text-[#031b4e]">+</span></h3>
                        <p class="text-[10px] lg:text-[11px] font-bold text-gray-300 uppercase tracking-widest">Satisfied Schools</p>
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
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 relative z-10">
                @foreach($categories as $category)
                <a href="{{ route('category.jobs', $category->id) }}"
                    class="block bg-[#031b4e] border-none rounded-xl p-8 text-center text-white transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl cursor-pointer group reveal shadow-md flex flex-col items-center justify-center no-underline">
                    <i class="fas fa-briefcase text-4xl mb-4 block text-white group-hover:scale-110 transition-transform"></i>
                    <h3 class="text-sm font-semibold mb-4">{{ $category->name }}</h3>
                    <div class="bg-white text-[#031b4e] px-5 py-2 rounded-full text-xs font-bold inline-block shadow-sm mt-3">
                        {{ $category->jobs_count }} Active Jobs
                    </div>
                </a>
                @endforeach
            </div>
        </section>


        

        <!-- Services Section -->
        <section class="py-20 px-6 lg:px-[5%] bg-[#031b4e] text-white text-center relative overflow-hidden">
            <div class="absolute top-5 right-[5%] opacity-[0.02] text-7xl md:text-[100px] font-extrabold uppercase pointer-events-none select-none tracking-wider">
                Warriors Educare</div>
            <div class="mb-12 relative z-10 reveal">
                <h4 class="text-[#031b4e] text-base font-medium mb-1.5 uppercase tracking-wider">Providing Everything You
                    Need</h4>
                <h2 class="text-4xl lg:text-5xl font-bold text-white">SCHOOLS</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                @forelse($services->where('title', '!=', 'Home Tutors') as $index => $service)
                <div class="relative bg-slate-50 border border-transparent p-8 rounded-3xl transition-all duration-300 hover:-translate-y-6 hover:scale-110 hover:shadow-xl hover:border-[#031b4e]/30 hover:z-50 group flex flex-col items-center text-center reveal overflow-hidden z-10 reveal-delay-{{ ($index % 4) + 1 }}">
                    
                    <!-- Animated Background Blob -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#031b4e] rounded-bl-full opacity-0 group-hover:opacity-10 transition-all duration-700 group-hover:scale-[2.5] origin-top-right z-0 pointer-events-none"></div>

                    <!-- Icon Box -->
                    <div class="relative z-10 w-20 h-20 rounded-3xl bg-[#031b4e] text-white flex items-center justify-center text-3xl mb-5 transition-all duration-500 group-hover:-translate-y-4 group-hover:scale-110 group-hover:shadow-lg group-hover:rotate-12">
                        <i class="{{ $service->icon }} transition-transform duration-500 group-hover:-rotate-12 group-hover:scale-110"></i>
                    </div>
                    
                    <!-- Title -->
                    <h3 class="relative z-10 text-slate-900 font-extrabold text-lg mb-5 transition-colors duration-300 group-hover:text-[#031b4e]">{{ $service->title }}</h3>
                    
                    <!-- Read More Link -->
                    <a href="{{ route('service.details', $service->slug) }}" class="relative z-10 inline-flex items-center gap-3 text-[#031b4e] font-semibold text-[14px] mt-auto overflow-visible">
                        <span class="transition-transform duration-500 group-hover:-translate-x-1">Read More</span>
                        <div class="bg-yellow-500 text-slate-900 w-7 h-7 rounded-full flex items-center justify-center transition-all duration-500 group-hover:translate-x-3 group-hover:bg-[#031b4e] group-hover:text-white group-hover:shadow-lg group-hover:scale-110">
                            <i class="fas fa-chevron-right text-[10px] transition-transform duration-500 group-hover:translate-x-0.5"></i>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-10 opacity-60">
                    <p>No services currently available.</p>
                </div>
                @endforelse
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
                <div class="flex justify-between items-end mb-6 px-4 xl:px-0">
                    <h3 class="text-2xl font-bold text-[#031b4e]">Recent Tuition Posts</h3>
                </div>
                
                <style>
                    .hide-scrollbar::-webkit-scrollbar { display: none; }
                    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                </style>
                
                <div class="flex overflow-x-auto gap-6 pb-8 pt-2 px-4 xl:px-0 snap-x snap-mandatory hide-scrollbar cursor-grab active:cursor-grabbing">
                    @forelse($employerTuitions as $tuition)
                        <div class="min-w-[85vw] md:min-w-[350px] bg-white rounded-2xl border border-blue-50 flex-shrink-0 snap-center relative overflow-hidden flex flex-col shadow-sm">
                            <!-- Top Right Dark Blue Background -->
                            <div class="absolute top-0 right-0 w-[45%] h-[45%] bg-[#031b4e] z-0"></div>
                            <!-- Bottom Left Bright Blue Background -->
                            <div class="absolute bottom-0 left-0 w-[35%] h-[25%] bg-[#3b82f6] z-0"></div>

                            <div class="p-5 relative z-10 flex flex-col h-full">
                                <!-- Top row (badges) -->
                                <div class="flex justify-between items-start mb-6">
                                    <div class="bg-[#031b4e] text-white px-4 py-1.5 rounded-full text-xs font-bold">{{ $tuition->student_class }}</div>
                                    <div class="bg-white text-emerald-600 px-4 py-1.5 rounded-lg text-sm font-bold border border-emerald-50 shadow-md">₹{{ $tuition->budget }}<span class="text-xs font-medium">/mo</span></div>
                                </div>
                                
                                <!-- Subject -->
                                <h4 class="text-xl font-extrabold text-[#031b4e] mb-4">{{ $tuition->subjects }}</h4>
                                
                                <!-- Inner white box -->
                                <div class="bg-white rounded-xl border border-[#031b4e] p-4 mb-6 relative z-20 shadow-[0_0_20px_rgba(0,0,0,0.25)]">
                                    <div class="space-y-4">
                                        <p class="text-sm text-slate-700 flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] text-red-500 flex items-center justify-center shrink-0 border border-gray-50"><i class="fas fa-map-marker-alt"></i></span> 
                                            <span class="truncate font-medium">{{ $tuition->location }}</span>
                                        </p>
                                        <p class="text-sm text-slate-700 flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] text-purple-600 flex items-center justify-center shrink-0 border border-gray-50"><i class="fas fa-book"></i></span> 
                                            <span class="truncate font-medium">{{ $tuition->board }}</span>
                                        </p>
                                        <p class="text-sm text-slate-700 flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-white shadow-[0_2px_8px_rgba(0,0,0,0.08)] text-amber-500 flex items-center justify-center shrink-0 border border-gray-50"><i class="fas fa-user-circle"></i></span> 
                                            <span class="truncate font-medium">{{ $tuition->employer ? ($tuition->employer->name === 'Super Admin' ? 'Warriors Educare' : $tuition->employer->name) : $tuition->guest_name }}</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Footer row -->
                                <div class="flex justify-between items-center mt-auto relative z-20">
                                    <div class="absolute -top-3 left-0 w-full h-[1px] bg-slate-200 z-10"></div>
                                    <span class="text-[11px] font-medium text-slate-500 bg-white/60 backdrop-blur-sm border border-slate-200/50 px-2 py-1 rounded flex items-center gap-1 shadow-sm relative z-20 mt-1"><i class="far fa-clock"></i> {{ $tuition->created_at->diffForHumans() }}</span>
                                    <a href="{{ auth()->check() ? route('candidate.tuitions.index') : route('login') }}" class="inline-flex items-center gap-2 bg-[#031b4e] text-white hover:bg-blue-900 px-5 py-2.5 rounded-lg font-bold text-sm transition-colors shadow-lg relative z-20">Apply Now <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full text-center py-12 bg-white rounded-2xl shadow-sm border border-slate-100">
                            <p class="text-slate-500">No recent tuition posts available.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Latest Tuition Requirements -->
            <div class="max-w-7xl mx-auto relative z-10 reveal">
                <div class="flex justify-between items-end mb-8">
                    <h3 class="text-2xl font-bold text-[#031b4e]">Latest Tuition Requirements</h3>
                    <a href="{{ route('contact') }}" class="text-accent-500 hover:text-[#031b4e] font-semibold text-sm transition-colors">Apply as Tutor <i class="fas fa-arrow-right ml-1"></i></a>
                </div>

                <div class="overflow-x-auto overflow-y-auto bg-white rounded-2xl border border-slate-200 shadow-sm" style="max-height: 400px;">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-slate-50 z-10 shadow-sm">
                            <tr class="border-b border-slate-200 text-slate-600 text-sm">
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Posted By</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Subjects</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Class & Board</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Location</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Budget</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Time</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($guestTuitions as $tuition)
                                <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-6 text-[#031b4e] font-medium whitespace-nowrap">
                                        <i class="fas fa-user-circle text-slate-400 mr-2"></i>{{ $tuition->employer ? ($tuition->employer->name === 'Super Admin' ? 'Warriors Educare' : $tuition->employer->name) : $tuition->guest_name }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-[#031b4e]">{{ $tuition->subjects }}</td>
                                    <td class="py-4 px-6">
                                        <span class="inline-block bg-accent-blue/10 text-accent-blue text-xs font-bold px-2 py-1 rounded mb-1">{{ $tuition->student_class }}</span><br>
                                        <span class="text-xs text-slate-500 font-medium">{{ $tuition->board }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-600">{{ $tuition->location }}</td>
                                    <td class="py-4 px-6 text-[#031b4e] font-semibold">₹{{ $tuition->budget }}</td>
                                    <td class="py-4 px-6 text-slate-500 text-xs whitespace-nowrap">{{ $tuition->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-2xl">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <h4 class="text-lg font-bold text-[#031b4e] mb-2">No Requirements Right Now</h4>
                                        <p class="text-slate-500 mb-6">Be the first to post a new home tuition requirement!</p>
                                        <a href="#quick-request-form" class="inline-block bg-accent-yellow text-[#031b4e] hover:bg-accent-yellow/90 px-6 py-3 rounded-xl font-bold shadow-sm transition-transform hover:-translate-y-1">Post a Tuition Need</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Quick Request Form -->
            <div id="quick-request-form" class="max-w-4xl mx-auto mt-20 relative z-10 reveal bg-white rounded-3xl p-8 md:p-10 shadow-2xl border border-slate-200">
                <div class="text-center mb-8">
                    <h3 class="text-2xl md:text-3xl font-bold text-[#031b4e] mb-2">Need a Tutor for Your Child?</h3>
                    <p class="text-slate-500">Fill this quick form and we'll match you with the best verified tutor.</p>
                </div>

                @if(session('tuition_success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500 text-green-600 px-4 py-3 rounded-xl flex items-center justify-center font-medium">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('tuition_success') }}
                    </div>
                @endif

                <form action="{{ route('tuition.post') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Guest Name -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Your Name *</label>
                            <input type="text" name="guest_name" required placeholder="Enter your full name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none">
                        </div>
                        <!-- Guest Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Your Phone Number *</label>
                            <input type="text" name="guest_phone" required placeholder="Enter your phone number" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none">
                        </div>
                        
                        <!-- Class -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Student's Class *</label>
                            <select name="student_class" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none appearance-none">
                                <option value="">Select Class</option>
                                <option value="Pre-Primary">Pre-Primary</option>
                                <option value="Class 1-5">Class 1 to 5</option>
                                <option value="Class 6-8">Class 6 to 8</option>
                                <option value="Class 9-10">Class 9 to 10</option>
                                <option value="Class 11-12">Class 11 to 12</option>
                                <option value="College/University">College/University</option>
                            </select>
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
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Subjects Needed *</label>
                                <input type="text" name="subjects" required placeholder="e.g., Math, Science" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Monthly Budget (₹) *</label>
                                <input type="text" name="budget" required placeholder="e.g., 3000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none">
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Complete Location/Address *</label>
                            <input type="text" name="location" required placeholder="Enter full address or area" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-[#031b4e] focus:ring-2 focus:ring-accent-500/50 focus:border-accent-500 transition-colors outline-none">
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
                    @forelse($clients as $client)
                    <div class="swiper-slide w-auto">
                        <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.2)] flex items-center justify-center min-w-[180px] h-20 transition-all duration-300 hover:-translate-y-1.5 hover:bg-white/60 hover:border-[#031b4e]/50 hover:shadow-[0_8px_32px_rgba(64,186,115,0.2)] cursor-grab active:cursor-grabbing group overflow-hidden">
                            <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}" class="max-h-12 max-w-full object-contain transition-all duration-300">
                        </div>
                    </div>
                    @empty
                    <div class="w-full text-center text-slate-500 py-4 italic">
                        Our trusted clients will appear here.
                    </div>
                    @endforelse
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
                    @for($i = 0; $i < 3; $i++)
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
                    @endfor
                </div>
            </div>
        </section>

        <!-- Latest Jobs Section -->
        <section class="py-20 px-6 lg:px-[5%] bg-[#031b4e] text-white relative">
            <div class="text-center mb-12 reveal">
                <h4 class="text-[#031b4e] text-base font-medium mb-1.5 uppercase tracking-wider">Latest Jobs</h4>
                <h2 class="text-white text-3xl lg:text-4xl font-bold mb-4">Explore Recent Opportunities</h2>
                <div class="zigzag-divider w-16 h-2 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                @forelse($recentJobs as $job)
                <a href="{{ route('jobs.show', $job->id) }}"
                    class="block bg-white border border-slate-200 rounded-2xl p-7 text-slate-800 transition-all duration-300 hover:-translate-y-2 shadow-lg hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] hover:border-[#031b4e]/30 flex flex-col group reveal cursor-pointer">
                    <h3 class="text-xl font-bold mb-3 text-slate-900 group-hover:text-[#031b4e] transition-colors">{{ $job->title ?? 'Job Requirement' }}</h3>
                    <p class="text-xs text-slate-500 mb-4 flex items-center gap-3">
                        <span class="text-red-400"><i class="fas fa-map-marker-alt mr-0.5"></i> {{ $job->city?->name ?? 'N/A' }}, {{ $job->state?->name ?? 'N/A' }}</span>
                        <span><i class="far fa-calendar-alt mr-0.5"></i> {{ $job->created_at->format('d M Y') }}</span>
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-[#031b4e]/8 text-[#031b4e] px-2.5 py-1 rounded-lg text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fas fa-folder-open text-[9px]"></i> {{ $job->category?->name ?? 'N/A' }}
                        </span>
                        <span class="bg-[#031b4e]/8 text-[#031b4e] px-2.5 py-1 rounded-lg text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fas fa-book text-[9px]"></i> {{ $job->subject?->name ?? 'N/A' }}
                        </span>
                        <span class="bg-[#031b4e]/8 text-[#031b4e] px-2.5 py-1 rounded-lg text-[11px] font-semibold flex items-center gap-1.5">
                            <i class="fas fa-graduation-cap text-[9px]"></i> {{ $job->qualification?->name ?? 'N/A' }}
                        </span>
                    </div>
                    <p class="text-[13px] text-slate-600 leading-relaxed mb-6 flex-grow">
                        {{ Str::limit(strip_tags($job->description), 100) }}
                    </p>
                    <div class="text-[#031b4e] font-semibold text-[13px] inline-flex items-center gap-2 self-start group-hover:gap-3 transition-all mt-auto">
                        View Details 
                        <span class="bg-accent-yellow text-slate-900 w-5 h-5 rounded-full flex items-center justify-center text-[9px] transition-transform group-hover:scale-110">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-10 opacity-60">
                    <p>No recent job openings available at the moment.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12 reveal">
                <a href="{{ route('jobs') }}" class="inline-flex items-center justify-center gap-3 bg-[#031b4e] text-white font-bold text-[15px] px-8 py-3.5 rounded-full hover:bg-[#1e3a8a] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl group">
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

            @if(isset($testimonials) && count($testimonials) > 0)
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
                    @for($i = 0; $i < 2; $i++)
                    <div class="flex gap-6 px-3">
                        @foreach($testimonials as $testimonial)
                        <div class="testimonial-card-w border border-green-100 rounded-2xl p-8 pt-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] transition-all duration-300" style="background-color: #f4f7f5;">
                            <div class="absolute top-6 right-6 text-[#031b4e]/10 text-4xl"><i class="fas fa-quote-right"></i></div>
                            <div class="w-16 h-16 rounded-full -mt-[60px] mx-auto mb-4 border-4 border-white relative overflow-hidden shadow-md flex items-center justify-center" style="background-color: #031b4e;">
                                @if($testimonial->image_path)
                                    <img src="{{ Storage::url($testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover bg-white">
                                @else
                                    <span class="text-xl font-bold text-white">{{ substr($testimonial->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <p class="text-[13px] text-slate-600 leading-relaxed mb-5 italic line-clamp-4 relative z-10">"{{ $testimonial->message }}"</p>
                            <div class="flex justify-center gap-1 text-accent-yellow text-[12px] mb-3 relative z-10">
                                @for($stars=0; $stars<$testimonial->rating; $stars++) <i class="fas fa-star"></i> @endfor
                                @for($stars=0; $stars<(5-$testimonial->rating); $stars++) <i class="far fa-star text-slate-300"></i> @endfor
                            </div>
                            <h4 class="text-slate-800 text-base font-extrabold mb-0.5 text-center relative z-10">{{ $testimonial->name }}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center relative z-10">{{ $testimonial->role }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Marquee Row 2 (Left to Right) -->
            <div class="overflow-hidden w-full relative z-10 mb-8 fade-edges reveal reveal-delay-1">
                <div class="animate-marquee-right flex" style="padding-top: 35px; padding-bottom: 10px;">
                    @for($i = 0; $i < 2; $i++)
                    <div class="flex gap-6 px-3">
                        @foreach($testimonials->reverse() as $testimonial)
                        <div class="testimonial-card-w border border-green-100 rounded-2xl p-8 pt-6 relative shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(64,186,115,0.15)] transition-all duration-300" style="background-color: #f4f7f5;">
                            <div class="absolute top-6 right-6 text-[#031b4e]/10 text-4xl"><i class="fas fa-quote-right"></i></div>
                            <div class="w-16 h-16 rounded-full -mt-[60px] mx-auto mb-4 border-4 border-white relative overflow-hidden shadow-md flex items-center justify-center" style="background-color: #031b4e;">
                                @if($testimonial->image_path)
                                    <img src="{{ Storage::url($testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover bg-white">
                                @else
                                    <span class="text-xl font-bold text-white">{{ substr($testimonial->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <p class="text-[13px] text-slate-600 leading-relaxed mb-5 italic line-clamp-4 relative z-10">"{{ $testimonial->message }}"</p>
                            <div class="flex justify-center gap-1 text-accent-yellow text-[12px] mb-3 relative z-10">
                                @for($stars=0; $stars<$testimonial->rating; $stars++) <i class="fas fa-star"></i> @endfor
                                @for($stars=0; $stars<(5-$testimonial->rating); $stars++) <i class="far fa-star text-slate-300"></i> @endfor
                            </div>
                            <h4 class="text-slate-800 text-base font-extrabold mb-0.5 text-center relative z-10">{{ $testimonial->name }}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold text-center relative z-10">{{ $testimonial->role }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endfor
                </div>
            </div>
            @else
            <div class="text-center py-10 opacity-60 text-slate-800 relative z-10">
                <p>No testimonials available.</p>
            </div>
            @endif
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

                <div class="bg-white rounded-xl shadow-[0_20px_60px_rgba(0,0,0,0.06)] p-8 lg:p-14 flex flex-col lg:flex-row gap-12 lg:gap-16">
                    
                    <!-- Left: Form -->
                    <div class="w-full lg:w-[58%]">
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
                </div>
            </div>
        </section>

    @endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
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
    });
</script>
@endpush

