<?php

$file = 'app/Http/Controllers/Admin/ReminderController.php';
$code = file_get_contents($file);

$methods = [
    'sendServiceChargeReminder', 
    'sendRenewalReminder', 
    'sendPaymentPendingReminder', 
    'sendProfileCompletionReminder', 
    'sendPlanExpiryReminder', 
    'sendLateFeeAlert'
];

foreach ($methods as $m) {
    // Find the block starting with $candidateId = $request->input('candidate_id'); and ending with $count = 0;
    $pattern = '/(\$candidateId\s*=\s*\$request->input\(\'candidate_id\'\);.*?)(\$count\s*=\s*0;)/s';
    if (preg_match($pattern, $code, $matches)) {
        $old_block = $matches[1];
        
        $col_name = strpos($old_block, "->where('id', \$candidateId)") !== false ? 'id' : 'candidate_id';
        
        $new_block = str_replace(
            "\$candidateId = \$request->input('candidate_id');",
            "\$sendToAll = \$request->input('send_to_all');\n        \$candidateIds = \$request->input('candidate_ids', []);\n\n        if (!\$sendToAll && empty(\$candidateIds)) {\n            return back()->with('error', 'Please select at least one candidate.');\n        }",
            $old_block
        );
        
        $new_block = str_replace(
            "if (\$candidateId) {\n            \$query->where('$col_name', \$candidateId);\n        }",
            "if (!\$sendToAll) {\n            \$query->whereIn('$col_name', \$candidateIds);\n        }",
            $new_block
        );
        
        $code = str_replace($old_block, $new_block, $code);
        
        // Log replace
        $logMethod = strtolower(str_replace(['send', 'Reminder', 'Alert'], '', $m));
        $code = str_replace(
            "\$this->logReminderAction('$logMethod', \$count, \$candidateId);",
            "\$this->logReminderAction('$logMethod', \$count, null);",
            $code
        );
    }
}

// Fix log names
$code = str_replace("\$this->logReminderAction('servicecharge', \$count, null);", "\$this->logReminderAction('service_charge', \$count, null);", $code);
$code = str_replace("\$this->logReminderAction('paymentpending', \$count, null);", "\$this->logReminderAction('payment_pending', \$count, null);", $code);
$code = str_replace("\$this->logReminderAction('profilecompletion', \$count, null);", "\$this->logReminderAction('profile_completion', \$count, null);", $code);
$code = str_replace("\$this->logReminderAction('planexpiry', \$count, null);", "\$this->logReminderAction('plan_expiry', \$count, null);", $code);
$code = str_replace("\$this->logReminderAction('latefee', \$count, null);", "\$this->logReminderAction('late_fee', \$count, null);", $code);

// Interview
$old_interview = "\$applicationId = \$request->input('application_id');

        \$query = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost']);

        if (\$applicationId) {
            \$query->where('id', \$applicationId);
        } else {
            \$query->where('interview_date', '<=', now()->addDays(3));
        }";

$new_interview = "\$sendToAll = \$request->input('send_to_all');
        \$applicationIds = \$request->input('candidate_ids', []);

        if (!\$sendToAll && empty(\$applicationIds)) {
            return back()->with('error', 'Please select at least one interview.');
        }

        \$query = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost']);

        if (!\$sendToAll) {
            \$query->whereIn('id', \$applicationIds);
        } else {
            \$query->where('interview_date', '<=', now()->addDays(3));
        }";
$code = str_replace($old_interview, $new_interview, $code);
$code = str_replace("\$this->logReminderAction('interview', \$count, \$applicationId ? null : null);", "\$this->logReminderAction('interview', \$count, null);", $code);

// Custom Message
$old_custom = "if (\$request->target === 'specific' && \$request->candidate_id) {
            \$candidates = User::where('id', \$request->candidate_id)->get();
        } else {
            \$candidates = User::where('role', 'candidate')->get();
        }";

$new_custom = "if (\$request->target === 'specific') {
            if(empty(\$request->candidate_ids)) return back()->with('error', 'Please select at least one candidate.');
            \$candidates = User::whereIn('id', \$request->candidate_ids)->get();
        } else {
            \$candidates = User::where('role', 'candidate')->get();
        }";
$code = str_replace($old_custom, $new_custom, $code);
$code = str_replace("'candidate_id' => 'required_if:target,specific|nullable|exists:users,id'", "'candidate_ids' => 'required_if:target,specific|array',\n            'candidate_ids.*' => 'exists:users,id'", $code);
$code = str_replace("\$this->logReminderAction('custom', \$count, \$request->candidate_id, \$request->title);", "\$this->logReminderAction('custom', \$count, null, \$request->title . ' (Multiple)');", $code);

file_put_contents($file, $code);
echo "Patched successfully!";
