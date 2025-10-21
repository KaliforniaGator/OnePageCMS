<?php
/**
 * Page Builder - Visual Page Editor
 * Drag-and-drop interface for building pages
 */

// Get available blocks organized by category
$normalBlocks = [
    'container' => ['name' => 'Container', 'icon' => 'fas fa-box'],
    'textview' => ['name' => 'Text View', 'icon' => 'fas fa-align-left'],
    'button' => ['name' => 'Button', 'icon' => 'fas fa-hand-pointer'],
    'buttongroup' => ['name' => 'Button Group', 'icon' => 'fas fa-th-large'],
    'card' => ['name' => 'Card', 'icon' => 'fas fa-id-card'],
    'accordion' => ['name' => 'Accordion', 'icon' => 'fas fa-bars'],
    'alert' => ['name' => 'Alert', 'icon' => 'fas fa-exclamation-triangle'],
    'form' => ['name' => 'Form', 'icon' => 'fas fa-file-alt'],
    'hero' => ['name' => 'Hero', 'icon' => 'fas fa-star'],
    'slider' => ['name' => 'Slider', 'icon' => 'fas fa-images'],
    'menu' => ['name' => 'Menu', 'icon' => 'fas fa-bars'],
    'list' => ['name' => 'List', 'icon' => 'fas fa-list'],
    'media' => ['name' => 'Media', 'icon' => 'fas fa-image'],
    'social' => ['name' => 'Social', 'icon' => 'fas fa-share-alt'],
    'logo' => ['name' => 'Logo', 'icon' => 'fas fa-tag'],
    'markdown' => ['name' => 'Markdown', 'icon' => 'fab fa-markdown'],
    'codeblock' => ['name' => 'Codeblock', 'icon' => 'fas fa-code'],
    'anchor' => ['name' => 'Anchor', 'icon' => 'fas fa-anchor']
];

$formBlocks = [
    'checkbox' => ['name' => 'Checkbox', 'icon' => 'fas fa-check-square'],
    'inputfield' => ['name' => 'Input Field', 'icon' => 'fas fa-keyboard'],
    'radiobuttons' => ['name' => 'Radio Buttons', 'icon' => 'fas fa-dot-circle'],
    'datepicker' => ['name' => 'Date Picker', 'icon' => 'fas fa-calendar-alt'],
    'timepicker' => ['name' => 'Time Picker', 'icon' => 'fas fa-clock'],
    'datetimepicker' => ['name' => 'Date Time Picker', 'icon' => 'fas fa-calendar-check'],
    'fileupload' => ['name' => 'File Upload', 'icon' => 'fas fa-file-upload'],
    'passwordfield' => ['name' => 'Password Field', 'icon' => 'fas fa-lock'],
    'selectfield' => ['name' => 'Select Field', 'icon' => 'fas fa-caret-square-down'],
    'textareafield' => ['name' => 'Text Area', 'icon' => 'fas fa-paragraph'],
    'togglefield' => ['name' => 'Toggle', 'icon' => 'fas fa-toggle-on'],
    'clearbutton' => ['name' => 'Clear Button', 'icon' => 'fas fa-eraser'],
    'submitbutton' => ['name' => 'Submit Button', 'icon' => 'fas fa-paper-plane']
];

