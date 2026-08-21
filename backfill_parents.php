<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\App\Models\HomeTuitionLead::whereNull('user_id')->get() as $lead) {
    if (empty($lead->parent_mobile)) continue;
    $user = \App\Models\User::where('phone', $lead->parent_mobile)->first();
    if (!$user) {
        $user = \App\Models\User::create([
            'name' => $lead->parent_name,
            'phone' => $lead->parent_mobile,
            'email' => $lead->parent_mobile . '@warriorseducare.com',
            'password' => bcrypt('12345678'),
            'role' => 'parent',
            'is_active' => true
        ]);
    }
    $lead->update(['user_id' => $user->id]);
    echo "Updated lead {$lead->id} with user {$user->id}\n";
}
echo "Done.\n";
