# Accordion & Tabs Blocks

Create collapsible accordions and tabbed content sections.

## Accordion

```php
// Basic accordion
echo block_accordion([
    [
        'title' => 'What is OnePage CMS?',
        'content' => 'OnePage CMS is a lightweight content management framework.'
    ],
    [
        'title' => 'How do I install it?',
        'content' => 'Simply upload the files to your server and configure config.php.'
    ],
    [
        'title' => 'Is it free?',
        'content' => 'Yes, OnePage CMS is completely free and open source.'
    ]
]);

// Allow multiple sections open at once
echo block_accordion([
    ['title' => 'Section 1', 'content' => 'Content 1'],
    ['title' => 'Section 2', 'content' => 'Content 2'],
    ['title' => 'Section 3', 'content' => 'Content 3']
], true);
```

## Accordion with HTML Content

```php
echo block_accordion([
    [
        'title' => 'Features',
        'content' => '
            <ul>
                <li>Easy to use</li>
                <li>Lightweight</li>
                <li>Customizable</li>
            </ul>
        '
    ],
    [
        'title' => 'Documentation',
        'content' => '<p>Check out our <a href="/docs">documentation</a> for more info.</p>'
    ]
]);
```

## Tabs

```php
// Basic tabs
echo block_tabs([
    [
        'title' => 'Overview',
        'content' => '<p>This is the overview tab content.</p>'
    ],
    [
        'title' => 'Features',
        'content' => '<p>List of features goes here.</p>'
    ],
    [
        'title' => 'Pricing',
        'content' => '<p>Pricing information here.</p>'
    ]
]);
```

## Tabs with Rich Content

```php
echo block_tabs([
    [
        'title' => 'Description',
        'content' => '
            <h3>Product Description</h3>
            <p>Detailed product information...</p>
        '
    ],
    [
        'title' => 'Specifications',
        'content' => '
            <table>
                <tr><td>Weight</td><td>1.5 kg</td></tr>
                <tr><td>Dimensions</td><td>30x20x10 cm</td></tr>
            </table>
        '
    ],
    [
        'title' => 'Reviews',
        'content' => '<p>Customer reviews will appear here.</p>'
    ]
]);
```

## Parameters

### block_accordion()
- **items** (array): Array of accordion items
  - **title** (string): Section title
  - **content** (string): Section content (supports HTML)
- **multiple** (boolean, default: false): Allow multiple sections to be open simultaneously

### block_tabs()
- **tabs** (array): Array of tab configurations
  - **title** (string): Tab title
  - **content** (string): Tab content (supports HTML)

## Examples

### FAQ Accordion
```php
echo block_accordion([
    [
        'title' => 'How do I get started?',
        'content' => '<p>Follow our <a href="/quickstart">Quick Start Guide</a> to get up and running in minutes.</p>'
    ],
    [
        'title' => 'What are the system requirements?',
        'content' => '<ul><li>PHP 7.4+</li><li>Apache/Nginx</li><li>MySQL (optional)</li></ul>'
    ],
    [
        'title' => 'Can I customize the design?',
        'content' => '<p>Yes! Edit the CSS files in the framework-styles directory.</p>'
    ]
]);
```

### Product Information Tabs
```php
echo block_tabs([
    [
        'title' => 'Details',
        'content' => block_card([
            'content' => 'Product details and description'
        ])
    ],
    [
        'title' => 'Shipping',
        'content' => '<p>Ships within 2-3 business days</p>'
    ],
    [
        'title' => 'Returns',
        'content' => '<p>30-day return policy</p>'
    ]
]);
```

### Documentation Tabs
```php
echo block_tabs([
    [
        'title' => 'Getting Started',
        'content' => '<h3>Installation</h3><p>Step-by-step installation guide...</p>'
    ],
    [
        'title' => 'API Reference',
        'content' => '<h3>Functions</h3><p>Complete API documentation...</p>'
    ],
    [
        'title' => 'Examples',
        'content' => '<h3>Code Examples</h3><p>Practical examples...</p>'
    ]
]);
```

## Notes

- Accordion sections collapse when clicked (unless `multiple` is true)
- Only one tab can be active at a time
- First accordion item is closed by default
- First tab is active by default
- Both support full HTML content
