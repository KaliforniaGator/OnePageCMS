<?php
/**
 * Accordion Block
 * Creates collapsible accordion sections
 * 
 * @param array $items - Array of accordion items with 'title' and 'content'
 * @param bool $multiple - Allow multiple sections open (default: false)
 */

function block_accordion($items, $multiple = false) {
    $id = 'accordion-' . uniqid();
    $multipleAttr = $multiple ? 'true' : 'false';
    
    $html = "<div class=\"block-accordion\" id=\"$id\" data-multiple=\"$multipleAttr\">";
    
    foreach ($items as $index => $item) {
        $title = $item['title'] ?? '';
        $content = $item['content'] ?? '';
        $itemId = "$id-item-$index";
        
        $html .= "<div class=\"accordion-item\">";
        $html .= "<button class=\"accordion-header\" onclick=\"toggleAccordion('$itemId')\">";
        $html .= "<span>$title</span>";
        $html .= "<span class=\"accordion-icon\">+</span>";
        $html .= "</button>";
        $html .= "<div class=\"accordion-content\" id=\"$itemId\">$content</div>";
        $html .= "</div>";
    }
    
    $html .= "</div>";
    return $html;
}

/**
 * Tabs Block
 * Creates tabbed content sections
 */

function block_tabs($tabs) {
    $id = 'tabs-' . uniqid();
    
    $html = "<div class=\"block-tabs\" id=\"$id\">";
    $html .= "<div class=\"tabs-nav\">";
    
    foreach ($tabs as $index => $tab) {
        $title = $tab['title'] ?? "Tab $index";
        $activeClass = $index === 0 ? 'active' : '';
        $html .= "<button class=\"tab-button $activeClass\" onclick=\"switchTab('$id', $index)\">$title</button>";
    }
    
    $html .= "</div>";
    $html .= "<div class=\"tabs-content\">";
    
    foreach ($tabs as $index => $tab) {
        $content = $tab['content'] ?? '';
        $activeClass = $index === 0 ? 'active' : '';
        $html .= "<div class=\"tab-pane $activeClass\" data-tab=\"$index\">$content</div>";
    }
    
    $html .= "</div>";
    $html .= "</div>";
    
    return $html;
}
?>
