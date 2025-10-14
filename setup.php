<?php
/**
 * Database Setup Script
 * 
 * Run this file once to set up the initial database structure
 * Access: http://localhost:8000/setup.php
 */

// Load configuration
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/framework/framework-includes/class-db.php';

// Check if already set up
$setupComplete = false;
$errors = [];
$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setup'])) {
    try {
        $db = db();
        
        // Create posts table
        if (!$db->tableExists(DB_PREFIX . 'posts')) {
            $db->addTable(DB_PREFIX . 'posts', [
                'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
                'title' => 'VARCHAR(255) NOT NULL',
                'content' => 'TEXT',
                'status' => 'VARCHAR(20) DEFAULT "publish"',
                'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ]);
            $messages[] = "Created table: " . DB_PREFIX . "posts";
        }
        
        // Create pages table
        if (!$db->tableExists(DB_PREFIX . 'pages')) {
            $db->addTable(DB_PREFIX . 'pages', [
                'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
                'title' => 'VARCHAR(255) NOT NULL',
                'slug' => 'VARCHAR(255) UNIQUE NOT NULL',
                'content' => 'TEXT',
                'status' => 'VARCHAR(20) DEFAULT "publish"',
                'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ]);
            $messages[] = "Created table: " . DB_PREFIX . "pages";
        }
        
        // Create users table
        if (!$db->tableExists(DB_PREFIX . 'users')) {
            $db->addTable(DB_PREFIX . 'users', [
                'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
                'username' => 'VARCHAR(100) UNIQUE NOT NULL',
                'email' => 'VARCHAR(100) UNIQUE NOT NULL',
                'password' => 'VARCHAR(255) NOT NULL',
                'role' => 'VARCHAR(20) DEFAULT "user"',
                'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
            ]);
            $messages[] = "Created table: " . DB_PREFIX . "users";
        }
        
        $setupComplete = true;
        $messages[] = "Database setup completed successfully!";
        
    } catch (Exception $e) {
        $errors[] = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - WindSurf CMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f5f5f5;
            padding: 2rem;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        
        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        
        button:hover {
            background: #2980b9;
        }
        
        .btn-secondary {
            background: #95a5a6;
            margin-left: 0.5rem;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        ul {
            list-style: none;
            padding: 0;
        }
        
        li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        li:last-child {
            border-bottom: none;
        }
        
        .config-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        
        .config-info strong {
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>WindSurf CMS Database Setup</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="message error">
                <strong>Errors:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($messages)): ?>
            <div class="message success">
                <ul>
                    <?php foreach ($messages as $message): ?>
                        <li><?php echo htmlspecialchars($message); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (!$setupComplete): ?>
            <div class="message info">
                <p>This script will create the initial database tables for your WindSurf CMS installation.</p>
            </div>
            
            <div class="config-info">
                <p><strong>Database Host:</strong> <?php echo DB_HOST; ?></p>
                <p><strong>Database Name:</strong> <?php echo DB_NAME; ?></p>
                <p><strong>Table Prefix:</strong> <?php echo DB_PREFIX; ?></p>
            </div>
            
            <p style="margin-bottom: 1rem;">The following tables will be created:</p>
            <ul style="margin-bottom: 1.5rem;">
                <li><?php echo DB_PREFIX; ?>posts - For blog posts and content</li>
                <li><?php echo DB_PREFIX; ?>pages - For static pages</li>
                <li><?php echo DB_PREFIX; ?>users - For user management</li>
            </ul>
            
            <form method="POST">
                <button type="submit" name="setup">Run Setup</button>
                <a href="/" class="btn-secondary" style="display: inline-block; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px;">Cancel</a>
            </form>
        <?php else: ?>
            <div class="message success">
                <p><strong>Setup Complete!</strong></p>
                <p>Your database has been set up successfully. You can now start using WindSurf CMS.</p>
            </div>
            
            <a href="/" style="display: inline-block; margin-top: 1rem;">
                <button>Go to Homepage</button>
            </a>
            
            <p style="margin-top: 1rem; color: #666; font-size: 0.9rem;">
                <strong>Security Note:</strong> For security reasons, you should delete or rename this setup.php file after setup is complete.
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
