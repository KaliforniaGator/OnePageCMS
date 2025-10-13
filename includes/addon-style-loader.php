<?php
/**
 * Addon Style Loader
 * Loads CSS files from addons based on entry.json configuration and addon controls
 */

function load_addon_styles() {
    $addonsDir = ADDONS_DIR;
    $styles = [];
    
    if (!is_dir($addonsDir)) {
        return $styles;
    }
    
    // Get current page to check for page-specific styles
    $currentPage = isset($_GET['page']) ? $_GET['page'] : (isset($_POST['page']) ? $_POST['page'] : '');
    $currentPage = str_replace(['..', '\\'], '', trim($currentPage, '/'));
    
    $dirs = scandir($addonsDir);
    
    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') {
            continue;
        }
        
        // Check if addon is disabled via controls
        if (is_addon_disabled($dir)) {
            continue;
        }
        
        $addonPath = $addonsDir . '/' . $dir;
        $entryFile = $addonPath . '/entry.json';
        
        if (is_dir($addonPath) && file_exists($entryFile)) {
            $json = file_get_contents($entryFile);
            $config = json_decode($json, true);
            
            if (!$config || !isset($config['enabled']) || !$config['enabled']) {
                continue;
            }
            
            // Check if this addon has styles
            if (isset($config['load']['styles']) && is_array($config['load']['styles'])) {
                foreach ($config['load']['styles'] as $style) {
                    // If addon is in global config, always load
                    if (should_addon_load_globally($dir)) {
                        $styles[] = '/framework-addons/' . $dir . '/' . $style['file'];
                    }
                    // Otherwise, check scope from entry.json
                    else {
                        $scope = isset($style['scope']) ? $style['scope'] : 'global';
                        
                        if ($scope === 'global') {
                            $styles[] = '/framework-addons/' . $dir . '/' . $style['file'];
                        }
                    }
                }
            }
        }
    }
    
    return $styles;
}
