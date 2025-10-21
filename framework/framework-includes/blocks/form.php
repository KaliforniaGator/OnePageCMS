<?php
/**
 * Form Block
 * Creates forms with various input types
 * 
 * @param mixed $config - Form configuration (array) or content (string for child blocks)
 *   - action: Form action URL
 *   - method: Form method (GET/POST)
 *   - fields: Array of field configurations (legacy support)
 *   - submit_text: Submit button text (legacy support)
 *   - content: Child blocks content (when used as container)
 */

function block_form($config) {
    // Support both legacy array config and new content-based approach
    if (is_string($config)) {
        // Simple content string
        $content = $config;
        $action = '#';
        $method = 'POST';
        $class = '';
        $style = '';
    } else {
        $action = $config['action'] ?? '#';
        $method = $config['method'] ?? 'POST';
        $class = $config['class'] ?? '';
        $style = $config['style'] ?? '';
        
        // Check if using legacy fields array or new content approach
        if (isset($config['fields']) && is_array($config['fields'])) {
            // Legacy mode: render fields from array
            $content = '';
            foreach ($config['fields'] as $field) {
                $content .= block_form_field($field);
            }
            
            $submitText = $config['submit_text'] ?? 'Submit';
            $content .= "<div class=\"form-group\">";
            $content .= "<button type=\"submit\" class=\"btn btn-primary\">$submitText</button>";
            $content .= "</div>";
        } else {
            // New mode: use content directly (for child blocks)
            $content = $config['content'] ?? '';
        }
    }
    
    // For GET forms, extract query parameters from action and add as hidden fields
    $hiddenFields = '';
    if (strtoupper($method) === 'GET' && strpos($action, '?') !== false) {
        $parts = explode('?', $action, 2);
        $baseAction = $parts[0];
        $queryString = $parts[1];
        
        // Parse query string into parameters
        parse_str($queryString, $params);
        
        // Create hidden fields for each parameter
        foreach ($params as $key => $value) {
            $hiddenFields .= "<input type=\"hidden\" name=\"" . htmlspecialchars($key) . "\" value=\"" . htmlspecialchars($value) . "\">";
        }
        
        // Use base action without query string
        $action = $baseAction;
    }
    
    $styleAttr = $style ? " style=\"$style\"" : '';
    $html = "<form action=\"$action\" method=\"$method\" class=\"block-form $class\"$styleAttr>";
    $html .= $hiddenFields;
    $html .= $content;
    $html .= "</form>";
    
    return $html;
}

/**
 * Form Field Block
 * Creates individual form fields
 */

function block_form_field($field) {
    $type = $field['type'] ?? 'text';
    $name = $field['name'] ?? '';
    $label = $field['label'] ?? '';
    $placeholder = $field['placeholder'] ?? '';
    $required = isset($field['required']) && $field['required'] ? 'required' : '';
    $value = $field['value'] ?? '';
    $class = $field['class'] ?? '';
    
    $html = "<div class=\"form-group $class\">";
    
    if ($label) {
        $requiredMark = $required ? '<span class="required">*</span>' : '';
        $html .= "<label for=\"$name\">$label$requiredMark</label>";
    }
    
    switch ($type) {
        case 'textarea':
            $html .= "<textarea name=\"$name\" id=\"$name\" placeholder=\"$placeholder\" $required>$value</textarea>";
            break;
        case 'select':
            $options = $field['options'] ?? [];
            $html .= "<select name=\"$name\" id=\"$name\" $required>";
            foreach ($options as $optValue => $optLabel) {
                $selected = $value == $optValue ? 'selected' : '';
                $html .= "<option value=\"$optValue\" $selected>$optLabel</option>";
            }
            $html .= "</select>";
            break;
        case 'checkbox':
            $checked = $value ? 'checked' : '';
            $html .= "<input type=\"checkbox\" name=\"$name\" id=\"$name\" value=\"1\" $checked $required>";
            if ($label) {
                $html .= "<label for=\"$name\" class=\"checkbox-label\">$label</label>";
            }
            break;
        case 'radio':
            $options = $field['options'] ?? [];
            foreach ($options as $optValue => $optLabel) {
                $checked = $value == $optValue ? 'checked' : '';
                $html .= "<input type=\"radio\" name=\"$name\" id=\"{$name}_{$optValue}\" value=\"$optValue\" $checked $required>";
                $html .= "<label for=\"{$name}_{$optValue}\" class=\"radio-label\">$optLabel</label>";
            }
            break;
        default:
            $html .= "<input type=\"$type\" name=\"$name\" id=\"$name\" placeholder=\"$placeholder\" value=\"$value\" $required>";
            break;
    }
    
    if (isset($field['help'])) {
        $html .= "<small class=\"form-help\">{$field['help']}</small>";
    }
    
    $html .= "</div>";
    return $html;
}
?>
