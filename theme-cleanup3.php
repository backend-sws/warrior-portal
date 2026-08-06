<?php

$dir = __DIR__ . '/resources/views/employer/tuitions';
$files = ['index.blade.php', 'create.blade.php'];

foreach ($files as $filename) {
    $path = $dir . '/' . $filename;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        // Remove the outer background class that overrides body
        $content = str_replace('<div class="bg-primary-bg min-h-screen pb-12">', '<div class="min-h-screen pb-12">', $content);
        
        // Fix opacities
        $content = str_replace('bg-primary-bg/20', 'bg-[#031b4e]/5', $content);
        
        // Fix inputs and elements
        $content = str_replace('bg-primary-bg', 'bg-white', $content);

        file_put_contents($path, $content);
        echo "Fixed bg-primary-bg in $filename\n";
    }
}
echo "Done\n";
