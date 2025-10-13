# Logo Block

Create a logo with image and/or text.

## Usage

```php
// Logo with image only
echo block_logo([
    'image' => '/assets/logo.png',
    'alt' => 'Company Logo',
    'width' => '200px',
    'height' => '50px',
    'link' => '/'
]);

// Logo with text only
echo block_logo([
    'text' => 'My Brand',
    'link' => '/'
]);

// Logo with image and text
echo block_logo([
    'image' => '/assets/logo.png',
    'text' => 'My Brand',
    'alt' => 'My Brand Logo',
    'width' => '50px',
    'height' => '50px',
    'link' => '/'
]);

// Logo with custom class
echo block_logo([
    'image' => '/assets/logo.png',
    'text' => 'My Brand',
    'class' => 'header-logo',
    'link' => '/'
]);
```

## Parameters

- **image** (string, optional): Path to logo image
- **text** (string, optional): Logo text
- **alt** (string, optional): Alt text for image (default: 'Logo')
- **width** (string, optional): Image width (e.g., '200px', '10rem')
- **height** (string, optional): Image height (e.g., '50px', '3rem')
- **link** (string, optional): URL to link to (default: '/')
- **class** (string, optional): Additional CSS classes

## Notes

- At least one of `image` or `text` should be provided
- Width and height are optional - image will scale naturally if not specified
- Logo automatically links to the specified URL (default: homepage)
