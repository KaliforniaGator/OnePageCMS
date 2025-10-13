# Media Blocks

Display images, videos, and icons with various options.

## Images

### Basic Image
```php
echo block_image('/images/photo.jpg', 'Photo description');
```

### Image with Caption
```php
echo block_image(
    '/images/landscape.jpg',
    'Beautiful landscape',
    'Sunset over the mountains'
);
```

### Image Sizes
```php
// Small image
echo block_image('/images/thumb.jpg', 'Thumbnail', '', '', 'small');

// Medium image
echo block_image('/images/photo.jpg', 'Photo', '', '', 'medium');

// Large image
echo block_image('/images/banner.jpg', 'Banner', '', '', 'large');

// Full width image
echo block_image('/images/hero.jpg', 'Hero', '', '', 'full');
```

### Image with Custom Class
```php
echo block_image(
    '/images/product.jpg',
    'Product photo',
    'Our flagship product',
    'featured-image rounded'
);
```

## Videos

### YouTube Video
```php
// Using full URL
echo block_video('https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'youtube');

// Using video ID
echo block_video('dQw4w9WgXcQ', 'youtube');

// With custom dimensions
echo block_video('dQw4w9WgXcQ', 'youtube', '', [
    'width' => '800px',
    'height' => '450px'
]);
```

### Vimeo Video
```php
// Using full URL
echo block_video('https://vimeo.com/123456789', 'vimeo');

// Using video ID
echo block_video('123456789', 'vimeo');

// With autoplay
echo block_video('123456789', 'vimeo', '', [
    'autoplay' => true,
    'height' => '500px'
]);
```

### Video File
```php
// Direct video file
echo block_video('/videos/demo.mp4', 'file');

// With autoplay
echo block_video('/videos/intro.mp4', 'file', '', [
    'autoplay' => true,
    'width' => '100%',
    'height' => '400px'
]);
```

## Icons

### Basic Icons
```php
// Font Awesome icons
echo block_icon('fas fa-home');
echo block_icon('fas fa-envelope');
echo block_icon('fab fa-github');
```

### Icon Sizes
```php
echo block_icon('fas fa-star', 'small');
echo block_icon('fas fa-star', 'medium');
echo block_icon('fas fa-star', 'large');
echo block_icon('fas fa-star', 'xl');
echo block_icon('fas fa-star', '2xl');
```

### Colored Icons
```php
echo block_icon('fas fa-heart', 'large', '', '#e74c3c');
echo block_icon('fas fa-check', 'large', '', '#2ecc71');
echo block_icon('fas fa-star', 'large', '', '#f39c12');
```

### Icons with Custom Classes
```php
echo block_icon('fas fa-user', 'medium', 'profile-icon rotating');
```

### Icon Shorthand
```php
// Automatically adds 'fas' prefix
echo block_icon('fa-home', 'medium');
echo block_icon('fa-envelope', 'large');
```

## Parameters

### block_image()
- **src** (string): Image source URL
- **alt** (string): Alt text for accessibility
- **caption** (string, optional): Image caption
- **class** (string, optional): Additional CSS classes
- **size** (string, default: 'full'): Image size
  - `small` - Small image
  - `medium` - Medium image
  - `large` - Large image
  - `full` - Full width image

### block_video()
- **src** (string): Video URL or ID
- **type** (string, default: 'youtube'): Video type
  - `youtube` - YouTube video
  - `vimeo` - Vimeo video
  - `file` - Direct video file
- **class** (string, optional): Additional CSS classes
- **options** (array, optional): Additional options
  - **width** (string, default: '100%'): Video width
  - **height** (string, default: '400px'): Video height
  - **autoplay** (boolean, default: false): Auto-play video

### block_icon()
- **icon** (string): Font Awesome icon class (e.g., 'fas fa-home')
- **size** (string, default: 'medium'): Icon size
  - `small` - Small icon
  - `medium` - Medium icon
  - `large` - Large icon
  - `xl` - Extra large
  - `2xl` - 2x extra large
- **class** (string, optional): Additional CSS classes
- **color** (string, optional): Icon color (CSS color value)

## Examples

### Image Gallery
```php
echo block_grid([
    block_image('/images/gallery1.jpg', 'Image 1', 'Caption 1', '', 'medium'),
    block_image('/images/gallery2.jpg', 'Image 2', 'Caption 2', '', 'medium'),
    block_image('/images/gallery3.jpg', 'Image 3', 'Caption 3', '', 'medium'),
    block_image('/images/gallery4.jpg', 'Image 4', 'Caption 4', '', 'medium')
], 2);
```

### Feature Icons
```php
echo block_grid([
    '<div class="feature">
        ' . block_icon('fas fa-rocket', 'xl', '', '#3498db') . '
        <h3>Fast</h3>
        <p>Lightning-fast performance</p>
    </div>',
    '<div class="feature">
        ' . block_icon('fas fa-shield-alt', 'xl', '', '#2ecc71') . '
        <h3>Secure</h3>
        <p>Enterprise-grade security</p>
    </div>',
    '<div class="feature">
        ' . block_icon('fas fa-mobile-alt', 'xl', '', '#e74c3c') . '
        <h3>Responsive</h3>
        <p>Works on all devices</p>
    </div>'
], 3);
```

### Video Embed
```php
echo block_container(
    '<h2>Watch Our Demo</h2>' .
    block_video('https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'youtube', '', [
        'width' => '100%',
        'height' => '500px'
    ]),
    '',
    '',
    'narrow'
);
```

### Product Image with Details
```php
echo '<div class="product">';
echo block_image('/images/product.jpg', 'Product Name', '', '', 'large');
echo '<h2>Product Name</h2>';
echo '<p>Product description goes here.</p>';
echo block_button('Buy Now', '/buy', 'primary');
echo '</div>';
```

### Icon List
```php
echo '<ul class="icon-list">';
echo '<li>' . block_icon('fas fa-check', 'small', '', '#2ecc71') . ' Feature 1</li>';
echo '<li>' . block_icon('fas fa-check', 'small', '', '#2ecc71') . ' Feature 2</li>';
echo '<li>' . block_icon('fas fa-check', 'small', '', '#2ecc71') . ' Feature 3</li>';
echo '</ul>';
```

### Social Media Icons
```php
echo '<div class="social-icons">';
echo block_icon('fab fa-facebook', 'large', '', '#3b5998');
echo block_icon('fab fa-twitter', 'large', '', '#1da1f2');
echo block_icon('fab fa-instagram', 'large', '', '#e4405f');
echo block_icon('fab fa-linkedin', 'large', '', '#0077b5');
echo '</div>';
```

## Notes

- All images use lazy loading by default for better performance
- Videos are embedded in responsive containers
- Icons use Font Awesome (ensure Font Awesome is loaded)
- YouTube and Vimeo videos are embedded via iframes
- Video files support MP4 format
- Images automatically scale to fit their container
