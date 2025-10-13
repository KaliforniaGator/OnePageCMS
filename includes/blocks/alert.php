<?php
/**
 * Alert Block
 * Creates alerts with various types and styles
 * 
 * @param array $config - Alert configuration
 *   - message: Alert message content (required)
 *   - type: Alert type - 'info', 'success', 'warning', 'error' (default: 'info')
 *   - style: Alert style - 'inline', 'banner', 'toast', 'popup' (default: 'inline')
 *   - dismissible: Whether alert can be dismissed (default: true)
 *   - icon: Icon class (optional)
 *   - title: Alert title (optional)
 *   - duration: Auto-dismiss duration in ms for toast (default: 5000, 0 = no auto-dismiss)
 *   - position: Position for toast/popup - 'top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center' (default: 'top-right')
 *   - id: Custom ID for the alert (optional)
 *   - class: Additional CSS classes (optional)
 */

function block_alert($config) {
    $message = $config['message'] ?? '';
    $type = $config['type'] ?? 'info';
    $style = $config['style'] ?? 'inline';
    $dismissible = $config['dismissible'] ?? true;
    $icon = $config['icon'] ?? getDefaultIcon($type);
    $title = $config['title'] ?? '';
    $duration = $config['duration'] ?? 5000;
    $position = $config['position'] ?? 'top-right';
    $id = $config['id'] ?? 'alert-' . uniqid();
    $class = $config['class'] ?? '';
    
    if (empty($message)) {
        return '';
    }
    
    $alertClasses = "block-alert alert-$type alert-style-$style";
    
    if ($style === 'toast' || $style === 'popup') {
        $alertClasses .= " alert-position-$position";
    }
    
    if ($class) {
        $alertClasses .= " $class";
    }
    
    $html = "<div id=\"$id\" class=\"$alertClasses\" role=\"alert\"";
    
    if ($style === 'toast' && $duration > 0) {
        $html .= " data-duration=\"$duration\"";
    }
    
    $html .= ">";
    
    // Alert content wrapper
    $html .= "<div class=\"alert-content\">";
    
    // Icon
    if ($icon) {
        $html .= "<div class=\"alert-icon\"><i class=\"$icon\"></i></div>";
    }
    
    // Message wrapper
    $html .= "<div class=\"alert-message\">";
    
    if ($title) {
        $html .= "<div class=\"alert-title\">$title</div>";
    }
    
    $html .= "<div class=\"alert-text\">$message</div>";
    $html .= "</div>"; // .alert-message
    
    // Dismiss button
    if ($dismissible) {
        $html .= "<button class=\"alert-close\" onclick=\"dismissAlert('$id')\" aria-label=\"Close\">";
        $html .= "<i class=\"fas fa-times\"></i>";
        $html .= "</button>";
    }
    
    $html .= "</div>"; // .alert-content
    $html .= "</div>"; // .block-alert
    
    // Add inline script for toast auto-dismiss
    if ($style === 'toast' && $duration > 0) {
        $html .= "<script>
            setTimeout(function() {
                dismissAlert('$id');
            }, $duration);
        </script>";
    }
    
    return $html;
}

/**
 * Get default icon based on alert type
 */
function getDefaultIcon($type) {
    $icons = [
        'info' => 'fas fa-info-circle',
        'success' => 'fas fa-check-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'error' => 'fas fa-exclamation-circle'
    ];
    
    return $icons[$type] ?? 'fas fa-info-circle';
}

/**
 * Helper function to show alert with JavaScript
 * Generates JavaScript code to create and show an alert
 */
function block_alert_js($config) {
    $config['id'] = $config['id'] ?? 'alert-' . uniqid();
    $alertHtml = block_alert($config);
    $escapedHtml = addslashes(str_replace(["\n", "\r"], '', $alertHtml));
    
    return "<script>
        (function() {
            var alertHtml = '$escapedHtml';
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = alertHtml;
            var alertElement = tempDiv.firstChild;
            document.body.appendChild(alertElement);
        })();
    </script>";
}
?>
