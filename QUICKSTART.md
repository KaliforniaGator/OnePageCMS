# Quick Start Guide

Get up and running with OnePage CMS in 2 minutes!

## Step 1: Configure Site

Edit `config.php` and update your site settings:

```php
define('SITE_TITLE', 'My Website');
define('SITE_DESCRIPTION', 'My awesome website');
```

## Step 2: Start Server

Run the PHP built-in server:

```bash
php -S localhost:8000
```

## Step 3: View Your Site

Open your browser and go to `http://localhost:8000`

That's it! You now have a working CMS.

## Optional: Enable Database

If you need database functionality:

1. Create a MySQL database
2. Edit `config.php` and uncomment the database settings:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'your_database_name');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```
3. Visit `http://localhost:8000/setup.php` to create initial tables

## Creating Your First Page

1. Create a new file in the `pages/` directory:

**pages/my-page.php**
```php
<article class="page-content">
    <h1>My First Page</h1>
    <p>Hello, World!</p>
</article>
```

2. Visit: `http://localhost:8000/?page=my-page`

## Adding Custom Styles

Edit `user-styles/main.css`:

```css
.site-header {
    background: #1a1a1a;
}

.my-custom-class {
    color: #ff6b6b;
}
```

## Adding Custom Scripts

Edit `user-scripts/main.js`:

```javascript
console.log('My site is ready!');

// Add your custom JavaScript here
```

## Working with Database (Optional)

**Note:** Only use this if you've enabled database in `config.php`

```php
<?php
// Get database instance
$db = db();

// Create a table
$db->addTable('products', [
    'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
    'name' => 'VARCHAR(100) NOT NULL',
    'price' => 'DECIMAL(10,2)'
]);

// Insert data
$productId = $db->insert('products', [
    'name' => 'Widget',
    'price' => 19.99
]);

// Query data
$products = $db->getResults("SELECT * FROM products");

// Display in your page
foreach ($products as $product) {
    echo "<p>" . htmlspecialchars($product['name']) . "</p>";
}
?>
```

## Project Structure

```
├── config.php              # Configuration
├── index.php               # Entry point
├── header.php              # Header template
├── body.php                # Body/routing template
├── footer.php              # Footer template
├── pages/                  # Your pages here
├── framework-styles/       # Framework CSS (don't edit)
├── framework-scripts/      # Framework JS (don't edit)
├── user-styles/           # Your custom CSS
└── user-scripts/          # Your custom JS
```

## Tips

- **Pages**: Add `.php` files to `pages/` directory
- **Subdirectories**: Create `pages/blog/index.php` for nested pages
- **Styles**: Use `user-styles/main.css` for custom styling
- **Scripts**: Use `user-scripts/main.js` for custom JavaScript
- **Database**: Optional - only needed if you want dynamic content
- **Framework Files**: Don't edit files in `framework-styles/` or `framework-scripts/`

## Need Help?

Check out the full `README.md` for detailed documentation!
