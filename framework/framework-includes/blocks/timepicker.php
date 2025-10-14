<?php
/**
 * Time Picker Block
 * Creates a time input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_timepicker($name = 'time', $label = 'Time', $required = false, $styles = []) {
    $id = 'time_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<input type=\"time\" id=\"$id\" name=\"$name\"$requiredAttr>";
    $html .= "</div>";
    
    return $html;
}
?>
