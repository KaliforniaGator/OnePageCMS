<?php
/**
 * Page Metadata Helper
 * Functions for setting page metadata for SEO and social sharing
 */

/**
 * Set page metadata
 * 
 * @param array $meta - Metadata array with keys:
 *   - title: Page title (required)
 *   - description: Page description (optional)
 *   - url: Full page URL (optional)
 *   - image: Full URL to page image for social sharing (optional)
 *   - type: Open Graph type (default: 'website', options: 'article', 'product', etc.)
 *   - author: Page author (optional)
 *   - keywords: Comma-separated keywords (optional)
 *   - custom_head: Custom HTML to add to <head> (optional)
 */
function set_page_meta($meta) {
    global $page_meta;
    $page_meta = $meta;
}

/**
 * Get current page metadata
 * 
 * @return array Current page metadata
 */
function get_page_meta() {
    global $page_meta;
    return $page_meta ?? [];
}
?>
