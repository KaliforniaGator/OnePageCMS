<?php
/**
 * Image Block
 * Displays an image with optional caption
 * 
 * @param string $src - Image source URL
 * @param string $alt - Alt text
 * @param string $caption - Image caption (optional)
 * @param string $class - Additional CSS classes (optional)
 * @param string $size - Image size: 'small', 'medium', 'large', 'full' (default: 'full')
 */

function block_image($src, $alt = '', $caption = '', $class = '', $size = 'full') {
    $sizeClass = "img-$size";
    $classes = trim("block-image $sizeClass $class");
    
    $html = "<figure class=\"$classes\">";
    $html .= "<img src=\"$src\" alt=\"$alt\" loading=\"lazy\">";
    
    if ($caption) {
        $html .= "<figcaption>$caption</figcaption>";
    }
    
    $html .= "</figure>";
    return $html;
}

/**
 * Video Block
 * Embeds a video (YouTube, Vimeo, or direct video file)
 * 
 * @param string $src - Video source URL or embed code
 * @param string $type - Video type: 'youtube', 'vimeo', 'file' (default: 'youtube')
 * @param string $class - Additional CSS classes (optional)
 * @param array $options - Additional options (width, height, autoplay, etc.)
 */

function block_video($src, $type = 'youtube', $class = '', $options = []) {
    $classes = trim("block-video video-$type $class");
    $width = $options['width'] ?? '100%';
    $height = $options['height'] ?? '400px';
    $autoplay = isset($options['autoplay']) && $options['autoplay'] ? '1' : '0';
    
    $html = "<div class=\"$classes\" style=\"max-width: $width;\">";
    
    switch ($type) {
        case 'youtube':
            // Extract video ID from URL
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/', $src, $matches);
            $videoId = $matches[1] ?? $src;
            $html .= "<iframe width=\"100%\" height=\"$height\" src=\"https://www.youtube.com/embed/$videoId?autoplay=$autoplay\" frameborder=\"0\" allowfullscreen></iframe>";
            break;
        case 'vimeo':
            // Extract video ID from URL
            preg_match('/vimeo\.com\/(\d+)/', $src, $matches);
            $videoId = $matches[1] ?? $src;
            $html .= "<iframe width=\"100%\" height=\"$height\" src=\"https://player.vimeo.com/video/$videoId?autoplay=$autoplay\" frameborder=\"0\" allowfullscreen></iframe>";
            break;
        case 'file':
            $autoplayAttr = $autoplay ? 'autoplay' : '';
            $html .= "<video width=\"100%\" height=\"$height\" controls $autoplayAttr>";
            $html .= "<source src=\"$src\" type=\"video/mp4\">";
            $html .= "Your browser does not support the video tag.";
            $html .= "</video>";
            break;
    }
    
    $html .= "</div>";
    return $html;
}

/**
 * Icon Block
 * Displays an icon using Font Awesome
 * 
 * @param string $icon - Font Awesome icon class (e.g., 'fas fa-home', 'fab fa-github')
 * @param string $size - Icon size: 'small', 'medium', 'large', 'xl', '2xl' (default: 'medium')
 * @param string $class - Additional CSS classes (optional)
 * @param string $color - Icon color (optional)
 */

function block_icon($icon, $size = 'medium', $class = '', $color = '') {
    $sizeClass = "icon-$size";
    $classes = trim("block-icon $sizeClass $class");
    $style = $color ? " style=\"color: $color;\"" : '';
    
    // If icon doesn't start with 'fa', assume it's a shorthand and add 'fas'
    if (strpos($icon, 'fa-') === 0) {
        $icon = "fas $icon";
    }
    
    return "<i class=\"$icon $classes\"$style></i>";
}
?>
