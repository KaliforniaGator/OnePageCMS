<?php
/**
 * Card Block
 * Creates card components
 * 
 * @param array $config - Card configuration
 */

function block_card($config) {
    $title = $config['title'] ?? '';
    $content = $config['content'] ?? '';
    $image = $config['image'] ?? '';
    $footer = $config['footer'] ?? '';
    $icon = $config['icon'] ?? '';
    $icon_shape = $config['icon_shape'] ?? 'none';
    $icon_color = $config['icon_color'] ?? '';
    $spacing = $config['spacing'] ?? '';
    $class = $config['class'] ?? '';
    
    // Build spacing style
    $spacingStyle = $spacing ? " style=\"padding: $spacing;\"" : '';
    
    $html = "<div class=\"block-card $class\"$spacingStyle>";
    
    // Add icon if provided
    if ($icon) {
        $iconShapeClass = $icon_shape !== 'none' ? "icon-shape-$icon_shape" : '';
        $iconColorStyle = $icon_color ? " style=\"color: $icon_color;\"" : '';
        $html .= "<div class=\"card-icon $iconShapeClass\"$iconColorStyle>";
        $html .= "<i class=\"$icon\"></i>";
        $html .= "</div>";
    }
    
    if ($image) {
        $html .= "<div class=\"card-image\"><img src=\"$image\" alt=\"$title\"></div>";
    }
    
    $html .= "<div class=\"card-body\">";
    
    if ($title) {
        $html .= "<h3 class=\"card-title\">$title</h3>";
    }
    
    if ($content) {
        $html .= "<div class=\"card-content\">$content</div>";
    }
    
    $html .= "</div>";
    
    if ($footer) {
        $html .= "<div class=\"card-footer\">$footer</div>";
    }
    
    $html .= "</div>";
    return $html;
}

/**
 * Grid Block
 * Creates a grid layout for cards or content
 */

function block_grid($items, $columns = 3, $gap = '2rem') {
    $html = "<div class=\"block-grid\" style=\"grid-template-columns: repeat($columns, 1fr); gap: $gap;\">";
    
    foreach ($items as $item) {
        $html .= "<div class=\"grid-item\">$item</div>";
    }
    
    $html .= "</div>";
    return $html;
}
?>
