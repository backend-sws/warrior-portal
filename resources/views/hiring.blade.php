@extends('layouts.app')

@section('title', 'How Our Hiring & Placement Process Works - Warriors Educare')
@section('meta_description', 'Learn about our transparent step-by-step placement process for Home Tuitions and School Teaching & Non-Teaching Staff at Warriors Educare.')

@section('content')
<style>
    .track-tab-btn.active {
        background: #031b4e !important;
        color: #ffffff !important;
        box-shadow: 0 10px 25px -5px rgba(3, 27, 78, 0.3);
    }
    .track-tab-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .step-badge {
        background: linear-gradient(135deg, #031b4e 0%, #129aef 100%);
    }
</style>

<x-page-header title="How Our Hiring & Placement Process Works" :breadcrumbs="['Home' => route('home'), 'Hiring Process' => null]" />

<div class="py-16 lg:py-24 bg-gradient-to-b from-[#f8fafc] via-[#f1f5f9] to-[#ffffff] relative font-sans overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100/50 rounded-full blur-3xl pointer-events-none -mr-20 -mt-20"></div>
    <div class="absolute bottom-1/3 left-0 w-96 h-96 bg-amber-100/40 rounded-full blur-3xl pointer-events-none -ml-20"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header Introduction -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-blue-50 text-accent-blue border border-blue-200/60 shadow-2xs mb-4">
                <i class="fas fa-route text-accent-blue"></i> Transparent & Streamlined Workflow
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#031b4e] tracking-tight leading-tight mb-4">
                WARRIORS EDUCARE
            </h2>
            <p class="text-base sm:text-lg text-slate-700 font-medium leading-relaxed">
                Understand our simple, professional, and end-to-end recruitment process for <strong class="text-[#031b4e] font-extrabold">Home Tuitions</strong> and <strong class="text-[#031b4e] font-extrabold">School Teaching & Non-Teaching Staff</strong>.
            </p>

            <!-- Interactive Track Tabs -->
            <div class="mt-8 inline-flex p-1.5 bg-white border border-slate-200 rounded-2xl shadow-sm max-w-full overflow-x-auto">
                <button type="button" onclick="switchTrack('tuition')" id="tuitionTabBtn" class="track-tab-btn active px-6 py-3 rounded-xl text-xs sm:text-sm font-black flex items-center gap-2.5 shrink-0">
                    <i class="fas fa-chalkboard-teacher text-amber-400"></i>
                    <span>Home Tuition Placement (10 Steps)</span>
                </button>
                <button type="button" onclick="switchTrack('school')" id="schoolTabBtn" class="track-tab-btn px-6 py-3 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:text-[#031b4e] flex items-center gap-2.5 shrink-0">
                    <i class="fas fa-school text-blue-500"></i>
                    <span>School & Staff Placement (11 Steps)</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TRACK 1: HOME TUITION PLACEMENT PROCESS   -->
        <!-- ========================================== -->
        <div id="tuitionTrackSection" class="transition-all duration-300">
            
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md p-6 sm:p-10 mb-12">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-2xl font-black shadow-inner shrink-0">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-amber-700 uppercase tracking-widest">Tutor Placement Guide</span>
                            <h3 class="text-xl sm:text-2xl font-extrabold text-[#031b4e]">Home Tuition Placement Process</h3>
                        </div>
                    </div>
                    <a href="{{ route('candidate.register') }}" class="px-5 py-2.5 bg-[#031b4e] hover:bg-[#021338] text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
                        <span>Register as Tutor</span> <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- 10 Step Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    
                    <!-- Step 1 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">01</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 1 – Submit Your Application</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Complete the registration form by providing your personal details, qualifications, teaching subjects, preferred classes and preferred teaching location.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">02</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 2 – Profile Verification</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Our team reviews and verifies your profile, qualifications and other submitted information to ensure suitability for tuition opportunities.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">03</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 3 – Registration Completion</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Complete the registration process to activate your tutor profile in our database.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">04</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 4 – Tuition Requirement Matching</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Based on your subject expertise, class preference, location and availability, we match your profile with suitable student requirements.
                        </p>
                    </div>

                    <!-- Step 5 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">05</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 5 – Tuition Lead Sharing</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Once a suitable requirement is available, complete details of the tuition opportunity will be shared with you.
                        </p>
                    </div>

                    <!-- Step 6 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">06</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 6 – Demo Class (If Required)</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            The parent may request a demo class before finalizing the tutor. Candidates are expected to attend the demo professionally and on time.
                        </p>
                    </div>

                    <!-- Step 7 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">07</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 7 – Parent Confirmation</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            If the parent is satisfied with the demo class and profile, the tuition assignment will be confirmed.
                        </p>
                    </div>

                    <!-- Step 8 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-blue-50/40 hover:border-blue-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">08</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 8 – Start Teaching</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Begin classes according to the mutually agreed schedule and maintain professional conduct throughout the engagement.
                        </p>
                    </div>

                    <!-- Step 9 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-emerald-50/70 border border-emerald-300 hover:bg-emerald-50 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">09</span>
                            <h4 class="font-extrabold text-emerald-950 text-base">Step 9 – Successful Placement 🎉</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-emerald-950 leading-relaxed font-semibold pl-11">
                            Your tuition placement is considered successful once classes have commenced and the first month's tuition fee is received.
                        </p>
                    </div>

                    <!-- Step 10 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-blue-50/70 border border-blue-300 hover:bg-blue-50 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="w-8 h-8 rounded-xl bg-[#031b4e] text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">10</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base">Step 10 – Service Charge Settlement</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-800 leading-relaxed font-semibold pl-11">
                            After receiving the first month's tuition fee/payment, the applicable service charge must be paid as per the agreed terms and conditions.
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- TRACK 2: SCHOOL TEACHER & STAFF PLACEMENT PROCESS        -->
        <!-- ======================================================== -->
        <div id="schoolTrackSection" class="hidden transition-all duration-300">
            
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md p-6 sm:p-10 mb-12">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 mb-8 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-accent-blue border border-blue-200 flex items-center justify-center text-2xl font-black shadow-inner shrink-0">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-accent-blue uppercase tracking-widest">Institutional Recruitment</span>
                            <h3 class="text-xl sm:text-2xl font-extrabold text-[#031b4e]">School Teacher & Non-Teaching Staff Placement Process</h3>
                        </div>
                    </div>
                    <a href="{{ route('candidate.register') }}" class="px-5 py-2.5 bg-accent-blue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-2">
                        <span>Apply for School Jobs</span> <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- 11 Step Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    
                    <!-- Step 1 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">01</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 1 – Submit Your Application</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Complete the registration form and provide your educational qualifications, work experience, preferred location and expected salary details.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">02</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 2 – Upload Required Documents</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Submit the required documents for verification, including educational certificates, Aadhaar Card, resume/CV, photograph and other relevant documents.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-purple-50/70 border border-purple-300 hover:bg-purple-50 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="w-8 h-8 rounded-xl bg-purple-700 text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">03</span>
                            <div class="flex items-center gap-2">
                                <h4 class="font-extrabold text-purple-950 text-base">Step 3 – Introduction Video</h4>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-purple-200 text-purple-900 uppercase">Mandatory</span>
                            </div>
                        </div>
                        <p class="text-xs sm:text-sm text-purple-950 leading-relaxed font-semibold pl-11">
                            Upload a 1–2 minute professional introduction video introducing yourself, your qualifications, teaching/professional experience, subject expertise and communication skills.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">04</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 4 – Profile Screening & Verification</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Our recruitment team carefully reviews your profile, documents and experience to assess your suitability for available vacancies.
                        </p>
                    </div>

                    <!-- Step 5 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">05</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 5 – Registration Confirmation</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            After successful verification and registration completion, your profile becomes eligible for placement opportunities.
                        </p>
                    </div>

                    <!-- Step 6 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">06</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 6 – Vacancy Matching</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Your profile is matched with suitable teaching or non-teaching vacancies based on qualifications, experience, salary expectations and location preferences.
                        </p>
                    </div>

                    <!-- Step 7 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">07</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 7 – Interview Coordination</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Shortlisted candidates receive interview schedules and guidance for the recruitment process.
                        </p>
                    </div>

                    <!-- Step 8 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">08</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 8 – School Selection Process</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            The respective school or institution conducts interviews and makes the final hiring decision.
                        </p>
                    </div>

                    <!-- Step 9 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-indigo-50/40 hover:border-indigo-300 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="step-badge w-8 h-8 rounded-xl text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">09</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base group-hover:text-accent-blue transition-colors">Step 9 – Offer & Joining Confirmation</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium pl-11">
                            Selected candidates receive offer details and confirm their joining date.
                        </p>
                    </div>

                    <!-- Step 10 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-emerald-50/70 border border-emerald-300 hover:bg-emerald-50 transition-all group">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">10</span>
                            <h4 class="font-extrabold text-emerald-950 text-base">Step 10 – Successful Placement 🎓</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-emerald-950 leading-relaxed font-semibold pl-11">
                            The placement process is considered successfully completed once the candidate joins the school/institution and begins working.
                        </p>
                    </div>

                    <!-- Step 11 -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-blue-50/70 border border-blue-300 hover:bg-blue-50 transition-all group md:col-span-2">
                        <div class="flex items-center gap-3.5 mb-3">
                            <span class="w-8 h-8 rounded-xl bg-[#031b4e] text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">11</span>
                            <h4 class="font-extrabold text-[#031b4e] text-base">Step 11 – Placement Service Charge Settlement</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-800 leading-relaxed font-semibold pl-11">
                            After receiving the first salary/payment, the applicable placement service charge must be paid as per the agreed terms and conditions.
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- WHY CHOOSE WARRIORS EDUCARE?               -->
        <!-- ========================================== -->
        <div class="mt-12 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 mb-10">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="text-xs font-black text-accent-blue uppercase tracking-widest">Our Strengths</span>
                <h3 class="text-2xl sm:text-3xl font-black text-[#031b4e] mt-1">Why Choose Warriors Educare?</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0 mt-0.5">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#031b4e] text-sm">Verified Opportunities</h4>
                        <p class="text-xs text-slate-600 mt-0.5 font-medium">Genuine parent requirements & verified educational institutions.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0 mt-0.5">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#031b4e] text-sm">Professional Profile Screening</h4>
                        <p class="text-xs text-slate-600 mt-0.5 font-medium">In-depth evaluation of qualifications and communication skills.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0 mt-0.5">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#031b4e] text-sm">Transparent Placement Process</h4>
                        <p class="text-xs text-slate-600 mt-0.5 font-medium">Clear stages with no hidden or unexpected commercial terms.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0 mt-0.5">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#031b4e] text-sm">Dedicated Recruitment Support</h4>
                        <p class="text-xs text-slate-600 mt-0.5 font-medium">Personalized guidance throughout interview & demo sessions.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0 mt-0.5">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#031b4e] text-sm">Dual Placement Assistance</h4>
                        <p class="text-xs text-slate-600 mt-0.5 font-medium">Comprehensive assistance for Home Tuitions & School vacancies.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0 mt-0.5">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#031b4e] text-sm">Skill & Requirement Matching</h4>
                        <p class="text-xs text-slate-600 mt-0.5 font-medium">Opportunities matched strictly on qualifications, subjects & location.</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================= -->
        <!-- PAYMENT COLLECTION, PRICING & COMMERCIAL TERMS (PHONEPE)  -->
        <!-- ========================================================= -->
        <div id="payment-policy" class="mt-12 bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-10 lg:p-12 mb-10 relative overflow-hidden">
            
            <!-- Top Header Badge & Title -->
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200/80 shadow-2xs mb-3">
                    <i class="fas fa-lock text-emerald-600"></i> Secure & Transparent Payment Policy
                </span>
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black text-[#031b4e] tracking-tight mb-3">
                    Fee Structure, Payment Collection & Terms
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed max-w-2xl mx-auto">
                    All financial transactions, registration charges, and placement fees at Warriors Educare are processed securely through certified payment gateways in full compliance with RBI guidelines.
                </p>
            </div>

            <!-- 3 Columns: Transparent Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                <!-- Card 1: Home Tuition Registration -->
                <div class="rounded-2xl bg-amber-50/60 border border-amber-200/90 p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-black uppercase tracking-wider text-amber-800 bg-amber-200/60 px-2.5 py-1 rounded-full">
                                Home Tuition
                            </span>
                            <span class="text-xs font-bold text-slate-500">1 Year Validity</span>
                        </div>
                        <h4 class="text-lg font-black text-[#031b4e] mb-1">Tutor Registration Fee</h4>
                        <p class="text-xs text-slate-600 mb-4 font-medium">One-time registration for access to verified home tuition leads.</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-amber-200/60 text-xs font-bold text-slate-800">
                                <span>Junior Classes (Up to Class 5)</span>
                                <span class="text-amber-800 font-black text-sm">₹500</span>
                            </div>
                            <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-amber-200/60 text-xs font-bold text-slate-800">
                                <span>Senior Classes (Class 6 - 12)</span>
                                <span class="text-amber-800 font-black text-sm">₹600</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium border-t border-amber-200/60 pt-3">
                        <i class="fas fa-check-circle text-amber-600 mr-1"></i> Includes KYC, profile verification & lead matching.
                    </p>
                </div>

                <!-- Card 2: School Staff Registration -->
                <div class="rounded-2xl bg-blue-50/60 border border-blue-200/90 p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-black uppercase tracking-wider text-blue-800 bg-blue-200/60 px-2.5 py-1 rounded-full">
                                School Placement
                            </span>
                            <span class="text-xs font-bold text-slate-500">8 Months Validity</span>
                        </div>
                        <h4 class="text-lg font-black text-[#031b4e] mb-1">Teacher & Staff Registration</h4>
                        <p class="text-xs text-slate-600 mb-4 font-medium">Split fee structure for institutional placement assistance.</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-blue-200/60 text-xs font-bold text-slate-800">
                                <span>At Initial Registration</span>
                                <span class="text-blue-800 font-black text-sm">₹500</span>
                            </div>
                            <div class="flex items-center justify-between p-2.5 bg-white rounded-xl border border-blue-200/60 text-xs font-bold text-slate-800">
                                <span>After Final Selection</span>
                                <span class="text-blue-800 font-black text-sm">₹500</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium border-t border-blue-200/60 pt-3">
                        <i class="fas fa-check-circle text-blue-600 mr-1"></i> Total ₹1,000. Covers screening, mock & interview scheduling.
                    </p>
                </div>

                <!-- Card 3: Post-Placement Service Charge -->
                <div class="rounded-2xl bg-emerald-50/60 border border-emerald-200/90 p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-200/60 px-2.5 py-1 rounded-full">
                                Post-Placement
                            </span>
                            <span class="text-xs font-bold text-emerald-700">Success-Based</span>
                        </div>
                        <h4 class="text-lg font-black text-[#031b4e] mb-1">Placement Service Charge</h4>
                        <p class="text-xs text-slate-600 mb-4 font-medium">Payable ONLY after receiving your first month salary or tuition fee.</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="p-2.5 bg-white rounded-xl border border-emerald-200/60 text-xs text-slate-800">
                                <span class="font-bold block text-emerald-900">Home Tuition Assignment:</span>
                                <span class="font-extrabold text-emerald-700">50% of 1st Month Tuition Fee (15 Days)</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-emerald-200/60 text-xs text-slate-800">
                                <span class="font-bold block text-emerald-900">School Faculty Job:</span>
                                <span class="font-extrabold text-emerald-700">50% of 1st Month Gross Salary (15 Days)</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium border-t border-emerald-200/60 pt-3">
                        <i class="fas fa-check-circle text-emerald-600 mr-1"></i> Zero recurring monthly commission thereafter.
                    </p>
                </div>

            </div>

            <!-- PhonePe & Payment Gateway Security Box -->
            <div class="bg-gradient-to-r from-slate-900 via-[#031b4e] to-slate-900 text-white rounded-2xl p-6 sm:p-8 mb-10 shadow-lg border border-white/10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-2xl text-cyan-300 shrink-0 border border-white/20">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-cyan-500/20 text-cyan-300 text-[10px] font-extrabold uppercase tracking-wider mb-1">
                                <i class="fas fa-bolt"></i> PhonePe Payment Gateway Integrated
                            </div>
                            <h4 class="text-lg sm:text-xl font-black">100% Safe & Authorized Online Payment Collection</h4>
                            <p class="text-xs text-slate-300 font-medium mt-1">
                                Supported Methods: PhonePe UPI, Google Pay, Paytm, Net Banking, Credit/Debit Cards (Visa/Mastercard/RuPay), & Wallets.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <span class="px-3 py-1.5 bg-white/10 rounded-xl text-xs font-bold text-slate-200 border border-white/10 flex items-center gap-1.5">
                            <i class="fas fa-lock text-emerald-400"></i> 256-Bit SSL
                        </span>
                        <span class="px-3 py-1.5 bg-white/10 rounded-xl text-xs font-bold text-slate-200 border border-white/10 flex items-center gap-1.5">
                            <i class="fas fa-receipt text-cyan-400"></i> Instant E-Receipt
                        </span>
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions Bullet Points for Payment Collection -->
            <div class="space-y-6">
                <h4 class="text-lg sm:text-xl font-black text-[#031b4e] flex items-center gap-2">
                    <i class="fas fa-file-contract text-accent-blue"></i>
                    Payment Collection Rules & Terms of Service
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm text-slate-700 font-medium">
                    
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                        <h5 class="font-bold text-[#031b4e] flex items-center gap-2 text-sm">
                            <i class="fas fa-clock text-blue-600"></i> Payment Settlement Timelines
                        </h5>
                        <p class="text-slate-600 leading-relaxed">
                            Upon receiving the first month's salary or tuition fee from the school/parent, the candidate is required to settle the agreed 50% service charge within <strong>12 to 24 hours</strong> through official online channels.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                        <h5 class="font-bold text-[#031b4e] flex items-center gap-2 text-sm">
                            <i class="fas fa-ban text-red-500"></i> No Unauthorized Cash Collection
                        </h5>
                        <p class="text-slate-600 leading-relaxed">
                            Warriors Educare never asks candidates or schools to pay cash to personal bank accounts or unverified agents. All payments must be made strictly via the official portal, PhonePe Payment Gateway, or official company QR.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                        <h5 class="font-bold text-[#031b4e] flex items-center gap-2 text-sm">
                            <i class="fas fa-undo-alt text-amber-600"></i> Refund & Failed Transaction Policy
                        </h5>
                        <p class="text-slate-600 leading-relaxed">
                            Registration fees cover administrative expenses (KYC verification, database access, screening) and are non-refundable. In case of failed or duplicate transactions, amounts are automatically refunded to the source account within 5-7 business days.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                        <h5 class="font-bold text-[#031b4e] flex items-center gap-2 text-sm">
                            <i class="fas fa-gavel text-indigo-600"></i> Legal & Compliance Governing Law
                        </h5>
                        <p class="text-slate-600 leading-relaxed">
                            Candidate registration and service charge agreements are legally binding. Non-payment after successful placement is subject to civil remedy and jurisdiction of competent courts in Bihar, India.
                        </p>
                    </div>

                </div>

                <!-- Footer Quick Links for Legal Compliance -->
                <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-bold text-slate-700">
                    <span class="flex items-center gap-2 text-[#031b4e]">
                        <i class="fas fa-info-circle text-accent-blue text-sm"></i>
                        For full legal terms, refer to our detailed statutory policies:
                    </span>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('terms') }}" class="px-3 py-1.5 bg-white text-[#031b4e] rounded-lg border border-slate-200 hover:border-[#031b4e] transition-colors shadow-2xs">
                            Terms & Conditions &rarr;
                        </a>
                        <a href="{{ route('refund') }}" class="px-3 py-1.5 bg-white text-[#031b4e] rounded-lg border border-slate-200 hover:border-[#031b4e] transition-colors shadow-2xs">
                            Refund & Cancellation Policy &rarr;
                        </a>
                        <a href="{{ route('privacy') }}" class="px-3 py-1.5 bg-white text-[#031b4e] rounded-lg border border-slate-200 hover:border-[#031b4e] transition-colors shadow-2xs">
                            Privacy Policy &rarr;
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- ========================================== -->
        <!-- IMPORTANT NOTE / DISCLAIMER (CRYSTAL CLEAR)-->
        <!-- ========================================== -->
        <div class="rounded-3xl p-6 sm:p-8 shadow-sm border-2" style="background-color: #fffbeb; border-color: #fcd34d;">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 mt-0.5 shadow-xs" style="background-color: #fef3c7; color: #b45309; border: 1.5px solid #f59e0b;">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="space-y-2">
                    <h4 class="text-base sm:text-lg font-black uppercase tracking-wider" style="color: #78350f;">
                        Important Note
                    </h4>
                    <p class="text-sm sm:text-[15px] leading-relaxed font-semibold" style="color: #451a03;">
                        Registration with <strong style="color: #031b4e; font-weight: 900;">Warriors Educare</strong> is intended to facilitate tuition and job placement opportunities. However, placement is not guaranteed and depends on factors such as candidate eligibility, qualifications, availability of vacancies, parent requirements, interview performance and final selection by the parent, school or institution.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-12 text-center">
            <div class="bg-[#031b4e] text-white rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-accent-blue/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                    <h3 class="text-2xl sm:text-3xl font-black">Ready to Start Your Teaching Journey?</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        Join hundreds of educators across India who trust Warriors Educare for premier home tuition and institutional career placements.
                    </p>
                    <div class="pt-4 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('candidate.register') }}" class="px-7 py-3 bg-[#fbc043] hover:bg-[#e5ae3a] text-slate-900 font-extrabold rounded-xl text-sm shadow-md transition-all">
                            Register as Candidate &rarr;
                        </a>
                        <a href="{{ route('contact') }}" class="px-7 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl text-sm border border-white/20 transition-all">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function switchTrack(track) {
        const tuitionSection = document.getElementById('tuitionTrackSection');
        const schoolSection = document.getElementById('schoolTrackSection');
        const tuitionBtn = document.getElementById('tuitionTabBtn');
        const schoolBtn = document.getElementById('schoolTabBtn');

        if (track === 'tuition') {
            tuitionSection.classList.remove('hidden');
            schoolSection.classList.add('hidden');
            
            tuitionBtn.className = 'track-tab-btn active px-6 py-3 rounded-xl text-xs sm:text-sm font-black flex items-center gap-2.5 shrink-0';
            schoolBtn.className = 'track-tab-btn px-6 py-3 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:text-[#031b4e] flex items-center gap-2.5 shrink-0';
        } else {
            schoolSection.classList.remove('hidden');
            tuitionSection.classList.add('hidden');
            
            schoolBtn.className = 'track-tab-btn active px-6 py-3 rounded-xl text-xs sm:text-sm font-black flex items-center gap-2.5 shrink-0';
            tuitionBtn.className = 'track-tab-btn px-6 py-3 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:text-[#031b4e] flex items-center gap-2.5 shrink-0';
        }
    }
</script>
@endsection
