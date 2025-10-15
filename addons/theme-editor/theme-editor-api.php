<?php
/**
 * Theme Editor API
 * Handles loading and saving theme.css file
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once __DIR__ . '/../../config.php';

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_log('=== THEME EDITOR API CALLED ===');

// Set JSON header
header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];
error_log('Request method: ' . $method);

// Define theme file paths
define('THEME_FILE', __DIR__ . '/../../styles/theme.css');
define('THEME_DEFAULTS_FILE', __DIR__ . '/theme-defaults.txt');
error_log('Theme file path: ' . THEME_FILE);
error_log('Theme file exists: ' . (file_exists(THEME_FILE) ? 'YES' : 'NO'));
error_log('Theme defaults file path: ' . THEME_DEFAULTS_FILE);
error_log('Theme defaults file exists: ' . (file_exists(THEME_DEFAULTS_FILE) ? 'YES' : 'NO'));

// Handle GET requests (load theme)
if ($method === 'GET') {
    error_log('Handling GET request');
    handleLoadTheme();
}

// Handle POST requests (save theme)
if ($method === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['action'])) {
        sendError('Invalid request');
    }
    
    switch ($data['action']) {
        case 'save':
            handleSaveTheme($data);
            break;
        case 'load':
            handleLoadTheme();
            break;
        case 'reset':
            handleResetTheme();
            break;
        default:
            sendError('Unknown action');
    }
}

/**
 * Load theme.css and parse CSS variables
 */
function handleLoadTheme() {
    error_log('handleLoadTheme called');
    
    if (!file_exists(THEME_FILE)) {
        error_log('ERROR: Theme file not found at: ' . THEME_FILE);
        sendError('Theme file not found at: ' . THEME_FILE);
    }
    
    $content = file_get_contents(THEME_FILE);
    error_log('Theme file content length: ' . strlen($content));
    
    // Parse CSS variables from :root
    $variables = parseCSSVariables($content);
    error_log('Parsed variables count: ' . count($variables));
    error_log('Variables: ' . json_encode($variables));
    
    // Load default values
    $defaults = loadDefaultValues();
    
    sendSuccess([
        'variables' => $variables,
        'defaults' => $defaults,
        'raw' => $content
    ]);
}

/**
 * Save theme.css with updated CSS variables
 */
function handleSaveTheme($data) {
    if (!isset($data['variables'])) {
        sendError('No variables provided');
    }
    
    if (!file_exists(THEME_FILE)) {
        sendError('Theme file not found');
    }
    
    // Read current theme file
    $content = file_get_contents(THEME_FILE);
    
    // Update CSS variables
    $updatedContent = updateCSSVariables($content, $data['variables']);
    
    // Write back to file
    $result = file_put_contents(THEME_FILE, $updatedContent);
    
    if ($result === false) {
        sendError('Failed to write theme file');
    }
    
    sendSuccess([
        'message' => 'Theme saved successfully',
        'bytes' => $result
    ]);
}

/**
 * Parse CSS variables from content
 */
function parseCSSVariables($content) {
    $variables = [];
    
    error_log('parseCSSVariables called');
    
    // Extract :root block - match everything between :root { and the closing }
    if (preg_match('/:root\s*\{(.*?)\n\}/s', $content, $matches)) {
        error_log('Found :root block');
        $rootBlock = $matches[1];
        error_log('Root block length: ' . strlen($rootBlock));
        
        // Extract each variable
        preg_match_all('/--([a-z0-9-]+)\s*:\s*([^;]+);/i', $rootBlock, $varMatches, PREG_SET_ORDER);
        error_log('Found ' . count($varMatches) . ' variables');
        
        foreach ($varMatches as $match) {
            $varName = $match[1];
            $varValue = trim($match[2]);
            
            // Categorize variable
            $category = categorizeVariable($varName);
            
            if (!isset($variables[$category])) {
                $variables[$category] = [];
            }
            
            $variables[$category][$varName] = $varValue;
        }
    } else {
        error_log('ERROR: Could not find :root block in CSS');
    }
    
    return $variables;
}

