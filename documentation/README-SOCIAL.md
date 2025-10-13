# Social Buttons Block

Create social media buttons with icons and links.

## Basic Social Buttons

```php
// Icon-only buttons
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com/yourpage'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com/yourhandle'],
    ['platform' => 'instagram', 'url' => 'https://instagram.com/yourprofile'],
    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/yourcompany']
]);
```

## Button Styles

### Icon Only (Default)
```php
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com'],
    ['platform' => 'github', 'url' => 'https://github.com']
], 'icon');
```

### Text Only
```php
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com'],
    ['platform' => 'github', 'url' => 'https://github.com']
], 'text');
```

### Icon + Text
```php
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com'],
    ['platform' => 'github', 'url' => 'https://github.com']
], 'both');
```

## Button Sizes

```php
// Small buttons
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'small');

// Medium buttons (default)
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'medium');

// Large buttons
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'large');
```

## Button Shapes

```php
// Circle buttons (default for icon-only)
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'medium', 'circle');

// Rounded rectangle
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'medium', 'rounded-rect');

// Rectangle
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'medium', 'rect');

// Plain (no background)
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com']
], 'icon', 'medium', 'plain');
```

## Supported Platforms

```php
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com'],
    ['platform' => 'x', 'url' => 'https://x.com'],  // X (formerly Twitter)
    ['platform' => 'instagram', 'url' => 'https://instagram.com'],
    ['platform' => 'linkedin', 'url' => 'https://linkedin.com'],
    ['platform' => 'youtube', 'url' => 'https://youtube.com'],
    ['platform' => 'github', 'url' => 'https://github.com'],
    ['platform' => 'pinterest', 'url' => 'https://pinterest.com'],
    ['platform' => 'tiktok', 'url' => 'https://tiktok.com'],
    ['platform' => 'discord', 'url' => 'https://discord.com'],
    ['platform' => 'reddit', 'url' => 'https://reddit.com'],
    ['platform' => 'snapchat', 'url' => 'https://snapchat.com'],
    ['platform' => 'whatsapp', 'url' => 'https://wa.me/1234567890'],
    ['platform' => 'telegram', 'url' => 'https://t.me/username'],
    ['platform' => 'twitch', 'url' => 'https://twitch.tv'],
    ['platform' => 'spotify', 'url' => 'https://spotify.com'],
    ['platform' => 'dribbble', 'url' => 'https://dribbble.com'],
    ['platform' => 'behance', 'url' => 'https://behance.net'],
    ['platform' => 'medium', 'url' => 'https://medium.com'],
    ['platform' => 'email', 'url' => 'mailto:contact@example.com'],
    ['platform' => 'website', 'url' => 'https://example.com'],
    ['platform' => 'link', 'url' => 'https://example.com']
]);
```

## Parameters

- **links** (array): Array of social links
  - **platform** (string): Platform name (lowercase)
  - **url** (string): Social media profile URL
- **style** (string, default: 'icon'): Button style
  - `icon` - Icon only
  - `text` - Text only
  - `both` - Icon and text
- **size** (string, default: 'medium'): Button size
  - `small` - Small buttons
  - `medium` - Medium buttons
  - `large` - Large buttons
- **shape** (string, default: 'rounded-rect'): Button shape
  - `circle` - Circular buttons
  - `rounded-rect` - Rounded rectangles
  - `rect` - Sharp rectangles
  - `plain` - No background/border

## Examples

### Footer Social Links
```php
echo '<footer>';
echo '<h3>Follow Us</h3>';
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com/company'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com/company'],
    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/company'],
    ['platform' => 'instagram', 'url' => 'https://instagram.com/company']
], 'icon', 'medium', 'circle');
echo '</footer>';
```

### Contact Page Social
```php
echo '<div class="contact-social">';
echo '<h2>Connect With Us</h2>';
echo block_social_buttons([
    ['platform' => 'email', 'url' => 'mailto:hello@example.com'],
    ['platform' => 'facebook', 'url' => 'https://facebook.com/page'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com/handle'],
    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/company/name']
], 'both', 'large', 'rounded-rect');
echo '</div>';
```

### Profile Social Links
```php
echo block_social_buttons([
    ['platform' => 'github', 'url' => 'https://github.com/username'],
    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/in/username'],
    ['platform' => 'twitter', 'url' => 'https://twitter.com/username'],
    ['platform' => 'website', 'url' => 'https://mywebsite.com']
], 'icon', 'small', 'plain');
```

### Share Buttons
```php
echo '<div class="share-buttons">';
echo '<h4>Share this post</h4>';
echo block_social_buttons([
    ['platform' => 'facebook', 'url' => 'https://facebook.com/sharer/sharer.php?u=' . urlencode($currentUrl)],
    ['platform' => 'twitter', 'url' => 'https://twitter.com/intent/tweet?url=' . urlencode($currentUrl)],
    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/sharing/share-offsite/?url=' . urlencode($currentUrl)],
    ['platform' => 'email', 'url' => 'mailto:?subject=Check this out&body=' . urlencode($currentUrl)]
], 'icon', 'medium', 'rounded-rect');
echo '</div>';
```

### Creator Links
```php
echo block_social_buttons([
    ['platform' => 'youtube', 'url' => 'https://youtube.com/@channel'],
    ['platform' => 'tiktok', 'url' => 'https://tiktok.com/@username'],
    ['platform' => 'instagram', 'url' => 'https://instagram.com/username'],
    ['platform' => 'twitch', 'url' => 'https://twitch.tv/username'],
    ['platform' => 'discord', 'url' => 'https://discord.gg/invite']
], 'both', 'large', 'rounded-rect');
```

### Developer Links
```php
echo block_social_buttons([
    ['platform' => 'github', 'url' => 'https://github.com/username'],
    ['platform' => 'stackoverflow', 'url' => 'https://stackoverflow.com/users/123'],
    ['platform' => 'dribbble', 'url' => 'https://dribbble.com/username'],
    ['platform' => 'behance', 'url' => 'https://behance.net/username'],
    ['platform' => 'medium', 'url' => 'https://medium.com/@username']
], 'icon', 'medium', 'circle');
```

## Notes

- All social links open in a new tab with `target="_blank"`
- Links include `rel="noopener noreferrer"` for security
- Icons use Font Awesome (ensure Font Awesome is loaded)
- Buttons are automatically styled with platform brand colors
- Platform names are case-insensitive
- WhatsApp links should use the format: `https://wa.me/1234567890`
- Email links use `mailto:` protocol
