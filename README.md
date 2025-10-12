# OnePage CMS

A lightweight, flexible content management framework built with PHP.

## Features

- **Simple Page Routing**: Create pages by adding PHP files to the `pages/` directory
- **Optional Database**: Works great for static sites - database is completely optional
- **Asset Separation**: Framework assets separate from user customizations
- **Template System**: Clean header, body, and footer templates
- **Security**: Built-in protection with prepared statements and input sanitization
- **No Forced Dependencies**: Use only what you need

## Directory Structure

```
windsurf-project/
├── config.php                 # Configuration file (database, site settings)
├── index.php                  # Universal entry point
├── header.php                 # Header template
├── body.php                   # Body template (handles page routing)
├── footer.php                 # Footer template
├── includes/
│   └── class-db.php          # Database class
├── pages/                     # User pages directory
│   ├── home.php              # Home page
│   ├── about.php             # About page
│   ├── contact.php           # Contact page
│   └── blog/                 # Example subdirectory
│       └── index.php         # Blog index
├── framework-styles/          # Framework CSS files
│   ├── reset.css             # CSS reset
│   └── layout.css            # Layout styles
├── framework-scripts/         # Framework JavaScript files
│   └── core.js               # Core JavaScript
├── user-styles/               # User custom CSS
│   └── main.css              # User stylesheet
└── user-scripts/              # User custom JavaScript
    └── main.js               # User scripts
```

## Installation

1. **Configure Site Settings**: Edit `config.php` and update your site information:
   ```php
   define('SITE_TITLE', 'My Website');
   define('SITE_DESCRIPTION', 'My awesome website');
   ```

2. **Optional - Configure Database**: If you need database functionality, uncomment and configure the database settings in `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'your_database_name');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

3. **Start PHP Server**: Run the built-in PHP server:
   ```bash
   php -S localhost:8000
   ```

4. **Visit Your Site**: Open your browser and navigate to `http://localhost:8000`

## Creating Pages

### Simple Page

Create a file in the `pages/` directory:

**pages/services.php**
```php
<article class="page-content">
    <h1>Our Services</h1>
    <p>This is the services page.</p>
</article>
```

Access it at: `http://localhost:8000/?page=services`

### Page in Subdirectory

Create a directory with an `index.php` file:

**pages/portfolio/index.php**
```php
<article class="page-content">
    <h1>Portfolio</h1>
    <p>This is the portfolio page.</p>
</article>
```

Access it at: `http://localhost:8000/?page=portfolio`

## Database Operations (Optional)

**Note:** Database functionality is completely optional. OnePage CMS works perfectly for static sites without any database configuration.

To use database features, first uncomment the database settings in `config.php`, then:

### Get Database Instance

```php
$db = db();
```

### Create a Table

```php
$db->addTable('users', [
    'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
    'name' => 'VARCHAR(100) NOT NULL',
    'email' => 'VARCHAR(100) UNIQUE NOT NULL',
    'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
]);
```

### Insert Data

```php
$userId = $db->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);
```

### Query Data

```php
// Get all rows
$users = $db->getResults("SELECT * FROM users");

// Get single row
$user = $db->getRow("SELECT * FROM users WHERE id = ?", [1]);

// Get single value
$count = $db->getVar("SELECT COUNT(*) FROM users");
```

### Update Data

```php
$db->update('users', 
    ['name' => 'Jane Doe'],  // Data to update
    ['id' => 1]              // Where condition
);
```

### Delete Data

```php
$db->delete('users', ['id' => 1]);
```

### Drop a Table

```php
$db->removeTable('users');
```

### Update Table Structure

```php
$db->updateTable('users', 'phone', 'VARCHAR(20)');
```

## Customization

### Custom Styles

Add your custom CSS to `user-styles/main.css`:

```css
.site-header {
    background: #1a1a1a;
}

.custom-button {
    background: #ff6b6b;
    color: white;
    padding: 1rem 2rem;
}
```

### Custom Scripts

Add your custom JavaScript to `user-scripts/main.js`:

```javascript
document.addEventListener('DOMContentLoaded', function() {
    console.log('My custom script loaded!');
    
    // Your custom code here
});
```

### Modify Templates

- **header.php**: Customize the site header and navigation
- **footer.php**: Customize the site footer
- **body.php**: Modify page routing logic (advanced)

## Configuration Options

Edit `config.php` to customize:

- **Database settings**: Host, name, user, password
- **Site settings**: Title, description, URL
- **Debug mode**: Enable/disable error reporting
- **Table prefix**: For multi-site installations

## Security Features

- **Prepared Statements**: All database queries use PDO prepared statements
- **Input Sanitization**: Page parameters are sanitized to prevent directory traversal
- **XSS Protection**: Use `htmlspecialchars()` when outputting user data
- **CSRF Protection**: Implement tokens in forms (recommended)

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB)
- PDO extension enabled

## License

Free to use and modify for personal and commercial projects.

## Support

For questions or issues, please refer to the documentation or create an issue in the repository.
