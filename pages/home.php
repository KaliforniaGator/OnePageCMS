<?php
/**
 * Home Page
 */
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
    <p>To create a new page, simply add a PHP file to the <code>pages/</code> directory. For example:</p>
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
        <li>Adding custom styles to <code>user-styles/main.css</code></li>
        <li>Adding custom scripts to <code>user-scripts/main.js</code></li>
        <li>Modifying the templates in <code>header.php</code>, <code>body.php</code>, and <code>footer.php</code></li>
    </ul>
    
    <p><a href="/?page=about" class="btn">Learn More</a></p>
</article>
