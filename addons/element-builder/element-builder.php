<?php
/**
 * Element Builder
 * Visual editor for header and footer elements
 */

// Set page metadata
set_page_meta([
    'title' => 'Element Builder - ' . SITE_TITLE,
    'description' => 'Visual builder for editing header and footer elements'
]);
?>
<link rel="stylesheet" href="/addons/element-builder/element-builder.css">
<div class="eb-body">
    <div class="eb-container">
        <!-- Toolbar -->
        <div class="eb-toolbar">
            <div class="eb-toolbar-left">
                <h1 class="eb-title">
                    <i class="fas fa-layer-group"></i> Element Builder
                </h1>
                <select id="eb-element-select" class="eb-select">
                    <option value="header">Header</option>
                    <option value="footer">Footer</option>
                </select>
            </div>
            
            <div class="eb-toolbar-right">
                <button id="eb-save-element" class="eb-btn eb-btn-primary" title="Save Element">
                    <i class="fas fa-save"></i> Save
                </button>
                <button id="eb-preview-element" class="eb-btn eb-btn-info" title="Preview Element">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <button id="eb-view-source" class="eb-btn eb-btn-warning" title="View Source Code">
                    <i class="fas fa-code"></i> Source
                </button>
                <button id="eb-reset-element" class="eb-btn eb-btn-danger" title="Reset to Default">
                    <i class="fas fa-undo"></i> Reset
                </button>
                <a href="/" class="eb-btn" style="background: #95a5a6; color: white; text-decoration: none;" title="Exit Element Builder">
                    <i class="fas fa-times"></i> Exit
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="eb-main">
            <!-- Sidebar with Blocks -->
            <div class="eb-sidebar">
                <h3 class="eb-sidebar-title">Blocks</h3>
                <div class="eb-blocks-list" id="eb-blocks-list">
                    <!-- Blocks will be populated by JavaScript -->
                </div>
                
                <h3 class="eb-sidebar-title">Element Settings</h3>
                <div class="eb-element-settings" id="eb-element-settings">
                    <!-- Element-level settings -->
                </div>
            </div>

            <!-- Canvas -->
            <div class="eb-canvas-wrapper">
                <div class="eb-canvas" id="eb-canvas">
                    <!-- Blocks will be dropped here -->
                </div>
            </div>

            <!-- Properties Panel -->
            <div class="eb-properties" id="eb-properties">
                <h3 class="eb-properties-title">Block Properties</h3>
                <div class="eb-properties-content" id="eb-properties-content">
                    <p class="eb-no-selection">Select a block to edit its properties</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="eb-preview-modal" class="eb-modal">
        <div class="eb-modal-content eb-modal-large">
            <div class="eb-modal-header">
                <h2>Preview</h2>
                <button class="eb-modal-close">&times;</button>
            </div>
            <div class="eb-modal-body">
                <iframe id="eb-preview-frame" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
        </div>
    </div>

    <!-- Source Code Modal -->
    <div id="eb-source-modal" class="eb-modal">
        <div class="eb-modal-content eb-modal-large">
            <div class="eb-modal-header">
                <h2>Source Code</h2>
                <button class="eb-modal-close">&times;</button>
            </div>
            <div class="eb-modal-body">
                <textarea id="eb-source-code" readonly style="width: 100%; height: 500px; font-family: monospace; padding: 1rem; border: 1px solid #ddd; border-radius: 4px;"></textarea>
            </div>
        </div>
    </div>

    <script src="/addons/element-builder/element-builder.js"></script>
</div>
