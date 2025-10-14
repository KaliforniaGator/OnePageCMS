<?php
/**
 * Social Buttons Block
 * Creates social media buttons with icons
 * 
 * @param array $links - Array of social links with 'platform' and 'url'
 * @param string $style - Button style: 'icon', 'text', 'both' (default: 'icon')
 * @param string $size - Button size: 'small', 'medium', 'large' (default: 'medium')
 * @param string $shape - Button shape: 'circle', 'rounded-rect', 'rect', 'plain' (default: 'rounded-rect')
 */

function block_social_buttons($links, $style = 'icon', $size = 'medium', $shape = 'rounded-rect') {
    $classes = "block-social social-$style social-$size social-shape-$shape";
    
    $html = "<div class=\"$classes\">";
    
    // Font Awesome brand icons
    $icons = [
        'facebook' => 'fab fa-facebook-f',
        'twitter' => 'fab fa-twitter',
        'x' => 'fab fa-x-twitter',
        'instagram' => 'fab fa-instagram',
        'linkedin' => 'fab fa-linkedin-in',
        'youtube' => 'fab fa-youtube',
        'github' => 'fab fa-github',
        'pinterest' => 'fab fa-pinterest-p',
        'tiktok' => 'fab fa-tiktok',
        'discord' => 'fab fa-discord',
        'reddit' => 'fab fa-reddit-alien',
        'snapchat' => 'fab fa-snapchat-ghost',
        'whatsapp' => 'fab fa-whatsapp',
        'telegram' => 'fab fa-telegram-plane',
        'twitch' => 'fab fa-twitch',
        'spotify' => 'fab fa-spotify',
        'dribbble' => 'fab fa-dribbble',
        'behance' => 'fab fa-behance',
        'medium' => 'fab fa-medium-m',
        'email' => 'fas fa-envelope',
        'website' => 'fas fa-globe',
        'link' => 'fas fa-link'
    ];
    
    foreach ($links as $link) {
        // Use the icon field directly if provided, otherwise fall back to platform mapping
        $platform = strtolower($link['platform'] ?? $link['name'] ?? '');
        $url = $link['url'] ?? '#';
        $iconClass = $link['icon'] ?? ($icons[$platform] ?? 'fas fa-link');
        $label = $link['name'] ?? ucfirst($platform);
        
        $html .= "<a href=\"$url\" class=\"social-link social-$platform\" target=\"_blank\" rel=\"noopener noreferrer\" aria-label=\"$label\">";
        
        if ($style === 'icon' || $style === 'both') {
            $html .= "<i class=\"$iconClass social-icon\"></i>";
        }
        
        if ($style === 'text' || $style === 'both') {
            $html .= "<span class=\"social-text\">$label</span>";
        }
        
        $html .= "</a>";
    }
    
    $html .= "</div>";
    return $html;
}
?>
