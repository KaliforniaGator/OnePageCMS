<?php
/**
 * Blocks Loader
 * Automatically loads all block functions
 */

// Load all block files
$blockFiles = [
    'container.php',
    'button.php',
    'list.php',
    'form.php',
    'media.php',
    'slider.php',
    'textview.php',
    'menu.php',
    'hero.php',
    'social.php',
    'card.php',
    'accordion.php',
    'logo.php',
    'markdown.php'
];

foreach ($blockFiles as $file) {
    $filePath = __DIR__ . '/blocks/' . $file;
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}
?>
