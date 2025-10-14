<?php
/**
 * Date Picker Block
 * Creates a date input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_datepicker($name = 'date', $label = 'Date', $required = false, $styles = []) {
    $id = 'date_' . uniqid();
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<input type=\"date\" id=\"$id\" name=\"$name\"$requiredAttr>";
    $html .= "</div>";
    
    return $html;
}
?>
