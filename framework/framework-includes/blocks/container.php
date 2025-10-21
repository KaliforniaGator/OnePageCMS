<?php
/**
 * Container Block
 * A flexible container for wrapping content
 * 
 * @param string $content - Content to display inside container
 * @param string $class - Additional CSS classes (optional)
 * @param string $style - Inline styles (optional)
 * @param string $width - Container width: 'full', 'wide', 'narrow' (default: 'wide')
 * 
 * Note: New properties (display_type, horizontal_align, flow_direction, background, 
 * border, corner_radius, shadow) are handled via inline styles passed in $style parameter
 */

function block_container($content, $class = '', $style = '', $width = 'wide') {
    $widthClass = '';
    switch($width) {
        case 'full':
            $widthClass = 'container-full';
            break;
        case 'narrow':
            $widthClass = 'container-narrow';
            break;
        case 'wide':
        default:
            $widthClass = 'container';
            break;
    }
    
    $classes = trim("block-container $widthClass $class");
    $styleAttr = $style ? " style=\"$style\"" : '';
    
    return "<div class=\"$classes\"$styleAttr>$content</div>";
}
?>
