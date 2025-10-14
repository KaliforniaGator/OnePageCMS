<?php
/**
 * Text Area Block
 * Creates a textarea input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param string $placeholder - Placeholder text
 * @param int $rows - Number of rows (default: 4)
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_textareafield($name = 'textarea', $label = 'Text Area Label', $placeholder = '', $rows = 4, $required = false, $styles = []) {
    $id = 'textarea_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<textarea id=\"$id\" name=\"$name\" rows=\"$rows\" placeholder=\"$placeholder\"$requiredAttr></textarea>";
    $html .= "</div>";
    
    return $html;
}
?>
