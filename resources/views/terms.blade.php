@extends('layouts.app')

@section('title', 'Terms & Conditions — Warriors Educare')
@section('meta_description', 'Read the official Terms and Conditions of Warriors Educare governing home tuition services, school teacher recruitment, registration validity, fees, and placement policies.')

@section('content')
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-[#031b4e] via-[#092b77] to-[#031b4e] text-white pt-36 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] opacity-10"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-bold text-cyan-300 uppercase tracking-widest mb-4 border border-white/15">
                <i class="fas fa-shield-alt"></i> Official Legal Policy
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight mb-3">Terms & Conditions</h1>
            <p class="text-blue-100 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Welcome to Warriors Educare owned and operated by Prince Kumar ("Founder"). Please read these terms carefully before accessing or using our services.
            </p>
            <div class="mt-4 text-xs text-blue-200/80 font-medium">
                Governed by the Laws of India • Updated & Effective for All Users
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl p-6 sm:p-10 md:p-12 shadow-xl border border-slate-200/80 text-slate-700 text-sm sm:text-base leading-relaxed space-y-10">

            <!-- Welcome Box -->
            <div class="p-6 rounded-2xl border-2" style="background-color: #f0f7ff; border-color: #bae6fd;">
                <h3 class="font-black text-[#031b4e] text-lg sm:text-xl mb-2 flex items-center gap-2.5">
                    <i class="fas fa-handshake text-accent-blue"></i> Welcome to Warriors Educare
                </h3>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium mb-3">
                    Welcome to <strong>Warriors Educare</strong> owned and operated by <strong>Prince Kumar</strong> ("Founder"). These Terms & Conditions govern your access to and use of our website, services, applications, recruitment solutions, home tuition services and placement-related activities.
                </p>
                <p class="text-xs sm:text-sm text-[#031b4e] leading-relaxed font-bold">
                    By accessing our website or registering with Warriors Educare, you acknowledge that you have read, understood and agreed to be bound by these Terms & Conditions.
                </p>
            </div>

            <!-- 1. About Warriors Educare -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">1</span>
                    About Warriors Educare
                </h2>
                <p class="text-slate-700 font-medium">
                    Warriors Educare is an education and recruitment consultancy providing:
                </p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm font-semibold text-slate-700 pl-2">
                    <li class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100"><i class="fas fa-check-circle text-accent-blue"></i> School Teaching Staff Recruitment</li>
                    <li class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100"><i class="fas fa-check-circle text-accent-blue"></i> School Non-Teaching Staff Recruitment</li>
                    <li class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100"><i class="fas fa-check-circle text-accent-blue"></i> Home Tutor Placement Services</li>
                    <li class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100"><i class="fas fa-check-circle text-accent-blue"></i> Educational Staffing Solutions</li>
                    <li class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100"><i class="fas fa-check-circle text-accent-blue"></i> Candidate Screening & Verification</li>
                    <li class="flex items-center gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100"><i class="fas fa-check-circle text-accent-blue"></i> Interview Coordination Services</li>
                </ul>
                <p class="text-xs sm:text-sm text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200 mt-2 font-medium">
                    <i class="fas fa-info-circle text-accent-blue mr-1"></i> Warriors Educare acts solely as a recruitment and placement facilitator and does not act as an employer unless expressly stated otherwise.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 2. Eligibility -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">2</span>
                    Eligibility
                </h2>
                <p class="text-slate-700 font-medium">To use our services, you must:</p>
                <ul class="list-disc pl-6 space-y-1.5 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>Be at least 18 years of age.</li>
                    <li>Provide accurate and complete information.</li>
                    <li>Submit genuine documents and credentials.</li>
                    <li>Comply with all applicable laws and regulations.</li>
                </ul>
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-900 font-bold flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                    <span>Any false, misleading or forged information may result in immediate suspension or termination of services without refund.</span>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 3. Registration -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">3</span>
                    Registration
                </h2>
                <p class="text-slate-700 font-medium">Candidates may register with Warriors Educare for:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">A. Home Tuition Services</h4>
                        <p class="text-xs text-slate-700 font-medium">Registration is required before receiving tuition leads, demo opportunities or placement assistance.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">B. School Teaching & Non-Teaching Placement Services</h4>
                        <p class="text-xs text-slate-700 font-medium">Registration is required before participation in recruitment and placement activities.</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 italic">
                    * Registration does not guarantee placement, tuition assignments, interviews or employment opportunities.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 4. Candidate Verification -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">4</span>
                    Candidate Verification
                </h2>
                <p class="text-slate-700 font-medium">Warriors Educare may request documents including but not limited to:</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs text-slate-700 font-semibold">
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-id-card text-accent-blue"></i> Aadhaar Card</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-file-pdf text-accent-blue"></i> Resume / CV</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-graduation-cap text-accent-blue"></i> Educational Certificates</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-award text-accent-blue"></i> Experience Certificates</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-camera text-accent-blue"></i> Passport Photograph</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-receipt text-accent-blue"></i> Salary Slip / Statement</div>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 font-medium">
                    The Company reserves the right to verify the authenticity of submitted documents at any stage.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 5. Registration Plans & Charges -->
            <div class="space-y-4">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">5</span>
                    Registration Plans & Charges
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Home Tuition Registration -->
                    <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200">
                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">Home Tuition</span>
                        <h4 class="font-extrabold text-[#031b4e] text-base mt-2 mb-3">Registration Fee Structure</h4>
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-800 font-semibold">
                            <li class="flex items-center justify-between p-2 bg-white rounded-xl border border-amber-100">
                                <span>Junior Classes (Up to Class V)</span>
                                <span class="font-black text-amber-700">₹500</span>
                            </li>
                            <li class="flex items-center justify-between p-2 bg-white rounded-xl border border-amber-100">
                                <span>Senior Classes (Up to Class XII)</span>
                                <span class="font-black text-amber-700">₹600</span>
                            </li>
                        </ul>
                    </div>

                    <!-- School Placement Registration -->
                    <div class="p-5 rounded-2xl bg-blue-50/70 border border-blue-200">
                        <span class="text-[10px] font-black uppercase tracking-wider text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">School Placement</span>
                        <h4 class="font-extrabold text-[#031b4e] text-base mt-2 mb-1">₹1,000 Registration Fee</h4>
                        <p class="text-xs text-slate-600 mb-2 font-medium">Split Payment Structure:</p>
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-800 font-semibold">
                            <li class="flex items-center justify-between p-2 bg-white rounded-xl border border-blue-100">
                                <span>At the time of registration</span>
                                <span class="font-black text-blue-700">₹500</span>
                            </li>
                            <li class="flex items-center justify-between p-2 bg-white rounded-xl border border-blue-100">
                                <span>After selection & before joining</span>
                                <span class="font-black text-blue-700">₹500</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <p class="text-xs text-slate-600 font-medium">
                    Registration charges cover profile verification, screening, interview coordination, documentation and placement assistance.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 6. Registration Validity -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">6</span>
                    Registration Validity
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1 flex items-center justify-between">
                            <span>Home Tuition</span>
                            <span class="text-xs bg-emerald-100 text-emerald-800 font-black px-2 py-0.5 rounded-md">1 Year Validity</span>
                        </h4>
                        <p class="text-xs text-slate-600 mb-2">Registration remains valid for 1 Year from the date of registration.</p>
                        <p class="text-xs text-slate-700 font-medium">Opportunities provided based on subject expertise, location, availability and parent requirements.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1 flex items-center justify-between">
                            <span>School Placement</span>
                            <span class="text-xs bg-indigo-100 text-indigo-800 font-black px-2 py-0.5 rounded-md">8 Months Validity</span>
                        </h4>
                        <p class="text-xs text-slate-600 mb-2">Registration remains valid for 8 Months from the date of registration.</p>
                        <p class="text-xs text-slate-700 font-medium">Interviews arranged based on qualifications, experience, salary expectations and vacancies.</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 font-semibold italic">Registration is non-transferable.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 7. Recruitment & Placement Process -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">7</span>
                    Recruitment & Placement Process
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-1.5">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-2">Home Tuition Process:</h4>
                        <div>1. Registration</div>
                        <div>2. Profile Verification</div>
                        <div>3. Tuition Requirement Matching</div>
                        <div>4. Tuition Lead Sharing</div>
                        <div>5. Demo Class (if required)</div>
                        <div>6. Parent Approval</div>
                        <div>7. Tuition Confirmation</div>
                        <div>8. Commencement of Classes</div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-1.5">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-2">School Placement Process:</h4>
                        <div>1. Registration</div>
                        <div>2. Document Submission</div>
                        <div>3. Profile Screening</div>
                        <div>4. Introduction Video Submission</div>
                        <div>5. Vacancy Matching</div>
                        <div>6. Interview Scheduling</div>
                        <div>7. School Selection Process</div>
                        <div>8. Joining Confirmation</div>
                        <div>9. Successful Placement</div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 8. Service Charges -->
            <div class="space-y-4">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">8</span>
                    Service Charges
                </h2>
                
                <div class="space-y-3">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">Home Tuition Service Charge</h4>
                        <p class="text-xs sm:text-sm text-slate-700 font-medium">
                            After successfully joining a tuition assignment and receiving the first month's tuition fee, the candidate agrees to pay Warriors Educare a service charge equivalent to:
                        </p>
                        <div class="mt-2 inline-block px-3 py-1 bg-emerald-100 text-emerald-900 font-black text-xs sm:text-sm rounded-lg">
                            50% of the first month's tuition fee (15 days' tuition fee).
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">Hourly Tuition Assignments</h4>
                        <p class="text-xs sm:text-sm text-slate-700 font-medium">
                            For hourly or per-class assignments, the service charge shall be <strong>50% of the total allotted monthly classes</strong>.
                        </p>
                        <p class="text-xs text-slate-600 mt-1.5 italic">
                            <strong>Example:</strong> If a candidate is allotted 12 classes per month, the service charge shall be equivalent to 6 classes. The service charge remains payable irrespective of the number of classes actually conducted during the first month.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">School Placement Service Charge</h4>
                        <p class="text-xs sm:text-sm text-slate-700 font-medium">
                            After joining a school/institution and receiving the first salary, the candidate agrees to pay:
                        </p>
                        <div class="mt-2 inline-block px-3 py-1 bg-blue-100 text-blue-900 font-black text-xs sm:text-sm rounded-lg">
                            50% of the first month's gross salary (15 days' salary).
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 9. Payment Timeline & Late Charges -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">9</span>
                    Payment Timeline & Late Charges
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-red-50/60 border border-red-200">
                        <h4 class="font-extrabold text-red-950 text-sm mb-1">Home Tuition Timeline</h4>
                        <p class="text-xs text-slate-700 mb-2 font-medium">Service charges must be paid within <strong>12 hours</strong> of receiving the first month's tuition fee.</p>
                        <div class="text-xs text-red-800 font-bold bg-white p-2 rounded-lg border border-red-200">
                            Late Fee: ₹200 per day until full payment is received.
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl bg-red-50/60 border border-red-200">
                        <h4 class="font-extrabold text-red-950 text-sm mb-1">School Placement Timeline</h4>
                        <p class="text-xs text-slate-700 mb-2 font-medium">Placement service charges must be paid within <strong>12 hours</strong> of receiving the first salary.</p>
                        <div class="text-xs text-red-800 font-bold bg-white p-2 rounded-lg border border-red-200">
                            Late Fee: ₹300 per day until full payment is received.
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 10. Refund Policy -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">10</span>
                    Refund Policy
                </h2>
                
                <div class="space-y-2.5 text-xs sm:text-sm text-slate-700 font-medium">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">Home Tuition Registration Refund</h4>
                        <p>A candidate may be eligible for a refund of the registration fee if:</p>
                        <ul class="list-disc pl-5 mt-1 space-y-0.5">
                            <li>A parent cancels or rejects a confirmed demo class; and</li>
                            <li>Warriors Educare is unable to provide another suitable confirmed tuition lead within <strong>25 working days</strong>.</li>
                        </ul>
                        <p class="text-xs text-slate-500 mt-2 italic">* The refund process shall commence only after completion of the applicable waiting period.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">School Placement Registration</h4>
                        <p>Registration fees paid for school placement services are generally non-refundable as they cover profile verification, screening, documentation and recruitment services already rendered.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-extrabold text-[#031b4e] text-sm mb-1">Service Charges</h4>
                        <p>Service charges paid after successful placement are strictly non-refundable.</p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 11. Candidate Responsibilities -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">11</span>
                    Candidate Responsibilities
                </h2>
                <p class="text-slate-700 font-medium">Candidates agree to:</p>
                <ul class="list-disc pl-6 space-y-1 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>Maintain honesty and professionalism.</li>
                    <li>Attend interviews, demos and classes on time.</li>
                    <li>Respect parents, students, schools and staff.</li>
                    <li>Follow commitments made during the recruitment process.</li>
                    <li>Maintain appropriate professional conduct.</li>
                </ul>
                <p class="text-xs text-red-700 bg-red-50 p-2.5 rounded-xl border border-red-200 font-bold">
                    Any misconduct, fraud, indiscipline or unethical behaviour may result in suspension or permanent blacklisting.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 12. Confidentiality -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">12</span>
                    Confidentiality
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Candidates, schools and users shall not disclose confidential information relating to Warriors Educare, Parents, Students, Schools, Recruitment Processes, or Business Operations without prior written permission.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 13. No Guarantee of Placement -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">13</span>
                    No Guarantee of Placement
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Warriors Educare does not guarantee job placement, school selection, tuition assignment, interview calls, salary levels, or number of opportunities. Selection depends entirely upon candidate qualifications, experience, parent requirements, school requirements, interview performance, and vacancy availability.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 14. Employment Relationship -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">14</span>
                    Employment Relationship
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Warriors Educare acts only as a recruitment and placement facilitator. Employment shall exist solely between the candidate and the respective school, institution, parent or client.
                </p>
                <p class="text-xs text-slate-600 font-medium">
                    Warriors Educare shall not be responsible for salary disputes, PF, ESI, leave benefits, incentives, employment termination, or working conditions unless otherwise agreed in writing.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 15. Intellectual Property -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">15</span>
                    Intellectual Property
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    All content, logos, trademarks, designs, website content and branding associated with Warriors Educare are the exclusive property of Warriors Educare and may not be copied, reproduced or distributed without prior written consent.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 16. Limitation of Liability -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">16</span>
                    Limitation of Liability
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Warriors Educare shall not be liable for any direct, indirect, incidental or consequential loss arising from recruitment decisions, school employment matters, parent decisions, candidate performance, service interruptions, or third-party actions.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 17. Account Suspension & Termination -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">17</span>
                    Account Suspension & Termination
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Warriors Educare reserves the right to suspend or terminate any registration or account if false information is provided, fraudulent activity is detected, payment obligations are violated, or Terms & Conditions are breached.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 18. Governing Law & Jurisdiction -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">18</span>
                    Governing Law & Jurisdiction
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    These Terms & Conditions shall be governed by and interpreted in accordance with the laws of India. Any dispute arising out of these Terms shall be subject to the jurisdiction of the competent courts having authority over the matter.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 19. Amendments -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">19</span>
                    Amendments
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Warriors Educare reserves the right to modify, update or revise these Terms & Conditions at any time without prior notice. Continued use of the website or services shall constitute acceptance of such changes.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 20. Contact Information -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">20</span>
                    Contact Information
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-800 font-semibold">
                    <div class="flex items-center gap-2"><i class="fas fa-building text-accent-blue"></i> <span><strong>Company:</strong> Warriors Educare</span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-user-tie text-accent-blue"></i> <span><strong>Founder:</strong> Prince Kumar</span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-globe text-accent-blue"></i> <span><strong>Website:</strong> <a href="https://www.warriorseducare.com" target="_blank" class="text-accent-blue hover:underline">www.warriorseducare.com</a></span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-envelope text-accent-blue"></i> <span><strong>Email:</strong> <a href="mailto:support@warriorseducare.com" class="text-accent-blue hover:underline">support@warriorseducare.com</a></span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-phone-alt text-accent-blue"></i> <span><strong>Phone:</strong> <a href="tel:+918210545286" class="text-accent-blue hover:underline">+91 8210545286</a></span></div>
                </div>
            </div>

            <!-- Acceptance Clause -->
            <div class="p-6 rounded-2xl bg-[#031b4e] text-white shadow-lg">
                <h4 class="text-amber-400 font-extrabold uppercase tracking-wider text-xs mb-2">Acceptance of Terms</h4>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-medium">
                    By accessing our website, registering with Warriors Educare, submitting documents, attending interviews, accepting tuition assignments or using any of our services, you acknowledge that you have read, understood and agreed to these Terms & Conditions in their entirety.
                </p>
            </div>

        </div>
    </div>
@endsection
