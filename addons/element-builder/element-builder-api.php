<?php
/**
 * Element Builder API
 * Handles save, load, and reset operations for header/footer elements
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once __DIR__ . '/../../config.php';

// Suppress PHP errors from being output (they break JSON)
error_reporting(0);
ini_set('display_errors', 0);

// Set JSON header
header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET requests (load element)
if ($method === 'GET') {
    handleLoadElement();
}

// Handle POST requests (save/reset/generate_code)
if ($method === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['action'])) {
        sendError('Invalid request');
    }
    
    switch ($data['action']) {
        case 'save':
            handleSaveElement($data);
            break;
        case 'reset':
            handleResetElement($data);
            break;
        case 'generate_code':
            handleGenerateCode($data);
            break;
        default:
            sendError('Unknown action');
    }
}

/**
 * Load an element's block data
 */
function handleLoadElement() {
    if (!isset($_GET['element'])) {
        sendError('Element name not provided');
    }
    
    $element = $_GET['element'];
    if (!in_array($element, ['header', 'footer'])) {
        sendError('Invalid element name');
    }
    
    $elementFile = __DIR__ . '/../../elements/' . $element . '.php';
    
    if (!file_exists($elementFile)) {
        sendError('Element file not found');
    }
    
    $content = file_get_contents($elementFile);
    
    // Try to extract block data from comment
    if (preg_match('/ELEMENT_BUILDER_DATA: (.+)/', $content, $matches)) {
        $elementData = json_decode($matches[1], true);
        sendSuccess([
            'blocks' => $elementData['blocks'] ?? [],
            'styles' => $elementData['styles'] ?? []
        ]);
    } else {
        // Return empty if no data found
        sendSuccess([
            'blocks' => [],
            'styles' => []
        ]);
    }
}

/**
 * Save an element
 */
function handleSaveElement($data) {
    if (!isset($data['element']) || !isset($data['blocks'])) {
        sendError('Missing required data');
    }
    
    $element = $data['element'];
    if (!in_array($element, ['header', 'footer'])) {
        sendError('Invalid element name');
    }
    
    $blocks = $data['blocks'];
    $styles = $data['styles'] ?? [];
    
    $elementFile = __DIR__ . '/../../elements/' . $element . '.php';
    
    // Create backup before saving
    if (file_exists($elementFile)) {
        createBackup($element, $elementFile);
    }
    
    // Generate PHP code
    $php = generateElementPHP($element, $blocks, $styles);
    
    // Save to file
    if (file_put_contents($elementFile, $php) === false) {
        sendError('Failed to save element file');
    }
    
    sendSuccess(['message' => 'Element saved successfully']);
}

/**
 * Create backup of element file
 */
