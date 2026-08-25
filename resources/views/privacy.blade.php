@extends('layouts.app')

@section('title', 'Privacy Policy — Warriors Educare')
@section('meta_description', 'Learn how Warriors Educare collects, uses, stores, and protects personal and professional information of candidates, tutors, schools, and parents.')

@section('content')
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-[#031b4e] via-[#092b77] to-[#031b4e] text-white pt-36 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] opacity-10"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-bold text-cyan-300 uppercase tracking-widest mb-4 border border-white/15">
                <i class="fas fa-user-shield"></i> Data Protection & Privacy
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight mb-3">Privacy Policy</h1>
            <p class="text-blue-100 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Warriors Educare is committed to protecting the privacy and personal information of our users, candidates, tutors, schools, institutions, parents and website visitors.
            </p>
            <div class="mt-4 text-xs text-blue-200/80 font-medium">
                Compliant with Indian IT & Digital Personal Data Protection Standards • Updated & Effective
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl p-6 sm:p-10 md:p-12 shadow-xl border border-slate-200/80 text-slate-700 text-sm sm:text-base leading-relaxed space-y-10">

            <!-- Welcome & Commitment Box -->
            <div class="p-6 rounded-2xl border-2" style="background-color: #f0fdf4; border-color: #bbf7d0;">
                <h3 class="font-black text-[#031b4e] text-lg sm:text-xl mb-2 flex items-center gap-2.5">
                    <i class="fas fa-shield-alt text-emerald-600"></i> Welcome to Warriors Educare
                </h3>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium mb-3">
                    Welcome to <strong>Warriors Educare</strong> ("Company", "We", "Our", "Us"), owned and operated by <strong>Prince Kumar</strong> ("Founder"). We are committed to protecting the privacy and personal information of our users, candidates, tutors, schools, institutions, parents and website visitors.
                </p>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium mb-3">
                    This Privacy Policy explains how we collect, use, store, disclose and protect your information when you use our website, applications and recruitment or placement services.
                </p>
                <p class="text-xs sm:text-sm text-[#031b4e] leading-relaxed font-bold">
                    By accessing our website or using our services, you agree to the practices described in this Privacy Policy.
                </p>
            </div>

            <!-- 1. Information We Collect -->
            <div class="space-y-4">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">1</span>
                    Information We Collect
                </h2>
                <p class="text-slate-700 font-medium">We may collect the following information:</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Personal Information -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-[#031b4e] text-sm mb-2 flex items-center gap-2">
                            <i class="fas fa-user text-accent-blue"></i> Personal Information
                        </h4>
                        <ul class="text-xs sm:text-sm space-y-1 text-slate-700 list-disc pl-5 font-medium">
                            <li>Full Name</li>
                            <li>Mobile Number</li>
                            <li>Email Address</li>
                            <li>Residential Address</li>
                            <li>Date of Birth</li>
                            <li>Gender (if voluntarily provided)</li>
                            <li>Aadhaar Card Details</li>
                            <li>Passport Size Photograph</li>
                        </ul>
                    </div>

                    <!-- Professional Information -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-[#031b4e] text-sm mb-2 flex items-center gap-2">
                            <i class="fas fa-briefcase text-indigo-600"></i> Professional Information
                        </h4>
                        <ul class="text-xs sm:text-sm space-y-1 text-slate-700 list-disc pl-5 font-medium">
                            <li>Resume / CV</li>
                            <li>Educational Qualifications</li>
                            <li>Teaching Experience</li>
                            <li>Employment History</li>
                            <li>Salary Details</li>
                            <li>Salary Slip / Account Statement</li>
                            <li>Skills and Certifications</li>
                        </ul>
                    </div>

                    <!-- Tuition & Placement Information -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-[#031b4e] text-sm mb-2 flex items-center gap-2">
                            <i class="fas fa-chalkboard-teacher text-amber-600"></i> Tuition & Placement Info
                        </h4>
                        <ul class="text-xs sm:text-sm space-y-1 text-slate-700 list-disc pl-5 font-medium">
                            <li>Preferred Location</li>
                            <li>Preferred Subjects</li>
                            <li>Preferred Classes</li>
                            <li>Salary Expectations</li>
                            <li>Availability for Tuition or Employment</li>
                        </ul>
                    </div>

                    <!-- Technical Information -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-[#031b4e] text-sm mb-2 flex items-center gap-2">
                            <i class="fas fa-laptop-code text-purple-600"></i> Technical Information
                        </h4>
                        <ul class="text-xs sm:text-sm space-y-1 text-slate-700 list-disc pl-5 font-medium">
                            <li>IP Address & Browser Type</li>
                            <li>Device Information & OS</li>
                            <li>Website Usage Data</li>
                            <li>Cookies and Similar Technologies</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 2. How We Use Your Information -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">2</span>
                    How We Use Your Information
                </h2>
                <p class="text-slate-700 font-medium">We use your information for the following purposes:</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5 text-xs sm:text-sm font-semibold text-slate-700">
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Candidate Registration</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Profile Verification</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Home Tutor Placement</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> School Recruitment</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Interview Coordination</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Parent & School Matching</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Communication & Support</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Service Improvement</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Fraud Prevention</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Legal Compliance</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Payment Processing</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check text-emerald-600"></i> Record Maintenance</div>
                </div>
                <p class="text-xs text-slate-500 font-medium mt-1">We collect only information reasonably necessary to provide our services.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 3. Information Sharing -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">3</span>
                    Information Sharing
                </h2>
                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs sm:text-sm text-emerald-950 font-bold flex items-center gap-2">
                    <i class="fas fa-shield-alt text-emerald-600 text-base"></i>
                    <span>Warriors Educare does not sell personal information to third parties.</span>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">However, information may be shared with:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-700">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                        <strong class="text-[#031b4e] block mb-1">Schools & Educational Institutions</strong>
                        <span class="text-slate-600">For recruitment, screening and placement purposes.</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                        <strong class="text-[#031b4e] block mb-1">Parents & Students</strong>
                        <span class="text-slate-600">For home tuition placement and verification purposes.</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                        <strong class="text-[#031b4e] block mb-1">Service Providers</strong>
                        <span class="text-slate-600">Including payment gateway providers, website hosting providers, communication platforms and verification partners.</span>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                        <strong class="text-[#031b4e] block mb-1">Legal Authorities</strong>
                        <span class="text-slate-600">Where disclosure is required by law, court order, government authority or legal process.</span>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 4. Document Verification -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">4</span>
                    Document Verification
                </h2>
                <p class="text-slate-700 font-medium">To maintain the integrity of our recruitment and placement services, Warriors Educare may collect and verify:</p>
                <ul class="list-disc pl-6 space-y-1 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>Aadhaar Card</li>
                    <li>Educational Certificates</li>
                    <li>Experience Certificates</li>
                    <li>Resume / CV</li>
                    <li>Salary Documents</li>
                    <li>Photographs</li>
                </ul>
                <p class="text-xs text-slate-600 font-semibold italic">
                    Candidates are responsible for ensuring that all submitted documents are genuine and accurate.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 5. Payment Information -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">5</span>
                    Payment Information
                </h2>
                <p class="text-slate-700 font-medium">Payments may be processed through third-party payment gateways.</p>
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-xs sm:text-sm text-blue-950 font-semibold">
                    <i class="fas fa-lock text-accent-blue mr-1.5"></i>
                    <strong>Warriors Educare does not store complete debit card, credit card, banking credentials or UPI PIN information on its servers.</strong>
                </div>
                <p class="text-xs text-slate-600 font-medium">
                    Payment processing is subject to the privacy and security policies of the respective payment gateway provider.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 6. Cookies Policy -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">6</span>
                    Cookies Policy
                </h2>
                <p class="text-slate-700 font-medium">Our website may use cookies and similar technologies to:</p>
                <ul class="list-disc pl-6 space-y-1 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>Improve website performance</li>
                    <li>Enhance user experience</li>
                    <li>Analyze website traffic</li>
                    <li>Remember user preferences</li>
                    <li>Improve service delivery</li>
                </ul>
                <p class="text-xs text-slate-500 font-medium">Users may disable cookies through their browser settings; however, certain website features may not function properly.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 7. Data Security -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">7</span>
                    Data Security
                </h2>
                <p class="text-slate-700 font-medium">We implement reasonable technical, administrative and organizational safeguards to protect personal information from:</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs font-bold text-slate-700">
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-center"><i class="fas fa-user-shield text-accent-blue mb-1 block"></i> Unauthorized Access</div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-center"><i class="fas fa-database text-accent-blue mb-1 block"></i> Data Loss</div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-center"><i class="fas fa-ban text-accent-blue mb-1 block"></i> Misuse</div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-center"><i class="fas fa-edit text-accent-blue mb-1 block"></i> Alteration</div>
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-center col-span-2 sm:col-span-2"><i class="fas fa-eye-slash text-accent-blue mb-1 block"></i> Unauthorized Disclosure</div>
                </div>
                <p class="text-xs text-slate-500 font-medium">While we strive to protect your information, no online platform can guarantee absolute security.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 8. Data Retention -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">8</span>
                    Data Retention
                </h2>
                <p class="text-slate-700 font-medium">We retain personal information only for as long as necessary to:</p>
                <ul class="list-disc pl-6 space-y-1 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>Provide services</li>
                    <li>Maintain records</li>
                    <li>Comply with legal obligations</li>
                    <li>Resolve disputes</li>
                    <li>Enforce agreements</li>
                </ul>
                <p class="text-xs text-slate-500 font-medium">Information may be securely deleted or anonymized when no longer required.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 9. Candidate & User Responsibilities -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">9</span>
                    Candidate & User Responsibilities
                </h2>
                <p class="text-slate-700 font-medium">Users are responsible for:</p>
                <ul class="list-disc pl-6 space-y-1 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>Providing accurate information.</li>
                    <li>Keeping contact details updated.</li>
                    <li>Protecting their login credentials (if applicable).</li>
                    <li>Not sharing false, misleading or fraudulent information.</li>
                </ul>
                <p class="text-xs text-slate-500 font-medium">Warriors Educare shall not be responsible for issues arising from incorrect information provided by users.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 10. Third-Party Links -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">10</span>
                    Third-Party Links
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Our website may contain links to third-party websites, social media platforms or external services. Warriors Educare is not responsible for the privacy practices, content or security of such third-party websites. Users are encouraged to review the privacy policies of those websites separately.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 11. Children's Privacy -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">11</span>
                    Children's Privacy
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Our services are primarily intended for adults, schools, institutions, tutors and job applicants. We do not knowingly collect personal information from children under the age of 18 without appropriate parental or guardian involvement where required.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 12. User Rights -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">12</span>
                    User Rights
                </h2>
                <p class="text-slate-700 font-medium">Subject to applicable laws, users may request:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs sm:text-sm text-slate-700 font-semibold">
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check-circle text-accent-blue"></i> Access to personal information</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check-circle text-accent-blue"></i> Correction of inaccurate info</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check-circle text-accent-blue"></i> Updating of profile details</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2"><i class="fas fa-check-circle text-accent-blue"></i> Deletion where legally permissible</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2 col-span-1 sm:col-span-2"><i class="fas fa-check-circle text-accent-blue"></i> Withdrawal of consent where applicable</div>
                </div>
                <p class="text-xs text-slate-500 font-medium">Such requests may be submitted through our official contact channels.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 13. Limitation of Liability -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">13</span>
                    Limitation of Liability
                </h2>
                <p class="text-slate-700 font-medium">Warriors Educare shall not be liable for any loss, damage or unauthorized access resulting from:</p>
                <ul class="list-disc pl-6 space-y-1 text-slate-700 text-xs sm:text-sm font-medium">
                    <li>User negligence</li>
                    <li>Third-party systems</li>
                    <li>Internet failures</li>
                    <li>Cyberattacks beyond reasonable control</li>
                    <li>Incorrect information provided by users</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- 14. Changes to This Privacy Policy -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">14</span>
                    Changes to This Privacy Policy
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Warriors Educare reserves the right to update, modify or revise this Privacy Policy at any time. Any changes will become effective immediately upon publication on the website unless otherwise stated. Continued use of our services after such changes constitutes acceptance of the revised Privacy Policy.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 15. Contact Information -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">15</span>
                    Contact Information
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mb-3 font-medium">For questions regarding this Privacy Policy, data handling practices or privacy-related requests, please contact:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-800 font-semibold">
                    <div class="flex items-center gap-2"><i class="fas fa-building text-accent-blue"></i> <span><strong>Company:</strong> Warriors Educare</span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-user-tie text-accent-blue"></i> <span><strong>Founder:</strong> Prince Kumar</span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-globe text-accent-blue"></i> <span><strong>Website:</strong> <a href="https://www.warriorseducare.com" target="_blank" class="text-accent-blue hover:underline">www.warriorseducare.com</a></span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-envelope text-accent-blue"></i> <span><strong>Email:</strong> <a href="mailto:support@warriorseducare.com" class="text-accent-blue hover:underline">support@warriorseducare.com</a></span></div>
                    <div class="flex items-center gap-2"><i class="fas fa-phone-alt text-accent-blue"></i> <span><strong>Phone:</strong> <a href="tel:+918210545286" class="text-accent-blue hover:underline">+91 8210545286</a></span></div>
                </div>
            </div>

            <!-- Consent Clause -->
            <div class="p-6 rounded-2xl bg-[#031b4e] text-white shadow-lg">
                <h4 class="text-amber-400 font-extrabold uppercase tracking-wider text-xs mb-2">Consent</h4>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-medium">
                    By accessing our website, submitting information, registering for home tuition services, applying for school placements, uploading documents, making payments or using any Warriors Educare service, you consent to the collection, use, storage and processing of your information as described in this Privacy Policy.
                </p>
            </div>

        </div>
    </div>
@endsection
