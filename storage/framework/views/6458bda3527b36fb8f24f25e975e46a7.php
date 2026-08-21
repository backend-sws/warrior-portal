<?php $__env->startSection('content'); ?>
<?php echo $__env->make('candidate.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <div class="text-center mb-8 reveal">
        <div class="w-14 h-14 rounded-2xl bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-2xl mx-auto mb-4">
            <i class="fas fa-file-contract"></i>
        </div>
        <h1 class="text-2xl font-bold text-[#031b4e]">Candidate Agreement</h1>
        <p class="text-sm text-[#031b4e]/60 mt-2 max-w-md mx-auto">Please read the terms and conditions carefully and provide your digital signature below.</p>
    </div>

    <?php if(session('error')): ?>
        <div class="mb-6 bg-red-500/10 border border-red-500/30 p-4 rounded-xl flex items-center gap-3 justify-center reveal">
            <i class="fas fa-exclamation-circle text-red-400"></i>
            <span class="text-sm text-red-400 font-medium"><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?>

    
    <div class="light-metallic-blue-card rounded-2xl border-0 overflow-hidden shadow-xl reveal reveal-delay-1">

        
        <div class="p-6 md:p-8 border-b border-[#031b4e]/10">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-8 h-8 rounded-lg bg-[#0ea5e9]/10 text-[#0ea5e9] flex items-center justify-center text-xs"><i class="fas fa-scroll"></i></span>
                <h2 class="text-lg font-bold text-[#031b4e]">Terms and Conditions</h2>
            </div>
            <div class="h-96 overflow-y-auto pr-4 text-sm text-[#031b4e]/80 space-y-4 custom-scrollbar bg-[#f4f7f5]/30 rounded-xl p-6 border border-[#031b4e]/10">
                <h4 class="font-bold text-[#031b4e] mb-4 text-center">TEACHER PLACEMENT SERVICE AGREEMENT</h4>
                
                <p class="mb-4">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Teacher").</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">1. Purpose of Agreement</h5>
                <p class="mb-4">This Agreement confirms that the Candidate willingly authorizes Warriors Educare to begin the recruitment and placement process for suitable teaching opportunities.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">2. Candidate Declaration</h5>
                <p class="mb-2">The Candidate declares that:</p>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>All information and documents submitted are true and genuine.</li>
                    <li>Any false information or forged document may result in immediate cancellation of registration and placement without any refund.</li>
                    <li>The Candidate agrees to cooperate throughout the recruitment process.</li>
                </ul>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">3. Document Verification</h5>
                <p class="mb-2">The Candidate shall provide all required documents, including but not limited to:</p>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>Aadhaar Card</li>
                    <li>Salary slip/Account statement</li>
                    <li>Passport-size Photograph</li>
                    <li>Any other document required by the school or Warriors Educare.</li>
                </ul>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">4. Registration Charges</h5>
                <p class="mb-2">The Candidate agrees to pay a non-refundable Registration Fee of ₹1,000, payable as follows:</p>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>₹500 at the time of registration to initiate the recruitment process.</li>
                    <li>₹500 immediately after selection by the school and before joining.</li>
                </ul>
                <p class="mb-4">Registration fees are charged for profile verification, documentation, screening, interview coordination and placement services. These charges are non-refundable.</p>
                <p class="mb-4"><strong>Registration Validity:</strong> The registration shall remain valid for 8 (Eight) months from the date of registration. During this period, Warriors Educare will make reasonable efforts to arrange up to 4–5 suitable interviews, subject to the Candidate's qualifications, preferred location, salary expectations and the availability of vacancies. The registration is non-transferable and non-refundable. After the expiry of the validity period, a fresh registration and the applicable registration fee may be required to continue placement services.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">5. Placement Service Charge</h5>
                <p class="mb-4">After joining the school/Institution and receiving the first month's salary/payment, the Candidate agrees to pay 50% of the first month's salary (equivalent to 15 days' salary) to Warriors Educare as the Placement Service Charge.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">6. Payment Timeline & Delay Charges</h5>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>The Placement Service Charge must be paid within 12 hours of receiving the first salary/payment from the school/Institution.</li>
                    <li>If payment is not made within the prescribed time, a Late Payment Penalty of ₹300 per day shall be applicable until full payment is received.</li>
                    <li>Warriors Educare reserves the right to suspend future placement services until all dues are cleared.</li>
                </ul>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">7. Job Placement</h5>
                <p class="mb-4">Warriors Educare provides recruitment and placement assistance only. Final selection, salary, benefits, probation, working conditions and employment terms shall be decided solely by the respective school/Institution.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">8. Joining Commitment</h5>
                <p class="mb-4">If the Candidate accepts the offer and confirms joining, they shall not refuse or leave before joining without a genuine reason and prior written/intimated notice to Warriors Educare.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">9. Professional Conduct</h5>
                <p class="mb-4">The Candidate shall maintain professionalism, honesty, discipline and comply with all school policies. Any misconduct, indiscipline or fraudulent activity may result in blacklisting from Warriors Educare.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">10. Confidentiality</h5>
                <p class="mb-4">The Candidate shall not disclose confidential information relating to Warriors Educare, the recruiting school or students to any third party.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">11. No Job Guarantee</h5>
                <p class="mb-4">Registration with Warriors Educare does not guarantee job placement. Selection depends entirely on the school's/Institutions requirements, interview performance and candidate eligibility.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">12. Employment Relationship</h5>
                <p class="mb-4">The Candidate understands that employment shall be with the respective school only. Warriors Educare acts solely as a recruitment and placement agency and shall not be responsible for salary, PF, ESI, leave, incentives or any employment benefits unless otherwise agreed in writing.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">13. Default & Legal Action</h5>
                <p class="mb-4">In case the Candidate intentionally avoids payment of the agreed Placement Service Charge or violates this Agreement, Warriors Educare reserves the right to recover the outstanding amount along with applicable late charges and to initiate appropriate legal proceedings under the applicable laws of India. Any dispute arising out of this Agreement shall be subject to the jurisdiction of the competent courts.</p>

                <h5 class="font-bold text-[#031b4e] mt-4 mb-2">14. Acceptance of Terms</h5>
                <p class="mb-2">By signing this Agreement physically or digitally, the Candidate confirms that:</p>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>They have carefully read and understood all the terms and conditions.</li>
                    <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
                    <li>They agree to comply with all payment obligations and conditions mentioned herein.</li>
                </ul>

                <hr class="my-6 border-[#031b4e]/10">

                <h4 class="font-bold text-[#031b4e] mb-4 text-center">DECLARATION & ACCEPTANCE</h4>
                <div class="bg-white p-5 rounded-lg border border-[#031b4e]/10 space-y-3 text-sm">
                    <p>I, <strong><?php echo e($user->name); ?></strong>, hereby solemnly declare that I have thoroughly read, understood, and willingly accepted all the terms and conditions stated in this document of Warriors Educare.</p>
                    <p>I confirm that all personal, academic, and professional details provided by me are true, accurate, and complete. I understand that any false or misleading information may result in immediate cancellation of my registration without any refund.</p>
                    <p>I hereby agree to pay a service/registration fee of <strong>₹ 1000 (Rupees One Thousand only)</strong> to Warriors Educare, as mutually agreed, for availing recruitment and placement assistance services.</p>
                    <p>I clearly acknowledge and accept that the aforesaid amount is non-refundable under any circumstances once paid, irrespective of selection, joining, delay, or personal decision.</p>
                    <p>I further understand that Warriors Educare functions solely as a placement facilitation and consultancy service provider and does not guarantee employment, salary structure, job continuity, or service conditions, which are solely governed by the hiring institution.</p>
                    <p>I agree to abide by all rules, policies, and professional ethics of the agency. Any breach, non-compliance, or misconduct on my part may lead to termination of services and may attract legal action, if deemed necessary.</p>
                    <p>This declaration shall be deemed to constitute a lawful and binding agreement, enforceable in accordance with applicable laws, and subject exclusively to the jurisdiction of Patna, Bihar.</p>
                    <p class="font-semibold text-accent-red mt-2">Candidates agree to resolve disputes through formal communication before taking legal recourse.</p>
                </div>
                
                <p class="mt-8 font-semibold text-accent-yellow italic border-l-2 border-accent-yellow/40 pl-4">By signing below, you acknowledge that you have read, understood, and agree to be bound by these terms.</p>
            </div>
        </div>

        
        <?php if($profile->is_agreement_signed): ?>
            <div class="p-6 md:p-8 bg-green-500/5">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#031b4e] mb-1">Agreement Digitally Signed</h3>
                        <p class="text-sm text-[#031b4e]/70 mb-6">You have accepted the terms and conditions.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-6 mb-6">
                            
                            <div class="bg-white border border-[#031b4e]/10 rounded-xl p-5 flex-1">
                                <h4 class="text-xs font-semibold text-[#031b4e]/50 uppercase tracking-wider mb-3">
                                    <?php echo e($profile->signature_data ? 'Your Digital Signature' : 'Agreement Status'); ?>

                                </h4>
                                
                                <?php if($profile->signature_data): ?>
                                    <div class="text-left" style="font-family: 'Times New Roman', Times, serif; font-size: 14px; color: #000; line-height: 1.2;">
                                        <i>Digitally Signed by</i><br>
                                        <i>Name : <?php echo e(auth()->user()->name); ?></i><br>
                                        <i>Phone No : ******<?php echo e(substr(auth()->user()->phone ?? '0000', -4)); ?></i><br>
                                        <i>Reason: Agreement E-signature</i><br>
                                        <i>Date : <?php echo e($profile->signature_date_time ? \Carbon\Carbon::parse($profile->signature_date_time)->format('D M d H:i:s T Y') : now()->format('D M d H:i:s T Y')); ?></i>
                                    </div>
                                <?php else: ?>
                                    <p class="text-sm font-medium text-[#031b4e] mb-3">
                                        <i class="fas fa-file-pdf text-[#0ea5e9] mr-1"></i> Agreement manually uploaded by Admin.
                                    </p>
                                    <div class="text-xs text-[#031b4e]/60 mt-4 pt-4 border-t border-[#031b4e]/10">
                                        <span class="block text-[#031b4e]/50 mb-0.5">Uploaded On</span>
                                        <span class="font-medium text-[#031b4e]/80"><?php echo e($profile->updated_at->format('d M Y, h:i A')); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <?php if($profile->live_photo_path): ?>
                            <div class="bg-white border border-[#031b4e]/10 rounded-xl p-5 flex-1">
                                <h4 class="text-xs font-semibold text-[#031b4e]/50 uppercase tracking-wider mb-3">
                                    Identity Verification Photo
                                </h4>
                                <img src="<?php echo e(asset('storage/' . $profile->live_photo_path)); ?>" alt="Live Photo" class="h-20 w-auto rounded-lg object-cover mb-3 border border-[#031b4e]/10">
                                
                                <div class="text-xs text-[#031b4e]/60 mt-4 pt-4 border-t border-[#031b4e]/10">
                                    <span class="block text-[#031b4e]/50 mb-0.5">Location Captured</span>
                                    <span class="font-medium text-[#031b4e]/80">
                                        <?php if($profile->latitude && $profile->longitude): ?>
                                            <?php echo e(number_format($profile->latitude, 4)); ?>, <?php echo e(number_format($profile->longitude, 4)); ?>

                                        <?php else: ?>
                                            Not Available
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-6">
                            <a href="<?php echo e(route('candidate.agreement.download', ['regenerate' => 1])); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0ea5e9]/10 text-[#0ea5e9] font-medium rounded-lg hover:bg-[#0ea5e9]/20 transition-colors text-sm">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($profile->agreement_status === 'pending_signature'): ?>
            <div class="p-6 md:p-8">
                <form action="<?php echo e(route('candidate.agreement.sign')); ?>" method="POST" id="signature-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="signature" id="signature-data">

                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-8 h-8 rounded-lg bg-accent-yellow/10 text-accent-yellow flex items-center justify-center text-xs"><i class="fas fa-pen-fancy"></i></span>
                        <div>
                            <h3 class="text-lg font-bold text-[#031b4e]">Digital Signature</h3>
                            <p class="text-xs text-[#031b4e]/60 mt-0.5">Use your mouse or touchscreen to sign inside the box below.</p>
                        </div>
                    </div>

                    <div class="border-2 border-dashed border-[#031b4e]/10 rounded-xl bg-[#f4f7f5]/30 relative overflow-hidden group hover:border-[#0ea5e9]/30 transition-colors" style="width: 100%; max-width: 500px;">
                        <canvas id="signature-pad" class="w-full h-48 cursor-crosshair touch-none"></canvas>
                        <div class="absolute bottom-2 right-2 text-[10px] text-[#031b4e]/80/20 pointer-events-none">Sign here</div>
                    </div>
                    <div class="mt-2.5">
                        <button type="button" id="clear-signature" class="text-xs text-red-400 hover:text-red-300 font-medium flex items-center gap-1.5 transition-colors">
                            <i class="fas fa-eraser"></i> Clear Signature
                        </button>
                    </div>
                </div>

                <div class="mb-6 bg-[#0ea5e9]/5 border border-[#0ea5e9]/10 p-4 rounded-xl flex items-start gap-3">
                    <input id="terms_accepted" name="terms_accepted" type="checkbox" required class="w-4 h-4 mt-0.5 rounded border-[#031b4e]/10 text-[#0ea5e9] focus:ring-[#0ea5e9]/50 bg-[#f4f7f5] cursor-pointer">
                    <label for="terms_accepted" class="text-sm text-[#031b4e]/70 cursor-pointer leading-relaxed">
                        I hereby declare that I agree to all the terms and conditions mentioned above and my digital signature is legally binding.
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="submit-btn" class="px-8 py-3 bg-[#0ea5e9] text-white font-semibold rounded-xl hover:bg-[#0ea5e9]-hover hover:-translate-y-0.5 transition-all shadow-lg flex items-center gap-2">
                        <i class="fas fa-file-signature"></i> Sign Agreement
                    </button>
                </div>
            </form>
        </div>
        <?php else: ?>
            <div class="p-8 text-center bg-gray-50 border-t border-[#031b4e]/10">
                <div class="w-16 h-16 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="text-xl font-bold text-[#031b4e] mb-2">Agreement Not Activated</h3>
                <p class="text-sm text-[#031b4e]/60 mb-6 max-w-md mx-auto">Your candidate agreement does not need to be signed at this time. Admin will activate it when you are assigned a job or tuition.</p>
                
                <form action="<?php echo e(route('candidate.agreement.request')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="px-6 py-2.5 bg-[#031b4e] text-white font-medium rounded-lg hover:bg-blue-900 transition-colors inline-flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i> Request Activation
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    const clearBtn = document.getElementById('clear-signature');
    const form = document.getElementById('signature-form');
    const signatureDataInput = document.getElementById('signature-data');

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        ctx.scale(ratio, ratio);
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.lineWidth = 2;
        ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--theme-text-main').trim() || '#ffffff';
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    let isDrawing = false;
    let hasDrawn = false;
    let lastX = 0;
    let lastY = 0;

    function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        const clientX = e.clientX || e.touches[0].clientX;
        const clientY = e.clientY || e.touches[0].clientY;
        return [clientX - rect.left, clientY - rect.top];
    }

    function startDrawing(e) {
        isDrawing = true;
        hasDrawn = true;
        [lastX, lastY] = getCoordinates(e);
    }

    function draw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const [x, y] = getCoordinates(e);
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.stroke();
        [lastX, lastY] = [x, y];
    }

    function stopDrawing() { isDrawing = false; }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    canvas.addEventListener('touchstart', startDrawing, { passive: false });
    canvas.addEventListener('touchmove', draw, { passive: false });
    canvas.addEventListener('touchend', stopDrawing);

    clearBtn.addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasDrawn = false;
    });

    form.addEventListener('submit', (e) => {
        if (!hasDrawn) {
            e.preventDefault();
            alert('Please provide your signature before submitting.');
            return;
        }
        signatureDataInput.value = canvas.toDataURL('image/png');
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Employee\Desktop\warrioredu\resources\views/candidate/agreement/show.blade.php ENDPATH**/ ?>