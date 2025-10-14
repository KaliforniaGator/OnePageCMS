<?php
/**
 * Addon Loader
 * Automatically discovers and loads addons from addons directory
 */

class AddonLoader {
    private $addonsDir;
    private $addons = [];
    private $loadedAddons = [];
    
    public function __construct($addonsDir = null) {
        $this->addonsDir = $addonsDir ?: BASE_PATH . '/addons';
    }
    
    /**
     * Discover all addons by scanning for entry.json files
     */
    public function discoverAddons() {
        if (!is_dir($this->addonsDir)) {
            return [];
        }
        
        $dirs = scandir($this->addonsDir);
        
        foreach ($dirs as $dir) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }
            
            $addonPath = $this->addonsDir . '/' . $dir;
            $entryFile = $addonPath . '/entry.json';
            
            if (is_dir($addonPath) && file_exists($entryFile)) {
                $this->loadAddonConfig($dir, $entryFile);
            }
        }
        
        return $this->addons;
    }
    
    /**
     * Load addon configuration from entry.json
     */
    private function loadAddonConfig($addonId, $entryFile) {
        $json = file_get_contents($entryFile);
        $config = json_decode($json, true);
        
        if (!$config) {
            error_log("Failed to parse entry.json for addon: {$addonId}");
            return;
        }
        
        // Check if addon is enabled
        if (isset($config['enabled']) && !$config['enabled']) {
            return;
        }
        
        $config['id'] = $addonId;
        $config['path'] = $this->addonsDir . '/' . $addonId;
        
        $this->addons[$addonId] = $config;
    }
    
    /**
     * Get all discovered addons
     */
    public function getAddons() {
        return $this->addons;
    }
    
    /**
     * Get a specific addon by ID
     */
    public function getAddon($addonId) {
        return isset($this->addons[$addonId]) ? $this->addons[$addonId] : null;
    }
    
    /**
     * Load global scripts (scripts that should be loaded on every page)
     */
    public function loadGlobalScripts() {
        $scripts = [];
        
        foreach ($this->addons as $addon) {
            if (isset($addon['load']['scripts'])) {
                foreach ($addon['load']['scripts'] as $script) {
                    if (isset($script['scope']) && $script['scope'] === 'global') {
                        $scripts[] = [
                            'addon' => $addon['id'],
                            'file' => $addon['path'] . '/' . $script['file'],
                            'url' => '/addons/' . $addon['id'] . '/' . $script['file'],
                            'defer' => isset($script['defer']) ? $script['defer'] : false,
                            'async' => isset($script['async']) ? $script['async'] : false
                        ];
                    }
                }
            }
        }
        
        return $scripts;
    }
    
    /**
     * Load global styles (styles that should be loaded on every page)
     */
    public function loadGlobalStyles() {
        $styles = [];
        
        foreach ($this->addons as $addon) {
            if (isset($addon['load']['styles'])) {
                foreach ($addon['load']['styles'] as $style) {
                    $scope = isset($style['scope']) ? $style['scope'] : 'global';
                    
                    if ($scope === 'global') {
                        $styles[] = '/addons/' . $addon['id'] . '/' . $style['file'];
                    }
                }
            }
        }
        
        return $styles;
    }
    
    /**
     * Load global config files
     */
    public function loadGlobalConfigs() {
        foreach ($this->addons as $addon) {
            if (isset($addon['load']['config'])) {
                $configFile = $addon['path'] . '/' . $addon['load']['config'];
                if (file_exists($configFile)) {
                    require_once $configFile;
                    $this->loadedAddons[] = $addon['id'];
                }
            }
        }
    }
    
    /**
     * Get addons that provide pages
     */
    public function getPageAddons() {
        $pageAddons = [];
        
        foreach ($this->addons as $addon) {
            if (isset($addon['type']) && $addon['type'] === 'page' && isset($addon['load']['page'])) {
                $pageAddons[$addon['id']] = $addon;
            }
        }
        
        return $pageAddons;
    }
    
    /**
     * Get menu items from addons
     */
    public function getAddonMenuItems() {
        $menuItems = [];
        
        foreach ($this->addons as $addon) {
            if (isset($addon['load']['page']['menu']) && $addon['load']['page']['menu']['show']) {
                $menu = $addon['load']['page']['menu'];
                $route = isset($addon['load']['page']['route']) ? $addon['load']['page']['route'] : $addon['id'];
                
                $menuItems[] = [
                    'addon' => $addon['id'],
                    'label' => $menu['label'],
                    'icon' => isset($menu['icon']) ? $menu['icon'] : '',
                    'url' => '/?page=' . $route,
                    'position' => isset($menu['position']) ? $menu['position'] : 999
                ];
            }
        }
        
        // Sort by position
        usort($menuItems, function($a, $b) {
            return $a['position'] - $b['position'];
        });
        
        return $menuItems;
    }
    
    /**
     * Check if current request is for an addon page
     */
    public function handleAddonPage($requestedPage) {
        foreach ($this->addons as $addon) {
            if (isset($addon['load']['page'])) {
                $route = isset($addon['load']['page']['route']) ? $addon['load']['page']['route'] : $addon['id'];
                
                if ($requestedPage === $route) {
                    $pageFile = $addon['path'] . '/' . $addon['load']['page']['file'];
                    
                    if (file_exists($pageFile)) {
                        // Set page title if specified
                        if (isset($addon['load']['page']['title'])) {
                            if (function_exists('set_page_meta')) {
                                set_page_meta(['title' => $addon['load']['page']['title']]);
                            }
                        }
                        
                        // Include the addon page
                        include $pageFile;
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
    
    
    /**
     * Get addon API routes
     */
    public function getApiRoutes() {
        $routes = [];
        
        foreach ($this->addons as $addon) {
            if (isset($addon['load']['api'])) {
                $route = isset($addon['load']['api']['route']) ? $addon['load']['api']['route'] : $addon['id'] . '-api';
                $routes[$route] = $addon['path'] . '/' . $addon['load']['api']['file'];
            }
        }
        
        return $routes;
    }
}

// Initialize global addon loader
$GLOBALS['addonLoader'] = new AddonLoader();
$GLOBALS['addonLoader']->discoverAddons();

/**
 * Helper function to get addon loader instance
 */
function get_addon_loader() {
    return $GLOBALS['addonLoader'];
}

/**
 * Helper function to get all addons
 */
function get_addons() {
    return $GLOBALS['addonLoader']->getAddons();
}

/**
 * Helper function to get addon menu items
 */
function get_addon_menu_items() {
    return $GLOBALS['addonLoader']->getAddonMenuItems();
}

/**
 * Get all addon page routes (for JavaScript to identify addon links)
 */
function get_addon_routes() {
    $addonLoader = get_addon_loader();
    $addons = $addonLoader->getAddons();
    $routes = [];
    
    foreach ($addons as $addon) {
        if (isset($addon['load']['page'])) {
            $route = isset($addon['load']['page']['route']) ? $addon['load']['page']['route'] : $addon['id'];
            $routes[] = $route;
        }
    }
    
    return $routes;
}
