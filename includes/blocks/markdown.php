<?php
/**
 * Markdown Block
 * Displays formatted markdown content from a file
 * 
 * @param string $src - Path to the markdown file (relative to project root)
 * @param array $options - Additional options (class, etc.)
 */

function block_markdown($src, $options = []) {
    $class = $options['class'] ?? '';
    $classes = trim("block-markdown $class");
    
    // Build the full path to the markdown file
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($src, '/');
    
    // Check if file exists
    if (!file_exists($filePath)) {
        return "<div class=\"$classes\"><p class=\"error\">Markdown file not found: $src</p></div>";
    }
    
    // Read the markdown file
    $markdown = file_get_contents($filePath);
    
    // Parse markdown to HTML using a simple parser
    $html = parseMarkdown($markdown);
    
    return "<div class=\"$classes\">$html</div>";
}

/**
 * Simple Markdown Parser
 * Converts markdown to HTML
 * 
 * @param string $markdown - Markdown content
 * @return string - HTML content
 */
function parseMarkdown($markdown) {
    // Normalize line endings
    $markdown = str_replace(["\r\n", "\r"], "\n", $markdown);
    
    // Process code blocks first (to protect them from other processing)
    $markdown = preg_replace_callback('/```(\w*)\n(.*?)```/s', function($matches) {
        $language = $matches[1] ? " class=\"language-{$matches[1]}\"" : '';
        $code = htmlspecialchars($matches[2]);
        return "<pre><code$language>$code</code></pre>";
    }, $markdown);
    
    // Process inline code
    $markdown = preg_replace('/`([^`]+)`/', '<code>$1</code>', $markdown);
    
    // Process headings
    $markdown = preg_replace('/^######\s+(.+)$/m', '<h6>$1</h6>', $markdown);
    $markdown = preg_replace('/^#####\s+(.+)$/m', '<h5>$1</h5>', $markdown);
    $markdown = preg_replace('/^####\s+(.+)$/m', '<h4>$1</h4>', $markdown);
    $markdown = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^#\s+(.+)$/m', '<h1>$1</h1>', $markdown);
    
    // Process bold and italic
    $markdown = preg_replace('/\*\*\*(.+?)\*\*\*/', '<strong><em>$1</em></strong>', $markdown);
    $markdown = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $markdown);
    $markdown = preg_replace('/___(.+?)___/', '<strong><em>$1</em></strong>', $markdown);
    $markdown = preg_replace('/__(.+?)__/', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/_(.+?)_/', '<em>$1</em>', $markdown);
    
    // Process links
    $markdown = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $markdown);
    
    // Process images
    $markdown = preg_replace('/!\[([^\]]*)\]\(([^\)]+)\)/', '<img src="$2" alt="$1">', $markdown);
    
    // Process horizontal rules
    $markdown = preg_replace('/^(\*\*\*|---|___)$/m', '<hr>', $markdown);
    
    // Process unordered lists
    $markdown = preg_replace_callback('/(?:^[\*\-\+]\s+.+$\n?)+/m', function($matches) {
        $items = preg_replace('/^[\*\-\+]\s+(.+)$/m', '<li>$1</li>', $matches[0]);
        return "<ul>\n$items</ul>\n";
    }, $markdown);
    
    // Process ordered lists
    $markdown = preg_replace_callback('/(?:^\d+\.\s+.+$\n?)+/m', function($matches) {
        $items = preg_replace('/^\d+\.\s+(.+)$/m', '<li>$1</li>', $matches[0]);
        return "<ol>\n$items</ol>\n";
    }, $markdown);
    
    // Process blockquotes
    $markdown = preg_replace_callback('/(?:^>\s+.+$\n?)+/m', function($matches) {
        $content = preg_replace('/^>\s+/m', '', $matches[0]);
        return "<blockquote>$content</blockquote>\n";
    }, $markdown);
    
    // Process paragraphs (lines separated by blank lines)
    $lines = explode("\n", $markdown);
    $html = '';
    $paragraph = '';
    $inBlock = false;
    
    foreach ($lines as $line) {
        $trimmed = trim($line);
        
        // Check if we're in a block element
        if (preg_match('/^<(h[1-6]|ul|ol|blockquote|pre|hr)/', $trimmed)) {
            if ($paragraph) {
                $html .= "<p>$paragraph</p>\n";
                $paragraph = '';
            }
            $html .= $line . "\n";
            $inBlock = preg_match('/^<(ul|ol|blockquote|pre)/', $trimmed);
        } elseif (preg_match('/<\/(ul|ol|blockquote|pre)>/', $trimmed)) {
            $html .= $line . "\n";
            $inBlock = false;
        } elseif ($inBlock) {
            $html .= $line . "\n";
        } elseif ($trimmed === '') {
            if ($paragraph) {
                $html .= "<p>$paragraph</p>\n";
                $paragraph = '';
            }
        } else {
            if ($paragraph) {
                $paragraph .= ' ';
            }
            $paragraph .= $trimmed;
        }
    }
    
    // Add any remaining paragraph
    if ($paragraph) {
        $html .= "<p>$paragraph</p>\n";
    }
    
    return $html;
}
?>
