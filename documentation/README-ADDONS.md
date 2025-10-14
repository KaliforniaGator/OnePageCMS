# Addon System

The OnePageCMS addon system allows you to extend the framework with modular, self-contained features. Addons are automatically discovered and loaded based on their `entry.json` configuration file.

## Related Documentation

- **README-ENTRY-JSON.md** - Detailed documentation of all configuration options
- **This Document** - Quick reference and examples

## Directory Structure

All addons are placed in the `framework-addons/` directory:

```
framework-addons/
├── page-builder/
│   ├── entry.json          # Addon configuration
│   ├── page-builder.php    # Main page file
│   ├── page-builder.css    # Styles
│   ├── page-builder.js     # Scripts
│   └── page-builder-api.php # API endpoints
└── your-addon/
    ├── entry.json
    └── ...
```

## Creating an Addon

### 1. Create Addon Directory

Create a new directory in `framework-addons/` with your addon name (use lowercase and hyphens):

```
framework-addons/my-addon/
```

### 2. Create entry.json

The `entry.json` file tells the framework how to load your addon:

```json
{
  "name": "My Addon",
  "version": "1.0.0",
  "description": "Description of what your addon does",
  "author": "Your Name",
  "type": "page",
  "enabled": true,
  "load": {
    "page": {
      "file": "my-addon.php",
      "route": "my-addon",
      "title": "My Addon",
      "menu": {
        "show": true,
        "label": "My Addon",
        "icon": "fas fa-star",
        "position": 100
      }
    },
    "scripts": [
      {
        "file": "my-addon.js",
        "scope": "page-only",
        "defer": true
      }
    ],
    "styles": [
      {
        "file": "my-addon.css",
        "scope": "page-only"
      }
    ],
    "config": "config.php",
    "api": {
      "file": "api.php",
      "route": "my-addon-api"
    }
  },
  "dependencies": {
    "blocks": true,
    "font-awesome": true
  }
}
```

## entry.json Configuration Reference

### Root Properties

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | string | Yes | Display name of the addon |
| `version` | string | Yes | Version number (semver) |
| `description` | string | No | Brief description |
| `author` | string | No | Author name |
| `type` | string | Yes | Addon type: `page`, `config`, `global` |
| `enabled` | boolean | Yes | Whether the addon is active |

### Addon Types

- **`page`** - Adds a new page accessible via URL
- **`config`** - Loads configuration without a page
- **`global`** - Loads scripts/styles on every page

### Load Configuration

#### Page Loading (`load.page`)

For `type: "page"` addons:

```json
"page": {
  "file": "main.php",           // PHP file to load
  "route": "my-page",            // URL route (/?page=my-page)
  "title": "Page Title",         // Browser title
  "menu": {                      // Optional menu integration
    "show": true,                // Show in navigation
    "label": "Menu Label",       // Menu text
    "icon": "fas fa-icon",       // Font Awesome icon
    "position": 100              // Menu position (lower = earlier)
  }
}
```

#### Scripts Loading (`load.scripts`)

Array of JavaScript files to load:

```json
"scripts": [
  {
    "file": "script.js",         // JavaScript file path
    "scope": "page-only",        // When to load: "global" or "page-only"
    "defer": true,               // Add defer attribute
    "async": false               // Add async attribute
  }
]
```

**Scopes:**
- `global` - Loaded on every page
- `page-only` - Only loaded when the addon page is active

#### Styles Loading (`load.styles`)

Array of CSS files to load:

```json
"styles": [
  {
    "file": "styles.css",        // CSS file path
    "scope": "page-only"         // When to load: "global" or "page-only"
  }
]
```

#### Config Loading (`load.config`)

Load a PHP configuration file on every request:

```json
"config": "config.php"
```

This file is loaded early in the request lifecycle and can define constants, functions, or register hooks.

#### API Endpoints (`load.api`)

Define API endpoints for your addon:

```json
"api": {
  "file": "api.php",             // PHP file handling API requests
  "route": "my-api"              // Route name (accessible via addon loader)
}
```

### Dependencies

Declare what your addon needs:

```json
"dependencies": {
  "blocks": true,                // Requires blocks system
  "font-awesome": true,          // Requires Font Awesome
  "database": false              // Requires database
}
```

### Permissions

Define what your addon can do (for future permission system):

```json
"permissions": {
  "create_pages": true,
  "edit_pages": true,
  "delete_pages": true
}
```

## Addon Types Examples

### Page Addon

Creates a new accessible page:

```json
{
  "type": "page",
  "load": {
    "page": {
      "file": "dashboard.php",
      "route": "dashboard",
      "title": "Dashboard"
    }
  }
}
```

Access at: `/?page=dashboard`

### Global Script Addon

Loads JavaScript on every page:

```json
{
  "type": "global",
  "load": {
    "scripts": [
      {
        "file": "analytics.js",
        "scope": "global",
        "async": true
      }
    ]
  }
}
```

### Config Addon

Loads configuration without a page:

```json
{
  "type": "config",
  "load": {
    "config": "custom-functions.php"
  }
}
```

## PHP API

### Available Functions

