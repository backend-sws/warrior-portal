<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

View::share('errors', new \Illuminate\Support\ViewErrorBag());

echo "=== TESTING CANDIDATE TUITION AGREEMENT VIEW ===\n";
$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);

try {
    $tCtrl = new \App\Http\Controllers\Candidate\TuitionController();
    $res = $tCtrl->index();
    $html = $res->render();
    echo "✓ Candidate Tuitions View rendered successfully (" . strlen($html) . " bytes)\n";
} catch (\Throwable $e) {
    echo "❌ Error in Candidate Tuitions View: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TESTING ADMIN CRM SHOW VIEW ===\n";
$admin = User::where('role', 'admin')->first() ?: $candidate;
Auth::login($admin);

try {
    $crmCtrl = new \App\Http\Controllers\Admin\CrmController();
    $res2 = $crmCtrl->show($candidate->id);
    $html2 = $res2->render();
    echo "✓ Admin CRM Show View rendered successfully (" . strlen($html2) . " bytes)\n";
} catch (\Throwable $e) {
    echo "❌ Error in Admin CRM Show View: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== ALL VERIFICATION TESTS COMPLETED ===\n";
