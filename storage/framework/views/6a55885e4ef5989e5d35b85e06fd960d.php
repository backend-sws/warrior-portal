<?php $__env->startSection('title', 'Manage Lead: ' . $lead->parent_name); ?>
<?php $__env->startSection('subtitle', 'View lead details, update status, and manage follow-ups.'); ?>

<?php $__env->startSection('content'); ?>

<div class="mb-4">
    <a href="<?php echo e(route('admin.tuition-leads.index')); ?>" class="text-sm text-text-dark/60 hover:text-accent-blue transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Leads
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Lead Details -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Header Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-accent-blue/10 text-accent-blue flex items-center justify-center text-xl font-black border border-accent-blue/20">
                    <?php echo e(strtoupper(substr($lead->parent_name, 0, 1))); ?>

                </div>
                <div>
                    <h2 class="text-xl font-bold text-text-main"><?php echo e($lead->parent_name); ?></h2>
                    <div class="text-sm text-text-dark/60 mt-1">Enquired <?php echo e($lead->enquiry_date ? $lead->enquiry_date->format('M d, Y') : 'Unknown'); ?></div>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-2">
                <?php
                    $statusColors = [
                        'New Lead' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                        'Demo Scheduled' => 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                        'Demo Completed' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                        'Confirmed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                        'Pending' => 'bg-orange-500/10 text-orange-500 border-orange-500/20',
                        'Cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                    ];
                    $colorClass = $statusColors[$lead->status] ?? 'bg-gray-500/10 text-gray-500 border-gray-500/20';
                ?>
                <span class="<?php echo e($colorClass); ?> px-3 py-1.5 rounded-lg text-xs font-bold border uppercase tracking-wider flex items-center gap-1">
                    <?php echo e($lead->status); ?>

                </span>
                
                <?php if($lead->follow_up_date): ?>
                    <div class="text-xs font-bold text-orange-500 flex items-center gap-1 bg-orange-500/10 px-2 py-1 rounded">
                        <i class="fas fa-clock"></i> Next Follow-up: <?php echo e($lead->follow_up_date->format('M d, Y')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Full Details Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-info-circle text-accent-blue"></i> Full Requirements
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-text-dark/40 mb-1">Contact Info</div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone w-4 text-text-dark/40"></i>
                                <a href="tel:<?php echo e($lead->parent_mobile); ?>" class="text-sm font-semibold text-text-main hover:text-accent-blue transition-colors"><?php echo e($lead->parent_mobile); ?></a>
                                <a href="https://wa.me/91<?php echo e(preg_replace('/[^0-9]/', '', $lead->parent_mobile)); ?>" target="_blank" class="text-green-500 hover:text-green-600 ml-2" title="WhatsApp Parent">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </a>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-map-marker-alt w-4 mt-1 text-text-dark/40"></i>
                                <span class="text-sm font-semibold text-text-main"><?php echo e($lead->location); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-text-dark/40 mb-1">Tuition Details</div>
                        <ul class="space-y-2 text-sm text-text-main">
                            <li><span class="text-text-dark/60 inline-block w-20">Class:</span> <span class="font-semibold"><?php echo e($lead->class); ?></span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Subjects:</span> <span class="font-semibold"><?php echo e($lead->subjects); ?></span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Timing:</span> <span class="font-semibold"><?php echo e($lead->preferred_timing ?: 'Not specified'); ?></span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Tutor Pref:</span> <span class="font-semibold"><?php echo e($lead->tutor_preference); ?></span></li>
                            <li><span class="text-text-dark/60 inline-block w-20">Fee:</span> <span class="font-semibold text-green-500"><?php echo e($lead->fee ?: 'Not discussed'); ?></span></li>
                        </ul>
                    </div>

                    <div class="md:col-span-2 pt-4 border-t border-card-border">
                        <div class="text-[10px] uppercase font-bold tracking-widest text-text-dark/40 mb-1">Management Info</div>
                        <ul class="space-y-3 text-sm text-text-main">
                            <li class="flex items-center gap-2">
                                <span class="text-text-dark/60 w-32">Teacher Assigned:</span> 
                                <?php if($lead->teacher_contact || $lead->teacher_name): ?>
                                    <span class="font-semibold bg-secondary-bg px-2 py-1 rounded border border-card-border flex items-center gap-2">
                                        <?php echo e($lead->teacher_name ? $lead->teacher_name . ' (' . $lead->teacher_contact . ')' : $lead->teacher_contact); ?>

                                        <?php if($lead->teacher_contact): ?>
                                        <a href="https://wa.me/91<?php echo e(preg_replace('/[^0-9]/', '', $lead->teacher_contact)); ?>" target="_blank" class="text-green-500 hover:text-green-600" title="WhatsApp Teacher">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-text-dark/40 italic">None assigned</span>
                                <?php endif; ?>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-text-dark/60 w-32 shrink-0">Dues / Status:</span> 
                                <span class="font-semibold"><?php echo e($lead->dues ?: 'No dues recorded'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Charge Invoice (USD $) Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50 flex justify-between items-center">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-green-500 text-lg"></i> Service Charge Invoice (USD $)
                </h3>
                <span class="text-xs bg-green-500/10 text-green-500 border border-green-500/20 font-bold px-2.5 py-1 rounded-lg">
                    Direct to Parent Dashboard
                </span>
            </div>
            <div class="p-6 space-y-6">
                <!-- Invoice Creation Form -->
                <form action="<?php echo e(route('admin.tuition-leads.invoice.store', $lead->id)); ?>" method="POST" class="bg-secondary-bg/30 p-4 rounded-xl border border-card-border" onsubmit="if(this.submitted) return false; this.submitted=true; this.querySelector('button[type=submit]').disabled=true; this.querySelector('button[type=submit]').innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Sending...';">
                    <?php echo csrf_field(); ?>
                    <h4 class="text-xs font-bold text-text-main uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <i class="fas fa-plus-circle text-accent-blue"></i> Create Service Charge Invoice
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-text-dark/60 mb-1">Target Parent Account</label>
                            <select name="user_id" class="w-full px-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 font-semibold">
                                <option value="">Auto (Match Mobile: <?php echo e($lead->parent_mobile); ?>)</option>
                                <?php $__currentLoopData = $parentUsers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pUser->id); ?>" <?php echo e($lead->user_id == $pUser->id ? 'selected' : ''); ?>>
                                        <?php echo e($pUser->name); ?> (<?php echo e($pUser->phone ?: $pUser->email); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-dark/60 mb-1">Invoice Title *</label>
                            <input type="text" name="title" value="Home Tuition Service Charge" required
                                   class="w-full px-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-dark/60 mb-1">Amount ($ USD) *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-green-500">$</span>
                                <input type="number" step="0.01" name="amount" placeholder="0.00" required
                                       class="w-full pl-7 pr-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main font-bold focus:outline-none focus:ring-2 focus:ring-accent-blue/50">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-text-dark/60 mb-1">Due Date</label>
                            <input type="date" name="due_date"
                                   class="w-full px-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-text-dark/60 mb-1">Notes / Terms (Optional)</label>
                        <input type="text" name="notes" placeholder="e.g. Service fee for teacher matching and setup"
                               class="w-full px-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50">
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2.5 rounded-lg text-xs font-bold transition-colors flex items-center gap-2 shadow">
                        <i class="fas fa-paper-plane"></i> Send USD Invoice to Parent
                    </button>
                </form>

                <!-- Existing Invoices List -->
                <div>
                    <h4 class="text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-3">Generated Invoices</h4>
                    <?php if($lead->serviceChargeInvoices && $lead->serviceChargeInvoices->count() > 0): ?>
                        <div class="overflow-x-auto border border-card-border rounded-xl">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-secondary-bg border-b border-card-border font-bold text-text-dark/60">
                                    <tr>
                                        <th class="p-3">Invoice #</th>
                                        <th class="p-3">Title</th>
                                        <th class="p-3">Amount ($)</th>
                                        <th class="p-3">Status</th>
                                        <th class="p-3">Date</th>
                                        <th class="p-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-card-border text-text-main">
                                    <?php $__currentLoopData = $lead->serviceChargeInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-secondary-bg/20">
                                            <td class="p-3 font-mono font-bold text-accent-blue"><?php echo e($invoice->invoice_number); ?></td>
                                            <td class="p-3 font-semibold"><?php echo e($invoice->title); ?></td>
                                            <td class="p-3 font-bold text-green-500">$<?php echo e(number_format($invoice->amount, 2)); ?> USD</td>
                                            <td class="p-3">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold border 
                                                    <?php echo e($invoice->status === 'Paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : ''); ?>

                                                    <?php echo e($invoice->status === 'Unpaid' ? 'bg-orange-500/10 text-orange-500 border-orange-500/20' : ''); ?>

                                                    <?php echo e($invoice->status === 'Cancelled' ? 'bg-red-500/10 text-red-500 border-red-500/20' : ''); ?>

                                                ">
                                                    <?php echo e($invoice->status); ?>

                                                </span>
                                            </td>
                                            <td class="p-3 text-text-dark/60"><?php echo e($invoice->created_at->format('M d, Y')); ?></td>
                                            <td class="p-3 text-right">
                                                <form action="<?php echo e(route('admin.tuition-leads.invoice.status', $invoice->id)); ?>" method="POST" class="inline-flex items-center gap-1">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <select name="status" onchange="this.form.submit()" class="px-2 py-1 bg-secondary-bg border border-card-border rounded text-[11px] font-semibold text-text-main focus:outline-none">
                                                        <option value="Unpaid" <?php echo e($invoice->status === 'Unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                                                        <option value="Paid" <?php echo e($invoice->status === 'Paid' ? 'selected' : ''); ?>>Paid</option>
                                                        <option value="Cancelled" <?php echo e($invoice->status === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6 text-xs text-text-dark/40 bg-secondary-bg/20 rounded-xl border border-dashed border-card-border">
                            No service charge invoices created for this lead yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Teacher Documents Upload & Final Appointment -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50 flex justify-between items-center">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-id-card text-accent-blue"></i> Final Appointment & Documents
                </h3>
                <?php if($lead->is_finally_appointed): ?>
                    <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-2 py-0.5 rounded text-xs font-bold">
                        Finally Appointed
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="p-6">
                <?php if($lead->status === 'Confirmed' || $lead->is_finally_appointed): ?>
                    <form action="<?php echo e(route('admin.tuition-leads.upload-documents', $lead->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- ID Proof Front -->
                            <div>
                                <label class="block text-xs font-bold text-text-dark/60 mb-2">ID Proof Front</label>
                                <?php if($lead->id_proof_front): ?>
                                    <div class="mb-2 w-full h-24 rounded-lg border border-card-border overflow-hidden">
                                        <img src="<?php echo e(asset('storage/' . $lead->id_proof_front)); ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="id_proof_front" accept="image/*" class="text-xs w-full file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-accent-blue/10 file:text-accent-blue hover:file:bg-accent-blue/20">
                            </div>
                            
                            <!-- ID Proof Back -->
                            <div>
                                <label class="block text-xs font-bold text-text-dark/60 mb-2">ID Proof Back</label>
                                <?php if($lead->id_proof_back): ?>
                                    <div class="mb-2 w-full h-24 rounded-lg border border-card-border overflow-hidden">
                                        <img src="<?php echo e(asset('storage/' . $lead->id_proof_back)); ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="id_proof_back" accept="image/*" class="text-xs w-full file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-accent-blue/10 file:text-accent-blue hover:file:bg-accent-blue/20">
                            </div>
                            
                            <!-- Passport Size Photo -->
                            <div>
                                <label class="block text-xs font-bold text-text-dark/60 mb-2">Passport Photo</label>
                                <?php if($lead->teacher_passport_photo): ?>
                                    <div class="mb-2 w-24 h-24 rounded-lg border border-card-border overflow-hidden">
                                        <img src="<?php echo e(asset('storage/' . $lead->teacher_passport_photo)); ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="teacher_passport_photo" accept="image/*" class="text-xs w-full file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-accent-blue/10 file:text-accent-blue hover:file:bg-accent-blue/20">
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-card-border flex justify-end">
                            <button type="submit" class="bg-accent-blue hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-colors shadow">
                                <i class="fas fa-upload mr-1"></i> Upload & Finalize Appointment
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="text-center py-6 bg-secondary-bg rounded-xl border border-dashed border-card-border text-sm text-text-dark/50">
                        <i class="fas fa-lock text-2xl mb-2 text-text-dark/30 block"></i>
                        You can upload documents and finalize appointment only when the lead status is <strong>Confirmed</strong>.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Right Column: Status & Follow-ups -->
    <div class="space-y-6">
        
        <!-- Update Status Card -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-tasks text-accent-blue"></i> Update Status
                </h3>
            </div>
            <div class="p-6">
                <form action="<?php echo e(route('admin.tuition-leads.status.update', $lead->id)); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">New Status</label>
                        <select name="status" class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                            <option value="New Lead" <?php echo e($lead->status === 'New Lead' ? 'selected' : ''); ?>>New Lead</option>
                            <option value="Demo Scheduled" <?php echo e($lead->status === 'Demo Scheduled' ? 'selected' : ''); ?>>Demo Scheduled</option>
                            <option value="Demo Completed" <?php echo e($lead->status === 'Demo Completed' ? 'selected' : ''); ?>>Demo Completed</option>
                            <option value="Confirmed" <?php echo e($lead->status === 'Confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                            <option value="Pending" <?php echo e($lead->status === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="Cancelled" <?php echo e($lead->status === 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">Next Follow-up Date</label>
                        <input type="date" name="follow_up_date" value="<?php echo e($lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : ''); ?>"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">Teacher Name (Optional)</label>
                        <input type="text" name="teacher_name" value="<?php echo e($lead->teacher_name); ?>" placeholder="Teacher's full name"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all mb-4">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-text-dark/60 uppercase tracking-wider mb-2">Teacher Contact (Optional)</label>
                        <input type="text" name="teacher_contact" value="<?php echo e($lead->teacher_contact); ?>" placeholder="Phone number"
                               class="w-full px-4 py-2.5 bg-secondary-bg border border-card-border rounded-xl text-sm font-semibold text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                    </div>
                    
                    <button type="submit" class="w-full bg-accent-blue text-white rounded-xl px-4 py-2.5 text-sm font-bold shadow hover:bg-accent-blue-hover transition-colors mt-4">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Follow-ups Timeline -->
        <div class="bg-card-bg rounded-2xl border border-card-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-card-border bg-secondary-bg/50">
                <h3 class="font-bold text-text-main flex items-center gap-2">
                    <i class="fas fa-history text-accent-blue"></i> Lead History
                </h3>
            </div>
            <div class="p-6">
                <!-- Add Note Form -->
                <form action="<?php echo e(route('admin.tuition-leads.followup.store', $lead->id)); ?>" method="POST" class="mb-6">
                    <?php echo csrf_field(); ?>
                    <textarea name="note" rows="2" placeholder="Add a follow-up note or conversation details..." required
                              class="w-full px-4 py-3 bg-secondary-bg border border-card-border rounded-xl text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all mb-3 resize-none"></textarea>
                    
                    <div class="flex items-center gap-3">
                        <input type="date" name="follow_up_date" title="Set Next Follow-up Date"
                               class="w-full px-3 py-2 bg-secondary-bg border border-card-border rounded-lg text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-accent-blue/50 focus:border-accent-blue transition-all">
                        <button type="submit" class="bg-card-border text-text-main hover:bg-text-main hover:text-card-bg px-4 py-2 rounded-lg text-sm font-bold transition-colors whitespace-nowrap">
                            Add Note
                        </button>
                    </div>
                </form>

                <!-- Timeline -->
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $lead->followUps()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="relative pl-6 border-l-2 <?php echo e($loop->first ? 'border-accent-blue' : 'border-card-border'); ?>">
                            <div class="absolute -left-[5px] top-1.5 w-2 h-2 rounded-full <?php echo e($loop->first ? 'bg-accent-blue shadow-[0_0_0_4px_rgba(37,99,235,0.2)]' : 'bg-card-border'); ?>"></div>
                            
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-text-main"><?php echo e($followup->admin->name ?? 'System'); ?></span>
                                <span class="text-[10px] text-text-dark/40"><?php echo e($followup->created_at->format('M d, Y H:i')); ?></span>
                            </div>
                            <div class="text-sm text-text-dark/80 whitespace-pre-wrap leading-relaxed"><?php echo e($followup->note); ?></div>
                            <?php if($followup->follow_up_date): ?>
                                <div class="mt-2 text-xs font-bold text-orange-500 bg-orange-500/10 inline-block px-2 py-1 rounded">
                                    <i class="fas fa-clock"></i> Follow-up set for: <?php echo e($followup->follow_up_date->format('M d, Y')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-6 text-text-dark/40 text-sm">
                            No history or notes yet.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\warriors portal\warriors portal\resources\views/admin/home_tuition_leads/show.blade.php ENDPATH**/ ?>