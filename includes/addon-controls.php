<?php
/**
 * Addon Controls
 * Determines which addons should load globally vs on-demand
 */

/**
 * Get addon loading configuration
 * Returns array of addon IDs and their loading strategy
 */
function get_addon_loading_config() {
    return [
        // Addons that should load globally (styles/scripts on every page)
        'global' => [
            'page-builder'
        ],
        
        // Disabled addons (won't load at all)
        'disabled' => [
            // Example: 'old-feature', 'deprecated-addon'
        ]
    ];
}

/**
 * Check if an addon should load globally
 */
function should_addon_load_globally($addonId) {
    $config = get_addon_loading_config();
    return in_array($addonId, $config['global']);
}

/**
 * Check if an addon is disabled
 */
function is_addon_disabled($addonId) {
    $config = get_addon_loading_config();
    return in_array($addonId, $config['disabled']);
}
