<?php
/**
 * Toggle Field Block
 * Creates a toggle switch (styled checkbox)
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param bool $checked - Whether toggle is checked by default (default: false)
 * @param array $styles - Optional styling properties
 */

function block_togglefield($name = 'toggle', $label = 'Toggle Label', $checked = false, $styles = []) {
    $id = 'toggle_' . uniqid();
    $checkedAttr = $checked ? ' checked' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group toggle-group\"$style>";
    $html .= "<label for=\"$id\" class=\"toggle-label\">";
    $html .= "<input type=\"checkbox\" id=\"$id\" name=\"$name\" class=\"toggle-input\"$checkedAttr>";
    $html .= "<span class=\"toggle-slider\"></span>";
    $html .= "<span class=\"toggle-text\">$label</span>";
    $html .= "</label>";
    $html .= "</div>";
    
    return $html;
}
?>
