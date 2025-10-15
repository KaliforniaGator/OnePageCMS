<?php
/**
 * Addon Manager Page
 * Interface for managing addons - enable/disable and configure settings
 */

// Define addons directory
$addonsDir = __DIR__ . '/../../addons';

// Handle POST requests for saving FIRST before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'toggle') {
        $addonId = $_POST['addon_id'];
        $enabled = $_POST['enabled'] === 'true';
        $entryFile = $addonsDir . '/' . $addonId . '/entry.json';
        
        if (file_exists($entryFile)) {
            $json = file_get_contents($entryFile);
            $config = json_decode($json, true);
            $config['enabled'] = $enabled;
            file_put_contents($entryFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Addon not found']);
        }
        exit;
    }
    
    if ($_POST['action'] === 'update_settings') {
        $addonId = $_POST['addon_id'];
        $settings = json_decode($_POST['settings'], true);
        $entryFile = $addonsDir . '/' . $addonId . '/entry.json';
        
        if (file_exists($entryFile)) {
            $json = file_get_contents($entryFile);
            $config = json_decode($json, true);
            $config['settings'] = $settings;
            file_put_contents($entryFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Addon not found']);
        }
        exit;
    }
}

// Set page metadata
set_page_meta([
    'title' => 'Addon Manager',
    'description' => 'Manage your site addons and their settings'
]);

// Load all addons
$addons = [];

if (is_dir($addonsDir)) {
    $dirs = scandir($addonsDir);
    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') continue;
        
        $addonPath = $addonsDir . '/' . $dir;
        $entryFile = $addonPath . '/entry.json';
        
        if (is_dir($addonPath) && file_exists($entryFile)) {
            $json = file_get_contents($entryFile);
            $config = json_decode($json, true);
            
            if ($config) {
                $config['id'] = $dir;
                if (!isset($config['enabled'])) {
                    $config['enabled'] = true;
                }
                $addons[] = $config;
            }
        }
    }
    
    // Sort by name
    usort($addons, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
}
?>

<article class="addon-manager-page">
    <div class="addon-manager-header">
        <h1><i class="fas fa-puzzle-piece"></i> Addon Manager</h1>
        <p>Enable or disable addons and configure their settings. Changes are saved automatically.</p>
        <div class="addon-manager-status">
            <span id="save-status" class="status-indicator">
                <i class="fas fa-circle"></i> <span class="status-text">Ready</span>
            </span>
        </div>
    </div>

    <div class="addon-manager-container">

        <!-- Manager Content -->
        <div id="manager-content" class="manager-content">
            <!-- Search and Filter -->
            <div class="manager-toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-input" placeholder="Search addons..." />
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <i class="fas fa-th"></i> All
                    </button>
                    <button class="filter-btn" data-filter="enabled">
                        <i class="fas fa-check-circle"></i> Enabled
                    </button>
                    <button class="filter-btn" data-filter="disabled">
                        <i class="fas fa-times-circle"></i> Disabled
                    </button>
                </div>
            </div>

            <!-- Addons Grid -->
            <div id="addons-container" class="addons-container">
                <!-- Addons will be dynamically generated -->
            </div>
        </div>
    </div>
</article>

<script>
// Pass addons data to JavaScript
window.ADDONS_DATA = <?php echo json_encode($addons); ?>;
</script>
