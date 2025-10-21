<?php
/**
 * Anchor Block
 * Creates an invisible anchor point for page navigation
 * 
 * @param array $config - Anchor configuration
 *   - id: Anchor ID (required)
 *   - class: Additional CSS classes (optional)
 */

function block_anchor($config) {
    $id = $config['id'] ?? '';
    $class = $config['class'] ?? '';
    
    if (empty($id)) {
        return '<!-- Anchor: Missing ID -->';
    }
    
    $classes = trim("block-anchor $class");
    
    // Create an invisible anchor point
    return "<div id=\"$id\" class=\"$classes\"></div>";
}
?>
