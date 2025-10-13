# Container Block

A flexible container for wrapping and constraining content width.

## Basic Usage

```php
// Default wide container
echo block_container('<h1>My Content</h1><p>Content goes here.</p>');

// Narrow container
echo block_container('<p>Centered narrow content.</p>', '', '', 'narrow');

// Full-width container
echo block_container('<p>Full-width content.</p>', '', '', 'full');
```

## With Custom Styling

```php
// Container with custom class
echo block_container(
    '<h2>Custom Styled Content</h2>',
    'my-custom-class',
    '',
    'wide'
);

// Container with inline styles
echo block_container(
    '<p>Content with custom background</p>',
    '',
    'background: #f0f0f0; padding: 2rem; border-radius: 8px;',
    'narrow'
);

// Container with both class and style
echo block_container(
    '<div>Fully customized container</div>',
    'featured-section',
    'margin: 3rem 0;',
    'wide'
);
```

## Parameters

- **content** (string): Content to display inside container (supports HTML)
- **class** (string, optional): Additional CSS classes
- **style** (string, optional): Inline CSS styles
- **width** (string, default: 'wide'): Container width preset
  - `full` - Full width (100% of parent)
  - `wide` - Wide container (default, typically 1200px max-width)
  - `narrow` - Narrow container (typically 800px max-width)

## Examples

### Section Wrapper
```php
echo block_container('
    <h2>About Us</h2>
    <p>We are a company that does amazing things...</p>
    ' . block_button('Learn More', '/about', 'primary') . '
', '', '', 'narrow');
```

### Full-Width Hero Content
```php
echo block_container(
    block_hero([
        'title' => 'Welcome',
        'subtitle' => 'To our website'
    ]),
    '',
    '',
    'full'
);
```

### Styled Content Section
```php
echo block_container('
    <h2>Featured Content</h2>
    <p>This section has a custom background and padding.</p>
', 'featured-box', 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem; border-radius: 12px;');
```

### Nested Containers
```php
// Outer full-width container with background
echo block_container(
    // Inner narrow container for content
    block_container(
        '<h1>Centered Title</h1><p>Narrow content within full-width background.</p>',
        '',
        '',
        'narrow'
    ),
    '',
    'background: #f8f9fa; padding: 4rem 0;',
    'full'
);
```

## Notes

- Containers automatically center their content
- The `wide` preset is the standard container width used throughout the CMS
- Use `narrow` for text-heavy content to improve readability
- Use `full` when you want content to span the entire viewport width
- Containers are responsive and adapt to smaller screens
