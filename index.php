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

// Load page metadata helper
require_once __DIR__ . '/includes/page-meta.php';

// Load blocks system
require_once __DIR__ . '/includes/blocks.php';

// Start output buffering to capture page content
ob_start();

// Load header
include __DIR__ . '/header.php';

// Load main content (this is where set_page_meta() is called)
include __DIR__ . '/body.php';

// Load footer
include __DIR__ . '/footer.php';

// Get the buffered content
$pageContent = ob_get_clean();

// Now render the complete page with head that has access to page metadata
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/head.php'; ?>
<body>
    <?php echo $pageContent; ?>
    
    <!-- Framework Scripts -->
    <script src="/framework-scripts/core.js"></script>
    <script src="/framework-scripts/blocks.js"></script>
    
    <!-- User Scripts -->
    <script src="/user-scripts/main.js"></script>
</body>
</html>