/**
 * Update CSS variables in content
 */
function updateCSSVariables($content, $variables) {
    // Flatten variables array
    $flatVars = [];
    foreach ($variables as $category => $vars) {
        foreach ($vars as $name => $value) {
            $flatVars[$name] = $value;
        }
    }
    
    // Replace each variable
    foreach ($flatVars as $name => $value) {
        $pattern = '/(--' . preg_quote($name, '/') . '\s*:\s*)[^;]+(;)/';
        $replacement = '${1}' . $value . '${2}';
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    return $content;
}

/**
 * Categorize variable by name
 */
function categorizeVariable($name) {
    if (strpos($name, 'color-primary') === 0) return 'Primary Colors';
    if (strpos($name, 'color-secondary') === 0) return 'Secondary Colors';
    if (strpos($name, 'color-success') === 0) return 'Success Colors';
    if (strpos($name, 'color-danger') === 0) return 'Danger Colors';
    if (strpos($name, 'color-warning') === 0) return 'Warning Colors';
    if (strpos($name, 'color-info') === 0) return 'Info Colors';
    if (strpos($name, 'color-gray') === 0) return 'Neutral Colors';
    if (strpos($name, 'color-white') === 0 || strpos($name, 'color-black') === 0) return 'Neutral Colors';
    if (strpos($name, 'color-text') === 0) return 'Text Colors';
    if (strpos($name, 'button-text') === 0) return 'Text Colors';
    if (strpos($name, 'color-bg') === 0) return 'Background Colors';
    if (strpos($name, 'color-border') === 0) return 'Border Colors';
    if (strpos($name, 'gradient') === 0) return 'Gradients';
    if (strpos($name, 'shadow') === 0) return 'Shadows';
    if (strpos($name, 'radius') === 0) return 'Border Radius';
    if (strpos($name, 'spacing') === 0) return 'Spacing';
    if (strpos($name, 'font-family') === 0) return 'Typography';
    if (strpos($name, 'font-size') === 0) return 'Typography';
    if (strpos($name, 'transition') === 0) return 'Transitions';
    if (strpos($name, 'z-') === 0) return 'Z-Index';
    
    return 'Other';
}

/**
 * Send success response
 */
function sendSuccess($data) {
    error_log('Sending success response');
    $response = [
        'success' => true,
        'data' => $data
    ];
    error_log('Response: ' . json_encode($response));
    echo json_encode($response);
    exit;
}

/**
 * Load default theme values from theme-defaults.txt
 */
function loadDefaultValues() {
    if (!file_exists(THEME_DEFAULTS_FILE)) {
        error_log('WARNING: Theme defaults file not found');
        return [];
    }
    
    $content = file_get_contents(THEME_DEFAULTS_FILE);
    return parseCSSVariables($content);
}

/**
 * Reset theme to default values
 */
function handleResetTheme() {
    error_log('handleResetTheme called');
    
    if (!file_exists(THEME_DEFAULTS_FILE)) {
        sendError('Theme defaults file not found');
    }
    
    // Load default values
    $defaultContent = file_get_contents(THEME_DEFAULTS_FILE);
    $defaults = parseCSSVariables($defaultContent);
    
    if (empty($defaults)) {
        sendError('Failed to parse default values');
    }
    
    // Read current theme file to preserve structure
    $currentContent = file_get_contents(THEME_FILE);
    
    // Update with default values
    $resetContent = updateCSSVariables($currentContent, $defaults);
    
    // Write back to file
    $result = file_put_contents(THEME_FILE, $resetContent);
    
    if ($result === false) {
        sendError('Failed to write theme file');
    }
    
    sendSuccess([
        'message' => 'Theme reset to defaults successfully',
        'variables' => $defaults,
        'bytes' => $result
    ]);
}

/**
 * Send error response
 */
function sendError($message) {
    error_log('Sending error response: ' . $message);
    echo json_encode([
        'success' => false,
        'error' => $message
    ]);
    exit;
}
