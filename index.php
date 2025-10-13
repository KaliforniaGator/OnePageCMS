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

// Load addon system
require_once __DIR__ . '/includes/addon-loader.php';

// Start output buffering to capture page content
ob_start();

// Load header
include __DIR__ . '/framework-core/header.php';

// Load main content (this is where set_page_meta() is called)
include __DIR__ . '/framework-core/body.php';

// Load footer
include __DIR__ . '/framework-core/footer.php';

// Get the buffered content
$pageContent = ob_get_clean();

// Now render the complete page with head that has access to page metadata
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/framework-core/head.php'; ?>
<body>
    <?php echo $pageContent; ?>
    
    <!-- Addon Routes Data for JavaScript -->
    <script>
        // Set addon routes before core.js loads
        (function() {
            window.OnePageCMS = window.OnePageCMS || {};
            window.OnePageCMS.addonRoutes = <?php echo json_encode(get_addon_routes()); ?>;
        })();
    </script>
    
    <!-- Framework Scripts -->
    <script src="/framework-scripts/core.js"></script>
    <script src="/framework-scripts/blocks.js"></script>
    
    <!-- User Scripts -->
    <script src="/user-scripts/main.js"></script>
    
    <?php
    // Load global addon scripts
    $addonLoader = get_addon_loader();
    $globalScripts = $addonLoader->loadGlobalScripts();
    foreach ($globalScripts as $script) {
        $defer = $script['defer'] ? ' defer' : '';
        $async = $script['async'] ? ' async' : '';
        echo '<script src="' . htmlspecialchars($script['url']) . '"' . $defer . $async . '></script>' . "\n    ";
    }
    ?>
</body>
</html>
