<?php
/**
 * Logo Block
 * Creates a logo with image and/or text
 * 
 * @param array $options - Logo options
 *   - image: Path to logo image (optional)
 *   - text: Logo text (optional)
 *   - alt: Alt text for image (default: 'Logo')
 *   - width: Image width (optional, e.g., '200px', '10rem')
 *   - height: Image height (optional, e.g., '50px', '3rem')
 *   - link: URL to link to (default: '/')
 *   - class: Additional CSS classes
 */

function block_logo($options = []) {
    // Support both old and new parameter names for backwards compatibility
    $image = $options['image'] ?? $options['image_url'] ?? '';
    $text = $options['text'] ?? '';
    $alt = $options['alt'] ?? ($text ? $text : 'Logo');
    $width = $options['width'] ?? $options['image_width'] ?? '';
    $height = $options['height'] ?? $options['image_height'] ?? '';
    $link = $options['link'] ?? '/';
    $class = $options['class'] ?? '';
    
    $classes = trim("block-logo $class");
    
    // Build style attribute for image dimensions
    $imageStyle = '';
    if (!empty($width)) {
        $imageStyle .= "width: $width; ";
    }
    if (!empty($height)) {
        $imageStyle .= "height: $height; ";
    }
    
    // Add text styling if provided
    $textStyle = '';
    if (!empty($options['text_font'])) $textStyle .= "font-family: {$options['text_font']}; ";
    if (!empty($options['text_size'])) $textStyle .= "font-size: {$options['text_size']}; ";
    if (!empty($options['text_color'])) $textStyle .= "color: {$options['text_color']}; ";
    
    $html = "<a href=\"$link\" class=\"$classes\">";
    
    if ($image) {
        $styleAttr = !empty($imageStyle) ? " style=\"" . trim($imageStyle) . "\"" : '';
        $html .= "<img src=\"$image\" alt=\"" . htmlspecialchars($alt) . "\" class=\"logo-image\"$styleAttr>";
    }
    
    if ($text) {
        $textStyleAttr = !empty($textStyle) ? " style=\"" . trim($textStyle) . "\"" : '';
        $html .= "<span class=\"logo-text\"$textStyleAttr>" . htmlspecialchars($text) . "</span>";
    }
    
    $html .= "</a>";
    
    return $html;
}
?>
