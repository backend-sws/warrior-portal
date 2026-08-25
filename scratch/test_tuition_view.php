<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

$candidate = User::where('role', 'candidate')->first();
Auth::login($candidate);
View::share('errors', new \Illuminate\Support\ViewErrorBag());

try {
    $ctrl = new \App\Http\Controllers\Candidate\TuitionController();
    $response = $ctrl->index();
    $html = $response->render();
    echo "\n\n✓ SUCCESS! TuitionController::index() EXECUTED AND RENDERED PERFECTLY WITH " . strlen($html) . " BYTES OF HTML.\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}
