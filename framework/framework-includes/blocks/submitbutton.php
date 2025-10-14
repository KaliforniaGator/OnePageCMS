<?php
/**
 * Submit Button Block
 * Creates a submit button for forms
 * 
 * @param string $text - Button text (default: 'Submit')
 * @param string $style - Button style: 'primary', 'secondary', 'success', 'danger', 'outline' (default: 'primary')
 * @param array $styles - Optional styling properties
 */

function block_submitbutton($text = 'Submit', $style = 'primary', $styles = []) {
    $classes = "btn btn-$style";
    
    $styleAttr = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$styleAttr>";
    $html .= "<button type=\"submit\" class=\"$classes\">$text</button>";
    $html .= "</div>";
    
    return $html;
}
?>
