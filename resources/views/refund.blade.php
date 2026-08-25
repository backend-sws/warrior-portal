@extends('layouts.app')

@section('title', 'Refund Policy — Warriors Educare')
@section('meta_description', 'Official Refund Policy of Warriors Educare governing Home Tuition registrations, School placement services, service charges, timelines, and refund conditions.')

@section('content')
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-[#031b4e] via-[#092b77] to-[#031b4e] text-white pt-36 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] opacity-10"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-bold text-cyan-300 uppercase tracking-widest mb-4 border border-white/15">
                <i class="fas fa-undo-alt"></i> Official Refund Documentation
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight mb-3">Refund Policy</h1>
            <p class="text-blue-100 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Warriors Educare • Comprehensive conditions and guidelines regarding registrations, service charges, and refund requests.
            </p>
            <div class="mt-4 text-xs text-blue-200/80 font-medium">
                Founder: Prince Kumar • Integral Part of Terms & Conditions
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl p-6 sm:p-10 md:p-12 shadow-xl border border-slate-200/80 text-slate-700 text-sm sm:text-base leading-relaxed space-y-10">

            <!-- Policy Overview Card -->
            <div class="p-6 rounded-2xl border-2" style="background-color: #f0f7ff; border-color: #bae6fd;">
                <h3 class="font-black text-[#031b4e] text-lg sm:text-xl mb-2 flex items-center gap-2.5">
                    <i class="fas fa-file-contract text-accent-blue"></i> Warriors Educare Refund Policy
                </h3>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium mb-3">
                    This Refund Policy forms an integral part of the Terms & Conditions of <strong>Warriors Educare</strong> and applies to all Home Tuition, School Teaching Staff Recruitment and Non-Teaching Staff Placement Services offered by Warriors Educare.
                </p>
                <p class="text-xs sm:text-sm text-[#031b4e] leading-relaxed font-bold">
                    By registering with Warriors Educare, making any payment or using any of our services, you acknowledge that you have read, understood and agreed to this Refund Policy.
                </p>
            </div>

            <!-- 1. General Policy -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">1</span>
                    General Policy
                </h2>
                <p class="text-slate-700 font-medium">
                    Warriors Educare provides recruitment, placement and educational staffing services. Registration fees are charged for profile verification, candidate screening, documentation review, interview coordination, lead generation, placement assistance and administrative services.
                </p>
                <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs sm:text-sm text-amber-950 font-semibold">
                    <i class="fas fa-info-circle text-amber-600 mr-1"></i>
                    Since these services begin immediately after registration, refunds are limited and shall be granted only in circumstances specifically mentioned in this policy.
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- 2. Home Tuition Registration Fee Refund -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">2</span>
                    Home Tuition Registration Fee Refund
                </h2>
                <p class="text-slate-700 font-medium">
                    A candidate may be eligible for a refund of the Home Tuition Registration Fee <strong>only when all of the following conditions are satisfied:</strong>
                </p>
                <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-2 text-xs sm:text-sm text-emerald-950 font-semibold">
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-600 mt-0.5"></i>
                        <span>A confirmed demo class or tuition lead is cancelled by the parent before the tuition is finalized.</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-600 mt-0.5"></i>
                        <span>The cancellation is not caused by the candidate's conduct, qualifications, availability, communication skills, demo performance or any candidate-related reason.</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-600 mt-0.5"></i>
                        <span>Warriors Educare is unable to provide another suitable confirmed tuition lead within <strong>25 working days</strong> from the date of cancellation.</span>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-slate-800 font-bold bg-slate-50 p-3 rounded-xl border border-slate-200">
                    If all the above conditions are fulfilled, the candidate may become eligible for a <strong>100% refund of the registration fee</strong>. The refund process shall commence only after the completion of the applicable waiting period and internal verification.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 3. Parent Rejection After Demo Class -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">3</span>
                    Parent Rejection After Demo Class
                </h2>
                <p class="text-slate-700 font-medium">
                    Warriors Educare does not guarantee selection by any parent. Parents make the final decision based on various factors including:
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs font-bold text-slate-700">
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl">• Teaching methodology</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl">• Communication skills</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl">• Subject knowledge</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl">• Student compatibility</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl">• Experience level</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl">• Personal preference</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl col-span-2 sm:col-span-2">• Academic requirements</div>
                </div>
                <p class="text-xs sm:text-sm text-slate-700 font-medium">
                    Accordingly, if a parent rejects a candidate after a demo class or decides not to continue with the candidate, such rejection shall not automatically entitle the candidate to a refund. Warriors Educare may make reasonable efforts to provide alternative tuition opportunities based on availability and suitability.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 4. Home Tuition Registration Fee – Non-Refundable Cases -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-red-100 text-red-700 flex items-center justify-center text-xs font-black shrink-0">4</span>
                    Home Tuition Registration Fee – Non-Refundable Cases
                </h2>
                <p class="text-slate-700 font-medium">The Home Tuition Registration Fee shall not be refunded under the following circumstances:</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm text-slate-700 font-semibold pl-2">
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The candidate voluntarily withdraws from the process.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The candidate refuses a suitable tuition opportunity.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The candidate fails to attend a scheduled demo class.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The candidate is unavailable for the tuition assignment.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The candidate provides incorrect, misleading or incomplete info.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The candidate submits false, forged or invalid documents.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> Unprofessional behavior with parents, students or staff.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> 3 consecutive demo rejections due to candidate reasons.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> Violation of policies or Terms & Conditions.</li>
                    <li class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex items-center gap-2"><i class="fas fa-times text-red-500"></i> The registration validity period has expired.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- 5. School Teacher & Non-Teaching Staff Registration Fee -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">5</span>
                    School Teacher & Non-Teaching Staff Registration Fee
                </h2>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <p class="text-xs sm:text-sm text-slate-800 font-bold mb-2">
                        The registration fee paid for School Teaching and Non-Teaching Staff Placement Services is <span class="text-red-600">strictly non-refundable</span>.
                    </p>
                    <p class="text-xs text-slate-600 mb-2">The fee is charged towards:</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs text-slate-700 font-semibold">
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Profile Verification</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Candidate Screening</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Documentation Review</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Vacancy Matching</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Recruitment Support</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Interview Coordination</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Placement Assistance</div>
                        <div class="p-2 bg-white rounded-lg border border-slate-100">• Admin Processing</div>
                    </div>
                </div>
                <p class="text-xs text-slate-500 italic font-medium">
                    As these services commence immediately upon registration, no refund shall be provided once the registration process has been initiated.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 6. Interview, Selection & Placement Related Refunds -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">6</span>
                    Interview, Selection & Placement Related Refunds
                </h2>
                <p class="text-slate-700 font-medium">No refund shall be provided if:</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-700 font-medium pl-2">
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• A school rejects the candidate.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate is not shortlisted by the school.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate fails the interview.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate declines the job offer.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate refuses the joining opportunity.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate leaves before joining.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate fails to meet school requirements.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• Profile does not match vacancy criteria.</li>
                </ul>
                <p class="text-xs text-slate-600 font-semibold italic">Warriors Educare provides placement assistance only and does not guarantee employment.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 7. Service Charges & Placement Charges -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">7</span>
                    Service Charges & Placement Charges
                </h2>
                <div class="p-4 rounded-2xl bg-red-50/60 border border-red-200">
                    <h4 class="font-extrabold text-red-950 text-sm mb-2">All service charges and placement charges are strictly non-refundable:</h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-800 font-semibold">
                        <li class="flex items-center justify-between p-2 bg-white rounded-lg border border-red-100">
                            <span>Home Tuition Service Charge:</span>
                            <span class="text-red-700">50% of 1st month tuition fee (15 days fee)</span>
                        </li>
                        <li class="flex items-center justify-between p-2 bg-white rounded-lg border border-red-100">
                            <span>Hourly Tuition Assignments:</span>
                            <span class="text-red-700">50% of total allotted monthly classes</span>
                        </li>
                        <li class="flex items-center justify-between p-2 bg-white rounded-lg border border-red-100">
                            <span>School Placement Service Charge:</span>
                            <span class="text-red-700">50% of 1st month gross salary (15 days salary)</span>
                        </li>
                    </ul>
                </div>
                <p class="text-xs text-slate-600 italic">Once placement services have been successfully delivered, no refund shall be granted under any circumstances.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 8. Duplicate Payments -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">8</span>
                    Duplicate Payments
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed">
                    If a user accidentally makes a duplicate payment for the same service, Warriors Educare may, after verification of records and transactions, refund the excess amount received.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 9. Failed or Unsuccessful Transactions -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">9</span>
                    Failed or Unsuccessful Transactions
                </h2>
                <p class="text-slate-700 font-medium">
                    If payment is deducted from the user's bank account but the transaction is not successfully completed due to banking issues, technical failures, UPI network issues or payment gateway errors, the refund shall be governed by the policies and timelines of the respective bank or payment gateway provider.
                </p>
                <p class="text-xs text-slate-500 font-medium">Warriors Educare shall not be responsible for delays caused by third-party financial institutions.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 10. Refund Request Procedure -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">10</span>
                    Refund Request Procedure
                </h2>
                <p class="text-slate-700 font-medium">To request a refund, the user must contact Warriors Educare and provide:</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs text-slate-700 font-semibold">
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl"><i class="fas fa-user text-accent-blue mr-1"></i> Full Name</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl"><i class="fas fa-phone text-accent-blue mr-1"></i> Registered Mobile</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl"><i class="fas fa-receipt text-accent-blue mr-1"></i> Payment Details</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl"><i class="fas fa-barcode text-accent-blue mr-1"></i> Transaction ID</div>
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl col-span-2 sm:col-span-2"><i class="fas fa-comment-alt text-accent-blue mr-1"></i> Reason for Refund Request & Supporting Documents</div>
                </div>
                <p class="text-xs text-slate-500 font-medium">Warriors Educare reserves the right to request additional information before processing any refund request.</p>
            </div>

            <hr class="border-slate-100">

            <!-- 11. Refund Processing Timeline -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">11</span>
                    Refund Processing Timeline
                </h2>
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-xs sm:text-sm text-blue-950 font-bold">
                    <i class="fas fa-clock text-accent-blue mr-1.5"></i>
                    Approved refunds shall generally be processed within 7–15 business days from the date of approval.
                </div>
                <p class="text-xs text-slate-600 font-medium">
                    The actual credit timeline may vary depending upon Banking Networks, UPI Service Providers, Payment Gateway Providers and Financial Institutions.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 12. Right to Reject Refund Requests -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">12</span>
                    Right to Reject Refund Requests
                </h2>
                <p class="text-slate-700 font-medium">Warriors Educare reserves the absolute right to reject any refund request if:</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-700 font-medium pl-2">
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The request does not satisfy policy conditions.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• Incorrect information has been provided.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• Fraudulent activity is suspected.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• False or forged documents have been submitted.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• The candidate has violated Terms & Conditions.</li>
                    <li class="p-2 bg-slate-50 rounded-lg border border-slate-100">• Services have already been substantially provided.</li>
                </ul>
            </div>

            <hr class="border-slate-100">

            <!-- 13. Modification of Refund Policy -->
            <div class="space-y-3">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">13</span>
                    Modification of Refund Policy
                </h2>
                <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed">
                    Warriors Educare reserves the right to modify, update or revise this Refund Policy at any time without prior notice. Any revised policy shall become effective immediately upon publication on the website.
                </p>
            </div>

            <hr class="border-slate-100">

            <!-- 14. Contact Information -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <h2 class="text-xl sm:text-2xl font-black text-[#031b4e] flex items-center gap-2.5 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-[#031b4e] flex items-center justify-center text-xs font-black shrink-0">14</span>
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
                <h4 class="text-amber-400 font-extrabold uppercase tracking-wider text-xs mb-2">Acceptance</h4>
                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-medium">
                    By registering with Warriors Educare, making any payment, applying for tuition opportunities, participating in recruitment activities or using any of our services, you acknowledge that you have read, understood and agreed to this Refund Policy in its entirety.
                </p>
            </div>

        </div>
    </div>
@endsection
