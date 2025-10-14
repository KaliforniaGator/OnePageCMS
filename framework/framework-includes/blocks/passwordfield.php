<?php
/**
 * Password Field Block
 * Creates a password input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param string $placeholder - Placeholder text
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_passwordfield($name = 'password', $label = 'Password', $placeholder = '', $required = false, $styles = []) {
    $id = 'password_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<input type=\"password\" id=\"$id\" name=\"$name\" placeholder=\"$placeholder\"$requiredAttr>";
    $html .= "</div>";
    
    return $html;
}
?>
