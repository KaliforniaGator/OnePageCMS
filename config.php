<?php
/**
 * OnePage CMS Configuration File
 * 
 * This file contains site settings and optional database configuration.
 */

// Site Settings
define('SITE_TITLE', 'OnePage CMS');
define('SITE_DESCRIPTION', 'A lightweight, flexible content management framework');
define('SITE_URL', 'http://localhost:8000');

// Paths
define('BASE_PATH', __DIR__);
define('PAGES_DIR', BASE_PATH . '/pages');

// Debug mode
define('DEBUG', true);

// Error reporting
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Default timezone
date_default_timezone_set('UTC');

// ============================================
// OPTIONAL: Database Configuration
// ============================================
// Uncomment and configure these if you want to use database features
// The CMS works perfectly fine without a database for static sites

// define('DB_HOST', 'localhost');
// define('DB_NAME', 'your_database_name');
// define('DB_USER', 'your_username');
// define('DB_PASS', 'your_password');
// define('DB_PREFIX', 'op_');
