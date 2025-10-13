# TextView & Alert Blocks

Display formatted text content and alert messages.

## TextView Block

### Paragraph
```php
// Basic paragraph
echo block_textview('This is a simple paragraph of text.');

// Paragraph with custom class
echo block_textview(
    'This is a styled paragraph.',
    'paragraph',
    ['class' => 'lead-text']
);
```

### Headings
```php
// H2 heading (default)
echo block_textview('Main Heading', 'heading');

// H1 heading
echo block_textview('Page Title', 'heading', ['level' => 1]);

// H3 heading
echo block_textview('Section Title', 'heading', ['level' => 3]);

// H4 heading
echo block_textview('Subsection', 'heading', ['level' => 4]);

// H5 heading
echo block_textview('Small Heading', 'heading', ['level' => 5]);

// H6 heading
echo block_textview('Tiny Heading', 'heading', ['level' => 6]);
```

### Blockquote
```php
// Quote without author
echo block_textview(
    'The only way to do great work is to love what you do.',
    'quote'
);

// Quote with author
echo block_textview(
    'The only way to do great work is to love what you do.',
    'quote',
    ['author' => 'Steve Jobs']
);

// Quote with custom class
echo block_textview(
    'Innovation distinguishes between a leader and a follower.',
    'quote',
    ['author' => 'Steve Jobs', 'class' => 'featured-quote']
);
```

### Code Block
```php
// Basic code block
echo block_textview('function hello() { return "Hello"; }', 'code');

// Code with language
echo block_textview(
    'function greet(name) {
    return `Hello, ${name}!`;
}',
    'code',
    ['language' => 'javascript']
);

// PHP code
echo block_textview(
    '<?php
function hello($name) {
    return "Hello, $name!";
}
?>',
    'code',
    ['language' => 'php']
);

// HTML code
echo block_textview(
    '<div class="container">
    <h1>Hello World</h1>
</div>',
    'code',
    ['language' => 'html']
);
```

## Alert Block

### Alert Types
```php
// Info alert
echo block_alert('This is an informational message.', 'info');

// Success alert
echo block_alert('Your action was completed successfully!', 'success');

// Warning alert
echo block_alert('Please review this information carefully.', 'warning');

// Error alert
echo block_alert('An error occurred. Please try again.', 'error');
```

### Dismissible Alerts
```php
// Dismissible info alert
echo block_alert('You can close this message.', 'info', true);

// Dismissible success alert
echo block_alert('Success! You can dismiss this.', 'success', true);

// Dismissible warning alert
echo block_alert('Warning! Click X to close.', 'warning', true);

// Dismissible error alert
echo block_alert('Error! This can be dismissed.', 'error', true);
```

## Parameters

### block_textview()
- **content** (string): Text content to display
- **format** (string, default: 'paragraph'): Text format
  - `paragraph` - Standard paragraph
  - `heading` - Heading (H1-H6)
  - `quote` - Blockquote
  - `code` - Code block
- **options** (array, optional): Additional options
  - **level** (integer, 1-6): Heading level (for heading format)
  - **author** (string): Quote author (for quote format)
  - **language** (string): Programming language (for code format)
  - **class** (string): Additional CSS classes

### block_alert()
- **message** (string): Alert message
- **type** (string, default: 'info'): Alert type
  - `info` - Informational (blue)
  - `success` - Success message (green)
  - `warning` - Warning message (yellow/orange)
  - `error` - Error message (red)
- **dismissible** (boolean, default: false): Whether alert can be dismissed

## Examples

### Article Content
```php
echo block_textview('Introduction to OnePage CMS', 'heading', ['level' => 1]);
echo block_textview('OnePage CMS is a lightweight content management framework designed for simplicity and flexibility.');
echo block_textview('Getting Started', 'heading', ['level' => 2]);
echo block_textview('Follow these steps to get started with OnePage CMS...');
```

### Testimonial
```php
echo block_textview(
    'OnePage CMS has transformed how we build websites. It\'s fast, flexible, and incredibly easy to use.',
    'quote',
    ['author' => 'Jane Doe, CEO of Example Corp']
);
```

### Code Documentation
```php
echo block_textview('Basic Usage', 'heading', ['level' => 3]);
echo block_textview('Here\'s how to create a simple button:');
echo block_textview(
    'echo block_button("Click Me", "/page", "primary");',
    'code',
    ['language' => 'php']
);
```

### Form Validation Messages
```php
// Success message
if ($formSubmitted) {
    echo block_alert('Thank you! Your message has been sent.', 'success', true);
}

// Error message
if ($hasError) {
    echo block_alert('Please fill in all required fields.', 'error', true);
}

// Warning message
if ($incompleteProfile) {
    echo block_alert('Your profile is incomplete. Please update your information.', 'warning', true);
}
```

### Help Text
```php
echo block_alert(
    'Tip: You can use Markdown syntax in your content for better formatting.',
    'info',
    false
);
```

### Status Messages
```php
// Processing
echo block_alert('Your request is being processed...', 'info');

// Completed
echo block_alert('Process completed successfully!', 'success');

// Needs attention
echo block_alert('Action required: Please verify your email address.', 'warning');

// Failed
echo block_alert('Failed to connect to server. Please check your connection.', 'error');
```

### Documentation Page
```php
echo block_textview('API Reference', 'heading', ['level' => 1]);

echo block_textview('block_button()', 'heading', ['level' => 2]);
echo block_textview('Creates a styled button element.');

echo block_textview('Parameters', 'heading', ['level' => 3]);
echo block_textview(
    'function block_button($text, $url = "#", $type = "primary", $size = "medium")',
    'code',
    ['language' => 'php']
);

echo block_textview('Example', 'heading', ['level' => 3]);
echo block_textview(
    'echo block_button("Click Me", "/page", "primary", "large");',
    'code',
    ['language' => 'php']
);
```

### Blog Post
```php
echo block_textview('How to Build Better Websites', 'heading', ['level' => 1]);
echo block_textview('Posted on January 15, 2024', 'paragraph', ['class' => 'post-meta']);

echo block_textview(
    'Building great websites requires a combination of good design, clean code, and user-focused thinking.',
    'paragraph',
    ['class' => 'lead']
);

echo block_textview('The Fundamentals', 'heading', ['level' => 2]);
echo block_textview('Every great website starts with a solid foundation...');

echo block_textview(
    'Good design is as little design as possible.',
    'quote',
    ['author' => 'Dieter Rams']
);
```

### Notification Banner
```php
echo block_alert(
    'New feature available! Check out our updated dashboard.',
    'info',
    true
);
```

### Multi-language Code Example
```php
echo block_textview('JavaScript Example', 'heading', ['level' => 3]);
echo block_textview(
    'const greeting = (name) => `Hello, ${name}!`;
console.log(greeting("World"));',
    'code',
    ['language' => 'javascript']
);

echo block_textview('Python Example', 'heading', ['level' => 3]);
echo block_textview(
    'def greeting(name):
    return f"Hello, {name}!"
    
print(greeting("World"))',
    'code',
    ['language' => 'python']
);
```

## Notes

- Heading levels are automatically constrained between 1-6
- Code blocks preserve whitespace and formatting
- Dismissible alerts can be closed by clicking the X button
- Alerts include appropriate ARIA roles for accessibility
- Quote citations are styled with em dash (—) prefix
- Code language classes follow the `language-*` convention for syntax highlighting
- All content supports HTML entities and special characters
