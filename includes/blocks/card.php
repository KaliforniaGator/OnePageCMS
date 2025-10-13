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
    $class = $config['class'] ?? '';
    
    $html = "<div class=\"block-card $class\">";
    
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
