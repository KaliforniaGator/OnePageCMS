<?php
/**
 * Theme Editor Page
 * Visual interface for editing theme.css
 */

// Set page metadata
set_page_meta([
    'title' => 'Theme Editor',
    'description' => 'Customize your site theme visually'
]);
?>

<article class="theme-editor-page">
    <div class="theme-editor-header">
        <h1><i class="fas fa-palette"></i> Theme Editor</h1>
        <p>Customize your site's theme by editing CSS variables. Changes are auto-saved.</p>
        <div class="theme-editor-status">
            <span id="save-status" class="status-indicator">
                <i class="fas fa-circle"></i> <span class="status-text">Ready</span>
            </span>
        </div>
    </div>

    <div class="theme-editor-container">
        <!-- Loading State -->
        <div id="loading-state" class="loading-state">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Loading theme properties...</p>
        </div>

        <!-- Error State -->
        <div id="error-state" class="error-state" style="display: none;">
            <i class="fas fa-exclamation-triangle"></i>
            <p id="error-message">Failed to load theme</p>
            <button onclick="location.reload()" class="btn btn-primary">Retry</button>
        </div>

        <!-- Editor Content -->
        <div id="editor-content" class="editor-content" style="display: none;">
            <!-- Search and Filter -->
            <div class="editor-toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-input" placeholder="Search properties..." />
                </div>
                <button id="reset-btn" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset All
                </button>
            </div>

            <!-- Categories -->
            <div id="categories-container" class="categories-container">
                <!-- Categories will be dynamically generated -->
            </div>
        </div>
    </div>
</article>

<script>
// Make API endpoint available to JavaScript
window.THEME_EDITOR_API = '/addons/theme-editor/theme-editor-api.php';
</script>

<script src="/addons/theme-editor/theme-editor.js"></script>
