<?php
/**
 * Codeblock Block
 * Embeds HTML, CSS, JS, or Actions into the page
 * 
 * @param array $config - Codeblock configuration
 *   - type: Type of code - 'html', 'css', 'js', 'action' (required)
 *   - content: The code content (required)
 *   - trigger_object: CSS selector for trigger element (for action type)
 *   - alert_object: Alert ID to trigger (for action type)
 *   - id: Custom ID for the codeblock (optional)
 *   - class: Additional CSS classes (optional)
 */

function block_codeblock($config) {
    $type = $config['type'] ?? 'html';
    $content = $config['content'] ?? '';
    $triggerObject = $config['trigger_object'] ?? '';
    $alertObject = $config['alert_object'] ?? '';
    $id = $config['id'] ?? 'codeblock-' . uniqid();
    $class = $config['class'] ?? '';
    
    if (empty($content) && $type !== 'action') {
        return '';
    }
    
    $html = '';
    
    switch ($type) {
        case 'html':
            // Render HTML directly
            $html = "<div id=\"$id\" class=\"block-codeblock codeblock-html $class\">";
            $html .= $content;
            $html .= "</div>";
            break;
            
        case 'css':
            // Inject CSS into a style tag
            $html = "<style id=\"$id\" class=\"block-codeblock codeblock-css $class\">";
            $html .= "\n" . $content . "\n";
            $html .= "</style>";
            break;
            
        case 'js':
            // Inject JavaScript into a script tag
            $html = "<script id=\"$id\" class=\"block-codeblock codeblock-js $class\">";
            $html .= "\n" . $content . "\n";
            $html .= "</script>";
            break;
            
        case 'action':
            // Create action to trigger alert
            if (empty($triggerObject) || empty($alertObject)) {
                return '<!-- Codeblock Action: Missing trigger_object or alert_object -->';
            }
            
            // Smart selector: add # if it looks like an ID, . if it looks like a class
            $selector = $triggerObject;
            if (!preg_match('/^[#.\[]/', $selector)) {
                // No prefix - assume it's an ID and add #
                $selector = '#' . $selector;
            }
            
            $html = "<script id=\"$id\" class=\"block-codeblock codeblock-action $class\">";
            $html .= "\n(function() {\n";
            $html .= "    // Wait for DOM to be ready\n";
            $html .= "    if (document.readyState === 'loading') {\n";
            $html .= "        document.addEventListener('DOMContentLoaded', initAction);\n";
            $html .= "    } else {\n";
            $html .= "        initAction();\n";
            $html .= "    }\n";
            $html .= "    \n";
            $html .= "    function initAction() {\n";
            $html .= "        var triggerElement = document.querySelector('" . addslashes($selector) . "');\n";
            $html .= "        var alertElement = document.getElementById('" . addslashes($alertObject) . "');\n";
            $html .= "        \n";
            $html .= "        if (!triggerElement) {\n";
            $html .= "            console.warn('Codeblock Action: Trigger element not found: " . addslashes($selector) . "');\n";
            $html .= "            return;\n";
            $html .= "        }\n";
            $html .= "        \n";
            $html .= "        if (!alertElement) {\n";
            $html .= "            console.warn('Codeblock Action: Alert element not found: " . addslashes($alertObject) . "');\n";
            $html .= "            return;\n";
            $html .= "        }\n";
            $html .= "        \n";
            $html .= "        // Add click event listener to trigger element\n";
            $html .= "        triggerElement.addEventListener('click', function(e) {\n";
            $html .= "            e.preventDefault();\n";
            $html .= "            \n";
            $html .= "            // Show the alert by removing hidden class\n";
            $html .= "            alertElement.classList.remove('hidden');\n";
            $html .= "            \n";
            $html .= "            // Add animation class if it's a toast or popup\n";
            $html .= "            if (alertElement.classList.contains('alert-style-toast') || \n";
            $html .= "                alertElement.classList.contains('alert-style-popup')) {\n";
            $html .= "                alertElement.style.display = 'block';\n";
            $html .= "            }\n";
            $html .= "        });\n";
            $html .= "    }\n";
            $html .= "})();\n";
            $html .= "</script>";
            break;
            
        default:
            return '<!-- Codeblock: Invalid type -->';
    }
    
    return $html;
}
?>
