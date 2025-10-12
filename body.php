<main class="site-content">
    <div class="container">
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
        $page = str_replace(['..', '/', '\\'], '', $page);

        // Build the page path
        $pagePath = '';
        if (!empty($page)) {
            // Check if it's a file in the pages directory
            $pagePath = PAGES_DIR . '/' . $page . '.php';
            
            // If not found, check if it's a directory with an index.php
            if (!file_exists($pagePath)) {
                $pagePath = PAGES_DIR . '/' . $page . '/index.php';
            }
        } else {
            // Default to home page
            $pagePath = PAGES_DIR . '/home.php';
        }

        // Load the page if it exists, otherwise show 404
        if (file_exists($pagePath)) {
            include $pagePath;
        } else {
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
