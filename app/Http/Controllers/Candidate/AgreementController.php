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

        // Redirect if profile is incomplete
        if (!$profile->is_profile_complete) {
            return redirect()->route('candidate.profile.edit')->with('error', 'Please complete your profile first before signing the agreement.');
        }

        // If not signed, redirect to the wizard to ensure the live photo process is followed
        if (!$profile->is_agreement_signed) {
            return redirect()->route('candidate.wizard')->with('info', 'Please sign the agreement here.');
        }

        // If already signed, we will just show the signed state in the view.
        return view('candidate.agreement.show', compact('user', 'profile'));
    }

    public function sign(Request $request)
    {
        $request->validate([
            'signature' => 'required|string', // Base64 image
            'terms_accepted' => 'required|accepted'
        ]);

        $user = auth()->user();
        $profile = $user->profile;

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

        $fileName = $this->generateStampedPdf($user, $profile, $signatureData, $type);

        // Update profile
        $profile->update([
            'is_agreement_signed' => true,
            'agreement_pdf_path' => $fileName
        ]);

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
                if (!$signatureDataRaw) {
                    return redirect()->route('candidate.dashboard')->with('error', 'Signature data is missing. Please sign the agreement again.');
                }

                $signatureData = '';
                $type = 'png';
                if ($profile->signature_type === 'type') {
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
                    }
                } else {
                    $signatureData = base64_decode($signatureDataRaw);
                }

                if (!$signatureData) {
                    return redirect()->route('candidate.dashboard')->with('error', 'Signature data invalid.');
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
