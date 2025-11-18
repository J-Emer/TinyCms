<?php

$rootDir = __DIR__; // or change to any directory you want
$outputFile = __DIR__ . '/directory_structure.txt';

// Directories to ignore
$ignoreDirs = ['vendor', '.git', 'node_modules'];

/**
 * Recursively scan directories and return a tree structure.
 *
 * @param string $dir
 * @param array $ignoreDirs
 * @param string $prefix
 * @param bool $isLast
 * @return string
 */
function scanDirTree(string $dir, array $ignoreDirs = [], string $prefix = '', bool $isLast = true): string
{
    $output = '';
    $items = array_values(array_diff(scandir($dir), ['.', '..']));

    // Remove ignored directories
    $items = array_filter($items, function ($item) use ($dir, $ignoreDirs) {
        return !(is_dir($dir . DIRECTORY_SEPARATOR . $item) && in_array($item, $ignoreDirs));
    });

    $count = count($items);
    foreach ($items as $i => $item) {
        $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
        $isLastItem = ($i === $count - 1);

        $branch = $isLastItem ? '└─ ' : '├─ ';
        $output .= $prefix . $branch . $item . PHP_EOL;

        if (is_dir($fullPath)) {
            $newPrefix = $prefix . ($isLastItem ? '    ' : '│   ');
            $output .= scanDirTree($fullPath, $ignoreDirs, $newPrefix, $isLastItem);
        }
    }

    return $output;
}

// Generate tree
$tree = scanDirTree($rootDir, $ignoreDirs);

// Save to file
file_put_contents($outputFile, $tree);

echo "Directory tree saved to $outputFile\n";
