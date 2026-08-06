<?php

$dir = __DIR__ . '/resources/views/employer';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $original = $content;

        // Nav Bar specific
        $content = str_replace('bg-card-bg/80', 'bg-white/90', $content);
        
        // Cards
        $content = str_replace('bg-card-bg', 'light-metallic-blue-card bg-[#f4f7f5]/50', $content);
        
        // Borders
        $content = str_replace('border-card-border', 'border-[#031b4e]/10', $content);
        
        // Text
        $content = str_replace('text-text-main', 'text-[#031b4e]', $content);
        $content = preg_replace('/text-text-dark(\/50)?/', 'text-[#031b4e]/70', $content);
        
        // Animations
        $content = str_replace('hover:-translate-y-0.5', 'hover:-translate-y-1 hover:shadow-lg transition-all duration-300', $content);
        $content = str_replace('shadow-glow-yellow', 'shadow-md', $content);
        $content = str_replace('shadow-glow-blue', 'shadow-md', $content);
        $content = str_replace('shadow-glow-red', 'shadow-md', $content);
        
        if ($original !== $content) {
            file_put_contents($path, $content);
            echo "Updated: $path\n";
        }
    }
}

echo "Done\n";
