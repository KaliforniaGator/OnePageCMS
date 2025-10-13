<?php
/**
 * Menu Block
 * Creates navigation menus
 * 
 * @param array $items - Array of menu items with 'text', 'url', and optional 'children'
 * @param string $type - Menu type: 'horizontal', 'vertical' (default: 'horizontal')
 * @param string $style - Menu style: 'simple', 'rect', 'rounded-rect', 'capsule', 'sticky' (default: 'simple')
 * @param string $class - Additional CSS classes (optional)
 */

function block_menu($items, $type = 'horizontal', $style = 'simple', $class = '') {
    $classes = trim("block-menu menu-$type menu-style-$style $class");
    
    $html = "<nav class=\"$classes\">";
    $html .= "<ul class=\"menu-list\">";
    
    foreach ($items as $item) {
        $text = $item['text'] ?? '';
        $url = $item['url'] ?? '#';
        $children = $item['children'] ?? [];
        $active = isset($item['active']) && $item['active'] ? 'active' : '';
        $icon = $item['icon'] ?? '';
        
        $hasChildren = !empty($children);
        $childClass = $hasChildren ? 'has-submenu' : '';
        
        $html .= "<li class=\"menu-item $childClass $active\">";
        $html .= "<a href=\"$url\" class=\"menu-link\">";
        
        if ($icon) {
            $html .= "<i class=\"$icon menu-icon\"></i> ";
        }
        
        $html .= $text;
        
        if ($hasChildren) {
            $html .= " <i class=\"fas fa-chevron-down submenu-indicator\"></i>";
        }
        
        $html .= "</a>";
        
        if ($hasChildren) {
            $html .= block_submenu($children);
        }
        
        $html .= "</li>";
    }
    
    $html .= "</ul>";
    $html .= "</nav>";
    
    return $html;
}

/**
 * Submenu Block
 * Creates dropdown submenus
 * 
 * @param array $items - Array of submenu items
 */

function block_submenu($items) {
    $html = "<ul class=\"submenu\">";
    
    foreach ($items as $item) {
        $text = $item['text'] ?? '';
        $url = $item['url'] ?? '#';
        $active = isset($item['active']) && $item['active'] ? 'active' : '';
        
        $html .= "<li class=\"submenu-item $active\">";
        $html .= "<a href=\"$url\" class=\"submenu-link\">$text</a>";
        $html .= "</li>";
    }
    
    $html .= "</ul>";
    return $html;
}

/**
 * Breadcrumb Block
 * Creates breadcrumb navigation
 * 
 * @param array $items - Array of breadcrumb items with 'text' and 'url'
 * @param string $separator - Separator character (default: '/')
 */

function block_breadcrumb($items, $separator = '/') {
    $html = "<nav class=\"block-breadcrumb\" aria-label=\"Breadcrumb\">";
    $html .= "<ol class=\"breadcrumb-list\">";
    
    $lastIndex = count($items) - 1;
    foreach ($items as $index => $item) {
        $text = $item['text'] ?? '';
        $url = $item['url'] ?? '';
        $isLast = $index === $lastIndex;
        
        $html .= "<li class=\"breadcrumb-item\">";
        
        if ($isLast) {
            $html .= "<span class=\"breadcrumb-current\">$text</span>";
        } else {
            $html .= "<a href=\"$url\" class=\"breadcrumb-link\">$text</a>";
            $html .= "<span class=\"breadcrumb-separator\">$separator</span>";
        }
        
        $html .= "</li>";
    }
    
    $html .= "</ol>";
    $html .= "</nav>";
    
    return $html;
}
?>
