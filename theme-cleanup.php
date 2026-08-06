<?php

$dir = __DIR__ . '/resources/views/employer';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $original = $content;

        // Fix malformed text colors like text-[#031b4e]/70/40
        $content = preg_replace('/text-\[\#031b4e\]\/70\/(\d+)/', 'text-[#031b4e]/$1', $content);
        
        // Fix background of empty state buttons which were white/5 with white text
        $content = str_replace('bg-white/5 hover:bg-white/10 text-white', 'bg-[#0ea5e9] hover:bg-[#0284c7] text-white', $content);
        
        // Fix primary-bg
        $content = str_replace('bg-primary-bg/50', 'bg-[#031b4e]/10', $content);

        if ($original !== $content) {
            file_put_contents($path, $content);
            echo "Cleaned up: $path\n";
        }
    }
}

echo "Done\n";
