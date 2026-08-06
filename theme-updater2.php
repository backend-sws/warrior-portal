<?php

$dir = __DIR__ . '/resources/views/employer';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $original = $content;

        // Replace bg-secondary-bg variants
        $content = str_replace('bg-secondary-bg/20', 'bg-[#031b4e]/5', $content);
        $content = str_replace('bg-secondary-bg/50', 'bg-[#031b4e]/10', $content);
        $content = str_replace('bg-secondary-bg', 'bg-white', $content);
        
        // Also fix text colors inside inputs that might have been text-text-main but are now dark
        // But we already replaced text-text-main with text-[#031b4e] in the previous run.
        
        if ($original !== $content) {
            file_put_contents($path, $content);
            echo "Updated: $path\n";
        }
    }
}

echo "Done\n";
