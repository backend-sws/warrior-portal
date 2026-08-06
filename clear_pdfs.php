<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\CandidateProfile::query()->update(['agreement_pdf_path' => null]);
echo "Cleared PDF paths\n";
