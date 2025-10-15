<?php
/**
 * Addon Manager API
 * Handles loading, enabling/disabling, and updating addon settings
 */

// Start output buffering to catch any accidental output
ob_start();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration if it exists
if (file_exists(__DIR__ . '/../../config.php')) {
    require_once __DIR__ . '/../../config.php';
}

// Enable error logging but disable display
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_log('=== ADDON MANAGER API CALLED ===');

// Set JSON header
header('Content-Type: application/json');

// Catch any errors and return as JSON
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("PHP Error: $errstr in $errfile on line $errline");
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $errstr
    ]);
    exit;
});

// Get request method
$method = $_SERVER['REQUEST_METHOD'];
error_log('Request method: ' . $method);

// Clear any buffered output before sending JSON
ob_clean();

// Handle GET requests (load addons)
if ($method === 'GET') {
    error_log('Handling GET request');
    handleLoadAddons();
}

// Handle POST requests (update addon)
if ($method === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['action'])) {
        sendError('Invalid request');
    }
    
    switch ($data['action']) {
        case 'toggle':
            handleToggleAddon($data);
            break;
        case 'update_settings':
            handleUpdateSettings($data);
            break;
        default:
            sendError('Unknown action');
    }
}

/**
 * Load all addons (including disabled ones)
 */
function handleLoadAddons() {
    error_log('handleLoadAddons called');
    
    if (!is_dir(ADDONS_DIR)) {
        sendError('Addons directory not found');
    }
    
    $addons = [];
    $dirs = scandir(ADDONS_DIR);
    
    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') {
            continue;
        }
        
        $addonPath = ADDONS_DIR . '/' . $dir;
        $entryFile = $addonPath . '/entry.json';
        
        if (is_dir($addonPath) && file_exists($entryFile)) {
            $json = file_get_contents($entryFile);
            $config = json_decode($json, true);
            
            if ($config) {
                $config['id'] = $dir;
                $config['path'] = $addonPath;
                
                // Ensure enabled property exists
                if (!isset($config['enabled'])) {
                    $config['enabled'] = true;
                }
                
                $addons[] = $config;
            }
        }
    }
    
    // Sort by name
    usort($addons, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    
    error_log('Loaded ' . count($addons) . ' addons');
    
    sendSuccess([
        'addons' => $addons
    ]);
}

/**
 * Toggle addon enabled/disabled state
 */
function handleToggleAddon($data) {
    if (!isset($data['addon_id']) || !isset($data['enabled'])) {
        sendError('Missing addon_id or enabled parameter');
    }
    
    $addonId = $data['addon_id'];
    $enabled = (bool) $data['enabled'];
    
    $entryFile = ADDONS_DIR . '/' . $addonId . '/entry.json';
    
    if (!file_exists($entryFile)) {
        sendError('Addon not found');
    }
    
    // Read current config
    $json = file_get_contents($entryFile);
    $config = json_decode($json, true);
    
    if (!$config) {
        sendError('Failed to parse addon configuration');
    }
    
    // Update enabled state
    $config['enabled'] = $enabled;
    
    // Write back to file with pretty formatting
    $updatedJson = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $result = file_put_contents($entryFile, $updatedJson . "\n");
    
    if ($result === false) {
        sendError('Failed to update addon configuration');
    }
    
    sendSuccess([
        'message' => 'Addon ' . ($enabled ? 'enabled' : 'disabled') . ' successfully',
        'addon_id' => $addonId,
        'enabled' => $enabled
    ]);
}

/**
 * Update addon settings
 */
function handleUpdateSettings($data) {
    if (!isset($data['addon_id']) || !isset($data['settings'])) {
        sendError('Missing addon_id or settings parameter');
    }
    
    $addonId = $data['addon_id'];
    $settings = $data['settings'];
    
    $entryFile = ADDONS_DIR . '/' . $addonId . '/entry.json';
    
    if (!file_exists($entryFile)) {
        sendError('Addon not found');
    }
    
    // Read current config
    $json = file_get_contents($entryFile);
    $config = json_decode($json, true);
    
    if (!$config) {
        sendError('Failed to parse addon configuration');
    }
    
    // Update settings
    $config['settings'] = $settings;
    
    // Write back to file with pretty formatting
    $updatedJson = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $result = file_put_contents($entryFile, $updatedJson . "\n");
    
    if ($result === false) {
        sendError('Failed to update addon settings');
    }
    
    sendSuccess([
        'message' => 'Settings updated successfully',
        'addon_id' => $addonId,
        'settings' => $settings
    ]);
}

/**
 * Send success response
 */
function sendSuccess($data) {
    error_log('Sending success response');
    
    // Clear any output buffer
    if (ob_get_length()) ob_clean();
    
    $response = [
        'success' => true,
        'data' => $data
    ];
    error_log('Response: ' . json_encode($response));
    echo json_encode($response);
    exit;
}

/**
 * Send error response
 */
function sendError($message) {
    error_log('Sending error response: ' . $message);
    
    // Clear any output buffer
    if (ob_get_length()) ob_clean();
    
    echo json_encode([
        'success' => false,
        'error' => $message
    ]);
    exit;
}
