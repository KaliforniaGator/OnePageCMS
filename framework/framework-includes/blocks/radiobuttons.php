<?php
/**
 * Radio Buttons Block
 * Creates a group of radio button inputs
 * 
 * @param string $name - Input name attribute (same for all radio buttons in group)
 * @param string $label - Group label text
 * @param array $options - Array of options with 'label' and 'value' keys
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_radiobuttons($name = 'radio', $label = 'Radio Group Label', $options = [], $required = false, $styles = []) {
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group radio-group\"$style>";
    if ($label) {
        $html .= "<label>$label</label>";
    }
    
    foreach ($options as $option) {
        $id = 'radio_' . uniqid();
        $optionLabel = $option['label'] ?? '';
        $optionValue = $option['value'] ?? '';
        
        $html .= "<label for=\"$id\" class=\"radio-label\">";
        $html .= "<input type=\"radio\" id=\"$id\" name=\"$name\" value=\"$optionValue\"$requiredAttr>";
        $html .= " <span>$optionLabel</span>";
        $html .= "</label>";
    }
    
    $html .= "</div>";
    
    return $html;
}
?>
