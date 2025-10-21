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
    
    // Build inline styles for font properties
    $inlineStyles = [];
    if (!empty($options['font_family']) && $options['font_family'] !== 'default') {
        $inlineStyles[] = 'font-family: ' . $options['font_family'];
    }
    if (!empty($options['font_size'])) {
        $inlineStyles[] = 'font-size: ' . $options['font_size'];
    }
    if (!empty($options['font_weight']) && $options['font_weight'] !== 'normal') {
        $inlineStyles[] = 'font-weight: ' . $options['font_weight'];
    }
    $styleAttr = !empty($inlineStyles) ? ' style="' . implode('; ', $inlineStyles) . '"' : '';
    
    switch ($format) {
        case 'heading':
            $level = $options['level'] ?? 2;
            $level = max(1, min(6, $level)); // Ensure level is between 1-6
            return "<h$level class=\"$classes\"$styleAttr>$content</h$level>";
            
        case 'quote':
            $author = $options['author'] ?? '';
            $html = "<blockquote class=\"$classes\"$styleAttr>";
            $html .= "<p>$content</p>";
            if ($author) {
                $html .= "<cite>— $author</cite>";
            }
            $html .= "</blockquote>";
            return $html;
            
        case 'code':
            $language = $options['language'] ?? '';
            $langClass = $language ? " language-$language" : '';
            return "<pre class=\"$classes\"$styleAttr><code class=\"$langClass\">$content</code></pre>";
            
        case 'paragraph':
        default:
            return "<p class=\"$classes\"$styleAttr>$content</p>";
    }
}

?>
