<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuitionApplication;
use App\Models\HomeTuitionLead;
use App\Models\ServiceChargeInvoice;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class TuitionApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = TuitionApplication::with([
            'candidate.profile.preferredCity',
            'candidate.profile.preferredState',
            'candidate.profile.subject',
            'candidate.profile.highestQualification',
            'tuitionLead'
        ]);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('candidate', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('tuitionLead', function ($lq) use ($search) {
                    $lq->where('parent_name', 'like', "%{$search}%")
                       ->orWhere('parent_mobile', 'like', "%{$search}%")
                       ->orWhere('subjects', 'like', "%{$search}%")
                       ->orWhere('class', 'like', "%{$search}%")
                       ->orWhere('location', 'like', "%{$search}%");
                });
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $applications = (clone $query)->latest()->paginate(15)->withQueryString();

        // Calculate counts based on search filter
        $baseQuery = TuitionApplication::query();
        if ($search) {
            $baseQuery->where(function ($q) use ($search) {
                $q->whereHas('candidate', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('tuitionLead', function ($lq) use ($search) {
                    $lq->where('parent_name', 'like', "%{$search}%")
                       ->orWhere('subjects', 'like', "%{$search}%")
                       ->orWhere('location', 'like', "%{$search}%");
                });
            });
        }

        $stats = [
            'total'       => (clone $baseQuery)->count(),
            'applied'     => (clone $baseQuery)->where('status', 'Applied')->count(),
            'shortlisted' => (clone $baseQuery)->where('status', 'Shortlisted')->count(),
            'assigned'    => (clone $baseQuery)->where('status', 'Assigned')->count(),
            'rejected'    => (clone $baseQuery)->where('status', 'Rejected')->count(),
        ];

        return view('admin.tuition_applications.index', compact('applications', 'stats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'                     => 'required|in:Applied,Shortlisted,Assigned,Rejected',
            'remarks'                    => 'nullable|string|max:500',
            'demo_date'                  => 'nullable|date',
            'create_service_charge'      => 'nullable|boolean',
            'service_charge_amount'      => 'nullable|numeric|min:0',
            'service_charge_due_date'    => 'nullable|date',
            'service_charge_description' => 'nullable|string|max:255',
        ]);

        $application = TuitionApplication::with(['candidate.profile', 'tuitionLead'])->findOrFail($id);
        $oldStatus = $application->status;
        
        $application->status = $request->status;
        $application->remarks = $request->remarks;

        if ($request->filled('demo_date')) {
            $application->demo_date = $request->demo_date;
        }

        $application->save();

        $lead = $application->tuitionLead;
        $candidate = $application->candidate;

        // If status changed to Assigned, update HomeTuitionLead teacher assignment
        if ($request->status === 'Assigned' && $lead) {
            $lead->update([
                'teacher_name'    => $candidate->name,
                'teacher_contact' => $candidate->phone,
                'status'          => 'Confirmed',
            ]);

            // Add follow-up record to lead
            $lead->followUps()->create([
                'admin_id'       => auth()->id(),
                'note'           => "Teacher assigned via Tuition Application: {$candidate->name} (Ph: {$candidate->phone})",
                'follow_up_date' => now()->addDays(2)->toDateString(),
            ]);

            // Generate Service Charge Invoice for Candidate if requested
            if ($request->boolean('create_service_charge') && $request->filled('service_charge_amount') && $request->service_charge_amount > 0) {
                $amount = (float) $request->service_charge_amount;
                $dueDate = $request->service_charge_due_date ?? now()->addDays(7)->toDateString();
                $desc = $request->service_charge_description ?: "Service Charge for Home Tuition (Class {$lead->class} - {$lead->subjects})";

                $invoice = ServiceChargeInvoice::create([
                    'candidate_id'           => $candidate->id,
                    'job_application_id'     => null,
                    'home_tuition_lead_id'   => $lead->id,
                    'tuition_application_id' => $application->id,
                    'amount'                 => $amount,
                    'due_date'               => $dueDate,
                    'status'                 => 'pending',
                    'description'            => $desc,
                ]);

                if ($candidate->profile) {
                    $candidate->profile->increment('pending_amount', $amount);
                }

                // Notify Candidate for invoice
                NotificationHelper::notifyUser(
                    $candidate->id,
                    'Service Charge Invoice Generated 🧾',
                    "An invoice for ₹" . number_format($amount, 2) . " has been created for your Home Tuition assignment. Please pay by " . Carbon::parse($dueDate)->format('d M Y') . ".",
                    route('candidate.serviceCharge.show'),
                    'fas fa-file-invoice-dollar'
                );

                // Send invoice email
                try {
                    Mail::to($candidate->email)->send(new \App\Mail\ServiceChargeInvoiceMail($invoice));
                } catch (\Throwable $e) {
                    // Ignore email failure
                }
            }

            // Notify candidate for assignment
            NotificationHelper::notifyUser(
                $candidate->id,
                'Tuition Assigned! 🎉',
                "Congratulations! You have been assigned as the tutor for {$lead->class} ({$lead->subjects}) in {$lead->location}. Parent Contact: {$lead->parent_name} ({$lead->parent_mobile}).",
                route('candidate.applications.index', ['tab' => 'tuitions']),
                'fas fa-chalkboard-teacher'
            );
        } elseif ($request->status === 'Shortlisted' && $oldStatus !== 'Shortlisted') {
            NotificationHelper::notifyUser(
                $candidate->id,
                'Shortlisted for Home Tuition ⭐',
                "You have been shortlisted for {$lead?->class} ({$lead?->subjects}) in {$lead?->location}. Admin will contact you soon for the demo session.",
                route('candidate.applications.index', ['tab' => 'tuitions']),
                'fas fa-star'
            );
        } elseif ($request->status === 'Rejected' && $oldStatus !== 'Rejected') {
            NotificationHelper::notifyUser(
                $candidate->id,
                'Tuition Application Update',
                "Your application for {$lead?->class} ({$lead?->subjects}) was not shortlisted for this requirement.",
                route('candidate.applications.index', ['tab' => 'tuitions']),
                'fas fa-info-circle'
            );
        }

        // If Demo Date was scheduled
        if ($request->filled('demo_date') && $request->demo_date !== $application->getOriginal('demo_date')) {
            $formattedDemo = Carbon::parse($request->demo_date)->format('d M Y, h:i A');
            NotificationHelper::notifyUser(
                $candidate->id,
                'Demo Class Scheduled! 📅',
                "Your demo session for {$lead?->class} ({$lead?->subjects}) is scheduled on {$formattedDemo}. Location: {$lead?->location}.",
                route('candidate.applications.index', ['tab' => 'tuitions']),
                'fas fa-calendar-check'
            );
        }

        return back()->with('success', "Application status for {$candidate->name} updated to {$request->status} successfully.");
    }
}
