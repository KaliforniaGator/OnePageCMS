# Card & Grid Blocks

Create card components and grid layouts for organizing content.

## Basic Card

```php
// Simple card
echo block_card([
    'title' => 'Card Title',
    'content' => 'Card content goes here.'
]);

// Card with image
echo block_card([
    'image' => '/images/card-image.jpg',
    'title' => 'Featured Post',
    'content' => 'This is a featured post with an image.'
]);

// Card with footer
echo block_card([
    'title' => 'Product Name',
    'content' => 'Product description here.',
    'footer' => block_button('Buy Now', '/buy', 'primary', 'small')
]);
```

## Complete Card

```php
// Card with all options
echo block_card([
    'image' => '/images/product.jpg',
    'title' => 'Amazing Product',
    'content' => '<p>Full product description with HTML support.</p>',
    'footer' => '<div>' . block_button('Details', '/product', 'outline', 'small') . '</div>',
    'class' => 'featured-card'
]);
```

## Grid Layout

```php
// Create a 3-column grid of cards
$cards = [
    block_card(['title' => 'Card 1', 'content' => 'Content 1']),
    block_card(['title' => 'Card 2', 'content' => 'Content 2']),
    block_card(['title' => 'Card 3', 'content' => 'Content 3'])
];

echo block_grid($cards, 3, '2rem');

// 2-column grid with custom gap
echo block_grid($cards, 2, '1.5rem');

// 4-column grid
echo block_grid($cards, 4, '1rem');
```

## Grid with Mixed Content

```php
// Grid doesn't have to contain only cards
$items = [
    '<div class="custom-item">Item 1</div>',
    '<div class="custom-item">Item 2</div>',
    '<div class="custom-item">Item 3</div>'
];

echo block_grid($items, 3);
```

## Parameters

### block_card()
- **config** (array): Card configuration
  - **title** (string, optional): Card title
  - **content** (string, optional): Card content (supports HTML)
  - **image** (string, optional): Image URL for card header
  - **footer** (string, optional): Card footer content (supports HTML)
  - **class** (string, optional): Additional CSS classes

### block_grid()
- **items** (array): Array of HTML content to display in grid
- **columns** (integer, default: 3): Number of columns
- **gap** (string, default: '2rem'): Gap between grid items (CSS value)

## Examples

### Product Grid
```php
$products = [];
foreach ($productData as $product) {
    $products[] = block_card([
        'image' => $product['image'],
        'title' => $product['name'],
        'content' => $product['description'],
        'footer' => block_button('View', "/product/{$product['id']}", 'primary', 'small')
    ]);
}

echo block_grid($products, 3, '2rem');
```

### Feature Cards
```php
echo block_grid([
    block_card([
        'title' => '⚡ Fast',
        'content' => 'Lightning-fast performance'
    ]),
    block_card([
        'title' => '🔒 Secure',
        'content' => 'Enterprise-grade security'
    ]),
    block_card([
        'title' => '📱 Responsive',
        'content' => 'Works on all devices'
    ])
], 3, '1.5rem');
```

### Blog Post Grid
```php
$posts = [
    block_card([
        'image' => '/images/post1.jpg',
        'title' => 'Blog Post Title',
        'content' => 'Post excerpt goes here...',
        'footer' => '<small>Posted on Jan 1, 2024</small>'
    ]),
    // More posts...
];

echo block_grid($posts, 2, '2rem');
```
