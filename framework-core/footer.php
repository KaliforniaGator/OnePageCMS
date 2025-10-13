<?php
/**
 * Footer Template (Framework Core)
 * 
 * This file loads the footer content from the elements directory.
 * Users should edit /elements/footer.php, not this file.
 */

$footerPath = __DIR__ . '/../elements/footer.php';

if (file_exists($footerPath)) {
    include $footerPath;
} else {
    // Fallback if footer element doesn't exist
    echo '<footer class="site-footer"><div class="container"><p>Footer element not found.</p></div></footer>';
}
?>
