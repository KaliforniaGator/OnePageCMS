<?php
/**
 * Accordion Block
 * Creates collapsible accordion sections
 * 
 * @param array $items - Array of accordion items with 'title' and 'content'
 * @param bool $multiple - Allow multiple sections open (default: false)
 * @param array $options - Additional options (text_align, icon_style, icon_shape, header_color, header_text_style)
 */

function block_accordion($items, $multiple = false, $options = []) {
    $id = 'accordion-' . uniqid();
    $multipleAttr = $multiple ? 'true' : 'false';
    
    // Extract options
    $text_align = $options['text_align'] ?? '';
    $icon_style = $options['icon_style'] ?? '+/-';
    $icon_shape = $options['icon_shape'] ?? 'rounded-square';
    $header_color = $options['header_color'] ?? '';
    $header_text_style = $options['header_text_style'] ?? 'h3';
    
    // Build inline styles
    $accordionStyles = [];
    if ($text_align) {
        $accordionStyles[] = 'text-align: ' . $text_align;
    }
    $accordionStyleAttr = !empty($accordionStyles) ? ' style="' . implode('; ', $accordionStyles) . '"' : '';
    
    // Determine icon based on icon_style
    $iconOpen = '+';
    $iconClosed = '-';
    if ($icon_style === 'arrow') {
        $iconOpen = '▼';
        $iconClosed = '▲';
    } elseif ($icon_style === '+/x') {
        $iconOpen = '+';
        $iconClosed = '×';
    }
    
    $html = "<div class=\"block-accordion accordion-icon-$icon_shape\" id=\"$id\" data-multiple=\"$multipleAttr\"$accordionStyleAttr>";
    
    foreach ($items as $index => $item) {
        $title = $item['title'] ?? '';
        $content = $item['content'] ?? '';
        $itemId = "$id-item-$index";
        
        // Build header styles
        $headerStyles = [];
        if ($header_color) {
            $headerStyles[] = 'background-color: ' . $header_color;
        }
        $headerStyleAttr = !empty($headerStyles) ? ' style="' . implode('; ', $headerStyles) . '"' : '';
        
        $html .= "<div class=\"accordion-item\">";
        $html .= "<button class=\"accordion-header header-style-$header_text_style\" onclick=\"toggleAccordion('$itemId')\"$headerStyleAttr>";
        $html .= "<span>$title</span>";
        $html .= "<span class=\"accordion-icon\" data-icon-open=\"$iconOpen\" data-icon-closed=\"$iconClosed\">$iconOpen</span>";
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
