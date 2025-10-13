<?php
/**
 * List Block
 * Creates ordered or unordered lists
 * 
 * @param array $items - Array of list items
 * @param string $type - List type: 'ul' or 'ol' (default: 'ul')
 * @param string $class - Additional CSS classes (optional)
 * @param string $style - List style: 'default', 'none', 'disc', 'circle', 'square', 'decimal', 'alpha' (optional)
 */

function block_list($items, $type = 'ul', $class = '', $style = 'default') {
    $styleClass = $style !== 'default' ? " list-style-$style" : '';
    $classes = trim("block-list$styleClass $class");
    
    $tag = $type === 'ol' ? 'ol' : 'ul';
    $html = "<$tag class=\"$classes\">";
    
    foreach ($items as $key => $item) {
        if (is_array($item)) {
            $content = $item['content'] ?? $key;
            $html .= "<li>$content";
            if (isset($item['children'])) {
                $html .= block_list($item['children'], $type, '', $style);
            }
            $html .= "</li>";
        } else {
            $html .= "<li>$item</li>";
        }
    }
    
    $html .= "</$tag>";
    return $html;
}

/**
 * Checklist Block (Static)
 * Creates a static checklist with visual checkmarks
 * 
 * @param array $items - Array of items with 'text' and optional 'checked' keys
 * @param string $class - Additional CSS classes (optional)
 */

function block_checklist($items, $class = '') {
    $classes = trim("block-checklist checklist-static $class");
    $html = "<ul class=\"$classes\">";
    
    foreach ($items as $item) {
        $text = is_array($item) ? $item['text'] : $item;
        $checked = is_array($item) && isset($item['checked']) && $item['checked'] ? 'checked' : '';
        $checkmark = $checked ? '✓' : '';
        
        $html .= "<li class=\"checklist-item $checked\">";
        $html .= "<span class=\"checkmark\">$checkmark</span>";
        $html .= "<span class=\"checklist-text\">$text</span>";
        $html .= "</li>";
    }
    
    $html .= "</ul>";
    return $html;
}

/**
 * Checklist Block (Interactive)
 * Creates an interactive checklist with actual checkboxes
 * 
 * @param array $items - Array of items with 'text', optional 'checked', and 'id' keys
 * @param string $name - Form name for the checklist (optional)
 * @param string $class - Additional CSS classes (optional)
 */

function block_checklist_interactive($items, $name = 'checklist', $class = '') {
    $classes = trim("block-checklist checklist-interactive $class");
    $html = "<ul class=\"$classes\">";
    
    foreach ($items as $index => $item) {
        $text = is_array($item) ? $item['text'] : $item;
        $checked = is_array($item) && isset($item['checked']) && $item['checked'] ? 'checked' : '';
        $id = is_array($item) && isset($item['id']) ? $item['id'] : "{$name}_{$index}";
        $value = is_array($item) && isset($item['value']) ? $item['value'] : $text;
        
        $html .= "<li class=\"checklist-item\">";
        $html .= "<input type=\"checkbox\" id=\"$id\" name=\"{$name}[]\" value=\"$value\" $checked>";
        $html .= "<label for=\"$id\" class=\"checklist-label\">$text</label>";
        $html .= "</li>";
    }
    
    $html .= "</ul>";
    return $html;
}
?>
