<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

View::share('errors', new \Illuminate\Support\ViewErrorBag());

echo "=== TESTING CANDIDATE DASHBOARD VIEW (With Profile) ===\n";
$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);

try {
    $profile = $candidate->profile;
    $html = View::make('candidate.dashboard', compact('profile'))->render();
    echo "✓ Candidate Dashboard with Profile rendered (" . strlen($html) . " bytes)\n";
} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TESTING CANDIDATE DASHBOARD VIEW (With NULL Profile) ===\n";
try {
    $profile = null;
    $html = View::make('candidate.dashboard', compact('profile'))->render();
    echo "✓ Candidate Dashboard with NULL Profile rendered (" . strlen($html) . " bytes)\n";
} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== ALL TESTS PASSED ===\n";
