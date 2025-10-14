# Entry.json Reference Guide

The `entry.json` file is the configuration heart of every addon. It defines metadata, loading behavior, dependencies, and custom settings.

## Table of Contents

- [File Location](#file-location)
- [Complete Structure](#complete-structure)
- [Core Properties](#core-properties)
- [Load Configuration](#load-configuration)
- [Additional Properties](#additional-properties)
- [Common Patterns](#common-patterns)
- [Best Practices](#best-practices)
- [Validation](#validation)
- [Next Steps](#next-steps)

## File Location

```
addons/
  └── your-addon/
      └── entry.json
```

## Complete Structure

```json
{
  "name": "Addon Name",
  "version": "1.0.0",
  "description": "Brief description of what this addon does",
  "author": "Your Name",
  "type": "page|utility|feature",
  "enabled": true,
  "load": {
    "config": "config.php",
    "page": {
      "file": "page.php",
      "route": "custom-route",
      "title": "Page Title",
      "menu": {
        "show": true,
        "label": "Menu Label",
        "icon": "fas fa-icon",
        "position": 100
      }
    },
    "scripts": [
      {
        "file": "script.js",
        "scope": "global|page-only",
        "defer": true,
        "async": false
      }
    ],
    "styles": [
      {
        "file": "styles.css",
        "scope": "global|page-only"
      }
    ],
    "api": {
      "file": "api.php",
      "route": "api-route"
    }
  },
  "dependencies": {
    "blocks": true,
    "font-awesome": true
  },
  "permissions": {
    "create_pages": true,
    "edit_pages": true
  },
  "settings": {
    "customKey": "customValue"
  }
}
```

---

## Core Properties

### `name` (required)
**Type:** `string`

The display name of your addon.

```json
"name": "Page Builder"
```

### `version` (required)
**Type:** `string`

Semantic version number (e.g., "1.0.0", "2.1.3").

```json
"version": "1.0.0"
```

### `description` (optional)
**Type:** `string`

Brief description of what the addon does.

```json
"description": "Visual drag-and-drop page builder"
```

### `author` (optional)
**Type:** `string`

Name of the addon creator or organization.

```json
"author": "OnePageCMS"
```

### `type` (optional)
**Type:** `string`

Category of addon. Common types:
- `page` - Adds a new page/route
- `utility` - Background functionality (analytics, banners, etc.)
- `feature` - Extends existing functionality
- `integration` - Third-party service integration

```json
"type": "utility"
```

### `enabled` (required)
**Type:** `boolean`

Controls whether the addon is active. Set to `false` to disable without deleting.

```json
"enabled": true
```

**Important:** This is the primary on/off switch for your addon!

---

## Load Configuration

The `load` object defines what files to load and when.

### `config`
**Type:** `string`

Path to a PHP configuration file that runs on every page load (when addon is enabled).

```json
"config": "config.php"
```

**Use for:**
- Defining helper functions
- Setting up hooks
- Exposing data to JavaScript via `$GLOBALS['addon_data']`

**Example config.php:**
```php
<?php
// Make settings available to JavaScript
$addonLoader = get_addon_loader();
$addon = $addonLoader->getAddon('your-addon');

$GLOBALS['addon_data']['your-addon'] = [
    'apiKey' => $addon['settings']['apiKey'] ?? ''
];
```

### `page`
**Type:** `object`

Defines a custom page/route for your addon.

```json
"page": {
  "file": "page-builder.php",
  "route": "page-builder",
  "title": "Page Builder",
  "menu": {
    "show": true,
    "label": "Page Builder",
    "icon": "fas fa-hammer",
    "position": 100
  }
}
```

**Properties:**
- **`file`** (required) - PHP file to load for this page
- **`route`** (optional) - URL parameter (defaults to addon ID)
  - Accessed via `?page=route-name`
- **`title`** (optional) - Page title for `<title>` tag
- **`menu`** (optional) - Navigation menu configuration
  - **`show`** - Display in navigation menu
  - **`label`** - Text to display in menu
  - **`icon`** - Font Awesome icon class
  - **`position`** - Sort order (lower = higher in menu)

### `scripts`
**Type:** `array`

JavaScript files to load.

```json
"scripts": [
  {
    "file": "analytics.js",
    "scope": "global",
    "defer": true,
    "async": false
  }
]
```

**Properties:**
- **`file`** (required) - Path to JavaScript file
- **`scope`** (optional, default: "global")
  - `"global"` - Loads on every page
  - `"page-only"` - Only loads when addon's page is active
- **`defer`** (optional, default: false) - Add `defer` attribute
- **`async`** (optional, default: false) - Add `async` attribute

**Scope Examples:**
```json
// Global - for analytics, chat widgets, site-wide features
{
  "file": "tracker.js",
  "scope": "global"
}

// Page-only - for page-specific functionality
{
  "file": "editor.js",
  "scope": "page-only"
}
```

### `styles`
**Type:** `array`

CSS files to load.

```json
"styles": [
  {
    "file": "banner.css",
    "scope": "global"
  }
]
```

**Properties:**
- **`file`** (required) - Path to CSS file
- **`scope`** (optional, default: "global")
  - `"global"` - Loads on every page
  - `"page-only"` - Only loads when addon's page is active

### `api`
**Type:** `object`

Defines an API endpoint for your addon.

```json
"api": {
  "file": "api.php",
  "route": "page-builder-api"
}
```

**Properties:**
- **`file`** (required) - PHP file to handle API requests
- **`route`** (optional) - API route name (defaults to `{addon-id}-api`)
  - Accessed via `?page=route-name`

---

## Additional Properties

### `dependencies`
**Type:** `object`

Declare dependencies on system features or other addons.

```json
"dependencies": {
  "blocks": true,
  "font-awesome": true
}
```

**Note:** Currently informational - future versions may enforce dependencies.

### `permissions`
**Type:** `object`

Declare what permissions this addon requires.

```json
"permissions": {
  "create_pages": true,
  "edit_pages": true,
  "delete_pages": true
}
```

**Note:** Currently informational - useful for documentation and future permission systems.

### `settings`
**Type:** `object`

Custom configuration specific to your addon. Can contain any data structure.

```json
"settings": {
  "apiKey": "your-api-key",
  "enabled": true,
  "maxItems": 10,
  "colors": {
    "primary": "#4f46e5",
    "secondary": "#ffffff"
  }
}
```

**Accessing in PHP:**
```php
$addonLoader = get_addon_loader();
$addon = $addonLoader->getAddon('your-addon');
$apiKey = $addon['settings']['apiKey'] ?? '';
```

**Accessing in JavaScript:**
```javascript
// First, expose in config.php:
$GLOBALS['addon_data']['your-addon'] = $addon['settings'];

// Then access in JavaScript:
const settings = window.OnePageCMS.addonData['your-addon'];
console.log(settings.apiKey);
```

---

## Common Patterns

### Minimal Addon (Utility)

```json
{
  "name": "Analytics Tracker",
  "version": "1.0.0",
  "enabled": true,
  "load": {
    "scripts": [
      {
        "file": "tracker.js",
        "scope": "global",
        "async": true
      }
    ]
  },
  "settings": {
    "trackingId": "UA-XXXXX-Y"
  }
}
```

### Page Addon with Menu

```json
{
  "name": "Admin Dashboard",
  "version": "1.0.0",
  "type": "page",
  "enabled": true,
  "load": {
    "page": {
      "file": "dashboard.php",
      "route": "admin",
      "title": "Admin Dashboard",
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
        "scope": "page-only"
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

### Full-Featured Addon

```json
{
  "name": "E-commerce Integration",
  "version": "2.1.0",
  "description": "Integrate with Shopify for product management",
  "author": "Your Company",
  "type": "integration",
  "enabled": true,
  "load": {
    "config": "config.php",
    "page": {
      "file": "products.php",
      "route": "products",
      "title": "Products",
      "menu": {
        "show": true,
        "label": "Products",
        "icon": "fas fa-shopping-cart",
        "position": 50
      }
    },
    "scripts": [
      {
        "file": "product-manager.js",
        "scope": "page-only",
        "defer": true
      }
    ],
    "styles": [
      {
        "file": "products.css",
        "scope": "page-only"
      }
    ],
    "api": {
      "file": "products-api.php",
      "route": "products-api"
    }
  },
  "dependencies": {
    "curl": true,
    "json": true
  },
  "permissions": {
    "manage_products": true,
    "view_orders": true
  },
  "settings": {
    "shopifyDomain": "your-store.myshopify.com",
    "apiKey": "",
    "apiSecret": "",
    "webhookUrl": ""
  }
}
```

---

## Best Practices

### 1. Always Set `enabled`
Make it easy to turn your addon on/off without deleting files.

```json
"enabled": true
```

### 2. Use Appropriate Scope
- **Global scope** - Only for truly site-wide features
- **Page-only scope** - For page-specific functionality

```json
// Good - page-specific editor only loads when needed
"scripts": [{"file": "editor.js", "scope": "page-only"}]

// Bad - heavy editor loads on every page
"scripts": [{"file": "editor.js", "scope": "global"}]
```

### 3. Provide Meaningful Metadata
Help users understand what your addon does.

```json
"name": "SEO Optimizer",
"description": "Automatically generates meta tags and sitemaps",
"version": "1.2.0",
"author": "SEO Tools Inc."
```

### 4. Use Settings for Configuration
Don't hardcode values - make them configurable.

```json
"settings": {
  "maxResults": 10,
  "cacheEnabled": true,
  "apiEndpoint": "https://api.example.com"
}
```

### 5. Document Dependencies
Even if not enforced, document what your addon needs.

```json
"dependencies": {
  "font-awesome": true,
  "blocks": true
}
```

---

## Validation

The system validates:
- ✅ File must be valid JSON
- ✅ `enabled` must be boolean
- ✅ Referenced files must exist (file, page.file, scripts[].file, etc.)

Common errors:
- ❌ Missing comma between properties
- ❌ Trailing comma after last property
- ❌ Unquoted property names
- ❌ Single quotes instead of double quotes

**Tip:** Use a JSON validator or IDE with JSON support to catch syntax errors.

---

## Next Steps

- See README-ADDONS.md for addon examples and quick reference
- Check addons/ directory for reference implementations
