<?php
/**
 * Sitewide Banner Configuration
 * Exposes banner settings to JavaScript
 */

// Get addon configuration
$addonLoader = get_addon_loader();
$bannerAddon = $addonLoader->getAddon('sitewide-banner');

if ($bannerAddon) {
    // Default settings
    $bannerSettings = [
        'message' => '🎉 Welcome to our site! Check out our latest updates.',
        'backgroundColor' => '#4f46e5',
        'textColor' => '#ffffff',
        'dismissible' => true
    ];
    
    // Merge with custom settings from entry.json if they exist
    if (isset($bannerAddon['settings'])) {
        $bannerSettings = array_merge($bannerSettings, $bannerAddon['settings']);
    }
    
    // Make settings available to JavaScript
    if (!isset($GLOBALS['addon_data'])) {
        $GLOBALS['addon_data'] = [];
    }
    
    $GLOBALS['addon_data']['sitewide-banner'] = $bannerSettings;
}
