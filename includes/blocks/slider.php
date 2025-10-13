<?php
/**
 * Slider Block
 * Creates an image or content slider/carousel
 * 
 * @param array $slides - Array of slide configurations
 * @param string $type - Slider type: 'image' or 'content' (default: 'image')
 * @param array $options - Slider options
 *   - autoplay: Enable autoplay (default: false)
 *   - interval: Autoplay interval in ms (default: 5000)
 *   - transition: Transition effect: 'fade', 'slide', 'zoom', 'flip' (default: 'fade')
 *   - show_arrows: Show navigation arrows (default: true)
 *   - show_dots: Show dot navigation (default: true)
 *   - show_captions: Show image captions (default: true)
 *   - class: Additional CSS classes
 */

function block_slider($slides, $type = 'image', $options = []) {
    $id = 'slider-' . uniqid();
    $autoplay = isset($options['autoplay']) && $options['autoplay'] ? 'true' : 'false';
    $interval = $options['interval'] ?? 5000;
    $transition = $options['transition'] ?? 'fade';
    $showArrows = $options['show_arrows'] ?? true;
    $showDots = $options['show_dots'] ?? true;
    $showCaptions = $options['show_captions'] ?? true;
    $class = $options['class'] ?? '';
    
    $classes = trim("block-slider slider-$type slider-transition-$transition $class");
    
    $html = "<div class=\"$classes\" id=\"$id\" data-autoplay=\"$autoplay\" data-interval=\"$interval\" data-transition=\"$transition\">";
    $html .= "<div class=\"slider-wrapper\">";
    
    foreach ($slides as $index => $slide) {
        $activeClass = $index === 0 ? 'active' : '';
        $html .= "<div class=\"slide $activeClass\">";
        
        if ($type === 'image') {
            $src = $slide['src'] ?? '';
            $alt = $slide['alt'] ?? '';
            $caption = $slide['caption'] ?? '';
            
            $html .= "<img src=\"$src\" alt=\"$alt\">";
            if ($caption && $showCaptions) {
                $html .= "<div class=\"slide-caption\">$caption</div>";
            }
        } else {
            $content = $slide['content'] ?? '';
            $html .= "<div class=\"slide-content\">$content</div>";
        }
        
        $html .= "</div>";
    }
    
    $html .= "</div>";
    
    // Navigation controls
    if ($showArrows) {
        $html .= "<button class=\"slider-prev\" onclick=\"sliderPrev('$id')\">‹</button>";
        $html .= "<button class=\"slider-next\" onclick=\"sliderNext('$id')\">›</button>";
    }
    
    // Dots navigation
    if ($showDots) {
        $html .= "<div class=\"slider-dots\">";
        foreach ($slides as $index => $slide) {
            $activeClass = $index === 0 ? 'active' : '';
            $html .= "<span class=\"dot $activeClass\" onclick=\"sliderGoTo('$id', $index)\"></span>";
        }
        $html .= "</div>";
    }
    
    $html .= "</div>";
    
    return $html;
}
?>
