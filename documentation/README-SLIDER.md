# Slider Block

Create image or content sliders/carousels with various transition effects.

## Basic Usage

```php
// Simple image slider with autoplay
echo block_slider([
    [
        'src' => '/images/slide1.jpg',
        'alt' => 'Slide 1',
        'caption' => 'First slide caption'
    ],
    [
        'src' => '/images/slide2.jpg',
        'alt' => 'Slide 2',
        'caption' => 'Second slide caption'
    ],
    [
        'src' => '/images/slide3.jpg',
        'alt' => 'Slide 3',
        'caption' => 'Third slide caption'
    ]
], 'image', ['autoplay' => true]);
```

## Advanced Options

```php
// Slider with custom transition and interval
echo block_slider([
    ['src' => '/images/slide1.jpg', 'alt' => 'Slide 1'],
    ['src' => '/images/slide2.jpg', 'alt' => 'Slide 2'],
    ['src' => '/images/slide3.jpg', 'alt' => 'Slide 3']
], 'image', [
    'autoplay' => true,
    'interval' => 3000,
    'transition' => 'slide'
]);

// Auto-sliding without user controls (no arrows, dots, or captions)
echo block_slider([
    ['src' => '/images/slide1.jpg', 'alt' => 'Slide 1'],
    ['src' => '/images/slide2.jpg', 'alt' => 'Slide 2'],
    ['src' => '/images/slide3.jpg', 'alt' => 'Slide 3']
], 'image', [
    'autoplay' => true,
    'interval' => 4000,
    'transition' => 'fade',
    'show_arrows' => false,
    'show_dots' => false,
    'show_captions' => false
]);

// Content slider
echo block_slider([
    ['content' => '<h3>Slide 1</h3><p>Content for first slide</p>'],
    ['content' => '<h3>Slide 2</h3><p>Content for second slide</p>'],
    ['content' => '<h3>Slide 3</h3><p>Content for third slide</p>']
], 'content', [
    'autoplay' => true,
    'transition' => 'zoom'
]);
```

## Parameters

### Slides Array
Each slide can have:
- **src** (string): Image URL (for image sliders)
- **alt** (string): Alt text for image
- **caption** (string, optional): Caption text to display over image
- **content** (string): HTML content (for content sliders)

### Type
- **image** (default): Image slider
- **content**: Content/HTML slider

### Options
- **autoplay** (boolean, default: false): Enable automatic slide transitions
- **interval** (integer, default: 5000): Time between slides in milliseconds
- **transition** (string, default: 'fade'): Transition effect
  - `fade` - Smooth fade in/out
  - `slide` - Slide from right to left
  - `zoom` - Zoom in/out effect
  - `flip` - 3D flip effect
- **show_arrows** (boolean, default: true): Show previous/next navigation arrows
- **show_dots** (boolean, default: true): Show dot navigation indicators
- **show_captions** (boolean, default: true): Show image captions
- **class** (string, optional): Additional CSS classes

## Examples

### Minimal Auto-Slider
Perfect for hero sections or background slideshows:
```php
echo block_slider([
    ['src' => '/images/hero1.jpg', 'alt' => 'Hero 1'],
    ['src' => '/images/hero2.jpg', 'alt' => 'Hero 2'],
    ['src' => '/images/hero3.jpg', 'alt' => 'Hero 3']
], 'image', [
    'autoplay' => true,
    'interval' => 5000,
    'transition' => 'fade',
    'show_arrows' => false,
    'show_dots' => false,
    'show_captions' => false
]);
```

### Full-Featured Slider
With all controls and captions:
```php
echo block_slider([
    ['src' => '/images/product1.jpg', 'alt' => 'Product 1', 'caption' => 'Amazing Product'],
    ['src' => '/images/product2.jpg', 'alt' => 'Product 2', 'caption' => 'Great Features'],
    ['src' => '/images/product3.jpg', 'alt' => 'Product 3', 'caption' => 'Best Quality']
], 'image', [
    'autoplay' => true,
    'interval' => 4000,
    'transition' => 'slide',
    'show_arrows' => true,
    'show_dots' => true,
    'show_captions' => true
]);
```

### Manual Navigation Only
No autoplay, user controls the slider:
```php
echo block_slider([
    ['src' => '/images/gallery1.jpg', 'alt' => 'Gallery 1'],
    ['src' => '/images/gallery2.jpg', 'alt' => 'Gallery 2'],
    ['src' => '/images/gallery3.jpg', 'alt' => 'Gallery 3']
], 'image', [
    'autoplay' => false,
    'show_arrows' => true,
    'show_dots' => true
]);
```
