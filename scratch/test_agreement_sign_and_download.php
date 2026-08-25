<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

echo "=== TESTING AGREEMENT SIGNING & DOWNLOAD FLOW ===\n";
$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);

// 1. Test Agreement Sign
$dummySig = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
$dummyPhoto = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

$request = Request::create('/candidate/agreement/sign', 'POST', [
    'signature' => $dummySig,
    'live_photo' => $dummyPhoto,
    'latitude' => 25.5941,
    'longitude' => 85.1376,
    'location_name' => 'Patna, Bihar, India',
    'terms_accepted' => 1
]);

try {
    $agCtrl = new \App\Http\Controllers\Candidate\AgreementController();
    $response = $agCtrl->sign($request);
    echo "✓ Agreement signed successfully (Redirected to: " . $response->getTargetUrl() . ")\n";
} catch (\Throwable $e) {
    echo "❌ Sign Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

// 2. Test Agreement Download & Regenerate
$downloadRequest = Request::create('/candidate/agreement/download?regenerate=1', 'GET', [
    'regenerate' => 1
]);

try {
    $agCtrl = new \App\Http\Controllers\Candidate\AgreementController();
    $downloadRes = $agCtrl->download($downloadRequest);
    echo "✓ Agreement Download/Regenerate succeeded! Status Code: " . $downloadRes->getStatusCode() . "\n";
} catch (\Throwable $e) {
    echo "❌ Download Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== ALL SIGN & DOWNLOAD TESTS COMPLETED ===\n";
