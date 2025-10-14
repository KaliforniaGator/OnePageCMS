<?php
/**
 * Select Field Block
 * Creates a select dropdown field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param array $options - Array of options with 'label' and 'value' keys
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_selectfield($name = 'select', $label = 'Select Option', $options = [], $required = false, $styles = []) {
    $id = 'select_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<select id=\"$id\" name=\"$name\"$requiredAttr>";
    $html .= "<option value=\"\">-- Select --</option>";
    
    foreach ($options as $option) {
        $optionLabel = $option['label'] ?? '';
        $optionValue = $option['value'] ?? '';
        $html .= "<option value=\"$optionValue\">$optionLabel</option>";
    }
    
    $html .= "</select>";
    $html .= "</div>";
    
    return $html;
}
?>
