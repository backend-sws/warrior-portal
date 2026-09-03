<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $profile = $user->profile;

        // We no longer require the profile to be complete just to view the agreement status

        // We no longer redirect to wizard because agreement is optional during registration

        // If already signed, we will just show the signed state in the view.
        return view('candidate.agreement.show', compact('user', 'profile'));
    }

    public function requestActivation()
    {
        $user = auth()->user();
        // Here you would typically send an email/notification to the admin.
        // For now we just flash a message to the user.
        return back()->with('success', 'Your request has been sent to the admin. They will activate your agreement shortly.');
    }

    public function sign(Request $request)
    {
        $request->validate([
            'signature' => 'required|string', // Base64 image
            'terms_accepted' => 'required|accepted'
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        // Check if agreement is activated for signing
        if (!$profile || ($profile->agreement_status !== 'pending_signature' && !$profile->is_agreement_signed)) {
            return back()->with('error', 'Agreement signing is currently locked. Please request agreement activation from admin.');
        }

        // Ensure signature is valid base64 image data
        if (preg_match('/^data:image\/(\w+);base64,/', $request->signature, $type)) {
            $signatureData = substr($request->signature, strpos($request->signature, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
        
            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                return back()->with('error', 'Invalid signature image type');
            }
            $signatureData = base64_decode($signatureData);
        } else {
            return back()->with('error', 'Did not match data URI with image data');
        }

        $photoPath = $profile->live_photo_path;
        if ($request->filled('live_photo')) {
            $livePhoto = $request->input('live_photo');
            if (preg_match('/^data:image\/(\w+);base64,/', $livePhoto, $pType)) {
                $pData = substr($livePhoto, strpos($livePhoto, ',') + 1);
                $pExt = strtolower($pType[1]);
                if (in_array($pExt, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $decodedPhoto = base64_decode($pData);
                    $photoFilename = 'candidate_live_photos/job_agreement_user_' . $user->id . '_' . time() . '.' . ($pExt === 'jpeg' ? 'jpg' : $pExt);
                    Storage::disk('public')->put($photoFilename, $decodedPhoto);
                    $photoPath = $photoFilename;
                }
            }
        } elseif ($request->hasFile('live_photo_file')) {
            $photoPath = $request->file('live_photo_file')->store('candidate_live_photos', 'public');
        }

        // Enforce mandatory photo
        if (empty($photoPath)) {
            return back()->with('error', 'Live camera photo or photo upload is mandatory to sign this agreement.');
        }

        $locationName = $request->input('location_name') ?: ($request->input('latitude') ? 'GPS: ' . $request->input('latitude') . ', ' . $request->input('longitude') : null);

        $fileName = $this->generateStampedPdf($user, $profile, $signatureData, $type);

        // Update profile
        $updateData = [
            'is_agreement_signed' => true,
            'agreement_pdf_path' => $fileName,
            'agreement_status' => 'signed',
            'signature_data' => $request->signature,
            'signature_type' => 'draw',
            'signature_date_time' => now(),
            'signature_ip_address' => $request->ip(),
            'signature_device_info' => $request->userAgent(),
        ];
        if ($photoPath) {
            $updateData['live_photo_path'] = $photoPath;
        }
        if ($request->filled('latitude')) {
            $updateData['latitude'] = $request->input('latitude');
        }
        if ($request->filled('longitude')) {
            $updateData['longitude'] = $request->input('longitude');
        }
        if ($locationName) {
            $updateData['signature_location_name'] = $locationName;
        }
        $profile->update($updateData);

        return redirect()->route('candidate.dashboard')->with('success', 'Agreement digitally signed successfully.');
    }

    public function download(Request $request)
    {
        try {
            $user = auth()->user();
            $profile = $user->profile;

            if (!$profile || !$profile->is_agreement_signed) {
                return redirect()->route('candidate.dashboard')->with('error', 'Agreement not signed yet.');
            }

            if (!$profile->agreement_pdf_path || !Storage::disk('public')->exists($profile->agreement_pdf_path) || ($request->has('regenerate') && $request->regenerate == '1')) {
                $signatureDataRaw = $profile->signature_data;
                $signatureData = '';
                $type = 'png';

                if (!$signatureDataRaw) {
                    $signatureData = $user->name;
                    $type = 'type';
                } elseif ($profile->signature_type === 'type') {
                    $signatureData = $signatureDataRaw;
                    $type = 'type';
                } elseif (Str::startsWith($signatureDataRaw, 'data:image')) {
                    preg_match('/^data:image\/(\w+);base64,/', $signatureDataRaw, $matches);
                    $type = strtolower($matches[1] ?? 'png');
                    $signatureData = base64_decode(substr($signatureDataRaw, strpos($signatureDataRaw, ',') + 1));
                } elseif ($profile->signature_type === 'upload') {
                    $path = Storage::disk('public')->path($signatureDataRaw);
                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $signatureData = file_get_contents($path);
                    } else {
                        $signatureData = $user->name;
                        $type = 'type';
                    }
                } else {
                    $signatureData = base64_decode($signatureDataRaw);
                    if (!$signatureData) {
                        $signatureData = $user->name;
                        $type = 'type';
                    }
                }

                $fileName = $this->generateStampedPdf($user, $profile, $signatureData, $type);
                $profile->update(['agreement_pdf_path' => $fileName]);
            }

            $fullFilePath = Storage::disk('public')->path($profile->agreement_pdf_path);
            if (!file_exists($fullFilePath)) {
                return redirect()->route('candidate.dashboard')->with('error', 'Agreement PDF file not found on server.');
            }

            return response()->download($fullFilePath, 'Candidate_Agreement_' . str_replace(' ', '_', $user->name ?? 'Candidate') . '.pdf');
        } catch (\Throwable $e) {
            \Log::error("Agreement download failed for User ID " . (auth()->id() ?? 'guest') . ": " . $e->getMessage() . "\nTrace: " . $e->getTraceAsString());
            return redirect()->route('candidate.dashboard')->with('error', 'Could not generate or download agreement PDF: ' . $e->getMessage());
        }
    }

    private function generateStampedPdf($user, $profile, $signatureData, $sigType)
    {
        $signatureSrc = '';
        
        if ($profile->signature_type === 'type') {
            $signatureSrc = $profile->signature_data;
        } else {
            // For DOMPDF, we can just pass base64 image data directly
            if ($signatureData) {
                // If it's not already base64, base64 encode it
                // We know $signatureData is raw bytes here
                $base64 = base64_encode($signatureData);
                $mime = in_array($sigType, ['jpg', 'jpeg']) ? 'jpeg' : 'png';
                $signatureSrc = 'data:image/' . $mime . ';base64,' . $base64;
            }
        }

        $photoSrc = null;
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
            $photoSrc = 'data:' . $mime . ';base64,' . base64_encode($photoData);
        }

        $date = \Carbon\Carbon::now()->format('d F Y');
        
        // Generate PDF using DOMPDF
        $pdf = \PDF::loadView('pdf.candidate-agreement', [
            'user' => $user,
            'profile' => $profile,
            'signature' => $signatureSrc,
            'signature_type' => $profile->signature_type,
            'photo' => $photoSrc,
            'date' => $date
        ]);
        
        $tempPdfPath = 'temp/agreement_' . $user->id . '_' . time() . '.pdf';
        Storage::disk('local')->put($tempPdfPath, $pdf->output());
        
        $absoluteTempPdfPath = Storage::disk('local')->path($tempPdfPath);
        $file = new \Illuminate\Http\File($absoluteTempPdfPath);
        $fileName = Storage::disk('public')->putFileAs('agreements', $file, 'agreement_' . $user->id . '_' . time() . '.pdf');
        
        Storage::disk('local')->delete($tempPdfPath);

        return $fileName;
    }
}
