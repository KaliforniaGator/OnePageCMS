<?php
$layoutClass = defined('PAGE_LAYOUT') ? PAGE_LAYOUT : 'boxed';
$paddingClass = defined('PAGE_PADDING') && PAGE_PADDING === false ? 'no-padding' : '';

// Add transition class based on config
$transitionClass = '';
if (defined('PAGE_TRANSITIONS') && PAGE_TRANSITIONS === true) {
    $transitionType = defined('PAGE_TRANSITION_TYPE') ? PAGE_TRANSITION_TYPE : 'fade';
    $transitionClass = 'page-transition-' . $transitionType;
}

$siteContentClass = trim("site-content $paddingClass");
$containerClass = trim("container layout-$layoutClass $paddingClass $transitionClass");
?>
<main class="<?php echo $siteContentClass; ?>">
    <div class="<?php echo $containerClass; ?>" id="page-container">
        <?php
        /**
         * Body Template
         * 
         * This template loads pages from the pages directory based on POST or GET parameters
         */

        // Get the page to load from POST or GET
        $page = '';
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } elseif (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        // Sanitize the page parameter to prevent directory traversal
        // Remove .. and backslashes, but allow forward slashes for subdirectories
        $page = str_replace(['..', '\\'], '', $page);
        // Remove any leading/trailing slashes
        $page = trim($page, '/');

        // Build the page path
        $pagePath = '';
        if (!empty($page)) {
            // First check if it's a directory with an index.php
            $dirIndexPath = PAGES_DIR . '/' . $page . '/index.php';
            if (file_exists($dirIndexPath)) {
                $pagePath = $dirIndexPath;
            } else {
                // Otherwise check if it's a direct .php file
                $pagePath = PAGES_DIR . '/' . $page . '.php';
            }
        } else {
            // Default to home page
            $pagePath = PAGES_DIR . '/home.php';
        }

        // Load the page if it exists, otherwise show 404
        if (file_exists($pagePath)) {
            include $pagePath;
        } else {
            // Set 404 metadata
            set_page_meta([
                'title' => '404 - Page Not Found',
                'description' => 'The page you are looking for does not exist.'
            ]);
            
            // 404 Page Not Found
            ?>
            <article class="page-content error-404">
                <h1>404 - Page Not Found</h1>
                <p>The page you are looking for does not exist.</p>
                <p>Requested page: <code><?php echo htmlspecialchars($page ?: 'home'); ?></code></p>
                <p><a href="/">Return to Home</a></p>
            </article>
            <?php
        }
        ?>
    </div>
</main>
