<?php
/**
 * Checkbox Block
 * Creates a checkbox input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param string $value - Checkbox value (default: '1')
 * @param bool $checked - Whether checkbox is checked by default (default: false)
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties (padding, margin, width, etc.)
 */

function block_checkbox($name = 'checkbox', $label = 'Checkbox Label', $value = '1', $checked = false, $required = false, $styles = []) {
    $id = 'checkbox_' . uniqid();
    $checkedAttr = $checked ? ' checked' : '';
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group checkbox-group\"$style>";
    $html .= "<label for=\"$id\">";
    $html .= "<input type=\"checkbox\" id=\"$id\" name=\"$name\" value=\"$value\"$checkedAttr$requiredAttr>";
    $html .= " <span>$label</span>";
    $html .= "</label>";
    $html .= "</div>";
    
    return $html;
}

/**
 * Helper function to build style attribute from styles array
 */
function buildStyleAttribute($styles) {
    if (empty($styles)) return '';
    
    $styleStr = '';
    $cssProps = [];
    
    // Padding
    if (!empty($styles['padding_all'])) {
        $cssProps[] = "padding: {$styles['padding_all']}";
    } else {
        if (!empty($styles['padding_top'])) $cssProps[] = "padding-top: {$styles['padding_top']}";
        if (!empty($styles['padding_right'])) $cssProps[] = "padding-right: {$styles['padding_right']}";
        if (!empty($styles['padding_bottom'])) $cssProps[] = "padding-bottom: {$styles['padding_bottom']}";
        if (!empty($styles['padding_left'])) $cssProps[] = "padding-left: {$styles['padding_left']}";
    }
    
    // Margin
    if (!empty($styles['margin_all'])) {
        $cssProps[] = "margin: {$styles['margin_all']}";
    } else {
        if (!empty($styles['margin_top'])) $cssProps[] = "margin-top: {$styles['margin_top']}";
        if (!empty($styles['margin_right'])) $cssProps[] = "margin-right: {$styles['margin_right']}";
        if (!empty($styles['margin_bottom'])) $cssProps[] = "margin-bottom: {$styles['margin_bottom']}";
        if (!empty($styles['margin_left'])) $cssProps[] = "margin-left: {$styles['margin_left']}";
    }
    
    // Dimensions
    if (!empty($styles['width'])) $cssProps[] = "width: {$styles['width']}";
    if (!empty($styles['height'])) $cssProps[] = "height: {$styles['height']}";
    if (!empty($styles['min_width'])) $cssProps[] = "min-width: {$styles['min_width']}";
    if (!empty($styles['max_width'])) $cssProps[] = "max-width: {$styles['max_width']}";
    if (!empty($styles['min_height'])) $cssProps[] = "min-height: {$styles['min_height']}";
    if (!empty($styles['max_height'])) $cssProps[] = "max-height: {$styles['max_height']}";
    
    if (!empty($cssProps)) {
        $styleStr = ' style="' . implode('; ', $cssProps) . '"';
    }
    
    return $styleStr;
}
?>