function createBackup($element, $elementFile) {
    $backupDir = __DIR__ . '/../../elements/backups';
    
    // Create backups directory if it doesn't exist
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
    
    // Create backup filename with timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $backupFile = $backupDir . '/' . $element . '_' . $timestamp . '.php';
    
    // Copy current file to backup
    copy($elementFile, $backupFile);
    
    // Keep only last 10 backups
    $backups = glob($backupDir . '/' . $element . '_*.php');
    if (count($backups) > 10) {
        // Sort by modification time
        usort($backups, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        
        // Delete oldest backups
        $toDelete = array_slice($backups, 0, count($backups) - 10);
        foreach ($toDelete as $file) {
            unlink($file);
        }
    }
}

/**
 * Reset an element to default
 */
function handleResetElement($data) {
    if (!isset($data['element'])) {
        sendError('Element name not provided');
    }
    
    $element = $data['element'];
    if (!in_array($element, ['header', 'footer'])) {
        sendError('Invalid element name');
    }
    
    // Generate default PHP
    $php = generateDefaultElementPHP($element);
    
    // Save to file
    $elementFile = __DIR__ . '/../../elements/' . $element . '.php';
    
    if (file_put_contents($elementFile, $php) === false) {
        sendError('Failed to reset element file');
    }
    
    sendSuccess(['message' => 'Element reset successfully']);
}

/**
 * Generate code for preview
 */
function handleGenerateCode($data) {
    if (!isset($data['element']) || !isset($data['blocks'])) {
        sendError('Missing required data');
    }
    
    $element = $data['element'];
    $blocks = $data['blocks'];
    $styles = $data['styles'] ?? [];
    
    $code = generateElementPHP($element, $blocks, $styles);
    
    sendSuccess(['code' => $code]);
}

/**
 * Generate PHP code for an element
 */
function generateElementPHP($element, $blocks, $styles) {
    $elementTag = $element === 'header' ? 'header' : 'footer';
    $elementClass = $element === 'header' ? 'site-header' : 'site-footer';
    
    // Build element data JSON for later editing
    $elementData = json_encode(['blocks' => $blocks, 'styles' => $styles]);
    
    // Build inline styles
    $inlineStyles = [];
    if (!empty($styles['background_color'])) $inlineStyles[] = 'background-color: ' . $styles['background_color'];
    if (!empty($styles['text_color'])) $inlineStyles[] = 'color: ' . $styles['text_color'];
    if (!empty($styles['padding_top'])) $inlineStyles[] = 'padding-top: ' . $styles['padding_top'];
    if (!empty($styles['padding_bottom'])) $inlineStyles[] = 'padding-bottom: ' . $styles['padding_bottom'];
    if (!empty($styles['border_bottom'])) $inlineStyles[] = 'border-bottom: ' . $styles['border_bottom'];
    if (!empty($styles['box_shadow'])) $inlineStyles[] = 'box-shadow: ' . $styles['box_shadow'];
    
    $styleAttr = !empty($inlineStyles) ? ' style="' . implode('; ', $inlineStyles) . '"' : '';
    
    $php = "<?php\n";
    $php .= "/**\n";
    $php .= " * " . ucfirst($element) . " Element\n";
    $php .= " * Generated by Element Builder\n";
    $php .= " * \n";
    $php .= " * ELEMENT_BUILDER_DATA: {$elementData}\n";
    $php .= " */\n";
    $php .= "?>\n";
    $php .= "<{$elementTag} class=\"{$elementClass}\"{$styleAttr}>\n";
    $php .= "    <div class=\"container\">\n";
    
    // Generate block code
    foreach ($blocks as $block) {
        $php .= generateBlockCode($block);
    }
    
    $php .= "    </div>\n";
    $php .= "</{$elementTag}>\n";
    
    return $php;
}

/**
 * Generate default element PHP
 */
function generateDefaultElementPHP($element) {
    if ($element === 'header') {
        return '<?php
/**
 * Header Element
 * Default header
 */
?>
<header class="site-header">
    <div class="container">
        <?php echo block_logo([
            \'image\' => \'/assets/favicon/apple-touch-icon.png\',
            \'text\' => SITE_TITLE,
            \'alt\' => SITE_TITLE,
            \'width\' => \'54px\',
            \'height\' => \'54px\',
            \'link\' => \'/\',
            \'class\' => \'site-logo\'
        ]); ?>
        <p class="site-description"><?php echo SITE_DESCRIPTION; ?></p>
        
        <nav class="main-nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/?page=about">About</a></li>
                <li><a href="/?page=blocks" data-no-ajax>Blocks</a></li>
                <li><a href="/?page=docs">Documentation</a></li>
                <li><a href="/?page=contact">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
';
    } else {
        return '<?php
/**
 * Footer Element
 * Default footer
 */
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-widget">
                <h3>About</h3>
                <p><?php echo SITE_DESCRIPTION; ?></p>
            </div>
            
            <div class="footer-widget">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/?page=about">About</a></li>
                    <li><a href="/?page=contact">Contact</a></li>
                </ul>
            </div>
        </div>
        
        <div class="site-info">
            <p>&copy; <?php echo date(\'Y\'); ?> <?php echo SITE_TITLE; ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
';
    }
}

/**
 * Generate PHP code for a block
 */
function generateBlockCode($block) {
    $type = $block['type'];
    $data = $block['data'];
    
    $code = "        <?php\n";
    
    switch ($type) {
        case 'logo':
            $code .= "        echo block_logo([\n";
            $code .= "            'image' => '" . addslashes($data['image'] ?? '') . "',\n";
            $code .= "            'text' => '" . addslashes($data['text'] ?? '') . "',\n";
            $code .= "            'alt' => '" . addslashes($data['alt'] ?? '') . "',\n";
            $code .= "            'width' => '" . addslashes($data['width'] ?? '') . "',\n";
            $code .= "            'height' => '" . addslashes($data['height'] ?? '') . "',\n";
            $code .= "            'link' => '" . addslashes($data['link'] ?? '') . "',\n";
            $code .= "            'class' => '" . addslashes($data['class'] ?? '') . "'\n";
            $code .= "        ]);\n";
            break;
            
        case 'textview':
            $content = $data['content'] ?? 'Text content';
            $viewType = $data['type'] ?? 'paragraph';
            $level = intval($data['level'] ?? 2);
            
            if ($viewType === 'heading') {
                $code .= "        echo '<h{$level}>" . addslashes($content) . "</h{$level}>';\n";
            } elseif ($viewType === 'quote') {
                $code .= "        echo '<blockquote>" . addslashes($content) . "</blockquote>';\n";
            } else {
                $code .= "        echo '<p>" . addslashes($content) . "</p>';\n";
            }
            break;
            
        case 'menu':
            $autoPopulate = isset($data['auto_populate']) && $data['auto_populate'];
            $items = $data['items'] ?? [];
            // Convert to array if it's a JSON string
            if (is_string($items)) {
                $items = json_decode($items, true) ?? [];
            }
            $showIcons = isset($data['show_icons']) && $data['show_icons'];
            $menuShape = $data['menu_shape'] ?? 'simple';
            $orientation = $data['orientation'] ?? 'horizontal';
            $hoverColor = $data['hover_color'] ?? '';
            
            if ($autoPopulate) {
                // Generate menu from pages directory
                $code .= "        // Auto-populate menu from pages directory\n";
                $code .= "        \$menuItems = [];\n";
                $code .= "        \$pagesDir = PAGES_DIR;\n";
                $code .= "        if (is_dir(\$pagesDir)) {\n";
                $code .= "            \$files = scandir(\$pagesDir);\n";
                $code .= "            foreach (\$files as \$file) {\n";
                $code .= "                if (\$file === '.' || \$file === '..' || \$file[0] === '.') continue;\n";
                $code .= "                \$filePath = \$pagesDir . '/' . \$file;\n";
                $code .= "                if (is_file(\$filePath) && pathinfo(\$file, PATHINFO_EXTENSION) === 'php') {\n";
                $code .= "                    \$pageName = pathinfo(\$file, PATHINFO_FILENAME);\n";
                $code .= "                    \$pageTitle = ucwords(str_replace(['-', '_'], ' ', \$pageName));\n";
                $code .= "                    \$menuItems[] = ['text' => \$pageTitle, 'url' => \$pageName === 'home' ? '/' : '/?page=' . \$pageName];\n";
                $code .= "                } elseif (is_dir(\$filePath) && file_exists(\$filePath . '/index.php')) {\n";
                $code .= "                    \$pageTitle = ucwords(str_replace(['-', '_'], ' ', \$file));\n";
                $code .= "                    \$menuItems[] = ['text' => \$pageTitle, 'url' => '/?page=' . \$file];\n";
                $code .= "                }\n";
                $code .= "            }\n";
                $code .= "            usort(\$menuItems, function(\$a, \$b) {\n";
                $code .= "                if (\$a['url'] === '/') return -1;\n";
                $code .= "                if (\$b['url'] === '/') return 1;\n";
                $code .= "                return strcmp(\$a['text'], \$b['text']);\n";
                $code .= "            });\n";
                $code .= "        }\n";
                $code .= "        echo block_menu(\$menuItems, '{$orientation}', '{$menuShape}');\n";
            } else {
                $code .= "        echo block_menu([\n";
                foreach ($items as $item) {
                    $code .= "            [\n";
                    $code .= "                'text' => '" . addslashes($item['text'] ?? '') . "',\n";
                    $code .= "                'url' => '" . addslashes($item['url'] ?? '') . "',\n";
                    if ($showIcons && !empty($item['icon'])) {
                        $code .= "                'icon' => '" . addslashes($item['icon']) . "',\n";
                    }
                    $code .= "            ],\n";
                }
                $code .= "        ], '{$orientation}', '{$menuShape}');\n";
            }
            break;
            
        case 'button':
            $code .= "        echo block_button([\n";
            $code .= "            'text' => '" . addslashes($data['text'] ?? 'Click Me') . "',\n";
            $code .= "            'url' => '" . addslashes($data['url'] ?? '#') . "',\n";
            $code .= "            'type' => '" . addslashes($data['type'] ?? 'primary') . "',\n";
            $code .= "            'size' => '" . addslashes($data['size'] ?? 'medium') . "',\n";
            $code .= "            'icon' => '" . addslashes($data['icon'] ?? '') . "',\n";
            $code .= "            'alignment' => '" . addslashes($data['alignment'] ?? 'left') . "',\n";
            $code .= "            'class' => '" . addslashes($data['class'] ?? '') . "'\n";
            $code .= "        ]);\n";
            break;
            
        case 'container':
            $code .= "        echo block_container('Container content', '" . addslashes($data['class'] ?? '') . "', '', '" . addslashes($data['width'] ?? 'wide') . "');\n";
            break;
    }
    
    $code .= "        ?>\n";
    
    return $code;
}

/**
 * Send success response
 */
function sendSuccess($data = []) {
    echo json_encode(array_merge(['success' => true], $data));
    exit;
}

/**
 * Send error response
 */
function sendError($message) {
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}
