<?php
/**
 * TextView Block
 * Displays formatted text content
 * 
 * @param string $content - Text content
 * @param string $format - Text format: 'paragraph', 'heading', 'quote', 'code' (default: 'paragraph')
 * @param array $options - Additional options (level for headings, language for code, etc.)
 */

function block_textview($content, $format = 'paragraph', $options = []) {
    $class = $options['class'] ?? '';
    $classes = trim("block-textview textview-$format $class");
    
    switch ($format) {
        case 'heading':
            $level = $options['level'] ?? 2;
            $level = max(1, min(6, $level)); // Ensure level is between 1-6
            return "<h$level class=\"$classes\">$content</h$level>";
            
        case 'quote':
            $author = $options['author'] ?? '';
            $html = "<blockquote class=\"$classes\">";
            $html .= "<p>$content</p>";
            if ($author) {
                $html .= "<cite>— $author</cite>";
            }
            $html .= "</blockquote>";
            return $html;
            
        case 'code':
            $language = $options['language'] ?? '';
            $langClass = $language ? " language-$language" : '';
            return "<pre class=\"$classes\"><code class=\"$langClass\">$content</code></pre>";
            
        case 'paragraph':
        default:
            return "<p class=\"$classes\">$content</p>";
    }
}

/**
 * Alert Block
 * Displays alert/notification messages
 * 
 * @param string $message - Alert message
 * @param string $type - Alert type: 'info', 'success', 'warning', 'error' (default: 'info')
 * @param bool $dismissible - Whether alert can be dismissed (default: false)
 */

function block_alert($message, $type = 'info', $dismissible = false) {
    $classes = "block-alert alert-$type";
    if ($dismissible) {
        $classes .= " alert-dismissible";
    }
    
    $html = "<div class=\"$classes\" role=\"alert\">";
    $html .= "<span class=\"alert-message\">$message</span>";
    
    if ($dismissible) {
        $html .= "<button class=\"alert-close\" onclick=\"this.parentElement.style.display='none'\">&times;</button>";
    }
    
    $html .= "</div>";
    return $html;
}
?>
