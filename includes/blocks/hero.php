<?php
/**
 * Hero Block
 * Creates modern hero sections with various styles
 * 
 * @param array $config - Hero configuration
 *   - title: Hero title
 *   - subtitle: Hero subtitle (optional)
 *   - background: Background image URL or gradient (optional)
 *   - type: Hero type: 'default', 'fullwidth', 'fullscreen', 'gradient', 'split', 'minimal' (default: 'default')
 *   - overlay: Overlay opacity 0-1 (optional, default: 0.5)
 *   - content: Additional content (optional)
 *   - buttons: Array of button configurations (optional)
 *   - height: Hero height (default: '600px', ignored for fullscreen)
 *   - alignment: Content alignment: 'left', 'center', 'right' (default: 'center')
 *   - gradient: Gradient preset: 'primary', 'sunset', 'ocean', 'forest', 'fire' (optional)
 *   - image: Image for split hero type (optional)
 */

function block_hero($config) {
    $title = $config['title'] ?? '';
    $subtitle = $config['subtitle'] ?? '';
    $background = $config['background'] ?? '';
    $type = $config['type'] ?? 'default';
    $overlay = $config['overlay'] ?? 0.5;
    $content = $config['content'] ?? '';
    $buttons = $config['buttons'] ?? [];
    $height = $config['height'] ?? '600px';
    $alignment = $config['alignment'] ?? 'center';
    $gradient = $config['gradient'] ?? '';
    $image = $config['image'] ?? '';
    $class = $config['class'] ?? '';
    
    $classes = trim("block-hero hero-type-$type hero-align-$alignment $class");
    $style = '';
    
    // Handle different hero types
    switch ($type) {
        case 'fullscreen':
            $style = "min-height: 100vh;";
            break;
        case 'fullwidth':
            $classes .= " hero-fullwidth";
            $style = "min-height: $height;";
            break;
        case 'gradient':
            $style = "min-height: $height;";
            $gradients = [
                'primary' => 'var(--gradient-primary)',
                'sunset' => 'var(--gradient-sunset)',
                'ocean' => 'var(--gradient-ocean)',
                'forest' => 'var(--gradient-forest)',
                'fire' => 'var(--gradient-fire)'
            ];
            $selectedGradient = $gradients[$gradient] ?? $gradients['primary'];
            $style .= " background: $selectedGradient;";
            break;
        case 'split':
            $classes .= " hero-split";
            $style = "min-height: $height;";
            break;
        case 'minimal':
            $classes .= " hero-minimal";
            $style = "min-height: $height;";
            break;
        default:
            $style = "min-height: $height;";
            if ($background) {
                $style .= " background-image: url('$background');";
            }
            break;
    }
    
    $html = "<section class=\"$classes\" style=\"$style\">";
    
    // Add overlay for image backgrounds
    if ($background && $type !== 'gradient' && $type !== 'split' && $overlay > 0) {
        $html .= "<div class=\"hero-overlay\" style=\"opacity: $overlay;\"></div>";
    }
    
    // Split hero layout
    if ($type === 'split') {
        $html .= "<div class=\"hero-split-container\">";
        $html .= "<div class=\"hero-split-content\">";
    } else {
        $html .= "<div class=\"hero-content-wrapper\">";
        $html .= "<div class=\"hero-content\">";
    }
    
    if ($title) {
        $html .= "<h1 class=\"hero-title\" data-aos=\"fade-up\">$title</h1>";
    }
    
    if ($subtitle) {
        $html .= "<p class=\"hero-subtitle\" data-aos=\"fade-up\" data-aos-delay=\"100\">$subtitle</p>";
    }
    
    if ($content) {
        $html .= "<div class=\"hero-text\" data-aos=\"fade-up\" data-aos-delay=\"200\">$content</div>";
    }
    
    if (!empty($buttons)) {
        $html .= "<div class=\"hero-buttons\" data-aos=\"fade-up\" data-aos-delay=\"300\">";
        foreach ($buttons as $btn) {
            $text = $btn['text'] ?? 'Button';
            $url = $btn['url'] ?? '#';
            $btnType = $btn['type'] ?? 'primary';
            $html .= block_button($text, $url, $btnType, 'large');
        }
        $html .= "</div>";
    }
    
    $html .= "</div>";
    
    // Add image for split hero
    if ($type === 'split' && $image) {
        $html .= "<div class=\"hero-split-image\" style=\"background-image: url('$image');\"></div>";
    }
    
    $html .= "</div>";
    $html .= "</section>";
    
    return $html;
}

/**
 * Call to Action Block
 * Creates a call-to-action section
 * 
 * @param string $title - CTA title
 * @param string $description - CTA description
 * @param array $button - Button configuration
 * @param string $style - CTA style: 'default', 'boxed', 'gradient' (default: 'default')
 */

function block_cta($title, $description = '', $button = [], $style = 'default') {
    $classes = "block-cta cta-$style";
    
    $html = "<section class=\"$classes\">";
    $html .= "<div class=\"cta-content\">";
    
    if ($title) {
        $html .= "<h2 class=\"cta-title\">$title</h2>";
    }
    
    if ($description) {
        $html .= "<p class=\"cta-description\">$description</p>";
    }
    
    if (!empty($button)) {
        $text = $button['text'] ?? 'Get Started';
        $url = $button['url'] ?? '#';
        $type = $button['type'] ?? 'primary';
        $html .= "<div class=\"cta-button\">";
        $html .= block_button($text, $url, $type, 'large');
        $html .= "</div>";
    }
    
    $html .= "</div>";
    $html .= "</section>";
    
    return $html;
}
?>
