# Hero & CTA Blocks

Create impressive hero sections and call-to-action blocks with various styles.

## Hero Types

### Default Hero
```php
echo block_hero([
    'title' => 'Welcome to Our Site',
    'subtitle' => 'Building amazing things together',
    'background' => '/images/hero-bg.jpg',
    'type' => 'default',
    'overlay' => 0.5,
    'height' => '600px',
    'alignment' => 'center',
    'buttons' => [
        ['text' => 'Get Started', 'url' => '/signup', 'type' => 'primary'],
        ['text' => 'Learn More', 'url' => '/about', 'type' => 'outline']
    ]
]);
```

### Gradient Hero
```php
echo block_hero([
    'title' => 'Modern Design',
    'subtitle' => 'Beautiful animated gradients',
    'type' => 'gradient',
    'gradient' => 'ocean',
    'height' => '500px',
    'alignment' => 'center',
    'buttons' => [
        ['text' => 'Explore', 'url' => '#', 'type' => 'primary']
    ]
]);
```

### Split Hero
```php
echo block_hero([
    'title' => 'Showcase Your Product',
    'subtitle' => 'Perfect for product launches',
    'type' => 'split',
    'image' => '/images/product.jpg',
    'height' => '600px',
    'alignment' => 'left',
    'buttons' => [
        ['text' => 'Buy Now', 'url' => '/shop', 'type' => 'primary']
    ]
]);
```

### Fullscreen Hero
```php
echo block_hero([
    'title' => 'Make an Impact',
    'subtitle' => 'Full viewport height hero',
    'background' => '/images/fullscreen-bg.jpg',
    'type' => 'fullscreen',
    'overlay' => 0.6,
    'alignment' => 'center',
    'buttons' => [
        ['text' => 'Discover More', 'url' => '#content', 'type' => 'primary']
    ]
]);
```

### Minimal Hero
```php
echo block_hero([
    'title' => 'Less is More',
    'subtitle' => 'Clean and simple design',
    'type' => 'minimal',
    'height' => '400px',
    'alignment' => 'center'
]);
```

## Gradient Presets

Available gradient options for `gradient` type:
- **primary** - Blue/purple gradient
- **sunset** - Orange/pink gradient
- **ocean** - Blue/teal gradient
- **forest** - Green gradient
- **fire** - Red/orange gradient

```php
echo block_hero([
    'title' => 'Choose Your Style',
    'type' => 'gradient',
    'gradient' => 'sunset',  // or 'ocean', 'forest', 'fire', 'primary'
    'height' => '500px'
]);
```

## Hero with Additional Content

```php
echo block_hero([
    'title' => 'Advanced Hero',
    'subtitle' => 'With extra content',
    'content' => '<p>Additional HTML content can go here.</p>',
    'background' => '/images/bg.jpg',
    'overlay' => 0.4,
    'buttons' => [
        ['text' => 'Action 1', 'url' => '#', 'type' => 'primary'],
        ['text' => 'Action 2', 'url' => '#', 'type' => 'secondary']
    ]
]);
```

## Call to Action (CTA)

### Default CTA
```php
echo block_cta(
    'Ready to Get Started?',
    'Join thousands of users building amazing websites.',
    ['text' => 'Sign Up Now', 'url' => '/signup', 'type' => 'primary']
);
```

### Boxed CTA
```php
echo block_cta(
    'Special Offer',
    'Get 50% off your first month. Limited time only!',
    ['text' => 'Claim Offer', 'url' => '/pricing', 'type' => 'success'],
    'boxed'
);
```

### Gradient CTA
```php
echo block_cta(
    'Transform Your Business',
    'Start your journey with us today.',
    ['text' => 'Get Started', 'url' => '/start', 'type' => 'primary'],
    'gradient'
);
```

## Parameters

### block_hero()
- **config** (array): Hero configuration
  - **title** (string): Hero title
  - **subtitle** (string, optional): Hero subtitle
  - **background** (string, optional): Background image URL
  - **type** (string, default: 'default'): Hero type
    - `default` - Standard hero with background image
    - `fullscreen` - Full viewport height
    - `fullwidth` - Full width hero
    - `gradient` - Animated gradient background
    - `split` - Split layout with image on side
    - `minimal` - Minimal design without background
  - **overlay** (float, default: 0.5): Overlay opacity (0-1) for image backgrounds
  - **content** (string, optional): Additional HTML content
  - **buttons** (array, optional): Array of button configurations
  - **height** (string, default: '600px'): Hero height (ignored for fullscreen)
  - **alignment** (string, default: 'center'): Content alignment
    - `left` - Left-aligned
    - `center` - Center-aligned
    - `right` - Right-aligned
  - **gradient** (string, optional): Gradient preset for gradient type
  - **image** (string, optional): Image URL for split hero
  - **class** (string, optional): Additional CSS classes

### block_cta()
- **title** (string): CTA title
- **description** (string, optional): CTA description text
- **button** (array, optional): Button configuration
  - **text** (string): Button text
  - **url** (string): Button URL
  - **type** (string): Button type (primary, secondary, etc.)
- **style** (string, default: 'default'): CTA style
  - `default` - Standard CTA
  - `boxed` - Boxed/card style
  - `gradient` - Gradient background

## Examples

### Landing Page Hero
```php
echo block_hero([
    'title' => 'Build Websites Faster',
    'subtitle' => 'The lightweight CMS for modern web development',
    'background' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97',
    'type' => 'fullscreen',
    'overlay' => 0.7,
    'alignment' => 'center',
    'buttons' => [
        ['text' => 'Start Free Trial', 'url' => '/trial', 'type' => 'primary'],
        ['text' => 'View Demo', 'url' => '/demo', 'type' => 'outline']
    ]
]);
```

### Product Showcase
```php
echo block_hero([
    'title' => 'Introducing Product X',
    'subtitle' => 'Innovation meets design',
    'type' => 'split',
    'image' => '/images/product-hero.jpg',
    'height' => '700px',
    'alignment' => 'left',
    'content' => '<ul><li>Feature 1</li><li>Feature 2</li><li>Feature 3</li></ul>',
    'buttons' => [
        ['text' => 'Pre-Order Now', 'url' => '/preorder', 'type' => 'success']
    ]
]);
```

### Newsletter CTA
```php
echo block_cta(
    'Stay Updated',
    'Subscribe to our newsletter for the latest updates and exclusive content.',
    ['text' => 'Subscribe', 'url' => '/newsletter', 'type' => 'primary'],
    'gradient'
);
```

### Conversion CTA
```php
echo block_cta(
    'Limited Time Offer!',
    'Get 3 months free when you sign up today. No credit card required.',
    ['text' => 'Start Free Trial', 'url' => '/signup', 'type' => 'success'],
    'boxed'
);
```
