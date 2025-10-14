<?php
/**
 * Clear Button Block
 * Creates a reset/clear button for forms
 * 
 * @param string $text - Button text (default: 'Clear')
 * @param string $style - Button style: 'primary', 'secondary', 'danger', 'outline' (default: 'secondary')
 * @param array $styles - Optional styling properties
 */

function block_clearbutton($text = 'Clear', $style = 'secondary', $styles = []) {
    $classes = "btn btn-$style";
    
    $styleAttr = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$styleAttr>";
    $html .= "<button type=\"reset\" class=\"$classes\">$text</button>";
    $html .= "</div>";
    
    return $html;
}
?>
