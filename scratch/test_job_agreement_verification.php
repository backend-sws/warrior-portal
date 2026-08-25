<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

View::share('errors', new \Illuminate\Support\ViewErrorBag());

echo "=== TESTING SCHOOL JOB CANDIDATE AGREEMENT VIEW ===\n";
$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);

try {
    $agCtrl = new \App\Http\Controllers\Candidate\AgreementController();
    $res = $agCtrl->show();
    $html = $res->render();
    echo "✓ School Job Agreement View rendered successfully (" . strlen($html) . " bytes)\n";
} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TESTING PDF TEMPLATE VIEW ===\n";
try {
    $profile = $candidate->profile;
    $htmlPdf = View::make('pdf.candidate-agreement', [
        'user' => $candidate,
        'profile' => $profile,
        'signature' => '',
        'signature_type' => 'draw',
        'photo' => '',
        'date' => date('d F Y')
    ])->render();
    echo "✓ PDF Template rendered successfully (" . strlen($htmlPdf) . " bytes)\n";
} catch (\Throwable $e) {
    echo "❌ Error in PDF View: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== ALL VERIFICATION TESTS COMPLETED ===\n";
