<?php
/**
 * OnePage CMS - Main Index File
 * 
 * Universal content display page that loads header, body, and footer
 */

// Start session
session_start();

// Load configuration
require_once __DIR__ . '/config.php';

// Load database class only if database is configured
if (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER') && defined('DB_PASS')) {
    require_once __DIR__ . '/includes/class-db.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>">
    
    <!-- Framework Styles -->
    <link rel="stylesheet" href="/framework-styles/reset.css">
    <link rel="stylesheet" href="/framework-styles/layout.css">
    
    <!-- User Styles -->
    <link rel="stylesheet" href="/user-styles/main.css">
</head>
<body>
    <!-- Header Section -->
    <?php include __DIR__ . '/header.php'; ?>
    
    <!-- Main Content Section -->
    <?php include __DIR__ . '/body.php'; ?>
    
    <!-- Footer Section -->
    <?php include __DIR__ . '/footer.php'; ?>
    
    <!-- Framework Scripts -->
    <script src="/framework-scripts/core.js"></script>
    
    <!-- User Scripts -->
    <script src="/user-scripts/main.js"></script>
</body>
</html>