```php
// Get addon loader instance
$loader = get_addon_loader();

// Get all addons
$addons = get_addons();

// Get specific addon
$addon = $loader->getAddon('page-builder');

// Get addon menu items
$menuItems = get_addon_menu_items();

// Check if addon page is being loaded
$isAddonPage = $loader->handleAddonPage($pageName);
```

### In Your Addon Files

Your addon PHP files have access to all framework functions:

```php
<?php
// page-builder.php

// You can use all block functions
echo block_button('Click Me', '#', 'primary');

// Set page metadata
set_page_meta([
    'title' => 'My Addon Page',
    'description' => 'Custom page'
]);

// Access configuration
$siteTitle = SITE_TITLE;

// Your addon code here
?>
```

## Asset Loading

### Automatic Loading

Assets are automatically loaded based on scope:

- **Global scope**: Loaded on every page
- **Page-only scope**: Only loaded when addon page is active

### Manual Loading

You can also manually include assets in your addon page:

```php
<?php
// In your addon page file
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/framework-addons/my-addon/custom.css">
</head>
<body>
    <!-- Your content -->
    <script src="/framework-addons/my-addon/custom.js"></script>
</body>
</html>
```

## Menu Integration

Addons can automatically add menu items:

```json
"menu": {
  "show": true,
  "label": "Page Builder",
  "icon": "fas fa-hammer",
  "position": 100
}
```

To display addon menu items in your navigation:

```php
<?php
$menuItems = get_addon_menu_items();
foreach ($menuItems as $item) {
    echo '<a href="' . $item['url'] . '">';
    if ($item['icon']) {
        echo '<i class="' . $item['icon'] . '"></i> ';
    }
    echo $item['label'] . '</a>';
}
?>
```

## API Endpoints

Addons can define API endpoints for AJAX requests:

### In entry.json:

```json
"api": {
  "file": "api.php",
  "route": "my-addon-api"
}
```

### In api.php:

```php
<?php
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getData':
        echo json_encode(['success' => true, 'data' => []]);
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
}
```

### Accessing from JavaScript:

```javascript
fetch('/framework-addons/my-addon/api.php?action=getData')
    .then(response => response.json())
    .then(data => console.log(data));
```

## Best Practices

### 1. Naming Conventions

- **Addon directory**: lowercase with hyphens (`page-builder`)
- **Files**: descriptive names (`page-builder.php`, `page-builder.css`)
- **Routes**: match directory name for consistency

### 2. File Organization

```
my-addon/
├── entry.json          # Configuration
├── my-addon.php        # Main page
├── my-addon.css        # Styles
├── my-addon.js         # Scripts
├── api.php             # API endpoints
├── config.php          # Configuration (if needed)
└── README.md           # Documentation
```

### 3. Scope Management

- Use `page-only` scope for addon-specific assets
- Use `global` scope only when truly needed on every page
- Keep global assets minimal to avoid performance impact

### 4. Security

- Sanitize all user input
- Validate file paths to prevent directory traversal
- Use prepared statements for database queries
- Escape output with `htmlspecialchars()`

### 5. Error Handling

```php
<?php
if (!defined('BASE_PATH')) {
    die('Direct access not permitted');
}

// Your addon code
```

## Example: Simple Dashboard Addon

### Directory Structure

```
framework-addons/dashboard/
├── entry.json
├── dashboard.php
├── dashboard.css
└── dashboard.js
```

### entry.json

```json
{
  "name": "Dashboard",
  "version": "1.0.0",
  "description": "Admin dashboard",
  "type": "page",
  "enabled": true,
  "load": {
    "page": {
      "file": "dashboard.php",
      "route": "dashboard",
      "title": "Dashboard",
      "menu": {
        "show": true,
        "label": "Dashboard",
        "icon": "fas fa-tachometer-alt",
        "position": 10
      }
    },
    "scripts": [
      {
        "file": "dashboard.js",
        "scope": "page-only",
        "defer": true
      }
    ],
    "styles": [
      {
        "file": "dashboard.css",
        "scope": "page-only"
      }
    ]
  }
}
```

### dashboard.php

```php
<?php
set_page_meta([
    'title' => 'Dashboard',
    'description' => 'Admin dashboard'
]);
?>

<div class="dashboard">
    <h1>Dashboard</h1>
    <p>Welcome to your dashboard!</p>
    
    <?php
    echo block_card([
        'title' => 'Statistics',
        'content' => 'Your stats here'
    ]);
    ?>
</div>
```

## Troubleshooting

### Addon Not Loading

1. Check `enabled: true` in entry.json
2. Verify JSON syntax is valid
3. Check file paths are correct
4. Ensure addon directory is in `framework-addons/`

### Assets Not Loading

1. Verify scope is set correctly (`global` or `page-only`)
2. Check file paths in entry.json
3. Ensure files exist in addon directory
4. Check browser console for 404 errors

### Menu Not Showing

1. Verify `menu.show: true` in entry.json
2. Check menu integration in your theme
3. Ensure `get_addon_menu_items()` is called

## Future Enhancements

Planned features for the addon system:

- Addon marketplace/repository
- Dependency management
- Version compatibility checking
- Automatic updates
- Addon settings UI
- Hook/filter system
- Event system
- Database migrations

## Support

For questions or issues with the addon system, refer to the main OnePageCMS documentation or create an issue in the repository.
