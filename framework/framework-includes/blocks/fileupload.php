<?php
/**
 * File Upload Block
 * Creates a file input field
 * 
 * @param string $name - Input name attribute
 * @param string $label - Label text
 * @param string $accept - Accepted file types (e.g., '.pdf,.doc,.docx')
 * @param bool $multiple - Allow multiple files (default: false)
 * @param bool $required - Whether field is required (default: false)
 * @param array $styles - Optional styling properties
 */

function block_fileupload($name = 'file', $label = 'Upload File', $accept = '', $multiple = false, $required = false, $styles = []) {
    $id = 'file_' . uniqid();
    $acceptAttr = $accept ? " accept=\"$accept\"" : '';
    $multipleAttr = $multiple ? ' multiple' : '';
    $requiredAttr = $required ? ' required' : '';
    
    $style = buildStyleAttribute($styles);
    
    $html = "<div class=\"form-group\"$style>";
    if ($label) {
        $html .= "<label for=\"$id\">$label</label>";
    }
    $html .= "<input type=\"file\" id=\"$id\" name=\"$name\"$acceptAttr$multipleAttr$requiredAttr>";
    $html .= "</div>";
    
    return $html;
}
?>
