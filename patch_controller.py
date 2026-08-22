import re

with open('app/Http/Controllers/Admin/ReminderController.php', 'r') as f:
    code = f.read()

methods = [
    'sendServiceChargeReminder', 
    'sendRenewalReminder', 
    'sendPaymentPendingReminder', 
    'sendProfileCompletionReminder', 
    'sendPlanExpiryReminder', 
    'sendLateFeeAlert'
]

for m in methods:
    pattern = r'(\$candidateId\s*=\s*\$request->input\(\'candidate_id\'\);.*?)(\$count\s*=\s*0;)'
    match = re.search(pattern, code, re.DOTALL)
    if match:
        old_block = match.group(1)
        col_name = 'id' if "->where('id', $candidateId)" in old_block else 'candidate_id'
        
        new_block = old_block.replace(
            "$candidateId = $request->input('candidate_id');",
            "$sendToAll = $request->input('send_to_all');\n        $candidateIds = $request->input('candidate_ids', []);\n\n        if (!$sendToAll && empty($candidateIds)) {\n            return back()->with('error', 'Please select at least one candidate.');\n        }"
        )
        
        new_block = new_block.replace(
            f"if ($candidateId) {{\n            $query->where('{col_name}', $candidateId);\n        }}",
            f"if (!$sendToAll) {{\n            $query->whereIn('{col_name}', $candidateIds);\n        }}"
        )
        code = code.replace(old_block, new_block)
        
        # Replace the logging line which uses $candidateId
        code = code.replace(
            f"$this->logReminderAction('{m.replace('send', '').replace('Reminder', '').replace('Alert', '').lower()}', $count, $candidateId);",
            f"$this->logReminderAction('{m.replace('send', '').replace('Reminder', '').replace('Alert', '').lower()}', $count, null);" # Simplification for log
        )

# Fix logging strings for the specific ones:
code = code.replace("$this->logReminderAction('servicecharge', $count, null);", "$this->logReminderAction('service_charge', $count, null);")
code = code.replace("$this->logReminderAction('paymentpending', $count, null);", "$this->logReminderAction('payment_pending', $count, null);")
code = code.replace("$this->logReminderAction('profilecompletion', $count, null);", "$this->logReminderAction('profile_completion', $count, null);")
code = code.replace("$this->logReminderAction('planexpiry', $count, null);", "$this->logReminderAction('plan_expiry', $count, null);")
code = code.replace("$this->logReminderAction('latefee', $count, null);", "$this->logReminderAction('late_fee', $count, null);")
code = code.replace("$this->logReminderAction('renewal', $count, $candidateId);", "$this->logReminderAction('renewal', $count, null);")


# For sendInterviewReminder
old_interview = """$applicationId = $request->input('application_id');

        $query = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost']);

        if ($applicationId) {
            $query->where('id', $applicationId);
        } else {
            $query->where('interview_date', '<=', now()->addDays(3));
        }"""

new_interview = """$sendToAll = $request->input('send_to_all');
        $applicationIds = $request->input('candidate_ids', []);

        if (!$sendToAll && empty($applicationIds)) {
            return back()->with('error', 'Please select at least one interview.');
        }

        $query = JobApplication::whereNotNull('interview_date')
            ->where('interview_date', '>', now())
            ->with(['candidate', 'jobPost']);

        if (!$sendToAll) {
            $query->whereIn('id', $applicationIds);
        } else {
            $query->where('interview_date', '<=', now()->addDays(3));
        }"""
code = code.replace(old_interview, new_interview)
code = code.replace("$this->logReminderAction('interview', $count, $applicationId ? null : null);", "$this->logReminderAction('interview', $count, null);")

# For custom message
old_custom = """if ($request->target === 'specific' && $request->candidate_id) {
            $candidates = User::where('id', $request->candidate_id)->get();
        } else {
            $candidates = User::where('role', 'candidate')->get();
        }"""

new_custom = """if ($request->target === 'specific') {
            if(empty($request->candidate_ids)) return back()->with('error', 'Please select at least one candidate.');
            $candidates = User::whereIn('id', $request->candidate_ids)->get();
        } else {
            $candidates = User::where('role', 'candidate')->get();
        }"""
code = code.replace(old_custom, new_custom)

code = code.replace("'candidate_id' => 'required_if:target,specific|nullable|exists:users,id'", "'candidate_ids' => 'required_if:target,specific|array',\n            'candidate_ids.*' => 'exists:users,id'")

code = code.replace("$this->logReminderAction('custom', $count, $request->candidate_id, $request->title);", "$this->logReminderAction('custom', $count, null, $request->title . ' (Multiple)');")

with open('app/Http/Controllers/Admin/ReminderController.php', 'w') as f:
    f.write(code)
