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
    $image = $options['image'] ?? '';
    $text = $options['text'] ?? '';
    $alt = $options['alt'] ?? 'Logo';
    $width = $options['width'] ?? '';
    $height = $options['height'] ?? '';
    $link = $options['link'] ?? '/';
    $class = $options['class'] ?? '';
    
    $classes = trim("block-logo $class");
    
    // Build style attribute for image dimensions
    $imageStyle = '';
    if ($width) $imageStyle .= "width: $width;";
    if ($height) $imageStyle .= "height: $height;";
    
    $html = "<a href=\"$link\" class=\"$classes\">";
    
    if ($image) {
        $styleAttr = $imageStyle ? " style=\"$imageStyle\"" : '';
        $html .= "<img src=\"$image\" alt=\"$alt\" class=\"logo-image\"$styleAttr>";
    }
    
    if ($text) {
        $html .= "<span class=\"logo-text\">$text</span>";
    }
    
    $html .= "</a>";
    
    return $html;
}
?>
