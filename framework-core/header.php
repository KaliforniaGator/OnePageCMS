<?php
/**
 * Header Template (Framework Core)
 * 
 * This file loads the header content from the elements directory.
 * Users should edit /elements/header.php, not this file.
 */

$headerPath = __DIR__ . '/../elements/header.php';

if (file_exists($headerPath)) {
    include $headerPath;
} else {
    // Fallback if header element doesn't exist
    echo '<header class="site-header"><div class="container"><p>Header element not found.</p></div></header>';
}
?>
