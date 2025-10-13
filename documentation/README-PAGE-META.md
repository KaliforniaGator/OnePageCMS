# Page Metadata System

Dynamic page metadata for SEO and social sharing with Open Graph and Twitter Card support.

## How It Works

The system automatically generates proper meta tags for each page based on metadata you provide.

## Usage

At the top of any page file, call `set_page_meta()` with your page information:

```php
<?php
// Set page metadata
set_page_meta([
    'title' => 'About Us',
    'description' => 'Learn about our company and mission.',
    'url' => SITE_URL . '/?page=about',
    'image' => SITE_URL . '/assets/about-og-image.jpg',
    'type' => 'website',
    'author' => 'John Doe',
    'keywords' => 'about, company, mission'
]);
?>
```

## Parameters

### Required
- **title** (string): Page title - will be formatted as "Site Title | Page Title"

### Optional
- **description** (string): Page description for meta tags and social sharing
- **url** (string): Full URL of the page
- **image** (string): Full URL to image for social sharing (Open Graph/Twitter)
- **type** (string): Open Graph type (default: 'website')
  - Options: 'website', 'article', 'product', 'profile', etc.
- **author** (string): Page author name
- **keywords** (string): Comma-separated keywords for SEO
- **custom_head** (string): Custom HTML to inject into `<head>`

## Generated Meta Tags

The system automatically generates:

### Basic Meta Tags
- `<title>` - Full page title
- `<meta name="description">` - Page description
- `<meta name="keywords">` - SEO keywords (if provided)
- `<meta name="author">` - Author name (if provided)
- `<link rel="canonical">` - Canonical URL

### Open Graph (Facebook)
- `og:type` - Content type
- `og:url` - Page URL
- `og:title` - Page title
- `og:description` - Page description
- `og:image` - Share image
- `og:site_name` - Site name

### Twitter Cards
- `twitter:card` - Card type (summary_large_image)
- `twitter:url` - Page URL
- `twitter:title` - Page title
- `twitter:description` - Page description
- `twitter:image` - Share image

## Example: Blog Post

```php
<?php
set_page_meta([
    'title' => 'How to Build a CMS',
    'description' => 'Learn how to build a lightweight CMS from scratch using PHP.',
    'url' => SITE_URL . '/?page=blog/how-to-build-cms',
    'image' => SITE_URL . '/assets/blog/cms-tutorial.jpg',
    'type' => 'article',
    'author' => 'Jane Developer',
    'keywords' => 'cms, php, tutorial, web development'
]);
?>
```

## Example: Product Page

```php
<?php
set_page_meta([
    'title' => 'Premium Theme',
    'description' => 'A beautiful, responsive theme for your website.',
    'url' => SITE_URL . '/?page=products/premium-theme',
    'image' => SITE_URL . '/assets/products/premium-theme.jpg',
    'type' => 'product'
]);
?>
```

## Custom Head Content

You can inject custom HTML into the `<head>` section:

```php
<?php
set_page_meta([
    'title' => 'Special Page',
    'custom_head' => '
        <link rel="stylesheet" href="/special-page-styles.css">
        <script src="/special-page-script.js"></script>
        <meta name="robots" content="noindex, nofollow">
    '
]);
?>
```

## Default Values

If you don't set metadata, the system uses defaults from `config.php`:
- Title: `SITE_TITLE`
- Description: `SITE_DESCRIPTION`
- URL: `SITE_URL`
- Image: `SITE_URL/assets/default-og-image.jpg`

## Testing Social Sharing

Test how your pages will appear when shared:

- **Facebook**: [Facebook Sharing Debugger](https://developers.facebook.com/tools/debug/)
- **Twitter**: [Twitter Card Validator](https://cards-dev.twitter.com/validator)
- **LinkedIn**: [LinkedIn Post Inspector](https://www.linkedin.com/post-inspector/)