// Get existing pages
$pagesDir = PAGES_DIR;
$existingPages = [];
if (is_dir($pagesDir)) {
    $files = scandir($pagesDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && $file !== 'index.php') {
            $existingPages[] = pathinfo($file, PATHINFO_FILENAME);
        }
    }
}
?>
<div class="pb-wrapper">
    <!-- Top Menu Bar -->
    <div class="pb-menu-bar">
        <div class="pb-menu-left">
            <h1 class="pb-title">
                <i class="fas fa-hammer"></i> Page Builder
            </h1>
        </div>
        <div class="pb-menu-center">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label for="pb-page-select" style="font-size: 0.9rem; white-space: nowrap;">Current Page:</label>
                <select id="pb-page-select" class="pb-select">
                    <option value="">-- Select Page --</option>
                    <?php foreach ($existingPages as $page): ?>
                        <option value="<?php echo htmlspecialchars($page); ?>">
                            <?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $page))); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" id="pb-current-page-input" class="pb-input" placeholder="Page name" 
                       style="display: none; width: 200px; padding: 0.5rem; border: 1px solid #34495e; border-radius: 4px; background: #34495e; color: white;">
            </div>
        </div>
        <div class="pb-menu-right">
            <button id="pb-new-page" class="pb-btn pb-btn-primary" title="New Page">
                <i class="fas fa-file"></i> New
            </button>
            <button id="pb-save-page" class="pb-btn pb-btn-success" title="Save Page">
                <i class="fas fa-save"></i> Save
            </button>
            <button id="pb-preview-page" class="pb-btn pb-btn-info" title="Preview Page">
                <i class="fas fa-eye"></i> Preview
            </button>
            <button id="pb-view-source" class="pb-btn pb-btn-warning" title="View Source Code">
                <i class="fas fa-code"></i> Source
            </button>
            <button id="pb-delete-page" class="pb-btn pb-btn-danger" title="Delete Page">
                <i class="fas fa-trash"></i> Delete
            </button>
            <a href="/" class="pb-btn pb-btn-secondary" title="Exit Builder">
                <i class="fas fa-times"></i> Exit
            </a>
        </div>
    </div>

    <!-- Main Builder Area -->
    <div class="pb-container">
        <!-- Left Sidebar - Block Palette -->
        <div class="pb-sidebar">
            <div class="pb-sidebar-header">
                <h2>Blocks</h2>
                <p>Drag blocks to the canvas</p>
            </div>
            <div class="pb-blocks-list">
                <!-- Normal Blocks Section -->
                <div class="pb-blocks-section">
                    <div class="pb-section-header">
                        <i class="fas fa-cube"></i>
                        <span>Content Blocks</span>
                    </div>
                    <?php foreach ($normalBlocks as $blockType => $blockInfo): ?>
                        <div class="pb-block-item" draggable="true" data-block-type="<?php echo $blockType; ?>">
                            <i class="pb-block-icon <?php echo $blockInfo['icon']; ?>"></i>
                            <span class="pb-block-name"><?php echo $blockInfo['name']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Form Blocks Section -->
                <div class="pb-blocks-section">
                    <div class="pb-section-header">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Form Elements</span>
                    </div>
                    <?php foreach ($formBlocks as $blockType => $blockInfo): ?>
                        <div class="pb-block-item" draggable="true" data-block-type="<?php echo $blockType; ?>">
                            <i class="pb-block-icon <?php echo $blockInfo['icon']; ?>"></i>
                            <span class="pb-block-name"><?php echo $blockInfo['name']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Center Canvas - Page Preview -->
        <div class="pb-canvas-wrapper">
            <div class="pb-canvas-header">
                <h2>Page Canvas</h2>
                <div class="pb-canvas-info">
                    <span id="pb-current-page-name">Untitled Page</span>
                </div>
            </div>
            <div id="pb-canvas" class="pb-canvas">
                <div class="pb-canvas-placeholder">
                    <i class="fas fa-mouse-pointer"></i>
                    <p>Drag blocks here to start building your page</p>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Properties Panel -->
        <div class="pb-properties-sidebar" id="pb-properties-sidebar">
            <div class="pb-properties-header">
                <h2>Properties</h2>
                <button id="pb-close-properties" class="pb-properties-close" title="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="pb-editor-form" class="pb-properties-form">
                <div class="pb-properties-empty">
                    <i class="fas fa-mouse-pointer"></i>
                    <p>Select a block to edit its properties</p>
                </div>
            </div>
            <div class="pb-properties-footer">
                <button id="pb-save-block" class="pb-btn pb-btn-success pb-btn-block">
                    <i class="fas fa-check"></i> Apply Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="pb-preview-modal" class="pb-modal">
        <div class="pb-modal-content">
            <div class="pb-modal-header">
                <h2>Preview Page</h2>
                <button id="pb-close-preview" class="pb-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="pb-preview-controls">
                <button class="pb-preview-size-btn active" data-size="desktop">
                    <i class="fas fa-desktop"></i> Desktop
                </button>
                <button class="pb-preview-size-btn" data-size="tablet">
                    <i class="fas fa-tablet-alt"></i> Tablet
                </button>
                <button class="pb-preview-size-btn" data-size="mobile">
                    <i class="fas fa-mobile-alt"></i> Mobile
                </button>
            </div>
            <div class="pb-preview-frame-wrapper">
                <iframe id="pb-preview-frame" class="pb-preview-frame desktop"></iframe>
            </div>
        </div>
    </div>

    <!-- Source Code Modal -->
    <div id="pb-source-modal" class="pb-modal">
        <div class="pb-modal-content">
            <div class="pb-modal-header">
                <h2>View Source Code</h2>
                <button id="pb-close-source" class="pb-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="pb-modal-body">
                <textarea id="pb-source-code" class="pb-source-textarea" readonly></textarea>
            </div>
            <div class="pb-modal-footer">
                <button id="pb-copy-source" class="pb-btn pb-btn-success">
                    <i class="fas fa-copy"></i> Copy to Clipboard
                </button>
            </div>
        </div>
    </div>

    <!-- New Page Modal -->
    <div id="pb-new-page-modal" class="pb-modal">
        <div class="pb-modal-content pb-small-modal">
            <div class="pb-modal-header">
                <h2>Create New Page</h2>
                <button id="pb-close-new-page" class="pb-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="pb-modal-body">
                <label for="pb-new-page-name">Page Name:</label>
                <input type="text" id="pb-new-page-name" class="pb-input" placeholder="e.g., about, services, contact">
                <p class="pb-hint">Use lowercase letters, numbers, and hyphens only</p>
            </div>
            <div class="pb-modal-footer">
                <button id="pb-create-page" class="pb-btn pb-btn-success">
                    <i class="fas fa-plus"></i> Create Page
                </button>
                <button id="pb-cancel-new-page" class="pb-btn pb-btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
