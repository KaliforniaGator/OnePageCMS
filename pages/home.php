<?php
/**
 * Home Page
 */

// Set page metadata
set_page_meta([
    'title' => 'Home',
    'description' => SITE_DESCRIPTION,
    'url' => SITE_URL,
    'type' => 'website'
]);
?>
<article class="page-content">
    <h1>Welcome to OnePage CMS</h1>
    
    <p>This is a lightweight, flexible content management framework built with PHP. It provides a simple way to create static or dynamic websites without the complexity of traditional CMS platforms.</p>
    
    <h2>Features</h2>
    <ul>
        <li>Simple page-based routing system</li>
        <li>Optional database support - works great for static sites too!</li>
        <li>Clean separation of framework and user code</li>
        <li>Easy to customize templates (header, body, footer)</li>
        <li>Modern, responsive design</li>
        <li>No forced dependencies - use only what you need</li>
    </ul>
    
    <h2>Getting Started</h2>
    
    <h3>Visual Page Builder</h3>
    <p>Create pages visually with our drag-and-drop page builder - no coding required!</p>
    <p>
        <a href="/?page=page-builder" class="btn btn-primary">
            <i class="fas fa-hammer"></i> Open Page Builder
        </a>
    </p>

    <h3>Element Builder</h3>
    <p>Build and edit header and footer elements visually with our drag-and-drop element builder - no coding required!</p>
    <p>
        <a href="/?page=element-builder" class="btn btn-primary">
            <i class="fas fa-layer-group"></i> Open Element Builder
        </a>
    </p>
    
    <h3>Theme Editor</h3>
    <p>Customize your site's theme visually by editing colors, typography, spacing, and more!</p>
    <p>
        <a href="/?page=theme-editor" class="btn btn-primary" data-no-ajax>
            <i class="fas fa-palette"></i> Open Theme Editor
        </a>
    </p>

    <h3>Addon Manager</h3>
    <p>Manage your addons in one place!</p>
    <p>
        <a href="/?page=addon-manager" class="btn btn-primary" data-no-ajax>
            <i class="fas fa-gear"></i> Addon Manager
        </a>
    </p>
    
    <h3>Manual Page Creation</h3>
    <p>Or add pages manually by creating PHP files in the <code>pages/</code> directory:</p>
    <ul>
        <li><code>pages/about.php</code> - accessible at <code>/?page=about</code></li>
        <li><code>pages/contact.php</code> - accessible at <code>/?page=contact</code></li>
        <li><code>pages/blog/index.php</code> - accessible at <code>/?page=blog</code></li>
    </ul>
    
    <h2>Database Operations (Optional)</h2>
    <p>If you need database functionality, simply uncomment the database settings in <code>config.php</code>. The framework includes a powerful database class:</p>
    <ul>
        <li><code>db()->query($sql, $params)</code> - Execute a query</li>
        <li><code>db()->addTable($name, $columns)</code> - Create a new table</li>
        <li><code>db()->removeTable($name)</code> - Drop a table</li>
        <li><code>db()->insert($table, $data)</code> - Insert data</li>
        <li><code>db()->update($table, $data, $where)</code> - Update data</li>
        <li><code>db()->delete($table, $where)</code> - Delete data</li>
    </ul>
    <p><strong>Note:</strong> Database is completely optional - OnePage CMS works great for static sites!</p>
    
    <h2>Customization</h2>
    <p>You can customize the look and feel of your site by:</p>
    <ul>
        <li>Editing theme colors and styles in <code>styles/theme.css</code></li>
        <li>Adding custom styles to <code>styles/main.css</code></li>
        <li>Adding custom scripts to <code>scripts/main.js</code></li>
        <li>Modifying header and footer in <code>elements/</code> directory</li>
        <li>Adding pages in the <code>pages/</code> directory</li>
    </ul>
    
    <h2>Explore Components</h2>
    <p>OnePage CMS comes with a comprehensive blocks system featuring buttons, forms, menus, heroes, sliders, and more!</p>
    
    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
        <a href="/?page=about" class="btn btn-primary">Learn More</a>
        <a href="/?page=blocks" class="btn btn-outline" data-no-ajax>View All Blocks</a>
    </div>
</article>
