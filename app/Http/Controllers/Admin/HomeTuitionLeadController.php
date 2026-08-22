<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeTuitionLead;
use App\Models\HomeTuitionLeadFollowUp;
use Illuminate\Http\Request;

use App\Models\ParentServiceChargeInvoice;
use App\Models\User;
use Illuminate\Support\Str;

class HomeTuitionLeadController extends Controller
{
    public function index(Request $request)
    {
        return $this->getLeadsView($request, 'All');
    }

    public function pending(Request $request)
    {
        return $this->getLeadsView($request, 'Pending');
    }

    public function confirmed(Request $request)
    {
        return $this->getLeadsView($request, 'Confirmed');
    }

    private function getLeadsView(Request $request, $filterStatus)
    {
        $query = HomeTuitionLead::query();

        if ($filterStatus !== 'All') {
            $query->where('status', $filterStatus);
        }

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('parent_mobile', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Additional Filters
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($class = $request->input('class')) {
            $query->where('class', 'like', "%{$class}%");
        }
        if ($subject = $request->input('subjects')) {
            $query->where('subjects', 'like', "%{$subject}%");
        }
        if ($date = $request->input('enquiry_date')) {
            $query->whereDate('enquiry_date', $date);
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        $candidates = \App\Models\User::where('role', 'candidate')
            ->where('is_active', true)
            ->with('profile.subject')
            ->orderBy('name')
            ->get(['id', 'name', 'phone', 'email']);

        $viewName = 'admin.home_tuition_leads.index';
        $title = $filterStatus === 'All' ? 'All Home Tuitions' : $filterStatus . ' Home Tuitions';
        
        return view($viewName, compact('leads', 'candidates', 'title', 'filterStatus'));
    }

    public function create()
    {
        return view('admin.home_tuition_leads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_mobile' => 'required|string|max:20',
            'class' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'status' => 'required|in:New Lead,Pending,Approved,Demo Scheduled,Demo Completed,Confirmed,Cancelled',
        ]);

        $user = \App\Models\User::where('phone', $validated['parent_mobile'])->first();

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $validated['parent_name'],
                'phone' => $validated['parent_mobile'],
                'email' => $validated['parent_mobile'] . '@warriorseducare.com', // Auto-generated
                'password' => bcrypt('12345678'), // Default password
                'role' => 'parent',
                'is_active' => true,
            ]);
        }

        $validated['user_id'] = $user->id;

        $lead = HomeTuitionLead::create($validated);

        return redirect()->route('admin.tuition-leads.index')->with('success', 'Tuition lead created successfully.');
    }

    public function show($id)
    {
        $lead = HomeTuitionLead::with(['followUps.admin', 'serviceChargeInvoices'])->findOrFail($id);
        $parentUsers = User::where('role', 'parent')->get(['id', 'name', 'phone', 'email']);
        return view('admin.home_tuition_leads.show', compact('lead', 'parentUsers'));
    }

    public function edit($id)
    {
        $lead = HomeTuitionLead::findOrFail($id);
        return view('admin.home_tuition_leads.edit', compact('lead'));
    }

    public function update(Request $request, $id)
    {
        $lead = HomeTuitionLead::findOrFail($id);
        
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_mobile' => 'required|string|max:20',
            'class' => 'required|string|max:255',
            'board' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'status' => 'nullable|in:New Lead,Pending,Approved,Demo Scheduled,Demo Completed,Confirmed,Cancelled',
        ]);

        $lead->update($validated);

        return redirect()->route('admin.tuition-leads.index')->with('success', 'Tuition lead updated successfully.');
    }

    public function approve(Request $request, $id)
    {
        $lead = HomeTuitionLead::findOrFail($id);
        $lead->update([
            'status' => 'Approved'
        ]);

        $lead->followUps()->create([
            'admin_id' => auth()->id(),
            'note' => 'Tuition requirement approved and published live for candidates/tutors.',
        ]);

        return redirect()->back()->with('success', 'Tuition requirement approved and posted live on the portal!');
    }

    public function assignTeacher(Request $request, $id)
    {
        $request->validate([
            'candidate_id' => 'required|exists:users,id',
        ]);

        $lead = HomeTuitionLead::findOrFail($id);
        $candidate = \App\Models\User::with('profile')->findOrFail($request->candidate_id);

        $lead->update([
            'teacher_name' => $candidate->name,
            'teacher_contact' => $candidate->phone,
            'status' => 'Confirmed',
        ]);

        // Create or update TuitionApplication record
        \App\Models\TuitionApplication::updateOrCreate(
            [
                'home_tuition_lead_id' => $lead->id,
                'candidate_id' => $candidate->id,
            ],
            [
                'status' => 'Assigned',
            ]
        );

        $lead->followUps()->create([
            'admin_id' => auth()->id(),
            'note' => "Teacher \"{$candidate->name}\" (Ph: {$candidate->phone}) assigned to this tuition requirement.",
        ]);

        // Notify Candidate
        \App\Helpers\NotificationHelper::notifyUser(
            $candidate->id,
            'Tuition Assigned to You!',
            "You have been assigned as teacher for {$lead->class} ({$lead->subjects}) at {$lead->location}.",
            route('candidate.tuitions.index'),
            'fas fa-chalkboard-teacher'
        );

        return redirect()->back()->with('success', "Teacher \"{$candidate->name}\" assigned successfully to {$lead->parent_name}'s tuition!");
    }

    public function updateStatus(Request $request, $id)
    {
        $lead = HomeTuitionLead::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:New Lead,Pending,Approved,Demo Scheduled,Demo Completed,Confirmed,Cancelled',
            'follow_up_date' => 'nullable|date',
            'teacher_contact' => 'nullable|string|max:20',
            'teacher_name' => 'nullable|string|max:255'
        ]);

        $lead->status = $request->status;
        if ($request->has('follow_up_date')) {
            $lead->follow_up_date = $request->follow_up_date;
        }
        if ($request->has('teacher_contact') && $request->teacher_contact) {
            $lead->teacher_contact = $request->teacher_contact;
        }
        if ($request->has('teacher_name') && $request->teacher_name) {
            $lead->teacher_name = $request->teacher_name;
        }
        
        $lead->save();

        $note = "Status updated to {$request->status}.";
        if ($request->filled('teacher_contact')) {
            $note .= " Teacher contact updated to {$request->teacher_contact}.";
        }
        if ($request->filled('teacher_name')) {
            $note .= " Teacher name updated to {$request->teacher_name}.";
        }

        $lead->followUps()->create([
            'admin_id' => auth()->id(),
            'note' => $note,
            'follow_up_date' => $request->follow_up_date,
        ]);

        return redirect()->back()->with('success', 'Lead status updated.');
    }

    public function storeFollowUp(Request $request, $id)
    {
        $lead = HomeTuitionLead::findOrFail($id);
        
        $request->validate([
            'note' => 'required|string',
            'follow_up_date' => 'nullable|date',
        ]);

        $lead->followUps()->create([
            'admin_id' => auth()->id(),
            'note' => $request->note,
            'follow_up_date' => $request->follow_up_date,
        ]);

        if ($request->filled('follow_up_date')) {
            $lead->update(['follow_up_date' => $request->follow_up_date]);
        }

        return redirect()->back()->with('success', 'Follow-up note added.');
    }

    public function storeInvoice(Request $request, $id)
    {
        $lead = HomeTuitionLead::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $userId = $request->input('user_id') ?: $lead->user_id;

        if (!$userId && $lead->parent_mobile) {
            $cleanMobile = preg_replace('/[^0-9]/', '', $lead->parent_mobile);
            $parentUser = User::where('phone', $lead->parent_mobile)
                ->orWhere('phone', $cleanMobile)
                ->orWhere('phone', 'like', "%{$cleanMobile}%")
                ->first();
            if ($parentUser) {
                $userId = $parentUser->id;
            }
        }

        // Fallback: If still no specific user_id, check if there is a parent role user
        if (!$userId) {
            $firstParent = User::where('role', 'parent')->first();
            if ($firstParent) {
                $userId = $firstParent->id;
            }
        }

        if ($userId) {
            $lead->update(['user_id' => $userId]);
        }

        $invoiceNum = 'INV-USD-' . strtoupper(Str::random(5)) . '-' . rand(100, 999);

        $invoice = ParentServiceChargeInvoice::create([
            'home_tuition_lead_id' => $lead->id,
            'user_id' => $userId,
            'invoice_number' => $invoiceNum,
            'title' => $request->title,
            'amount' => $request->amount,
            'currency' => 'USD',
            'due_date' => $request->due_date,
            'status' => 'Unpaid',
            'notes' => $request->notes,
        ]);

        $lead->followUps()->create([
            'admin_id' => auth()->id(),
            'note' => "Generated USD Service Charge Invoice #{$invoiceNum} for \${$request->amount} USD.",
        ]);

        return redirect()->back()->with('success', "Service Charge Invoice ({$invoiceNum}) created in USD ($) and sent to Parent Dashboard.");
    }

    public function updateInvoiceStatus(Request $request, $invoiceId)
    {
        $invoice = ParentServiceChargeInvoice::findOrFail($invoiceId);

        $request->validate([
            'status' => 'required|in:Unpaid,Paid,Cancelled',
        ]);

        $invoice->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Invoice status updated to {$request->status}.");
    }

    public function uploadTeacherDocuments(Request $request, $id)
    {
        $lead = HomeTuitionLead::findOrFail($id);

        $request->validate([
            'id_proof_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_proof_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'teacher_passport_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('id_proof_front')) {
            $lead->id_proof_front = $request->file('id_proof_front')->store('teacher_docs', 'public');
        }
        if ($request->hasFile('id_proof_back')) {
            $lead->id_proof_back = $request->file('id_proof_back')->store('teacher_docs', 'public');
        }
        if ($request->hasFile('teacher_passport_photo')) {
            $lead->teacher_passport_photo = $request->file('teacher_passport_photo')->store('teacher_docs', 'public');
        }

        $lead->is_finally_appointed = true;
        $lead->status = 'Confirmed';
        $lead->save();

        $lead->followUps()->create([
            'admin_id' => auth()->id(),
            'note' => "Final appointment completed and documents uploaded. Lead status set to Confirmed.",
        ]);

        return redirect()->back()->with('success', 'Documents uploaded and appointment finalized successfully.');
    }
}
