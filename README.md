# OnePage CMS

A lightweight, flexible content management framework built with PHP. Create beautiful websites with minimal complexity and maximum control.

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4)
![License](https://img.shields.io/badge/license-MIT-green)

## ✨ Features

- **Simple Page-Based Routing** - Create pages by adding PHP files to the `pages/` directory
- **Visual Page Builder** - Drag-and-drop interface for building pages without code
- **Theme Editor** - Visually customize colors, typography, spacing, and more with auto-save
- **Powerful Blocks System** - Pre-built components for buttons, forms, heroes, sliders, and more
- **Addon System** - Extend functionality with modular addons
- **Optional Database Support** - Works great for static sites, but database features available when needed
- **Modern, Responsive Design** - Clean UI that works on all devices
- **No Forced Dependencies** - Use only what you need
- **Easy Customization** - Clean separation of framework and user code

## 🚀 Quick Start

### Requirements

- PHP 7.4 or higher
- Apache with mod_rewrite (or equivalent web server)
- Optional: MySQL/MariaDB for database features

### Installation

1. **Clone or download** the repository:
   ```bash
   git clone https://github.com/kaliforniagator/OnePageCMS.git
   cd OnePageCMS
   ```

2. **Configure your site** in `config.php`:
   ```php
   define('SITE_TITLE', 'Your Site Name');
   define('SITE_DESCRIPTION', 'Your site description');
   define('SITE_URL', 'http://localhost:8080');
   ```

3. **Start a local server**:
   ```bash
   php -S localhost:8080
   ```

4. **Visit your site** at `http://localhost:8080`

That's it! Your site is ready to use.

## 📖 Documentation

### Creating Pages

#### Manual Page Creation

Create a new PHP file in the `pages/` directory:

```php
<?php
// pages/about.php
set_page_meta([
    'title' => 'About Us',
    'description' => 'Learn more about our company'
]);
?>

<article class="page-content">
    <h1>About Us</h1>
    <p>Welcome to our about page!</p>
</article>
```

Access it at: `/?page=about`

#### Visual Page Builder

1. Navigate to the **Page Builder** from the menu
2. Click **New** to create a page
3. Drag blocks from the sidebar onto the canvas
4. Configure each block's properties
5. Click **Save** when done

### Using the Theme Editor

1. Navigate to **Theme Editor** from the menu
2. Browse theme properties organized by category
3. Edit colors, fonts, spacing, and more
4. Changes auto-save and apply immediately
5. Use the search to find specific properties
6. Reset individual properties or all at once

### Blocks System

OnePage CMS includes a comprehensive blocks system:

**Layout Blocks:**
- Container
- Grid layouts

**Content Blocks:**
- Text View (headings, paragraphs, quotes, code)
- Button & Button Groups
- Cards
- Alerts
- Hero sections
- Lists
- Accordions

**Media Blocks:**
- Images
- Sliders/Carousels

**Form Blocks:**
- Input fields
- Text areas
- Select dropdowns
- Radio buttons
- Checkboxes
- Date/Time pickers
- File uploads
- Toggle switches

**Navigation Blocks:**
- Menus
- Social media buttons
- Logos

### Customizing Your Theme

Edit `styles/theme.css` to customize CSS variables:

```css
:root {
    --color-primary: #3482db;
    --font-family-base: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto;
    --spacing-md: 1rem;
    /* ... and many more */
}
```

Or use the **Theme Editor** for visual customization!

### Database Usage (Optional)

Uncomment database settings in `config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

Use the database class in your pages:

```php
// Insert data
db()->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Query data
$users = db()->query('SELECT * FROM users');

// Update data
db()->update('users', ['name' => 'Jane Doe'], ['id' => 1]);
```

## 🔌 Creating Addons

Addons extend OnePage CMS functionality. Here's how to create one:

### 1. Create Addon Directory

```
addons/
  my-addon/
    entry.json
    my-addon.php
    my-addon.css
    my-addon.js
```

### 2. Define entry.json

```json
{
  "name": "My Addon",
  "version": "1.0.0",
  "description": "Description of my addon",
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
        "position": 200
      }
    },
    "scripts": [
      {
        "file": "my-addon.js",
        "scope": "page"
      }
    ],
    "styles": [
      {
        "file": "my-addon.css",
        "scope": "page"
      }
    ]
  }
}
```

### 3. Addon Types

- **`type: "page"`** - Adds a new page to your site
- **`type: "utility"`** - Provides functionality without a page

### 4. Script/Style Scopes

- **`scope: "global"`** - Loads on every page
- **`scope: "page"`** - Loads only on the addon's page

## 📁 Directory Structure

```
OnePageCMS/
├── addons/              # Addon modules
│   ├── page-builder/    # Visual page builder
│   ├── theme-editor/    # Theme customization
│   └── sitewide-banner/ # Example utility addon
├── assets/              # Static assets (images, fonts)
├── documentation/       # Component documentation
├── elements/            # Reusable page elements
│   ├── header.php
│   └── footer.php
├── framework/           # Core framework (don't modify)
│   ├── framework-core/
│   ├── framework-includes/
│   ├── framework-scripts/
│   └── framework-styles/
├── pages/               # Your site pages
│   ├── home.php
│   ├── about.php
│   └── contact.php
├── scripts/             # Custom JavaScript
├── styles/              # Custom CSS
│   ├── theme.css        # Theme variables
│   └── main.css         # Custom styles
├── config.php           # Site configuration
└── index.php            # Entry point
```

## 🎨 Page Transitions

Enable smooth page transitions in `config.php`:

```php
define('PAGE_TRANSITIONS', true);
define('PAGE_TRANSITION_TYPE', 'fade'); // Options: fade, slide, zoom, flip
```

## 🛠️ Configuration Options

Edit `config.php` to customize:

- **Site Settings** - Title, description, URL
- **Layout** - Boxed or full-width
- **Page Transitions** - Type and enable/disable
- **Debug Mode** - Error reporting
- **Database** - Optional database connection

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

- Built with modern PHP best practices
- Uses Font Awesome for icons
- Inspired by simplicity and developer experience

## 📞 Support

For issues, questions, or suggestions:
- Open an issue on GitHub
- Check the documentation in the `documentation/` folder

---

**Made with ❤️ by the OnePage CMS Team**
