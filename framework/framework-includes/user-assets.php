<?php
/**
 * User Assets Loader
 * Dynamically loads user styles and scripts from /styles and /scripts directories
 */

/**
 * Get all CSS files from the /styles directory
 * 
 * @return array Array of CSS file paths relative to site root
 */
function get_user_styles() {
    $stylesDir = __DIR__ . '/../../styles';
    $styles = [];
    
    if (!is_dir($stylesDir)) {
        return $styles;
    }
    
    $files = scandir($stylesDir);
    
    foreach ($files as $file) {
        // Skip directories and hidden files
        if ($file === '.' || $file === '..' || $file[0] === '.') {
            continue;
        }
        
        $filePath = $stylesDir . '/' . $file;
        
        // Only include CSS files
        if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'css') {
            $styles[] = '/styles/' . $file;
        }
    }
    
    // Sort alphabetically for consistent loading order
    sort($styles);
    
    return $styles;
}

/**
 * Get all JavaScript files from the /scripts directory
 * 
 * @return array Array of JS file paths relative to site root
 */
function get_user_scripts() {
    $scriptsDir = __DIR__ . '/../../scripts';
    $scripts = [];
    
    if (!is_dir($scriptsDir)) {
        return $scripts;
    }
    
    $files = scandir($scriptsDir);
    
    foreach ($files as $file) {
        // Skip directories and hidden files
        if ($file === '.' || $file === '..' || $file[0] === '.') {
            continue;
        }
        
        $filePath = $scriptsDir . '/' . $file;
        
        // Only include JavaScript files
        if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'js') {
            $scripts[] = '/scripts/' . $file;
        }
    }
    
    // Sort alphabetically for consistent loading order
    sort($scripts);
    
    return $scripts;
}
