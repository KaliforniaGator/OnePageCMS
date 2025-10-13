# Menu & Navigation Blocks

Create navigation menus and breadcrumbs with various styles.

## Basic Menu

```php
// Simple horizontal menu
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Services', 'url' => '/services'],
    ['text' => 'Contact', 'url' => '/contact']
]);
```

## Menu with Icons

```php
echo block_menu([
    ['text' => 'Home', 'url' => '/', 'icon' => 'fas fa-home'],
    ['text' => 'About', 'url' => '/about', 'icon' => 'fas fa-info-circle'],
    ['text' => 'Blog', 'url' => '/blog', 'icon' => 'fas fa-blog'],
    ['text' => 'Contact', 'url' => '/contact', 'icon' => 'fas fa-envelope']
]);
```

## Menu with Dropdowns

```php
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Products', 'url' => '/products', 'children' => [
        ['text' => 'Category 1', 'url' => '/products/cat1'],
        ['text' => 'Category 2', 'url' => '/products/cat2'],
        ['text' => 'Category 3', 'url' => '/products/cat3']
    ]],
    ['text' => 'Services', 'url' => '/services', 'children' => [
        ['text' => 'Web Design', 'url' => '/services/web-design'],
        ['text' => 'Development', 'url' => '/services/development'],
        ['text' => 'Consulting', 'url' => '/services/consulting']
    ]],
    ['text' => 'Contact', 'url' => '/contact']
]);
```

## Menu Styles

### Simple Menu (Default)
```php
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
], 'horizontal', 'simple');
```

### Rounded Rectangle Menu
```php
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
], 'horizontal', 'rounded-rect');
```

### Capsule Menu
```php
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
], 'horizontal', 'capsule');
```

### Rectangle Menu
```php
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
], 'horizontal', 'rect');
```

### Sticky Menu
```php
echo block_menu([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
], 'horizontal', 'sticky');
```

## Vertical Menu

```php
echo block_menu([
    ['text' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'fas fa-tachometer-alt'],
    ['text' => 'Profile', 'url' => '/profile', 'icon' => 'fas fa-user'],
    ['text' => 'Settings', 'url' => '/settings', 'icon' => 'fas fa-cog'],
    ['text' => 'Logout', 'url' => '/logout', 'icon' => 'fas fa-sign-out-alt']
], 'vertical');
```

## Active Menu Items

```php
echo block_menu([
    ['text' => 'Home', 'url' => '/', 'active' => true],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
]);
```

## Breadcrumb Navigation

```php
// Basic breadcrumb
echo block_breadcrumb([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Products', 'url' => '/products'],
    ['text' => 'Category', 'url' => '/products/category'],
    ['text' => 'Product Name', 'url' => '']
]);

// Breadcrumb with custom separator
echo block_breadcrumb([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Blog', 'url' => '/blog'],
    ['text' => 'Post Title', 'url' => '']
], '>');

// Breadcrumb with arrow separator
echo block_breadcrumb([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Docs', 'url' => '/docs'],
    ['text' => 'Getting Started', 'url' => '']
], '→');
```

## Parameters

### block_menu()
- **items** (array): Array of menu items
  - **text** (string): Menu item text
  - **url** (string): Menu item URL
  - **children** (array, optional): Submenu items
  - **active** (boolean, optional): Mark as active/current page
  - **icon** (string, optional): Font Awesome icon class
- **type** (string, default: 'horizontal'): Menu orientation
  - `horizontal` - Horizontal menu
  - `vertical` - Vertical menu
- **style** (string, default: 'simple'): Menu style
  - `simple` - Simple text links
  - `rect` - Rectangle buttons
  - `rounded-rect` - Rounded rectangle buttons
  - `capsule` - Pill/capsule shaped buttons
  - `sticky` - Sticky navigation (stays at top when scrolling)
- **class** (string, optional): Additional CSS classes

### block_breadcrumb()
- **items** (array): Array of breadcrumb items
  - **text** (string): Breadcrumb text
  - **url** (string): Breadcrumb URL (empty for current page)
- **separator** (string, default: '/'): Separator character

## Examples

### Main Navigation
```php
echo block_menu([
    ['text' => 'Home', 'url' => '/', 'icon' => 'fas fa-home', 'active' => true],
    ['text' => 'Products', 'url' => '/products', 'icon' => 'fas fa-box', 'children' => [
        ['text' => 'All Products', 'url' => '/products'],
        ['text' => 'New Arrivals', 'url' => '/products/new'],
        ['text' => 'Best Sellers', 'url' => '/products/bestsellers']
    ]],
    ['text' => 'About', 'url' => '/about', 'icon' => 'fas fa-info-circle'],
    ['text' => 'Blog', 'url' => '/blog', 'icon' => 'fas fa-blog'],
    ['text' => 'Contact', 'url' => '/contact', 'icon' => 'fas fa-envelope']
], 'horizontal', 'rounded-rect');
```

### Sidebar Navigation
```php
echo block_menu([
    ['text' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'fas fa-home', 'active' => true],
    ['text' => 'Projects', 'url' => '/projects', 'icon' => 'fas fa-folder'],
    ['text' => 'Tasks', 'url' => '/tasks', 'icon' => 'fas fa-tasks'],
    ['text' => 'Team', 'url' => '/team', 'icon' => 'fas fa-users'],
    ['text' => 'Settings', 'url' => '/settings', 'icon' => 'fas fa-cog']
], 'vertical', 'simple');
```

### Footer Navigation
```php
echo block_menu([
    ['text' => 'Privacy Policy', 'url' => '/privacy'],
    ['text' => 'Terms of Service', 'url' => '/terms'],
    ['text' => 'Cookie Policy', 'url' => '/cookies'],
    ['text' => 'Sitemap', 'url' => '/sitemap']
], 'horizontal', 'simple', 'footer-nav');
```

### Mega Menu
```php
echo block_menu([
    ['text' => 'Shop', 'url' => '/shop', 'children' => [
        ['text' => 'Men', 'url' => '/shop/men'],
        ['text' => 'Women', 'url' => '/shop/women'],
        ['text' => 'Kids', 'url' => '/shop/kids'],
        ['text' => 'Accessories', 'url' => '/shop/accessories']
    ]],
    ['text' => 'Collections', 'url' => '/collections', 'children' => [
        ['text' => 'Summer 2024', 'url' => '/collections/summer'],
        ['text' => 'Winter 2024', 'url' => '/collections/winter'],
        ['text' => 'Sale', 'url' => '/collections/sale']
    ]],
    ['text' => 'About', 'url' => '/about'],
    ['text' => 'Contact', 'url' => '/contact']
], 'horizontal', 'capsule');
```

### Page Breadcrumbs
```php
echo block_breadcrumb([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Shop', 'url' => '/shop'],
    ['text' => 'Electronics', 'url' => '/shop/electronics'],
    ['text' => 'Laptops', 'url' => '/shop/electronics/laptops'],
    ['text' => 'MacBook Pro', 'url' => '']
], '/');
```

### Documentation Breadcrumbs
```php
echo block_breadcrumb([
    ['text' => 'Docs', 'url' => '/docs'],
    ['text' => 'Blocks', 'url' => '/docs/blocks'],
    ['text' => 'Menu Block', 'url' => '']
], '›');
```

## Notes

- Horizontal menus are responsive and adapt to mobile screens
- Submenus appear on hover for desktop, click for mobile
- Active menu items are automatically highlighted
- Breadcrumbs automatically style the last item as current page
- Icons require Font Awesome to be loaded
- Sticky menus remain visible when scrolling
