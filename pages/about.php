<?php
/**
 * About Page
 */

// Set page metadata
set_page_meta([
    'title' => 'About Us',
    'description' => 'Learn about OnePage CMS - a lightweight, flexible content management framework designed for developers.',
    'url' => SITE_URL . '/?page=about',
    'type' => 'website'
]);
?>
<article class="page-content">
    <h1>About OnePage CMS</h1>
    
    <p>OnePage CMS is a lightweight, flexible content management framework designed for developers who want full control over their website structure while maintaining simplicity and ease of use.</p>
    
    <h2>Philosophy</h2>
    <p>Our framework is built on the following principles:</p>
    <ul>
        <li><strong>Simplicity:</strong> Keep things simple and easy to understand</li>
        <li><strong>Flexibility:</strong> Allow developers to customize everything</li>
        <li><strong>No Forced Dependencies:</strong> Database is optional - use only what you need</li>
        <li><strong>Separation of Concerns:</strong> Framework code stays separate from user code</li>
        <li><strong>Security:</strong> Built-in protection against common vulnerabilities</li>
    </ul>
    
    <h2>Architecture</h2>
    <p>The framework follows a simple architecture:</p>
    <ul>
        <li><code>index.php</code> - Universal entry point that loads header, body, and footer</li>
        <li><code>body.php</code> - Handles page routing and loads content from the pages directory</li>
        <li><code>pages/</code> - Directory containing all your page files</li>
        <li><code>framework-styles/</code> - Core CSS files for the framework</li>
        <li><code>framework-scripts/</code> - Core JavaScript files for the framework</li>
        <li><code>user-styles/</code> - Your custom CSS files</li>
        <li><code>user-scripts/</code> - Your custom JavaScript files</li>
    </ul>
    
    <h2>Database Layer</h2>
    <p>The database class provides a clean abstraction over PDO, making it easy to perform common database operations without writing repetitive SQL code.</p>
    
    <h2>Example Usage</h2>
    <pre><code>&lt;?php
// Get database instance
$db = db();

// Create a table
$db->addTable('users', [
    'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
    'name' => 'VARCHAR(100) NOT NULL',
    'email' => 'VARCHAR(100) UNIQUE NOT NULL',
    'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
]);

// Insert a user
$userId = $db->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Get all users
$users = $db->getResults("SELECT * FROM users");

// Update a user
$db->update('users', 
    ['name' => 'Jane Doe'], 
    ['id' => $userId]
);
?&gt;</code></pre>
    
    <p><a href="/" class="btn">Back to Home</a></p>
</article>
