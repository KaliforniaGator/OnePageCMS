<?php
/**
 * Button Block
 * Creates styled buttons
 * 
 * @param string $text - Button text
 * @param string $url - Button URL (optional)
 * @param string $type - Button type: 'primary', 'secondary', 'success', 'danger', 'outline' (default: 'primary')
 * @param string $size - Button size: 'small', 'medium', 'large' (default: 'medium')
 * @param string $class - Additional CSS classes (optional)
 * @param string $onclick - JavaScript onclick handler (optional)
 */

function block_button($text, $url = '#', $type = 'primary', $size = 'medium', $class = '', $onclick = '') {
    $classes = trim("btn btn-$type btn-$size $class");
    $onclickAttr = $onclick ? " onclick=\"$onclick\"" : '';
    
    if ($url) {
        return "<a href=\"$url\" class=\"$classes\"$onclickAttr>$text</a>";
    } else {
        return "<button class=\"$classes\"$onclickAttr>$text</button>";
    }
}

/**
 * Button Group Block
 * Groups multiple buttons together
 * 
 * @param array $buttons - Array of button configurations
 * @param string $alignment - Alignment: 'left', 'center', 'right' (default: 'left')
 */

function block_button_group($buttons, $alignment = 'left') {
    $alignClass = "btn-group-$alignment";
    $html = "<div class=\"btn-group $alignClass\">";
    
    foreach ($buttons as $btn) {
        $text = $btn['text'] ?? 'Button';
        $url = $btn['url'] ?? '#';
        $type = $btn['type'] ?? 'primary';
        $size = $btn['size'] ?? 'medium';
        $class = $btn['class'] ?? '';
        $onclick = $btn['onclick'] ?? '';
        
        $html .= block_button($text, $url, $type, $size, $class, $onclick);
    }
    
    $html .= "</div>";
    return $html;
}
?>
