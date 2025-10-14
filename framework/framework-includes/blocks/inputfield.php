<?php
/**
 * Input Field Block
 * Creates a text input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param string $placeholder - Placeholder text
 * @param string $value - Default value
 * @param string $input_type - Input type: 'text', 'email', 'tel', 'url', 'number' (default: 'text')
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_inputfield($name = 'input', $label = 'Input Label', $placeholder = '', $value = '', $input_type = 'text', $required = false, $styles = []) {
    $id = 'input_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<input type=\"$input_type\" id=\"$id\" name=\"$name\" value=\"$value\" placeholder=\"$placeholder\"$requiredAttr>";
    $html .= "</div>";
    
    return $html;
}
?>
