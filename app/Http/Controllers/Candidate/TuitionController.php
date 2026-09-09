<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeTuitionLead;
use App\Models\TuitionApplication;
use App\Helpers\NotificationHelper;

use Illuminate\Support\Facades\Storage;

class TuitionController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $profile = $user->profile;
        $tuitionAgreementStatus = $profile?->tuition_agreement_status ?? 'not_required';
        $isAgreementSigned = ($tuitionAgreementStatus === 'signed' || (bool) $profile?->is_tuition_agreement_signed);
        $isAgreementActive = ($tuitionAgreementStatus === 'pending_signature');

        $completionPercentage = $profile?->completion_percentage ?? 0;
        $isProfileUnder80 = $completionPercentage < 80;

        if ($isProfileUnder80) {
            $tuitions = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
            $appliedTuitionIds = [];
        } else {
            $query = HomeTuitionLead::where('status', 'Approved');

            if ($search = $request->input('search')) {
                $query->where(function($q) use ($search) {
                    $q->where('tuition_id', 'like', "%{$search}%")
                      ->orWhere('class', 'like', "%{$search}%")
                      ->orWhere('subjects', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            }

            $tuitions = $query->latest()
                ->paginate(12)
                ->withQueryString();

            $appliedTuitionIds = TuitionApplication::where('candidate_id', $user->id)
                ->pluck('home_tuition_lead_id')
                ->toArray();
        }

        return view('candidate.tuitions.index', compact('tuitions', 'appliedTuitionIds', 'profile', 'isAgreementSigned', 'isAgreementActive', 'tuitionAgreementStatus', 'isProfileUnder80', 'completionPercentage'));
    }

    public function requestAgreement(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $profile = $user->profile;

        if (!$profile) {
            return back()->with('error', 'Candidate profile not found.');
        }

        if ($profile->tuition_agreement_status === 'not_required' || empty($profile->tuition_agreement_status)) {
            $profile->update([
                'tuition_agreement_status' => 'request_pending'
            ]);

            \App\Helpers\NotificationHelper::notifyAdmin(
                'Tuition Agreement Unlock Requested',
                $user->name . ' has requested to unlock their Home Tuition Agreement.',
                route('admin.crm.show', $user->id),
                'fas fa-unlock'
            );

            return back()->with('success', 'Your request has been sent to the admin. You will be able to sign once they approve.');
        }

        return back()->with('info', 'Your agreement is already requested or active.');
    }

    public function signAgreement(Request $request)
    {
        $request->validate([
            'accept_terms' => 'required|accepted',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'location_name' => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();
        $profile = $user->profile;
        if (!$profile) {
            return back()->with('error', 'Candidate profile not found.');
        }

        // Candidate can only sign if admin has activated the tuition agreement
        if ($profile->tuition_agreement_status !== 'pending_signature' && !$profile->is_tuition_agreement_signed) {
            return back()->with('error', 'Home Tuition Agreement signing has not been activated by the admin yet.');
        }

        if ($profile) {
            $photoPath = $profile->tuition_live_photo_path ?? $profile->live_photo_path;

            // Handle base64 live camera capture
            if ($request->filled('live_photo')) {
                $livePhoto = $request->input('live_photo');
                if (preg_match('/^data:image\/(\w+);base64,/', $livePhoto, $type)) {
                    $data = substr($livePhoto, strpos($livePhoto, ',') + 1);
                    $ext = strtolower($type[1]);
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $decoded = base64_decode($data);
                        $filename = 'candidate_live_photos/tuition_agreement_user_' . $user->id . '_' . time() . '.' . ($ext === 'jpeg' ? 'jpg' : $ext);
                        Storage::disk('public')->put($filename, $decoded);
                        $photoPath = $filename;
                    }
                }
            } elseif ($request->hasFile('live_photo_file')) {
                $photoPath = $request->file('live_photo_file')->store('candidate_live_photos', 'public');
            }

            // Strictly enforce mandatory live photo capture
            if (empty($photoPath)) {
                return back()->with('error', 'Live camera selfie is MANDATORY to sign this agreement. Please click "Open Camera" and capture your live photo (or upload photo).');
            }

            $locationName = $request->input('location_name') ?: ($request->input('latitude') ? 'GPS: ' . $request->input('latitude') . ', ' . $request->input('longitude') : ($profile->address ?? 'Location not shared'));

            $sigData = $profile->signature_data;
            $sigType = $profile->signature_type ?? 'draw';

            if ($request->filled('signature_type')) {
                $reqSigType = $request->signature_type;
                if ($reqSigType === 'draw' && $request->filled('signature_data') && str_starts_with($request->signature_data, 'data:image')) {
                    $sigData = $request->signature_data;
                    $sigType = 'draw';
                } elseif ($reqSigType === 'type' && $request->filled('signature_data')) {
                    $sigData = $request->signature_data;
                    $sigType = 'type';
                }
            }

            $signatureMeta = [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'location' => $locationName,
                'signed_at' => now()->toIso8601String(),
                'photo_path' => $photoPath,
                'signature_data' => $sigData,
                'signature_type' => $sigType,
            ];

            $updateData = [
                'is_tuition_agreement_signed' => true,
                'tuition_agreement_status' => 'signed',
                'tuition_agreement_signed_at' => now(),
                'tuition_signature_data' => json_encode($signatureMeta),
                'tuition_live_photo_path' => $photoPath,
                'tuition_latitude' => $request->input('latitude'),
                'tuition_longitude' => $request->input('longitude'),
                'tuition_location_name' => $locationName,
            ];

            // If profile has no digital signature yet and one was drawn/typed here, persist to profile
            if (!$profile->signature_data && $sigData) {
                $updateData['signature_data'] = $sigData;
                $updateData['signature_type'] = $sigType;
                $updateData['signature_date_time'] = now();
                $updateData['is_agreement_signed'] = true;
            }

            // If profile has no live photo yet, set it
            if (!$profile->live_photo_path && $photoPath) {
                $updateData['live_photo_path'] = $photoPath;
            }

            $profile->update($updateData);
        }

        NotificationHelper::notifyUser(
            $user->id,
            'Tuition Agreement Signed & Verified ✅',
            'You have successfully signed the Home Tuition Tutor Service Agreement with live verification.',
            route('candidate.tuitions.index'),
            'fas fa-file-signature'
        );

        return back()->with('success', 'Home Tuition Tutor Service Agreement signed and digitally verified!');
    }

    public function apply(Request $request, int $id)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $profile = $user->profile;

        if (($profile?->completion_percentage ?? 0) < 80) {
            return redirect()->route('candidate.profile.edit')->with('error', 'Registration Pending: Your profile must be at least 80% complete to apply for home tuitions.');
        }

        if (!$profile || !$profile->gender || !$profile->date_of_birth || !$profile->highest_qualification_name) {
            return redirect()->route('candidate.profile.edit')->with('error', 'Please complete your Basic Profile (Date of Birth, Gender & Qualification) before applying for home tuitions.');
        }

        $tuition = HomeTuitionLead::findOrFail($id);

        if ($tuition->status !== 'Approved') {
            return back()->with('error', 'This tuition requirement is no longer active or accepting applications.');
        }

        $existingApplication = TuitionApplication::where('candidate_id', $user->id)
            ->where('home_tuition_lead_id', $id)
            ->first();

        if ($existingApplication) {
            return back()->with('info', 'You have already applied to this tuition.');
        }

        TuitionApplication::create([
            'candidate_id' => $user->id,
            'home_tuition_lead_id' => $id,
            'status' => 'Applied'
        ]);

        NotificationHelper::notifyUser(
            $user->id,
            'Tuition Application Submitted ✅',
            "You have applied for {$tuition->class} ({$tuition->subjects}) in {$tuition->location}.",
            route('candidate.tuitions.index'),
            'fas fa-book-reader'
        );

        return back()->with('success', 'You have successfully applied for this tuition!');
    }
}
