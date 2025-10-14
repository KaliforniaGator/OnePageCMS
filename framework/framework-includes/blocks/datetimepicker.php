<?php
/**
 * Date Time Picker Block
 * Creates a datetime-local input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_datetimepicker($name = 'datetime', $label = 'Date & Time', $required = false, $styles = []) {
    $id = 'datetime_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<input type=\"datetime-local\" id=\"$id\" name=\"$name\"$requiredAttr>";
    $html .= "</div>";
    
    return $html;
}
?>
