<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
    <h2 class="text-2xl font-bold text-[#031b4e]">Available Tuitions</h2>
    <p class="text-sm text-[#031b4e]/80 mt-1">Find and apply for home tuitions matching your expertise.</p>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 mb-6 flex items-center">
        <i class="fas fa-check-circle mr-3"></i> <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<!-- Tuition Agreement Section -->
<div class="light-metallic-blue-card rounded-2xl border-0 shadow-sm p-6 mb-8 flex justify-between items-center bg-[#f4f7f5]/50 border border-[#031b4e]/10">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xl">
            <i class="fas fa-file-signature"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold text-[#031b4e]">Home Tuition - Tutor Service Agreement</h3>
            <p class="text-sm text-[#031b4e]/70">Review and download your tuition service agreement.</p>
        </div>
    </div>
    <div class="flex gap-3">
        <button onclick="document.getElementById('tuitionAgreementModal').classList.remove('hidden')" class="px-4 py-2 bg-white border border-[#031b4e]/20 text-[#031b4e] rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors">
            <i class="fas fa-eye mr-1"></i> View
        </button>
        <button onclick="printTuitionAgreement()" class="px-4 py-2 bg-[#0ea5e9] text-white rounded-xl text-sm font-semibold hover:bg-[#0ea5e9]/90 transition-colors shadow-sm">
            <i class="fas fa-download mr-1"></i> Download PDF
        </button>
    </div>
</div>

<!-- Modal for Tuition Agreement -->
<div id="tuitionAgreementModal" class="fixed inset-0 z-[999] hidden bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden relative">
        <div class="p-6 border-b border-[#031b4e]/10 flex justify-between items-center bg-[#f4f7f5]">
            <h3 class="text-xl font-bold text-[#031b4e]">Home Tuition – Tutor Service Agreement</h3>
            <button onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div id="printableTuitionAgreement" class="p-8 overflow-y-auto custom-scrollbar text-[#031b4e]/80 text-sm relative">
            <!-- Watermark Image -->
            <img src="<?php echo e(asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg')); ?>" class="watermark-img" alt="Watermark" style="position: absolute; top: 65%; left: 50%; transform: translateX(-50%); width: 60%; max-width: 500px; opacity: 0.1; z-index: 0; pointer-events: none;">

            <div class="text-center mb-6 relative z-10 border-b-2 border-[#031b4e] pb-4">
                <img src="<?php echo e(asset('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg')); ?>" alt="Warriors Educare Logo" style="max-height: 80px; margin: 0 auto 10px auto;">
                <h2 class="text-2xl font-bold text-[#031b4e] mb-1">WARRIORS EDUCARE</h2>
                <h3 class="text-lg font-semibold text-[#031b4e]">HOME TUITION – TUTOR SERVICE AGREEMENT</h3>
            </div>
            
            <?php
                $profile = auth()->user()->profile;
                
                // Photo URL
                $photoUrl = null;
                $photoPath = null;
                if ($profile->live_photo_path && Storage::disk('public')->exists($profile->live_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->live_photo_path);
                } elseif ($profile->profile_photo_path && Storage::disk('public')->exists($profile->profile_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->profile_photo_path);
                } elseif ($profile->passport_photo_path && Storage::disk('public')->exists($profile->passport_photo_path)) {
                    $photoPath = Storage::disk('public')->path($profile->passport_photo_path);
                }

                if ($photoPath && file_exists($photoPath)) {
                    $photoData = file_get_contents($photoPath);
                    $mime = mime_content_type($photoPath);
                    $photoUrl = 'data:' . $mime . ';base64,' . base64_encode($photoData);
                }

                // Signature
                $signature = '';
                if ($profile->signature_type === 'type') {
                    $signature = $profile->signature_data;
                } else {
                    if (Str::startsWith($profile->signature_data, 'data:image')) {
                        $signature = $profile->signature_data;
                    } elseif ($profile->signature_type === 'upload') {
                        $sigPath = Storage::disk('public')->path($profile->signature_data);
                        if (file_exists($sigPath)) {
                            $sigData = file_get_contents($sigPath);
                            $mime = mime_content_type($sigPath);
                            $signature = 'data:' . $mime . ';base64,' . base64_encode($sigData);
                        } else {
                            $signature = Storage::disk('public')->url($profile->signature_data);
                        }
                    } else {
                        // Assuming raw bytes converted to base64
                        $signature = 'data:image/png;base64,' . base64_encode($profile->signature_data);
                    }
                }
            ?>
            
            <div class="relative z-10">
            
            <!-- Candidate Details & Photo -->
            <div class="bg-gray-50 border border-gray-200 p-4 mb-6 rounded-xl flex justify-between items-start">
                <div>
                    <p class="mb-1"><strong>Candidate Name:</strong> <?php echo e(auth()->user()->name); ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?php echo e(auth()->user()->email); ?></p>
                    <p class="mb-1"><strong>Phone:</strong> <?php echo e(auth()->user()->phone); ?></p>
                    <p class="mb-0"><strong>Address:</strong> <?php echo e($profile->address); ?></p>
                </div>
                <?php if($photoUrl): ?>
                    <div>
                        <img src="<?php echo e($photoUrl); ?>" alt="Candidate Photo" class="w-20 h-24 object-cover border border-gray-300 rounded-lg">
                    </div>
                <?php endif; ?>
            </div>

            <p class="mb-4">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Tutor").</p>

            <h5 class="font-bold text-[#031b4e] mb-2">1. Purpose of Agreement</h5>
            <p class="mb-4">This Agreement confirms that the Candidate voluntarily authorizes Warriors Educare to provide home tuition opportunities and to begin the tutor placement process.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">2. Candidate Declaration</h5>
            <p class="mb-2">The Candidate declares that:</p>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>All information and documents provided are true and genuine.</li>
                <li>Any false information or forged documents may result in immediate cancellation of registration without any refund.</li>
                <li>The Candidate agrees to cooperate throughout the recruitment and placement process.</li>
                <li>The Candidate agrees to maintain professionalism while interacting with parents, students and Warriors Educare.</li>
            </ul>

            <h5 class="font-bold text-[#031b4e] mb-2">3. Registration Fee</h5>
            <p class="mb-2">The Candidate agrees to pay a Registration Fee as follows:</p>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>₹500 – Junior Classes (Up to Class V)</li>
                <li>₹600 – Senior Classes (Up to Class XII)</li>
            </ul>
            <p class="mb-4">Registration is mandatory before receiving any tuition lead, demo class or placement opportunity.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">4. Registration Validity</h5>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>Registration shall remain valid for 1 (One) Year from the date of registration.</li>
                <li>During the validity period, Warriors Educare will make reasonable efforts to provide up to 4 confirmed tuition leads, subject to the Candidate's qualifications, preferred location, subject availability and parents' requirements.</li>
                <li>Registration is non-transferable.</li>
            </ul>

            <h5 class="font-bold text-[#031b4e] mb-2">5. Registration Refund Policy</h5>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>If a parent cancels or declines a demo class and Warriors Educare is unable to provide another suitable confirmed tuition lead within 25 working days, the Candidate shall be eligible for a 100% refund of the Registration Fee.</li>
                <li>The refund process shall commence only after the completion of 25 working days from the date of the cancelled demo.</li>
            </ul>

            <h5 class="font-bold text-[#031b4e] mb-2">6. Registration Cancellation</h5>
            <p class="mb-4">If the Candidate receives three (3) consecutive demo rejections due to candidate-related reasons, Warriors Educare reserves the right to cancel the registration without any refund.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">7. Service Charge</h5>
            <p class="mb-4">After successfully joining the tuition and receiving the first month's tuition fee/payment, the Candidate agrees to pay 50% of the first month's tuition fee (equivalent to 15 days' tuition fee) to Warriors Educare as the Service Charge.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">8. Payment Timeline & Delay Charges</h5>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>The Service Charge must be paid within 12 hours of receiving the first month's tuition fee/payment.</li>
                <li>Failure to make payment within the prescribed time shall attract a Late Payment Penalty of ₹200 per day until the outstanding amount is fully cleared.</li>
            </ul>

            <h5 class="font-bold text-[#031b4e] mb-2">9. Tutor Responsibilities</h5>
            <p class="mb-2">The Candidate shall:</p>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>Maintain honesty, discipline and professionalism.</li>
                <li>Reach tuition on time.</li>
                <li>Behave respectfully with parents and students.</li>
                <li>Follow all commitments made during the placement process.</li>
            </ul>
            <p class="mb-4">Any misconduct or unprofessional behaviour may result in cancellation of registration and future services.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">10. Confidentiality</h5>
            <p class="mb-4">The Candidate shall keep confidential all information relating to Warriors Educare, parents and students and shall not disclose such information to any third party without prior written permission.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">11. No Tuition Guarantee</h5>
            <p class="mb-4">Registration with Warriors Educare does not guarantee tuition opportunity. Selection depends entirely on the parents' requirements, the Candidate's qualifications, demo performance and overall suitability.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">12. Default & Legal Action</h5>
            <p class="mb-4">In case the Candidate intentionally avoids payment of the agreed Service Charge or violates any terms of this Agreement, Warriors Educare reserves the right to recover the outstanding amount along with applicable late charges and initiate appropriate legal proceedings under the applicable laws of India. Any dispute arising from this Agreement shall be subject to the jurisdiction of the competent courts.</p>

            <h5 class="font-bold text-[#031b4e] mb-2">13. Acceptance of Terms</h5>
            <p class="mb-2">By signing this Agreement physically or digitally, the Candidate confirms that:</p>
            <ul class="list-disc pl-5 mb-4 space-y-2">
                <li>They have carefully read and understood all the terms and conditions.</li>
                <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
                <li>They agree to comply with all payment obligations and conditions mentioned herein.</li>
            </ul>

            <div class="mt-8 pt-6 border-t border-gray-300 flex justify-between items-end" style="page-break-inside: avoid;">
                <div>
                    <div class="date mb-6">
                        <strong>Date of Execution:</strong> <?php echo e(\Carbon\Carbon::now()->format('d F Y')); ?>

                    </div>
                    <p class="font-bold mb-8">For Warriors Educare</p>
                    <p>(Authorized Signatory)</p>
                </div>
                <div class="text-left" style="font-family: 'Times New Roman', Times, serif; font-size: 14px; color: #000; line-height: 1.2; margin-top: 40px; padding-left: 20%;">
                    <i>Digitally Signed by</i><br>
                    <i>Name : <?php echo e(auth()->user()->name); ?></i><br>
                    <i>Phone No : ******<?php echo e(substr(auth()->user()->phone ?? '0000', -4)); ?></i><br>
                    <i>Reason: Agreement E-signature</i><br>
                    <i>Date : <?php echo e(\Carbon\Carbon::parse($profile->signature_date_time ?? now())->format('D M d H:i:s T Y')); ?></i>
                </div>
            </div>
            </div> <!-- End relative z-10 -->
        </div>
        <div class="p-4 border-t border-[#031b4e]/10 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
            <button onclick="document.getElementById('tuitionAgreementModal').classList.add('hidden')" class="px-6 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors">Close</button>
            <button onclick="printTuitionAgreement()" class="px-6 py-2 bg-[#0ea5e9] text-white rounded-xl font-semibold hover:bg-[#0ea5e9]/90 transition-colors shadow-sm flex items-center gap-2">
                <i class="fas fa-download"></i> Download / Print PDF
            </button>
        </div>
    </div>
</div>

<script>
function printTuitionAgreement() {
    const printContents = document.getElementById('printableTuitionAgreement').innerHTML;
    const originalContents = document.body.innerHTML;

    // Create a temporary print styling
    const style = document.createElement('style');
    style.innerHTML = `
        @media print {
            body { font-family: Arial, sans-serif; padding: 20px; color: #000; position: relative; }
            h2, h3, h5 { color: #000; }
            * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
            .watermark-img { 
                position: fixed !important; 
                top: 25% !important; 
                left: 20% !important; 
                width: 60% !important; 
                opacity: 0.1 !important; 
                z-index: -1 !important; 
                display: block !important;
            }
            .relative.z-10 { position: relative !important; z-index: 10 !important; }
        }
    `;
    document.head.appendChild(style);

    document.body.innerHTML = printContents;
    window.print();
    
    // Restore
    document.body.innerHTML = originalContents;
    location.reload(); // Reload to reattach event listeners safely
}
</script>

<?php if(session('info')): ?>
    <div class="bg-blue-50 text-blue-700 p-4 rounded-xl border border-blue-100 mb-6 flex items-center">
        <i class="fas fa-info-circle mr-3"></i> <?php echo e(session('info')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 mb-6 flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i> <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $tuitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="light-metallic-blue-card rounded-2xl border-0 shadow-sm p-6 flex flex-col hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <span class="bg-[#0ea5e9]/10 text-[#0ea5e9] text-xs font-bold px-3 py-1 rounded-full">
                    <?php echo e($tuition->{'class'}); ?>

                </span>
                <span class="bg-green-50 text-green-700 text-sm font-bold px-3 py-1 rounded-lg border border-green-100">
                    ₹<?php echo e($tuition->fee); ?><span class="text-xs font-normal">/mo</span>
                </span>
            </div>

            <h3 class="text-xl font-bold text-[#031b4e] mb-2"><?php echo e($tuition->subjects); ?></h3>
            
            <div class="space-y-3 mb-6 flex-grow">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-book w-5 text-[#031b4e]/50"></i>
                    <span><?php echo e($tuition->board); ?></span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt w-5 text-[#031b4e]/50"></i>
                    <span class="line-clamp-1" title="<?php echo e($tuition->location); ?>"><?php echo e($tuition->location); ?></span>
                </div>
                <?php if($tuition->additional_notes): ?>
                <div class="text-sm text-[#031b4e]/80 mt-2 line-clamp-2" title="<?php echo e($tuition->additional_notes); ?>">
                    <?php echo e($tuition->additional_notes); ?>

                </div>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between mt-auto pt-4 border-t border-[#031b4e]/5">
                <span class="text-xs text-[#031b4e]/50">
                    <i class="far fa-clock mr-1"></i> <?php echo e($tuition->created_at->diffForHumans()); ?>

                </span>

                <?php if(in_array($tuition->id, $appliedTuitionIds)): ?>
                    <button disabled class="bg-gray-100 text-[#031b4e]/80 font-semibold py-2 px-6 rounded-xl text-sm cursor-not-allowed">
                        Applied <i class="fas fa-check ml-1"></i>
                    </button>
                <?php else: ?>
                    <form action="<?php echo e(route('candidate.tuitions.apply', $tuition->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-[#0ea5e9] hover:bg-[#0ea5e9]/90 text-white font-semibold py-2 px-6 rounded-xl text-sm transition-colors shadow-sm">
                            Apply Now
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full bg-white p-12 text-center rounded-2xl border border-[#031b4e]/5">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-reader text-[#031b4e]/50 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-[#031b4e] mb-1">No Tuitions Available</h3>
            <p class="text-[#031b4e]/80">There are currently no active tuitions to apply for. Please check back later.</p>
        </div>
    <?php endif; ?>
</div>

<?php if($tuitions->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($tuitions->links()); ?>

    </div>
<?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\warrior-portal\resources\views/candidate/tuitions/index.blade.php ENDPATH**/ ?>