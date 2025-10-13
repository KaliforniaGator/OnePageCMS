# Button Blocks

Create styled buttons and button groups with various types and sizes.

## Basic Button

```php
// Simple button
echo block_button('Click Me', '/page', 'primary', 'medium');

// Button types
echo block_button('Primary', '#', 'primary');
echo block_button('Secondary', '#', 'secondary');
echo block_button('Success', '#', 'success');
echo block_button('Danger', '#', 'danger');
echo block_button('Outline', '#', 'outline');

// Button sizes
echo block_button('Small', '#', 'primary', 'small');
echo block_button('Medium', '#', 'primary', 'medium');
echo block_button('Large', '#', 'primary', 'large');
```

## Button with JavaScript

```php
// Button with onclick handler
echo block_button('Alert', '', 'primary', 'medium', '', 'alert("Hello!")');

// Button with custom class
echo block_button('Custom', '#', 'primary', 'medium', 'my-custom-class');
```

## Button Group

```php
// Horizontal button group
echo block_button_group([
    ['text' => 'Save', 'url' => '/save', 'type' => 'success'],
    ['text' => 'Cancel', 'url' => '/cancel', 'type' => 'secondary'],
    ['text' => 'Delete', 'url' => '/delete', 'type' => 'danger']
]);

// Centered button group
echo block_button_group([
    ['text' => 'Option 1', 'url' => '#', 'type' => 'primary'],
    ['text' => 'Option 2', 'url' => '#', 'type' => 'outline']
], 'center');

// Right-aligned button group
echo block_button_group([
    ['text' => 'Next', 'url' => '/next', 'type' => 'primary', 'size' => 'large']
], 'right');
```

## Parameters

### block_button()
- **text** (string): Button text
- **url** (string, default: '#'): Button URL (leave empty for `<button>` tag)
- **type** (string, default: 'primary'): Button type
  - `primary` - Primary action button
  - `secondary` - Secondary action button
  - `success` - Success/confirmation button
  - `danger` - Destructive action button
  - `outline` - Outlined button
- **size** (string, default: 'medium'): Button size
  - `small` - Small button
  - `medium` - Medium button
  - `large` - Large button
- **class** (string, optional): Additional CSS classes
- **onclick** (string, optional): JavaScript onclick handler

### block_button_group()
- **buttons** (array): Array of button configurations (each with same parameters as block_button)
- **alignment** (string, default: 'left'): Group alignment
  - `left` - Left-aligned
  - `center` - Center-aligned
  - `right` - Right-aligned

## Examples

### Call-to-Action Buttons
```php
echo block_button_group([
    ['text' => 'Get Started', 'url' => '/signup', 'type' => 'primary', 'size' => 'large'],
    ['text' => 'Learn More', 'url' => '/about', 'type' => 'outline', 'size' => 'large']
], 'center');
```

### Form Actions
```php
echo block_button_group([
    ['text' => 'Submit', 'url' => '', 'type' => 'success', 'onclick' => 'submitForm()'],
    ['text' => 'Reset', 'url' => '', 'type' => 'secondary', 'onclick' => 'resetForm()']
]);
```
