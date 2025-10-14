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
    require_once __DIR__ . '/framework/framework-includes/class-db.php';
}

// Load page metadata helper
require_once __DIR__ . '/framework/framework-includes/page-meta.php';

// Load blocks system
require_once __DIR__ . '/framework/framework-includes/blocks.php';

// Load addon system
require_once __DIR__ . '/framework/framework-includes/addon-loader.php';

// Load global addon configs (functions, hooks, etc.) - works for all addons
$GLOBALS['addonLoader']->loadGlobalConfigs();

// Start output buffering to capture page content
ob_start();

// Load header
include __DIR__ . '/framework/framework-core/header.php';

// Load main content (this is where set_page_meta() is called)
include __DIR__ . '/framework/framework-core/body.php';

// Load footer
include __DIR__ . '/framework/framework-core/footer.php';

// Get the buffered content
$pageContent = ob_get_clean();

// Now render the complete page with head that has access to page metadata
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/framework/framework-core/head.php'; ?>
<body>
    <?php echo $pageContent; ?>
    
    <!-- Addon Data for JavaScript -->
    <script>
        // Set addon data before scripts load - works for all addons
        (function() {
            window.OnePageCMS = window.OnePageCMS || {};
            window.OnePageCMS.addonRoutes = <?php echo json_encode(get_addon_routes()); ?>;
            window.OnePageCMS.addonData = <?php echo json_encode(isset($GLOBALS['addon_data']) ? $GLOBALS['addon_data'] : []); ?>;
        })();
    </script>
    
    <!-- Framework Scripts -->
    <script src="/framework/framework-scripts/core.js"></script>
    <script src="/framework/framework-scripts/blocks.js"></script>
    
    <!-- User Scripts -->
    <script src="/scripts/main.js"></script>
    
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
