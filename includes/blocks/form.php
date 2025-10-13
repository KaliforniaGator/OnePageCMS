<?php
/**
 * Form Block
 * Creates forms with various input types
 * 
 * @param array $config - Form configuration
 *   - action: Form action URL
 *   - method: Form method (GET/POST)
 *   - fields: Array of field configurations
 *   - submit_text: Submit button text
 */

function block_form($config) {
    $action = $config['action'] ?? '';
    $method = $config['method'] ?? 'POST';
    $fields = $config['fields'] ?? [];
    $submitText = $config['submit_text'] ?? 'Submit';
    $class = $config['class'] ?? '';
    
    $html = "<form action=\"$action\" method=\"$method\" class=\"block-form $class\">";
    
    foreach ($fields as $field) {
        $html .= block_form_field($field);
    }
    
    $html .= "<div class=\"form-group\">";
    $html .= "<button type=\"submit\" class=\"btn btn-primary\">$submitText</button>";
    $html .= "</div>";
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
